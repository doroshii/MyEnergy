<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Devices;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)     
    {
        $floorId = $request->query('floor_id');
        $floor = Floor::where('id', $floorId)->get();
        $rooms = Room::where('floor_id', $floorId)->get();

        $buildingId = Floor::where('id', $floorId)->pluck('building_id')->first();
        $building = Building::where('id', $buildingId)->get();


        return view('rooms.index', ['floorId' => $floorId, 'rooms' => $rooms, 'floor' => $floor, 'building' => $building]);
    }


    public function create()
    {
        return view('rooms.create');
    }

    public function store(Request $request)
    {
        $room = new Room();
        
        $room->name = $request->input('room_name');
        $room->floor_id = $request->input('floor_id'); 
        $room->save();

        return redirect()->back();
    }

    public function show($id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $rooms)
    {
        return view('rooms.edit', compact('rooms'));
    }

    public function update(Request $request, Room $rooms)
    {
        $building->update($request->all());
        return redirect()->route('rooms.index')->with('success','Room updated successfully');
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return redirect()->back();
    }
}
