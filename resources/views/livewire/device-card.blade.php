<button
    wire:click="toggle"
    class="relative group w-full aspect-square flex flex-col items-center justify-center p-4 rounded-2xl transition-all duration-300
    {{ $device->isOn()
        ? 'bg-gradient-to-br from-green-500 to-emerald-600 text-white shadow-lg shadow-green-500/30 scale-[1.02]'
        : 'bg-white dark:!bg-zinc-800 text-gray-600 dark:!text-gray-200 hover:bg-gray-50 dark:hover:!bg-zinc-700 shadow-sm hover:shadow-md'
    }}">

    <!-- Status Dot -->
    <div class="absolute top-4 right-4 w-2 h-2 rounded-full {{ $device->isOn() ? 'bg-white animate-pulse' : 'bg-gray-300 dark:bg-zinc-500' }}"></div>

    <!-- Icon -->
    <div class="mb-3 transition-transform duration-300 group-hover:scale-110">
        @if($device->type === 'light')
            <svg class="w-10 h-10 {{ $device->isOn() ? 'text-white' : 'text-gray-400 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
        @elseif($device->type === 'ac')
            <svg class="w-10 h-10 {{ $device->isOn() ? 'text-white' : 'text-gray-400 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
        @elseif($device->type === 'heater')
            <svg class="w-10 h-10 {{ $device->isOn() ? 'text-white' : 'text-gray-400 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"/>
            </svg>
        @elseif($device->type === 'pump')
            <svg class="w-10 h-10 {{ $device->isOn() ? 'text-white' : 'text-gray-400 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
            </svg>
        @else
            <svg class="w-10 h-10 {{ $device->isOn() ? 'text-white' : 'text-gray-400 dark:text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
            </svg>
        @endif
    </div>

    <!-- Name -->
    <span class="text-sm font-semibold tracking-wide">{{ $device->name }}</span>
    
    <!-- Room (Optional, small) -->
    @if($device->room)
        <span class="text-xs opacity-70 mt-1">{{ $device->room->name }}</span>
    @endif

</button>
