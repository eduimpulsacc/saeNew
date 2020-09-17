<?php require('../../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$usuario		=$_USUARIO;
	$apoderado		=$_APODERADO;
	$_POSP = 7;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

		<SCRIPT language="JavaScript" src="../../../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">

			function valida(form){
				if(form.txtPW1.length<6){
					alert('Clave de acceso muy corta.\n Clave de acceso debe ser entre 6 y 10 caracteres.');
					return false;
				};
				if(form.txtPW1.length>10){
					alert('Clave de acceso muy larga.\n Clave de acceso debe ser entre 6 y 10 caracteres.');
					return false;
				};

				if(!chkVacio(form.txtPW1,'Ingresar CLAVE.')){
					return false;
				};
				if(!chkVacio(form.txtPW2,'Repetir CLAVE.')){
					return false;
				};
				if (!igual(form.txtPW1,form.txtPW2,'Error al repetir la clave de acceso.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../../Sea/cortes/b_ayuda_r.jpg','../../../../../../../Sea/cortes/b_info_r.jpg','../../../../../../../Sea/cortes/b_mapa_r.jpg','../../../../../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
           <? include("../../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
								  
								  
								  
	<?php // echo tope("../../../../../../../util/");?>
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD COLSPAN=2>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
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
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nombre_instit']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>APODERADO</strong>
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
											$qry="SELECT * FROM APODERADO WHERE RUT_APO='".trim($apoderado)."'";
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_apo']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<tr>
				<td colspan=2 align=right>
					<INPUT TYPE="button" value="VOLVER" class="botonXX" onClick=document.location="usuario.php3">
				</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle" colspan="2">
					CREAR ACCESO COLEGIO ELECTRONICO
				</td>
			</tr>
			<FORM method=post name="frm" action="guardaAcceso.php3">
				<TR>
					<TD width=30></TD>
					<TD>
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>NOMBRE USUARIO</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
									<?php imp(trim($apoderado));?>
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR>
					<TD width=30></TD>
					<TD>
						<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 >
							<TR>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>INGRESAR CLAVE</STRONG>
									</FONT>
								</TD>
								<td>&nbsp;&nbsp;</td>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>REPETIR CLAVE</STRONG>
									</FONT>
								</TD>
								<td>&nbsp;&nbsp;</td>
								<TD>
									<FONT face="arial, geneva, helvetica" size=1 color=#000000>
										<STRONG>PERFIL DE ACCESO</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
									<input type=password name="txtPW1" size=15 maxlength=8>
								</TD>
								<td></td>
								<TD>
									<input type=password name="txtPW2" size=15 maxlength=8>
								</TD>
								<td></td>
								<TD>
									APODERADO<br>
									<input type=hidden name="cmbPERFIL" value="15">
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR align=center HEIGHT=50 VALIGN=BOTTOM>
					<TD colspan=2 align=center>
						<input type="submit" value="GUARDAR" class="botonXX" onClick="return valida(this.form);">
					</TD>
				</TR>

			</FORM>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#0099cc">
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
