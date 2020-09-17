<?php require('../../../../../util/header.inc');?>
<?php
 	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$institucion	=$_INSTIT;	

    for ($i=0; $i < $contador; $i++){
	    $check = "check".$i;
		$check = $$check;
		
		if ($check){
		     // seleccionado
		     //echo "Ramo a eliminar: $check <br>"; 
			 $borrar_tiene2007 = "delete from tiene2007 where id_ramo = '$check'";
			 $res_borrar_tiene2007 = @pg_Exec($conn,$borrar_tiene2007);			 
			 
			 
			 $borrar_ramos = "delete from ramo where id_ramo = '$check'";
			 $res_borrar = @pg_Exec($conn,$borrar_ramos);
		}	
	}
	
	
	?>
	<script>window.location='listarRamos_dav.php3'</script>
	<?	
	
?>
