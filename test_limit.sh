#!/bin/bash

# Set the URL of your PHP script (replace with the actual URL if needed)
URL="http://localhost:8000/"

# Function to send a request to the PHP script
send_request() {
  response=$(curl -s -o /dev/null -w "%{http_code}" "$URL")
  if [ "$response" -eq 200 ]; then
    echo "Request successful: $response"
  else
    echo "Request failed with status: $response"
  fi
}

# Send 15 requests in quick succession (within the same minute)
for i in $(seq 1 15); do
  echo "Sending request #$i"
  send_request
  sleep 1 # Sleep for 1 second between requests
done

# Send the 16th request to test rate limiting
echo "Sending 16th request to test rate limiting"
send_request
