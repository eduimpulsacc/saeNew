<?php require('../../../../util/header.inc');?>
<?php 
	 	for($i=0;$i<$_POST["total"];$i++){
		
		if($_POST["confirma_".$i]==0){
			$_POST["confirma_".$i]=0;
		}
		
		$sqlconfirm="select * from asiste_actividad where rut_alumno=".$_POST["rut_".$i]." and id_extra=".$_POST["cmb_acti"];
		$result = @pg_Exec($conn,$sqlconfirm);
		if(@pg_numrows($result) == 0 ){
			$sql="insert into asiste_actividad (rut_alumno,id_extra,asiste) values(".$_POST["rut_".$i].",".$_POST["cmb_acti"].",".$_POST["confirma_".$i].")";
			$result = @pg_Exec($conn,$sql);
			
		}else{ 
			$sql2="UPDATE asiste_actividad SET asiste = ".$_POST["confirma_".$i]." WHERE rut_alumno = ".$_POST["rut_".$i]." and id_extra=".$_POST["cmb_acti"];
			$result2 = @pg_Exec($conn,$sql2);
			}
	}
    pg_close($conn);
	
	echo "<script>window.location = 'muestra_actextra.php?cmb_curso=".$_POST["cmb_curso"]."'</script>";		
?>