<?php

namespace App\Observers;

use App\Models\Ticket;
use Filament\Notifications\DatabaseNotification;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;

class TicketObserver
{
    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        $agent = $ticket->assignedTo;
        Notification::make()
            ->title('Ticket Created and assigned to you')
            ->success()
            ->sendToDatabase($agent);
        event(new DatabaseNotificationsSent($agent));
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {

    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}
