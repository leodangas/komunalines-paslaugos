<?php

namespace Database\Seeders;

use App\Models\House;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        House::create([
            'address' => 'Luokės 75'
        ]);

        House::create([
            'address' => 'Luokės 77'
        ]);

        House::create([
            'address' => 'Luokės 76'
        ]);

        House::create([
            'address' => 'Vilniaus 2'
        ]);

        House::create([
            'address' => 'Vilniaus 3'
        ]);
    }
}
