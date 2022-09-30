from Crypto.Hash import SHA3_256
from Crypto.Cipher import AES
from Crypto.Util.Padding import pad
from secret import flag

# parameters
N = 66
p = 3
q = 2^20
d = 31


Zx.<x> = ZZ[]

# the multiplication operation used in NTRU
def convolution(f, g):
    return (f * g) % (x^n - 1)

def balancedmod(f, q):
    g = list(((f[i] + q//2) % q) - q//2 for i in range(n))
    return Zx(g)

def invertmodprime(f, p):
    T = Zx.change_ring(Integers(p)).quotient(x^n-1)
    return Zx(lift(1 / T(f)))

def invertmodpowerof2(f, q):
    assert q.is_power_of(2)
    g = invertmodprime(f, 2)
    while True:
        r = balancedmod(convolution(g, f), q)
        if r == 1: return g
        g = balancedmod(convolution(g, 2 - r), q)

def randomdpoly():
    assert d <= n
    result = n*[0]
    for j in range(d):
        while True:
            r = randrange(n)
            if not result[r]: break
        result[r] = 1-2*randrange(2)
    return Zx(result)

def keypair():
    print ("----------------------------------")
    print ("[+] Keypair Generation Start...")
    while True:
        try:
            f = randomdpoly()
            f3 = invertmodprime(f, 3)
            fq = invertmodpowerof2(f, q)
            break
        except:
            pass
    print ("[-] f Generation Finished.")
    g = randomdpoly()
    print ("[-] g Generation Finished.")
    publickey = balancedmod(3 * convolution(fq,g), q)
    secretkey = f, f3
    return publickey, secretkey


def encrypt(message, publickey):
    r = randomdpoly()
    return balancedmod(convolution(publickey, r) + message, q)

def randommessage():
    result = list(randrange(3) - 1 for j in range(n))
    return Zx(result)

def decrypt(ciphertext,secretkey):
    f, f3 = secretkey
    a = balancedmod(convolution(ciphertext,f), q)
    return balancedmod(convolution(a, f3), 3)

def attack(publickey):
    recip3 = lift(1/Integers(q)(3))
    publickeyover3 = balancedmod(recip3 * publickey, q)
    M = matrix(2 * n)
    for i in range(n):
        M[i, i] = q
    for i in range(n):
        M[i+n, i+n] = 1
        c = convolution(x^i, publickeyover3)
        for j in range(n):
            M[i+n, j] = c[j]
    M = M.LLL()
    for j in range(2 * n):
        try:
            f = Zx(list(M[j][n:]))
            f3 = invertmodprime(f, 3)
            return (f, f3)
        except:
            pass
    return (f, f)

def toStr(n, base):
    convString = "0123456789ABCDEF"
    if n < base:
        return convString[n]
    else:
        return toStr(n//base,base) + convString[n%base]

n = 7
q = 256
d = 5

publickey, secretkey = keypair()

donald = attack(publickey)

try:
    # m = randommessage()
    flag = "a"
    tmp = []
    for i in flag:
        tmp_m = list(toStr(ord(i), 3))[::-1]
        length = len(tmp_m)
        if length < 6:
            tmp_m.extend((6-length)*['0'])
        tmp.extend(tmp_m)
    initial_m = Zx(tmp)
    for i in range(len(tmp)):
        if tmp[i] == '2':
            tmp[i] = '-1'
    m = Zx(tmp)
    c = encrypt(m, publickey)
    res = decrypt(c, donald)
    assert res == m
    print ("[-] Attack successfully finished.")
except:
    print ("[x] Attack was unsuccessful.")



m_coeff = res.list()
coeff = m_coeff[::-1]

if len(coeff)%6 != 0:
    coeff = (6 - len(coeff)%6)*[0] + coeff

for i in range(len(coeff)):
    if coeff[i] == -1:
        coeff[i] = 2

message = ""
for i in range(1):
    tmp_m = chr(int(''.join(str(i) for i in coeff[i*6:i*6+6]), 3))
    message += tmp_m

print ("[*] Plaintext is {}.".format(message[::-1]))