<?php require('../../../..//util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$usuario		=$_USUARIO;
	$empleado		=$_EMPLEADO;
	$nombreusuario=$_NOMBREUSUARIO;
	$_POSP          =4;
	if ($empleado==""){
		$empleado=$empleados;
	};
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

		
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">

			function valida(form){
				if(!chkVacio(form.txting,'Ingresar FECHA COMIENZO.')){
					return false;
				};
				if(!chkVacio(form.txtter,'Ingresar FECHA TERMINO.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
	

</head>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- inocio codigo antiguo -->
								  
								  
								  
	<?php //echo tope("../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=2>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>EMPLEADO</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
										if ($_PERFIL == 2){
										   $qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".trim($nombreusuario);
											$result = pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														exit();
													}		
													
												}
											}
									    }else{							
										
											$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$empleado;
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
													
												}
											}
										}	
										echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_emp']);
										
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<tr>
				
      <td colspan=2 align=right> <input class="botonXX"  name="button" type="button" onClick="window.history.go(-1)" value="VOLVER"></td>
			</tr>
			<tr height="20">
				<td align="middle" colspan="2" class="tableindex">
					AGREGAR EXPIRACIÓN A LA CUENTA 
				</td>
			</tr>
			<TR>
				<TD width=30></TD>
				<TD>
					<FORM method=post name="frm" action="proceso_expiracion.php">
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>INGRESAR<BR>FECHA COMIENZO<br>(aaa-mm-dd)</STRONG>
									</FONT>
								</TD>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>INGRESAR<BR>FECHA TERMINO<br>(aaaa-mm-dd)</STRONG>
									</FONT>
								</TD>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>ULTIMA CONEXION<BR>FECHA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; HORA:<br>(aaaa-mm-dd)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(hh:mm:ss)</STRONG>
									</FONT>
								</TD>
							</TR>
					<?	$sql = "select * from cliente_prueba where rut_emp = '$empleado'";
						$result =@pg_Exec($conn,$sql);
						$fila = @pg_fetch_array($result,0);
						if(@pg_numrows($result)!=0)
						{	?>						
							<TR>
								<TD>
									<input type="text" name="txting" size=15 maxlength=10 value="<?=$fila['primer_ingreso']?>">
								</TD>
								<TD>
									<input type="text" name="txtter" size=15 maxlength=10 value="<?=$fila['ultimo_ingreso']?>">
								</TD>
								<TD>
									<input type="text" name="txtPW3" size=15 maxlength=10 disabled="disabled" value="<?=$fila['ultima_coneccion']?>">
									<input type="text" name="txtPW3" size=15 maxlength=10 disabled="disabled" value="<?=$fila['hora']?>">
								</TD>
							</TR>							
					<?	}else{											
					?>							
							<TR>
								<TD>
									<input type="text" name="txting" size=15 maxlength=10>
								</TD>
								<TD>
									<input type="text" name="txtter" size=15 maxlength=10>
								</TD>
								<TD>
									<input type="text" name="txtPW3" size=15 maxlength=8 disabled="disabled" value="No iniciado">
									<input type="text" name="txtPW3" size=15 maxlength=10 disabled="disabled" value="No iniciado">
								</TD>
							</TR>
						<? } ?>
							<TR align=center HEIGHT=50 VALIGN=BOTTOM>
								<TD colspan=3>
									<input class="botonXX"  type=submit value=GUARDAR onClick="return valida(this.form);">
								</TD>
							</TR>
						</TABLE>
					</FORM>
				</TD>
			</TR>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#003b85">
				</td>
			</tr>
		</table>
	</center>

								  
								  <!-- fin codigo antiguo --></td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>