<?php require('../../../../../../util/header.inc');?>
<?php
	$frmModo		=$_FRMMODO;
	
if ($frmModo=="ingresar"){
	//VERIFICAR EXISTENCIA PREVIA
	$qry="SELECT * FROM hermanos WHERE rut_hermano='".trim($rut_hermano)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result){echo '<B> ERROR :</b>Error al acceder a la BD. (1)</B>'; exit;
		}else{
			if(pg_numrows($result)!=0){
				$qry="UPDATE hermanos SET nombre_hermano = '".trim($nombre_hermano)."', ape_pat = '".trim($ape_pat)."', ape_mat = '".trim($ape_mat)."', fecha_nac = '".fEs2En($fecha_nac)."', estudios = '".trim($estudios)."', dig_rut = '".trim($dig_rut)."'WHERE (((rut_hermano)=".$rut_hermano."))";
				$result =@pg_Exec($conn,$qry);
				if(!$result){
					echo '<B> ERROR :</b>Error al acceder a la BD. (2)</B>'; exit;
				}else{
					$qry="SELECT * FROM relacion_hermanos WHERE rut_hermano=".$rut_hermano." AND RUT_ALUMNO='".trim($_ALUMNO)."'";
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						echo '<B> ERROR :</b>Error al acceder a la BD. (3)</B>'; exit;
						}else{
						if(pg_numrows($result)==0){      
							$qry="INSERT INTO relacion_hermanos (rut_hermano,RUT_ALUMNO) VALUES ('".trim($rut_hermano)."','".$_ALUMNO."')";
							$result =@pg_Exec($conn,$qry);
							if (!$result){
								echo '<B> ERROR :</b>Error al acceder a la BD. (4)</B>'; exit;
							}
						}
					}
				}
				echo "<html><title>ADVERTENCIA</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ADVERTENCIA: EL APODERADO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.";
				echo "<BR>";
				echo "LA INFORMACION HA SIDO ACTUALIZADA...";
				echo "<BR><BR><BR>";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarApoderado.php3\";>";
				echo "</center></body></html>";
			}else{
				$qry="INSERT INTO hermanos ( rut_hermano,dig_rut,nombre_hermano,APE_PAT,APE_MAT,fecha_nac,estudios) VALUES ('".trim($rut_hermano)."','".trim($dig_rut)."','".trim($nombre_hermano)."','".trim($ape_pat)."','".trim($ape_mat)."','".fEs2En($fecha_nac)."','".trim($estudios)."')";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					echo '<B> ERROR :</b>Error al acceder a la BD. (5)</B>'; exit;
				}else{
				    pg_close($conn);
					echo "<script>window.location = 'listarHermanos.php'</script>";
				}				
				
				$qry="INSERT INTO relacion_hermanos (rut_hermano,rut_alumno) VALUES ('".trim($rut_hermano)."','".trim($_ALUMNO)."')";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					echo '<B> ERROR :</b>Error al acceder a la BD. (6)</B>'; exit;
				}else{
				    pg_close($conn);
					echo "<script>window.location = 'listarHermanos.php'</script>";
				}
			}
		}
}

if ($frmModo=="modificar") {
		echo "Actualizando...";
		$qry="UPDATE hermanos SET nombre_hermano = '".trim($nombre_hermano)."', ape_pat = '".trim($ape_pat)."', ape_mat = '".trim($ape_mat)."', fecha_nac = '".fEs2En($fecha_nac)."', estudios = '".trim($estudios)."', dig_rut = '".trim($dig_rut)."' WHERE rut_hermano = '".$_HERMANO."'";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			echo '<B> ERROR :</b>Error al acceder a la BD. (7)</B>'; exit;
		}else{
		    pg_close($conn);
			echo "<script>window.location = 'seteaHermano.php?caso=1&hermano=".trim($_HERMANO)."'</script>";
			
		}
}

if ($frmModo=="eliminar") {

	$qry="DELETE FROM relacion_hermanos WHERE RUT_hermano='".trim($rut_hermano)."' AND RUT_ALUMNO='".trim($_ALUMNO)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.'.$qry);
	}else{
		echo '<B> ERROR :</b>Error al acceder a la BD. (8)</B>'; exit;
	}
}
pg_close($conn);
?>