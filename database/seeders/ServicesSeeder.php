<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Service::create([
            'name' => 'Dujos'
        ]);

        Service::create([
            'name' => 'Karštas vanduo'
        ]);

        Service::create([
            'name' => 'Atliekų tvarkymas'
        ]);

        Service::create([
            'name' => 'Šilumos energija'
        ]);
    }
}
