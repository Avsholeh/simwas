<?php

namespace App\Filament\Resources\LhaResource\Pages;

use App\Filament\Resources\LhaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLhas extends ListRecords
{
    protected static string $resource = LhaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
