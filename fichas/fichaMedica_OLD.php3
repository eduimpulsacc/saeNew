<?php require('../util/header.inc');?>
<?php
	$institucion	=$_INSTIT;
//	$frmModo		=$_FRMMODO;
	$frmModo		="mostrar";
	$curso			=$_CURSO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;


?>
<?php 
	if($idFicha!=""){
		$qry="SELECT * FROM FICHA_MEDICA WHERE ID_FICHA=".$idFicha." ORDER BY FECHA_ATENCION DESC";
		$result =@pg_Exec($conn,$qry);
		if (!$result){
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
		<LINK REL="STYLESHEET" HREF="td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
/*				if(!chkVacio(form.txtFECHAATE,'Ingresar FECHA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAATE,'FECHA ATENCION invalida.')){
					return false;
				};
*/
				if(!chkVacio(form.txtFECHAPROXATE,'Ingresar FECHA PROXIMA ATENCION.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAPROXATE,'FECHA PROXIMA ATENCION invalida.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
		<SCRIPT language="JavaScript">
			function jmpFicha(form){
				document.location = "seteaFichaMed.php3?caso=1&ficha=" + form.txtFECHAATE.value;
//				return false;
			}
		</SCRIPT>
	</HEAD>
<BODY leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">
	<CENTER>
	<TABLE WIDTH=100% align="center" cellpadding="0" cellspacing="0" background="imagenes/background.gif">
  <TR> 
      <TD height="99"> 
        <div align="center"><img src="imagenes/superior_salud.gif" height="99" width="600"></div></TD>
  </TR>
</TABLE>
<?php 
	if($idFicha!=""){
//		echo (int) $idFicha;
//		exit;
?>
	<FORM method=post name="frm">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
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
												$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
												$arr=@pg_fetch_array($result,0);

												$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
												$retrieve_result = @pg_exec($conn,$output);
											?>
											<img src=../../tmp/<?php echo $arr[rut_alumno] ?> ALT="NO DISPONIBLE" width=150>
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
								<INPUT TYPE="button" value="CONTENIDOS"  class="button" onClick=document.location="fichaContenidos.php3">
								<INPUT TYPE="button" value="FICHA APODERADOS"  class="button"onClick=document.location="fichaApoderados.php3">
								<INPUT TYPE="button" value="FICHA ALUMNO"  class="button"onClick=document.location="fichaAlumno.php3">
								<INPUT TYPE="button" value="FICHA DEPORTIVA"  class="button"onClick=document.location="fichaDeportiva.php3">
								<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')">
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>FICHA MEDICA</strong>
								</FONT>
							</TD>
						</TR>

						<TR>
							<TD colspan=3 align=center>
								<TABLE WIDTH="75%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA DE ATENCION<BR>DEL ESPECIALISTA</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA PROXIMO<BR>CONTROL</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtFECHAATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAATE,'Fecha atencion invalida.');">
											<?php };?>
											<Select name="txtFECHAATE">
												<!--option value=0></option-->
												<?php 
													//SELECCIONAR FECHAS DEL AÑO ESCOLAR
													$qryANO ="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$_ANO;
													$resultANO =@pg_Exec($conn,$qryANO);
//													echo pg_numrows($resultANO); 
													if (pg_numrows($resultANO)!=0){
														$filaANO = @pg_fetch_array($resultANO,0);
														if (!$filaANO){
															error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
															exit();
														}
														//SELECCIONAR FICHAS PARA ESE AÑO ACADEMICO
														$qryFICHA="SELECT * FROM FICHA_MEDICA WHERE FECHA_ATENCION BETWEEN '".$filaANO['fecha_inicio']."' AND '".$filaANO['fecha_termino']."' AND RUT_ALUMNO='".trim($_ALUMNO)."'";
														//echo $qryFICHA;
														$resultFICHA =@pg_Exec($conn,$qryFICHA);
														if (pg_numrows($resultFICHA)!=0){
															$filaFICHA = @pg_fetch_array($resultFICHA,0);
															if (!$filaFICHA){
																error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																exit();
															}
															//LISTAR FICHAS
															for($i=0 ; $i < @pg_numrows($resultFICHA) ; $i++){
																$filaFICHA = @pg_fetch_array($resultFICHA,$i);
																$laFecha=$filaFICHA['fecha_atencion'];
																if(!strcmp((int)$filaFICHA['id_ficha'],$idFicha)){
																	$ID=$filaFICHA['id_ficha'];
																	echo  "<option value=".$ID." selected >".$laFecha;
																}else{
																	$ID=$filaFICHA['id_ficha'];
																	echo  "<option value=".$ID." >".$laFecha;
																}
															}
														}
													}
												?>
											</Select>
											<INPUT TYPE="button" value="VER" onClick="javascript:jmpFicha(this.form);">
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHAATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAATE,'Fecha atencion invalida.');"  value="<?php impF($fila['fecha_atencion'])?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtFECHAPROXATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAPROXATE,'Fecha proximo control invalida.');">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_prox_at']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtFECHAPROXATE size=10 maxlength=10 onChange="chkFecha(form.txtFECHAPROXATE,'Fecha proximo control invalida.');"  value="<?php impF($fila['fecha_prox_at'])?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						
						<TR>
							<!--TD width=30></TD-->
							<TD>

								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;OFTALMOLOGIA</STRONG>
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
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk1">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_alta'],"chk1");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_alta'],"chk1");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ALTA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk2">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_en_estudio'],"chk2");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_en_estudio'],"chk2");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EN ESTUDIO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk3">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_hipermetropia'],"chk3");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_hipermetropia'],"chk3");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>HIPERMETROPIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk4">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_miopia'],"chk4");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_miopia'],"chk4");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MIOPIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk5">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_miope'],"chk5");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_miope'],"chk5");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO MIOPE</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk6">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_hipermetrope'],"chk6");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_hipermetrope'],"chk6");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO HIPERMETROPE</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk7">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_mixto'],"chk7");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_mixto'],"chk7");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO MIXTO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk8">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_miopito_comp'],"chk8");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_miopito_comp'],"chk8");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO MIOPITO COMP</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk9">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_astigmatismo_hipermetria_c'],"chk9");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_astigmatismo_hipermetria_c'],"chk9");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ASTIGMATISMO HIPERMETRIA COMP</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk10">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_anisometropia'],"chk10");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_anisometropia'],"chk10");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ANISOMETROPIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk11">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_estrabismo'],"chk11");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_estrabismo'],"chk11");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ESTRABISMO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk12">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_influencia_convergencia'],"chk12");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_influencia_convergencia'],"chk12");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>INFLUENCIA CONVENGENCIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['of_otros_desc']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="of_otros_desc" size=50 value="<?php echo $fila['of_otros_desc']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%" align=center>
																	<HR width="80%" color=black><BR>
																	<FONT face="arial, geneva, helvetica" size=2>
																		<strong>INDICACIONES</strong>
																	</FONT>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox"  NAME="chk14">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_lentes_primera_vez'],"chk14");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_lentes_primera_vez'],"chk14");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>LENTES PRIMERA VEZ</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk15">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_cambiar_lentes'],"chk15");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_cambiar_lentes'],"chk15");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CAMBIAR LENTES</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk16">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_mantener_lentes'],"chk16");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_mantener_lentes'],"chk16");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MANTENER LENTES</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk17">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_estudio_estrabismo'],"chk17");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_estudio_estrabismo'],"chk17");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ESTUDIO ESTRABISMO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk18">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_ejercicios_opticos'],"chk18");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_ejercicios_opticos'],"chk18");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EJERCICIOS OPTICOS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk19">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['of_cirugia'],"chk19");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['of_cirugia'],"chk19");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CIRUGIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['of_otros_desc_indic']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="of_otros_desc_indic" size=50 value="<?php echo $fila['of_otros_desc_indic']?>">
																				<?php }; ?>
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
							<!--TD width=30></TD-->
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;OTORRINO</STRONG>
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
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk21">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_alta'],"chk21");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_alta'],"chk21");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ALTA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk22">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_en_estudio'],"chk22");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_en_estudio'],"chk22");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EN ESTUDIO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk23">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_agenesia_pabellon'],"chk23");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_agenesia_pabellon'],"chk23");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>AGENESIA PABELLON</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk24">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_cerumen_impactado'],"chk24");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_cerumen_impactado'],"chk24");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CERUMEN IMPACTADO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk25">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_mucosis_timpanica'],"chk25");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_mucosis_timpanica'],"chk25");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MUCOSIS TIMPANICA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk26">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_hipoacusia_neurosensorial'],"chk26");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_hipoacusia_neurosensorial'],"chk26");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>HIPOACUSIA NEUROSENSORIAL</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['ot_otros_desc']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="ot_otros_desc" size=50 value="<?php echo $fila['ot_otros_desc']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
														
															<TR>
																<TD width="100%" align=center>
																	<HR width="80%" color=black><BR>
																	<FONT face="arial, geneva, helvetica" size=2>
																		<strong>INDICACIONES</strong>
																	</FONT>
																</TD>
															</TR>
														

														







															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk28">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_audiometria'],"chk28");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_audiometria'],"chk28");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>AUDIOMETRIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk29">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_impedanciometria'],"chk29");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_impedanciometria'],"chk29");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>IMPEDANCIOMETRIA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk30">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_radiografia'],"chk30");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_radiografia'],"chk30");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>RADIOGRAFIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>







															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk31">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_medicamento'],"chk31");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_medicamento'],"chk31");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MEDICAMENTO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk32">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_audifono'],"chk32");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_audifono'],"chk32");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>AUDIFONO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk33">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['ot_cirugia'],"chk33");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['ot_cirugia'],"chk33");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CIRUGIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>




														
														
														

															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['ot_otros_desc_indic']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="ot_otros_desc_indic" size=50 value="<?php echo $fila['ot_otros_desc_indic']?>">
																				<?php }; ?>
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
							<!--TD width=30></TD-->
							<TD>

								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=left height=10>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>&nbsp;&nbsp;ORTOPEDIA</STRONG>
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
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk35">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_alta'],"chk35");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_alta'],"chk35");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ALTA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk36">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_en_estudio'],"chk36");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_en_estudio'],"chk36");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>EN ESTUDIO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk37">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_pie_plano'],"chk37");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_pie_plano'],"chk37");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>PIE PLANO</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk38">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_genu_valgo_varo'],"chk38");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_genu_valgo_varo'],"chk38");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>GENU VALGO/VARO</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk39">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_deform_adquir_dedos'],"chk39");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_deform_adquir_dedos'],"chk39");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>DEFORM. ADQUIR. DEDOS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk40">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_escoliosis'],"chk40");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_escoliosis'],"chk40");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>ESCOLIOSIS</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['or_otros_desc']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="or_otros_desc" size=50 value="<?php echo $fila['or_otros_desc']?>">
																				<?php }; ?>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%" align=center>
																	<HR width="80%" color=black><BR>
																	<FONT face="arial, geneva, helvetica" size=2>
																		<strong>INDICACIONES</strong>
																	</FONT>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk42">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_cambiar_plantillas'],"chk42");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_cambiar_plantillas'],"chk42");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CAMBIAR PLANTILLAS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk43">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_mantener_plantillas'],"chk43");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_mantener_plantillas'],"chk43");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>MANTENER PLANTILLAS</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk44">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_kinesiterapia'],"chk44");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_kinesiterapia'],"chk44");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>KINESITERAPIA</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk45">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_rx_extrem_inferiores'],"chk45");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_rx_extrem_inferiores'],"chk45");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>RX EXTREM. INFERIORES</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk46">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_rx_columna'],"chk46");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_rx_columna'],"chk46");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>RX COLUMNA</STRONG>
																				</FONT>
																			</TD>
																			<TD width=20></TD>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk47">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_corse'],"chk47");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_corse'],"chk47");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CORSE</STRONG>
																				</FONT>
																			</TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2>
																				<?php if($frmModo=="ingresar"){ ?>
																					<INPUT TYPE="checkbox" NAME="chk48">
																				<?php };?>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						impChkEst($fila['or_cirugia'],"chk48");
																					};
																				?>
																				<?php 
																					if($frmModo=="modificar"){ 
																						impChk($fila['or_cirugia'],"chk48");
																					};
																				?>
																			</TD>
																			<TD width="33%">
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>CIRUGIA</STRONG>
																				</FONT>
																			</TD>
																			<TD colspan=5></TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD width="100%">
																	<TABLE WIDTH=100% BORDER=0 CELLSPACING=3 CELLPADDING=3>
																		<TR>
																			<TD width=2></TD>
																			<TD width="33%" align=right>
																				<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																					<STRONG>OTRO</STRONG>
																				</FONT>
																			</TD>
																			<TD COLSPAN=5 align=left>
																				<?php 
																					if($frmModo=="mostrar"){ 
																						imp($fila['or_otros_desc_indic']);	
																					};
																				?>
																				<?php if($frmModo=="modificar"){ ?>
																						<INPUT TYPE="text" NAME="or_otros_desc_indic" size=50 value="<?php echo $fila['or_otros_desc_indic']?>">
																				<?php }; ?>
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
							<TD colspan=3 align=center>
								<TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ACCIDENTES</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtACCIDENTE" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){
													if(trim($fila['accidentes'])!="")
														imp($fila['accidentes']);
														else
															imp('No se registran accidentes.');
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtACCIDENTE" cols="60" rows="3"> <?php echo ($fila['accidentes'])?></textarea>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=3 align=center>
								<TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ALERGIAS</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtALERGIA" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													if(trim($fila['alergias'])!="")
														imp($fila['alergias']);
														else
															imp('No se registran alergias.');
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtALERGIA" cols="60" rows="3"> <?php echo ($fila['alergias'])?></textarea>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD colspan=3 align=center>
								<TABLE  BORDER=0 CELLSPACING=0 CELLPADDING=0 width=75%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>MEDICAMENTOS</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtMEDICAMENTO" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													if(trim($fila['medicamentos'])!="")
														imp($fila['medicamentos']);
														else
															imp('No se registran medicamentos.');
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtMEDICAMENTO" cols="60" rows="3"> <?php echo ($fila['medicamentos'])?></textarea>
											<?php };?>
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
							<TD width="100%" colspan=2>
								<?php if($frmModo=="mostrar"){?>
								<?php }else{?>
								<?php }?>
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
<?php 
	}else{
?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
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
												$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
												$arr=pg_fetch_array($result,0);

												$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr['rut_alumno']."');";
												$retrieve_result = @pg_exec($conn,$output);
											?>
											<img src=../../tmp/<?php echo $arr['rut_alumno'] ?> ALT="NO DISPONIBLE" width=150>
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
						<TR height="50">
							<TD align=right>
								<INPUT TYPE="button" value="CONTENIDOS"  class="button" onClick=document.location="fichaContenidos.php3">
								<INPUT TYPE="button" value="FICHA APODERADOS"  class="button" onClick=document.location="fichaApoderados.php3">
								<INPUT TYPE="button" value="FICHA ALUMNO"  class="button" onClick=document.location="fichaAlumno.php3">
								<INPUT TYPE="button" value="FICHA DEPORTIVA"  class="button" onClick=document.location="fichaDeportiva.php3">
								<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')">
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>FICHA MEDICA</strong>
								</FONT>
							</TD>
						</TR>
						<TR height=20 bgcolor=white>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>No existe ficha medica registrada para el alumno en este año academico.</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
<?php 
	}
?>










				</TD>	
			</TR>
		</TABLE>
	</CENTER>

</BODY>
</HTML>