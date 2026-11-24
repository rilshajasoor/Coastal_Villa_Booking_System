<?php
require_once 'config.php';
 $page_title='Room Availability';

$rooms=$pdo->query("SELECT * FROM rooms WHERE room_status='Available' ORDER BY price_per_night")->fetchAll();

$results=[];
$error='';
$in=$_GET['check_in']??'';
$out=$_GET['check_out']??'';
$guests=(int)($_GET['guests']??1);

if(isset($_GET['search'])) {
    if(!$in||!$out||$out<=$in||$in<date('Y-m-d'))$error='Please select a valid check-in and check-out date.';
    elseif($guests<1)$error='Please select at least one guest.';
    else {
        
$sql="SELECT r.* FROM rooms r WHERE r.room_status='Available' AND r.max_guests>=? AND NOT EXISTS (SELECT 1 FROM bookings b WHERE b.room_id=r.room_id AND b.booking_status IN ('Pending','Confirmed') AND b.check_in < ? AND b.check_out > ?)";
        
$q=$pdo->prepare($sql);
        $q->execute([$guests,$out,$in]);
        $results=$q->fetchAll();
    }
}

require 'includes/header.php';
 ?>
<div class="form-card"><h2>Find an available room</h2><p class="muted">Choose your dates and number of guests to see suitable rooms.</p><?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif;
 ?>
<form method="get" data-validate="true"><div class="form-grid"><div class="field"><label>Check-in</label><input type="date" name="check_in" id="check_in" min="<?=date('Y-m-d')?>" required value="<?=e($in)?>"></div><div class="field"><label>Check-out</label><input type="date" name="check_out" id="check_out" min="<?=date('Y-m-d',strtotime('+1 day'))?>" required value="<?=e($out)?>"></div><div class="field"><label>Number of guests</label><input type="number" name="guests" min="1" max="20" required value="<?=e($guests)?>"></div></div><button class="btn" name="search" value="1">Search rooms</button></form></div>
<?php if(isset($_GET['search'])&&!$error): ?><section class="section"><h2>Search results</h2><?php if(!$results): ?><div class="empty">Sorry, no suitable rooms are available for the selected dates.</div><?php else: ?><div class="grid"><?php foreach($results as $r): ?><article class="room-card"><div class="room-body"><h3><?=e($r['room_name'])?></h3><p><?=e($r['description'])?></p><p>Maximum guests: <?=e($r['max_guests'])?></p><div class="price">LKR <?=number_format($r['price_per_night'])?> / night</div><a class="btn small" href="book.php?room_id=<?=$r['room_id']?>&check_in=<?=urlencode($in)?>&check_out=<?=urlencode($out)?>&guests=<?=$guests?>">Book this room</a></div></article><?php endforeach;
 ?></div><?php endif;
 ?></section><?php endif;
 ?>
<?php require 'includes/footer.php';
 ?>
