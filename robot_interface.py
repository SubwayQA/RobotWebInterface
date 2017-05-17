#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Unicorny, 2017 (v3)
import serial, time, sys
    
# Get the arguments list 
robotName = str(sys.argv[1])
command = str(sys.argv[2])

ser = serial.Serial()
tty = "Unknown robot"
if robotName == "Swipe":
	tty = "/dev/ttySwipe"
if robotName == "Insert":
	tty = "/dev/ttyInsert"
if robotName == "Tap":
	tty = "/dev/ttyTap"
if robotName == "Tapster":
	tty = "/dev/ttyTapster"
ser.port = tty;
ser.baudrate = 9600	 
response = ""
curtime = 0
answer_time = 10
if robotName == "Insert":
	ser.baudrate = 115200

ser.open()


ser.flushOutput()

if ser.isOpen() == False:
	print("{ \"response\": \"Port wasn't open\"}")
	exit()

while response == "":
	ser.flushInput()
	ser.write("?")
	time.sleep(1)
	response = ser.read(ser.inWaiting())
	curtime = curtime + 1
	if curtime > answer_time:
		print ("{ \"response\": \"Robot doesn't answer\"}")
		exit()
		
curtime = 0
response = ""

ser.flushInput() 
ser.write(command)
command_len = len(command)

for i in range(command_len):
	cur_time = 1
	response = ""
	while response == "":
		curtime = curtime + 1
		response = ser.read(ser.inWaiting())
		time.sleep(1)
		if curtime > 70:
			response = "Robot time out. Probably the wrong command was sent ( " + command + " )"
			break


time.sleep(1)
if robotName == "Tapster" and command != "?":
    print("{\"response\" : \"DONE (Tapster robot entered " + command + " (" + str(command_len) + " movements))\"}")
else:
    print("{ \"response\" : \"" + response + "\"}")



