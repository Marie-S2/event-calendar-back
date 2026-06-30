<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Material;

class MaterialSeeder extends Seeder
{
    public function run():void
    {
        $materials = [
           ['name' => 'Laser',                'description' => 'Laser événementiel',          'quantity' => 1,  'unit' => 'unité', 'is_divisible' => false],
            ['name' => 'Machine à fumée',      'description' => 'Machine à fumée scénique',    'quantity' => 1,  'unit' => 'unité', 'is_divisible' => false],
            ['name' => 'Machine à bulles',     'description' => 'Machine à bulles',            'quantity' => 1,  'unit' => 'unité', 'is_divisible' => false],
            ['name' => 'Machine à étincelles', 'description' => 'Machine à étincelles froide', 'quantity' => 4,  'unit' => 'unité', 'is_divisible' => false],
            ['name' => 'Sonorisation',         'description' => 'Système audio complet',       'quantity' => 4,  'unit' => 'unité', 'is_divisible' => false],
            ['name' => 'Piste de danse',       'description' => 'Piste de danse modulable',    'quantity' => 49, 'unit' => 'm²',    'is_divisible' => true],
        ];
        foreach ($materials as $m) {
            Material::create($m);
        }
    }
}




