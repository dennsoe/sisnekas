<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MataPelajaranResource\Pages;
use App\Models\MataPelajaran;
use App\Models\Sekolah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MataPelajaranResource extends Resource
{
    protected static ?string $model = MataPelajaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Akademik';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        $defaultSekolah = Sekolah::first();
        
        return $form
            ->schema([
                Forms\Components\Hidden::make('sekolah_id')
                    ->default(fn() => $defaultSekolah?->id)
                    ->required(),
                    
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\Select::make('sekolah_id')
                            ->relationship('sekolah', 'nama_sekolah')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->default(fn() => $defaultSekolah?->id)
                            ->label('Sekolah'),
                            
                        Forms\Components\TextInput::make('nama_mapel')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Mata Pelajaran'),
                            
                        Forms\Components\TextInput::make('kode_mapel')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('Kode Mata Pelajaran'),
                            
                        Forms\Components\Select::make('kelompok_mapel')
                            ->required()
                            ->options([
                                'A' => 'Kelompok A (Umum)',
                                'B' => 'Kelompok B (Umum)',
                                'C' => 'Kelompok C (Peminatan)',
                            ])
                            ->default('A')
                            ->label('Kelompok Mata Pelajaran'),
                            
                        Forms\Components\Select::make('tingkat_kelas')
                            ->required()
                            ->options([
                                10 => 'Kelas X',
                                11 => 'Kelas XI',
                                12 => 'Kelas XII',
                            ])
                            ->default(10)
                            ->label('Tingkat Kelas'),
                            
                        Forms\Components\TextInput::make('jumlah_jam')
                            ->required()
                            ->numeric()
                            ->default(2)
                            ->minValue(1)
                            ->maxValue(10)
                            ->label('Jumlah Jam per Minggu'),
                            
                        Forms\Components\Select::make('kurikulum')
                            ->required()
                            ->options([
                                'Kurikulum Merdeka' => 'Kurikulum Merdeka',
                                'Kurikulum 2013' => 'Kurikulum 2013',
                            ])
                            ->default('Kurikulum Merdeka')
                            ->label('Kurikulum'),
                            
                        Forms\Components\Toggle::make('aktif')
                            ->required()
                            ->default(true)
                            ->label('Status Aktif'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sekolah.nama_sekolah')
                    ->sortable()
                    ->searchable()
                    ->label('Sekolah'),
                Tables\Columns\TextColumn::make('nama_mapel')
                    ->sortable()
                    ->searchable()
                    ->label('Nama Mata Pelajaran'),
                Tables\Columns\TextColumn::make('kode_mapel')
                    ->sortable()
                    ->searchable()
                    ->label('Kode Mata Pelajaran'),
                Tables\Columns\TextColumn::make('kelompok_mapel')
                    ->sortable()
                    ->label('Kelompok'),
                Tables\Columns\TextColumn::make('tingkat_kelas')
                    ->sortable()
                    ->label('Tingkat'),
                Tables\Columns\TextColumn::make('jumlah_jam')
                    ->sortable()
                    ->label('Jam/Minggu'),
                Tables\Columns\IconColumn::make('aktif')
                    ->boolean()
                    ->sortable()
                    ->label('Status'),
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMataPelajarans::route('/'),
            'create' => Pages\CreateMataPelajaran::route('/create'),
            'edit' => Pages\EditMataPelajaran::route('/{record}/edit'),
        ];
    }
}
