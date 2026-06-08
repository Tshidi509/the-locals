
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('buyer','seller','admin') NOT NULL DEFAULT 'buyer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE brands (
  id INT AUTO_INCREMENT PRIMARY KEY,
  seller_id INT NOT NULL,
  brand_name VARCHAR(120) NOT NULL,
  description TEXT NOT NULL,
  logo_path VARCHAR(255),
  address TEXT,
  pep_collection_point VARCHAR(180),
  subscription_status ENUM('pending','active','expired') DEFAULT 'pending',
  subscription_expires DATE NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE seller_payment_details (
  id INT AUTO_INCREMENT PRIMARY KEY,
  seller_id INT NOT NULL UNIQUE,
  bank_name VARCHAR(120) NOT NULL,
  account_holder VARCHAR(120) NOT NULL,
  account_number VARCHAR(60) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  brand_id INT NOT NULL,
  seller_id INT NOT NULL,
  product_name VARCHAR(140) NOT NULL,
  category VARCHAR(80) NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  stock INT NOT NULL DEFAULT 1,
  description TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (brand_id) REFERENCES brands(id) ON DELETE CASCADE,
  FOREIGN KEY (seller_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE product_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  product_id INT NOT NULL,
  image_path VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  buyer_id INT NOT NULL,
  seller_id INT NOT NULL,
  brand_id INT NOT NULL,
  total DECIMAL(10,2) NOT NULL,
  delivery_method ENUM('collect_at_brand','pep_collection') DEFAULT 'pep_collection',
  buyer_address TEXT,
  pep_collection_point VARCHAR(180),
  proof_path VARCHAR(255),
  status ENUM('pending_payment','proof_uploaded','confirmed','packed','sent_to_pep','ready_for_collection','completed','cancelled') DEFAULT 'pending_payment',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (buyer_id) REFERENCES users(id),
  FOREIGN KEY (seller_id) REFERENCES users(id),
  FOREIGN KEY (brand_id) REFERENCES brands(id)
);

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL,
  price DECIMAL(10,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
  FOREIGN KEY (product_id) REFERENCES products(id)
);

CREATE TABLE newsletters (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(160) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE seller_subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  seller_id INT NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 200.00,
  period_year INT NOT NULL,
  proof_path VARCHAR(255),
  status ENUM('pending','approved','rejected') DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (seller_id) REFERENCES users(id)
);

-- Create your admin after importing by registering as buyer, then run:
-- UPDATE users SET role='admin' WHERE email='your-email@example.com';
