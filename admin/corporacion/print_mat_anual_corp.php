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
	break;
	
	case 4:
	$fin_dia=30;
	$mes_ant=3;
	$dia_ant=31;
	break;
	
	case 5:
	$fin_dia=31;
	$mes_ant=4;
	$dia_ant=30;
	break;
	
	case 6:
	$fin_dia=30;
	$mes_ant=5;
	$dia_ant=31;
	break;
	
	case 7:
	$fin_dia=31;
	$mes_ant=6;
	$dia_ant=30;
	break;
	
	case 8:
	$fin_dia=31;
	$mes_ant=7;
	$dia_ant=31;
	break;
	
	case 9:
	$fin_dia=30;
	$mes_ant=8;
	$dia_ant=31;
	break;
	
	case 10:
	$fin_dia=31;
	$mes_ant=9;
	$dia_ant=30;
	break;
	
	case 11:
	$fin_dia=30;
	$mes_ant=10;
	$dia_ant=31;
	break;
	
	case 12:
	$fin_dia=31;
	$mes_ant=11;
	$dia_ant=30;
	break;
	
}

if($xls==1){
	$fecha_actual = date('d-m-Y-H:i:s');	 
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Mat_mes_corp_$fecha_actual.xls"); 	 
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo2 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo3 {font-size: 10px}
.Estilo4 {font-weight: bold}
.Estilo5 {font-size: 14px}
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
	window.location='print_mat_anual_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>&xls=1';
	return false;
		  }		  
		  
</script>
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
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td colspan="14"><div align="center" class="Estilo1 Estilo5"><strong>Total matr&iacute;cula corporaci&oacute;n <?php echo $nombre_corp ?></strong></div></td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="Estilo4 Estilo1 Estilo3">Establecimiento</td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">MAR</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">ABR</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">MAY</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">JUN</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">JUL</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">AUG</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">SEP</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">OCT</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">NOV</div></td>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2">DIC</div></td>
  </tr>
	<?php
											 $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = ".$corporacion." and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												 // echo "encontrados=".pg_numrows($result_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													 $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													  
													  //busco año escolar
													$sql_bus_anio="select * from ano_escolar where id_institucion=".$rdb." and nro_ano=".$cmb_ano;
													$res_bus_anio=@pg_Exec($conn,$sql_bus_anio);  
													for($h=0;$h<pg_numrows($res_bus_anio);$h++)
													{ 
													 $fila_anio = pg_fetch_array($res_bus_anio,$h); 
														$id_anio = $fila_anio['id_ano'];
														//busco cursos con ese año
														

													   ?>
  <tr>
    <td class="Estilo4"><span class="Estilo11 Estilo1 Estilo3"><?php echo $establecimiento ?> </span></td>
	<?php for ($a=0;$a<=12;$a++)
	{
		
		if ($a>2)
		{
		//empezar a hacer calculo
		
	?>
    <td >
	  <div align="center" class="Estilo11 Estilo1 Estilo3" >
	    <?php   
		//retirados
		 $sql_calc="select count (*) as calc1 from matricula where id_ano=".$id_anio." and fecha_retiro<=".$cmb_ano."-".$a."-".$dias[$a];
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				 $calc_1=$fila_calc_1['calc1'];
				} 
				
				//matricula total
			$sql_calc="select count (*) as calc2 from matricula where id_ano=".$id_anio;
				$res_calc=pg_exec($conn,$sql_calc);
				for($c=0;$c<pg_numrows($res_calc);$c++)
				{
				$fila_calc_2 = pg_fetch_array($res_calc,$c);
				$calc_2=$fila_calc_2['calc2'];
				
				$total=$total+$calc_2;
				} 
				
	  $calc_total=$calc_2-$calc_1;
	echo $calc_total;
	?>
    </div></td>
    <?php
	 }
	}
	}
	?>
  </tr>
	<?php  }?>
	 <tr>
    <td bgcolor="#CCCCCC" class="Estilo4 Estilo1 Estilo3">Totales</td>
	<?php for ($a=0;$a<=12;$a++)
	{
		
		if ($a>2)
		{
		//empezar a hacer calculo
		
	?>
    <td bgcolor="#CCCCCC" class="Estilo4"><div align="center" class="Estilo2"><span class="Estilo11"><?php   
		//retirados
		   $sql_calc="select count(rut_alumno) as calc1 from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = $cmb_ano and id_institucion in (select rdb from corp_instit where num_corp=$corporacion)) and fecha_retiro<".$cmb_ano."-".$a."-".$dias[$a];
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				 $calc_1=$fila_calc_1['calc1'];
				} 
				
				//matricula total
		$sql_calc="select count(rut_alumno) as calc2 from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = $cmb_ano and id_institucion in (select rdb from corp_instit where num_corp=$corporacion))";
				$res_calc=pg_exec($conn,$sql_calc);
				for($c=0;$c<pg_numrows($res_calc);$c++)
				{
				$fila_calc_2 = pg_fetch_array($res_calc,$c);
				$calc_2=$fila_calc_2['calc2'];
				
				$total=$total+$calc_2;
				} 
				
	  $calc_total=$calc_2-$calc_1;
	echo $calc_total;
	?></span></div></td>
    <?php }
	}?>
    </tr>
</table>
</body>
</html>
