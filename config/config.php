<?php

// ======================================
// SANITIZE INPUT
// ======================================

function clean_input($data)
{
    return htmlspecialchars(
        trim($data),
        ENT_QUOTES,
        'UTF-8'
    );
}

// ======================================
// LOG ACTIVITY
// ======================================

function log_activity(
    $conn,
    $user_id,
    $activity,
    $reference_id = null,
    $reference_table = null
) {

    $sql = "INSERT INTO activity_logs (
                user_id,
                activity,
                reference_id,
                reference_table
            )
            VALUES (?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "isis",
        $user_id,
        $activity,
        $reference_id,
        $reference_table
    );

    mysqli_stmt_execute($stmt);
}

// ======================================
// GENERATE CERTIFICATE NUMBER
// ======================================

function generate_certificate_no()
{
    return 'CERT-' . date('YmdHis');
}

// ======================================
// GET FULL NAME
// ======================================

function get_full_name($first, $middle, $last, $suffix = '')
{
    return trim(
        $first . ' ' .
        $middle . ' ' .
        $last . ' ' .
        $suffix
    );
}

// ======================================
// FORMAT DATE
// ======================================

function format_date($date)
{
    return date(
        'F d, Y',
        strtotime($date)
    );
}

// ======================================
// REDIRECT WITH MESSAGE
// ======================================

function redirect($url)
{
    header("Location: $url");
    exit;
}

// ======================================
// CHECK ROLE
// ======================================

function has_role($role)
{
    return isset($_SESSION['role'])
        && $_SESSION['role'] === $role;
}
