<?php

namespace App\Filament\Resources\TimResource\Pages;

use App\Filament\Resources\TimResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTims extends ListRecords
{
    protected static string $resource = TimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
