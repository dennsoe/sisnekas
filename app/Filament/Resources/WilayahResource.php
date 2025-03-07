<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WilayahResource\Pages;
use App\Models\Province;
use App\Models\Regency;
use App\Models\District;
use App\Models\Village;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Facades\Artisan;
use Filament\Notifications\Notification;

class WilayahResource extends Resource
{
    protected static ?string $model = Province::class;
    protected static ?string $navigationIcon = 'heroicon-o-globe-asia-australia';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $pluralModelLabel = 'Wilayah';
    protected static ?string $modelLabel = 'Wilayah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Wilayah')
                    ->description('Kelola data wilayah administratif')
                    ->schema([
                        Forms\Components\Tabs::make('Wilayah')
                            ->tabs([
                                // Tab Provinsi
                                Forms\Components\Tabs\Tab::make('Provinsi')
                                    ->schema([
                                        Forms\Components\TextInput::make('province_code')
                                            ->label('Kode Provinsi')
                                            ->maxLength(2),
                                        Forms\Components\TextInput::make('province_name')
                                            ->label('Nama Provinsi')
                                            ->maxLength(255),
                                    ])->columns(2),

                                // Tab Kabupaten/Kota
                                Forms\Components\Tabs\Tab::make('Kabupaten/Kota')
                                    ->schema([
                                        Forms\Components\Select::make('province_id')
                                            ->label('Provinsi')
                                            ->options(Province::pluck('name', 'id'))
                                            ->searchable(),
                                        Forms\Components\TextInput::make('regency_code')
                                            ->label('Kode Kabupaten/Kota')
                                            ->maxLength(4),
                                        Forms\Components\TextInput::make('regency_name')
                                            ->label('Nama Kabupaten/Kota')
                                            ->maxLength(255),
                                    ])->columns(2),

                                // Tab Kecamatan
                                Forms\Components\Tabs\Tab::make('Kecamatan')
                                    ->schema([
                                        Forms\Components\Select::make('regency_id_district')
                                            ->label('Kabupaten/Kota')
                                            ->options(Regency::pluck('name', 'id'))
                                            ->searchable(),
                                        Forms\Components\TextInput::make('district_code')
                                            ->label('Kode Kecamatan')
                                            ->maxLength(7),
                                        Forms\Components\TextInput::make('district_name')
                                            ->label('Nama Kecamatan')
                                            ->maxLength(255),
                                    ])->columns(2),

                                // Tab Desa/Kelurahan
                                Forms\Components\Tabs\Tab::make('Desa/Kelurahan')
                                    ->schema([
                                        Forms\Components\Select::make('district_id_village')
                                            ->label('Kecamatan')
                                            ->options(District::pluck('name', 'id'))
                                            ->searchable(),
                                        Forms\Components\TextInput::make('village_code')
                                            ->label('Kode Desa/Kelurahan')
                                            ->maxLength(10),
                                        Forms\Components\TextInput::make('village_name')
                                            ->label('Nama Desa/Kelurahan')
                                            ->maxLength(255),
                                    ])->columns(2),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('regencies_count')
                    ->label('Kabupaten/Kota')
                    ->counts('regencies'),
                Tables\Columns\TextColumn::make('districts_count')
                    ->label('Kecamatan')
                    ->counts('districts'),
                Tables\Columns\TextColumn::make('villages_count')
                    ->label('Desa/Kelurahan')
                    ->counts('villages'),
            ])
            ->modifyQueryUsing(fn ($query) => 
                $query->withCount(['regencies', 'districts', 'villages'])
            )
            ->filters([
                //
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('seedWilayah')
                    ->label('Import Data Wilayah')
                    ->color('success')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->requiresConfirmation()
                    ->action(function () {
                        try {
                            Artisan::call('db:seed', [
                                '--class' => 'IndoRegionProvinceSeeder'
                            ]);
                            Artisan::call('db:seed', [
                                '--class' => 'IndoRegionRegencySeeder'
                            ]);
                            Artisan::call('db:seed', [
                                '--class' => 'IndoRegionDistrictSeeder'
                            ]);
                            Artisan::call('db:seed', [
                                '--class' => 'IndoRegionVillageSeeder'
                            ]);

                            Notification::make()
                                ->title('Data wilayah berhasil diimport')
                                ->success()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Gagal import data wilayah')
                                ->danger()
                                ->body($e->getMessage())
                                ->send();
                        }
                    })
                    ->modalHeading('Import Data Wilayah')
                    ->modalDescription('Proses ini akan mengimport data Provinsi, Kabupaten/Kota, Kecamatan, dan Desa/Kelurahan. Lanjutkan?')
                    ->modalSubmitActionLabel('Ya, Import Data')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWilayah::route('/'),
            'create' => Pages\CreateWilayah::route('/create'),
            'edit' => Pages\EditWilayah::route('/{record}/edit'),
        ];
    }
}
