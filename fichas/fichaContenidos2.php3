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
<script>
 function downloadme(x){
    myTempWindow = window.open(x,"","left=10000,screenX=10000");
    myTempWindow.document.execCommand("SaveAs","null",x);
    myTempWindow.close();
}
</script>



	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=idFicha value=".$fila['id_ficha'].">"
	?>
	<TABLE WIDTH=100% align="center" cellpadding="0" cellspacing="0" background="imagenes/background.gif">
  <!--<TR> 
      <TD height="99"> 
        <div align="center"><img src="imagenes/superior_contenidos.gif" height="99" width="600"></div></TD>
  </TR>-->
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

												$output= "select lo_export(".$arr[foto].",'/opt/www/tmp/".chop($alumno)."');";
												$retrieve_result = @pg_exec($conn,$output);
											if (!$retrieve_result){ ?>
													<img src="apoderado/imag/alumno.gif" alt="FOTOGRAF&Iacute;A ALUMNO" name="ALUMNO" width="180" height="220" id="ALUMNO">
											<?php }else{ ?>
													<img src=../../tmp/<?php echo chop($alumno) ?> ALT="NO DISPONIBLE" width=150></p>
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
        <!--<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="mostrar"){ ?>
									<INPUT TYPE="button" value="FICHA DEPORTIVA"  class="button" onClick=document.location="fichaDeportiva.php3">
									<INPUT TYPE="button" value="FICHA MEDICA"  class="button"onClick=document.location="seteaFichaMed.php3">
									<INPUT TYPE="button" value="FICHA ALUMNO"  class="button"onClick=document.location="fichaAlumno.php3">
									<INPUT TYPE="button" value="FICHA APODERADOS"  class="button"onClick=document.location="fichaApoderados.php3">
									<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')">
								<?php };?>
							</TD>
						</TR>-->
        <TR height=20 bgcolor=#0099cc>
							
          <TD colspan=2 align=middle bgcolor="003b85"> <FONT face="arial, geneva, helvetica" size=2 color=White> 
            <strong>FICHA CONTENIDOS DISPONIBLES</strong> </FONT> </TD>
						</TR>

						<TR>
							<TD>
								<TABLE width=100% Border=0 cellpadding=0 cellspacing=0>
									<TR>
										<TD width=30></TD>
										<TD>
											<!--SUBSECTORES DEL ALUMNO-->
											<?php
												//TOTAL DE RAMOS INGRESADOS
												$qryX="SELECT subsector.nombre, ramo.id_ramo FROM (((alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN curso ON matricula.id_curso = curso.id_curso) INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((alumno.rut_alumno)=".$_ALUMNO.") and curso.id_ano=$ano)";

												$resultX =@pg_Exec($conn,$qryX);
												if(pg_numrows($resultX)!=0){
													for($i=0 ; $i < @pg_numrows($resultX) ; $i++){
														$filaX = @pg_fetch_array($resultX,$i);
											?>
												<TABLE width=520 bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
													<TR>
														<TD align=left height=10>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>&nbsp;&nbsp;
																	<?php echo $filaX['nombre'];?>
																</STRONG>
															</FONT>
														</TD>
													</TR>
													<!--ARCHIVOS DEL SUBSECTOR-->
													<?php
														//TOTAL DE ARCHIVOS INGRESADOS
														$qryY="SELECT archivo.id_archivo, archivo.nombre_archivo, archivo.descripcion_archivo FROM (archivo INNER JOIN adjunta ON archivo.id_archivo = adjunta.id_archivo) INNER JOIN ramo ON adjunta.id_ramo = ramo.id_ramo WHERE (((ramo.id_ramo)=".$filaX['id_ramo']."))";

														$qryY="SELECT * FROM (archivo INNER JOIN adjunta ON archivo.id_archivo = adjunta.id_archivo) INNER JOIN ramo ON adjunta.id_ramo = ramo.id_ramo WHERE (((ramo.id_ramo)=".$filaX['id_ramo']."))";

														$resultY =@pg_Exec($conn,$qryY);
														if(pg_numrows($resultY)!=0){
															for($j=0 ; $j < @pg_numrows($resultY) ; $j++){
																$filaY = @pg_fetch_array($resultY,$j);
													?>
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
																								<TD width=99%>
																									<FONT face="arial, geneva, helvetica" size=1 color=RED>
																										<STRONG>
																										<?php echo trim($filaY['nombre_archivo']);?>
																										</STRONG>
																									</FONT>
																								</TD>
																								<TD width=*>
																								<?php
																									$output= "select lo_export(".$filaY['archivo'].",'/opt/www/coe/tmp/".trim($filaY['nombre_archivo'])."');";
																									$retrieve_result = @pg_exec($conn,$output);
																									?>
																									<input name="archivo" type="hidden" value=<?php echo "../../../../../../../tmp/".trim($filaY['nombre_archivo'])?>>
																								<!--script> alert(archivo.value); </script-->
																								<!--<a href=javascript:downloadme("archivo.value");>-->
																								<a href="../../../../../../../tmp/<?php echo trim($filaY['nombre_archivo'])?>">
																									<INPUT TYPE=image SRC="../util/disk.jpg" width=30 disabled>
																								</a>
																								</TD>
																							</TR>
																							<TR>
																								<TD>
																									<FONT face="arial, geneva, helvetica" size=2 color=GRAY>
																										&nbsp;&nbsp;&nbsp;<?php echo trim($filaY['descripcion_archivo'])?>
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
															</TD>
														</TR>
													<?php
															}
														}else{
													?>
														<TR>
															<TD>
																<TABLE width=100% height=100% bgcolor=White BORDER=0>
																	<TR>
																		<TD align=center>
																			<FONT face="arial, geneva, helvetica" size=1 color=BLACK>
																				<STRONG>NO se registran archivos ingresados.</STRONG>
																			</FONT>
																		</TD>
																	</TR>
																</TABLE>
															</TD>
														</TR>
													<?php 
														} 
													?>
												</TABLE>
											<?php
													}
												}
											?>
											
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








</BODY>
</HTML>