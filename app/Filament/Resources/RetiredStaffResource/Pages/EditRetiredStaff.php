<?php

namespace App\Filament\Resources\RetiredStaffResource\Pages;

use App\Filament\Resources\RetiredStaffResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRetiredStaff extends EditRecord
{
    protected static string $resource = RetiredStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
