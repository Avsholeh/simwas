<?php

namespace App\Filament\Resources\TemuanResource\Pages;

use App\Filament\Resources\TemuanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTemuan extends EditRecord
{
    protected static string $resource = TemuanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
