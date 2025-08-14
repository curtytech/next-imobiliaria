<?php

namespace App\Filament\Resources\ImovelResource\Pages;

use App\Filament\Resources\ImovelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditImovel extends EditRecord
{
    protected static string $resource = ImovelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Converter videos de array simples para formato do Repeater
        if (isset($data['videos']) && is_array($data['videos'])) {
            $data['videos'] = collect($data['videos'])->map(function ($video) {
                // Se já é um array com 'url', manter como está
                if (is_array($video) && isset($video['url'])) {
                    return $video;
                }

                // Se é uma string, converter para formato do Repeater
                return ['url' => $video];
            })->toArray();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Converter videos do formato Repeater para array simples
        if (isset($data['videos']) && is_array($data['videos'])) {
            $data['videos'] = collect($data['videos'])->map(function ($video) {
                // Extrair apenas a URL se for um array
                if (is_array($video) && isset($video['url'])) {
                    return $video['url'];
                }

                // Se já é uma string, manter como está
                return $video;
            })->filter()->toArray();
        }

        return $data;
    }
}
