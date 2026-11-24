<?php
require_once 'config.php';

$page_title = 'Welcome';

$rooms = $pdo->query("SELECT * FROM rooms WHERE room_status='Available' ORDER BY price_per_night LIMIT 3")->fetchAll();

require 'includes/header.php';

?>
<section class="hero"><div class="hero-content"><span class="eyebrow">A little closer to paradise</span><h1>Wake up to the ocean.</h1><p>Relax, recharge and enjoy the warm hospitality of Sri Lanka at Coastline Villa.</p><a class="btn" href="availability.php">Book your stay</a></div></section>
<section class="section"><div class="section-head"><span class="eyebrow">Welcome to Coastline</span><h2>Your peaceful coastal escape</h2><p class="muted">A comfortable place to slow down, explore the coast and create wonderful memories.</p></div>
<div class="features"><div class="feature"><strong>Beautiful coastal setting</strong><span class="muted">Enjoy a relaxing stay close to Sri Lanka's beaches.</span></div><div class="feature"><strong>Comfortable rooms</strong><span class="muted">Choose accommodation to suit couples, families and friends.</span></div><div class="feature"><strong>Simple reservations</strong><span class="muted">Check dates and send your booking request online.</span></div></div></section>
<section class="section"><div class="section-head"><span class="eyebrow">Stay with us</span><h2>Featured rooms</h2><p class="muted">Find the right space for your next getaway.</p></div>
<div class="grid"><?php foreach($rooms as $r): ?><article class="room-card"><div class="room-image" style="background-image:url('https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=900&q=80')"></div><div class="room-body"><h3><?=e($r['room_name'])?></h3><p class="muted"><?=e($r['description'])?></p><div class="price">LKR <?=number_format($r['price_per_night'])?> <small>/ night</small></div><a class="btn small" href="availability.php">Check availability</a></div></article><?php endforeach;
 ?></div>
<?php if(!$rooms): ?><p class="empty">Rooms will be displayed here once the administrator adds them.</p><?php endif;
 ?></section>
<section class="section gallery-promo"><div><span class="eyebrow">See more before you book</span><h2>Explore the villa</h2><p class="muted">Browse photos of our rooms and facilities, then find us on the map.</p><div class="actions"><a class="btn" href="gallery.php">View photo gallery</a><a class="btn secondary" href="location.php">View location map</a></div></div><img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1000&q=80" alt="Villa swimming pool and tropical surroundings" loading="lazy"></section>
<?php require 'includes/footer.php';
 ?>
