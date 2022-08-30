<?php

namespace App\Policies;

use App\Models\Status;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function updateDueDate(User $user, Ticket $ticket)
    {
        return $user->isAdmin();
    }

    public function updateStatus(User $user, Ticket $ticket, Status $newStatus)
    {
        return $user->isAdmin() || $ticket->canTransition($newStatus);
    }

}
