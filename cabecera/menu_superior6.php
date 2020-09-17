        <?
		//require('../../util/header.inc');	

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
       
	  
		
		//////////////////////////////////////////////////////////////////////////////
	
		   ?>
			

        <table width="100%">
		    <tr>
			 <td>	
			 
			    
			 
			   <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 <tr>
                   <td width="1"><? 
				/*
				 $nombre_archivo=$d."tmp/".$arr[rdb]."insignia";
				 $nombre_archivo=substr($nombre_archivo,3,strlen($nombre_archivo));
				 if (file_exists($nombre_archivo)){?>
			           <!--img src="<? echo $d; ?>tmp/<?php echo $arr['rdb']."insignia"?>" width=99 height=75-->
			   <? }else{ ?>
				      <!--img src="<? echo $d; ?>menu/imag/logo.gif" width="155px" height="75"-->
			  <?  }*/
			  
			  if($institucion!=""){
		           echo "<img src='".$d."menu/imag/logo.gif' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }
			  ?>
				 </td>
                   <td width="250" align="center" class="topcollege"><?=$n_inst?></td>
				 <? if($_PERFIL=="0" || $_PERFIL=="24"){?>
					<td class="textonegrita" valign="top" align="right"><br />
						  
						  
						  
						  
					  
					  </td>
				<?	}	?>
                   <td valign="bottom"> 				   
				   <div align="right">
				   <div align="left"></div>
					 
					 
					 
					 
					 
					 
				   <div align="right">
				     <table border="0" cellspacing="0" cellpadding="0">
                       <tr>
                         <td width="36" height="26" rowspan="2" align="left">&nbsp;</td>
                        <td height="19">&nbsp;</td>
                       </tr>
                       <tr>
                         <td height="22" class="textosesion">&nbsp;</td>
                       </tr>
                     </table>
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
                   <td height="41" align="left" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                       <tr>
                         <td width="352"><img src="<? echo $d; ?>cortes/linea01_2.jpg" width="352" height="28" /></td>
                         <td width="100%" background="<? echo $d; ?>cortes/fondo_linea01.jpg">&nbsp;</td>
                         <td width="15" background="<? echo $d; ?>cortes/fondo_linea01.jpg"><div align="right"></div></td>
                       </tr>
                   </table>                     <table width="100%" border="0" cellpadding="0" cellspacing="0">
                       <tr>
                         <td width="200" align="right"><table width="100%" border="0" align="right" cellpadding="0" cellspacing="0">
                             <tr  valign="top">
                               <td width="100%"></td>
                             </tr>
                           </table>
                             <div align="right"></div></td>
                         <td width="100" align="right"></td>
                       </tr>

                                        </table></td>
                 </tr>
			   </table>
			   
			