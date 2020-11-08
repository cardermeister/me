import json
import random
import lab1

def rsa_keys(filename):
  Q = lab1.RandomPrime(32500,45000); P = 2*Q+1; 
  while not(lab1.isPrime(Q) and lab1.isPrime(P)):
    Q = lab1.RandomPrime(32500,45000); P = 2*Q+1; 

  N = Q*P
  fi = (P-1)*(Q-1)

  while True:
    while True:
      d = random.randint(555,fi-1)
      x,y,rez = lab1.gcd(d,fi)
      if rez==1: break
    c=max(x,y)
    if (c*d)%fi==1: break

  fw = open(filename, 'w')
  fw.write(json.dumps({"N":N,"d":d,"c":c}))
  fw.close()

  return filename

def rsa_encode(filepath,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  d=bytesz.get("d")
  N=bytesz.get("N")

  f = open(filepath, 'rb')
  bytesz = f.read()
  strout = ""
  i = 1
  for b in bytesz:
    print(str(i)+"/"+str(len(bytesz)),"RSA")
    i=i+1
    m=ord(b)
    e=lab1.powmod(m,d,N)
    strout=strout+str(e)+"\n"

  filepath = filepath[:-4]+"(RSA)"+filepath[-4:]
  fw = open(filepath, 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filepath
  
def rsa_decode(filepath,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  c=bytesz.get("c")
  N=bytesz.get("N")

  f = open(filepath, 'rb')
  bytesz = f.read()
  strout = ""
  for b in bytesz.splitlines():
    strout=strout+chr(lab1.powmod(int(b),c,N))

  filename = filepath[:-4]+".decrypt"+filepath[-4:]
  fw = open(filename, 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filename

def shamir_keys(filename):
  p = lab1.RandomPrime(3000,5000)
  while not lab1.isPrime(p): p = lab1.RandomPrime(3000,5000)
  while True:
    C_a = random.randint(10, 500)
    x,y,res = lab1.gcd(p-1,C_a);
    if res==1:
      D_a=max(x,y)
      if (D_a*C_a)%(p-1)==1:
        print(C_a,D_a)
        break

  while True:
    C_b = random.randint(10, 500)
    x,y,res = lab1.gcd(p-1,C_b);
    if res==1:
      D_b=max(x,y)
      if (D_b*C_b)%(p-1)==1:
        print(C_b,D_b)
        break
  fw = open(filename, 'w')
  fw.write(json.dumps({"C_a":C_a,"D_a":D_a,"C_b":C_b,"D_b":D_b,"p":p}))
  fw.close()

  return filename

  

def shamir_encode(filename,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  C_a=bytesz.get("C_a")
  C_b=bytesz.get("C_b")
  p=bytesz.get("p")

  f = open(filename, 'rb')
  bytesz = f.read()
  strout = ""
  i = 1
  for b in bytesz:
    print(str(i)+"/"+str(len(bytesz)),"shamir")
    i=i+1
    m=ord(b)
    x1=lab1.powmod(m,C_a,p)
    x2=lab1.powmod(x1,C_b,p)
    strout=strout+str(x2)+"\n"

  filename = filename[:-4]+"(SHAMIR)"+filename[-4:]
  fw = open(filename, 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filename

def shamir_decode(filepath,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  D_a=bytesz.get("D_a")
  D_b=bytesz.get("D_b")
  p=bytesz.get("p")

  f = open(filepath, 'rb')
  bytesz = f.read()
  strout = ""
  for b in bytesz.splitlines():
    x3=lab1.powmod(int(b),D_a,p)
    x4=lab1.powmod(x3,D_b,p)
    strout=strout+chr(x4)

  filename = filepath[:-4]+".decrypt"+filepath[-4:]
  fw = open(filename, 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filename


def el_gamal_keys(filename):
  p = lab1.RandomPrime(32500,45000)
  while not lab1.isPrime(p): p = lab1.RandomPrime(32500,45000)
  g = random.randint(2,p-2)
  while lab1.powmod(g,p/2,p)==1: g = random.randint(2,p-2)


  x = random.randint(2,p-1)
  y = lab1.powmod(g,x,p)

  fw = open(filename, 'w')
  fw.write(json.dumps({"g":g,"x":x,"y":y,"p":p}))
  fw.close()

  return filename
  
def el_gamal_encode(filename,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  x=bytesz.get("x")
  y=bytesz.get("y")
  p=bytesz.get("p")
  g=bytesz.get("g")

  f = open(filename, 'rb')
  bytesz = f.read()
  strout = ""
  i = 1
  for b in bytesz:
    print(str(i)+"/"+str(len(bytesz)),"el-gamal")
    i=i+1
    m=ord(b)
    k = random.randint(2,p-2)
    a=lab1.powmod(g,k,p)
    b=(m%p)*lab1.powmod(y,k,p)%p
    strout=strout+str(a)+" "+str(b)+"\n"

  filename = filename[:-4]+"(ELGAMAL)"+filename[-4:]
  fw = open(filename, 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filename

def el_gamal_decode(filepath,keyfile):

  fk = open(keyfile, 'r')
  bytesz = json.load(fk)
  x=bytesz.get("x")
  p=bytesz.get("p")

  f = open(filepath, 'rb')
  bytesz = f.read()
  strout = ""
  for b in bytesz.splitlines():
    a,b = b.split()
    mes = (int(b)%p)*lab1.powmod(int(a),p-1-x,p)%p
    strout=strout+chr(mes)

  filename = filepath[:-4]+".decrypt"+filepath[-4:]
  
  fw = open(filepath[:-4]+".decrypt"+filepath[-4:], 'w')
  fw.write(strout)
  fw.close()
  f.close()

  return filename


def vernam_encode(filename):
  f = open(filename, 'rb')
  bytesz = f.read()
  key = ""
  e = ""
  for m in bytesz:
    keysh = random.randint(1,255)
    key=key+chr(keysh)
    e=e+chr(ord(m)^keysh)

  fw = open("/mnt/d/pyton/vernam.keys", 'w')
  fw.write(key)
  fw.close()

  filename = filename[:-4]+"(vernam)"+filename[-4:]
  fw = open(filename, 'w')
  fw.write(e)
  fw.close()
  
  return filename,"/mnt/d/pyton/vernam.keys"
  

def vernam_decode(filename,filekey):
  f = open(filekey, 'r')
  key = f.read()

  e = open(filename, 'r')
  e = e.read()

  res = ""

  for i in range(0,len(key)):
    res=res+chr(ord(e[i])^ord(key[i]))

  filename = filename[:-4]+".decrypt"+filename[-4:]

  fw = open(filename, 'w')
  fw.write(res)
  fw.close()
  f.close()
  return filename


if __name__ == "__main__":
  Che_delat = "elgamal"


  if Che_delat == "shamir":
    keyfile = '/mnt/d/pyton/shamir.keys'
    shamir_keys('/mnt/d/pyton/shamir.keys')
    output = shamir_encode('/mnt/d/pyton/1.jpg',keyfile)
    print("Cipher",Che_delat)
    print("Key",keyfile)
    print("Encoded",output)
    print("Decoded",shamir_decode(output,keyfile))

  if Che_delat == "RSA":
    keyfile = '/mnt/d/pyton/rsa.keys'
    rsa_keys(keyfile)
    output = rsa_encode('/mnt/d/pyton/1.jpg',keyfile)
    print("Cipher",Che_delat)
    print("Key",keyfile)
    print("Encoded",output)
    print("Decoded",rsa_decode(output,keyfile))

  if Che_delat == "elgamal":
    keyfile = '/mnt/d/pyton/el-gamal.keys'
    el_gamal_keys(keyfile)
    output = el_gamal_encode('/mnt/d/pyton/1.jpg',keyfile)
    print("Cipher",Che_delat)
    print("Key",keyfile)
    print("Encoded",output)
    print("Decoded",el_gamal_decode(output,keyfile))

  if Che_delat == "vernam":
    output,keyfile = vernam_encode('/mnt/d/pyton/1.jpg')
    print("Cipher",Che_delat)
    print("Key",keyfile)
    print("Encoded",output)
    print("Decoded",vernam_decode(output,keyfile))