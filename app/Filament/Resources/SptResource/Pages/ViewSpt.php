<?php

namespace App\Filament\Resources\SptResource\Pages;

use App\Filament\Resources\SptResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSpt extends ViewRecord
{
    protected static string $resource = SptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
