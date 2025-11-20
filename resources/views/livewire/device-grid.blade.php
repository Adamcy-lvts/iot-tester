<div class="w-full">
    <!-- Header -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Your Devices</h2>
        <p class="text-gray-600 dark:text-gray-400">Control all your IoT devices from one place</p>
    </div>

    <!-- Devices by Room -->
    @foreach($rooms as $room)
        @if($room->devices->count() > 0)
            <div class="mb-10">
                <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    {{ $room->name }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($room->devices as $device)
                        @livewire('device-card', ['device' => $device], key($device->id))
                    @endforeach
                </div>
            </div>
        @endif
    @endforeach

    <!-- API Information Box -->
    {{-- <div class="mt-10 p-6 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
        <h4 class="text-lg font-semibold text-blue-900 dark:text-blue-300 mb-3">ESP8266 / Arduino Integration</h4>

        <div class="space-y-2 text-sm text-blue-800 dark:text-blue-300">
            <div>
                <strong>All Devices JSON Endpoint:</strong>
                <code class="ml-2 px-2 py-1 bg-blue-100 dark:bg-blue-900/40 rounded">GET /api/devices/all</code>
            </div>

            <div>
                <strong>Single Device Endpoint:</strong>
                <code class="ml-2 px-2 py-1 bg-blue-100 dark:bg-blue-900/40 rounded">GET /api/devices/{slug}/status</code>
            </div>

            <div>
                <strong>Legacy LED Endpoint:</strong>
                <code class="ml-2 px-2 py-1 bg-blue-100 dark:bg-blue-900/40 rounded">GET /led/status</code>
            </div>
        </div>

        <div class="mt-4 text-xs text-blue-600 dark:text-blue-400">
            <p>Poll interval: 2-3 seconds recommended</p>
            <p>JSON response format: <code>{"living_room_light": "1", "air_condition": "0", ...}</code></p>
        </div>
    </div> --}}
</div>
