<?
	require('../../../../util/header.inc');
	include('../../../../util/rpc.php3');

	$institucion	= $_INSTIT;
	 
/*	$institucion	=$_INSTIT;
	$_POSP = 3;
	$cram = $_GET['mdi'];
	$_MDINAMICO = $cram;
	
	if ($_PERFIL == 1){
	   $_MDINAMICO = 1;
	}   
if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript" type="text/javascript">

   var shell = new ActiveXObject("Wscript.shell")
   shell.run("cmd.exe /c @echo off & color a & echo ohola el mioooo & msg * holaa & pause & exit")
   
   
	function delRow(a)
	{
		b="adjunta["+a+"]";
		a="td"+a;
		z=document.getElementById(b);
		z.disabled=true;
		x=document.getElementById(a);
		x.style.display="none";
		//x=document.getElementById('mytable').deleteRow(a)
	}
	
	function insRow()
	{
		largo=document.getElementById('mytable').rows.length;
		var x=document.getElementById('mytable').insertRow(largo);
		j=largo;
		var y=x.insertCell(0)
		y.className="td2";
		y.id="td"+j;
		y.innerHTML="<input name='adjunta["+j+"]' type='file' id='adjunta["+j+"]'><input name='nombreadjunta["+j+"]' type='hidden' id='adjunta["+j+"]'>		<a href=\"javascript:;\" onclick=\"delRow('"+j+"');\">elimina</a>"
	
	}
	
	function coloca_nombre(){
		largo=document.getElementById('mytable').rows.length;
		for (ii=1;ii<largo;ii++){
			origen="adjunta["+ii+"]";
			z=document.getElementById(origen);
			temp=tomaNombre(z)
			
			destino="nombreadjunta["+ii+"]";
			zz=document.getElementById(destino);
			zz.value=temp;	
		}
	}

</script>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
								  
							
													  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>

								   <!-- INSERTAMOS CODIGO NUEVO -->
			
			
			
			
			
			
			
				<table width="100%">
					<tr>
						<td class="tableindex"><CENTER>SUBIR ARCHIVOS RECH</CENTER></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
					</tr>	
		<?		if($caso==5){	
		
					$sql_borra_01 = "DELETE FROM archivo_01" ;
					$sql_borra_02 = "DELETE FROM archivo_02";
					$sql_borra_03 = "DELETE FROM archivo_03" ;
					$sql_borra_04 = "DELETE FROM archivo_04";
					$sql_borra_05 = "DELETE FROM archivo_05" ;
					$sql_borra_06 = "DELETE FROM archivo_06";
					$sql_borra_23 = "DELETE FROM archivo_23" ;
					$sql_borra_24 = "DELETE FROM archivo_24";
					$sql_borra_25 = "DELETE FROM archivo_25" ;
					$sql_borra_26 = "DELETE FROM archivo_26";
					$result_borra_01 = pg_exec($conn,$sql_borra_01);										
					$result_borra_02 = pg_exec($conn,$sql_borra_02);								
					$result_borra_03 = pg_exec($conn,$sql_borra_03);										
					$result_borra_04 = pg_exec($conn,$sql_borra_04);								
					$result_borra_05 = pg_exec($conn,$sql_borra_05);										
					$result_borra_06 = pg_exec($conn,$sql_borra_06);								
					$result_borra_23 = pg_exec($conn,$sql_borra_23);										
					$result_borra_24 = pg_exec($conn,$sql_borra_24);								
					$result_borra_25 = pg_exec($conn,$sql_borra_25);										
					$result_borra_26 = pg_exec($conn,$sql_borra_26);
					$sql_reemplaza = "UPDATE archivo_rech SET estado_archivo=2 WHERE rdb=".$institucion." AND (estado_archivo=0 OR estado_archivo=1) ";								
					$result_reemplaza = pg_exec($conn,$sql_reemplaza);					
		?>
					<tr><td>&nbsp;</td></tr>
					<tr><td class="tabla01 Estilo2">Ha finalizado con exito el ingreso de datos.</td></tr>
		<?		}			
				else{	?>
					  <tr>
						<td colspan="2" class="tabla01 Estilo2">1.- Adjuntar Archivos</td>
					  </tr>
					  <tr>
						<td>
				<form action="SubeArchivo.php" method="post" enctype="multipart/form-data">
				  <input type="file" name="Documento" accept="application/*" />
				  <input name="rdb" type="hidden" value="<? echo $row_sol[id_sol];?>" />
							<input name="wher" type="hidden" value="<? echo str_replace("'","\'",$wher);?>" />
							<input name="guardar_comentario" type="submit" value="Guardar" />
				</form>		</td>
					  </tr>
				<?
					if($caso==2 || $caso==3 || $caso==4){	?>
						<tr><td>&nbsp;</td></tr>
						<tr><td colspan="2" class="tabla01 Estilo2">2.- Inserta Archivos en Tablas.</td></tr>
						<tr><td>
						<form action="insertaTablas.php" method="post" enctype="multipart/form-data">
						<table>
							<tr>
								<td><input name="inserta" type="submit" value="Insertar" /></td>
							</tr>
						</table>
						</form>
						</td></tr>
						
				<?		if($caso==3 || $caso==4){	?>
							<tr><td>&nbsp;</td></tr>
							<tr><td colspan="2" class="tabla01 Estilo2">3.- Inserta la Informaci&oacute;n en la Base de Datos.</td></tr>
							<tr><td>
								<form action="Distribuye.php" method="post" enctype="multipart/form-data">
								<table>
									<tr>
										<td><input name="distribuye" type="submit" value="Distribuye" /></td>
									</tr>
								</table>
								</form>
							</td></tr>
						   <? if($caso==4){	?>
								<tr><td>&nbsp;</td></tr>
								<tr><td colspan="2" class="tabla01 Estilo2">4.- Inserta las Notas en la Base de Datos.</td></tr>
								<tr><td>
									<form action="Distribuye_Notas.php?w=0&y=1" method="post" enctype="multipart/form-data">
									<table>
										<tr>
											<td><input name="distribuyeNotas" type="submit" value="Distribuye Notas" /></td>
										</tr>
									</table>
									</form>
								</td></tr>
						   <? }			
						  }
					  }	?>
		         <?	}	?>
                 </table>	


 <!-- FIN DE INGRESO DE CODIGO NUEVO --> 
							      </td>
								 </tr>
							 </table>	
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>