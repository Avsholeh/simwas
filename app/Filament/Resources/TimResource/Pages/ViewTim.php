<?php

namespace App\Filament\Resources\TimResource\Pages;

use App\Filament\Resources\TimResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTim extends ViewRecord
{
    protected static string $resource = TimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
