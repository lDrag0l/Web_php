<?php
require_once 'config/db_connect.php';
require_once 'functions/auth.php';

if (isLoggedIn()) {
    header("Location: profile.php");
    exit();
}

$errors = [];
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $surname = trim($_POST['surname'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $patronymic = trim($_POST['patronymic'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';
    $passwordConfirm = $_POST['password_confirm'] ?? '';
    $healthCertificate = isset($_POST['health_certificate']) ? 1 : 0;
    
    if (empty($surname)) $errors[] = "Фамилия обязательна для заполнения";
    if (empty($name)) $errors[] = "Имя обязательно для заполнения";
    if (empty($birthdate)) $errors[] = "Дата рождения обязательна";
    if (empty($address)) $errors[] = "Адрес обязателен";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Укажите корректный email";
    if (empty($phone)) $errors[] = "Телефон обязателен";
    if (strlen($password) < 6) $errors[] = "Пароль должен содержать минимум 6 символов";
    if ($password !== $passwordConfirm) $errors[] = "Пароли не совпадают";
    
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM Клиенты WHERE Email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetchColumn() > 0) {
                $errors[] = "Пользователь с таким email уже зарегистрирован";
            }
        } catch (PDOException $e) {
            $errors[] = "Ошибка при проверке email: " . $e->getMessage();
        }
    }
        if (empty($errors)) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $registrationDate = date('Y-m-d');
            
            $stmt = $pdo->prepare("
                INSERT INTO Клиенты (
                    Фамилия, Имя, Отчество, Дата_рождения, Адрес_проживания, 
                    Email, Телефон, Пароль, Наличие_справки_о_здоровье, Дата_регистрации
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            
            $stmt->execute([
                $surname, $name, $patronymic, $birthdate, $address,
                $email, $phone, $hashedPassword, $healthCertificate, $registrationDate
            ]);
            
            $success = true;
        } catch (PDOException $e) {
            $errors[] = "Ошибка при регистрации: " . $e->getMessage();
        }
    }
}

$pageTitle = "Регистрация";
include 'templates/header.php';
?>

<div class="container py-5" style = 'min-height: 100vh'>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-body p-4">
                    <h2 class="card-title text-center mb-4">Регистрация</h2>
                    
                    <?php if ($success): ?>
                        <div class="alert alert-success">
                            Регистрация прошла успешно! Теперь вы можете <a href="login.php">войти</a> в систему.
                        </div>
                    <?php else: ?>
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="surname" class="form-label">Фамилия*</label>
                                    <input type="text" class="form-control" id="surname" name="surname" value="<?= htmlspecialchars($_POST['surname'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="name" class="form-label">Имя*</label>
                                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="patronymic" class="form-label">Отчество</label>
                                    <input type="text" class="form-control" id="patronymic" name="patronymic" value="<?= htmlspecialchars($_POST['patronymic'] ?? '') ?>">
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Дата рождения*</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" value="<?= htmlspecialchars($_POST['birthdate'] ?? '') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="address" class="form-label">Адрес проживания*</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= htmlspecialchars($_POST['address'] ?? '') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email*</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="phone" class="form-label">Телефон*</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password" class="form-label">Пароль* (мин. 6 символов)</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Подтверждение пароля*</label>
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                            </div>
                            
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="health_certificate" name="health_certificate" <?= isset($_POST['health_certificate']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="health_certificate">Есть справка о здоровье</label>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100">Зарегистрироваться</button>
                            
                            <div class="mt-3 text-center">
                                <p>Уже есть аккаунт? <a href="login.php">Войдите</a></p>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'templates/footer.php'; ?>