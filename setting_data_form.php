<?php




      
   echo  '<button class="btn btn-extra"  type="submit" onclick = "load_data_shop();"> Загрузить данные о магазинах </button>';
  



/*------------------------------------------------------------------------------------------------------------
function data_from_contract_2015($problem, $doc_base, $name_file, $find_type, $link_test,$user){
   $name_script = 'func_load_from_contract.php/function data_from_contract_2015;';
   global $flag_header;
   $flag_header = 0;
   $hc = 0;
   $f_error = fopen("../../tmp/error_file-".$problem.".txt","a");
   if (!$f_error) {
     // echo "Не удалось открыть файл ".$name_file;
      return;
   }
   date_default_timezone_set('Asia/Yekaterinburg');  
   fwrite($f_error, "Протокол загрузки файла в таблицы problem_DocBase, data_contract и works_contract" ."\r\n");
   fwrite($f_error, "Задача № ". $problem."\r\n");
   fwrite($f_error, "№ Документа-основания - ". $doc_base."\r\n");
   fwrite($f_error, "Дата загрузки ".date("d-m-Y H:i:s")."\r\n");
   fwrite($f_error, "Поиск по  ".$find_type."\r\n");
   fwrite($f_error, "Имя файла 1". $name_file."\r\n");
   if (strrpos( $name_file , "\\")>0){
      $name_file = substr($name_file, strrpos( $name_file , "\\")+1);
   }
   fwrite($f_error, "Имя файла 1". $name_file."\r\n");
   $f = fopen ("../../tmp/".$name_file, "r");
   if (!$f) {
      fwrite($f_error, "Не удалось открыть файл ".$name_file."\r\n");
      return;
   }

  while ($line= fgetcsv ($f, 2000, ";")) {
        ++$ln;
       if ($line===FALSE) 
        {
            fwrite($f_error, "Ошибка в строке файла ".$ln);
            continue;
        }
-----------------------------------------------------------------------------
﻿<?php
$uploads_dir = '/opt/esuppp/tos/tmp/';
$tmp_name = $_FILES["name_load_file_225"]["tmp_name"];
$name = $_FILES["name_load_file_225"]["name"];
move_uploaded_file($tmp_name, $uploads_dir.$name);
$tmp_name = $_FILES["name_load_file_226"]["tmp_name"];
$name = $_FILES["name_load_file_226"]["name"];
move_uploaded_file($tmp_name, $uploads_dir.$name);*/