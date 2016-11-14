<?php
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));
mysqli_query($link,"set names 'utf8'");
$start_date=$_GET['start_date'];
$finish_date=$_GET['finish_date'];
$id_driver=$_GET['id_driver'];
$address_head=$_GET['address_head'];
$mechanik_name=$_GET['mechanik_name'];
$speedometr_val_start_month=$_GET['speedometr_val_start_month'];
$disel_mark=$_GET['disel_mark'];
$issued_fuel=$_GET['issued_fuel'];
$balance_fuel_start=$_GET['balance_fuel_start'];
$balance_fuel_finish=$_GET['balance_fuel_finish'];
$consumption_month=$_GET['consumption_month'];
$speedometr_val_finish_month=$_GET['speedometr_val_finish_month'];
$data_way = json_decode($_GET['data_way'],true);

//данные из таблиц 
$data_driver_qry = mysqli_query($link,"SELECT concat(d.`Syrname`,' ',substring(d.FirstName,1,1),'.', substring(d.`SecondName`,1,1),'.') as fio_little,
                    concat(d.`Syrname`,' ',d.`FirstName`,' ', d.`SecondName`) as fio_all, d.`ModelCar`, d.`NumberCar`,d.`Certification`,d.`Class`,
                    d.expenditure
                      FROM driver d where d.id='".$id_driver."'") or die ("Problem driver_qry - ".mysql_error()) ;
$data_driver_res = mysqli_fetch_array($data_driver_qry,MYSQLI_ASSOC);
$fio_all=$data_driver_res['fio_all'];
$fio_little=$data_driver_res['fio_little'];
$model_car = $data_driver_res['ModelCar'];
$number_car = $data_driver_res['NumberCar'];
$prava = $data_driver_res['Certification'];
$class_prav = $data_driver_res['Class'];
$expenditure=$data_driver_res['expenditure'];
//подготовка к формирования отчета

$tmpfile='upload/Put_list.odt';
 
//сохраняем полученный документ
//if (isset($_FILES['document']) and move_uploaded_file($_FILES['document']['tmp_name'], $tmpfile)) {
 
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
 
    // удаляем директорию с содержимым документа и создаем заново
    // при желании, можно перемещать старую версию куда-либо, сделав тем самым версионность документа
    deleteDirectory('doc/');
    mkdir('doc/');
 
 
    // извлекаем архив
    $zip = new ZipArchive;
    if ($zip->open('upload/Put_list.odt') === TRUE) {
    // Сохраняем пути к файлам в нужной последовательности
    // Это нам понадобится в будущем.
    // Например, по требованию формата odf , файл mimetype должен быть первым в архиве.
        $files=array();
        for($i = 0; $i < $zip->numFiles; $i++) {
            $files[]=$zip->getNameIndex($i);
        }
        file_put_contents("doc.list",implode("\n",$files));
 
        //извлекаем
        $zip->extractTo('doc/');
        $zip->close();
    } else {
        die("zip error");
    }
  //echo 'ok';
   // unlink ($tmpfile);
//}
//путь к временному файлу
$tmp_file='download/doc.odt';
//файл, который будем отдавать
$outname='waylist.odt';
 
 
//удаляем старый файл
unlink($tmp_file);
 

//создаем новый архив
$zip = new ZipArchive;
if ($zip->open($tmp_file,ZIPARCHIVE::CREATE) === TRUE) {
//проходимся по структуре нашего архива
    $files=file('doc.list');
    foreach ($files as $filename) {
        $filename=trim($filename);
 
        //если директория - добавляем ее
        if (is_dir('doc/'.$filename)) {
            $zip->addEmptyDir($filename);
        }
        //иначе добавляем файл
        else {
 
        //если нужный файл, то проводим в нем подстановку пользовательских полей
            if ($filename=="content.xml") {
 
            //значения полей
                $vars=array(
                    'Дата_Начало'=>$start_date,
                    'Дата_Конец'=>$finish_date,
                    'Марка_Авто'=>$model_car,
                    'Номер_авто'=>$number_car,
                    'ФИО_Водитель_полностью'=>$fio_all,
                    'Удостоверение'=>$prava,
                    'Категория_Прав'=>$class_prav,
                    'Адрес_Подачи'=>$address_head,
                    'ФИО_Механик'=>$mechanik_name,
                    'ФИО_Водитель'=>$fio_little,
                    'Спидометр_НачМесяц'=>$speedometr_val_start_month,
                    'Марка_Горючего'=>$disel_mark,
                    'Выдано_ЗаМесяц'=>$issued_fuel,
                    'Остаток_ПриВыезде'=>$balance_fuel_start,
                    'Остаток_ПриВозвращении'=>$balance_fuel_finish,
                    'Расход_ПоНорме'=>$expenditure,
                    'Расход_ФактЗаМесяц'=>$consumption_month,
                    'Спидометр_КонецМесяц'=>$speedometr_val_finish_month
                   
                  
                );
                $t=1;
                $val=array();
                for($i=0; $i<87;$i++){ 
                   
                if($i<count($data_way)){
                $val['Дата'.$t.'']=$data_way[$i][0];
                $val['Старт'.$t.'']=$data_way[$i][1];
                $val['Финиш'.$t.'']=$data_way[$i][2];
                $val['Км_Начало'.$t.'']=$data_way[$i][3];
                $val['Км_Конец'.$t.'']=$data_way[$i][4];
                $val['Пройдено'.$t.'']=$data_way[$i][5];
                }else{
                $val['Дата'.$t.'']='';
                $val['Старт'.$t.'']='';
                $val['Финиш'.$t.'']='';
                $val['Км_Начало'.$t.'']='';
                $val['Км_Конец'.$t.'']='';
                $val['Пройдено'.$t.'']='';
                }
                 $t++;
               
                }
               
 
                //создаем объект simplexml
                $xml = new SimpleXMLElement(file_get_contents('doc/'.$filename));
 
                //получаем заранее нужные namespace
                $ns=$xml->getNamespaces(true);
 
                // две переменные, необходимые для доступа к элементам xml и к атрибутам
                $usr="user-field-decls";
                $str="string-value";
 
                //проверяем есть ли в файле пользовательские поля
                if ($fields=$xml->children($ns["office"])->body->text->children($ns["text"])->$usr) {
                //если есть, пробегаемся по ним и заменяем их атрибут string-value на новый
                    foreach ($fields->children($ns["text"]) as  $field) {
 
                        if (isset($vars[(string)$field->attributes($ns["text"])->name])) {
                            $field->attributes($ns["office"])->$str = $vars[(string)$field->attributes($ns["text"])->name];
                        }
                        if (isset($val[(string)$field->attributes($ns["text"])->name])) {
                            $field->attributes($ns["office"])->$str = $val[(string)$field->attributes($ns["text"])->name];
                        }
                    }
 
                }
                //добавляем в архив
                $zip->addFromString($filename, $xml->asXML());
            }
            else {
            //добавляем в архив из файла
                $zip->addFile('doc/'.$filename,$filename );
            }
        }
    }
 
 
    $zip->close();
} else {
    die("zip error");
}
 
//очищаем буфер и выдаем файл
ob_clean();
 
header('Content-Disposition: attachment; filename="'.$outname.'"');
header('Content-type: application/odt');
print file_get_contents($tmp_file);

