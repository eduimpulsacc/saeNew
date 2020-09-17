<?php require('../../util/header.inc');

function diashabiles($ano,$mes){

	if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia=31;
	}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
		$dia=30;
	}else{
		$dia=28;
	}
	
	for($i=1;$i<=$dia;$i++){
		$semana=date("l",mktime(0,0,0,$mes,$i,$ano));
		if($semana=="Sunday" OR $semana=="Saturday"){
			$cuentanohabil++;
		}
	}
	$diashabiles = $dia - $cuentanohabil;
	return($diashabiles);
}

$sql =  "SELECT nombre_corp FROM corporacion WHERE num_corp=".$_CORPORACION;
$res_corp = @pg_exec($conn,$sql);
$Nombre_Corp = @pg_result($res_corp,0);

$sql ="SELECT nombre_tipo FROM tipo_ensenanza WHERE cod_tipo=".$cmb_plan."";
$res_plan = @pg_exec($conn,$sql);
$Nombre_Plan = @pg_result($res_plan,0);




?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>:::::...COLEGIO INTERACTIVO.....:::::::</title>
<link href="estilos.css" rel="stylesheet" type="text/css" />
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always; height:0;line-height:0
 }
 
</style>
</head>

<body>
<div id="capa0">
<table width="650" border="0" align="center">
  <tr>
    <td><input name="Submit" type="submit" class="boton02" value="CANCELAR" onClick="window.close()" /></td>
    <td><div align="right"><input name="Submit2" type="button" class="boton02" value="IMPRIMIR" onClick="imprimir();"/>
    </div></td>
  </tr>
</table>
</div>
<br />
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="20%" class="textonegrita">CORPORACI&Oacute;N</td>
        <td width="2%" class="textonegrita"><div align="center">:</div></td>
        <td width="78%" class="textosimple"><?=$Nombre_Corp;?></td>
      </tr>
      <tr>
        <td class="textonegrita">FECHA</td>
        <td class="textonegrita"><div align="center">:</div></td>
        <td class="textosimple"><?=date('D-M-Y');?></td>
      </tr>
      <tr>
        <td class="textonegrita">TIPO DE ENSE&Ntilde;ANZA  </td>
        <td class="textonegrita"><div align="center">:</div></td>
        <td class="textosimple"><?=$Nombre_Plan;?></td>
      </tr>
      <tr>
        <td class="textonegrita">TOTAL DIAS HABILES </td>
        <td class="textonegrita"><div align="center">:</div></td>
        <td class="textosimple"><? echo $valor=diashabiles($cmb_mesI,$cmb_anoI);?></td>
      </tr>

    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita"><div align="center">LISTADO DE ASISTENCIA POR TIPO DE ENSE&Ntilde;ANZA <br />
        <br />

    </div></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td class="tablatit2-1"><div align="center">Instituci&oacute;n</div></td>
        <td class="tablatit2-1"><div align="center">Matriculados</div></td>
        <td class="tablatit2-1"><div align="center">Asistencia</div></td>
        <td class="tablatit2-1"><div align="center">Inasistencia</div></td>
        <td class="tablatit2-1"><div align="center">%</div></td>
      </tr>
	  
	  <? 	$sql = "SELECT rdb, nombre_instit FROM institucion WHERE rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$_CORPORACION." AND rdb in(SELECT rdb FROM tipo_ense_inst WHERE cod_tipo=".$cmb_plan."))";
			$res2 = @pg_Exec($conn,$sql);
			  for($i=0;$i<@pg_numrows($res2);$i++){
				$fila_inst = @pg_fetch_array($res2,$i);
				$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb'];
				$res_ano = @pg_exec($conn,$sql);
				$Ano_Esc = @pg_result($res_ano,0);
				
				$sql = "SELECT count(*) FROM matricula WHERE rdb=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$cmb_mesP." AND id_ano=".$Ano_Esc;
				$res_mat = @pg_exec($conn,$sql);
				$Total_M = @pg_result($res_mat,0);
				
				$sql = "SELECT count(*) FROM asistencia a where date_part('year',fecha)=".$cmb_anoP." AND date_part('month',fecha)=".$cmb_mesP." AND a.ano in(SELECT id_ano FROM ano_escolar WHERE id_institucion IN (SELECT rdb FROM tipo_ense_inst WHERE cod_tipo=".$cmb_plan." AND rdb=".$fila_inst['rdb']."))";
				$res_ina = @pg_exec($conn,$sql);
				$Total_INA = @pg_result($res_ina,0);
				if(!isset($Total_INA)) $Total_INA="&nbsp;";
				
				$sql = "SELECT count(*) FROM feriado WHERE id_periodo IN(
			select id_periodo from periodo where id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmb_anoP.") and (date_part('month',fecha_inicio)<=".$cmb_mesP." AND date_part('month',fecha_termino)>=".$cmb_mesP.")) AND id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." and nro_ano=".$cmb_anoP.")";
				$res_fer = @pg_exec($conn,$sql);
				$Feriado = @pg_result($res_fer,0);
				$Total_ASI = $Total_M * ($valor - $Feriado);
				if($Total_ASI!=0){
					$Porc = substr(100-((($Total_INA *100)/$Total_ASI)),0,5);
				}else{
					$Porc = "&nbsp;";
				}
				
				
			?>
				  <tr>
					<td class="textosimple"><? echo $fila_inst['nombre_instit'];?></td>
					<td class="textosimple"><div align="center"><?=$Total_M;?></div></td>
					<td class="textosimple"><div align="center"><?=$Total_ASI;?></div></td>
					<td class="textosimple"><div align="center"><?=$Total_INA;?></div></td>
					<td class="textosimple"><div align="center"><?=$Porc;?></div></td>
				  </tr>
				  
		<? } ?>
      
    </table></td>
  </tr>
</table>
</body>
</html>
