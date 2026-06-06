<?php

// ======================================
// DATABASE CONFIGURATION
// ======================================

$host = "localhost";
$user = "root";
$password = "";
$database = "barangay_sayog_mis";

// ======================================
// CONNECT TO MYSQL SERVER
// ======================================

$conn = mysqli_connect($host, $user, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ======================================
// CREATE DATABASE
// ======================================

$sql = "CREATE DATABASE IF NOT EXISTS `$database`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci";

if (!mysqli_query($conn, $sql)) {
    die("Database creation failed: " . mysqli_error($conn));
}

// ======================================
// SELECT DATABASE
// ======================================

mysqli_select_db($conn, $database);

// ======================================
// USERS TABLE
// ======================================

$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('secretary','resident') NOT NULL DEFAULT 'resident',
    status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

mysqli_query($conn, $sql);

// ======================================
// RESIDENTS TABLE
// ======================================

$sql = "CREATE TABLE IF NOT EXISTS residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    household_no VARCHAR(50) DEFAULT NULL,
    first_name VARCHAR(100) NOT NULL,
    middle_name VARCHAR(100) DEFAULT NULL,
    last_name VARCHAR(100) NOT NULL,
    suffix VARCHAR(20) DEFAULT NULL,
    gender ENUM('Male','Female') NOT NULL,
    birth_date DATE NOT NULL,
    civil_status VARCHAR(50) DEFAULT NULL,
    contact_no VARCHAR(20) DEFAULT NULL,
    address TEXT NOT NULL,
    occupation VARCHAR(100) DEFAULT NULL,
    citizenship VARCHAR(100) DEFAULT 'Filipino',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_resident_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE
)";

mysqli_query($conn, $sql);

// ======================================
// DOCUMENT TYPES
// ======================================

$sql = "CREATE TABLE IF NOT EXISTS document_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    document_name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

mysqli_query($conn, $sql);

// ======================================
// DOCUMENT REQUESTS
// ======================================

$sql = "CREATE TABLE IF NOT EXISTS document_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resident_id INT NOT NULL,
    document_type_id INT NOT NULL,

    purpose TEXT NOT NULL,

    status ENUM(
        'Pending',
        'Approved',
        'Rejected',
        'Released'
    ) NOT NULL DEFAULT 'Pending',

    remarks TEXT DEFAULT NULL,

    requested_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    approved_by INT DEFAULT NULL,
    approved_at DATETIME DEFAULT NULL,
    released_at DATETIME DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_request_resident
    FOREIGN KEY (resident_id)
    REFERENCES residents(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_request_document
    FOREIGN KEY (document_type_id)
    REFERENCES document_types(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_request_approver
    FOREIGN KEY (approved_by)
    REFERENCES users(id)
    ON DELETE SET NULL
)";

mysqli_query($conn, $sql);

// ======================================
// CERTIFICATES
// ======================================

$sql = "CREATE TABLE IF NOT EXISTS certificates (
    id INT AUTO_INCREMENT PRIMARY KEY,

    request_id INT NOT NULL,

    certificate_no VARCHAR(100) NOT NULL UNIQUE,

    issued_date DATE NOT NULL,

    issued_by INT DEFAULT NULL,

    file_path VARCHAR(255) DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_certificate_request
    FOREIGN KEY (request_id)
    REFERENCES document_requests(id)
    ON DELETE CASCADE,

    CONSTRAINT fk_certificate_user
    FOREIGN KEY (issued_by)
    REFERENCES users(id)
    ON DELETE SET NULL
)";

mysqli_query($conn, $sql);

// ======================================
// ANNOUNCEMENTS
// ======================================

$sql = "CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,

    title VARCHAR(255) NOT NULL,

    content TEXT NOT NULL,

    posted_by INT DEFAULT NULL,

    status ENUM('Draft','Published')
    DEFAULT 'Published',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_announcement_user
    FOREIGN KEY (posted_by)
    REFERENCES users(id)
    ON DELETE SET NULL
)";

mysqli_query($conn, $sql);

// ======================================
// ACTIVITY LOGS
// ======================================

$sql = "CREATE TABLE IF NOT EXISTS activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT DEFAULT NULL,

    activity TEXT NOT NULL,

    reference_id INT DEFAULT NULL,

    reference_table VARCHAR(100) DEFAULT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_activity_user
    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE SET NULL
)";

mysqli_query($conn, $sql);

// ======================================
// INSERT DOCUMENT TYPES
// ======================================

$documents = [
    'Barangay Clearance',
    'Cedula',
    'Certificate of Indigency'
];

foreach ($documents as $document) {

    $check = mysqli_query(
        $conn,
        "SELECT id FROM document_types
         WHERE document_name = '$document'"
    );

    if (mysqli_num_rows($check) == 0) {

        mysqli_query(
            $conn,
            "INSERT INTO document_types
            (document_name)
            VALUES ('$document')"
        );
    }
}

// ======================================
// DEFAULT SECRETARY ACCOUNT
// ======================================

$email = "admin@barangaysayog.com";

$check = mysqli_query(
    $conn,
    "SELECT id FROM users
     WHERE email = '$email'"
);

if (mysqli_num_rows($check) == 0) {

    $password_hash = password_hash(
        "admin123",
        PASSWORD_DEFAULT
    );

    mysqli_query(
        $conn,
        "INSERT INTO users (
            full_name,
            email,
            password_hash,
            role,
            status
        )
        VALUES (
            'Barangay Secretary',
            '$email',
            '$password_hash',
            'secretary',
            'approved'
        )"
    );
}

// ======================================
// SUCCESS
// ======================================

// echo "
// <h3>Barangay Sayog MIS Setup Completed Successfully!</h3>
// <p>Default Secretary Account:</p>
// <p>Email: admin@barangaysayog.com</p>
// <p>Password: admin123</p>
// ";
?>
