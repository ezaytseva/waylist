<?php
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_query($link,"set names 'utf8'");
$id_driver = $_POST['id_driver'];
$finish_date = $_POST['finish_date'];
$d1 = strtotime($finish_date); // переводит из строки в дату
$date2 = date("Y-m-d", $d1); // переводит в новый формат
$balance_fuel_finish = $_POST['balance_fuel_finish'];



    $sql = "INSERT INTO road_data (id_driver, month, balance_fuel) 
	VALUES ('".$id_driver."', '".$date2."','".$balance_fuel_finish."');";
    $query = mysqli_query($link,$sql) or die('Ошибка  записи: '.mysql_error());
 
echo 'Данные записаны';

