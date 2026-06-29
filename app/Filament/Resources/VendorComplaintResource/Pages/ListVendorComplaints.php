<?php

namespace App\Filament\Resources\VendorComplaintResource\Pages;

use App\Filament\Resources\VendorComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVendorComplaints extends ListRecords
{
    protected static string $resource = VendorComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
