<?php
session_start(); // Запуск сессии
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Подключение к базе данных
    $conn = new mysqli('sql107.infinityfree.com', 'if0_39140569', '43dfpC0vFj6gtd', 'if0_39140569_new');
    if ($conn->connect_error) {
        die('Ошибка подключения: ' . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    $login = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
    // Проверка на существование пользователя с таким логином или email
    $stmt = $conn->prepare("SELECT id FROM user1 WHERE login = ? OR email = ?");
    $stmt->bind_param("ss", $login, $email);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo '<script>
            alert("Ошибка: логин или email уже зарегистрирован.");
            window.location.href = "registr.php";
        </script>';
        $stmt->close();
        $conn->close();
        exit;
    }
    // Хеширование пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // Вставка данных в базу
    $stmt = $conn->prepare("INSERT INTO user1 (login, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $login, $hashed_password, $email);
    if ($stmt->execute()) {
        // Сохранение идентификатора сессии (например, id пользователя) в сессии
        $_SESSION['user_id'] = $conn->insert_id;  // Сохранить id нового пользователя
        $_SESSION['logged_in'] = true;  // Установка флага о том, что пользователь вошел в систему
        echo '<script>
            localStorage.setItem("loggedIn", "true");
            alert("Регистрация прошла успешно!");
            window.location.href = "index.php";
        </script>';
    } else {
        echo '<script>
            alert("Ошибка: невозможно зарегистрировать пользователя.");
            window.location.href = "registr.php";
        </script>';
    }
    $stmt->close();
    $conn->close();
} else {
    header('Location: registr.php');
    exit;
}
?>