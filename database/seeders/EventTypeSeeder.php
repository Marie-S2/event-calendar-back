<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EventType;

class EventTypeSeeder extends Seeder
{
    public function run():void
    {
        $types = [
            ['name' => 'Mariage',      'color' => '#EC4899'],
            ['name' => 'Gala',         'color' => '#8B5CF6'],
            ['name' => 'Anniversaire', 'color' => '#F59E0B'],
            ['name' => 'Conférence',   'color' => '#3B82F6'],
            ['name' => 'Concert',      'color' => '#10B981'],
            ['name' => 'Autre',        'color' => '#6B7280'],
        ];
        foreach ($types as $type) {
            EventType::create($type);
        }
    }
}

