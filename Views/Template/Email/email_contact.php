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
    <h1>Message received</h1>
    <p>We have received your message, we will contact you soon.</p>
    <div class="credentials">
      <p><strong>Name:</strong> <?= $data['name'];?></p>
      <p><strong>Email:</strong> <?= $data['password'];?></p>
	  <p><strong>Phone:</strong> <?= $data['phone'];?></p>
	  <p><strong>Service:</strong> <?= $data['service'];?></p>
	  <p><strong>Message:</strong> <?= $data['message'];?></p>
    </div>
    <a href="<?= BASE_URL ?>" class="button">Website</a>
  </div>
</body>
</html>
