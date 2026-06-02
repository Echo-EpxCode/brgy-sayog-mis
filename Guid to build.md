1. Database Setup
2. Login System
3. Registration System
4. Dashboard
5. Resident Management
6. Registration Approval
7. Document Requests
8. Certificate Generation
9. Announcements
10. Reports
11. Activity Logs

Recommended Session Variables
After successful login:

<?php
$_SESSION['user_id']   = $user['id'];
$_SESSION['full_name'] = $user['full_name'];
$_SESSION['role']      = $user['role'];
$_SESSION['status']    = $user['status'];
?>

Secretary Page Protection
Example:
<?php
require '../config/session.php';

if (
    !isset($_SESSION['user_id']) ||
    $_SESSION['role'] !== 'secretary'
) {
    header('Location: ../auth/login.php');
    exit;
}

Email:
admin@barangaysayog.com
Password:
admin123
