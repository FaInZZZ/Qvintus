<?php
include_once 'includes/config.php';
include_once 'includes/header.php';
include_once 'includes/functions.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $userId = $_GET['id'];


    $user = getUserDetails($pdo, $userId);
    if (!$user) {
        die('<div class="alert alert-success" role="alert" </div>');
    }

    
    $roles = getRoles($pdo);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $u_id = $_POST['u_id'];
        $u_email = $_POST['u_email'];
        $u_password = $_POST['u_password'];
        $u_role_fk = $_POST['u_role_fk'];

        $result = updateUser($pdo, $u_id, $u_email, $u_password, $u_role_fk);  }
} else {
    die('<div class="alert alert-danger" role="alert">
  Invalid request
</div>
');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
    <div class="container mt-3">
        <h1>Edit User</h1>
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php elseif (isset($_GET['success'])): ?>
            <div class="alert alert-success">User updated successfully.</div>
        <?php endif; ?>

        <form action="" method="POST">
            <input type="hidden" name="u_id" value="<?= htmlspecialchars($user['u_id']); ?>">

            <div class="form-group">
                <label for="u_name">Username:</label>
                <input type="text" id="u_name" name="u_name" class="form-control" value="<?= htmlspecialchars($user['u_name']); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="u_email">Email</label>
                <input type="email" id="u_email" name="u_email" class="form-control" value="<?= htmlspecialchars($user['u_email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="u_password">New Password (leave blank to keep unchanged)</label>
                <input type="password" id="u_password" name="u_password" class="form-control">
            </div>

            <div class="form-group mb-3">
                <label for="u_role_fk">Role</label>
                <select id="u_role_fk" name="u_role_fk" class="form-control" required>
                    <?php foreach ($roles as $role): ?>
                        <option value="<?= htmlspecialchars($role['r_id']); ?>" <?= $user['u_role_fk'] == $role['r_id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($role['r_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn custom-btn">Update User</button>
        </form>
    </div>
</body>
</html>
