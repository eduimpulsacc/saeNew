<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$pago			=$_PAGOS;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
	$ano			=$_ANO;
//	$frmModo		="ingresar";
if (trim($hid)=="") {
	$hid="hidden";
}
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM pagos WHERE id_tipo=".$pago;
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
		<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.monto,'Ingresar MONTO.')){
					return false;
				};

				if(!chkVacio(form.descripcion,'INGRESE DESCRIPCION.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
		
<?php }?>
	</HEAD>
<BODY >

	<FORM method=post name="frm" action="procesoPago.php3">
	<?php 
//		echo "<input type=hidden name=rdb value=".$institucion.">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR >
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
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
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
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick="window.location='listarPagos.php'">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaPagos.php3?pagos=<?php echo $pago ?>&caso=3">&nbsp;
									
									<INPUT TYPE=button value='ELIMINAR' onClick="window.location='procesoPago.php3?modo=eliminar&rdb=<?php echo $institucion; ?>&id=<?php echo $fila['id_tipo'];?>'">
									<INPUT TYPE="button" value="VOLVER" 
									onClick="window.location='listarPagos.php'">&nbsp;
								<?php };?>

								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick="window.location='listarPagos.php'">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>PAGOS</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>DESCRIPCION PAGO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input type=text name="descripcion" size=50 maxlength=50>
												<input type=hidden name="ano" value=<?php echo $ano?> >
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['descripcion']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="descripcion" size=50 maxlength=50 value="<?php echo $fila['descripcion'] ?>">
												<input type=hidden name="ano" value=<?php echo $ano?> >
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>MONTO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=monto size=10 maxlength=10>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['monto']);
													echo "<hr width=100% color=#0099cc>";
													?>
												<INPUT type=button value='FECHAS DE VENCIMIENTO' onClick="cuadrofecha.style.visibility = 'visible';pagocuota.style.visibility = 'hidden'">
												<INPUT type=button value='PAGO DE CUOTAS' onClick="cuadrofecha.style.visibility = 'hidden';pagocuota.style.visibility = 'visible'">
												<?php

												};
											   if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=monto size=10 maxlength=10 value="<?php echo $fila['monto'] ?>">
											<?php };?>
										<INPUT type="hidden" name=rdb value=<?php echo $institucion ?> >
										<INPUT type="hidden" name=id value=<?php echo $fila['id_tipo'] ?> >
										<INPUT type="hidden" name=modo value=<?php echo $frmModo ?> >
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
<!-------------------/ CUADRO FECHA /--------------------------------------------!-->
<?
if($frmModo=="mostrar"){
		$qry="SELECT * FROM fecha_vencimiento WHERE id_tipo=".$fila['id_tipo'];
		$miresult =@pg_Exec($conn,$qry);
		if (!$miresult) {
			error('<B> ERROR :</b>Error al acceder a la BD. ()</B>');
		}else{
			if (pg_numrows($miresult)!=0){
				$fla = @pg_fetch_array($miresult,0);	
				if (!$fla){
					error('<B> ERROR :</b>Error al acceder a la BD. (0)</B>');
					exit();
				}
			}
		}
	}
?>

<div id="cuadrofecha" style="position: absolute; top: 270px; left: 200px; width: 325px; height: 167px; visibility: hidden ">
			<p></p>
<!-------------------------------/ BEGIN FORM /-------------------------------------------------!-->
			<form action="addfecha.php" method="post" name="formu">
			<table border="0" cellpadding="0" cellspacing="1" width="60" bgcolor="black">
				<tr>									 
					<td>
						<table border="0" cellpadding="0" cellspacing="0" width="323">
							<tr>
								<td bgcolor="#4682b4">
									<div align="center">
										<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" color="white">FECHA&nbsp;VENCIMIENTO</font></div>
								</td>
								<td bgcolor="#4682b4">
									<div align="center">
										<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" color="white">FECHAS</font></div>
								</td>
							</tr>
							<tr>
								<td bgcolor="white">
									<div align="center">
										<input type="text" name="fecha" size="24">
										<input type="hidden" name="id_tipo" value="<?php echo $fila['id_tipo'] ?>" size="24">
										Ej. (dd/mm/aaaa) 
									</div>
										
								</td>
								<td bgcolor="white" align="center">
									
										<select name="select" size="4" multiple onclick='document.formu2.fecha.value=this.value'>
										  <?php
										    for ($x=0;$x<pg_numrows($miresult);$x++){
													$fla = @pg_fetch_array($miresult,$x);	
													echo "<option value='",$fla[0],"'>",$fla[0],"</option>";
											}
										  ?>
										</select>
									
								</td>
							</tr>
							<tr>
								<td bgcolor="#f5f5f5" >
									<div align="center">

										<button type="submit">
											<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
												AGREGAR FECHA
											</font>
										</button>
										
									</form>
<!---------------------------------/ END FORM/-------------------------------------------------------!-->
									</div>
								</td>
								<td bgcolor="#f5f5f5" align="center">

<!-------------------------------/ BEGIN FORM /-------------------------------------------------!-->
								<form action="elimfecha.php" method="post" name="formu2">
								<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">FECHA A ELIMINAR :</font>
									<input type="text" name="fecha" size="10" style="color:#00000;border:1px solid #152C53;padding: 3px; float:center;"  READONLY>
									<input type="hidden" name="id_tipo" value="<?php echo $fila['id_tipo'] ?>" size="24">
									
									<button type="submit" name="buttonName">
									<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">ELIMINAR</font>
											</button>
									</form>
<!---------------------------------/ END FORM/-------------------------------------------------------!-->
										
									</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
			<p><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">(*)Cada Fecha de vencimiento corresponde a una cuota</font>
		</div>

<!---------------------/ cuardro pago cuta/------------------------------------------------------!-->

		<div id="pagocuota" style="position: absolute; top: 300px; left: 200px; width: 455px; height: 197px; visibility:<?php echo $hid ?>">
			<div align="center">
				<table border="0" cellpadding="0" cellspacing="1" width="426" bgcolor="black">
					<tr>
						<td bgcolor="#d3d3d3">
							<table border="0" cellpadding="0" cellspacing="0" width="453">
								<tr>
									<td bgcolor="#4682b4">
										<div align="center">
									<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" color="white">BUSCAR&nbsp;ALUMNO</font></div>
									</td>
								</tr>
								<tr>
									<td bgcolor="white">
										<div align="center">
										<form action="" method="post">
											<input type="text" name="rt_emp" size="9">
											<input type="text" name="dig" size="2"> 
											<button onClick="buscaalu.php?rdb='$institucion'" type="submit" name="buttonName">
													<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Buscar
													</font>
											</button>
										</form>
										</div>
									</td>
								</tr>
								<tr>
									<td bgcolor="#f5f5f5" >
									<div align="center">
										ALUMNO<p></p>
										NOMBRE : <?php echo $nom_alum,"</p>"; ?> 
										RUT : <?php echo $rt_rmp; ?> 
									</div>
									
									</td>
								</tr>
								<tr>
									<td bgcolor="#d3d3d3">
										<div align="center">
											<?
												if($frmModo=="mostrar"){
														$qry="SELECT * FROM fecha_vencimiento where fecha_venc not in (select fecha_venc from fechaxalumno where rut_emp='$rt_emp')";
														$miresult =@pg_Exec($conn,$qry);
														if (!$miresult) {
															error('<B> ERROR :</b>Error al acceder a la BD. ()</B>');
														}else{
															if (pg_numrows($miresult)!=0){
																$fla = @pg_fetch_array($miresult,0);	
																if (!$fla){
																	error('<B> ERROR :</b>Error al acceder a la BD. (0)</B>');
																	exit();
																}
															}
														}
													}
											?>
											<font size="1" face="Courier New,Courier,Monaco">CUOTA&nbsp;A&nbsp;CANCELAR</font>
											<p>
											<select name="fechas" size="1" >
													  <?php
														for ($x=0;$x<pg_numrows($miresult);$x++){
																$fla = @pg_fetch_array($miresult,$x);	
																echo "<option value='",$fla[fecha_venc],"'>",$fla[fecha_venc],"</option>";
														}
													  ?>
											</select>
				<button type="submit" <?php if (pg_numrows($miresult)==0) 
													echo "disabled";
												else 
													echo "enabled"; ?>
					>
					<font size="1" face="Arial,Courier,Monaco">CANCELAR&nbsp;CUOTA</font></button></p>
				</button>
										</div>
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
				</BODY>
</HTML>