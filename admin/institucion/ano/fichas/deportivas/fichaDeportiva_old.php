<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$_POSP          =5;
	$_bot           = 5;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO='".trim($alumno)."'";
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
<link href="../../../../../Sea/estilos.css" rel="stylesheet" type="text/css">
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
<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
	
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../Sea/cortes/b_ayuda_r.jpg','../../../../../Sea/cortes/b_info_r.jpg','../../../../../Sea/cortes/b_mapa_r.jpg','../../../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../Sea/<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7">  
             <? include("../../../../../cabecera/menu_superior.php"); ?>
                           
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? //include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio codigo nuevo -->
								  
								  
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? //include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	<FORM method=post name="frm" action="../../../../../procesoFicha.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO</strong>
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
									<INPUT TYPE="submit" class="botonXX"  value="GUARDAR"  name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" class="botonXX"  value="CANCELAR" name=btnCancelar onClick=document.location="listarAno.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=20)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){ //ACADEMICO Y LEGAL?>
										<INPUT TYPE="button" value="MODIFICAR" class="botonXX"  name=btnModificar  onClick=document.location="seteaFicha.php3?alumno=<?php echo $alumno?>&caso=3">&nbsp;
									<?php }?>
									<INPUT TYPE="button" value="VOLVER" class="botonXX"  onClick=document.location="../listarAlumnosMatriculados.php3?tipoFicha=2">&nbsp;
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<!--INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);"-->
									<INPUT TYPE="submit" value="GUARDAR"  name=btnGuardar class="botonXX" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar class="botonXX"  onclick=document.location="seteaFicha.php3?alumno=<?php echo $alumno?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor="#003b85">
							<TD align=middle colspan=2 class="tableindex">
								
									FICHA DEPORTIVA
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10 class="tablatit2-1">
														PESO
													</TD>
												</TR>
												<TR>
													<TD>
														<TABLE width=100% height=100% bgcolor=White BORDER=0>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD>
																				<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
																					<TR>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>MARZO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>ABRIL</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>MAYO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>JUNIO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>JULIO</STRONG>
																							</FONT>
																						</TD>
																					</TR>
																					<TR>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP3 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe3"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP3 size=5 maxlength=5 value="<?php echo $fila["pe3"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP4 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe4"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP4 size=5 maxlength=5 value="<?php echo $fila["pe4"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP5 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe5"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP5 size=5 maxlength=5 value="<?php echo $fila["pe5"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP6 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe6"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP6 size=5 maxlength=5 value="<?php echo $fila["pe6"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP7 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe7"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP7 size=5 maxlength=5 value="<?php echo $fila["pe7"]?>">
																							<?php };?>
																						</TD>
																					</TR>

																					<TR height=15><TD colspan=5></TD></TR>

																					<TR>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>AGOSTO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>SEPTIEMBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>OCTUBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>NOVIEMBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>DICIEMBRE</STRONG>
																							</FONT>
																						</TD>
																					</TR>
																					<TR>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP8 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe8"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP8 size=5 maxlength=5 value="<?php echo $fila["pe8"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP9 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe9"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP9 size=5 maxlength=5 value="<?php echo $fila["pe9"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP10 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe10"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP10 size=5 maxlength=5 value="<?php echo $fila["pe10"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP11 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe11"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP11 size=5 maxlength=5 value="<?php echo $fila["pe11"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP12 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pe12"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtP12 size=5 maxlength=5 value="<?php echo $fila["pe12"]?>">
																							<?php };?>
																						</TD>
																					</TR>
																				</TABLE>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
											</TABLE>						
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10 class="tablatit2-1">
														TALLA
													</TD>
												</TR>
												<TR>
													<TD>
														<TABLE width=100% height=100% bgcolor=White BORDER=0>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD>
																				<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
																					<TR>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>MARZO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>ABRIL</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>MAYO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>JUNIO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>JULIO</STRONG>
																							</FONT>
																						</TD>
																					</TR>
																					<TR>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT3 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta3"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT3 size=5 maxlength=5 value="<?php echo $fila["ta3"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT4 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta4"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT4 size=5 maxlength=5 value="<?php echo $fila["ta4"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT5 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta5"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT5 size=5 maxlength=5 value="<?php echo $fila["ta5"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT6 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta6"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT6 size=5 maxlength=5 value="<?php echo $fila["ta6"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT7 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta7"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT7 size=5 maxlength=5 value="<?php echo $fila["ta7"]?>">
																							<?php };?>
																						</TD>
																					</TR>

																					<TR height=15><TD colspan=5></TD></TR>

																					<TR>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>AGOSTO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>SEPTIEMBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>OCTUBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>NOVIEMBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>DICIEMBRE</STRONG>
																							</FONT>
																						</TD>
																					</TR>
																					<TR>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtP8 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta8"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT8 size=5 maxlength=5 value="<?php echo $fila["ta8"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT9 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta9"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT9 size=5 maxlength=5 value="<?php echo $fila["ta9"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT10 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta10"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT10 size=5 maxlength=5 value="<?php echo $fila["ta10"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT11 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta11"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT11 size=5 maxlength=5 value="<?php echo $fila["ta11"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtT12 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["ta12"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtT12 size=5 maxlength=5 value="<?php echo $fila["ta12"]?>">
																							<?php };?>
																						</TD>
																					</TR>
																				</TABLE>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
											</TABLE>						
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10 class="tablatit2-1">
														% GRASA
													</TD>
												</TR>
												<TR>
													<TD>
														<TABLE width=100% height=100% bgcolor=White BORDER=0>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD>
																				<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
																					<TR>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>MARZO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>JUNIO</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>SEPTIEMBRE</STRONG>
																							</FONT>
																						</TD>
																						<TD>
																							<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																								<STRONG>NOVIEMBRE</STRONG>
																							</FONT>
																						</TD>
																					</TR>
																					<TR>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtPG3 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pg3"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtPG3 size=5 maxlength=5 value="<?php echo $fila["pg3"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtPG6 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pg6"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtPG6 size=5 maxlength=5 value="<?php echo $fila["pg6"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtPG9 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pg9"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtPG9 size=5 maxlength=5 value="<?php echo $fila["pg9"]?>">
																							<?php };?>
																						</TD>
																						<TD>
																							<?php if($frmModo=="ingresar"){ ?>
																								<INPUT type="text" name=txtPG11 size=5 maxlength=5>
																							<?php };?>
																							<?php 
																								if($frmModo=="mostrar"){ 
																									imp($fila["pg11"]);
																								};
																							?>
																							<?php if($frmModo=="modificar"){ ?>
																								<INPUT type="text" name=txtPG11 size=5 maxlength=5 value="<?php echo $fila["pg11"]?>">
																							<?php };?>
																						</TD>
																					</TR>

																				</TABLE>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
														</TABLE>
													</TD>
												</TR>
											</TABLE>						
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=3>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<HR width="100%" color="#003b85">
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2 ALIGN=CENTER>
								<FONT face="arial, geneva, helvetica" size=2 COLOR=RED>&nbsp;
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>

								  
								  
								  
								  
								  
								  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../Sea/<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
