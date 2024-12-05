<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PangkatGolonganResource\Pages;
use App\Filament\Resources\PangkatGolonganResource\RelationManagers;
use App\Models\PangkatGolongan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PangkatGolonganResource extends Resource
{
    protected static ?string $model = PangkatGolongan::class;

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Golongan PNS';
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
            'index' => Pages\ListPangkatGolongans::route('/'),
            'create' => Pages\CreatePangkatGolongan::route('/create'),
            'edit' => Pages\EditPangkatGolongan::route('/{record}/edit'),
        ];
    }
}
