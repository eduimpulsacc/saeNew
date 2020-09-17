<?php 
require('../../../../../util/header.inc'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$ense			=$cmbTIPO;
	$_POSP = 4;
	$_bot = 6;
	
/// tomar nombre de la institucion
$qry1="SELECT nombre_instit FROM institucion WHERE rdb = '$_INSTIT'";
$result1 =@pg_Exec($conn,$qry1);
$fila1 = @pg_fetch_array($result1,0);
$nombre_institucion = $fila1['nombre_instit'];

	
/// tomar el número de año
$qry2="SELECT nro_ano FROM ano_escolar WHERE id_ano = '$ano'";
$result2 =@pg_Exec($conn,$qry2);
$fila2 = @pg_fetch_array($result2,0);
$nro_ano = $fila2['nro_ano'];

/// tomar el nombre del tipo enseñanza 
$qry3="SELECT nombre_tipo FROM tipo_ensenanza WHERE cod_tipo = '$cmbTIPO'";
$result3 =pg_Exec($conn,$qry3);
$fila3 = @pg_fetch_array($result3,0);
$nombre_ense = $fila3['nombre_tipo'];

// tomar los cursos del tipo ensenanza

$qry4="select distinct grado_curso from curso where ensenanza='$ense' and id_ano='$_ANO' order by grado_curso";
$result4=@pg_Exec($conn,$qry4);

for ($i=0; $i < @pg_numrows($result4); $i++){
	$fila4=@pg_fetch_array($result4,$i);
	//$id_curso_[] = $fila4['id_curso'];
	$grado_curso_[] = $fila4['grado_curso'];
	//$letra_curso_[] = $fila4['letra_curso'];
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
</head>

<body>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>

	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="7" class="tableindex">
          <div align="center">NOTAS DEL ALUMNO POR TIPO DE ENSE&Ntilde;ANZA</div></td>
      </tr>
      <tr>
        <td colspan="7"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="170" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td width="480" colspan="3" class="Estilo8"><?=$nombre_institucion;?></td>
      </tr>
      <tr>
        <td class="Estilo8">Ense&ntilde;anza</td>
        <td colspan="3" class="Estilo8"><?=$nombre_ense;?></td>
        </tr>
      
      
      <tr>
        <td class="Estilo8">A&ntilde;o</td>
        <td colspan="3" class="Estilo8"><?=$nro_ano;?></td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8" valign="top">
         <? for ($i=0; $i < pg_numrows($result4); $i++){  ?>
         <br/>
        <table width="50%" border="1" cellpadding="0" cellspacing="0" >
          <tr>
            <td>&nbsp;</td>
            <td><div align="center">PROMEDIO CURSO</div></td>
            </tr>
                
          <tr>
            <td width="78%" height="14">Alumno</td>
            <td width="22%" valign="top" align="center"><?=$grado_curso_[$i];?></td>
            </tr>
            <? /// lista de alumnos por curso
			$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
			$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";	
			$sql_alu = $sql_alu . "INNER JOIN curso ON matricula.id_curso = curso.id_curso ";
			$sql_alu = $sql_alu . "WHERE (((curso.grado_curso)=".$grado_curso_[$i].")) AND curso.id_ano='$ano' ";
			$sql_alu = $sql_alu . "AND curso.ensenanza='$ense' AND  matricula.rdb='$institucion' AND matricula.bool_ar = 0 ";
	        $sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
			$result_alu =@pg_Exec($conn,$sql_alu);


				for ($j=0; $j < @pg_numrows($result_alu); $j++){
	    			$fila_alu = pg_fetch_array($result_alu,$j);
					$rut = $fila_alu['rut_alumno'];
				
			?>
          <tr>
		
            <td><?=$fila_alu['ape_pat']." ".$fila_alu['ape_mat']." ".$fila_alu['nombre_alu'];?></td>
           <?
           	// obtener promedio de los alumno 
			
			
			$qry6="select promedio from promedio_alumno where rdb='$institucion' and  id_ano='$ano' ";
			$qry6= $qry6 . "and rut_alumno='$rut' ";
		    $resp =@pg_Exec($conn,$qry6);
			$promedio=@pg_result($resp,0);
			
		   
		   ?> 
            
            <td width="22%" valign="top"><?=$promedio;?></td>
            </tr> <? }?>
          <tr>
            <td><div align="center">PROMEDIO FINAL </div></td>
            <td width="22%" valign="top">&nbsp;</td>
          </tr>
         
        </table>
        <? }?></td>
        </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>
