-- Create the database
CREATE DATABASE IF NOT EXISTS pension_system;

-- Use the database
USE pension_system;

-- Create employee_pension table
CREATE TABLE IF NOT EXISTS employee_pension (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employ_name VARCHAR(100) NOT NULL,
    employee_address VARCHAR(255) NOT NULL,
    monthly_salary DECIMAL(10, 2) NOT NULL,
    employee_period INT NOT NULL,
    benefit_percentage DECIMAL(5, 2) NOT NULL,
    total_amount DECIMAL(15, 2) NOT NULL,
    amount_per_month DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);