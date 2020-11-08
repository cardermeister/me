import sys
sys.path.insert(0, 'D:\\py\\wrapper')
from PIL import ImageGrab
import numpy as np
import os
import array
import time
import cv2
from AutoHotPy import AutoHotPy
from InterceptionWrapper import InterceptionMouseState,InterceptionMouseStroke,InterceptionMouseFlag
from bresenham import bresenham
import threading
import random

def get_screen(x1, y1, x2, y2):
    #box = (x1 + 8, y1 + 30, x2 - 8, y2) #if window
    box = (x1, y1, x2, y2)
    screen = ImageGrab.grab(box)
    img = np.array(screen.getdata(), dtype=np.uint8).reshape((screen.size[1], screen.size[0], 3))
    return img


def exitAutoHotKey(autohotpy,event):
    """
    exit the program when you press ESC
    """
    autohotpy.stop()

def moveMouseToPosition(self, x, y):
        width_constant = 65535.0/float(self.user32.GetSystemMetrics(0)) # 1920*2
        height_constant = 65535.0/float(self.user32.GetSystemMetrics (1)) 
        # move mouse to the specified position
        stroke = InterceptionMouseStroke()
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_MOVE
        stroke.flags = InterceptionMouseFlag.INTERCEPTION_MOUSE_MOVE_ABSOLUTE
        stroke.x = int(float(x)*width_constant)
        stroke.y = int(float(y)*height_constant)
        self.sendToDefaultMouse(stroke)
        
def smooth_move(autohotpy, x, y):
    
    (startX, startY) = autohotpy.getMousePosition() 
    coordinates = bresenham(startX, startY, x, y)#draw_line(startX, startY, x, y)
    x = 0 
    for dot in coordinates:
        x += 1
        if x % 2 == 0 and x % 3 == 0:
            time.sleep(0.01)
        moveMouseToPosition(autohotpy,dot[0], dot[1])

def click_on_pos(autohotpy,event,x,y):
        # time.sleep(0.02)
        smooth_move(autohotpy,x + random.randint(-25, 26), y + random.randint(-4, 4))
        stroke = InterceptionMouseStroke()
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_DOWN
        autohotpy.sendToDefaultMouse(stroke)
        autohotpy.sleep(0.1) 
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_UP
        autohotpy.sendToDefaultMouse(stroke)
        autohotpy.sleep(0.3)
        smooth_move(autohotpy,958 + random.randint(-45, 46), 335 + random.randint(-14, 14))
        autohotpy.sleep(0.1)
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_DOWN
        autohotpy.sendToDefaultMouse(stroke)
        autohotpy.sleep(0.1) 
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_UP
        autohotpy.sendToDefaultMouse(stroke)
        autohotpy.sleep(0.3)

def do_reload(autohotpy,event):
        smooth_move(autohotpy,812 + random.randint(-25, 26), 775 + random.randint(-4, 4))
        stroke = InterceptionMouseStroke()
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_DOWN
        autohotpy.sendToDefaultMouse(stroke)
        autohotpy.sleep(0.1) 
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_UP
        autohotpy.sendToDefaultMouse(stroke)
        autohotpy.sleep(0.3)

def potik(autohotpy,event):
    global prcss
    prcss = not prcss
    if prcss:
        t = threading.Thread(target=press_torg, args=(autohotpy,event))
        t.daemon = True
        t.start()


def do_somprcss(autohotpy,event,img,tresh,img_rgb,img_gray,space,desc):
    template = cv2.imread(img,0) #<-ITEM IMAGE
    w, h = template.shape[::-1]
    res = cv2.matchTemplate(img_gray,template,cv2.TM_CCOEFF_NORMED)
    threshold = tresh
    loc = np.where( res >= threshold)
    for pt in zip(*loc[::-1]):
        #cv2.rectangle(img_rgb, pt, (pt[0] + w, pt[1] + h), (0,0,255), 2)
        smooth_move(autohotpy,454 + pt[0] + w/2 + random.randint(-25, 26), 164 + pt[1] + h/2 + random.randint(-8, 8))
        print("["+time.strftime("%c")+"] "+desc)
        time.sleep(0.01)
        stroke = InterceptionMouseStroke()
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_DOWN
        autohotpy.sendToDefaultMouse(stroke)
        autohotpy.sleep(0.1) 
        stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_LEFT_BUTTON_UP
        autohotpy.sendToDefaultMouse(stroke)
        time.sleep(0.3)
        if space:
                autohotpy.sleep(0.1) 
                autohotpy.SPACE.down()
                autohotpy.sleep() 
                autohotpy.SPACE.up()
                autohotpy.sleep(0.2)

def press_torg(autohotpy,event):
    global prcss
    abspath = os.path.dirname(os.path.abspath(__file__)) + os.path.sep
    increment=0

    while(prcss):
        #958 335
        increment+=1
        img_rgb = get_screen(454,164,1464,871)

        img_gray = cv2.cvtColor(img_rgb, cv2.COLOR_BGR2GRAY)

        do_somprcss(autohotpy,event,abspath+"test\\tort.png",0.58,img_rgb,img_gray,True,"TORG")
        do_somprcss(autohotpy,event,abspath+"test\\max_check.png",0.45,img_rgb,img_gray,False,"MAXSTAVKA")
        
        for scrl in range(8):
                stroke = InterceptionMouseStroke()
                stroke.state = InterceptionMouseState.INTERCEPTION_MOUSE_WHEEL
                stroke.rolling = -1
                autohotpy.sendToDefaultMouse(stroke)
                autohotpy.sleep(0.1) 

        img_rgb = get_screen(454,164,1464,871)
        img_gray = cv2.cvtColor(img_rgb, cv2.COLOR_BGR2GRAY)

        do_somprcss(autohotpy,event,abspath+"test\\tort.png",0.58,img_rgb,img_gray,True,"TORG")
        do_somprcss(autohotpy,event,abspath+"test\\max_check.png",0.45,img_rgb,img_gray,False,"MAXSTAVKA")

        """
        time.sleep(random.random()+1)
        do_reload(autohotpy,event)

        time.sleep(random.random())
        img_rgb = get_screen(454,164,1464,871)
        img_gray = cv2.cvtColor(img_rgb, cv2.COLOR_BGR2wGRAY)
        do_somprcss(autohotpy,event,abspath+"test\\max_check.png",0.45,img_rgb,img_gray,False,"MAXSTAVKA")
        """

        time.sleep(random.random())
        
        if increment==1:
                click_on_pos(autohotpy,event,1546,625)
        elif increment==2:
                click_on_pos(autohotpy,event,1559,662)
        #elif increment==3:
        #        click_on_pos(autohotpy,event,1560,662+35)
        else:
             increment=0   
        

        time.sleep(random.random()/2)
    


if __name__=="__main__":
    auto = AutoHotPy()
    prcss = False
    auto.registerExit(auto.ESC,exitAutoHotKey)   # Registering an end key is mandatory to be able tos top the program gracefully
    auto.registerExit(auto.F1,potik)
    # lets switch right and left mouse buttons!
    #auto.registerForMouseMovement(moveHandler)

    auto.start()