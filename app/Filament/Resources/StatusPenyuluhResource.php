<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusPenyuluhResource\Pages;
use App\Filament\Resources\StatusPenyuluhResource\RelationManagers;
use App\Models\StatusPenyuluh;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusPenyuluhResource extends Resource
{
    protected static ?string $model = StatusPenyuluh::class;

    protected static ?string $navigationGroup = 'Master Data';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'Status Penyuluh';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('nama')
                    ->required()
                    ->columnSpanFull(),
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
            'index' => Pages\ListStatusPenyuluhs::route('/'),
            'create' => Pages\CreateStatusPenyuluh::route('/create'),
            'edit' => Pages\EditStatusPenyuluh::route('/{record}/edit'),
        ];
    }
}
