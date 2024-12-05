<?php

namespace App\Filament\Resources\DaftarPenyuluhResource\Pages;

use App\Filament\Resources\DaftarPenyuluhResource;
use App\Imports\PenyuluhImport;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use EightyNine\ExcelImport\ExcelImportAction;

class ListDaftarPenyuluhs extends ListRecords
{
    protected static string $resource = DaftarPenyuluhResource::class;
    protected ?string $heading = 'Daftar Penyuluh';
    protected function getHeaderActions(): array
    {
        $data = [
                Action::make('download')->label("Unduh Template Excel")
                ->url('/template/new_Format_Data_Penyuluh_2025.xlsx', shouldOpenInNewTab: true)
                ->icon('heroicon-o-document-text')
                ->color("info"),
                ExcelImportAction::make()
                ->slideOver()
                ->color("warning")
                ->use(PenyuluhImport::class),
                Actions\CreateAction::make(),
                
            ];
        return $data;
    }
}
