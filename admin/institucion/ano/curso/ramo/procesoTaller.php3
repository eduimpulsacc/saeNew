<?php 

//print_r($_POST);

require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$institucion	=$_INSTIT;
		  
		  if($truncado) $truncado=1;	else	$truncado=0;

if ($frmModo=="ingresar") {
          
	      if($ip)		$ip=1;		else	$ip=0;
	      if($sar)		$sar=1;		else	$sar=0;
		  if($truncado) $truncado=1;	else	$truncado=0;
		  if ($alumno_taller=="") $alumno_taller=0;
		  if($NomTall!=""){
		  	$taller=$NomTall;
		     }

		$qry="INSERT INTO TALLER (NOMBRE_TALLER,RDB, ID_ANO, MODO_EVAL,TRUNCADO,alumno_elige_taller) VALUES	('".$taller."'," . $institucion . ",".$ano.",".$cmbMODO.",'".$truncado."',".$alumno_taller.")";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al acceder a la BD. (3)'.$qry);
			exit;
		}
		
		$qry="SELECT MAX(ID_TALLER) AS taller FROM TALLER WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
			if (!$result){
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
				exit;
	   		}
		$fila = @pg_fetch_array($result,0);	
		if (!$fila){
			error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
			exit();
		}
		$newID = trim($fila['taller']);

	if($cmbDOC!=0){
	 $qry="INSERT INTO DICTA_TALLER (RUT_EMP,ID_TALLER,ACARGO) VALUES ('".$cmbDOC."',".$newID.",1)";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(41)'.$qry);
		exit;
	}
	}
	if($cmbDOCIMP!=0){
	 $sql="INSERT INTO DICTA_TALLER (RUT_EMP,ID_TALLER,ACARGO) VALUES ('".$cmbDOCIMP."',".$newID.",default)";
	$result =@pg_Exec($conn,$sql);
	if (!$result) {
		error('<b> ERROR :</b>Error al acceder a la BD.(42)'.$sql);
		exit;
	}
	}
	
	 echo "<script>window.location = 'listarTalleres.php3?ano=".$_ANO."'</script>";
}

if ($frmModo=="modificar") {

for($x=0 ; $x < $des ; $x++){
	$alu = "alu".$x;
	$alu = $$alu;	
	if($alu!=0){
			$qryA="SELECT rut_alumno, id_taller FROM tiene_taller  WHERE rut_alumno= '$alu' AND id_taller='$_TALLER'";
			$resultA =@pg_Exec($conn,$qryA);
		if(pg_numrows($resultA)==0){
			$qryT="INSERT INTO TIENE_TALLER (RUT_ALUMNO, ID_TALLER) VALUES  ('$alu','$_TALLER')";
			$resultT =@pg_Exec($conn,$qryT);
		} 
	} 


}

               for ($i=0;$i<$ins;$i++) { 
			   	$alum = "alum".$i;
				$alum = $$alum;	
				echo $alum;
				
			 	if ($alum){			   
				   $qryA="DELETE  FROM TIENE_TALLER  WHERE ((rut_alumno='".${"alum".$i}."') AND (id_taller='".$_TALLER."')) ";
					$resultA =@pg_Exec($conn,$qryA);
                     }
				}

  	                if($ip)		$ip=1;		else	$ip=0;
	                 if($sar)		$sar=1;		else	$sar=0;
					 if ($txtPCT=="") $txtPCT=0;
					 if ($txtNEXIM=="") $txtNEXIM=0;
					 if ($alumno_taller=="") $alumno_taller=0;
					    if ($_PERFIL!=17){
	$qry="UPDATE taller SET pct_examen = '".$txtPCT."', nota_exim = '".$txtNEXIM."',  modo_eval = ".$cmbMODO.", truncado = ".$truncado.",alumno_elige_taller=".$alumno_taller." WHERE (((id_taller)=".$_TALLER."))";
	$result =@pg_Exec($conn,$qry);
	}
if((!$result) and ($_PERFIL!=17))
	error('<b> ERROR :</b>Error al acceder a la BD. (311)'.$qry);
else{
	echo $qry2	="SELECT * FROM DICTA_TALLER WHERE ID_TALLER=".$_TALLER;

	$result2=pg_Exec($conn,$qry2);
	if($cmbDOC!=0){
		if(pg_numrows($result2)!=0){
			//echo"<br>111->".$qry="UPDATE DICTA_TALLER SET RUT_EMP='".$cmbDOC."',  acargo=1 WHERE ID_TALLER=".$_TALLER."";
			
			$sql = "DELETE FROM dicta_taller WHERE ID_TALLER=".$_TALLER." AND acargo=1";
			$rs_delete = pg_exec($conn,$sql);
			
			$qry="INSERT INTO DICTA_TALLER (RUT_EMP, ID_TALLER,ACARGO) VALUES ('".$cmbDOC."',".$_TALLER.",1)";
		}else{
			echo"<br>".$qry="INSERT INTO DICTA_TALLER (RUT_EMP, ID_TALLER,ACARGO) VALUES ('".$cmbDOC."',".$_TALLER.",1)";
		}
		$result =@pg_Exec($conn,$qry);
	}
							   
	if($cmbDOCIMP!=0){
		echo"<br>".$qry2="SELECT * FROM DICTA_TALLER WHERE ID_TALLER=".$_TALLER." and acargo=0";
		$result3=pg_Exec($conn,$qry2);	
			
		if(pg_numrows($result3)==1){
			//echo"<br>".$qry="UPDATE DICTA_TALLER SET RUT_EMP='".$cmbDOCIMP."', acargo=0 WHERE ID_TALLER=".$_TALLER."";
			$qry = "DELETE FROM dicta_taller WHERE ID_TALLER=".$_TALLER." AND acargo=0";
			$result =@pg_Exec($conn,$qry);
			
			$qry="INSERT INTO DICTA_TALLER (RUT_EMP, ID_TALLER,ACARGO) VALUES ('".$cmbDOCIMP."',".$_TALLER.",0)";
			$result =@pg_Exec($conn,$qry);
		}else{
		echo"<br>".$qry="INSERT INTO DICTA_TALLER (RUT_EMP, ID_TALLER,ACARGO) VALUES ('".$cmbDOCIMP."',".$_TALLER.",0)";
		$result =@pg_Exec($conn,$qry);
		}
	
	}else{
		
		$qry = "DELETE FROM dicta_taller WHERE ID_TALLER=".$_TALLER." AND acargo=0";
		$result =@pg_Exec($conn,$qry);
	}
						   
		   
			
						
		}
		
		//if($_PERFIL==0){
			
			//break;
			//}else{
		
		 echo "<script>window.location = 'seteaTaller.php3?caso=1&taller=".$_TALLER."&plan=".$_PLAN."'</script>";
			//}
		}



 if ($frmModo=="eliminar") {
 
			$qry2="DELETE FROM DICTA_TALLER WHERE ID_TALLER=".$_TALLER;
			$result2 =@pg_Exec($conn,$qry2);
			if (!$result2) {
		         error('<b> ERROR :</b>Error al eliminar.(511)'.$qry2);
	         }
										 
	       $qry="DELETE FROM TALLER WHERE ID_TALLER=".$_TALLER;
	        $result =@pg_Exec($conn,$qry);
	           if (!$result) {
		         error('<b> ERROR :</b>Error al eliminar.(512)'.$qry);
	         }else{
		        echo "<script>window.location = 'listarTalleres.php3?plan=".$_PLAN."'</script>";
	           }
        }
         ?>