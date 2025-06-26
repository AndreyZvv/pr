<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div class="blue-backgroundindex"></div>
    <header>
        <img class="logo" src="images/logoimage.png" />

    <nav>
        <a href="about.html">О нас</a>
        <a href="goods.php">Товары</a></a>   
    </nav>
        </div>
    </header>
    <img class="banner" src="images/bannerimage.jpg" alt="Наш бассейн">
    <br><br>
    <div class="containerindex">
        <img src="images/poolimage.jpg" alt="Изображение бассейна">
        <div class="text">
            Описание
        </div>
    </div>
    <footer class="index">
        <p>&copy; 2025 Организация. Все права защищены.</p>
    </footer>
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
</body>
</html>

