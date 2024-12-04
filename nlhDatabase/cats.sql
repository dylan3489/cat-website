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

INSERT INTO `stock` (`ProductSKU`, `Quantity`, `ProductName`, `Product_Description`, `Barcode`, `Product_Status`, `Product_Category`, `Price`,`image`) VALUES
('1', '27', 'Selsun 2.5% selenium sulphide shampoo', '2.5% selenium sulphide. Medicated shampoo. Reduces greasiness of scalp. Slows down the growth of skin on scalp that causes flakes', '14956', 'In stock', 'Haircare', '4.09','productImages/1.jpg'),
('2', '23', 'Regaine minoxidil', 'Increases blood flow to follicles. Results can be noticed in 8 weeks. Thicker, longer, more visible hair. Does not affect male hormones. Contains minoxidil', '19342', 'In stock', 'Haircare', '54.99','productImages/2.jpg'),
('6', '40', 'Piriton allergy tablets', 'Piriton allergy tablets is an antihistamine containing Chlorphenamine Maleate which can help to relieve the symptoms of some allergies and itchy skin rashes.', '17564', 'In stock', 'General', '3.99','productImages/3.jpg'),
('7', '35', 'Difflam Mouth Spray', 'Suitable for adults, the elderly and children. With benzydamine hydrochloride. Targets mouth and throat pain', '17568', 'In stock', 'DentalCare', '7.99','productImages/4.jpg'),
('11', '40', 'Orajel dental gel', 'Benzocaine:use up to four times per day. Relieves tooth pain.', '12453', 'In stock', 'DentalCare', '5.99','productImages/5.jpg'),
('12', '45', 'Gaviscon Advance', 'For heartburn and acid indigestion. 10ml dose contains 4.6 mmol of sodium, 2.0 mmol of potassium & 2.0 mmol of calcium.', '25304', 'In stock', 'General', '9.99','productImages/6.jpg'),
('16', '59', 'Centrum Advance Multivitamins', '24 tablets. Each tablet includes, Vitamin C, Vitamin B12 and Vitamin D.', '98345', 'In stock', 'Vitamins_Supplements', '13.99','productImages/7.jpg'),
('17', '54', 'Simple Moisturising Face Wash', 'Warning: for external usage only. Avoid getting into your eyes.', '36743', 'In stock', 'SkinCare', '3.80','productImages/8.jpg'),
('21', '37', 'Seven Seas Omega-3 Fish Oil', 'No other leading brand has a higher level of Omega-3 in just one daily capsule 1250 mg Fish Oil, 1063 mg Omega-3; Vitamin D for bones, teeth, and to support the normal functioning of the immune system.', '24754', 'In stock', 'Vitamins_Supplements', '19.99','productImages/9.jpg'),
('22', '28', 'Anthisan bite & sting', 'Containing the active ingredient Mepyramine Maleate 2% w/w, use as soon as possible after the bite or sting to help relieve itching, pain, swelling and inflammation. ', '21675', 'In stock', 'SkinCare', '4.95','productImages/10.jpg');

INSERT INTO `stock` (`ProductSKU`, `Quantity`, `ProductName`, `Product_Description`, `Barcode`, `Product_Status`, `Product_Category`, `Price`) VALUES
('3', '35', 'Capasal Therapeutic Shampoo', 'Capasal Therapeutic Shampoo is for the treatment of dry and irritated scalp conditions such as seborrhoeic eczema, dandruff, psoriasis in children.', '14957', 'In stock', 'Haircare', '8.00'),
('4', '55', 'Wella Deluxe Rich Oil', 'Infused with a blend of nourishing oils, specifically designed for dry hair.', '14958', 'In stock', 'Haircare', '9.00'),
('5', '70', 'OGX Renewing Argan Oil Morocco Conditioner', 'This renewing formula is free of sulphates and parabens and is safe for colour treated hair.', '14959', 'In stock', 'Haircare', '6.00'),
('8', '40', 'Ibuprofen 400mg', 'Can be used to relieve headaches, migraines, toothaches, nerve pains and menstrual pains. They can also reduce fevers and discomforts associated with colds and the flu.', '25305', 'In stock', 'General', '6.00'),
('9', '43', 'Paracetamol 500mg', 'Paracetamol 500mg helps to bring temporary relief from pain linked to; Headaches, Sinus Headaches, Neuralgic Conditions, Muscular Aches, Rheumatics, Fever Symptoms.', '25306', 'In stock', 'General', '1.00'),
('10', '67', 'Nurofen Plus 200mg', 'Nurofen Plus can be used for the short-term relief of rheumatic and muscular pain, backache, migraine, headache, neuralgia, period pain and dental pain.', '25307', 'In stock', 'General', '12.00'),
('13', '29', 'TePe Interdental Brushes Original Green', 'designed specifically to clean in-between your teeth and all those hard to reach places. Designed with a metal wire that cleans your teeth thoroughly.', '17569', 'In stock', 'DentalCare', '4.00'),
('14', '48', 'Corsodyl Daily Complete Protection Toothpaste Extra Fresh', 'Corsodyl Complete Protection Toothpaste Extra Fresh is a daily toothpaste with 8 specially designed benefits for healthy gums and strong teeth.', '17570', 'In stock', 'DentalCare', '3.00'),
('15', '35', 'Aquafresh Triple Protection Toothpaste Fresh & Minty', 'Aquafresh Triple Protection Toothpaste Fresh & Minty is a daily toothpaste for the whole family, which gives you fresh breath, healthy gums and strong teeth.', '17571', 'In stock', 'DentalCare', '1.00'),
('18', '50', 'Centrum Multivitamin Fruity Chewables', 'Supports the general wellbeing of adults. Made with Vitamins B1, B2, B6, B12, and C, Biotin, Chromium, and Zinc. Chewable multivitamin. Free from gluten, lactose, nuts, wheat, yeast and artificial colours.', '24755', 'In stock', 'Vitamins_Supplements', '8.00'),
('19', '70', 'Adcal D3', 'promotes delaying and preventing certain bone conditions such as osteoporosis. Each chewable tablet is packed full of Calcium and Vitamin D3, which is scientifically proven to help prevent hip and non-vertebral bone fractures from occurring later in life.', '24756', 'In stock', 'Vitamins_Supplements', '6.00'),
('20', '66', 'Berocca Immuno Energy & Immune Support', 'Berocca Immuno is packed with 11 vitamins and minerals including high-strength vitamin C, vitamins D, A, B6, B9 & B12 as well as Zinc, Copper, Iron & Selenium, which all support your immune system', '24757', 'In stock', 'Vitamins_Supplements', '14.00'),
('23', '34', 'CeraVe Eye Repair Cream', 'CeraVe Eye Repair Cream is a light and fast absorbing eye treatment that quickly melts quickly into skin around the eyes, controlling the release of ingredients to help repair and restore skins protective barrier.', '21678', 'In stock', 'SkinCare', '14.00'),
('24', '27', 'CeraVe Moisturising Cream', 'Suitable for dry to very dry skin. Has the National Eczema Association Seal of Acceptance. Fragrance free. Moisturises the protective skin barrier of the face and body. Non-comedogenic', '21679', 'In stock', 'SkinCare', '17.00'),
('25', '53', 'QV Skin Lotion', ' Lightweight, easy-to-apply, all-over body lotion. Acts as a protective barrier. Relieves daily discomfort from dry skin. Suitable for eczema, psoriasis, and dermatitis.', '21680', 'In stock', 'SkinCare', '8.00');
