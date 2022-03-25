 CREATE DATABASE clinica
GO

USE clinica
GO

CREATE TABLE type_users
(
	id_type_user INT IDENTITY(1,1) PRIMARY KEY,
	[type] VARCHAR(30) NOT NULL
);
GO

CREATE TABLE users
(
	dui VARCHAR(10) PRIMARY KEY,
	name VARCHAR(50) NOT NULL,
	lastname VARCHAR(50) NOT NULL,
	email VARCHAR(100) NOT NULL,
	[address] VARCHAR(150) NOT NULL,
	[password] VARCHAR(30) NOT NULL,
	birthdate DATE NOT NULL,
	id_type_user INT,
	FOREIGN KEY (id_type_user) REFERENCES type_users(id_type_user)
);
GO

CREATE TABLE phones
(
	id_phone INT IDENTITY(1,1) PRIMARY KEY,
	phone VARCHAR(9) NOT NULL,
	[type] VARCHAR(20) NOT NULL,
	id_usuario VARCHAR(10) NOT NULL,
	FOREIGN KEY (id_usuario) REFERENCES users(dui)
);
GO

CREATE TABLE identification_files
(
	id_identification_file INT IDENTITY(1,1) PRIMARY KEY,
	gender BIT NOT NULL,
	age INT,
	marital_status VARCHAR(50) NOT NULL,
	occupation VARCHAR(50) NOT NULL,
	father_name VARCHAR(100),
	mother_name VARCHAR(100),
	couple_name VARCHAR(100),
	attendant_name VARCHAR(100) NOT NULL,
	attendant_address VARCHAR(150) NOT NULL,
	attendant_phone VARCHAR(9) NOT NULL,
	provided_information_name VARCHAR(150) NOT NULL,
	provided_information_relationship VARCHAR(75) NOT NULL,
	provided_information_dui VARCHAR(10) NOT NULL,
	couple_provided_information_name VARCHAR(150),
	take_information_name VARCHAR(150) NOt NULL,
	inscription_date DATE NOT NULL
);
GO

CREATE TABLE information_data 
(
	id_information_data INT IDENTITY(1,1) PRIMARY KEY,
	highrisk_pregnancy BIT NOT NULL,
	location VARCHAR(100) NOT NULL,
	ethnic VARCHAR(100) NOT NULL,
	literate BIT NOT NULL,
	studies varchar(100) NOT NULL,
	lonely BIT,
	tbc BIT,
	diabetes BIT,
	hipertension BIT,
	preeclamsia BIT,
	eclampsia BIT,
	other_illness VARCHAR(200),
	surgery BIT,
	infertility BIT,
	heart_disease BIT,
	nephropathy BIT,
	violence BIT,
	VIH BIT,
	end_of_last_pregnancy BIT,
	planned_pregnancy BIT,
	contraceptives VARCHAR(200),
	last_weight FLOAT,
	size FLOAT,
	antirubeola BIT,
	antitetanica BIT,
	actively_smoke BIT,
	passively_smoke BIT,
	use_drugs BIT,
	alcoholic BIT
);
GO

CREATE TABLE files
(
	id_file VARCHAR(7) PRIMARY KEY,
	id_identification_file INT NOT NULL,
	id_information_file INT NOT NULL,
	FOREIGN KEY (id_identification_file) REFERENCES identification_files(id_identification_file),
	FOREIGN KEY (id_information_file) REFERENCES information_data(id_information_data)
);
GO

CREATE TABLE patients
(
	id_patient VARCHAR(10) PRIMARY KEY,
	id_file VARCHAR(7) NOT NULL,
	FOREIGN KEY (id_patient) REFERENCES users(dui),
	FOREIGN KEY (id_file) REFERENCES files(id_file)
);
GO

CREATE TABLE prescriptions
(
	id_drug INT IDENTITY(1,1) PRIMARY KEY,
	drug VARCHAR(30) NOT NULL,
	dose VARCHAR(100) NOT NULL,
	id_patient VARCHAR(10) NOT NULL,
	FOREIGN KEY (id_patient) REFERENCES patients(id_patient)
);
GO

CREATE TABLE medical_monitoring
(
	id_monitoring INT IDENTITY(1,1) PRIMARY KEY,
	[date] DATE NOT NULL,
	id_promoter VARCHAR(10) NOT NULL,
	id_patient VARCHAR(10) NOT NULL,
	FOREIGN KEY (id_promoter) REFERENCES users(dui),
	FOREIGN KEY (id_patient) REFERENCES patients(id_patient)

);
GO
