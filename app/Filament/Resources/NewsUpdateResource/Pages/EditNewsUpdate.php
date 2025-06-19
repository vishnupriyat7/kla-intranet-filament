<?php

namespace App\Filament\Resources\NewsUpdateResource\Pages;

use App\Filament\Resources\NewsUpdateResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditNewsUpdate extends EditRecord
{
    protected static string $resource = NewsUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
