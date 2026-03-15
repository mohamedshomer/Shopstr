-- ======================================
-- قاعدة البيانات: clothing_system
-- ======================================

CREATE DATABASE IF NOT EXISTS clothing_system;
USE clothing_system;

-- ======================================
-- جدول المتاجر
-- ======================================
CREATE TABLE IF NOT EXISTS stores (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    store_name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ======================================
-- جدول المستخدمين
-- ======================================
CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    store_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE SET NULL
);

-- ======================================
-- جدول التصنيفات
-- ======================================
CREATE TABLE IF NOT EXISTS categories (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    store_id INT(11),
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE
);

-- ======================================
-- جدول المنتجات
-- ======================================
CREATE TABLE IF NOT EXISTS products (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    store_id INT(11),
    category_id INT(11),
    name VARCHAR(150),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- ======================================
-- جدول العملاء
-- ======================================
CREATE TABLE IF NOT EXISTS customers (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    store_id INT(11),
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE
);

-- ======================================
-- جدول الفواتير
-- ======================================
CREATE TABLE IF NOT EXISTS invoices (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    store_id INT(11),
    customer_id INT(11),
    total DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
);

-- ======================================
-- جدول عناصر الفاتورة
-- ======================================
CREATE TABLE IF NOT EXISTS invoice_items (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT(11),
    product_id INT(11),
    quantity INT(11) DEFAULT 1,
    price DECIMAL(10,2) DEFAULT 0.00,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL
);

-- ======================================
-- جدول الألوان
-- ======================================
CREATE TABLE IF NOT EXISTS colors (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

-- ======================================
-- جدول المقاسات
-- ======================================
CREATE TABLE IF NOT EXISTS sizes (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

-- ======================================
-- جدول تنويعات المنتجات
-- ======================================
CREATE TABLE IF NOT EXISTS product_variants (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    product_id INT(11),
    color_id INT(11),
    size_id INT(11),
    stock INT(11) DEFAULT 0,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (color_id) REFERENCES colors(id) ON DELETE SET NULL,
    FOREIGN KEY (size_id) REFERENCES sizes(id) ON DELETE SET NULL
);

-- ======================================
-- جدول المدفوعات
-- ======================================
CREATE TABLE IF NOT EXISTS payments (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT(11),
    amount DECIMAL(10,2) DEFAULT 0.00,
    method VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
);

-- ======================================
-- جدول المكاتب / الفروع
-- ======================================
CREATE TABLE IF NOT EXISTS offices (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    store_id INT(11),
    name VARCHAR(100),
    slug VARCHAR(100) UNIQUE,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE
);

-- ======================================
-- جدول الخزينة
-- ======================================
CREATE TABLE IF NOT EXISTS cashbox (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    store_id INT(11),
    balance DECIMAL(10,2) DEFAULT 0.00,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (store_id) REFERENCES stores(id) ON DELETE CASCADE
);
