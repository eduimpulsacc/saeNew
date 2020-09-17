<?php require('../../util/header.inc');	

$corporacion   =$_CORPORACION;

 //// llenamos los arregloa que vamos a necesitar
// tomar Los datos del nivel seleccionado
$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$id_nivel'";
$result7 =@pg_Exec($conn,$qry7);
for ($i=0; $i < @pg_numrows($result7); $i++){
	 $fila7 = @pg_fetch_array($result7,$i);	
	 $nombre_nivel  = $fila7['nombre'];
	 $id_nivel      = $fila7['id_nivel'];
}


/// tomar nombre las instituciones de la corporacion de tipo de enseñanza 310								
$qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb inner join tipo_ense_inst on corp_instit.rdb = tipo_ense_inst.rdb WHERE corp_instit.num_corp = '".$_CORPORACION."' and tipo_ense_inst.cod_tipo = 310  group by institucion.rdb, institucion.nombre_instit";
$result2 =@pg_Exec($conn,$qry2);
for ($i=0; $i < @pg_numrows($result2); $i++){
	$fila2 = @pg_fetch_array($result2,$i);
	$nombre_institucion_[] = $fila2['nombre_instit'];
	$rdb_[] = $fila2['rdb'];
	
	/// tomar el número número de año seleccionado
	$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
	$result4 =@pg_Exec($conn,$qry4);
	if (pg_numrows($result4)==0){
		$id_ano_[] = 0;
	}else{
		$fila4 = @pg_fetch_array($result4,0);
		$id_ano_[] = $fila4['id_ano'];
	}
	
	/// tomar período
	$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE nombre_periodo = '".$cmbPERIODO."' and id_ano = '$id_ano_[$i]'";
	$result =@pg_Exec($conn,$qry);
	if ($id_ano_[$i]==0){
		$id_periodo_[]  =  0;										
	}else{
		$fila1 = @pg_fetch_array($result,0);
		$id_periodo_[]  = $fila1['id_periodo'];									    	
	}
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
.Estilo10 {color: #0099FF}
#subsectores { width: 400px;
height: 200px;
/*background-color: #366;*/
float: left;
position:relative; 
border: 1px solid #808080; 
overflow: auto; 
top:0px; 
left:0px; 

}
.Estilo11 {font-size: 9px}
.Estilo20 {
	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-size: 9}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo26 {font-size: 9; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }

-->
</style>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr></table>
</div>
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
<tr>
 <td valign="top">
	<table width="650" border="1" cellspacing="0" cellpadding="3">
	   <tr >
		 <td colspan="5" class="tableindex"><div align="center">PROMEDIOS ESTABLECIMIENTOS CIENTIFICO HUMANISTICO POR NIVEL </div></td>
	   </tr>
	   <tr>
		 <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
	   </tr>
	   <tr>
		 <td width="178" class="Estilo10"><strong>Nivel</strong></td>
		 <td width="472" class="Estilo7">&nbsp;
			 <?=$nombre_nivel?></td>
	   </tr>
	   <tr>
		 <td class="Estilo10"><b>Semestre</b></td>
		 <td class="Estilo7">&nbsp;
			 <?=$cmbPERIODO?></td>
	   </tr>
	   <tr>
		 <td class="Estilo10"><b>A&ntilde;o</b></td>
		 <td class="Estilo7">&nbsp;
			 <?=$cmb_ano ?></td>
	   </tr>
	 </table>
   <br>
	 <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
	   <tr>
		 <td>&nbsp;</td>
		 <td align="center" class="Estilo28">Promedios</td>
		 <td>&nbsp;</td>
	   </tr>
	   <tr>
		 <td class="Estilo28">Establecimientos</td>
		 <?
		 if ($id_nivel==7){ ?>
		      <td align="center"><span class="Estilo28"> 1&ordm; E. M. </span></td>	   
		 <? } ?>
		 <?
		 if ($id_nivel==8){ ?>
		      <td align="center"><span class="Estilo28"> 2&ordm; E. M. </span></td>
		 <? } ?>
		 <?
		 if ($id_nivel==9){ ?>		 
		      <td align="center"><span class="Estilo28"> 3&ordm; E. M. </span></td>
		 <? } ?>
		 <?
		 if ($id_nivel==10){ ?>
		      <td align="center"><span class="Estilo28"> 4&ordm; E. M. </span></td>
		 <? } ?>
		 <td align="center"><span class="Estilo28">Prom. Final </span></td>
	   </tr>
	  
	  <!-- ciclo de establecimientos -->	
		  <?
		  for ($i=0; $i < @pg_numrows($result2); $i++){
			  //$rdb_[] = $fila2['rdb'];
			  $suma_promedio = 0;
			  
			  ?>								  
			  <tr>
				<td class="Estilo28"><?=$nombre_institucion_[$i]?></td>		
				<?
				if ($id_nivel==7){ ?>							
						<td align="center" class="Estilo28">&nbsp;
						<?
						$sql_curso1 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$id_ano_[$i]' and ensenanza = '310' and grado_curso = '1'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
						$result_curso1 = @pg_Exec($conn, $sql_curso1);
						$fila_curso1 = @pg_fetch_array($result_curso1,0);
						$cantidad = $fila_curso1['cantidad'];
						$suma     = $fila_curso1['suma'];
						$promedio1 = round($suma / $cantidad);
					 
						if ($promedio1>0){
						   echo $promedio1;
						   $suma_promedio = $suma_promedio + $promedio1;
						   $contador_promedios++;
						}
						
						?></td>
				<? } ?>   
				
				<?
				if ($id_nivel==8){ ?>                                    
						   <td align="center" class="Estilo28">&nbsp;
						   <?
						$sql_curso2 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$id_ano_[$i]' and ensenanza = '310' and grado_curso = '2'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
						$result_curso2 = @pg_Exec($conn, $sql_curso2);
						$fila_curso2 = @pg_fetch_array($result_curso2,0);
						$cantidad = $fila_curso2['cantidad'];
						$suma     = $fila_curso2['suma'];
						$promedio2 = round($suma / $cantidad);
					 
						if ($promedio2>0){
						   echo $promedio2;
						   $suma_promedio = $suma_promedio + $promedio2;
						   $contador_promedios++;
						}
						
						?></td>
			 <? } ?>	
			 
			 <?
				if ($id_nivel==9){ ?>
					   <td align="center" class="Estilo28">&nbsp;
					   <?
					$sql_curso3 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$id_ano_[$i]'  and ensenanza = '310' and grado_curso = '3'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
					$result_curso3 = @pg_Exec($conn, $sql_curso3);
					$fila_curso3 = @pg_fetch_array($result_curso3,0);
					$cantidad = $fila_curso3['cantidad'];
					$suma     = $fila_curso3['suma'];
					$promedio3 = round($suma / $cantidad);
				 
					if ($promedio3>0){
					   echo $promedio3;
					   $suma_promedio = $suma_promedio + $promedio3;
					   $contador_promedios++;
					}
					
					?></td>
			  <? } ?>
			    <?
				if ($id_nivel==10){ ?>	
						   <td align="center" class="Estilo28">&nbsp;
						   <?
						$sql_curso4 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$id_ano_[$i]'  and ensenanza = '310' and grado_curso = '4'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
						$result_curso4 = @pg_Exec($conn, $sql_curso4);
						$fila_curso4 = @pg_fetch_array($result_curso4,0);
						$cantidad = $fila_curso4['cantidad'];
						$suma     = $fila_curso4['suma'];
						$promedio4 = @round($suma / $cantidad);
					 
						if ($promedio4>0){
						   echo $promedio4;
						   $suma_promedio = $suma_promedio + $promedio4;
						   $contador_promedios++;
						}
						
						?></td>
				<? } 
				
				   $prom_establecimiento = @round($suma_promedio / $contador_promedios);
				   ?>
				   <td align="center" class="Estilo28">&nbsp;<?=$prom_establecimiento?></td>
			  </tr>
			  <?
		  } ?>	  
	  <!-- fin ciclo de establecimientos -->  
	  
	   <tr>
		 <td>Promedio Final </td>
		
		 <td align="center">&nbsp;</td>
		
		 <td>&nbsp;</td>
		
	   </tr>
   </table></td>
</tr>
</table>
</body>
</html>
