<?php require('../../../util/header.inc');?>
<?php
   
    // guardo el nombre de la foto en la tabla empleado
	$file = $_FILES['upload_file']['name'];
	
	$query = "update empleado set nom_foto2='".$file."' where rut_emp='".trim($_EMPLEADO)."'";
	$result = pg_Exec($conn, $query);
	if (!$result){
		printf ("ERROR"); 
	}else{
	      // guardo la foto en el servidor
		  
		  if (is_uploaded_file($_FILES['upload_file']['tmp_name'])) {
			  
		      @copy($_FILES['upload_file']['tmp_name'],"../../../tmp/$file");
			 
			  
		  }else{
		       echo "Possible file upload attack. Filename: " . $HTTP_POST_FILES['upload_file']['name'];	  
		  }	  
          printf("<title>IMAGEN INSERTADA...</title>
		        <div align='center' ><font face='Arial, Helvetica, sans-serif' size=2>LA IMAGEN HA SIDO INSERTADA CON EXITO </p><input type=button value=ACEPTAR onClick=window.close()></font></div>");
		 
	}	 		 
	
?>
