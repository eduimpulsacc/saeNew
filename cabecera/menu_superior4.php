        <?
		$institucion	=$_INSTIT;
		$usuarioensesion = $_USUARIOENSESION;
	
	    ## código para tomar la insignia
	    $result = pg_Exec($conn,"select * from institucion where rdb=".$institucion);
	    $arr=pg_fetch_array($result,0);

	    $output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb].         "insignia');";
	    $retrieve_result = @pg_exec($conn,$output);
	
	    ?>
		
		<table>
		    <tr>
			 <td>	
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> 
                <td width="156" height="75" valign="middle">
				 <? if ($arr[insignia]){?>
			           <img src="../../../../../../tmp/<?php echo $arr['rdb']."insignia" ?>" width=99 height=75>
				 <? }else{?>
			           <img src="../../../../../../menu/imag/logo.gif" width="155px" height="75">
			     <? }?>
				
				</td>
                <td width="174">&nbsp;</td>
                <td width="392" valign="bottom"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      <td width="34" height="26" rowspan="2" align="left"><img src="../../../../../../cortes/icono_perfil.jpg" width="26" height="26px"></td>
                      <td width="362" height="19"><span class="textosesion">Mis 
                        Datos</span> - <span class="textosesion">Cambio de Clave</span> 
                        - <span class="textosesion">Cerrar Sesi&oacute;n</span></td>
                    </tr>
                    <tr> 
                      <td height="22" class="textosesion">Iniciado por: <?=$usuarioensesion ?></td>
                    </tr>
                  </table></td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="28" colspan="3"> 
                  <table width="100%" height="19" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td height="19" align="left" valign="top">
<table height="28" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td width="367" rowspan="2" align="left" valign="top"><img src="../../../../../../cortes/linea01.jpg" width="367" height="28"></td>
                            <td width="315" align="left" valign="top"> 
                              <table width="221" border="0" cellspacing="0" cellpadding="0">
                                <tr align="left" valign="top"> 
                                  <td width="60"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image15','','../../../../../../cortes/b_ayuda_r.jpg',1)"><img src="../../../../../../cortes/b_ayuda_n.jpg" name="Image15" width="60" height="20" border="0"></a></td>
                                  <td width="86"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image16','','../../../../../../cortes/b_info_r.jpg',1)"><img src="../../../../../../cortes/b_info_n.jpg" name="Image16" width="101" height="20" border="0"></a></td>
                                  <td width="75"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image17','','../../../../../../cortes/b_mapa_r.jpg',1)"><img src="../../../../../../cortes/b_mapa_n.jpg" name="Image17" width="60" height="20" border="0"></a></td>
                                  <td width="75"><a href="#" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','../../../../../../cortes/b_home_r.jpg',1)"><img src="../../../../../../cortes/b_home_n.jpg" name="Image7" width="60" height="20" border="0"></a></td>
                                </tr>
                              </table>
                            </td>
                          </tr>
                          <tr> 
                            <td height="8" align="left" valign="top" bgcolor="ff6600"><img src="../../../../../../cortes/linea02.jpg" height="8"></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
				 </td>
				 </tr>
				 </table>