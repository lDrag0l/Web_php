<?php
require_once 'config/session.php';
require_once 'config/db_connect.php';
require_once 'functions/auth.php';
require_once 'functions/cart.php';

$pageTitle = "Абонементы";
include 'templates/header.php';

try {
    $stmt = $pdo->query("SELECT * FROM Абонементы ORDER BY Цена");
    $subscriptions = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Ошибка при получении данных: " . $e->getMessage());
}
?>

<div class="container py-5" style = 'min-height: 100vh'>
    <h1 class="text-center mb-5">Абонементы</h1>
    
    <div class="row">
        <?php foreach ($subscriptions as $subscription): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-primary text-white">
                        <h4 class="text-center"><?= htmlspecialchars($subscription['Название']) ?></h4>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title pricing-card-title text-center"><?= $subscription['Цена'] ?> ₽</h2>
                        <ul class="list-unstyled mt-3 mb-4">
                            <li><?= $subscription['Описание'] ?></li>
                            <li>Срок действия: <?= $subscription['Срок_действия'] ?> дней</li>
                            <li>Количество посещений: <?= $subscription['Количество_посещений'] ?></li>
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <?php if (isLoggedIn()): ?>
                    <form action="cart_actions.php" method="POST">
                                <input type="hidden" name="action" value="add">
                                <input type="hidden" name="subscription_id" value="<?= $subscription['Код_абонемента'] ?>">
                        <button type="submit" class="btn btn-lg btn-outline-primary">
                                Добавить в корзину
                            <?php if (isset($_SESSION['cart']['subscriptions'][$subscription['Код_абонемента']])): ?>
                                (<?= $_SESSION['cart']['subscriptions'][$subscription['Код_абонемента']] ?>)
                            <?php endif; ?>
                        </button>
                    </form>
                <?php else: ?>
                    <a href="login.php" class="btn btn-lg btn-outline-primary">Войдите для покупки</a>
                <?php endif; ?>
            </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'templates/footer.php'; ?>