#!/usr/bin/python3
import os
import sys
import json
from datetime import datetime

print("Content-Type: applciation/json\n")

method = os.environ.get('REQUEST_METHOD', 'GET')
payload = ""

if method in ['POST', 'PUT', 'DELETE']:
    payload = sys.stdin.read()

response = {
    "hostname": os.uname()[1],
    "datetime": datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
    "user_agent": os.environ.get('HTTP_USER_AGENT'),
    "IP_address": os.environ.get('REMOTE_ADDR'),
    "method": method,
    "payload": payload
}

print(json.dumps(response, indent=4))