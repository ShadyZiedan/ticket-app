<?php

namespace App\Http\Controllers\Api;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Status;
use App\Models\Ticket;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return TicketResource::collection(Ticket::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {
        $ticket = Ticket::create([
            'name' => $request->name,
            'due_date' => $request->due_date,
            'author_user_id' => $request->user()->id,
            'performer_user_id' => $request->performer_user_id,
            'status_id' => $request->status_id ?? StatusEnum::OPEN
        ]);
        return new TicketResource($ticket);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $ticket->name = $request->name;

        if ($ticket->due_date !== $request->due_date
            && $request->user()->cannot('update-due-date', $ticket)){
            abort(403, "You can't change due date of this ticket.");
        } else {
            $ticket->due_date = $request->due_date;
        }

        $newStatus = Status::find($request->status_id);
        if (!$ticket->status->is($newStatus)
            && $request->user()->cannot('update-status', [$ticket, $newStatus])) {
            abort(403, "Wrong ticket status");
        } else {
            $ticket->status_id = $request->status_id;
        }

        $ticket->performer_user_id = $request->performer_user_id;


        $ticket->saveOrFail();

        return new TicketResource($ticket->refresh());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
    }
}
