<?php

namespace App\Filament\Resources\OrderCircularResource\Pages;

use App\Filament\Resources\OrderCircularResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListOrderCirculars extends ListRecords
{
    protected static string $resource = OrderCircularResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    //  protected function getHeaderWidgets(): array
    //    {
    //        return [
    //            OrderCircularResource\Widgets\OrderStats::class,
    //        ];
    //    }
}
