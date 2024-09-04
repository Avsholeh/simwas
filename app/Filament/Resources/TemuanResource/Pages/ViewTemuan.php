<?php

namespace App\Filament\Resources\TemuanResource\Pages;

use App\Filament\Resources\TemuanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTemuan extends ViewRecord
{
    protected static string $resource = TemuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
