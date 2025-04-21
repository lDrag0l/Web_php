<?php
require_once 'config/session.php';
require_once 'config/db_connect.php';
require_once 'functions/auth.php';
require_once 'functions/cart.php';

if (!isLoggedIn()) {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Для работы с корзиной требуется авторизация'];
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['message'] = ['type' => 'danger', 'text' => 'Некорректный метод запроса'];
    header('Location: subscriptions.php');
    exit();
}

$action = $_POST['action'] ?? '';
$subscriptionId = (int)($_POST['subscription_id'] ?? 0);

switch ($action) {
    case 'add':
        if ($subscriptionId > 0 && addToCart($subscriptionId)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Абонемент добавлен в корзину'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Ошибка при добавлении в корзину'];
        }
        break;
        
    case 'remove':
        if ($subscriptionId > 0 && removeFromCart($subscriptionId)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Абонемент удален из корзины'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Ошибка при удалении из корзины'];
        }
        break;
        
    case 'checkout':
        processCheckout($pdo);
        break;
        
    default:
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Неизвестное действие'];
}

header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? 'subscriptions.php'));
exit();

function processCheckout($pdo) {
    $cartData = getCartItems($pdo);
    
    if (empty($cartData['items'])) {
        $_SESSION['message'] = ['type' => 'warning', 'text' => 'Корзина пуста'];
        return;
    }
    
    if (count($cartData['items']) !== 1) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Можно оформить только один абонемент'];
        return;
    }
    
    try {
        $pdo->beginTransaction();
        
        $subscription = $cartData['items'][0]['data'];
        $clientId = $_SESSION['user_id'];
        
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime("+{$subscription['Срок_действия']} days"));
        
        $stmt = $pdo->prepare("
            UPDATE Клиенты 
            SET 
                Код_абонемента = ?, 
                Начало_действия = ?, 
                Конец_действия = ?,
                Наличие_справки_о_здоровье = ?
            WHERE Код_клиента = ?
        ");
        
        $hasHealthCert = isset($_POST['health_certificate']) && $_POST['health_certificate'] === 'on';
        
        $stmt->execute([
            $subscription['Код_абонемента'],
            $startDate,
            $endDate,
            $hasHealthCert ? 1 : 0,
            $clientId
        ]);
        
        clearCart();
        
        $pdo->commit();
        
        $_SESSION['message'] = [
            'type' => 'success', 
            'text' => "Абонемент '{$subscription['Название']}' успешно оформлен! Срок действия до $endDate"
        ];
        
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Ошибка при оформлении: ' . $e->getMessage()];
    }
}
?>