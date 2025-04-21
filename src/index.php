<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

$pageTitle = "Главная - Тренажерный зал";
include 'templates/header.php';
?>

<section id="about" class="py-5">
    <div class="container">
        <h2 class="text-center mb-4">О нашем тренажерном зале</h2>
        <div class="row">
            <div class="col-md-6">
                <p>Наш тренажерный зал предлагает современное оборудование, профессиональных тренеров и индивидуальный подход к каждому клиенту. Мы работаем с 2010 года и помогли тысячам людей достичь своих целей.</p>
                <p>У нас вы найдете:</p>
                <ul>
                    <li>Более 100 единиц современного оборудования</li>
                    <li>Групповые и индивидуальные тренировки</li>
                    <li>Профессиональных тренеров с большим опытом</li>
                    <li>Различные виды абонементов</li>
                </ul>
            </div>
            <div class="col-md-6">
                <img src="assets/index.jpg" alt="Тренажерный зал" class="img-fluid rounded" style = 'width: 400px'>
            </div>
        </div>
    </div>
</section>

<section id="features" class="py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Наши преимущества</h2>
        <div class="row">
            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">
                    <i class="fas fa-dumbbell fa-3x"></i>
                </div>
                <h3>Современное оборудование</h3>
                <p>Только качественные тренажеры от ведущих производителей</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">
                    <i class="fas fa-users fa-3x"></i>
                </div>
                <h3>Профессиональные тренеры</h3>
                <p>Опытные специалисты с индивидуальным подходом</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="feature-icon mb-3">
                    <i class="fas fa-calendar-alt fa-3x"></i>
                </div>
                <h3>Гибкий график</h3>
                <p>Работаем с 7:00 до 23:00 без выходных</p>
            </div>
        </div>
    </div>
</section>

<?php include 'templates/footer.php'; ?>