<?php 
require('../../../../../util/header.inc'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;
	
	
	
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


// tomar los períodos de la institucion
$qry8 = "select id_periodo, nombre_periodo from  periodo where id_ano = '$ano' and id_periodo=".$cmbPERIODO;
$result8 =@pg_Exec($conn,$qry8);
for ($i=0; $i < @pg_numrows($result8); $i++){
     $fila8 = @pg_fetch_array($result8,$i);	
     $nombre_periodo_[]  = $fila8['nombre_periodo'];
	 $id_periodo_[]      = $fila8['id_periodo'];
	 
}	


/// lista de alumnos del curso
$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$cmbCURSO.")) AND matricula.bool_ar = 0 ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
$result_alu =@pg_Exec($conn,$sql_alu);


for ($i=0; $i < @pg_numrows($result_alu); $i++){
	    $fila_alu = pg_fetch_array($result_alu,$i);
		$rut_alumno_[] = $fila_alu['rut_alumno'];
		$nombre_alumno_[] = ucfirst(strtolower($fila_alu['ape_pat']))." ".ucfirst(strtolower($fila_alu['ape_mat']))." ".ucfirst	(strtolower($fila_alu['nombre_alu']));	
}
	

// Subsector
//-----------------------------------------
$sql_sub = "SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval, ramo.conex, ramo.sub_obli, ramo.cod_subsector ";
$sql_sub = $sql_sub . "FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector ";
$sql_sub = $sql_sub . "WHERE (((ramo.id_curso)=".$cmbCURSO."))  AND ramo.cod_subsector=".$cmbSUBSECTOR."; ";
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
<title>Documento sin t&iacute;tulo</title>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.Estilo7 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo8 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
</style>

<script language="javascript" type="text/javascript">
function cerrar(){ 
window.close() 
} 

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
<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>

	<table width="650" border="0" cellspacing="0" cellpadding="3">
      <tr >
        <td colspan="7" class="tableindex">
          <div align="center">LIBRO DE CLASES ELECTRONICO POR SUBSECTOR</div></td>
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
        <td class="Estilo8">Subsector</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$subsector_nombre_[0]?></td>
        </tr>
      <tr>
        <td class="Estilo8">Semestre</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nombre_periodo_[0]?></td>
        </tr>
      <tr>
        <td class="Estilo8">Año</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nro_ano ?></td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" valign="top"><table width="100%" border="1" cellpadding="0" cellspacing="0">
          <tr>
            <td width="37%" class="Estilo8">&nbsp;</td>
            <td class="Estilo8"><div align="center">Notas</div></td>
            <td width="10%" class="Estilo8">&nbsp;</td>
          </tr>
          <tr>
            <td width="37%" class="Estilo8">Alumnos</td>
            <td width="53%" valign="center" class="Estilo8"><table width="100%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td width="6%"><div align="center">&nbsp;N1&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N2&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N3&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N4&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N5&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N6&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N7&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N8&nbsp;</div></td>
                <td width="6%"><div align="center">&nbsp;N9&nbsp;</div></td>
                <td width="6%"><div align="center">N10</div></td>
                <td width="6%"><div align="center">N11</div></td>
                <td width="6%"><div align="center">N12</div></td>
                <td width="6%"><div align="center">N13</div></td>
                <td width="6%"><div align="center">N14</div></td>
                <td width="6%"><div align="center">N15</div></td>
              </tr>
            </table></td>
            <td width="10%" class="Estilo8"><div align="center">Promedio Final</div></td>
          </tr>
		  <? for ($k=0; $k < @pg_numrows($result_alu); $k++){  ?>
          <tr>
            <td width="37%" class="Estilo7"><?=$nombre_alumno_[$k];?></td>
            <td width="53%" valign="top" class="Estilo7"><table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0">
			
			<? 
			
		//---------------- CONSULTA DE CANTIDAD DE NOTAS Y SUMA DE ELLAS PARA OBTENER PROMEDIO ------------//	
			
			$qry = "select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$nro_ano ";
			$qry.= "where id_ramo in (select id_ramo from ramo where id_ramo = '$id_ramo_[0]' ";
			$qry.= "and cod_subsector = '$cmbSUBSECTOR') and id_periodo = '$cmbPERIODO' and ";
			$qry.= "promedio > 0 and rut_alumno = '$rut_alumno_[$k]'";
					  $result1 = @pg_Exec($conn, $qry);
					  $fila1 = @pg_fetch_array($result1,0);
					  $cantidad = $fila1['cantidad'];
					  $suma     = $fila1['suma'];
					  $promedio = round($suma / $cantidad); 
					 
		//------------------- CONSULTA DE CADA UNA DE LAS NOTAS DEL ALUMNO ---------------------------//

				$qry_nota = "select nota1,nota2,nota3,nota4,nota5,nota6,nota7,nota8,nota9,nota10,nota11,nota12,";
				$qry_nota.= "nota13,nota14,nota15, promedio, notaap from notas$nro_ano where id_ramo in (select id_ramo from ramo where ";
				$qry_nota.= "id_ramo = '$id_ramo_[0]' and cod_subsector = '$cmbSUBSECTOR') and id_periodo = '$cmbPERIODO' ";
				$qry_nota.= "and promedio > 0 and rut_alumno = '$rut_alumno_[$k]'";		  
					 $result_nota = @pg_Exec($conn, $qry_nota);
					 $fila_nota = @pg_fetch_array($result_nota,0);
			
			?>
              <tr>
                <td width="6%"><div align="center"><? if($fila_nota['nota1']==""){ echo "-"; }else{ echo $fila_nota['nota1'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota2']==""){ echo "-"; }else{ echo $fila_nota['nota2'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota3']==""){ echo "-"; }else{ echo $fila_nota['nota3'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota4']==""){ echo "-"; }else{ echo $fila_nota['nota4'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota5']==""){ echo "-"; }else{ echo $fila_nota['nota5'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota6']==""){ echo "-"; }else{ echo $fila_nota['nota6'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota7']==""){ echo "-"; }else{ echo $fila_nota['nota7'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota8']==""){ echo "-"; }else{ echo $fila_nota['nota8'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota9']==""){ echo "-"; }else{ echo $fila_nota['nota9'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota10']==""){ echo "-"; }else{ echo $fila_nota['nota10'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota11']==""){ echo "-"; }else{ echo $fila_nota['nota11'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota12']==""){ echo "-"; }else{ echo $fila_nota['nota12'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota13']==""){ echo "-"; }else{ echo $fila_nota['nota13'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota14']==""){ echo "-"; }else{ echo $fila_nota['nota14'];}?></div></td>
                <td width="6%"><div align="center"><? if($fila_nota['nota15']==""){ echo "-"; }else{ echo $fila_nota['nota15'];}?></div></td>
              </tr>
            </table></td>
            <td width="10%" class="Estilo7"><div align="center" class="Estilo8"><? if($ckPROMEDIO==0) echo $fila_nota['promedio']; else echo $fila_nota['notaap'];?></div></td>
          </tr>
          <? }?>
		  <tr>
            <td width="37%">&nbsp;</td>
            <td width="53%">&nbsp;</td>
            <td width="10%">&nbsp;</td>
          </tr>

          
        </table></td>
        </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>
