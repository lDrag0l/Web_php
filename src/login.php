<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

if (isLoggedIn()) {
    header("Location: profile.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM Клиенты WHERE Email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user && password_verify($password, $user['Пароль'])) {
            loginUser($user['Код_клиента'], $user);
            header("Location: profile.php");
            exit();
        } else {
            $error = "Неверный email или пароль";
        }
    } catch (PDOException $e) {
        $error = "Ошибка при авторизации: " . $e->getMessage();
    }
}

$pageTitle = "Авторизация";
include 'templates/header.php';
?>

<div class="container py-5" style = 'min-height: 100vh'>
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Вход в личный кабинет</h3>
                    
                    <?php if ($error): ?>
                        <div class="alert alert-danger"><?= $error ?></div>
                    <?php endif; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Войти</button>
                    </form>
                    
                    <div class="mt-3 text-center">
                        <p>Еще нет аккаунта? <a href="register.php">Зарегистрируйтесь</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>