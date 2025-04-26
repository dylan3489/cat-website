CREATE TABLE cats (
    cat_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    cat_name VARCHAR(255) NOT NULL,
    breed VARCHAR(255),
    cat_age INT,
    cat_health VARCHAR(255),
    cat_description TEXT,
    image_url VARCHAR(1000),
    adoption_status ENUM('available', 'adopted') DEFAULT 'available',
    special_requirements TEXT NOT NULL
);

INSERT INTO cats (
    cat_name, breed, cat_age, cat_health, cat_description, image_url, adoption_status, special_requirements
) 
VALUES (
    'Milo', 'Domestic Shorthair', 3, 'Healthy', 
    'Milo is an energetic and playful kitten with a beautiful blend of brown and ginger fur. He loves exploring, chasing toys, and snuggling after playtime.', 
    '../nlhImages/cat1.jpg', 
    'Available for Adoption', 
    'Requires a safe indoor environment at his young age, and a human to look after him around the clock for at least the first few months, with plenty of interactive playtime.'
);

INSERT INTO cats (
    cat_name, breed, cat_age, cat_health, cat_description, image_url, adoption_status, special_requirements
)
VALUES
    ('Whiskers', 'Domestic Shorthair', 2, 'Healthy', 'Whiskers is a playful and curious cat who loves exploring her surroundings.', '../nlhImages/cat2.jpg', 'available', 'Requires a calm environment.'),
    ('Mittens', 'Domestic Longhair', 4, 'Healthy', 'Mittens enjoys spending time with people and is very affectionate.', '../nlhImages/cat3.jpg', 'available', 'Prefers a household with no other pets.'),
    ('Shadow', 'Domestic Shorthair', 1, 'Healthy', 'Shadow is an energetic kitten who loves playing with toys.', '../nlhImages/cat4.jpg.jpg', 'available', 'Needs plenty of interactive playtime.'),
    ('Pumpkin', 'Tabby', 3, 'Healthy', 'Pumpkin is a sweet and social cat who thrives on attention.', '../nlhImages/cat5.jpg', 'adopted', 'Requires regular grooming.'),
    ('Luna', 'Tuxedo', 5, 'Healthy', 'Luna is independent but enjoys quiet companionship.', '../nlhImages/cat6.jpg', 'available', 'Needs a quiet home to feel safe.'),
    ('Oreo', 'Black and White Mix', 2, 'Healthy', 'Oreo is friendly and adapts well to new environments.', '../nlhImages/cat7.jpg', 'available', 'No special requirements.'),
    ('Tiger', 'Tabby', 6, 'Healthy', 'Tiger is laid-back and loves lounging in sunny spots.', '../nlhImages/cat8.jpg', 'available', 'Best suited to a home without young children.'),
    ('Smokey', 'Domestic Shorthair', 7, 'Minor health issues', 'Smokey is calm and gentle, perfect for a quiet household.', '../nlhImages/cat9.jpg', 'available', 'Requires occasional medication for arthritis.'),
    ('Daisy', 'Calico', 3, 'Healthy', 'Daisy is affectionate and enjoys being the center of attention.', '../nlhImages/cat10.jpg', 'adopted', 'Best as the only pet in the home.'),
    ('Charlie', 'Domestic Shorthair', 1, 'Healthy', 'Charlie is curious and loves meeting new people.', '../nlhImages/cat11.jpg', 'available', 'No special requirements.'),
    ('Cleo', 'Tortoiseshell', 8, 'Healthy', 'Cleo is calm and enjoys peaceful environments.', '../nlhImages/cat12.jpg', 'available', 'Requires a stable and predictable routine.'),
    ('Max', 'Tabby', 2, 'Healthy', 'Max is a social cat who gets along with other cats.', '../nlhImages/cat13.jpg', 'available', 'No special requirements.'),
    ('Bella', 'Domestic Shorthair', 4, 'Healthy', 'Bella is loving and enjoys spending time with people.', '../nlhImages/cat14.jpg', 'adopted', 'No special requirements.'),
    ('Milo', 'Domestic Shorthair', 3, 'Healthy', 'Milo is playful and full of energy.', '../nlhImages/cat15.jpg', 'available', 'Prefers a household with other playful pets.'),
    ('Mochi', 'Domestic Shorthair', 5, 'Healthy', 'Mochi is sweet and loves snuggling with her favorite people.', '../nlhImages/cat16.jpg', 'available', 'Best suited for a home with older children.');
