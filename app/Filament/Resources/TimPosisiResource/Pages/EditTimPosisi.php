<?php

namespace App\Filament\Resources\TimPosisiResource\Pages;

use App\Filament\Resources\TimPosisiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTimPosisi extends EditRecord
{
    protected static string $resource = TimPosisiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): ?string
    {
        return $this->getResource()::getUrl('index');
    }
}
