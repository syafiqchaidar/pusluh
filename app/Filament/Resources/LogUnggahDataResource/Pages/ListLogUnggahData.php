<?php

namespace App\Filament\Resources\LogUnggahDataResource\Pages;

use App\Filament\Resources\LogUnggahDataResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLogUnggahData extends ListRecords
{
    protected static string $resource = LogUnggahDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
