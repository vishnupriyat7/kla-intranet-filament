<?php

namespace App\Filament\Resources\PeriodicalResource\Pages;

use App\Filament\Resources\PeriodicalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPeriodicals extends ListRecords
{
    protected static string $resource = PeriodicalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
