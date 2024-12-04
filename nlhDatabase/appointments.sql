CREATE TABLE appointments (
    appointment_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT NOT NULL,
    appointment_date DATETIME NOT NULL,
    vet_name VARCHAR(255),
    status ENUM('pending','scheduled', 'completed', 'cancelled') DEFAULT 'pending',
    image_url VARCHAR(1000),
    notes TEXT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (cat_id) REFERENCES cats(cat_id)
);
