-- DATABASE CREATE
CREATE DATABASE IF NOT EXISTS rajpoot;
USE rajpoot;

-- OLD TABLE DELETE (safe reset)
DROP TABLE IF EXISTS patients;
DROP TABLE IF EXISTS doctors;
DROP TABLE IF EXISTS appointments;

-- DOCTORS TABLE
CREATE TABLE doctors(
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50),
 password VARCHAR(50)
);

INSERT INTO doctors(username,password)
VALUES('doctor','1234');


-- PATIENTS TABLE (UPDATED FULL)

CREATE TABLE patients(
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(50),
 email VARCHAR(100),
 password VARCHAR(100),
 age VARCHAR(10),
 phone VARCHAR(20),
 weight VARCHAR(10),
 bgroup VARCHAR(10),
 disease VARCHAR(100),
 history VARCHAR(200),
 gender VARCHAR(10)
);


--APPOINTMENT TABLE
CREATE TABLE appointments(
 id INT AUTO_INCREMENT PRIMARY KEY,
 patient_name VARCHAR(50),
 doctor_name VARCHAR(50),
 app_date DATE,
 app_time VARCHAR(20)
);