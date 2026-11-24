<?php
require_once 'config.php';
 require_login();
 $page_title='My Bookings';

$q=$pdo->prepare("SELECT b.*,r.room_name,r.room_type FROM bookings b JOIN rooms r ON b.room_id=r.room_id WHERE b.user_id=? ORDER BY b.booking_date DESC");
$q->execute([$_SESSION['user_id']]);
$bookings=$q->fetchAll();

if($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $id=(int)($_POST['booking_id']??0);
    $u=$pdo->prepare("UPDATE bookings SET booking_status='Cancelled' WHERE booking_id=? AND user_id=? AND booking_status='Pending'");
    $u->execute([$id,$_SESSION['user_id']]);
    set_flash($u->rowCount()?'Pending booking cancelled.':'Booking could not be cancelled.');
    header('Location: my-bookings.php');
    exit;
}

require 'includes/header.php';
 ?>
<h1>My Bookings</h1><p class="muted">View your reservation details and booking status.</p>
<?php if(!$bookings): ?><div class="empty"><h3>You have no bookings yet.</h3><a class="btn" href="availability.php">Find a room</a></div><?php else: ?><div class="table-wrap"><table><thead><tr><th>Room</th><th>Check-in</th><th>Check-out</th><th>Total</th><th>Status</th><th>Action</th></tr></thead><tbody><?php foreach($bookings as $b): ?><tr><td><?=e($b['room_name'])?></td><td><?=e($b['check_in'])?></td><td><?=e($b['check_out'])?></td><td>LKR <?=number_format($b['total_amount'])?></td><td><span class="status <?=e($b['booking_status'])?>"><?=e($b['booking_status'])?></span></td><td><?php if($b['booking_status']==='Pending'): ?><form method="post" onsubmit="return confirm('Cancel this pending booking?')"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><input type="hidden" name="booking_id" value="<?=$b['booking_id']?>"><button class="btn danger small">Cancel</button></form><?php else: ?>—<?php endif;
 ?></td></tr><?php endforeach;
 ?></tbody></table></div><?php endif;
 ?>
<?php require 'includes/footer.php';
 ?>
