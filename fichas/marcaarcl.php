<?php 
session_start();
require('../util/header.inc');

$funcion = $_POST['funcion'];

if($funcion==1){


if($per==15){$prf="apoderado";}
	if($per==16){$prf="alumno";}
//ver si usuario está en archivo
$sql_a = "select $prf from archivo where id_archivo = $ida and $prf like '%$usu%'";
$rs_a = pg_exec($conn,$sql_a);

if(pg_numrows($rs_a)==0){
	$fila_a = pg_fetch_array($rs_a,0);
	
	if($fila_a[$prf]=='0' || $fila_a[$prf]=='1'){
		echo $sql_b ="update archivo set $prf='$usu' where id_archivo=$ida";
	}
	else{
		
		$sql_c = "select $prf from archivo where id_archivo = $ida";
		$rs_c = pg_exec($conn,$sql_c);
		
		$cad = pg_result($rs_c,0).",$usu";
		echo $sql_b =  $sql_b ="update archivo set $prf='$cad' where id_archivo=$ida";
	}
	
	
	$rs_b = pg_exec($conn,$sql_b);
}


}

 ?>