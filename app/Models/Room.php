<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'floor_id',
        'name',
    ];

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function devices()
    {
        return $this->hasMany(Devices::class);
    }

    public function totalEnergy()
    {
        // Initialize total energy consumption
        $totalEnergy = 0;
    
        // Loop through each device in the room and calculate energy consumption
        foreach ($this->devices as $device) {
            // Calculate energy consumption for each device
            $deviceEnergy = $device->active_quantity * $device->power * $device->hours_used / 1000; // in kWh
    
            // Add device energy consumption to the total
            $totalEnergy += $deviceEnergy;
        }
    
        return $totalEnergy;
    }
    
}

