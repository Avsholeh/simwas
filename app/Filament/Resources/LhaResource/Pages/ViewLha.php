<?php

namespace App\Filament\Resources\LhaResource\Pages;

use App\Filament\Resources\LhaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewLha extends ViewRecord
{
    protected static string $resource = LhaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
