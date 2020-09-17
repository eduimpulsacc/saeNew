<?	require('../../util/header.inc');

$rut;
//"<br/>";
$nombre_em=$_POST['txtnombreem'];
//"<br/>";
$rut_emp=$_POST['txtrutemp'];
//"<br/>";
$fono_emp=$_POST['txtfonoemp'];
//"<br/>";
$encargado=$_POST['txtencargado'];
///"<br/>";
$fech_ini=$_POST['txtinicio'];
//"<br/>";
$fech_ter=$_POST['txttermino'];
//"<br/>";
$cantidad=$_POST['txtcantidad'];
//"<br/>";
$monto=$_POST['txtmonto'];
//"<br/>";
//echo "id:".$id_practica;
//echo "<br/>";
//$caso;
//echo "<br/>";
$calificacion=$_POST['txtcalif'];
//echo "<br/>";
$horas=$_POST['txtcantidadhoras'];
//echo "<br/>";
$fecha_actual=date("m-d-Y");
//echo "<br/>";
$estado=$_POST['cmb_varios'];
//echo "<br/>";
$descripcion=$_POST['textareadescripcion'];
//echo "<br/>";
$cmb=$_POST['cmb_practica'];
//echo "<br/>";
$titulo=$_POST['txtnumerotitu'];
//echo "<br/>";
$fecha_titulo=$_POST['txtfechatitu'];
$decreto=$_POST['txtdecretotitulacion'];
//////////////////////////////////////////////////
$FECHAC1= $fech_ini;
$AA1 = substr ("$FECHAC1;", 6, -1); 
$mm1 = substr ("$FECHAC1;", 3, -6);
$dd1 = substr ("$FECHAC1;", 0, -9);
$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
$dia1 = $dia11["mday"];
if($dia1<10){
	 $dia1 = "0".$dia1;
}else{
	 $dia1;
	}
$mes1 = $dia11["mon"];
if($mes1<10){
	 $mes1 = "0".$mes1;
}else{
	 $mes1;
}
$fecha_mes1 =$mes1."-".$dia1;
$FECHAC1 = $fecha_mes1."-".$dia11["year"];
////////////////////////////////////////////////

//////////////////////////////////////////////////
$FECHAC2= $fech_ter;
$AA2 = substr ("$FECHAC2;", 6, -1); 
$mm2 = substr ("$FECHAC2;", 3, -6);
$dd2 = substr ("$FECHAC2;", 0, -9);
$dia22 = getdate(mktime(0,0,0,$mm2,$dd2,$AA2));
$dia2 = $dia22["mday"];
if($dia2<10){
	 $dia2 = "0".$dia2;
}else{
	 $dia2;
	}
$mes2 = $dia22["mon"];
if($mes2<10){
	 $mes2 = "0".$mes2;
}else{
	 $mes2;
}
$fecha_mes2 =$mes2."-".$dia2;
$FECHAC2 = $fecha_mes2."-".$dia22["year"];
////////////////////////////////////////////////

//////////////////////////////////////////////////
$FECHAC3= $fecha_titulo;
$AA3 = substr ("$FECHAC3;", 6, -1); 
$mm3 = substr ("$FECHAC3;", 3, -6);
$dd3 = substr ("$FECHAC3;", 0, -9);
$dia33 = getdate(mktime(0,0,0,$mm3,$dd3,$AA3));
$dia3 = $dia33["mday"];
if($dia3<10){
	 $dia3 = "0".$dia3;
}else{
	 $dia3;
	}
$mes3 = $dia33["mon"];
if($mes3<10){
	 $mes3 = "0".$mes3;
}else{
	 $mes3;
}
$fecha_mes3 =$mes3."-".$dia3;
$FECHAC3 = $fecha_mes3."-".$dia33["year"];
////////////////////////////////////////////////

if($fech_ter==0 or $fech_ter==""){
  $fech_ter='NULL';
 }

 if($caso==1){
 
 $sql="INSERT INTO practicas (rut_alu,id_ano,nombre_emp,rut_emp,fono_emp,encargado_alu,fecha_ini,fecha_ter,cantidad_horas,monto_pago,estado) ";
 $sql.=" VALUES (".$rut.",".$_ANO.",'".$nombre_em."',".$rut_emp.",".$fono_emp.",'".$encargado."','".$FECHAC1."','".$FECHAC2."',".$cantidad.",".$monto.",2)";
 $rs_sql = pg_exec($conn,$sql);
 
?>
 
<script language="javascript">window.location="listaPractica.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>
 
<? } ?>
 
<? if($caso==2){ 
 
 $sql_up = " UPDATE practicas SET nombre_emp='".$nombre_em."',rut_emp=".$rut_emp.",fono_emp=".$fono_emp.",encargado_alu='".$encargado."', fecha_ini='".$FECHAC1."', fecha_ter='".$FECHAC2."' ";
 $sql_up.=" ,cantidad_horas=".$cantidad.", monto_pago=".$monto.", estado=2 where id_practica=$id_practica ";
 $rs_up = pg_exec($conn,$sql_up);
 
?>
 
<script language="javascript">window.location="listaPractica.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>
 
<? } ?>

<? if($caso==3){ 
 
 if($calificacion<40){
 
 $sql  = "UPDATE practicas SET estado=1 WHERE id_practica=$cmb";
 $resp = pg_exec($conn,$sql);
 
 	}else{
 
 $sql  = "UPDATE practicas SET estado=3 WHERE id_practica=$cmb";
 $resp = pg_exec($conn,$sql);
 
 }
 
 $sql_eva = " INSERT INTO eval_practicas (id_practica,fecha_eval,calificacion,cantidad_horas) VALUES ";
 $sql_eva.=" (".$cmb.",'".$fecha_actual."',".$calificacion.",".$horas.") ";
 $rs_eva = pg_exec($conn,$sql_eva);
 
?>
 
<script language="javascript">window.location="listaevaluacion.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>
 
<? } ?>

<? if($caso==4){ 
 
  if($calificacion<40){
 
 $sql  = "UPDATE practicas SET estado=1 WHERE id_practica=$id_practica";
 $resp = pg_exec($conn,$sql);
 
 	}else{
 
 $sql  = "UPDATE practicas SET estado=3 WHERE id_practica=$id_practica";
 $resp = pg_exec($conn,$sql);
 
 }
 
 $sql_eva_up = " UPDATE eval_practicas SET calificacion=".$calificacion." , cantidad_horas=".$horas." ";
 $sql_eva_up.=" where id_practica=$id_practica";
 $rs_eva_up = pg_exec($conn,$sql_eva_up);
 
?>
 
<script language="javascript">window.location="listaevaluacion.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>

<? } ?>
<?  if($caso==5){ 
 
 
 //$sqlid="select id_practica from practicas where rut_alumno=$rut and estado>1";
 //$respid=pg_exec($conn,$sqlid);
 //$id=pg_result($respid,0);
 
 $sql  = "UPDATE practicas SET estado=4 WHERE id_practica=$id_practica";
 $resp = pg_exec($conn,$sql);
 
 
 $sql_titu = "INSERT INTO titulacion (rut_alu,rdb,fecha_envio_nomina) ";
 $sql_titu.= "values ('$rut','$_INSTIT','$fecha_actual') ";
 $rs_titu = pg_exec($conn,$sql_titu);
 
?>
 
<script language="javascript">window.location="titulacion.php?rut=<?=$fila['rut_alumno'];?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>

<? } ?>

<? if($caso==6){ 
 
 $sql_varios ="INSERT INTO practicas (rut_alu,estado,descripcion)  ";
 $sql_varios.=" VALUES (".$rut.",'".$estado."','".$descripcion."') ";
 $rs_varios = pg_exec($conn,$sql_varios);
 
?>

<script language="javascript">window.location="alumnoPractica.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>
 
<? } ?>
<? if($caso==7){ 
 
 $sql_up_varios ="UPDATE practicas SET estado='".$estado."',descripcion='".$descripcion."' where rut_alu=$rut  ";
 $rs_up_varios = pg_exec($conn,$sql_up_varios);
 
?>

<script language="javascript">window.location="alumnoPractica.php?rut=<?=$rut;?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>
 
<? } ?>
<?  if($caso==8){ 
 
 
 $sql  = "UPDATE practicas SET estado=5 WHERE id_practica=$id_practica";
 $resp = pg_exec($conn,$sql);
 
 
 $sql_titu = "UPDATE titulacion SET numero_titulo='".$titulo."', ";
 $sql_titu.= " fecha_entrega_titulo='".$FECHAC3."', decreto_proceso_titulo='".$decreto."' where rut_alu=$rut ";
 $rs_titu = pg_exec($conn,$sql_titu);
 

 
?>
 
<script language="javascript">window.location="titulacion.php?rut=<?=$fila['rut_alumno'];?>&cmb_ense=<?=$cmb_ense?>&cmb_curso=<?=$cmb_curso?>"</script>

<? } ?>
