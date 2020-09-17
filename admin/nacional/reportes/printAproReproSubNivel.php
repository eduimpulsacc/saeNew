<?

include("../controlador/controlador_1.php");


$corporacion	= $_NACIONAL;
$ano			= $cmbANO;
$nivel			= $cmbNIVEL;

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
		<? $sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
			$result=pg_exec($conn,$sql);
			$nom_nivel=pg_result($result,0);
		?>
          <td class="titulo1">CANTIDAD DE ALUMNOS APROBADOS Y REPROBADOS POR INSTITUCI&Oacute;N, NIVEL <?=$nom_nivel;?><br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="3" cellspacing="0" class="tabla2">
      <tr>
        <td rowspan="2" class="celdas1">RDB</td>
        <td rowspan="2" class="celdas1">ESTABLECIMIENTO</td>
		<? $sql = "SELECT nombre FROM subsector WHERE cod_subsector=".$cmbSUBSECTOR_1;
		   $result = @pg_exec($conn, $sql);
		   $nom_sub = pg_result($result,0);
		?>
        <td colspan="3" class="celdas1"><?=$nom_sub;?>&nbsp;</td>
        </tr>
      <tr>
        <td class="celdas1">APROB.</td>
        <td class="celdas1">REPROB.</td>
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
		
				
				$sql_apro ="select count(*) as cantidad from promedio_sub_alumno where id_ano=".$id_ano." and id_ramo in(select id_ramo";
				$sql_apro.=" from ramo where cod_subsector=".$cmbSUBSECTOR_1." and id_curso in (Select id_curso from curso where ";
				$sql_apro.="id_ano=".$id_ano." and id_nivel=".$cmbNIVEL.")) and promedio>='40'";
				$res_apro = pg_exec($conn, $sql_apro);
				$fila_apro = pg_fetch_array($res_apro,0);
				$cantidad_apro = $fila_apro['cantidad'];
				
				
				$sql_repro ="select count(*) as cantidad from promedio_sub_alumno where id_ano=".$id_ano." and id_ramo ";
				$sql_repro.="in(select id_ramo from ramo where cod_subsector=".$cmbSUBSECTOR_1." and id_curso in ";
				$sql_repro.="(Select id_curso from curso where id_ano=".$id_ano." and id_nivel=".$cmbNIVEL.")) and promedio<'40'";
				$res_repro = pg_exec($conn, $sql_repro);
				$fila_repro = pg_fetch_array($res_repro,0);
				$cantidad_repro = $fila_repro['cantidad'];
				
				$total_apro_repro = $cantidad_apro + $cantidad_repro;
				
				$tot_apro = $tot_apro + $cantidad_apro;
				$tot_repro = $tot_repro + $cantidad_repro;
				
				$total_final = $tot_apro + $tot_repro;

			?>
			<td align="right" class="text2"><div align="center">
			  <?=number_format($cantidad_apro,'0',',','.');?>
		    </div></td>
			<td align="right" class="text2"><div align="center">
			  <?=number_format($cantidad_repro,'0',',','.');?>
		    </div></td>
			<td align="right" class="text2"><div align="center">
			  <?=number_format($total_apro_repro,'0',',','.');?>
		    </div></td>
			<? 

			
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
        <td align="right" class="celdas2"><div align="center">
          <?=number_format($tot_apro,'0,',',','.');?>
        </div></td>
        <td align="right" class="celdas2"><div align="center">
          <?=number_format($tot_repro,'0,',',','.');?>
        </div></td>
	    <td align="right" class="celdas2"><div align="center"><?=number_format($total_final,'0,',',','.');?></div></td>
	  </tr>
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