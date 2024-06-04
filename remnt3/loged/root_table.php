<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['authorized'])) {
        die('Несанкционированный доступ!');
    }

    // Устанавливаем переменные для подключения к базе данных
    $servername = "localhost";
    $username = "";
    $password = "";
    $dbname = "";

    // Создаем подключение к базе данных
    $conn = mysqli_connect($servername, $username, $password, $dbname); 
    if (!$conn) { 
        die("Connection failed: " . mysqli_connect_error()); 
    } 

    // Выполняем запрос к базе данных для получения данных из таблицы history
    $result = mysqli_query($conn, "SELECT * FROM history");

    ?>

    <table>
        <tr>
            <th>Имя</th>
            <th>Телефон</th>
            <th>Дата</th>
        </tr>
        <?php 
        // Выводим данные каждой строки
        while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $row['name'] ?></td>
                <td><?= $row['phone'] ?></td>
                <td><?= $row['creation_time'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <?php
    // Закрываем подключение к базе данных
    mysqli_close($conn); 
    ?>

    <!-- Add a button for clearing the table -->
    <button onclick="clearTable()">Очистить все</button>

    <script>
function clearTable() {
    // Создаем новый экземпляр XMLHttpRequest
    var xhr = new XMLHttpRequest();
    // Настраиваем его на POST-запрос к скрипту clear_history.php
    xhr.open('POST', 'clear_history.php', true);

    // Устанавливаем заголовок, чтобы сервер знал, что это AJAX-запрос
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

    // Определяем функцию, которая будет вызвана при изменении состояния запроса
    xhr.onreadystatechange = function() {
        // Если запрос завершен (XMLHttpRequest.DONE === 4) и успешен (статус 200)
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Выводим ответ сервера
            console.log(xhr.responseText);
            // Обновляем таблицу или страницу, если это необходимо
            // Например, можно перезагрузить страницу
            window.location.reload();
        }
    };

    // Отправляем запрос
    xhr.send();
}

    </script>

</body>
</html>

