<?php require('../../util/header.inc');


if($del==1)
{	
	$qry2 = "delete from corporacion where num_corp =".$_GET['codigo'];
	$res2 = @pg_Exec($conn,$qry2);
	
	
}
if($del=="")
{
	$txtNOMBRE = $_FILES['archivo']['name'];
	$file_tmp = $_FILES['archivo']['tmp_name'];
	$path = "../../tmp/".$txtNOMBRE;
	move_uploaded_file($file_tmp,$path);
	
	$sql = "select max(num_corp) from corporacion";
	$resu = @pg_Exec($conn,$sql);
	$fila = pg_fetch_array($resu);
	$tot = $fila['max'] +1;
	$qry = "insert into corporacion (num_corp, nombre_corp,direccion,fono,logo) values ('$tot','$txt_corp','$txtDIREC','$txtFONO','$txtNOMBRE')";
	$res = pg_Exec($conn,$qry);
}
echo "<script>window.location = 'admin_corporaciones.php'</script>";


?>