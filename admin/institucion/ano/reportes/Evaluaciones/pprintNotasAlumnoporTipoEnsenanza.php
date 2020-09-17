<?php 
require('../../../../../util/header.inc'); 

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$ense			=$cmbTIPO;
	$_POSP = 4;
	$_bot = 6;
	$cantidad=17;
	$xx=0;
	

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

$qry4="select distinct id_curso,letra_curso,grado_curso from curso where ensenanza='$ense' and id_ano='$_ANO' order by grado_curso";
$result4=@pg_Exec($conn,$qry4);
$maxx=0;
for ($i=0; $i < @pg_numrows($result4); $i++){
	$fila4=@pg_fetch_array($result4,$i);
	$id_curso_[] = $fila4['id_curso'];
	$grado_curso_[] = $fila4['grado_curso'];
	$letra_curso_[] = $fila4['letra_curso'];
	
	 $sql="select count(rut_alumno) from matricula where id_curso=$id_curso_[$i] and bool_ar = 0";
	 $resultado = pg_Exec($conn,$sql);
	 $valor = pg_result($resultado,0);
	 
	 if($valor>$maxx){
		 $maxx=$valor;
	 }else{
		 $maxx=$maxx;	 
	 }
	
}



// alumnos del tipo de ensenanza
$sql_alu = "SELECT alumno.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";
$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";	
$sql_alu = $sql_alu . "INNER JOIN curso ON matricula.id_curso = curso.id_curso ";
$sql_alu = $sql_alu . "WHERE curso.id_ano='$ano' ";
$sql_alu = $sql_alu . "AND curso.ensenanza='$cmbTIPO' AND  matricula.rdb='$institucion' AND matricula.bool_ar = 0 ";
$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu ";


$result_alu = @pg_Exec($conn,$sql_alu);

for ($i=0; $i < @pg_numrows($result_alu); $i++){
	$fila_alu=@pg_fetch_array($result_alu,$i);
	$nombre_alu_[] = $fila_alu['nombre_alu'];
	$ape_pat_[]    = $fila_alu['ape_pat'];
	$ape_mat_[]    = $fila_alu['ape_mat'];
	$rut_alumno_[] = $fila_alu['rut_alumno'];
	
	// ciclo para consultar los cursos que ha tenido en tipo de enseñanza básica
	for ($j=1; $j < 9; $j++){
	    $sql_mat = "select promedio from promocion where id_curso in (select id_curso from curso where ensenanza = '110' and grado_curso = '$j' and id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno_[$i]' and id_ano in (select id_ano from ano_escolar where id_institucion = '$institucion'))) and rut_alumno = '$rut_alumno_[$i]' "; 
		$res_mat = @pg_Exec($conn, $sql_mat);		
		if (@pg_numrows($res_mat)>0){
	        $fil_mat = @pg_fetch_array($res_mat,0);
			
			if ($fil_mat['promedio']>0){			
				$prom_alumno_[$i][] = $fil_mat['promedio'];
				$suma_promedio =  $suma_promedio + $fil_mat['promedio'];
				$cont_promedio++;
			}else{
			    $prom_alumno_[$i][] = 0;
			}	
		}else{
		    $prom_alumno_[$i][] = 0;
		}	
	}
	
	$promedio_final_alumno_[] = round($suma_promedio/$cont_promedio);
	
	$suma_promedio = 0;
	$cont_promedio = 0;
		
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
H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
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
</td></tr>  
</table>
</div>
<br/>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top">

	<table width="650" border="0" cellspacing="0" cellpadding="0">
 
</table>

	<table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="8" class="tableindex">
          <div align="center">NOTAS DEL ALUMNO POR TIPO DE ENSE&Ntilde;ANZA</div></td>
      </tr>
      <tr>
        <td colspan="8"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
        </tr>
      <tr>
        <td width="160" class="Estilo7"><strong>Nombre Establecimiento</strong></td>
        <td width="15" class="Estilo8">:</td>
        <td width="475" colspan="3" class="Estilo8"><?=ucfirst($nombre_institucion);?></td>
      </tr>
      <tr>
        <td class="Estilo8">Ense&ntilde;anza</td>
        <td class="Estilo8">:</td>
        <td colspan="3" class="Estilo8"><?=$nombre_ense;?></td>
        </tr>
      <tr>
        <td class="Estilo8">A&ntilde;o</td>
        <td class="Estilo8">:</td>
        <td colspan="3" class="Estilo8"><?=$nro_ano;?></td>
        </tr>
      <tr>
        <td colspan="5" class="Estilo8">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="5" valign="top">
         

         	</td>
        </tr>
      <tr>
        <td colspan="5" valign="top"><table width="100%" border="1" cellpadding="2" cellspacing="0">
          <tr>
            <td>&nbsp;</td>
			<?
			if ($cmbTIPO==110){ ?>	
                  <td colspan="8" align="center">Promedio Cursos </td>
		  <? }else{ ?>
		          <td colspan="4" align="center">Promedio Cursos </td>		  
		  <? } ?>		  
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>Alumnos</td>
			
			<?
			if ($cmbTIPO==110){ ?>		
					<td width="30" align="center">1</td>
					<td width="30" align="center">2</td>
					<td width="30" align="center">3</td>
					<td width="30" align="center">4</td>
					<td width="30" align="center">5</td>
					<td width="30" align="center">6</td>
					<td width="30" align="center">7</td>
					<td width="30" align="center">8</td>
		<? }else{ ?>
			        <td width="30" align="center">1</td>
					<td width="30" align="center">2</td>
					<td width="30" align="center">3</td>
					<td width="30" align="center">4</td>
			
		<? } ?>
            <td align="center">Prom.<br /> Final </td>
          </tr>
		  
		  <?
		  for ($i=0; $i < @pg_numrows($result_alu); $i++){   ?>
			    <tr>
					<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? echo $ape_pat_[$i];?> <? echo $ape_mat_[$i];?> <? echo $nombre_alu_[$i];?></font></td>
					<?
					if ($cmbTIPO==110){
					     $hasta = 8;
					}else{
					     $hasta = 4;
					}	 
					
					
					for ($j=0; $j < $hasta; $j++){  ?>
	  	                  <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp;<? if ($prom_alumno_[$i][$j]>0){ ?><?=$prom_alumno_[$i][$j]?><? } ?></font></td>
	              <? } ?>
					<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px">&nbsp;<? if ($promedio_final_alumno_[$i]>0){ ?><?=$promedio_final_alumno_[$i]?><? } ?></font></td>
			    </tr>
		 <? } ?> 
        </table></td>
      </tr>
    </table>

    </td>
  </tr>
</table>
</body>
</html>