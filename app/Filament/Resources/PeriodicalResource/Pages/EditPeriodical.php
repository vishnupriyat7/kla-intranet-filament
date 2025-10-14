<?php

namespace App\Filament\Resources\PeriodicalResource\Pages;

use App\Filament\Resources\PeriodicalResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriodical extends EditRecord
{
    protected static string $resource = PeriodicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
