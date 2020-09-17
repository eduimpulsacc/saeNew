<?php require('../../../../util/header.inc'); ?>
<?php



	$usuario	=$_ID_USER;
//	$empleado	=$_EMPLEADO;
	
	$empleado		=$_EMPLEADO;
if ($txtPW2==NULL) { 
	
	echo "<script>alert('Debe ingresar Clave Nueva.')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}
	
	
	if ($txtPW2!=$txtPW3) {	
	echo "<script>alert('La Nueva Clave no Coincide.')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}
	
	
	if ($txtPW3==NULL) { 
	
	echo "<script>alert('Debe Confirmar Clave Nueva.')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}

	if ($txtPW2==$txtPW1) { 
	
	echo "<script>alert('La Nueva Clave debe ser distinta de la Anterior.')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}
	if ($txtPW2==2005) { 
	
	echo "<script>alert('Clave No Segura')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}								
	
	
	if ($txtPW2==2006) { 
	
	echo "<script>alert('Clave No Segura')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}			
	
	
	
	if ($txtPW2==1212) { 
	
	echo "<script>alert('Clave No Segura')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}			
	
	if ($txtPW2==1999) { 
	
	echo "<script>alert('Clave No Segura')</script>";
    echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
	exit();}				
	
	
		
	if($usuario!=''){
	$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$usuario;
	}else{
	$qry="SELECT * FROM USUARIO WHERE nombre_usuario='$_NOMBREUSUARIO'";
	}
	$result =@pg_Exec($conn,$qry);

	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(1)');
	}else{
		if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
			$fila = @pg_fetch_array($result,0);	
			if($usuario==''){
				$usuario =trim($fila['id_usuario']);
			}
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
				if (strcmp(trim($fila['pw']),trim($txtPW1))){
					echo "<script>alert('Clave actual no corresponde.')</script>";
					echo "<script>window.location = 'claveAcceso.php?cram=1&modoseguro=1'</script>";
				}
				else{
				
				///NUEVO CODIGO, CAMBIA CLAVE EN COI_VINA o Corporaciones SI ES QUE EXISTE //
					$conn_vina_aux=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");
					
					echo "<br>viña-->".$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE NOMBRE_USUARIO='$_NOMBREUSUARIO'";
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					$result_vina_aux =@pg_Exec($conn_vina_aux,$qry_aux);
					$result_1 =pg_Exec($conn_vina_aux,$qry_122);

					
					$conn_corp_aux=pg_connect("dbname=coi_corporaciones host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexión.");
					
					echo "<br>corp-->".$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					$result_corp_aux =@pg_Exec($conn_corp_aux,$qry_aux);
					$result_1 =pg_Exec($conn_corp_aux,$qry_122);
					
					$conn_final=pg_connect("dbname=coi_final host=10.132.10.36 port=5432 user=postgres password=cole#newaccess");
					
					echo "<br>final-->".$qry_aux="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					$result_final_aux =@pg_Exec($conn_final,$qry_aux);
					$result_1 =pg_Exec($conn_final,$qry_122);
					
					/////// FIN NUEVO CODIGO
					/*$qry="UPDATE USUARIO SET PW='".trim($txtPW2)."' WHERE ID_USUARIO=".$usuario;
					$qry_122="UPDATE USUARIO SET IP_CON='$ip2' WHERE ID_USUARIO=".$usuario;
					
					$result =pg_Exec($conn,$qry);
			   	    $result_1 =pg_Exec($conn,$qry_122);
					if (!$result){
						error('<b> ERROR :</b>Error al acceder a la BD.(3)');
					};*/
					echo "<script>alert('Clave actual modificada exitosamente..')</script>";
					if($_PERFIL==0 || $_PERFIL==14){
						echo "<script>window.location = '../../../../session/perfilaUsuario.php'</script>";
					}
					else{
						echo "<script>window.location = '../../../../session/perfilaUsuario.php'</script>";
					}
				}
			}
		}
	}
?> 