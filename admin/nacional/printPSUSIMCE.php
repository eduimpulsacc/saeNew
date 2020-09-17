<?php require('../../util/header.inc');

$corporacion   =$_CORPORACION;

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
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
-->
</style>
</head>
<script>

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<body>

<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
  	<td>
	<div id="capa0">
  <table width="100%" border="0">
  <tr>
	<td class="Estilo4" align="left"><input name="cerrar" type="button" class="botonXX" onClick="window.close();" value="CERRAR" /></td>
	<td class="Estilo4" align="right"><input name="imprimir" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR" /></td>
  </tr>
  </table>
  </div>
  </td>
  </tr>
  <br />
  <tr>
    <td>
	<? if($caso==1){
		$sql ="SELECT nombre_instit, rdb FROM institucion a INNER JOIN ano_escolar b ON a.rdb=b.id_institucion WHERE rdb in ";
		$sql.=" (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_SP."";
		$rs_instit = @pg_exec($conn,$sql);
		
		$sql = "SELECT distinct a.cod_subsector,b.nombre  FROM simce_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
		$sql.="INNER JOIN ano_escolar c ON a.id_ano=c.id_ano WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") ";
		$sql.="AND nro_ano=".$cmbANO_SP;
		$rs_subsector = @pg_exec($conn,$sql);
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tableindex" align="center">RESULTADO PRUEBA SIMCE DE TODOS LOS ESTABLECIMIENTOS
          <?=$cmbSUBSECTOR;?></td>
      </tr>
      <tr>
        <td align="center" class="Estilo25">A&Ntilde;O&nbsp;
            <?=$cmbANO_SP;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
            <tr>
              <td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
              <td colspan="<?=pg_numrows($rs_subsector);?>" align="center" class="tableindex">SUBSECTOR</td>
              <td rowspan="2" class="tableindex">RESULTADO<br />
                PUNTAJE</td>
            </tr>
            <tr>
              <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){
					$fila_sub = @pg_fetch_array($rs_subsector,$x);
			  ?>
              <td class="tableindex"><? InicialesSubsector($fila_sub['nombre']);?></td>
              <? } ?>
            </tr>
            <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
					       ?>
            <tr>
              <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
              <? 	$prom_inst=0;
								$cont_sub=0;
						  		for($x=0;$x<@pg_numrows($rs_subsector);$x++){
								$fila_sub = @pg_fetch_array($rs_subsector,$x);
								
								$sql ="SELECT avg(nota) FROM simce_notas_2009 WHERE id_ano in (SELECT id_ano FROM ano_Escolar WHERE "; 
								$sql.="id_institucion=".$fila_instit['rdb']."";
								$sql.=" AND nro_ano=".$cmbANO_SP.") AND id_sub_sim in (SELECT id_sub_sim FROM simce_conf_2009 WHERE ";
								$sql.=" cod_subsector=".$fila_sub['cod_subsector'].")";
								$rs_puntaje = @pg_exec($conn,$sql);	
								$puntaje = @pg_result($rs_puntaje,0);
						  ?>
              <td class="Estilo25"><?=intval($puntaje);?></td>
              <? 		$prom_inst += $puntaje;
								$prom_sub[$x] +=$puntaje;
								$valor[$x] = $puntaje;
								if($valor[$x] !=""){
								 	$cont_sub[$x]=$cont_sub[$x] + 1;
								}
									
						} 
						?>
              <td class="Estilo25"><?=round($prom_inst / @pg_numrows($rs_subsector));?></td>
            </tr>
            <? } ?>
            <tr>
              <td class="tableindex">RESULTADO PUNTAJE </td>
              <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){?>
              <td class="tableindex"><?=intval($prom_sub[$x]);?></td>
              <? } ?>
              <td class="tableindex">&nbsp;</td>
            </tr>
          </table>
            <br />
            </td>
      </tr>
    </table>
	<? }?>
	</td>
  </tr>
  <tr>
    <td>
	<? if($caso==2){
			$sql =" SELECT nombre_instit, rdb, id_ano FROM institucion a INNER JOIN ano_escolar b ON a.rdb=b.id_institucion WHERE rdb in ";
			$sql.=" (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_SP;
			$rs_instit = @pg_exec($conn,$sql);
				
			$sql = "SELECT distinct a.cod_subsector,b.nombre FROM psu_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
			$sql.= "INNER JOIN ano_escolar c ON a.cod_ano=c.id_ano WHERE c.id_institucion in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") ";
			$sql.= " AND nro_ano=".$cmbANO_SP;
			$rs_subsector = @pg_exec($conn,$sql);
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tableindex" align="center">RESULTADO PRUEBA PSU DE TODOS LOS ESTABLECIMIENTOS</td>
      </tr>
      <tr>
        <td align="center" class="Estilo25">A&Ntilde;O&nbsp;
            <?=$cmbANO_SP;?></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
            <tr>
              <td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
              <td colspan="<?=pg_numrows($rs_subsector);?>" align="center" class="tableindex">SUBSECTOR</td>
              <td rowspan="2" class="tableindex">RESULTADO<br />
                PUNTAJE</td>
            </tr>
            <tr>
              <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){
								$fila_sub = @pg_fetch_array($rs_subsector,$x);
						?>
              <td class="tableindex"><? InicialesSubsector($fila_sub['nombre']);?></td>
              <? } ?>
            </tr>
            <? 	for($i=0;$i<@pg_numrows($rs_instit);$i++){
						   		$fila_instit = @pg_fetch_array($rs_instit,$i);
								
								
					   ?>
            <tr>
              <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
              <? $puntaje_inst=0;
				  for($x=0;$x<@pg_numrows($rs_subsector);$x++){
						$fila_sub = @pg_fetch_array($rs_subsector,$x);
						
						$sql =" SELECT avg(puntaje) FROM psu_notas_2009 WHERE cod_ano in (SELECT id_ano FROM ano_Escolar WHERE ";
						$sql.=" id_institucion=".$fila_instit['rdb']." AND nro_ano=".$cmbANO_SP.") AND cod_sub_psu in (SELECT cod_sub_psu ";
						$sql.=" FROM psu_conf_2009 WHERE cod_subsector=".$fila_sub['cod_subsector'].") 	";
						$rs_puntaje = @pg_exec($conn,$sql);
						$puntaje = @pg_result($rs_puntaje,0);
			  ?>
              <td class="Estilo25"><?=round($puntaje,1);?></td>
              <? 
				  	$puntaje_inst += $puntaje;
					$puntaje_sub[$x] +=$puntaje;
			  } ?>
              <td class="Estilo25"><?=round($puntaje_inst,1);?></td>
            </tr>
            <? } ?>
            <tr>
              <td class="tableindex">RESULTADO PUNTAJE </td>
              <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){
							$fila_sub = @pg_fetch_array($rs_subsector,$x);
						?>
              <td class="tableindex"><?=round($puntaje_sub[$x],1);?></td>
              <? } ?>
              <td class="tableindex">&nbsp;</td>
            </tr>
          </table>
            <br />
           </td>
      </tr>
    </table>
	<? } ?>
	</td>
  </tr>
  <tr>
    <td>
	<? if($caso==3){
			$sql ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion." AND ";
			$sql.="rdb in (SELECT id_institucion FROM ano_escolar WHERE nro_ano=".$cmbANO_SP."))";
			$rs_instit = @pg_exec($conn,$sql);
			
			$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
			$rs_sub = @pg_exec($conn,$sql);
			$nombre_sub = @pg_result($rs_sub,0);
			
			$sql =" SELECT DISTINCT id_curso FROM simce_notas_2009 WHERE id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion in ";
			$sql.="(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")) AND id_sub_sim IN (SELECT id_sub_sim FROM simce_conf_2009 ";
			$sql.=" WHERE cod_subsector=".$cmbSUBSECTOR.")";
			$rs_curso = @pg_exec($conn,$sql);			
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA SIMCE DE TODOS LOS ESTABLECIMIENTOS</td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
      </tr>
      <tr>
        <td width="18%" class="Estilo25">SUBSECTOR</td>
        <td width="82%" class="Estilo25"><?=$nombre_sub;?></td>
      </tr>
      <tr>
        <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
        <td><span class="Estilo25">
          <?=$cmbANO_SP;?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
            <tr>
              <td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
              <td colspan="<?=@pg_numrows($rs_curso);?>" align="center"class="tableindex">CURSOS</td>
              <td rowspan="2" class="tableindex">RESULTADO<br />
                PUNTAJE</td>
            </tr>
            <tr>
              <? for($x=0;$x<@pg_numrows($rs_curso);$x++){
					$fila_curso = @pg_fetch_array($rs_curso,$x);
			  ?>
              <td class="tableindex"><? echo CursoPalabra($fila_curso['id_curso'],2,$conn);?></td>
              <? } ?>
            </tr>
            <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
				$fila_instit = @pg_fetch_array($rs_instit,$i);
				$prom_inst=0;
		   ?>
            <tr>
              <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
              <? for($x=0;$x<@pg_numrows($rs_curso);$x++){
					$fila_curso = @pg_fetch_array($rs_curso,$x);
					
					$sql ="SELECT avg(nota) FROM simce_notas_2009 a INNER JOIN simce_conf_2009 b ON (a.id_ano=b.id_ano) WHERE rdb=".$fila_instit['rdb']."";
					$sql.="  AND b.id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." AND nro_ano=".$cmbANO_SP.") ";
					$sql.=" AND cod_subsector=".$cmbSUBSECTOR." AND id_curso=".$fila_curso['id_curso'];
					$rs_nota =@pg_exec($conn,$sql);
			  ?>
              <td class="Estilo25"><?=round(pg_result($rs_nota,0));?></td>
              <? 	$prom_inst += round(pg_result($rs_nota,0));
			  		$prom_curso[$x] +=round(pg_result($rs_nota,0));
			  	} ?>
              <td class="Estilo25"><?=$prom_inst;?></td>
            </tr>
            <? } ?>
            <tr>
              <td class="tableindex">RESULTADO PUNTAJE </td>
              <? for($x=0;$x<@pg_numrows($rs_curso);$x++){?>
              <td class="tableindex"><?=$prom_curso[$x];?></td>
              <? } ?>
              <td class="tableindex">&nbsp;</td>
            </tr>
          </table>
            <br />
            </td>
      </tr>
    </table>
	<? } ?>
	</td>
  </tr>
  <tr>
    <td>
	<? if($caso==4){
			$sql = "SELECT nombre_instit, a.rdb, c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON ";
			$sql.= " a.rdb=c.id_institucion AND b.rdb=c.id_institucion WHERE num_corp=".$corporacion." AND nro_ano=".$cmbANO_SP; 
			$rs_instit = @pg_exec($conn,$sql);
			
			
			$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
			$rs_sub = @pg_exec($conn,$sql);
			$nombre_sub = @pg_result($rs_sub,0);
			
			$sql = "SELECT DISTINCT curso, id_ano FROM psu_promedios_2009 WHERE id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion in ";
			$sql.= "(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_SP.") AND id_subsector=".$cmbSUBSECTOR;
			$rs_curso = @pg_exec($conn,$sql);	
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA PSU DE TODOS LOS ESTABLECIMIENTOS </td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
      </tr>
      <tr>
        <td width="18%" class="Estilo25">SUBSECTOR</td>
        <td width="82%" class="Estilo25"><?=$cmbSUBSECTOR."-->".$nombre_sub;?></td>
      </tr>
      <tr>
        <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
        <td><span class="Estilo25">
          <?=$cmbANO_SP;?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
            <tr>
              <td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
              <td colspan="<?=@pg_numrows($rs_curso);?>" align="center"class="tableindex">4TOS MEDIOS </td>
              <td rowspan="2" class="tableindex">RESULTADO<br />
                PUNTAJE</td>
            </tr>
            <tr>
              <? for($x=0;$x<@pg_numrows($rs_curso);$x++){
							$fila_curso = @pg_fetch_array($rs_curso,$x);
							
					?>
              <td class="tableindex"><? echo CursoPalabra($fila_curso['curso'],3,$conn)."---".$fila_curso['curso'];?></td>
              <? } ?>
            </tr>
            <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
								$prom_inst=0;
					       ?>
            <tr>
              <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
              <? for($x=0;$x<@pg_numrows($rs_curso);$x++){
							$fila_curso = @pg_fetch_array($rs_curso,$x);
							$promedio =0;
							
							
							$sql ="SELECT avg(puntaje) FROM psu_promedios_2009 WHERE curso=".$fila_curso['curso']." AND id_ano=".$fila_instit['id_ano'];
							$rs_promedio =@pg_exec($conn,$sql);
							$promedio = @pg_result($rs_promedio,0);
							
						?>
              <td class="Estilo25"><?=round($promedio);?></td>
              <? 	$prom_inst +=$promedio; 
					   		} ?>
              <td class="Estilo25"><?=round($prom_inst);?></td>
            </tr>
            <? } ?>
            <tr>
              <td class="tableindex">RESULTADO PUNTAJE </td>
              <? for($x=0;$x<@pg_numrows($rs_curso);$x++){
							$fila_curso = @pg_fetch_array($rs_curso,$x);
						?>
              <td class="tableindex">&nbsp;</td>
              <? } ?>
              <td class="tableindex">&nbsp;</td>
            </tr>
          </table>
            <br />
           </td>
      </tr>
    </table>
	<? } ?>
	</td>
  </tr>
  <tr>
    <td>
	<? if($caso==5){
		$sql = "SELECT nombre_instit, a.rdb, c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON ";
		$sql.= " a.rdb=c.id_institucion AND b.rdb=c.id_institucion WHERE num_corp=".$corporacion." AND nro_ano=".$cmbANO_SP; 
		$rs_instit = @pg_exec($conn,$sql);
		
		$sql = "SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
		$rs_nivel = @pg_exec($conn,$sql);
		$nombre_nivel = @pg_result($rs_nivel,0);
		
		$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
		$rs_sub = @pg_exec($conn,$sql);
		$nombre_sub = @pg_result($rs_sub,0);
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA SIMCE DE TODOS LOS ESTABLECIMIENTOS </td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
      </tr>
      <tr>
        <td class="Estilo25">NIVEL</td>
        <td class="Estilo25"><?=$nombre_nivel;?></td>
      </tr>
      <tr>
        <td width="18%" class="Estilo25">SUBSECTOR</td>
        <td width="82%" class="Estilo25"><?=$nombre_sub;?></td>
      </tr>
      <tr>
        <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
        <td><span class="Estilo25">
          <?=$cmbANO_SP;?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
            <tr>
              <td class="tableindex">ESTABLECIMIENTO</td>
              <td align="center"class="tableindex">PROMEDIO FINAL </td>
              <td class="tableindex">PUNTAJE SIMCE </td>
            </tr>
            <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
								$sql =" SELECT avg(puntaje) FROM simce_inst_2009 WHERE id_ano=".$fila_instit['id_ano']." AND id_curso in ";
								$sql.=" (SELECT id_curso FROM curso WHERE id_nivel=".$cmbNIVEL." AND id_ano=".$fila_instit['id_ano'].")";
								$rs_puntaje = @pg_exec($conn,$sql);
								$puntaje = @pg_result($rs_puntaje,0);
								
								$sql =" SELECT avg(puntaje_final) FROM simce_final_2009 WHERE id_ano=".$fila_instit['id_ano']." AND id_curso in ";
								$sql.=" (SELECT id_curso FROM curso WHERE id_nivel=".$cmbNIVEL." AND id_ano=".$fila_instit['id_ano'].")";
								$rs_promedio = @pg_exec($conn,$sql);
								$promedio = @pg_result($rs_promedio,0);
					       ?>
            <tr>
              <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
              <td class="Estilo25"><?=round($promedio);?></td>
              <td class="Estilo25"><?=round($puntaje);?></td>
            </tr>
            <? 	$promedio_inst +=$promedio;
							$puntaje_inst +=$puntaje;
						
							} ?>
            <tr>
              <td class="tableindex">PROMEDIO</td>
              <td class="tableindex"><?=round($promedio_inst);?></td>
              <td class="tableindex"><?=round($puntaje_inst);?></td>
            </tr>
          </table>
            <br />
            </td>
      </tr>
    </table>
	<? } ?>
	</td>
  </tr>
  <tr>
    <td>
	<? if($caso==6){
			$sql = "SELECT nombre_instit, a.rdb, c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON ";
			$sql.= " a.rdb=c.id_institucion AND b.rdb=c.id_institucion WHERE num_corp=".$corporacion." AND nro_ano=".$cmbANO_SP; 
			$rs_instit = @pg_exec($conn,$sql);
			
			$sql = "SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
			$rs_nivel = @pg_exec($conn,$sql);
			$nombre_nivel = @pg_result($rs_nivel,0);
			
			$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
			$rs_sub = @pg_exec($conn,$sql);
			$nombre_sub = @pg_result($rs_sub,0);
	?>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA PSU DE TODOS LOS ESTABLECIMIENTOS </td>
      </tr>
      <tr>
        <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
      </tr>
      <tr>
        <td class="Estilo25">NIVEL</td>
        <td class="Estilo25"><?=$nombre_nivel;?></td>
      </tr>
      <tr>
        <td width="18%" class="Estilo25">SUBSECTOR</td>
        <td width="82%" class="Estilo25"><?=$nombre_sub;?></td>
      </tr>
      <tr>
        <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
        <td><span class="Estilo25">
          <?=$cmbANO_SP;?>
        </span></td>
      </tr>
      <tr>
        <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
            <tr>
              <td class="tableindex">ESTABLECIMIENTO</td>
              <td align="center"class="tableindex">PROMEDIO FINAL </td>
              <td class="tableindex">PUNTAJE PSU </td>
            </tr>
            <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
								
								$sql ="SELECT avg(puntaje) FROM psu_promedios_2009 WHERE id_ano=547 AND curso IN (SELECT id_curso FROM curso ";
								echo $sql.="WHERE id_nivel=".$cmbNIVEL." AND id_ano=".$fila_instit['id_ano'].") AND id_subsector=".$cmbSUBSECTOR;
								$rs_promedio = @pg_exec($conn,$sql);
								$promedio = @pg_result($rs_promedio,0);
								
								$sql ="SELECT avg(puntaje) FROM psu_notas_2009 WHERE cod_ano=".$fila_instit['id_ano']." AND cod_sub_psu in ";
								$sql.="(SELECT cod_sub_psu FROM psu_conf_2009 WHERE cod_ano=".$fila_instit['id_ano']." AND cod_subsector=".$cmbSUBECTOR.")";
								$rs_puntaje = @pg_exec($conn,$sql);
								$puntaje = @pg_result($rs_puntaje,0);
								
								

					       ?>
            <tr>
              <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
              <td class="Estilo25"><?=round($promedio);?></td>
              <td class="Estilo25"><?=round($puntaje);?></td>
            </tr>
            <? 	$promedio_inst +=$promedio;
							$puntaje_inst +=$puntaje;
							} ?>
            <tr>
              <td class="tableindex">PROMEDIO</td>
              <td class="tableindex"><?=$promedio_inst;?></td>
              <td class="tableindex"><?=$puntaje_inst;?></td>
            </tr>
          </table>
            <br />
            </td>
      </tr>
    </table>
	<? } ?>
	</td>
  </tr>
</table>

</body>
</html>
