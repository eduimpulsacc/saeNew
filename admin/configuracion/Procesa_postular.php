<?php require('../../util/header.inc');
$ano			=$_ANO;
$institucion	=$_INSTIT;
$txtrut=$_POST['txtrut'];
$txtproc=$_POST['txtproc']; 
$prom7=$_POST['prom7']; 
$prom8=$_POST['prom8']; 
$prompostu=$_POST['prompostu']; 
$pref1=$_POST['pref1']; 
$pref2=$_POST['pref2']; 
$pref3=$_POST['pref3']; 
$pref4=$_POST['pref4']; 
$pref5=$_POST['pref5'];
$txt_edad=$_POST['txt_edad']; 
$cmbproce=$_POST['cmbproce'];

	if($_POST["hd_grado"]==8){
		$grado=1;
	}
	if($_POST["hd_grado"]==1){
		$grado=2;
	}
	
	if($_POST["hd_grado"]==2){
		$grado=3;
	}
	
	if($_POST["hd_grado"]==3){
		$grado=4;
	}
 	$sql="insert into formulario_postulacion (rut,prom_postu,prefe_1,prefe_2,prefe_3,prefe_4,prefe_5,rdb_origen,id_ano,prom_7,prom_8,establecimiento_proc,edad_31mar,id_estado,tipo_inst,preferencia,grado)";
	 $sql=$sql."values(".$txtrut.",'".$prompostu."',".$pref1.",".$pref2.",".$pref3.",".$pref4.",".$pref5.",".$institucion.",".$ano.",'".$prom7."','".$prom8."','".$txtproc."',".$txt_edad.",0,".$cmbproce.",1,".$grado.")";
$resultado=@pg_Exec($conn,$sql);
header("location: Postular_form.php"); 
?>