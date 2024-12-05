<?php

namespace App\Imports;

use App\Models\DaftarPenerimaBOP;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\PendaftaranPenyuluh;
use App\Models\EImport;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Desa;
use App\Models\StatusPenyuluh;

class SheetImport implements ToCollection, WithHeadingRow, SkipsOnError
{
    private $errorCount = 0;

    /**
     * Constructor
     */
    public function __construct()
    {
        HeadingRowFormatter::default('none');
    }
    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        EImport::where('user_id', auth()->user()->id)->delete();
        $successCount = 0;
        $errorCount = 0;
        
        foreach ($rows as $row) {
            $prov = Provinsi::where('nama',$row['Provinsi'])->first();
            $kab1 = Kabupaten::where('nama',$row['Kabupaten/Kota'])->first();
            
            if(null!==$kab1){
                $kab = $kab1->id;
            }else{
                $kab = null;
            }
            $stat = StatusPenyuluh::where('nama',$row['Status (PNS/PPPK/THL-TBPP)'])->first();
            $nik1 = str_replace([' ', "'", '`'], '', $row['NIK']);
            $nomor1 = str_replace([' ', "'", '`'], '', $row['NIP/NI PPPK/Nomor Registrasi THL']);
            try {
                set_time_limit(300);
                DaftarPenerimaBOP::create([
                    'nama' => $row['Nama Penyuluh'],
                    'email' => $nomor1 . '@noemail.com',
                    'nik' => $nik1,
                    'nomor' => $nomor1,
                    'jenis_user' => $row['Wilayah Kerja Penyuluh (PENYULUH PROVINSI/PENYULUH KABKOTA/PENYULUH BPP)'],
                    'status_penyuluh' => $stat->id,
                    'provinsi_id' => $prov->id,
                    'kabupaten_id' => $kab,
                    'no_hp' => $row['No. HP (Prabayar)'],
                ]);
            // try {
            //     set_time_limit(600);
            //     PendaftaranPenyuluh::create([
            //         'nama' => $row['Nama Penyuluh'],
            //         'email' => $row['NIP/NI PPPK/Nomor Registrasi THL'] . '@noemail.com',
            //         'nik' => $row['NIK'],
            //         'nomor' => $row['NIP/NI PPPK/Nomor Registrasi THL'],
            //         'jenis_user' => $row['Wilayah Kerja Penyuluh (PENYULUH PROVINSI/KABKOTA/BPP)'],
            //         'status_penyuluh' => $stat->id,
            //         'provinsi_id' => $prov->id,
            //         'kabupaten_id' => $kab,
            //         'no_hp' => $row['No. HP (Prabayar)'],
            //     ]);

                // Increment the success count
                $successCount++;
            } catch (\Throwable $e) {
                // Increment the error count
                $errorCount++;
                
                

                // Log the error to your EImport model
                EImport::create([
                    'user_id' => auth()->user()->id,
                    'modul' => "Pendaftaran Penyuluh",
                    'error_messages' => $e->getMessage(),
                ]);
            }
        }

        if ($errorCount > 0) {
            Notification::make()
                ->title('Data Gagal Tersimpan')
                ->body("$errorCount data gagal tersimpan.")
                ->color('danger') 
                ->persistent()
                ->actions([
                    Action::make('view')
                        // ->url(url('/admin/e-imports'), shouldOpenInNewTab: true)
                        ->url(url('/admin/e-imports'))
                        ->button(),
                ])
                ->send();
        }
        if ($successCount > 0) {
            Notification::make()
                ->title('Data Tersimpan')
                ->body("$successCount data berhasil tersimpan")
                ->color('success') 
                ->persistent()
                ->send();
        }
    }
    /**
     * @return int
     */
    public function headingRow(): int
    {
        return 5;
    }

    public function onError(\Throwable $e)
    {
        // Log error details to e_import table

    }
}
