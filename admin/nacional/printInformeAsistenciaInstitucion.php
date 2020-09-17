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
        <td width="22%" class="textonegrita">CORPORACI&Oacute;N</td>
        <td width="2%" class="textonegrita"><div align="center">:</div></td>
        <td width="76%" class="textosimple"><?=$Nombre_Corp;?></td>
      </tr>
      <tr>
        <td class="textonegrita">FECHA</td>
        <td class="textonegrita"><div align="center">:</div></td>
        <td class="textosimple"><?=date('D-M-Y');?></td>
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
    <td class="textonegrita"><div align="center">LISTADO DE ASISTENCIA POR INSTITUCI&Oacute;N <br /><br />

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
	  
 <? 	$valor = diashabiles($cmb_anoA,$cmb_mesA);
	  	$sql = "SELECT a.nombre_instit,a.rdb FROM institucion a WHERE a.rdb in(select rdb from corp_instit where num_corp='$_CORPORACION')";
		$res = @pg_exec($conn,$sql);
		for($i=0;$i<pg_numrows($res);$i++){
			$fila =@pg_fetch_array($res,$i);
			$sql = "SELECT count(*) FROM matricula WHERE RDB=".$fila['rdb']." AND date_part('month',fecha)<".$cmb_mesA." AND id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila['rdb']." AND nro_ano=".$cmb_anoA." )";
			$res2 = @pg_exec($conn,$sql);
			$Total_M = @pg_result($res2,0);
			
			$sql="SELECT count(*) FROM asistencia WHERE date_part('month',fecha)=".$cmb_mes." AND date_part('year',fecha)=".$cmb_ano." AND id_curso in (SELECT DISTINCT id_curso FROM matricula WHERE
RDB=".$fila['rdb'].")";
			$res3 =@pg_exec($conn,$sql);
			$Total_IN = @pg_result($res3,0);
			if(!isset($Total_IN)) $Total_IN=0;
			
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
			<td class="datosB"><div align="left"><?=$fila['nombre_instit'];?></div></td>
			<td class="datosB"><div align="right"><? echo number_format($Total_M,'0',',','.');?></div></td>
			<td class="datosB"><div align="right"><?=$Total_ASI;?></div></td>
			<td class="datosB"><div align="right"><? echo $Total_IN;?></div></td>
			<td class="datosB"><div align="right"><?=$Porc;?></div></td>
			</tr>
			<? 
			if($i==27){
				echo "<H1 class=SaltoDePagina></H1>";?>
				<tr>
					<td class="tablatit2-1"><div align="center">Instituci&oacute;n</div></td>
					<td class="tablatit2-1"><div align="center">Matriculados</div></td>
					<td class="tablatit2-1"><div align="center">Asistencia</div></td>
					<td class="tablatit2-1"><div align="center">Inasistencia</div></td>
					<td class="tablatit2-1"><div align="center">%</div></td>
				  </tr>
			<? }
			} ?>
      
    </table></td>
  </tr>
</table>
</body>
</html>
