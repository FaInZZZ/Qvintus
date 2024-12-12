<?php
include_once 'includes/config.php';
include_once 'includes/functions.php';
$user->checkLoginStatus();
$user->checkUserRole(300);

if (!isset($_SESSION['user_id'])) {
    
}

$userId = $_SESSION['user_id'];

$user = getUserDetails($pdo, $userId);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u_email = $_POST['u_email'];
    $u_password = $_POST['u_password'];

    $result = updatecurrentUser($pdo, $userId, $u_email, $u_password, $user['u_role_fk']);

   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Account</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Edit Account</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php elseif (isset($_GET['success'])): ?>
            <div class="alert alert-success">Account updated successfully.</div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="form-group">
                <label for="u_name">Username:</label>
                <input type="text" id="u_name" name="u_name" class="form-control" value="<?= htmlspecialchars($user['u_name']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="u_email">Email</label>
                <input type="email" id="u_email" name="u_email" class="form-control" value="<?= htmlspecialchars($user['u_email']); ?>" required>
            </div>

            <div class="form-group mb-2">
                <label for="u_password">New Password (leave blank to keep unchanged)</label>
                <input type="password" id="u_password" name="u_password" class="form-control">
            </div>

            <button type="submit" class="btn custom-btn">Update Account</button>
        </form>
    </div>
    <?php include_once 'includes/footerfixed.php'; ?>
</body>
</html>
