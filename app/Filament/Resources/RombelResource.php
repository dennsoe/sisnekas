<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RombelResource\Pages;
use App\Models\Rombel;
use App\Models\MataPelajaran;
use App\Models\Gtk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class RombelResource extends Resource
{
    protected static ?string $model = Rombel::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $modelLabel = 'Rombongan Belajar';

    protected static ?string $pluralModelLabel = 'Rombongan Belajar';

    protected static ?string $navigationGroup = 'Akademik';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Rombongan Belajar')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('Informasi Dasar')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('sekolah_id')
                                            ->relationship('sekolah', 'nama_sekolah')
                                            ->required()
                                            ->searchable()
                                            ->preload(),

                                        Forms\Components\Grid::make()
                                            ->schema([
                                                Forms\Components\TextInput::make('nama_rombel')
                                                    ->datalist([
                                                        'X-ATPH A',
                                                        'X-ATPH B',
                                                        'X-RPL A',
                                                        'X-RPL B',
                                                        'X-RPL C',
                                                        'X-TSM A',
                                                        'X-TSM B',
                                                        'XI-ATPH',
                                                        'XI-RPL A',
                                                        'XI-RPL B',
                                                        'XI-RPL C',
                                                        'XI-TSM A',
                                                        'XI-TSM B',
                                                        'XI-TSM C',
                                                        'XII-ATPH',
                                                        'XII-RPL A',
                                                        'XII-RPL B',
                                                        'XII-RPL C',
                                                        'XII-TSM A',
                                                        'XII-TSM B',
                                                    ])
                                                    ->required()
                                                    ->label('Nama Rombel'),

                                                Forms\Components\Select::make('tingkat')
                                                    ->options([
                                                        10 => 'Tingkat 10',
                                                        11 => 'Tingkat 11',
                                                        12 => 'Tingkat 12',
                                                    ])
                                                    ->required(),

                                                Forms\Components\Select::make('jurusan')
                                                    ->options([
                                                        'Agribisnis Tanaman' => 'Agribisnis Tanaman',
                                                        'Agribisnis Tanaman Pangan dan Hortikultura' => 'Agribisnis Tanaman Pangan dan Hortikultura',
                                                        'Pengembangan Perangkat Lunak dan Gim' => 'Pengembangan Perangkat Lunak dan Gim',
                                                        'Rekayasa Perangkat Lunak' => 'Rekayasa Perangkat Lunak',
                                                        'Teknik Otomotif' => 'Teknik Otomotif',
                                                        'Teknik Sepeda Motor' => 'Teknik Sepeda Motor',
                                                    ])
                                                    ->searchable()
                                                    ->required()
                                                    ->preload()
                                                    ->label('Jurusan'),

                                                Forms\Components\TextInput::make('tahun_ajaran')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(date('Y')),

                                                Forms\Components\Select::make('semester')
                                                    ->options([
                                                        'ganjil' => 'Ganjil',
                                                        'genap' => 'Genap',
                                                    ])
                                                    ->required(),

                                                Forms\Components\TextInput::make('kuota')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(32),
                                            ])
                                            ->columns(3),

                                        Forms\Components\Select::make('wali_kelas_id')
                                            ->options(function() {
                                                return Gtk::query()
                                                    ->where('role', 'guru')
                                                    ->orWhere('role', 'kepala_sekolah')
                                                    ->orderBy('nama')
                                                    ->pluck('nama', 'id');
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->label('Wali Kelas')
                                            ->required(),

                                        Forms\Components\Toggle::make('aktif')
                                            ->default(true)
                                            ->required(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Siswa')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Select::make('siswa')
                                            ->relationship('siswa', 'nama')  // Ubah dari nama_lengkap ke nama
                                            ->multiple()
                                            ->searchable()
                                            ->preload(),
                                    ]),
                            ]),

                        Forms\Components\Tabs\Tab::make('Pembelajaran')
                            ->schema([
                                Forms\Components\Section::make()
                                    ->schema([
                                        Forms\Components\Repeater::make('pembelajaran')
                                            ->relationship()
                                            ->schema([
                                                Forms\Components\Select::make('mata_pelajaran_id')
                                                    ->label('Mata Pelajaran')
                                                    ->options(MataPelajaran::query()->pluck('nama_mapel', 'id'))
                                                    ->required()
                                                    ->searchable()
                                                    ->preload(),

                                                Forms\Components\Select::make('gtk_id')
                                                    ->label('Guru Pengajar')
                                                    ->options(Gtk::query()->pluck('nama', 'id'))
                                                    ->required()
                                                    ->searchable()
                                                    ->preload(),

                                                Forms\Components\TextInput::make('jam_mengajar')
                                                    ->required()
                                                    ->numeric()
                                                    ->default(2),

                                                Forms\Components\Select::make('status_pembelajaran')
                                                    ->options([
                                                        'aktif' => 'Aktif',
                                                        'nonaktif' => 'Nonaktif',
                                                    ])
                                                    ->default('aktif')
                                                    ->required(),
                                            ])
                                            ->columns(4),
                                    ]),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->searchable()
                    ->sortable()
                    ->label('Sekolah'),

                Tables\Columns\TextColumn::make('nama_rombel')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Rombel'),

                Tables\Columns\TextColumn::make('tingkat')
                    ->sortable(),

                Tables\Columns\TextColumn::make('jurusan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('waliKelas.nama')  // Ubah dari nama_lengkap ke nama
                    ->searchable()
                    ->sortable()
                    ->label('Wali Kelas'),

                Tables\Columns\TextColumn::make('tahun_ajaran')
                    ->sortable(),

                Tables\Columns\TextColumn::make('semester')
                    ->sortable(),

                Tables\Columns\TextColumn::make('kuota')
                    ->sortable(),

                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->sortable(),

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
                Tables\Filters\SelectFilter::make('sekolah')
                    ->relationship('sekolah', 'nama_sekolah'),

                Tables\Filters\SelectFilter::make('tingkat')
                    ->options([
                        1 => 'Tingkat 1',
                        2 => 'Tingkat 2',
                        3 => 'Tingkat 3',
                        4 => 'Tingkat 4',
                        5 => 'Tingkat 5',
                        6 => 'Tingkat 6',
                        7 => 'Tingkat 7',
                        8 => 'Tingkat 8',
                        9 => 'Tingkat 9',
                        10 => 'Tingkat 10',
                        11 => 'Tingkat 11',
                        12 => 'Tingkat 12',
                    ]),

                Tables\Filters\SelectFilter::make('semester')
                    ->options([
                        'ganjil' => 'Ganjil',
                        'genap' => 'Genap',
                    ]),

                Tables\Filters\Filter::make('aktif')
                    ->query(fn (Builder $query): Builder => $query->where('aktif', true)),
            ])
            ->actions([
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
            'index' => Pages\ListRombels::route('/'),
            'create' => Pages\CreateRombel::route('/create'),
            'edit' => Pages\EditRombel::route('/{record}/edit'),
        ];
    }

    public static function getModelLabel(): string
    {
        return 'Rombongan Belajar';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Rombongan Belajar';
    }

    public static function getCreateButtonLabel(): string
    {
        return 'Tambah Rombongan Belajar';
    }
}
