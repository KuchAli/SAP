<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@perpustakaan.com',
            ],
            [
                'name'     => 'Administrator',
                'email' => 'admin@perpustakaan.com',
                'password' => Hash::make('admin321'),
                'role'=> 'admin'   
                
            ]
        );
    }
}
