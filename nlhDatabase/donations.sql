CREATE TABLE donations (
    donation_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    donation_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    message TEXT,
    FOREIGN KEY (user_id) REFERENCES users(user_id) 
);








