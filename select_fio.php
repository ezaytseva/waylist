<?php
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_query($link,"set names 'utf8'");
//setlocale('LC_ALL','');
$search_fio_qry=  mysqli_query($link,"select d.id, concat_ws(' ', d.`Syrname`,d.`FirstName`,d.`SecondName`) fio from driver d ")
        or die('problem search_fio_qry  - '.mysql_error());
echo "Выберите водителя";
echo "<select  id = 'driver_name' class='form-control' style='width:300px; margin-left:20px;' name='driver_name' onchange='show_prev_month();'>";
echo "<option value='0'></option>";
while($fio_res=mysqli_fetch_array($search_fio_qry,MYSQLI_ASSOC)){
    echo "<option value='".$fio_res['id']."'>".$fio_res['fio']."</option>";
    
}

mysqli_free_result($search_fio_qry);
mysqli_close($link);
echo "</select>";
