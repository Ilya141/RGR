<?php
// Настройки подключения
$host = 'localhost'; // или другой адрес сервера
$dbname = 'id123456_emails_db'; // Имя вашей базы данных
$username = 'id123456_user';    // Имя пользователя базы данных
$password = 'your_password';    // Пароль

try {
    // Подключение к БД через PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);

    // Проверка данных
    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];

        // Вставка в таблицу
        $stmt = $pdo->prepare("INSERT INTO subscribers (email) VALUES (:email)");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        echo "Спасибо! Ваш email сохранён в базе данных.";
    } else {
        echo "Неверный email.";
    }
} catch (PDOException $e) {
    echo "Ошибка подключения к БД: " . $e->getMessage();
}
?>
