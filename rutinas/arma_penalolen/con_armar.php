<?php
$connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");
 
//include_once('../../util/funciones_utiles.php');

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
 // echo "<br>".$asignacion;
}

if($base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }

if($funcion==1){
  $srdb = "select ins.rdb,ins.nombre_instit from institucion ins inner join corp_instit on corp_instit.rdb=ins.rdb where num_corp=38 order by nombre_instit";
$rrdb=pg_exec($conn,$srdb);


 $srdbI = "select ins.rdb,ins.nombre_instit from institucion ins inner join corp_instit on corp_instit.rdb=ins.rdb where num_corp=38 order by nombre_instit";
$rrdbI=pg_exec($conn,$srdbI);

$dcad_ano ="";
for($i=0;$i<pg_numrows($rrdbI);$i++){
$ffI=pg_fetch_array($rrdbI,$i);
$dcad_ano.=$ffI['rbd'].",";
}
$dcad_ano = substr($dcad_ano, 0, -1);
?>
<select name="rdb" id="rdb" onchange="listaAno()">
<option value="0">TODOS</option>
<?php for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
     <option value="<?php echo $ff['rdb'] ?>"><?php echo utf8_encode($ff['nombre_instit']) ?></option>
    <?php
	}
	?>
</select>
<?php
	
}
if($funcion==2){
	
 	 $srdb = "select distinct(id_ano),nro_ano from
 ano_escolar where id_institucion=$rdb and nro_ano >= 2016  order by nro_ano
";
$rrdb=pg_exec($conn,$srdb);
?>
<select name="cmbANO" id="cmbANO">
<option value="0">SELECCIONE A&Ntilde;O</option>
<?php
   for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
    
    <option value="<?php echo $ff['id_ano'] ?>" ><?php echo $ff['nro_ano'] ?></option>
    
      
      <?php
      }
	  ?>
	  </select>
      <?php
}
if($funcion==3){
 	 $srdb = "select distinct(id_ano),nro_ano from
 ano_escolar where id_institucion=$rdb   order by nro_ano
";
$rrdb=pg_exec($conn,$srdb);
?>
<select name="cmbANO" id="cmbANO">
<option value="0">SELECCIONE A&Ntilde;O</option>
<?php
   for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
    
    <option value="<?php echo $ff['id_ano'] ?>"><?php echo $ff['nro_ano'] ?></option>
    
      
      <?php
      }
	  ?>
	  </select>
      <?php
}
if($funcion==4){
	
function semanas($a) {   // $a -> año 
   return date("W", mktime(0,0,0,12,28,$a)); 
} 	

function WeekToDate ($week, $year) 
{ 
$Jan1 = mktime (1, 1, 1, 1, 1, $year); 
$iYearFirstWeekNum = (int) strftime("%W",mktime (1, 1, 1, 1, 1, $year)); 

if ($iYearFirstWeekNum == 1) 
{ 
$week = $week - 1; 
} 

$weekdayJan1 = date ('w', $Jan1); 
$FirstMonday = strtotime(((4-$weekdayJan1)%7-3) . ' days', $Jan1); 
$CurrentMondayTS = strtotime(($week) . ' weeks', $FirstMonday); 
return ($CurrentMondayTS); 
} 
$iYear = $_POST['nano']; 

$diaSemana=date("w",mktime(0,0,0,1,1,$_POST['nano']));

$parte=($diaSemana==1)?1:0;

?>

<select name="semanadesde" id="semanadesde" >
<option value="99">Seleccione</option>
<? for ($i = $parte; $i <= semanas($_POST['nano']); $i++) { 
$num=($diaSemana==1)?$i:$i+1;
$sStartTS = WeekToDate ($i,$_POST['nano']); 
$sLunes = date ("Y-m-d", $sStartTS);
$mLunes = date ("d-m-Y", $sStartTS);  
list($year,$mon,$day) = explode('-',$sLunes); 
$sDomingo = date('Y-m-d',mktime(0,0,0,$mon,$day+6,$year));
$mDomingo = date('d-m-Y',mktime(0,0,0,$mon,$day+6,$year));

  ?>   
<option value="<?php echo $sLunes ?>" ><?php echo $mLunes.' a '.$mDomingo ?>  
</option>   
<?php } ?>
</select> a 
<select name="semanahasta" id="semanahasta" >
<option value="99">Seleccione</option>
<? for ($i = $parte; $i <= semanas($_POST['nano']); $i++) { 
$num=($diaSemana==1)?$i:$i+1;
$sStartTS = WeekToDate ($i,$_POST['nano']); 
$sLunes = date ("Y-m-d", $sStartTS);
$mLunes = date ("d-m-Y", $sStartTS);  
list($year,$mon,$day) = explode('-',$sLunes); 
$sDomingo = date('Y-m-d',mktime(0,0,0,$mon,$day+6,$year));
$mDomingo = date('d-m-Y',mktime(0,0,0,$mon,$day+6,$year));

  ?>   
<option value="<?php echo $sDomingo ?>"><?php echo $mLunes.' a '.$mDomingo ?>  
</option>   
<?php } ?>
</select>

<?
}

?>