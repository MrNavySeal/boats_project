<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Welcome to AquaFrame Solutions</title>
  <style>
    body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
    .container { max-width: 600px; margin: auto; background: #fff; padding: 40px 30px; }
    h1 { color: #003366; }
    p { color: #333; font-size: 16px; line-height: 1.5; }
    .credentials { background: #f0f0f0; padding: 15px; margin: 20px 0; border-radius: 4px; }
    a.button { display: inline-block; padding: 12px 24px; background: #0077cc; color: #fff; text-decoration: none; border-radius: 4px; }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome to <?= $data['company']['name'] ?></h1>
    <p>Thanks for signing up. Your account is now active and ready to use.</p>
    <p>To get started, log in to your dashboard and explore our services and products.</p>
    <a href="<?= BASE_URL; ?>" class="button">Access Your Account</a>
  </div>
</body>
</html>