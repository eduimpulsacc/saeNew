<?php

$conn=@pg_connect("dbname=coi_usuario host=200.29.21.124 port=5432 user=postgres password=cole#newaccess");
if (!$conn){
	  error('<b>ERROR:</b>No se puede conectar a la base de datos.(1)');
	  exit;
	}

?>