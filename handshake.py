
#!/usr/bin/env python
# -*- coding: utf-8 -*-
# Unicorny, 2017 (v2)
import serial, time, sys
    
serInsert = serial.Serial()
serSwipe = serial.Serial()
insertRobotTTY = "/dev/ttyInsert"
swipeRobotTTY = "/dev/ttySwipe"

serInsert.port = insertRobotTTY;
serInsert.baudrate = 115200

serSwipe.port = swipeRobotTTY;
serSwipe.baudrate = 9600

response = ""
answer_time = 10

serInsert.open()
serSwipe.open()
serInsert.flushOutput()
serSwipe.flushOutput()


def openPort(port):
	if port.isOpen() == False:
		print("{ \"response\": \"" + port + " port wasn't open\"}")
		exit()

openPort(serInsert)
openPort(serSwipe)	

def waitForRobotReady(port):
	curtime = 0
	response = ""
	while response == "":
		port.flushInput()
		port.write("?")
		time.sleep(1)
		response = port.read(port.inWaiting())
		curtime = curtime + 1
		if curtime > answer_time:
			print ("{\"response\" : \"" + port + " doesn't answer\"")
			exit()

waitForRobotReady(serInsert)
waitForRobotReady(serSwipe)
 
def waitForRobotAnswer(port, msg):
	curtime = 0;
	response = ""
	while response == "":
		curtime = curtime + 1
		response = port.read(port.inWaiting())
		time.sleep(1)
		if curtime > 70:
			response = msg
			break
	
 
# Exchange start from slot 1
response = ""
serInsert.write("l")
serInsert.flushInput()
waitForRobotAnswer(serInsert, "{\"response\": \"Insert robot time out. Exchange start movement\"") 

# Get card from another slot
response = ""
serSwipe.write("6")
serSwipe.flushInput()
waitForRobotAnswer(serSwipe, "{\"response\": \"Swipe robot time out. Get card from another slot movement\"") 

# Exchange wait
response = ""
serInsert.write("d")
serInsert.flushInput()
waitForRobotAnswer(serInsert, "{\"response\": \"Insert robot time out. Exchange wait movement\"") 

# Sweep another robots card
response = ""
serSwipe.write("7")
serSwipe.flushInput()
waitForRobotAnswer(serSwipe, "{\"response\": \"Swipe robot time out. Sweep another robots card movement\"")

# Exchange prepare to return
response = ""
serInsert.write("k")
serInsert.flushInput()
waitForRobotAnswer(serInsert, "{\"response\": \"Insert robot time out. Exchange prepare to return movement\"")  

# Release card
response = ""
serSwipe.write("8")
serSwipe.flushInput()
waitForRobotAnswer(serSwipe, "{\"response\": \"Swipe robot time out. SRelease card movement\"")

# Exchange return to slot 1
response = ""
serInsert.write("m")
serInsert.flushInput()
waitForRobotAnswer(serInsert, "{\"response\": \"Insert robot time out. Exchange return to slot 1 movement\"")  


print("{ \"response\" : \"DONE (Handshake procedure)\"}")


