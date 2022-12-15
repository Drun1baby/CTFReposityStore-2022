from Crypto.Util.number import *
from flag import flag
import random

text = 'aCdhpnlmNKuRJbfVIXUvyTrSPqjBMzgwHZkAxWGiYetEsocDLFOQ'

def Affline_Encode(plain, a, b):
	cipher = ''
	for i in plain:
		if i not in text:
			cipher += i
		else:
			x = text.find(i)
			cipher += text[(x*a + b) % len(text)]

	return cipher

while True:
	a=random.randint(1<<99, 1<<100)
	b=random.randint(1<<99, 1<<100)
	if GCD(a,52) == 1:
		break

assert flag[:6]=='DASCTF'
print(Affline_Encode(flag, a, b))
# cipher = 'CezmBh{BKDdD_oP_rKD_rdtF_cMHu}'