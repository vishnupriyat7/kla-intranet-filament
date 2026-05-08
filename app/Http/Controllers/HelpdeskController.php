<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\HelpdeskTicket;


class HelpdeskController extends Controller
{


    // ✅ Get Floors based on Building
    public function getFloors($locationId)
    {
        $floors = Room::where('office_location_id', $locationId)
            ->whereNotNull('floor')
            ->distinct()
            ->pluck('floor');

        return response()->json($floors);
    }

    // ✅ Get Rooms based on Building + Floor
    public function getRooms($locationId, $floor)
    {
        $rooms = Room::where('office_location_id', $locationId)
            ->where('floor', $floor)
            ->pluck('name', 'id'); // id => name

        return response()->json($rooms);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'nullable',
            'section' => 'required',
            'office_location_id' => 'required',
            'floor' => 'required',
            'room_id' => 'required',
            'complaint_type' => 'required',
            'description' => 'required',
        ]);

        $ticket = HelpdeskTicket::create([
            'employee_id' => $request->employee_id,
            'section' => $request->section,
            'office_location_id' => $request->office_location_id,
            'floor' => $request->floor,
            'room_id' => $request->room_id,
            'complaint_type' => $request->complaint_type,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Ticket submitted successfully! Your Ticket ID is: ' . $ticket->ticket_no);
    }
    public function liveScreen()
    {
        return view('helpdesk.live');
    }
    public function liveData()
    {
        $tickets = HelpdeskTicket::with(['technician', 'location', 'room', 'statusHistories.technician'])->latest()->get();

        return response()->json($tickets);
    }

    public function takeTicket(Request $request, HelpdeskTicket $ticket)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if (strtolower(auth()->user()->role ?? '') !== 'chm') {
            return response()->json(['success' => false, 'message' => 'Unauthorized. Only CHM technicians can process tickets.']);
        }

        $ticket->update([
            'technician_id' => auth()->id(),
            'status' => 'Assigned',
        ]);

        return response()->json(['success' => true, 'message' => 'Ticket Assigned to ' . auth()->user()->name]);
    }

    public function resolveTicket(Request $request, HelpdeskTicket $ticket)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated.'], 401);
        }

        if (strtolower(auth()->user()->role ?? '') !== 'chm') {
            return response()->json(['success' => false, 'message' => 'Unauthorized. Only CHM technicians can process tickets.']);
        }

        if ($ticket->technician_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'You are not assigned to this ticket.']);
        }

        $ticket->update([
            'status' => $request->input('status', 'Resolved'),
            'remarks' => $request->input('remarks'),
        ]);

        return response()->json(['success' => true, 'message' => 'Ticket Status Updated successfully']);
    }
}