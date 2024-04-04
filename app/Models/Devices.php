<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'name',
        'type',
        'active_quantity', // Adding active_quantity to the fillable array
        'inactive_quantity', // Adding inactive_quantity to the fillable array
        'brand',
        'model',
        'installed_date',
        'life_expectancy',
        'power',
        'hours_used',
        'energy',
    ];

    protected $appends = ['energy'];

    protected $hidden = ['energy'];

    public function getEnergyAttribute()
    {
        return $this->active_quantity * $this->power * $this->hours_used / 1000;
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
