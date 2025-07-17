<?php

namespace App\Filament\Resources\NewsUpdateResource\Pages;

use App\Filament\Resources\NewsUpdateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListNewsUpdates extends ListRecords
{
    protected static string $resource = NewsUpdateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
