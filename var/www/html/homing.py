import sys
import os
sys.path.insert(0, os.path.abspath('.'))

from lib.interface import Interface
from time import sleep

bot = Interface('/dev/ttyUSB0')

print('Bot status:', 'connected' if bot.connected() else 'not connected')

params = bot.get_homing_paramaters()
print('Params:', params)

print('Homing')
bot.set_homing_command(0)
sleep(4)
