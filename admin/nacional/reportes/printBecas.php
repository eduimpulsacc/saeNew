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
          <td class="titulo1">CANTIDAD DE ALUMNOS BECADOS POR INSTITUCI&Oacute;N <br />
          A&Ntilde;O <?=$ano;?></td>
        </tr>
      </table>
    <br />
	<? 	$sql  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
								$rs_instit = @pg_exec($conn,$sql)or die("f");
								for($b=0;$b<@pg_numrows($rs_instit);$b++){
											$fila_instit = @pg_fetch_array($rs_instit,$b);
												if($b==pg_numrows($rs_instit)-1){
														$conj_rdb = $conj_rdb."".$fila_instit['rdb'];
												}else{
														$conj_rdb = $conj_rdb."".$fila_instit['rdb'].",";
												} 
											}
						
	?>
    <table width="100%" border="1" cellspacing="0" cellpadding="3">
									<tr>
									  <td width="10%" class="celdas1">RDB</td>
									  <td width="50%" class="celdas1">ESTABLECIMIENTO</td>
							<? $sql_beca  ="SELECT id_beca, nomb_beca FROM becas_conf WHERE id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion in (".$conj_rdb."))";
								$rs_beca = @pg_exec($conn,$sql_beca);
								?>
								<? for($a=0; $a<@pg_numrows($rs_beca);$a++){
									$beca = pg_fetch_array($rs_beca,$a);	
								?>
									  <td align="center"class="celdas1" width="10%"><?=$beca['nomb_beca'];?></td>
								<? }?>
									</tr>
									<? for($i=0;$i<@pg_numrows($rs_instit);$i++){
											$fila_instit = @pg_fetch_array($rs_instit,$i);
									   ?>
									<tr>
									  <td class="text2"><div align="center">
									    <?=$fila_instit['rdb'];?>
								      </div></td>
									  <td class="text2"><div align="center">
									    <?=$fila_instit['nombre_instit'];?>
								      </div></td>

									  <? for($c=0; $c<@pg_numrows($rs_beca);$c++){
									  		$beca = pg_fetch_array($rs_beca,$c);
											
								$sql_ano  ="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." ";
								$sql_ano.="and nro_ano=".$ano."";
								$rs_ano = @pg_exec($conn,$sql_ano);
								$id_ano = pg_result($rs_ano,0);
								//echo $fila_instit['rdb']."=".$id_ano;
								
								$sql_becados  ="SELECT COUNT(*) FROM becas_benef WHERE id_ano=".$id_ano." and id_beca=".$beca['id_beca'];
								$rs_becados = @pg_exec($conn,$sql_becados);
								$becados = pg_result($rs_becados,0);
									  ?>
									  <td class="text2"><div align="center">
									    <?=$becados?>
								      </div></td>
									  <? 
									  	$total[$c]= $total[$c]+$becados; 
									  }?>
									</tr>
									<? } ?>
									<tr>
									  <td colspan="2" class="celdas1"><div align="right">TOTAL BECADOS 
									  </div></td>
									  <? for($d=0; $d<@pg_numrows($rs_beca);$d++){?>
									  <td class="celdas1"><div align="center">
									    <?=$total[$d]?>
								      </div></td>
									  <? }?>
									</tr>
	  </table>
    <br />
    <br />
    <br /></td>
  </tr>
  
  <tr>
    <td width="30%" valign="baseline"><HR />
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