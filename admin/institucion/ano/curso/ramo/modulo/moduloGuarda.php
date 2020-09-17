<?php 
require('../../../../../../util/header.inc');

//var_dump($_POST);

//elimino todo lo del ramo
 $sql0="delete from relacion_ramo where id_ramo_padre=".$_POST['padre'];
 $regis = pg_Exec( $conn,$sql0 ) or die( "Error bd anos" );
 

//rescato a los hijos

for($i=0;$i<count($_POST['hijo']);$i++){
	
	 $hijo=$_POST['hijo'][$i];
	//inserto
	 $sql1="insert into relacion_ramo values(".$_POST['padre'].",".$hijo.",".$_POST['cur'].",".$_ANO.");";
	$regis2 = pg_Exec( $conn,$sql1 ) or die( "Error bd anos" );
	

}

if($regis && $regis2){echo 1;}else{echo 0;}
?>