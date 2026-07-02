<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Support\Enums\MaxWidth;

class ComplaintLiveScreen extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    
    protected static ?string $navigationLabel = 'IT Complaint Live';
    
    protected static ?string $title = 'IT Complaint Register Live';
    
    // Sort order 1 puts it right below the Dashboard (which is typically 0 or top)
    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.pages.complaint-live-screen';

    public function getHeading(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return '';
    }

    public function getMaxContentWidth(): MaxWidth
    {
        return MaxWidth::Full;
    }
}
