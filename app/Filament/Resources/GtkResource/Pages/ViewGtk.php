<?php

namespace App\Filament\Resources\GtkResource\Pages;

use App\Filament\Resources\GtkResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewGtk extends ViewRecord
{
    protected static string $resource = GtkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()
                ->label('')
                ->icon('heroicon-m-pencil-square')
                ->color('warning')
                ->button()
                ->tooltip('Ubah'),
            Actions\DeleteAction::make()
                ->label('')
                ->modalHeading('Hapus Data GTK')
                ->modalDescription('Apakah Anda yakin ingin menghapus data GTK ini? Data yang sudah dihapus tidak dapat dikembalikan.')
                ->modalSubmitActionLabel('Ya, Hapus')
                ->modalCancelActionLabel('Batal')
                ->successNotificationTitle('Data GTK berhasil dihapus'),
            Actions\Action::make('back')
                ->label('')
                ->icon('heroicon-m-arrow-left')
                ->color('gray')
                ->button()
                ->tooltip('Kembali')
                ->url(fn () => GtkResource::getUrl('index')),
        ];
    }
}
