<?php

namespace App\Filament\Resources\PeriodicalMasterResource\Pages;

use App\Filament\Resources\PeriodicalMasterResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriodicalMasters extends ListRecords
{
    protected static string $resource = PeriodicalMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
