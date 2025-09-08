<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Password updated</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
    .container { max-width: 600px; margin: auto; background: #fff; padding: 40px 30px; }
    h1 { color: #003366; }
    p { font-size: 16px; color: #333; }
    a.button { display: inline-block; padding: 12px 24px; background: #0077cc; color: #fff; text-decoration: none; border-radius: 4px; }
    .credentials { background: #f0f0f0; padding: 15px; margin: 20px 0; border-radius: 4px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Password updated</h1>
    <p>Your password has been updated. Please, log in your account and enjoy our products and services.</p>
    <div class="credentials">
      <p><strong>Email:</strong> <?= $data['email_usuario'];?></p>
      <p><strong>Password:</strong> <?= $data['password'];?></p>
    </div>
    <a href="<?= BASE_URL ?>" class="button">Website</a>
  </div>
</body>
</html>