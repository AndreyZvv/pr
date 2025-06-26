<?php
session_start();  
$conn = new mysqli('sql107.infinityfree.com', 'if0_39140569', '43dfpC0vFj6gtd', 'if0_39140569_new');
if ($conn->connect_error) {
    die('Ошибка подключения к базе данных: ' . $conn->connect_error);
}
$login = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$stmt = $conn->prepare("SELECT id, password, role FROM user1 WHERE login = ?");
$stmt->bind_param("s", $login);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        echo '<script>
            localStorage.setItem("loggedIn", "true");
            alert("Авторизация прошла успешно!");
            window.location.href = "' . ($row['role'] === 'admin' ? 'admin.php' : 'index.php') . '";
        </script>';
        exit;
    }
}
echo '<script>
    alert("Неверный логин или пароль");
    window.location.href = "registr.php";
</script>';
$stmt->close();
$conn->close();
?>
