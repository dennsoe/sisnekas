<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use App\Filament\Resources\SekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSekolah extends ViewRecord
{
    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('Ubah')
                ->icon('heroicon-m-pencil-square')
                ->color('warning')
                ->modalHeading('Ubah Data Sekolah')
                ->successNotificationTitle('Data sekolah berhasil diperbarui'),
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->icon('heroicon-m-trash')
                ->color('danger')
                ->modalHeading('Hapus Data Sekolah')
                ->modalDescription('Apakah Anda yakin ingin menghapus data sekolah ini? Data yang sudah dihapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal')
                ->successNotificationTitle('Data sekolah berhasil dihapus'),
            Actions\Action::make('back')
                ->label('Kembali')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->url(fn () => SekolahResource::getUrl('index')),
        ];
    }
}
