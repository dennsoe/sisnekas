<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GtkResource\Pages;
use App\Models\Gtk;
use Filament\Forms;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Set;
use App\Data\IndonesiaData;
use App\Data\ProvinsiData;
use App\Data\KabupatenKotaData;
use App\Data\KecamatanData;
use App\Data\DesaKelurahanData;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Actions;
use App\Data\BankData;
use App\Data\MataPelajaranData;
use Illuminate\Support\Arr;
use App\Data\GelarAkademikData;

class GtkResource extends Resource
{
    protected static ?string $model = Gtk::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationLabel = 'GTK';
    protected static ?string $modelLabel = 'GTK';
    protected static ?string $pluralModelLabel = 'GTK';
    protected static ?string $slug = 'ptk';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'GTK';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('GTK')
                    ->tabs([
                        // Tab 1: Sekolah
                        Forms\Components\Tabs\Tab::make('Sekolah')
                            ->icon('heroicon-o-academic-cap')
                            ->badge('1')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi sekolah tempat GTK bertugas')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('sekolah_id')
                                                    ->relationship('sekolah', 'nama_sekolah')
                                                    ->required()
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->afterStateUpdated(function (string $state, Forms\Set $set) {
                                                        if (blank($state)) {
                                                            $set('npsn', null);
                                                            $set('nama_sekolah', null);
                                                            return;
                                                        }

                                                        $sekolah = \App\Models\Sekolah::find($state);
                                                        
                                                        if ($sekolah) {
                                                            $set('npsn', $sekolah->npsn);
                                                            $set('nama_sekolah', $sekolah->nama_sekolah);
                                                        }
                                                    }),
                                                Forms\Components\TextInput::make('npsn')
                                                    ->maxLength(20)
                                                    ->disabled()
                                                    ->dehydrated(false)
                                                    ->label('NPSN')
                                                    ->hint('readonly')
                                                    ->hintColor('warning')
                                                    ->afterStateHydrated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                        $sekolahId = $get('sekolah_id');
                                                        if ($sekolahId) {
                                                            $sekolah = \App\Models\Sekolah::find($sekolahId);
                                                            if ($sekolah) {
                                                                $set('npsn', $sekolah->npsn);
                                                            }
                                                        }
                                                    }),
                                            ])
                                            ->columns(2),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama_sekolah')
                                                    ->disabled()
                                                    ->dehydrated(false)
                                                    ->label('Nama Sekolah')
                                                    ->hint('readonly')
                                                    ->hintColor('warning')
                                                    ->afterStateHydrated(function (Forms\Get $get, Forms\Set $set, ?string $state) {
                                                        $sekolahId = $get('sekolah_id');
                                                        if ($sekolahId) {
                                                            $sekolah = \App\Models\Sekolah::find($sekolahId);
                                                            if ($sekolah) {
                                                                $set('nama_sekolah', $sekolah->nama_sekolah);
                                                            }
                                                        }
                                                    }),
                                            ])
                                            ->columns(1),
                                    ]),
                            ]),

                        // Tab 2: Identitas GTK
                        Forms\Components\Tabs\Tab::make('Identitas')
                            ->icon('heroicon-o-identification')
                            ->badge('2')
                            ->schema([
                                Forms\Components\Section::make()    
                                    ->description('Informasi dasar GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan nama lengkap')
                                                    ->label('Nama Lengkap')
                                                    ->hint('tanpa gelar')
                                                    ->hintColor('warning'),
                                                Forms\Components\Select::make('jenis_kelamin')
                                                    ->required()
                                                    ->options([
                                                        'L' => 'Laki-laki',
                                                        'P' => 'Perempuan',
                                                    ])
                                                    ->placeholder('Pilih jenis kelamin')
                                                    ->label('Jenis Kelamin'),
                                                Forms\Components\TextInput::make('nama_ibu_kandung')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan nama ibu kandung')
                                                    ->label('Ibu Kandung'),
                                            ])
                                            ->columns(3),

                                        // Grid baru untuk tempat & tanggal lahir
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('tempat_lahir')
                                                    ->required()
                                                    ->options(IndonesiaData::getCitiesGroupedByProvince())
                                                    ->searchable()
                                                    ->placeholder('Pilih tempat lahir')
                                                    ->label('Tempat Lahir'),
                                                Forms\Components\DatePicker::make('tanggal_lahir')
                                                    ->required()
                                                    ->maxDate(now())
                                                    ->displayFormat('d/m/Y')
                                                    ->format('Y-m-d')
                                                    ->placeholder('Pilih tanggal lahir')
                                                    ->label('Tanggal Lahir'),
                                            ])
                                            ->columns(2),

                                        // Grid baru untuk NIK & No. KK
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nik')
                                                    ->required()
                                                    ->unique(ignoreRecord: true)
                                                    ->maxLength(16)
                                                    ->minLength(16)
                                                    ->numeric()
                                                    ->placeholder('Masukkan 16 digit NIK')
                                                    ->label('NIK')
                                                    ->hint('16 digit angka')
                                                    ->hintColor('warning'),
                                                Forms\Components\TextInput::make('no_kk')
                                                    ->maxLength(16)
                                                    ->minLength(16)
                                                    ->numeric()
                                                    ->placeholder('Masukkan 16 digit nomor KK')
                                                    ->label('Nomor KK')
                                                    ->hint('16 digit angka')
                                                    ->hintColor('warning'),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        // Tab 3: Alamat
                        Forms\Components\Tabs\Tab::make('Alamat')
                            ->icon('heroicon-o-map-pin')
                            ->badge('3')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi alamat tempat tinggal GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Textarea::make('alamat')
                                                    ->required()
                                                    ->placeholder('Masukkan alamat lengkap')
                                                    ->label('Alamat')
                                                    ->columnSpanFull(),
                                                Forms\Components\TextInput::make('rt')
                                                    ->maxLength(3)
                                                    ->numeric()
                                                    ->placeholder('000')
                                                    ->label('RT'),
                                                Forms\Components\TextInput::make('rw')
                                                    ->maxLength(3)
                                                    ->numeric()
                                                    ->placeholder('000')
                                                    ->label('RW'),
                                                Forms\Components\TextInput::make('nama_dusun')
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan nama dusun')
                                                    ->label('Nama Dusun'),
                                                Forms\Components\Grid::make()
                                                    ->schema([
                                                        Forms\Components\Select::make('provinsi')
                                                            ->required()
                                                            ->options(ProvinsiData::getProvinsiOptions())
                                                            ->searchable()
                                                            ->live()
                                                            ->afterStateUpdated(fn (Set $set) => $set('kabupaten_kota', null)),

                                                        Forms\Components\Select::make('kabupaten_kota')
                                                            ->required()
                                                            ->options(fn (Get $get): array => 
                                                                KabupatenKotaData::getKabupatenKotaOptions($get('provinsi') ?? ''))
                                                            ->searchable()
                                                            ->live()
                                                            ->afterStateUpdated(fn (Set $set) => $set('kecamatan', null))
                                                            ->disabled(fn (Get $get): bool => blank($get('provinsi'))),

                                                        Forms\Components\Select::make('kecamatan')
                                                            ->required()
                                                            ->options(fn (Get $get): array => 
                                                                KecamatanData::getKecamatanOptions($get('kabupaten_kota') ?? ''))
                                                            ->searchable()
                                                            ->live()
                                                            ->afterStateUpdated(fn (Set $set) => $set('desa_kelurahan', null))
                                                            ->disabled(fn (Get $get): bool => blank($get('kabupaten_kota'))),

                                                        Forms\Components\Select::make('desa_kelurahan')
                                                            ->required()
                                                            ->options(fn (Get $get): array => 
                                                                DesaKelurahanData::getDesaKelurahanOptions($get('kecamatan') ?? ''))
                                                            ->searchable()
                                                            ->disabled(fn (Get $get): bool => blank($get('kecamatan'))),
                                                    ])
                                                    ->columns(2),
                                                Forms\Components\TextInput::make('kode_pos')
                                                    ->required()
                                                    ->maxLength(5)
                                                    ->minLength(5)
                                                    ->numeric()
                                                    ->placeholder('00000')
                                                    ->label('Kode Pos')
                                                    ->hint('5 digit angka')
                                                    ->hintColor('warning'),
                                                Forms\Components\TextInput::make('lintang')
                                                    ->numeric()
                                                    ->maxLength(20)
                                                    ->placeholder('-6.2088')
                                                    ->label('Lintang'),
                                                Forms\Components\TextInput::make('bujur')
                                                    ->numeric()
                                                    ->maxLength(20)
                                                    ->placeholder('106.8456')
                                                    ->label('Bujur'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 4: NPWP & Kewarganegaraan
                        Forms\Components\Tabs\Tab::make('NPWP')
                            ->icon('heroicon-o-document-text')
                            ->badge('4')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi NPWP dan kewarganegaraan GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('npwp')
                                                    ->maxLength(20)
                                                    ->minLength(15)
                                                    ->numeric()
                                                    ->placeholder('00.000.000.0-000.000')
                                                    ->label('NPWP')
                                                    ->hint('15 digit angka')
                                                    ->hintColor('warning'),
                                                Forms\Components\TextInput::make('nama_wajib_pajak')
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan nama wajib pajak')
                                                    ->label('Nama Wajib Pajak'),
                                                Forms\Components\Select::make('kewarganegaraan')
                                                    ->options([
                                                        'ID' => 'Indonesia',
                                                        'MY' => 'Malaysia',
                                                        'SG' => 'Singapura',
                                                        'BN' => 'Brunei Darussalam',
                                                        'TH' => 'Thailand',
                                                        'VN' => 'Vietnam',
                                                        'PH' => 'Filipina',
                                                        'MM' => 'Myanmar',
                                                        'KH' => 'Kamboja',
                                                        'LA' => 'Laos',
                                                        'TL' => 'Timor Leste',
                                                        'US' => 'Amerika Serikat',
                                                        'GB' => 'Inggris',
                                                        'NL' => 'Belanda',
                                                        'DE' => 'Jerman',
                                                        'FR' => 'Prancis',
                                                        'JP' => 'Jepang',
                                                        'KR' => 'Korea Selatan',
                                                        'CN' => 'Tiongkok',
                                                    ])
                                                    ->default('ID')
                                                    ->required()
                                                    ->searchable()
                                                    ->placeholder('Pilih kewarganegaraan')
                                                    ->label('Kewarganegaraan'),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        // Tab 5: Data Kepegawaian
                        Forms\Components\Tabs\Tab::make('Kepegawaian')
                            ->icon('heroicon-o-briefcase')
                            ->badge('5')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi kepegawaian GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('status_kepegawaian')
                                                    ->options([
                                                        'PNS' => 'PNS',
                                                        'PPPK' => 'PPPK',
                                                        'Honor Daerah TK.I Provinsi' => 'Honor Daerah TK.I Provinsi',
                                                        'Guru Honor Sekolah' => 'Guru Honor Sekolah',
                                                        'Tenga Honor Sekolah' => 'Tenga Honor Sekolah',
                                                    ])
                                                    ->searchable()
                                                    ->placeholder('Pilih status kepegawaian'),
                                                Forms\Components\TextInput::make('nip')
                                                    ->maxLength(18)
                                                    ->minLength(18)
                                                    ->numeric()
                                                    ->unique(ignoreRecord: true)
                                                    ->placeholder('Masukkan NIP')
                                                    ->label('NIP')
                                                    ->hint('18 digit angka')
                                                    ->hintColor('warning'),
                                                Forms\Components\TextInput::make('nuptk')
                                                    ->maxLength(16)
                                                    ->minLength(16)
                                                    ->numeric()
                                                    ->unique(ignoreRecord: true)
                                                    ->placeholder('Masukkan NUPTK')
                                                    ->label('NUPTK')
                                                    ->hint('16 digit angka')
                                                    ->hintColor('warning'),
                                                Forms\Components\Select::make('jenis_ptk')
                                                    ->options([
                                                        'Guru Kelas' => 'Guru Kelas',
                                                        'Guru Mata Pelajaran' => 'Guru Mata Pelajaran',
                                                        'Guru BK' => 'Guru BK',
                                                        'Guru TIK' => 'Guru TIK',
                                                        'Kepala Sekolah' => 'Kepala Sekolah',
                                                        'Wakil Kepala Sekolah' => 'Wakil Kepala Sekolah',
                                                        'Kepala Laboratorium' => 'Kepala Laboratorium',
                                                        'Kepala Perpustakaan' => 'Kepala Perpustakaan',
                                                        'Kepala Bengkel' => 'Kepala Bengkel',
                                                        'Tenaga Administrasi Sekolah' => 'Tenaga Administrasi Sekolah',
                                                        'Laboran' => 'Laboran',
                                                        'Pustakawan' => 'Pustakawan',
                                                        'Penjaga Sekolah' => 'Penjaga Sekolah',
                                                        'Petugas Keamanan' => 'Petugas Keamanan',
                                                        'Pesuruh/Office Boy' => 'Pesuruh/Office Boy',
                                                        'Tenaga Kebersihan' => 'Tenaga Kebersihan',
                                                    ])
                                                    ->searchable()
                                                    ->placeholder('Pilih jenis PTK')
                                                    ->label('Jenis PTK'),
                                                Forms\Components\Select::make('lembaga_pengangkat')
                                                    ->options([
                                                        'Pemerintah Pusat' => 'Pemerintah Pusat',
                                                        'Pemerintah Provinsi' => 'Pemerintah Provinsi',
                                                        'Pemerintah Kab/Kota' => 'Pemerintah Kab/Kota',
                                                        'Ketua Yayasan' => 'Ketua Yayasan',
                                                        'Kepala Sekolah' => 'Kepala Sekolah',
                                                    ])
                                                    ->searchable()
                                                    ->placeholder('Pilih lembaga pengangkat')
                                                    ->label('Lembaga Pengangkat'),
                                                Forms\Components\TextInput::make('sk_cpns')
                                                    ->maxLength(50),
                                                Forms\Components\DatePicker::make('tmt_cpns')
                                                    ->label('TMT CPNS'),
                                                Forms\Components\TextInput::make('sk_pns')
                                                    ->label('SK PNS')
                                                    ->maxLength(50),
                                                Forms\Components\DatePicker::make('tmt_pns')
                                                    ->label('TMT PNS'),
                                                Forms\Components\Select::make('sumber_gaji')
                                                    ->options([
                                                        'APBN' => 'APBN',
                                                        'APBD Provinsi' => 'APBD Provinsi',
                                                        'APBD Kab/Kota' => 'APBD Kab/Kota',
                                                        'Yayasan' => 'Yayasan',
                                                        'Sekolah' => 'Sekolah',
                                                        'Lembaga Donor' => 'Lembaga Donor',
                                                        'Lainnya' => 'Lainnya',
                                                    ])
                                                    ->searchable()
                                                    ->placeholder('Pilih sumber gaji')
                                                    ->label('Sumber Gaji'),
                                                Forms\Components\TextInput::make('nomor_karpeg')
                                                    ->label('Nomor KARPEG')
                                                    ->unique(ignoreRecord: true)
                                                    ->maxLength(50),
                                                Forms\Components\TextInput::make('nomor_karis_karsu')
                                                    ->label('Nomor KARSU/KARIS')
                                                    ->unique(ignoreRecord: true)
                                                    ->maxLength(50),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 6: Bidang Keahlian
                        Forms\Components\Tabs\Tab::make('Bidang Keahlian')
                            ->icon('heroicon-o-academic-cap')
                            ->badge('6')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi bidang keahlian GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Toggle::make('lisensi_kepala_sekolah')
                                                    ->helperText('Centang jika memiliki lisensi kepala sekolah'),
                                                Forms\Components\Toggle::make('keahlian_braille')
                                                    ->label('Memiliki Keahlian Braille')
                                                    ->helperText('Centang jika memiliki keahlian braille'),
                                                Forms\Components\Toggle::make('keahlian_bahasa_isyarat')
                                                    ->label('Memiliki Keahlian Bahasa Isyarat')
                                                    ->helperText('Centang jika memiliki keahlian bahasa isyarat'),
                                                Forms\Components\TextInput::make('nuks')
                                                    ->maxLength(100)
                                                    ->placeholder('Masukkan nomor NUKS')
                                                    ->label('Nomor UKS'),
                                                Forms\Components\TextInput::make('keahlian_laboratorium')
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan keahlian laboratorium')
                                                    ->label('Keahlian Laboratorium'),
                                                Forms\Components\TextInput::make('mampu_menangani_kebutuhan_khusus')
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan keahlian menangani kebutuhan khusus')
                                                    ->label('Keahlian Menangani Kebutuhan Khusus'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 7: Kontak & Autentikasi
                        Forms\Components\Tabs\Tab::make('Kontak & Autentikasi')
                            ->icon('heroicon-o-device-phone-mobile')
                            ->badge('7')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi kontak dan autentikasi GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('role')
                                                    ->options([
                                                        'guru' => 'Guru',
                                                        'kepala_sekolah' => 'Kepala Sekolah',
                                                        'tendik' => 'Tendik'
                                                    ])
                                                    ->default('guru'),
                                                Forms\Components\TextInput::make('no_telp_rumah'),
                                                Forms\Components\TextInput::make('no_hp')
                                                    ->tel()
                                                    ->maxLength(12)
                                                    ->unique(ignoreRecord: true)
                                                    ->placeholder('08xxxxxxxxxx')
                                                    ->label('Nomor HP'),
                                                Forms\Components\TextInput::make('email')
                                                    ->required()
                                                    ->email()
                                                    ->unique(ignoreRecord: true)
                                                    ->maxLength(100)
                                                    ->placeholder('nama@email.com')
                                                    ->label('Email'),
                                                Forms\Components\TextInput::make('password')
                                                    ->password()
                                                    ->required(fn ($context) => $context === 'create')
                                                    ->minLength(8)
                                                    ->dehydrated(fn ($state) => filled($state))
                                                    ->maxLength(255)
                                                    ->placeholder('********')
                                                    ->label('Password'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 8: Data Rekening Bank
                        Forms\Components\Tabs\Tab::make('Data Rekening Bank')
                            ->icon('heroicon-o-credit-card')
                            ->badge('8')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi rekening bank GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('nama_bank')
                                                    ->options(BankData::getBanks())
                                                    ->searchable()
                                                    ->placeholder('Pilih nama bank')
                                                    ->label('Nama Bank')
                                                    ->optionsLimit(100)
                                                    ->searchPrompt('Ketik untuk mencari bank...')
                                                    ->searchingMessage('Mencari bank...')
                                                    ->noSearchResultsMessage('Tidak ada bank yang ditemukan.'),
                                                Forms\Components\TextInput::make('cabang_bank')
                                                    ->label('Cabang Bank'),
                                                Forms\Components\TextInput::make('nomor_rekening')
                                                    ->label('Nomor Rekening')
                                                    ->unique(ignoreRecord: true)
                                                    ->maxLength(50),
                                                Forms\Components\TextInput::make('nama_pemilik_rekening')
                                                    ->label('Nama Pemilik Rekening'),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),
                            // Tab Riwayat Kepangkatan
                        Forms\Components\Tabs\Tab::make('Riwayat Kepangkatan')
                            ->icon('heroicon-o-arrow-trending-up')
                            ->badge('9')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi riwayat kepangkatan GTK')
                                    ->schema([
                                        Repeater::make('riwayat_kepangkatan')
                                            ->label('')
                                            ->schema([
                                                Forms\Components\Select::make('pangkat_golongan')
                                                    ->options([
                                                        'II/a' => 'Pengatur Muda (II/a)',
                                                        'II/b' => 'Pengatur Muda Tingkat I (II/b)',
                                                        'II/c' => 'Pengatur (II/c)',
                                                        'II/d' => 'Pengatur Tingkat I (II/d)',
                                                        'III/a' => 'Penata Muda (III/a)',
                                                        'III/b' => 'Penata Muda Tingkat I (III/b)',
                                                        'III/c' => 'Penata (III/c)',
                                                        'III/d' => 'Penata Tingkat I (III/d)',
                                                        'IV/a' => 'Pembina (IV/a)',
                                                        'IV/b' => 'Pembina Tingkat I (IV/b)',
                                                        'IV/c' => 'Pembina Utama Muda (IV/c)',
                                                        'IV/d' => 'Pembina Utama Madya (IV/d)',
                                                        'IV/e' => 'Pembina Utama (IV/e)',
                                                    ])
                                                    ->required()
                                                    ->searchable()
                                                    ->placeholder('Pilih pangkat/golongan')
                                                    ->label('Pangkat/Golongan'),
                                                Forms\Components\Select::make('jenis_pangkat')
                                                    ->options([
                                                        'Pengangkatan Pertama' => 'Pengangkatan Pertama',
                                                        'Kenaikan Pangkat Regular' => 'Kenaikan Pangkat Regular',
                                                        'Kenaikan Pangkat Pilihan' => 'Kenaikan Pangkat Pilihan',
                                                        'Penyesuaian Ijazah' => 'Penyesuaian Ijazah',
                                                        'Jabatan' => 'Jabatan',
                                                        'Impasing' => 'Impasing',
                                                    ])
                                                    ->required()
                                                    ->searchable()
                                                    ->placeholder('Pilih jenis pangkat')
                                                    ->label('Jenis Pangkat'),
                                                Forms\Components\TextInput::make('sk_pangkat')
                                                    ->required()
                                                    ->maxLength(50)
                                                    ->label('Nomor SK'),
                                                Forms\Components\DatePicker::make('tanggal_sk')
                                                    ->required()
                                                    ->label('Tanggal SK')
                                                    ->displayFormat('d/m/Y'),
                                                Forms\Components\DatePicker::make('tmt_pangkat')
                                                    ->required()
                                                    ->label('TMT Pangkat')
                                                    ->displayFormat('d/m/Y'),
                                                Forms\Components\TextInput::make('masa_kerja_tahun')
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(50)
                                                    ->placeholder('0')
                                                    ->label('Masa Kerja (Tahun)')
                                                    ->suffix('tahun'),
                                                Forms\Components\TextInput::make('masa_kerja_bulan')
                                                    ->required()
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->maxValue(11)
                                                    ->placeholder('0')
                                                    ->label('Masa Kerja (Bulan)')
                                                    ->suffix('bulan'),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->addActionLabel('Tambah Riwayat Kepangkatan')
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->collapsed()
                                            ->columnSpanFull()
                                            ->itemLabel(function ($state) {
                                                // Handling ketika state adalah string atau null
                                                if (!is_array($state)) {
                                                    return 'Riwayat Kepangkatan';
                                                }
                                                
                                                $pangkat = $state['pangkat_golongan'] ?? 'Belum diisi';
                                                $sk = $state['sk_pangkat'] ?? 'Belum diisi';
                                                
                                                return "{$pangkat} - {$sk}";
                                            })
                                            ->afterStateHydrated(function (Forms\Components\Repeater $component, $state) {
                                                if (is_string($state)) {
                                                    $component->state([]);
                                                }
                                            })
                                            ->mutateRelationshipDataBeforeFillUsing(function ($data): array {
                                                // Pastikan $data adalah array
                                                if (!is_array($data)) {
                                                    return [];
                                                }

                                                return collect($data)
                                                    ->map(function ($item) {
                                                        // Jika item adalah string atau null, return array kosong
                                                        if (!is_array($item)) {
                                                            return [];
                                                        }
                                                        
                                                        // Pastikan semua field yang dibutuhkan ada
                                                        return [
                                                            'pangkat_golongan' => $item['pangkat_golongan'] ?? null,
                                                            'jenis_pangkat' => $item['jenis_pangkat'] ?? null,
                                                            'sk_pangkat' => $item['sk_pangkat'] ?? null,
                                                            'tanggal_sk' => $item['tanggal_sk'] ?? null,
                                                            'tmt_pangkat' => $item['tmt_pangkat'] ?? null,
                                                            'masa_kerja_tahun' => $item['masa_kerja_tahun'] ?? null,
                                                            'masa_kerja_bulan' => $item['masa_kerja_bulan'] ?? null,
                                                        ];
                                                    })
                                                    ->filter()
                                                    ->values()
                                                    ->toArray();
                                            })
                                            ->mutateRelationshipDataBeforeSaveUsing(function ($data): array {
                                                if (!is_array($data)) {
                                                    return [];
                                                }

                                                return collect($data)
                                                    ->filter(function ($item) {
                                                        return is_array($item) 
                                                            && !empty($item['pangkat_golongan']) 
                                                            && !empty($item['sk_pangkat']);
                                                    })
                                                    ->values()
                                                    ->toArray();
                                            })
                                            ->extraAttributes([
                                                'class' => 'repeater-riwayat-kepangkatan',
                                            ]),
                                    ]),
                            ]),

                        // Tab Riwayat Sertifikasi
                        Forms\Components\Tabs\Tab::make('Riwayat Sertifikasi')
                            ->icon('heroicon-o-document-check')
                            ->badge('10')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi sertifikasi GTK')
                                    ->schema([
                                        Repeater::make('riwayat_sertifikasi')
                                            ->label('')
                                            ->schema([
                                                Forms\Components\Select::make('lembaga_sertifikasi')
                                                    ->required()
                                                    ->options([
                                                        'Kementerian Pendidikan dan Kebudayaan' => 'Kementerian Pendidikan dan Kebudayaan',
                                                        'Kementerian Agama' => 'Kementerian Agama',
                                                        'Kementerian Dalam Negeri' => 'Kementerian Dalam Negeri',
                                                        'Kementerian Kesehatan' => 'Kementerian Kesehatan',
                                                        'Kementerian Perindustrian' => 'Kementerian Perindustrian',
                                                        'Kementerian Perhubungan' => 'Kementerian Perhubungan',
                                                        'Kementerian Pertanian' => 'Kementerian Pertanian',
                                                        'Kementerian Energi dan Sumber Daya Mineral' => 'Kementerian Energi dan Sumber Daya Mineral',
                                                        'Kementerian Kelautan dan Perikanan' => 'Kementerian Kelautan dan Perikanan',
                                                        'Kementerian Pariwisata' => 'Kementerian Pariwisata',
                                                        'Lembaga Sertifikasi Profesi (LSP)' => 'Lembaga Sertifikasi Profesi (LSP)',
                                                        'Lainnya' => 'Lainnya',
                                                    ])
                                                    ->searchable()
                                                    ->placeholder('Pilih lembaga sertifikasi')
                                                    ->label('Lembaga Sertifikasi'),
                                                Forms\Components\Select::make('jenis_sertifikasi')
                                                    ->required()
                                                    ->options([
                                                        'Sertifikat Pendidik' => 'Sertifikat Pendidik',
                                                        'Surat Tanda Tamat Pendidikan dan Pelatihan (STTPP)' => 'Surat Tanda Tamat Pendidikan dan Pelatihan (STTPP)',
                                                        'Sertifikat Keahlian' => 'Sertifikat Keahlian',
                                                        'Sertifikat Kompetensi' => 'Sertifikat Kompetensi',
                                                        'Sertifikat Profesi' => 'Sertifikat Profesi',
                                                        'Sertifikat Pendidik Kejuruan' => 'Sertifikat Pendidik Kejuruan',
                                                    ])
                                                    ->searchable()
                                                    ->placeholder('Pilih jenis sertifikasi')
                                                    ->label('Jenis Sertifikasi'),
                                                Forms\Components\TextInput::make('nomor_sertifikat_pendidik')
                                                    ->required()
                                                    ->maxLength(50)
                                                    ->placeholder('Masukkan nomor sertifikat pendidik')
                                                    ->label('Nomor Sertifikat Pendidik'),
                                                Forms\Components\TextInput::make('nomor_registrasi_guru')
                                                    ->required()
                                                    ->maxLength(50)
                                                    ->placeholder('Masukkan NRG')
                                                    ->label('Nomor Registrasi Guru (NRG)'),
                                                Forms\Components\Select::make('bidang_studi_sertifikasi')
                                                    ->required()
                                                    ->searchable()
                                                    ->options(MataPelajaranData::getAllMataPelajaran())
                                                    ->placeholder('Pilih bidang studi sertifikasi')
                                                    ->label('Bidang Studi Sertifikasi'),
                                                Forms\Components\DatePicker::make('tanggal_sertifikasi')
                                                    ->required()
                                                    ->label('Tanggal Sertifikasi')
                                                    ->displayFormat('d/m/Y'),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->addActionLabel('Tambah Riwayat Sertifikasi')
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->collapsed()
                                            ->columnSpanFull()
                                            ->itemLabel(function ($state) {
                                                // Handling ketika state adalah string atau null
                                                if (!is_array($state)) {
                                                    return 'Riwayat Sertifikasi';
                                                }
                                                
                                                $lembaga = $state['lembaga_sertifikasi'] ?? 'Belum diisi';
                                                $jenis = $state['jenis_sertifikasi'] ?? 'Belum diisi';
                                                $bidang = $state['bidang_studi_sertifikasi'] ?? 'Belum diisi';
                                                
                                                return "{$lembaga} - {$jenis} - {$bidang}";
                                            })
                                            ->afterStateHydrated(function (Forms\Components\Repeater $component, $state) {
                                                if (is_string($state)) {
                                                    $component->state([]);
                                                }
                                            })
                                            ->mutateRelationshipDataBeforeFillUsing(function ($data): array {
                                                if (!is_array($data)) {
                                                    return [];
                                                }

                                                return collect($data)
                                                    ->map(function ($item) {
                                                        if (!is_array($item)) {
                                                            return [];
                                                        }
                                                        
                                                        return [
                                                            'lembaga_sertifikasi' => $item['lembaga_sertifikasi'] ?? null,
                                                            'jenis_sertifikasi' => $item['jenis_sertifikasi'] ?? null,
                                                            'nomor_sertifikat_pendidik' => $item['nomor_sertifikat_pendidik'] ?? null,
                                                            'nomor_registrasi_guru' => $item['nomor_registrasi_guru'] ?? null,
                                                            'bidang_studi_sertifikasi' => $item['bidang_studi_sertifikasi'] ?? null,
                                                            'tanggal_sertifikasi' => $item['tanggal_sertifikasi'] ?? null,
                                                        ];
                                                    })
                                                    ->filter()
                                                    ->values()
                                                    ->toArray();
                                            })
                                            ->mutateRelationshipDataBeforeSaveUsing(function ($data): array {
                                                if (!is_array($data)) {
                                                    return [];
                                                }

                                                return collect($data)
                                                    ->filter(function ($item) {
                                                        return is_array($item) 
                                                            && !empty($item['lembaga_sertifikasi'])
                                                            && !empty($item['jenis_sertifikasi'])
                                                            && !empty($item['bidang_studi_sertifikasi'])
                                                            && !empty($item['nomor_sertifikat_pendidik'])
                                                            && !empty($item['nomor_registrasi_guru'])
                                                            && !empty($item['tanggal_sertifikasi']);
                                                    })
                                                    ->map(function ($item) {
                                                        return [
                                                            'lembaga_sertifikasi' => $item['lembaga_sertifikasi'],
                                                            'jenis_sertifikasi' => $item['jenis_sertifikasi'],
                                                            'nomor_sertifikat_pendidik' => $item['nomor_sertifikat_pendidik'],
                                                            'nomor_registrasi_guru' => $item['nomor_registrasi_guru'],
                                                            'bidang_studi_sertifikasi' => $item['bidang_studi_sertifikasi'],
                                                            'tanggal_sertifikasi' => $item['tanggal_sertifikasi'],
                                                        ];
                                                    })
                                                    ->values()
                                                    ->toArray();
                                            })
                                            ->extraAttributes([
                                                'class' => 'repeater-riwayat-sertifikasi',
                                            ]),
                                    ]),
                            ]),

                        // Tab Riwayat Pendidikan
                        Forms\Components\Tabs\Tab::make('Riwayat Pendidikan')
                            ->icon('heroicon-o-academic-cap')
                            ->badge('11')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi riwayat pendidikan GTK dari SD sampai Perguruan Tinggi')
                                    ->schema([
                                        Repeater::make('riwayat_pendidikan')
                                            ->schema([
                                                Forms\Components\Select::make('jenjang')
                                                    ->required()
                                                    ->options([
                                                        'SD/MI' => 'SD/MI',
                                                        'SMP/MTs' => 'SMP/MTs',
                                                        'SMA/MA' => 'SMA/MA',
                                                        'SMK/MAK' => 'SMK/MAK',
                                                        'D1' => 'D1',
                                                        'D2' => 'D2',
                                                        'D3' => 'D3',
                                                        'D4' => 'D4',
                                                        'S1' => 'S1',
                                                        'S2' => 'S2',
                                                        'S3' => 'S3'
                                                    ])
                                                    ->searchable()
                                                    ->placeholder('Pilih jenjang pendidikan')
                                                    ->label('Jenjang Pendidikan')
                                                    ->live(),
                                                Forms\Components\TextInput::make('satuan_pendidikan')
                                                    ->required()
                                                    ->placeholder('Contoh: Universitas Indonesia'),
                                                Forms\Components\Select::make('bidang_studi')
                                                    ->options(MataPelajaranData::getAllMataPelajaran())
                                                    ->searchable()
                                                    ->placeholder('Pilih bidang studi')
                                                    ->label('Bidang Studi')
                                                    ->helperText('Pilih bidang studi sesuai dengan ijazah')
                                                    ->visible(fn (Get $get) => in_array($get('jenjang'), ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']))
                                                    ->required(fn (Get $get) => in_array($get('jenjang'), ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])),
                                                Forms\Components\Select::make('gelar_akademik')
                                                    ->options(GelarAkademikData::getGelarAkademik())
                                                    ->searchable()
                                                    ->placeholder('Pilih gelar akademik')
                                                    ->label('Gelar Akademik')
                                                    ->helperText('Pilih gelar sesuai dengan ijazah')
                                                    ->optionsLimit(100)
                                                    ->searchPrompt('Ketik untuk mencari gelar...')
                                                    ->visible(fn (Get $get) => 
                                                        in_array($get('jenjang'), ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']) && 
                                                        !$get('masih_sekolah')
                                                    ),
                                                Forms\Components\Select::make('tahun_masuk')
                                                    ->options(collect(range(date('Y'), 1950))
                                                        ->mapWithKeys(fn ($year) => [$year => $year])
                                                        ->toArray())
                                                    ->required()
                                                    ->searchable()
                                                    ->placeholder('Pilih tahun masuk')
                                                    ->default(date('Y')),
                                                Forms\Components\Select::make('tahun_lulus')
                                                    ->options(collect(range(date('Y'), 1950))
                                                        ->mapWithKeys(fn ($year) => [$year => $year])
                                                        ->toArray())
                                                    ->searchable()
                                                    ->placeholder('Pilih tahun lulus')
                                                    ->visible(fn (Get $get, $state) => 
                                                        !($get('masih_sekolah') && in_array($get('jenjang'), ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']))
                                                    ),
                                                // Field untuk pendidikan dasar menengah
                                                Forms\Components\TextInput::make('nisn')
                                                    ->label('NISN')
                                                    ->placeholder('Contoh: 18220032')
                                                    ->visible(fn (Get $get) => in_array($get('jenjang'), ['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK/MAK'])),
                                                Forms\Components\TextInput::make('rata_rata')
                                                    ->label('Nilai akhir')
                                                    ->numeric()
                                                    ->placeholder('Contoh: 85.5')
                                                    ->visible(fn (Get $get) => in_array($get('jenjang'), ['SD/MI', 'SMP/MTs', 'SMA/MA', 'SMK/MAK'])),
                                                // Field untuk pendidikan tinggi
                                                Forms\Components\TextInput::make('nim')
                                                    ->label('NIM')
                                                    ->placeholder('Contoh: 18220032')
                                                    ->visible(fn (Get $get) => in_array($get('jenjang'), ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])),
                                                Forms\Components\TextInput::make('ipk')
                                                    ->label('IPK')
                                                    ->numeric()
                                                    ->placeholder('Contoh: 3.75')
                                                    ->visible(fn (Get $get) => 
                                                        in_array($get('jenjang'), ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']) && 
                                                        !$get('masih_sekolah')
                                                    ),
                                                Forms\Components\TextInput::make('semester')
                                                    ->numeric()
                                                    ->placeholder('Contoh: 8')
                                                    ->visible(fn (Get $get) => 
                                                        in_array($get('jenjang'), ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3']) && 
                                                        $get('masih_sekolah')
                                                    ),
                                                Forms\Components\Toggle::make('masih_sekolah')
                                                    ->label('Masih Sekolah')
                                                    ->helperText('Centang jika masih sekolah')
                                                    ->visible(fn (Get $get) => in_array($get('jenjang'), ['S1', 'S2', 'S3']))
                                                    ->live(),
                                            ])
                                            ->columns(3)
                                            ->defaultItems(0)
                                            ->addActionLabel('Tambah Riwayat Pendidikan')
                                            ->reorderable()
                                            ->collapsible()
                                            ->cloneable()
                                            ->collapsed()
                                            ->columnSpanFull()
                                            ->itemLabel(function ($state) {
                                                if (!is_array($state)) {
                                                    return 'Riwayat Pendidikan';
                                                }
                                                
                                                $jenjang = $state['jenjang'] ?? 'Belum diisi';
                                                $satuan = $state['satuan_pendidikan'] ?? 'Belum diisi';
                                                $status = isset($state['masih_sekolah']) && $state['masih_sekolah'] ? '(Masih Sekolah)' : $state['tahun_masuk'] ?? 'Belum diisi';
                                                
                                                // Hanya tampilkan bidang studi untuk jenjang D1-S3
                                                if (in_array($jenjang, ['D1', 'D2', 'D3', 'D4', 'S1', 'S2', 'S3'])) {
                                                    $bstudi = $state['bidang_studi'] ?? 'Belum diisi';
                                                    return "{$jenjang} - {$satuan} - {$bstudi} - {$status}";
                                                }
                                                
                                                return "{$jenjang} - {$satuan} - {$status}";
                                            })
                                            ->extraAttributes([
                                                'class' => 'repeater-riwayat-pendidikan',
                                            ]),
                                    ]),
                            ]),

                        // Tab 11: Data Keluarga (menggantikan "Data Anak")
                        Forms\Components\Tabs\Tab::make('Data Keluarga')
                            ->icon('heroicon-o-users')
                            ->badge('12')
                            ->schema([
                                Forms\Components\Section::make('Data Perkawinan')
                                    ->description('Informasi status perkawinan GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('status_perkawinan')
                                                    ->options([
                                                        'Kawin' => 'Kawin',
                                                        'Belum Kawin' => 'Belum Kawin',
                                                        'Janda/Duda' => 'Janda/Duda'
                                                    ]),
                                                Forms\Components\TextInput::make('nama_suami_istri')
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('nip_suami_istri')
                                                    ->maxLength(18),
                                                Forms\Components\TextInput::make('pekerjaan_suami_istri')
                                                    ->maxLength(100),
                                            ])
                                            ->columns(2),
                                    ]),
                                Forms\Components\Section::make('Data Anak')
                                    ->description('Informasi data anak GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama_anak_1'),
                                                Forms\Components\TextInput::make('nama_anak_2'),
                                                Forms\Components\TextInput::make('nama_anak_3'),
                                                Forms\Components\TextInput::make('nama_anak_4'),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        // Tab 12: Beasiswa & Tunjangan
                        Forms\Components\Tabs\Tab::make('Beasiswa & Tunjangan')
                            ->icon('heroicon-o-banknotes')
                            ->badge('13')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi beasiswa dan tunjangan GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('jenis_beasiswa')
                                                    ->maxLength(100),
                                                Forms\Components\Textarea::make('keterangan_beasiswa'),
                                                Forms\Components\TextInput::make('tahun_mulai_beasiswa')
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('tahun_akhir_beasiswa')
                                                    ->numeric(),
                                                Forms\Components\Toggle::make('masih_menerima_beasiswa'),
                                                Forms\Components\TextInput::make('jenis_tunjangan')
                                                    ->maxLength(50),
                                                Forms\Components\TextInput::make('nama_tunjangan'),
                                                Forms\Components\TextInput::make('instansi_pemberi_tunjangan'),
                                                Forms\Components\TextInput::make('nominal_tunjangan')
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->prefix('Rp')
                                                    ->placeholder('0')
                                                    ->mask('999,999,999,999')
                                                    ->label('Nominal Tunjangan')
                                                    ->hint('Masukkan angka tanpa titik atau koma')
                                                    ->hintColor('warning'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 13: Tugas Tambahan
                        Forms\Components\Tabs\Tab::make('Tugas Tambahan')
                            ->icon('heroicon-o-clipboard-document-list')
                            ->badge('14')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi tugas tambahan GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('jabatan_tugas_tambahan')
                                                    ->maxLength(100)
                                                    ->placeholder('Masukkan jabatan tugas tambahan')
                                                    ->label('Jabatan Tugas Tambahan'),
                                                Forms\Components\TextInput::make('nomor_sk_tugas_tambahan')
                                                    ->maxLength(50)
                                                    ->placeholder('Masukkan nomor SK tugas tambahan')
                                                    ->label('Nomor SK Tugas Tambahan'),
                                                Forms\Components\DatePicker::make('tmt_tugas_tambahan')
                                                    ->label('TMT Tugas Tambahan')
                                                    ->displayFormat('d/m/Y')
                                                    ->format('Y-m-d')
                                                    ->placeholder('Pilih tanggal mulai tugas')
                                                    ->maxDate(now()),
                                                Forms\Components\DatePicker::make('tst_tugas_tambahan')
                                                    ->label('TST Tugas Tambahan')
                                                    ->displayFormat('d/m/Y')
                                                    ->format('Y-m-d')
                                                    ->placeholder('Pilih tanggal selesai tugas')
                                                    ->minDate(fn (Get $get) => $get('tmt_tugas_tambahan')),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 14: Penghargaan
                        Forms\Components\Tabs\Tab::make('Penghargaan')
                            ->icon('heroicon-o-trophy')
                            ->badge('15')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi penghargaan GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('tingkat_penghargaan')
                                                    ->maxLength(50),
                                                Forms\Components\TextInput::make('jenis_penghargaan')
                                                    ->maxLength(100)
                                                    ->placeholder('Masukkan jenis penghargaan')
                                                    ->label('Jenis Penghargaan'),
                                                Forms\Components\TextInput::make('nama_penghargaan')
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan nama penghargaan')
                                                    ->label('Nama Penghargaan'),
                                                Forms\Components\TextInput::make('tahun_penghargaan')
                                                    ->numeric()
                                                    ->length(4)
                                                    ->placeholder('2024')
                                                    ->label('Tahun Penghargaan')
                                                    ->hint('4 digit tahun')
                                                    ->hintColor('warning'),
                                                Forms\Components\TextInput::make('instansi_pemberi')
                                                    ->maxLength(255)
                                                    ->placeholder('Masukkan instansi pemberi penghargaan')
                                                    ->label('Instansi Pemberi'),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 15: Riwayat Gaji Berkala
                        Forms\Components\Tabs\Tab::make('Riwayat Gaji Berkala')
                            ->icon('heroicon-o-currency-dollar')
                            ->badge('16')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi riwayat gaji berkala GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nomor_sk_kgb')
                                                    ->maxLength(50),
                                                Forms\Components\DatePicker::make('tanggal_sk_kgb'),
                                                Forms\Components\DatePicker::make('tmt_kgb'),
                                                Forms\Components\TextInput::make('masa_kerja_tahun')
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('masa_kerja_bulan')
                                                    ->numeric(),
                                                Forms\Components\TextInput::make('gaji_pokok')
                                                    ->numeric()
                                                    ->step(0.01),
                                            ])
                                            ->columns(3),
                                    ]),
                            ]),

                        // Tab 16: Riwayat Karir
                        Forms\Components\Tabs\Tab::make('Riwayat Karir')
                            ->icon('heroicon-o-chart-bar')
                            ->badge('17')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi riwayat karir GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\KeyValue::make('riwayat_karir')
                                                    ->columnSpanFull(),
                                            ])
                                            ->columns(1),
                                    ]),
                            ]),

                        // Tab 17: Penugasan
                        Forms\Components\Tabs\Tab::make('Penugasan')
                            ->icon('heroicon-o-briefcase')  // Fixed: Added missing closing parenthesis
                            ->badge('18')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi penugasan GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nomor_surat_tugas')
                                                    ->maxLength(50),
                                                Forms\Components\DatePicker::make('tanggal_surat_tugas'),
                                                Forms\Components\DatePicker::make('tmt_tugas'),
                                                Forms\Components\Toggle::make('status_sekolah_induk'),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        // Tab 18: Data Keluar
                        Forms\Components\Tabs\Tab::make('Data Keluar')
                            ->icon('heroicon-o-arrow-right-circle')
                            ->badge('19')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi data keluar GTK')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('alasan_keluar')
                                                    ->maxLength(50)
                                                    ->placeholder('Masukkan alasan keluar')
                                                    ->label('Alasan Keluar'),
                                                Forms\Components\DatePicker::make('tanggal_keluar')
                                                    ->label('Tanggal Keluar')
                                                    ->displayFormat('d/m/Y')
                                                    ->format('Y-m-d')
                                                    ->placeholder('Pilih tanggal keluar')
                                                    ->maxDate(now()),
                                                Forms\Components\TextInput::make('nomor_sk_keluar')
                                                    ->maxLength(50)
                                                    ->placeholder('Masukkan nomor SK keluar')
                                                    ->label('Nomor SK Keluar'),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),
                        
                    ])
                    ->contained(false)
                    ->persistTabInQueryString()
                    ->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->label('Sekolah')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama GTK')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nip')
                    ->label('NIP')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('nuptk')
                    ->label('NUPTK')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status_kepegawaian')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'PNS' => 'success',
                        'PPPK' => 'info',
                        'Honor Daerah TK.I Provinsi' => 'primary',
                        'Guru Honor Sekolah' => 'warning',
                        'Tenga Honor Sekolah' => 'danger',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pangkat_golongan')
                    ->label('Pangkat/Gol')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('No. HP')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('riwayat_pendidikan')
                    ->label('Riwayat Pendidikan')
                    ->formatStateUsing(function ($state) {
                        // Jika state kosong atau bukan array
                        if (empty($state) || !is_array($state)) {
                            return '-';
                        }
                        
                        return collect($state)
                            ->map(function ($item) {
                                // Pastikan $item adalah array dan memiliki key yang dibutuhkan
                                if (!is_array($item)) {
                                    return '';
                                }
                                
                                $jenjang = $item['jenjang'] ?? '-';
                                $satuan = $item['satuan_pendidikan'] ?? '-';
                                $tahun = $item['tahun_lulus'] ?? '-';
                                
                                return "{$jenjang} - {$satuan} - {$tahun}";
                            })
                            ->filter() // Hapus string kosong
                            ->join('<br>');
                    })
                    ->html()
                    ->wrap()
                    ->searchable(false)
                    ->sortable(false),
                Tables\Columns\TextColumn::make('riwayat_kepangkatan')
                    ->label('Riwayat Kepangkatan')
                    ->formatStateUsing(function ($state) {
                        // Jika state kosong atau bukan array
                        if (empty($state) || !is_array($state)) {
                            return '-';
                        }
                        
                        return collect($state)
                            ->map(function ($item) {
                                // Pastikan $item adalah array dan memiliki key yang dibutuhkan
                                if (!is_array($item)) {
                                    return '';
                                }
                                
                                $pangkat = $item['pangkat_golongan'] ?? '-';
                                $sk = $item['sk_pangkat'] ?? '-';
                                
                                return "{$pangkat} - {$sk}";
                            })
                            ->filter() // Hapus string kosong
                            ->join('<br>');
                    })
                    ->html()
                    ->wrap(),
                Tables\Columns\TextColumn::make('riwayat_sertifikasi')
                    ->label('Riwayat Sertifikasi')
                    ->formatStateUsing(function ($state) {
                        // Jika state kosong atau bukan array
                        if (empty($state) || !is_array($state)) {
                            return '-';
                        }
                        
                        return collect($state)
                            ->map(function ($item) {
                                // Pastikan $item adalah array dan memiliki key yang dibutuhkan
                                if (!is_array($item)) {
                                    return '';
                                }
                                
                                $lembaga = $item['lembaga_sertifikasi'] ?? '-';
                                $jenis = $item['jenis_sertifikasi'] ?? '-';
                                $bidang = $item['bidang_studi_sertifikasi'] ?? '-';
                                
                                return "{$lembaga} - {$jenis} - {$bidang}";
                            })
                            ->filter() // Hapus string kosong
                            ->join('<br>');
                    })
                    ->html()
                    ->wrap(),
                Tables\Columns\TextColumn::make('kewarganegaraan')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'ID' => 'Indonesia',
                        'MY' => 'Malaysia',
                        'SG' => 'Singapura',
                        'BN' => 'Brunei Darussalam',
                        'TH' => 'Thailand',
                        'VN' => 'Vietnam',
                        'PH' => 'Filipina',
                        'MM' => 'Myanmar',
                        'KH' => 'Kamboja',
                        'LA' => 'Laos',
                        'TL' => 'Timor Leste',
                        'US' => 'Amerika Serikat',
                        'GB' => 'Inggris',
                        'NL' => 'Belanda',
                        'DE' => 'Jerman',
                        'FR' => 'Prancis',
                        'JP' => 'Jepang',
                        'KR' => 'Korea Selatan',
                        'CN' => 'Tiongkok',
                        default => $state,
                    })
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_kepegawaian')
                    ->options([
                        'PNS' => 'PNS',
                        'PPPK' => 'PPPK',
                        'Honor Daerah TK.I Provinsi' => 'Honor Daerah TK.I Provinsi',
                        'Guru Honor Sekolah' => 'Guru Honor Sekolah',
                        'Tenga Honor Sekolah' => 'Tenga Honor Sekolah',
                    ])
                    ->label('Status Kepegawaian'),
                Tables\Filters\SelectFilter::make('sekolah_id')
                    ->relationship('sekolah', 'nama_sekolah')
                    ->searchable()
                    ->preload()
                    ->label('Sekolah'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->button()
                    ->tooltip('Lihat'),
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning')
                    ->button()
                    ->tooltip('Ubah'),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->button()
                    ->tooltip('Hapus')
                    ->modalHeading('Hapus Data GTK')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data GTK ini? Data yang sudah dihapus tidak dapat dikembalikan.')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal')
                    ->successNotificationTitle('Data GTK berhasil dihapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus')
                        ->modalHeading('Hapus Data GTK')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data GTK yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->successNotificationTitle('Data GTK berhasil dihapus'),
                ]),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGtks::route('/'),
            'create' => Pages\CreateGtk::route('/create'),
            'edit' => Pages\EditGtk::route('/{record}/edit'),
            'view' => Pages\ViewGtk::route('/{record}'),
        ];
    }
}
