<?php require('../../../../../util/header.inc');?>
<?php

 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	/*if($_POST["total3"]==null){
		echo $total=$_POST["total3"];
	}else{*/
	$total=$_POST["total3"];
	//}
	//for($i=0;$i<($total+$total2);$i++){
	for($i=0;$i<($total);$i++){
	$txtMatricula = ${"txtNro_Mat".$i};
	if(strlen($txtMatricula)==0){
		$txtMatricula = $txtNro_Mat[$i];
	}
	
	//$txtMatricula =$txtNro_Mat[$i];
	//$alumno = $rut_alumno[$i];
	$alumno = ${"rut_alumno".$i};
	if(strlen($alumno)==0){
		$alumno = $rut_alumno[$i];
	}
	
	
	
	
	
	//echo "-->".$txtNro_Mat[$i];
		if($txtMatricula==" " || $txtMatricula==NULL || $txtMatricula=="" ){
		    
			$qry="UPDATE matricula SET num_mat=0 WHERE rut_alumno='".trim($alumno)."' AND rdb='".trim($rdb[$i])."' AND id_ano='".trim($id_ano[$i])."' AND id_curso='".trim($id_curso[$i])."' ";
			$result = @pg_Exec($conn,$qry);
		}
		else{
		   
			$qry="UPDATE matricula SET num_mat=".$txtMatricula." WHERE rut_alumno='".trim($alumno)."' AND rdb='".trim($rdb[$i])."' AND id_ano='".trim($id_ano[$i])."' AND id_curso='".trim($id_curso[$i])."' ";
			$result = @pg_Exec($conn,$qry);
		}
		
		//echo $qry."<br>";
	}
   
  
	echo "<script>window.location = 'seteaAlumno.php3?caso=7'</script>";		

?>