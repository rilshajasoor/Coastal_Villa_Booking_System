<?php
require_once 'config.php';
 require_admin();
 $page_title='Admin Dashboard';

$rooms=(int)$pdo->query("SELECT COUNT(*) FROM rooms")->fetchColumn();
$users=(int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='guest'")->fetchColumn();
$bookings=(int)$pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();

$recent=$pdo->query("SELECT b.*,u.name,r.room_name FROM bookings b JOIN users u ON b.user_id=u.user_id JOIN rooms r ON b.room_id=r.room_id ORDER BY b.booking_date DESC LIMIT 8")->fetchAll();

require 'includes/header.php';
 ?>
<h1>Administrator Dashboard</h1><p class="muted">Manage villa rooms and guest reservations.</p><div class="stats"><div class="stat">Rooms<b><?=$rooms?></b></div><div class="stat">Registered guests<b><?=$users?></b></div><div class="stat">Bookings<b><?=$bookings?></b></div></div>
<div class="actions"><a class="btn" href="admin-rooms.php">Manage rooms</a><a class="btn secondary" href="admin-bookings.php">Manage bookings</a></div>
<section class="section"><h2>Recent bookings</h2><div class="table-wrap"><table><tr><th>Guest</th><th>Room</th><th>Dates</th><th>Amount</th><th>Status</th></tr><?php foreach($recent as $b): ?><tr><td><?=e($b['name'])?></td><td><?=e($b['room_name'])?></td><td><?=e($b['check_in'])?> to <?=e($b['check_out'])?></td><td>LKR <?=number_format($b['total_amount'])?></td><td><span class="status <?=e($b['booking_status'])?>"><?=e($b['booking_status'])?></span></td></tr><?php endforeach;
 ?></table></div></section>
<?php require 'includes/footer.php';
 ?>
