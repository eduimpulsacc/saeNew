<?  require('../../../../../../../util/header.inc');
session_start();

header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");

$_SESSION['_FechaDeSeleccion'] = $_POST['datepicker'];

	if(!empty($_POST['botoncito1'])){
	
	 if(!empty($_POST['datepicker'])){
	
	//Delete 
	$del = "DELETE FROM public.asistencia_taller 
	WHERE id_taller=".$_POST['id_taller']." AND fecha ='".$_POST['datepicker']."' AND ano=".$_POST['id_ano']." ; ";
	$res = pg_Exec($conn,$del) or die (pg_last_error($conn));
	
		foreach ($alum as $i => $value) {
			$sql = "INSERT INTO public.asistencia_taller (rut_alumno,ano,id_taller,fecha)
			VALUES ( ".$alum[$i].",".$_POST['id_ano'].",".$_POST['id_taller'].",'".$_POST['datepicker']."');";
			$res = pg_Exec($conn,$sql) or die (pg_last_error($conn));
			if($res){
			  echo "INSERT OK  <br/>";
			}else{
			  echo "ERROR EN INSERT :".$sql."<br/>"; 				
			 }
		  }
	 
	 }else{
		
	   echo "Not There";
		
	  }
	  
	 }

 header("Location: asistencia_taller.php");
	
?>