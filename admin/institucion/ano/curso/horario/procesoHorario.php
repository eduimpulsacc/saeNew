<?php require('../../../../../util/header.inc');?>
<?php
//print_r($_POST);
 	$frmModo		=$_FRMMODO;
	$curso			=$_CURSO;
	$flag 			=0;
	$cmbESTANCIA=$_POST['cmbESTANCIA'];
	if($cmbESTANCIA=='null'){
	$cmbESTANCIA=0;
	}
	
	if ($frmModo=="ingresar"){
//		$SQL = "SELECT * FROM horario WHERE (dia=".$cmbDia.") AND (id_estancia=".$cmbESTANCIA.") AND (id_curso=".$curso.") AND ((horaini BETWEEN '".$txtHoraIni."' AND '".$txtHoraFin."') OR (horafin BETWEEN '".$txtHoraIni."' AND '".$txtHoraFin."'))";

		$SQL = "SELECT * FROM horario WHERE (dia='$cmbDia') AND (id_estancia='$cmbESTANCIA') AND '$txtHoraIni'< horafin and '$txtHoraFin'>= horafin and '$txtHoraFin'>'$txtHoraIni' AND id_curso='$curso' and id_ramo=$cmbRAMO";
		$result_aux = pg_exec($conn,$SQL);
		if (!$result_aux){
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{		
			if (pg_numrows($result_aux)==0){			

				$qry = "SELECT MAX(ID_HORARIO) AS CANT FROM HORARIO";
				$result = pg_exec($conn,$qry);
				if (!$result){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				}else{
					$fila = pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (3.2)</B>');
						exit();
					};
					$newID =  $fila['cant'];
					$newID = $newID + 1;
					
					$sql ="SELECT rut_emp FROM dicta WHERE id_ramo =".$cmbRAMO;
					$rs_dicta = pg_exec($conn,$sql);
					
					if(pg_numrows($rs_dicta)==0){
						$sql ="SELECT rut_emp FROM dicta_taller WHERE id_taller =".$cmbTALLER;
						$rs_dicta = pg_exec($conn,$sql);	
					}
					$rut_emp =pg_result($rs_dicta,0);
					
					$qry = "INSERT INTO HORARIO (ID_HORARIO, ID_CURSO, ID_RAMO, ID_ESTANCIA, DIA, HORAINI, HORAFIN, ID_TALLER, RUT_EMP) VALUES (" . $newID . "," . intval($curso) . "," . intval($cmbRAMO) . "," . intval($cmbESTANCIA) . "," . intval($cmbDia) . ",'" . $txtHoraIni . "','" . $txtHoraFin . "'," . intval($cmbTALLER) . ",".$rut_emp.")";
					$newANO=$newID;
					$result2 = pg_exec($conn,$qry);
					if (!$result2){
						error('<b> ERROR :</b>Error al acceder a la BD. (4)'.$qry);
					}else{
						echo "<script>window.location = 'listarHorario.php'</script>";
					};
				};
			}else{	
				echo "<center><font face='arial,hervetica' size='2'><b>HORARIO YA ASIGNADO A UN SUBSECTOR, VERIFICAR</b></font></center>";
//				echo "<script>window.location = 'listarHorario.php'<!--/script>";
			}
				
		};
	};

	if ($frmModo=="modificar"){
 		$sql_total = "select * from horario where dia=".$cmbDia." and id_estancia=".$cmbESTANCIA." order by horaini asc";	  
		$result_total = @pg_Exec($conn,$sql_total);

		for($i=0;$i<@pg_numrows($result_total);$i++){
			$fila = @pg_fetch_array($result_total,$i);			
			$id_horario[$i] = $fila['id_horario'];
			$hora_ini[$i] = $fila['horaini'];
			$hora_fin[$i] = $fila['horafin'];		
			if($id_horario[$i]==$_HORARIO){
				$id_horario_ant = $id_horario[$i-1];
				$hora_fin_ant = $hora_fin[$i-1];

				$j = $i + 1 ;
				$fila = @pg_fetch_array($result_total,$j);			
				$id_horario_sig = $fila['id_horario'];
				$hora_ini_sig = $fila['horaini'];
			}
		}

		$SQL_mod = "SELECT * FROM horario WHERE (dia=".$cmbDia.") AND (id_estancia=".$cmbESTANCIA.") AND '".$txtHoraFin."'>'".$txtHoraIni."' AND id_horario=".$_HORARIO."";

		if($hora_fin_ant!='NULL' && $hora_fin_ant!='' && $hora_ini_sig!='NULL' && $hora_ini_sig!=''){
			$flag=1;
			$SQL_mod = $SQL_mod ." AND '".$txtHoraIni."'>='".$hora_fin_ant."' AND '".$txtHoraFin."'<='".$hora_ini_sig."'";				
		}
		else if($hora_fin_ant!='NULL' && $hora_fin_ant!=''){
			$SQL_mod = $SQL_mod ." AND '".$txtHoraIni."'>='".$hora_fin_ant."'";
		}
		else if($hora_ini_sig!='NULL' && $hora_ini_sig!=''){
//			$SQL_mod = $SQL_mod ." AND '".$txtHoraFin."'<='".$hora_ini_sig."'";				
		}
//echo $SQL_mod;
		$result_aux = @pg_Exec($conn,$SQL_mod);

		if (!$result_aux) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if($flag==1){ 
				$sql ="SELECT rut_emp FROM dicta WHERE id_ramo =".$cmbRAMO;
				$rs_dicta = pg_exec($conn,$sql);
				
				if(pg_numrows($rs_dicta)==0){
					$sql ="SELECT rut_emp FROM dicta_taller WHERE id_taller =".$cmbTALLER;
					$rs_dicta = pg_exec($conn,$sql);	
				}
				$rut_emp =pg_result($rs_dicta,0);
				// ----- SE ELIMINA CAMPO PARA POSTERIOR CORRECCION 
				$qry = "UPDATE horario SET id_estancia = ".intval($cmbESTANCIA).", id_ramo=". intval($cmbRAMO).",  dia =".intval($cmbDia).", horaini ='".$txtHoraIni."', horafin='".$txtHoraFin."', rut_emp=".$rut_emp."  WHERE id_horario=".$_HORARIO." AND id_curso=".$curso."";
				$result = @pg_Exec($conn,$qry);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3.1)' . $qry);
				}else{
					echo "<script>window.location = 'listarHorario.php'</script>";
				};
			}	
			else{
				if (pg_numrows($result_aux)==1){
					$sql ="SELECT rut_emp FROM dicta WHERE id_ramo =".$cmbRAMO;
					$rs_dicta = pg_exec($conn,$sql);
					
					if(pg_numrows($rs_dicta)==0){
						$sql ="SELECT rut_emp FROM dicta_taller WHERE id_taller =".$cmbTALLER;
						$rs_dicta = pg_exec($conn,$sql);	
					}
					$rut_emp =pg_result($rs_dicta,0);
					
					$qry = "UPDATE horario SET id_estancia = ".intval($cmbESTANCIA).", dia =".intval($cmbDia).", horaini ='".$txtHoraIni."', horafin='".$txtHoraFin."'  WHERE id_horario=".$_HORARIO." AND id_curso=".$curso."";
					$result = @pg_Exec($conn,$qry);
					if (!$result) {
						error('<b> ERROR :</b>Error al acceder a la BD. (4)' . $qry);
					}else{
						echo "<script>window.location = 'listarHorario.php'</script>";
					};
				}else
					$sql ="SELECT rut_emp FROM dicta WHERE id_ramo =".$cmbRAMO;
					$rs_dicta = pg_exec($conn,$sql);
					
					if(pg_numrows($rs_dicta)==0){
						$sql ="SELECT rut_emp FROM dicta_taller WHERE id_taller =".$cmbTALLER;
						$rs_dicta = pg_exec($conn,$sql);	
					}
					$rut_emp =pg_result($rs_dicta,0);
					$qry = "UPDATE horario SET id_estancia = ".intval($cmbESTANCIA).", dia =".intval($cmbDia).", horaini ='".$txtHoraIni."', horafin='".$txtHoraFin."'  WHERE id_horario=".$_HORARIO." AND id_curso=".$curso."";
					$result = @pg_Exec($conn,$qry);	
					echo "<script>window.location = 'listarHorario.php'</script>";				
			}
		};
	};


	if ($frmModo=="eliminar") {

		$qry = "DELETE FROM HORARIO WHERE ID_HORARIO=".$_HORARIO." AND ID_CURSO=" . $_CURSO . "";
		$result = pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al eliminar.' . $qry);
			exit();
		}else{
			echo "<script>window.location = 'listarHorario.php'</script>";
		};
	};
?>