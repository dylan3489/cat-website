CREATE TABLE success_stories (
    story_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    cat_id INT NOT NULL,
    story_text TEXT NOT NULL,
    before_image_url VARCHAR(1000),
    after_image_url VARCHAR(1000),
    story_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (cat_id) REFERENCES cats(cat_id) ON DELETE CASCADE
);