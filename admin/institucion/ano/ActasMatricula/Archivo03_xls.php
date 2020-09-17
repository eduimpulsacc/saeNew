
<?php require('../../../../util/header.inc');?>
<?php 

	//$ls_criterio = $_GET["as_criterio"];
	//$ls_input    = $_GET["as_input"];
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$ano_escolar = $fila_ano['nro_ano'];
	//------------------------	
	$sql = "SELECT institucion.rdb, institucion.dig_rdb, curso.ensenanza, curso.grado_curso, curso.letra_curso, ano_escolar.nro_ano, alumno.rut_alumno, alumno.dig_rut, alumno.region, alumno.ciudad, alumno.comuna, ens.nombre_tipo,
  comuna.nom_com  ";
	$sql = $sql . "FROM institucion, ((matricula INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso and ((matricula.bool_ar=1 and matricula.fecha_retiro > '04-30-".$ano_escolar."') or (matricula.bool_ar=0))
	INNER JOIN tipo_ensenanza ens ON ens.cod_tipo = curso.ensenanza
	LEFT JOIN comuna ON (comuna.cod_reg=alumno.region and comuna.cor_pro=alumno.ciudad and comuna.cor_com=alumno.comuna)
	";
	$sql = $sql . "WHERE (((institucion.rdb)=".$institucion.") AND ((curso.ensenanza)>109) AND ((matricula.id_ano)=".$ano.")) ";
	$sql = $sql . "ORDER BY curso.id_curso, alumno.ape_pat, alumno.ape_mat;"; 
	//echo $sql;
	$resultado_query= pg_exec($conn,$sql);
	$total_filas= pg_numrows($resultado_query);

?>
<?php header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=".$institucion."_03.xls");
header("Pragma: no-cache");
header("Expires: 0");?>

<table  border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nº</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rbd</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Tipo Ense&ntilde;anza</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Grado</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Letra</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Nro A&ntilde;o </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Rut Estududiante</strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong>Digito Rut </strong></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><strong> Comuna </strong></font></td>
  </tr>
  <?
for ($j=0; $j < $total_filas; $j++)
{
 $ls_string = "";
 $salto = "\r\n"; 	 
 $ls_espacio= chr(9);
 $fila = @pg_fetch_array($resultado_query,$j);
 $rdb = $fila['rdb'];
 $dig_rdb = $fila['dig_rdb'];
 $ensenanza = $fila['nombre_tipo'];
 $grado_curso = $fila['grado_curso'];
 $letra_curso = $fila['letra_curso'];
 $nro_ano = $fila['nro_ano'];
 $rut_alumno = $fila['rut_alumno'];
 $dig_rut = $fila['dig_rut'];
 $region_aux = $fila['region'];
 if ($region_aux<10) $region = "0".$region_aux; else $region = $region_aux;
 $ciudad = $fila['ciudad'];
 $comuna_aux = $fila['comuna'];
 if ($comuna_aux<10) $comuna = "0".$comuna_aux; else $comuna = $comuna_aux;
 $nom_com=$fila['nom_com']


  ?>
  <tr>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $j+1?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rdb?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $ensenanza?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $grado_curso?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $letra_curso?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nro_ano?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $rut_alumno?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $dig_rut?></font></td>
    <td><font face="Arial, Helvetica, sans-serif" size="-2"><? echo $nom_com?></font></td>
  </tr>
  <? }
pg_close($conn);


?>
</table>

