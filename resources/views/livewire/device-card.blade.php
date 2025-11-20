<div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-6">
    <!-- Device Header -->
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $device->name }}</h3>
            @if($device->room)
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $device->room->name }}</p>
            @endif
        </div>

        <!-- Status Indicator -->
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full {{ $device->isOn() ? 'bg-green-500 animate-pulse' : 'bg-gray-400 dark:bg-zinc-600' }}"></div>
            <span class="text-sm font-medium {{ $device->isOn() ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                {{ $device->isOn() ? 'ON' : 'OFF' }}
            </span>
        </div>
    </div>

    <!-- Device Icon/Visual -->
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full mb-3 transition-all duration-300
            {{ $device->isOn() ? 'bg-green-100 dark:bg-green-900/30 shadow-green-200 dark:shadow-green-800 shadow-lg' : 'bg-gray-100 dark:bg-zinc-700' }}">

            @if($device->type === 'light')
                <svg class="w-12 h-12 {{ $device->isOn() ? 'text-green-500' : 'text-gray-400 dark:text-zinc-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                </svg>
            @elseif($device->type === 'ac')
                <svg class="w-12 h-12 {{ $device->isOn() ? 'text-green-500' : 'text-gray-400 dark:text-zinc-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            @elseif($device->type === 'heater')
                <svg class="w-12 h-12 {{ $device->isOn() ? 'text-green-500' : 'text-gray-400 dark:text-zinc-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
                </svg>
            @elseif($device->type === 'pump')
                <svg class="w-12 h-12 {{ $device->isOn() ? 'text-green-500' : 'text-gray-400 dark:text-zinc-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
            @else
                <svg class="w-12 h-12 {{ $device->isOn() ? 'text-green-500' : 'text-gray-400 dark:text-zinc-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            @endif
        </div>
    </div>

    <!-- Control Buttons -->
    <div class="space-y-3">
        <button
            wire:click="turnOn"
            class="w-full py-3 px-6 rounded-lg font-semibold text-white transition-all duration-200
                {{ $device->isOn() ? 'bg-green-600 shadow-lg' : 'bg-green-500 hover:bg-green-600' }}
                focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800">
            Turn ON
        </button>

        <button
            wire:click="turnOff"
            class="w-full py-3 px-6 rounded-lg font-semibold text-white transition-all duration-200
                {{ $device->isOff() ? 'bg-gray-600 dark:bg-zinc-600 shadow-lg' : 'bg-gray-500 dark:bg-zinc-500 hover:bg-gray-600 dark:hover:bg-zinc-600' }}
                focus:outline-none focus:ring-2 focus:ring-gray-500 dark:focus:ring-zinc-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800">
            Turn OFF
        </button>

        <button
            wire:click="toggle"
            class="w-full py-3 px-6 rounded-lg font-semibold text-gray-700 dark:text-white bg-blue-100 dark:bg-blue-900/30 hover:bg-blue-200 dark:hover:bg-blue-900/50
                transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800">
            Toggle
        </button>
    </div>

    <!-- Last Updated -->
    <div class="mt-4 text-xs text-gray-500 dark:text-gray-400 text-center">
        Last updated: {{ $lastUpdated }}
    </div>
</div>
