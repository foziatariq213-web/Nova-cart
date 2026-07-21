<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Mood;

class MoodSeeder extends Seeder
{
    public function run(): void
    {
        $moods = [
            ['name' => 'Party'],
            ['name' => 'Office'],
            ['name' => 'Casual'],
            ['name' => 'Self Care'],
            ['name' => 'Wedding'],
        ];

        foreach ($moods as $mood) {
            Mood::firstOrCreate($mood);
        }
    }
}