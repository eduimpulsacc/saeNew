<?
	require('../../../../util/header.inc');
	include('../../../clases/class_Reporte.php');
	include('../../../clases/class_Membrete.php');
	
	/*if($_PERFIL==0){
		echo "<pre>";
		print_r($_GET);
		echo "<pre>";
		}*/

	

	$institucion	=$_INSTIT;
	$ano			=$anodesde;
	
	$reporte		=$c_reporte;

	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	$desde =  $ob_membrete->fecha_inicio;
	$hasta =  $ob_membrete->fecha_termino;
		

	$ob_reporte ->ano = $ano;
	
	
	//$fecha = $ob_membrete->nro_ano;
	

	

	
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	//$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if($institucion == 770){		

		$sqlInstit="select * from institucion where rdb=".$institucion;
		$resultInstit=@pg_Exec($conn, $sqlInstit);
		$filaInstit=@pg_fetch_array($resultInstit);
		
		$sql_reg="select nom_reg from region where cod_reg =". $filaInstit['region'];
		$res_reg = pg_exec($conn, $sql_reg);
		$fila_reg = pg_fetch_array($res_reg);
		
		$sql_pro="select nom_pro from provincia where cod_reg=".$filaInstit['region']." and cor_pro =".$filaInstit['ciudad'];
		$res_pro=pg_exec($conn, $sql_pro);
		$fila_pro = pg_fetch_array($res_pro);
		
		$sql_com="select nom_com from comuna where cod_reg=". $filaInstit['region'] ." and cor_pro =".$filaInstit['ciudad']." and cor_com=".$filaInstit['comuna'];
		$res_com=pg_exec($conn, $sql_com);
		$fila_com = pg_fetch_array($res_com);	 

		//$fecha = strftime("%d %m %Y");		
}				  


 
				  

	/*if($cb_ok!="Buscar"){
		$xls=1;
	}*/
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=AsistenciaInstitucion_$fecha_actual.xls"); 	 
	}


?>
<script language="javascript" type="text/javascript">
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
//-->

function cerrar(){ 
	window.close() 
} 

function exportar(){
			//form.target="_blank";
			window.location='printinformeAsistenciaInstitucion.php?anodesde=<?php echo $ano ?>&xls=1';
			document.form.submit(true);
		return false;
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin-9" />
<?php if($xls!=1){?>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<?php }?>
<title>INFORME DE NOTAS PARCIALES</title>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
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
<!--onLoad="window.print()"-->
<body >
<div id="capa0">
<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>
</div>

<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="114" class="item"><div align="left"><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class="item"><strong>:</strong></td>
    <td width="361" class="item"><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="161" rowspan="7" align="center" valign="top" ><?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
			
					if($xls!=1){
					$ruta="http://".$_SERVER['HTTP_HOST']."sae3.0/";	
					
					
				  if($institucion!=""){
					   echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?>    </td>
    <? } 
	
	}
	
	?>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td class="item">
  </td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
  </tr>
  <tr>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
  </tr>
  <tr>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
    <td class="item">&nbsp;</td>
  </tr>
  
</table>
<br />
	<?php 
	
	 /*echo $qrya = "select matricula.rut_alumno,
alumno.dig_rut, 
 upper(alumno.ape_pat) as ape_pat,
  upper(alumno.ape_mat) as ape_mat, 
  upper(alumno.nombre_alu) as nombres, 
  matricula.id_curso,
   matricula.bool_ar,
   matricula.fecha
   FROM MATRICULA, ALUMNO 
   where id_ano =$ano 
   and matricula.rut_alumno = alumno.rut_alumno 
   and matricula.bool_ar=0
   and matricula.id_curso>0
   order by  matricula.id_curso asc,alumno.ape_pat asc,
  alumno.ape_mat asc, 
  alumno.nombre_alu";*/
  $qrya="
select matricula.rut_alumno, alumno.dig_rut, upper(alumno.ape_pat) as ape_pat, 
upper(alumno.ape_mat) as ape_mat, upper(alumno.nombre_alu) as nombres, 
matricula.id_curso, matricula.bool_ar, matricula.fecha 
FROM MATRICULA INNER JOIN ALUMNO ON matricula.rut_alumno=alumno.rut_alumno
INNER JOIN curso ON curso.id_curso=matricula.id_curso
where matricula.id_ano =$ano and matricula.rut_alumno = alumno.rut_alumno and matricula.bool_ar=0 
and matricula.id_curso>0 
order by curso.ensenanza, grado_curso, letra_curso,alumno.ape_pat, 
alumno.ape_mat, alumno.nombre_alu ASC";
  
  $rsa=pg_exec($conn,$qrya);
  

?>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td width="158" align="center">Curso</td>
    <td width="77" align="center">RUT</td>
    <td width="215" align="center">ALUMNO</td>
    <td width="97" align="center">DIAS INASISTIDOS</td>
    <td width="91" align="center">% ASISTENCIA</td>
  </tr>
<?php   if(pg_numrows($rsa)>0){
	for($i=0;$i<pg_numrows($rsa);$i++){
	$fer=0;
	$dias_t=0;
	$fila= pg_fetch_array($rsa,$i);	
	$porc=0;
	
	$ob_reporte->alumno=$fila['rut_alumno'];
	
	//fechas
	if($fila['fecha'] > $desde){
		 $f_desde= $fila['fecha']; 
	}
	else{
		$f_desde= $desde; 
	}
	
	/*if(date("Y-m-d") < $hasta){
		$f_hasta = date("Y-m-d");
	}
	else{
		$f_hasta = $hasta;
	}	*/	
	
	$f_hasta = $hasta;
	
	//dias habiles rango
	$cant_habiles = hbl($f_desde,$f_hasta);
	//feriados calendario
	$ob_reporte->fecha_ini2=$f_desde;	
	$ob_reporte->fecha2=$f_hasta;		
	$rs_feriado2=$ob_reporte->DiaHabil2($conn);
	if(pg_numrows($rs_feriado2)>0){
	for($f=0;$f<pg_numrows($rs_feriado2);$f++){
			$filaf=pg_fetch_array($rs_feriado2,$f);
			$fecha_inif = date($filaf['fecha_inicio']);
			$fecha_finf = date($filaf['fecha_fin']);
			
			//si un feriado cae sabado o domingo
			$ferf = ihbl($fecha_inif,$fecha_finf);
			
			$fer=$fer+(ddiff($fecha_inif,$fecha_finf)-$ferf); 
			
		}
}
$cant_feriados=intval($fer);


//dias inasistencias
$ob_reporte ->fecha_inicio=$f_desde;
$ob_reporte ->fecha_termino=$f_hasta;
$result_asis = $ob_reporte ->Asistencia($conn);
$cuenta_inasis = @pg_numrows($result_asis);

$diast=$cant_habiles-$cant_feriados;

$total_asis= $diast-$cuenta_inasis;


	?>
  <tr class="textosimple">
    <td>
	<?
				  $Curso_pal = CursoPalabra($fila["id_curso"], 0, $conn);
				  if (empty($Curso_pal))
				  	$Curso_pal = "Sin Curso";
   			  	  $Curso_pal = trim(ucwords($Curso_pal));
				  echo $Curso_pal;
				  
				  ?></td>
    <td align="center"><?php echo $fila['rut_alumno'] ?>-<?php echo $fila['dig_rut'] ?></td>
    <td><?php echo $fila['ape_pat'] ?> <?php echo $fila['ape_mat'] ?>, <?php echo $fila['nombres'] ?></td>
    <td align="center">
      <?php echo  $cuenta_inasis ?>
    </td>
    <td align="center">
   <?php  if($cuenta_inasis==0){
    $porc=100;
    }
    else{
    $porc = $porc = ($total_asis*100)/$diast;
    }
    echo round($porc,1);?>
    </td>
  </tr>
  <?php 
	}
   } ?>
</table>

</body>
</html>
