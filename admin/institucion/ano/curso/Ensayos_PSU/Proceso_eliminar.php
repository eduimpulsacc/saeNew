<?php 
header( 'Content-type: text/html; charset=iso-8859-1' );

session_start();

require "Mod_Ensayo_PSU.php";

$institucion=$_INSTIT;
//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$Obj_Ensayo_Psu = new EnsayoPSU($conn);

 $sql ="delete from ensayos_psu where id_ramo=".$_POST['ramo']." and id_curso=".$_POST['curso']." and fecha='".$_POST['fecha']."'";

 //if($_PERFIL==0){echo $sql;}

	              $regis=pg_Exec($conn,$sql);
		

		if($regis){
		echo 1;
		}else{
		echo 0;
		}

?>