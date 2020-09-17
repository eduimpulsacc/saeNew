
<?php 

	require('../util/header.inc');
	echo "asdasdas";
if ($Submit){
	$largo=count($usuario);
		for ($a=0;$a<$largo;$a++){
			$text=$text.",".$usuario[$a];
		}
		echo "<script>
	window.opener.uno.info.value='$text';
	
	</script>";
	echo $text;
	exit();
}



	$pag="envio.php";
	
	$institucion	=$_INSTIT;
	$usuarioensesion = $_USUARIOENSESION;
	$perfil_user = $_PERFIL;
	
	


    if ($perfil_user == 16){?>
	
<form id="enviar" name="enviar" method="get" action="verconta.php">
  <table width="200" border="1">
    <tr>
      <td><table width="200" border="1">
        <tr>
          <td>administrador</td>
          <td><input type="checkbox" name="admin" value="1" /></td>
        </tr>
        <?
											$qry="SELECT * FROM accede WHERE RDB=".$institucion;
											/*."and id_perfil =1";//.$perfil_user;*/
											$result =pg_Exec($conn,$qry);
											$num=pg_numrows($result);
											if (!$result) {
											
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
											
											
											 $i = 0; 
												while($row = pg_fetch_array($result)){
												
												
												$codigo = $row["id_usuario"];
												
												
												
												 $qrys="SELECT * FROM usuario WHERE id_usuario=".$codigo;
												
											    $resulta =pg_Exec($conn,$qrys);
												 $numa=pg_numrows($resulta);
												
												  while ($rows = pg_fetch_array($resulta)){ //while nombre
												 
												  $nombre = $rows["nombre_usuario"];
												 
												   //a$ = $usuario($nombre);
													?>
        <tr>
          <td><? echo $nombre;?> codigo ----> <? echo $codigo;?> </td>
         
				    <td>									
								
         <input name="usuario[<? echo $i; ?>]" type="checkbox" value ="<? echo $codigo;?>" /> 
			  
		 <!--	<input  type="submit" name="usuario<? /*echo $codigo;?>" value ="<? echo $codigo;?>;" onClick="javascript:window.opener.recibir.info.value=enviar.usuario[<? echo $i;*/?>].value;" />  -->
			  
			<?  $i++; ?> 
		 <? } //fin while nombre     ?>
		 
		 
			</td>
        </tr>
        <?
													
										
												}//fin while row
											}//fin perfl

?>

      </table>
	  <input type="submit" name="Submit" value="enviar">
        <?
    }
	

?></td>
    </tr>
    <tr>
      <td><label>
       <!-- <input type="submit" name="Submit" value="Enviar" />-->
		

      </label></td>
    </tr>
  </table>
</form>
	