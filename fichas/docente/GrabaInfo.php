<?php require('../../util/header.inc');
	//--------------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$profesor		=$_USUARIO;
	$curso			=$_CURSO;	
	//$id_info		=$id_info_aux;
	//--------------------------------
	
	if ($borrar==1){ //Elimina registro
		$sqlElimina = "delete from info_profesor where id_info = ".$id_info;
		$rsElimina = @pg_Exec($conn,$sqlElimina);
	}else{
		if ($id_info>0){
			$sqlUpdate = "update info_profesor set fecha = '".$fecha."', tipo = ".$tipo.", descripcion = '".nl2br($descripcion)."' where id_info = ".$id_info."";
			$rsUpdate = @pg_Exec($conn,$sqlUpdate);
		}else{
			//-----------------
			$sqlVerifica = "select max(id_info)+1 as cantidad, count(id_info) as cantidad2 from info_profesor";
			
			$rsVerifica = @pg_Exec($conn,$sqlVerifica );
			$fVerifica= @pg_fetch_array($rsVerifica,0); 
			if ($fVerifica['cantidad2']==0)
				$id_info = 1;
			if ($fVerifica['cantidad2']>0)
				$id_info = $fVerifica['cantidad'];
			//-----------------
			$sqlInsert = "insert into info_profesor (id_info, fecha, tipo, descripcion, rut_emp, id_ano, id_curso) values (".$id_info.",'".fEs2En($fecha)."',".$tipo.",'".nl2br($descripcion)."','".$rut_profe."',".$ano.",".$curso.")";
			$rsInsert = @pg_Exec($conn,$sqlInsert);			
		}
		
	}
	echo "<script>window.location = 'infoprofe.php'</script>";	
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>

</body>
</html>
