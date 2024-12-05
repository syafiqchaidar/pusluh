<?php

namespace App\Filament\Resources\DaftarPenyuluhResource\Pages;

use App\Filament\Resources\DaftarPenyuluhResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDaftarPenyuluh extends EditRecord
{
    protected static string $resource = DaftarPenyuluhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
