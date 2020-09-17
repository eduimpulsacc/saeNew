<?
require('../../../../../util/header.inc');

$institucion = $_INSTIT;



$sql="SELECT nombre_instit, calle, nro, telefono FROM institucion where rdb=".$institucion;
$rs_instit = pg_exec($conn,$sql);
$nombre_instit = pg_result($rs_instit,0);
$direccion = pg_result($rs_instit,1)." ".pg_result($rs_instit,2);
$telefono = pg_result($rs_instit,3);


$sql="select a.nombre_alu ||' '|| a.ape_pat ||' '|| a.ape_mat as nombre_alumno, e.id_curso, e.fecha, e.observaciones
,e.acuerdos, em.nombre_emp ||' '|| em.ape_pat ||' '||em.ape_mat as nombre_empleado
FROM entrevista_jefeutp e 
INNER JOIN alumno a ON a.rut_alumno=e.rut_entrevistado
INNER JOIN empleado em ON em.rut_emp=CAST(e.rut_emp as INTEGER)
WHERE id_entrevista=".$id_entrevista;
$rs_entevista = pg_exec($conn,$sql);
$fila = pg_fetch_array($rs_entevista,0); 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>ENTREVISTA UTP</title>
</head>

<body onload="window.print() ">

<table width="650" border="0" align="center">
  <tr>
    <td width="311" class="textonegrita"><?=$nombre_instit;?></td>
    <td width="12" rowspan="4">&nbsp;</td>
    <td width="313" rowspan="4" align="right"><?
		$result_foto = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result_foto,0);
		$fila_foto = @pg_fetch_array($result_foto,0);
	    ## código para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='../../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='../../".$d."menu/imag/logo.gif' >";
	  }?></td>
  </tr>
  <tr>
    <td class="textonegrita"><?=$fireccion;?></td>
  </tr>
  <tr>
    <td class="textonegrita"><?=$telefono;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td align="center" class="tableindex"><div align="center">INFORME ENTREVISTA UTP</div></td>
  </tr>
</table>
<br />
<table width="650" border="0" align="center">
  <tr>
    <td width="141" class="textonegrita">ALUMNO</td>
    <td width="7">&nbsp;</td>
    <td width="488" class="textosimple">&nbsp;<?=$fila['nombre_alumno'];?></td>
  </tr>
  <tr>
    <td class="textonegrita">CURSO</td>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;<?=CursoPalabra($fila['id_curso'], 1, $conn);?></td>
  </tr>
  <tr>
    <td class="textonegrita">FECHA</td>
    <td>&nbsp;</td>
    <td class="textosimple">&nbsp;<? impF($fila['fecha']);?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">OBSERVACIONES</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2" class="textosimple"><?=$fila['observaciones'];?></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="textonegrita">ACUERDOS</td>
    <td colspan="2" class="textosimple"><?=$fila['acuerdos'];?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
</table>
<br />
<br /><br />
<br />
<br />
<br />
<br />
<br />
<br />

<table width="650" border="0" align="center">
  <tr>
    <td align="center">___________________</td>
    <td>&nbsp;</td>
    <td align="center">___________________</td>
  </tr>
  <tr>
    <td class="textosimple" align="center"><?=$fila['nombre_alumno'];?>&nbsp;</td>
    <td>&nbsp;</td>
    <td class="textosimple" align="center"><?=$fila['nombre_empleado'];?>&nbsp;</td>
  </tr>
</table>

</body>
</html>