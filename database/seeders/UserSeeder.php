<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Jean Robles',
            'email' => 'jean.robles@example.com',
            'password' => bcrypt('abcd1234'),
        ]);
    
        $userRole = Role::where('name', 'user')->first();
    
        $user->roles()->sync($userRole);

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin'),
        ]);
    
        $adminRole = Role::where('name', 'admin')->first();
    
        $user->roles()->sync($adminRole);
        
    }
}
