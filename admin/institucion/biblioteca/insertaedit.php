<?
  require('../../../util/header.inc');
  
  $nom=trim($nom);
  if($nom!=''){
		$query = "insert into  editorial values(nextval('editorial_COD_EDIT_seq') , '".$nom."')";
		$result = pg_exec($conn,$query);
		if (!$result) {
			printf ("ERROR"); 
		}
		else { 
		   printf("<title>EDITORIAL AGREGADA...</title>LA EDITORIAL HA SIDO INSERTADA CON EXITO </p><input type=button value=ACEPTAR onClick=window.close()>"); 
		}
	}
	else { 
	   printf("<title>EDITORIAL</title>INGRESE EL NOMBRE DE LA EDITORIAL..... </p><input type=button value=ACEPTAR onClick=window.close()>"); 
	}
?>