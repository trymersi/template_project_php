-- Membuat database
CREATE DATABASE IF NOT EXISTS db_inventory;
USE db_inventory;

-- Membuat tabel users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Membuat tabel produk
CREATE TABLE IF NOT EXISTS produk (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    harga DECIMAL(10, 2) NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    deskripsi TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Membuat tabel pengaturan
CREATE TABLE IF NOT EXISTS pengaturan (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(50) NOT NULL UNIQUE,
    nilai TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Membuat user default
INSERT INTO users (nama, email, password, role) VALUES 
('Administrator', 'admin@admin.com', '$2y$10$KfID.ZrXu3e.lBZhQrsRZuHqYuL5sP03zoGrRhRQl4sLg5HVjsL/6', 'admin'), -- password: password
('User Biasa', 'user@user.com', '$2y$10$KfID.ZrXu3e.lBZhQrsRZuHqYuL5sP03zoGrRhRQl4sLg5HVjsL/6', 'user'); -- password: password

-- Membuat beberapa data produk contoh
INSERT INTO produk (nama_produk, harga, stok) VALUES
('Laptop Asus ROG', 15000000.00, 10),
('Smartphone Samsung Galaxy', 8000000.00, 20),
('Monitor LG 24 inch', 2500000.00, 15),
('Keyboard Mechanical RGB', 850000.00, 30),
('Mouse Gaming Logitech', 450000.00, 25),
('Headset Gaming', 750000.00, 18),
('SSD 1TB', 1500000.00, 12),
('RAM DDR4 16GB', 950000.00, 22),
('Power Supply 700W', 1200000.00, 8),
('VGA Card RTX 3060', 6500000.00, 5);

-- Menambahkan pengaturan default
INSERT INTO pengaturan (kode, nilai) VALUES
('nama_situs', 'Template Project PHP'),
('tagline', 'Aplikasi Web Dengan Template EduAdmin'),
('deskripsi', 'Template project PHP dengan MVC dan template EduAdmin'),
('email_admin', 'admin@example.com'),
('alamat', 'Jl. Contoh No. 123, Kota Contoh'),
('telepon', '08123456789'),
('footer_text', 'Copyright &copy; 2023. All rights reserved.'),
('logo_path', 'assets/images/logo.png'),
('favicon_path', 'assets/images/favicon.ico');

-- Buat user admin default
INSERT INTO users (nama, email, password, role) VALUES
('Administrator', 'admin@admin.com', '$2y$10$uJHKixCH.9HQnF0bz6Gy6.3jCMqK1wSGE8QAWLKBs9QOW6.cF3t2S', 'admin');
-- Password: admin123 