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
		$qry="SELECT * FROM FICHA_DEPORTIVA WHERE ID_ANO=".$ano." AND RUT_ALUMNO=".$alumno;
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
		<LINK REL="STYLESHEET" HREF="td.css" TYPE="text/css">
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
	</HEAD>
<BODY leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
	
  <TABLE WIDTH=100% align="center" cellpadding="0" cellspacing="0" background="imagenes/background.gif">
  <TR> 
      <TD height="99"> 
        <div align="center"><img src="imagenes/superior_docente.gif" height="99" width="600"></div></TD>
  </TR>
</TABLE>
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
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarAno.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<INPUT TYPE="button" value="CONTENIDOS"  class="button" onClick=document.location="fichaContenidos.php3">
									<INPUT TYPE="button" value="FICHA MEDICA"  class="button"onClick=document.location="seteaFichaMed.php3">
									<INPUT TYPE="button" value="FICHA ALUMNO"  class="button"onClick=document.location="fichaAlumno.php3">
									<INPUT TYPE="button" value="FICHA DEPORTIVA" class="button"onClick=document.location="fichaDeportiva.php3">
									<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')">
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<!--INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);"-->
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaFicha.php3?alumno=<?php echo $alumno?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>FICHA APODERADOS</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=5 cellspacing=5>
									<TR>
										<TD width=300 align=center VALIGN=TOP>
										PADRE
										<?php
											$qry="SELECT apoderado.* FROM alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno WHERE (((apoderado.relacion)=1) AND ((alumno.rut_alumno)=".$_ALUMNO."))";

											$result = @pg_Exec($conn,$qry);
											$arr=@pg_fetch_array($result,0);

											$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr[rut_apo]."');";
											$retrieve_result = @pg_exec($conn,$output);
										?>
										<img src=../../tmp/<?php echo $arr[rut_apo] ?> ALT="NO DISPONIBLE"  width=120>
										</TD>
										<TD VALIGN=TOP>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=CENTER height=10>
														<FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<STRONG>&nbsp;&nbsp;DATOS DEL PADRE</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD align=CENTER height=10>
														<TABLE width=600 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=1 CLASS="tabla_2">
															<TR>
																<TD align=LEFT WIDTH=150 CLASS="td2" VALIGN=TOP >NOMBRES</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['nombre_apo']
																?>
																</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2"  VALIGN=TOP >COMUNA</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$arr['region']." AND COR_PRO=".$arr['ciudad']." AND COR_COM=".$arr['comuna'];
																	$resultCOM	=@pg_Exec($conn,$qryCOM);
																	$filaCOM	= @pg_fetch_array($resultCOM,0);
																	imp($filaCOM['nom_com']);
																?>
																</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >APELLIDOS</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['ape_pat']
																?>
																</TD>
																<TD align=LEFT CLASS="td2" VALIGN=TOP  >REGION</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$arr['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																?>
																</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >RUT</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['rut_apo']."-".$arr['dig_rut']
																?>
																</TD>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >PAIS</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																CHILE</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2" VALIGN=TOP  >PROFESION/OCUPACION</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >EMAIL</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['email']
																?>
																</TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >PROCEDENCIA</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD  CLASS="td2" align=LEFT VALIGN=TOP >TELEFONO OF</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD  CLASS="td2" align=LEFT VALIGN=TOP >FECHA NACIMIENTO</TD>
																<TD  CLASS="td2" align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >TELEFONO</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['telefono']
																?>
																</TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >NACIONALIDAD</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >CELULAR</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >ESTADO CIVIL</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >OBSERVACION</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE ROWSPAN=2 VALIGN=TOP VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >DOMICILIO</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['calle']." ".$arr['nro']." ".$arr['block']." ".$arr['depto']." ".$arr['villa']
																?>
																</TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP ></TD>
																<!--TD CLASS="td2"  align=LEFT BGCOLOR=WHITE></TD-->
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
						<TR height=20 bgcolor=WHITE>
							<TD align=middle colspan=2></TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=5 cellspacing=5>
									<TR>
										<TD width=300 align=center VALIGN=TOP>
										MADRE
										<?php
											$qry="SELECT apoderado.* FROM alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno WHERE (((apoderado.relacion)=2) AND ((alumno.rut_alumno)=".$_ALUMNO."))";

											$result = @pg_Exec($conn,$qry);
											$arr=@pg_fetch_array($result,0);

											$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr[rut_apo]."');";
											$retrieve_result = @pg_exec($conn,$output);
										?>
										<img src=../../tmp/<?php echo $arr[rut_apo] ?> ALT="NO DISPONIBLE"  width=120>
										</TD>
										<TD VALIGN=TOP>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=CENTER height=10>
														<FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<STRONG>&nbsp;&nbsp;DATOS DE LA MADRE</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD align=CENTER height=10>
														<TABLE width=600 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=1 CLASS="tabla_2">
															<TR>
																<TD align=LEFT WIDTH=150 CLASS="td2" VALIGN=TOP >NOMBRES</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['nombre_apo']
																?>
																</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2"  VALIGN=TOP >COMUNA</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$arr['region']." AND COR_PRO=".$arr['ciudad']." AND COR_COM=".$arr['comuna'];
																	$resultCOM	=@pg_Exec($conn,$qryCOM);
																	$filaCOM	= @pg_fetch_array($resultCOM,0);
																	imp($filaCOM['nom_com']);
																?>
																</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >APELLIDOS</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['ape_pat']
																?>
																</TD>
																<TD align=LEFT CLASS="td2" VALIGN=TOP  >REGION</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$arr['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																?>
																</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >RUT</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['rut_apo']."-".$arr['dig_rut']
																?>
																</TD>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >PAIS</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																CHILE</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2" VALIGN=TOP  >PROFESION/OCUPACION</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >EMAIL</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['email']
																?>
																</TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >PROCEDENCIA</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD  CLASS="td2" align=LEFT VALIGN=TOP >TELEFONO OF</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD  CLASS="td2" align=LEFT VALIGN=TOP >FECHA NACIMIENTO</TD>
																<TD  CLASS="td2" align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >TELEFONO</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['telefono']
																?>
																</TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >NACIONALIDAD</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >CELULAR</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >ESTADO CIVIL</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >OBSERVACION</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE ROWSPAN=2 VALIGN=TOP VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >DOMICILIO</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['calle']." ".$arr['nro']." ".$arr['block']." ".$arr['depto']." ".$arr['villa']
																?>
																</TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP ></TD>
																<!--TD CLASS="td2"  align=LEFT BGCOLOR=WHITE></TD-->
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
						<TR height=20 bgcolor=WHITE>
							<TD align=middle colspan=2></TD>
						</TR>
						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=5 cellspacing=5>
									<TR>
										<TD width=300 align=center VALIGN=TOP>
										APODERADO
										<?php
											$qry="SELECT apoderado.* FROM alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno WHERE (((tiene2.responsable)=1) AND ((alumno.rut_alumno)=".$_ALUMNO."))";

											$result = @pg_Exec($conn,$qry);
											$arr=@pg_fetch_array($result,0);

											$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr[rut_apo]."');";
											$retrieve_result = @pg_exec($conn,$output);
										?>
										<img src=../../tmp/<?php echo $arr[rut_apo] ?> ALT="NO DISPONIBLE"  width=120>
										</TD>
										<TD VALIGN=TOP>
											<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
												<TR>
													<TD align=CENTER height=10>
														<FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<STRONG>&nbsp;&nbsp;DATOS DEL APODERADO(A)</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD align=CENTER height=10>
														<TABLE width=600 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=1 CLASS="tabla_3">
															<TR>
																<TD align=LEFT WIDTH=150 CLASS="td2" VALIGN=TOP >NOMBRES</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['nombre_apo']
																?>
																</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2"  VALIGN=TOP >COMUNA</TD>
																<TD align=LEFT WIDTH=150 CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$arr['region']." AND COR_PRO=".$arr['ciudad']." AND COR_COM=".$arr['comuna'];
																	$resultCOM	=@pg_Exec($conn,$qryCOM);
																	$filaCOM	= @pg_fetch_array($resultCOM,0);
																	imp($filaCOM['nom_com']);
																?>
																</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >APELLIDOS</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['ape_pat']
																?>
																</TD>
																<TD align=LEFT CLASS="td2" VALIGN=TOP  >REGION</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$arr['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																?>
																</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >RUT</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['rut_apo']."-".$arr['dig_rut']
																?>
																</TD>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >PAIS</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																CHILE</TD>
															</TR>
															<TR>
																<TD align=LEFT CLASS="td2" VALIGN=TOP  >PROFESION/OCUPACION</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD align=LEFT CLASS="td2"  VALIGN=TOP >EMAIL</TD>
																<TD align=LEFT  CLASS="td2" BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['email']
																?>
																</TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >PROCEDENCIA</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD  CLASS="td2" align=LEFT VALIGN=TOP >TELEFONO OF</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD  CLASS="td2" align=LEFT VALIGN=TOP >FECHA NACIMIENTO</TD>
																<TD  CLASS="td2" align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >TELEFONO</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['telefono']
																?>
																</TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >NACIONALIDAD</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >CELULAR</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >ESTADO CIVIL</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP ></TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >OBSERVACION</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE ROWSPAN=2 VALIGN=TOP VALIGN=TOP ></TD>
															</TR>
															<TR>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP >DOMICILIO</TD>
																<TD CLASS="td2"  align=LEFT BGCOLOR=WHITE VALIGN=TOP >
																<?php
																	echo $arr['calle']." ".$arr['nro']." ".$arr['block']." ".$arr['depto']." ".$arr['villa']
																?>
																</TD>
																<TD CLASS="td2"  align=LEFT VALIGN=TOP ></TD>
																<!--TD CLASS="td2"  align=LEFT BGCOLOR=WHITE></TD-->
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
					</TABLE>
			</TR>
		</TABLE>
				</TR>
</TABLE> </CENTER> 
</BODY>
</HTML>