<?php require('../../../../../../util/header.inc');


	
	$institucion	=$_INSTIT;
	$alumno			=$_ALUMNO;
	$_POSP = 6;

	
	if ($RUT>0){
		$alumno = $RUT;
		session_register('_ALUMNO');
		$_ALUMNO = $alumno;
	}
	
	$qry="select * from usuario where nombre_usuario='".trim($alumno)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
		if (pg_numrows($result)!=0){
			$fila1 = @pg_fetch_array($result,0);	
			if (!$fila1){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
				$idUsuario=trim($fila1['id_usuario']);
			};
		};
	};

	/*echo"-->".$_ID_USER	=	$idUsuario;
	if(!session_is_registered('_ID_USER')){
		session_register('_ID_USER');
	};*/
	//SI $idUsuario ES "" IMPLICA QUE NO EXISTE ESTE USUARIO REGISTRADO.
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../estilos.css" rel="stylesheet" type="text/css">
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
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				return true;
			}
		</SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include ("../../../../../../cabecera/menu_superior.php") ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="96%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="13%" height="363" align="left" valign="top"> 
                        <? include ("../../../../../../menus/menu_lateral.php") ?></td>
                      <td width="87%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top">
								  <!-- inicio codigo antiguo -->
								  
								  
								  
								  <FORM method=post name="frm">
		<TABLE WIDTH=95% BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD <?php if($idUsuario=="") { echo "colspan=4";}?>>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
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
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>ALUMNO</strong>
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
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
		<?php if($idUsuario!="") {//SI EL NOMBRE DE USUARIO YA ESTA REGISTRADO COMO USUARIO DE COE?>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
<!--							<TD align=right colspan=2>
								<? if ($_TIPO_CLAVE==1){?>
									<INPUT class="botonXX"  name="button" TYPE="button" onClick=document.location="../../../../Claves.php" value="VOLVER">								  &nbsp;
								<? } else { 
									    if ($_PERFIL == 15){ ?>																		
									       <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../apoderado.php3" >
										   <?
										}else{
										    if ($_PERFIL == 0){ ?>
											   <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../alumno.php3" >   
											   <?
											}
									     }		   
								 } ?>&nbsp;
							</TD>
-->						</TR>
						<TR height=20 class="tableindex">
							<TD align=center colspan=2>
								USUARIO
							</TD>
						</TR>
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
											<?php 
											    imp(trim($fila1['rut_alumno']));
												
											?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>PERFILES DE ACCESO</STRONG>
												</FONT>
										</TD>
									</TR>
									<TR>
										<TD >
											<?php
													$qry="SELECT usuario.id_usuario, usuario.nombre_usuario, accede.estado, accede.rdb, perfil.id_perfil, perfil.nombre_perfil FROM (accede INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON accede.id_usuario = usuario.id_usuario WHERE (((usuario.id_usuario)=".$idUsuario.") AND ((accede.rdb)=".$_INSTIT.")) ORDER BY NOMBRE_PERFIL ASC;";
													$result =@pg_Exec($conn,$qry);
													if (!$result) 
														error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
													else{
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															if (!$fila1){
																error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
																exit();
															};
															for($i=0 ; $i < @pg_numrows($result) ; $i++){
																$fila1 = @pg_fetch_array($result,$i);
																echo "- ".$fila1["nombre_perfil"];
																	if($fila1["estado"]==1)
																		if(($_PERFIL==15)||($_PERFIL==16)){//APODERADO O ALUMNO
																			echo "&nbsp;&nbsp;&nbsp;&nbsp;<input class=botonXX type=button value=off onClick=document.location='onoffPerfil.php3?estado=1&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."' disabled ><BR>";
																			}else{
																				echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=button class=botonXX value=off onClick=document.location='onoffPerfil.php3?estado=1&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."'><BR>";
																			}
																		else
																			if(($_PERFIL==15)||($_PERFIL==16)){//APODERADO O ALUMNO
																				echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=button class=botonXX value=on onClick=document.location='onoffPerfil.php3?estado=0&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."' disabled ><BR>";
																				}else{
																					echo "&nbsp;&nbsp;&nbsp;&nbsp;<input type=button class=botonXX value=on onClick=document.location='onoffPerfil.php3?estado=0&perfil=".$fila1["id_perfil"]."&usuario=".$fila1["id_usuario"]."'><BR>";
																				}
															}
														}
												};
											?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#0099cc>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
						
							<TD width="100%" colspan=2 align=left>
								<INPUT TYPE="button" class="botonXX"  value="CAMBIAR CLAVE" onClick=document.location="claveAcceso.php3">
								<?php if(($_PERFIL==0)/*||($_PERFIL==14)||($_PERFIL==1)*/){//ADMINISTRADOR TOTAL O ADMINISTRADOR WEB?>
									<INPUT TYPE="button" class="botonXX"  value="AGREGAR PERFIL" onClick=document.location="addPerfil.php3">
								<?php 
									
								}?>
							</TD>
						</TR>
		<?php }else{ //EMPLEADO SIN ACCESO WEB?>
						<TR>
							<TD width=30></TD>
							<TD colspan=3><br><br>
								<center>
								  <span class="tableindex">	
									USUARIO SIN ACCESO WEB <BR><br><br>
									<INPUT TYPE="button" class="botonXX"  value="CREAR CUENTA" onClick=document.location="creaAcceso.php3"<?php if(($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=1)){echo " disabled ";}?>>
&nbsp;								  </span>
								</center>							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color=#0099cc>
										</TD>
									</TR>
									<TR>
<!--										<TD align=right>
									<? if ($_TIPO_CLAVE==1){?>
									<INPUT class="botonXX"  name="button" TYPE="button" onClick=document.location="../../../../Claves.php" value="VOLVER">								  &nbsp;
									<? } else { ?>																		
									<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="../alumno.php3" >
									<? } ?>&nbsp;
										</TD>
-->									</TR>
								</TABLE>
							</TD>
						</TR>
					<?php }?>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
								  
								  
								  
								  
								  <!-- fin codigo antiguo -->
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php");?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
