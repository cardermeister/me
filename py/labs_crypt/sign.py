import crypt
import hashlib
import json
import lab1
import random


def rsa_sign(filename,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  c=bytesz.get("c")
  N=bytesz.get("N")

  f = open(filename, 'rb')
  bytesz = f.read()
  strout = ""
  i = 1
  hashed = hashlib.sha256(bytesz).hexdigest()
  for b in hashed:
    i=i+1
    m=ord(b)
    e=lab1.powmod(m,c,N)
    strout=strout+str(e)+"\n"

  filename = filename[:-4]+".rsa"
  fw = open(filename, 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filename

def rsa_sign_check(filename,filesign,keyfile):
    
    fk = open(keyfile, 'r')
    bytesz = json.load(fk)
    d=bytesz.get("d")
    N=bytesz.get("N")
    
    f = open(filename, 'rb')
    bytesz = f.read()
    strout = ""
    i = 1
    hashed = hashlib.sha256(bytesz).hexdigest()
    
    f = open(filesign, 'rb')
    bytesz = f.read()
    for b in bytesz.splitlines():
        strout=strout+chr(lab1.powmod(int(b),d,N))

    return strout==hashed

def el_gamal_sign(filename,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  x=bytesz.get("x")
  y=bytesz.get("y")
  p=bytesz.get("p")
  g=bytesz.get("g")

  f = open(filename, 'rb')
  bytesz = f.read()
  hashed = hashlib.sha256(bytesz).hexdigest()
  strout = ""

  for b in hashed:
    m=ord(b)
    k = random.randint(2,p-2)
    xxx,yyy,res = lab1.gcd(k,p-1)
    while res!=1: 
      k = random.randint(2,p-2)
      xxx,yyy,res = lab1.gcd(k,p-1)

    r = lab1.powmod(g,k,p)

    if (m - x*r < 0):
      u = (p-1) - ((x*r - m)%(p-1))
    else:
      u = (m - x*r)%(p-1)

    s = (xxx*u)%(p-1)

    strout=strout+str(r)+" "+str(s)+"\n"
  
  filename = filename[:-4]+".elgamal"
  fw = open(filename, 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filename


def el_gamal_check(filename,filesign,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  y=bytesz.get("y")
  p=bytesz.get("p")
  g=bytesz.get("g")

  f = open(filesign, 'rb')
  bytesz = f.read()

  f2 = open(filename, 'rb')
  bytesz2 = f2.read()
  hashed = hashlib.sha256(bytesz2).hexdigest()
  
  i=0
  for b in bytesz.splitlines():
    r = int(b.split()[0])
    s = int(b.split()[1])
    
    l3 = (lab1.powmod(y,r,p)*lab1.powmod(r,s,p))%p;
    l4 = lab1.powmod(g,ord(hashed[i]),p);
    i=i+1
    if l3!=l4:
      return False

  return True


  


def gost_sign(filename,filenamekeys):
  f = open(filename, 'rb')
  bytesz = f.read()
  hashed = hashlib.sha256(bytesz).hexdigest()
  q = lab1.RandomPrime(32500,45000)
  while not lab1.isPrime(q): q = lab1.RandomPrime(32500,45000)
  i=1
  p = i*q+1
  while not lab1.isPrime(p):
    p = i*q+1
    i=i+1

  g = random.randint(2, 1000000000)
  a = lab1.powmod(g,(p-1)/q,p)
  while not a>1:
    g = random.randint(2, 1000000000)
    a = lab1.powmod(g,(p-1)/q,p)

  x = random.randint(1, q)
  y = lab1.powmod(a,x,p)
  
  strout = ""
  for b in hashed:
    m=ord(b)
    k = random.randint(1, q - 1)
    r = lab1.powmod(a, k, p) % q
    s = (k*m + x*r) % q
    while not (r != 0 and s != 0):
      k = random.randint(1, q - 1)
      r = lab1.powmod(a, k, p) % q
      s = (k*m + x*r) % q
    strout=strout+str(r)+" "+str(s)+"\n"
    
  filename = filename[:-4]+".gost"
  fw = open(filename, 'w')
  fw.write(strout)
  fw.close()

  fw = open(filenamekeys, 'w')
  fw.write(json.dumps({"q":q,"a":a,"y":y,"p":p}))
  fw.close()

def gost_check(filename,filenamehash,filenamekeys):
  fk = open(filenamekeys, 'r')
  bytesz = json.load(fk)
  y=bytesz.get("y")
  p=bytesz.get("p")
  q=bytesz.get("q")
  a=bytesz.get("a")

  f = open(filename, 'rb')
  bytesz = f.read()
  hashed = hashlib.sha256(bytesz).hexdigest()

  f = open(filenamehash, 'rb')
  bytesz = f.read()
  i=0
  for b in bytesz.splitlines():
    r = int(b.split()[0])
    s = int(b.split()[1])

    xxx,yyy,res = lab1.gcd(ord(hashed[i]),q)
    if xxx<0: xxx = xxx + q
    
    u1 = (s * xxx)%q
    u2 = q - ((r * xxx)%q)
    v = ((lab1.powmod(a, u1, p) * lab1.powmod(y, u2, p)) % p ) % q
    i=i+1
    if v!=r:
      return False

  return True

if __name__ == "__main__":
  Che_delat = "RSA"

if Che_delat == "RSA":
    crypt.rsa_keys("/mnt/d/pyton/sign.keys")
    rsa_sign("/mnt/d/pyton/labs.pdf","/mnt/d/pyton/sign.keys")
    if rsa_sign_check("/mnt/d/pyton/labs.pdf","/mnt/d/pyton/labs.rsa","/mnt/d/pyton/sign.keys"):
        print("Sign equals")
    else:
        print("Sign not equals")

if Che_delat == "elgamal":
    crypt.el_gamal_keys("/mnt/d/pyton/elgamal.keys")
    el_gamal_sign("/mnt/d/pyton/labs.pdf","/mnt/d/pyton/elgamal.keys")
    print(el_gamal_check("/mnt/d/pyton/labs.pdf","/mnt/d/pyton/labs.elgamal","/mnt/d/pyton/elgamal.keys"))

if Che_delat == "gost":
    gost_sign("/mnt/d/pyton/labs.pdf","/mnt/d/pyton/gost.keys")
    print(gost_check("/mnt/d/pyton/labs.pdf","/mnt/d/pyton/labs.gost","/mnt/d/pyton/gost.keys"))