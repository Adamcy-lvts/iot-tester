/*
 * ESP8266 Multi-Device IoT Controller
 *
 * This sketch polls the Laravel server for all device statuses (JSON format)
 * and sends the status to Arduino via Serial for controlling 4 devices:
 * - Living Room Light
 * - Air Condition
 * - Water Heater
 * - Borehole Pump
 *
 * Hardware: ESP8266 (ESP-01 or NodeMCU)
 * Communication: Serial to Arduino
 */

#include <ESP8266WiFi.h>
#include <ESP8266HTTPClient.h>
#include <WiFiClientSecure.h>
#include <ArduinoJson.h>  // Install: ArduinoJson by Benoit Blanchon

// WiFi Credentials
const char* ssid = "YOUR_WIFI_SSID";
const char* password = "YOUR_WIFI_PASSWORD";

// Server Configuration
String serverUrl = "https://iot-test.online/api/devices/all";
const unsigned long POLL_INTERVAL = 2000;  // 2 seconds

unsigned long lastPollTime = 0;
String lastPayload = "";  // Store last response to detect changes

void setup() {
  Serial.begin(115200);
  delay(100);

  Serial.println("\n\n=================================");
  Serial.println("ESP8266 Multi-Device Controller");
  Serial.println("=================================\n");

  // Connect to WiFi
  Serial.print("Connecting to WiFi: ");
  Serial.println(ssid);
  WiFi.begin(ssid, password);

  while (WiFi.status() != WL_CONNECTED) {
    delay(500);
    Serial.print(".");
  }

  Serial.println("\n\nWiFi Connected!");
  Serial.print("IP Address: ");
  Serial.println(WiFi.localIP());
  Serial.print("Signal Strength: ");
  Serial.print(WiFi.RSSI());
  Serial.println(" dBm\n");
}

void loop() {
  // Check WiFi connection
  if (WiFi.status() != WL_CONNECTED) {
    Serial.println("WiFi lost! Reconnecting...");
    WiFi.begin(ssid, password);
    while (WiFi.status() != WL_CONNECTED) {
      delay(500);
      Serial.print(".");
    }
    Serial.println("\nReconnected!");
  }

  // Poll server at specified interval
  if (millis() - lastPollTime >= POLL_INTERVAL) {
    lastPollTime = millis();
    pollServer();
  }

  delay(10);  // Prevent watchdog timer issues
}

void pollServer() {
  WiFiClientSecure client;
  HTTPClient http;

  // Disable SSL certificate verification (for testing)
  client.setInsecure();

  http.begin(client, serverUrl);
  http.setTimeout(5000);  // 5 second timeout

  int httpCode = http.GET();

  if (httpCode == HTTP_CODE_OK) {
    String payload = http.getString();

    // Only process if payload changed (save bandwidth & processing)
    if (payload != lastPayload) {
      lastPayload = payload;

      // Parse JSON response
      StaticJsonDocument<256> doc;
      DeserializationError error = deserializeJson(doc, payload);

      if (error) {
        Serial.print("JSON Parse Error: ");
        Serial.println(error.c_str());
        http.end();
        return;
      }

      // Extract device statuses
      String living_room = doc["living_room_light"].as<String>();
      String ac = doc["air_condition"].as<String>();
      String heater = doc["water_heater"].as<String>();
      String borehole = doc["borehole"].as<String>();

      // Send to Arduino as 4-character string: "1001" = living=ON, ac=OFF, heater=OFF, borehole=ON
      String deviceStates = living_room + ac + heater + borehole;
      Serial.print(deviceStates);
      Serial.println();  // End marker for Arduino

      // Debug output
      Serial.print("[");
      Serial.print(millis());
      Serial.print("ms] Devices: ");
      Serial.print("LR=");
      Serial.print(living_room);
      Serial.print(" AC=");
      Serial.print(ac);
      Serial.print(" WH=");
      Serial.print(heater);
      Serial.print(" BH=");
      Serial.println(borehole);
    }
  } else {
    Serial.print("HTTP Error: ");
    Serial.println(httpCode);
  }

  http.end();
}
