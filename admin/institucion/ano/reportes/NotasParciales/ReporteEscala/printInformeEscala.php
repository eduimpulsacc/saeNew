<?
	require('../../../../../../util/header.inc');
	include('../../../../../clases/class_Reporte.php');
	include('../../../../../clases/class_Membrete.php');
	
	/*if($_PERFIL==0){
		echo "<pre>";
		print_r($_GET);
		echo "<pre>";
		}*/

	

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno		    =$c_alumno;
	$reporte		=$c_reporte;
	$periodo		=$cmbPeriodo;
	$taller			=$opc_Taller;
	$estadistica	=$opc_estadistica;
	$obs			=$opc_obs;
	$tipo_rep		=$tipo_rep;
	$anotacion		=$opc_Anotacion;
	$colilla		=$opc_Colilla;
	$muestra_notas	=$Mnotas;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;
	
	/****************DATOS PERIODO************/
	$ob_reporte ->ano=$ano;
	$ob_reporte ->nro_ano=$nro_ano;
	$ob_reporte ->periodo=$periodo;
	$ob_reporte ->Periodo($conn);
	$periodo_pal = $ob_reporte->nombre_periodo . " DEL " . $nro_ano;
	$result1 = $ob_reporte->result;
	$dias_habiles = $ob_reporte->dias_habiles;
	$fecha_ini = $ob_reporte->fecha_inicio;
	$fecha_fin = $ob_reporte->fecha_termino;
	
	
	
	

	
	/************** CURSO ***********************/
	//$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
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

		$fecha = strftime("%d %m %Y");		
}				  

//tipo ensenanza
$ob_reporte->institucion=$institucion;
$ob_reporte->tipo_ense= $cmbEnse;
$rs_ense = $ob_reporte->Ensenanza($conn);

//escala 
$ob_reporte->concepto=$cmbEscala;
$rs_conc = $ob_reporte->conceptoEscala($conn);

$nota_min = pg_result($rs_conc,5);
$nota_max = pg_result($rs_conc,6);

//ramos ensenanza
$rs_ramo = $ob_reporte->ramoTipoEnse($conn);

//grados
$rs_grado =$ob_reporte->gradoTipoEnseEscala($conn);

$ens=($cmbEnse==110)?"B&Aacute;S.":"MEDIO";


//parte 1 no

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
<meta http-equiv="Content-Type" content="text/html; charset=iso8859-1" />
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>INFORME DE NOTAS PARCIALES</title>
<STYLE>
body{
font-family:Verdana, Arial, Helvetica, sans-serif;
}
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 .titulo
 {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:Verdana, Arial, Helvetica, sans-serif;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
 .nota
 {font-size:11px;}
 
 .rojo
 {color:red;}
 
  .azul
 {color:black;}
 
 .t
 {font-weight:bold;}

</style>
</head>
<!---->
<body >
<div id="capa0" align="center">
*Este reporte debe imprimirse en hoja tama&ntilde;o oficio y de manera horizontal
<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>
</div>
<br />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
        <tr>
          <td width="487" class="item"><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></td>
          <td width="11" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
		<?
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
	
			  if($institucion!=""){
				   echo "<img src='../../../../../".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='../../../../../".$d."menu/imag/logo.gif' >";
			  }
		?>	  		</td>
		 </tr>
     </table></td>
          
        </tr>
        <tr>
          <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
        </tr>
        <tr>
          <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
        </tr>
        <tr>
          <td height="41">&nbsp;</td>
        </tr>  
  </table>
<br>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td class="tableindex"><div align="center">INFORME DE NOTAS POR RANGO DE ESCALA</div></td>
   </tr>
    <tr>
      <td ></td>
   </tr>
</table>
<br />
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="17%" class="textonegrita">Tipo de Ense&ntilde;anza</td>
      <td width="83%" class="textosimple"><?php echo pg_result($rs_ense,1);?></td>
      </tr>
    <tr>
      <td class="textonegrita">Periodo</td>
      <td class="textosimple"><?php echo $periodo_pal ?></td>
    </tr>
    <tr>
      <td colspan="2" ></td>
      </tr>
</table><br />
<br />
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
  <tr class="tableindex">
    <td class="textonegrita"><strong>NIVEL</strong></td>
   <?php   for($g=0;$g<pg_numrows($rs_grado);$g++){ 
   $fila_grado = pg_fetch_array($rs_grado,$g);
   
  
   
   ?>
    <td colspan="2" align="center" class="textosimple"><strong><?php echo $fila_grado['grado_curso']."&ordm; ".$ens ?>&nbsp;</strong></td>
    <?php }?>
  </tr>
   
  <tr>
    <td bgcolor="#CCCCCC" class="textonegrita"><strong>MATRICULA</strong></td>
	<?php   for($g=0;$g<pg_numrows($rs_grado);$g++){ 
   $fila_grado = pg_fetch_array($rs_grado,$g);
    $ob_reporte->grado = $fila_grado['grado_curso'];
   
   $rs_cuenta = $ob_reporte->cuentaAlumnogrado($conn);
   $conteomat = pg_result($rs_cuenta,0);
   
   ?>
    <td colspan="2" align="center" bgcolor="#CCCCCC" class="textosimple"><strong><?php echo $conteomat; ?></strong></td>
	<?php }?>
  </tr>
  
  <tr>
    <td bgcolor="#CCCCCC" class="textonegrita"><strong><?php echo pg_result($rs_conc,3) ?> / PORCENTAJE</strong></td>
    <?php   for($g=0;$g<pg_numrows($rs_grado);$g++){ 
   $fila_grado = pg_fetch_array($rs_grado,$g);
   ?>
    <td width="50" align="center" bgcolor="#CCCCCC" class="textosimple"><strong>CANT.</strong></td>
    <td width="50" align="center" bgcolor="#CCCCCC" class="textosimple"><strong>%</strong></td>
    <?php }?>
  </tr>
  <tr>
    <td class="textonegrita">ASIGNATURAS</td>
    <?php   for($g=0;$g<pg_numrows($rs_grado);$g++){ 
   $fila_grado = pg_fetch_array($rs_grado,$g);
   
  
   
   ?>
    <td colspan="2" align="center">&nbsp;</td>
    <?php }?>
  </tr>
  <?php for($r=0;$r<pg_numrows($rs_ramo);$r++){
	  $fila_sub = pg_fetch_array($rs_ramo,$r);
	  $color=($r%2==0)?"#f3f3f3":"";
	  ?>
  <tr bgcolor="<?php echo $color ?>">
    <td class="textonegrita"><?php echo $fila_sub['nombre'] ?>&nbsp;</td>
    <?php   for($g=0;$g<pg_numrows($rs_grado);$g++){ 
	
	
     $fila_grado = pg_fetch_array($rs_grado,$g);
    $ob_reporte->grado = $fila_grado['grado_curso'];
	$ob_reporte->cod_subsector=$fila_sub['cod_subsector'];
	$ob_reporte->notamin=$nota_min;
	$ob_reporte->notamax=$nota_max;
	
		
   ?>
    <td align="center" class="textosimple">
    <?php
	$ob_reporte->notaRamoGrado($conn);
	 echo $ob_reporte->cuentanot; 
	$rs_cuenta = $ob_reporte->cuentaAlumnogrado($conn);
   $conteomat2 = pg_result($rs_cuenta,0);
	 ?>
   </td>
    <td align="center" class="textosimple"><?php echo number_format(($ob_reporte->cuentanot*100)/ $conteomat2,1,',','.'); ?>&nbsp;</td>
    <?php }?>
  </tr>
  <?php }?>
</table>

</body>
</html>
