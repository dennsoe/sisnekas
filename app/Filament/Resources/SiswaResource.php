<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiswaResource\Pages;
use App\Filament\Resources\SiswaResource\RelationManagers;
use App\Models\Siswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Enums\Pekerjaan;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Filament\Forms\Get;
use Filament\Forms\Set;

class SiswaResource extends Resource
{
    protected static ?string $model = Siswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $modelLabel = 'Siswa';
    protected static ?string $pluralModelLabel = 'Siswa';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Akademik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Siswa')
                    ->tabs([
                        // Tab 1: Identitas Siswa
                        Forms\Components\Tabs\Tab::make('Identitas Siswa')
                            ->icon('heroicon-o-identification')
                            ->badge('1')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi dasar identitas siswa')
                                    ->schema([
                                        Forms\Components\Select::make('sekolah_id')
                                            ->relationship('sekolah', 'nama_sekolah')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->default(fn () => \App\Models\Sekolah::first()?->id)
                                            ->label('Sekolah'),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\TextInput::make('nisn')
                                                    ->required()
                                                    ->maxLength(10)
                                                    ->unique(ignoreRecord: true),
                                                Forms\Components\TextInput::make('nis')
                                                    ->required()
                                                    ->maxLength(10)
                                                    ->unique(ignoreRecord: true),
                                            ])
                                            ->columns(3),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nik')
                                                    ->required()
                                                    ->maxLength(16)
                                                    ->unique(ignoreRecord: true),
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

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('jenis_kelamin')
                                                    ->options([
                                                        'L' => 'Laki-laki',
                                                        'P' => 'Perempuan',
                                                    ])
                                                    ->required(),
                                                Forms\Components\TextInput::make('tempat_lahir')
                                                    ->required(),
                                                Forms\Components\DatePicker::make('tanggal_lahir')
                                                    ->required()
                                                    ->displayFormat('d/m/Y')
                                                    ->format('Y-m-d'),
                                            ])
                                            ->columns(3),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('agama')
                                                    ->options([
                                                        'Islam' => 'Islam',
                                                        'Kristen' => 'Kristen',
                                                        'Katolik' => 'Katolik',
                                                        'Hindu' => 'Hindu',
                                                        'Buddha' => 'Buddha',
                                                        'Konghucu' => 'Konghucu',
                                                    ])
                                                    ->required(),
                                                Forms\Components\TextInput::make('kewarganegaraan')
                                                    ->default('Indonesia'),
                                                Forms\Components\TextInput::make('nomor_hp')
                                                    ->tel(),
                                                Forms\Components\TextInput::make('email')
                                                    ->email(),
                                            ])
                                            ->columns(2),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('asal_sekolah'),
                                                Forms\Components\TextInput::make('nomor_ijazah_sebelumnya'),
                                                Forms\Components\TextInput::make('nomor_skhun_sebelumnya'),
                                            ])
                                            ->columns(3),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Toggle::make('aktif')
                                                    ->required()
                                                    ->default(true),
                                                Forms\Components\DatePicker::make('tanggal_masuk')
                                                    ->required()
                                                    ->displayFormat('d/m/Y')
                                                    ->format('Y-m-d'),
                                                Forms\Components\DatePicker::make('tanggal_keluar')
                                                    ->displayFormat('d/m/Y')
                                                    ->format('Y-m-d')
                                                    ->hidden(fn (Forms\Get $get): bool => $get('aktif')),
                                                Forms\Components\TextInput::make('alasan_keluar')
                                                    ->hidden(fn (Forms\Get $get): bool => $get('aktif')),
                                            ])
                                            ->columns(2),
                                    ]),
                            ]),

                        // Tab 2: Alamat
                        Forms\Components\Tabs\Tab::make('Alamat')
                            ->icon('heroicon-o-map-pin')
                            ->badge('2')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->description('Informasi alamat tempat tinggal siswa')
                                    ->schema([
                                        Forms\Components\Textarea::make('alamat')
                                            ->required()
                                            ->rows(3)
                                            ->label('Alamat')
                                            ->placeholder('Masukkan alamat lengkap'),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('rt')
                                                    ->maxLength(3),
                                                Forms\Components\TextInput::make('rw')
                                                    ->maxLength(3),
                                            ])
                                            ->columns(2),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\Select::make('provinsi')
                                                    ->options(Province::pluck('name', 'id'))
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->afterStateUpdated(fn (Set $set) => $set('kabupaten_kota', null)),

                                                Forms\Components\Select::make('kabupaten_kota')
                                                    ->options(fn (Get $get): array => 
                                                        Regency::query()
                                                            ->where('province_id', $get('provinsi'))
                                                            ->pluck('name', 'id')
                                                            ->toArray()
                                                    )
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->afterStateUpdated(fn (Set $set) => $set('kecamatan', null)),

                                                Forms\Components\Select::make('kecamatan')
                                                    ->options(fn (Get $get): array => 
                                                        District::query()
                                                            ->where('regency_id', $get('kabupaten_kota'))
                                                            ->pluck('name', 'id')
                                                            ->toArray()
                                                    )
                                                    ->searchable()
                                                    ->preload()
                                                    ->live()
                                                    ->afterStateUpdated(fn (Set $set) => $set('desa_kelurahan', null)),

                                                Forms\Components\Select::make('desa_kelurahan')
                                                    ->options(fn (Get $get): array => 
                                                        Village::query()
                                                            ->where('district_id', $get('kecamatan'))
                                                            ->pluck('name', 'id')
                                                            ->toArray()
                                                    )
                                                    ->searchable()
                                                    ->preload(),
                                            ])
                                            ->columns(2),

                                        Forms\Components\TextInput::make('kode_pos')
                                            ->maxLength(5),
                                    ]),
                            ]),

                        // Tab 3: Data Orang Tua
                        Forms\Components\Tabs\Tab::make('Data Orang Tua')
                            ->icon('heroicon-o-users')
                            ->badge('3')
                            ->schema([
                                Forms\Components\Section::make('Data Ayah')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama_ayah')
                                                    ->required(),
                                                Forms\Components\TextInput::make('nik_ayah')
                                                    ->maxLength(16),
                                                Forms\Components\Select::make('pekerjaan_ayah')
                                                    ->options(Pekerjaan::toArray())
                                                    ->searchable()
                                                    ->nullable()
                                                    ->default(null),
                                                Forms\Components\TextInput::make('penghasilan_ayah')
                                                    ->numeric()
                                                    ->nullable()
                                                    ->default(null),
                                            ])
                                            ->columns(2),
                                    ]),

                                Forms\Components\Section::make('Data Ibu')
                                    ->schema([
                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama_ibu')
                                                    ->required(),
                                                Forms\Components\TextInput::make('nik_ibu')
                                                    ->maxLength(16),
                                                Forms\Components\Select::make('pekerjaan_ibu')
                                                    ->options(Pekerjaan::toArray())
                                                    ->searchable()
                                                    ->nullable()
                                                    ->default(null),
                                                Forms\Components\TextInput::make('penghasilan_ibu')
                                                    ->numeric()
                                                    ->nullable()
                                                    ->default(null),
                                            ])
                                            ->columns(2),
                                    ]),

                                Forms\Components\Section::make('Data Wali')
                                    ->schema([
                                        Forms\Components\Toggle::make('has_wali')
                                            ->label('Memiliki Wali')
                                            ->live(),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama_wali')
                                                    ->hidden(fn (Get $get): bool => ! $get('has_wali')),
                                                Forms\Components\TextInput::make('nik_wali')
                                                    ->maxLength(16)
                                                    ->hidden(fn (Get $get): bool => ! $get('has_wali')),
                                                Forms\Components\Select::make('pekerjaan_wali')
                                                    ->options(Pekerjaan::toArray())
                                                    ->searchable()
                                                    ->nullable()
                                                    ->hidden(fn (Get $get): bool => ! $get('has_wali')),
                                                Forms\Components\TextInput::make('penghasilan_wali')
                                                    ->numeric()
                                                    ->nullable()
                                                    ->hidden(fn (Get $get): bool => ! $get('has_wali')),
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
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nis')
                    ->label('NIS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis_kelamin')
                    ->label('L/P')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'L' => 'info',
                        'P' => 'danger',
                    }),
                Tables\Columns\TextColumn::make('tempat_lahir')
                    ->label('TTL')
                    ->formatStateUsing(fn ($record) => "{$record->tempat_lahir}, " . date('d/m/Y', strtotime($record->tanggal_lahir)))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_hp')
                    ->label('No. HP')
                    ->searchable(),
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sekolah_id')
                    ->relationship('sekolah', 'nama_sekolah')
                    ->label('Sekolah')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('jenis_kelamin')
                    ->options([
                        'L' => 'Laki-laki',
                        'P' => 'Perempuan',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListSiswas::route('/'),
            'create' => Pages\CreateSiswa::route('/create'),
            'view' => Pages\ViewSiswa::route('/{record}'),
            'edit' => Pages\EditSiswa::route('/{record}/edit'),
        ];
    }
}
