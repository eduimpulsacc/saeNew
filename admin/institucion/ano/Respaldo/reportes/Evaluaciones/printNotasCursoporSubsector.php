<?
require('../../../../../util/header.inc'); 
//include('../../../../clases/class_Reporte.php');
//include('../../../../clases/class_Reporte.php');

//setlocale("LC_ALL","es_ES");
$institucion	= $_INSTIT;
$ano			= $_ANO;

//$ob_reporte = new Reporte();
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
$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$id_curso_[0].")) AND matricula.bool_ar = 0 ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
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
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

	<table width="650" border="1" cellspacing="0" cellpadding="3">
      <tr >
        <td colspan="7" class="tableindex">
          <div align="center" class="Estilo9">NOTAS DEL CURSO POR SUBSECTOR</div></td>
      </tr>
      <tr>
        <td colspan="7"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="178" class="Estilo10"><strong>Nombre Establecimiento</strong></td>
        <td colspan="3" class="Estilo7">&nbsp;<?=$nombre_institucion?></td>
      </tr>
      <tr>
        <td class="Estilo10">Curso</td>
        <td width="225" class="Estilo7">&nbsp;<?=$grado_curso_[0]?>-<?=$letra_curso_[0]?> <?=ucwords(strtolower($nombre_tipo_curso_[0]));?></td>
        <td colspan="2" rowspan="4" valign="top" ><table width="100%" border="1" cellpadding="1" cellspacing="0" class="Estilo7">
          <tr>
            <td width="73%"><strong>Cuadro Resumen</strong></td>
            <td width="27%"><div align="center"><strong>Cantidad</strong></div></td>
          </tr>
		  <?
		  //------------------ TOTAL MATRICULA INICIAL AL 30-04 MUJER
          $sql = "select count(*) as cantidad from matricula where matricula.id_ano = '$ano' and matricula.id_curso = $curso and matricula.fecha < '$nro_ano-05-01' ";
          $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
          ?>
          <tr>
            <td>Mat. 30 Abril</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
		  <?
		  //------------------- TOTAL MATRICULA Ingresos entre el 1º Mayo y 30 Noviembre
		  $sql = "select count(*) as cantidad from matricula where id_ano = ".$ano." and matricula.fecha > '".$nro_ano."-04-30' and matricula.fecha < '".$nro_ano."-12-01' and id_ano = '$ano' and matricula.id_curso=".$id_curso_[0]."";
		  $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
          ?>
          <tr>
            <td>Ingresos (1 Mayo - 30 Noviembre)</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
		  <?
		  // ALUMNOS retirados entre el 1º de mayo y el 30 de noviembre 
		  $sql = "select count(*) as cantidad from matricula where matricula.id_ano = ".$ano." and matricula.id_curso = ".$id_curso_[0]."  and matricula.bool_ar = 1 and (matricula.fecha_retiro > '".$nro_ano."-04-30' and matricula.fecha_retiro  < '".$nro_ano."-12-01') ";
		  $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
          ?>
          <tr>
            <td>Retiros (1 de Mayo - 30 Noviembre)</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
		  <?
		  // MATRICULADOS AL 30 DE NOVIEMBRE
		  $sql = "select count(*) as cantidad from matricula where id_curso = ".$id_curso_[0]." and matricula.fecha < '12-01-".$nro_ano."' and id_ano =".$ano."  and (matricula.bool_ar=0)";
		  $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
          ?>
          <tr>
            <td>Mat. 30 Noviembre</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
		  <?
		  // PROMOVIDOS
		  $sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$id_curso_[0]." and promocion.situacion_final = 1 ";
		  $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
		  ?>		  		  
          <tr>
            <td>Promovidos</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
		 
		  <tr>
            <td>Reprobados por:</td>
            <td><div align="center">&nbsp;</div></td>
          </tr>
		   <?
		  // REPROBADOS INASISTENCIA
		  $sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$id_curso_[0]." and promocion.situacion_final = 2 and tipo_reprova = 2";
          $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
		  ?>
		  
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Inasistencia</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
		  <?
		  // RENDIMIENTO
		  $sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$id_curso_[0]." and promocion.situacion_final = 2  and tipo_reprova = 1";
		  $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
		  ?>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Rendimiento</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
		   <?
		  // TOTAL REPROBADOS
		  $sql = "select count(*) as cantidad from promocion where promocion.id_curso = ".$id_curso_[0]." and promocion.situacion_final = 2";
		  $res_cant = @pg_exec($conn,$sql);
          $fil_cant = @pg_fetch_array($res_cant,0);
		  $cantidad = $fil_cant['cantidad'];
		  ?>
          <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Total Reprobados</td>
            <td><div align="center">&nbsp;<?=$cantidad?></div></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td class="Estilo10">Per&iacute;odo</td>
        <td class="Estilo7">&nbsp;<?=ucwords(strtolower($nombre_periodo))?></td>
        </tr>
      <tr>
        <td class="Estilo10">A&ntilde;o</td>
        <td class="Estilo7">&nbsp;<?=$nro_ano ?></td>
        </tr>
      <tr>
        <td colspan="2" valign="top">
		
		
		<table width="100%" border="1" cellpadding="1" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
            <td colspan="<?=$num_subsectores?>">Subsectores</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Alumnos</td>
			<?
			/// subsectores
			for ($i=0; $i < $num_subsectores; $i++){
			    $prom_col_[] = 0;
				$contador_prom_col_[] = 0;
			    ?>
                <td align="center"><font size="1" face="verdana,arial, geneva, helvetica"><strong>&nbsp;<?=$cod_subsector_[$i]?><br /><? echo  InicialesSubsector($subsector_nombre_[$i]);?></strong></font></td>
           <? } ?>
			
            <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Prom.</strong></font></td>
          </tr>
         
		 <? 
		$prom_final_curso_[0]=0;
		$contador_final_curso_[0]=0;
		
		 
		for ($i=0; $i < @pg_numrows($result_alu); $i++){  ?>
			  <tr>
				<td><font size="0" face="arial, geneva, helvetica"><?=ucwords(strtolower($nombre_alumno_[$i]))?>&nbsp;</font></td>
				<?
			    /// subsectores
			    for ($j=0; $j < $num_subsectores; $j++){
				
				      $qry8 = "select sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$nro_ano where id_ramo in (select id_ramo from ramo where id_ramo = '$id_ramo_[$j]' and cod_subsector = '$cod_subsector_[$j]') and id_periodo = '$cmbPERIODO' and promedio > 0 and rut_alumno = '$rut_alumno_[$i]'";
					  $result8 = @pg_Exec($conn, $qry8);
					  $fila8 = @pg_fetch_array($result8,0);
					  $cantidad = $fila8['cantidad'];
					  $suma     = $fila8['suma'];
					  $promedio = round($suma / $cantidad); 
					  
					  if ($promedio>0){					  
					      $prom_col_[$j] = $prom_col_[$j] + $promedio;
				          $contador_prom_col_[$j]++;				
			          }	
				      ?>
                      <td align="center">&nbsp;<font size="0" face="verdana,arial, geneva, helvetica" <? if ($promedio<40) { ?> color="#FF0000" <? } ?> >&nbsp; <? if ($promedio>0){ ?><?=$promedio?><? } ?></font></td>             
			 
			         <?
					 
					 if ($promedio>0){
					     $promedio_alumno = $promedio_alumno + $promedio;
						 $contador_prom_alumno++;
					 }	  
			     
			 
			 
			   } 
			   $promedio_alumno =  round($promedio_alumno/$contador_prom_alumno);
			   
			   ?>
				
				<td align="center"><font size="0" face="verdana,arial, geneva, helvetica">&nbsp;
				  <? if ($promedio_alumno>0){ 
				         $prom_final_curso_[0]= $prom_final_curso_[0] + $promedio_alumno;
		                 $contador_final_curso_[0]++;				  
				  
				         echo $promedio_alumno;
				     } ?>  </font></td>
			  </tr>
	   <? 
	   $promedio_alumno = 0;
	   $contador_prom_alumno = 0;
	 
	 
	    } ?> 	  
          <tr>
            <td class="Estilo10">Promedio final </td>
            <?
			/// subsectores
			for ($i=0; $i < $num_subsectores; $i++){
			    $promedio_columna = round($prom_col_[$i]/$contador_prom_col_[$i]); 
			    ?>
                <td align="center" class="Estilo10">&nbsp;<? if ($promedio_columna>0){ echo $promedio_columna; } ?></td>
         <? } ?>
		   
		   <td class="Estilo10" align="center">&nbsp;
		      <?
		      $promedio_final_curso = round($prom_final_curso_[0]/$contador_final_curso_[0]);
			  echo $promedio_final_curso;
			  ?>
		   </td>
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