<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO=".trim($alumno);
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
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
								<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

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
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../../../../../../menu/adm/imag/fondomain.gif);
	margin-left: 75px;
}
-->
</style></HEAD>
<body topmargin="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<!--table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>
          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../../../ano/ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table -->
<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	<FORM method=post name="frm" action="procesoFicha.php">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 >
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
									<INPUT TYPE="submit" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="GUARDAR"  name=btnGuardar onclick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="CANCELAR" name=btnCancelar onClick=document.location="listarAno.php">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=20)){ //ACADEMICO Y LEGAL?>
										<INPUT TYPE="button" value="MODIFICAR" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name=btnModificar  onClick=document.location="seteaFicha.php?alumno=<?php echo $alumno?>&caso=3">&nbsp;
									<?php }?>
									<INPUT TYPE="button" value="LISTADO" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onClick=document.location="../listarAlumnosMatriculados.php?tipoFicha=2">&nbsp;
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<!--INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);"-->
									<INPUT TYPE="submit" value="GUARDAR"  name=btnGuardar class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff'>&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' onclick=document.location="seteaFicha.php?alumno=<?php echo $alumno?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor="#003b85">
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>FICHA DEPORTIVA</strong>
								</FONT>
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
</BODY>
</HTML>