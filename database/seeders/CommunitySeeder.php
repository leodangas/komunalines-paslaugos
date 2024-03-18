<?php

namespace Database\Seeders;

use App\Models\Community;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommunitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Community::create([
            'name' => 'Luokės bendrija'
        ]);

        Community::create([
            'name' => 'Vilniaus g. bendrija'
        ]);
    }
}
