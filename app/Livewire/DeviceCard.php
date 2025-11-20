<?php

namespace App\Livewire;

use App\Models\Device;
use Livewire\Component;

class DeviceCard extends Component
{
    public Device $device;
    public $lastUpdated;

    public function mount(Device $device)
    {
        $this->device = $device;
        $this->lastUpdated = now()->format('h:i:s A');
    }

    public function turnOn()
    {
        $this->device->turnOn();
        $this->device->refresh();
        $this->lastUpdated = now()->format('h:i:s A');
        $this->dispatch('device-updated', deviceId: $this->device->id, status: 'on');
    }

    public function turnOff()
    {
        $this->device->turnOff();
        $this->device->refresh();
        $this->lastUpdated = now()->format('h:i:s A');
        $this->dispatch('device-updated', deviceId: $this->device->id, status: 'off');
    }

    public function toggle()
    {
        $this->device->toggle();
        $this->device->refresh();
        $this->lastUpdated = now()->format('h:i:s A');
        $this->dispatch('device-updated', deviceId: $this->device->id, status: $this->device->status);
    }

    public function render()
    {
        return view('livewire.device-card');
    }
}
