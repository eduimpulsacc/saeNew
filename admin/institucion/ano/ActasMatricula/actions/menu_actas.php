<?	require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	if (isset($_POST['matricula_inicial']) && isset($_POST['sub1'])) {
		$sql_mat = "UPDATE institucion set matricula_inicial = 't' WHERE rdb = ".$institucion;
		if(!@pg_exec($conn,$sql_mat)) {
			echo "<script>alert('Error al actualizar la Base de Datos')</script>";
		}
	} elseif(!isset($_POST['matricula_inicial']) && isset($_POST['sub1'])) {
		$sql_mat = "UPDATE institucion set matricula_inicial = 'f' WHERE rdb = ".$institucion;
		if(!@pg_exec($conn,$sql_mat)) {
			echo "<script>alert('Error al actualizar la Base de Datos')</script>";
		}		
	}
	if (isset($_POST['proceso_promocion']) && isset($_POST['sub2'])) {
		$sql_mat = "UPDATE institucion set proceso_promocion = 't' WHERE rdb = ".$institucion;
		if(!@pg_exec($conn,$sql_mat)) {
			echo "<script>alert('Error al actualizar la Base de Datos')</script>";
		}
	} elseif (!isset($_POST['proceso_promocion']) && isset($_POST['sub2'])){
		$sql_mat = "UPDATE institucion set proceso_promocion = 'f' WHERE rdb = ".$institucion;
		if(!@pg_exec($conn,$sql_mat)) {
			echo "<script>alert('Error al actualizar la Base de Datos')</script>";
		}
	}
	
	echo "<script>location.href='../Menu_Actas.php';</script>";
?>