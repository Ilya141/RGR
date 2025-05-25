<?php
$host = 'localhost';
$dbname = 'id123456_emails_db';
$username = 'id123456_user';
$password = 'your_password';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = trim($_POST['email']);

        // Защита от повторных записей
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM subscribers WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->fetchColumn() == 0) {
            $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (:email)");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            echo "Спасибо! Ваш email сохранён.";
        } else {
            echo "Этот email уже существует в базе.";
        }
    } else {
        echo "Введите корректный email.";
    }
} catch (PDOException $e) {
    echo "Ошибка базы данных: " . $e->getMessage();
}
?>
