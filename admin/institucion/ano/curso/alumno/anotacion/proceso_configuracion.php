<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$alumno			=$_ALUMNO;
	$_POSP          =6;
	$_bot           =5;
	
	
	if (isset($actualizar)){
		/// actualizar
		$q1 = "update tipos_anotacion set codtipo = '$codigotipo', descripcion = '$descripciontipo', tipo = '$tipo' where id_tipo = '$id_tipo'";
		$r1 = pg_Exec($conn,$q1);
		
		$q1 = "delete from detalle_anotaciones where id_tipo = '$id_tipo'";
		$r1 = pg_Exec($conn,$q1);
    }
	
		
	if (isset($actualizar)){
	    // hace esto
	}else{	
	    // guardo los datos en la base de datos.
	    $q1 = "select * from tipos_anotacion where rdb = '$institucion' and codtipo = '$codigotipo' and tipo '$tipo'";
	    $r1 = pg_Exec($conn,$q1);
	    $n1 = pg_numrows($r1);
	}	
	
	if ($n1==0){
	    if (isset($actualizar)){
		    // hace esto
			// rescato el nuevo id creado
			$q3 = "select * from tipos_anotacion where codtipo = '$codigotipo'";
			$r3 = pg_Exec($conn,$q3);
			$f3 = pg_fetch_array($r3);
			//$id_tipo = $f3['id_tipo'];
		}else{	
	        // insertamos el nuevo tipo_anotacion
		    $q2 = "insert into tipos_anotacion (rdb, codtipo, descripcion, tipo) values ('$institucion','$codigotipo','$descripciontipo','$tipo')"; 
		    $r2 = pg_Exec($conn,$q2);
			
			// rescato el nuevo id creado
			$q3 = "select * from tipos_anotacion order by id_tipo Desc";
			$r3 = pg_Exec($conn,$q3);
			$f3 = pg_fetch_array($r3);
			$id_tipo = $f3['id_tipo'];
		}	
		
		
			
		// insertamos los subanotaciones
		$i = 0;
		$j = 1;
		if (isset($actualizar)){
		    $total++;
			$total++;
			$j = 0;
		}	 
		while ($i < $total){
		    $codigo = "codigo".$j;
		    $codigo = $$codigo;
			
			$descripcion = "descripcion".$j;
			$descripcion = $$descripcion;
			
			if ($codigo!=NULL){		
		        $q4 = "insert into detalle_anotaciones (id_tipo, codigo, detalle) values ('$id_tipo','$codigo','$descripcion')";
			    $r4 = pg_Exec($conn,$q4);
			}	
			
			$i++;
			$j++;
		}
	}
	
	if($_GET['elimina']==1){
		$sql = "DELETE FROM tipos_anotacion WHERE id_tipo=".$_GET['id_tipo'];
		$rs_delete = @pg_exec($conn,$sql);
	}
	
	pg_close($conn);	
	//echo "<script>alert('Continuar...'); /script>";		
	echo "<script>window.location='configurar.php'</script>";		
	

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
