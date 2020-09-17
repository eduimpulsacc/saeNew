<?php 
	require('../../util/header.inc');
	

	
	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="procesodesactiva.php">
  <p> Desactivar Instituci&oacute;n (Ingrese Rbd) 
    <input type="text" name="rbd" />
  </p>
  <p>
    <input type="submit" name="Submit" value="Desactivar" />
  </p>
</form>

<?
$ma2 = "update accede set estado='0' where rdb='$rbd'";
$ma = "Update institucion set estado_colegio='0' where rdb='$rbd'";
$result =@pg_Exec($conn,$ma2,$ma);
?>

<form id="form2" name="form1" method="post" action="procesoactiva.php">
  <p> Activar Instituci&oacute;n (Ingrese Rbd) 
    <input type="text" name="rbd" />
  </p>
  <p>
    <input type="submit" name="Submit" value="Activar" />
  </p>
</form>

</body>
</html>
