from __future__ import print_function
import sys
sys.path.insert(0, 'D:\\py\\wrapper')
from PIL import ImageGrab
import numpy as np
import os
import array
import cv2
import time
from AutoHotPy import AutoHotPy
from InterceptionWrapper import InterceptionMouseState,InterceptionMouseStroke,InterceptionMouseFlag
import random

def exitAutoHotKey(autohotpy,event):

    if (autohotpy.LEFT_CTRL.isPressed() & autohotpy.LEFT_ALT.isPressed()): 
        autohotpy.stop()
    else:
        autohotpy.sendToDefaultKeyboard(event)

def get_screen(x1, y1, x2, y2):
    #box = (x1 + 8, y1 + 30, x2 - 8, y2) #if window
    box = (x1, y1, x2, y2)
    screen = ImageGrab.grab(box)
    img = np.array(screen.getdata(), dtype=np.uint8).reshape((screen.size[1], screen.size[0], 3))
    return img


def runcode(autohotpy,event):

    time.sleep(1)
    autohotpy.SPACE.down()
    autohotpy.sleep() 
    autohotpy.SPACE.up()
    autohotpy.sleep(1.675+random.random()/7)
    autohotpy.SPACE.down()
    autohotpy.sleep() 
    autohotpy.SPACE.up()
    time.sleep(2.5)
    print("GACHA")
    img = get_screen(770,347,1139,412);
    ret, img = cv2.threshold(img, 120, 255, cv2.THRESH_TOZERO)

    time.sleep(0.4)
    for i in range(8):
        ilonMask = get_screen(770,347,1139,412);
        ret, ilonMask = cv2.threshold(ilonMask, 120, 255, cv2.THRESH_TOZERO)
        img = cv2.multiply(ilonMask,img)
        time.sleep(0.2)

    ret, img = cv2.threshold(img, 120, 255, cv2.THRESH_BINARY)
    cv2.imwrite('D:\\py\\end.png',img)
    img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
    cv2.imwrite('D:\\py\\endgray.png',img)
    

    keyz={}
    keyz["W"]=autohotpy.W
    keyz["A"]=autohotpy.A
    keyz["S"]=autohotpy.S
    keyz["D"]=autohotpy.D

    trigz = ["D:\\py\\left.png","D:\\py\\right.png", "D:\\py\\up.png", "D:\\py\\down.png"]

    mvs = ["A","D","W","S"]
    kod = {}
    ok = False
    
    for i in range(4):
        template = cv2.imread(trigz[i],0)
        w, h = template.shape[::-1]

        res = cv2.matchTemplate(img,template,cv2.TM_CCOEFF_NORMED)
        threshold = 0.8
        loc = np.where( res >= threshold)
        for pt in zip(*loc[::-1]):
            ok = True
            cv2.putText(img, mvs[i], (pt[0] + w, pt[1] + h), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (255, 255, 255), lineType=cv2.LINE_AA)
            kod[pt[0] + w] = mvs[i]

    hax = 0;

    cv2.imwrite('D:\\py\\endim.png',img)

    for i in sorted(kod):
    
        if (i-hax)>5: 
            print(kod[i],end='')
            keyz[kod[i]].down()
            autohotpy.sleep(0.13) 
            keyz[kod[i]].up()
            autohotpy.sleep(0.13) 
            ok=True
        else:
            print("ignoring",kod[i])

        hax=i       

    print("")

    autohotpy.sleep(2.765) 
    autohotpy.R.down()
    autohotpy.sleep(0.2) 
    autohotpy.R.up()
    autohotpy.sleep(0.854) 
    autohotpy.R.down()
    autohotpy.sleep(0.13) 
    autohotpy.R.up()
    autohotpy.sleep(0.13)
    autohotpy.SPACE.down()
    autohotpy.sleep(0.2) 
    autohotpy.SPACE.up()
    autohotpy.sleep() 

    if not ok:
        print("FAIL")

    

if __name__=="__main__":
    auto = AutoHotPy()
    auto.registerExit(auto.Z,exitAutoHotKey)

    auto.registerForKeyDown(auto.X,runcode)   
    auto.start()

