<?php

namespace App\Filament\Resources\PkptResource\Pages;

use App\Filament\Resources\PkptResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPkpt extends ViewRecord
{
    protected static string $resource = PkptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
