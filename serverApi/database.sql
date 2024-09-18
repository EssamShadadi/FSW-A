CREATE DATABASE ticketing;

USE DATABASE ticketing;

CREATE TABLE centers (
    centerId INT AUTO_INCREMENT PRIMARY KEY,
    centerName VARCHAR(500) NOT NULL
);

CREATE TABLE ItSpecialists(
    itId INT AUTO_INCREMENT PRIMARY KEY,
    itName VARCHAR(500) NOT NULL
);

CREATE TABLE employees(
    empId INT AUTO_INCREMENT PRIMARY KEY,
    empName VARCHAR(255) NOT NULL,
    empCenterId INT NOT NULL,
    FOREIGN KEY (empCenterId) REFERENCES centers(centerId)
);

CREATE TABLE ItSpecialistsCenters ( -- link the IT specialst with the centers
    id INT AUTO_INCREMENT PRIMARY KEY,
    centerId INT NOT NULL,
    itId INT NOT NULL,
    FOREIGN KEY (centerId) REFERENCES centers(centerId),
    FOREIGN KEY (itId) REFERENCES ItSpecialists(itId)
);


CREATE TABLE tickets(
    ticketId INT AUTO_INCREMENT PRIMARY KEY,
    ticketStatus ENUM('pending','in process','completed') DEFAULT 'pending',
    ticketCenterId INT NOT NULL,
    ticketProblemDescription TEXT,  
    ticketProblemType ENUM('software','hardware'),
    ticketDeviceType VARCHAR(100) NOT NULL,
    ticketEmployeeId INT NOT NULL,
    ticketItSpecialistId INT NOT NULL,
    ticketOsVersion VARCHAR(500) NOT NULL,
    ticketAffectedSoftware VARCHAR(500) NOT NULL,
    ticketErrorCode VARCHAR(500),
    ticketScreenshot VARCHAR(500),
    ticketDeviceSN VARCHAR(500),
    FOREIGN KEY (ticketCenterId) REFERENCES centers(centerId),
    FOREIGN KEY (ticketEmployeeId) REFERENCES employees(empId),
    FOREIGN KEY (ticketItSpecialistId) REFERENCES ItSpecialists(itId)
);

INSERT INTO centers (centerName) VALUES ("HQ"),("Shatila"),("Nabaa"),("Tripoli"),("Bekaa"); -- inserting centers to database 
INSERT INTO ItSpecialists (itName) VALUES ("Firas"),("Wael"),("Hussein"); -- inserting IT Specialsts to database 

-- link each IT with the his center
INSERT INTO ItSpecialistsCenters(centerId,itId) VALUES (1,1);
INSERT INTO ItSpecialistsCenters(centerId,itId) VALUES (2,3);
INSERT INTO ItSpecialistsCenters(centerId,itId) VALUES (3,3);
INSERT INTO ItSpecialistsCenters(centerId,itId) VALUES (4,2);
INSERT INTO ItSpecialistsCenters(centerId,itId) VALUES (5,2);