<?php

namespace App\Filament\Resources\PeriodicalMasterResource\Pages;

use App\Filament\Resources\PeriodicalMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPeriodicalMaster extends EditRecord
{
    protected static string $resource = PeriodicalMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
