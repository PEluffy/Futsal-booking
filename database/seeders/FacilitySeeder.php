<?php

namespace Database\Seeders;

use App\Models\Facility;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        $facilities = [
            [
                'name' => 'call',
                'desc' => 'Dedicated helpdesk for your bookings and queries.'
            ],
            [
                'name' => 'rs',
                'desc' => 'Dedicated helpdesk for your bookings and queries.'
            ],
            [
                'name' => 'user',
                'desc' => 'Dedicated helpdesk for your bookings and queries.'
            ],
            [
                'name' => 'wifi',
                'desc' => 'Dedicated helpdesk for your bookings and queries.'
            ],
        ];

        foreach ($facilities as $facility) {
            Facility::create($facility);
        }
    }
}
