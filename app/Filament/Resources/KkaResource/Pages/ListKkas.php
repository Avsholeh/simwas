<?php

namespace App\Filament\Resources\KkaResource\Pages;

use App\Filament\Resources\KkaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKkas extends ListRecords
{
    protected static string $resource = KkaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
