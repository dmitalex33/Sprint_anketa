<?php 

include 'db_info.php';
 
// Соединяемся с базой
$db = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName); 
$db->set_charset("utf8");
// Проверяем соединение
if ($db->connect_error) { 
    die("Connection failed: " . $db->connect_error); 
} 
 
// Данные передаются в 'term'
$searchTerm = $_GET['term']; 
 
// выбираем совпадения из БД
$query = $db->query("SELECT * FROM streets WHERE name LIKE '".$searchTerm."%'"); 
 
// Создаём массив с совпадениями
$streetsData = array(); 
if($query->num_rows > 0){ 
    while($row = $query->fetch_array()){ 
        $data = $row['name']; 
        array_push($streetsData, $data); 
    } 
} 
 
// Возвращаем результаты в формате json
echo json_encode($streetsData); 
?>