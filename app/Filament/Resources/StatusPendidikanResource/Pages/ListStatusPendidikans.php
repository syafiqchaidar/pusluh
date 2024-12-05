<?php

namespace App\Filament\Resources\StatusPendidikanResource\Pages;

use App\Filament\Resources\StatusPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusPendidikans extends ListRecords
{
    protected static string $resource = StatusPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
