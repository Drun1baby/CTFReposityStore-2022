from Crypto.Hash import SHA3_256
from Crypto.Cipher import AES
from Crypto.Util.Padding import pad
from secret import flag

# parameters
N = 66
p = 3
q = 2^20
d = 31
assert q>(6*d+1)*p

R.<x> = ZZ[]

#d1 1s and #d2 -1s
def T(d1, d2):
    assert N >= d1+d2
    s = [1]*d1 + [-1]*d2 + [0]*(N-d1-d2)
    shuffle(s)
    return R(s)

def invertModPrime(f, p):
    Rp = R.change_ring(Integers(p)).quotient(x^N-1)
    return R(lift(1 / Rp(f)))

def convolution(f, g):
    return (f*g) % (x^N-1)

def liftMod(f, q):
    g = list(((f[i] + q//2) % q) - q//2 for i in range(N))
    return R(g)

def polyMod(f, q):
    g = [f[i]%q for i in range(N)]
    return R(g)

def invertModPow2(f, q):
    assert q.is_power_of(2)
    g = invertModPrime(f,2)
    while True:
        r = liftMod(convolution(g,f),q)
        if r == 1: return g
        g = liftMod(convolution(g,2 - r),q)

def genMessage():
    result = list(randrange(p) - 1 for j in range(N))
    return R(result)

def genKey():
  while True:
    try:
      f = T(d+1, d)
      g = T(d, d)
      Fp = polyMod(invertModPrime(f, p), p)
      Fq = polyMod(invertModPow2(f, q), q)
      break
    except:
      continue
  h = polyMod(convolution(Fq, g), q)
  return h, (f, g)

def encrypt(m, h):
  e = liftMod(p*convolution(h, T(d, d)) + m, q)
  return e

# Step 1
h, secret = genKey()
m = genMessage()
e = encrypt(m, h)

print('h = %s' % h)
print('e = %s' % e)

# Step 2
sha3 = SHA3_256.new()
sha3.update(bytes(str(m).encode('utf-8')))
key = sha3.digest()

cypher = AES.new(key, AES.MODE_ECB)
c = cypher.encrypt(pad(flag, 32))
print('c = %s' % c)

