<?php require('../../util/header.inc');
	

$corporacion   =$_CORPORACION;
$ano		   = $_ANO;

//echo $cantidad;
//$corporacion=8;
foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 	

$sql_corp="select * from corp_instit where num_corp=".$corporacion;
$res_corp=pg_exec($conn,$sql_corp);
$fila_corp = @pg_fetch_array($res_corp,0);
$corp = $fila_corp['num_corp']; 


$sql_corp2="select * from corporacion where num_corp=".$corporacion;
$res_corp2=pg_exec($conn,$sql_corp2);
$fila_corp2 = @pg_fetch_array($res_corp2,0);
$nombre_corp = $fila_corp2['nombre_corp']; 


$dias=array("","","",31,30,31,30,31,31,30,31,30,31);
$meses=array("","","","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");

switch ($mes)
{

	case 3:
	$fin_dia=31;
	$mes_ant=3;
	$dia_ant=31;
	$tmes="MARZO";
	break;
	
	case 4:
	$fin_dia=30;
	$mes_ant=3;
	$dia_ant=31;
	$tmes="ABRIL";
	break;
	
	case 5:
	$fin_dia=31;
	$mes_ant=4;
	$dia_ant=30;
	$tmes="MAYO";
	break;
	
	case 6:
	$fin_dia=30;
	$mes_ant=5;
	$dia_ant=31;
	$tmes="JUNIO";
	break;
	
	case 7:
	$fin_dia=31;
	$mes_ant=6;
	$dia_ant=30;
	$tmes="JULIO";
	break;
	
	case 8:
	$fin_dia=31;
	$mes_ant=7;
	$dia_ant=31;
	$tmes="AGOSTO";
	break;
	
	case 9:
	$fin_dia=30;
	$mes_ant=8;
	$dia_ant=31;
	$tmes="Septiembre";
	break;
	
	case 10:
	$fin_dia=31;
	$mes_ant=9;
	$dia_ant=30;
	$tmes="OCTUBRE";
	break;
	
	case 11:
	$fin_dia=30;
	$mes_ant=10;
	$dia_ant=31;
	$tmes="NOVIEMBRE";
	break;
	
	case 12:
	$fin_dia=31;
	$mes_ant=11;
	$dia_ant=30;
	$tmes="DICIEMBRE";
	break;
	
}

if($xls==1){
	$fecha_actual = date('d-m-Y-H:i:s');	 
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Mat_Mes_corp_$fecha_actual.xls"); 	 
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Matr&iacute;cula Mensual Corporaci&oacute;n <?php echo $nombre_corp ?></title>
<style type="text/css">
<!--
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo5 {
	font-size: 16px;
	font-weight: bold;
}
.Estilo6 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo7 {font-size: 14px}
-->
</style>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


		  
function exportar(){
	window.location='print_mat_mes_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>&mes=<?php echo $mes ?>&xls=1';
	return false;
		  }		  
		  
</script>
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	   				
		<td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
	  
    </tr>
  </table>
</div>
<table width="100%" border="1" cellpadding="0" cellspacing="0">
												  <tr>
													<td width="20%" colspan="6" bgcolor="#CCCCCC" class="Estilo2"><div align="center" class="Estilo5 Estilo7">Matrícula de alumnos Mensual Corporaci&oacute;n <?php echo $nombre_corp ?></div></td>
												  </tr>
												  
												  <tr>
												    <td colspan="6" bgcolor="#CCCCCC" class="Estilo6"> Al mes de
												       <?php echo  $tmes ?>
&nbsp;&nbsp;&nbsp;&nbsp;												                                                                                                               </td>
											      </tr>
												  <tr>
												    <td colspan="6" bgcolor="#CCCCCC" class="Estilo6">A&ntilde;o
												      <?php echo $cmb_ano ?></td>
											      </tr>
												  <tr>
												    <td bgcolor="#CCCCCC" class="Estilo6">Establecimiento</td>
												    <td bgcolor="#CCCCCC" class="Estilo2"><div align="center"><strong>Matr&iacute;cula Mes </strong></div></td>
												    <td bgcolor="#CCCCCC" class="Estilo2"><div align="center"><strong>Matr&iacute;cula Mes Anterior </strong></div></td>
												    <td bgcolor="#CCCCCC" class="Estilo2"><div align="center"><strong>Altas</strong></div></td>
												    <td bgcolor="#CCCCCC" class="Estilo2"><div align="center"><strong>Bajas</strong></div></td>
												    <td bgcolor="#CCCCCC" class="Estilo2"><div align="center"><strong>Total</strong></div></td>
											      </tr>
													<?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = ".$corporacion." and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													 $sql_bus_anio="select * from ano_escolar where id_institucion=".$rdb." and nro_ano=".$cmb_ano;
													$res_bus_anio=@pg_Exec($conn,$sql_bus_anio);  
													for($h=0;$h<pg_numrows($res_bus_anio);$h++)
													{ 
													 $fila_anio = pg_fetch_array($res_bus_anio,$h); 
													$id_anio = $fila_anio['id_ano'];
														//busco cursos con ese año
													}	

													   ?>
													   
													  <tr>
												    <td class="Estilo2"><?php echo $establecimiento ?></td>
												    <td class="Estilo2"><div align="center">
												      <?php    $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($id_anio) and fecha<='$cmb_ano-$mes-$fin_dia' and ID_CURSO>0 ) and rut_alumno not in (select rut_alumno from matricula where id_ano = ($id_anio) and fecha_retiro <= '$cmb_ano-$mes-$fin_dia' ) ";
													  
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
																									
													echo $totalmes = $fila2['suma2'];
													$tot_ens_mes=$tot_ens_mes+$totalmes;
													
												}
											} ?>
												    </div></td>
												    <td class="Estilo2"><div align="center">
												      <?php $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($id_anio) and fecha<='$cmb_ano-$mes_ant-$dia_ant' and ID_CURSO>0 ) and rut_alumno not in (select rut_alumno from matricula where id_ano = ($id_anio) and fecha_retiro <= '$cmb_ano-$mes_ant-$dia_ant' ) ";
	
	//$qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso) and fecha<='$ob_reporte->nro_ano-$mes_ant-$dia_ant' and ID_CURSO>0 and bool_ar = '0') ";
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila2['suma2']);
													if ($mes==3)
													echo "0";
													else
													echo $totalmesant = $fila2['suma2'];
													
													$tot_mes_ant=$tot_mes_ant+$totalmesant;
													
												}
											} ?>
												    </div></td>
												    <td class="Estilo2"><div align="center">
												      <?php   
		
	$sql_calc="select count (*) as calc1 from matricula where id_ano=".$id_anio." and fecha>='".$cmb_ano."-".$mes."-1' and fecha<='".$cmb_ano."-".$mes."-".$fin_dia."'";
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				echo $calc_1=$fila_calc_1['calc1'];
				
				$tot_alt=$tot_alt+$calc_1;
				} 
				
				
		
	 
	?>
												    </div></td>
												    <td class="Estilo2"><div align="center">
												      <?php   
		
	 $sql_calc="select count (*) as calc1 from matricula where id_ano=".$id_anio." and fecha_retiro>='".$cmb_ano."-".$mes."-1' and fecha_retiro<='".$cmb_ano."-".$mes."-".$fin_dia."' and bool_ar=1";
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				echo $bajas=$fila_calc_1['calc1'];
				
				$bajas_total=$bajas_total+$bajas;
				} 
				
				
		
	 
	?>
												    </div></td>
												    <td class="Estilo2"><div align="center">
												      <?php    $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($id_anio) and fecha<='$cmb_ano-$mes-$fin_dia' and ID_CURSO>0 ) and rut_alumno not in (select rut_alumno from matricula where id_ano = ($id_anio) and fecha_retiro <= '$cmb_ano-$mes-$fin_dia' ) ";
													  
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
																									
													echo $totalmes2 = $fila2['suma2'];
													$tot_ens_mes2=$tot_ens_mes2+$totalmes2;
													
												}
											} ?>
												    </div></td>
												    </tr>
													<?php }?>
												  <tr>
												    <td bgcolor="#FFFFFF" class="Estilo6">Total</td>
												    <td bgcolor="#FFFFFF" class="Estilo2"><div align="center"><?php echo $tot_ens_mes ?></div></td>
												    <td bgcolor="#FFFFFF" class="Estilo2"><div align="center"><?php echo $tot_mes_ant ?></div></td>
												    <td bgcolor="#FFFFFF" class="Estilo2"><div align="center"><?php echo $tot_alt ?></div></td>
												    <td bgcolor="#FFFFFF" class="Estilo2"><div align="center"><?php echo $bajas_total ?></div></td>
												    <td bgcolor="#FFFFFF" class="Estilo2"><div align="center"><?php echo $tot_ens_mes2 ?></div></td>
											      </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as abril from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1 and fecha > '$cmb_ano-04-30'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $abril = $filsMatriculados['abril'];
													   ?>
													   <?
													   $total_abril = $total_abril + $abril;
												  }
												  ?>
</table>
</body>
</html>
