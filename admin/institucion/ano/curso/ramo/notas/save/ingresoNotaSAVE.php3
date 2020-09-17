<?php require('../../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$_ALUMNO	=	$alumno;
	if(!session_is_registered('_ALUMNO'))
		session_register('_ALUMNO');
	$docente		=5; //Codigo Docente
	$periodo		=$_PERIODORAMO
?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../../util/td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
		<?php 
			if($_MODOEVAL==1){ //EVALUACION NUMERICA
		?>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!notaNroOnly(form.N1,'Nota 1 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N2,'Nota 2 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N3,'Nota 3 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N4,'Nota 4 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N5,'Nota 5 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N6,'Nota 6 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N7,'Nota 7 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N8,'Nota 8 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N9,'Nota 9 inválida.')){
						return false;
					};

					if(!notaNroOnly(form.NP,'Nota Promedio inválida.')){
						return false;
					};
					
					if(form.NP.value!='')
						if(form.NP.value!=promedio(form)){
							alert('Promedio no corresponde.');
							return false;
						}

					return true;
				}


			
				function valida2prom(form){
					if(!notaNroOnly(form.N1,'Nota 1 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N2,'Nota 2 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N3,'Nota 3 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N4,'Nota 4 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N5,'Nota 5 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N6,'Nota 6 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N7,'Nota 7 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N8,'Nota 8 inválida.')){
						return false;
					};
					if(!notaNroOnly(form.N9,'Nota 9 inválida.')){
						return false;
					};

					if(!notaNroOnly(form.NP,'Nota Promedio inválida.')){
						return false;
					};
					
					return true;
				}
				
				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}
				
				function promedio(form){
					if(valida2prom(form)){
						var cant=0;
						var suma=0;
						if(form.N1.value!=''){
							cant++;
							suma = suma + parseInt(form.N1.value);
						};
						if(form.N2.value!=''){
							cant++;
							suma = suma + parseInt(form.N2.value);
						};
						if(form.N3.value!=''){
							cant++;
							suma = suma + parseInt(form.N3.value);
						};
						if(form.N4.value!=''){
							cant++;
							suma = suma + parseInt(form.N4.value);
						};
						if(form.N5.value!=''){
							cant++;
							suma = suma + parseInt(form.N5.value);
						};
						if(form.N6.value!=''){
							cant++;
							suma = suma + parseInt(form.N6.value);
						};
						if(form.N7.value!=''){
							cant++;
							suma = suma + parseInt(form.N7.value);
						};
						if(form.N8.value!=''){
							cant++;
							suma = suma + parseInt(form.N8.value);
						};
						if(form.N9.value!=''){
							cant++;
							suma = suma + parseInt(form.N9.value);
						};
					return round((suma/cant),0);
					}
				}
			</SCRIPT>
		<?php 
			}
		?>
		<?php 
			if($_MODOEVAL==2){ //EVALUACION CONCEPTUAL
		?>
			<SCRIPT language="JavaScript">

				function valida(form){
					if(!chkVacio(form.NP,'Ingresar PROMEDIO.')){
						return false;
					};
					if(!notaConOnly(form.N1,'Nota 1 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N2,'Nota 2 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N3,'Nota 3 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N4,'Nota 4 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N5,'Nota 5 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N6,'Nota 6 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N7,'Nota 7 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N8,'Nota 8 inválida.')){
						return false;
					};
					if(!notaConOnly(form.N9,'Nota 9 inválida.')){
						return false;
					};

					if(!notaConOnly(form.NP,'Nota Promedio inválida.')){
						return false;
					};

					return true;
				}
			</SCRIPT>
		<?php 
			}
		?>
	</HEAD>
<BODY>
	<?php echo tope("../../../../../../util/");?>
	<FORM method=post name="frm" action="procesoIngreso.php3">
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
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>PERIODO</strong>
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
											$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$periodo;
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
													echo trim($fila1['nombre_periodo']);
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
								<INPUT TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida(this.form);">&nbsp;
								<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="mostrarNotas.php3">&nbsp;	
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>INGRESO NOTAS</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
								<?php
									$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
									$result =@pg_Exec($conn,$qry);
									if (!$result) {
										error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
									}else{
										if (pg_numrows($result)!=0){
											$fila1 = @pg_fetch_array($result,0);	
											if (!$fila1){
												error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
												exit();
											}
											echo "<TR>";
											echo "<TD align=center>ALUMNO";
											echo "</TD>";
											echo "<TD colspan=9>";
											echo "</TD>";
											echo "<TD align=center>PROM";
											echo "</TD>";
											echo "</TR>";

											echo "<TR>";
											echo "<TD align=left width=200>";
											echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];
											echo "</TD>";
											$qry2="SELECT alumno.rut_alumno, nota.id_nota, nota.valor, periodo.id_periodo FROM nota INNER JOIN (((alumno INNER JOIN califica ON alumno.rut_alumno = califica.rut_alumno) INNER JOIN ramo ON califica.id_ramo = ramo.id_ramo) INNER JOIN periodo ON califica.id_periodo = periodo.id_periodo) ON (nota.id_periodo = califica.id_periodo) AND (nota.rut_alumno = califica.rut_alumno) AND (nota.id_ramo = califica.id_ramo) WHERE (((alumno.rut_alumno)=".$fila1['rut_alumno'].") AND ((periodo.id_periodo)=".$periodo.") AND ((califica.id_ramo)=".$ramo."))"; 
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};
													for($j=0 ; $j < @pg_numrows($result2) ; $j++){
														$fila2 = @pg_fetch_array($result2,$j);
														echo "<TD align=center>";
														echo  "<INPUT TYPE=text NAME=N".($j+1)." maxlength=2 size=2 value=".$fila2['valor']." >";
														echo "</TD>";
													}



													for($j=@pg_numrows($result2) ; $j < 9 ; $j++){
														$fila2 = @pg_fetch_array($result2,$j);
														echo "<TD align=center>";
														echo  "<INPUT TYPE=text NAME=N".($j+1)." size=2 maxlength=2>";
														echo "</TD>";
													}
												}else{
													echo "<TD><INPUT TYPE=text NAME=N1 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N2 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N3 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N4 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N5 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N6 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N7 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N8 size=2 maxlength=2>";
													echo "</TD>";
													echo "<TD><INPUT TYPE=text NAME=N9 size=2 maxlength=2>";
													echo "</TD>";
												}
											};
										$qry4="SELECT * FROM CALIFICA WHERE ID_RAMO=".$_RAMO." AND RUT_ALUMNO=".$_ALUMNO." AND ID_PERIODO=".$periodo;
										$result3 =@pg_Exec($conn,$qry3);
										$fila3 = @pg_fetch_array($result3,0);
										echo "<TD align=center><INPUT TYPE=text NAME=NP size=2 maxlength=2 value=".$fila3['promedio'].">";
										echo "</TD>";
										echo "</TR>";
										}
									}
								?>
								<TR>
									<TD colspan=10></TD>
									<TD align=center>
										<?php 
											if($_MODOEVAL==1){ //EVALUACION NUMERICA
										?>
											<INPUT TYPE="button" value="PROM" name=btnPromedio onClick="document.frm.NP.value=promedio(this.form);">&nbsp;
										<?php }?>
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
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>