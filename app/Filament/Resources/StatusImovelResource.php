<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StatusImovelResource\Pages;
use App\Filament\Resources\StatusImovelResource\RelationManagers;
use App\Models\StatusImovel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StatusImovelResource extends Resource
{
    protected static ?string $model = StatusImovel::class;

    protected static ?string $navigationIcon = 'heroicon-o-check-circle';
    
    protected static ?string $navigationLabel = 'Status de Imóveis';

    protected static ?string $modelLabel = 'Status de Imóvel';

    protected static ?string $pluralModelLabel = 'Status de Imóveis';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nome')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nome')->sortable()->searchable(),
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
            'index' => Pages\ListStatusImovels::route('/'),
            'create' => Pages\CreateStatusImovel::route('/create'),
            'edit' => Pages\EditStatusImovel::route('/{record}/edit'),
        ];
    }
}
