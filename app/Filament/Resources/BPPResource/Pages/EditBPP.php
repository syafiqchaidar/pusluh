<?php

namespace App\Filament\Resources\BPPResource\Pages;

use App\Filament\Resources\BPPResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBPP extends EditRecord
{
    protected static string $resource = BPPResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
