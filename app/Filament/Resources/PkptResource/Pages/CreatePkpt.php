<?php

namespace App\Filament\Resources\PkptResource\Pages;

use App\Filament\Resources\PkptResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePkpt extends CreateRecord
{
    protected static string $resource = PkptResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
