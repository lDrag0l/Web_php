<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

$pageTitle = "Контакты";
include 'templates/header.php';

$feedbackSent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    
    if (!empty($name) && !empty($email) && !empty($message)) {
        $feedbackSent = true;
    }
}
?>

<div class="container py-5" style = 'min-height: 100vh'>
    <div class="row">
        <div class="col-lg-6">
            <h1 class="mb-4">Контакты</h1>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-map-marker-alt me-2"></i> Адрес</h3>
                    <p class="card-text">Большая Морская улица, 67, Санкт-Петербург</p>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-clock me-2"></i> Режим работы</h3>
                    <p class="card-text">
                        <strong>Пн-Пт:</strong> 7:00 - 23:00<br>
                        <strong>Сб-Вс:</strong> 8:00 - 22:00
                    </p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title"><i class="fas fa-envelope me-2"></i> Email</h3>
                    <p class="card-text">info@gym.ru</p>
                </div>
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title mb-4">Обратная связь</h2>
                    
                    <?php if ($feedbackSent): ?>
                        <div class="alert alert-success">
                            Спасибо за ваше сообщение! Мы свяжемся с вами в ближайшее время.
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Ваше имя</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Сообщение</label>
                            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Отправить</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>