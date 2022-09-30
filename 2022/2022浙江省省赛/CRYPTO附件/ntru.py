from Crypto.Util.number import *
from Crypto.Hash import SHA3_256
from Crypto.Cipher import AES
from Crypto.Util.Padding import unpad

n = 66
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
    publickey = balancedmod(convolution(fq,g), q)
    secretkey = f, f3
    return publickey, secretkey


def encrypt(message, publickey):
    r = randomdpoly()
    return balancedmod(3*convolution(publickey, r) + message, q)

def randommessage():
    result = list(randrange(3) - 1 for j in range(n))
    return Zx(result)

def decrypt(ciphertext,secretkey):
    f, f3 = secretkey
    a = balancedmod(convolution(ciphertext,f), q)
    return balancedmod(convolution(a, f3), 3)

def attack(publickey):
    recip3 = lift(1/Integers(q)(1))
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

h = 847417*x^65 + 149493*x^64 + 671215*x^63 + 940073*x^62 + 422433*x^61 + 906071*x^60 + 661777*x^59 + 213093*x^58 + 776476*x^57 + 308727*x^56 + 199931*x^55 + 256166*x^54 + 201216*x^53 + 964303*x^52 + 961341*x^51 + 216401*x^50 + 503421*x^49 + 391011*x^48 + 724233*x^47 + 834103*x^46 + 534483*x^45 + 145755*x^44 + 31514*x^43 + 633909*x^42 + 611687*x^41 + 656421*x^40 + 51098*x^39 + 23193*x^38 + 874589*x^37 + 481483*x^36 + 772432*x^35 + 596655*x^34 + 924673*x^33 + 790137*x^32 + 711581*x^31 + 795565*x^30 + 179559*x^29 + 974401*x^28 + 252177*x^27 + 712781*x^26 + 292518*x^25 + 556867*x^24 + 247625*x^23 + 131231*x^22 + 545208*x^21 + 774544*x^20 + 810813*x^19 + 997461*x^18 + 951783*x^17 + 778973*x^16 + 225243*x^15 + 241753*x^14 + 419437*x^13 + 1013119*x^12 + 847743*x^11 + 60647*x^10 + 477291*x^9 + 674781*x^8 + 245115*x^7 + 745149*x^6 + 280553*x^5 + 298381*x^4 + 849205*x^3 + 541486*x^2 + 720005*x + 21659
e = -34408*x^65 - 271875*x^64 - 72324*x^63 - 146782*x^62 - 191501*x^61 + 228014*x^60 - 236704*x^59 - 162996*x^58 - 93476*x^57 + 438756*x^56 - 340498*x^55 - 177073*x^54 + 309787*x^53 + 287611*x^52 - 13370*x^51 - 189635*x^50 + 271391*x^49 + 215846*x^48 - 286021*x^47 + 215770*x^46 + 259901*x^45 - 9022*x^44 - 410163*x^43 + 187965*x^42 - 99716*x^41 + 150105*x^40 + 161841*x^39 - 24872*x^38 - 288722*x^37 + 263847*x^36 + 142479*x^35 - 355131*x^34 - 181543*x^33 - 379836*x^32 + 206610*x^31 - 264717*x^30 - 381231*x^29 + 346552*x^28 - 59454*x^27 - 38411*x^26 - 200819*x^25 + 271459*x^24 + 169671*x^23 - 494515*x^22 - 250245*x^21 + 28462*x^20 + 485002*x^19 - 252744*x^18 + 301433*x^17 + 116488*x^16 - 359247*x^15 + 472604*x^14 + 16539*x^13 - 207870*x^12 - 137611*x^11 - 379327*x^10 + 477482*x^9 + 447007*x^8 - 368776*x^7 - 488265*x^6 - 312305*x^5 - 17292*x^4 + 372405*x^3 + 288980*x^2 + 95015*x - 99099
c = b"\x90\xd4D\xd0\x0e\x19\x04\xd2]\xd5k\x0c&\xeas\xf42T\x89\x02\x10\xa7\x1b\x04aR|<,\xa8J/\x86\xdf@wW&\xf3\x1c}\x0e\xe1\xa4\xc4'\xffw\xc8\xcaT+\x10\xacR\xc0N\x99\x83\x1d}F\x0f\x99"

sk = attack(h)
m=decrypt(e,sk)
sha3 = SHA3_256.new()
sha3.update(bytes(str(m).encode('utf-8')))
key = sha3.digest()
cipher = AES.new(key, AES.MODE_ECB)
flag=cipher.decrypt(c)
flag=unpad(flag,32)
print(flag)

#b'DASCTF{c4d2a7a2-1b1d-4ccb-95e6-655313e5a416}'