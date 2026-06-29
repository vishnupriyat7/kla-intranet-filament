<?php

namespace App\Filament\Resources\ComplaintRegisterResource\Pages;

use App\Filament\Resources\ComplaintRegisterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComplaintRegister extends EditRecord
{
    protected static string $resource = ComplaintRegisterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
