<?php require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;

if ($frmModo=="modificar") {
	if($idFicha=="")
			$idFicha=0;
	//VERIFICAR EXISTENCIA PREVIA DE LA FICHA
	$qry="SELECT * FROM FICHA_MEDICA WHERE ID_FICHA=".$idFicha;
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		if(pg_numrows($result)!=0){//OSEA 1
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

			$qry="UPDATE ficha_deportiva SET pe3 = ".$txtP3.", pe4 = ".$txtP4.", pe5 = ".$txtP5.", pe6 = ".$txtP6.", pe7 = ".$txtP7.", pe8 = ".$txtP8.", pe9 = ".$txtP9.", pe10 = ".$txtP10.", pe11 = ".$txtP11.", pe12 = ".$txtP12.", ta3 = ".$txtT3.", ta4 = ".$txtT4.", ta5 = ".$txtT5.", ta6 = ".$txtT6.", ta7 = ".$txtT7.", ta8 = ".$txtT8.", ta9 = ".$txtT9.", ta10 = ".$txtT10.", ta11 = ".$txtT11.", ta12 = ".$txtT12.", pg3 = ".$txtPG3.", pg6 = ".$txtPG6.", pg9 = ".$txtPG9.", pg11 = ".$txtPG11." WHERE rut_alumno ='".trim($_ALUMNO)."' AND id_ano = ".$_ANO;
			$result =@pg_Exec($conn,$qry);
			if (!$result){
				error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
				}else{
					echo "<script>window.location = 'seteaFicha.php3?caso=1&alumno=".$_ALUMNO."'</script>";
			}
		}else{//INSERTAR UNA Y ACTUALIZARLA

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
						$qry="UPDATE ficha_deportiva SET  ".$newID;
						$qry="UPDATE ficha_deportiva SET pe3 = ".$txtP3.", pe4 = ".$txtP4.", pe5 = ".$txtP5.", pe6 = ".$txtP6.", pe7 = ".$txtP7.", pe8 = ".$txtP8.", pe9 = ".$txtP9.", pe10 = ".$txtP10.", pe11 = ".$txtP11.", pe12 = ".$txtP12.", ta3 = ".$txtT3.", ta4 = ".$txtT4.", ta5 = ".$txtT5.", ta6 = ".$txtT6.", ta7 = ".$txtT7.", ta8 = ".$txtT8.", ta9 = ".$txtT9.", ta10 = ".$txtT10.", ta11 = ".$txtT11.", ta12 = ".$txtT12.", pg3 = ".$txtPG3.", pg6 = ".$txtPG6.", pg9 = ".$txtPG9.", pg11 = ".$txtPG11." WHERE ID_FICHA = ".$newID;

						$result =@pg_Exec($conn,$qry);
						if (!$result){
							error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
							}else{
								echo "<script>window.location = 'seteaFicha.php3?caso=1&alumno=".trim($_ALUMNO)."'</script>";
						}
				}
			}
		}
	}
}
?>