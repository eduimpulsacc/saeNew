        <?
		$institucion	=$_INSTIT;
		$usuarioensesion = $_USUARIOENSESION;
	
	    ## código para tomar la insignia
	    $result = pg_Exec($conn,"select * from institucion where rdb=".$institucion);
	    $arr=pg_fetch_array($result,0);

	    $output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb].         "insignia');";
	    $retrieve_result = @pg_exec($conn,$output);
	    
		
				$posp = $_POSP;//<----pertenece a while de imagenes
				
						/////////////////////////////////////////////////////////////////////////////
		/// seccion ideas geniales///david y cristian
		// Este codigo permite al menu de la cabecera poder encontrar las imagenes en forma automatica
		
		$a = 0;
		$d = "";
		while ($a < $posp){ // while de imagenes
		$d = $d."../../../sae3.0/";
		$a++; 
		}
		
				
	    ?>
		
		<table>
		    <tr>
			 <td>	
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> 
                <td width="156" height="75" valign="middle">
				 <? if ($arr[insignia]){?>
				 <? }else{?>
			           <img src="../../../../menu/imag/logo.gif" width="155px" height="75">
			     <? }?>
				
				</td>
                <td width="174">&nbsp;</td>
                <td width="392" valign="bottom"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr> 
                      
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
                            <td width="367" rowspan="2" align="left" valign="top"><img src="../../../../cortes/linea01.jpg" width="367" height="28"></td>
                            <td width="556" align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="8" align="left" valign="top" bgcolor="ff6600"><img src="../../../../cortes/linea02.jpg" height="8"></td>
                          </tr>
                        </table></td>
                    </tr>
                  </table>
				 </td>
				 </tr>
				 </table>