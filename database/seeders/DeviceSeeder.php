<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create rooms
        $livingRoom = \App\Models\Room::create([
            'name' => 'Living Room',
            'description' => 'Main living area',
            'icon' => 'home',
        ]);

        $utilityRoom = \App\Models\Room::create([
            'name' => 'Utility Room',
            'description' => 'Utility and service area',
            'icon' => 'tool',
        ]);

        // Create devices matching Arduino setup
        \App\Models\Device::create([
            'name' => 'Living Room Light',
            'slug' => 'living-room-light',
            'type' => 'light',
            'room_id' => $livingRoom->id,
            'status' => '0',
            'token' => 'living_room_light',
            'description' => 'Main living room lighting',
        ]);

        \App\Models\Device::create([
            'name' => 'Air Condition',
            'slug' => 'air-condition',
            'type' => 'ac',
            'room_id' => $livingRoom->id,
            'status' => '0',
            'token' => 'air_condition',
            'description' => 'Living room air conditioning unit',
        ]);

        \App\Models\Device::create([
            'name' => 'Water Heater',
            'slug' => 'water-heater',
            'type' => 'heater',
            'room_id' => $utilityRoom->id,
            'status' => '0',
            'token' => 'water_heater',
            'description' => 'Main water heating system',
        ]);

        \App\Models\Device::create([
            'name' => 'Borehole Pump',
            'slug' => 'borehole',
            'type' => 'pump',
            'room_id' => $utilityRoom->id,
            'status' => '0',
            'token' => 'borehole',
            'description' => 'Water borehole pump',
        ]);
    }
}
