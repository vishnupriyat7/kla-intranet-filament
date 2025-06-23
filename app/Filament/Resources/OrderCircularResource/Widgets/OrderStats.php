<?php

namespace App\Filament\Resources\OrderCircularResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\OrderCircular;
use Illuminate\Support\HtmlString;

class OrderStats extends BaseWidget
{
    protected function getStats(): array

    {
        $currentYear = now()->year;

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
        ];
    }
}
