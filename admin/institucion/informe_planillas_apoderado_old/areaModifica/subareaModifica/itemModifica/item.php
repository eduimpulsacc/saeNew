<?php require('../../../../../../util/header.inc'); 
?>
<html>
<head>
<title>Untitled Document</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php 
		$sqlTraeSubarea="select * from informe_subarea where id_subarea=".$subarea;
		$returnTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
		if (!$returnTraeSubarea) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlTraeSubarea);
		}
		
		$filaTraeSubarea=@pg_fetch_array($returnTraeSubarea,0);
	?>
<form action="creaItem.php" method="post">
  <font size="2" face="Arial, Helvetica, sans-serif">Cantidad de Itemes a crear 
  para Subarea <?php echo $filaTraeSubarea['nombre'] ?>:</font> 
  <input name="txtCant" type="text" size="2" maxlength="2">
  <input type="submit" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="enviar" value="OK">
  <input type="hidden" name="subarea" value="<?php echo $subarea; ?>">
  <input type="hidden" name="area" value="<?php echo $filaTraeSubarea['id_area']; ?>">
</form>
</body>
</html>

