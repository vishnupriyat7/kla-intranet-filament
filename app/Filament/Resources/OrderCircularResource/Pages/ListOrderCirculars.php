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
            Actions\CreateAction::make()
            ->label( 'Add New Order/Circular'),

            Actions\Action::make('issue_register')
                ->label('Issue Register')
                ->url('https://docs.google.com/spreadsheets/d/1a1Ti4HK_b7zdo9z4tdJHEE-_wH18awS8AHKt_R2QnD0/edit?usp=sharing')
                ->color('warning') // Optional: Sets the button color
                ->openUrlInNewTab() // Optional: Opens the URL in a new tab
                ->icon('heroicon-o-document-text') // Optional: Adds an icon to the button
                ->button(),
        ];
    }
    //  protected function getHeaderWidgets(): array
    //    {
    //        return [
    //            OrderCircularResource\Widgets\OrderStats::class,
    //        ];
    //    }
}
