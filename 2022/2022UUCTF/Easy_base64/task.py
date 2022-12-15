from flag import flag
import base64
assert flag[0:4] == "flag"
tmp=base64.b64encode(bytes(flag,"utf-8"))
flag=str(tmp)[2:-1]
for i in range(0,len(flag)-1):
    print(ord(flag[i]) ^ ord(flag[i+1]),end=" ")
#55 21 16 50 105 71 14 27 41 30 34 16 50 111 74 62 5 18 54 52 106 85 31 54 24 111 83 11 38 1 53 17 37 17 35 47 32 52 40 2 9 59 47 54 25 111 77 16 48 26 33 9 55 108 0