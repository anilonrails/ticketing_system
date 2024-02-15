<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Builder;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Tickets', Ticket::count()),
            Stat::make('Total Categories', Ticket::count()),
            Stat::make('Total Users', Ticket::count()),
            Stat::make('Agent Users', User::whereHas('roles', fn(Builder $query)=>$query->where('name','Agent'))->count())
        ];
    }
}
