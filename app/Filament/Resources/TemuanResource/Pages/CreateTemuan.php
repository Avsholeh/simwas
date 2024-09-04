<?php

namespace App\Filament\Resources\TemuanResource\Pages;

use App\Filament\Resources\TemuanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateTemuan extends CreateRecord
{
    protected static string $resource = TemuanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
