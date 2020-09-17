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
          <td class="titulo1">CANTIDAD DE ALUMNOS APROBADOS Y REPROBADOS POR INSTITUCI&Oacute;N<br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="3" cellspacing="0" class="tabla2">
      <tr>
        <td rowspan="3" class="celdas1">RDB</td>
        <td rowspan="3" class="celdas1">ESTABLECIMIENTO</td>
		<? $sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
			$result=pg_exec($conn,$sql);
			$nom_nivel=pg_result($result,0);
		?>
        <td colspan="5" class="celdas1"><?=$nom_nivel;?></td>
        </tr>
      <tr>
        <td rowspan="2" class="celdas1">TOTAL<br />
          MATRICULA NIVEL</td>
        <td rowspan="2" class="celdas1">APROB.</td>
		<td colspan="3" class="celdas1">REPROBADOS</td>
        </tr>
      <tr>
        <td class="celdas1">ASISTENCIA</td>
        <td class="celdas1">RENDIMIENTO</td>
        <td class="celdas1">TOTAL</td>
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
			
			 $matricula = matricula_institucion_mes_acumulado_niv($id_ano,12,$cmbNIVEL,$conn);
			$reprobados = alumnos_reprobados_nivel($id_ano,$cmbNIVEL,$conn);
			$aprobados = alumnos_promovidos_nivel($id_ano,$cmbNIVEL,$conn);
			
			$sql_asist = "SELECT count(*) as cantidad FROM promocion WHERE id_ano=$id_ano AND situacion_final=2 AND tipo_reprova=2 AND id_curso IN (SELECT id_curso FROM curso WHERE id_nivel=$cmbNIVEL AND id_ano=$id_ano)";
			$res_asist = pg_exec($conn, $sql_asist);
			$fila_asist = pg_fetch_array($res_asist,0);
			$inasistencia = $fila_asist['cantidad'];
			
			"<br />".$sql_rend = "SELECT count(*) as cantidad FROM promocion WHERE id_ano=$id_ano AND situacion_final=2 AND tipo_reprova=1 AND id_curso IN (SELECT id_curso FROM curso WHERE id_nivel=$cmbNIVEL AND id_ano=$id_ano)";
			$res_rend = pg_exec($conn, $sql_rend);
			$fila_rend = pg_fetch_array($res_rend,0);
			$rendimiento = $fila_rend['cantidad'];
			
			
			
			?>
			<td align="right" class="text2">
			  <div align="center">
			    <?=number_format($matricula,'0',',','.');?>
	        </div></td>
			<td align="right" class="text2"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">
			  <?=number_format($aprobados,'0',',','.');?>
		    </font></div></td>
			<td align="right" class="text2">
			  <div align="center">
			    <?=number_format($inasistencia,'0',',','.');?>
	        </div></td>
			<td align="right" class="text2">
			  <div align="center">
			    <?=number_format($rendimiento,'0',',','.');?>
	        </div></td>
			<td align="right" class="text2"><div align="center">
			  <?=$reprobados;?>
		    </div></td>
			<? 
			$tot_instit = $tot_instit + $matricula; 
			$tot_repro	= $tot_repro + $reprobados;
			$tot_apro	= $tot_apro + $aprobados;
			$tot_inasist	= $tot_inasist + $inasistencia;
			$tot_rend	= $tot_rend + $rendimiento;
			$tot_1 = $tot_1 + $matricula;
			$arr_rdb1[]=$institucion['rdb']; 
			$arr_mat_mes1[]=$matricula;
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
      
	  <tr>
	    <td colspan="2" class="celdas2">TOTALES</td>
        <td align="right" class="celdas2">&nbsp;
          <div align="center">
            <?=number_format($tot_1,'0,',',','.');?>
          </div></td>
        <td align="right" class="celdas2"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">
          <?=number_format($tot_apro,'0,',',','.');?>
        </font></div></td>
		<td align="right" class="celdas2">
		  <div align="center">
		    <?=$tot_inasist;?>
	      </div></td>
	    <td align="right" class="celdas2">
	      <div align="center">
	        <?=$tot_rend;?>
          </div></td>
	    <td align="right" class="celdas2"><div align="center">
	      <?=$tot_repro;?>
	      </div></td>
	  </tr>
    </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
  <?
  	 setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
     $fechaEspañol = strftime("%A %d de %B del %Y");
  ?>
  
    <td valign="baseline"><HR />
       <div align="right" class="fecha">Valparaiso, <?=$fechaEspañol?></div></td>
  </tr>
</table>
</body>
</html>