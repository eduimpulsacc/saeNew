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
	header("Content-Disposition:inline; filename=Mat_ind_corp_$fecha_actual.xls"); 	 
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Alumnos de origen ind�gena Corporaci&oacute;n <?php echo $nombre_corp ?></title>
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo14 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
.Estilo16 {
	font-size: 10px;
	font-weight: bold;
}
.Estilo17 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
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
	window.location='print_mat_ind_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>&xls=1';
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
													<td colspan="2"><div align="center" class="Estilo15">Matr�cula de alumnos origen ind�gena de la Corporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td bgcolor="#CCCCCC" class="Estilo14 Estilo4"><span class="Estilo16">Establecimiento</span></td>
													<td width="20%" bgcolor="#CCCCCC" class="Estilo4"><div align="right" class="Estilo17">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as indi from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1 and bool_aoi = '1'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $indi = $filsMatriculados['indi'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$indi ?></b></div></td>
													   </tr>
													   <?
													   $total_indi = $total_indi + $indi;
												  }
												  ?>
												  <tr>
													<td bgcolor="#CCCCCC" class="Estilo4"><div align="right" class="Estilo17">Total</div></td>
													<td bgcolor="#CCCCCC" class="Estilo4"><div align="right" class="Estilo17"><?=$total_indi ?></div></td>
												  </tr>
												</table>
</body>
</html>
