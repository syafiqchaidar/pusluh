<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DaftarPenyuluhResource\Pages;
use App\Filament\Resources\DaftarPenyuluhResource\RelationManagers;
use App\Models\Bpp;
use App\Models\DaftarPenerimaBOP;
use App\Models\DaftarPenyuluh;
use App\Models\Desa;
use App\Models\JabatanFungsional;
use App\Models\Kabupaten;
use App\Models\KategoriJabatanFungsional;
use App\Models\Kecamatan;
use App\Models\PangkatGolongan;
use App\Models\Provinsi;
use App\Models\StatusPendidikan;
use App\Models\StatusPenyuluh;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\ActionsPosition;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class DaftarPenyuluhResource extends Resource
{
    protected static ?string $model = DaftarPenerimaBOP::class;

    protected static ?string $navigationGroup = 'Data Penyuluh';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Daftar Penerima BOP';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')
                    ->label('Nama Lengkap')
                    ->required(),
                Forms\Components\TextInput::make('nik')
                    ->label('Nomor Induk Kependudukan (NIK)')
                    ->required()
                    ->numeric(),
                Forms\Components\Select::make('status_penyuluh')
                    ->label('Status (PNS/PPPK/THL-TBPP)')
                    ->searchable()
                    ->options(function () {
                        return StatusPenyuluh::all()->pluck('nama', 'id')->toArray();
                    })
                    ->required()->live(),
                Forms\Components\TextInput::make('nomor')
                    ->label('NIP/NI PPPK/Nomor Registrasi THL')
                    ->required()
                    ->numeric(function(Get $get){
                        if($get('status_penyuluh')==3){
                            return false;
                        }else{
                            return true;
                        }
                    }),
                Forms\Components\TextInput::make('tahun')
                    ->label('Tahun Pengangkatan')
                    ->hiddenOn('create')
                    ->numeric()
                    ->maxLength(4),
                
                Forms\Components\Select::make('status_pendidikan')
                    ->label('Pendidikan Terakhir')
                    ->hiddenOn('create')
                    ->searchable()
                    ->options(function () {
                        return StatusPendidikan::all()->pluck('nama', 'nama')->toArray();
                    }),
                Forms\Components\Select::make('jenis_kelamin')
                    ->label('Jenis Kelamin')
                    ->hiddenOn('create')
                    ->searchable()
                    ->options([
                        'Laki-Laki' => 'Laki-laki',
                        'Perempuan' => 'Perempuan',
                    ]),
                Forms\Components\TextInput::make('tempat_lahir')
                    ->label('Tempat Lahir')->hiddenOn('create'),
                Forms\Components\DatePicker::make('tanggal_lahir')
                    ->label('Tanggal Lahir')->hiddenOn('create'),
                Forms\Components\TextInput::make('no_hp')
                    ->label('No. HP (Prabayar) (Konsultasikan dengan pusat)')
                    ->disabledOn('edit')
                    ->required(),
                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->email(),
                Forms\Components\Select::make('jenis_user')
                    ->label('Wilayah Kerja Penyuluh (PENYULUH PROVINSI/KABKOTA/BPP)')
                    ->options([
                        'PENYULUH PROVINSI' => 'PENYULUH PROVINSI',
                        'PENYULUH KABKOTA' => 'PENYULUH KABKOTA',
                        'PENYULUH BPP' => 'PENYULUH BPP',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\Select::make('kategori_jf_id')
                    ->label('Kategori Jabatan Fungsional')
                    ->hiddenOn('create')
                    ->searchable()
                    ->options(function () {
                        return KategoriJabatanFungsional::all()->pluck('nama', 'id')->toArray();
                    })
                    ->visible(function (Get $get) {
                                            if ($get('status_penyuluh') == 3) {
                                                return false;
                                            } else {
                                                return  true;
                                            }
                                        })
                                        ->live(),
                Forms\Components\Select::make('jf_penyuluh_id')
                    ->label('Nama Jenjang Jabatan')
                    ->hiddenOn('create')
                    ->searchable()
                    ->options(function (Get $get) {
                        if (NULL !== $get('kategori_jf_id')) {
                            return JabatanFungsional::where('kategori_jf_id', $get('kategori_jf_id'))->pluck('jenjang_jabat', 'id')->toArray();
                        } else {
                            return NULL;
                        }
                    })
                    ->visible(function (Get $get) {
                                            if ($get('status_penyuluh') == 3) {
                                                return false;
                                            } else {
                                                return  true;
                                            }
                                        })
                                        ->live(),
                Forms\Components\Select::make('pangkat_golongans_id')
                    ->label('Golongan')
                    ->hiddenOn('create')
                    ->searchable()
                    ->options(function (Get $get) {
                                            if (NULL !== $get('jf_penyuluh_id')) {
                                                if ($get('status_penyuluh') == 2) {
                                                    return PangkatGolongan::where([['jf_penyuluh_id', $get('jf_penyuluh_id')], ['status_penyuluh_id', 2]])->pluck('nama', 'id')->toArray();
                                                } elseif ($get('status_penyuluh') == 1) {
                                                    return PangkatGolongan::where([['jf_penyuluh_id', $get('jf_penyuluh_id')], ['status_penyuluh_id', 1]])->pluck('nama', 'id')->toArray();
                                                }
                                            } else {
                                                return NULL;
                                            }
                                        })->visible(function (Get $get) {
                                            if ($get('status_penyuluh') == 3) {
                                                return false;
                                            } else {
                                                return  true;
                                            }
                                        }),
                Forms\Components\Select::make('provinsi_id')
                    ->label('Nama Provinsi')
                    ->searchable()
                    ->options(function () {
                        $user = auth()->user();
                        if ($user->hasRole('Provinsi')) {
                            return Provinsi::where('id', auth()->user()->provinsi_id)->pluck('nama', 'id')->toArray();
                        } else {
                            return Provinsi::all()->pluck('nama', 'id')->toArray();
                        }
                    })
                    ->required()->live(),
                Forms\Components\Select::make('kabupaten_id')
                    ->label('Nama Kabupaten/Kota')
                    ->searchable()
                    ->options(function (Get $get) {
                        if (NULL !== $get('provinsi_id')) {
                            return Kabupaten::where('provinsi_id', $get('provinsi_id'))->pluck('nama', 'id')->toArray();
                        } else {
                            return NULL;
                        }
                    })
                    ->required()
                    ->visible(function (Get $get) {
                        if (NULL !== $get('jenis_user')) {
                            if ($get('jenis_user') == "PENYULUH PROVINSI") {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    })
                    ->live(),
                Forms\Components\Select::make('bpp_id')
                    ->label('Nama BPP')
                    ->hiddenOn('create')
                    ->searchable()
                    ->options(function (Get $get) {
                        if (NULL !== $get('kabupaten_id')) {
                            return Bpp::where('kabupaten_id', $get('kabupaten_id'))->pluck('nama', 'id')->toArray();
                        } else {
                            return NULL;
                        }
                    })
                    ->visible(function (Get $get) {
                        if (NULL !== $get('jenis_user')) {
                            if ($get('jenis_user') == "PENYULUH BPP") {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    })
                    ->live(),

                    Forms\Components\Select::make('wilbin')
                    ->label('Wilayah Binaan')
                    ->hiddenOn('create')
                    ->multiple()
                    ->searchable()
                    ->options(
                        function (Get $get){
                            if ($get('jenis_user') == "PENYULUH BPP") {
                                if (null !== $get('kabupaten_id')) {
                                    $statusPendidikanOptions = Desa::where('kabupaten_id', $get('kabupaten_id'))->pluck('nama', 'id')->toArray();
                                } elseif (null == $get('kabupaten_id')) {
                                    $statusPendidikanOptions = null;
                                }
                                return $statusPendidikanOptions;
                            } elseif ($get('jenis_user') == "PENYULUH KABKOTA") {
                                if (null !== $get('kabupaten_id')) {
                                    $statusPendidikanOptions = Kecamatan::where('kabupaten_id', $get('kabupaten_id'))->pluck('nama', 'id')->toArray();
                                } else {
                                    $statusPendidikanOptions = null;
                                }
                                return $statusPendidikanOptions;
                            } elseif ($get('jenis_user') == "PENYULUH PROVINSI") {
                                if (null !== $get('provinsi_id')) {
                                    $statusPendidikanOptions = Kabupaten::where('provinsi_id', $get('provinsi_id'))->pluck('nama', 'id')->toArray();
                                } else {
                                    $statusPendidikanOptions = null;
                                }
                                return $statusPendidikanOptions;
                            }
                        }
                    ),
                    Forms\Components\TextInput::make('nama_rekening')
                    ->label('Nama Pemilik Rekening')
                    ->hiddenOn('create')
                    ->disabled(function () {
                        if (
                            auth()->user()->hasRole('Provinsi') or
                            auth()->user()->hasRole('Pusat') or
                            auth()->user()->hasRole('super_admin')
                        ) {
                            return false;
                        } else {
                            return true;
                        }
                    }),
                    Forms\Components\TextInput::make('bank_rekening')
                    ->label('Nama Bank Rekening')
                    ->hiddenOn('create')
                    ->disabled(function () {
                        if (
                            auth()->user()->hasRole('Provinsi') or
                            auth()->user()->hasRole('Pusat') or
                            auth()->user()->hasRole('super_admin')
                        ) {
                            return false;
                        } else {
                            return true;
                        }
                    }),
                    Forms\Components\TextInput::make('nomor_rekening')
                    ->label('Nomor Rekening')
                    ->hiddenOn('create')
                    ->disabled(function () {
                        if (
                            auth()->user()->hasRole('Provinsi') or
                            auth()->user()->hasRole('Pusat') or
                            auth()->user()->hasRole('super_admin')
                        ) {
                            return false;
                        } else {
                            return true;
                        }
                    }),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Lengkap')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('nik')
                    ->label('NIK')
                    ->formatStateUsing(function($state){return "'".$state;})
                    ->searchable(),
                Tables\Columns\TextColumn::make('nomor')
                    ->label('NIP/NI PPPK/Nomor Registrasi THL')
                    ->formatStateUsing(function($state){return "'".$state;})
                    ->searchable(),
                Tables\Columns\TextColumn::make('jenis_user')
                    ->label('Wilayah Kerja Penyuluh (PENYULUH PROVINSI/KABKOTA/BPP)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('provinsi.nama')
                    ->label('Nama Provinsi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('kabupaten.nama')
                    ->label('Nama Kabupaten/Kota')
                    ->default('Bukan Penyuluh Kab/Kota/BPP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('bpp.nama')
                    ->label('Nama BPP')
                    ->default('Bukan Penyuluh BPP')
                    ->searchable(),
                Tables\Columns\TextColumn::make('statuspenyuluh.nama')
                    ->label('Status (PNS/PPPK/THL-TBPP)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('no_hp')
                    ->label('Nomor HP')
                    ->formatStateUsing(function($state){return "'".$state;})
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->label('Status Registrasi')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Data Dibuat Pada')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
                SelectFilter::make('provinsi_id')
                ->label('Pilih Provinsi')
                ->options(function () {
                    $user = auth()->user();
                if ($user->hasRole('Bpp') or $user->hasRole('Kabupaten') or $user->hasRole('Provinsi')) {
                    return Provinsi::where('id',$user->provinsi_id)->pluck('nama', 'id')->toArray();
                }else{
                    return Provinsi::all()->pluck('nama', 'id')->toArray();
                }})->searchable(),
            SelectFilter::make('kabupaten_id')
                ->label('Pilih Kabupaten/Kota')
                ->options(function () {
                    $user = auth()->user();
                if ($user->hasRole('Bpp') or $user->hasRole('Kabupaten')) {
                    return Kabupaten::where('id',$user->kabupaten_id)->pluck('nama', 'id')->toArray();
                }elseif ($user->hasRole('Provinsi')) {
                    return Kabupaten::where('provinsi_id',$user->provinsi_id)->pluck('nama', 'id')->toArray();
                }else{
                    return Kabupaten::all()->pluck('nama', 'id')->toArray();
                }})->searchable(),
            SelectFilter::make('bpp_id')
                ->label('Pilih BPP')
                ->options(function () {
                    $user = auth()->user();
                if ($user->hasRole('Bpp')) {
                    return Bpp::where('id',$user->bpp_id)->pluck('nama', 'id')->toArray();
                }elseif ($user->hasRole('Kabupaten')) {
                    return Bpp::where('kabupaten_id',$user->kabupaten_id)->pluck('nama', 'id')->toArray();
                }elseif ($user->hasRole('Provinsi')) {
                    return Bpp::where('provinsi_id',$user->provinsi_id)->pluck('nama', 'id')->toArray();
                }else{
                    return Bpp::all()->pluck('nama', 'id')->toArray();
                }})->searchable(),
            SelectFilter::make('status')
                ->label('Pilih Status')
                ->options([
                    '1' => 'Teregistrasi',
                    '0' => 'Belum Teregistrasi',
                ])->searchable(),
            SelectFilter::make('status_aktif')
                ->label('Pilih Status Aktif')
                ->options([
                    '1' => 'Aktif',
                    '0' => 'Non Aktif',
                ])->searchable(),
        ], layout: FiltersLayout::AboveContent)->filtersFormColumns(5)
        ->headerActions([
           // Tables\Actions\CreateAction::make(),
           ExportAction::make()->exports([
            ExcelExport::make('table')->fromTable(),
        ])
        ])
        ->actions([
            Tables\Actions\DeleteAction::make()->button()->visible(function($record){
                if($record->status==true){
                    return false;
                }else{
                    return true;
                }
            }),
        //   Tables\Actions\Action::make('updateStatus')
        //   ->visible(function($record){
        //         $user = auth()->user();
        //         if($user->hasRole('Provinsi') or $user->hasRole('super_admin') or $user->hasRole('Pusat')){
        //             return true;
        //         }else{
        //             return false;
        //         }
        //     })
        //     ->label('Ubah Status Registrasi')
        //     ->button()
        //     ->form([
        //         Forms\Components\Select::make('status')
        //             ->label('Ubah Status Registrasi')
        //             ->options([
        //                 '1'=>'Terregistrasi',
        //                 '0'=>'Belum Terregistrasi'
        //                 ])
        //             ->required(),
        //     ])
        //     ->action(function (array $data, Post $record): void {
        //         $record->update(['status'=>$data['status']]);
        //     }),
            Tables\Actions\Action::make('update_nonaktif')
            ->visible(function($record){
                $user = auth()->user();
                if($user->hasRole('Provinsi') or $user->hasRole('super_admin')){
                // if($record->status==true){
                    return true;
                // }else{
                //     return false;
                // }
                }else{
                    return false;
                }
            })
            ->label(function($record){
                $sta = $record->status_aktif;
                if($sta==true){
                    return "Status Aktif";
                }else{
                    return "Status Non Aktif";
                }
            })
            ->color(function($record){
                $sta = $record->status_aktif;
                if($sta==true){
                    return 'info';
                }else{
                    return 'danger';
                }
            })
            ->button()
            ->fillForm(
                function ($record): array {
                    $re = $record->tanggal_nonaktif;
                    if(null!==$re){
                         return [
                             'status1' => 0,
                            'tanggal_nonaktif' => $record->tanggal_nonaktif,
                            'dokumen_nonaktif' => $record->dokumen_nonaktif,
                            'ket_nonaktif' => $record->ket_nonaktif,
                        ];
                    }else{
                         return [
                             'status1' => 1,
                           
                        ];
                    }
                       
                    })
                ->form([
                    Forms\Components\Select::make('status1')
                        ->label('Status')
                        ->options([
                            '0' => 'Non-Aktif (Pensiun/Meninggal/Mengundurkan Diri/Mutasi/Cuti)',
                            '1' => 'Aktif',
                            ])
                            ->default(1)
                        ->live()
                        ->required(),
                    Forms\Components\DatePicker::make('tanggal_nonaktif')
                        ->label('Tanggal Non Aktif')
                        ->visible(function($get){
                            if($get('status1')==1){
                                return false;
                            }else{
                                return true;
                            }
                        })
                        ->required(),
                    Forms\Components\FileUpload::make('dokumen_nonaktif')
                        ->label('Dokumen Non Aktif')
                        ->acceptedFileTypes(['application/pdf'])
                        ->visible(function($get){
                            if($get('status1')==1){
                                return false;
                            }else{
                                return true;
                            }
                        })
                        ->required(),
                    Forms\Components\Select::make('ket_nonaktif')
                        ->label('Keterangan Non Aktif')
                        ->options([
                            'Menjadi Struktural (Bukan Fungsional)' => 'Menjadi Struktural (Bukan Fungsional)',
                            'Mengundurkan Diri' => 'Mengundurkan Diri',
                            'Pensiun' => 'Pensiun',
                            'Meninggal Dunia' => 'Meninggal Dunia',
                            'Mutasi' => 'Mutasi',
                            'Cuti' => 'Cuti'
                            ])
                        ->visible(function($get){
                            if($get('status1')==1){
                                return false;
                            }else{
                                return true;
                            }
                        })
                        ->required(),
                ])
                ->action(function (array $data, $record): void {
                    $ada = User::where('nomor',$record->nomor)->count();
                    if($ada>0){
                        $ada = 1;
                    }else{
                        $ada = 0;
                    }
                    if(isset($data['tanggal_nonaktif']) and isset($data['dokumen_nonaktif']) and isset($data['ket_nonaktif'])){
                        $record->where('id',$record->id)->update([
                        'status_aktif' => 0,
                        'status' => $ada,
                        'tanggal_nonaktif' => $data['tanggal_nonaktif'],
                        'dokumen_nonaktif' => $data['dokumen_nonaktif'],
                        'ket_nonaktif' => $data['ket_nonaktif']
                        ]);
                        User::where('nomor',$record->nomor)->update([
                        'aktif' => 0,
                        'tanggal_nonaktif' => $data['tanggal_nonaktif'],
                        'dokumen_nonaktif' => $data['dokumen_nonaktif'],
                        'ket_nonaktif' => $data['ket_nonaktif']
                        ]);
                    }else{
                         $record->where('id',$record->id)->update([
                        'status_aktif' => 1,
                         'status' => $ada,
                        'tanggal_nonaktif' => null,
                        'dokumen_nonaktif' => null,
                        'ket_nonaktif' => null
                        ]);
                        User::where('nomor',$record->nomor)->update([
                        'aktif' => 1,
                        'tanggal_nonaktif' => null,
                        'dokumen_nonaktif' => null,
                        'ket_nonaktif' => null
                        ]);
                    }
                    
                }),
            Tables\Actions\EditAction::make()->button()->visible(function($record){
                $user = auth()->user();
    if ($user->hasRole('Provinsi') or $user->hasRole('super_admin')) {
        return true;
    }else{
        if($record->status==true){
                    return false;
                }else{
                    return true;
                }
    }
                
            }),
        ], position: ActionsPosition::BeforeColumns)
        ->bulkActions([
            // Tables\Actions\BulkActionGroup::make([
            //     Tables\Actions\DeleteBulkAction::make(),
            // ]),
        ]);
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDaftarPenyuluhs::route('/'),
            'create' => Pages\CreateDaftarPenyuluh::route('/create'),
            'edit' => Pages\EditDaftarPenyuluh::route('/{record}/edit'),
        ];
    }
}
