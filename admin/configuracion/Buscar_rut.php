<? 
require('../../util/header.inc');
$txtrut=$_POST['txtrut'];
$sql="select * from matricula where rut_alumno=".$txtrut." and id_ano=".$_ANO;
$resp = pg_exec($conn,$sql); 
if(pg_numrows($resp)>0){
//	echo header("location: http://intranet.colegiointeractivo.cl/sae3.0/admin/configuracion/Postular_form.php?rut=".$txtrut);
	echo header("location: Postular_form.php?rut=".$txtrut);
}else{
//	header("location: http://intranet.colegiointeractivo.cl/sae3.0/admin/configuracion/Postular_form.php"); 
	header("location: Postular_form.php"); 

}
?>