<?php require('../util/header.inc');

if($rdb!=""){
	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$rdb." AND nro_ano=2008";
	$Rs_ANO = pg_exec($conn,$sql);
	$ano = pg_result($Rs_ANO,0);
	
	$sql = "INSERT INTO alumno2008(rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, calle, nro, depto, block, villa, region, ciudad, comuna, telefono, sexo, email, situacion, id_usuario, fecha_nac, foto, nacionalidad, fecha_retiro, rut_alum, nom_foto, salud, religion, junaeb, ingestab, cursosrep, colegioprocedencia, pasaporte) SELECT rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, calle, nro, depto, block, villa, region, ciudad, comuna, telefono, sexo, email, situacion, id_usuario, fecha_nac, foto, nacionalidad, fecha_retiro, rut_alum, nom_foto, salud, religion, junaeb, ingestab, cursosrep, colegioprocedencia, pasaporte FROM alumno WHERE rut_alumno IN (SELECT rut_alumno FROM matricula WHERE rdb=".$rdb." AND id_ano=".$ano.") ";
	$Rs_Alumno = pg_exec($conn,$sql);
	
	$sql = "INSERT INTO matricula2008(rut_alumno,rdb,id_ano,id_curso,fecha,num_mat,bool_baj,bool_bchs, bool_aoi, bool_rg, bool_ae, bool_i, bool_gd, bool_ar, fecha_retiro, nro_lista, bool_ed, bool_mun,bool_cpadre, bool_otros, bool_seg, total_notas, suma_pond, pond_demre, alum_prio, ben_cedae, ben_hpv, ben_puente, ben_pie) SELECT rut_alumno, rdb, id_ano, id_curso, fecha, num_mat, bool_baj, bool_bchs, bool_aoi, bool_rg, bool_ae, bool_i, bool_gd, bool_ar, fecha_retiro, nro_lista, bool_ed, bool_mun,bool_cpadre, bool_otros, bool_seg, total_notas, suma_pond, pond_demre, alum_prio, ben_cedae, ben_hpv, ben_puente, ben_pie FROM matricula WHERE rdb=".$rdb." AND id_ano=".$ano." ";
	$Rs_matricula = pg_exec($conn,$sql); 	
}

$sql = "SELECT distinct RDB FROM MATRICULA2008 ORDER BY rdb DESC";
$Rs_Cuenta =@pg_exec($conn,$sql);



	
?>
<script language="javascript">
function inicio(){
	document.rdb.focus();
}
</script>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="TraspasoTablas.php">
<table width="200" border="1">
  <tr>
    <td>
      <label>
        <input type="text" name="rdb" />
        </label>    </td>
    <td><label>
      <input type="submit" name="Submit" value="Enviar" />
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
</form>
<table width="363" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td width="55" bgcolor="#666666"><div align="center"><strong>RDB</strong></div></td>
    <td width="233" bgcolor="#666666"><div align="center"><strong>NOMBRE COLEGIO</strong></div></td>
    <td width="67" bgcolor="#666666"><div align="center"><strong>ESTADO</strong></div></td>
  </tr>
  <? for($i=0;$i<@pg_numrows($Rs_Cuenta);$i++){
  		$fila = @pg_fetch_array($Rs_Cuenta,$i);
		$sql = "SELECT a.nombre_instit FROM institucion a WHERE a.rdb=".$fila['rdb'];
		$Rs_Inst = @pg_exec($conn,$sql);
		$Nombre = @pg_result($Rs_Inst,0);
  ?>	
  <tr>
    <td><? echo $fila['rdb'];?></td>
	<td><? echo $Nombre;?></td>
    <td>OK</td>
  </tr>
  <? } ?>
</table>

	
</body>
</html>
<? pg_close($conn);?>