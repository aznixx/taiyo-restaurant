



CREATE DATABASE IF NOT EXISTS taiyo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE taiyo;




CREATE TABLE IF NOT EXISTS users (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username    VARCHAR(60)  NOT NULL UNIQUE,
  password    VARCHAR(255) NOT NULL,         
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);




CREATE TABLE IF NOT EXISTS categories (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name        VARCHAR(100) NOT NULL UNIQUE,
  description TEXT,
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);




CREATE TABLE IF NOT EXISTS menu_items (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  category_id INT UNSIGNED NOT NULL,
  name        VARCHAR(150) NOT NULL,
  description TEXT,
  price       DECIMAL(6,2) NOT NULL,
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);




CREATE TABLE IF NOT EXISTS messages (
  id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name   VARCHAR(120) NOT NULL,
  email       VARCHAR(180) NOT NULL,
  phone       VARCHAR(30),
  party_size  VARCHAR(20),
  message     TEXT         NOT NULL,
  is_read     TINYINT(1)   NOT NULL DEFAULT 0,
  created_at  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP
);




INSERT INTO categories (name, description) VALUES
  ('Starters',  'Small plates to begin with'),
  ('Ramen',     'Signature bowls'),
  ('Sides',     'Extras and accompaniments'),
  ('Desserts',  'Sweet endings'),
  ('Drinks',    'Hot and cold beverages');

INSERT INTO menu_items (category_id, name, description, price) VALUES
  (1, 'Gyoza (6 pcs)',       'Pan-fried pork and cabbage dumplings with ponzu dipping sauce.',  7.50),
  (1, 'Karaage',             'Japanese fried chicken, crispy outside, juicy inside.',            8.50),
  (2, 'Tonkotsu Ramen',      '12-hour pork bone broth, chashu pork, soft egg, nori.',           14.50),
  (2, 'Shoyu Ramen',         'Clear soy tare broth, chicken chashu, menma, spring onion.',      13.50),
  (2, 'Spicy Miso Ramen',    'Rich miso base with chilli oil, tofu, corn and crispy garlic.',   14.00),
  (3, 'Seasoned Soft Egg',   'Marinated ajitsuke tamago, jammy yolk.',                           2.50),
  (3, 'Extra Chashu',        'Two slices of slow-braised pork belly.',                           3.50),
  (4, 'Mochi Ice Cream',     'Two pieces — matcha and black sesame.',                            5.50),
  (5, 'Matcha Latte',        'Ceremonial grade matcha with steamed oat milk.',                   4.50),
  (5, 'Ramune',              'Japanese soda — original or strawberry.',                          3.00);
