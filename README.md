# IoT Home Automation System

A Laravel-based web application for remotely controlling multiple IoT devices (lights, appliances, pumps) via ESP8266 + Arduino from anywhere in the world.

## Features

- **Multi-Device Control** - Manage multiple devices from one dashboard
- **Real-time Updates** - Livewire for instant status changes
- **Room Organization** - Group devices by location
- **REST API** - JSON endpoints for ESP8266 polling
- **Backward Compatible** - Legacy single LED endpoint still works
- **Remote Access** - Control from anywhere globally
- **Production Ready** - Tested with real hardware over hundreds of kilometers

## Default Devices

The system comes pre-configured with 4 devices:
1. **Living Room Light** (Arduino Pin 13)
2. **Air Condition** (Arduino Pin 12)
3. **Water Heater** (Arduino Pin 11)
4. **Borehole Pump** (Arduino Pin 10)

## Tech Stack

- Laravel 11 (Backend API + Database)
- Livewire 3 (Real-time UI)
- Tailwind CSS (Styling)
- SQLite Database (Device State Storage)
- ESP8266 (WiFi + JSON Parsing)
- Arduino (Relay Control)
- ArduinoJson Library

## Installation

### Prerequisites

- PHP 8.2+
- Composer
- Node.js & npm

### Setup

1. Clone the repository
```bash
git clone <your-repo-url>
cd iot_tester
```

2. Install dependencies
```bash
composer install
npm install
```

3. Copy environment file
```bash
cp .env.example .env
```

4. Generate application key
```bash
php artisan key:generate
```

5. Run migrations and seed devices
```bash
php artisan migrate
php artisan db:seed --class=DeviceSeeder
```

6. Build assets
```bash
npm run build
```

7. Start the development server
```bash
php artisan serve
```

## Hardware Setup

See [SETUP_GUIDE.md](SETUP_GUIDE.md) for complete wiring diagrams and instructions.

**Quick Start:**
1. Upload `arduino/ESP8266_MultiDevice.ino` to ESP8266
2. Upload `arduino/Arduino_RelayControl.ino` to Arduino
3. Wire ESP8266 to Arduino via Serial (pins 2,3)
4. Wire Arduino to 4-channel relay module
5. Update WiFi credentials in ESP8266 code

## API Endpoints

### Multi-Device Endpoints

#### GET `/api/devices/all`
Returns JSON with all device statuses:
```json
{
  "living_room_light": "1",
  "air_condition": "0",
  "water_heater": "1",
  "borehole": "0"
}
```

#### GET `/api/devices/{slug}/status`
Returns single device status (`1` or `0`)

Example: `GET /api/devices/living-room-light/status` → `1`

### Legacy Single LED Endpoints (Backward Compatible)

#### GET `/led/status`
Returns the current LED status (`1` or `0`)

#### GET `/led/on`
Turns the LED on (returns `1`)

#### GET `/led/off`
Turns the LED off (returns `0`)

## Testing

A polling simulator script is included to test the system without hardware:

```bash
./test_esp_polling.sh
```

This simulates the ESP8266 polling behavior every 3 seconds.

## Deployment

### Digital Ocean Droplet

1. Deploy Laravel application to your droplet
2. Update your ESP8266 code with the droplet's IP/domain
3. Ensure the `/led/status` endpoint is publicly accessible
4. Control your LED from anywhere!

## Usage

### Web Dashboard
1. Access the dashboard at `http://your-server`
2. View all devices organized by room
3. Click "Turn ON", "Turn OFF", or "Toggle" for any device
4. Status updates instantly in browser
5. ESP8266 detects changes within 2 seconds
6. Arduino activates relays accordingly

### Remote Control
The system works from anywhere with internet:
- Control devices from different countries ✓
- Tested working over hundreds of kilometers ✓
- Real-time response (2-3 second delay) ✓

### Arduino Code Files
- `arduino/ESP8266_MultiDevice.ino` - WiFi + JSON parsing
- `arduino/Arduino_RelayControl.ino` - Relay control logic

## License

Open-source software licensed under the MIT license.
