<?php require('../../../../../util/header.inc');

 	$frmModo		=$_FRMMODO;
	$alumno			=$_ALUMNO;
	$ano			=$_ANO;
	$Id_Ficha		=$_IDFICHA;
		
	if($frmModo=="ingresar"){
		$qry ="";
		$qry = "INSERT INTO ficha_psicologica (fechacontrol, fechasesion, medicamento, tratamiento, diagnostico, observacion, rut_alum, id_ano)";
		$qry = $qry. " VALUES (to_date('" . $fechacontrol . "','DD MM YYYY'), to_date('" . $fechasesion . "','DD MM YYYY'), '" . $medic ."', '" . $tratam . "', '" . $diag . "', '" . $observ . "', '" . $alumno . "', " . $ano .")";
		$Rs_ficha = @pg_exec($conn,$qry);
		
		$qry1 = "";
		$qry1 = "SELECT max(id_ficha) as ficha FROM ficha_psicologica";
		$Rs_Max = @pg_exec($conn,$qry1);
		$fila = @pg_fetch_array($Rs_Max,0);
		$Id_Ficha = $fila['ficha'];		
		
	
	}
	
	if($frmModo=="modificar"){
		$qry ="";
		$qry = "UPDATE ficha_psicologica SET fechacontrol=to_date('" . $fechacontrol . "','DD MM YYYY'), fechasesion=to_date('" . $fechasesion . "','DD MM YYYY'), ";
		$qry = $qry. "medicamento ='" . $medic ."', ";
		$qry = $qry. "tratamiento ='" . $tratam . "', ";
		$qry = $qry. "diagnostico ='" . $diag . "', ";
		$qry = $qry. "observacion ='" . $observ ."' ";
		$qry = $qry. "WHERE id_ficha = " . $Id_Ficha . "";
		$Rs_ficha = @pg_exec($conn,$qry);
	}
	
	if($frmModo=="eliminar"){
		$qry ="";
		$qry ="DELETE FROM ficha_psicologica WHERE id_ficha=". $Id_Ficha;
		$Rs_ficha = @pg_exec($conn,$qry);
	}
		if (!$Rs_ficha){
				echo $qry;
		}
		elseif($frmModo=="eliminar"){
			echo "<script>window.location = 'listaFichaAlumnos.php?alumno=".$alumno."'</script>";
		}else{
				echo "<script>window.location = 'seteaFicha.php?caso=1&alumno=".$alumno."&idFicha=".$Id_Ficha."'</script>";
		}
				

?>