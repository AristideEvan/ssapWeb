<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nom' => 'Admin',
            'prenom' => 'Admin',
            'telephone' => '0000000000',
            'identifiant' => 'admin',
            'password' => Hash::make('admin'),
            'actif' => true,
            'profil_id' => 1,
        ]);
        User::create([
            'nom' => 'User',
            'prenom' => 'User',
            'telephone' => '0000000000',
            'identifiant' => 'user',
            'password' => Hash::make('user'),
            'actif' => true,
            'profil_id' => 2,
        ]);
    }
}
