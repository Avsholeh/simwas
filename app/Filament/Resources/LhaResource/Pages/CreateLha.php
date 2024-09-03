<?php

namespace App\Filament\Resources\LhaResource\Pages;

use App\Filament\Resources\LhaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateLha extends CreateRecord
{
    protected static string $resource = LhaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
