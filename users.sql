DROP DATABASE IF EXISTS zuriphp;

CREATE DATABASE zuriphp;

USE zuriphp;

CREATE TABLE students(
    id int(11) PRIMARY KEY AUTO_INCREMENT NOT NULL,
    full_names varchar(64) NOT NULL,
    country varchar(32) NOT NULL DEFAULT 'nigeria',
    email varchar(64) NOT NULL,
    gender varchar(32) NOT NULL DEFAULT 'male',
    password varchar(128) NOT NULL,
    dob date DEFAULT '2000-01-01'
);

INSERT INTO `students` (`id`, `full_names`, `country`, `email`, `gender`, `password`) VALUES
(2, 'Nancy Vicky', 'Nigeria', 'nancy@gmail.com', 'Female', 'andy'),
(3, 'Seyi Olufe', 'Nigeria', 'seyi@gmail.com', 'Male', '1234'),
(4, 'Chioma Victoria', 'Nigeria', 'vicky@gmail.com', 'Female', '129323'),
(8, 'Nfon Andrew', 'Cameroon', 'drew@gmail.com', 'Nigeria', 'tatah');
