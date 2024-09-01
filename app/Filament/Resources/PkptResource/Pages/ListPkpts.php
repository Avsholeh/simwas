<?php

namespace App\Filament\Resources\PkptResource\Pages;

use App\Filament\Resources\PkptResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPkpts extends ListRecords
{
    protected static string $resource = PkptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
