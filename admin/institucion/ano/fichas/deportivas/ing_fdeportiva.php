<?php require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$_POSP          =5;
	$_bot           = 5;
	/*$dd = substr($fecha,8,2);
	$mm = substr($fecha,5,2);
	$ano = substr($fecha,6,4);*/	
	
	if (!$sexo){
		$sexo=0;
	}

	if (!$seleccionado){
		$seleccionado=0;
	}
		

	$query_val="select * from alumno_oldest where rut_alumno='$alumno'";
	$result_val=pg_exec($conn,$query_val);
	$num_val=pg_numrows($result_val);
	if ($num_val<1){
			$query_insert = "insert into alumno_oldest(rut_alumno) values ('$alumno')";
			$result_insert= pg_Exec($conn,$query_insert);
	}
	
	$dia = substr($fecha,0,2);
	$mes = substr($fecha,3,2);
	$ano = substr($fecha,6,4);
	
	$fecha = "$mes-$dia-$ano";	
	
	
	// INSERTO REGISTROS EN LA NUEVA TABLA FICHA_DEPORTIVANEW
	$q1 = "insert into ficha_deportivanew (rut_alumno,fecha,observaciones,emitido) values ('$alumno','$fecha','$observaciones','$emitido')";
	$r1 = pg_Exec($conn,$q1);
	
	// CONSULTO SI HAY FICHAS DEPORTIVAS INGRESADA PARA ESTE ALUMNO
	$q2 = "select * from ficha_deportiva where rut_alumno = '$alumno'";
	$r2 = pg_Exec($conn,$q2);
	$n2 = pg_numrows($r2);
	
	if ($n2 == 0){
	    // INSERTAMOS UN REGISTRO NUEVO
		    $qry="SELECT MAX(ID_FICHA) AS CANT FROM FICHA_DEPORTIVA";
			$result =@pg_Exec($conn,$qry);
			if (!$result) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			}else{
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				}
				$newID =  $fila['cant'];
				$newID++;
		
		
		
	    		if($txtP3==""){$txtP3=0;};
			if($txtP4==""){$txtP4=0;};
			if($txtP5==""){$txtP5=0;};
			if($txtP6==""){$txtP6=0;};
			if($txtP7==""){$txtP7=0;};
			if($txtP8==""){$txtP8=0;};
			if($txtP9==""){$txtP9=0;};
			if($txtP10==""){$txtP10=0;};
			if($txtP11==""){$txtP11=0;};
			if($txtP12==""){$txtP12=0;};
			if($txtT3==""){$txtT3=0;};
			if($txtT4==""){$txtT4=0;};
			if($txtT5==""){$txtT5=0;};
			if($txtT6==""){$txtT6=0;};
			if($txtT7==""){$txtT7=0;};
			if($txtT8==""){$txtT8=0;};
			if($txtT9==""){$txtT9=0;};
			if($txtT10==""){$txtT10=0;};
			if($txtT11==""){$txtT11=0;};
			if($txtT12==""){$txtT12=0;};
			if($txtPG3==""){$txtPG3=0;};
			if($txtPG6==""){$txtPG6=0;};
			if($txtPG9==""){$txtPG9=0;};
			if($txtPG11==""){$txtPG11=0;};

				$qry="INSERT INTO FICHA_DEPORTIVA (ID_FICHA, RUT_ALUMNO, ID_ANO) VALUES (".$newID.",'".$_ALUMNO."',".$_ANO.")";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				}else{
				       $dia = substr($fechanac,0,2);
	                   $mes = substr($fechanac,3,2);
	                   $ano = substr($fechanac,6,4);
	
	                   $fechanac = "$mes-$dia-$ano";
				
				        
						//$qry="UPDATE ficha_deportiva SET  ".$newID;
						$qry="UPDATE ficha_deportiva SET pe3 = '$txtP3', pe4 = '$txtP4', pe5 = '$txtP5', pe6 = '$txtP6', pe7 = '$txtP7', pe8 = '$txtP8', pe9 = '$txtP9', pe10 = '$txtP10', pe11 = '$txtP11', pe12 = '$txtP12', ta3 = '$txtT3', ta4 = '$txtT4', ta5 = '$txtT5', ta6 = '$txtT6', ta7 = '$txtT7', ta8 = '$txtT8', ta9 = '$txtT9', ta10 = '$txtT10', ta11 = '$txtT11', ta12 = '$txtT12',    pg3 = '$txtPG3', pg6 = '$txtPG6', pg9 = '$txtPG9', pg11 = '$txtPG11', fechanac = '$fechanac', sexo = '$sexo', seleccionado = '$seleccionado', para = '$para' WHERE ID_FICHA = ".$newID;

						$result =pg_Exec($conn,$qry);
						if (!$result){
							error('<b> ERROR :</b>Error al acceder a la BD. (4)'.$qry);
						}else{
							
						}
				}
		   }		
	}else{
	    //	ACTUALIZAMOS EL REGISTRO EXISTENTE
		$f2 = @pg_fetch_array($r2,0);
		$id_ficha = $f2['id_ficha'];
		
		if($txtP3==""){$txtP3=0;};
			if($txtP4==""){$txtP4=0;};
			if($txtP5==""){$txtP5=0;};
			if($txtP6==""){$txtP6=0;};
			if($txtP7==""){$txtP7=0;};
			if($txtP8==""){$txtP8=0;};
			if($txtP9==""){$txtP9=0;};
			if($txtP10==""){$txtP10=0;};
			if($txtP11==""){$txtP11=0;};
			if($txtP12==""){$txtP12=0;};
			if($txtT3==""){$txtT3=0;};
			if($txtT4==""){$txtT4=0;};
			if($txtT5==""){$txtT5=0;};
			if($txtT6==""){$txtT6=0;};
			if($txtT7==""){$txtT7=0;};
			if($txtT8==""){$txtT8=0;};
			if($txtT9==""){$txtT9=0;};
			if($txtT10==""){$txtT10=0;};
			if($txtT11==""){$txtT11=0;};
			if($txtT12==""){$txtT12=0;};
			if($txtPG3==""){$txtPG3=0;};
			if($txtPG6==""){$txtPG6=0;};
			if($txtPG9==""){$txtPG9=0;};
			if($txtPG11==""){$txtPG11=0;};
		
		$qry="UPDATE ficha_deportiva SET pe3 = '$txtP3', pe4 = '$txtP4', pe5 = '$txtP5', pe6 = '$txtP6', pe7 = '$txtP7', pe8 = '$txtP8', pe9 = '$txtP9', pe10 = '$txtP10', pe11 = '$txtP11', pe12 = '$txtP12', ta3 = '$txtT3', ta4 = '$txtT4', ta5 = '$txtT5', ta6 = '$txtT6', ta7 = '$txtT7', ta8 = '$txtT8', ta9 = '$txtT9', ta10 = '$txtT10', ta11 = '$txtT11', ta12 = '$txtT12',   pg3 = '$txtPG3', pg6 = '$txtPG6', pg9 = '$txtPG9', pg11 = '$txtPG11', fechanac = '$fechanac', sexo = '$sexo', seleccionado = '$seleccionado', para = '$para' WHERE ID_FICHA = ".$id_ficha;
		
		$result =pg_Exec($conn,$qry);
		if (!$result){
			error('<b> ERROR :</b>Error al acceder a la BD. (5)'.$qry);
		}else{
		
		}
	}							
?>
<html>
<script type="text/JavaScript">
<!--
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

//-->
</script>
<body onLoad="MM_goToURL('parent','lista_fichadeportiva.php');return document.MM_returnValue">
</body>
</html>
