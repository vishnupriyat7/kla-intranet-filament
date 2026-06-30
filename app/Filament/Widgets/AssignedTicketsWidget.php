<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\ComplaintRegister;
use Illuminate\Support\HtmlString;

class AssignedTicketsWidget extends BaseWidget
{
    public static function canView(): bool
    {
        $role = strtolower(auth()->user()->role ?? '');
        return auth()->check() && in_array($role, ['chm', 'programmer', 'admin', 'superadmin', 'hardwareadmin']);
    }

    protected function getStats(): array
    {
        $userId = auth()->id();
        
        $myTickets = ComplaintRegister::where('technician_id', $userId)
            ->where('status', 'Assigned')
            ->count();
            
        $openTickets = ComplaintRegister::where('status', 'Open')->count();
        
        $doneTickets = ComplaintRegister::where('status', 'Resolved')
            ->where('technician_id', $userId)
            ->count();

        return [
            Stat::make('My Assigned Tickets', $myTickets)
                ->description(new HtmlString('<a href="' . url('/admin/complaint-live-screen') . '" style="color: blue; text-decoration: underline;">Click here to process tickets</a>'))
                ->color('success'),
                
            Stat::make('Total Open Tickets', $openTickets) // New tickets that need taking
                ->description(new HtmlString('<a href="' . url('/admin/complaint-live-screen') . '" style="color: blue; text-decoration: underline;">Go to Live Board</a>'))
                ->color('warning'),
                
            Stat::make('My Done Tickets', $doneTickets) 
                ->description(new HtmlString('<a href="' . url('/admin/complaint-live-screen') . '" style="color: blue; text-decoration: underline;">View Done Tickets</a>'))
                ->color('gray'),
        ];
    }
}
