/*
 * Arduino Multi-Device Relay Controller
 *
 * Receives device status from ESP8266 via Serial and controls 4 relays:
 * - Pin 13: Living Room Light
 * - Pin 12: Air Condition
 * - Pin 11: Water Heater
 * - Pin 10: Borehole Pump
 *
 * Data Format: 4-character string from ESP8266
 * Example: "1001" means Living Room=ON, AC=OFF, Heater=OFF, Borehole=ON
 *
 * Hardware: Arduino Uno/Nano + ESP-01 (connected via SoftwareSerial)
 */

#include <SoftwareSerial.h>

// ESP8266 Serial Communication (RX, TX)
SoftwareSerial esp(2, 3);  // Arduino pin 2 = RX, pin 3 = TX

// Relay Pins (connected to relay module)
const int LIVING_ROOM_PIN = 13;
const int AC_PIN = 12;
const int HEATER_PIN = 11;
const int BOREHOLE_PIN = 10;

// Store last known states to detect changes
String lastStates = "0000";

void setup() {
  // Initialize relay pins as OUTPUT
  pinMode(LIVING_ROOM_PIN, OUTPUT);
  pinMode(AC_PIN, OUTPUT);
  pinMode(HEATER_PIN, OUTPUT);
  pinMode(BOREHOLE_PIN, OUTPUT);

  // Set all relays to OFF initially
  digitalWrite(LIVING_ROOM_PIN, LOW);
  digitalWrite(AC_PIN, LOW);
  digitalWrite(HEATER_PIN, LOW);
  digitalWrite(BOREHOLE_PIN, LOW);

  // Initialize Serial communications
  Serial.begin(115200);    // USB serial for debugging
  esp.begin(115200);       // ESP8266 communication

  Serial.println("\n================================");
  Serial.println("Arduino Multi-Device Controller");
  Serial.println("================================\n");
  Serial.println("Waiting for commands from ESP8266...\n");
}

void loop() {
  // Check if data available from ESP8266
  if (esp.available()) {
    String data = esp.readStringUntil('\n');
    data.trim();

    // Validate data format (should be 4 characters: "1001", "0110", etc.)
    if (data.length() == 4) {
      // Only update if state changed (prevent unnecessary relay switching)
      if (data != lastStates) {
        Serial.println("\n--- State Change Detected ---");
        Serial.print("Previous: ");
        Serial.println(lastStates);
        Serial.print("New:      ");
        Serial.println(data);

        // Update devices
        updateDevice("Living Room Light", LIVING_ROOM_PIN, data[0], lastStates[0]);
        updateDevice("Air Condition", AC_PIN, data[1], lastStates[1]);
        updateDevice("Water Heater", HEATER_PIN, data[2], lastStates[2]);
        updateDevice("Borehole Pump", BOREHOLE_PIN, data[3], lastStates[3]);

        lastStates = data;
        Serial.println("-----------------------------\n");
      }
    } else {
      Serial.print("Invalid data received: ");
      Serial.println(data);
    }
  }
}

/**
 * Update a single device if its state changed
 */
void updateDevice(String name, int pin, char newState, char oldState) {
  if (newState != oldState) {
    if (newState == '1') {
      digitalWrite(pin, HIGH);
      Serial.print("[ON]  ");
      Serial.println(name);
    } else {
      digitalWrite(pin, LOW);
      Serial.print("[OFF] ");
      Serial.println(name);
    }
  }
}
