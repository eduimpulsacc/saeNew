<?php require('../../../util/header.inc');

 $frmModo= $_FRMMODO;
 $ano= $_ANO;
 $institucion= $_INSTIT;

 
if($frmModo=="ingresar"){
	
	for($i=0;$i<$cont_docente;$i++){ //INGRESO DOCENTE
	
		$rut_docente = ${"rut_docente".$i}; 
		
		$cargo_docente = ${"cargo_docente".$i};
		
		$cmb_docente = ${"cmb_DOCENTE".$i}; 	
		if(!is_numeric($cmb_docente)) $cmb_docente=0;
		if($cmb_docente=="") $cmb_docente=0;
		
		$hrs_contrato = ${"hrs_contrato".$i}; 
		if(!is_numeric($hrs_contrato)) $hrs_contrato=0;
		if($hrs_contrato=="") $hrs_contrato=0;
		
		$art_69 = ${"art_69".$i};		
		if(!is_numeric($art_69)) $art_69=0;
		if($art_69=="") $art_69=0;
		
		$amp_simple		= ${"amp_simple".$i};	
		if($amp_simple=="") $amp_simple=0;
		
		$amp_jec= ${"amp_jec".$i};
		if(!is_numeric($amp_jec)) $amp_jec=0;		
		if($amp_jec=="") $amp_jec=0;
		
		$hrs_total		= ${"hrs_total".$i};	
		if(!is_numeric($hrs_total)) $hrs_total=0;
		if($hrs_total=="") $hrs_total=0;
		
		$hrs_excedente= ${"hrs_excedente".$i};
		if(!is_numeric($hrs_excedente)) $hrs_excedente=0;
		if($hrs_excedente=="") $hrs_excedente=0;
		
		$asignatura = ${"asignatura".$i};	
		if(!is_numeric($asignatura)) $asignatura=0;
		if($asignatura=="") $asignatura=0;
		
		$obs = ${"obs".$i};	
		if($obs=="") $obs=0;
		
		$sql = "INSERT INTO dotacion_docente (rdb,id_ano,rut_emp,cargo,tipo_emp,hrs_contrato,art_69,amp_simple,amp_jec,total_aula,hrs_excedente,cargo_asig,obs) VALUES ( ";
		$sql.= " '".$institucion."','".$ano."','".$rut_docente."','".$cargo_docente."','".$cmb_docente."','".$hrs_contrato."','".$art_69."','".$amp_simple."','".$amp_jec."', ";
		$sql.= " '".$hrs_total."','".$hrs_excedente."','".$asignatura."','".$obs."') ";
		$rs_docente = @pg_exec($conn,$sql) or die ("INSERT FALLO (docente)".$sql);		
	}
	for($j=0;$j<$cont_director;$j++){// INGRESO DIRECTIVO
		$rut_director	= ${"rut_director".$j};		
		$cargo_director	= ${"cargo_director".$j};
		$cmb_directivo	= ${"cmb_DIRECTIVO".$j};	if($cmb_directivo=="") $cmb_directivo=0;
		$hrs_contrato_d	= ${"hrs_contrato_d".$j};	if($hrs_contrato_d=="") $hrs_contrato_d=0;
		$amp_simple_d	= ${"amp_simple_d".$j};		if($amp_simple_d=="") $amp_simple_d=0;
		$total_hrs_d	= ${"total_hrs_d".$j};		if($total_hrs_d=="") $total_hrs_d=0;
		$tipo_func_d	= ${"tipo_func_d".$j};		if($tipo_func_d=="") $tipo_func_d=0;
		
		$sql = " INSERT INTO dotacion_docente (rdb,id_ano,rut_emp,cargo,tipo_emp,hrs_contrato,amp_simple,total_aula,tipo_func ) VALUES ( ";
		$sql.= " '".$institucion."','".$ano."','".$rut_director."','".$cargo_director."','".$cmb_directivo."','".$hrs_contrato_d."','".$amp_simple_d."','".$total_hrs_d."', ";
		$sql.= " '".$tipo_func_d."' )";
		$rs_directivo = @pg_exec($conn,$sql) or die ("INSERT FALLO (directivo) :".$sql);
	}
	for($x=0;$x<$cont_tecnico;$x++){
		$rut_tecnico	= ${"rut_tecnico".$x};
		$cargo_tecnico	= ${"cargo_tecnico".$x};
		$cmb_tecnico	= ${"cmb_TECNICO".$x};		if($cmb_tecnico=="") $cmb_tecnico=0;
		$hrs_contrato_t	= ${"hrs_contrato_t".$x};	if($hrs_contrato_t=="") $hrs_contrato_t=0;
		$amp_simple_t	= ${"amp_simple_t".$x};		if($amp_simple_t=="") $amp_simple_t=0;
		$total_hrs_t	= ${"total_hrs_t".$x};		if($total_hrs_t=="") $total_hrs_t=0;
		$tipo_func_t	= ${"tipo_func_t".$x};		if($tipo_func_t=="") $tipo_func_t=0;
		
		$sql = " INSERT INTO dotacion_docente (rdb, id_ano, rut_emp,cargo, tipo_emp, hrs_contrato, amp_simple, total_aula, tipo_func ) VALUES ( ";
		$sql.= " '".$institucion."','".$ano."','".$rut_tecnico."','".$cargo_tecnico."','".$cmb_tecnico."','".$hrs_contrato_t."','".$amp_simple_t."', ";
		$sql.= " '".$total_hrs_t."','".$tipo_func_t."' )";
		$rs_tecnico = @pg_exec($conn,$sql) or die ("INSERT FALLO (TECNICO :".$sql);
	}
}




if($frmModo=="modificar"){
for($i=0;$i<$cont_docente;$i++){ //INGRESO DOCENTE


		$rut_docente 	= ${"rut_docente".$i}; 
		$cargo_docente	= ${"cargo_docente".$i};
		
		$cmb_docente 	= ${"cmb_DOCENTE".$i}; 	
		if(!is_numeric($cmb_docente)) $cmb_docente=0;
		if($cmb_docente=="") $cmb_docente=0;
		
		$hrs_contrato	= ${"hrs_contrato".$i};
		if(!is_numeric($hrs_contrato)) $hrs_contrato=0;
		 if($hrs_contrato=="") $hrs_contrato=0;
		
		$art_69	= ${"art_69".$i};		
		if(!is_numeric($art_69)) $art_69=0;
		if($art_69=="") $art_69=0;
		
		$amp_simple	= ${"amp_simple".$i};	
		if(!is_numeric($amp_simple)) $amp_simple=0;
		if($amp_simple=="") $amp_simple=0;
		
		$amp_jec= ${"amp_jec".$i};		
		if(!is_numeric($amp_jec)) $amp_jec=0;
		if($amp_jec=="") $amp_jec=0;
		
		$hrs_total= ${"hrs_total".$i};	
		if(!is_numeric($hrs_total)) $hrs_total=0;
		if($hrs_total=="") $hrs_total=0;
		
		$hrs_excedente= ${"hrs_excedente".$i};
		if(!is_numeric($hrs_total)) $hrs_total=0;
		if($hrs_excedente=="") $hrs_excedente=0;
		
		$asignatura= ${"asignatura".$i};	
		if(!is_numeric($asignatura)) $asignatura=0;
		if($asignatura=="") $asignatura=0;
		
		$obs= ${"obs".$i};
		if($obs=="") $obs=0;
		
		
		$sql = "SELECT * FROM dotacion_docente 
		WHERE rut_emp=".$rut_docente." AND rdb=".$institucion." AND id_ano=".$ano." AND  cargo=".$cargo_docente." ; ";
		
		$rs_docente = @pg_exec($conn,$sql) or die ("SELECT FALLO (docente)".$sql);	
		
		if(pg_num_rows($rs_docente)==0){
			   
		$sql = "INSERT INTO dotacion_docente (rdb,id_ano,rut_emp,cargo,tipo_emp,hrs_contrato,art_69,amp_simple,amp_jec,total_aula,hrs_excedente,cargo_asig,obs) VALUES ( ";
		$sql.= " '".$institucion."','".$ano."','".$rut_docente."','".$cargo_docente."','".$cmb_docente."','".$hrs_contrato."','".$art_69."','".$amp_simple."','".$amp_jec."', ";
		$sql.= " '".$hrs_total."','".$hrs_excedente."','".$asignatura."','".$obs."') ";
		
		$rs_docente = @pg_exec($conn,$sql) or die ("INSERT FALLO (docente)".$sql);	
		
		}else{
		
		$sql = "UPDATE dotacion_docente SET ";
		$sql.= "tipo_emp='".$cmb_docente."', hrs_contrato='".$hrs_contrato."', art_69='".$art_69."', amp_simple='".$amp_simple."', amp_jec='".$amp_jec."', ";
		$sql.= "total_aula='".$hrs_total."', hrs_excedente='".$hrs_excedente."', cargo_asig='".$asignatura."', obs='".$obs."' WHERE rdb='".$institucion."' ";
		$sql.= "AND id_ano='".$ano."' AND  rut_emp='".$rut_docente."' AND  cargo='".$cargo_docente."'";
		
		$rs_docente = @pg_exec($conn,$sql) or die ("UPDATE FALLO (docente)".$sql);		
	    		
		}
		
		//echo "<br>querInsDocente->".$sql;
	}
	
	
	for($j=0;$j<$cont_director;$j++){
		
		$rut_director	= ${"rut_director".$j};		
		$cargo_director	= ${"cargo_director".$j};
		
		$cmb_directivo	= ${"cmb_DIRECTIVO".$j};	
		if(!is_numeric($cmb_directivo)) $cmb_directivo=0;
		if($cmb_directivo=="") $cmb_directivo=0;
		
		$hrs_contrato_d	= ${"hrs_contrato_d".$j};
		if(!is_numeric($hrs_contrato_d)) $hrs_contrato_d=0;	
		if($hrs_contrato_d=="") $hrs_contrato_d=0;
		
		$amp_simple_d	= ${"amp_simple_d".$j};		
		if(!is_numeric($amp_simple_d)) $amp_simple_d=0;
		if($amp_simple_d=="") $amp_simple_d=0;
		
		$total_hrs_d	= ${"total_hrs_d".$j};
		if(!is_numeric($total_hrs_d)) $total_hrs_d=0;		
		if($total_hrs_d=="") $total_hrs_d=0;
		
		$tipo_func_d	= ${"tipo_func_d".$j};		
		if(!is_numeric($tipo_func_d)) $tipo_func_d=0;
		if($tipo_func_d=="") $tipo_func_d=0;
		
		
			$sql = "SELECT * FROM dotacion_docente 
		WHERE rut_emp=".$rut_director." AND rdb=".$institucion." AND id_ano=".$ano." AND  cargo=".$cargo_director." ; ";
		
		$rs_docente = @pg_exec($conn,$sql) or die ("SELECT FALLO (director)".$sql);	
		
		if(pg_num_rows($rs_docente)==0){
			   
		$sql = "INSERT INTO dotacion_docente (rdb,id_ano,rut_emp,cargo,tipo_emp,hrs_contrato,art_69,amp_simple,amp_jec,total_aula,hrs_excedente,cargo_asig,obs,tipo_func) VALUES ( ";
		$sql.= " '".$institucion."','".$ano."','".$rut_director."','".$cargo_director."','".$cmb_directivo."','".$hrs_contrato_d."','0','".$amp_simple_d."','0', ";
		$sql.= " '".$total_hrs_d."','0','0','".$obs."','".$tipo_func_d."') ";
		
		$rs_docente = @pg_exec($conn,$sql) or die ("INSERT FALLO (docente)".$sql);	
		
		}else{
						
		$sql = " UPDATE dotacion_docente SET  ";
		$sql.= " tipo_emp='".$cmb_directivo."', hrs_contrato='".$hrs_contrato_d."', amp_simple='".$amp_simple_d."', total_aula='".$total_hrs_d."', ";
		$sql.= " tipo_func='".$tipo_func_d."' WHERE rdb='".$institucion."' AND  id_ano='".$ano."' AND rut_emp='".$rut_director."' AND cargo='".$cargo_director."' ";
		$rs_directivo = @pg_exec($conn,$sql) or die ("UPDATE FALLO (directivo) :".$sql);
		
		}
		
		//echo "<br>queryInsDirectivo->".$sql;
		
	}

	for($x=0;$x<$cont_tecnico;$x++){
		$rut_tecnico	= ${"rut_tecnico".$x};
		$cargo_tecnico	= ${"cargo_tecnico".$x};
		
		$cmb_tecnico	= ${"cmb_TECNICO".$x};		
		if($cmb_tecnico=="") $cmb_tecnico=0;
		if(!is_numeric($cmb_tecnico)) $cmb_tecnico=0;
		
		$hrs_contrato_t	= ${"hrs_contrato_t".$x};	
		if($hrs_contrato_t=="") $hrs_contrato_t=0;
		if(!is_numeric($hrs_contrato_t)) $hrs_contrato_t=0;
		
		$amp_simple_t	= ${"amp_simple_t".$x};		
		if($amp_simple_t=="") $amp_simple_t=0;
		if(!is_numeric($amp_simple_t)) $amp_simple_t=0;
		
		$total_hrs_t	= ${"total_hrs_t".$x};
		if(!is_numeric($total_hrs_t)) $total_hrs_t=0;		
		if($total_hrs_t=="") $total_hrs_t=0;
			
		$tipo_func_t	= ${"tipo_func_t".$x};		
		if($tipo_func_t=="") $tipo_func_t=0;
		if(!is_numeric($tipo_func_t)) $tipo_func_t=0;
		
			$sql = "SELECT * FROM dotacion_docente 
		WHERE rut_emp=".$rut_tecnico." AND rdb=".$institucion." AND id_ano=".$ano." AND  cargo=".$cargo_tecnico." ; ";
		
		$rs_docente = @pg_exec($conn,$sql) or die ("SELECT FALLO (docente)".$sql);	
		
		if(pg_num_rows($rs_docente)==0){
			   
		$sql = "INSERT INTO dotacion_docente 
		(rdb,id_ano,rut_emp,cargo,tipo_emp,hrs_contrato,art_69,amp_simple,amp_jec,total_aula,hrs_excedente,cargo_asig,obs) 
		VALUES ( ";
		$sql.= " '".$institucion."','".$ano."','".$rut_tecnico."','".$cargo_tecnico."','".$cmb_tecnico."','".$hrs_contrato_t."','".$art_69."','".
		$amp_simple."','".$amp_jec."', ";
		$sql.= " '".$hrs_total."','".$hrs_excedente."','".$asignatura."','".$obs."') ";
		
		$rs_docente = @pg_exec($conn,$sql) or die ("INSERT FALLO (docente)".$sql);	
		
		}else{
		
		$sql = " UPDATE dotacion_docente SET ";
		$sql.= " tipo_emp='".$cmb_tecnico."', hrs_contrato='".$hrs_contrato_t."', amp_simple='".$amp_simple_t."', total_aula='".
		$total_hrs_t."', ";
		$sql.= " tipo_func='".$tipo_func_t."' WHERE rdb='".$institucion."' AND id_ano='".$ano."' AND rut_emp='".$rut_tecnico."' 		AND cargo='".$cargo_tecnico."' ";

		$rs_tecnico = @pg_exec($conn,$sql) or die ("UPDATE FALLO (TECNICO :".$sql);
		
		}
		//echo "<br>querInstecnico->".$sql;
		
	}
	
 }


		if($frmModo=="eliminar"){
		
		}


//if($_PERFIL!=0){

echo "<script>window.location='seteaDotacionDocente.php?caso=1'</script>";

     // }

?>