<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Device extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'room_id',
        'status',
        'config',
        'token',
        'mac_address',
        'description',
    ];

    protected $casts = [
        'config' => 'array',
    ];

    /**
     * Get the room this device belongs to.
     */
    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    /**
     * Turn the device on.
     */
    public function turnOn(): self
    {
        $this->update(['status' => '1']);
        return $this;
    }

    /**
     * Turn the device off.
     */
    public function turnOff(): self
    {
        $this->update(['status' => '0']);
        return $this;
    }

    /**
     * Toggle device status.
     */
    public function toggle(): self
    {
        $this->update(['status' => $this->status === '1' ? '0' : '1']);
        return $this;
    }

    /**
     * Check if device is on.
     */
    public function isOn(): bool
    {
        return $this->status === '1';
    }

    /**
     * Check if device is off.
     */
    public function isOff(): bool
    {
        return $this->status === '0';
    }
}
