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
            'name' => "Dr. Nando Septian",
            'email' => "dokternando@gmail.com",
            'no_hp' => "081234567890",
            'password' => bcrypt('dokternando'),
            'foto' => "fotoProfile/harjo.jpg",
            'is_active' => false,
            'role' => 'dokter',
            // 'face_id' => 'fotoProfile/harjo.jpg'
        ]);

        User::create([
            'name' => "Dr. Rakan Refaya",
            'email' => "dokterrakan@gmail.com",
            'no_hp' => "081298765432",
            'password' => bcrypt('dokterrakan'),
            'foto' => "fotoProfile/rakan.jpg",
            'is_active' => false,
            'role' => 'dokter',
            // 'face_id' => 'fotoProfile/harjo.jpeg'
        ]);
        User::create([
            'name' => "Dr. Faiz Iwan",
            'email' => "dokterfaiz@gmail.com",
            'no_hp' => "081299765432",
            'password' => bcrypt('dokterfaiz'),
            'foto' => "fotoProfile/faiz.jpg",
            'is_active' => false,
            'role' => 'dokter',
            // 'face_id' => 'fotoProfile/harjo.jpeg'
        ]);
        User::create([
            'name' => "Dr. Naza Sulthoniyah",
            'email' => "dokternaza@gmail.com",
            'no_hp' => "081298766432",
            'password' => bcrypt('dokternaza'),
            'foto' => "fotoProfile/naza.jpg",
            'is_active' => false,
            'role' => 'dokter',
            // 'face_id' => 'fotoProfile/harjo.jpeg'
        ]);
        User::create([
            'name' => "Dr. Hilmy Fahrizal",
            'email' => "dokterhilmy@gmail.com",
            'no_hp' => "081278765432",
            'password' => bcrypt('dokterhilmy'),
            'foto' => "fotoProfile/hilmy.jpg",
            'is_active' => false,
            'role' => 'dokter',
            // 'face_id' => 'fotoProfile/harjo.jpeg'
        ]);
    }
}
