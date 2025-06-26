<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = $_POST['full_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $service = $_POST['service'];
    $date = date('d.m.Y');

    // Загружаем шаблон
    $template = file_get_contents('blank_template.doc');

    // Подстановка значений
    $filled = str_replace(
        ['${full_name}', '${phone}', '${email}', '${service}', '${date}'],
        [$fullName, $phone, $email, $service, $date],
        $template
    );

    // Установка заголовков для скачивания
    $filename = 'zayavka_' . time() . '.doc';
    header('Content-Type: application/msword');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Length: ' . strlen($filled));
    echo $filled;
    exit;
}

// Если GET-запрос — показываем форму
$service = isset($_GET['service']) ? htmlspecialchars($_GET['service']) : '';
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Форма заявки</title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>
    <div class="blue-backgroundindex"></div>
    <header>
        <img class="logo" src="images/logoimage.png" />

    <nav>
        <a href="index.php">Главная</a>
        <a href="about.html">О нас</a>
        <a href="goods.php">Услуги</a>
    </nav>
        </div>
    </header>
    <div class="containerindex">
        <div class="text">
        <h2>Заполните заявку</h2>
    <label>Услуга:</label><br>
        <input type="text" name="service" value="<?= $service ?>" readonly><br><br>
    <label>Просим Вас выполнить проектирование и монтаж газопровода в объёме:</label><br>
    <input type="text" name="work_scope" value="${work_scope}" required><br><br>
    <label>Количество участков / точек подключения:</label><br>
    <input type="text" name="work_quantity" value="${work_quantity}" required><br><br>
    <label>Объект:</label><br>
    <input type="text" name="object_address" value="${object_address}" required><br><br>
    <label>Сроки выполнения:</label><br>
    <input type="date" name="start_date" value="${start_date}" required><br><br>
    по <input type="date" name="end_date" value="${end_date}" required><br><br>
    <label>Контактное лицо:</label><br>
    <input type="text" name="contact_name" value="${contact_name}" required><br><br>
    <input type="tel" name="contact_phone" value="${contact_phone}" required><br><br>
    <input type="email" name="contact_email" value="${contact_email}" required><br><br>
    <label>Дополнительное контактное лицо:</label><br>
    <input type="text" name="additional_contact_name" value="${additional_contact_name}"><br><br>
    <input type="tel" name="additional_contact_phone" value="${additional_contact_phone}"><br><br>
    <input type="email" name="additional_contact_email" value="${additional_contact_email}"><br><br>
    <label>Электронная почта компании:</label><br>
    <input type="email" name="company_email" value="${company_email}"><br><br>
    <label>Юридический и фактический адрес:</label><br>
    <input type="text" name="company_address" value="${company_address}" required><br><br>
    <label>ИНН:</label><br>
    <input type="text" name="inn" value="${inn}" required><br><br>
    <label>КПП:</label><br>
    <input type="text" name="kpp" value="${kpp}" required><br><br>
    <label>Расчетный счет №:</label><br>
    <input type="text" name="account_number" value="${account_number}" required><br><br>
    <label>Корр. счет №:</label><br>
    <input type="text" name="correspondent_account" value="${correspondent_account}" required><br><br>
    <label>Банк:</label><br>
    <input type="text" name="bank_name" value="${bank_name}" required><br><br>
    <label>БИК:</label><br>
    <input type="text" name="bic" value="${bic}" required><br><br>
    <label>Должность:</label><br>
    <input type="text" name="post" value="${post}"><br><br>
    <button type="submit">Отправить заявку</button>
</form>
        </div>
    </div>
    <footer class="index">
        <p>&copy; 2025 Организация. Все права защищены.</p>
    </footer>
</body>
</html>
