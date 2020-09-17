<?php 
require('../../../../../util/header.inc'); 
//setlocale("LC_ALL","es_ES");
$institucion	= $_INSTIT;
$ano			= $_ANO;
//echo "<br/>";

/// funcion
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
// fin funcion



/// tomar nombre de la institucion
$qry2="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result2 =@pg_Exec($conn,$qry2);
$fila2 = @pg_fetch_array($result2,0);
$nombre_institucion = $fila2['nombre_instit'];

// curso seleccionado
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and id_curso = '$cmbCURSO' ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$query_curso = @pg_exec($conn,$sql_curso); 	
$fila_curso = pg_fetch_array($query_curso,0);
$id_curso_[] = $fila_curso['id_curso'];
$grado_curso_[] = $fila_curso['grado_curso'];
$letra_curso_[] = $fila_curso['letra_curso'];
$nombre_tipo_curso_[] = $fila_curso['nombre_tipo'];   

/// tomar el número de año
$qry4="SELECT nro_ano FROM ano_escolar WHERE id_ano = '$ano'";
$result4 =@pg_Exec($conn,$qry4);
$fila4 = @pg_fetch_array($result4,0);
$nro_ano = $fila4['nro_ano'];


//-----------------------------------------
// Cantidad de Subsectores
//-----------------------------------------
$sql_sub = "select count(*) as cantidad from ramo where id_curso = ".$id_curso_[0]." ";
$result_sub =@pg_Exec($conn,$sql_sub );
$fila_sub = @pg_fetch_array($result_sub,0);	
$num_subsectores = $fila_sub['cantidad'];
//-----------------------------------------
// Subsectores
//-----------------------------------------
$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$id_curso_[0]."))  ORDER BY ramo.id_orden; ";
$result_sub =@pg_Exec($conn,$sql_sub );
//-----------------------------------------		
for ($i=0; $i < @pg_numrows($result_sub); $i++){
	    $fila_sub = pg_fetch_array($result_sub,$i);        
		$id_ramo_[]          = $fila_sub['id_ramo'];
		$subsector_nombre_[] = $fila_sub['nombre'];
		$cod_subsector_[]    = $fila_sub['cod_subsector'];
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
        <td colspan="7" class="tableindex">
          <div align="center">CANTIDAD APROBADOS Y REPROBADOS DE UN CURSO POR SUBSECTOR</div></td>
      </tr>
      <tr>
        <td colspan="7"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="170" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td width="480" colspan="3" class="Estilo8">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      
      
      <tr>
        <td class="Estilo8">Curso</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$grado_curso_[0]?>-<?=$letra_curso_[0]?> <?=$nombre_tipo_curso_[0]?></td>
      </tr>
      <tr>
        <td class="Estilo8">Año</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nro_ano ?></td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8" valign="top"><table width="100%" border="0">
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
			/// subsectores
			for ($i=0; $i < $num_subsectores; $i++){
			    //$prom_col_[] = 0;
				//$contador_prom_col_[] = 0;
			    ?>
			  
                <th scope="col"><strong>&nbsp;<? echo  InicialesSubsector($subsector_nombre_[$i]);?></strong></font></th>
              
                 <? }?>
              </tr>
              <tr>
              <?
              //APROBADOS
			    $total_aprobados=0;
			  for ($j=0; $j < $num_subsectores; $j++){
			  
			  	$sql="select count(promedio) from promedio_sub_alumno where id_ramo=$id_ramo_[$j] and promedio>=40";
				$resp=pg_exec($conn,$sql);
				$aprobados=pg_result($resp,0);
			    $total_aprobado=$total_aprobado+$aprobados;
			  
			  
			  ?>
                <td><div align="center"><?=$aprobados;?></div></td>
               <?  } ?>
              </tr>
              <tr>
                <?
              //REPROBADOS
			    $total_reprobados=0;
			  for ($x=0; $x < $num_subsectores; $x++){
			  
			  	$sql2="select count(promedio) from promedio_sub_alumno where id_ramo=$id_ramo_[$x] and promedio<40";
				$resp2=pg_exec($conn,$sql2);
				$reprobados=pg_result($resp2,0);
			  	$total_reprobados=$total_reprobados+$reprobados;
			  
			  
			  ?>
                <td><div align="center"><?=$reprobados;?></div></td>
                <?  } ?>
              </tr>  
			 
              <tr>
                <td><div align="center"></div></td>
              </tr>
                <td><div align="center"></div></td>
              </tr>
            </table></td>
            <td width="14%"><div align="center">Total</div></td>
          </tr>
          <tr>
            <td>Aprobados</td>
            <td><div align="center"><?=$total_aprobado;?></div></td>
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
            <td height="20">Total Nivel</td>
            <td><div align="center"><?=$total_curso=$total_reprobados+$total_aprobado;?></div></td>
          </tr>
          
         

          
        </table></td>
        </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>
