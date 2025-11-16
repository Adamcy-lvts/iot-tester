#!/bin/bash

echo "ESP8266 Polling Simulator"
echo "=========================="
echo "This simulates your ESP8266 polling the /led/status endpoint"
echo "Press Ctrl+C to stop"
echo ""

COUNTER=0

while true; do
    COUNTER=$((COUNTER + 1))
    TIMESTAMP=$(date '+%Y-%m-%d %H:%M:%S')

    # Poll the endpoint (like ESP8266 does)
    RESPONSE=$(curl -s http://localhost:8000/led/status)

    if [ "$RESPONSE" = "1" ]; then
        echo "[$TIMESTAMP] Poll #$COUNTER: LED Status = ON (1) ✓"
    else
        echo "[$TIMESTAMP] Poll #$COUNTER: LED Status = OFF (0)"
    fi

    # Poll every 3 seconds (matching your UI description)
    sleep 3
done
