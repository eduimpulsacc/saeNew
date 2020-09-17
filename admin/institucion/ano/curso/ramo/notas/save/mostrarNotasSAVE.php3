<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))";
		$result =@pg_Exec($conn,$qry);
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
			if (pg_numrows($result)!=0){
				$fila1 = @pg_fetch_array($result,0);	
				if (!$fila1){
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
				};
				$periodo	= $fila1['id_periodo'];
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}

	$_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../../util/td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'mostrarNotas.php3?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
		</SCRIPT>

	</HEAD>
<BODY>
	<?php echo tope("../../../../../../util/");?>
	<FORM method=post name="frm">
		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
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
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
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
									<strong>SUBSECTOR</strong>
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
											$qry="SELECT subsector.nombre FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre']);
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
								<INPUT TYPE="button" value="VOLVER" name=btnCancelar onClick=document.location="../seteaRamo.php3?caso=4">&nbsp;
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>NOTAS</strong>
								</FONT>
							</TD>
						</TR>
						<TR height=20 bgcolor=white>
							<TD align=middle colspan=2 align=center>
								  <select name="cmbPERIODO" onChange="enviapag(this.form)">
									<?php
										$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
										$result =@pg_Exec($conn,$qry);
										if (!$result) 
											error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
										else{
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												if (!$fila1){
													error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
													exit();
												};
												for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
													if($fila1['id_periodo']==$periodo){
														echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
													}else{
														echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
													}
												}
											}
										};
									?>
								</Select>
							</TD>
						</TR>

						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
								<?php
									//ALUMNOS DEL CURSO
									$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, curso.id_curso FROM ((alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso) INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano WHERE (((curso.id_curso)=".$curso.") AND ((ano_escolar.id_ano)=".$ano."))";

									$result =@pg_Exec($conn,$qry);
									if (!$result) 
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
									else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);	
											if (!$fila1){
												error('<B> ERROR :</b>Error al acceder a la BD. (85)</B>');
												exit();
											};
												echo "<TR>";
												echo "<TD align=center>ALUMNO";
												echo "</TD>";
												echo "<TD colspan=9>";
												echo "</TD>";
												echo "<TD align=center>PROM";
												echo "</TD>";
												echo "</TR>";
											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
															<TR bgcolor=#ffffff onmouseover=this.style.background='yellow'; this.style.cursor='hand'; onmouseout=this.style.background='transparent'; onClick="go('ingresoNota.php3?alumno=<?php echo $fila1['rut_alumno'];?>');">
														<?php
													}else{
														echo "<TR bgcolor=#ffffff>";
													}
												}else{
													echo "<TR bgcolor=#ffffff>";
												}
												echo "<TD align=left width=400>";
												echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];
												echo "</TD>";

												//NOTAS ALUMNO POR RAMO Y PERIODO
												$qry2="SELECT alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)=".$fila1['rut_alumno'].") AND ((periodo.id_periodo)=".$periodo.") AND ((califica.id_ramo)=".$ramo."))"; 

												$result2 =@pg_Exec($conn,$qry2);
												if (!$result2) 
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>');
												else{
													if (pg_numrows($result2)!=0){
														$fila2 = @pg_fetch_array($result2,0);	
														if (!$fila2){
															error('<B> ERROR :</b>Error al acceder a la BD. (86)</B>');
															exit();
														};
														for($j=0 ; $j < @pg_numrows($result2) ; $j++){
															$fila2 = @pg_fetch_array($result2,$j);
															echo "<TD align=right width=100>";
															imp($fila2['valor']);
															echo "</TD>";
														}
													}else{
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
															echo "<TD align=right>";
																imp('');
															echo "</TD>";
													}
												};
											$qry4="SELECT * FROM CALIFICA WHERE ID_RAMO=".$ramo." AND RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$periodo;
											$result4 =@pg_Exec($conn,$qry4);
											$fila4 = @pg_fetch_array($result4,0);	
											echo "<TD align=center>";
											imp($fila4['promedio']);
											echo "</TD>";
											echo "</TR>";
											};
										};
									};
								?>
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
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>