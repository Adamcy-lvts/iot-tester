<div class="max-w-md mx-auto">
    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow-lg p-8">
        <!-- LED Status Display -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-32 h-32 rounded-full mb-4 transition-all duration-300
                {{ $ledStatus === '1' ? 'bg-green-100 dark:bg-green-900/30 shadow-green-200 dark:shadow-green-800 shadow-lg' : 'bg-gray-100 dark:bg-zinc-700' }}">
                <div class="w-20 h-20 rounded-full transition-all duration-300
                    {{ $ledStatus === '1' ? 'bg-green-500 shadow-green-400 dark:shadow-green-600 shadow-lg animate-pulse' : 'bg-gray-400 dark:bg-zinc-600' }}">
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
                LED Status:
                <span class="{{ $ledStatus === '1' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 dark:text-gray-400' }}">
                    {{ $ledStatus === '1' ? 'ON' : 'OFF' }}
                </span>
            </h2>

            <p class="text-sm text-gray-500 dark:text-gray-400">Last updated: {{ $lastUpdated }}</p>
        </div>

        <!-- Control Buttons -->
        <div class="space-y-3">
            <button
                wire:click="turnOn"
                class="w-full py-3 px-6 rounded-lg font-semibold text-white transition-all duration-200
                    {{ $ledStatus === '1' ? 'bg-green-600 shadow-lg' : 'bg-green-500 hover:bg-green-600' }}
                    focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-zinc-800">
                Turn ON
            </button>

            <button
                wire:click="turnOff"
                class="w-full py-3 px-6 rounded-lg font-semibold text-white transition-all duration-200
                    {{ $ledStatus === '0' ? 'bg-gray-600 dark:bg-zinc-600 shadow-lg' : 'bg-gray-500 dark:bg-zinc-500 hover:bg-gray-600 dark:hover:bg-zinc-600' }}
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

        <!-- Info Box -->
        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
            <p class="text-xs text-blue-800 dark:text-blue-300">
                <strong>ESP8266 Endpoint:</strong> /api/led/status
            </p>
            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                Polling every 3 seconds from your Arduino
            </p>
        </div>
    </div>
</div>