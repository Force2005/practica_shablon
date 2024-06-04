<?php
// Файл: authenticate.php
// Аутентификация пользователя

// Чтение данных пользователей из JSON-файла
$usersJson = file_get_contents('loged/users.json');
$users = json_decode($usersJson, true);

// Проверка логина и пароля
if (isset($_POST['login']) && isset($_POST['password'])) {
    $authenticated = false;
    foreach ($users as $user) {
        if ($_POST['login'] == $user['login'] && $_POST['password'] == $user['password']) {
            // Успешная аутентификация
            session_start();
            $_SESSION['authorized'] = true;
            $authenticated = true;
            break;
        }
    }

    if ($authenticated) {
        // Перенаправление на соответствующую страницу
        header('Location: loged/' . $user['role'] . '_table.php');
        exit();
    } else {
        // Неверный логин или пароль
        header('Location: error.html');
    }
}
?>

