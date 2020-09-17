<?
require('../../../../../util/header.inc');

$alumno = $_REQUEST[alumno];
$ano = $_REQUEST[c_ano];
$idanotacion = $_REQUEST[idanotacion];



function limpiar($cadena) {
    $str = str_replace("Ã³", "&oacute;", $cadena); //ó
    $str = str_replace("Ã¡", "&aacute;", $str); //á
    $str = str_replace("Ã¬", "&iacute;", $str); //í
    $str = str_replace("Ã©", "&eacute;", $str); //é
    $str = str_replace("Ãº", "&uacute;", $str); //ú
    $str = str_replace("Â´", "&#39;", $str); //'
    $str = str_replace("Ã±", "&ntilde;", $str); //ñ
    $str = str_replace("Ã¼", "&#252;", $str); // ü
    $str = str_replace("Ã‘", "&Ntilde;", $str); // Ñ
    $str = str_replace("Ã ", "&Ntilde;", $str); // Ñ
    $str = str_replace("Ã ", "&Aacute;", $str); // Ñ
	$str = str_replace("Ã­", "&iacute;", $str); // í
	
	
	   
    
    return $str;
}


$sql = "SELECT * FROM anotacion WHERE id_anotacion = $idanotacion";
$reg =@pg_Exec($conn,$sql)  or die ("Error 013):".$sql);

if (pg_numrows($reg)!=0){

$regfila = @pg_fetch_array($reg,0);	

if (!$regfila['sigla']){
$nullsigla1 = '/*';
$nullsigla2 = '*/';
}else{ 
$nullsigla1 = '';
$nullsigla2 = '';
}

	if (!$regfila['codigo_tipo_anotacion']){
		$nullcota1 = '/*';
		$nullcota2 = '*/';
	}else{ 
		$nullcota1 = '';
		$nullcota2 = '';
	}

if (!$regfila['codigo_anotacion']){
$nullca1 = '/*';
$nullca2 = '*/';
}else{ 
$nullca1 = '';
$nullca2 = '';
}

    }

$sql = "SELECT 
a.*,
$nullsigla1 si.sigla,si.detalle, $nullsigla2
CASE
  WHEN a.codigo_anotacion IS NULL THEN 'TRADICIONAL'
  ELSE (a.codigo_anotacion 
  $nullca1 || '-' || dt.detalle  $nullca2
  ) END as anotacion,
CASE 
  $nullcota1 WHEN ti.codtipo IS NOT NULL THEN (ti.codtipo || '-'|| ti.descripcion) $nullcota2
  WHEN a.tipo = 1 and a.tipo_conducta = 1 THEN 'CONDUCTA POSITIVA'
  WHEN a.tipo = 1 and a.tipo_conducta = 2 THEN 'CONDUCTA NEGATIVA'
  WHEN a.tipo = 2 THEN 'ATRASO'
  WHEN a.tipo = 3 THEN 'RESPONSABILIDAD'
  WHEN a.tipo = 4 THEN 'INASISTENCIA'
END as tipo_anotacion,
  a.observacion,
  a.rut_alumno,initcap(al.nombre_alu || ' ' ||al.ape_pat || ' ' || al.ape_mat) as nombre_alumno,
  e.rut_emp,initcap(e.nombre_emp || ' ' || e.ape_pat || ' ' ||e.ape_mat) as nombre_empleado, 
  inst.nombre_instit
FROM anotacion as a
INNER JOIN alumno as al ON a.rut_alumno = al.rut_alumno AND al.rut_alumno = $alumno
INNER JOIN empleado as e ON a.rut_emp = e.rut_emp 
LEFT OUTER JOIN institucion as inst ON inst.rdb = a.rdb
$nullsigla1 LEFT JOIN sigla_subsectoraprendisaje as si ON si.id_sigla = cast(a.sigla as integer) $nullsigla2
$nullcota1 LEFT JOIN tipos_anotacion as ti ON ti.id_tipo = cast(a.codigo_tipo_anotacion as integer) $nullcota2
$nullca1 LEFT JOIN detalle_anotaciones as dt ON dt.id_tipo = ti.id_tipo AND dt.codigo = a.codigo_anotacion $nullca2
WHERE a.id_periodo in (select id_periodo from periodo where id_ano = $ano ) 
AND a.id_anotacion = $idanotacion ORDER BY fecha DESC";


$result =@pg_Exec($conn,$sql) or die ("Error 21):".$sql) or die($sql);
		
		if (!$result){

        error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');

        }else{

				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
		
					$fila = @pg_fetch_array($result,0);	
		
				if (!$fila){
				
					  error('<B> ERROR :</b>Error al acceder a la BD.(4)');
					  //exit();
					}
				 }
              }

?>
<meta charset="UTF-8">
<br><br>
<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center class="textonegrita" >

<tr>
	<td align='left' > Institucion </td>
	<td>:
    <?=$fila['nombre_instit'];?></td>
	<td>&nbsp;</td>
</tr>

<tr>
	<td align=left>
	Responsable	</td>
	<td>:
    <?=$fila['nombre_empleado'];?></td>
	<td>&nbsp;</td>
</tr>

<tr>
	<td align=left>
	Alumno	</td>
	<td>:
    <?=$fila['nombre_alumno'];?></td>
	<td>&nbsp;</TD>
</tr>

</tr>
	<tr height=20 class="tableindex">
	<td colspan=2>Datos Anotacion  </TD>
</tr>


<TR>
	<TD width=40% class="cuadro02">Fecha</TD>
	<TD width="60%" align="left" class="cuadro01">&nbsp;<?=impF($fila['fecha']);?></TD>
</TR>
<?php if($fila['id_ramo']>0){?>
<tr>
  <td class="cuadro02">Asignatura</td>
  <td width="60%" align="left" class="cuadro01">&nbsp;<?php $sql_ra = "select s.nombre 
from subsector s inner join ramo r on s.cod_subsector = r.cod_subsector
where r.id_ramo =". $fila['id_ramo'];
$rs_ra = pg_exec($conn,$sql_ra);
echo pg_result($rs_ra,0);
?></td>
  <td>&nbsp;</td>
</tr>
<?php }?>
  <? if ($fila['sigla']){  ?> 
<TR>
	<TD width="40%" class="cuadro02">Subsector Aprendizaje</TD>
	<TD width="60%" align="left" class="cuadro01">&nbsp; 
	<?=$fila['sigla'];?></TD>
</TR>
  <? } ?>
  
<TR>
	<TD width=40% class="cuadro02">Tipo de Anotaci&oacute;n </TD>
	<TD width="60%" align="left" class="cuadro01">&nbsp;
	<?=$fila['anotacion'];?></TD>
</TR>

<TR>
	<TD width=40% class="cuadro02">Sub-Tipo</TD>
	<TD width="60%" align="left" class="cuadro01">&nbsp;
	<?=$fila['tipo_anotacion'];?></TD>
</TR>

<TR>
	<TD width=40% class="cuadro02">Observaci&oacute;n</TD>
	<TD width="60%" align=left class="cuadro01">&nbsp;<?php echo utf8_decode(limpiar(utf8_encode($fila['observacion'])));?></TD>
</TR>

<TR>
<TD colspan=4>

	<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
	<TR>
	<TD>
	<HR width="100%" color=#003b85>	</TD>
	</TR>
	</TABLE></TD>
</TR>
</TABLE><br><br>
