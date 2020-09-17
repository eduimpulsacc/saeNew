<?
	$institucion	=$_INSTIT;
		
		

if (isset($_USUARIOENSESION)){
	$usuarioensesion = $_USUARIOENSESION;
}else{		
	if ($perfil != 0){    
	// NUEVO CODIGO INGRESADO			
	$qry="SELECT * FROM USUARIO WHERE ID_USUARIO=".$_USUARIO;
	$resultu =@pg_Exec($conn,$qry);
	if (!$resultu) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		if (pg_numrows($resultu)!=0){
			$fila100 = @pg_fetch_array($resultu,0);	
			if (!$fila100){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}
		}
	}

	$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$fila100['nombre_usuario']."";
	$resulte =@pg_Exec($conn,$qry);
	if (!$resulte) {
		error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
	}else{
		if (pg_numrows($resulte)!=0){
			$fila200 = @pg_fetch_array($resulte,0);	
			if (!$fila200){
				error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
				exit();
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
		
	    ## código para tomar la insignia
	    $resulti = @pg_Exec($conn,"select rdb, insignia, nombre_instit from institucion where rdb=".$institucion);
	    $arr=@pg_fetch_array($resulti,0);

		
		$a = 0;
		$d = "";
		while ($a < $posp){ // while de imagenes
		$d = $d."../../sae3.0/";
		$a++; 
		}
	  
		
		//////////////////////////////////////////////////////////////////////////////
	
		   ?>
			

       
			    
			 
			   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td width="17"><? 
				/*
				 $nombre_archivo=$d."tmp/".$arr[rdb]."insignia";
				 $nombre_archivo=substr($nombre_archivo,3,strlen($nombre_archivo));
				 if (file_exists($nombre_archivo)){?>
			           <!--img src="<? echo $d; ?>tmp/<?php echo $arr['rdb']."insignia"?>" width=99 height=75-->
			   <? }else{ ?>
				      <!--img src="<? echo $d; ?>menu/imag/logo.gif" width="155px" height="75"-->
			  <?  }*/
			  
			  if($institucion!=""){
		           echo "<img src='".$d."tmp/".$arr['rdb']."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
			  ?>				 </td>
                   <td width="250" align="center" class="topcollege"><?=$n_inst?></td>
				 <? if($_PERFIL=="0" || $_PERFIL=="24"){?>
					<td width="223" align="right" valign="top" class="textonegrita"><a href="http://intranet.colegiointeractivo.com/sae3.0/admin/institucion/estadisticas/index.php">Actualmente hay <?=$usuarios_online?> usuarios activos</a><br />
						  
						  
						  
						  
					  
				   </td>
				<?	}	?>
                   <td width="613" valign="bottom"> 				   
				   <div align="right">

					<?
					// SI TIENE MAS DE UN PERFIL, NO PUEDO MOSTRAR ESTOS DATOS
					
					
				  if (($_PERFIL == 17) OR ($_PERFIL == 2) OR ($_PERFIL == 19) OR ($_PERFIL == 14) OR ($_PERFIL == 20) OR ($_PERFIL == 21) OR ($_PERFIL == 1) OR ($_PERFIL == 6) OR ($_PERFIL == 25) OR ($_PERFIL == 26) OR ($_PERFIL == 28)){ 
					    ?>					
					   <table border="0" cellspacing="0" cellpadding="0">
                        <tr>
                         <td width="36" height="26" rowspan="2" align="left"><img src="<? echo $d; ?>cortes/icono_perfil.jpg" width="26" height="26px" /></td>
                         <td height="19"><span class="textosesion">
						 
						  <a href="<? echo $d; ?>admin/institucion/empleado/empleado.php3?usr=1">Mis 
                             Datos Personales</a></span> - <span class="textosesion">
						    
						   <a href="<? echo $d; ?>admin/institucion/empleado/usuario/claveAcceso.php3?cram=1">Cambio de Clave</a>
						     
						   
						   
						   </span> - <span class="textosesion"><a href="<? echo $d; ?>menu/salida.php" target="_self">Cerrar Sesi&oacute;n</a></span>
						   - <span class="textosision"><a href="<?=$d;?>session/listarPerfiles.php" target="_self">Listar Perfiles</a></span>
					      </td>
                       </tr>
                       <tr>
                         <td height="22" class="textosesion">Iniciado por:
                           <?=$usuarioensesion ?></td>
                       </tr>
                     </table>
					 <div align="left">
					   <? } ?>
					 			   
								   
								   
								   
								   
								   
								   
					  <?  // IF PERFIL ES ADMINISTRADOR COE
					  if ($_PERFIL == 0){
					      ?>					
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
                       <tr>
                         <td width="36" height="26" rowspan="2" align="left"><img src="<? echo $d; ?>cortes/icono_perfil.jpg" width="26" height="26px" /></td>
                         <td height="19"><span class="textosesion">
						 
						  <a href="<? echo $d; ?>infousuario/muestra_info.php">Mis 
                           Datos</a> 
						   					   
						    </span> - <span class="textosesion"> 
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
						   	  
						   
						   </span> - <span class="textosesion"><a href="<? echo $d; ?>menu/salida.php" target="_self">Cerrar Sesi&oacute;n</a></span></td>
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
/*
							$corte1="fin_linea01.jpg";
							$corte2="fondo_linea01.jpg";
							$corte3="linea01_2.jpg";
							$corte4="linea02.jpg";
	*/
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
                           <td width="100%"></td>
                         </tr>
                       </table>
                       <div align="right"></div></td>
                       <td width="100" align="right"><div align="right"><a href="<? echo $d; ?>index.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image71','','<? echo $d; ?>cortes/b_home_r.jpg',1)"><img src="<? echo $d; ?>cortes/b_home_n.jpg" name="Image71" width="60" height="20" border="0" align="right" id="Image71" /></a></div></td>
                     </tr>
                     <tr>
                       <td colspan="2" background="<? echo $d; ?>cortes/<?=$corte4?>"><img src="<? echo $d; ?>cortes/<?=$corte4?>" height="8" /></td>
                     </tr>
                   </table></td>
                 </tr>
               </table>
			   
			