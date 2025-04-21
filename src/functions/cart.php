<?php
function initCart() {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = [
            'subscriptions' => []
        ];
    }
}

function getCart() {
    initCart();
    return $_SESSION['cart'];
}

function addToCart($subscriptionId) {
    initCart();
    
    $subscriptionId = (int)$subscriptionId;
    if ($subscriptionId <= 0) return false;
    
    if (!isset($_SESSION['cart']['subscriptions'][$subscriptionId])) {
        $_SESSION['cart']['subscriptions'][$subscriptionId] = 0;
    }
    
    $_SESSION['cart']['subscriptions'][$subscriptionId]++;
    return true;
}

function removeFromCart($subscriptionId) {
    initCart();
    
    $subscriptionId = (int)$subscriptionId;
    if (isset($_SESSION['cart']['subscriptions'][$subscriptionId])) {
        unset($_SESSION['cart']['subscriptions'][$subscriptionId]);
        return true;
    }
    
    return false;
}

function clearCart() {
    unset($_SESSION['cart']);
}

function getCartItems($pdo) {
    initCart();
    
    $items = [];
    $total = 0;
    
    if (!empty($_SESSION['cart']['subscriptions'])) {
        $ids = array_keys($_SESSION['cart']['subscriptions']);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $stmt = $pdo->prepare("
            SELECT 
                А.*, 
                TIMESTAMPDIFF(DAY, CURDATE(), DATE_ADD(CURDATE(), INTERVAL А.Срок_действия DAY)) as Дней_действия
            FROM Абонементы А 
            WHERE Код_абонемента IN ($placeholders)
        ");
        $stmt->execute($ids);
        $subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($subscriptions as $subscription) {
            $id = $subscription['Код_абонемента'];
            $items[] = [
                'id' => $id,
                'data' => $subscription,
                'quantity' => $_SESSION['cart']['subscriptions'][$id]
            ];
            $total += $subscription['Цена'] * $_SESSION['cart']['subscriptions'][$id];
        }
    }
    
    return [
        'items' => $items,
        'total' => $total
    ];
}
?>