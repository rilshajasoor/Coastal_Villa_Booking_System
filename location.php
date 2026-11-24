<?php
require_once 'config.php';

$page_title = 'Find Us';

require 'includes/header.php';

$mapQuery = defined('VILLA_MAP_QUERY') ? VILLA_MAP_QUERY : 'Sri Lanka';

?>
<div class="section-head"><span class="eyebrow">Plan your visit</span><h1>Find Coastline Villa</h1><p class="muted">Use the interactive map below to explore the villa location.</p></div>
<section class="location-panel">
 <div class="location-copy"><h2>Our Location</h2><p>Find directions and explore the surrounding area using the map.</p><p class="help"><strong>Important:</strong> The map currently uses the sample location setting. Update <code>VILLA_MAP_QUERY</code> in <code>config.php</code> with your villa's real address or Google Maps place name.</p><a class="btn" target="_blank" rel="noopener" href="https://www.google.com/maps/search/?api=1&query=<?=rawurlencode($mapQuery)?>">Open directions in Google Maps</a></div>
 <div class="map-frame"><iframe title="Map showing Coastline Villa location" src="https://maps.google.com/maps?q=<?=rawurlencode($mapQuery)?>&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe></div>
</section>
<?php require 'includes/footer.php';
 ?>
