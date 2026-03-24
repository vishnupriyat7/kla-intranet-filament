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
            'employee_id' => 'required',
            'section' => 'required',
            'office_location_id' => 'required',
            'floor' => 'required',
            'room_id' => 'required',
            'complaint_type' => 'required',
            'description' => 'required',
        ]);

        HelpdeskTicket::create([
            'employee_id' => $request->employee_id,
            'section' => $request->section,
            'office_location_id' => $request->office_location_id,
            'floor' => $request->floor,
            'room_id' => $request->room_id,
            'complaint_type' => $request->complaint_type,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Ticket submitted successfully!');
    }
}