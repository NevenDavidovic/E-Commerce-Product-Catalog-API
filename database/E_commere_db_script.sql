-- Create the database
CREATE DATABASE IF NOT EXISTS product_catalog;
USE product_catalog;

-- Create Categories table
CREATE TABLE Categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create Products table
CREATE TABLE Products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sku VARCHAR(50) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    type ENUM('physical', 'virtual') NOT NULL,
    category_id INT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES Categories(id)
);

-- Create Attributes table
CREATE TABLE Attributes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    product_id INT NOT NULL,
    attribute VARCHAR(50) NOT NULL,
    value VARCHAR(255) NOT NULL,
    FOREIGN KEY (product_id) REFERENCES Products(id)
);

-- Seed Categories
INSERT INTO Categories (name) VALUES
('Electronics'),
('Books'),
('Clothing');

-- Seed Products and Attributes
-- Physical Products
INSERT INTO Products (sku, name, description, price, type, category_id, image_url) VALUES
('PHY001', 'Smartphone', 'High-end smartphone', 799.99, 'physical', 1, 'https://i.guim.co.uk/img/media/2ce8db064eabb9e22a69cc45a9b6d4e10d595f06/392_612_4171_2503/master/4171.jpg?width=1200&height=900&quality=85&auto=format&fit=crop&s=45b5856ba8cd83e6656fbe5c166951a4'),
('PHY002', 'Laptop', 'Powerful laptop', 1299.99, 'physical', 1, 'https://ssl-product-images.www8-hp.com/digmedialib/prodimg/lowres/c08484411.png'),
('PHY003', 'T-shirt', 'Cotton t-shirt', 19.99, 'physical', 3, 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSfVu-3zoeOSWvLESygPat9hKdpzaEx1vK60A&s'),
('PHY004', 'Jeans', 'Denim jeans', 49.99, 'physical', 3, 'https://lsco.scene7.com/is/image/lsco/726930130-front-pdp-ld?$laydownfront$'),
('PHY005', 'Headphones', 'Wireless headphones', 149.99, 'physical', 1, 'https://products.shureweb.eu/cdn-cgi/image/width=1380,height=1380,format=auto/shure_product_db/product_main_images/files/c25/16a/40-/original/ce632827adec4e1842caa762f10e643d.webp'),
('PHY006', 'Smartwatch', 'Fitness tracker watch', 199.99, 'physical', 1, 'https://cdn5.elipso.hr/elipsowebmedia/images/xbig/154171.jpg'),
('PHY007', 'Dress', 'Evening dress', 89.99, 'physical', 3, 'https://i.ebayimg.com/images/g/SWwAAOSwcYpg7RgI/s-l400.jpg'),
('PHY008', 'Sneakers', 'Running shoes', 79.99, 'physical', 3, 'https://cdn.thewirecutter.com/wp-content/media/2024/05/white-sneaker-2048px-9320.jpg?auto=webp&quality=75&width=1024'),
('PHY009', 'Tablet', '10-inch tablet', 299.99, 'physical', 1, 'https://www.mall.hr/i/83757711'),
('PHY010', 'Jacket', 'Winter jacket', 129.99, 'physical', 3, 'https://www.travelandleisure.com/thmb/UZbCB67U1kcuriEGNc9KVjq5Nf0=/fit-in/1500x2604/filters:no_upscale():max_bytes(150000):strip_icc()/tal-down-jackets-men-women-test-lole-emeline-kat-zhang-21-5c363b633d284fcca5127a57b9c44934.jpeg');

-- Attributes for Physical Products
INSERT INTO Attributes (product_id, attribute, value) VALUES
(1, 'color', 'Black'),
(1, 'shipping_price', '9.99'),
(2, 'color', 'Silver'),
(2, 'shipping_price', '14.99'),
(3, 'color', 'White'),
(3, 'shipping_price', '4.99'),
(4, 'color', 'Blue'),
(4, 'shipping_price', '4.99'),
(5, 'color', 'Black'),
(5, 'shipping_price', '7.99'),
(6, 'color', 'Gray'),
(6, 'shipping_price', '6.99'),
(7, 'color', 'Red'),
(7, 'shipping_price', '5.99'),
(8, 'color', 'White'),
(8, 'shipping_price', '8.99'),
(9, 'color', 'Space Gray'),
(9, 'shipping_price', '11.99'),
(10, 'color', 'Green'),
(10, 'shipping_price', '9.99');

-- Virtual Products
INSERT INTO Products (sku, name, description, price, type, category_id, image_url) VALUES
('VIR001', 'E-book: Python Programming', 'Comprehensive Python guide', 29.99, 'virtual', 2, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR002', 'Online Course: Web Development', '12-week web dev course', 199.99, 'virtual', 2, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR003', 'Software License: Photo Editor', '1-year license for photo editing software', 89.99, 'virtual', 1, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR004', 'E-book: Healthy Recipes', 'Collection of 100 healthy recipes', 14.99, 'virtual', 2, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR005', 'Online Course: Digital Marketing', '8-week digital marketing course', 149.99, 'virtual', 2, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR006', 'Software License: Antivirus', '2-year antivirus subscription', 59.99, 'virtual', 1, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR007', 'E-book: Science Fiction Collection', '10 sci-fi novels bundle', 24.99, 'virtual', 2, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR008', 'Online Course: Yoga for Beginners', '4-week yoga course', 39.99, 'virtual', 2, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR009', 'Software License: Office Suite', '1-year license for office software', 119.99, 'virtual', 1, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg'),
('VIR010', 'E-book: Financial Planning', 'Guide to personal finance', 19.99, 'virtual', 2, 'https://erasmuscoursescroatia.com/wp-content/uploads/2019/12/Online-courses.jpg');

-- Attributes for Virtual Products
INSERT INTO Attributes (product_id, attribute, value) VALUES
(11, 'expires_at', '2025-12-31 23:59:59'),
(11, 'coupon_code', 'PYTH0N2024'),
(12, 'expires_at', '2025-06-30 23:59:59'),
(12, 'coupon_code', 'WEBDEV2024'),
(13, 'expires_at', '2025-12-31 23:59:59'),
(13, 'coupon_code', 'PHOTO2024'),
(14, 'expires_at', '2026-12-31 23:59:59'),
(14, 'coupon_code', 'HEALTH2024'),
(15, 'expires_at', '2025-09-30 23:59:59'),
(15, 'coupon_code', 'MKTG2024'),
(16, 'expires_at', '2026-12-31 23:59:59'),
(16, 'coupon_code', 'SECURE2024'),
(17, 'expires_at', '2026-12-31 23:59:59'),
(17, 'coupon_code', 'SCIFI2024'),
(18, 'expires_at', '2025-03-31 23:59:59'),
(18, 'coupon_code', 'YOGA2024'),
(19, 'expires_at', '2025-12-31 23:59:59'),
(19, 'coupon_code', 'OFFICE2024'),
(20, 'expires_at', '2026-12-31 23:59:59'),
(20, 'coupon_code', 'FINANCE2024');