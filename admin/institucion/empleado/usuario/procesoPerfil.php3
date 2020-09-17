<?php require('../../../../util/header.inc'); ?>
<?php
$ss = explode("_",$_POST['cmbPERFIL']);
$id_perfil=$ss[0];
$id_sistema=$ss[1];
/*$id_perfil = $_POST['cmbPERFIL'];
$id_sistema=1;*/

	$qry="INSERT INTO public.accede (id_usuario,id_perfil,rdb,id_sistema,id_base,estado) VALUES (".$_ID_USER.",".$id_perfil.",".$_INSTIT.",".$id_sistema.",".$_ID_BASE.",1)";
	$result =@pg_Exec($connection,$qry) or die("1".$qry);
	//$result2 =@pg_Exec($conn2,$qry)or die("2".$qry);
	
	$sql = "SELECT * FROM corp_instit WHERE rdb=".$_INSTIT;
	$rs_instit = @pg_exec($connection,$sql);
	
	if(@pg_numrows($rs_instit)>0){
	$sql ="SELECT id_usuario FROM usuario WHERE nombre_usuario='".$_POST['rut_emp']."'";
	$rs_usuario = @pg_exec($connection,$sql);
	$usuario = @pg_result($rs_usuario,0);
	$sql = "INSERT INTO public.accede (id_usuario,id_perfil,rdb,id_sistema,id_base,estado) VALUES (".$usuario.",".$id_perfil.",".$_INSTIT.",".$id_sistema.",".$_ID_BASE.",1)";	
	$result3 =@pg_Exec($connection,$sql);
    }

	if (!$result) {
	     echo "<script>alert('Se produjo un error al intentar crear un nuevo usuario');</script>";	
	}else{
		echo "<script>window.location = '../empleado.php3?pesta=4'</script>";
	}

?>