<?php

namespace App\Filament\Resources\OrderCircularResource\Pages;

use App\Filament\Resources\OrderCircularResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOrderCircular extends EditRecord
{
    protected static string $resource = OrderCircularResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
