<?php
require_once 'config.php';
 require_login();
 $page_title='Room Booking';

$room_id=(int)($_GET['room_id']??$_POST['room_id']??0);
$q=$pdo->prepare("SELECT * FROM rooms WHERE room_id=? AND room_status='Available'");
$q->execute([$room_id]);
$room=$q->fetch();

if(!$room) {
    set_flash('Please select a valid available room.','error');
    header('Location: rooms.php');
    exit;
}

$in=$_GET['check_in']??$_POST['check_in']??'';
$out=$_GET['check_out']??$_POST['check_out']??'';
$guests=(int)($_GET['guests']??$_POST['guests']??1);
$error='';

if($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $in=$_POST['check_in']??'';
    $out=$_POST['check_out']??'';
    $guests=(int)($_POST['guests']??1);
    
if(!$in||!$out||$out<=$in||$in<date('Y-m-d'))$error='Please choose valid future booking dates.';
    
elseif($guests<1||$guests>$room['max_guests'])$error='Guest count is outside this room capacity.';
    
else {
        $nights=(int)((strtotime($out)-strtotime($in))/86400);
        $total=$nights*(float)$room['price_per_night'];
        
$check=$pdo->prepare("SELECT COUNT(*) FROM bookings WHERE room_id=? AND booking_status IN ('Pending','Confirmed') AND check_in < ? AND check_out > ?");
        $check->execute([$room_id,$out,$in]);
        
if($check->fetchColumn()>0)$error='This room has just been booked for those dates. Please search again.';
        
else {
            $ins=$pdo->prepare("INSERT INTO bookings(user_id,room_id,check_in,check_out,total_amount,booking_status,booking_date,guests) VALUES(?,?,?,?,?,'Pending',NOW(),?)");
            $ins->execute([$_SESSION['user_id'],$room_id,$in,$out,$total,$guests]);
            set_flash('Your booking request has been submitted. Status: Pending.');
            header('Location: my-bookings.php');
            exit;
        }
    }
}

require 'includes/header.php';
 ?>
<div class="form-card"><h2>Complete your booking</h2><p class="muted"><?=e($room['room_name'])?> · LKR <?=number_format($room['price_per_night'])?> per night · Maximum <?=e($room['max_guests'])?> guests</p><?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif;
 ?>
<form method="post" data-validate="true"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><input type="hidden" name="room_id" value="<?=$room_id?>"><div class="form-grid"><div class="field"><label>Check-in date</label><input id="check_in" type="date" name="check_in" min="<?=date('Y-m-d')?>" required value="<?=e($in)?>"></div><div class="field"><label>Check-out date</label><input id="check_out" type="date" name="check_out" min="<?=date('Y-m-d',strtotime('+1 day'))?>" required value="<?=e($out)?>"></div><div class="field"><label>Number of guests</label><input type="number" name="guests" min="1" max="<?=e($room['max_guests'])?>" required value="<?=max(1,$guests)?>"></div></div><div class="total-box">Estimated stay: <strong id="nights_count">0 nights</strong><br>Estimated total: <strong id="estimated_total">Select valid dates</strong><span class="help"> Final amount is calculated by the server when you submit.</span></div><button class="btn">Submit booking request</button> <a class="btn secondary" href="availability.php">Back</a></form></div>
<script>document.addEventListener('DOMContentLoaded',()=>{const room=document.createElement('select');room.innerHTML='<option data-price="<?=e($room['price_per_night'])?>" selected></option>';document.querySelector('form').appendChild(room);room.id='room_id';room.style.display='none';});</script>
<?php require 'includes/footer.php';
 ?>
