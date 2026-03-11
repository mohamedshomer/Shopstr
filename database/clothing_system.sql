-- ========================================
-- قاعدة البيانات لنظام إدارة مكاتب الملابس
-- ========================================

-- 1️⃣ إنشاء قاعدة البيانات
CREATE DATABASE IF NOT EXISTS clothing_system;
USE clothing_system;

-- 2️⃣ جدول المكاتب
CREATE TABLE offices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3️⃣ جدول المستخدمين
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_id INT,
    name VARCHAR(150),
    username VARCHAR(100),
    password VARCHAR(255),
    role ENUM('admin','manager','cashier'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (office_id) REFERENCES offices(id) ON DELETE CASCADE
);

-- 4️⃣ جدول التصنيفات
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_id INT,
    name VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5️⃣ جدول المنتجات (الموديلات)
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_id INT,
    category_id INT,
    name VARCHAR(150),
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
);

-- 6️⃣ جدول المقاسات
CREATE TABLE sizes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

-- 7️⃣ جدول الألوان
CREATE TABLE colors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50)
);

-- 8️⃣ جدول Variants (موديل + مقاس + لون)
CREATE TABLE product_variants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT,
    size_id INT,
    color_id INT,
    barcode VARCHAR(100),
    cost_price DECIMAL(10,2),
    wholesale_price DECIMAL(10,2),
    retail_price DECIMAL(10,2),
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    FOREIGN KEY (size_id) REFERENCES sizes(id) ON DELETE CASCADE,
    FOREIGN KEY (color_id) REFERENCES colors(id) ON DELETE CASCADE
);

-- 9️⃣ جدول المخزن
CREATE TABLE inventory (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_id INT,
    variant_id INT,
    quantity INT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE CASCADE,
    FOREIGN KEY (office_id) REFERENCES offices(id) ON DELETE CASCADE
);

-- 🔟 جدول العملاء
CREATE TABLE customers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_id INT,
    name VARCHAR(150),
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (office_id) REFERENCES offices(id) ON DELETE CASCADE
);

-- 1️⃣1️⃣ جدول الفواتير
CREATE TABLE invoices (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_id INT,
    customer_id INT,
    invoice_type ENUM('retail','wholesale'),
    total DECIMAL(10,2),
    discount DECIMAL(10,2) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (office_id) REFERENCES offices(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id) ON DELETE SET NULL
);

-- 1️⃣2️⃣ جدول عناصر الفاتورة
CREATE TABLE invoice_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT,
    variant_id INT,
    quantity INT,
    price DECIMAL(10,2),
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE,
    FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE CASCADE
);

-- 1️⃣3️⃣ جدول المدفوعات
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_id INT,
    amount DECIMAL(10,2),
    payment_method ENUM('cash','bank','other'),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (invoice_id) REFERENCES invoices(id) ON DELETE CASCADE
);

-- 1️⃣4️⃣ جدول الخزينة
CREATE TABLE cashbox (
    id INT AUTO_INCREMENT PRIMARY KEY,
    office_id INT,
    type ENUM('inflow','outflow'),
    amount DECIMAL(10,2),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (office_id) REFERENCES offices(id) ON DELETE CASCADE
);
