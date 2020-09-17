<?php 
require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	//$_POSP = 4;
	//$_bot = 6;
	
/// tomar nombre de la institucion
$qry2="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result2 =@pg_Exec($conn,$qry2);
$fila2 = @pg_fetch_array($result2,0);
$nombre_institucion = $fila2['nombre_instit'];

/// tomar el número de año
$qry4="SELECT nro_ano FROM ano_escolar WHERE id_ano = '$ano'";
$result4 =@pg_Exec($conn,$qry4);
$fila4 = @pg_fetch_array($result4,0);
$nro_ano = $fila4['nro_ano'];

// tomar Los datos del nivel seleccionado
$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$cmbNIVEL'";
$result7 =@pg_Exec($conn,$qry7);
for ($i=0; $i < @pg_numrows($result7); $i++){
    $fila7 = @pg_fetch_array($result7,$i);	
    $nombre_nivel  = $fila7['nombre'];
    $id_nivel      = $fila7['id_nivel'];
		}	

/// tomar todos los subsectores de los cursos al que pertenece este nivel
$qry6 = "select ramo.cod_subsector, subsector.nombre from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from nivel_curso where id_nivel = '$cmbNIVEL' and id_ano = '$ano') group by ramo.cod_subsector, subsector.nombre order by subsector.nombre";
$result6 =@pg_Exec($conn,$qry6);
for ($j=0; $j < @pg_numrows($result6); $j++){
     $fila6 = @pg_fetch_array($result6,$j);	
     $nombre_subsector_[]   = $fila6['nombre'];
	 $cod_subsector_[]      = $fila6['cod_subsector'];

}	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SAE - Sistema de Administración Escolar</title>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
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

<body>
<div id="capa0">
<table width="650" align="center">
  <tr><td>
   <input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
        <font size="1" face="Arial, Helvetica, sans-serif"></font>
   <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
</td></tr></table>
</div>
<br/>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>

	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr >
        <td colspan="8" class="tableindex">
          <div align="center">CANTIDAD APROBADOS Y REPROBADOS DE UN NIVEL POR SUBSECTOR</div></td>
      </tr>
      <tr>
        <td colspan="8"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="168" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td class="Estilo8">:</td>
        <td width="475" colspan="3" class="Estilo8">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      
      
      <tr>
        <td class="Estilo8">Nivel</td>
        <td class="Estilo8">:</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nombre_nivel?></td>
      </tr>
      <tr>
        <td class="Estilo8">Año</td>
        <td class="Estilo8">:</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nro_ano ?></td>
        </tr>
      <tr>
        <td colspan="5" class="Estilo8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" class="Estilo8" valign="top"><table width="100%" border="0">
          <tr>
            <td>&nbsp;</td>
            <td><div align="center">Subsector</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="33%">&nbsp;</td>
            <td width="53%" rowspan="6" valign="top"><table width="100%" border="0">
              <tr>
              <? 
			  		for ($j=0; $j < @pg_numrows($result6); $j++){  
			  
			  ?>
                <th scope="col"><? InicialesSubsector($nombre_subsector_[$j]) ?></th>
                <? } ?>
               
              </tr>
              <tr>
			  <?
              //APROBADOS POR NIVEL
			  $total_aprobados=0;
			for ($x=0; $x < @pg_numrows($result6); $x++){  
			  
			
			$sql="select count(promedio) from promedio_sub_alumno a inner join ramo b on (a.id_ramo=b.id_ramo)";
			$sql.="inner join curso c on (b.id_curso=c.id_curso) where b.cod_subsector=$cod_subsector_[$x] ";
			$sql.=" and a.promedio>=40 and c.id_nivel='$cmbNIVEL' and a.rdb='$_INSTIT' and a.id_ano='$ano'";
			$resp=pg_exec($conn,$sql);
			$aprobados=pg_result($resp,0);  
			$total_aprobados=$total_aprobados+$aprobados; 
			  
			  ?>
           
                <td><div align="center"><?=$aprobados;?></div></td>
                <? }?>
              </tr>
              <tr>
              
               <?
              //REPROBADOS POR NIVEL
			  $total_reprobados=0;
			for ($y=0; $y < @pg_numrows($result6); $y++){  
			  
			
			$sql2="select count(promedio) from promedio_sub_alumno a inner join ramo b on (a.id_ramo=b.id_ramo)";
			$sql2.="inner join curso c on (b.id_curso=c.id_curso) where b.cod_subsector=$cod_subsector_[$y] ";
			$sql2.=" and a.promedio<40 and c.id_nivel='$cmbNIVEL' and a.rdb='$_INSTIT' and a.id_ano='$ano'";
			$resp2=pg_exec($conn,$sql2);
			$reprobados=pg_result($resp2,0);  
			$total_reprobados=$total_reprobados+$aprobados; 
			  
			  ?>
                <td><div align="center"><?=$reprobados;?></div></td>
                
                <? }?>
              </tr>
              <tr>
                <td><div align="center"></div></td>
               </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><div align="center"></div></td>
              </tr>
            </table></td>
            <td width="14%"><div align="center">Total</div></td>
          </tr>
          <tr>
            <td>Aprobados</td>
            <td><div align="center"><?=$total_aprobados;?></div></td>
          </tr>
          <tr>
            <td>Reprobados</td>
            <td><div align="center"><?=$total_reprobados;?></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center"></div></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><div align="center"></div></td>
          </tr>
          <tr>
            <td>Total Nivel</td>
            <td><div align="center"><?=$total=$total_reprobados+$total_aprobados;?></div></td>
          </tr>

          
        </table></td>
        </tr>
    </table>

    </td>
  </tr>
  <?
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
</table>
</body>
</html>
