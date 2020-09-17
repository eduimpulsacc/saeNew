<?php require('../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
?>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT alumno.*, curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, matricula.num_mat FROM (tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ON curso.id_curso = matricula.id_curso WHERE (((matricula.id_ano)=".$_ANO.") AND ((alumno.rut_alumno)=".$_ALUMNO."))";

		$result =@pg_Exec($conn,$qry);
		if (!$result)
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		else
			if (pg_numrows($result)!=0)
				$fila = @pg_fetch_array($result,0);	
	};
?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	    <link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
		<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
	</HEAD>
<body  onLoad="window.print();window.close();">
	<FORM method=post name="frm" action="procesoMatricula.php3">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0  CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
						<TR height=15>
							<TD>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">

									<TR height=20 bgcolor=#0099cc>
									  <TD colspan=2 align=middle bgcolor="#FFFFFF"><table width="590" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                          <td width="183"><?php
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);

						$output= "select lo_export(".$arr['insignia'].",'/var/www/html/tmp/".$arr[rdb]."');";
						$retrieve_result = @pg_exec($conn,$output);
						
					?><img src=../../../../../../../tmp/<?php echo $institucion ?> ALT="NO DISPONIBLE"  width=100 ></td>
                                          <td width="391"><div align="right"><?php
											$qry="SELECT * FROM institucion WHERE rdb=".$_INSTIT;
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre_instit']);
												echo "<br>";
											?>
											<FONT face="arial, geneva, helvetica" size=1>
												<strong>
											RBD: <?php 
											   echo trim($fila1['rdb']);
											?>- <?php 
											   echo trim($fila1['dig_rdb']);
												echo "<br>";
											?>
											</strong>
											<strong>
										  <?php
												echo trim($fila1['calle'])." ".trim($fila1['nro'])." ".trim($fila1['villa']);
												echo "<br>";
												$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila1['region']." AND COR_PRO=".$fila1['ciudad']." AND COR_COM=".$fila1['comuna'];
												$resultCOM	=@pg_Exec($conn,$qryCOM);
												$filaCOM = @pg_fetch_array($resultCOM,0);
												$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila1['region']." AND COR_PRO=".$fila1['ciudad'];
												$resultPRO	=@pg_Exec($conn,$qryPRO);
												$filaPRO = @pg_fetch_array($resultPRO,0);
												echo trim($filaCOM['nom_com']).", ".trim($filaPRO['nom_pro']);
												echo "<br>";
												echo "Fono:".trim($fila1['telefono']);
											}
										?></strong></FONT></div></td>
                                        </tr>
                                      </table></TD>
								  </TR>
									<TR height=20>
										<TD colspan=2 align=middle class="tableindex">
											<div align="center">CERTIFICADO ALUMNO REGULAR</div></TD>
								  </TR>
							  </TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD>
								<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%" width=100%>
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
														$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$_ALUMNO;
														$result =@pg_Exec($conn,$qry);
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat']).", ".trim($fila1['nombre_alu']);
														}
													?>
												</strong>
											</FONT>
										</TD>
										<td rowspan=2 valign=top width=300 align=right>
										
											
										</td>
									</TR>
									<TR>
										<TD align=left>
											<FONT face="arial, geneva, helvetica" size=2>
												<strong>RUT</strong>
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
														$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$_ALUMNO;
														$result =@pg_Exec($conn,$qry);
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															echo trim($fila1['rut_alumno'])." - ".trim($fila1['dig_rut']);
														}
													?>
												</strong>
											</FONT>
							
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD align=center>
								<TABLE BORDER=0 CELLSPACING=15 CELLPADDING=15>
									<TR>
										<TD>
											<TABLE BORDER=1 CELLSPACING=0 CELLPADDING=15 width=550>
												<TR>
													<TD colspan=3>
														<FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<?php
																$qry3="SELECT * from ano_escolar where id_ano=".$_ANO;
																$result3 =@pg_Exec($conn,$qry3);
																$fila3 = @pg_fetch_array($result3,0);	
															?>
															
															<?php
																$qry4="SELECT COUNT(*) from matricula where id_ano=".$_ANO;
																$result4 =@pg_Exec($conn,$qry4);
																$fila4 = @pg_fetch_array($result4,0);	
															?>
																								
															<BR>
															<BR>
															<STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;El presente documento certifica, que el alumno antes individualizado asiste regularmente a clases a este establecimiento educacional, cursando actualmente el <?php echo trim($fila['grado_curso'])." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo'])?> del año <?php echo trim($fila3['nro_ano'])?> con el número de matrícula Nº <?php echo $fila['num_mat']; ?>. </STRONG>
															<BR>
															<BR>
															<BR>
															<STRONG>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Se extiende el presente certificado de matricula a petición del interesado para los fines que estime conveniente.</STRONG>
															<BR>
															<BR>
															<BR>
															<BR>
															<BR>
															<BR>
															<BR>
															<BR>
															<BR>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--------------------------------------------------------
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nombre y firma el Director
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
	</TABLE>
	</FORM>
</BODY>
</HTML>