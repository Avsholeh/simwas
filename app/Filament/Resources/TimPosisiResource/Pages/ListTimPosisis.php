<?php

namespace App\Filament\Resources\TimPosisiResource\Pages;

use App\Filament\Resources\TimPosisiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTimPosisis extends ListRecords
{
    protected static string $resource = TimPosisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
