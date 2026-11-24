<?php
require_once 'config.php';

$page_title = 'Photo Gallery';

require 'includes/header.php';

$gallery = [
 ['title'=>'Deluxe Room','category'=>'Rooms','image'=>'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=1200&q=85'],
 ['title'=>'Comfortable Bedroom','category'=>'Rooms','image'=>'https://images.unsplash.com/photo-1616594039964-ae9021a400a0?auto=format&fit=crop&w=1200&q=85'],
 ['title'=>'Villa Suite','category'=>'Rooms','image'=>'https://images.unsplash.com/photo-1616486338812-3dadae4b4ace?auto=format&fit=crop&w=1200&q=85'],
 ['title'=>'Swimming Pool','category'=>'Facilities','image'=>'https://images.unsplash.com/photo-1572331165267-854da2b10ccc?auto=format&fit=crop&w=1200&q=85'],
 ['title'=>'Outdoor Relaxation','category'=>'Facilities','image'=>'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=1200&q=85'],
 ['title'=>'Dining Area','category'=>'Facilities','image'=>'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=85'],
 ['title'=>'Coastal View','category'=>'Surroundings','image'=>'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?auto=format&fit=crop&w=1200&q=85'],
 ['title'=>'Tropical Garden','category'=>'Surroundings','image'=>'https://images.unsplash.com/photo-1511497584788-876760111969?auto=format&fit=crop&w=1200&q=85'],
];

?>
<div class="section-head"><span class="eyebrow">Explore Coastline Villa</span><h1>Photo Gallery</h1><p class="muted">Take a look at our rooms, facilities and relaxing surroundings.</p></div>
<div class="gallery-grid">
<?php foreach ($gallery as $item): ?>
<button class="gallery-item" type="button" data-full="<?=e($item['image'])?>" data-title="<?=e($item['title'])?>" aria-label="View <?=e($item['title'])?> photo">
<img src="<?=e($item['image'])?>" alt="<?=e($item['title'])?>" loading="lazy"><span class="gallery-caption"><strong><?=e($item['title'])?></strong><small><?=e($item['category'])?></small></span>
</button>
<?php endforeach;
 ?>
</div>
<dialog class="gallery-dialog" id="galleryDialog"><button class="gallery-close" type="button" aria-label="Close">&times;</button><img id="galleryPreview" src="" alt=""><p id="galleryTitle"></p></dialog>
<?php require 'includes/footer.php';
 ?>
