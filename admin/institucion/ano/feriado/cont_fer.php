<?php 
require('../../../../util/header.inc');
$funcion=$_POST['funcion'];

if($funcion==1){
	?>
    
    <script>
var disabledDays = [];
//var disabledDays = ["2-21-2015","2-24-2015","2-27-2015","2-28-2015","3-3-2015","3-17-2015","4-2-2015","4-3-2015","4-4-2015","4-5-2015"];

function nationalDays(date) {
	var m = date.getMonth(), d = date.getDate(), y = date.getFullYear();
	//console.log('Checking (raw): ' + m + '-' + d + '-' + y);
	for (i = 0; i < disabledDays.length; i++) {
		if($.inArray((m+1) + '-' + d + '-' + y,disabledDays) != -1 ) {
			//console.log('bad:  ' + (m+1) + '-' + d + '-' + y + ' / ' + disabledDays[i]);
			return [false, "festivos", 'Día festivo'];
			//return [false];
		}
	}
	//console.log('good:  ' + (m+1) + '-' + d + '-' + y);
	return [true];
}
function noWeekendsOrHolidays(date) {
	var noWeekend = jQuery.datepicker.noWeekends(date);
	return noWeekend[0] ? nationalDays(date) : noWeekend;
}

/* create datepicker */
jQuery(document).ready(function() {
	jQuery('#fechaini,#fechater').datepicker({
		minDate: new Date('<?php echo $fiano[1]."/".$fiano[2]."/".$fiano[0] ?>'),
		maxDate: new Date('<?php echo $ftano[1]."/".$ftano[2]."/".$ftano[0] ?>'),
		dateFormat: 'dd-mm-yy',
		constrainInput: true,
		changeMonth: true,
		monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
	  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
	  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'S&aacute;bado'],
	  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
	  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
	  firstDay: 1,
	  beforeShowDay: noWeekendsOrHolidays
	});
});

	</script>
<table width="90%" border="0">
  <tr>
    <td width="15%" class="cuadro02">Fecha Inicio</td>
    <td width="85%" class="cuadro01"><input name="fechaini" type="text" id="fechaini" value="" size="10" maxlength="10" readonly></td>
  </tr>
  <tr>
    <td class="cuadro02">Fecha t&eacute;rmino</td>
    <td class="cuadro01"><input name="fechater" type="text" id="fechater" v size="10" maxlength="10" readonly></td>
  </tr>
  <tr>
    <td class="cuadro02">Descripci&oacute;n</td>
    <td class="cuadro01"><input name="desc" type="text" id="desc" size="40"  ></td>
  </tr>
</table>
<?

}

if($funcion==2){
$sql="insert into feriado_ano(nro_ano,fecha_inicio,fecha_termino,descripcion) values($ano,'".CambioFE($finicio)."','".CambioFE($termino)."','".utf8_decode($desc)."')";	
//$result=pg_exec($conn,$sql);

$base=$_ID_BASE;

if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	
	
	
	}

$result = pg_exec($conn,$sql);
$result2 = pg_exec($conn2,$sql);
$result3 = pg_exec($conn3,$sql);

echo($result && $result2 && $result3)?1:0;
}

if($funcion==3){
//show($_POST);
/*$base=$_ID_BASE;
if($base==1){
		//coi final
	
	 $conn2=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
	 $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
	 
}
if($base==2){
	 //coi viña
	
	  $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
      $conn3=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	
	
}
	 //coi corpraciones
if($base==4){	
	 $conn2=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
  de conexion Coi_final");
	  $conn3=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");

}*/





$sql_ins = "select * from institucion where estado_colegio=1 order by base_datos,rdb ";
$rs_ins=pg_exec($connection,$sql_ins);

	for($in=0;$in<pg_numrows($rs_ins);$in++){
		$fins=pg_fetch_array($rs_ins,$in);
		
		switch($fins['base_datos']){
		//coi_final
		case 1:
		$conec=pg_connect("dbname=coi_final host=192.168.1.10 port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");
		break;
		
		//coi_viña
		case 2:
		$conec=pg_connect("dbname=coi_final_vina host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");
		break;
		
		//coi_corporaciones
		case 4:
		$conec=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");
		break;	
		
		}
		
		
		//busco los años escolares
		$sql_ano="select * from ano_escolar where id_institucion=".$fins['rdb']." and nro_ano=".$ano;
		$rs_ano = pg_exec($conec,$sql_ano);
		
		for($aa=0;$aa<pg_numrows($rs_ano);$aa++){
		$fano = pg_fetch_array($rs_ano,$aa);
		
		//busco los periodos
		 $sql_periodo="select * from periodo where id_ano=".$fano['id_ano']."order by fecha_inicio";
		$rs_periodo = pg_exec($conec,$sql_periodo);
			for($pp=0;$pp<pg_numrows($rs_periodo);$pp++){
				$fper=pg_fetch_array($rs_periodo,$pp);
				//buscar los feriados del año que coincidan con los periodos
				 $sql_fer="select * from feriado_ano where nro_ano=$ano and fecha_inicio>='".$fper['fecha_inicio']."' and fecha_termino<='".$fper['fecha_termino']."'";
				 $rs_fer=pg_exec($conec,$sql_fer);
				 for($ff=0;$ff<pg_numrows($rs_fer);$ff++){
					$ffer=pg_fetch_array($rs_fer,$ff);
					//ingresar los feriados
					$sql_ins = "insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$fano['id_ano'].",'".$ffer['fecha_inicio']."','".$ffer['fecha_termino']."','".$ffer['descripcion']."',1,".$fper['id_periodo'].");";	 
					$rs_insf1=pg_exec($conec,$sql_ins);
					
					
				}
				 
				 //vacaciones de invierno
				 if($pp==0){
					 $sql_vaca1 = "insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$fano['id_ano'].",'$ano-07-10','$ano-07-14','Vacaciones de Invierno',1,".$fper['id_periodo'].");";
					$rs_vaca1=pg_exec($conec,$sql_vaca1);
					
					  $sql_vaca2 = "insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$fano['id_ano'].",'$ano-07-17','$ano-07-21','Vacaciones de Invierno',1,".$fper['id_periodo'].");";
					 $rs_vaca2=pg_exec($conec,$sql_vaca2);	
					}
				 
			}
		
		}
		
	}
echo 1;
}//fin funcion

if($funcion==4){
	?>
    <script>
	$(document).ready(function(){
    $('.check:checkbox').toggle(function(){
        $('input:checkbox').attr('checked','checked');
       
    },function(){
        $('input:checkbox').removeAttr('checked');
             
    })
})


	</script>
    <?
	
	 $sql_cur="select * from curso where id_ano=".$_ANO." order by ensenanza,grado_curso,letra_curso";
	$rs_cur = pg_exec($conn,$sql_cur);
	
	
	?>
    <form id="crc" name="crc">
	<table width="371" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
    <tr class="textosimple">
     <td colspan="2"><input type="checkbox" class="check" value="check all"/>TODOS
      <input type="hidden" name="fer" id="fer" value="<?php echo $fer ?>" /></td>
     </tr>
   <?php  for($c=0;$c<pg_numrows($rs_cur);$c++){
	   $fila_cur = pg_fetch_array($rs_cur,$c);
	   $sql_cfer="select * from feriado_curso where id_feriado=".$fer = $_POST['fer']."and id_curso=".$fila_cur['id_curso'];
		$rs_cfer=pg_exec($conn,$sql_cfer);
	   ?>
   
   <tr class="textosimple">
    <td width="32"><input type="checkbox" name="cur" id="cur[]" value="<?php echo $fila_cur['id_curso'] ?>" class="cb-element" <?php echo (pg_result($rs_cfer,0)>0)?"checked":""; ?>/></td>
    <td width="333">&nbsp;<?php echo CursoPalabra($fila_cur['id_curso'],1,$conn) ?></td>
  </tr>
<?php  }?>
</table>
</form>
<?
	
}

if($funcion==5){
//show($_POST);

$cad = explode(",",$_POST['cur']);
$fer = $_POST['fer'];

$sql_bfer="delete from feriado_curso where id_feriado=".$fer;
$rs_bfer = pg_exec($conn,$sql_bfer);

for($i=0;$i<count($cad);$i++){
	// echo $cad[$i];
	$sql_afer="insert into feriado_curso values(".$fer.",".$cad[$i].")";
	$rs_afer = pg_exec($conn,$sql_afer);
}
	
}

if($funcion==6){


echo $sql_periodo="select * from periodo where id_ano=".$ano." order by fecha_inicio";
		$rs_periodo = pg_exec($conn,$sql_periodo);
			for($pp=0;$pp<pg_numrows($rs_periodo);$pp++){
				$fper=pg_fetch_array($rs_periodo,$pp);
				//buscar los feriados del año que coincidan con los periodos
				echo  $sql_fer="select * from feriado_ano where nro_ano=$nro_ano and fecha_inicio>='".$fper['fecha_inicio']."' and fecha_termino<='".$fper['fecha_termino']."'";
				 $rs_fer=pg_exec($conn,$sql_fer);
				 for($ff=0;$ff<pg_numrows($rs_fer);$ff++){
					$ffer=pg_fetch_array($rs_fer,$ff);
					//ingresar los feriados
					echo $sql_ins = "insert into feriado (id_ano,fecha_inicio,fecha_fin,descripcion,bool_fer,id_periodo) values(".$ano.",'".$ffer['fecha_inicio']."','".$ffer['fecha_termino']."','".$ffer['descripcion']."',1,".$fper['id_periodo'].");";	 
					$rs_insf1=pg_exec($conn,$sql_ins);
					
					
				}
			}
			
			//select feriados
			
			

echo "<br>".$sql_fer="select id_feriado from feriado where id_ano = ".$ano;
$rs_fer = pg_exec($conn,$sql_fer);

echo "<br>".$sql_cur="select id_curso from curso where id_ano = ".$ano;
$rs_cur = pg_exec($conn,$sql_cur);


for($c=0;$c<pg_numrows($rs_cur);$c++){
$fila_curso = pg_fetch_array($rs_cur,$c);

	//paseo por los feriados
	for($f=0;$f<pg_numrows($rs_fer);$f++){
	$fila_feriado = pg_fetch_array($rs_fer,$f);
	
	echo "<br>".$sql_copiaf ="insert into feriado_curso values(".$fila_feriado['id_feriado'].",".$fila_curso['id_curso'].")";
	$rs_copiaf = pg_exec($conn,$sql_copiaf);
		
	}
	
}

}
?>