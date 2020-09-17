<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$alumno			=$_ALUMNO;
	$_POSP          =6;
	$_bot           =5;
	
	
	// Eliminar antes de ingresar
	$q1 = "delete from sigla_subsectoraprendisaje where rdb = '$institucion'";
	$r1 = pg_Exec($conn,$q1);
	
	$total++;
	$total++;
	
	$j = 1;
	$i = 0;
	while ($i < $total){
	   $sigla = "sigla".$j;
	   $sigla = $$sigla;
	   
	   $descripcion = "descripcion".$j;
	   $descripcion = $$descripcion;	
		
	
	    if ($sigla==NULL){
		   // nada
		}else{			
			// antes de insertar consulto si existe
			$q1 = "select * from  sigla_subsectoraprendisaje where rdb = '$institucion' and sigla = '$sigla'";
			$r2 = pg_Exec($conn,$q1);
			$n2 = pg_numrows($r2);
			
			if ($n2==0){
				 // no existe, entonces inserto
				 $q2 = "insert into sigla_subsectoraprendisaje (rdb,sigla,detalle)
				  values ('$institucion','$sigla','$descripcion')";
				 $r2 = pg_Exec($conn,$q2);				 
			}
		}
		$j++;	
		$i++;
	} 
	
	pg_close($conn);		
	echo "<script>window.location='subsectoraprendisaje.php'</script>";		
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	
	

</head>
<body>
</body>
</html>
