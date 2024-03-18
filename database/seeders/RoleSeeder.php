<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create([
            'name' => 'Administratorius',
            'id' => Role::ADMIN_ID
        ]);

        Role::create([
            'name' => 'Vadybininkas',
            'id' => Role::MANAGER_ID
        ]);

        Role::create([
            'name' => 'Gyventojas',
            'id' => Role::DEFAULT_ID
        ]);
    }
}
