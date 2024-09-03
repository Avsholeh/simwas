<?php

namespace App\Filament\Resources\SptResource\Pages;

use App\Filament\Resources\SptResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSpt extends CreateRecord
{
    protected static string $resource = SptResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
