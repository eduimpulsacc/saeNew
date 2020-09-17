<?php require('../../../util/header.inc');?>
<?php 
	 $institucion	=$_INSTIT;
	 $frmModo		=$_FRMMODO;
	 $empleado		=$_EMPLEADO;


if ($guardar){
	$largo=count($id_curso);
	for ($i=0;$i<$largo;$i++){
		$x="nivel_".$i;
		if ($_POST[$x]){
			$query_val="select * from nivel_empleado where rut_emp='$rut_empleado' and id_curso='$id_curso[$i]' and id_ramo='$id_ramo[$i]'";
			$result_val=pg_exec($conn,$query_val);
			$num_val=pg_numrows($result_val);
			if ($num_val==0){
					$query="INSERT INTO nivel_empleado (rut_emp,id_curso,id_ramo,nivel,id_ano,rdb)
					 VALUES('$rut_empleado','$id_curso[$i]','$id_ramo[$i]','$_POST[$x]','$id_ano[$i]','$institucion')";
			}else{
					$query="update nivel_empleado set nivel='$_POST[$x]' 
					where rut_emp='$rut_empleado' and id_curso='$id_curso[$i]' and id_ramo='$id_ramo[$i]'";
			}
			//echo $query."<BR>";
			$result=pg_exec($conn,$query);
		}
		$x="";
	}
	echo "<script>
	window.close();
	</script>";
}

$query_anos="select * from ano_escolar where id_institucion='$institucion'";
$result_anos=pg_exec($conn,$query_anos);
$num_anos=pg_numrows($result_anos);


?>	

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">	
<title>Documento sin t&iacute;tulo</title>
<link rel="STYLESHEET" href="../../../util/td.css" type="text/css">
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
table {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
td {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 9px;
}
-->
</style>
<link href="../../../estilos.css" rel="stylesheet" type="text/css">
</head>
<body>
<table>
<form method="post">
<?
$cont=0;
 for ($i=0;$i<$num_anos;$i++){
	$row_ano=pg_fetch_array($result_anos);
	?>
	<tr><td class="fondo" colspan="6"><? echo $row_ano[nro_ano];?></td></tr>
	<? $query_dicta="
	select ramo.id_ramo,sub.nombre, curso.id_curso from dicta,ramo,curso,subsector as sub
	where rut_emp='$rut_empleado' and ramo.id_ramo=dicta.id_ramo and ramo.id_curso=curso.id_curso
	and sub.cod_subsector=ramo.cod_subsector and curso.id_ano =$row_ano[id_ano]
	 order by curso.ensenanza,curso.grado_curso,curso.letra_curso ";
	$result_dicta=pg_exec($conn,$query_dicta);
	$num_dicta=pg_numrows($result_dicta);?>
	<tr><td>Curso</td><td>Asignaturas</td><td>Habilitado</td><td>Titulado</td><td>Tit. Otras</td></tr>
	<?  for ($x=0;$x<$num_dicta;$x++){
	 $row_dicta=pg_fetch_array($result_dicta);
	$query_nivel="select * from nivel_empleado where id_curso=$row_dicta[id_curso] and rut_emp='$rut_empleado' and id_ramo='$row_dicta[id_ramo]'";
	$result_nivel=pg_exec($conn,$query_nivel);
	$num_nivel=pg_numrows($result_nivel);
	if ($num_nivel>0){
		$row_nivel=pg_fetch_array($result_nivel);
		$nivel=$row_nivel[nivel];
	}
	//echo $query_nivel."<br>";
	?>
		<tr>
			<td><? echo  CursoPalabra($row_dicta[id_curso],1,$conn);?></td>
			<td>
			   <? echo $row_dicta[nombre];?>			
			  <input type="hidden"name="id_ramo[<? echo $cont;?>]" value="<? echo $row_dicta[id_ramo];?>">
		  	  <input type="hidden"name="id_ano[<? echo $cont;?>]" value="<? echo $row_ano[id_ano];?>">
			   <input type="hidden"name="id_curso[<? echo $cont;?>]" value="<? echo $row_dicta[id_curso];?>">
		  </td>
			<td align="center"><input name="nivel_<? echo $cont;?>"  type="radio" value="1" <? if ($nivel==1){ echo "checked";}?>></td>
			<td align="center"><input name="nivel_<? echo $cont;?>" type="radio" value="2" <? if ($nivel==2){ echo "checked";}?>></td>
			<td align="center"><input name="nivel_<? echo $cont;?>" type="radio" value="3" <? if ($nivel==3){ echo "checked";}?>></td>
		</tr>
	<? $cont++;}?>
	<? if ($num_dicta==0){?>
		<tr>
			<td colspan="6" align="center">
				No tienen asignado ningun curso
			</td>
		</tr>
	<? }?>

	
<? }?>
<tr>
	<td colspan="6" align="center">
	<input name="rut_empleado" value="<? echo $rut_empleado;?>" type="hidden">
	<input name="guardar" type="submit" value="Guardar" class="botonXX">
	</td>
</tr>
</form>
</table>


</body>
</html>
