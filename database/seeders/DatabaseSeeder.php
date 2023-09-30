<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RoleSeeder::class]);
        User::create([
            'name'=>"CLEB",
            'email'=>"admin@cleb.me",
            'phone_number'=>"68 18 40 40",
            'password'=>Hash::make('12345678'),
            'role_id'=>1
         ]);
    }
}
