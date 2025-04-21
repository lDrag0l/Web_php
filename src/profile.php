<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$userData = getUserData();

try {
    // Получаем данные клиента
    $stmt = $pdo->prepare("SELECT * FROM Клиенты WHERE Код_клиента = ?");
    $stmt->execute([$userId]);
    $client = $stmt->fetch();
    
    // Получаем данные абонемента, если он есть
    $subscription = null;
    if ($client['Код_абонемента']) {
        $stmt = $pdo->prepare("SELECT * FROM Абонементы WHERE Код_абонемента = ?");
        $stmt->execute([$client['Код_абонемента']]);
        $subscription = $stmt->fetch();
    }
    
    // Получаем группу клиента (теперь связь напрямую через поле Код_группы)
    $group = null;
    if ($client['Код_группы']) {
        $stmt = $pdo->prepare("SELECT * FROM Группы WHERE Код_группы = ?");
        $stmt->execute([$client['Код_группы']]);
        $group = $stmt->fetch();
    }
    
    // Получаем тренировки клиента
    $stmt = $pdo->prepare("
        SELECT 
            Тренировки.*,
            CONCAT(Тренеры.Фамилия, ' ', Тренеры.Имя) AS Тренер
        FROM Тренировки
        JOIN Клиенты_Тренировки ON Тренировки.Код_тренировки = Клиенты_Тренировки.Код_тренировки
        LEFT JOIN Тренеры ON Тренировки.Код_тренера = Тренеры.Код_тренера
        WHERE Клиенты_Тренировки.Код_клиента = ?
        ORDER BY Тренировки.Дата, Тренировки.Время
    ");
    $stmt->execute([$userId]);
    $trainings = $stmt->fetchAll();
    
} catch (PDOException $e) {
    die("Ошибка при получении данных: " . $e->getMessage());
}

// Функция для форматирования даты
function formatDate($dateString) {
    return date('d.m.Y', strtotime($dateString));
}

$pageTitle = "Личный кабинет";
include 'templates/header.php';
?>

<div class="container py-5" style='min-height: 100vh'>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h4><?= htmlspecialchars($client['Фамилия'] . ' ' . $client['Имя']) ?></h4>
                    <p class="text-muted">Клиент</p>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Мой абонемент</h5>
                </div>
                <div class="card-body">
                    <?php if ($subscription): ?>
                        <h6><?= htmlspecialchars($subscription['Название']) ?></h6>
                        <p>Действует с <?= formatDate($client['Начало_действия']) ?> по <?= formatDate($client['Конец_действия']) ?></p>
                        <p>Осталось дней: <?= floor((strtotime($client['Конец_действия']) - time()) / (60 * 60 * 24)) ?></p>
                    <?php else: ?>
                        <p>У вас нет активного абонемента</p>
                        <a href="subscriptions.php" class="btn btn-primary">Приобрести абонемент</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Личная информация</h5>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label">Фамилия</label>
                                <input disabled type="text" class="form-control" value="<?= htmlspecialchars($client['Фамилия']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Имя</label>
                                <input disabled type="text" class="form-control" value="<?= htmlspecialchars($client['Имя']) ?>" readonly>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Отчество</label>
                                <input disabled type="text" class="form-control" value="<?= htmlspecialchars($client['Отчество'] ?? '') ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Дата рождения</label>
                                <input disabled type="text" class="form-control" value="<?= formatDate($client['Дата_рождения']) ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Справка о здоровье</label>
                                <input disabled type="text" class="form-control" value="<?= $client['Наличие_справки_о_здоровье'] ? 'Есть' : 'Нет' ?>" readonly>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Адрес проживания</label>
                            <input disabled type="text" class="form-control" value="<?= htmlspecialchars($client['Адрес_проживания']) ?>" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input disabled type="email" class="form-control" value="<?= htmlspecialchars($client['Email']) ?>" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Телефон</label>
                            <input disabled type="tel" class="form-control" value="<?= htmlspecialchars($client['Телефон'] ?? '') ?>" readonly>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>