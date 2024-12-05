<?php

namespace App\Filament\Resources\KategoriJenjangJabatanResource\Pages;

use App\Filament\Resources\KategoriJenjangJabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKategoriJenjangJabatan extends EditRecord
{
    protected static string $resource = KategoriJenjangJabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
