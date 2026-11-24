<?php require_once __DIR__ . '/../config.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($page_title ?? SITE_NAME) ?> | <?= SITE_NAME ?></title>
  <link rel="stylesheet" href="assets/style.css">
  <script defer src="assets/app.js"></script>
</head>
<body>
<header class="site-header">
  <a class="brand" href="index.php"><span class="brand-mark">CV</span><span>Coastline <small>VILLA</small></span></a>
  <button class="menu-toggle" aria-label="Toggle navigation" onclick="document.querySelector('.nav-links').classList.toggle('open')">☰</button>
  <nav class="nav-links">
    <a href="index.php">Home</a><a href="rooms.php">Rooms</a><a href="gallery.php">Gallery</a><a href="location.php">Location</a><a href="availability.php">Availability</a>
    <?php if (is_logged_in()): ?>
      <a href="my-bookings.php">My Bookings</a>
      <?php if (is_admin()): ?><a href="admin.php">Admin</a><?php endif;
 ?>
      <a class="nav-cta" href="logout.php">Logout</a>
    <?php else: ?>
      <a href="login.php">Login</a><a class="nav-cta" href="register.php">Register</a>
    <?php endif;
 ?>
  </nav>
</header>
<main class="container">
<?php show_flash();
 ?>
