<?php

namespace App\Filament\Resources\ComplaintRegisterResource\Pages;

use App\Filament\Resources\ComplaintRegisterResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComplaintRegister extends CreateRecord
{
    protected static string $resource = ComplaintRegisterResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
