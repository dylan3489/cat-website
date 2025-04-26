CREATE TABLE users (
    user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    date_of_birth DATE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15),
    street_address VARCHAR(255) NOT NULL,
    city VARCHAR(100),
    post_code VARCHAR(20) NOT NULL,
    user_type ENUM('general', 'admin') DEFAULT 'general',
    admin_key CHAR(7),
    admin_status BOOLEAN NOT NULL,
    registration_date DATETIME DEFAULT CURRENT_TIMESTAMP
);


INSERT INTO accountdetails (Customer_ID, FirstName, Surname, MobileNumber, Email, CustomerAddress, DateOfBirth, Admin_ID, AdminStatus)
VALUES ('220021','Ellen', 'Smith', '07456128791', 'ellen12@gmail.com', 
        '44 Springfield Road, Birmingham, B12 3BE', '1982/01/09', '109817', '1');  


INSERT INTO accountdetails (FirstName, Surname, MobileNumber, Email, CustomerAddress, DateOfBirth, Admin_ID, AdminStatus)                         
VALUES('Bob', 'Stone', '07129844651', 
       'stone@yahoo.com', 
       '102 Yardley Road , Coventry, CV12 9RU', '1987/09/15', 
       '909987', '1');    


INSERT INTO accountdetails (FirstName, Surname, MobileNumber, Email, CustomerAddress, DateOfBirth, Admin_ID, AdminStatus)                         
VALUES('Emily', 'Mitchells', '07198842650', 
       'emilyM@yahoo.com', 
       '98 Spring Road, Birmingham, B10 0AA', '1990/05/01', '',
       '0');  




