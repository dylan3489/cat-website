CREATE TABLE queries( 
user_id INT NULL, 
query_ref INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
first_name VARCHAR(255) NOT NULL,
last_name VARCHAR(255) NOT NULL, 
email VARCHAR(255) UNIQUE NOT NULL, 
query_description TEXT NOT NULL, 
FOREIGN KEY (user_id) REFERENCES users(user_id)); 




