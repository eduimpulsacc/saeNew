<?php require('../../../../../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$_POSP=6;
	$qry = "";
	$qry = "SELECT * FROM ficha_psicologica WHERE rut_alum='". $alumno . "'";
	$Rs_ficha = @pg_exec($conn,$qry);
	if (!$Rs_ficha) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}
?>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3;
						 include("../../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  
								  
	                              
<?php if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      
	   <?
						 include("../../../../../cabecera/menu_inferior.php");
						 ?>
	  
	  
	  
	   </td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../../../util/");?>

<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
        <TR> 
          <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
            <?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
											}
										?>
            </strong> </FONT> </TD>
        </TR>
        <TR> 
          <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
            </FONT> </TD>
          <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
            <?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
										?>
            </strong> </FONT> </TD>
        </TR>
		<TR> 
              <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>ALUMNO</strong> 
                </FONT> </TD>
              <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
                </FONT> </TD>
              <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
                <?php
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
												}
											}
										?>
                </strong> </FONT> </TD>
            </TR>
      </TABLE></td>
  </tr>
  <tr>
    <td>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td align="right">
				<INPUT TYPE="submit" value="AGREGAR" class="botonXX"   name=btnGuardar onClick=document.location="seteaFicha.php?alumno=<?php echo $alumno;?>&caso=4&ano=<? echo $ano;?>">&nbsp;
				<INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick=document.location="../../matricula/seteaMatricula.php3?alumno=<?php echo $alumno;?>&caso=1">
			</td>
		  </tr>
		  <tr>
			<td align=middle colspan=2 class="tableindex"><center>LISTADO DE ALUMNOS&nbsp;</center></td>
		  </tr>
		</table>

	</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
        <tr class="tabla02"> 
          <td>&nbsp;FECHA</td>
          <td>&nbsp;MEDICAMENTOS</td>
          <td>&nbsp;TRATAMIENTO</td>
		  <td>&nbsp;DIAGNOSTICO</td>
		  <td>&nbsp;OBSERVACIONES</td>
        </tr>
        <? if(@pg_numrows($Rs_ficha)!=0){
				for($i=0;$i<@pg_numrows($Rs_ficha);$i++){
					$fila = @pg_fetch_array($Rs_ficha,$i);
		?>			
		<tr  onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('seteaFicha.php?alumno=<?php echo trim($fila["rut_alum"]);?>&idFicha=<?php echo $fila["id_ficha"];?>&caso=1')>
          <td><font face="Genevaa, Arial, Helvetica, sans-serif" size="1"><? if ($fila['medicamento']!=""){ echo "SI";}else{ echo "NO";}?></font></td>
          <td><font face, Arial, Helvetica, sans-serif" size="1"><? impF($fila['fechacontrol']);?></td>
          <td><font face="Genev="Geneva, Arial, Helvetica, sans-serif" size="1"><? if ($fila['tratamiento']!=""){ echo "SI";}else{ echo "NO";}?></font></td>
		  <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><? if ($fila['diagnostico']!=""){ echo "SI";}else{ echo "NO";}?></font></td>
		  <td><font face="Geneva, Arial, Helvetica, sans-serif" size="1"><? if ($fila['observacion']!=""){ echo "SI";}else{ echo "NO";}?></font></td>
        </tr>
		<? } // fin for
		}else{?>
		<tr>
			
          <td colspan="5"><font size="2" face="Geneva, Arial, Helvetica, sans-serif">No existen fichas</font></td>
		</tr>
		<? } ?>
      </table>
</td>
  </tr>
  
</table>
		
					 


   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
