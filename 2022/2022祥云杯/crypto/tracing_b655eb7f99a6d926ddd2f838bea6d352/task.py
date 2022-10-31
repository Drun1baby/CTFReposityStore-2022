from secret import p, q, flag
from Crypto.Util.number import bytes_to_long

def gcd(a, b):
    s = 0
    while b != 0:
        print(a, b)
        if isOdd(a):
            if isOdd(b):
                a = a - b
                a = rshift1(a)
                if a < b:
                    a, b = b, a
            else:
                b = rshift1(b)
                if a < b:
                    a, b = b, a
        else:
            if isOdd(b):
                a = rshift1(a)
                if a < b:
                    a, b = b, a
            else:
                a = rshift1(a)
                b = rshift1(b)
                s += 1
    if s:
        return lshift(a, s)
    return a

def isOdd(a):
    return a & 1 == 1

def rshift1(a):
    return a >> 1

def lshift(a, s):
    return a << s


n = p * q
e = 65537
phi = (p - 1) * (q - 1)
assert gcd(phi, e) == 1
c = pow(bytes_to_long(flag), e, n)
print(c)
print(n)
