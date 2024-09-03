<?php

namespace App\Filament\Resources\LhaResource\Pages;

use App\Filament\Resources\LhaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLha extends EditRecord
{
    protected static string $resource = LhaResource::class;

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
