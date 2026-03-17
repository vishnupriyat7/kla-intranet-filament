<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;


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
}
