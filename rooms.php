<?php
require_once 'config.php';
 $page_title='Rooms';

$rooms=$pdo->query("SELECT * FROM rooms WHERE room_status='Available' ORDER BY price_per_night")->fetchAll();

require 'includes/header.php';
 ?>
<div class="section-head"><span class="eyebrow">Find your space</span><h1>Rooms & Accommodation</h1><p class="muted">Explore our available room types, facilities and nightly rates.</p></div>
<div class="grid"><?php foreach($rooms as $r): ?><article class="room-card"><div class="room-image" style="background-image:url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80')"></div><div class="room-body"><h3><?=e($r['room_name'])?></h3><span class="tag"><?=e($r['room_type'])?></span><span class="tag">Up to <?=e($r['max_guests'])?> guests</span><p class="muted"><?=e($r['description'])?></p><div class="price">LKR <?=number_format($r['price_per_night'])?> / night</div><div class="actions"><a class="btn small" href="availability.php">Book this room</a></div></div></article><?php endforeach;
 ?></div>
<?php if(!$rooms): ?><div class="empty">No rooms are currently available.</div><?php endif;
 ?>
<?php require 'includes/footer.php';
 ?>
