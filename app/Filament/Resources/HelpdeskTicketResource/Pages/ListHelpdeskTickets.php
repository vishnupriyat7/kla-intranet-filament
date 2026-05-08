<?php

namespace App\Filament\Resources\HelpdeskTicketResource\Pages;

use App\Filament\Resources\HelpdeskTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHelpdeskTickets extends ListRecords
{
    protected static string $resource = HelpdeskTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Widgets\HelpdeskStatsOverview::class,
        ];
    }
}
