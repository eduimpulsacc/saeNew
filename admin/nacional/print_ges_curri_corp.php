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
	header("Content-Disposition:inline; filename=ges_curri_$fecha_actual.xls"); 	 
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Planificación Curricular Corporaci&oacute;n <?php echo $nombre_corp ?></title>
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
#subsectores { width: 400px;
height: 200px;
/*background-color: #366;*/
float: left;
position:relative; 
border: 1px solid #808080; 
overflow: auto; 
top:0px; 
left:0px; 

}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }

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
	window.location='print_ges_curri_corp.php?pesta=7&cmb_anog=<?php echo $cmb_anog ?>&xls=1';
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
<table width="80%" border="0" align="center" id="gestion" cellpadding="0" cellspacing="0">
								<tr  >
									<td colspan="4"><div align="center"><table width="80%" border="0" align="center" id="gestion" cellpadding="0" cellspacing="0">
								<tr class="tableindex" >
									<td colspan="4"><div align="center">Gesti&oacute;n Curricular  </div></td>
							    </tr>
								<tr class="Estilo25">
								  <td colspan="3">&nbsp;</td>
							    </tr>
								<tr class="Estilo25">
								  <td width="14%" ><div align="left"><strong>Corporaci&oacute;n</strong></div></td>
							      <td width="86%"  ><div align="left"><?php echo $nombre_corp ?></div></td>
								</tr>
								<tr class="Estilo25">
								  <td ><div align="left"><strong>A&ntilde;o</strong></div></td>
							      <td><div align="left"><?php echo $cmb_anog ?></div></td>
								</tr>
								<tr >
								  <td colspan="3">&nbsp;</td>
							    </tr>
								<tr >
								  <td colspan="4">
								  <?php
											 $qry_ins="select corp_instit.rdb, corp_instit.estado, 

institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = ".$corporacion." and corp_instit.rdb = institucion.rdb order by 

nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												 // echo "encontrados=".pg_numrows($result_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													 $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													  
													 //busco año escolar
													$sql_bus_anio="select * from ano_escolar where 

id_institucion=".$rdb." and nro_ano=".$cmb_anog;
													$res_bus_anio=@pg_Exec($conn,$sql_bus_anio);  
													for($h=0;$h<pg_numrows($res_bus_anio);$h++)
													{ 
													 $fila_anio = pg_fetch_array($res_bus_anio,$h); 
														$id_anio = $fila_anio['id_ano']; 
														//busco cursos con ese año
														
														//busco planificacion
								 
								
													   ?>
								  <table width="100%" border="1" cellpadding="3" cellspacing="0" class="Estilo2 Estilo1">
  <tr>
    <td width="13%" rowspan="2" valign="top" bgcolor="#CCCCCC"><strong>Instituci&oacute;n</strong></td>
    <td colspan="2" bgcolor="#CCCCCC"><?php echo $establecimiento?></td>
  </tr>
  
  <tr>
    <td colspan="2" valign="top"><table width="100%"  border="1" cellpadding="0" cellspacing="0" class="Estilo1" style="border:1px">
      <tr>
        <td width="69%" bgcolor="#CCCCCC"><strong>Curso</strong></td>
        <td width="10%" bgcolor="#CCCCCC"><div align="center"><strong>% Avance </strong></div></td>
        <td width="10%" bgcolor="#CCCCCC"><div align="center">Prom. Gral. </div></td>
        <td width="11%" bgcolor="#CCCCCC"><div align="center">% Logro </div></td>
      </tr>
	   <?php $sql_cur="select * from curso where id_ano=$id_anio and ensenanza>100 order by ensenanza,grado_curso,letra_curso asc";
	$res_cur=@pg_exec($conn,$sql_cur);
for($q=0;$q<pg_numrows($res_cur);$q++)
{
	$fil_curso=@pg_fetch_array($res_cur,$q);
	$id_curso=$fil_curso['id_curso'];
	$grado_curso=$fil_curso['grado_curso'];
	$letra_curso=$fil_curso['letra_curso'];
	$ensenanza=$fil_curso['ensenanza'];
	
	//tipo enseñanza
	$sql_ense="select nombre_tipo from tipo_ensenanza where cod_tipo=$ensenanza";
	$res_ense=@pg_exec($conn,$sql_ense);
	
	$cod_tipo=pg_result($res_ense,0,'"nombre_tipo"');
	
	//total filas planificacion
	 $sql_t_fil="SELECT count(*) AS total FROM plani INNER JOIN ramo ON (plani.id_ramo = ramo.id_ramo) INNER JOIN curso ON (ramo.id_curso = curso.id_curso) INNER JOIN ano_escolar ON (curso.id_ano = ano_escolar.id_ano) WHERE   (curso.id_curso = $id_curso)";
	 $res_tfil=@pg_exec($conn,$sql_t_fil);
	$total=pg_result($res_tfil,0,'"total"');
	
	//total filas cumplido
	
	$sql_t_cum="SELECT count(*) AS cumplido FROM plani INNER JOIN ramo ON (plani.id_ramo = ramo.id_ramo) INNER JOIN curso ON (ramo.id_curso = curso.id_curso) INNER JOIN ano_escolar ON (curso.id_ano = ano_escolar.id_ano) WHERE   (curso.id_curso = $id_curso) and plani.estado='Cumplido'";
	 $res_tcum=@pg_exec($conn,$sql_t_cum);
	 $cumplido=pg_result($res_tcum,0,'"cumplido"');
	 
	 $promedio=0;
	  $porc=0;
	  $porc_log=0;
	 
	 //porcentaje avance colegio
 	 $porc=($cumplido/$total)*100;
	 
	
	////////////////////notas
	 $sql_prom="SELECT sum(CAST(notas".$cmb_anog.".promedio AS integer)) AS suma, count(notas".$cmb_anog.".promedio) AS cantidad FROM   notas".$cmb_anog." INNER JOIN ramo ON (notas".$cmb_anog.".id_ramo = ramo.id_ramo) INNER JOIN curso ON (ramo.id_curso = curso.id_curso) INNER JOIN ano_escolar ON (curso.id_ano = ano_escolar.id_ano) WHERE (curso.id_curso = $id_curso) AND (notas".$cmb_anog.".promedio BETWEEN 10 AND 70)";
	$res_prom=@pg_exec($conn,$sql_prom);
	 $suma=pg_result($res_prom,0,'"suma"');
	$cantidad=pg_result($res_prom,0,'"cantidad"');
	
	 $promedio=$suma/$cantidad;
	 
	 $porc_log=($promedio/70)*100; 
	
	?>
      <tr>
        <td align="left"><?php echo $grado_curso ?> - <?php echo $letra_curso ?> <?php echo $cod_tipo ?></td>
        <td><div align="center"><?php echo number_format($porc, 2, ',', '')?></div></td>
        <td><div align="center"><?php echo number_format($promedio, 0, ',', '');?></div></td>
        <td><div align="center"><?php echo number_format($porc_log, 2, ',', '');?></div></td>
      </tr>
	  <?php }?>
	  <?php 
	  
	  $porc_ins=0;
	  $prom_ins=0;
	  $log_ins=0;
	  
	  //Totales Institución
	 $sql_tot_ins="SELECT count(*) AS total_ins FROM plani INNER JOIN ramo ON (plani.id_ramo = ramo.id_ramo) INNER JOIN public.curso ON (public.ramo.id_curso = public.curso.id_curso) INNER JOIN public.ano_escolar ON (public.curso.id_ano = public.ano_escolar.id_ano) WHERE (ano_escolar.id_ano = $id_anio)";
	  $res_tot_ins=@pg_exec($conn,$sql_tot_ins);
	$total_ins=pg_result($res_tot_ins,0,'"total_ins"');
	  
	  //cumplidos institucion
	  
	  $sql_tot_cum="SELECT count(*) AS total_cum FROM plani INNER JOIN ramo ON (plani.id_ramo = ramo.id_ramo) INNER JOIN public.curso ON (public.ramo.id_curso = public.curso.id_curso) INNER JOIN public.ano_escolar ON (public.curso.id_ano = public.ano_escolar.id_ano) WHERE (ano_escolar.id_ano = $id_anio) and plani.estado='Cumplido'";
	  $res_tot_cum=@pg_exec($conn,$sql_tot_cum);
	 $total_cum=pg_result($res_tot_cum,0,'"total_cum"');
	 
	 
	 //porcentaje avance insitucion
 	 $porc_ins=($total_cum/$total_ins)*100;
	 
	 ///////////////promedio institución
	$sql_prom_ins="SELECT sum(CAST(notas".$cmb_anog.".promedio AS integer)) AS suma_ins, count( notas".$cmb_anog.".promedio) AS cantidad_ins FROM notas".$cmb_anog." INNER JOIN ramo ON (notas".$cmb_anog.".id_ramo = ramo.id_ramo) INNER JOIN curso ON (ramo.id_curso = curso.id_curso)INNER JOIN ano_escolar ON (curso.id_ano = ano_escolar.id_ano) WHERE (ano_escolar.id_ano = $id_anio) AND  (notas".$cmb_anog.".promedio BETWEEN 10 AND 70)";
	$res_prom_ins=@pg_exec($conn,$sql_prom_ins);
	 $suma_ins=pg_result($res_prom_ins,0,'"suma_ins"');
	$cantidad_ins=pg_result($res_prom_ins,0,'"cantidad_ins"');
	
	 $prom_ins=$suma_ins/$cantidad_ins;
	 
	 $log_ins=($prom_ins/70)*100;
	
	 
	  ?>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="4"><table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="89%" class="Estilo25"><div align="right"><strong>% Avance Instituci&oacute;n </strong></div></td>
            <td width="11%" bgcolor="#CCCCCC" class="Estilo25"><div align="center"><?php echo number_format($porc_ins, 2, ',', '');?></div></td>
          </tr>
          <tr>
            <td class="Estilo25"><div align="right"><strong>Promedio General Instituci&oacute;n </strong></div></td>
            <td bgcolor="#CCCCCC" class="Estilo25"><div align="center"><?php echo number_format($prom_ins, 2, ',', '');?></div></td>
          </tr>
          <tr>
            <td class="Estilo25"><div align="right"><strong>%Logro Instituci&oacute;n </strong></div></td>
            <td bgcolor="#CCCCCC" class="Estilo25"><div align="center"><?php echo number_format($log_ins, 2, ',', '');?></div></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="4">&nbsp;</td>
      </tr>
	 
    </table>	</td>
  </tr>
  <tr>
    <td colspan="5">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td colspan="5" valign="top"><hr /></td>
  </tr><?php }}?>
  <tr>
    <td colspan="5" valign="top"><div align="center"><a href="print_ges_curri_corp.php?pesta=7&cmb_anog=<?php echo $cmb_anog ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></div></td>
  </tr>
</table></td>
							    </tr>
							</table>
									</div></td>
							    </tr>
<tr class="Estilo25">
  <td colspan="3">&nbsp;</td>
							    </tr><tr >
								    <td colspan="4">
								      
								  </body>
</html>
