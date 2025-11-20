# IoT Home Automation - Setup Guide

Complete guide for setting up the multi-device IoT home automation system.

## Table of Contents
1. [System Overview](#system-overview)
2. [Hardware Requirements](#hardware-requirements)
3. [Software Installation](#software-installation)
4. [Arduino Setup](#arduino-setup)
5. [Testing Without Hardware](#testing-without-hardware)
6. [Deployment](#deployment)
7. [Troubleshooting](#troubleshooting)

---

## System Overview

This system controls 4 devices remotely via a web interface:
- **Living Room Light** (Pin 13)
- **Air Condition** (Pin 12)
- **Water Heater** (Pin 11)
- **Borehole Pump** (Pin 10)

**Architecture:**
```
Web Dashboard → Laravel API → ESP8266 (polls JSON) → Arduino → 4 Relays → Devices
```

**Communication Flow:**
1. User clicks button on website
2. Laravel updates database
3. ESP8266 polls `/api/devices/all` endpoint (every 2 seconds)
4. ESP8266 receives JSON: `{"living_room_light": "1", "air_condition": "0", ...}`
5. ESP8266 parses JSON and sends "1001" to Arduino via Serial
6. Arduino updates relay states accordingly

---

## Hardware Requirements

### Required Components:
- **ESP8266** (ESP-01 or NodeMCU/D1 Mini)
- **Arduino Uno or Nano**
- **4-Channel Relay Module** (5V)
- **Jumper Wires**
- **Power Supply** (5V for Arduino + relays)

### Wiring Diagram:

**ESP8266 to Arduino:**
```
ESP8266 TX  →  Arduino Pin 2 (RX)
ESP8266 RX  →  Arduino Pin 3 (TX)
ESP8266 GND →  Arduino GND
ESP8266 VCC →  Arduino 3.3V
```

**Arduino to Relay Module:**
```
Arduino Pin 13  →  Relay 1 (Living Room Light)
Arduino Pin 12  →  Relay 2 (Air Condition)
Arduino Pin 11  →  Relay 3 (Water Heater)
Arduino Pin 10  →  Relay 4 (Borehole Pump)
Arduino GND     →  Relay GND
Arduino 5V      →  Relay VCC
```

**Relays to Devices:**
- Connect each relay's NO (Normally Open) terminal to your devices
- **IMPORTANT:** High voltage wiring must be done by a qualified electrician!

---

## Software Installation

### 1. Install Arduino IDE
- Download from: https://www.arduino.cc/en/software
- Install ESP8266 board support:
  - File → Preferences → Additional Board Manager URLs
  - Add: `http://arduino.esp8266.com/stable/package_esp8266com_index.json`
  - Tools → Board → Boards Manager → Search "esp8266" → Install

### 2. Install Required Libraries
Open Arduino IDE → Sketch → Include Library → Manage Libraries:
- **ArduinoJson** by Benoit Blanchon (v6.x or later)

### 3. Laravel Server Setup
```bash
# Clone repository
git clone https://github.com/YOUR_USERNAME/iot-tester.git
cd iot-tester

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Run migrations and seed
php artisan migrate
php artisan db:seed --class=DeviceSeeder

# Build assets
npm run build

# Start server
php artisan serve
```

---

## Arduino Setup

### Step 1: Upload ESP8266 Code

1. Open `arduino/ESP8266_MultiDevice.ino` in Arduino IDE
2. Update WiFi credentials:
   ```cpp
   const char* ssid = "YOUR_WIFI_SSID";
   const char* password = "YOUR_WIFI_PASSWORD";
   ```
3. Update server URL:
   ```cpp
   String serverUrl = "https://your-domain.com/api/devices/all";
   ```
4. Select Board: Tools → Board → ESP8266 Boards → Your ESP model
5. Select Port: Tools → Port → COM port for ESP8266
6. Click Upload ✓

### Step 2: Upload Arduino Code

1. Open `arduino/Arduino_RelayControl.ino` in Arduino IDE
2. No configuration needed (uses default pins)
3. Select Board: Tools → Board → Arduino Uno/Nano
4. Select Port: Tools → Port → COM port for Arduino
5. Click Upload ✓

### Step 3: Connect Hardware

1. Wire ESP8266 to Arduino as shown above
2. Wire Arduino to relay module
3. Power on Arduino (via USB or external 5V)
4. Open Serial Monitor (115200 baud) to see debug output

### Step 4: Test

1. Open your web browser: `http://your-server-ip`
2. Click "Turn ON" for Living Room Light
3. Watch Arduino Serial Monitor - should show:
   ```
   --- State Change Detected ---
   Previous: 0000
   New:      1000
   [ON]  Living Room Light
   ```
4. Physical relay should click and turn on!

---

## Testing Without Hardware

You can test the system without Arduino/ESP8266 using the provided simulator:

### Web Testing:
```bash
# Start Laravel server
php artisan serve

# Open browser
http://localhost:8000

# Click device buttons - status updates in database
```

### ESP8266 Simulation:
```bash
# Run the polling simulator
./test_esp_polling.sh

# Or manually poll the API
curl http://localhost:8000/api/devices/all

# Response:
{
  "living_room_light": "1",
  "air_condition": "0",
  "water_heater": "1",
  "borehole": "0"
}
```

---

## Deployment

### Deploy to Digital Ocean

1. **Setup Droplet:**
   - Create Ubuntu droplet with Laravel Forge or manual setup
   - Install PHP 8.2+, Composer, Node.js, Nginx/Apache

2. **Configure GitHub Secrets:**
   Go to: GitHub Repository → Settings → Secrets → Actions
   - `DO_HOST_DEVCENTRIC`: Your droplet IP/domain
   - `DO_USER_DEVCENTRIC`: SSH username (usually `forge`)
   - `SSH_PRIVATE_KEY_DEVCENTRIC`: Private SSH key
   - `SSH_PASSPHRASE_DEVCENTRIC`: SSH key passphrase

3. **Push to GitHub:**
   ```bash
   git push origin main
   ```
   GitHub Actions will automatically deploy!

4. **Update ESP8266:**
   Update server URL in ESP8266 code:
   ```cpp
   String serverUrl = "https://your-domain.com/api/devices/all";
   ```

5. **Test Remotely:**
   - Open web dashboard from anywhere
   - Click device buttons
   - Watch ESP8266 respond (even hundreds of km away!)

---

## Troubleshooting

### ESP8266 Not Connecting to WiFi
- **Check:** SSID and password correct?
- **Check:** WiFi signal strength (ESP8266 has weak antenna)
- **Try:** Move ESP8266 closer to router
- **Check:** Router firewall settings

### Arduino Not Receiving Data
- **Check:** Wiring between ESP and Arduino
- **Check:** Baud rate (must be 115200 on both)
- **Try:** Swap RX/TX pins
- **Check:** Serial Monitor shows ESP output?

### Devices Not Responding
- **Check:** API endpoint returns correct JSON:
  ```bash
  curl https://your-domain.com/api/devices/all
  ```
- **Check:** ESP8266 Serial Monitor shows "JSON Parse Error"?
- **Check:** Database has device records:
  ```bash
  php artisan tinker
  >>> App\Models\Device::all();
  ```

### Relays Clicking But Devices Not Working
- **WARNING:** High voltage! Stop and call an electrician
- **Check:** Relay module power (should have LED indicators)
- **Check:** Using NO (Normally Open) terminals, not NC
- **Check:** Device power supply working?

### Web Dashboard Not Loading
- **Check:** Laravel server running: `php artisan serve`
- **Check:** Assets built: `npm run build`
- **Check:** Database migrated: `php artisan migrate`
- **Check:** Browser console for JavaScript errors

### SSL/HTTPS Errors on ESP8266
- **Using self-signed certificate?** Set `client.setInsecure()` in ESP code
- **Production:** Get proper SSL certificate (Let's Encrypt)

---

## API Endpoints Reference

### Get All Devices (JSON)
```
GET /api/devices/all

Response:
{
  "living_room_light": "1",
  "air_condition": "0",
  "water_heater": "1",
  "borehole": "0"
}
```

### Get Single Device
```
GET /api/devices/{slug}/status

Example: GET /api/devices/living-room-light/status
Response: 1
```

### Legacy LED Endpoint (Backward Compatible)
```
GET /led/status

Response: 1 or 0
```

---

## Next Steps

1. ✅ Test all devices individually
2. ✅ Test from remote location
3. 🔧 Add more devices (add to database & update Arduino pins)
4. 🔧 Implement scheduling (turn on at 7pm)
5. 🔧 Add automation rules (if motion → turn on light)
6. 🔧 Add mobile app (using same API)

---

## Support

- **GitHub Issues:** https://github.com/YOUR_USERNAME/iot-tester/issues
- **Arduino Forum:** https://forum.arduino.cc
- **ESP8266 Community:** https://www.esp8266.com

---

**Built with Laravel, Livewire, ESP8266, and Arduino**
