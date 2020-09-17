<?php
if($_PERFIL==0){
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
}

?>

<?
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');
//	show($_POST);
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$ramo		    =$c_ramo;
	$reporte		=$c_reporte;
	$periodo		=$cmb_periodos;
	$retirado 		=$chk_ret;
	//$xls="";
	//$chk_apo="";
	
	//show($_POST);
		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
		/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	$iniano = $ob_membrete->fecha_inicio;
	$finano = $ob_membrete->fecha_termino;
	
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->Periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	//if($_PERFIL==0){echo "1-".$dias_habiles;}
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	
	$ob_reporte ->ano = $ano; 
	$ob_reporte ->nro_ano=$nro_ano;
	
	
	$ob_reporte ->ramo=$ramo;
	$rs_ramo = $ob_reporte ->ramoUNO($conn);
	
	
	
	

	
	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************** CURSO ***********************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	 $ob_config->id_item=$c_reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	//show($fila_config);
	
	$ob_reporte ->ano = $ano;
	$ob_reporte ->curso = $curso;
	$ob_reporte->bool_ar=$retirado;
	$ob_reporte->institucion=$institucion;
	$result_alu =$ob_reporte ->AlumnosTieneop($conn);
	
	//grupos de nota
	//$rs_grupo = $ob_reporte ->TraeGrupoNota($conn);
	$ob_reporte ->periodo = $periodo;
	$rs_grupo=$ob_reporte->TraeGrupoNotaPer($conn);
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>INFORME DE NOTAS PARCIALES</title>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
  H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always;
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
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}



</script>
</head>

<body>
<div id="capa0">
	<TABLE width="100%"><TR><TD>
	<table>
    <tr>
	  <td align="left"><input name="button4" type="button" class="botonXX" onClick="window.close()"   value="CERRAR">	  </td>
	</tr>
  </table>
  </TD><TD>
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	
          <!--INPUT name="button" TYPE="button" class="botonX" onClick=document.location="curso.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"-->
  		</div></TD>
		
  <TD>&nbsp;</TD>
	</TR></TABLE>
</div>

<?
	
	
		
	
	$cont_alumnos = @pg_numrows($result_alu);

	
	
	
	?>

    <?

	
	
	
	
	
	
if($ramo!=0 && $curso!=0){	
?>

<table width="950" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
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
			
				  if($institucion!=""){
					
					  
					  echo "<img src='../../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
					 // echo "<img src='"."http://".$_SERVER['HTTP_HOST']."/sae3.0/tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."menu/imag/logo.gif' >";
				  }?></td>
        <? } ?>
      </tr>
      <tr>
        <td class="item"><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
        <td class="item"><strong>:</strong></td>
        <td class="item"><div align="left"><? echo trim($nro_ano) ?></div></td>
      </tr>
      <tr>
        <td class="item"><div align="left"><strong>CURSO</strong></div></td>
        <td class="item"><strong>:</strong></td>
        <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
      </tr>
     
  <tr>
        <td class="item"><div align="left"><strong>PROFESOR(A) JEFE</strong></div></td>
        <td class="item"><div align="left"><strong>:</strong></div></td>
        <td class="item"><div align="left">
          <?
				    if($institucion==14490){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
					}				
					?>
        </div></td>
      </tr>
    </table><br />
<br />

<table width="950" border="0" align="center">
  <tr>
    <td class="tableindex"><div align="center"><strong>INFORME DE NOTAS PARCIALES POR GRUPO<br />
ASIGNATURA: <?php echo pg_result($rs_ramo,1) ?><br /><br /><?php echo $periodo_pal ?></strong></div></td>
  </tr>
</table><br />
<br />
<table width="950" border="1" align="center" style="border-collapse:collapse">
<tr class="tableindex">
  <td rowspan="2" align="center" width="300">Alumno</td>
  <?php for($g=0;$g<pg_numrows($rs_grupo);$g++){
	  $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   $suesp=0;
	  
	   $cuentacols=0;
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   
	   $nombre = (pg_numrows($rs_grupo)<=3)?$fila_grupo['nombre']:"Grupo ".($g+1);
  
  		$pg = (pg_numrows($rs_grupo)<=3)?"(".$fila_grupo['porcentaje']."%)":"";
	   
	   
	   $cuentacols = ($fila_grupo['nota1']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota2']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota3']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota4']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota5']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota6']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota7']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota8']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota9']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota10']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota11']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota12']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota13']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota14']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota15']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota16']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota17']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota18']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota19']==1)?$cuentacols+1:$cuentacols;
	  // $cuentacols = ($fila_grupo['nota20']==1)?$cuentacols+1:$cuentacols;
	   
	   
	 $suesp=$suesp+$cuentacols;
	 $rpos = 19- $suesp;
	  
	  
	  ?>
  <td align="center" colspan="<? echo $cuentacols +2; ?>"><?php echo $nombre ?> <?php echo $pg ?>  </td>
  
  <?php }?>
  <td rowspan="2" align="center">Prom.<br />
    Asig.</td>
   
     
  </tr>
<tr class="tableindex">
<?php for($g=0;$g<pg_numrows($rs_grupo);$g++){
	  $fila_grupo = pg_fetch_array($rs_grupo,$g);
	 // echo $ob_reporte->grupo=$fila_grupo['id_grupo'];
	  //$rsgp = $ob_reporte->TraeGrupoNota($conn);
	  $cuentacols=0;
	   
	   $fila_grupo = pg_fetch_array($rs_grupo,$g);
	   
	   $cuentacols = ($fila_grupo['nota1']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota2']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota3']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota4']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota5']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota6']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota7']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota8']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota9']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota10']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota11']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota12']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota13']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota14']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota15']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota16']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota17']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota18']==1)?$cuentacols+1:$cuentacols;
	   $cuentacols = ($fila_grupo['nota19']==1)?$cuentacols+1:$cuentacols;
	  // $cuentacols = ($fila_grupo['nota20']==1)?$cuentacols+1:$cuentacols;
	  
	   
	   
	 $suesp=$suesp+$cuentacols;
	 $rpos = 19- $suesp;
	  	  ?>
  <td align="center" colspan="<? echo $cuentacols;  ?>">Notas</td>
  <td align="center">P.G.</td>
   <td  align="center">%</td>
  <?php  }?>
</tr>
<?php for($a=0;$a<$cont_alumnos;$a++){
	$fila_alumno = pg_fetch_array($result_alu,$a);
	$ob_reporte->alumno=$fila_alumno['rut_alumno']
	?>
<tr class="textosimple">
  <td><?php echo $fila_alumno['nombres']?></td>
 <?php for($g=0;$g<pg_numrows($rs_grupo);$g++){
	  $fila_grupo = pg_fetch_array($rs_grupo,$g);
	  
	  $fondo= ($g%2==0)?"#E2E2E2":"#FFE6E6";
	  $pgrupo=0;
	 
  for($nog=1;$nog<=19;$nog++){
	   $ob_reporte->posicion=$nog;
	   $ob_reporte ->periodo=$periodo;
	   if($fila_grupo['nota'.$nog]==1){
	   $rs_pos = $ob_reporte->TraeNotaG($conn);
	   
	   if(pg_result($rs_pos,0)!='0'){
	   $promg[$fila_alumno['rut_alumno']][$fila_grupo['id_grupo']][]=pg_result($rs_pos,0);
	   
	   }
	 
	 if(count($promg[$fila_alumno['rut_alumno']][$fila_grupo['id_grupo']])>0){
	    $pgrupo = (pg_result($rs_ramo,4)==1)?round(array_sum($promg[$fila_alumno['rut_alumno']][$fila_grupo['id_grupo']])/count($promg[$fila_alumno['rut_alumno']][$fila_grupo['id_grupo']])):intval(array_sum($promg[$fila_alumno['rut_alumno']][$fila_grupo['id_grupo']])/count($promg[$fila_alumno['rut_alumno']][$fila_grupo['id_grupo']]));
	   
	 }
	   ?>
      <td width="17"  align="center" valign="middle"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo (pg_result($rs_pos,0)<40 && pg_result($rs_pos,0)>0)?"#FF0000":"#000000" ?>" ><?php echo (pg_result($rs_pos,0)!='0')?pg_result($rs_pos,0):""; ?>&nbsp;</font></td>
     <?php  }
	  }?>
  <td align="center"><font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo ($pgrupo<40 && $pgrupo>0)?"#FF0000":"#000000" ?>vv" ><?php echo ($pgrupo!='0')?$pgrupo:""; ?></font></td>
   <td  align="center" bgcolor="#CCCCCC"><font size="1" face="Arial, Helvetica, sans-serif" color="#000000" >
   <?php $par_pro= ($pgrupo!='0')?($pgrupo/10)*($fila_grupo['porcentaje']/100):"";
  // echo number_format($par_pro,2,  ',', ' ');
    echo substr($par_pro,0,4);
  // echo $par_pro,2;
    ?></font></td>
  <?php }?>
  <td align="center"><?php 
  $prom = $ob_reporte ->PromedioAlumnoG($conn);
  $rprp = pg_result($prom,0);
   ?>
   <font size="1" face="Arial, Helvetica, sans-serif" color="<?php echo ($rprp<40 && $rprp>0)?"#FF0000":"#000000" ?>" ><?php echo ($rprp!=0)?$rprp:""; ?></font></td>
  </tr>
<?php }?>
</table>
<?php if(pg_numrows($rs_grupo)>3){?>
<br />
<br />
<table width="950" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td width="78">Grupo</td>
    <td width="443">Descipci&oacute;n</td>
    <td width="421">Porcentaje</td>
  </tr>
  

 <?php for($g=0;$g<pg_numrows($rs_grupo);$g++){
	  $fila_grupo = pg_fetch_array($rs_grupo,$g);
	  ?>
	  <tr class="textosimple">
    <td><?php echo $g+1 ?></td>
    <td><?php echo $fila_grupo['nombre'] ?></td>
    <td><?php echo $fila_grupo['porcentaje'] ?>%</td>
  </tr>

<?php  }?>
</table><br />
<br />

<?php }?>
<?php }?>
<?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 include("../../firmas/firmas.php");?>
</body>
</html>