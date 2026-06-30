<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['name', 'description', 'quantity', 'unit', 'is_divisible'];

    protected $casts = ['is_divisible' => 'boolean'];

    public function events() {
        return $this->belongsToMany(Event::class, 'event_material')
                    ->withPivot('quantity');
    }
}
