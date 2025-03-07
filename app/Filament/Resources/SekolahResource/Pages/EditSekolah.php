<?php

namespace App\Filament\Resources\SekolahResource\Pages;

use App\Filament\Resources\SekolahResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSekolah extends EditRecord
{
    protected static string $resource = SekolahResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->label('Hapus')
                ->modalHeading('Hapus Data Sekolah')
                ->successNotificationTitle('Data sekolah berhasil dihapus'),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            $this->getSaveFormAction()
                ->label('Simpan Perubahan')
                ->icon('heroicon-m-check')
                ->color('success')
                ->successNotificationTitle('Data sekolah berhasil diperbarui'),
            $this->getCancelFormAction()
                ->label('Batal')
                ->icon('heroicon-m-x-mark')
                ->color('gray'),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
