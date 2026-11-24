<?php
require_once 'config.php';
 $page_title='Login';
 $error='';

if($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    $email=trim($_POST['email']??'');
    $pass=$_POST['password']??'';
    
$q=$pdo->prepare("SELECT * FROM users WHERE email=?");
    $q->execute([$email]);
    $u=$q->fetch();
    
if($u && password_verify($pass,$u['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id']=$u['user_id'];
        $_SESSION['name']=$u['name'];
        $_SESSION['role']=$u['role'];
        set_flash('Welcome back, '.$u['name'].'!');
        header('Location: '.($u['role']==='admin'?'admin.php':'my-bookings.php'));
        exit;
    }
else {
        $error='Invalid email address or password.';
    }
}

require 'includes/header.php';
 ?>
<div class="form-card"><h2>Welcome back</h2><p class="muted">Login to continue to your account.</p><?php if($error): ?><div class="alert error"><?=e($error)?></div><?php endif;
 ?>
<form method="post" data-validate="true"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><div class="field"><label>Email address</label><input type="email" name="email" required></div><div class="field"><label>Password</label><input type="password" name="password" required></div><button class="btn">Login</button></form><p>New guest? <a href="register.php">Create an account</a>.</p></div>
<?php require 'includes/footer.php';
 ?>
