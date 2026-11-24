<?php
require_once 'config.php';
 require_admin();
 $page_title='Room Management';
$error='';

if($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $action=$_POST['action']??'';
    
if($action==='delete') {
        $id=(int)$_POST['room_id'];
        $q=$pdo->prepare("UPDATE rooms SET room_status='Inactive' WHERE room_id=?");
        $q->execute([$id]);
        set_flash('Room deactivated.');
        header('Location: admin-rooms.php');
        exit;
    }

$name=trim($_POST['room_name']??'');
    $type=trim($_POST['room_type']??'');
    $desc=trim($_POST['description']??'');
    $price=(float)($_POST['price_per_night']??0);
    $max=(int)($_POST['max_guests']??0);
    $status=$_POST['room_status']??'Available';
    $id=(int)($_POST['room_id']??0);
    
if($name===''||$type===''||$price<=0||$max<1)$error='Please complete all room details with valid values.';
    
else {
        if($id) {
            $q=$pdo->prepare("UPDATE rooms SET room_name=?,room_type=?,description=?,price_per_night=?,max_guests=?,room_status=? WHERE room_id=?");
            $q->execute([$name,$type,$desc,$price,$max,$status,$id]);
        }
else {
            $q=$pdo->prepare("INSERT INTO rooms(room_name,room_type,description,price_per_night,max_guests,room_status) VALUES(?,?,?,?,?,?)");
            $q->execute([$name,$type,$desc,$price,$max,$status]);
        }
set_flash('Room details saved.');
        header('Location: admin-rooms.php');
        exit;
    }
}

$edit=null;
if(isset($_GET['edit'])) {
    $q=$pdo->prepare("SELECT * FROM rooms WHERE room_id=?");
    $q->execute([(int)$_GET['edit']]);
    $edit=$q->fetch();
}

$rooms=$pdo->query("SELECT * FROM rooms ORDER BY room_id DESC")->fetchAll();
require 'includes/header.php';
 ?>
<h1>Room Management</h1><p class="muted">Add, view, update or deactivate accommodation records.</p>
<div class="form-card"><h2><?=$edit?'Update room':'Add a new room'?></h2><?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif;
 ?><form method="post"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><input type="hidden" name="room_id" value="<?=e($edit['room_id']??'')?>"><div class="form-grid"><div class="field"><label>Room name</label><input name="room_name" required value="<?=e($edit['room_name']??'')?>"></div><div class="field"><label>Room type</label><input name="room_type" required placeholder="Deluxe / Family / Standard" value="<?=e($edit['room_type']??'')?>"></div><div class="field"><label>Price per night (LKR)</label><input type="number" name="price_per_night" min="1" step="0.01" required value="<?=e($edit['price_per_night']??'')?>"></div><div class="field"><label>Maximum guests</label><input type="number" name="max_guests" min="1" required value="<?=e($edit['max_guests']??'2')?>"></div><div class="field"><label>Status</label><select name="room_status"><option>Available</option><option <?=($edit['room_status']??'')==='Inactive'?'selected':''?>>Inactive</option></select></div><div class="field full"><label>Description and facilities</label><textarea name="description" rows="3"><?=e($edit['description']??'')?></textarea></div></div><button class="btn">Save room</button> <?php if($edit): ?><a class="btn secondary" href="admin-rooms.php">Cancel edit</a><?php endif;
 ?></form></div>
<h2>All rooms</h2><div class="table-wrap"><table><tr><th>Name</th><th>Type</th><th>Price/night</th><th>Guests</th><th>Status</th><th>Actions</th></tr><?php foreach($rooms as $r): ?><tr><td><?=e($r['room_name'])?></td><td><?=e($r['room_type'])?></td><td>LKR <?=number_format($r['price_per_night'])?></td><td><?=e($r['max_guests'])?></td><td><?=e($r['room_status'])?></td><td><a class="btn small" href="?edit=<?=$r['room_id']?>">Edit</a> <form method="post" style="display:inline" onsubmit="return confirm('Deactivate this room?')"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><input type="hidden" name="action" value="delete"><input type="hidden" name="room_id" value="<?=$r['room_id']?>"><button class="btn danger small">Deactivate</button></form></td></tr><?php endforeach;
 ?></table></div>
<?php require 'includes/footer.php';
 ?>
