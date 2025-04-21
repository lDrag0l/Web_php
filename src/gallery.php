<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

$pageTitle = "Галерея";
include 'templates/header.php';
?>

<div class="container py-5" style = 'min-height: 100vh'>
    <h1 class="text-center mb-5">Галерея нашего зала</h1>
    
    <div class="row g-4">
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="assets/zal1.jpg" class="img-fluid rounded" alt="Зал кардиотренажеров" style = 'width: 400px; height: 300px'>
                <div class="p-3">
                    <h5>Зал кардиотренажеров</h5>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="assets/zal2.jpg" class="img-fluid rounded" alt="Силовая зона" style = 'width: 400px; height: 300px'>
                <div class="p-3">
                    <h5>Силовая зона</h5>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="assets/zal3.jpg" class="img-fluid rounded" alt="Зона свободных весов" style = 'width: 400px; height: 300px'>
                <div class="p-3">
                    <h5>Зона свободных весов</h5>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="assets/zal4.jpg" class="img-fluid rounded" alt="Групповые тренировки" style = 'width: 400px; height: 300px'>
                <div class="p-3">
                    <h5>Групповые тренировки</h5>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="assets/zal5.jpg" class="img-fluid rounded" alt="Функциональный тренинг" style = 'width: 400px; height: 300px'>
                <div class="p-3">
                    <h5>Функциональный тренинг</h5>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="gallery-item">
                <img src="assets/zal6.jpg" class="img-fluid rounded" alt="Зона растяжки" style = 'width: 400px; height: 300px'>
                <div class="p-3">
                    <h5>Зона растяжки</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>