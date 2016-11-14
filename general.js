/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



$('document').ready(function(){
    

    $('#modal').modal();
 
   
   
});
 function load_progress(div){
     $('#'+div+'').html("<div class='progress progress-striped active'>\n\
  <div class='progress-bar' style='width: 60%;'>\n\
    <span class='sr-only'>Завершено 60%</span>\n\
  </div>\n\
</div>" );
 }

//выбор предыдущего месяца для загрузки данных об остатке топлива
function show_prev_month(){
    load_progress('last_report_date');
   var driver_name =  $('#fio_div').val();
    $('#last_report_date').load('select_prev_month.php?driver_name='+driver_name);
}
function show_report_form(){
    load_progress('report_form');
    var balance_fuel = $('#balance_fuel').val();
 
    $('#report_form').load('report_form.php?balance_fuel='+balance_fuel);
}
function Anketa_form(){
    $('#content').load('Anketa_form.php');
}
function load_anketa_form(){
    $('#fio_div').load('select_fio.php');
    $('#last_report_date').load('select_prev_month.php?driver_name='+0);
}
function add_str(){
    var date_report = document.getElementById('date_all').getElementsByTagName('input')[0].value;
    var old_date='temp';
    //определяем строки в таблице
   var str= document.getElementById('report_table').getElementsByTagName('tr');
   var str_len=str.length;
   //if(str_len==2){
       /* $('#report_table > thead').after('<tr>\n\
        <td><input type="checkbox"></input></td>\n\
        <td><textarea class="form-control" cols="8" rows="1">'+date_report+'</textarea></td>\n\
        <td><div name="start_point"></div></td>\n\
        <td><div name="finish_point"></div></td>\n\
        <td><div name="km_start"><textarea class="form-control" cols="8" rows="1" onchange="path_km_start('+str_len+');"></textarea></div></td>\n\
        <td><div name=\"km_fin\"><textarea class=\"form-control\" cols=\"8\" rows=\"1\" onchange=\"path_km_finish('+str_len+');\"></textarea></div></td>\n\
        <td><div name="dist"><textarea class="form-control" cols="8" rows="1" ></textarea></div></td>\n\
</tr>');*/
     var body = $('#report_table tbody');

     //сравнение даты текущей строки с датой из предыдущей строки
     if(str_len>2){
       old_date =  $('#report_table  tr:last td:eq(1) textarea:eq(0)').val();
   }
var mess_text='<tr>\n\
        <td><input type="checkbox"></input></td>\n\
        <td><textarea class="form-control" cols="8" rows="1">'+date_report+'</textarea></td>\n\
        <td><div name="start_point"></div></td>\n\
        <td><div name="finish_point"></div></td>';
        if((old_date!='temp')&&(old_date==date_report)){
            var old_km_start = $('#report_table  tr:last td:eq(5) textarea:eq(0)').val();
            mess_text+='<td><div name="km_start"><textarea  class="form-control" cols="8" rows="1" onchange="path_km_start('+str_len+');">'+old_km_start+'</textarea></div></td>';
        }else{
        mess_text+='<td><div name="km_start"><textarea  class="form-control" cols="8" rows="1" onchange="path_km_start('+str_len+');"></textarea></div></td>';
    }
     mess_text+='   <td><div name=\"km_fin\"><textarea class=\"form-control\" cols=\"8\" rows=\"1\" onchange=\"path_km_finish('+str_len+');\"></textarea></div></td>\n\
        <td><div name="dist"><textarea class="form-control" cols="8" rows="1" ></textarea></div></td>\n\
</tr>';
    body.append(mess_text);

    
    load_select_points(str_len);

}

function load_select_points(str_len){

    $("#report_table tr:eq("+str_len+" ) td:eq(2) div:eq(0)").load('select_shop_start.php?str_len='+str_len);
    $("#report_table tr:eq("+str_len+" ) td:eq(3) div:eq(0)").load('select_shop_finish.php?str_len='+str_len);
  

}

function calc(str){
   
    
   var val_start= $("#report_table tr:eq("+str+" ) td:eq(2) div:eq(0) select:eq(0) option:selected").val();
   var val_finish= $("#report_table tr:eq("+str+" ) td:eq(3) div:eq(0) select:eq(0) option:selected").val();
 
   calculateDistances (val_start,val_finish)
     .done(function(response){

                var origins = response.originAddresses;

                for (var i = 0; i < origins.length; i++) {
                    var results = response.rows[i].elements;
                    for (var j = 0; j < results.length; j++) {
                        //console.log(results[j].distance.text);
                      //  var znach1= Number($("#report_table tr:eq("+str+" ) td:eq(4) textarea:eq(0) ").val());//значение на момент выезда
                       
                        var km_day= Number($("#report_table tr:eq("+str+") td:eq(6) textarea:eq(0)").val()); //исходное значение пробега за день
                       // $("#report_table tr:eq("+str+") td:eq(5) textarea:eq(0) ").html(Math.ceil(znach1+results[j].distance.value/1000));
                          
                             
                          
                          $("#report_table tr:eq("+str+") td:eq(6) textarea:eq(0)").html(Math.ceil(results[j].distance.value/1000));
                       var new_km_day= Number($("#report_table tr:eq("+str+") td:eq(6) textarea:eq(0)").val()); //обновленное значение пробега за день
                       if(km_day!=new_km_day){
                           var itog_km=Number($("#itog_km textarea:eq(0)").val());
                           var new_itog_km = itog_km-km_day+new_km_day;
                           $("#itog_km textarea:eq(0)").html(new_itog_km);
                       }
                    }
                }
               
           })
           .fail(function(status){
              document.getElementById('result').innerHTML = 'An error occured. Status: ' + status;
           });
   
   }
  
   function change_km_start_up(str){
       var date_currient =  $("#report_table tr:eq("+str+" ) td:eq(1) textarea:eq(0)").val();
       var up_str=str-1;
       var date_up =  $("#report_table tr:eq("+up_str+" ) td:eq(1) textarea:eq(0)").val();
      if(date_currient==date_up){
       var km_finish_in_str_up = Number($("#report_table tr:eq("+str+" ) td:eq(4) textarea:eq(0)").val());
        $("#report_table tr:eq("+up_str+" ) td:eq(5) textarea:eq(0)").val();
       $("#report_table tr:eq("+up_str+" ) td:eq(5) textarea:eq(0)").val(km_finish_in_str_up);
       console.log('функция change km_start_up : в строку '+up_str+'значение finish_km изменено на '+km_finish_in_str_up);
       change_km_finish_up(up_str);
   }
   }
   function change_km_finish_up(str){
       var km_probeg_str =  Number($("#report_table tr:eq("+str+" ) td:eq(6) textarea:eq(0)").val());
       var km_finish_in_str_up = Number($("#report_table tr:eq("+str+" ) td:eq(5) textarea:eq(0)").val());
       var km_start_in_str_up = km_finish_in_str_up-km_probeg_str;
        $("#report_table tr:eq("+str+" ) td:eq(4) textarea:eq(0) ").val();
       $("#report_table tr:eq("+str+" ) td:eq(4) textarea:eq(0) ").val(km_start_in_str_up);
        console.log('функция change km_finish_up : в строку '+str+'значение finish_km изменено на '+km_start_in_str_up);
       change_km_start_up(str);
       
   }
   
     function change_km_finish_down(str){
       var date_currient =  $("#report_table tr:eq("+str+" ) td:eq(1) textarea:eq(0)").val();
       var down_str=str+1;
       var date_down =  $("#report_table tr:eq("+down_str+" ) td:eq(1) textarea:eq(0)").val();
      if(date_currient==date_down){
       var km_start_in_str_down = Number($("#report_table tr:eq("+str+" ) td:eq(5) textarea:eq(0)").val());
        $("#report_table tr:eq("+down_str+" ) td:eq(4) textarea:eq(0) ").val();
       $("#report_table tr:eq("+down_str+" ) td:eq(4) textarea:eq(0) ").val(km_start_in_str_down);
         console.log('функция change km_finish_down : в строку '+down_str+'значение finish_km изменено на '+km_start_in_str_down);
       change_km_start_down(down_str);
   }
   }
   function change_km_start_down(str){
       var km_probeg_str =  Number($("#report_table tr:eq("+str+" ) td:eq(6) textarea:eq(0)").val());
       var km_start_in_str_down = Number($("#report_table tr:eq("+str+" ) td:eq(4) textarea:eq(0)").val());
       var km_finish_in_str_down = km_start_in_str_down+km_probeg_str;
       console.log(km_finish_in_str_down+'km_finish_in_str_down');
        $("#report_table tr:eq("+str+" ) td:eq(5) textarea:eq(0)").val();
       $("#report_table tr:eq("+str+" ) td:eq(5) textarea:eq(0)").val(km_finish_in_str_down);
       console.log('функция change km_start_down : в строку '+str+'значение finish_km изменено на '+km_finish_in_str_down);
       change_km_finish_down(str);
       
   }
   function path_km_start(str){
      
       //меняем значение в текущей строке
       var km_start= Number($("#report_table tr:eq("+str+" ) td:eq(4) textarea:eq(0)").val());
       var km_day= Number($("#report_table tr:eq("+str+") td:eq(6) textarea:eq(0)").val()); 
       var km_finish = km_start+km_day;
       $("#report_table tr:eq("+str+" ) td:eq(5) textarea:eq(0) ").val(km_finish);
      if(str==2){
          change_km_finish_down(str);
          return;
      }
      var table_len = document.getElementById('report_table').getElementsByTagName('tr').length;
      if(str==table_len){
         change_km_finish_up(str);
          return;
      }
      if(str>2){
           change_km_finish_up(str);
          
      }
      if(str<table_len){
           change_km_finish_down(str);
          
      }
   }
   function path_km_finish (str){
       //меняем значение в текущей строке
       var km_finish= Number($("#report_table tr:eq("+str+" ) td:eq(5) textarea:eq(0)").val());
       var km_day= Number($("#report_table tr:eq("+str+") td:eq(6) textarea:eq(0)").val()); 
       var km_start = km_finish-km_day;
       $("#report_table tr:eq("+str+" ) td:eq(4) textarea:eq(0) ").val(km_start);
      if(str==2){
          change_km_start_down(str);
          return;
      }
      var table_len = document.getElementById('report_table').getElementsByTagName('tr').length;
      if(str==table_len){
         change_km_start_up(str);
          return;
      }
      if(str>2){
           change_km_start_up(str);
                
      } 
       if(str<table_len){
           change_km_start_down(str);
                
      }
   }
   
     
   
   function km_sum_month(){
         var km_month_sum=+0;
       var str= document.getElementById('report_table').getElementsByTagName('tr');
                 var str_len=str.length;
                 for (var i=2;i<str_len;i++){
                      km_month_sum+= Number($("#report_table tr:eq("+i+") td:eq(6) textarea:eq(0)").val());
                 }
                $("#itog_km textarea:eq(0)").html(km_month_sum);
                
   }
  function calculateDistances(val_start,val_finish) {
service = new google.maps.DistanceMatrixService();
  var d = $.Deferred();
   

service.getDistanceMatrix(
    {
        origins: [val_start],
        destinations: [val_finish],
        travelMode: google.maps.TravelMode.DRIVING,
        unitSystem: google.maps.UnitSystem.METRIC,
        avoidHighways: false,
        avoidTolls: false
    }, 
     function(response, status){
                  if (status != google.maps.DistanceMatrixStatus.OK) {
                     d.reject(status);
                  } else {
                     d.resolve(response);
                  }
                });
           
            return d.promise(); 

}
  

    
 
    

function del_str(){
      
   var checks =  document.getElementById('report_table').getElementsByTagName('tr');
   var i=2;
  var flag_check_str = 0;//флаг наличия выбранных строк
  if(checks.length>=2){
   while(i<checks.length){
       var tr_input = checks[i].getElementsByTagName('input')[0];
       if (tr_input.checked){
           flag_check_str=1;
          
           var itog_km=Number($("#itog_km textarea:eq(0)").val());
           var km_day = Number($("#report_table tr:eq("+i+") td:eq(6) textarea:eq(0)").val());
           checks[i].remove();
           var new_itog_km = itog_km-km_day;
                           $("#itog_km textarea:eq(0)").html(new_itog_km);
           i--;
            }
           i++;
     }     
     if(flag_check_str==0){
         alert ('Строки для удаления не выбраны!');
   }
}
 else{
     alert('Таблица с итоговыми строками для отчета не заполнена!');
 }
 }


function load_report_file(){
    var start_date = $('#date_start input:eq(0)').val();//начальная дата отчета
    var finish_date = $('#date_finish input:eq(0)').val();//конечная дата отчета
    var id_driver = $('#driver_name').val();//id driver
    var address_head = $('#address_head textarea:eq(0)').val();//адрес подачи
    var mechanik_name = $('#mechanik_name textarea:eq(0)').val()//механик/диспетчер
    var speedometr_val_start_month = $('#speedometr_val_start_month textarea:eq(0)').val() ;//показания спидометра на начало месяца
    var disel_mark = $('#disel_mark textarea:eq(0)').val() ;//марка горючего
    var issued_fuel =  $('#issued_fuel textarea:eq(0)').val() ;//выдано за месяц
    var balance_fuel_start =  $('#balance_fuel_start textarea:eq(0)').val() ;//остаток при выезде
    var balance_fuel_finish =  $('#balance_fuel_finish textarea:eq(0)').val() ;//остаток при возвращении
    var consumption_month =  $('#consumption_month textarea:eq(0)').val() ;//остаток при возвращении
    var speedometr_val_finish_month = $('#speedometr_val_finish_month textarea:eq(0)').val() ;//показания спидометра на конец месяца
    
    var str = document.getElementById('report_table').getElementsByTagName('tr');
    var data_way=new Array();//массив с путевыми данными
    var j=0;
    for(var i=2; i<str.length;i++){
     data_way[j]= new Array();
       // var start_point = str[i].getElementsByName('start_shop')[0].option.value;
      data_way[j][0]=   $("#report_table tr:eq("+i+" ) td:eq(1) textarea:eq(0)").val();//date in str
      data_way[j][1]= $("#report_table tr:eq("+i+" ) td:eq(2) select:eq(0) option:selected").text();//start_point
      data_way[j][2] = $("#report_table tr:eq("+i+" ) td:eq(3) select:eq(0) option:selected").text();//finish_point
      data_way[j][3]=   $("#report_table tr:eq("+i+" ) td:eq(4) textarea:eq(0)").val();//start_km_day
      data_way[j][4]=   $("#report_table tr:eq("+i+" ) td:eq(5) textarea:eq(0)").val();//finish_km_day
      data_way[j][5]=   $("#report_table tr:eq("+i+" ) td:eq(6) textarea:eq(0)").val();//distance_day
    j++;
    }
    
data_way =JSON.stringify(data_way);
   window.open('file_report.php?start_date='+start_date+'&finish_date='+finish_date+'&id_driver='+id_driver+'&address_head='+address_head+
           '&mechanik_name='+mechanik_name+'&speedometr_val_start_month='+speedometr_val_start_month+'&disel_mark='+disel_mark+
           '&issued_fuel='+issued_fuel+'&balance_fuel_start='+balance_fuel_start+'&balance_fuel_finish='+balance_fuel_finish+
           '&consumption_month='+consumption_month+'&speedometr_val_finish_month='+speedometr_val_finish_month+'&data_way='+data_way);
}

function setting_data(){
     $('#content').load('setting_data_form.php');
}
function load_data_shop(){
$.post( "load_shop_data.php", function( data ) {
  alert(data);
});
}

function write_fuel_disel(){
    var id_driver = $('#driver_name').val();//id driver
    var finish_date = $('#date_finish input:eq(0)').val();//конечная дата отчета
    var balance_fuel_finish =  $('#balance_fuel_finish textarea:eq(0)').val() ;//остаток при возвращении
 $.post( "write_fuel_disel.php",{id_driver:id_driver, finish_date:finish_date, balance_fuel_finish:balance_fuel_finish})
 .done(function(data) {

  alert("Data Loaded: " + data);

});

}