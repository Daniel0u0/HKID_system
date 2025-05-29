<?php
// File: setup.sql
// Database setup script
CREATE DATABASE hkid_appointments;
USE hkid_appointments;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('citizen', 'junior_staff', 'approving_staff', 'admin') NOT NULL
);

CREATE TABLE appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    hkid VARCHAR(10) NOT NULL,
    dob DATE NOT NULL,
    appointment_date DATETIME NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Sample user (password: 'password123')
INSERT INTO users (username, password, role) VALUES (
    'citizen1',
    '$2y$10$examplehashedpassword', -- Use password_hash('password123', PASSWORD_DEFAULT)
    'citizen'
);
?>