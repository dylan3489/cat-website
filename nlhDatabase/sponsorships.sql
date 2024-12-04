CREATE TABLE sponsorships (
    sponsorship_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT NOT NULL,
    sponsorship_amount DECIMAL(10, 2) NOT NULL,
    sponsorship_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (cat_id) REFERENCES cats(cat_id)
);
