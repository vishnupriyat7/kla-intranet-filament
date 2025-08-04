<?php

namespace App\Filament\Resources\OrderCircularResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\OrderCircular;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class OrderStats extends BaseWidget
{
    protected function getStats(): array

    {
        $currentYear = now()->year;
        $user = Auth::user();
        $userName = $user ? $user->name : 'N/A';
        $userId = Auth::id();

        // Fetch user-specific counts in a single query
        $userCounts = $userId ? OrderCircular::where('updated_by', $userId)
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN type = "G" THEN 1 ELSE 0 END) as government_order,
                SUM(CASE WHEN type = "O" THEN 1 ELSE 0 END) as office_order,
                SUM(CASE WHEN type = "C" THEN 1 ELSE 0 END) as circular,
                SUM(CASE WHEN status = "1" THEN 1 ELSE 0 END) as published,
                SUM(CASE WHEN status = "0" THEN 1 ELSE 0 END) as unpublished,
                SUM(CASE WHEN type = "G" AND go_type = "M" THEN 1 ELSE 0 END) as go_manuscript,
                SUM(CASE WHEN type = "G" AND go_type = "R" THEN 1 ELSE 0 END) as go_routine,
                SUM(CASE WHEN type = "G" AND go_type = "P" THEN 1 ELSE 0 END) as go_print
            ')
            ->first() : null;

        $userStats = $userId ? [
            'total' => $userCounts->total ?? 0,
            'government_order' => $userCounts->government_order ?? 0,
            'office_order' => $userCounts->office_order ?? 0,
            'circular' => $userCounts->circular ?? 0,
            'published' => $userCounts->published ?? 0,
            'unpublished' => $userCounts->unpublished ?? 0,
            'go_manuscript' => $userCounts->go_manuscript ?? 0,
            'go_routine' => $userCounts->go_routine ?? 0,
            'go_print' => $userCounts->go_print ?? 0,
        ] : [
            'total' => 0,
            'government_order' => 0,
            'office_order' => 0,
            'circular' => 0,
            'published' => 0,
            'unpublished' => 0,
            'go_manuscript' => 0,
            'go_routine' => 0,
            'go_print' => 0,
        ];
        return [
            // Govt. Orders Card
            Stat::make('Govt. Orders', OrderCircular::where('type', 'G')->count())
                ->description(new HtmlString(
                    ' <span style="color: #16a34a;">Published: ' . OrderCircular::where('type', 'G')->where('status', '1')->count() . '</span>' .
                        ' | <span style="color: #dc2626;">Unpublished: ' . OrderCircular::where('type', 'G')->where('status', '0')->count() . '</span>' . '<br>' . '<br>' .
                        'Go.M:  ' . OrderCircular::where('type', 'G')->where('go_type', 'M')->count() .
                        ' | Go.R:  ' . OrderCircular::where('type', 'G')->where('go_type', 'R')->count() .
                        ' | Go.P: ' . OrderCircular::where('type', 'G')->where('go_type', 'P')->count()

                ))
                ->color('info'),

            // Office Orders Card
            Stat::make('Office Orders', OrderCircular::where('type', 'O')->count())
                ->description(new HtmlString(
                    '<span style="color: #16a34a;">Published: ' . OrderCircular::where('type', 'O')->where('status', '1')->count() . '</span>' .
                        ' | <span style="color: #dc2626;">Unpublished: ' . OrderCircular::where('type', 'O')->where('status', '0')->count() . '</span>'
                ))
                ->descriptionIcon('heroicon-o-briefcase')
                ->color('warning'),

            // Circulars Card
            Stat::make('Circulars', OrderCircular::where('type', 'C')->count())
                ->description(new HtmlString(
                    '<span style="color: #16a34a;">Published: ' . OrderCircular::where('type', 'C')->where('status', '1')->count() . '</span>' .
                        ' | <span style="color: #dc2626;">Unpublished: ' . OrderCircular::where('type', 'C')->where('status', '0')->count() . '</span>'
                ))
                ->descriptionIcon('heroicon-o-newspaper')
                ->color('success'),



            // User-Specific Card
            Stat::make('Edited by ' . $userName, new HtmlString('<span style="color: #010308ff;">' . $userStats['total'] . '</span>'))
                ->description(new HtmlString(
                    '<span style="color: #2d20e7ff; font-weight: normal;">GO: ' . $userStats['government_order'] . '</span> | ' .
                        '<span style="color: #ca24afff; font-weight: normal;">OO: ' . $userStats['office_order'] . '</span> | ' .
                        '<span style="color: #119627ff; font-weight: normal;">Cir: ' . $userStats['circular'] . '</span><br><br>' .

                        '<span style="color: #2d20e7ff; font-weight: normal;">Go.M: ' . $userStats['go_manuscript'] . '</span> |' .
                        '<span style="color: #2d20e7ff; font-weight: normal;">Go.R: ' . $userStats['go_routine'] . '</span> | ' .
                        '<span style="color: #2d20e7ff; font-weight: normal;">Go.P: ' . $userStats['go_print'] . '</span>'
                ))
                ->color('gray'),

        ];
    }
}
