<?php
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_query($link,"set names 'utf8'");
$str_len = $_GET['str_len'];
$search_shop_qry=  mysqli_query($link,"select * from shop") or die('problem search_shop_qry  - '.mysql_error());
echo "<select name='start_shop' class='form-control' onchange='calc(".$str_len.");'>";
while($shop_result=mysqli_fetch_array($search_shop_qry,MYSQLI_ASSOC)){
    echo "<option value='".$shop_result['shop_address']."' >".$shop_result['type']." ".$shop_result['shop_name']."</option>";
    
}

mysqli_free_result($search_shop_qry);
mysqli_close($link);
echo "</select>";