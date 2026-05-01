<?php
import mysql.connector

def connect_db():
    return mysql.connector.connect(
        host="localhost",  # Change as needed
        user="root",        # Your database username
        password="",        # Your database password
        database="project12"  # Your database name
    )

def login(username, password):
    db = connect_db()
    cursor = db.cursor()
    
    query = "SELECT * FROM users WHERE username = %s AND password = %s"
    cursor.execute(query, (username, password))
    result = cursor.fetchone()
    
    db.close()
    
    if result:
        print("Login successful!")
    else:
        print("Invalid username or password")

# Example usage
if __name__ == "__main__":
    user = input("Enter username: ")
    pwd = input("Enter password: ")
    login(user, pwd)

?>