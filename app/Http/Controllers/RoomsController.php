<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room; // Assuming Room model is in this namespace

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        // Fetch all rooms from the database
        $rooms = Room::latest()->get();
        dd($rooms);
        
        // Pass the rooms data to the view for rendering
        return view('rooms.index', compact('rooms'));
    }
}
