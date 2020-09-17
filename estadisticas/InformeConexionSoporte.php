<?php 
	require('../util/header.inc');
	
	
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}
	$colpan = $txtMESH - $txtMESD + 1 ;
	if($rdTIPO==1){
		$colpan = $txtMESH - $txtMESD + 1 ;
		$conn2=pg_connect("dbname=soporte host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
	}else{
		$conn3=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
	}
	
	if($xls==1){	 
		$fecha_actual = date('d/m/Y-H:i:s');
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=InformeConexiones$fecha_actual.xls"); 	 
	}	 

?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


function exportar(){
	//var ensenanza_exp = document.form.ensenanza_c.value;
	window.location='InformeConexionSoporte.php?xls=1&rdTIPO=<?=$rdTIPO;?>&cmbPERFIL=<?=$cmbPERFIL;?>&rdTIPO=<?=$rdTIPO;?>&cmbCORP=<?=$cmbCORP;?>&rbINSTIT=<?=$rbINSTIT;?>&txtMESD=<?=$txtMESD;?>&txtANOD=<?=$txtANOD;?>&txtMESH=<?=$txtMESH;?>&txtANOH=<?=$txtANOH;?>';
	return false;
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE: Colegio Interactivo</title>
<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
.Estilo6 {font-size: 12px}
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo10 {font-size: 10px}
.Estilo15 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10; }
.Estilo16 {font-size: 10}
-->
</style>
</head>

<body>
<div id="capa0">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><input type="button" name="Submit" value="CERRAR" onClick="window.close() " class="botonXX"/></td>
    <td><input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR" /></td>
    <td><input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR" /></td>
  </tr>
</table>
</div>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="3" class="tableindex"><div align="center"><strong>REPORTE ESTADISTICO </strong></div></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td width="170"><span class="Estilo5">TIPO INSTITUCION</span></td>
        <td width="9"><span class="Estilo5">:</span></td>
        <td width="413"><span class="Estilo6">
		<? 	if($rbINSTIT==1){
				$tipo_instit = "Colegios Particular o Particular Subvencionado";
			}else{
				$sql ="SELECT  nombre_corp FROM corporacion WHERE num_corp = ".$cmbCORP;
				$rs_corp = pg_exec($conn,$sql) or die ("SELECT FALLO:".$sql);
				$tipo_instit = @pg_result($rs_corp,0);
			}
				echo strtoupper($tipo_instit);
		?>
		</span></td>
      </tr>
      <tr>
        <td><span class="Estilo5">PERFIL</span></td>
        <td><span class="Estilo5">:</span></td>
        <td><span class="Estilo6"><?
			$sql = "SELECT nombre_perfil FROM perfil WHERE id_perfil=".$cmbPERFIL;
			$rs_perfil = @pg_exec($conn,$sql);
			echo $perfil = @pg_result($rs_perfil,0); ?>
			</span>
		</td>
      </tr>
      <tr>
        <td><span class="Estilo5">PERIODO</span></td>
        <td><span class="Estilo5">:</span></td>
        <td><span class="Estilo6"><? echo "DESDE :".$txtMESD."/".$txtANOD."   HASTA :".$txtMESH."/".$txtANOH;?></span></td>
      </tr>
      <tr>
        <td><span class="Estilo5">TIPO REPORTE</span></td>
        <td><span class="Estilo5">: </span></td>
        <td><span class="Estilo6">
		<?	if($rdTIPO==1){
				echo "SOPORTE";
			}else{
				echo "CONEXIONES";
			}
		?>
		</span></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">
		<? if($rdTIPO==1){?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%" rowspan="2" class="Estilo5">RDB</td>
            <td width="80%" rowspan="2" class="Estilo5">NOMBRE</td>
            <td width="9%" colspan="<?=$colpan;?>" class="Estilo5"><div align="center">SOPORTE</div></td>
          </tr>
          <tr>
		  	<? for($x=$txtMESD;$x<=$txtMESH;$x++){?>
            <td class="Estilo5"><span class="Estilo16"><? echo substr(envia_mes($x),0,3);?></span></td>
			<? } ?>

          </tr>
		  <?	if($rbINSTIT==2){
			  		$sql = "SELECT rdb,nombre_instit FROM institucion WHERE rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$cmbCORP.")";
				}else{
					if($cmbINSTIT==0){
						$sql = "SELECT rdb,nombre_instit FROM institucion WHERE estado_colegio=1"; 
					}else{
						$sql = "SELECT rdb,nombre_instit FROM institucion WHERE rdb=".$cmbINSTIT; 
					}
				}
		  		$result_instit = @pg_exec($conn,$sql);
				for($i=0;$i<@pg_numrows($result_instit);$i++){
					$fila_instit = @pg_fetch_array($result_instit,$i);
			?>
          <tr>
            <td><span class="Estilo9">&nbsp;
            <?=$fila_instit['rdb'];?>
            </span></td>
            <td><span class="Estilo9">&nbsp;
            <?=$fila_instit['nombre_instit'];?>
            </span></td>
			<? for($x=$txtMESD;$x<=$txtMESH;$x++){
					$contador=0;
					$sql ="SELECT count(*) FROM solicitud_ot2 WHERE rdb=".$fila_instit['rdb']." AND date_part('month',fecha_sol)=".$x." AND date_part('year',fecha_sol)=".$txtANOD;
					$rs_soporte =@pg_exec($conn2,$sql);
					$contador = @pg_result($rs_soporte,0);
			?>
            <td><div align="center"><span class="Estilo10">&nbsp;
              <?=$contador;?>
            </span></div></td>
			<? } ?>
          </tr>
		  <? } ?>
        </table>
		<? }else{?>
		<table width="100%" border="1" cellspacing="0" cellpadding="0">
          <tr>
            <td width="11%" rowspan="2" class="Estilo5">RDB</td>
            <td width="80%" rowspan="2" class="Estilo5">NOMBRE</td>
            <td width="9%" colspan="<?=$colpan;?>" class="Estilo5"><div align="center">CONEXI&Oacute;N</div></td>
          </tr>
          <tr>
		  	<? for($x=$txtMESD;$x<=$txtMESH;$x++){?>
            <td class="Estilo5"><span class="Estilo16"><? echo substr(envia_mes($x),0,3);?></span></td>
			<? } ?>

          </tr>
		  <?	if($rbINSTIT==2){
			  		$sql = "SELECT rdb,nombre_instit FROM institucion WHERE rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$cmbCORP.")";
				}else{
					if($cmbINSTIT==0){
						$sql = "SELECT rdb,nombre_instit FROM institucion WHERE estado_colegio=1"; 
					}else{
						$sql = "SELECT rdb,nombre_instit FROM institucion WHERE rdb=".$cmbINSTIT; 
					}
				}
		  		$result_instit = @pg_exec($conn,$sql);
				for($i=0;$i<@pg_numrows($result_instit);$i++){
					$fila_instit = @pg_fetch_array($result_instit,$i);
			?>
          <tr>
            <td><span class="Estilo9">&nbsp;
            <?=$fila_instit['rdb'];?>
            </span></td>
            <td><span class="Estilo9">&nbsp;
            <?=$fila_instit['nombre_instit'];?>
            </span></td>
			<? for($x=$txtMESD;$x<=$txtMESH;$x++){
					$contador_con=0;
					$sql ="SELECT sum(cant_conex) FROM estadistica WHERE rdb=".$fila_instit['rdb']." AND date_part('year',fecha)=".$txtANOD."  AND date_part('month',fecha)=".$x." and perfil=".$cmbPERFIL;
					$rs_conexion =@pg_exec($conn3,$sql);
					$contador_con = @pg_result($rs_conexion,0);
			?>
            <td><div align="center"><span class="Estilo10">&nbsp;			
              <?=$contador_con;?>
            </span></div></td>
			<? } ?>
          </tr>
		  <? } ?>
        </table>
		<? } ?>
		</td>
      </tr>
</table>
</body>
</html>
<? pg_close($conn);?>