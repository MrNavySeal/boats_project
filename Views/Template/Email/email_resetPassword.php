
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reset Your Password</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
    .container { max-width: 600px; margin: auto; background: #fff; padding: 40px 30px; }
    h1 { color: #003366; }
    p { font-size: 16px; color: #333; }
    a.button { display: inline-block; padding: 12px 24px; background: #0077cc; color: #fff; text-decoration: none; border-radius: 4px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Password Reset Request</h1>
    <p>We received a request to reset your <?= $data['company']['name'] ?> account password.</p>
    <a href="<?= $data['url_recovery']; ?>" class="button">Reset Password</a>
    <p>If you didn’t request this, you can safely ignore this email.</p>
  </div>
</body>
</html>
