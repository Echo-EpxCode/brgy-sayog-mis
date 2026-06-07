<?php

// ======================================
// DATABASE CONNECTION (NO DB YET)
// ======================================

$host = "localhost";
$user = "root";
$pass = "";

// connect to MySQL server only
$conn = mysqli_connect($host, $user, $pass);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ======================================
// CREATE DATABASE IF NOT EXISTS
// ======================================

$db_name = "barangay_sayog_mis";

$sql = "CREATE DATABASE IF NOT EXISTS $db_name";
mysqli_query($conn, $sql);

// select database
mysqli_select_db($conn, $db_name);

// ======================================
// CREATE TABLES
// ======================================

// USERS
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role ENUM('secretary','resident') NOT NULL DEFAULT 'resident',
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)
");

// RESIDENTS
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS residents (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  household_no VARCHAR(50),
  first_name VARCHAR(100) NOT NULL,
  middle_name VARCHAR(100),
  last_name VARCHAR(100) NOT NULL,
  suffix VARCHAR(20),
  gender ENUM('Male','Female') NOT NULL,
  birth_date DATE NOT NULL,
  civil_status VARCHAR(50),
  contact_no VARCHAR(20),
  address TEXT NOT NULL,
  occupation VARCHAR(100),
  citizenship VARCHAR(100) DEFAULT 'Filipino',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)
");

// DOCUMENT TYPES
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS document_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  document_name VARCHAR(100) NOT NULL UNIQUE,
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");

// DOCUMENT REQUESTS
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS document_requests (
  id INT AUTO_INCREMENT PRIMARY KEY,
  resident_id INT NOT NULL,
  document_type_id INT NOT NULL,
  purpose TEXT NOT NULL,
  status ENUM('Pending','Approved','Rejected','Released') DEFAULT 'Pending',
  remarks TEXT,
  requested_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  approved_by INT,
  approved_at DATETIME,
  released_at DATETIME,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (resident_id) REFERENCES residents(id) ON DELETE CASCADE,
  FOREIGN KEY (document_type_id) REFERENCES document_types(id) ON DELETE CASCADE
)
");

// CERTIFICATES
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS certificates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  request_id INT NOT NULL,
  certificate_no VARCHAR(100) UNIQUE,
  issued_date DATE NOT NULL,
  issued_by INT,
  file_path VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (request_id) REFERENCES document_requests(id) ON DELETE CASCADE
)
");

// ANNOUNCEMENTS
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS announcements (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  posted_by INT,
  status ENUM('Draft','Published') DEFAULT 'Published',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (posted_by) REFERENCES users(id) ON DELETE SET NULL
)
");

// ACTIVITY LOGS
mysqli_query($conn, "
CREATE TABLE IF NOT EXISTS activity_logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  activity TEXT NOT NULL,
  reference_id INT,
  reference_table VARCHAR(100),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
)
");

// ======================================
// SEED DATA (SAFE - NO DUPLICATES)
// ======================================

// DEFAULT DOCUMENT TYPES
mysqli_query($conn, "
INSERT INTO document_types (document_name)
SELECT 'Barangay Clearance' WHERE NOT EXISTS (
  SELECT 1 FROM document_types WHERE document_name = 'Barangay Clearance'
)
");

mysqli_query($conn, "
INSERT INTO document_types (document_name)
SELECT 'Cedula' WHERE NOT EXISTS (
  SELECT 1 FROM document_types WHERE document_name = 'Cedula'
)
");

mysqli_query($conn, "
INSERT INTO document_types (document_name)
SELECT 'Certificate of Indigency' WHERE NOT EXISTS (
  SELECT 1 FROM document_types WHERE document_name = 'Certificate of Indigency'
)
");

// DEFAULT ADMIN
$check_admin = mysqli_query($conn, "SELECT id FROM users WHERE role='secretary' LIMIT 1");

if (mysqli_num_rows($check_admin) == 0) {

    $password = password_hash("admin123", PASSWORD_DEFAULT);

    mysqli_query($conn, "
    INSERT INTO users (full_name, email, password_hash, role, status)
    VALUES ('Barangay Secretary', 'admin@barangaysayog.com', '$password', 'secretary', 'approved')
    ");
}

// ======================================
// DONE
// ======================================

echo "Database setup completed successfully.";

?>
