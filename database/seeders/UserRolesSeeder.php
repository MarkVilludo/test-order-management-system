<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $users = [
            ['name' => 'Admin', 'email' => 'admin@example.com', 'role' => 'admin'],
            ['name' => 'Kitchen Staff 1', 'email' => 'kitchen1@example.com', 'role' => 'kitchen_staff'],
            ['name' => 'Kitchen Staff 2', 'email' => 'kitchen2@example.com', 'role' => 'kitchen_staff'],
            ['name' => 'Delivery Person 1', 'email' => 'delivery1@example.com', 'role' => 'delivery_person'],
            ['name' => 'Delivery Person 2', 'email' => 'delivery2@example.com', 'role' => 'delivery_person'],
        ];

        foreach ($users as $user) {
            User::factory()->create([
                'name' => $user['name'],
                'email' => Str::random(2) .''.$user['email'],
                'password' => Hash::make('password'),
                'role' => $user['role'],
            ]);
        }
    }
}
