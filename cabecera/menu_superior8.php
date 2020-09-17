        
        <?php
		//require('file:///C|/util/header.inc');
		  

	$institucion = $_INSTIT;	
	
	
 

	
	
			
		if ($_USUARIOENSESION!=""){
	          
			 $usuarioensesion = $_USUARIOENSESION;
		
		}else{		
		
		    if ($perfil != 0){    

		        // NUEVO CODIGO INGRESADO			
			    $qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$_USUARIO;
				
				$resultu =@pg_Exec($connection,$qry);
				if (!$resultu) {
					error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
				}else{
					if (pg_numrows($resultu)!=0){
						$fila100 = @pg_fetch_array($resultu,0);	
						if (!$fila100){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							//exit();
						}
					}
				}
 
											
			    $qry="SELECT * FROM EMPLEADO WHERE RUT_EMP = ".$fila100['nombre_usuario']." ";
				
				$resulte =@pg_Exec($conn,$qry);
				
				if (!$resulte) {
					//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($resulte)!=0){
						$fila200 = @pg_fetch_array($resulte,0);	
						if (!$fila200){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							//exit();
						}
						
						//echo trim($fila2['nombre_emp']." ".$fila2['ape_pat']." ".$fila2['ape_mat']);
						$_USUARIOENSESION=$fila200['nombre_emp'];
						$_USUARIOENSESION.=$fila200['ape_pat'];
						session_register('_USUARIOENSESION');	
						$usuarioensesion = $_USUARIOENSESION;		
						
					}
				}
											
			    // FIN NUEVO CODIGO INGRESADO //
		       }else{
			      $usuarioensesion = $_USUARIOENSESION;
			   }	  
		 }									
			    
		$posp = $_POSP;//<----pertenece a while de imagenes
		if($posp==0) $posp=1;
		
	    ## código para tomar la insignia
	    $resulti = @pg_Exec($conn,"select rdb, insignia, nombre_instit from institucion where rdb=".$institucion);
	    $arr=@pg_fetch_array($resulti,0);

		
		//$sql='SELECT nom_foto2 FROM empleado INNER JOIN usuario ON usuario.nombre_usuario = cast(empleado.rut_emp as varchar)         AND usuario.id_usuario = '.$_USUARIO.'';
		 $sql ="SELECT nom_foto2 FROM empleado WHERE rut_emp=".$_NOMBREUSUARIO;
		 $result_foto = @pg_Exec($conn,$sql);
	 	$fila_foto = @pg_fetch_array($result_foto,0);
		$NOM_FOTO = $fila_foto['nom_foto2'];


	    //$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."insignia');";
		//$output= "select lo_export(".$arr['insignia'].",'/opt/www/coeint/tmp/".$arr[rdb]."insignia');";
	    //$retrieve_result = @pg_exec($conn,$output);
		//$n_inst=$arr['nombre_instit'];
		/////////////////////////////////////////////////////////////////////////////
		/// seccion ideas geniales///david y cristian
		// Este codigo permite al menu de la cabecera poder encontrar las imagenes en forma automatica
		
		$a = 0;
		$d = "";
		while ($a < $posp){ // while de imagenes
		$d = $d."../../../sae3.0/";
		$a++; 
		}
	 //  $d=$d."coe_v3.0/";
	 
	  // $d=$d."coe_v3.0/";
       
	  //$d = "../../../sae3.0/";
		//////////////////////////////////////////////////////////////////////////////
	

	if($_NOMBREUSUARIO==14620209 or  $_NOMBREUSUARIO==14184219 or $_PERFIL == 0)
		{
			
?>	

<link rel="stylesheet" type="text/css" href="<?=$d;?>admin/clases/jqueryui/themes/smoothness/jquery-ui-1.8.6.custom.css"/>
<script type="text/javascript" src="<?=$d;?>admin/clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="<?=$d;?>admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script src="../Scripts/swfobject_modified.js" type="text/javascript"></script>
<script language="javascript">
function saludo(pag){

$.ajax({
  	  url:'<?=$d?>manual_html/'+pag,
	  type:'POST',
	  success:function(data){
			$('#System_Help').html(data);
		   }
		})
		
		$("#System_Help").dialog({ 
			open: function(event, ui) { 
			//$(".ui-dialog-titlebar").hide();
		     }, 
		      closeOnEscape: true,
			  modal:true,
			  resizable: true,
			  draggable: true,
			  Width: 1000,
			  Height: 800,
			  minWidth: 1000,
			  minHeight: 800,
			  maxWidth: 1000,
			  maxHeight: 800,
		      show:"slide",
			  hide: { effect: 'drop', direction: "down" },
			  position:"top",
			  position:"absolute",
			  buttons: {
				"Cerrar": function(){
					$(this).dialog("close");
				 }
			 }   
		}); 	
		
	}

</script>   

	

	<div id="System_Help"></div>
    
<?			
     }
?>

        <table width="100%">
<tr>
  <td>	
			   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td width="600">
				        <table width="100%" border="0" cellpadding="3" cellspacing="0">
						  <tr>
						    <td>				   
							   <?		  
							  if($institucion!=""){
							  	   echo "<img src='".$d."tmp/".$arr['rdb']."insignia". "' >";
							  }else{
								   echo "<img src='".$d."menu/imag/logo.gif' >";
							  }
							  ?>
						    </td>
							 <td width="450" align="right">
                                                          
                               <!--
							   <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="400" height="75">
							     <param name="movie" value="<? echo $d; ?>400x75.swf" />
							     <param name="quality" value="high" />
							     <embed src="<? echo $d; ?>400x75.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="400" height="75"></embed>
						       </object>
							   -->
 
 
<!--  <a href="http://www.simce.cl" target="_blank"><img src="<? //echo $d; ?>cabecera/Banner.jpg" width="328" height="136" border="0" /></a>	   -->
<object id="FlashID" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="539" height="86">
  <param name="movie" value="<? echo $d; ?>swf/banner_colegiointeractivo.swf" />
  <param name="quality" value="high" />
  <param name="wmode" value="opaque" />
  <param name="swfversion" value="6.0.65.0" />
  <!-- Esta etiqueta param indica a los usuarios de Flash Player 6.0 r65 o posterior que descarguen la versión más reciente de Flash Player. Elimínela si no desea que los usuarios vean el mensaje. -->
  <param name="expressinstall" value="../Scripts/expressInstall.swf" />
  <!-- La siguiente etiqueta object es para navegadores distintos de IE. Ocúltela a IE mediante IECC. -->
  <!--[if !IE]>-->
  <object type="application/x-shockwave-flash" data="<? echo $d; ?>swf/banner_colegiointeractivo.swf" width="539" height="86">
    <!--<![endif]-->
    <param name="quality" value="high" />
    <param name="wmode" value="opaque" />
    <param name="swfversion" value="6.0.65.0" />
    <param name="expressinstall" value="../Scripts/expressInstall.swf" />
    <!-- El navegador muestra el siguiente contenido alternativo para usuarios con Flash Player 6.0 o versiones anteriores. -->
    <div>
      <h4>El contenido de esta p&aacute;gina requiere una versi&oacute;n m&aacute;s reciente de Adobe Flash Player.</h4>
      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Obtener Adobe Flash Player" width="112" height="33" /></a></p>
    </div>
    <!--[if !IE]>-->
  </object>
  <!--<![endif]-->
</object></td>
						  </tr>
					 </table>		  
			  
				 </td>
                   
				 <? if($_PERFIL=="0" || $_PERFIL=="24"){?>
					<td class="textonegrita" valign="top" align="right">
                    <a href="http://intranet.colegiointeractivo.com/sae3.0/admin/institucion/estadisticas/index.php">Actualmente hay <?=$usuarios_online?> usuarios activos</a><br />		  
					  
				   </td>
				<?	}	?>
				
                   <td valign="bottom"> 
				   <div align="right">

					<?
					// SI TIENE MAS DE UN PERFIL, NO PUEDO MOSTRAR ESTOS DATOS
					
				  if (($_PERFIL == 17) OR ($_PERFIL == 2) OR ($_PERFIL == 19)OR ($_PERFIL == 33) OR ($_PERFIL == 35) OR ($_PERFIL == 22) OR ($_PERFIL == 22)OR ($_PERFIL == 22)OR ($_PERFIL == 32)OR ($_PERFIL == 31)OR ($_PERFIL == 30)OR ($_PERFIL == 29)OR ($_PERFIL == 28)OR ($_PERFIL == 27)OR ($_PERFIL == 26)OR ($_PERFIL == 25)OR ($_PERFIL == 21)OR ($_PERFIL == 9)OR ($_PERFIL == 8)OR ($_PERFIL == 6)OR ($_PERFIL == 22)OR ($_PERFIL == 14) OR ($_PERFIL == 20) OR ($_PERFIL == 21) OR ($_PERFIL == 1) OR ($_PERFIL == 6) OR ($_PERFIL == 31) OR ($_PERFIL == 25) OR ($_PERFIL == 26) OR ($_PERFIL == 28)  OR ($_PERFIL == 27) OR ($_PERFIL == 44) OR ($_PERFIL == 41) OR ($_PERFIL == 47) OR ($_PERFIL == 49) OR ($_PERFIL == 24) OR ($_PERFIL == 51)){ 
					    ?>					
					   <table border="0" cellspacing="0" cellpadding="0">
                        
                        <tr >
                        <td  colspan="2"align="right">
    <?
    if($_NOMBREUSUARIO==14620209 or  $_NOMBREUSUARIO==14184219 )
	{
			
	$pag = $_SERVER["REQUEST_URI"];
	$pi = explode('/',$pag);
	$pa = end($pi);
	$pe = explode('?',$pa);
	$pi  = reset($pe);
	$po = explode('.',$pi);
	$pu  = reset($po);
    $pag = $pu.'.php';
	 
    echo '<a href="#" title="system helps" class="active"><img src="'.$d.'cabecera/logo_sae_sistemaayuda.jpg" width="140" height="71" onClick=saludo("'.$pag.'") ></a>';
    echo '<div id="System_Help"></div>';

		}

		?>
                        </td>
                        </tr>
                        
     <tr>
     <td width="36" height="26" rowspan="2" align="left">
     <? if(isset($NOM_FOTO)){?>
	     <img src="<? echo $d; ?>tmp/<?=$NOM_FOTO?>"  ALT= "FOTO"  style="margin:10px;" width="90" height="100" border="1" >
	<? 	}else{?>
    	<img src="images/icono_user.png" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="39" height="50" border="0" id="ALUMNO">
	<?	}?>
	 
     </td>
     <td height="19">
						 
	<span class="textosesion">
		<a href="<? echo $d; ?>admin/institucion/empleado/empleado.php3?usr=1">Mis Datos Personales</a></span> - <span class="textosesion">
						    
						   <a href="<? echo $d; ?>admin/institucion/empleado/usuario/claveAcceso.php3?cram=1">Cambio de Clave</a>
						 </span> - <span class="textosesion">
						 
						 <a href="<? echo $d; ?>cabecera/ManualAdministradorSAE.pdf">Manual SAE</a>
						 </span> 
                         <br/>
                         <span class="textosesion">
						    
						   <a href="<? echo $d; ?>session/listarPerfiles.php">Listar Perfiles </a>
						 </span> - <span class="textosesion"><a href="<? echo $d; ?>menu/salida.php" target="_self">Cerrar Sesi&oacute;n</a></span></td>
                       </tr>
                       <tr>
                         <td height="22" class="textosesion">Iniciado por:
                           <?=$usuarioensesion ?>
                         </td>
                       </tr>
                     </table>
					 <div align="left">
					   <? } ?>

								   
					  <?  // IF PERFIL ES ADMINISTRADOR COE
					  if ($_PERFIL == 0){
					      ?>
                   
<table >

<tr>
 
 <td width="36" height="26" rowspan="2" align="left">
 
 <?=$fila200['nom_foto2']?>
 
  <? if(isset($NOM_FOTO)){?>
	     <img src="<? echo $d; ?>tmp/<?=$NOM_FOTO?>"  ALT= "FOTO"  style="margin:10px;" width="90" height="100" border="1" >
	<? 	}else{?>
    	<img src="images/icono_Administrador.png" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="70" height="80" border="0" id="ALUMNO">
	<?	}?></td>
 
<td>
    <?
    if($_NOMBREUSUARIO==14620209 or  $_NOMBREUSUARIO==14184219 or $PERFIL == 0)
	{

			
	$pag = $_SERVER["REQUEST_URI"];
	$pi = explode('/',$pag);
	$pa = end($pi);
	$pe = explode('?',$pa);
	$pi  = reset($pe);
	$po = explode('.',$pi);
	$pu  = reset($po);
    $pag = $pu.'.php';
	 
    echo '<a href="#" title="system helps" class="active"><img src="'.$d.'cabecera/logo_sae_sistemaayuda.jpg" width="140" height="71" onClick=saludo("'.$pag.'") ></a>';

		}


		?>
		</td>
        </tr>
        </table>
        
        			       <span class="textosesion">Iniciado por: 
				             <?=$usuarioensesion ?>
				           </span>
				          <?
					  } ?>
					 </div>
	
					 
					 
				 <?
				// para usuaros apoderados y alumnos
				if (($_PERFIL == 15) OR ($_PERFIL == 16)){  ?>
				     
					 <div align="right">
					    <table border="0" cellspacing="0" cellpadding="0">
                        
                        
                                                <tr >
                        <td  colspan="2"align="right">
    <?
    if($_NOMBREUSUARIO==14620209 or  $_NOMBREUSUARIO==14184219)
	{
			
	$pag = $_SERVER["REQUEST_URI"];
	$pi = explode('/',$pag);
	$pa = end($pi);
	$pe = explode('?',$pa);
	$pi  = reset($pe);
	$po = explode('.',$pi);
	$pu  = reset($po);
    $pag = $pu.'.php';
	 
    echo '<a href="#" title="system helps" class="active"><img src="'.$d.'cabecera/logo_sae_sistemaayuda.jpg" width="140" height="71" onClick=saludo("'.$pag.'") ></a>';
    echo '<div id="System_Help"></div>';

		}


		?>
                        </td>
                        </tr>
                        
                       <tr>
                         <td width="36" height="26" rowspan="2" align="left">
                         <img src="<? echo $d; ?>tmp/<?=$fila200['nom_foto2']?>"  style="margin:10px;" width="90" height="100" border="1" />
                         </td>
                         <td height="19">
                         
                         <span class="textosesion">
						 
						  <a href="<? echo $d; ?>infousuario/muestra_info.php">Mis Datos</a> 
						   					   
					       </span> 
                            
                            <br/>
                            
                            <span class="textosesion"> 
						   <?
						   						   
						   if ($_PERFIL == 16){
						      ?>						   
						      <a href="<? echo $d; ?>admin/institucion/ano/curso/alumno/usuario/claveAcceso.php3">Cambio de Clave</a>
						      <?
						   }
						   	
						   if ($_PERFIL == 15){
						      ?>						   
						      <a href="<? echo $d; ?>admin/institucion/ano/curso/alumno/apoderado/usuario/claveAcceso.php3">Cambio de Clave</a>
						      <?
						   }
						   	
						  ?>				   
						   	  
						    </span>
                            
                            <br>
                            
                            <span class="textosesion"><a href="<? echo $d; ?>session/listarPerfiles.php">Listar Perfiles </a></span>
						   
                           <br/>
                           
                           
                           <span class="textosesion"><a href="<? echo $d; ?>menu/salida.php" target="_self">Cerrar Sesi&oacute;n</a></span>
                           
                           <br/>
                           
                         </td>
                       </tr>
                       <tr>
                         <td height="22" class="textosesion">Iniciado por: <?=$usuarioensesion ?></td>
                       </tr>
                     </table>
				<? } ?>					 
					 
					 
                   </div></td>
                 </tr>
               </table>
					   <? 
				if($institucion==""){
						$corte1="fin_linea01.jpg";
						$corte2="fondo_linea01.jpg";
						$corte3="linea01_2.jpg";
						$corte4="linea02.jpg";
					}else{
						$corte1=$institucion."/fin_linea01.jpg";
						$corte2=$institucion."/fondo_linea01.jpg";
						$corte3=$institucion."/linea01_2.jpg";
						$corte4=$institucion."/linea02.jpg";
					  }
					 ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                 <tr>
                   <td width="70%" height="19" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                     <tr>
                       <td width="352"><img src="<? echo $d; ?>cortes/<?=$corte3?>" width="352" height="28" /></td>
                       <td width="100%" background="<? echo $d; ?>cortes/<?=$corte2?>">&nbsp;</td>
                       <td width="15" background="<? echo $d; ?>cortes/<?=$corte2?>"><div align="right"><img src="<? echo $d; ?>cortes/<?=$corte1?>" width="15" height="28" /></div></td>
                     </tr>
                   </table></td>
                   <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                     <tr>
                       <td width="200" align="right"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                         <tr  valign="top">
                           <td width="100%" class="textosimple">
						   <? if($_PERFIL==0 ){
							   /*$sql ="SELECT b.bd FROM corp_instit a INNER JOIN corporacion b ON a.num_corp=b.num_corp WHERE rdb=".$institucion;
							   $rs_corp = @pg_exec($conn,$sql) or die(pg_last_error());	
							   
							   if(@pg_numrows($rs_corp)==0){
									echo "BD:COI_FINAL";
							   }else{
									echo "BD:".@pg_result($rs_corp,0);
							   }*/
							   echo pg_dbname($conn);
							}						   
						   
						   ?></td>
                         </tr>
                       </table>
                       <div align="right"></div></td>
                       <td width="100" align="right"><div align="right"><a href="<? echo $d; ?>index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image71','','<? echo $d; ?>cortes/b_home_r.jpg',1)"> <img src="<? echo $d; ?>cortes/b_home_n.jpg" name="Image71" width="60" height="20" border="0" align="right" id="Image71" /></a></div></td>
                     </tr>
                     <tr>
                       <td colspan="2" background="<? echo $d; ?>cortes/<?=$corte4?>"><img src="<? echo $d; ?>cortes/<?=$corte4?>" height="8" /></td>
                     </tr>
                   </table></td>
                 </tr>
    </table>
<script type="text/javascript">
swfobject.registerObject("FlashID");
</script>
	