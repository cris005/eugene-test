<?php

namespace Database\Seeders;

use App\Models\Specialty;
use Illuminate\Database\Seeder;

class SpecialtiesTableSeeder extends Seeder
{
    public function run()
    {
        Specialty::create(['id' => 1, 'name' => 'Unknown']);
        Specialty::create(['id' => 2, 'name' => 'General Practitioner']);
        Specialty::create(['id' => 3, 'name' => 'OB-GYN']);
        Specialty::create(['id' => 4, 'name' => 'Obstetrician']);
        Specialty::create(['id' => 5, 'name' => 'Gynaecologist']);
    }
}
