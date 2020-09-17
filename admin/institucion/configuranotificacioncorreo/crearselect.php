<? require('../../../util/header.inc');
$tipo_cargo = $_REQUEST['tipo_cargo'];
$sql = "select  e.rut_emp,
( e.ape_pat || cast(' ' as varchar) || e.ape_mat || cast(' ' as varchar) || e.nombre_emp) as nombre_empleado,
t.cargo from empleado e
inner join trabaja t on t.rut_emp = e.rut_emp 
and t.cargo= ".trim($tipo_cargo)." and t.rdb = ".$_INSTIT." ORDER BY 2";
$reg_empleados = @pg_Exec($conn,$sql);
$n_reg_empleados = @pg_numrows($reg_empleados);
echo '<select multiple id="select1" class="Estilomio4">';
		$l = 0;
		while ($l < $n_reg_empleados){
		$fila_reg_empleados = pg_fetch_array($reg_empleados,$l);
		$rut_empleado  = $fila_reg_empleados['rut_emp'];
		$nombre_empleado =  trim($fila_reg_empleados['nombre_empleado']);
	    echo '<option value="'.$rut_empleado.'">'.$nombre_empleado.'</option>';
	    $l++; }	 
echo '</select>'; ?>
