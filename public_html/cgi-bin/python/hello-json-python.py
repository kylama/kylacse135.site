#!usr/bin/python3
import os
import json
from datetime import datetime

print("Content-Type: application/json\n\n")
data = {
    "title": "Python Hello JSON",
    "heading": "Hello, Python!",
    "message": "This page was generated with the Python programming language",
    "time": datetime.now().strftime('%Y-%m-%d %H:%M:%S'),
    "IP": os.environ.get('REMOTE_ADDR')
}
print(json.dumps(data))