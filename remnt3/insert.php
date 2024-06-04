<?php 
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

date_default_timezone_set("Europe/Moscow");

// Перенаправляем пользователя на предыдущую страницу
header("Location: " . $_SERVER['HTTP_REFERER']); 

// Получаем данные из GET-запроса
$name = $_GET['name'];
$phone = $_GET['phone'];

if (!empty($name) && !empty($phone)) { 
  // Подготавливаем SQL запрос на вставку данных в таблицу list
  $stmt_list = mysqli_prepare($conn, "INSERT INTO list (name, phone, creation_time) VALUES (?, ?, CURRENT_TIMESTAMP)");
  mysqli_stmt_bind_param($stmt_list, "ss", $name, $phone);
  
  // Подготавливаем SQL запрос на вставку данных в таблицу history
  $stmt_history = mysqli_prepare($conn, "INSERT INTO history (name, phone, creation_time) VALUES (?, ?, CURRENT_TIMESTAMP)");
  mysqli_stmt_bind_param($stmt_history, "ss", $name, $phone);
  
  // Выполняем SQL запросы и проверяем их успешность
  if (mysqli_stmt_execute($stmt_list) && mysqli_stmt_execute($stmt_history)) { 
    echo "Данные успешно записаны";
  } else { 
    echo "Ошибка: " . mysqli_error($conn);
  } 
} else { 
  echo "Пожалуйста, заполните все поля";
} 

mysqli_close($conn); 
?>
