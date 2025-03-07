<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SekolahResource\Pages;
use App\Filament\Resources\SekolahResource\RelationManagers;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\Model;
use App\Data\ProvinsiData;
use App\Data\KabupatenKotaData;
use App\Data\KecamatanData;
use App\Data\DesaKelurahanData;
use Filament\Forms\Get;
use Filament\Forms\Set;

class SekolahResource extends Resource
{
    protected static ?string $model = Sekolah::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    
    protected static ?string $navigationLabel = 'Sekolah';
    
    protected static ?string $modelLabel = 'Sekolah';
    
    protected static ?string $pluralModelLabel = 'Sekolah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Sekolah')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Identitas Sekolah')
                            ->icon('heroicon-o-identification')
                            ->badge('1')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi dasar tentang sekolah')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('npsn')
                                                    ->required()
                                                    ->maxLength(8)
                                                    ->unique(ignoreRecord: true)
                                                    ->label('NPSN')
                                                    ->placeholder('Masukkan NPSN')
                                                    ->hint('8 digit angka')
                                                    ->hintColor('warning'),
                                                Forms\Components\TextInput::make('nama_sekolah')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Nama Sekolah')
                                                    ->placeholder('Masukkan nama sekolah'),
                                                Forms\Components\TextInput::make('nama_kepala_sekolah')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Nama Kepala Sekolah')
                                                    ->placeholder('Masukkan nama kepala sekolah'),
                                                Forms\Components\TextInput::make('nip_kepala_sekolah')
                                                    ->maxLength(18)
                                                    ->label('NIP Kepala Sekolah')
                                                    ->placeholder('Masukkan NIP kepala sekolah')
                                                    ->hint('18 digit angka')
                                                    ->hintColor('warning'),
                                            ])
                                            ->columns([
                                                'default' => 1,
                                                'sm' => 2,
                                                'lg' => 4
                                            ]),
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('status_sekolah')
                                                    ->options([
                                                        'Negeri' => 'Negeri',
                                                        'Swasta' => 'Swasta'
                                                    ])
                                                    ->default('Negeri')
                                                    ->required()
                                                    ->native(false),
                                                Forms\Components\Select::make('bentuk_pendidikan')
                                                    ->options([
                                                        'SD' => 'SD',
                                                        'SMP' => 'SMP',
                                                        'SMA' => 'SMA',
                                                        'SMK' => 'SMK'
                                                    ])
                                                    ->required()
                                                    ->native(false)
                                                    ->searchable(),
                                                Forms\Components\Select::make('status_kepemilikan')
                                                    ->options([
                                                        'Pemerintah Pusat' => 'Pemerintah Pusat',
                                                        'Pemerintah Daerah' => 'Pemerintah Daerah',
                                                        'Yayasan' => 'Yayasan',
                                                        'Lainnya' => 'Lainnya'
                                                    ])
                                                    ->required()
                                                    ->native(false)
                                                    ->searchable(),
                                            ])
                                            ->columns([
                                                'default' => 1,
                                                'sm' => 2,
                                                'lg' => 3
                                            ]),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Alamat')
                            ->icon('heroicon-o-map-pin')
                            ->badge('2')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi lokasi sekolah')
                                    ->schema([
                                        Forms\Components\Textarea::make('alamat_jalan')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Alamat')
                                            ->placeholder('Masukkan alamat lengkap'),
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
                                            ->label('Kode Pos'),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Kontak')
                            ->icon('heroicon-o-device-phone-mobile')
                            ->badge('3')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi kontak sekolah')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nomor_telepon')
                                                    ->tel()
                                                    ->maxLength(255)
                                                    ->label('Nomor Telepon')
                                                    ->placeholder('021-1234567')
                                                    ->prefix('☎'),
                                                Forms\Components\TextInput::make('nomor_fax')
                                                    ->maxLength(255)
                                                    ->label('Nomor Fax')
                                                    ->placeholder('021-1234567')
                                                    ->prefix('📠'),
                                                Forms\Components\TextInput::make('email')
                                                    ->email()
                                                    ->required()
                                                    ->unique(ignoreRecord: true)
                                                    ->maxLength(255)
                                                    ->label('Email')
                                                    ->placeholder('sekolah@gmail.com')
                                                    ->prefix('@'),
                                                Forms\Components\TextInput::make('website')
                                                    ->url()
                                                    ->maxLength(255)
                                                    ->label('Website')
                                                    ->placeholder('https://www.website.sch.id')
                                                    ->prefix('🌐'),
                                            ])
                                            ->columns([
                                                'default' => 1,
                                                'sm' => 2,
                                                'lg' => 4
                                            ]),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Informasi Tambahan')
                            ->icon('heroicon-o-document-text')
                            ->badge('4')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi legalitas dan akademik')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('sk_pendirian')
                                                    ->maxLength(255)
                                                    ->label('SK Pendirian')
                                                    ->placeholder('Nomor SK Pendirian'),
                                                Forms\Components\DatePicker::make('tanggal_sk_pendirian')
                                                    ->label('Tanggal SK Pendirian')
                                                    ->format('d/m/Y')
                                                    ->displayFormat('d/m/Y'),
                                                Forms\Components\TextInput::make('sk_izin_operasional')
                                                    ->maxLength(255)
                                                    ->label('SK Izin Operasional')
                                                    ->placeholder('Nomor SK Izin Operasional'),
                                                Forms\Components\DatePicker::make('tanggal_sk_izin_operasional')
                                                    ->label('Tanggal SK Izin Operasional')
                                                    ->format('d/m/Y')
                                                    ->displayFormat('d/m/Y'),
                                            ])
                                            ->columns([
                                                'default' => 1,
                                                'sm' => 2,
                                                'lg' => 4
                                            ]),
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('akreditasi')
                                                    ->options([
                                                        'A' => 'A',
                                                        'B' => 'B',
                                                        'C' => 'C',
                                                        'Belum Terakreditasi' => 'Belum Terakreditasi'
                                                    ])
                                                    ->native(false),
                                                Forms\Components\Select::make('kurikulum')
                                                    ->options([
                                                        'Kurikulum Merdeka' => 'Kurikulum Merdeka',
                                                        'Kurikulum 2013' => 'Kurikulum 2013',
                                                        'KTSP' => 'KTSP'
                                                    ])
                                                    ->native(false),
                                            ])
                                            ->columns([
                                                'default' => 1,
                                                'sm' => 2
                                            ]),
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
                Tables\Columns\TextColumn::make('npsn')
                    ->label('NPSN')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_sekolah')
                    ->label('Sekolah')
                    ->badge()
                    ->color('info')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_kepala_sekolah')
                    ->label('Kepala Sekolah')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_sekolah')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Negeri' => 'success',
                        'Swasta' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('bentuk_pendidikan')
                    ->label('Jenjang')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'SD' => 'success',
                        'SMP' => 'info',
                        'SMA' => 'warning',
                        'SMK' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('kabupaten_kota')
                    ->label('Kab/Kota')
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_sekolah')
                    ->options([
                        'Negeri' => 'Negeri',
                        'Swasta' => 'Swasta'
                    ]),
                Tables\Filters\SelectFilter::make('bentuk_pendidikan')
                    ->options([
                        'SD' => 'SD',
                        'SMP' => 'SMP',
                        'SMA' => 'SMA',
                        'SMK' => 'SMK'
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('')
                    ->icon('heroicon-m-eye')
                    ->color('info')
                    ->button()
                    ->tooltip('Lihat')
                    ->url(fn (Model $record): string => route('filament.admin.resources.sekolahs.view', $record)),
                Tables\Actions\Action::make('edit')
                    ->label('')
                    ->icon('heroicon-m-pencil-square')
                    ->color('warning')
                    ->button()
                    ->tooltip('Ubah')
                    ->url(fn (Model $record): string => route('filament.admin.resources.sekolahs.edit', $record)),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->icon('heroicon-m-trash')
                    ->color('danger')
                    ->button()
                    ->tooltip('Hapus')
                    ->modalHeading('Hapus Data Sekolah')
                    ->modalDescription('Apakah Anda yakin ingin menghapus data sekolah ini? Data yang sudah dihapus tidak dapat dikembalikan.')
                    ->modalSubmitActionLabel('Ya, Hapus')
                    ->modalCancelActionLabel('Batal')
                    ->successNotificationTitle('Data sekolah berhasil dihapus'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('Hapus')
                        ->modalHeading('Hapus Data Sekolah')
                        ->modalDescription('Apakah Anda yakin ingin menghapus data sekolah yang dipilih? Data yang sudah dihapus tidak dapat dikembalikan.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->successNotificationTitle('Data sekolah berhasil dihapus'),
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
            'index' => Pages\ListSekolahs::route('/'),
            'create' => Pages\CreateSekolah::route('/create'),
            'edit' => Pages\EditSekolah::route('/{record}/edit'),
            'view' => Pages\ViewSekolah::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getModelLabel(): string
    {
        return 'Sekolah';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Sekolah';
    }

    public static function getCreateButtonLabel(): string
    {
        return 'Tambah Sekolah';
    }

    public static function getCreateModalIcon(): string
    {
        return 'heroicon-o-plus-circle';
    }
}
