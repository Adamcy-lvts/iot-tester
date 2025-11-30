/*
 * ESP8266 Direct Relay Controller
 *
 * This sketch polls the Laravel server for device statuses and directly controls
 * relays connected to the ESP8266 GPIO pins.
 *
 * Hardware: NodeMCU / Wemos D1 Mini (Recommended)
 * Note: ESP-01 has limited pins (GPIO0, GPIO2).
 */

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecure.h>
#include <ArduinoJson.h>

// ==========================================
// CONFIGURATION
// ==========================================

// WiFi Credentials
const char* ssid = "YOUR_WIFI_SSID";
const char* password = "YOUR_WIFI_PASSWORD";

// Server URL
const String serverUrl = "https://iot-test.online/api/devices/all";
const unsigned long POLL_INTERVAL = 2000; // 2 seconds

// Device Configuration Structure
struct Device {
  const char* jsonKey; // The key in the JSON response
  int pin;             // The GPIO pin connected to the relay
};

// Define your devices and pins here
// NOTE: Pin numbers are GPIO numbers (e.g., D1 on NodeMCU is usually GPIO 5)
const int DEVICE_COUNT = 4;
Device devices[DEVICE_COUNT] = {
  { "living_room_light", 5 },  // GPIO 5 (D1)
  { "air_condition",     4 },  // GPIO 4 (D2)
  { "water_heater",      0 },  // GPIO 0 (D3)
  { "borehole",          2 }   // GPIO 2 (D4)
};

// ==========================================
// GLOBAL VARIABLES
// ==========================================

unsigned long lastPollTime = 0;
String lastPayload = "";

// ==========================================
// SETUP
// ==========================================

void setup() {
  Serial.begin(115200);
  delay(100);

  Serial.println("\n\n=================================");
  Serial.println("ESP8266 Direct Relay Controller");
  Serial.println("=================================\n");

  // Initialize Relay Pins
  for (int i = 0; i < DEVICE_COUNT; i++) {
    pinMode(devices[i].pin, OUTPUT);
    // Default to OFF (Assuming Active HIGH relays, change to HIGH if Active LOW)
    digitalWrite(devices[i].pin, LOW); 
  }

  // Connect to WiFi
  connectWiFi();
}

// ==========================================
// MAIN LOOP
// ==========================================

void loop() {
  // Maintain WiFi Connection
  if (WiFi.status() != WL_CONNECTED) {
    connectWiFi();
  }

  // Poll Server
  if (millis() - lastPollTime >= POLL_INTERVAL) {
    lastPollTime = millis();
    pollServer();
  }
}

// ==========================================
// HELPER FUNCTIONS
// ==========================================

void connectWiFi() {
  Serial.print("Connecting to WiFi: ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }
  
  Serial.println("\nWiFi Connected!");
  Serial.print("IP: ");
  Serial.println(WiFi.localIP());
}

void pollServer() {
  WiFiClientSecure client;
  HTTPClient http;

  // Disable SSL verification for simplicity
  client.setInsecure();

  http.begin(client, serverUrl);
  http.setTimeout(5000);

  int httpCode = http.GET();

  if (httpCode == HTTP_CODE_OK) {
    String payload = http.getString();

    // Only process if data changed
    if (payload != lastPayload) {
      lastPayload = payload;
      processJson(payload);
    }
  } else {
    Serial.print("HTTP Error: ");
    Serial.println(httpCode);
  }

  http.end();
}

void processJson(String payload) {
  StaticJsonDocument<512> doc;
  DeserializationError error = deserializeJson(doc, payload);

  if (error) {
    Serial.print("JSON Parse Error: ");
    Serial.println(error.c_str());
    return;
  }

  Serial.println("\n--- Updating Devices ---");

  for (int i = 0; i < DEVICE_COUNT; i++) {
    // Get status from JSON using the key defined in our struct
    String status = doc[devices[i].jsonKey].as<String>();
    
    Serial.print(devices[i].jsonKey);
    Serial.print(": ");
    
    if (status == "1") {
      digitalWrite(devices[i].pin, HIGH);
      Serial.println("ON");
    } else {
      digitalWrite(devices[i].pin, LOW);
      Serial.println("OFF");
    }
  }
  Serial.println("------------------------");
}
