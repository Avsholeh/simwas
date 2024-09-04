<?php

namespace App\Filament\Resources\TemuanResource\Pages;

use App\Filament\Resources\TemuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTemuans extends ListRecords
{
    protected static string $resource = TemuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
