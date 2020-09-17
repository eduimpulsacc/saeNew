<? 	require('../../../util/header.inc');
	require('../../../util/header.inc');
	
	$sql ="SELECT id_ramo, id_ramo_new, id_curso, id_curso_new FROM temporal_ramo WHERE rdb=".$_INSTIT;
	$rs_temporal = @pg_exec($_ORIGEN,$sql);
	$total_filas = @pg_numrows($rs_temporal);
	
	if($num=="") $num=0;
	
	if($num < $total_filas){
		$fila = @pg_fetch_array($rs_temporal,$num);
		
		$sql = "SELECT id_ano,id_ano_new,id_periodo,id_periodo_new FROM temporal_periodo WHERE id_ano in(SELECT id_ano FROM curso ";
		$sql.= "WHERE id_curso = ".$fila['id_curso'];
		$rs_periodo = @pg_exec($_ORIGEN,$sql);
		$id_ano = @pg_result($rs_periodo,0);
		$id_ano_new = @pg_result($rs_periodo,1);
		$id_periodo = @pg_result($rs_periodo,2);
		$id_periodo_new = @pg_result($rs_periodo,3);
		
		$sql  ="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$id_ano;
		$rs_ano = @pg_exec($_ORIGEN,$sql);
		$nro_ano = @pg_result($rs_ano,0);
		
		$sql = "SELECT rut_alumno, id_periodo, id_ramo, notas1,notas2,notas3,notas4,notas5,notas6,notas7,notas8,notas9,notas10,notas11,notas12, ";
		$sql.= "notas13,notas14,notas15,notas16,notas17,notas18,notas19,notas20,promedio FROM notas$nro_ano WHERE id_ramo = ".$fila['id_ramo'];
		$rs_notas = @pg_exec($_ORIGEN,$sql);
		
		for($i=0; $i < @pg_numrows($rs_notas); $i++){
			$fila_nota = @pg_fetch_array($rs_notas,$i);
			$sql = "INSERT INTO notas$nro_ano (rut_alumno, id_periodo, id_ramo, notas1, notas2, notas3, notas4, notas5, notas6, notas7, notas8,  ";
			$sql.= "notas9,notas10,notas11,notas12, notas13,notas14,notas15,notas16,notas17,notas18,notas19,notas20,promedio) VALUES ",
			$sql.= "('".$fila_nota['rut_alumno']."','".$id_periodo_new."','".$fila['id_ramo_new']."','".$fila_nota['nota1']."', ";
			$sql.= "'".$fila_nota['nota2']."','".$fila_nota['nota3']."','".$fila_nota['nota4']."','".$fila_nota['nota5']."', ";
			$sql.= "'".$fila_nota['nota6']."','".$fila_nota['nota7']."','".$fila_nota['nota8']."','".$fila_nota['nota9']."', ";
			$sql.= "'".$fila_nota['nota10']."','".$fila_nota['nota11']."','".$fila_nota['nota12']."','".$fila_nota['nota13']."', ";
			$sql.= "'".$fila_nota['nota14']."','".$fila_nota['nota15']."','".$fila_nota['nota16']."','".$fila_nota['nota17']."', ";
			$sql.= "'".$fila_nota['nota18']."','".$fila_nota['nota19']."','".$fila_nota['nota20']."','".$fila_nota['promedio']."')";
			$rs_insert = @pg_exec($_DESTINO,$sql);
		}
	}else{
		echo "<script>window.location = 'Traspaso_Apoderado.php' </script>";
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
        <td><span class="Estilo8">PROCESO MATRICULA TERMINADO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo8">PROCESO INSCRIPCION DE ALUMNO</span></td>
      </tr>
	  <tr>
        <td><span class="Estilo6">Porcentaje del proceso completado: <? echo $porcentaje; ?> %</span></td>
      </tr>
      </table></td>
  </tr>
</table>
	<script> setTimeout("window.location='Traspaso_Notas.php?num=<? echo $num; ?>'");</script>
</body>
</html>