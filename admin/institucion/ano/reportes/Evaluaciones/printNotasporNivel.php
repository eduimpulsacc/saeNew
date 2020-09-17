<?
require('../../../../../util/header.inc'); 
//setlocale("LC_ALL","es_ES");
$institucion	= $_INSTIT;
$ano			= $_ANO;
/// tomar nombre de la institucion
$qry2="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result2 =@pg_Exec($conn,$qry2);
$fila2 = @pg_fetch_array($result2,0);
$nombre_institucion = $fila2['nombre_instit'];

	
/// tomar período
$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) and id_periodo = '$cmbPERIODO'";
$result =@pg_Exec($conn,$qry);
$fila1 = @pg_fetch_array($result,0);
$nombre_periodo = $fila1['nombre_periodo'];

/// tomar el número de año
$qry4="SELECT nro_ano FROM ano_escolar WHERE id_ano = '$ano'";
$result4 =@pg_Exec($conn,$qry4);
$fila4 = @pg_fetch_array($result4,0);
$nro_ano = $fila4['nro_ano'];

	
/// tomar todos los subsectores de los cursos al que pertenece este nivel
$qry6 = "select ramo.cod_subsector, subsector.nombre from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from nivel_curso where id_nivel = '$cmbNIVEL' and id_ano = '$ano') group by ramo.cod_subsector, subsector.nombre order by subsector.nombre";
$result6 =@pg_Exec($conn,$qry6);
for ($i=0; $i < @pg_numrows($result6); $i++){
     $fila6 = @pg_fetch_array($result6,$i);	
     $nombre_subsector_[]   = $fila6['nombre'];
	 $cod_subsector_[]      = $fila6['cod_subsector'];
}	

// tomar Los datos del nivel seleccionado
$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$cmbNIVEL'";
$result7 =@pg_Exec($conn,$qry7);
for ($i=0; $i < @pg_numrows($result7); $i++){
     $fila7 = @pg_fetch_array($result7,$i);	
     $nombre_nivel  = $fila7['nombre'];
	 $id_nivel      = $fila7['id_nivel'];
}	


// cursos por nivel
$qry9 = "select id_curso, ensenanza, grado_curso, letra_curso from curso where id_curso in (select id_curso from nivel_curso where id_nivel = '$cmbNIVEL' and id_ano = '$ano') order by ensenanza, grado_curso, letra_curso";
$result9 =@pg_Exec($conn,$qry9);
for ($i=0; $i < @pg_numrows($result9); $i++){
     $fila9 = @pg_fetch_array($result9,$i);	
     $id_curso_[]      = $fila9['id_curso'];
	 $ensenanza_[]     = $fila9['ensenanza'];
	 $grado_curso_[]   = $fila9['grado_curso'];
	 $letra_curso_[]   = $fila9['letra_curso'];
	 
	 if ($ensenanza_[$i]=="110"){
	     $tipo_pal_[] = "E.Bas.";		 
	 }else{
	     if ($ensenanza_[$i]=="310"){
	         $tipo_pal_[] = "E.Med.";		 
	     }else{
		     $tipo_pal_[] = $ensenanza_[$i];
		 }
	 }	     
	 
}	



	
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {
	font-size: 14px;
	font-weight: bold;
}
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo10 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
</style>
</head>
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
<body>
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

	<table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>

	<table width="650" border="1" cellspacing="0" cellpadding="3">
      <tr >
        <td colspan="5" class="tableindex">
          <div align="center">NOTAS POR NIVEL</div></td>
      </tr>
      <tr>
        <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="178" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td width="472" class="Estilo7">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      <tr>
        <td class="Estilo10">Nivel</td>
        <td class="Estilo7">&nbsp;<?=$nombre_nivel?></td>
      </tr>
      <tr>
        <td class="Estilo10">Per&iacute;odo</td>
        <td class="Estilo7">&nbsp;<?=ucwords(strtolower($nombre_periodo));?></td>
      </tr>
      <tr>
        <td class="Estilo10">A&ntilde;o</td>
        <td class="Estilo7">&nbsp;<?=$nro_ano ?></td>
      </tr>
      <tr>
        <td class="Estilo10">&nbsp;</td>
        <td class="Estilo7">&nbsp;</td>
      </tr>
    </table>
<br>
<table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
  <tr>
    <td>&nbsp;</td>
    <td colspan="<?=@pg_numrows($result9)?>" align="center">Promedio Cursos </td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Subsector</td>
	<?
	for ($i=0; $i < @pg_numrows($result9); $i++){ 
	    $prom_curso_[$i]   = 0;
		$contador_curso_[$i] = 0;
	    ?>
		<td align="center"><?=$grado_curso_[$i]?>-<?=$letra_curso_[$i]?> <?=$tipo_pal_[$i]?></td>		
   <? } ?>		
    <td>Promedio Final </td>
  </tr>
  <?
  
  for ($i=0; $i < @pg_numrows($result6); $i++){ ?>
  <tr>
    <td><strong><?=$nombre_subsector_[$i]?></strong></td>
    
	<?
	for ($j=0; $j < @pg_numrows($result9); $j++){
	      $qry8 = "select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_curso = '$id_curso_[$j]'  and cod_subsector = '$cod_subsector_[$i]') and id_periodo = '$cmbPERIODO' and promedio > 0";
		
		  $result8 = @pg_Exec($conn, $qry8);
		  $fila8 = @pg_fetch_array($result8,0);
		  $cantidad = $fila8['cantidad'];
		  $suma     = $fila8['suma'];
		  $promedio = round($suma / $cantidad);		  
		  
	    ?>
		<td align="center">&nbsp;<? if ($promedio>0){ 
		     
			 /*
			 echo "<br><br>consulta: ".$qry8;
			 echo "<br>p: ".$promedio;
		     */
		
		?><?=$promedio?><? } ?></td>		
   <?
		if ($promedio>0){
		     $suma_promedio = $suma_promedio + $promedio;
		     $contador_promedios++;
		     $prom_curso_[$j] = $prom_curso_[$j] + $promedio;	
		     $contador_curso_[$j]++;			    
	    }	   
	    $promedio=0; 

   
   
    } ?>	
   
	 <td align="center">&nbsp;<? if (round($suma_promedio/$contador_promedios)>0){ ?><? echo round($suma_promedio/$contador_promedios)?><? } ?></td>
  </tr>
  <? 
     $contador_promedios=0;
	 $suma_promedio = 0;
  
 } ?>
  
  <tr>
    <td>Promedio Final </td>
    
	<?
	for ($i=0; $i < @pg_numrows($result9); $i++){  ?>
		<td><div align="center"><strong>&nbsp;<? if (round($prom_curso_[$i]/$contador_curso_[$i])>0){ ?><? echo round($prom_curso_[$i]/$contador_curso_[$i]);?><? } ?></strong></div></td>		
   <? } ?>	
	
	<td>&nbsp;</td>
  </tr>
</table>
</td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>