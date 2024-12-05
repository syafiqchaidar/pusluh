<?php

namespace App\Imports;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
class PenyuluhImport implements WithMultipleSheets
{
    
    public function sheets(): array
    {
        return [
            new SheetImport()
        ];
    }
}
