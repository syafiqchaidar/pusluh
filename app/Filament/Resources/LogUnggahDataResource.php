<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LogUnggahDataResource\Pages;
use App\Filament\Resources\LogUnggahDataResource\RelationManagers;
use App\Models\EImport;
use App\Models\LogUnggahData;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LogUnggahDataResource extends Resource
{
    protected static ?string $model = EImport::class;

    protected static ?string $navigationGroup = 'Pengaturan';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Log Unggah Data';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListLogUnggahData::route('/'),
            'create' => Pages\CreateLogUnggahData::route('/create'),
            'edit' => Pages\EditLogUnggahData::route('/{record}/edit'),
        ];
    }
}
