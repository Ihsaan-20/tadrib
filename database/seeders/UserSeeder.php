<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * 
     * 
     * 
     
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'email' => 'admin@gmail.com',
                'name' => 'admin',
                'role' => '1',
                'password' => Hash::make('12345')
            ],

            [
                'email' => 'coach@gmail.com',
                'name' => 'coach',
                'role' => '2',
                'password' => Hash::make('12345')
            ],

            [
                'email' => 'user@gmail.com',
                'name' => 'user',
                'role' => '3',
                'password' => Hash::make('12345')
            ],

        ]);


       
    }
}
