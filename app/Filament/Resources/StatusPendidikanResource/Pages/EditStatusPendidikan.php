<?php

namespace App\Filament\Resources\StatusPendidikanResource\Pages;

use App\Filament\Resources\StatusPendidikanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusPendidikan extends EditRecord
{
    protected static string $resource = StatusPendidikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
