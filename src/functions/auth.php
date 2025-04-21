<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function loginUser($userId, $userData) {
    $_SESSION['user_id'] = $userId;
    $_SESSION['user_data'] = $userData;
}

function logoutUser() {
    session_unset();
    session_destroy();
}

function getUserData() {
    return $_SESSION['user_data'] ?? null;
}
?>