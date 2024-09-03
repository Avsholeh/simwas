<?php

namespace App\Filament\Resources\KkaResource\Pages;

use App\Filament\Resources\KkaResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKka extends CreateRecord
{
    protected static string $resource = KkaResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
