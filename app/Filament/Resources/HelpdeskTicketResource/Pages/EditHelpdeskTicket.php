<?php

namespace App\Filament\Resources\HelpdeskTicketResource\Pages;

use App\Filament\Resources\HelpdeskTicketResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHelpdeskTicket extends EditRecord
{
    protected static string $resource = HelpdeskTicketResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
