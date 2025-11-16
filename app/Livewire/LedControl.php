<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Setting;

class LedControl extends Component
{
    public $ledStatus;
    public $lastUpdated;

    public function mount()
    {
        $this->loadStatus();
    }

    public function loadStatus()
    {
        $this->ledStatus = Setting::getValue('led_status', '0');
        $this->lastUpdated = now()->format('h:i:s A');
    }

    public function turnOn()
    {
        Setting::setValue('led_status', '1');
        $this->loadStatus();
        $this->dispatch('led-updated', status: 'on');
    }

    public function turnOff()
    {
        Setting::setValue('led_status', '0');
        $this->loadStatus();
        $this->dispatch('led-updated', status: 'off');
    }

    public function toggle()
    {
        $newStatus = $this->ledStatus === '1' ? '0' : '1';
        Setting::setValue('led_status', $newStatus);
        $this->loadStatus();
        $this->dispatch('led-updated', status: $newStatus === '1' ? 'on' : 'off');
    }

    public function render()
    {
        return view('livewire.led-control');
    }
}