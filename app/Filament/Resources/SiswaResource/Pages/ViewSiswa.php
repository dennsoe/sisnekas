<?php

namespace App\Filament\Resources\SiswaResource\Pages;

use App\Filament\Resources\SiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSiswa extends ViewRecord
{
    protected static string $resource = SiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Ubah')
                ->icon('heroicon-m-pencil-square')
                ->color('warning')
                ->modalHeading('Ubah Data Siswa')
                ->successNotificationTitle('Data siswa berhasil diperbarui'),
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->modalHeading('Hapus Data Siswa')
                ->modalDescription('Apakah Anda yakin ingin menghapus data siswa ini? Data yang sudah dihapus tidak dapat dikembalikan.'),
        ];
    }
}