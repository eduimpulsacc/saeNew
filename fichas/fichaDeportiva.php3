<?php require('../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="mostrar";
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO='".$alumno."'";
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
<link href="../estilos.css" rel="stylesheet" type="text/css">
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
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../Sea/cortes/b_ayuda_r.jpg','../Sea/cortes/b_info_r.jpg','../Sea/cortes/b_mapa_r.jpg','../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../cortes/fondo_01.jpg">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!--inicio codigo antiguo -->
								  
								  
								  
								  
								  
								  
								  
								  
								  
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
	<CENTER>
	<TABLE WIDTH=100% align="center" cellpadding="0" cellspacing="0" background="../imagenes/background.gif">
 <!-- <TR> 
      <TD height="99"> 
        <div align="center"><img src="imagenes/superior_deportes.gif" height="99" width="600"></div></TD>
  </TR>-->
</TABLE
		><TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
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
							<td rowspan=4>
								<TABLE BORDER=3 CELLSPACING=5 CELLPADDING=5>
									<TR>
										<TD>
											<?php
												$result = @pg_Exec($conn,"select * from alumno where rut_alumno='".$alumno."'");
												$arr=@pg_fetch_array($result,0);

												$output= "select lo_export(".$arr[foto].",'/opt/www/coeint/tmp/".chop($arr[rut_alumno])."');";
												$retrieve_result = @pg_exec($conn,$output);
											if (!$retrieve_result){ ?>
													<img src="apoderado/imag/alumno.gif" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" id="ALUMNO">
											<?php }else{ ?>
													<img src=../../../../../../../tmp/<?php echo chop($arr[rut_alumno]) ?> ALT="NO DISPONIBLE" width=150></p>
											<?php } ?>
										</TD>
									</TR>
								</TABLE>
							</td>
						</TR>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>AÑO ESCOLAR</strong>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
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
									<strong>CURSO</strong>
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
						 	// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
							// ---------------------------------------------------------------------
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
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													$tipo=$fila1['cod_tipo'];
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".$alumno."'";
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
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
													
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
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAno.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<!--INPUT TYPE="button" value="CONTENIDOS"  class="button" onClick=document.location="fichaContenidos.php3">
									<INPUT TYPE="button" value="FICHA MEDICA"  class="button"onClick=document.location="seteaFichaMed.php3">
									<INPUT TYPE="button" value="FICHA ALUMNO"  class="button"onClick=document.location="fichaAlumno.php3">
									<INPUT TYPE="button" value="FICHA APODERADOS"  class="button"onClick=document.location="fichaApoderados.php3">
									<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')"-->
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<!--INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);"-->
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaFicha.php3?alumno=<?php echo $alumno?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20>
							
            <TD colspan=2 align=middle class="tableindex"> FICHA DEPORTIVA</TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=5 cellspacing=5>
									<TR>
										
                  <TD width=300 align=center VALIGN=TOP> <font size="2" face="Arial, Helvetica, sans-serif">DOCENTE</font> 
                    <?php
											$qry="SELECT empleado.*, subsector.cod_subsector FROM ((subsector INNER JOIN (curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) ON subsector.cod_subsector = ramo.cod_subsector) INNER JOIN dicta ON ramo.id_ramo = dicta.id_ramo) INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp WHERE (((curso.id_curso)=".$_CURSO.") AND ((subsector.cod_subsector)=11))";
											$result = @pg_Exec($conn,$qry);
											$arr=@pg_fetch_array($result,0);

											$sqlTitulo = "select nombre from empleado_estudios where rut_empleado ='".$arr[rut_emp]."'";
											$rsTitulo = @pg_Exec($conn,$sqlTitulo);
											
											$output= "select lo_export(".$arr[foto].",'/opt/www/coeint/tmp/".chop($arr[rut_emp])."');";
											$retrieve_result = @pg_exec($conn,$output);
										?>
										<? if (retrieve_result){?>
						                    <img src=../../../../../../../tmp/<?php echo chop($arr[rut_emp]) ?> ALT="NO DISPONIBLE"  width=120> 
										<? } ?>
                  </TD>
										<TD VALIGN=TOP>
											<TABLE width=400 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=CENTER height=10>
														<FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<STRONG>&nbsp;&nbsp;DATOS DEL PROFESOR(A) DE EDUCACION FISICA</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													
                        <TD align=CENTER height=10> <table width=100% bgcolor=#cccccc border=0 cellpadding=1 cellspacing=1 class="tabla_2">
                            <tr> 
                              <td align=LEFT width=150 class="td2" valign=TOP ><font size="2" face="Arial, Helvetica, sans-serif">NOMBRE</font></td>
                              <td align=LEFT width=250 class="td2" bgcolor=WHITE valign=TOP > 
                                <font size="2" face="Arial, Helvetica, sans-serif"> 
                                <?php
												echo $arr['ape_pat']." , ".$arr['nombre_emp'];
								?>
                                </font></td>
                            </tr>
                            <tr> 
                              <td align=LEFT class="td2" valign=TOP ><font size="2" face="Arial, Helvetica, sans-serif">TITULO</font></td>
                              <td align=LEFT class="td2" bgcolor=WHITE valign=TOP > 
                                <font size="2" face="Arial, Helvetica, sans-serif"> 
                                <?php 
											$fTitulo  = @pg_fetch_array($rsTitulo,0); 
											echo $fTitulo['nombre'];
								?>
                                </font></td>
                            </tr>
                            <tr> 
                              <td align=LEFT class="td2" valign=TOP ><font size="2" face="Arial, Helvetica, sans-serif">OTROS 
                                ESTUDIOS</font></td>
                              <td align=LEFT class="td2" bgcolor=WHITE valign=TOP > 
                                <font size="2" face="Arial, Helvetica, sans-serif"> 
                                <?php
									for($i=1;$i<@pg_numrows($rsTitulo);$i++)
									{ 
											$fTitulo  = @pg_fetch_array($rsTitulo,$i); 
											echo $fTitulo['nombre'];
									}
								?>
                                </font></td>
                            </tr>
                            <tr> 
                              <td align=LEFT class="td2" valign=TOP ><font size="2" face="Arial, Helvetica, sans-serif">CORREO 
                                ELECTRONICO</font></td>
                              <td align=LEFT class="td2" bgcolor=WHITE valign=TOP > 
                                <font size="2" face="Arial, Helvetica, sans-serif"> 
                                <?php
																	echo $arr['email']
																?>
                                </font></td>
                            </tr>
                          </table></TD>
												</TR>
											</TABLE>						
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=20 bgcolor=WHITE>
							<TD align=middle colspan=2></TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;PESO</STRONG>
														</FONT>
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
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;TALLA</STRONG>
														</FONT>
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
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;% GRASA</STRONG>
														</FONT>
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
											<HR width="100%" color=#0099cc>
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
	</TD>	
			</TR>
		</TABLE>
	</CENTER>

								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  <!-- fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 - Desarrolla Colegio 
                        Interactivo</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="52" align="left" valign="top" background="../cortes/fomdo_02.jpg">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
