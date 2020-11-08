#!/usr/bin/python
# -*- coding: utf-8 -*-
import lab1
import copy 
import random


deck = ["","","",""]
for i in range(2,15):
    if i==11: i="J"
    if i==12: i="Q"
    if i==13: i="K"
    if i==14: i="A"
    deck.append(str(i)+"♥")
    deck.append(str(i)+"♦")
    deck.append(str(i)+"♣")
    deck.append(str(i)+"♠")


def getPubKeys():
    Q = lab1.RandomPrime(100000000,1000000000); P = 2*Q+1; 
    while not(lab1.isPrime(Q) and lab1.isPrime(P)):
        Q = lab1.RandomPrime(100000000,1000000000); P = 2*Q+1; 

    return P

def getPrivateKeys(P):
    C = random.randint(2, P-2)
    D,yyy,res = lab1.gcd(C,P-1)
    while res!=1 or D<0: 
        C = random.randint(2, P-2)
        D,yyy,res = lab1.gcd(C,P-1)

    return C,D
    

P = getPubKeys()

m=2
n=23
Ruki = {}
Ki = []
for i in deck:
    if i=="": continue
    Ki.append(deck.index(i))
Ci = []
Di = []

for i in range(0,n):
    C,D = getPrivateKeys(P)
    for i in Ki:
        Ki[Ki.index(i)] = lab1.powmod(i,C,P)
    random.shuffle(Ki)
    Ci.append(C)
    Di.append(D)

for i in range(0,n):
    Ruki[i] = []
    for j in range(0,m):
        temp = Ki.pop()
        while temp=="": temp = Ki.pop()
        Ruki[i].append(temp)


Stol = []
for j in range(0,5):
    temp = Ki.pop()
    while temp=="": temp = Ki.pop()
    Stol.append(temp)

print(Stol)
print(Ruki)

RukiDecrypt = copy.copy(Ruki)
for i in range(0,n):
    for j in range(0,n):
        if i==j: continue
        for k in range(0,m):
            RukiDecrypt[i][k] = lab1.powmod(RukiDecrypt[i][k],Di[j],P)

print(RukiDecrypt) 

for i in range(0,n):
    cards = RukiDecrypt[i]
    print("Игрок #"+str(i)+": ")
    for k in cards:
        print("\t"+deck[lab1.powmod(k,Di[i],P)]+" ("+str(k)+")")

print("Стол: ")
for i in range(0,n):
    for k in range(0,5):
        Stol[k] = lab1.powmod(Stol[k],Di[i],P)

for k in range(0,5): Stol[k] = deck[Stol[k]]
print(' '.join(Stol))
