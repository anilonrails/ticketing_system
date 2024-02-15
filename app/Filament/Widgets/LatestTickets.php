<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestTickets extends BaseWidget
{

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {

        return $table
            ->query(
                auth()->user()->hasRole('Admin') ? Ticket::query() : Ticket::where('assigned_to',auth()->id())
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')->description(fn(Ticket $record) => \Livewire\str()->limit($record?->description ?? '', 50))->sortable()->searchable(),
                Tables\Columns\TextColumn::make('assignedBy.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('assignedTo.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->colors([
                    'success'=>'Open',
                    'danger'=>'Closed',
                    'warning'=>'Archived'
                ])->searchable()->sortable(),
                Tables\Columns\TextColumn::make('priority')->badge()->colors([
                    'danger'=>'High',
                    'warning'=>'Medium',
                    'success'=>'Low'
                ])->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->formatStateUsing(fn($state)=>$state->format("d M Y"))->sortable()
            ]);
    }
}
