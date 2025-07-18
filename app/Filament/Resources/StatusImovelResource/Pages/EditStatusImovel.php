<?php

namespace App\Filament\Resources\StatusImovelResource\Pages;

use App\Filament\Resources\StatusImovelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusImovel extends EditRecord
{
    protected static string $resource = StatusImovelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
