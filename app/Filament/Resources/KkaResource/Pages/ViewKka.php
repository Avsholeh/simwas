<?php

namespace App\Filament\Resources\KkaResource\Pages;

use App\Filament\Resources\KkaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewKka extends ViewRecord
{
    protected static string $resource = KkaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
