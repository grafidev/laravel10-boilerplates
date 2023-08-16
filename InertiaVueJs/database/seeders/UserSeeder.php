<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'firstname' => 'Papa Samba',
            'lastname' => 'DIOP',
            'email' => 'superadmin@mail.com',
            'phone_number' => '+221771420315',
            'address' => 'Zac Mbao, Cité finance',
        ]);

        User::factory()->create([
            'firstname' => 'Papa Mouhamadou',
            'lastname' => 'DIOP',
            'email' => 'admin@mail.com',
            'phone_number' => '+221783894298',
            'address' => 'Zac Mbao, Cité finance',
        ]);

        User::factory()->create([
            'firstname' => 'Fatou Kine',
            'lastname' => 'DIOP',
            'email' => 'user@mail.com',
            'phone_number' => '+221778720788',
            'address' => 'Zac Mbao, Cité finance',
        ]);
    }
}
