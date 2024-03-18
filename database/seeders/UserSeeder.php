<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'login' => 'admin',
            'password' => 'admin',
            'role_id' => Role::ADMIN_ID,
            'name' => 'Leodangas',
            'last_name' => 'Griciūnas',
            'phone' => '+37060432902'
        ]);

        User::create([
            'login' => 'vadybininkas',
            'password' => 'vadybininkas',
            'role_id' => Role::MANAGER_ID,
            'name' => 'Vadybininkas',
            'last_name' => 'Jonas',
            'phone' => '+37060432901'
        ]);

        User::create([
            'login' => 'gyventojas',
            'password' => 'gyventojas',
            'role_id' => Role::DEFAULT_ID,
            'name' => 'Gyventojas',
            'last_name' => 'Jonas',
            'phone' => '+37060432901'
        ]);
    }
}
