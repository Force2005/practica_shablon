<?php
// Файл: clear_history.php
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

// Выполняем запрос на очистку таблицы history
$sql = "TRUNCATE TABLE history";
if (mysqli_query($conn, $sql)) {
    echo "Таблица history была успешно очищена";
} else {
    echo "Ошибка при очистке таблицы history: " . mysqli_error($conn);
}

// Закрываем подключение к базе данных
mysqli_close($conn); 
?>
