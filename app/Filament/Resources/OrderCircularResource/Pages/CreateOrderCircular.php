<?php

namespace App\Filament\Resources\OrderCircularResource\Pages;

use App\Filament\Resources\OrderCircularResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrderCircular extends CreateRecord
{
    protected static string $resource = OrderCircularResource::class;

    protected function afterSave(): void
    {
        $this->record->title_length = mb_strlen($this->form->getState()['title'], 'UTF-8');
        $this->record->save();
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
