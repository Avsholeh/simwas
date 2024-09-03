<?php

namespace App\Filament\Resources\KkaResource\Pages;

use App\Filament\Resources\KkaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKka extends EditRecord
{
    protected static string $resource = KkaResource::class;

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
