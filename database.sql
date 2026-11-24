CREATE DATABASE IF NOT EXISTS coastal_villa CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE coastal_villa;

CREATE TABLE users (
  user_id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(160) NOT NULL UNIQUE,
  contact_number VARCHAR(30) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('guest','admin') NOT NULL DEFAULT 'guest',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE rooms (
  room_id INT AUTO_INCREMENT PRIMARY KEY,
  room_name VARCHAR(120) NOT NULL,
  room_type VARCHAR(80) NOT NULL,
  description TEXT,
  price_per_night DECIMAL(10,2) NOT NULL,
  max_guests INT NOT NULL DEFAULT 2,
  room_status ENUM('Available','Inactive') NOT NULL DEFAULT 'Available',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE bookings (
  booking_id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  room_id INT NOT NULL,
  check_in DATE NOT NULL,
  check_out DATE NOT NULL,
  total_amount DECIMAL(10,2) NOT NULL,
  booking_status ENUM('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  booking_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  guests INT NOT NULL DEFAULT 1,
  CONSTRAINT fk_booking_user FOREIGN KEY (user_id) REFERENCES users(user_id),
  CONSTRAINT fk_booking_room FOREIGN KEY (room_id) REFERENCES rooms(room_id),
  INDEX idx_room_dates (room_id, check_in, check_out, booking_status)
);

INSERT INTO rooms (room_name, room_type, description, price_per_night, max_guests) VALUES
('Ocean View Deluxe', 'Deluxe', 'A bright room with a private balcony, air conditioning, Wi-Fi and an ocean view.', 18000.00, 2),
('Garden Family Suite', 'Family', 'A spacious family suite with garden views, attached bathroom and sitting area.', 26000.00, 4),
('Cozy Standard Room', 'Standard', 'A comfortable room with essential facilities, Wi-Fi and a peaceful atmosphere.', 12000.00, 2);

-- Create an administrator after importing the database:
-- 1. Register a normal account through register.php.
-- 2. Run this SQL, replacing the email with that account's email:
-- UPDATE users SET role='admin' WHERE email='admin@example.com';
