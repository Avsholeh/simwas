<?php

namespace App\Filament\Resources\PkptResource\Pages;

use App\Filament\Resources\PkptResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPkpt extends EditRecord
{
    protected static string $resource = PkptResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
