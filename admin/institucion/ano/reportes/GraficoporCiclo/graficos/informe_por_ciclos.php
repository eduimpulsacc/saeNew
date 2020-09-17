<?php
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include ("funciones_php/FusionCharts.php");
	 $institucion	= $_INSTIT;
	 $reporte		= $c_reporte;
	 $ob_reporte = new Reporte();
	 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	/////////////////////////////////////////////////////////////////////////////
			   
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/JavaScript" src="http://code.jquery.com/jquery-1.7.2.js" ></script>

<script language="JavaScript" type="text/JavaScript" src="js/FusionCharts.js" ></script>

<script language="JavaScript" type="text/JavaScript">

function imprimir() {
      document.getElementById("capa0").style.display='none';
      window.print();
      document.getElementById("capa0").style.display='block';
      }

function cerrar(){ 
window.close() 
} 

</script>



<STYLE>
 H1.SaltoDePagina
 {
    PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>



</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<div id="capa0">
  <table width="650" align="center" >
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
	<? }?>
      </td>
    </tr>
  </table>
</div>


<table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td>
					<!-- aqui va la insignia -->
					
					<table width="125" border="0" cellpadding="0" cellspacing="0">
					<tr valign="top" >
					  <td width="125" align="center"> 	  
						<?
						if($institucion!=""){
						   echo "<img src='".$d."../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>		  </td>
					</tr>
				  </table>
					
					<!-- fin de la insignia -->	
                    </td>
					<td>&nbsp;</td>
                    
				  </tr>
                  
		</table>
        <br>

<?
	
	/*
	echo "<pre>";
	 print_r($_POST);
	echo "</pre>";
	*/
	
	
	$select_ano = explode('/',$_POST['select_ano']);
	$select_periodos = explode('/',$_POST['select_periodos']);
	$select_ciclos = explode('/',$_POST['select_ciclos']);
	
	$filtro_curso = "";
	$filtro_subsector = "";
	
	 if($_POST['select_niveles']!=0){
		 
		 $select_niveles = explode('/',$_POST['select_niveles']);
		 $filtro_curso .= " AND cu.id_nivel = ".$select_niveles[0];
		
		}
		 
	 if($_POST['select_grado']!=0){
		 
		 $select_grado = explode('/',$_POST['select_grado']);
	     $filtro_curso .= " AND cu.grado_curso = ".$select_grado[0];  
		
		}
	 
	 if($_POST['select_subsector']!=0){
		 
	    $select_subsector = explode('/',$_POST['select_subsector']);
		$filtro_subsector = '  AND ra.cod_subsector = '.$select_subsector[0];
		
		}
	
?>

<table>
<tr>
<td>Año:<td>
<td><?=$select_ano[1]?><td>
</tr>
<tr> 	
<td>Periodo:<td>
<td><?=$select_periodos[1]?><td> 	
</tr>
<tr>
<td>Ciclo:<td>
<td><?=$select_ciclos[1]?><td>
</tr>
<tr> 	
<td>Subsector:<td>
<td><?=$select_subsector[1]?><td> 	
</tr>
<tr>
<td>Nivel:<td>
<td><?=$select_niveles[1]?><td>
</tr>
<tr> 	
<td>Grado:<td>
<td><?=$select_grado[1]?><td> 	
</tr>
<table>

<br/>

<?


$sql_cursos = "SELECT 
				clo.id_curso,
				(cu.grado_curso || '-' || cu.letra_curso) as curso,
				(sum(cast(nt.promedio as integer)) / count(nt.promedio)) as prom,
				CASE 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 10 AND 39 THEN 'Inicial' 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 40 AND 49 THEN 'Suficiente' 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 50 AND 59 THEN 'Intermedio' 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 60 AND 70 THEN 'Avanzado' 
				END as clasificacion,  
				CASE 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 10 AND 39 THEN 1 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 40 AND 49 THEN 2 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 50 AND 59 THEN 3 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 60 AND 70 THEN 4 
				END as numero_clasificacion  
				FROM ciclo_conf cco
				INNER JOIN ciclos clo ON clo.id_ciclo = cco.id_ciclo
				INNER JOIN curso cu ON cu.id_curso = clo.id_curso  ".$filtro_curso." 
				INNER JOIN ramo ra ON ra.id_curso = clo.id_curso  ".$filtro_subsector."
				INNER JOIN notas2012 nt ON nt.id_ramo = ra.id_ramo AND nt.id_periodo = ".$select_periodos[0]." AND nt.promedio NOT IN ('MB','S','B','I','NULL','','0')
				WHERE 
				cco.rdb = ".$institucion." AND cco.id_ano = ".$select_ano[0]." AND cco.id_ciclo = ".$select_ciclos[0]."
				GROUP BY 1,2
				ORDER BY 5";


 $r_cursos = pg_exec($conn,$sql_cursos)  or die ( pg_last_error($conn));
 
 
$sql_resultados ="SELECT x.numero_clasificacion,x.clasificacion,count(x.*) FROM ( SELECT 
				clo.id_curso,
				(sum(cast(nt.promedio as integer)) / count(nt.promedio)) as prom,
				CASE 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 10 AND 39 THEN 'Inicial' 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 40 AND 49 THEN 'Suficiente' 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 50 AND 59 THEN 'Intermedio' 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 60 AND 70 THEN 'Avanzado' 
				END as clasificacion,  
				CASE 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 10 AND 39 THEN 1 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 40 AND 49 THEN 2 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 50 AND 59 THEN 3 
				WHEN (sum(cast(nt.promedio as integer)) / count(nt.promedio)) BETWEEN 60 AND 70 THEN 4 
				END as numero_clasificacion  
				FROM ciclo_conf cco
				INNER JOIN ciclos clo ON clo.id_ciclo = cco.id_ciclo
				INNER JOIN curso cu ON cu.id_curso = clo.id_curso ".$filtro_curso."
				INNER JOIN ramo ra ON ra.id_curso = clo.id_curso  ".$filtro_subsector."
				INNER JOIN notas2012 nt ON nt.id_ramo = ra.id_ramo AND nt.id_periodo = ".$select_periodos[0]." AND nt.promedio NOT IN ('MB','S','B','I','NULL','','0')
				WHERE 
				cco.rdb = ".$institucion." AND cco.id_ano = ".$select_ano[0]." AND cco.id_ciclo = ".$select_ciclos[0]."
				GROUP BY 1
				ORDER BY 3 ) as x GROUP by 1,2
				ORDER BY 1";         

     $r_resultados = pg_exec($conn,$sql_resultados)  or die ( pg_last_error($conn));
 
    $strXML = "";

	$strXML = "<chart caption = 'Grafico Promedios por Ciclos' bgColor='#CDDEE5' baseFontSize='12' showValues='1'   yAxisMaxValue='".@pg_num_rows($r_cursos)."' chartRightMargin='50' xAxisName='Tramos de Notas' yAxisName='N° Cursos' exportEnabled='1' exportAtClient='1' exportHandler='fcExporter1'  >";

	for( $i=0 ; $i < @pg_num_rows($r_resultados) ; $i++ ){
		
			$fila = @pg_fetch_array($r_resultados,$i); 
			
			//$link = urlencode("\"javascript:detalleAnios('".$fila['id_carrera']."','".$fila['nombre_carrera']."');\"");
			$strXML .= "<set label ='".$fila['clasificacion']."' value='".$fila['count']."' />";
	
	   }

   $strXML .= "</chart>";


	echo renderChartHTML("swf_charts/Column3D.swf","",$strXML,1000,600,false);

?>

<br/>
<br/>
 <?
      
 
 echo "<table border=1 style='border-collapse:collapse'>
 <tr>
 <th>&nbsp;Curso&nbsp;</th>
 <th>&nbsp;Prom&nbsp;</th>
 <th>&nbsp;Tramo de Promedio&nbsp;</th>
 </tr>";
 
 	for( $i=0 ; $i < @pg_num_rows($r_cursos) ; $i++ ){
		
	      $fila = @pg_fetch_array($r_cursos,$i); 
			
			echo "<tr>
			<td>&nbsp;".$fila['curso']."&nbsp;</td>
			<td>&nbsp;".$fila['prom']."&nbsp;</td>
			<td>&nbsp;".$fila['clasificacion']."&nbsp;</td>
			</tr>";
	
	     }
	  
	  
	  echo "</table>";
	  
	  ?>
      
      
<br/>      
<br/>      
      


<table>
      
      
      <tr>
      
      <td><div align="right" class="subitem"><?=$fecha=$ob_reporte->fecha_actual();?></div></td>
      
      
      </tr>
      
</table>

</body>
</html> 

