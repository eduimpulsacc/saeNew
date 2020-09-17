<? require('../../../../util/header.inc');

$xrut = $_REQUEST['xrut']; 
$xinstitucion = $_REQUEST['xinstitucion']; 
$xano = $_REQUEST['xano']; 
$xcurso = $_REQUEST['xcurso']; 


	$sql="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$xano;
	$rs_ano = pg_exec($conn,$sql);
	$nro_ano = pg_result($rs_ano,0);

	$qry="DELETE FROM MATRICULA WHERE RUT_ALUMNO=".$xrut." AND RDB=".$xinstitucion." AND ID_ANO =".$xano." AND id_curso=".$xcurso;
	$result =@pg_Exec($conn,$qry);
	
	$sql ="DELETE FROM tiene$nro_ano WHERE id_curso=".$xcurso." AND rut_alumno=".$xrut;
	$rs_tiene = pg_exec($conn,$sql);

  if (!$result) {
			
	echo 0;
	exit;
		 
  }else{
    
	echo 1;
	
  }

?>

