<?php
require_once 'config.php';
 require_admin();
 $page_title='Booking Management';

if($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $id=(int)($_POST['booking_id']??0);
    $status=$_POST['booking_status']??'';
    if(in_array($status,['Confirmed','Cancelled','Pending'],true)) {
        $q=$pdo->prepare("UPDATE bookings SET booking_status=? WHERE booking_id=?");
        $q->execute([$status,$id]);
        set_flash('Booking status updated.');
    }
header('Location: admin-bookings.php');
    exit;
}

$rows=$pdo->query("SELECT b.*,u.name,u.email,u.contact_number,r.room_name FROM bookings b JOIN users u ON b.user_id=u.user_id JOIN rooms r ON b.room_id=r.room_id ORDER BY b.booking_date DESC")->fetchAll();
require 'includes/header.php';
 ?>
<h1>Booking Management</h1><p class="muted">Review guest requests and confirm or cancel reservations.</p><div class="table-wrap"><table><tr><th>Guest details</th><th>Room</th><th>Dates</th><th>Guests</th><th>Total</th><th>Status / Update</th></tr><?php foreach($rows as $b): ?><tr><td><?=e($b['name'])?><br><small><?=e($b['email'])?><br><?=e($b['contact_number'])?></small></td><td><?=e($b['room_name'])?></td><td><?=e($b['check_in'])?><br>to <?=e($b['check_out'])?></td><td><?=e($b['guests'])?></td><td>LKR <?=number_format($b['total_amount'])?></td><td><span class="status <?=e($b['booking_status'])?>"><?=e($b['booking_status'])?></span><form method="post" style="margin-top:8px"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><input type="hidden" name="booking_id" value="<?=$b['booking_id']?>"><select name="booking_status"><option>Pending</option><option>Confirmed</option><option>Cancelled</option></select><button class="btn small" style="margin-top:5px">Update</button></form></td></tr><?php endforeach;
 ?></table></div>
<?php require 'includes/footer.php';
 ?>
