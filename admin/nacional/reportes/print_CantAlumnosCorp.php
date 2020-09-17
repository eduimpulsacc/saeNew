<?

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
$ano			= $cmbANO;
$mes			= $cmbMES;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Reporte Sostenedor Corporativo</title>
<link href="../estilo.css" rel="stylesheet" type="text/css" />
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
<link href="../../../../../admin/corporacion/estilo.css" rel="stylesheet" type="text/css" />
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
      <td><input type="button" name="Submit" value="VOLVER" onClick="javascript:history.back(1) " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	  
    </tr>
  </table>
</div>
<br />
<table width="750" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="730" height="4" /></td>
        </tr>
        <tr>
          <td rowspan="5"> <?  echo "<img src='../images/".$corporacion."_logo.jpg' >"; ?></td>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$nombre;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$direc;?></div></td>
        </tr>
        <tr>
          <td class="membrete"><div align="right"><?=$fono;?></div></td>
        </tr>
        <tr>
          <td class="membrete">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2"><img src="../images/linea.jpg" width="730" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">ALUMNOS ADVENTISTAS DE TODOS LOS ESTABLECIMIENTOS </td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="3" cellspacing="0" class="tabla2">
      <tr>
        <td class="celdas1">RDB</td>
        <td class="celdas1">ESTABLECIMIENTO</td>
        <td class="celdas1">TOTAL MATRICULA</td>
        <td class="celdas1">TOTAL ADVENTISTAS</td>
        <td class="celdas1">% ADVENTISTAS</td>
		</tr>
      
	  <?
	  $tot_instit=0;
	  $tot_1 = 0;
	  
	  
	  $arr_rdb1= array();
	  $arr_mat_mes1= array();
	  
	 
	  
	  
	  
	   foreach ($instituciones as $institucion): 
	       
		   $arr_mes    = array();
		   $arr_cant   = array();
	      
		   ?>
		  <tr>
		    <td class="text2"><?=$institucion['rdb']?>&nbsp;</td>
			<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><?=$institucion['nombre_instit']?></font></td>
			<?
			$id_ano = ano_escolar_por_institucion($institucion['rdb'],$ano,$conn);
			$matricula_adv = alumnos_adventistas($id_ano,$conn);
			
			$matricula_total=matricula_total($id_ano,$conn);
			
			$porcentajetotal = ($matricula_adv * 100) / $matricula_total;
			
			?>
            <td align="right" class="text2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=number_format($matricula_total,'0',',','.');?></font></td>
            <td align="right" class="text2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=number_format($matricula_adv,'0',',','.');?></font></td>
			<td align="right" class="text2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?='%'.round($porcentajetotal);?></font></td>
			<? 
			$tot_instit = $tot_instit + $matricula; $tot_1 = $tot_1 + $matricula; $arr_rdb1[]=$institucion['rdb']; $arr_mat_mes1[]=$matricula;
			$arr_mes[]=1;
			$arr_cant[] = $matricula;
			
			$arr1=serialize($arr_rdb1);
			$arr1=urlencode($arr1);
			
			
			$mat1=serialize($arr_mat_mes1);
			$mat1=urlencode($mat1);
			
			
			?>
	      </tr>
		  <?
		  $tot_instit=0;
		  ?>
		  
	<? endforeach ?>	  
      
	  
	 
    </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
       <? $fecha=date("d-m-Y");
		$sql="SELECT comuna FROM nacional n INNER JOIN macional_corp nc ON n.id_nacional=nc.id_nacional WHERE num_corp=".$_CORPORACION;
		$rs_nacional = pg_exec($connection,$sql);
		$comuna=pg_result($rs_nacional,0);?>
      <?php switch($_CORPORACION){
			case 6:
				$nom_com="Pe&ntilde;alol&eacute;n,";
			break;
			case 1:
				$nom_com="Santiago,";
			break;
			case 2:
				$nom_com="Vi&ntilde;a del Mar,";
			break;
		}?>
       <div align="right" class="fecha"><?php echo $nom_com ?> <? echo fecha_espanol($fecha);?></div></td>
  </tr>
</table>
</body>
</html>