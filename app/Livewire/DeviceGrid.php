<?php

namespace App\Livewire;

use App\Models\Device;
use App\Models\Room;
use Livewire\Component;

class DeviceGrid extends Component
{
    protected $listeners = ['device-updated' => '$refresh'];

    public function render()
    {
        $rooms = Room::with('devices')->get();
        $devices = Device::with('room')->get();

        return view('livewire.device-grid', [
            'rooms' => $rooms,
            'devices' => $devices,
        ]);
    }
}
