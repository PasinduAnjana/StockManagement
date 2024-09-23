CREATE DATABASE stock_management;
USE stock_management;


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL,
    image VARCHAR(255),
    contact VARCHAR(10)
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL,
    image VARCHAR(255)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    status VARCHAR(10) NOT NULL DEFAULT 'pending',
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);



INSERT INTO users (username, password, role) VALUES
('admin', 'admin', 'admin');


INSERT INTO users (username, password, role) VALUES
('ucsc', 'ucsc', 'user');


INSERT INTO products(name,description,category,quantity,price,image) 
VALUES
('Chair','Wood Chair','Furniture',20,8000.00,'../uploads/chair.jpg'),
('Table','Conference Table','Furniture',10,10000.00,'../uploads/table.jpg'),
('Apple','Red Apple','Food',100,50.00,'../uploads/apple.jpg'),
('Orange','Orange Orange','Food',80,40.00,'../uploads/orange.jpg');

