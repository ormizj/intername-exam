CREATE SCHEMA IF NOT EXISTS leads_db;

USE leads_db;

CREATE TABLE IF NOT EXISTS leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    phone_number VARCHAR(30) NOT NULL,
    ip VARCHAR(39) NOT NULL,
    country VARCHAR(255) NOT NULL,
    url TEXT NOT NULL,
    note TEXT NOT NULL,
    sub_1 TEXT NOT NULL,
    called BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);