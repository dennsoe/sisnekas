<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSiswa extends EditRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make()
                ->label('Lihat')
                ->icon('heroicon-m-eye')
                ->color('info'),
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->modalHeading('Hapus Data Siswa')
                ->modalDescription('Apakah Anda yakin ingin menghapus data siswa ini? Data yang sudah dihapus tidak dapat dikembalikan.'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
