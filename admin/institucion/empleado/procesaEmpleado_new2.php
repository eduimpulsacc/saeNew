<? require('../../clases/OpenConnect.php');

if(!isset($caso_an)){

$caso	=trim($_GET['caso']);


if($caso=="1"){//MODIFICAR DATOS PERSONALES

	$empleado	=$_GET['empleado'];
	$valor		=$_GET['dato'];
	$campo		=$_GET['actualizar'];
	$id_estudio =trim($_GET['id_estudio']);
	$tipo		=trim($_GET['tipo']);
		if($id_estudio==0){
			$sql="UPDATE empleado SET ".$campo."='".$valor."' WHERE rut_emp=".$empleado;
			$resp = pg_exec($conn,$sql);
		}else{
			$sql="INSERT INTO empleado rut_emp,dig_ver VALUES ('".$valor."',".$id_estudio.")";
			$resp = pg_exec($conn,$sql);
		}
}
if($caso=="5"){

	$empleado	=$_GET['empleado'];
	$valor		=$_GET['dato'];
	$campo		=$_GET['actualizar'];
	$id_estudio =trim($_GET['id_estudio']);
	$tipo		=trim($_GET['tipo']);
	
		if(!$id_estudio==0){
		$sql="UPDATE trabaja SET cargo=".$valor." WHERE rut_emp=".$empleado." AND rut_emp=".$empleado." AND cargo=".$id_estudio." AND rdb=".$tipo;
		}else{
		$sql="INSERT INTO trabaja (rdb,rut_emp,cargo) VALUES (".$tipo.",".$empleado.",".$valor.")";
		}
		$resp=pg_exec($conn,$sql);

}	
if($caso=="2"){//MODIFICAR titulos,postitulos,posgrados,cursos

	$empleado	=$_GET['empleado'];
	$valor		=trim($_GET['dato']);
	$campo		=trim($_GET['actualizar']);
	$id_estudio =trim($_GET['id_estudio']);
	$tipo		=trim($_GET['tipo']);
	
	if($id_estudio != 0){
			$sql="UPDATE empleado_estudios SET ".$campo."='".$valor."' ";
			$sql.=" WHERE rut_empleado=".$empleado." AND id_estudio=".$id_estudio." AND tipo=".$tipo;
			$resp = pg_exec($conn,$sql);
			
	}
	if($id_estudio == 0){		
				$sql_1="SELECT MAX(id_estudio) AS id_estudio FROM empleado_estudios";
				$resp_1 = pg_exec($conn,$sql_1);
				$f_id_estudio 	=pg_fetch_array($resp_1,0);
				$id_estudio		=$f_id_estudio['id_estudio'];
				$new_id_estudio	=$id_estudio+1;
				
					$sql_2="SELECT MAX(orden) AS orden FROM empleado_estudios WHERE rut_empleado=".$empleado;
					$resp_2 = pg_exec($conn,$sql_2);
					$f_orden_titulo 	=pg_fetch_array($resp_2,0);
					$orden_titulo 		=$f_orden_titulo['orden'];
					$new_orden_titulo	=$orden_titulo+1;
				
				$sql_3 ="INSERT INTO empleado_estudios (id_estudio,rut_empleado,nombre,tipo,orden) ";
				$sql_3.="VALUES ('".$new_id_estudio."','".$empleado."','".$valor."' ";
				$sql_3.=",".$tipo.",".$new_orden_titulo.")";
				$resp_3 = pg_exec($conn,$sql_3);
					
	}
}
if($caso=="3"){//Modificar habilitaciones ingresadas
	$empleado	=$_GET['empleado'];
	$valor		=trim($_GET['dato']);
	$campo		=trim($_GET['actualizar']);
	$id_estudio =trim($_GET['id_estudio']);
	$tipo		=trim($_GET['tipo']);
	
	$sql="UPDATE habilitaciones SET ".$campo."='".$valor."' WHERE id_aux =".$id_estudio." AND rut_emp=".$empleado;
	$resp = pg_exec($conn,$sql);

}
}else{
//Codigo Antiguo

if (($pesta==2) and ($eli==1)){
    $q1 = "delete from habilitaciones where id_aux = '$id_aux'";
	$r1 = pg_Exec($conn,$q1);	
	
	
	echo "<script>window.location='empleado_new2.php?pesta=2&m1=1'</script>";
	exit();	
	
}	   

if (($pesta==2) and ($h==1)){ 
echo "aki";  
    // primero consutlo si existe tal registro
	$q1 = "select * from habilitaciones where rut_emp = '$rut_emp' and id_ano = '$_ANO' and cod_subsector = '$cmb_subsector' and tipo_ense = '$cmb_tipoensenanza'";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	
	if (($c1!=1) OR (!isset($c1))){
	    $c1=0;
	}
	if (($c2!=1) OR (!isset($c2))){
	    $c2=0;
	}
	if (($c3!=1) OR (!isset($c3))){
	    $c3=0;
	}
	if (($c4!=1) OR (!isset($c4))){
	    $c4=0;
	}
	if (($c5!=1) OR (!isset($c5))){
	    $c5=0;
	}
	if (($c6!=1) OR (!isset($c6))){
	    $c6=0;
	}
	if (($c7!=1) OR (!isset($c7))){
	    $c7=0;
	}
	if (($c8!=1) OR (!isset($c8))){
	    $c8=0;
	}
	if (($EP!=1) OR (!isset($EP))){
	    $EP=0;
	}
	if (($EDA!=1) OR (!isset($EDA))){
	    $EDA=0;
	}
	if (($EDM!=1) OR (!isset($EDM))){
	    $EDM=0;
	}
	if (($EDV!=1) OR (!isset($EDV))){
	    $EDV=0;
	}
	if (($EAL!=1) OR (!isset($EAL))){
	    $EAL=0;
	}
	if (($ETM!=1) OR (!isset($ETM))){
	    $ETM=0;
	}
	if (($EA!=1) OR (!isset($EA))){
	    $EA=0;
	}
	
	
		
	$dd = substr($h_fecha,0,2);
	$mm = substr($h_fecha,3,2);
	$aa = substr($h_fecha,6,4);
	$h_fecha = "$aa-$mm-$dd";
		
			
	if ($n1==0){ // ingreso la habilitacion
	   $q2 = "insert into habilitaciones (rut_emp, fecha, id_ano, resolucion, inscripcion, tipo_aut, cod_subsector, tipo_ense, c1, c2, c3, c4, c5, c6, c7, c8, EP, EDA, EDM, EDV, EAL, ETM, EA)
		values ('".$rut_emp."','".$h_fecha."','$_ANO','$h_resolucion','$h_inscripcion','$h_tipo_aut','$cmb_subsector','$cmb_tipoensenanza','$c1','$c2','$c3','$c4','$c5','$c6','$c7','$c8','$EP','$EDA','$EDM','$EDV','$EAL','$ETM','$EA')";   
       echo $q2;
	    $r2 = pg_Exec($conn,$q2);
		
		// actualizo en la tabla empleado
		$q22 = "update empleado set titulo = '0', habilitado = '1', fecha_resol = '$h_fecha', nu_resol = '$h_resolucion' where rut_emp = '$rut_emp'";
		$r22 = @pg_Exec($conn,$q22);
	}	
		
			
	echo "<script>window.location='empleado_new2.php?pesta=2&m1=1'</script>";
	exit();	

}	
if (($pesta == 5) and ($borrar == 1)){
       // borrar
	   $q1 = "delete from relacion_grupo where rut_integrante = '".trim($_EMPLEADO)."' and id_grupo = '$id_grupo'";
	   $r1 = pg_Exec($conn,$q1);
	   
	   echo "<script>window.location='empleado_new2.php?pesta=5'</script>";
	   exit();
}	


if (($pesta==5) and ($graba==1)){
       // Agregar grupo al alumno
	   echo $q1 = "select * from grupos where rdb=".trim($rdb)." order by id_grupo Desc";
	   $rs = pg_exec($conn,$q1);
	   $n1 = pg_numrows($rs);	   
	   $i = 0;
	   while ($i < $n1){
		  
	   for($x=0;$x<$n1;$x++)
		   $f1=pg_fetch_array($rs,$i);
		   {
		   	   $chg = "chg".$x;
		       $chg = $$chg;	   
	
		   if (trim($chg) == trim($id_grupo)){		     			  			   
		      // antes de agregar consultar si ya existe
			 echo "<br />".$q3 = "select * from relacion_grupo where id_grupo =".$f1['id_grupo']." and rut_integrante = '".trim($_EMPLEADO)."'";
			  $r3 = pg_Exec($conn,$q3);
			  $n3 = pg_numrows($r3);
			  if ($n3==0){  // Inserto		   
			      // debo rescatar el perfil del empleado
				  //$q3 = "select * from accede, usuario where accede.id_usuario = usuario.id_usuario and usuario.nombre_usuario = '$_EMPLEADO'    
			  			  
		   		  // Agrego al alumno en detalle_grupos			   
				 echo "<br />".$q2 = "insert into relacion_grupo (id_grupo, rut_integrante, id_ano)
				  values (".$f1['id_grupo'].",'".trim($_EMPLEADO)."','$_ANO')";
				  $r2 = pg_Exec($conn,$q2);
								   
				  // registro insertado
			   }	   
		   }
		  }
		   $i++;
	   }	   	    

	   // fin proceso
	  echo "<script>window.location = 'empleado_new2.php?pesta=5'</script>";
	  
	   exit();
}	 
}
?>


