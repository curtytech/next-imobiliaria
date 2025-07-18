<?php

namespace App\Filament\Resources\StatusImovelResource\Pages;

use App\Filament\Resources\StatusImovelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStatusImovels extends ListRecords
{
    protected static string $resource = StatusImovelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
