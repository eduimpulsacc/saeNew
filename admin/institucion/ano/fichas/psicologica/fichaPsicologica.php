<?php require('../../../../../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$idFicha		=$_FICHAM;
$_POSP=6;
	if(($frmModo=="mostrar")||($frmModo=="modificar")){
		$qry = "";
		$qry = "SELECT * FROM ficha_psicologica WHERE rut_alum='" . $alumno ."' AND id_ficha=" . $idFicha;
		$Rs_ficha = @pg_exec($conn,$qry);
		$fila =@pg_fetch_array($Rs_ficha,0);
	}
?>

		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.fechacontrol,'Ingresar FECHA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.fechacontrol,'FECHA ATENCION inválida.')){
					return false;
				};

				if(!chkVacio(form.fechasesion,'Ingresar FECHA PROXIMA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.fechasesion,'FECHA PROXIMA ATENCION inválida.')){
					return false;
				};
				return true;
			}
</SCRIPT>
<script language="JavaScript">
function Confirmacion(){
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			document.location="seteaFicha.php?caso=9&Id_Ficha=<? echo $fila['id_ficha'];?>"
		};
</script>
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
    <td height="30" align="center" valign="top"> &nbsp;</td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../../../util/");?>


		
<form name="form" action="procesoFicha.php" method="post">
<input name="Id_Ficha" type="hidden" value="<? echo $fila['id_ficha'];?>">
<table width="600" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
	
	
	<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
      <TR height=15> 
        <TD> <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
          </TABLE>
        </td>
      </tr>
      <TR height=15>
        <TD><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td align="right">
					<?php if($frmModo=="ingresar"){ ?>
							<INPUT TYPE="submit" value="GUARDAR" class="botonXX"  name=btnGuardar onClick="return valida(this.form);" >&nbsp;
							<INPUT TYPE="button" value="CANCELAR" class="botonXX"  name=btnCancelar onClick=document.location="listaFichaAlumnos.php?alumno=<?php echo $alumno;?>">
                  &nbsp; 
                  <?php };?>
                  <?php if($frmModo=="mostrar"){ ?>
                  <?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
                  <input type="button" value="MODIFICAR" name=btnModificar class="botonXX"  onClick=document.location="seteaFicha.php?caso=3">
				  <input type="button" value="ELIMINAR" name=btnModificar class="botonXX"  onClick="Confirmacion()">
                  &nbsp; 
                  <?php }?>
                  <INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick=document.location="listaFichaAlumnos.php?alumno=<?php echo $alumno;?>">&nbsp;
					<?php };?>
					<?php if($frmModo=="modificar"){ ?>
							<INPUT TYPE="submit" value="GUARDAR" class="botonXX"  name=btnGuardar onClick="return valida(this.form);" >&nbsp;
							<INPUT TYPE="button" value="CANCELAR" class="botonXX" onclick=document.location="seteaFicha.php?alumno=<?php echo $alumno?>&caso=1&idFicha=<?php echo $_FICHAM?>">&nbsp;
					<?php };?>
				</td>
			</tr>
			<tr> 
              <td align=middle colspan=2 class="tableindex"><center> FICHA PSICOLOGICA</center></td>
            </tr>
          </table></td>
      </tr>
      <TR height=15>
        <TD><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr> 
              <td height="18"><font size="1" face="Arial, Helvetica, sans-serif">FECHA 
                ATENCI&Oacute;N</font></td>
              <td><font size="1" face="Arial, Helvetica, sans-serif">FECHA PR&Oacute;XIMO 
                CONTROL</font></td>
            </tr>
            <tr> 
              <td><? if($frmModo=="ingresar"){?>
			  			<input name="fechacontrol" type="text" size="10" maxlength="10">
					<? }
					if($frmModo=="mostrar"){
						impF($fila['fechacontrol']);
						echo "<br><br>";
						}
					if($frmModo=="modificar"){?>
						<input name="fechacontrol" type="text" size="10" maxlength="10" value="<? impF($fila['fechacontrol']);?>">
					<? }
					?>
				</td>
              <td><? if($frmModo=="ingresar"){?>
					  <input name="fechasesion" type="text" size="10" maxlength="10">
			  <? }
					if($frmModo=="mostrar"){
						impF($fila['fechasesion']);
						echo "<br><br>";
						}
					if($frmModo=="modificar"){?>
						<input name="fechasesion" type="text" size="10" maxlength="10" value="<? impF($fila['fechasesion']);?>">
					<? }	?>
			  </td>
            </tr>
            <tr> 
              <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">MEDICAMENTOS</font></td>
            </tr>
            <tr> 
              <td colspan="2"><? if($frmModo=="ingresar"){?>
							  <textarea name="medic" cols="60" rows="5"></textarea>
				  			  <? }
								if($frmModo=="mostrar"){
									echo "<font face='arial, Helvetica, sans-serif' size='2'><b>". nl2br($fila['medicamento'])."</b></font>";
									echo "<br><br>";
									}
	  						  if($frmModo=="modificar"){?>
								<textarea name="medic" cols="60" rows="5"><? echo nl2br($fila['medicamento']);?></textarea>
							<? }?>

			  </td>

            </tr>
            <tr> 
              <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">TRATAMIENTOS</font></td>
            </tr>
            <tr> 
              <td colspan="2"><? if($frmModo=="ingresar"){?>
								  <textarea name="tratam" cols="60" rows="5"></textarea>
							  <? }
								if($frmModo=="mostrar"){
									echo "<font face='arial, Helvetica, sans-serif' size='2'><b>". nl2br($fila['tratamiento'])."</b></font>";
									echo "<br><br>";
									}
	  						  if($frmModo=="modificar"){?>
								<textarea name="tratam" cols="60" rows="5"><? echo nl2br($fila['tratamiento']);?></textarea>
							<? }?>			  
			  </td>
            </tr>
            <tr> 
              <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">DIAGNOSTICO</font></td>
            </tr>
            <tr> 
              <td colspan="2"><? if($frmModo=="ingresar"){?>
			  						<textarea name="diag" cols="60" rows="5"></textarea>			  
								<? }
								if($frmModo=="mostrar"){
									echo "<font face='arial, Helvetica, sans-serif' size='2'><b>".nl2br($fila['diagnostico'])."</b></font>&nbsp;";
									echo "<br><br>";
									}
	  						 if($frmModo=="modificar"){?>
								<textarea name="diag" cols="60" rows="5"><? echo nl2br($fila['diagnostico']);?></textarea>
							<? } ?></td>
            </tr>
            <tr> 
              <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">OBSERVACIONES</font></td>
            </tr>
            <tr> 
              <td colspan="2"><? if($frmModo=="ingresar"){?>
			  						<textarea name="observ" cols="60" rows="5"></textarea>			  
							  <? }
								if($frmModo=="mostrar"){
									echo "<font face='arial, Helvetica, sans-serif' size='2'><b>". nl2br($fila['observacion'])."</b></font>&nbsp;";
									echo "<br><br>";
									}
	  						  if($frmModo=="modificar"){?>
								<textarea name="observ" cols="60" rows="5"><? echo nl2br($fila['observacion']);?></textarea>
							<? }?></td>
            </tr>
          </table></td>
      </tr>
    </table>
</form>					 


   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
