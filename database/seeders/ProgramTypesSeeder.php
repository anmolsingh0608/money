<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProgramType;

class ProgramTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProgramType::create([
            'title' => 'Junior program',
        ]);
        ProgramType::create([
            'title' => 'Highschool program',
        ]);
        ProgramType::create([
            'title' => 'Highschool (Spanish)',
        ]);
    }
}
