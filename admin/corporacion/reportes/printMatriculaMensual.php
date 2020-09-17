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
      <td><input type="button" name="Submit" value="VOLVER" onClick="javascript:history.back() " class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR" />
      </div></td>
	   <? if($_PERFIL == 0){?>					
		<td align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar();"  value="EXPORTAR"></td>
	  <? }?>
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
          <td class="titulo1">MATRICULA MENSUAL DE TODOS LOS ESTABLECIMIENTOS </td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="3" cellspacing="0" class="tabla2">
      <tr>
        <td rowspan="2" class="celdas1">RDB</td>
        <td rowspan="2" class="celdas1">ESTABLECIMIENTO</td>
        <td class="celdas1"><?=$ano;?></td>
		</tr>
      <tr>
        <td class="celdas1"><? echo envia_mes($mes);?></td>
		</tr>
	  <?
	  $tot_instit=0;
	  $tot_1 = 0;
	  $tot_2 = 0;
	  $tot_3 = 0;
	  $tot_4 = 0;
	  $tot_5 = 0;
	  $tot_6 = 0;
	  $tot_7 = 0;
	  $tot_8 = 0;
	  $tot_9 = 0;
	  $tot_10 = 0;
	  $tot_11 = 0;
	  $tot_12 = 0;
	  
	  $arr_rdb1= array();
	  $arr_mat_mes1= array();
	  
	  $arr_rdb2= array();
	  $arr_mat_mes2= array();
	  
	  $arr_rdb3= array();
	  $arr_mat_mes3= array();
	  
	  $arr_rdb4= array();
	  $arr_mat_mes4= array();
	  
	  $arr_rdb5= array();
	  $arr_mat_mes5= array();
	  
	  $arr_rdb6= array();
	  $arr_mat_mes6= array();
	  
	  $arr_rdb7= array();
	  $arr_mat_mes7= array();
	  
	  $arr_rdb8= array();
	  $arr_mat_mes8= array();
	  
	  $arr_rdb9= array();
	  $arr_mat_mes9= array();
	  
	  $arr_rdb10= array();
	  $arr_mat_mes10= array();
	  
	  $arr_rdb11= array();
	  $arr_mat_mes11= array();
	  
	  $arr_rdb12= array();
	  $arr_mat_mes12= array();
	  
	  $arr_rdb13= array();
	  $arr_mat_mes13= array();
	  
	  
	  
	  
	   foreach ($instituciones as $institucion): 
	       
		   $arr_mes    = array();
		   $arr_cant   = array();
	      
		   ?>
		  <tr>
		    <td class="text2"><?=$institucion['rdb']?>&nbsp;</td>
			<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><?=$institucion['nombre_instit']?></font></td>
			<?
			$id_ano = ano_escolar_por_institucion($institucion['rdb'],$ano,$conn);
			$matricula = matricula_institucion_mes_acumulado($id_ano,$mes,$conn,$ano);
			
			?>
			<td align="right" class="text2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=number_format($matricula,'0',',','.');?></font></td>
			<? 
			$tot_instit = $tot_instit + $matricula; $tot_1 = $tot_1 + $matricula; $arr_rdb1[]=$institucion['rdb']; $arr_mat_mes1[]=$matricula;
			$arr_mes[]=1;
			$arr_cant[] = $matricula;
			
			$arr1=serialize($arr_rdb1);
			$arr1=urlencode($arr1);
			
			
			$mat1=serialize($arr_mat_mes1);
			$mat1=urlencode($mat1);
			
			
			
			
			
			
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_2 = $tot_2 + $matricula; $arr_rdb2[]=$institucion['rdb']; $arr_mat_mes2[]=$matricula;
			$arr_mes[]=2;
			$arr_cant[] = $matricula;
			
			$arr2=serialize($arr_rdb2);
			$arr2=urlencode($arr2);
			
			
			$mat2=serialize($arr_mat_mes2);
			$mat2=urlencode($mat2);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_3 = $tot_3 + $matricula; $arr_rdb3[]=$institucion['rdb']; $arr_mat_mes3[]=$matricula;
			$arr_mes[]=3;
			$arr_cant[] = $matricula;
			
			$arr3=serialize($arr_rdb3);
			$arr3=urlencode($arr3);
			
			
			$mat3=serialize($arr_mat_mes3);
			$mat3=urlencode($mat3);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_4 = $tot_4 + $matricula; $arr_rdb4[]=$institucion['rdb']; $arr_mat_mes4[]=$matricula;
			$arr_mes[]=4;
			$arr_cant[] = $matricula;
			
			$arr4=serialize($arr_rdb4);
			$arr4=urlencode($arr4);
			
			
			$mat4=serialize($arr_mat_mes4);
			$mat4=urlencode($mat4);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_5 = $tot_5 + $matricula; $arr_rdb5[]=$institucion['rdb']; $arr_mat_mes5[]=$matricula;
			$arr_mes[]=5;
			$arr_cant[] = $matricula;
			
			$arr5=serialize($arr_rdb5);
			$arr5=urlencode($arr5);
			
			
			$mat5=serialize($arr_mat_mes5);
			$mat5=urlencode($mat5);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_6 = $tot_6 + $matricula; $arr_rdb6[]=$institucion['rdb']; $arr_mat_mes6[]=$matricula;
			$arr_mes[]=6;
			$arr_cant[] = $matricula;
			
			$arr6=serialize($arr_rdb6);
			$arr6=urlencode($arr6);
			
			
			$mat6=serialize($arr_mat_mes6);
			$mat6=urlencode($mat6);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_7 = $tot_7 + $matricula; $arr_rdb7[]=$institucion['rdb']; $arr_mat_mes7[]=$matricula;
			$arr_mes[]=7;
			$arr_cant[] = $matricula;
			
			$arr7=serialize($arr_rdb7);
			$arr7=urlencode($arr7);
			
			
			$mat7=serialize($arr_mat_mes7);
			$mat7=urlencode($mat7);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_8 = $tot_8 + $matricula; $arr_rdb8[]=$institucion['rdb']; $arr_mat_mes8[]=$matricula;
			$arr_mes[]=8;
			$arr_cant[] = $matricula;
			
			$arr8=serialize($arr_rdb8);
			$arr8=urlencode($arr8);
			
			
			$mat8=serialize($arr_mat_mes8);
			$mat8=urlencode($mat8);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_9 = $tot_9 + $matricula; $arr_rdb9[]=$institucion['rdb']; $arr_mat_mes9[]=$matricula;
			$arr_mes[]=9;
			$arr_cant[] = $matricula;
			
			$arr9=serialize($arr_rdb9);
			$arr9=urlencode($arr9);
			
			
			$mat9=serialize($arr_mat_mes9);
			$mat9=urlencode($mat9);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_10 = $tot_10 + $matricula; $arr_rdb10[]=$institucion['rdb']; $arr_mat_mes10[]=$matricula;
			$arr_mes[]=10;
			$arr_cant[] = $matricula;
			
			$arr10=serialize($arr_rdb10);
			$arr10=urlencode($arr10);
			
			
			$mat10=serialize($arr_mat_mes10);
			$mat10=urlencode($mat10);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_11 = $tot_11 + $matricula; $arr_rdb11[]=$institucion['rdb']; $arr_mat_mes11[]=$matricula;
			$arr_mes[]=11;
			$arr_cant[] = $matricula;
			
			$arr11=serialize($arr_rdb11);
			$arr11=urlencode($arr11);
			
			
			$mat11=serialize($arr_mat_mes11);
			$mat11=urlencode($mat11);
			?>
			<? $tot_instit = $tot_instit + $matricula; $tot_12 = $tot_12 + $matricula; $arr_rdb12[]=$institucion['rdb']; $arr_mat_mes12[]=$matricula;
			$arr_mes[]=12;
			$arr_cant[] = $matricula;
			
			$arr12=serialize($arr_rdb12);
			$arr12=urlencode($arr12);
			
			
			$mat12=serialize($arr_mat_mes12);
			$mat12=urlencode($mat12);
			
			
			$arr_meses=serialize($arr_mes);
			$arr_meses=urlencode($arr_meses);
			
			
			$arr_cantidad=serialize($arr_cant);
			$arr_cantidad=urlencode($arr_cantidad);
			
			?>
			<? $arr_rdb13[]=$institucion['rdb']; $arr_mat_mes13[]=$tot_instit;
			$arr_mes[]=13;
			$arr_cant[] = $matricula;
			
			$arr13=serialize($arr_rdb13);
			$arr13=urlencode($arr13);
						
			$mat13=serialize($arr_mat_mes13);
			$mat13=urlencode($mat13);
			
			?>
	      </tr>
		  <?
		  $tot_instit=0;
		  ?>
		  
	<? endforeach ?>	  
      
	  <tr>
	    <td colspan="2" class="celdas2">TOTALES</td>
        <td align="right" class="celdas2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=number_format($tot_1,'0,',',','.');?></font></td>
		</tr>
	 
	  <tr>
	    <td colspan="2" class="celdas2">GRAFICOS</td>
	    <td align="right" class="text2"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr2?>&amp;arr_mat_mes=<?=$mat1?>&mes=1&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    </tr>
    </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
       <div align="right" class="fecha"><?=date("l,d-m-Y");?> </div></td>
  </tr>
</table>
</body>
</html>