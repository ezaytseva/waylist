<?php
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_query($link,"set names 'utf8'");

$loadfile ='CTO.xls'; // получаем имя загруженного файла
require_once $_SERVER['DOCUMENT_ROOT']."/Classes/PHPExcel/IOFactory.php"; // подключаем класс для доступа к файлу
$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT']."/upload/".$loadfile);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) // цикл обходит страницы файла
{
  $highestRow = $worksheet->getHighestRow(); // получаем количество строк
  $highestColumn = $worksheet->getHighestColumn(); // а так можно получить количество колонок
 
  for ($row = 2; $row <= $highestRow; ++ $row) // обходим все строки
  {
    $type = $worksheet->getCellByColumnAndRow(1, $row); //тип магазина ММ,МК
    $shop_name = $worksheet->getCellByColumnAndRow(2, $row); //наименование
    $address = $worksheet->getCellByColumnAndRow(8, $row); //адрес

    $sql = "INSERT INTO shop (shop_name, shop_address, `type`) 
	VALUES ('".$shop_name."', '".$address."','".$type."');";
    $query = mysqli_query($link,$sql) or die('Ошибка чтения записи: '.mysql_error());
  }
}
echo 'Все загружено';

