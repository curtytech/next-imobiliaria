<?php

namespace App\Filament\Resources\ImovelResource\Pages;

use App\Filament\Resources\ImovelResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListImovels extends ListRecords
{
    protected static string $resource = ImovelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
