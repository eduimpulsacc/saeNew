<?php require('../../../../../util/header.inc');?>

<?php 
/***************************************************************************************/
	/*-------------------------- FUNCION LLENA COMBO ----------------------------*/
/***************************************************************************************/
	function LLenarCombo($sql,$cone,$param,$flag,$mensaje){
		$Conexion = @pg_exec($cone,$sql);
		echo "<select " . $param . ">";
		$cadena_vacio = $cadena_vacio . "&nbsp;";
		if ($flag=="true"){
			echo "<option style='Courier' value='null'>" . $mensaje . "</option>";
		};
		if ($Conexion){
			if (@pg_numrows($Conexion)!=0){
				$strValue = "       ";
				$fils = @pg_fetch_array($Conexion,0);
				for ($i=0;$i<pg_numrows($Conexion);$i++){
					$fils = @pg_fetch_array($Conexion,$i); 
					echo "<option style='Courier' value='" . Trim($fils[0]) . "'>" . Trim($fils[1]) . $strValue . "</option>";
				};
			};
		};
		@pg_close($Conexion);
		echo "</select>";
	};
/***************************************************************************************/
	/*------------------------------ FIN FUNCION --------------------------------*/
/***************************************************************************************/
?>
			
	<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	
	<SCRIPT LANGUAGE="JavaScript">
	<!--
		function valida(form){
			for (x=0;x<=form.length-1;x++){
				if (form[x].name.substr(0,5)=="fecha"){
					if(!chkVacio(form[x],'Ingresar FECHA de retiro.')){
						return false;
					};
					if(!chkFecha(form[x],'Fecha inicio invalida.')){
						return false;
					};
				};
				if (form[x].name.substr(0,12)=="especialidad"){
					if(!chkSelect(form[x],'Seleccionar la ESPECIALIDAD del alumno curso.')){
						return false;
					};
				};

			};
		};
	//-->
	</SCRIPT>

<?php 	$institucion	=$_INSTIT;
		$frmModo		=$_FRMMODO;
		$ano			=$_ANO;
		$curso			=$_CURSO; ?>

<HTML>
	<HEAD>

	
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>

	<BODY>
		<FORM METHOD=POST name="frm" ACTION="procesoFechaespec.php">
			<INPUT TYPE="hidden" name="institucion" value="<?php echo $institucion; ?>">
			<INPUT TYPE="hidden" name="ano" value="<?php echo $ano; ?>">
			<INPUT TYPE="hidden" name="curso" value="<?php echo $curso; ?>">
			
			<TABLE WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
				<TR height=15>
					<TD COLSPAN=5>
						<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
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
											$result = @pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													};
													echo trim($fila['nombre_instit']);
													$TipoRegimen = trim($fila['tipo_regimen']);
												};
											};	?>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												};
											};
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";

											$result = @pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{

												$fila = @pg_fetch_array($result,0);	
												if (!$fila){
													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
													exit();
												}
												echo trim($fila['grado_curso'])."-".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
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
					<td colspan=5 align=right>
						<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);">&nbsp;
						<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="seteapromocion.php3?institucion=<?php echo $institucion; ?>&ano=<?php echo $ano; ?>&curso=<?php echo $curso; ?>&caso=1">&nbsp;
					</td>
				</TR>
			<?php	/*****************************************************************************************/ 
						/*-------------------------------- RETIRADOS -----------------------------------*/
					/*****************************************************************************************/ ?>
				<?php	if (count($_RUT_RETIRADO)!=0){ 
							/*--- Los datos vienen de promocion (formulario)---*/
							$ListaAlumnoRetirado = "";
							for ($x=0;$x<count($_RUT_RETIRADO);$x++){
								$ListaAlumnoRetirado = $ListaAlumnoRetirado . "'" . Trim($_RUT_RETIRADO[$x]). "',";
							};
								
							if ($ListaAlumnoRetirado!=""){
								$ListaAlumnoRetirado = substr(Trim($ListaAlumnoRetirado),0,-1);
							};    ?>				
							<tr height="20" bgcolor="#003b85">
								<td align="middle" colspan="5">
									<font face="arial, geneva, helvetica" size="2" color="#ffffff">
										<strong>TOTAL DE ALUMNOS RETIRADOS=
									<b><?php $cuntalum = 0;
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")  AND ID_CURSO=(".$curso.") AND RUT_ALUMNO IN (".$ListaAlumnoRetirado.")";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila7){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila7['suma']);
													$cantalumret = intval(trim($fila7['suma']));
												}
											}
										?>
										<INPUT TYPE="hidden" name="cantalumret" value="<?php echo $cantalumret; ?>">	
									</b></strong>
									</font>
								</td>
							</tr>
							<tr bgcolor="#48d1cc">
								<td align="center" width="80">
									<font face="arial, geneva, helvetica" size="1" color="#000000">
										<strong>RUT</strong>
									</font>
								</td>
								<td align="center" width="320">
									<font face="arial, geneva, helvetica" size="1" color="#000000">
										<strong>NOMBRE</strong>
									</font>
								</td>
								<td align="center" width="50">
									<font face="arial, geneva, helvetica" size="1" color="#000000">
										<strong>FECHA</strong>
									</font>
								</td>
							</TR>
				<?php		$SQL = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=" . $curso . ") AND ((matricula.id_ano)=" . $ano . ") AND (alumno.rut_alumno) IN (" . $ListaAlumnoRetirado . ")) ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";
							$rs_alum = @pg_exec($conn,$SQL);
							if (!$rs_alum){
								error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
							};
							if (@pg_numrows($rs_alum)!=0){//En caso de estar el arreglo vacio.
								$fila = @pg_fetch_array($rs_alum,0);	
								if (!$fila){
									error('<B> ERROR :</b>Error al acceder a la BD. (10) No hay alumnos </B>');
									exit();
								};
								for($i=0 ; $i < @pg_numrows($rs_alum) ; $i++){
									$fila = @pg_fetch_array($rs_alum,$i); ?>
									<tr bgcolor=#ffffff>
										<td align="center" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<INPUT TYPE="hidden" name="rutalumret[<?php echo $i; ?>]" value="<?php echo $fila["rut_alumno"]; ?>">
												<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong>
											</font>
										</td>
										<td align="left" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong>
											</font>
										</td>
										<td align="center"><INPUT TYPE="text" NAME="fecha[<?php echo $i; ?>]" size="10">
										</td>
									</tr>
				<?php			};
							};
						}; ?>
			<?php	/*****************************************************************************************/ 
						/*------------------------------ FIN RETIRADOS ---------------------------------*/
					/*****************************************************************************************/ ?>
			<?php	/*****************************************************************************************/ 
						/*------------------------------- ESPECIALIDAD ----------------------------------*/
					/*****************************************************************************************/ ?>
				<?php	if (count($_RUT_APROBADO)!=0){ 
						/*--- Los datos vienen de promocion (formulario)---*/
							$ListaAlumnoAprobado = "";
							for ($x=0;$x<count($_RUT_APROBADO);$x++){
								$ListaAlumnoAprobado = $ListaAlumnoAprobado . "'" . Trim($_RUT_APROBADO[$x]). "',";
							};
								
							if ($ListaAlumnoAprobado!=""){
								$ListaAlumnoAprobado = substr(Trim($ListaAlumnoAprobado),0,-1);
							};		?>
							<tr height="20" bgcolor="#003b85">
								<td align="middle" colspan="5">
									<font face="arial, geneva, helvetica" size="2" color="#ffffff">
										<strong>TOTAL DE ALUMNOS APROBADOS=
									<b><?php $cuntalum = 0;
											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")  AND ID_CURSO=(".$curso.") AND RUT_ALUMNO IN (".$ListaAlumnoAprobado.")";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila7 = @pg_fetch_array($result,0);	
													if (!$fila7){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila7['suma']);
													$cantalumaprob = intval(trim($fila7['suma']));
												}
											}
										?>
										<INPUT TYPE="hidden" name="cantalumaprob" value="<?php echo $cantalumaprob; ?>">	
									</b></strong>
									</font>
								</td>
							</tr>
							
							<tr bgcolor="#48d1cc">
								<td align="center" width="80">
									<font face="arial, geneva, helvetica" size="1" color="#000000">
										<strong>RUT</strong>
									</font>
								</td>
								<td align="center" width="320">
									<font face="arial, geneva, helvetica" size="1" color="#000000">
										<strong>NOMBRE</strong>
									</font>
								</td>
								<td align="center" width="50">
									<font face="arial, geneva, helvetica" size="1" color="#000000">
										<strong>ESPECIALIDAD</strong>
									</font>
								</td>
							</TR>
				<?php	$SQL = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=" . $curso . ") AND ((matricula.id_ano)=" . $ano . ") AND (alumno.rut_alumno) IN (" . $ListaAlumnoAprobado . ")) ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu";
							$rs_alum = @pg_exec($conn,$SQL);
							if (!$rs_alum){
								error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
							};
							if (@pg_numrows($rs_alum)!=0){//En caso de estar el arreglo vacio.
								$fila = @pg_fetch_array($rs_alum,0);	
								if (!$fila){
									error('<B> ERROR :</b>Error al acceder a la BD. (10) No hay alumnos </B>');
									exit();
								};
								for($i=0 ; $i < @pg_numrows($rs_alum) ; $i++){
									$fila = @pg_fetch_array($rs_alum,$i); ?>
									<tr bgcolor=#ffffff>
										<td align="center" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<INPUT TYPE="hidden" name="rutalumaprob[<?php echo $i; ?>]" value="<?php echo $fila["rut_alumno"]; ?>">
												<strong><?php echo $fila["rut_alumno"]." - ".$fila["dig_rut"];?></strong>
											</font>
										</td>
										<td align="left" >
											<font face="arial, geneva, helvetica" size="1" color="#000000">
												<strong><?php echo $fila["ape_pat"]." ".$fila["ape_mat"].", ".$fila["nombre_alu"];?></strong>
											</font>
										</td>
										<td align="center"><?php LlenarCombo("SELECT especialidad.cod_rama || CAST('- ' AS CHARACTER) || especialidad.cod_sector || CAST('- ' AS CHARACTER) ||  especialidad.cod_esp AS cod_esp, trim(sector_eco.nombre_sector) || CAST('- ' AS CHARACTER) || trim( especialidad.nombre_esp) FROM (((curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo) INNER JOIN rama ON tipo_ensenanza.cod_tipo = rama.cod_tipo) INNER JOIN sector_eco ON rama.cod_rama = sector_eco.cod_rama) INNER JOIN especialidad ON (sector_eco.cod_sector = especialidad.cod_sector) AND (sector_eco.cod_rama = especialidad.cod_rama) WHERE (((curso.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso."))", $conn, "name='especialidad[".$i."]' size='1' width='40' syle='FONT-FAMILY:Verdana; FONT-SIZE:8pt'","true",""); ?>
										</td>
									</tr>
				<?php			};
							};
						}; ?>
			<?php	/*******************************************************************************************/
						/*------------------------------- FIN ESPECIALIDAD --------------------------------*/
					/*******************************************************************************************/ ?>
				<tr>
					<td colspan="3">
					<hr width="100%" color="#003b85">
					</td>
				</tr>
			</TABLE>
		</FORM>
	</BODY>
</HTML>
