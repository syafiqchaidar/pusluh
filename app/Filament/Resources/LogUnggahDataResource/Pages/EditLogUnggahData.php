<?php

namespace App\Filament\Resources\LogUnggahDataResource\Pages;

use App\Filament\Resources\LogUnggahDataResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLogUnggahData extends EditRecord
{
    protected static string $resource = LogUnggahDataResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
