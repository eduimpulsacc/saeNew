<?

include("../controlador/controlador_1.php");


$corporacion	= $_CORPORACION;
//$corporacion	= 2; 	//Usar esta corporación para pruebas si es que no existen datos en corporación
$ano			= $cmbANO;

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
<table width="900" height="843" border="0" align="center" cellpadding="0" cellspacing="0" >
  <tr>
    <td height="113" valign="top">
      <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td colspan="2"><img src="../images/linea2.jpg" width="900" height="4" /></td>
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
          <td colspan="2"><img src="../images/linea.jpg" width="900" height="4" /></td>
        </tr>
      </table>
      <br />
      <br />
      <br />
		<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" >
        <tr>
          <td class="titulo1">TOTAL DE ASISTENCIA ANUAL DE TODOS LOS ESTABLECIMIENTOS 
           <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
	    <br />
      <br />
		<table width="100%" border="1" cellpadding="3" cellspacing="0">
                                 <tr>
                                   <td rowspan="2" class="celdas1">RBD</td>
                                   <td rowspan="2" class="celdas1">ESTABLECIMIENTOS</td>
                                   <td colspan="10" class="celdas1">MESES</td>
                                   <td rowspan="2" class="celdas1">TOTAL</td>
                                 </tr>
								 <? $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO." ORDER BY nombre_instit ASC";
									$rs_instit = @pg_exec($conn,$sql); 
									
									
									?>
									
                                 <tr>
                                   <? for($i=3;$i<13;$i++){?>
                                   <td class="celdas1">&nbsp;
                                       <?=substr(envia_mes($i),0,3);?></td>
                                   <? } ?>
                                 </tr>
								 <? for($k=0;$k<@pg_numrows($rs_instit);$k++){
										$fila_inst = @pg_fetch_array($rs_instit,$k);
										$total_colegio=0;

										?>
                                 <tr>
                                   <td class="text2"><div align="center">
                                     <?=$fila_inst['rdb'];?>
                                   </div></td>
                                   <td class="text2"><div align="center">
                                     <?=$fila_inst['nombre_instit'];?>
                                   </div></td>
                                   <? for($i=3;$i<13;$i++){
								   		 $sql = "select count(*) as cuenta,id_institucion from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano WHERE nro_ano=".$cmbANO." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$i." AND bool_ar=0 group by id_institucion ";
										$rs_mat = @pg_exec($conn,$sql);
										
										
										
										?>
                                   <td class="text2"><div align="center">
                                     <?=number_format(pg_result($rs_mat,0),'0',',','.');?>
                                   </div></td>
                                   <? 	$total_colegio = $total_colegio + pg_result($rs_mat,0);
								   		$total_mes[$i] = $total_mes[$i] + pg_result($rs_mat,0);
								   } ?>
                                   <td class="celdas1"><div align="center">
                                     <?=number_format($total_colegio,'0',',','.');?>
                                   </div></td>
                                 </tr>
								 <? } ?>
                                 <tr>
                                   <td class="celdas1">&nbsp;</td>
                                   <td class="celdas1">TOTAL</td>
                                   <? for($i=3;$i<13;$i++){?>
                                   <td class="celdas1"><?=number_format($total_mes[$i],'0',',','.');?>&nbsp;</td>
                                   <? $total_gral = $total_gral + $total_mes[$i];
								   } ?>
                                   <td class="celdas1"><?=number_format($total_gral,'0',',','.');?>&nbsp;</td>
                                 </tr>
                               </table>	
									  <BR />

								

								<br>
		
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
       <div align="right" class="fecha"> <?=$fechaEspañol?> </div></td>
  </tr>
</table>
</body>
</html>