<?php require('../../../../../util/header.inc');?>

<?php 	$institucion	=$_INSTIT;
		$frmModo		=$_FRMMODO;
		$ano			=$_ANO;
		$curso			=$_CURSO;
?>

<?php 
	function calcula_numero_dia_semana($dia,$mes,$ano)
	{
		$numerodiasemana = date('w', mktime(0,0,0,$mes,$dia,$ano));
		if ($numerodiasemana == 0) 
			$numerodiasemana = 6;
		else
			$numerodiasemana--;
		return $numerodiasemana;
	}

	//funcion que devuelve el último día de un mes y año dados
	function ultimoDia($mes,$ano){ 
		$ultimo_dia=28; 
		while (checkdate($mes,$ultimo_dia + 1,$ano)){ 
		   $ultimo_dia++; 
		} 
		return $ultimo_dia; 
	} 

	function dame_nombre_mes($mes){
		 switch ($mes){
			case 1:
				$nombre_mes="ENERO";
				break;
			case 2:
				$nombre_mes="FEBRERO";
				break;
			case 3:
				$nombre_mes="MARZO";
				break;
			case 4:
				$nombre_mes="ABRIL";
				break;
			case 5:
				$nombre_mes="MAYO";
				break;
			case 6:
				$nombre_mes="JUNIO";
				break;
			case 7:
				$nombre_mes="JULIO";
				break;
			case 8:
				$nombre_mes="AGOSTO";
				break;
			case 9:
				$nombre_mes="SEPTIEMBRE";
				break;
			case 10:
				$nombre_mes="OCTUBRE";
				break;
			case 11:
				$nombre_mes="NOVIEMBRE";
				break;
			case 12:
				$nombre_mes="DICIEMBRE";
				break;
		}
		return $nombre_mes;
	}

	function SelHor($id_curso,$dia,$con)
	{
		$SQL = "SELECT a.id_horario,to_char(a.horaini,'HH24:MI') || CAST ('-' AS CHARACTER) || to_char(a.horafin,'HH24:MI') AS hora, trim(c.nombre) AS nombre FROM horario a, ramo b, subsector c WHERE a.id_ramo=b.id_ramo AND b.cod_subsector=c.cod_subsector AND a.id_curso=" . $id_curso . " AND a.dia=" . $dia . " ORDER BY a.horaini,a.horafin";
		//echo($SQL."<BR>");
		$lishor = @pg_exec($con,$SQL);
		if (!$lishor){
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			exit();
		};
		if (@pg_NumRows($lishor)!=0){
			$fila_aux = @pg_fetch_array($lishor,0);
			if (!$fila_aux){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			};
			//for($i=0;$i<@pg_NumRows($lishor);$i++){
			//	$fila_aux = @pg_fetch_array($lishor,$i);
			//	$ArrayHor[0][$i] = intval(Trim($fila_aux['id_horario']));
			//	$ArrayHor[1][$i] = Trim($fila_aux['nombre']);
			//	$ArrayHor[2][$i] = Trim($fila_aux['hora']);
			//};
			return $lishor;
		}else{
			return "0";
		};
	};
?>

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
	</HEAD>
	<BODY>
		<?php echo tope("../../../../../util/");?>
		<FORM ACTION="listarHorario.php" METHOD="POST">		
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
													exit();
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
												$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo as tpe FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
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
				<TR>
					<TD align="right">
						<TABLE>
							<TR>
								<TD>
									<INPUT TYPE="button" value="AGREGAR" onClick=document.location="seteaHorario.php?caso=2">&nbsp;<INPUT TYPE="button" value="VOLVER" onClick=document.location="../seteaCurso.php3?caso=4">	
								</TD>
							</TR>
						</TABLE>
					</TD>
				</TR>
				<TR height=15>
					<TD>
			<?php	if (!$HTTP_POST_VARS && !$HTTP_GET_VARS)
					{
						$tiempo_actual = time();
						$mes = date("n", $tiempo_actual);
						$ano = date("Y", $tiempo_actual);
						$dia = date("d");
						$fecha = $dia . "/" . $mes . "/" . $ano;
					}
					else 
					{
						$mes = $nuevo_mes;
						$ano = $nuevo_ano;
						$dia = $dia;
						$fecha = $dia . "/" . $mes . "/" . $ano;
					}

					$mes_hoy = date("m");
					$ano_hoy = date("Y");

					if (($mes_hoy <> $mes) || ($ano_hoy <> $ano))
					{
						$hoy = 0;
					}
					else
					{
						$hoy = date("d");
					}
					//tomo el nombre del mes que hay que imprimir
					$nombre_mes = dame_nombre_mes($mes);
					
					//construyo la cabecera de la tabla ?>
					<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
						<tr>
							<td align="center">
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
									<tr height=20 bgcolor=#0099cc>
										<td align="center" style="font-size:10pt;font-weight:bold;color:black">
											<FONT face="arial, geneva, helvetica" size=2 color=White>
												<strong>HORARIO</strong>
											</FONT>
										<?php	//calculo el mes y ano del mes anterior
												$mes_anterior = $mes - 1;
												$ano_anterior = $ano;
												if ($mes_anterior==0)
												{
													$ano_anterior--;
													$mes_anterior = 12;
												} ?>
										<?php	//calculo el mes y ano del mes siguiente
												$mes_siguiente = $mes + 1;
												$ano_siguiente = $ano;
												if ($mes_siguiente==13)
												{
													$ano_siguiente++;
													$mes_siguiente=1;
												} ?></td>
									</tr>
								</table>
							</td>
						</tr>
						<TR><TD><TABLE WIDTH="100%" BORDER=0 CELLSPACING=1 CELLPADDING=1>	
						<tr>
							<td width="14%" align="center">Lunes</td>
							<td width="14%" align="center">Martes</td>
							<td width="14%" align="center">Miércoles</td>
							<td width="14%" align="center">Jueves</td>
							<td width="14%" align="center">Viernes</td>
							<td width="14%" align="center">Sábado</td>
							<td width="14%" align="center">Domingo</td>
						</tr>
						<?php	//Variable para llevar la cuenta del dia actual
								$dia_actual = 1;

								//calculo el numero del dia de la semana del primer dia
								$numero_dia = calcula_numero_dia_semana($hoy,$mes,$ano);

								//echo ("Numero del dia de demana del primer:" . $numero_dia . "<br>");
					
								//calculo el último dia del mes
								$ultimo_dia = ultimoDia($mes,$ano); ?>
						<TR bgcolor="#E1EFFF">
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==0){ echo ("class='da'"); };?>><!-- LUNES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,0,$conn); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%'>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); ?>
											<TR bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['nombre']); ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==1){ echo ("class='da'"); };?>><!-- MARTES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,1,$conn); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%'>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); ?>
											<TR bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['nombre']); ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==2){ echo ("class='da'"); };?>><!-- MIERCOLES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,2,$conn); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%'>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); ?>
											<TR bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['nombre']); ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==3){ echo ("class='da'"); };?>><!-- JUEVES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,3,$conn); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%'>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); ?>
											<TR bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['nombre']); ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==4){ echo ("class='da'"); };?>><!-- VIERNES -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,4,$conn); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%'>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); ?>
											<TR bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['nombre']); ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==5){ echo ("class='da'"); }else{ echo ("class='fs'"); };?>><!-- SABADO -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,5,$conn); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%'>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); ?>
											<TR bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['nombre']); ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
							<TD width="14%" height="100" valign="top" <?php if ($numero_dia==6){ echo ("class='da'"); }else{ echo ("class='fs'"); };?>><!-- DOMINGO -->&nbsp;
							<?php	$ArrayHorario = SelHor($curso,6,$conn); 
									if (@pg_numrows($ArrayHorario)!=0){
										echo ("<TABLE width='100%'>");
										for($z=0;$z<@pg_numrows($ArrayHorario);$z++){ 
											$fila_aux = @pg_fetch_array($ArrayHorario,$z); ?>
											<TR bgcolor="#ffffff" onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='#ffffff'" onClick="go('seteaHorario.php?horario=<?php echo $fila_aux['id_horario']; ?>&caso=1')">
											<td align='center' valign="top">
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['hora']); ?></strong>
											</font>
											</td>
											<td align='center'>
											<font face='arial, geneva, helvetica' size='1' color='#000000'>
											<strong><?php imp($fila_aux['nombre']); ?></strong>
											</font>
											</td>
											</TR>
							<?php		};
										echo ("</TABLE>");
									};
							?>
							</TD>
						</TR>
						</TABLE></TD></TR>
					</table>
				</TD>
				</TR>
				<TR>
					<TD>&nbsp;</TD>
				</TR>
				<TR>
					<TD><hr width="100%" color="#0099cc"></TD>
				</TR>
			</TABLE>
		</FORM>
		<CENTER>
		<TABLE WIDTH="600">
			<TR>
				<TD valign="top" align="right">
					<table WIDTH="600" CELLSPACING="0" CELLPADDING="1" bgcolor="white">
						<tr>
							<td>
								<TABLE width="600" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
									<TR>
										<TD width="485">&nbsp;</TD>
										<TD bgcolor="#FFFFD7" width="15" height="10">&nbsp;</TD>
										<TD width="100"><font face="arial, geneva, helvetica" size="1" color=black>Día Actual</font></TD>
									</TR>
									<TR>
										<TD width="485">&nbsp;</TD>
										<TD bgcolor="#E1EFFF" width="15" height="10">&nbsp;</TD>
										<TD width="100"><font face="arial, geneva, helvetica" size="1" color=black>Días Hábiles</font></TD>
									</TR>
									<TR>
										<TD width="485">&nbsp;</TD>
										<TD bgcolor="#EAEAEA" width="15" height="10">&nbsp;</TD>
										<TD width="100"><font face="arial, geneva, helvetica" size="1" color=black>Fin de semana</font></TD>
									</TR>
								</TABLE>
							</td>
						</tr>
					</table>
				</TD>
			</TR>	
			<TR>
				<TD valign="top" align="left">
					<table WIDTH="100%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
						<tr>
							<td>
								<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
									<tr>
										<td>
											<font face="arial, geneva, helvetica" size="1" color=black>
											<ul>
											<li>Seleccionar presionando con el puntero del mouse sobre el ramo que corresponda.</li>
											<li>Para agregar una nuevo ramo presionar "AGREGAR".</li>
											<li>Para volver a la información del curso presionar "VOLVER".</li> 
											<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
											</ul>
											</font>
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</TD>
			</TR>
		</TABLE>
		</CENTER>
		<BR>
	</BODY>
</HTML>
<?php	//require('../../../Include/CloseConnect.php'); ?>