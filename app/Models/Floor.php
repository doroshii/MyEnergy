<?php

namespace App\Models; 

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{
    protected $fillable = [
        'building_id',
        'name'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class);
    }

    public function rooms()     
    {
        return $this->hasMany(Room::class);
    }

    public function totalEnergy()
    {
        $totalEnergy = 0;

        foreach ($this->rooms as $room) {
            $totalEnergy += $room->totalEnergy();
        }

        return $totalEnergy;
    }
}
