<?php require "../../../util/header.php";?>
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
		$filen = $rut.".pdf"; 
		unlink( "images/$filen"); 	  // Elimina la foto q estaba insertada
	  if (!copy($_FILES['upload_file']['tmp_name'], "images/$filen")){
	      echo "el archivo no ha sido copiado";
	  }else{
	      // actualizamos en la base de datos
		  $q3 = "update pme.empresa set archivo = '$filen' where rut_empresa = '".$rut."' AND rdb=".$rdb."";
		  $r3 = pg_Exec($conn,$q3);
	  }
	  
	  
	}  	 
	
	   pg_close($conn);   
      ?>
	  <script language="javascript">
          //opener.self.location='ficha_alumno.php?alumno=<?=$rut;?>';
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