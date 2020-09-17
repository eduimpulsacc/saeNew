<?php require('../../../../../../util/header.inc');?>
<?php
	$periodo		=$_PERIODORAMO;
	//BORRA LA CALIFICACION DEL ALUMNO PARA EL RAMO EN EL PERIODO CORESSPONDIENTE
	$qry="DELETE FROM CALIFICA WHERE ID_RAMO=".$_RAMO." AND RUT_ALUMNO=".$_ALUMNO." AND ID_PERIODO=".$periodo;
	$result =pg_Exec($conn,$qry);

	$qry="INSERT INTO CALIFICA (ID_RAMO, RUT_ALUMNO, PROMEDIO, ID_PERIODO) VALUES (".$_RAMO.",'".$_ALUMNO."','".$NP."',".$periodo.")";
	$result =pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD. (3)');
		exit;
	};
		$qry="SELECT MAX(ID_NOTA) AS CANT FROM NOTA";
		$result =pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			$fila = pg_fetch_array($result,0);
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}
			$newID = trim($fila['cant']);
			$newID++;

			//BORRA TODAS LAS NOTAS DEL ALUMNO PARA ESE RAMO y PERIODO
			//$qry="DELETE FROM NOTA WHERE ID_RAMO=".$_RAMO." AND RUT_ALUMNO=".$_ALUMNO." AND ID_PERIODO=".$periodo;
			//$result =@pg_Exec($conn,$qry);

			// NOTA 1
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N1."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 2
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N2."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 3
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N3."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 4
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N4."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 5
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N5."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 6
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N6."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 7
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N7."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 8
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N8."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

			// NOTA 9
			$newID++;
			$qry="INSERT INTO NOTA (ID_NOTA, VALOR,  ID_RAMO, RUT_ALUMNO, ID_PERIODO) VALUES (".$newID.",'".$N9."',".$_RAMO.",".$_ALUMNO.",".$periodo.")";
			$result =@pg_Exec($conn,$qry);

		}
echo "<script>window.location = 'mostrarNotas.php3'</script>";
?>