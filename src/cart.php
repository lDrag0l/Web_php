<?php
require_once 'config/session.php';
require_once 'config/db_connect.php';
require_once 'functions/auth.php';
require_once 'functions/cart.php';

$pageTitle = "Корзина";
include 'templates/header.php';

$cartData = getCartItems($pdo);
?>

<div class="container py-5" style="min-height: 100vh">
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-<?= $_SESSION['message']['type'] ?> alert-dismissible fade show">
            <?= $_SESSION['message']['text'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <h1 class="text-center mb-5">Ваша корзина</h1>
    
    <?php if (empty($cartData['items'])): ?>
        <div class="alert alert-info">
            Ваша корзина пуста. <a href="subscriptions.php">Посмотрите наши абонементы</a>
        </div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table">
                <thead class="table-light">
                    <tr>
                        <th>Абонемент</th>
                        <th>Цена</th>
                        <th>Количество</th>
                        <th>Сумма</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cartData['items'] as $item): ?>
                        <tr>
                            <td>
                                <h5><?= htmlspecialchars($item['data']['Название']) ?></h5>
                                <p class="text-muted"><?= htmlspecialchars($item['data']['Описание']) ?></p>
                            </td>
                            <td><?= number_format($item['data']['Цена'], 2) ?> ₽</td>
                            <td><?= $item['quantity'] ?></td>
                            <td><?= number_format($item['data']['Цена'] * $item['quantity'], 2) ?> ₽</td>
                            <td>
                                <form action="cart_actions.php" method="POST" class="d-inline">
                                    <input type="hidden" name="action" value="remove">
                                    <input type="hidden" name="subscription_id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th colspan="3">Итого:</th>
                        <th colspan="2"><?= number_format($cartData['total'], 2) ?> ₽</th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="d-flex justify-content-between mt-4">
    <a href="subscriptions.php" class="btn btn-outline-primary" style = 'height: 40px'>Продолжить покупки</a>
    <?php if (count($cartData['items']) === 1): ?>
        <form action="cart_actions.php" method="POST" class="d-inline">
            <input type="hidden" name="action" value="checkout">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="health_certificate" id="healthCert">
                <label class="form-check-label" for="healthCert">
                    У меня есть справка о здоровье
                </label>
            </div>
            <button type="submit" class="btn btn-primary">Оформить абонемент</button>
        </form>
    <?php else: ?>
        <button class="btn btn-primary" disabled>Оформить абонемент (только 1)</button>
    <?php endif; ?>
</div>
    <?php endif; ?>
</div>

<?php include 'templates/footer.php'; ?>