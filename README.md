# IoT LED Controller

A Laravel-based web application for remotely controlling an ESP8266-connected LED from anywhere in the world.

## Features

- Real-time LED control via web interface using Livewire
- REST API endpoint for ESP8266 polling
- Turn LED ON/OFF or Toggle
- Live status updates
- Remote control from any location

## Tech Stack

- Laravel 11
- Livewire 3
- Tailwind CSS
- SQLite Database
- ESP8266 (Arduino)

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

5. Run migrations
```bash
php artisan migrate
```

6. Build assets
```bash
npm run build
```

7. Start the development server
```bash
php artisan serve
```

## ESP8266 Configuration

Configure your ESP8266 to poll the `/led/status` endpoint:

```cpp
String serverName = "http://your-server-ip/led/status";
```

The endpoint returns:
- `1` - LED should be ON
- `0` - LED should be OFF

Poll every 3 seconds for optimal responsiveness.

## API Endpoints

### GET `/led/status`
Returns the current LED status (`1` or `0`)

### GET `/led/on`
Turns the LED on (returns `1`)

### GET `/led/off`
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

1. Access the dashboard at `http://your-server/dashboard`
2. Click "Turn ON", "Turn OFF", or "Toggle" buttons
3. The ESP8266 will detect changes within 3 seconds
4. LED responds accordingly

## License

Open-source software licensed under the MIT license.
