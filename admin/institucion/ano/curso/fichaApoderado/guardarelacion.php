<?php
require('../../../../../util/header.inc');

$rut_apo	 =$_POST['rut_apo'];
$rut_alumno  =$_POST['rut_alumno'];
$responsable =$_POST['responsable'];
$sostenedor  =$_POST['sostenedor'];
$guarda_apo= $_POST['guarda_apo'];
$modifica_apo = $_POST['modifica_apo'];

 $nombre_apo=$_POST['nombre_apo'];
 $ape_pat=$_POST['ape_pat'];
 $ape_mater=$_POST['ape_mater'];
 $telefono=$_POST['telefono'];
 $celular=$_POST['celular'];
 $direccion=$_POST['direccion'];
 $numero=$_POST['numero'];
 $Region=$_POST['Region'];
 $Provincia=$_POST['Provincia'];
 $Comuna=$_POST['Comuna'];
 $lugar_trabajo=$_POST['lugar_trabajo'];
 $cmbRELACION=$_POST['cmbRELACION'];
 $nivel_edu=$_POST['nivel_edu'];
 $chkSOS=$_POST['chkSOS'];
 $profesion=$_POST['profesion'];
 $cargo=$_POST['cargo'];
 $email=$_POST['email'];
 $curso=$_POST['curso'];
 $alumno=$_POST['alumno'];

	
$rut=$_POST['rut'];
$dig=$_POST['dig'];
$inserta_apo=$_POST['inserta_apo'];



	if($guarda==1){
		
		
		 $sqld="delete from tiene2 where rut_apo=".$rut_apo." and rut_alumno=".$rut_alumno;
		$reselim=pg_Exec($conn,$sqld);
		if (!$reselim) {
		
	echo "Error al eliminar BD.(02)";
	exit;
	
	}else{
	
	echo 1; // elimino correctamente.
	}
		exit();
		}


	if($guarda_apo==1){
		//busco si tiene datos primero
		
		$sqle="select * from tiene2 where rut_apo=$rut_apo and rut_alumno=$rut_alumno and responsable=$responsable and sostenedor=$sostenedor";
		$resulte = pg_Exec($conn,$sqle);
		$cnte=pg_numrows($resulte);
		
		if($cnte==0){
  $sql="insert into tiene2 (rut_apo,rut_alumno,responsable,sostenedor)
values(".$rut_apo.",".$rut_alumno.",".$responsable.",".$sostenedor.")";

$result = pg_Exec($conn,$sql);

	if (!$result) {
			
		echo "Error al acceder a la BD.(01)";
		exit;
		
		}else{
		
		echo 1; // guardo correctamente.
		}
	}else{
		echo 2;
	}
	
		exit();

}//fin guardaapo
	
	
	
	
	if ($modifica_apo==1){
		
	
		if(!isset($chkSOS)){$chkSOS=0;}
	if(!isset($cmbRELACION)){$cmbRELACION=0;}
	//if(NULL($Provincia)){$Provincia=0;}
	//if(NULL($Comuna)){$Comuna=0;}
	
	
		
		
 $qry="Update apoderado set nombre_apo ='".$nombre_apo."', ape_pat='".$ape_pat."',ape_mat='".$ape_mater."',
	nivel_edu='".$nivel_edu."',telefono='".$telefono."',celular='".$celular."',calle='".$direccion."',
	nro='".$numero."',region='".$Region."',ciudad='".$Provincia."',Comuna='".$Comuna."',profesion='".$profesion."',cargo='".$cargo."',lugar_trabajo='".$lugar_trabajo."',email='".$email."',relacion='".$cmbRELACION."'
	WHERE rut_apo=".$rut_apo;
	
	$result =@pg_Exec($conn,$qry)or die("Fallo Update ".$qry );
	if (!$result) {
	
	error('<b> ERROR :</b>Error al acceder a la BD. (323)');
	}else{
	echo 1;
	
	
}
		exit();
		}
		
		
		if ($inserta_apo==1){
			
	if(!isset($chkSOS)){$chkSOS=0;}
	if(!isset($cmbRELACION2)){$cmbRELACION2=0;}
	
	if(!isset($Provincia)){$Provincia=0;}
	if(!isset($Comuna)){$Comuna=0;}
	
	$sqle="select * from apoderado where rut_apo=$rut";
		$resulte = pg_Exec($conn,$sqle);
		$cnte=pg_numrows($resulte);
	
	if($cnte==0){
		
	 $qry="INSERT INTO apoderado (rut_apo,dig_rut,nombre_apo,ape_pat,ape_mat,nivel_edu,telefono,celular,calle,nro,region,
	ciudad,Comuna,profesion,cargo,lugar_trabajo,email,relacion)
	VALUES(".$rut.",'".$dig."','".$nombre_apo."','".$ape_pat."','".$ape_mater."','".$nivel_edu."','".$telefono."','".$celular."','".$direccion."','".$numero."','".$Region."','".$Provincia."','".$Comuna."','".$profesion."','".$cargo."','".$lugar_trabajo."','".$email."',".$cmbRELACION.")";
	$result =@pg_Exec($conn,$qry)or die("Fallo Insert ".$qry );
	 $sql2="insert into tiene2 (rut_apo,rut_alumno,responsable,sostenedor)
values(".$rut.",".$alumno.",1,0)";

$result2 = pg_Exec($conn,$sql2);
	
	if (!$result) {
	error('<b> ERROR :</b>Error al Insertar en la BD. (K)');
	}else{
	echo 1;
	
	
}
	}else{
		echo 2;
	}
		exit();
		}
		
	
?>
