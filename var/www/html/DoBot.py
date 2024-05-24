import sys
import os
import argparse
import requests
import json

sys.path.insert(0, os.path.abspath('.'))

from lib.dobot import Dobot
from time import sleep

bot = Dobot('/dev/ttyUSB0')

def print_message (message):
	url = "http://192.168.0.203:8000/set_message"
	# Datele care vor fi trimise prin POST
	data = {
		"message": message
	}

	# Header pentru a specifica faptul că datele sunt în format JSON
	headers = {
		"Content-Type": "application/json"
	}

	# Trimiterea cererii POST
	response = requests.post(url, data=json.dumps(data), headers=headers)


parser = argparse.ArgumentParser()
parser.add_argument('-x', help='coordonata x', type=int)
parser.add_argument('-y', help='coordonata y', type=int)
parser.add_argument('-z', help='coordonata z', type=int)
parser.add_argument('-r', help='rotatia capului', type=float)
parser.add_argument('-s', help='ventuza', type=int)
parser.add_argument('-u', help='user', type=str)
args = parser.parse_args()

#print('Bot status:', 'connected' if bot.connected() else 'not connected')

#pose = bot.get_pose()
#print('Pose:', pose)

#print('Deplasare la coordonate ')
#bot.move_to(20, 20, 20, 0.5)
#print ('X: %2d, Y: %2d, Z: %2d, R: %2d, S: %2d'%(args.x,args.y,args.z,args.r,args.s))
#print_message("User: "+args.u+" Command: Go to home position")
#bot.home()
print_message("User: "+args.u+" Command: Goto X:"+str(args.x)+", Y="+str(args.y)+", Z="+str(args.z)+", R="+str(args.r))
bot.move_to(args.x,args.y,args.z,args.r,True)
sleep(0.5)
print_message("Welcome to Dobot Control Panel!")
