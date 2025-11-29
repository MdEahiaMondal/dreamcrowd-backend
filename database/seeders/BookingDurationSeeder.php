<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BookingDuration;

class BookingDurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default booking duration settings
        BookingDuration::updateOrCreate(
            ['id' => 1],
            [
                'class_online' => 3,           // 3 hours for online classes
                'class_inperson' => 4,         // 4 hours for in-person classes
                'class_oneday' => 1,           // 1 hour for one-day classes
                'freelance_online_normal' => 2,        // 2 hours for normal freelance online
                'freelance_online_consultation' => 1,  // 1 hour for consultation
                'freelance_inperson' => 4,     // 4 hours for in-person freelance
            ]
        );
    }
}
