CREATE TABLE sponsorships (
    sponsorship_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT NOT NULL,
    sponsorship_amount DECIMAL(10, 2) NOT NULL CHECK (sponsorship_amount > 0), 
    sponsorship_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('active', 'inactive', 'expired', 'canceled') DEFAULT 'active', 
    renewal_date DATETIME,
    sponsorship_type ENUM('one-time', 'recurring') DEFAULT 'one-time',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP, 
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (cat_id) REFERENCES cats(cat_id)
);
