<?php
// Database connection and application settings
session_start();


define('DB_HOST', 'localhost');

define('DB_NAME', 'coastal_villa');

define('DB_USER', 'root');

define('DB_PASS', '');

define('SITE_NAME', 'Coastline Villa');


try {
    
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USER,
        DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
}
 catch (PDOException $e) {
    
    die('Database connection failed. Please import database.sql and check config.php.');
}


function e($value) {
    
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function is_logged_in() {
    
    return isset($_SESSION['user_id']);
}

function is_admin() {
    
    return is_logged_in() && ($_SESSION['role'] ?? '') === 'admin';
}

function require_login() {
    
    if (!is_logged_in()) {
        
        header('Location: login.php');
        
        exit;
    }
}

function require_admin() {
    
    if (!is_admin()) {
        
        header('Location: login.php');
        
        exit;
    }
}

function set_flash($message, $type = 'success') {
    
    $_SESSION['flash'] = ['message' => $message, 'type' => $type];
}

function show_flash() {
    
    if (!empty($_SESSION['flash'])) {
        
        $f = $_SESSION['flash'];
        
        echo '<div class="alert ' . e($f['type']) . '">' . e($f['message']) . '</div>';
        
        unset($_SESSION['flash']);
    }
}

function csrf_token() {
    
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    
    return $_SESSION['csrf'];
}

function verify_csrf() {
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $token = $_POST['csrf'] ?? '';
        
        if (!hash_equals($_SESSION['csrf'] ?? '', $token)) {
            
            http_response_code(403);
            
            exit('Invalid request token. Please go back and try again.');
        }
    }
}


// CHANGE THIS to your villa's real address or Google Maps place name.
define('VILLA_MAP_QUERY', 'Coastline Villa, Sri Lanka');

