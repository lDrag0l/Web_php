<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

$pageTitle = "Тренировки";
include 'templates/header.php';

$sortOrder = isset($_GET['sort']) && $_GET['sort'] === 'desc' ? 'DESC' : 'ASC';
$nextSortOrder = $sortOrder === 'ASC' ? 'desc' : 'asc';

try {
    $stmt = $pdo->query("
        SELECT 
            Тренировки.Код_тренировки,
            Тренировки.Дата,
            Тренировки.Время,
            Тренировки.Код_группы,
            Группы.Номер_секции,
            CONCAT(Тренеры.Фамилия, ' ', Тренеры.Имя) AS Тренер
        FROM Тренировки
        LEFT JOIN Группы ON Тренировки.Код_группы = Группы.Код_группы
        LEFT JOIN Тренеры ON Тренировки.Код_тренера = Тренеры.Код_тренера
        ORDER BY Тренировки.Дата $sortOrder, Тренировки.Время
    ");
    $trainings = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Ошибка при получении данных: " . $e->getMessage());
}
?>

<div class="container py-5" style='min-height: 100vh'>
    <h1 class="text-center mb-5">Расписание тренировок</h1>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>
                        <a href="?sort=<?= $nextSortOrder ?>" class="text-white text-decoration-none">
                            Дата 
                            <?php if ($sortOrder === 'ASC'): ?>
                                <i class="bi bi-arrow-up"></i>
                            <?php else: ?>
                                <i class="bi bi-arrow-down"></i>
                            <?php endif; ?>
                        </a>
                    </th>
                    <th>Время</th>
                    <th>Группа</th>
                    <th>Тренер</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($trainings as $training): ?>
                    <tr>
                        <td><?= date('d.m.Y', strtotime($training['Дата'])) ?></td>
                        <td><?= substr(htmlspecialchars($training['Время']), 0, 5) ?></td>
                        <td>
                            <?php if ($training['Код_группы']): ?>
                                Группа #<?= htmlspecialchars($training['Код_группы']) ?> 
                                (Секция <?= htmlspecialchars($training['Номер_секции']) ?>)
                            <?php else: ?>
                                Индивидуальная
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($training['Тренер'] ?? 'Не назначен') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'templates/footer.php'; ?>