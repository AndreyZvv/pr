<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация и Авторизация</title>
    <link rel="stylesheet" href="style/styles.css">
</head>

<body>
<div class="blue-background4"></div>
           <header>
        <img class="logo" src="images/logoimage.png" />
        <h1 class="a">Добро пожаловать в наш бассейн!</h1><br><br>
        <nav>
        <a href="about.html">О нас</a>
       <a href="index.php">Главная</a>
        </nav>
    </header>

     <div class="containerreg">
        <section id="register-form">
            <h2>Регистрация</h2>
            <form method="post" action="44.php">
            <label> Логин: </label>
            <input type="text" name="username" required>
            <br>
            <label>  Пароль: </label>
            <input type="password" name="password" required>
            <br>
            <label>  Электронная почта: </label>
            <input type="email" name="email" required>
            <button type="submit">Зарегистрироваться</button>
            <div class="form-toggle">
                <p>Уже есть аккаунт? <a href="javascript:void(0)" onclick="toggleForms()">Войти</a></p>
            </div>
        </form>
        </section>
        <section id="login-form" style="display: none;">
            <h2>Авторизация</h2>
            <form method="post" action="4.php">
            <label> Логин: </label>
            <input type="text" name="username" required>
            <br>
            <label>  Пароль: </label>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Войти</button>
                <br>
                <div class="form-toggle">
                <p>Нет аккаунта? <a href="javascript:void(0)" onclick="toggleForms()">Зарегистрироваться</a></p>
            </div>
            </form>
        </section>
    </div>


    <footer>
        <p>&copy; 2024 Организация. Все права защищены.</p>
    </footer>
    <script>
        function toggleForms() {
            var registerForm = document.getElementById('register-form');
            var loginForm = document.getElementById('login-form');
            if (registerForm.style.display === 'none') {
                registerForm.style.display = 'block';
                loginForm.style.display = 'none';
            } else {
                registerForm.style.display = 'none';
                loginForm.style.display = 'block';
            }
        }
    </script>
</body>
</html>
