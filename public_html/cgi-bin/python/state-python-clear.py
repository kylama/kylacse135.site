#!/usr/bin/python3
from http import cookies
import sys

c = cookies.SimpleCookie()
c["stored_info"] = ""
c["stored_info"]["path"] = '/'
c["stored_info"]["expires"] = 'Thu, 01 Jan 1970 00:00:00 GMT'

print(c.output())
print("Location: state-python-view.py\n")