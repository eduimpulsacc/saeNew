<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$_bot = 10;
	$libro			=$_LIBRO;
	if ($botonera==1){
	$frmModo="mostrar";
	}else{
	$frmModo		=$_FRMMODO;
	}
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
//	$frmModo		="ingresar";
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM LIBRO WHERE ID=".$libro;
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
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=_ESTILO?>" rel="stylesheet" type="text/css">
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


<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkSelect(form.COD_EDIT,'INGRESE EDITORIAL.')){
					return false;
				};
				if(!chkVacio(form.TITULO,'Ingresar TITULO.')){
					return false;
				};
				if(!chkVacio(form.AUTOR,'Ingresar AUTOR.')){
					return false;
				};
				if(!chkVacio(form.ANO,'Ingresar AÑO.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  
					    <?
						$menu_lateral=4;
						include("../../../menus/menu_lateral.php");
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
                                  <td><br>

								  
								  <!-- AQUI INGRESO EL NUEVO CÓDIGO -->
								  
								  
								     <table width="90%" height="38" border="0" cellpadding="0" cellspacing="0">
       <tr> 
    <td height="38" align="center" valign="top"> 
      	<?php if (($_PERFIL!=15)and($_PERFIL!=16)){?>

	  
	  
	  <?
						include("../../../cabecera/menu_inferiorinstitucion.php");
						?>
	  
	  
	  
	  
	  	<?php }?>

	   </td>
  </tr>
</table>  


	<FORM method=post name="frm" action="procesoLibro.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		
	?>
		<input type="hidden" name="id_libro" value="<?=trim($fila['id']); ?>">
		<TABLE WIDTH=90% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR >
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
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
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
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
        <TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar 
									onclick="return valida(this.form);">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarLibros.php">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4) and ($_PERFIL!=15)and($_PERFIL!=16)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaLibro.php3?libro=<?php echo $libro?>&caso=3">&nbsp;
									<!--	<INPUT class="botonXX"  TYPE="button" value="ELIMINAR" name=btnEliminar onClick="window.location='elimlibro.php?id=<?php echo $libro?>'">  -->
										&nbsp;
											<?php }?>
									<?php }//ACADEMICO Y LEGAL?>
										<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarLibros.php">&nbsp;
								<?php };?>

								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaLibro.php3?libro=<?php echo $libro?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						
        <TR height=20> 
          <TD colspan=2 align=middle class="tableindex"> LIBROS </TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
              <TR> 
                <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>ISBN</STRONG> </FONT> </TD>
              </TR>
              <TR> 
                <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php if($frmModo=="ingresar"){ ?>
                  <input type=text name="ISBN" size=12 maxlength=12>
                  <?php };?>
                  <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['isbn']);
												};
											?>
                  <?php if($frmModo=="modificar"){ ?>
                  <input type=text name="ISBN" VALUE=<?php echo trim($fila['isbn']); ?> size=12 maxlength=12>
                  <?php };?>
                  </font></strong></TD>
              </TR>
            </TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
              <TR> 
                <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>TITULO</STRONG> </FONT> </TD>
              </TR>
              <TR> 
                <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="text" name=TITULO size=80 maxlength=100>
                  <?php };?>
                  <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['titulo']);
												};
											?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=TITULO size=80 VALUE="<?php echo trim($fila['titulo']); ?>" maxlength=100>
                  <?php };?>
                  </font></strong></TD>
              </TR>
            </TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
              <TR> 
                <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>SUB TITULO</STRONG> </FONT> </TD>
              </TR>
              <TR> 
                <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php if($frmModo=="ingresar"){ ?>
                  <INPUT type="text" name=SUBTITULO size=80 maxlength=100>
                  <?php };?>
                  <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['subtitulo']);
												};
											?>
                  <?php if($frmModo=="modificar"){ ?>
                  <INPUT type="text" name=SUBTITULO size=80 VALUE="<?php echo trim($fila['subtitulo']); ?>" >
                  <?php };?>
                  </font></strong></TD>
              </TR>
            </TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
              <TR> 
                <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>NOTAS</STRONG> </FONT> </TD>
              </TR>
              <TR> 
                <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php if($frmModo=="ingresar"){ ?>
                  <textarea name="NOTA" cols="60" rows="3"></textarea>
                  <?php };?>
                  <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['notas']);
												};
											?>
                  <?php if($frmModo=="modificar"){ ?>
                  <textarea name="NOTA" cols="60" rows="3"><?php echo trim($fila['notas']); ?></textarea>
                  <?php };?>
                  </font></strong></TD>
              </TR>
            </TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
              <TR> 
                <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>AUTOR</STRONG> </FONT> </TD>
              </TR>
              <TR> 
                <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php if($frmModo=="ingresar"){ ?>
                  <input type=test name="AUTOR" size="60" >
                  <?php };?>
                  <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['autor']);
												};
											?>
                  <?php if($frmModo=="modificar"){ ?>
                  <input type=test name="AUTOR" size="60" VALUE="<?php echo trim($fila['autor']); ?>">
                  <?php };?>
                  </font></strong></TD>

              </TR>
            </TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
              <TR> 
                <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>AÑO EDICION</STRONG> </FONT> </TD>
              </TR>
              <TR> 
                <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php if($frmModo=="ingresar"){ ?>
                  <input name="ANO" size="4" maxlength=4>
                  Ej. 2002</font> <font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php };?>
                  <?php 
										if($frmModo=="mostrar"){ 
											imp($fila['ano']);
										};
									?>
                  <?php if($frmModo=="modificar"){ ?>
                  <input name="ANO" size="4" VALUE="<?php echo trim($fila['ano']); ?>">
                  Ej. 2002</font> <font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php };?>
                  </font></strong></TD>
              </TR>
            </TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
              <TR> 
                <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>EDICION</STRONG> </FONT> </TD>
              </TR>
              <TR> 
                <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                  <?php if($frmModo=="ingresar"){ ?>
                  <input name="EDICION" size="50">
                  <?php };?>
                  <?php 
										if($frmModo=="mostrar"){ 
											imp($fila['edicion']);
										};
									?>
                  <?php if($frmModo=="modificar"){ ?>
                  <input name="EDICION" size="50" VALUE="<?php echo trim($fila['edicion']); ?>">
                  <?php };?>
                  </font></strong></TD>
              </TR>
              <TR> 
                <TD> <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
                    <TR> 
                      <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>EDITORIAL</STRONG> </FONT> </TD>
                    </TR>
                    <TR> 
                      <TD> <strong><font color="#000000" size="2" face="Arial, Helvetica, sans-serif"> 
                        <?php
										if(($frmModo=="ingresar")||($frmModo=="modificar")){
											$qry="SELECT * FROM editorial where nombre!='' order by nombre asc ";
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD.(1)</B>');
											$sele="";
											if ($fila['cod_edit']!=0) {
												$sele="SELECTED";
											}
											echo "<select name=COD_EDIT >";
											echo "<option value='' ",$sele,">--SELECCIONE UNA--</option>";
											for ($x=0 ; $x<@pg_numrows($result);$x++){
													$row = @pg_fetch_array($result,$x);
													echo "<option value=",$row[cod_edit]," ".$sele.">",$row[nombre]," ",$row[APE_PAT],"</option>";
											}
											echo "</select>";	
											
										?>
                        <INPUT class="botonXX"  TYPE="button" value="AGREGAR EDITORIAL" onClick=window.open('addedit.htm','Editorial','height=200,width=380,scrollbar=no,location=no,resizable=no')>
                        <?php 
										}
										if($frmModo=="mostrar"){ 
											$qry="SELECT * FROM editorial where COD_EDIT=".$fila[cod_edit];
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD.(1)</B>');
											$row = @pg_fetch_array($result,0);

											echo $row[nombre];
										}
										?>
                        <input type=hidden name=id value=<?php echo trim($libro)?>>
                        </font></strong></TD>
                    </TR>
                  </TABLE></TD>
              </TR>
            </TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
	
	     <!-- FIN DE INGRESO DEL NUEVO CODIGO -->
								  
								 </td>
                                </tr>
                              </table>  
								  
								  
								  
								  </td>
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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
