<?php require('../../util/header.inc');?>
<?

$ano			=$_ANO;
for($i=0;$i < $_POST['num_fila'];$i++){
	$rut=$_POST["rut_".$i];
	$sqlprefe="select preferencia,id_estado,grado from formulario_postulacion where rut=".$_POST["rut_".$i];
	$resultprefe = @pg_Exec($conn,$sqlprefe);
	$filaprefe = @pg_fetch_array($resultprefe,0);
	
	if($_POST["chk_acepta_".$i]==null){
		$_POST["chk_acepta_".$i]=2;
	}
	if($_POST["chk_acepta_".$i]==2){
		$prefe = $filaprefe["preferencia"]+1;
	}else{
		$prefe=$filaprefe["preferencia"];
		$sqlvac="select * from vacantes where grado=".$filaprefe["grado"]." and id_ano=".$ano;
		$resultvac = @pg_Exec($conn,$sqlvac);
		$filaprefe = @pg_fetch_array($resultvac,0);
		if($filaprefe["vac_dis"]>0){
			$vacante=$filaprefe["vac_dis"]-1;
			$sqlupvac="UPDATE VACANTES SET vac_dis =".$vacante." where grado=".$filaprefe["grado"]." and id_ano=".$ano;
			$resultup = @pg_Exec($conn,$sqlupvac);
		}
	}
	$sql="UPDATE formulario_postulacion SET id_estado = ".$_POST["chk_acepta_".$i].", preferencia=".$prefe." WHERE rut= ".$_POST["rut_".$i];
	$result = @pg_Exec($conn,$sql);
}
 ?>	
<script language="javascript">window.location="acepta.php?cmb_grado=<?= $_POST["cmb_grado"] ?>"</script>