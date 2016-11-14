<?php


//создать базу, создать конф, прописать сюда
$host='localhost';
$user='root';
$password='';
$database='road_report';
$link = mysqli_connect($host, $user, $password, $database) 
    or die("Ошибка " . mysqli_error($link));

$balance_fuel=$_GET['balance_fuel'];
echo "<div class='All_div'> ";
echo "<div class='Left_col'>";
echo "<div class='input-group date' id='date_start'>
    <input type='text' class='form-control' />
    <span class='input-group-addon' style='width:20%;'>
      <span class='glyphicon glyphicon-calendar'></span>
    </span>
  </div>";
echo "<div class='input-group date' id='date_finish'>
    <input type='text' class='form-control' />
    <span class='input-group-addon' style='width:20%;'>
      <span class='glyphicon glyphicon-calendar'></span>
    </span>
  </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Адрес подачи</label>
            <div class='col-sm-10' id='address_head'>
               <textarea class='form-control' rows='1'>г.Челябинск, ул.Ленина,11</textarea>
            </div>
        </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Показания спидометра на начало месяца</label>
            <div class='col-sm-10' id='speedometr_val_start_month'>
                <textarea class='form-control' rows='1' cols='20'></textarea>
            </div>
        </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Марка горючего</label>
            <div class='col-sm-10' id='disel_mark'>
                <textarea class='form-control' rows='1'>АИ-95</textarea>
            </div>
        </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Выдано за месяц</label>
            <div class='col-sm-10' id='issued_fuel'>
              <textarea class='form-control' rows='1'></textarea>
            </div>
        </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Остаток при выезде</label>
            <div class='col-sm-10' id='balance_fuel_start'>
               <textarea class='form-control' rows='1'>".$balance_fuel."</textarea>
            </div>
        </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Остаток при возвращении</label>
            <div class='col-sm-10' id='balance_fuel_finish'>
                <textarea class='form-control' rows='1'></textarea>
            </div>
        </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Расход: фактический за месяц</label>
            <div class='col-sm-10' id ='consumption_month'>
               <textarea class='form-control' rows='1'></textarea>
            </div>
        </div>";
    echo "<div class='form-group'>
            <label class=' control-label' >Показания спидометра на конец месяца</label>
            <div class='col-sm-10' id='speedometr_val_finish_month'>
               <textarea class='form-control' rows='1'></textarea>
            </div>
    </div>";
     echo "<div class='form-group'>
            <label class=' control-label' >Механик   _</label>
            <div class='col-sm-10' id='mechanik_name'>
               <textarea class='form-control' rows='1'>Семенов И.П.</textarea>
            </div>
    </div>";
     echo "<button type='button' class='btn btn-default' style='margin:5px;' onclick='write_fuel_disel();'>
      Записать остаток бензина</button>";



echo "</div>";
echo "<div class='Right_col'>";
echo "<button type='button' class='btn btn-default' style='margin:5px;' onclick='add_str();'>
      <span class='glyphicon  glyphicon-plus'></span> Добавить</button>";
echo "<button type='button' class='btn btn-default' style='margin:5px;' onclick='del_str();'>
      <span class='glyphicon  glyphicon-minus'></span> Удалить</button>";

echo "<div class='input-group date' id='date_all'>
    <input type='text' class='form-control' />
    <span class='input-group-addon' style='width:20%;'>
      <span class='glyphicon glyphicon-calendar'></span>
    </span>
  </div>";


     


echo "<table id='report_table' class='table table-bordered' style='padding:10px'>";
echo "<thead><tr><th rowspan='2'></th>
<th rowspan='2'>Дата</th>
<th colspan='2'>Место</th>
<th colspan='2' >Показания спидометра</th>
<th>Пройдено</th>
</tr>
<tr><th>отправления</th>
<th>назначения</th>
<th>на начало дня</th>
<th>на конец дня</th>
<th>км</th>
</tr></thead>";
echo "<tbody></tbody>";
echo "</table>";

echo "</div>";
echo "<div class='form-group'><div class='form-group' style='width:30%; margin-left:70%;'>
            <label class=' control-label' >Итого пройдено за месяц</label>
            <div class='col-sm-8' id='itog_km'>
                <textarea class='form-control' rows='1'>0</textarea>
            </div>
            </div
        </div>";
echo "<div><button type='button' class='btn btn-default' style='margin:5px;' onclick='load_report_file();'>
      Сформировать файл</button></div>";
echo"</div>";
   
echo "<script type='text/javascript'>
     var date = new Date();
     var today = '01.'+(date.getMonth()+1)+'.'+date.getFullYear();
     var finish_date = '31.'+(date.getMonth()+1)+'.'+date.getFullYear();
     
     $(function () {
    $('#date_all').datetimepicker(
   
      {pickTime: false, language: 'ru',defaultDate:today}
    );
  });
    $(function () {
    $('#date_start').datetimepicker(
   
      {pickTime: false, language: 'ru',defaultDate:today}
    );
  });
    $(function () {
    $('#date_finish').datetimepicker(
   
      {pickTime: false, language: 'ru',defaultDate:finish_date}
    );
  });
</script>";



