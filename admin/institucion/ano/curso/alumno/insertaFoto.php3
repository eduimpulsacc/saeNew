<?php require('../../../../../util/header.inc');?>
<?
if ($swfoto=="1"){
   // guardamos la foto en otra carpeta
   // ACTUALIZACION FOTO DEL ALUMNO
   $tiempo = time();
   $digitos = substr($tiempo,6,3);
   // SUBIR FOTO AL SERVIDOR
   $filep = $_FILES['upload_file']['size'];
		
   if ($filep != 0){
//      $filen = "$nombreusuario$digitos.jpg";
		$filen = $rut; 
		unlink( "../../../../../infousuario/images/$filen"); 	  // Elimina la foto q estaba insertada
	  if (!copy($_FILES['upload_file']['tmp_name'], "../../../../../infousuario/images/$filen")){
	      echo "el archivo no ha sido copiado";
	  }else{
	      // actualizamos en la base de datos
		  $q3 = "update alumno set nom_foto = '$filen' where rut_alumno = '".$rut."'";
		  $r3 = pg_Exec($conn,$q3);
	  }
	  
	  
	}  	 
	
	   pg_close($conn);   
      ?>
	  <script language="javascript">
          opener.self.location='alumno.php3';
          window.close();	   
       </script>
	  <?
    	       
   	  
}else{	
	
	
	chmod($upload_file,"700");
	$query = "update ALUMNO set foto=lo_import('$upload_file') where rut_alumno='".$_ALUMNO."';";
	$result = pg_exec($conn, $query);
	if (!$result){
		printf ("ERROR"); 
	}else{ 
	   printf("<title>IMAGEN INSERTADA...</title>LA IMAGEN HA SIDO INSERTADA CON EXITO </p>
	   	   
 	   <input type=button value=ACEPTAR onClick=window.close()>");
	}
	pg_close($conn);
	
}	
?>