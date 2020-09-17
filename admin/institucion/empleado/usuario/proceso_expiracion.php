<?php require('../../../../util/header.inc'); ?>
<?php
	$usuario	=$_ID_USER;
	$empleado	=$_EMPLEADO;
	$_INSTIT;
	$qry = "select * from cliente_prueba where rut_emp = '$empleado'";
	$result =@pg_Exec($conn,$qry);
	if(@pg_numrows($result)!=0)
	{
		$qry2 = "update cliente_prueba set primer_ingreso = '$txting', ultimo_ingreso = '$txtter', rdb = '$_INSTIT' where rut_emp = '$empleado'";
		$result =@pg_Exec($conn,$qry2);
	}else{
		$qry3 = "insert into cliente_prueba (rut_emp, rdb, primer_ingreso, ultimo_ingreso) values ('$empleado', '$_INSTIT' ,'$txting','$txtter' )";
		$result =@pg_Exec($conn,$qry3);	
	}

	echo "<script>alert('Cuenta configurada exitosamente..')</script>";
	echo "<script>window.location = '../empleado.php3?pesta=4'</script>";
?> 
