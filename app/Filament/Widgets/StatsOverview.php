<?php

namespace App\Filament\Widgets;

use App\Models\Blog;
use App\Models\Gallery;
use App\Models\Partner;
use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Blogs Count', Blog::count())
                ->icon('heroicon-m-newspaper'),
            Stat::make('Gallery Count', Gallery::count())
                ->icon('heroicon-o-photo'),
            Stat::make('Partner Count', Partner::count())
                ->icon('heroicon-o-user-group'),
            Stat::make('Product Count', Product::count())
                ->icon('heroicon-o-shopping-bag'),
        ];
    }
}
