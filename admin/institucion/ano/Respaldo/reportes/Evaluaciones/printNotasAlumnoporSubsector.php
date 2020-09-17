<?
require('../../../../../util/header.inc');
//include('../../../../clases/class_Reporte.php');
//setlocale("LC_ALL","es_ES");
$institucion	= $_INSTIT;
$ano			= $_ANO;

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

/// lista de alumnos del curso
$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$id_curso_[0].")) AND matricula.bool_ar = 0 and rut_alumno = '".$cmbALUMNO."' ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
$result_alu =@pg_Exec($conn,$sql_alu);


for ($i=0; $i < @pg_numrows($result_alu); $i++){
	    $fila_alu = pg_fetch_array($result_alu,$i);
		$rut_alumno_[] = $fila_alu['rut_alumno'];
		$nombre_alumno_[] = $fila_alu['ape_pat']." ".$fila_alu['ape_mat']." ".$fila_alu['nombre_alu'];	
}

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

// nombre del alumno
$sql_alu="select alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from  alumno where rut_alumno = '$cmbALUMNO'";
$result_alumno= @pg_Exec($conn,$sql_alu);
$fila_alu = pg_fetch_array($result_alumno,0);     
$rut_alumno_[]    = $fila_alu['rut_alumno'];   
$nombre_alumno_[] = $fila_alu['ape_pat']." ".$fila_alu['ape_mat']." ".$fila_alu['nombre_alu'];
//--------------------------
	

	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
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
<body topmargin="0">
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

	<table width="100%" border="1" cellspacing="0" cellpadding="3">
      <tr >
        <td colspan="7" class="tableindex">
          <div align="center">NOTAS DEL ALUMNO POR SUBSECTOR</div></td>
      </tr>
      <tr>
        <td colspan="7"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="170" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td width="480" colspan="3" class="Estilo8">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      <tr>
        <td class="Estilo8">Nombre Alumno</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nombre_alumno_[0]?></td>
        </tr>
      <tr>
        <td class="Estilo8">Curso</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$grado_curso_[0]?>-<?=$letra_curso_[0]?> <?=$nombre_tipo_curso_[0]?></td>
        </tr>
      <tr>
        <td class="Estilo8">Período</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nombre_periodo?></td>
        </tr>
      <tr>
        <td class="Estilo8">A&ntilde;o</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nro_ano ?></td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8" valign="top"><table width="100%"  border="1" align="center" cellpadding="1" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
            <td colspan="15"><div align="center">Notas</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="33%">Subsector</td>
            <?
			/// casilla de notas
		    for ($i=0; $i < 15; $i++){ ?>
			    <td width="1%" valign="top">N<?=$i+1?></td>
				<?
			}
			
			?>
			
			<td width="12%"><div align="center">Prom.</div></td>
          </tr>
		  
		  <?
		  /// subsectores
		  for ($i=0; $i < $num_subsectores; $i++){
			  $prom_col_[] = 0;
			  $contador_prom_col_[] = 0;
			  ?>
			  <tr>
				<td height="25"><?=$subsector_nombre_[$i]?></td>
				 <?
			     /// casilla de notas
				 
				 // cosnulata que trae las notas y el promedio
				 $sql_notas = "select * from notas$nro_ano where rut_alumno = '$rut_alumno_[0]' and id_periodo = '$cmbPERIODO' and id_ramo = '$id_ramo_[$i]' ";
				 $res_notas = @pg_Exec($conn, $sql_notas);
				 $fil_notas = @pg_fetch_array($res_notas,0);				 
				 				 
		         for ($j=0; $j < 15; $j++){
				     $var_nota = $fil_notas['nota'.($j+1)];					 
					  
					 if ($var_nota>0){
					     $suma_nota = $suma_nota + $var_nota;
						 $cont_nota++;
						 $prom_col_[$j] = $prom_col_[$j] + $var_nota;
			             $contador_prom_col_[$j]++;
					 }					  
				     ?>
				     <td width="1%" valign="top">&nbsp;<? if ($var_nota>0){ ?><?=$var_nota?><? } ?></td>
			  <? }
			  
			     $prom_alumno = round($suma_nota/$cont_nota);
			     			  
			     ?>	
				<td align="center">&nbsp;<? if ($prom_alumno>0){ ?><?=$prom_alumno?><? } ?></td>
			  </tr>
			  <?
			  $suma_nota = 0;
			  $cont_nota = 0;
			  
			  
		  } 
		  
		  ?>		  
		  
          <tr>
            <td>Final.</td>
                <?
			     /// casilla de notas
		         for ($i=0; $i < 15; $i++){ 
				     $promedio_columna = round($prom_col_[$i]/$contador_prom_col_[$i]);				 
				     ?>
				     <td width="1%" valign="top">&nbsp;<? if ($promedio_columna>0){ ?><?=$promedio_columna?><? } ?></td>
			  <? } ?>
            <td>&nbsp;</td>
          </tr>
        
        </table></td>
        </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>
