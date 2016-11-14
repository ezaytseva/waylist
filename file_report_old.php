<?php
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_query($link,"set names 'utf8'");

 $start_date='01.01.2016';
    $finish_date='31.01.2016';
    $marka_auto='ваз2110';
    $number_auto='965';
    $driver_name='Тявловский Евгений Геннадьевич';
    $prava='asdfdasf54665';

$replace_from = array(
    '%start_date',
    '%finish_date',
    '%marka_auto',
    '%number_auto',
    '%driver_name',
    '%prava'
   
);

$replace_to = array(
   $start_date,
    $finish_date,
    $marka_auto,
    $number_auto,
    $driver_name,
    $prava
   
);


 $name_file = 'way_list_oct';
 $name_dir = 'way_list_report';
 $type_file = 'odt';
 create_doc($replace_from, $replace_to); 
// header('Content-Type: application/vnd.oasis.opendocument.text');
// header('Content-disposition: attachment; filename="way_list_oct.odt"');
// readfile("/wamp/www/waylist/tmp/way_list_oct.odt");
// exec("rm -r /tmp/".$name_dir, $out, $err);

function create_doc($replace_from, $replace_to) {
   
   

    $content_xml = str_replace($replace_from, $replace_to, file_get_contents('/wamp/www/waylist/templates/way_list/content.xml'));
    $styles_xml = str_replace($replace_from, $replace_to, file_get_contents('/wamp/www/waylist/templates/way_list/styles.xml'));


    mkdir   ("/wamp/www/waylist/tmp/report",0777);
    $dir2 = "/wamp/www/waylist/tmp/report/";
    $dir1 = "/wamp/www/waylist/templates/way_list/";
   lowering($dir1,$dir2); 
    //exec("chmod -R 774 /wamp/www/waylist/tmp/report_tmp", $out, $err);

    $fn = fopen("/wamp/www/waylist/tmp/report/content.xml", "w");
    fputs($fn, $content_xml);
    fclose($fn);

    $f_styles = fopen("/wamp/www/waylist/tmp/report/styles.xml", "w");
    fputs($f_styles, $styles_xml);
    fclose($f_styles);
    create_archive("/wamp/www/waylist/tmp/report/");

 $dir="tmp/report";
   
 //deleteDirectory($dir);
   
}


//архив

function create_archive($dirname){
$tmpfile='doc.odt';
$zip = new ZipArchive;
$outname='zayavlenie.odt';
//unlink($tmpfile);
$zip = new ZipArchive(); // подгружаем библиотеку zip
//$zip_name = time().".zip"; // имя файла
if ($zip->open($tmpfile,ZIPARCHIVE::CREATE) === TRUE) {
  //  print_r('dfas');

  $dir = opendir("tmp/report"); 
 
    // В цикле выводим её содержимое 
  while (false !== ($file = readdir($dir))) { 
       if (is_dir($file)) {
            $zip->addEmptyDir($file);
        }
        //иначе добавляем файл
        else {
 
$zip->addFile($file); // добавляем файлы в zip архив
        }
}
   $zip->close();
} else {
    die("zip error");
}
    closedir($dir); 

ob_clean();
header('Content-Disposition: attachment; filename="'.$outname.'"');
header('Content-type: application/odt');
print file_get_contents($tmpfile);
}


 
  ////////////////////////////////////////////////////////// 
  // Рекурсивная функция для копирования вложенных файлов и директорий
  ////////////////////////////////////////////////////////// 
  function lowering($dirname,$dirdestination) 
  { 
    // Открываем директорию 
    $dir = opendir($dirname); 
    // В цикле выводим её содержимое 
    while (($file = readdir($dir)) !== false) 
    { 
      //echo $file."<br>"; 
      // Вырезаем первую точку 
      // Если это файл копируем его 
      if(is_file($dirname."/".$file)) 
      { 
        copy($dirname."/".$file, $dirdestination."/".$file); 
      } 
      // Если это директория - создаём её 
      if(is_dir($dirname."/".$file) && 
         $file != "." && 
         $file != "..") 
      { 
        // Создаём директорию 
        if(!mkdir($dirdestination."/".$file)) 
        { 
          echo "Can't create ".$dirdestination."/".$file."\n"; 
        } 
        // Вызываем рекурсивно функцию lowering 
        lowering("$dirname/$file","$dirdestination/$file"); 
      } 
    } 
    // Закрываем директорию 
    closedir($dir); 
  } 

  // функция удаления директории
    function deleteDirectory($dir) {
        if (!file_exists($dir)) return true;
        if (!is_dir($dir) || is_link($dir)) return unlink($dir);
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') continue;
            if (!deleteDirectory($dir . "/" . $item)) {
                chmod($dir . "/" . $item, 0777);
                if (!deleteDirectory($dir . "/" . $item)) return false;
            };
        }
        return rmdir($dir);
    }
    
    