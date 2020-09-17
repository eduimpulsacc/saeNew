<?
session_start();
include("../controlador/controlador_1.php");
echo "<pre>";
//print_r($GLOBALS);
echo "</pre>";
$corporacion	= $_CORPORACION;
$ano			=  $cmbANO;

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
      <td><input type="button" name="Submit" value="CERRAR" onClick="javascript:window.close() " class="botonXX"/></td>
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
          <td class="titulo1">TOTAL DE MATRICULA TODOS LOS ESTABLECIMIENTOS </td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="3" cellspacing="0" class="tabla2">
      <tr>
        <td rowspan="2" class="celdas1">RDB</td>
        <td rowspan="2" class="celdas1">ESTABLECIMIENTO</td>
        <td colspan="12" class="celdas1"><?=$cmbANO;?></td>
		<td rowspan="2" class="celdas1">TOT.</td>
        <td rowspan="2" class="celdas1">GFC</td>
      </tr>
      <tr>
        <td class="celdas1">ENE</td>
		<td class="celdas1">FEB</td>
        <td class="celdas1">MAR</td>
        <td class="celdas1">ABR</td>
        <td class="celdas1">MAY</td>
        <td class="celdas1">JUN</td>
        <td class="celdas1">JUL</td>
        <td class="celdas1">AGO</td>
        <td class="celdas1">SEP</td>
        <td class="celdas1">OCT</td>
        <td class="celdas1">NOV</td>
        <td class="celdas1">DIC</td>
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
			<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px"><?=strtoupper($institucion['nombre_instit']);?></font></td>
			<?
			$id_ano = ano_escolar_por_institucion($institucion['rdb'],$ano,$conn);
			
			
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,1,$conn,$ano);?></font></td>
			<? 
			$tot_instit = $tot_instit + $matricula; $tot_1 = $tot_1 + $matricula; 
			$arr_rdb1[]=$institucion['rdb']; 
			$arr_mat_mes1[]=$matricula;
			$arr_mes[]=1;
			$arr_cant[] = $matricula;
			
			$arr1=serialize($arr_rdb1);
			$arr1=urlencode($arr1);
			
			
			$mat1=serialize($arr_mat_mes1);
			$mat1=urlencode($mat1);
			
			
			
			
			
			
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,2,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_2 = $tot_2 + $matricula; 
			$arr_rdb2[]=$institucion['rdb']; 
			$arr_mat_mes2[]=$matricula;
			$arr_mes[]=2;
			$arr_cant[] = $matricula;
			
			$arr2=serialize($arr_rdb2);
			$arr2=urlencode($arr2);
			
			
			$mat2=serialize($arr_mat_mes2);
			$mat2=urlencode($mat2);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,3,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_3 = $tot_3 + $matricula; $arr_rdb3[]=$institucion['rdb']; $arr_mat_mes3[]=$matricula;
			$arr_mes[]=3;
			$arr_cant[] = $matricula;
			
			$arr3=serialize($arr_rdb3);
			$arr3=urlencode($arr3);
			
			
			$mat3=serialize($arr_mat_mes3);
			$mat3=urlencode($mat3);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,4,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_4 = $tot_4 + $matricula; $arr_rdb4[]=$institucion['rdb']; $arr_mat_mes4[]=$matricula;
			$arr_mes[]=4;
			$arr_cant[] = $matricula;
			
			$arr4=serialize($arr_rdb4);
			$arr4=urlencode($arr4);
			
			
			$mat4=serialize($arr_mat_mes4);
			$mat4=urlencode($mat4);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,5,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_5 = $tot_5 + $matricula; $arr_rdb5[]=$institucion['rdb']; $arr_mat_mes5[]=$matricula;
			$arr_mes[]=5;
			$arr_cant[] = $matricula;
			
			$arr5=serialize($arr_rdb5);
			$arr5=urlencode($arr5);
			
			
			$mat5=serialize($arr_mat_mes5);
			$mat5=urlencode($mat5);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,6,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_6 = $tot_6 + $matricula; $arr_rdb6[]=$institucion['rdb']; $arr_mat_mes6[]=$matricula;
			$arr_mes[]=6;
			$arr_cant[] = $matricula;
			
			$arr6=serialize($arr_rdb6);
			$arr6=urlencode($arr6);
			
			
			$mat6=serialize($arr_mat_mes6);
			$mat6=urlencode($mat6);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,7,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_7 = $tot_7 + $matricula; $arr_rdb7[]=$institucion['rdb']; $arr_mat_mes7[]=$matricula;
			$arr_mes[]=7;
			$arr_cant[] = $matricula;
			
			$arr7=serialize($arr_rdb7);
			$arr7=urlencode($arr7);
			
			
			$mat7=serialize($arr_mat_mes7);
			$mat7=urlencode($mat7);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,8,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_8 = $tot_8 + $matricula; $arr_rdb8[]=$institucion['rdb']; $arr_mat_mes8[]=$matricula;
			$arr_mes[]=8;
			$arr_cant[] = $matricula;
			
			$arr8=serialize($arr_rdb8);
			$arr8=urlencode($arr8);
			
			
			$mat8=serialize($arr_mat_mes8);
			$mat8=urlencode($mat8);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,9,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_9 = $tot_9 + $matricula; $arr_rdb9[]=$institucion['rdb']; $arr_mat_mes9[]=$matricula;
			$arr_mes[]=9;
			$arr_cant[] = $matricula;
			
			$arr9=serialize($arr_rdb9);
			$arr9=urlencode($arr9);
			
			
			$mat9=serialize($arr_mat_mes9);
			$mat9=urlencode($mat9);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,10,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_10 = $tot_10 + $matricula; $arr_rdb10[]=$institucion['rdb']; $arr_mat_mes10[]=$matricula;
			$arr_mes[]=10;
			$arr_cant[] = $matricula;
			
			$arr10=serialize($arr_rdb10);
			$arr10=urlencode($arr10);
			
			
			$mat10=serialize($arr_mat_mes10);
			$mat10=urlencode($mat10);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,11,$conn);?></font></td>
			<? $tot_instit = $tot_instit + $matricula; $tot_11 = $tot_11 + $matricula; $arr_rdb11[]=$institucion['rdb']; $arr_mat_mes11[]=$matricula;
			$arr_mes[]=11;
			$arr_cant[] = $matricula;
			
			$arr11=serialize($arr_rdb11);
			$arr11=urlencode($arr11);
			
			
			$mat11=serialize($arr_mat_mes11);
			$mat11=urlencode($mat11);
			?>
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$matricula = matricula_institucion_mes($id_ano,12,$conn);?></font></td>
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
			<td class="text2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=number_format($tot_instit,'0',',','.')?></font></td>
			
			<? $arr_rdb13[]=$institucion['rdb']; $arr_mat_mes13[]=$tot_instit;
			$arr_mes[]=13;
			$arr_cant[] = $matricula;
			
			$arr13=serialize($arr_rdb13);
			$arr13=urlencode($arr13);
						
			$mat13=serialize($arr_mat_mes13);
			$mat13=urlencode($mat13);
			
			?>
			
			
		    <td class="text2" align="right"><a href="#"><img src="../images/grafico1.jpg" width="17" height="18" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr_meses?>&amp;arr_mat_mes=<?=$arr_cantidad?>&mes=1&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
		  </tr>
		  <?
		  $tot_instit=0;
		  ?>
		  
	<? endforeach ?>	  
      
	  <tr>
	    <td colspan="2" class="celdas2">TOTALES</td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_1?></font></td>
		<td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_2?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_3?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_4?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_5?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_6?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_7?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_8?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_9?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_10?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_11?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_12?></font></td>
        <td class="celdas2" align="right"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=$tot_1+$tot_2+$tot_3+$tot_4+$tot_5+$tot_6+$tot_7+$tot_8+$tot_9+$tot_10+$tot_11+$tot_12?></font></td>
        <td class="text2" align="right"><a href="#"><img src="../images/grafico1.jpg" width="17" height="18" border="0" /></a></td>
	  </tr>
	 
	  <tr>
	    <td colspan="2" class="celdas2">GRAFICOS</td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?mes=1&nro_ano=2010&arr_rdb=<?=$arr2?>&arr_mat_mes=<?=$mat1;?>' ,'','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr2?>&amp;arr_mat_mes=<?=$mat2?>&mes=2&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr3?>&amp;arr_mat_mes=<?=$mat3?>&mes=3&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0"  onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr4?>&amp;arr_mat_mes=<?=$mat4?>&mes=4&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')"/></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr5?>&amp;arr_mat_mes=<?=$mat5?>&mes=5&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr6?>&amp;arr_mat_mes=<?=$mat6?>&mes=6&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr7?>&amp;arr_mat_mes=<?=$mat7?>&mes=7&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr8?>&amp;arr_mat_mes=<?=$mat8?>&mes=8&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr9?>&amp;arr_mat_mes=<?=$mat9?>&mes=9&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr10?>&amp;arr_mat_mes=<?=$mat10?>&mes=10&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr11?>&amp;arr_mat_mes=<?=$mat11?>&mes=11&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr12?>&amp;arr_mat_mes=<?=$mat12?>&mes=12&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr13?>&amp;arr_mat_mes=<?=$mat13?>&mes=0&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    <td class="text2" align="right">&nbsp;</td>
	    </tr>
    </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td valign="baseline"><HR />
    <? $fecha=date("d-m-Y");
		 $sql="SELECT comuna FROM nacional n INNER JOIN nacional_corp nc ON n.id_nacional=nc.id_nacional WHERE num_corp=".$_CORPORACION;
		$rs_nacional = pg_exec($connection,$sql);
		$comuna=pg_result($rs_nacional,0);
		
		switch($_CORPORACION){
			case 6:
				$nom_com="Pe&ntilde;alol&eacute;n,";
			break;
			case 1:
				$nom_com="Santiago,";
			break;
			case 2:
				$nom_com="Vi&ntilde;a del Mar,";
			break;
		}
		
		?>
        
        
        
       <div align="right" class="fecha"><?php echo $nom_com ?> <? echo fecha_espanol($fecha);?></div></td>
  </tr>
</table>
</body>
</html>