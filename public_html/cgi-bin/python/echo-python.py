#!/usr/bin/python3
import os
import sys
import json
from datetime import datetime

print("Content-Type: applciation/json\n")

raw_input = sys.stdin.read()
content_type = os.environ.get('CONTENT_TYPE', '')

payload = {}
if "application/json" in content_type:
    try:
        payload = json.loads(raw_input)
    except:
        payload = {"error": "Invalid JSON"}
else:
    payload = raw_input

response = {
    "hostname": os.uname()[1],
    "datetime": datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
    "user_agent": os.environ.get('HTTP_USER_AGENT'),
    "IP_address": os.environ.get('REMOTE_ADDR'),
    "method": os.environ.get('REQUEST_METHOD'),
    "payload": payload
}

print(json.dumps(response, indent=4))