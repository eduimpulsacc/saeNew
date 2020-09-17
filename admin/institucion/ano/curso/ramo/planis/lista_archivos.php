<?php
require('../../../../../../util/header.inc');
print_r($_GET);



/************* CONSULTAR POR ARCHIVOS***************************/

	echo $sql_archivos="select rut_emp,id_curso,id_ramo from plani_archivos where rut_emp =".$_NOMBREUSUARIO;
		$result_archivos = @pg_Exec($conn, $sql_archivos);
               for ($j = 0; $j < pg_numrows($result_archivos); $j ++){
				$fila_archivos[$j] = @pg_fetch_array($result_archivos, $j, PGSQL_ASSOC) or die("Error obteniendo Archivos");	
				
					
			}	
			
			
			

?>

<table id="tabla_archivo">
algoooo
</table>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
</body>
</html>
