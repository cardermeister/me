from __future__ import print_function
import sys
sys.path.insert(0, 'D:\\py\\wrapper')
from PIL import ImageGrab
import time
from AutoHotPy import AutoHotPy
from InterceptionWrapper import InterceptionMouseState,InterceptionMouseStroke,InterceptionMouseFlag

while(True):
    hp=0
    hp_full=0
    image = ImageGrab.grab()
    for x in range(140+1, 475-1, 10):
        color = image.getpixel((x, 65))
        hp_full+=1.0
        if color[0]>100:
            hp+=1.0

    if hp/hp_full<0.6:
        autohotpy = AutoHotPy()
        autohotpy.sleep(0.1) 
        autohotpy.SPACE.down()
        autohotpy.sleep() 
        autohotpy.SPACE.up()
        autohotpy.sleep(0.2)
    time.sleep(0.5)
