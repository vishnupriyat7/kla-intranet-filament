<?php

namespace App\Filament\Resources\RetiredStaffResource\Pages;

use App\Filament\Resources\RetiredStaffResource;
use App\Imports\RetiredStaffImport;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class ListRetiredStaff extends ListRecords
{
    protected static string $resource = RetiredStaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add New')
                ->icon('heroicon-o-plus'),
            Actions\Action::make('import')
                ->label('Import Retired Staff')
                ->button()
                ->color('primary')
                ->icon('heroicon-o-arrow-up-tray')
                ->visible(fn() => Auth::user()?->role === 'superadmin')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('file')
                        ->label('Spreadsheet File (.xls / .xlsx / .ods)')
                        ->disk('local') // ✅ use local (already points to storage/app/private)
                        ->directory('imports')
                        ->required()
                        ->acceptedFileTypes([
                            'application/vnd.ms-excel',
                            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                            'application/vnd.oasis.opendocument.spreadsheet',
                        ]),
                ])
                ->action(function (array $data): void {
                    // ✅ Use same disk to get the full system path
                    $filePath = Storage::disk('local')->path($data['file']);

                    Excel::import(new RetiredStaffImport, $filePath);

                    // optional: clean up after import
                    Storage::disk('local')->delete($data['file']);

                    Notification::make()
                        ->title('Retired staff imported successfully!')
                        ->success()
                        ->send();
                }),
        ];
    }
}
