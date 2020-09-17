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
	$curso			=1;
	
	$reporte		=$c_reporte;
	$periodo		=$cmb_periodos;
	
	$subsector  	=$cmb_ramo;
	
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
	
	
	
	//empleadfo
	$ob_reporte ->rut_emp= $cmb_docente;
	$ob_reporte ->Profesor($conn);
	 
	
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

<table width="650" align="center">
  <tr>
    <td width="188"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR" /></td>
    <td width="367" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" /></td>
    <td width="79" align="right"><input name="cb_exp" type="button" onClick="exportar(this.form)" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>
</div>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
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
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td class="tableindex"><div align="center">CANTIDAD DE NOTAS POR DOCENTE</div></td>
   </tr>
    <tr>
      <td ></td>
   </tr>
</table>
<br />
 <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="17%" class="textonegrita">Docente</td>
      <td width="83%" class="textosimple"><?php echo $ob_reporte ->profesor; ?></td>
      </tr>
    <tr>
      <td class="textonegrita">Periodo</td>
      <td class="textosimple"><?php echo $periodo_pal ?></td>
    </tr>
  <?php  if( $subsector!=0){
	$ob_reporte->subsector=$subsector;
	 $ns= $ob_reporte->Subs1($conn);
	  ?>
    <tr>
      <td class="textonegrita">Asignatura</td>
      <td class="textosimple"><?php echo pg_result($ns,1) ?></td>
    </tr>
    <?php }?>
    <tr>
      <td colspan="2" ></td>
      </tr>
</table>
 <br />
 <?php if($subsector==0){
	 $rs_subs = $ob_reporte->subsDocente($conn);
	 for($s=0;$s<pg_numrows($rs_subs);$s++){
		 $fila = pg_fetch_array($rs_subs,$s);
		  $ob_reporte->subsector=$fila['cod_subsector'];
		 $rs_cu = $ob_reporte->currRamo($conn);
		 
	 ?>
 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
   <tr class="tableindex">
     <td width="546">ASIGNATURA: <?php echo $fila['nombre'] ?></td>
     <td width="98" align="center">NOTAS</td>
   </tr>
  
   <?php for($c=0;$c<pg_numrows($rs_cu);$c++){
	   $fc = pg_fetch_array($rs_cu,$c);
	   $cuentanotas=0;
	   
	   
	   for($n=1;$n<=20;$n++){
		 $ob_reporte->posicion=$n;
	   $ob_reporte->id_ramo=$fc['id_ramo'];
	   $nn = $ob_reporte->cuentaNotaPos($conn);
	   if(pg_numrows($nn)>0){$cuentanotas++;}
		   
		}
	   
	   ?>
   <tr class="textosimple">
     <td><?php echo CursoPalabra($fc['id_curso'],0,$conn); ?></td>
     <td align="center"><?php echo $cuentanotas ?></td>
   </tr>
   <?php }?>
 </table><br />

 <?php }?>
 <?php }else{
	 $rs_subs = $ob_reporte->currRamo($conn);
	
	 
	 ?>
 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
   
   <tr class="tableindex">
     <td width="547">Curso</td>
     <td width="97" align="center">NOTAS</td>
   </tr>
    <?php for($s=0;$s<pg_numrows($rs_subs);$s++){
		 $fila = pg_fetch_array($rs_subs,$s);
		 $cuentanotas=0;
	   
	   
	   for($n=1;$n<=20;$n++){
		 $ob_reporte->posicion=$n;
	   $ob_reporte->id_ramo=$fila['id_ramo'];
	   $nn = $ob_reporte->cuentaNotaPos($conn);
	   if(pg_numrows($nn)>0){$cuentanotas++;}
		   
		}
		 
		 ?>
   <tr class="textosimple">
     <td><?php echo CursoPalabra($fila['id_curso'],0,$conn); ?></td>
     <td align="center" valign="middle"><?php echo $cuentanotas ?></td>
   </tr>
   <?php }?>
 </table>
 <?php }?>
 <br />
<br />
 <?php  
		 $ruta_timbre =6;
		 $ruta_firma =4;
		 $concur=0;
		 include("../../firmas/firmas.php");?>
<br />
</body>
</html>
