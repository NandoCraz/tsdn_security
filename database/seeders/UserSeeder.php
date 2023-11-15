<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Dr. Hargo Wihardjo",
            'email' => "dokterharjo@gmail.com",
            'no_hp' => "081234567890",
            'password' => bcrypt('dokterharjo'),
            'foto' => "fotoProfile/user_pic.png",
            'is_active' => false,
            'role' => 'dokter',
            'face_id' => 'fotoProfile/harjo.jpeg'
        ]);

        User::create([
            'name' => "Dr. Santi Astutik",
            'email' => "doktersanti@gmail.com",
            'no_hp' => "081298765432",
            'password' => bcrypt('doktersanti'),
            'foto' => "fotoProfile/user_pic.png",
            'is_active' => false,
            'role' => 'dokter',
            // 'face_id' => 'fotoProfile/harjo.jpeg'
        ]);
    }
}
