<?php

namespace App\Filament\Resources\OrderCircularResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\OrderCircular;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

class OrderStats extends BaseWidget
{
    public static function canView(): bool
    {
        $role = strtolower(auth()->user()->role ?? '');
        return auth()->check() && !in_array($role, ['chm', 'hardwareadmin']);
    }
    protected function getStats(): array
    {
        $currentYear = now()->year;
        $user = Auth::user();
        $userId = Auth::id();
        $isSuperAdmin = $user && $user->isSuperAdmin();

        // Initialize stats array
        $stats = [];

        // User-specific stats
        if ($isSuperAdmin) {
            // Fetch all users and their stats in one query
            $userCounts = Cache::remember('all_user_order_stats', 60, function () {
                return OrderCircular::selectRaw('
                        updated_by,
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
                    ->whereNotNull('updated_by')
                    ->groupBy('updated_by')
                    ->get()
                    ->keyBy('updated_by');
            });

            // Fetch all users
            $users = User::all()->keyBy('id');

            // Create a card for each user
            foreach ($users as $u) {
                $userStats = isset($userCounts[$u->id]) ? [
                    'total' => $userCounts[$u->id]->total ?? 0,
                    'government_order' => $userCounts[$u->id]->government_order ?? 0,
                    'office_order' => $userCounts[$u->id]->office_order ?? 0,
                    'circular' => $userCounts[$u->id]->circular ?? 0,
                    'published' => $userCounts[$u->id]->published ?? 0,
                    'unpublished' => $userCounts[$u->id]->unpublished ?? 0,
                    'go_manuscript' => $userCounts[$u->id]->go_manuscript ?? 0,
                    'go_routine' => $userCounts[$u->id]->go_routine ?? 0,
                    'go_print' => $userCounts[$u->id]->go_print ?? 0,
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

                $stats[] = Stat::make('Edited by ' . ($u->name ?? 'N/A'), new HtmlString('<span style="color: #010308ff;">' . $userStats['total'] . '</span>'))
                    ->description(new HtmlString(
                        '<span style="color: #2d20e7ff; font-weight: normal;">GO: ' . $userStats['government_order'] . '</span> | ' .
                            '<span style="color: #ca24afff; font-weight: normal;">OO: ' . $userStats['office_order'] . '</span> | ' .
                            '<span style="color: #119627ff; font-weight: normal;">Cir: ' . $userStats['circular'] . '</span><br><br>' .
                            'GO Type: ' .
                            '<span style="color: #2d20e7ff; font-weight: normal;">Go.M: ' . $userStats['go_manuscript'] . '</span> | ' .
                            '<span style="color: #2d20e7ff; font-weight: normal;">Go.R: ' . $userStats['go_routine'] . '</span> | ' .
                            '<span style="color: #2d20e7ff; font-weight: normal;">Go.P: ' . $userStats['go_print'] . '</span>'
                    ))
                    ->color('gray');
            }
        } else {
            // Non-SuperAdmin: Show only logged-in user's stats
            $userCounts = $userId ? Cache::remember("user_order_stats_{$userId}", 60, function () use ($userId) {
                return OrderCircular::where('updated_by', $userId)
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
                    ->first();
            }) : null;

            $userStats = $userCounts ? [
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

            $stats[] = Stat::make('Edited by ' . ($user ? $user->name : 'N/A'), new HtmlString('<span style="color: #010308ff;">' . $userStats['total'] . '</span>'))
                ->description(new HtmlString(
                    '<span style="color: #2d20e7ff; font-weight: normal;">GO: ' . $userStats['government_order'] . '</span> | ' .
                        '<span style="color: #ca24afff; font-weight: normal;">OO: ' . $userStats['office_order'] . '</span> | ' .
                        '<span style="color: #119627ff; font-weight: normal;">Cir: ' . $userStats['circular'] . '</span><br><br>' .

                        '<span style="color: #2d20e7ff; font-weight: normal;">Go.M: ' . $userStats['go_manuscript'] . '</span> | ' .
                        '<span style="color: #2d20e7ff; font-weight: normal;">Go.R: ' . $userStats['go_routine'] . '</span> | ' .
                        '<span style="color: #2d20e7ff; font-weight: normal;">Go.P: ' . $userStats['go_print'] . '</span>'
                ))
                ->color('gray');
        }

        // Add overall stats for all users
        $stats = array_merge($stats, [
            // Govt. Orders Card
            Stat::make('Govt. Orders', OrderCircular::where('type', 'G')->count())
                ->description(new HtmlString(
                    '<span style="color: #16a34a;">Published: ' . OrderCircular::where('type', 'G')->where('status', '1')->count() . '</span>' .
                        ' | <span style="color: #dc2626;">Unpublished: ' . OrderCircular::where('type', 'G')->where('status', '0')->count() . '</span><br><br>' .
                        'Go.M: ' . OrderCircular::where('type', 'G')->where('go_type', 'M')->count() .
                        ' | Go.R: ' . OrderCircular::where('type', 'G')->where('go_type', 'R')->count() .
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
        ]);

        return $stats;
    }
}
