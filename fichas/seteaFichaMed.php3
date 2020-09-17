<?php 
	require('../util/header.inc');

	if($caso==1){
		//SELECCIONAR FICHAS PARA ESE AÑO ACADEMICO
		$qry2="SELECT * FROM FICHA_MEDICA WHERE ID_FICHA='".$ficha."' AND RUT_ALUMNO=".$_ALUMNO." ORDER BY ID_FICHA ASC";
		$result2 =@pg_Exec($conn,$qry2);
		if (pg_numrows($result2)!=0){
			$fila2 = @pg_fetch_array($result2,0);	
			if (!$fila2){
				error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
				exit();
			}
			//PRIMERA FICHA ENCONTRADA
			echo "<script>window.location = 'fichaMedica.php3?idFicha=".$fila2['id_ficha']."'</script>";
			exit;
		}
	}else{
		//SELECCIONAR FECHAS DEL AÑO ESCOLAR
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$_ANO;
		$result =@pg_Exec($conn,$qry);
		if (pg_numrows($result)!=0){
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
				exit();
			}
			//SELECCIONAR FICHAS PARA ESE AÑO ACADEMICO
			$qry2="SELECT * FROM FICHA_MEDICA WHERE FECHA_ATENCION BETWEEN '".$fila['fecha_inicio']."' AND '".$fila['fecha_termino']."' AND RUT_ALUMNO=".$_ALUMNO." ORDER BY ID_FICHA ASC";
			$result2 =@pg_Exec($conn,$qry2);
			if (pg_numrows($result2)!=0){
				$fila2 = @pg_fetch_array($result2,0);	
				if (!$fila2){
					error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
					exit();
				}
				//PRIMERA FICHA ENCONTRADA
				echo "<script>window.location = 'fichaMedica.php3?idFicha=".$fila2['id_ficha']."'</script>";
				exit;
			}else{//SI NO HAY RESULTADOS DE FICHAS MEDICAS
				echo "<script>window.location = 'fichaMedica.php3'</script>";
				exit;
			}
		}else{//SI NO HAY RESULTADOS PARA AÑO ESCOLAR
			echo "<script>window.location = 'fichaMedica.php3'</script>";
			exit;
		}
	}
?>