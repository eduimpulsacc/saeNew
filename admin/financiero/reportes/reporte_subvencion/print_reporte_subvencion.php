<?
require_once('mod_reporte_subvencion.php');
require('../../../../util/header.inc');

$rdb	= $_INSTIT;
$nro_ano			= $cmb_anos;
$mes			= $cmb_mes;

$id_nacional=	$_ID_NACIONAL;
$tipo_instit=1;

//print_r($_POST);




switch($mes){
			case $mes == 1;
			$mes='Enero';
			break;
			case $mes == 2;
			$mes='Febrero';
			break;
			case $mes == 3;
			$mes='Marzo';
			break;
			case $mes == 4;
			$mes='Abril';
			break;
			case $mes == 5;
			$mes='Mayo';
			break;
			case $mes == 6;
			$mes='Junio';
			break;
			case $mes == 7;
			$mes='Julio';
			break;
			case $mes == 8;
			$mes='Agosto';
			break;
			case $mes == 9;
			$mes='Septiembre';
			break;
			case $mes == 10;
			$mes='Octubre';
			break;
			case $mes == 11;
			$mes='Noviembre';
			break;
			case $mes == 12;
			$mes='Diciembre';
			break;
			}



$obj_motor = new Motor($conn); 


$datos_instit=$obj_motor->datos_institucion($rdb);
$nombre=pg_result($datos_instit,2);
$calle=pg_result($datos_instit,3);
$numero=pg_result($datos_instit,4);
$direc=$calle."  ".$numero;
$fono=pg_result($datos_instit,11);
$insignia=pg_result($datos_instit,27);


$rs_ano=$obj_motor->ano_academico($rdb,$nro_ano);
$id_ano=(pg_result($rs_ano,0));




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte Sostenedor Corporativo</title>
<link href="../../../estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
body {
	background-image: url();
}
-->
</style>
<script language="javascript">
<!--

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	  
		 
</script>
<link href="../../../corporacion/estilo.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo2 {font-weight: bold; background-color: #CCCCCC; text-align: center;}
.Estilo3 {font-family:Verdana, Arial, Helvetica, sans-serif; text-align:center; font-weight: bold; background-color: #CCCCCC;}
-->
</style>
</head>
<body>
<div id="capa0">
  <table width="650" border="0" align="center">
    <tr>
      <td><input type="button" name="Cerrar" value="CERRAR" onClick="javascript:window.close() " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	  
    </tr>
  </table>
</div>
<br /><br /><br />
<? 	$sql="SELECT logo FROM corporacion WHERE num_corp=".$_CORPORACION;
	$rs_logo = pg_exec($conn,$sql);
	$logo = pg_result($rs_logo,0);?>
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td><img src="<?=$logo;?>" /></td>
          <td align="right"><img src="../../img/logo_colegiointeractivo.jpg" width="194" height="104" /></td>
        </tr>
        
     
       
        <tr>
          <td>&nbsp;</td>
          <td height="21" align="right">&nbsp;</td>
        </tr>
      </table>
      <hr />
      <br />
      <br />
      <br />
      <table width="600" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">REPORTE SUBVENCI&Oacute;N<br />
            &nbsp;<?=$mes?> A&Ntilde;O <?=$nro_ano;?></td>
        </tr>
      </table>
    <br />
    <br />
    <table width="600" border="1" align="center" cellpadding="3" cellspacing="0" class="#" style="background-color:#FFFFFF">
      <tr style="background-color:#CCC; font-family:Georgia, 'Times New Roman', Times, serif;">
        <td width="10%" align="center" >RDB</td>
        <td width="25%" align="center" >Instituci&oacute;n</td>
        <td width="12%" align="center" >SEP</td>
        <td width="9%" align="center" >PIE</td>
        <td width="15%" align="center" >RETOS</td>
        <td width="20%" align="center" >NORMAL</td>
        <td width="16%" align="center" >TOTAL</td>
        </TR>
        
        
        <?php
			$contador_s=0;
			$contador_p=0;
			$contador_r=0;
			$contador_n=0;
		    $cmb_mes;
			$rs_sub=$obj_motor->carga_subvenciones($id_nacional,$nro_ano,$cmb_mes);
			
			for($i=0;$i<pg_numrows($rs_sub);$i++){
			$fila=pg_fetch_array($rs_sub,$i);
			?>
            <tr style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#333;">
            <td><?=$fila['rdb']?></td>
            <td><?=$fila['nombre_intitucion']?></td>
            <td align="center">$<?=number_format($fila['sep'], 0, ',', '.')?></td>
            <td align="center">$<?=number_format($fila['pie'], 0, ',', '.')?></td>
            <td align="center">$<?=number_format($fila['retos'], 0, ',', '.')?></td>
            <td align="center">$<?=number_format($fila['normal'], 0, ',', '.')?></td>
            <td align="center">
            <?
            $Total = $fila['sep']+$fila['pie']+$fila['retos']+$fila['normal'];
			echo number_format($Total, 0, ',', '.');
			?>
            
            
            </td>
            
            </tr>
            <?	
			$contador_s=$fila['sep']+$contador_s;
			$contador_p=$fila['pie']+$contador_p;
			$contador_r=$fila['retos']+$contador_r;
			$contador_n=$fila['normal']+$contador_n;
				
				}
     		?>            
              <div id="separa">&nbsp;</div>
    </table>
    <br />
    <br />
    <br />
    
  <table width="600" align="center" border="1" style="border-collapse:collapse">
            <tr style="font-family:Verdana, Geneva, sans-serif; font-size:11px; color:#333;">
            <td width="188" align="center" style="font:bold">TOTAL</td>
            <td width="58" align="center">$<?=number_format($contador_s, 0, ',', '.')?></td>
            <td width="41" align="center">$<?=number_format($contador_s, 0, ',', '.')?></td>
            <td width="76" align="center">$<?=number_format($contador_r, 0, ',', '.')?></td>
            <td width="104" align="center">$<?=number_format($contador_n, 0, ',', '.')?></td>
            <td width="93" align="center">
            <?
            	$total_ = ($contador_s+$contador_s+$contador_r+$contador_n)
			?>
            
            $<?=number_format($total_, 0, ',', '.')?></td>

            
            </tr>
            </table>  
             <br />
    <br />
    <br />
    
  </td>
  </tr>
  
  <tr>
  <?
  	 setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspañol = strftime("%A %d de %B del %Y");
  ?>
    <td valign="baseline"><HR />
       <div align="right" class="fecha"> <?=$fechaEspañol?> </div></td>
  </tr>
</table>
</body>
</html>