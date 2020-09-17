<?php require('../../../util/header.inc');?>
<?php

   $rut_emp=trim($_GET['rut_emp']);
   $nombre_emp=trim($_GET['nombre_emp']);
   $dig=trim($_GET['dig']);
   $nacionalidad=trim($_GET['nacionalidad']);
   $ape_pat=trim($_GET['ape_pat']);
   $ape_mat=trim($_GET['ape_mat']);
   $telefono=trim($_GET['telefono']);
   $telefono2=trim($_GET['telefono2']);
   $telefono3=trim($_GET['telefono3']);
   $email=trim($_GET['email']);
   $sexo=trim($_GET['sexo']);
   $fecha_nac=trim($_GET['fecha_nac']);
   $fecha_ing=trim($_GET['fecha_ing']);
   $afp=trim($_GET['afp']);
   $salud=trim($_GET['salud']);
   $horas=trim($_GET['horas']);
   if ($horas==NULL){
       $horas=0;
   }
   $estado_civil=trim($_GET['estado_civil']);
   $atencion=trim($_GET['atencion']);
   $calle=trim($_GET['calle']);
   $nro=trim($_GET['nro']);
   $dpto=trim($_GET['dpto']);
   $block=trim($_GET['block']);
   $villa_pob=trim($_GET['villa_pob']);
   $region=trim($_GET['region']);
   $provincia=trim($_GET['provincia']);
   $comuna=trim($_GET['comuna']);
   
   $region = str_replace("region","",$region);
   
   $provincia = str_replace("reg13","",$provincia);
   $provincia = str_replace("reg12","",$provincia);
   $provincia = str_replace("reg11","",$provincia);
   $provincia = str_replace("reg10","",$provincia);
   $provincia = str_replace("reg9","",$provincia);
   $provincia = str_replace("reg8","",$provincia);
   $provincia = str_replace("reg7","",$provincia);
   $provincia = str_replace("reg6","",$provincia);
   $provincia = str_replace("reg5","",$provincia);
   $provincia = str_replace("reg4","",$provincia);
   $provincia = str_replace("reg3","",$provincia);
   $provincia = str_replace("reg2","",$provincia);
   $provincia = str_replace("reg1","",$provincia);
   
   $provincia = str_replace("prov","",$provincia);  
   
   
   $q1 = "insert into empleado (rut_emp, nombre_emp, dig_rut, ape_pat, ape_mat, nacionalidad, telefono, telefono2, telefono3, email, sexo, prevision, sistema_salud, hxclase, estado_civil, atencion, calle, nro, depto, block, villa, region, ciudad, comuna) values ('$rut_emp','$nombre_emp','$dig','$ape_pat','$ape_mat','$nacionalidad','$telefono','$telefono2','$telefono3','$email','$sexo','$afp','$salud','$horas','$estado_civil','$atencion','$calle','$nro','$dpto','$block','$villa_pob', '$region', '$provincia', '$comuna')";
   $r1 = pg_Exec($conn,$q1);
   
   if ($fecha_nac!=NULL){
        $sql = "update empleado set fecha_nacimiento = '$fecha_nac' where rut_emp = '$rut_emp'";
		$res = pg_Exec($conn,$sql); 
   }
   if ($fecha_ing!=NULL){
        $sql = "update empleado set fecha_ingreso = '$fecha_ing' where rut_emp = '$rut_emp'";
		$res = pg_Exec($conn,$sql);
   }  	
	
?>