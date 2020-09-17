<?php require('../../util/header.inc');

$corporacion = $_CORPORACION;
$empleado = $_EMPLEADO;

$sql = "SELECT nombre_corp FROM corporacion WHERE num_corp=".$corporacion;
$rs_corp = @pg_exec($conn,$sql);
$nombre_corp = @pg_result($rs_corp,0);

$sql ="SELECT a.nombre_emp || cast(' ' as varchar) || a.ape_pat || cast(' ' as varchar) || a.ape_mat as nombre FROM empleado a WHERE rut_emp=".$empleado;
$rs_emp = @pg_exec($conn,$sql);
$nombre_emp = @pg_result($rs_emp,0);


function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo5 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; font-weight: bold; }
.Estilo6 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 16px;
	font-weight: bold;
}
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo11 {font-size: 10px}
-->
</style>
</head>

<body>
<table width="100%" border="0" cellpadding="3">
  <tr>
    <td width="155"><span class="Estilo5">Corporacion</span></td>
    <td width="8"><span class="Estilo5">:</span></td>
    <td width="465" ><span class="Estilo9">
      <?=$nombre_corp;?>
    </span></td>
  </tr>
  <tr>
    <td><span class="Estilo5">Sostenedor</span></td>
    <td><span class="Estilo5">:</span></td>
    <td><span class="Estilo9"><?=$nombre_emp;?></span></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><div align="center"><span class="Estilo6">INFORME DE CALIFICACIONES </span></div></td>
  </tr>
</table>
<br />
<table width="100%" border="1"  cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="2" class="Estilo9"><div align="center">INSTITUCION</div></td>
    <td colspan="2" class="Estilo9"><div align="center">CURSO / ASIGNATURA </div></td>
  </tr>
  <tr>
    <td colspan="2" class="Estilo9" valign="top">
			<table width="100%" border="1"  cellpadding="0" cellspacing="0">
			<tr>
		<? 	$sql = "SELECT DISTINCT a.cod_tipo, b.nombre_tipo FROM tipo_ense_inst a INNER JOIN tipo_ensenanza b ON ";
			$sql.="a.cod_tipo=b.cod_tipo WHERE  a.rdb IN (select RDB from corp_instIT WHERE num_corp=$_CORPORACION) AND a.cod_tipo<>10 ";
			if($cmbINST!=0){
				$sql.=" AND a.rdb=".$cmbINST;
			}
			if($cmbENSENANZA!=0){
				$sql.= " AND a.cod_tipo=".$cmbENSENANZA;
			}
			$rs_ensenanza = @pg_exec($conn,$sql);
			
			for($a=0; $a<@pg_numrows($rs_ensenanza); $a++){
				$fila_ense = @pg_fetch_array($rs_ensenanza,$a);	?>	
			<td width="25%" align="center">Tipo Enseñanza <?=$fila_ense['cod_tipo'];?></td>
		   <? } ?>
		   </tr>
   		   <tr>
		   <? for($a=0; $a<@pg_numrows($rs_ensenanza); $a++){
				$fila_ense = @pg_fetch_array($rs_ensenanza,$a);	?>	
		   	<td valign="top">
			<table width="100%" border="1" cellpadding="0" cellspacing="0">
			  <tr>
			  <? for($i=1; $i<13; $i++){
					$st ="grado".$i;
					$st = $$st;
					if($st==$i){ 
					for($d=1; $d<=$contSubsector; $d++){
						$subsector = ${"cod_subsector".$d};
						$colspan=0;
						if($subsector!=""){
							$sql ="select nombre from subsector where cod_subsector in(select cod_subsector FROM ramo WHERE cod_subsector=".$subsector." AND id_curso IN (SELECT id_curso FROM curso WHERE grado_curso=".$st." AND ensenanza=".$fila_ense['cod_tipo']."))";
								$rs_subsector = @pg_exec($conn,$sql);
								if(@pg_numrows($rs_subsector)>0){
									$colspan++;
								}
						}
					}?>
					<td colspan="<?=$colspan;?>" class="Estilo9" align="center">Grado <?=$st;?>º</td>
				  <? }?>
			<? 	} ?>
			</tr>
			<tr>
				<? for($i=1; $i<13; $i++){
					$st ="grado".$i;
					$st = $$st;
					if($st==$i){
						for($d=1; $d<=$contSubsector; $d++){
							$subsector = ${"cod_subsector".$d};
							
								$sql ="select nombre from subsector where cod_subsector in(select cod_subsector FROM ramo WHERE cod_subsector=".$subsector." AND id_curso IN (SELECT id_curso FROM curso WHERE grado_curso=".$st." AND ensenanza=".$fila_ense['cod_tipo']."))";
								$rs_subsector = @pg_exec($conn,$sql);
								$nombre_sub = @pg_result($rs_subsector,0);
								if($subsector!=""){?>			
					<td class="Estilo9" align="center"><? InicialesSubsector($nombre_sub);?></td>
				 		 <? }
				 		 }
				 	 }?>
			<? 	} ?>
			</tr>
			</table>
			</td>
		   <? } ?>
		   </tr>
		   
		</table>
	</td>
  </tr>
  <? 	$sql = "SELECT institucion.rdb, nombre_instit FROM institucion INNER JOIN corp_instit ON institucion.rdb=corp_instit.rdb WHERE corp_instit.num_corp=".$corporacion." ";
  		if($cmbINST!=0){
			$sql.=" AND institucion.rdb=".$cmbINST."";
		}
		$rs_instit = @pg_exec($conn,$sql);
	for($i=0; $i<@pg_numrows($rs_instit); $i++){
		$fila_inst = @pg_fetch_array($rs_instit,$i);
  ?>		
  <tr>
    <td><span class="Estilo9">
      <?=$fila_inst['nombre_instit'];?>
    </span></td>
    <td colspan="2"><span class="Estilo11">70</span></td>
  </tr>
  <? } ?>
</table>
</body>
</html>
