import random
import math

def npowmod(a,b,c):
  z=1
  for i in range(0,b,1):
    z=z*a%c
  return z;


def powmod(base, degree, module):
  degree = bin(degree)[2:]
  r = 1
  
  for i in range(len(degree) - 1, -1, -1):
    r = (r * base ** int(degree[i])) % module
    base = (base ** 2) % module
  
  return r


def RandomPrime(a,b):
  prime = False
  while prime == False:
    n = random.randint(a, b)
    if n % 2 != 0:
      for x in range(3, int(n**0.5), 2):
        if n % x ==0:
          prime = False
        else:
          prime = True
  

  return n

def isPrime(n):
  isit = True

  i = 2
  limit = int(math.sqrt(n))

  while i <= limit:
      if n % i == 0:
          isit = False
          break
      i += 1

  return isit

def gcd(a,b):
  x, xx, y, yy = 1, 0, 0, 1
  while b:
      q = a // b
      a, b = b, a % b
      x, xx = xx, x - xx*q
      y, yy = yy, y - yy*q
  return (x, y, a)
