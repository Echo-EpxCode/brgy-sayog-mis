<?php

require_once __DIR__ . '/session.php';

// ======================================
// CHECK LOGIN
// ======================================

if (!isset($_SESSION['user_id'])) {

    header("Location: ../auth/login.php");
    exit;
}
