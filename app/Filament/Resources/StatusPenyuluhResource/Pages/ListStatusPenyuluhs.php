<?php

namespace App\Filament\Resources\StatusPenyuluhResource\Pages;

use App\Filament\Resources\StatusPenyuluhResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusPenyuluhs extends ListRecords
{
    protected static string $resource = StatusPenyuluhResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
