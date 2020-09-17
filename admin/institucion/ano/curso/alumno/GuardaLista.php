<?php require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	
	for($i=0;$i<($total+$total2);$i++){
	
		if($txtNro_Lista[$i]==" " || $txtNro_Lista[$i]==NULL || $txtNro_Lista[$i]=="" ){
			$qry="UPDATE matricula SET nro_lista=NULL WHERE rut_alumno='".trim($rut_alumno[$i])."' AND rdb='".trim($rdb[$i])."' AND id_ano='".trim($id_ano[$i])."' AND id_curso='".trim($id_curso[$i])."' AND bool_ar='".trim($ret[$i])."'";
			$result = @pg_Exec($conn,$qry);
		}
		else{
		$qry="UPDATE matricula SET nro_lista=".$txtNro_Lista[$i]." WHERE rut_alumno='".trim($rut_alumno[$i])."' AND rdb='".trim($rdb[$i])."' AND id_ano='".trim($id_ano[$i])."' AND id_curso='".trim($id_curso[$i])."' AND bool_ar='".trim($ret[$i])."'";
			$result = @pg_Exec($conn,$qry);
		}
		
		
		if($txtNro_Reporte[$i]==" " || $txtNro_Reporte[$i]==NULL || $txtNro_Reporte[$i]=="" ){
			$qry2="UPDATE matricula SET numero_reporte=NULL WHERE rut_alumno='".trim($rut_alumno[$i])."' AND rdb='".trim($rdb[$i])."' AND id_ano='".trim($id_ano[$i])."' AND id_curso='".trim($id_curso[$i])."' AND bool_ar='".trim($ret[$i])."'";
			$result2 = @pg_Exec($conn,$qry2)or die("FALLO 1".$qry2);
		}
		else{
		 $qry2="UPDATE matricula SET numero_reporte=".$txtNro_Reporte[$i]." WHERE rut_alumno='".trim($rut_alumno[$i])."' AND rdb='".trim($rdb[$i])."' AND id_ano='".trim($id_ano[$i])."' AND id_curso='".trim($id_curso[$i])."' AND bool_ar='".trim($ret[$i])."'";
			$result2 = @pg_Exec($conn,$qry2)or die("FALLO 2");
		}
		
	}
    pg_close($conn);
	echo "<script>window.location = 'seteaAlumno.php3?caso=7'</script>";		

?>