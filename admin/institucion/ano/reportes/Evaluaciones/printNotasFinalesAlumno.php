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
$qry8 = "select id_periodo, nombre_periodo from  periodo where id_ano = '$ano' order by id_periodo";
$result8 =@pg_Exec($conn,$qry8);
for ($i=0; $i < @pg_numrows($result8); $i++){
     $fila8 = @pg_fetch_array($result8,$i);	
     $nombre_periodo_[]  = $fila8['nombre_periodo'];
	 $id_periodo_[]      = $fila8['id_periodo'];
	 
}	


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
.Estilo14 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
}
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
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>

	<table width="650" border="1" cellspacing="0" cellpadding="3">
      <tr>
        <td colspan="7" class="tableindex">
          <div align="center" class="Estilo14">NOTAS FINALES DEL ALUMNO</div></td>
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
        <td class="Estilo8">A&ntilde;o</td>
        <td colspan="3" class="Estilo8">&nbsp;<?=$nro_ano ?></td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="4" class="Estilo8" valign="top">
		
		<table width="100%" border="1" cellpadding="2" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
            <td colspan="<?=@pg_numrows($result8)?>"><div align="center">PERIODO</div></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td width="33%">Subsector</td>
			<?
			for ($i=0; $i < @pg_numrows($result8); $i++){
			     $prom_col_periodo_[$i] = 0;
				 $contador_col_sem_[$i] = 0;
			    
				 ?>
                 <td width="20%" valign="top"><div align="center"><?=$nombre_periodo_[$i]?></div></td>
                
				 <?
			} ?>	 
			
			
            <td width="12%"><div align="center">Final</div></td>
          </tr>
		  <?
		  /// subsectores
		  for ($i=0; $i < $num_subsectores; $i++){
			  
			  ?>
		  
			  <tr>
				<td><?=$subsector_nombre_[$i]?></td>
				<?
			    for ($j=0; $j < @pg_numrows($result8); $j++){
				
			         // cosnulata que trae las notas y el promedio
				     $sql_notas = "select * from notas$nro_ano where rut_alumno = '$rut_alumno_[0]' and id_periodo = '$id_periodo_[$j]' and id_ramo = '$id_ramo_[$i]' ";
				     $res_notas = @pg_Exec($conn, $sql_notas);
				     $fil_notas = @pg_fetch_array($res_notas,0);				 
				 				 
		             for ($k=0; $k < 15; $k++){
				         $var_nota = $fil_notas['nota'.($k+1)];					 
					  
					     if ($var_nota>0){
					         $suma_nota = $suma_nota + $var_nota;
						     $cont_nota++;
						     
					     }					  
				     }
					 
					 $prom_alumno = @round($suma_nota/$cont_nota);
					 
					 if ($prom_alumno>0){
					     $prom_col_periodo_[$j] = $prom_col_periodo_[$j] + $prom_alumno;
						 $contador_col_sem_[$j]++;
					 
					 }			 
			     	 
					 ?>		         			
				     <td width="20%" valign="top"><div align="center">&nbsp;<? if ($prom_alumno>0){ ?><?=$prom_alumno?><? } ?></div></td>
				     <?
					 if ($prom_alumno>0){ 
					      $sum_prom_periodo = $sum_prom_periodo + $prom_alumno;
						  $cont_prom_periodo++;
					 }				 
					 
					 $suma_nota = 0;
					 $cont_nota = 0;
				}
				
				$promedio_periodo = @round($sum_prom_periodo/$cont_prom_periodo);					
				
				?>			
				<td><div align="center">&nbsp;<? if ($promedio_periodo>0){ ?><?=$promedio_periodo?><? } ?></div></td>
			  </tr>
		      <? 
		      $sum_prom_periodo = 0;
			  $cont_prom_periodo = 0;
		
		
		  } ?>	  
          <tr>
            <td>FINAL</td>
			<?
			for ($j=0; $j < @pg_numrows($result8); $j++){
			    ?>
                <td width="20%" valign="top"><div align="center">&nbsp;<? echo round($prom_col_periodo_[$j]/$contador_col_sem_[$j]);?></div></td>             
         <? } ?> 
			
			<td><div align="center">&nbsp;</div></td>
          </tr>

          
        </table>
		
		</td>
        </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>