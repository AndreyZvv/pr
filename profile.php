<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: registr.php');
    exit;
}
$userId = $_SESSION['user_id'];
$host = 'sql107.infinityfree.com';
$db   = 'if0_39140569_new';
$user = 'if0_39140569';
$pass = '43dfpC0vFj6gtd';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    $sql = "
        SELECT g.id, g.title, g.description, g.price, o.order_date, o.status
        FROM orders1 o
        JOIN goods1 g ON o.abonement_id = g.id
        WHERE o.user_id = :user_id
        ORDER BY o.order_date DESC
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $goods = $stmt->fetchAll();
    $goodsByStatus = [
        'incart' => [],
        'inactive' => [],
        'old' => []
    ];
    foreach ($goods as $item) {
        if ($item['status'] == 'incart') {
            $goodsByStatus['incart'][] = $item;
        } elseif ($item['status'] == 'inactive') {
            $goodsByStatus['inactive'][] = $item;
        } else {
            $goodsByStatus['old'][] = $item;
        }
    }
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
$sql = "SELECT login, email FROM user1 WHERE id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $userId]);
$userData = $stmt->fetch();
$userName = $userData['login'] ?? 'Неизвестное имя';
$userEmail = $userData['email'] ?? 'Неизвестный email';
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div class="backprofile"></div>
    <header>
        <img class="logo" src="images/logoimage.png" />
        <h1 class="a">Добро пожаловать в наш бассейн!</h1><br><br><br>
        <nav>
            <a href="about.html">О нас</a>
            <a href="goods.php">Товары</a>
            <a href="registr.html">Зарегистрироваться</a>
        </nav>
    </header>
    <div class="containerindex2">
        <div id="profile"><br><br>
            <h1>Информация о пользователе</h1>
            <p><strong>Логин:</strong> <?= htmlspecialchars($userName) ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($userEmail) ?></p>
        </div> 
        <div class="block">
            <h2 style="color:green;">Ваши товары</h2>
            <!-- Товары в корзине -->
            <div class="block">
                <h2>Товары в корзине</h2>
                <?php if (!empty($goodsByStatus['incart'])): ?>
                    <ul>
                        <?php foreach ($goodsByStatus['incart'] as $item): ?>
                            <div class="abonement-name"><b>Товар<br> &laquo;<?= htmlspecialchars($item['title']) ?>&raquo;</b></div><br>
                            <img class="abon" src="images/image<?= htmlspecialchars($item['id']); ?>.jpg" alt="Товар <?= htmlspecialchars($item['id']); ?>" />
                            <div>Цена: <?= htmlspecialchars($item['price']) ?> рублей / месяц</div>
                            <p class="description"><?= htmlspecialchars($item['description']); ?></p>
                            <div>Статус: <span class="status-active">В корзине</span></div>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>У вас нет товаров в корзине.</p>
                <?php endif; ?>
                <button style="background-color: #0001ff; color: white; font-size: 18px; padding: 15px 30px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;" 
                        onmouseover="this.style.backgroundColor='#000080'" 
                        onmouseout="this.style.backgroundColor='#0000ff'" 
                        onclick="alert('Эта функция еще в разработке')">
                    Оплатить
                </button>
            </div>
            <!-- Активные товары -->
            <div class="block">
                <h2>Активные товары</h2>
                <?php if (!empty($goodsByStatus['inactive'])): ?>
                    <ul>
                        <?php foreach ($goodsByStatus['inactive'] as $item): ?>
                            <div class="abonement-name"><b>Товар<br> &laquo;<?= htmlspecialchars($item['title']) ?>&raquo;</b></div><br>
                            <img class="abon" src="images/image<?= htmlspecialchars($item['id']); ?>.jpg" alt="Товар <?= htmlspecialchars($item['id']); ?>" />
                            <div>Цена: <?= htmlspecialchars($item['price']) ?> рублей / месяц</div>
                            <p class="description"><?= htmlspecialchars($item['description']); ?></p>
                            <div>Статус: <span class="status-inactive">Активен</span></div>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>У вас нет активных товаров.</p>
                <?php endif; ?>
            </div>
            <!-- Старые товары -->
            <div class="block">
                <h2>Старые товары</h2>
                <?php if (!empty($goodsByStatus['old'])): ?>
                    <ul>
                        <?php foreach ($goodsByStatus['old'] as $item): ?>
                            <div class="abonement-name"><b>Товар<br> &laquo;<?= htmlspecialchars($item['title']) ?>&raquo;</b></div><br>
                            <img class="abon" src="images/image<?= htmlspecialchars($item['id']); ?>.jpg" alt="Товар <?= htmlspecialchars($item['id']); ?>" />
                            <div>Цена: <?= htmlspecialchars($item['price']) ?> рублей / месяц</div>
                            <p class="description"><?= htmlspecialchars($item['description']); ?></p>
                            <div>Статус: <span class="status-old">Старый</span></div>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>У вас нет старых товаров.</p>
                <?php endif; ?>
            </div>
        </div>
        <footer class="d">
            <p>&copy; 2024 Бассейн. Все права защищены.</p>
        </footer>
    </div>
    <script src="script.js"></script>
</body>
</html>