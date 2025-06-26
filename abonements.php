<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: registr.php');
    exit;
}
$userId = $_SESSION['user_id'];
$host = 'sql108.infinityfree.com';
$db   = 'if0_39094640_zvyagintsev_205s9';
$user = 'if0_39094640';
$pass = 'BBPmyRhRvR2p';
$charset = 'utf8mb4';
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    // Получаем все абонементы
    $sql = "SELECT id, title, price, description FROM abonement1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $abonements = $stmt->fetchAll();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $abonementId = $_POST['abonement_id'];
        
        $sql = "SELECT COUNT(*) FROM orders1 WHERE user_id = :user_id AND abonement_id = :abonement_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'abonement_id' => $abonementId
        ]);
        $count = $stmt->fetchColumn();
        
        if ($count > 0) {
            $errorMessage = "Вы уже добавили этот абонемент в корзину.";
        } else {
            $orderDate = date('Y-m-d H:i:s'); // Текущая дата и время
            $status = 'incart'; // Статус по умолчанию
            $sql = "INSERT INTO orders1 (user_id, abonement_id, order_date, status) VALUES (:user_id, :abonement_id, :order_date, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'user_id' => $userId,
                'abonement_id' => $abonementId,
                'order_date' => $orderDate,
                'status' => $status
            ]);
            
            header('Location: abonements.php');
            exit;
        }
    }
    $sql = "
    SELECT a.id, a.title, a.price 
    FROM abonement1 a
    JOIN orders1 o ON a.id = o.abonement_id
    WHERE o.user_id = :user_id AND o.status = 'incart'
";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['user_id' => $userId]);
    $userOrders = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Абонементы</title>
    <link rel="stylesheet" href="style/styles.css">
    <style>
    .search-block {
            background-color: rgba(220,230,246, 0.77);
            box-shadow: 0 4px 4px rgba(10, 0, 0, 0.5);
            padding: 20px;
            margin: 20px auto;
            text-align: center;
            border-radius: 12px;
            max-width: 600px;
        }
        .search-block input[type="text"] {
            width: 70%;
            padding: 10px;
            font-size: 16px;
            text-align: center;
        }
        .search-block button {
            font-size: 16px;
            background-color: #0077cc;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-block button:hover {
            background-color: #005fa3;
        }
.subscription-block h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
}

.abonblock {
    width: 300px;
    margin-bottom: 20px;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    background-color: #f9f9f9; 
}
.subscription-block .abonement-name {
    font-weight: bold;
    font-size: 18px;
}
.subscription-block .price {
    color: #0077cc;
    font-size: 16px;
}
.subscription-block .add-button {
    background-color: #0077cc;
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
}
.subscription-block .add-button:hover {
    background-color: #005fa3;
}
    </style>
</head>
<body>
<div class="blue-background100"></div>
<header>
        <img class="logo" src="images/logoimage.png" />
        <h1 class="a">Добро пожаловать в наш бассейн!</h1><div id="content"></div>
    <nav>
        <a href="index.php">Главная</a> 
        <a href="about.html">О нас</a>
    </nav>
        </div>
</header>
<div class="search-block">
    <h2>Поиск по абонементам</h2>
    <form onsubmit="return false;">
        <input type="text" id="searchInput" placeholder="Введите название, описание или цену">
        <button type="button" onclick="filterBlocks()">Найти</button>
    </form>
</div>
<div class="container2">
    <div class="subscription-block" id="subscriptionBlock">
        <h1></h1>
        <!-- Ошибка, если абонемент уже добавлен -->
        <?php if (isset($errorMessage)): ?>
            <p class="error-message" style='color: red;'><?= htmlspecialchars($errorMessage) ?></p>
        <?php endif; ?>
        <!-- Список доступных абонементов с кнопками "Добавить" -->
        <h2>Все доступные абонементы</h2><br>
        <div>
        <?php foreach ($abonements as $abonement): ?>
    <div class="abonblock">
        <div class="abonement-name">Абонемент<br> &laquo;<?= htmlspecialchars($abonement['title']) ?>&raquo;</div><div><br></div>
        <img class="abon" src="images/image<?php echo htmlspecialchars($abonement['id']);?>.jpg" alt="Абонемент <?php echo htmlspecialchars($abonement['id']); ?>" />
        <div>Цена: <?= htmlspecialchars($abonement['price']) ?> рублей / месяц</div>
        <p class="description"><?php echo htmlspecialchars($abonement['description']); ?></p>
        <!-- Добавить изображение абонемента -->
        <?php if (isset($abonement['image_url'])): ?>
            <img src="<?= htmlspecialchars($abonement['image_url']) ?>" alt="Изображение абонемента">
        <?php endif; ?>
        <!-- Форма с кнопкой для добавления абонемента -->
        <form action="abonements.php" method="post">
            <input type="hidden" name="abonement_id" value="<?= $abonement['id'] ?>">
            <button type="submit" class="add-button">Добавить</button>
        </form>
    </div>
<?php endforeach; ?>
    </div>
</div>
</div>
<!-- Список активных абонементов пользователя -->
<br><div class="container2">
<div class="subscription-block" id="subscriptionBlock">
<h2>Абонементы в корзине</h2>
<?php if (!empty($userOrders)): ?>
        <?php foreach ($userOrders as $order): ?>
                <div class="block2">
                <div class="abonement-name">Абонемент &laquo;<?= htmlspecialchars($order['title']) ?>&raquo;</div><div></div><br>
                <div>Цена: <?= htmlspecialchars($abonement['price']) ?> рублей / месяц</div>
                <p class="description"><?php echo htmlspecialchars($row['description']); ?></p><br>
            </div>
        <?php endforeach; ?>
<?php else: ?>
    <p>У вас нет активных абонементов.</p>
<?php endif; ?>
  </div>
</div>
 <script>
        if (localStorage.getItem('loggedIn') === 'true') {
            const contentDiv = document.getElementById('content');
            const link = document.createElement('a');
            link.href = 'profile.php';  
            const img = document.createElement('img');
            img.src = 'images/profile.png';
            img.alt = 'Ссылка для авторизованных';
            img.classList.add('profile');
            link.appendChild(img);
            contentDiv.appendChild(link);
        } else {
            document.getElementById('content').innerHTML = '<a href="registr.php" class="registerlink">Зарегистрироваться</a>';
        }
    </script>
    <footer class='abonements'>
    <p>&copy; 2024 Бассейн. Все права защищены.</p>
</footer>
<script>
function filterBlocks() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const blocks = document.querySelectorAll('.subscription-block .abonblock');
    blocks.forEach(block => {
        const text = block.innerText.toLowerCase();
        block.style.display = text.includes(input) ? "block" : "none";
    });
}
</script>
</body>
</html>

