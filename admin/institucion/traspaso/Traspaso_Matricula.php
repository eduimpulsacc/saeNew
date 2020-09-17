<?	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql = "SELECT id_curso, id_curso_new, rdb FROM temporal_curso WHERE rdb=".$_INSTIT;
	$result = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_result($resul);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($result,$num);
		$sql = "SELECT id_ano,nro_ano FROM ano_escolar WHERE id_curso=".$fila['id_curso'];
		$rs_ano = @pg_exec($_ORIGEN,$sql);
		$ano = @pg_result($rs_ano,0);
		$nro_ano = @pg_result($rs_ano,1);
		
		$sql = " SELECT rut_alumno, dig_rut,nombre_alu, ape_pat, ape_mat, calle,nro, depto,block,villa, region, ciudad, comuna, telefono, sexo, ";
		$sql.= " email,situacion, id_usuario, fecha_nac, foto,nacionalidad, fecha_retiro,rut_alum,nom_foto,salud, religion, junaeb, ";
		$sql.= " ingestab, cursosrep, colegioprocedencia, pasaporte FROM alumno WHERE rut_alumno in  ";
		$sql.= " (SELECT rut_alumno FROM matricula WHERE id_ano=".$ano." AND id_curso=".$fila['id_curso'].")";
		$rs_alumno = @pg_exec($_ORIGEN,$sql);
		
		for($i=0; $i < @pg_numrows($rs_alumno); $i++){
			$fila_alu = @pg_fetch_array($rs_alumno,$i);
			$sql = " INSERT INTO alumno (rut_alumno, dig_rut,nombre_alu, ape_pat, ape_mat, calle,nro, depto,block,villa, region, ciudad, comuna, ";
			$sql.= " telefono, sexo, email,situacion, id_usuario, fecha_nac, foto,nacionalidad, fecha_retiro,rut_alum,nom_foto,salud, religion, ";
			$sql.= " junaeb, ingestab, cursosrep, colegioprocedencia, pasaporte) VALUES ('".$fila_alu['rut_alumno']."','".$fila_alu['dig_rut']."', ";
			$sql.= " '".$fila_alu['nombre_alu']."','".$fila_alu['ape_pat']."','".$fila_alu['ape_mat']."','".$fila_alu['calle']."', ";
			$sql.= " '".$fila_alu['nro']."','".$fila_alu['depto']."','".$fila_alu['block']."','".$fila_alu['villa']."','".$fila_alu['region']."', ";
			$sql.= " '".$fila_alu['ciudad']."','".$fila_alu['comuna']."','".$fila_alu['telefono']."','".$fila_alu['sexo']."', ";
			$sql.= " '".$fila_alu['email']."','".$fila_alu['situacion']."','".$fila_alu['id_usuario']."','".$fila_alu['fecha_nac']."', ";
			$sql.= " '".$fila_alu['foto']."','".$fila_alu['nacionalidad']."','".$fila_alu['fecha_retiro']."','".$fila_alu['rut_alum']."', ";
			$sql.= " '".$fila_alu['nom_foto']."','".$fila_alu['salud']."','".$fila_alu['relgion']."','".$fila_alu['junaeb']."', ";
			$sql.= " '".$fila_alu['ingestab']."','".$fila_alu['cursosrep']."','".$fila_alu['colegioprocedencia']."','".$fila_alu['pasaporte']."')";
			$rs_newalumno = @pg_exec($_DESTINO,$sql);
		}
		
		$sql = "SELECT id_ano_new FROM temporal_ano_escolar WHERE id_ano=".$ano;
		$rs_newano = @pg_exec($_ORIGEN,$sql);
		$id_ano_new = @pg_result($rs_newano,0);
		
		$sql = " SELECT rut_alumno,rdb,id_ano,id_curso,fecha,num_mat,bool_baj,bool_bchs,bool_aoi,bool_rg,bool_ae,bool_i,bool_gd, bool_ar,";
		$sql.= " fecha_retiro,nro_lista,bool_ed,bool_num,bool_cpadre,bool_otros,bool_seg,total_notas, sum_pond,pond_demre,alum_prio,ben_cedae, ";
		$sql.= " ben_hpv,ben_puente,ben_pie,ben_sep FROM matricula WHERE rdb=".$_INSTIT." AND id_ano=".$ano." AND id_curso=".$fila['id_curso'];
		$rs_matricula = @pg_exec($_ORIGEN,$sql);
		
		for($j=0; $j < @pg_numrows($rs_matricula); $j++){
			$fila_mat =@pg_fetch_array($rs_matricula,$j);
			$sql = "INSET INTO matricula$nro_ano (rut_alumno,rdb,id_ano,id_curso,fecha,num_mat, bool_baj,bool_bchs,bool_aoi,bool_rg,bool_ae, ";
			$sql.= "bool_i,bool_gd, bool_ar,fecha_retiro,nro_lista,bool_ed,bool_num,bool_cpadre,bool_otros,bool_seg,total_notas, sum_pond, ";
			$sql.= "pond_demre,alum_prio,ben_cedae, ben_hpv,ben_puente,ben_pie,ben_sep) VALUES ('".$fila_mat['rut_alumno']."', ";
			$sql.= "'".$fila_mat['rdb']."','".$id_ano_new."','".$fila['id_curso_new']."','".$fila_mat['fecha_num']."','".$fila_mat['bool_baj']."', ";
			$sql.= "'".$fila_mat['bool_bchs']."','".$fila_mat['bool_aoi']."','".$fila_mat['bool_rg']."','".$fila_mat['bool_ae']."', ";
			$sql.= "'".$fila_mat['bool_i']."','".$fila_mat['bool_gd']."','".$fila_mat['bool_ar']."','".$fila_mat['fecha_retiro']."', ";
			$sql.= "'".$fila_mat['nro_lista']."','".$fila_mat['bool_ed']."','".$fila_mat['bool_num']."','".$fila_mat['bool_cpadre']."', ";
			$sql.= "'".$fila_mat['bool_otros']."','".$fila_mat['bool_seg']."','".$fila_mat['total_notas']."','".$fila_mat['sum_pond']."', ";
			$sql.= "'".$fila_mat['pond_demre']."','".$fila_mat['alum_prio']."','".$fila_mat['ben_cedae']."','".$fila_mat['ben_hpv']."', ";
			$sql.= "'".$fila_mat['ben_puente']."','".$fila_mat['ben_pie']."','".$fila_mat['ben_sep']."')"; 
			$rs_matricula_new = @pg_exec($_DESTINO,$sql);
			
			$sql = "INSET INTO matricula (rut_alumno,rdb,id_ano,id_curso,fecha,num_mat, bool_baj,bool_bchs,bool_aoi,bool_rg,bool_ae, ";
			$sql.= "bool_i,bool_gd, bool_ar,fecha_retiro,nro_lista,bool_ed,bool_num,bool_cpadre,bool_otros,bool_seg,total_notas, sum_pond, ";
			$sql.= "pond_demre,alum_prio,ben_cedae, ben_hpv,ben_puente,ben_pie,ben_sep) VALUES ('".$fila_mat['rut_alumno']."', ";
			$sql.= "'".$fila_mat['rdb']."','".$id_ano_new."','".$fila['id_curso_new']."','".$fila_mat['fecha_num']."','".$fila_mat['bool_baj']."', ";
			$sql.= "'".$fila_mat['bool_bchs']."','".$fila_mat['bool_aoi']."','".$fila_mat['bool_rg']."','".$fila_mat['bool_ae']."', ";
			$sql.= "'".$fila_mat['bool_i']."','".$fila_mat['bool_gd']."','".$fila_mat['bool_ar']."','".$fila_mat['fecha_retiro']."', ";
			$sql.= "'".$fila_mat['nro_lista']."','".$fila_mat['bool_ed']."','".$fila_mat['bool_num']."','".$fila_mat['bool_cpadre']."', ";
			$sql.= "'".$fila_mat['bool_otros']."','".$fila_mat['bool_seg']."','".$fila_mat['total_notas']."','".$fila_mat['sum_pond']."', ";
			$sql.= "'".$fila_mat['pond_demre']."','".$fila_mat['alum_prio']."','".$fila_mat['ben_cedae']."','".$fila_mat['ben_hpv']."', ";
			$sql.= "'".$fila_mat['ben_puente']."','".$fila_mat['ben_pie']."','".$fila_mat['ben_sep']."')"; 
			$rs_matricula_new = @pg_exec($_DESTINO,$sql);			
		}
		
	}else{
		echo "<script>window.location = 'Traspaso_InscripcionRamo.php' </script>";
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../estilo1.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?
		$num = $num +1;
		$porcentaje = round(($num*100)/$total_filas,2);?>
<style type="text/css">
<!--
.Estilo6 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif;}
.Estilo8 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; }
-->
</style>

<table width="700" border="0" class="celdas3" align="center" >
  <tr>
    <td><strong>PROCESO DE TRASPASO DE INSTITUCION </strong></td>
  </tr>
  <tr>
    <td><table width="699" border="0" class="celdas2">
      <tr>
        <td><span class="Estilo8">PROCESO INSTITUCION TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO ANO ESCOLAR TERMINADO</span></td>
      </tr>
	    <tr>
        <td><span class="Estilo8">PROCESO PERIODO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO FERIADO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO PLAN ESTUDIO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO CURSOS PLAN TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO PLAN INSTITUCION TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO PLAN TIPO TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO HORAS TIPO ENSENANZA TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO SUBSECTORES PROPIOS TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO CURSOS TERMINADO</span></td>
      </tr>
	   <tr>
        <td><span class="Estilo8">PROCESO RAMO TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo6">Porcentaje del proceso completado: <? echo $porcentaje; ?> %</span></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Matricula.php?num=<? echo $num; ?>'");</script>
</body>
</html>
