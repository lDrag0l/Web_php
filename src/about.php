<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

$pageTitle = "О нашем зале";
include 'templates/header.php';
?>

<div class="container py-5">
    <div class="row" style = 'min=height: 100vh'>
        <div class="col-lg-8 mx-auto">
            <h1 class="text-center mb-5">О нашем тренажерном зале</h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">Наша история</h2>
                    <p class="card-text">Наш тренажерный зал был основан в 2010 году с целью создания пространства, где каждый может работать над своим телом и здоровьем. За эти годы мы выросли из небольшого зала в современный фитнес-центр с профессиональным оборудованием и командой опытных тренеров.</p>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">Наши ценности</h2>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Индивидуальный подход к каждому клиенту
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Профессионализм и опыт наших тренеров
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Современное и безопасное оборудование
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Дружелюбная атмосфера и комфорт
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h2 class="card-title">Наши тренеры</h2>
                    <p class="card-text">В нашем зале работают только сертифицированные специалисты с большим опытом работы. Каждый тренер имеет профильное образование и регулярно повышает свою квалификацию.</p>
                    
                    <?php
                    try {
                        $stmt = $pdo->query("SELECT * FROM Тренеры ORDER BY Фамилия");
                        $trainers = $stmt->fetchAll();
                        
                        if ($trainers): ?>
                            <div class="row mt-4">
                                <?php foreach ($trainers as $trainer): ?>
                                    <div class="col-md-6 mb-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($trainer['Фамилия'] . ' ' . htmlspecialchars($trainer['Имя'] . ' ' . htmlspecialchars($trainer['Отчество']))) ?></h5>
                                                <p class="card-text">
                                                    <strong>Разряд:</strong> <?= htmlspecialchars($trainer['Разряд']) ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif;
                    } catch (PDOException $e) {
                        echo '<div class="alert alert-warning">Не удалось загрузить информацию о тренерах</div>';
                    }
                    ?>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Наше оборудование</h2>
                    <p class="card-text">Мы используем только профессиональное оборудование от ведущих мировых производителей: TechnoGym, Life Fitness, Hammer Strength и других. Все тренажеры регулярно обслуживаются и обновляются.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>