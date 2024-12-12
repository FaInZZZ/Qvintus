<?php
    include_once 'includes/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="assets/css/style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Form</title>
  
</head>
<body>
    <div class="container mt-5 mb-5">
        <h2 class="text-center mb-4">Contact Us</h2>
        <form action="contact_process.php" method="POST" class="p-4 border rounded">
            <div class="mb-3">
                <label for="fullName" class="form-label">Full Name</label>
                <input type="text" id="fullName" name="fullName" class="form-control" placeholder="Enter your full name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea id="message" name="message" class="form-control" rows="5" placeholder="Write your message here" required></textarea>
            </div>
            <button type="submit" class="btn custom-btn w-100">Send</button>
        </form>
    </div>


    <?php
    include_once 'includes/footer.php';
?>
</body>
</html>
