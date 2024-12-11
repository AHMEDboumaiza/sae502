CREATE DATABASE IF NOT EXISTS sae502;

USE sae502;

-- Création de la table `users`
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(50) NOT NULL
);

-- Ajout des utilisateurs
INSERT INTO users (email, password) VALUES
('admin', 'admin123'),
('user1@example.com', 'password1'),
('user2@example.com', 'password2');
