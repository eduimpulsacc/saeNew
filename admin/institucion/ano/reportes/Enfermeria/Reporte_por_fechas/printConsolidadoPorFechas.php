<?php
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');


	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$reporte		=$c_reporte;
	$fecha_ini=$fecha_ini;
	$fecha_fin = $fecha_fin;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	//$ob_config->curso=$curso;
	$rs_config = $ob_config->BuscaReporte($conn);
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

		$fecha = strftime("%d %m %Y");		
}				  




				  

	if($cb_ok!="Buscar"){
		$xls=1;
	}
		 
	if($xls==1){	 
	$fecha_actual = date('d/m/Y-H:i:s');
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Parciales_alumno_$fecha_actual.xls"); 	 
	}

$ob_reporte->ano=$ano;

$ob_reporte->fecha_inicio = CambioFE($f_incio);
$ob_reporte->fecha_termino = CambioFE($f_fin);

$rs_atenciones=$ob_reporte->countEnfermeriaFecha($conn);
$cont_atencion = pg_numrows($rs_atenciones);
 
 //$rs_datopatologia = $ob_reporte->Patologia($conn);

?>
<?
	$sql_institu = "SELECT institucion.rdb, institucion.dig_rdb, institucion.nombre_instit, institucion.calle, institucion.nro, institucion.telefono, region.nom_reg, provincia.nom_pro, comuna.nom_com ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (region.cod_reg = provincia.cod_reg)) INNER JOIN comuna ON (provincia.cod_reg = comuna.cod_reg) AND (provincia.cor_pro = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$rdb = $fila_institu['rdb'] . "-" . $fila_institu['dig_rdb'];
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro']));
	$telefono = $fila_institu['telefono'];
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	$ciudad = ucwords(strtolower($fila_institu['nom_pro']));
	$region = ucwords(strtolower($fila_institu['nom_reg']));
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
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin-9" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE ATENCIONES ENFERMERIA (POR PATOLOGIA)</title>
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
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;

 }
 .subitem
 {
 font-family:Arial, Helvetica, sans-serif;
 font-size:11px;
 }
.textoverital{writing-mode: tb-rl;filter: flipv fliph;}

.rojo{color:red;}
.azul{color:black;}
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
<?php if($cont_atencion>0){?>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
	  <tr>
		<td width="487"><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($nombre_institu));?></strong></font></td>
		<td width="11">&nbsp;</td>
		<td width="152" rowspan="4" align="center">
				<?	
					$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto = @pg_fetch_array($result,0);
					## código para tomar la insignia
				
					if($institucion!=""){
						echo "<img src='../../../../../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
					}else{
						echo "<img src='../../../../../../".$d."menu/imag/logo.gif' >";
					}
				?>
		</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($direccion));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($telefono));?></font></td>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td height="41">&nbsp;</td>
		<td>&nbsp;</td>
	  </tr>
	</table>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td class="tableindex"><div align="center">ESTAD&Iacute;STICA DE ATENCIONES DESDE <?php echo $f_incio ?> HASTA <?php echo $f_fin ?></div></td>
    </tr>
  <tr>
    <td c>&nbsp;</td>
  </tr>
  
</table><br />
<table width="650" border="0" align="center">
  <tr>
    <td width="192" class="textonegrita">TOTAL DE ATENCIONES</td>
    <td width="3" align="center"><strong>:</strong></td>
    <td width="448" class="textosimple">&nbsp;<?php echo $cont_atencion ?></td>
  </tr>
  <tr>
    <td colspan="3" class="textonegrita">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" class="textonegrita">TOTAL ATENCIONES POR PATOLOG&Iacute;A</td>
  </tr>
  <tr>
    <td colspan="3" class="textonegrita" >

    <table width="100%" border="0" class="textosimple">
        <tr>
          <td width="8%"><b>
            <?php  $ob_reporte->countEnfermeriaConDestino($conn); echo number_format($ob_reporte->cont_accidente,0,',','.'); ?>
          </b></td>
          <td width="92%">Accidentes en total derivados a atenci&oacute;n m&eacute;dica</td>
        </tr>
         <?php $rs_cont_porpato = $ob_reporte->countEnfermeriaPorPatologiaTODOS($conn);
        for($ppt=0;$ppt<pg_numrows($rs_cont_porpato);$ppt++){
			$fila_ppt = pg_fetch_array($rs_cont_porpato,$ppt);
			?>
        <tr>
          <td><b>
            <?php echo  number_format($fila_ppt['conteo'],0,',','.'); ?>
          </b></td>
          <td><?php echo  strtoupper($fila_ppt['nombre']); ?></td>
        </tr>
        <?php }?>
    </table></td>
  </tr>
  <tr>
    <td colspan="3" >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"  class="textonegrita">TOTAL ATENCIONES POR TIPO  DE ENSE&Ntilde;ANZA</td>
  </tr>
  <tr>
    <td colspan="3" valign="top">
    <?php 
	$ob_reporte->institucion= $institucion;
	$rs_ense = $ob_reporte->Ensenanza($conn);
	?>
    
      <table width="100%" border="0">
    <?php   for($en=0;$en<pg_numrows($rs_ense);$en++){
		$fila_ense = pg_fetch_array($rs_ense,$en);
		$ob_reporte->ensenanza = $fila_ense['cod_tipo'];
		$contense = $ob_reporte->conteoEnfermeriaEnsenanza($conn);
		$contpatoense = pg_result($contense,0);
		
		?>
  <tr>
    <td width="8%" class="textonegrita"><b><?php echo  number_format($contpatoense,0,',','.'); ?></b></td>
    <td  class="textosimple"><?php echo $fila_ense['nombre_tipo'] ?></td>
  </tr>
 <?php }?>
</table></td>
  </tr>
</table>

<br />
<br />
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		// $concur=($curso>0)?1:0;
		 include("../../firmas/firmas.php");?>
<?php }?>
</body>
</html>
