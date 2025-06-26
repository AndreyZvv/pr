<?php
session_start(); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli('sql107.infinityfree.com', 'if0_39140569', '43dfpC0vFj6gtd', 'if0_39140569_new');
    if ($conn->connect_error) {
        die('Ошибка подключения: ' . $conn->connect_error);
    }
    
    $conn->set_charset("utf8");
    $login = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $email = $_POST['email'] ?? '';
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
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user1 (login, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $login, $hashed_password, $email);
    if ($stmt->execute()) {
        $_SESSION['user_id'] = $conn->insert_id;  
        $_SESSION['logged_in'] = true; 
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
