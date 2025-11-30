<div class="w-full" wire:poll.2s>


    <!-- Unified Remote Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @foreach($devices as $device)
            @livewire('device-card', ['device' => $device], key($device->id))
        @endforeach
    </div>

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
