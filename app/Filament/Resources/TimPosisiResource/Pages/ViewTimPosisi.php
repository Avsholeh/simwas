<?php

namespace App\Filament\Resources\TimPosisiResource\Pages;

use App\Filament\Resources\TimPosisiResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTimPosisi extends ViewRecord
{
    protected static string $resource = TimPosisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
