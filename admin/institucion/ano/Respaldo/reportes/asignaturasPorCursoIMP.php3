<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
?>
<?php 
	$docente		=5; //Codigo Docente
?>
<html>
	<head>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
	</head>
<body onLoad="javascript:window.print();history.back();">
	<center>
		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD colspan=2>


					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
				<td rowspan=3 valign=meddle>
					<?php
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);

						$output= "select lo_export(".$arr[insignia].",'/var/www/html/tmp/".$arr[rdb]."');";
						$retrieve_result = @pg_exec($conn,$output);
					?>
					<img src=../../../../../tmp/<?php echo $arr[rdb] ?> ALT="NO DISPONIBLE" width=75>
				</td>

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
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nombre_instit']);
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
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
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
													echo trim($fila['grado_curso'])." - ".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);
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
			<tr>
				<td colspan=2 align=right>
					<!--INPUT TYPE="button" value="VOLVER" onClick=document.location="asignaturasPorCurso1.php3?caso=4"-->
				</td>
			</tr>
			<tr height="20" bgcolor="#0099cc">
				<td align="middle" colspan="2">
					<font face="arial, geneva, helvetica" size="2" color="#ffffff">
						<strong>TOTAL DE RAMOS</strong>
					</font>
				</td>
			</tr>
			<tr bgcolor="#48d1cc">
				<td align="center" width="450">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>NOMBRE</strong>
					</font>
				</td>
				<td align="center" width="150">
					<font face="arial, geneva, helvetica" size="1" color="#000000">
						<strong>MODO EVALUACION</strong>
					</font>
				</td>
			</tr>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
			<?php
				$qry="SELECT subsector.nombre as nombre_ramo, ramo.id_ramo , ramo.modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";

				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
					for($i=0 ; $i < @pg_numrows($result) ; $i++){
						$fila = @pg_fetch_array($result,$i);
			?>
						<tr>
							<td align="left" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $fila["nombre_ramo"];?></strong>
								</font>
							</td>
							<td align="center" >
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong>
									<?php
										switch ($fila['modo_eval']) {
											 case 0:
												 imp('INDETERMINADO');
												 break;
											 case 1:
												 imp('Numérica');
												 break;
											 case 2:
												 imp('Conceptual');
												 break;
										 };
									?>
									</strong>
								</font>
							</td>
						</tr>
			<?php
					}
				}
			?>
			<tr>
				<td colspan="2">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>
		</table>
	</center>
</body>
</html>
<? pg_close($conn);?>