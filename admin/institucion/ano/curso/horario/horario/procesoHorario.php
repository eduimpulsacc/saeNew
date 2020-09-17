<?php require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	if ($frmModo=="ingresar"){
		$SQL = "SELECT * FROM horario WHERE (dia=".$cmbDia.") AND (id_estancia=".$cmbESTANCIA.") AND ((horaini BETWEEN '".$txtHoraIni."' AND '".$txtHoraFin."') OR (horafin BETWEEN '".$txtHoraIni."' AND '".$txtHoraFin."'))";
		$result_aux = @pg_exec($conn,$SQL);
		if (!$result_aux){
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (@pg_numrows($result_aux)==0){
				$qry = "SELECT MAX(ID_HORARIO) AS CANT FROM HORARIO";
				$result = @pg_exec($conn,$qry);
				if (!$result){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				}else{
					$fila = @pg_fetch_array($result,0);	
					if (!$fila){
						error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
						exit();
					};
					$newID =  $fila['cant'];
					$newID++;
					$qry = "INSERT INTO HORARIO (ID_HORARIO, ID_CURSO, ID_RAMO, ID_ESTANCIA, DIA, HORAINI, HORAFIN) VALUES (" . $newID . "," . intval($curso) . "," . intval($cmbRAMO) . "," . intval($cmbESTANCIA) . "," . intval($cmbDia) . ",'" . $txtHoraIni . "','" . $txtHoraFin . "')";
					$newANO=$newID;
					$result2 = @pg_exec($conn,$qry);
					if (!$result2){
						error('<b> ERROR :</b>Error al acceder a la BD. (4)'.$qry);
					}else{
						echo "<script>window.location = 'listarHorario.php'</script>";
					};
				};
			};
		};
	};

	if ($frmModo=="modificar"){

		$SQL = "SELECT * FROM horario WHERE (dia=".$cmbDia.") AND (id_estancia=".$cmbESTANCIA.") AND ((horaini BETWEEN '".$txtHoraIni."' AND '".$txtHoraFin."') OR (horafin BETWEEN '".$txtHoraIni."' AND '".$txtHoraFin."'))";
		$result_aux = @pg_Exec($conn,$SQL);
		if (!$result_aux) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (@pg_numrows($result_aux)==0){
				$qry = "UPDATE horario SET id_estancia = " . intval($cmbESTANCIA) . ", dia = " . intval($cmbDia) . ", horaini = '" . $txtHoraIni . "', horafin = '" . $txtHoraFin . "' WHERE (((id_horario)=" . $_HORARIO . ") AND ((id_curso)=" . $curso . "))";
				$result = @pg_Exec($conn,$qry);
				if (!$result) {
					error('<b> ERROR :</b>Error al acceder a la BD. (3)' . $qry);
				}else{
					echo "<script>window.location = 'seteaHorario.php?caso=1&horario=".$_HORARIO."'</script>";
				};
			};
		};
	};

	if ($frmModo=="eliminar") {

		$qry = "DELETE FROM HORARIO WHERE ID_HORARIO=".$_HORARIO." AND ID_CURSO=" . $_CURSO . "";
		$result = @pg_Exec($conn,$qry);
		if (!$result) {
			error('<b> ERROR :</b>Error al eliminar.' . $qry);
			exit();
		}else{
			echo "<script>window.location = 'listarHorario.php'</script>";
		};
	};
?>