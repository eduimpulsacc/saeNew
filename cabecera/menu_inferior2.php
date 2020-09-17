<?
echo "holaaaaaaa";

$posps = $_POSP;//<----pertenece a while de imagenes

$botons = $_bot;//<--- recibe el numero de boton

$perfil_usuarios = $_PERFIL;

echo $perfil_usuarios;
//$perfil_usuario =0;




		
	    ## código para tomar la insignia
/*	    $result = pg_Exec($conn,"select * from institucion where rdb=".$institucion);
	    $arr=pg_fetch_array($result,0);

	    $output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."insignia');";
	    $retrieve_result = @pg_exec($conn,$output);*/
		
		//////////////////////////////////////////
///// determinacion de ruta.


echo "mensaje";

$location = dirname($_SERVER['PHP_SELF']); 
$arr = split('/', $location); 
$num = count($arr); 

echo "Ud esta en : ".$location."  con el boton n° = ".$boton;

$num = $num - 1; 
//$TheDIR = $arr[$num];
		
		
		
		/////////////////////////////////////////////////////////////////////////////
		/// seccion ideas geniales///david y cristian
		// Este codigo permite al menu de la cabecera poder encontrar las imagenes en forma automatica
		
		$w = 0;
		//$posp = $posp -2;
		//$posp = $posp;
		$c = "";
		$e = "";
		$d = "";
		$ca = "";
		
		while ($w < $num){ // while de imagenes
		$e = $d;
		$d = $c;
		$c = $c."../";
		$ca = $c."../";
		$w++; 
		}




////////////////////////////////////////////////////////////////////////////////////////////////
//menu superior dos


 ?>


<? if ($perfil_usuarios == 16){
    echo "no debe dibujar el menu";
}else{ 


?>

<table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
		<?
		  if ($boton == 1){
		      ?> 
              <td width="81" height="30"><img src="<? echo $c; ?>botones/institucion_roll.gif" name="Image1" width="81" height="30" border="0" id="Image1"></td>
		      <?
		  }else{
		      ?> 
              <td width="81" height="30"><a href="<? echo $c; ?>atributos/nuestraInstitucion.php3"><img src="<? echo $c; ?>botones/institucion.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','<? echo $c; ?>botones/institucion_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		      <?
		  }
		  
		  
		  if ($boton == 2){
		      ?>	  
              <td width="81" height="30"><img src="<? echo $c; ?>botones/reglamento_roll.gif" name="Image2" width="81" height="30" border="0" id="Image2"></td>
			  <?
		  }else{
		  	   ?>	  
              <td width="81" height="30"><a href="<? echo $c; ?>atributos/reglamentoInterno.php3"><img src="<? echo $c; ?>botones/reglamento.gif" name="Image2" width="81" height="30" border="0" id="Image2" onMouseOver="MM_swapImage('Image2','','<? echo $c; ?>botones/reglamento_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
		  }	  
			  
			  
		  if ($boton == 3){
		      ?>	  			  
              <td width="81" height="30"><img src="<? echo $c; ?>botones/carta_roll.gif" name="Image3" width="81" height="30" border="0" id="Image3"></td>
			  <?
		  }else{
		      ?>	  			  
              <td width="81" height="30"><a href="<? echo $c; ?>atributos/cartaDireccion.php3"><img src="<? echo $c; ?>botones/carta.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','<? echo $c; ?>botones/carta_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
		  }	  	  
			  
		
		  if ($boton == 4){
		      ?>	  
              <td width="81" height="30"><img src="<? echo $c; ?>botones/admision_roll.gif" name="Image4" width="81" height="30" border="0" id="Image4"></td>
			  <?
		  }else{
		  	  ?>	  
              <td width="81" height="30"><a href="<? echo $c; ?>atributos/procesoAdmision.php3"><img src="<? echo $c; ?>botones/admision.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','<? echo $c; ?>botones/admision_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
		  }	  
			  
			  
		  if ($boton == 5){
		      ?>		  
              <td width="81" height="30"><img src="<? echo $c; ?>botones/educativo_roll.gif" name="Image5" width="81" height="30" border="0" id="Image5"></td>
			  <?
		  }else{
		  	  ?>		  
              <td width="81" height="30"><a href="<? echo $c; ?>atributos/proyectoEducativo.php3"><img src="<? echo $c; ?>botones/educativo.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','<? echo $c; ?>botones/educativo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
		  }	  
			  
			  
		  if ($boton == 6){
		      ?>		  
              <td width="81" height="30"><img src="<? echo $c; ?>botones/uniforme_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></td>
			  <?
		  }else{
		      ?>		  
              <td width="81" height="30"><a href="<? echo $c; ?>uniforme.php"><img src="<? echo $c; ?>botones/uniforme.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','<? echo $c; ?>botones/uniforme_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
		  }	  
		       	  
			  
		  if ($boton == 7){
		      ?>			  
              <td width="81" height="30"><img src="<? echo $c; ?>botones/sede_roll.gif" name="Image0" width="81" height="30" border="0" id="Image0"></td>
			  <?
		  }else{
		      ?>			  
              <td width="81" height="30"><a href="<? echo $c; ?>sede/listarSede.php"><img src="<? echo $c; ?>botones/sede.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','<? echo $c; ?>botones/sede_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
		  }	  	  
			  
		
		  if ($boton == 8){
		      ?>		  
		      <td width="81" height="30"><img src="<? echo $c; ?>botones/mapa_roll.gif" name="Image7" width="81" height="30" border="0" id="Image7"></td>
			  <?
		  }else{
		      ?>		  
		      <td width="81" height="30"><a href="<? echo $c; ?>mapa.php"><img src="<? echo $c; ?>botones/mapa.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','<? echo $c; ?>botones/mapa_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
		   }
		   
		   	  	  
			if ($boton == 9){
		      ?>  
			  <td width="81" height="30"><img src="<? echo $c; ?>botones/insignia_roll.gif" name="Image8" width="81" height="30" border="0" id="Image8"></td>
			  <?
			}else{
			  ?>  
			  <td width="81" height="30"><a href="<? echo $c; ?>insignia.php"><img src="<? echo $c; ?>botones/insignia.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','<? echo $c; ?>botones/insignia_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			  <?
			}    
			  
			if ($boton == 10){
		       ?>   		  
               <td width="81"><img src="<? echo $c; ?>botones/biblioteca_roll.gif" name="Image9" width="81" height="30" border="0" id="Image9"></td>
			   <?
			}else{
			   ?>   		  
               <td width="81"><a href="<? echo $c; ?>biblioteca/listarLibros.php?botonera=1"><img src="<? echo $c; ?>botones/biblioteca.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','<? echo $c; ?>botones/biblioteca_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
			   <?
			}
			?>		   
        </tr>
      </table>
	 <?
}	?>      
		  
		  
		  		 