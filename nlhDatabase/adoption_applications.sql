CREATE TABLE adoption_applications (
    application_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT NOT NULL,
    application_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    application_status ENUM('pending') DEFAULT 'pending',
    age INT,
    occupation VARCHAR(255),
    hear_about VARCHAR(255),
    dwelling VARCHAR(255),
    ownership VARCHAR(255),
    landlord_permission ENUM('yes', 'no'),
    household_people INT,
    other_pets ENUM('yes', 'no'),
    allergies ENUM('yes', 'no'),
    why_interest TEXT,
    preference VARCHAR(255),
    owned_cat_before ENUM('yes', 'no'),
    previous_experience TEXT,
    secure_space ENUM('yes', 'no'),
    hours_alone VARCHAR(255),
    indoor_or_outdoor VARCHAR(255),
    secure_outdoor_area ENUM('yes', 'no'),
    financial_prepared ENUM('yes', 'no'),
    lifetime_commitment ENUM('yes', 'no'),
    regular_care ENUM('yes', 'no'),
    understood_responsibility ENUM('yes', 'no'),
    accuracy_confirm BOOLEAN,
    home_visit_permission BOOLEAN,
    understood_terms BOOLEAN,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (cat_id) REFERENCES cats(cat_id)
); 



INSERT INTO orderprocessing(OrderTotal,CustomerID, OrderStatus, Order_Description, Email, FirstName, LastName, Address, City, Country, PostCode, PhoneNumber)
VALUES ('30','220023', 'Processing', '2x Cerave Foam Cleanser', 'emilyM@yahoo.com', 'Emily', 'Mitchells', '98 Spring Road', 'Birmingham', 'England', 'B10 0AA', '07198842650');

