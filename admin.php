<?php
session_start();


if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}
$conn = new mysqli('sql107.infinityfree.com', 'if0_39140569', '43dfpC0vFj6gtd', 'if0_39140569_new');
if ($conn->connect_error) {
    die("Ошибка подключения к БД: " . $conn->connect_error);
}

if (isset($_POST['add'])) {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stmt = $conn->prepare("INSERT INTO goods1 (title, description, price) VALUES (?, ?, ?)");
    $stmt->bind_param("ssd", $title, $description, $price);
    $stmt->execute();
    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $conn->prepare("DELETE FROM goods1 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

if (isset($_POST['edit'])) {
    $id = (int)$_POST['id'];
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $stmt = $conn->prepare("UPDATE goods1 SET title = ?, description = ?, price = ? WHERE id = ?");
    $stmt->bind_param("ssdi", $title, $description, $price, $id);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query("SELECT * FROM goods1");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

            <form method="post" style="margin-bottom: 20px;">
    <button type="submit" name="logout">Выйти</button>
</form><br><br>
    <h1>Админ-панель: Товары/Услуги</h1>
    <h2>Добавить товар/услугу</h2>
    <form method="post">
        <input type="text" name="title" placeholder="Название" required>
        <input type="text" name="description" placeholder="Описание">
        <input type="number" step="0.01" name="price" placeholder="Цена" required>
        <button type="submit" name="add">Добавить</button>
    </form>
    <h2>Список товаров/услуг</h2>
    <table border="1" cellpadding="5">
        <tr>
            <th>ID</th><th>Название</th><th>Описание</th><th>Цена</th><th>Действия</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <form method="post">
                    <td><?= $row['id'] ?></td>
                    <td><input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>"></td>
                    <td><input type="text" name="description" value="<?= htmlspecialchars($row['description']) ?>"></td>
                    <td><input type="number" step="0.01" name="price" value="<?= $row['price'] ?>"></td>
                    <td>
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <button type="submit" name="edit">Изменить</button>
                        <a href="?delete=<?= $row['id'] ?>" onclick="return confirm('Удалить этот товар?')">Удалить</a>
                    </td>
                </form>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
<?php
$conn->close();
?>
