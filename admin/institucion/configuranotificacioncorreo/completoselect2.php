<? require('../../../util/header.inc');
$institucion = $_INSTIT;
$idconfiguracion=NULL;
if($_REQUEST['id']!="")$idconfiguracion=$_REQUEST['id'];
 $sql="SELECT nce.rut_empleado,
 ( e.ape_pat || cast(' ' as varchar) || e.ape_mat || cast(' ' as varchar) || e.nombre_emp) as 
 nombre_empleado
 FROM notifica_correo_empleados nce 
 INNER JOIN empleado e ON e.rut_emp = nce.rut_empleado
 WHERE nce.id_notifica_correo_configuracion = $idconfiguracion ";
 $rs_nce = @pg_exec($conn,$sql) or die (pg_last_error());
	 if (@pg_numrows($rs_nce)!=0){
		  echo '<select multiple id="select2" class="Estilomio4">';
			  for($i=0;$i<@pg_numrows($rs_nce);$i++){
			  $fila_nce = @pg_fetch_array($rs_nce,$i);
			  echo '<option value="'.$fila_nce['rut_empleado'].'">'.$fila_nce['nombre_empleado'].'</option>';
		  }
	   echo '</select>';
	 }else{
		 echo '<select multiple id="select2" class="Estilomio4"></select>';
	 }
 ?>
