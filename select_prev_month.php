<?php
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_query($link,"set names 'utf8'");
//setlocale('LC_ALL','');
$driver_name = $_GET['driver_name'];
$text_qry = "select * from road_data rd";
$text_qry.=$driver_name?" where rd.id_driver='".$driver_name."'":"";
$text_qry.=" order by rd.`month`";
$search_balance_fuel_qry=  mysqli_query($link,$text_qry) or die('problem search_balance_fuel_qry  - '.mysql_error());
echo "Выберите предыдущий месяц отчета:";
echo "<select  id = 'balance_fuel' class='form-control' style='width:200px; margin-left:20px;' name='balance_fuel' onchange='show_report_form();'>";
echo "<option value='0'>----</option>";
while($balance_fuel_res=mysqli_fetch_array($search_balance_fuel_qry,MYSQLI_ASSOC)){
    echo "<option value='".$balance_fuel_res['balance_fuel']."'>".$balance_fuel_res['month']."</option>";
    
}

mysqli_free_result($search_balance_fuel_qry);
mysqli_close($link);
echo "</select>";
