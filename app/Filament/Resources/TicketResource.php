<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->autofocus()
                    ->required()
                    ->maxLength(255)
                    ->placeholder('Title'),
                Forms\Components\Textarea::make('description')->rows(4)->nullable(),

                Forms\Components\Select::make('assigned_to')->relationship('assignedTo', 'name')->required(),
                Forms\Components\Select::make('status')->options(Ticket::STATUS)->required()->in(Ticket::STATUS),
                Forms\Components\Select::make('priority')->options(Ticket::PRIORITY)->required()->in(Ticket::PRIORITY),
                Forms\Components\Textarea::make('comment')->rows(4)->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->description(fn(Ticket $record)=>\Livewire\str()->limit($record->description,50))->sortable()->searchable(),
                Tables\Columns\TextColumn::make('assignedBy.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('assignedTo.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('priority')->badge()->searchable()->sortable(),
                Tables\Columns\TextInputColumn::make('comment')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\CategoriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
