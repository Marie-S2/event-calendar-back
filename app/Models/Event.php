<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name', 'date', 'time', 'location',
        'client', 'phone', 'city',
        'event_type_id', 'user_id', 'status', 'notes'
    ];

    protected $casts = ['date' => 'date'];

    public function eventType() {
        return $this->belongsTo(EventType::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function materials() {
        return $this->belongsToMany(Material::class, 'event_material')
                    ->withPivot('quantity');
    }
}


