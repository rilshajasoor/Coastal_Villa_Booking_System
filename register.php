<?php
require_once 'config.php';
 $page_title='Guest Registration';
 $errors=[];

if($_SERVER['REQUEST_METHOD']==='POST') {
    verify_csrf();
    
$name=trim($_POST['name']??'');
    $email=filter_var(trim($_POST['email']??''),FILTER_VALIDATE_EMAIL);
    $phone=trim($_POST['contact_number']??'');
    $pass=$_POST['password']??'';
    
if($name==='')$errors[]='Please enter your name.';
    
if(!$email)$errors[]='Please enter a valid email address.';
    
if(strlen($pass)<8)$errors[]='Password must contain at least 8 characters.';
    
if(!$errors) {
        $q=$pdo->prepare("SELECT user_id FROM users WHERE email=?");
        $q->execute([$email]);
        if($q->fetch())$errors[]='This email address is already registered.';
        else {
            $q=$pdo->prepare("INSERT INTO users(name,email,contact_number,password,role) VALUES(?,?,?,?, 'guest')");
            $q->execute([$name,$email,$phone,password_hash($pass,PASSWORD_DEFAULT)]);
            set_flash('Registration successful. Please log in.');
            header('Location: login.php');
            exit;
        }
    }
}

require 'includes/header.php';
 ?>
<div class="form-card"><h2>Create your account</h2><p class="muted">Register to make and manage your room bookings.</p><?php foreach($errors as $er): ?><div class="alert error"><?=e($er)?></div><?php endforeach;
 ?>
<form method="post" data-validate="true"><input type="hidden" name="csrf" value="<?=csrf_token()?>"><div class="field"><label>Full name</label><input name="name" required value="<?=e($_POST['name']??'')?>"></div><div class="field"><label>Email address</label><input type="email" name="email" required value="<?=e($_POST['email']??'')?>"></div><div class="field"><label>Contact number</label><input name="contact_number" required value="<?=e($_POST['contact_number']??'')?>"></div><div class="field"><label>Password</label><input type="password" name="password" minlength="8" required></div><button class="btn">Register</button></form><p>Already registered? <a href="login.php">Login here</a>.</p></div>
<?php require 'includes/footer.php';
 ?>
