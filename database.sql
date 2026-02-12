CREATE DATABASE voting;
USE voting;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    password VARCHAR(100),
    voted INT DEFAULT 0
);

CREATE TABLE candidates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    votes INT DEFAULT 0
);

CREATE TABLE admin (
    username VARCHAR(50),
    password VARCHAR(50)
);

INSERT INTO admin VALUES ('admin','admin123');

INSERT INTO candidates(name) VALUES
('Candidate A'),
('Candidate B'),
('Candidate C');
