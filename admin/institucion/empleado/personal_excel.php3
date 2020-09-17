<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP           = 3;
	$fecha = time();
	$dd = date(d);
	$mm = date(m);
	$aa = date(Y);
	$fechahoy = "$dd-$mm-$aa";
	$fechahoy.="_";
	$hora= date ( "h:i:s" , $fecha );
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$fechahoy."Usuarios.xls"); 

?>
<html>
<head>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top"> 
                <td width="53" height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
         
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--codigo antiguo -->
	<center>
		<table WIDTH="700" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<tr>
				<td colspan=5 align=right></td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="5"></td>
			</tr>
			<tr class="tablatit2-1">
				
      <td align="center" width="268" bgcolor="#666666"> <div align="center"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="2"><b>NOMBRE</b></font></div></td>
				
      <td align="center" width="150" bgcolor="#666666"> <div align="center"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="2"><b>USUARIO</b></font> </div></td>
				
      <td align="center" width="160" bgcolor="#666666"> <div align="center"><font face="Arial, Helvetica, sans-serif" color="#FFFFFF" size="2"><b>CLAVE</b></font> </div></td>
	  
	  
	  
			</tr>
			<?php
			/*	$qry="SELECT DISTINCT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro, usuario.nombre_usuario, usuario.pw FROM (((empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN usuario ON trabaja.rut_emp=usuario.nombre_usuario)INNER JOIN accede ON accede.id_usuario=usuario.id_usuario)  WHERE (((trabaja.rdb)=$institucion)and accede.estado=1) order by  ape_pat, ape_mat, nombre_emp asc";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}
					}*/
					
					
			  $qry="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, empleado.telefono,empleado.telefono2,empleado.telefono3, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM trabaja inner join empleado on trabaja.rut_emp=empleado.rut_emp WHERE (((rdb)=".$institucion.")) order by ape_pat, ape_mat, nombre_emp";
				//echo $qry;
				$result =@pg_Exec($conn,$qry);
				
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}
					}

					
					
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila1 = @pg_fetch_array($result,$i);
						
						
				$qry2="SELECT usuario.*, accede.* FROM usuario inner join accede on usuario.id_usuario=accede.id_usuario where nombre_usuario='".$fila1['rut_emp']."'and accede.estado=1 and accede.rdb='".$_INSTIT."'" ;
				//echo $qry2;
				$result2 =@pg_Exec($conn,$qry2);

				if (!$result2) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
				}else{
					if (pg_numrows($result2)!=0){//En caso de estar el arreglo vacio.
						$fila2 = @pg_fetch_array($result2,0);	
						if (!$fila2){
							error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
							exit();
						}

			?>

						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' >
					      <td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
      					  <strong><?php echo $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"];?></strong> 
       						 </font> </td>
							
      <td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')> <font face="arial, geneva, helvetica" size="1" color="#000000"> 
        <strong>
		<? if ($_PERFIL==14 or $_PERFIL==0 or $institucion!=8933) { ?>
	   <?php echo $fila2["nombre_usuario"];?>  
	   <? } else  echo "******************" ?></strong> </font> </td>
							<td align="left" onClick=go('usuario/claveAcceso.php3?empleados=<?php echo trim($fila1["rut_emp"]);?>&caso=1')>
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
									<? if ($_PERFIL==14  or $_PERFIL==0) { ?>
                                    	<? if ($_PERFIL==14 && $fila2['id_perfil']==14) {
												echo "******************"; 
											} else {?>
										<?php echo $fila2["pw"]; }?>	
										<? } else echo "******************" ?>
											</strong>								</font>							</td>
										
						</tr>
			<?php
			
			}
		
		}

					}
				}
			?>
			<tr>
				<td colspan="5">
				<hr width="100%" color="#0099cc">				</td>
			</tr>
		</table>
	</center>

								  
								  
								  
								  <!-- codigo antiguo -->
								  &nbsp;</td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
         </tr>
      </table></td>
  </tr>
</table>
</body>
</html>