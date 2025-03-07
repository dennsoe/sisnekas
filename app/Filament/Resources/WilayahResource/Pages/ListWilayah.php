<?php

namespace App\Filament\Resources\WilayahResource\Pages;

use App\Filament\Resources\WilayahResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWilayah extends ListRecords
{
    protected static string $resource = WilayahResource::class;
    protected static ?string $title = 'Data Wilayah';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
