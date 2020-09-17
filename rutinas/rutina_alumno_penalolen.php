<?

$conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	

$rdb = 9121;
$ano = 1445;
$habiles = 20;

$sql="SELECT a.rut_alumno, dig_rut, nombre_alu, ape_pat, ape_mat, fecha_nac,
2017 - date_part('year',fecha_nac) as edad, case when (a.sexo=2) then 'Masculino' else 'Femenino' end as genero, a.telefono, celular, 
a.calle ||' '|| a.nro as direccion, $rdb as rdb , i.nombre_instit, c.grado_curso, c.letra_curso, te.nombre_tipo ,
case when (bool_ar=0) THEN 'Vigente' else 'Retirado' end as estado_matricula, m.fecha_retiro
FROM alumno a 
INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno 
INNER JOIN institucion i ON i.rdb=m.rdb
INNER JOIN curso c ON c.id_curso=m.id_curso
INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
WHERE m.id_ano=".$ano;
$rs_alumno =pg_exec($conn,$sql);

?>
<table width="100%" border="1">
  <tr>
    <td>RUT</td>
    <td>DIGITO</td>
    <td>NOMBRE</td>
    <td>APELLIDO<br />
    PATERNO</td>
    <td>APELLIDO<br />
    MATERNO</td>
    <td>FECHA<br />
    NAC</td>
    <td>EDAD</td>
    <td>GENERO</td>
    <td>TELEFONO</td>
    <td>CELULAR</td>
    <td>DIRECCION</td>
    <td>RDB</td>
    <td>COLEGIO</td>
    <td>CURSO</td>
    <td>LETRA</td>
    <td>NIVEL</td>
    <td>DIAS <br />
    INASISTENCIA</td>
    <td>DIAS<br />
    HABILES</td>
    <td>PORCENTAJE</td>
    <td>CANTIDAD<br />
    INASISTENCIA</td>
    <td>JUSTIFICADOS</td>
    <td>ESTADO<br />
    MATRICULA</td>
    <td>FECHA<br />
    RETIRO</td>
    <td>NUEVO<br />
      ESTABLECIMIENTO</td>
  </tr>
  <?

for($i=0;$i<pg_numrows($rs_alumno);$i++){
	$fila = pg_fetch_array($rs_alumno,$i);
	
	$sql="select * from asistencia where rut_alumno=".$fila['rut_alumno']." and date_part('year', fecha)=2017 and date_part('month', fecha)=03";	
	$rs_dias_inasistencia = pg_exec($conn,$sql);
	unset($dias_inasistencia);
	unset($cont);
	for($j=0;$j<pg_numrows($rs_dias_inasistencia);$j++){
		$fila_ina = pg_fetch_array($rs_dias_inasistencia,$j);
		if($j==0){
			$dias_inasistencia="(";
		}
		$dias_inasistencia.= $fila_ina['fecha'].")--(";	
		$cont++;
	}
	
	$sql="select count(*) from justifica_inasistencia where rut_alumno=".$fila['rut_alumno']." and date_part('year', fecha)=2017 and date_part('month', fecha)=03";
	$rs_inasis = pg_exec($conn,$sql);
	$justifica = pg_result($rs_inasis,0);
	
	$porcentaje = (($habiles - $cont) * 100) / $habiles;
	?>
	
  <tr>
    <td>&nbsp;<?=$fila['rut_alumno'];?></td>
    <td>&nbsp;<?=$fila['dig_rut'];?></td>
    <td>&nbsp;<?=$fila['nombre_alu'];?></td>
    <td>&nbsp;<?=$fila['ape_pat'];?></td>
    <td>&nbsp;<?=$fila['ape_mat'];?></td>
    <td>&nbsp;<?=$fila['fecha_nac'];?></td>
    <td>&nbsp;<?=$fila['edad'];?></td>
    <td>&nbsp;<?=$fila['genero'];?></td>
    <td>&nbsp;<?=$fila['telefono'];?></td>
    <td>&nbsp;<?=$fila['celular'];?></td>
    <td>&nbsp;<?=$fila['direccion'];?></td>
    <td>&nbsp;<?=$fila['rdb'];?></td>
    <td>&nbsp;<?=$fila['nombre_instit'];?></td>
    <td>&nbsp;<?=$fila['grado_curso'];?></td>
    <td>&nbsp;<?=$fila['letra_curso'];?></td>
    <td>&nbsp;<?=$fila['nombre_tipo'];?></td>
    <td>&nbsp;<?=$dias_inasistencia;?></td>
    <td>&nbsp;<?=$habiles;?></td>
    <td>&nbsp;<?=$porcentaje;?></td>
    <td>&nbsp;<?=$cont;?></td>
    <td>&nbsp;<?=$justifica;?></td>
    <td>&nbsp;<?=$fila['estado_matricula'];?></td>
    <td>&nbsp;<?=$fila['fecha_retiro'];?></td>
    <td>&nbsp;<?=$fila[''];?></td>

<? } ?>

   </tr>
</table>
