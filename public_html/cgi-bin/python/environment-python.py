#!/usr/bin/python3
import os

print("Content-Type: text/html\n")
print("<!DOCTYPE html>")
print("<html><head><title>Environment Variables</title>")
print("</head><body><h1 style='text-align: center'>Environment Variables</h1><hr>")
for key, value in os.environ.items():
    print(f"<strong>{key}:</strong> {value}<br />")
print("</body></html>")