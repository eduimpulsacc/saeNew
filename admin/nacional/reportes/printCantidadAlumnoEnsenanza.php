<?

include("../controlador/controlador_1.php");

session_start();
$corporacion	= $_NACIONAL;
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
          <td class="titulo1">CANTIDAD DE ALUMNOS POR TIPO DE ENSEÑANZA POR INSTITUCI&Oacute;N<br />
            A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
    <table width="98%" border="1" align="center" cellpadding="3" cellspacing="0" class="tabla2">
      <tr>
        <td class="celdas1">RDB</td>
        <td class="celdas1">ESTABLECIMIENTO</td>
        
        <? 
			 $sql="  SELECT DISTINCT ensenanza,te.nombre_tipo from nacional_corp nc
					INNER JOIN corp_instit ci ON nc.num_corp=ci.num_corp
					INNER JOIN institucion i ON ci.rdb=i.rdb
					INNER JOIN ano_escolar ae ON ae.id_institucion=i.rdb
					INNER JOIN curso c ON c.id_ano=ae.id_ano
					INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
					WHERE id_nacional= ".$_CORPORACION;
 			$rs_ensenanza = pg_exec($conn,$sql);
			for($j=0;$j<@pg_numrows($rs_ensenanza);$j++){
				$fila_e = pg_fetch_array($rs_ensenanza,$j);
				
		?>
        <td class="celdas1"><?=$fila_e['ensenanza'];?></td>
        <?	
			}
		?>
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
			
			$arr_rdb1[]=$institucion['rdb']; 
			$arr_mat_mes1[]=$matricula;
			$arr_mes[]=1;
			$arr_cant[] = $matricula;
			
			$arr1=serialize($arr_rdb1);
			$arr1=urlencode($arr1);
			
			
			$mat1=serialize($arr_mat_mes1);
			$mat1=urlencode($mat1);
			
			for($j=0;$j<@pg_numrows($rs_ensenanza);$j++){
				$fila_e = pg_fetch_array($rs_ensenanza,$j);
				$ensenanza = matricula_ensenanza($id_ano,$conn,$fila_e['ensenanza']);
				
		?>
        <td class="text2">&nbsp;<?=$ensenanza;?></td>
        <?	
		
			//$tot_1.$j =$tot_1.$j + $ensenanza;
			
			}
		?>
		
            
	      </tr>
		  <?

		  $tot_instit=0;
		  ?>
		  
	<? endforeach ?>	  
      
	  <tr>
	    <td colspan="2" class="celdas2">TOTALES</td>
        <? 
        for($j=0;$j<@pg_numrows($rs_ensenanza);$j++){
				
		?>
        <td align="right" class="celdas2"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:10px">&nbsp;<?=number_format($tot_1.$j,'0,',',','.');?></font></td>
        <?	
		}
		?>
       
	
        
       
	  </tr>
	 
	  <tr>
	    <td colspan="2" class="celdas2">GRAFICO</td>
	    <td align="right" class="text2"><a href="#"><img src="../images/grafico2.jpg" width="22" height="27" border="0" onclick="MM_openBrWindow('graficoTotalMatricula.php?arr_rdb=<?=$arr1?>&amp;arr_mat_mes=<?=$mat1?>&mes=1&nro_ano=2010','','scrollbars=yes,resizable=yes,width=850,height=500')" /></a></td>
	    
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