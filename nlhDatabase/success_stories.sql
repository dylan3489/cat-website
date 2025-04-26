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

INSERT INTO success_stories (
    user_id, cat_id, story_text, before_image_url, after_image_url, story_date
)
VALUES
    (
        11, 
        5, 
        'Pumpkin has brought so much joy to our home! She was a little shy at first, but within days she warmed up to everyone and now loves curling up on the couch with us. She is truly a part of our family and we can’t imagine life without her.', 
        'https://example.com/pumpkin-before.jpg', 
        'https://example.com/pumpkin-after.jpg', 
        '2024-01-15 14:30:00'
    ),
    (
        9, 
        10, 
        'Daisy has been the perfect addition to our lives. Her playful energy and affectionate personality have made her a favorite among our friends and family. We are so grateful to the shelter for helping us find her.', 
        'https://example.com/daisy-before.jpg', 
        'https://example.com/daisy-after.jpg', 
        '2024-01-10 10:00:00'
    ),
    (
        10, 
        14, 
        'Bella is thriving in her new home! She has claimed her favorite sunny spot by the window and loves to greet us every morning with a purr. Adopting her was the best decision we’ve made, and she has truly completed our family.', 
        'https://example.com/bella-before.jpg', 
        'https://example.com/bella-after.jpg', 
        '2024-01-20 16:45:00'
    );
