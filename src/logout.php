<?php
require_once 'config/session.php';
require_once 'functions/auth.php';

if (isLoggedIn()) {
    logoutUser();
    
    $_SESSION['message'] = [
        'type' => 'success',
        'text' => 'Вы успешно вышли из системы'
    ];
    header('Location: index.php');
    exit();
} else {
    header('Location: index.php');
    exit();
}