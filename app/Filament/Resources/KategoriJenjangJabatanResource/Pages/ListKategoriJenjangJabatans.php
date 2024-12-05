<?php

namespace App\Filament\Resources\KategoriJenjangJabatanResource\Pages;

use App\Filament\Resources\KategoriJenjangJabatanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriJenjangJabatans extends ListRecords
{
    protected static string $resource = KategoriJenjangJabatanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
