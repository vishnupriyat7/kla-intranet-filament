<?php

namespace App\Filament\Widgets;

use App\Models\HelpdeskTicket;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class HelpdeskStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Open Tickets', HelpdeskTicket::where('status', 'Open')->count())
                ->description('Tickets awaiting assignment')
                ->descriptionIcon('heroicon-m-ticket')
                ->color('danger'),
            Stat::make('Tickets In Progress', HelpdeskTicket::whereIn('status', ['Assigned', 'InProgress'])->count())
                ->description('Tickets currently being worked on')
                ->descriptionIcon('heroicon-m-arrow-path')
                ->color('warning'),
            Stat::make('Resolved Today', HelpdeskTicket::where('status', 'Resolved')->whereDate('updated_at', today())->count())
                ->description('Tickets resolved in the last 24 hours')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),
        ];
    }
}
