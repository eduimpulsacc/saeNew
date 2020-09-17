<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$noticia		=$_NOTICIA;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;	
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM NOTICIA WHERE ID_NOTICIA=".$noticia;
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
		<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};

				if(!chkVacio(form.txtTITULAR,'Ingresar TITULAR.')){
					return false;
				};

				if(!chkVacio(form.txtCONTENIDO,'Ingresar CONTENIDO.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
	
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY >
	<?php //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoNoticia.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=agrupacion value=".$agrupacion.">";
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
						<!--------------------------------------------------------------------->
						<!-- ESTA PARTE DEL DOCUMENTO SE MUESTRA SOLO SI ID_AGRUPACION ES "" -->
						<!--------------------------------------------------------------------->
						<!--TR>
							<TD></TD>
							<TD></TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT * FROM AGRUPACION WHERE ID_AGRUPACION=".$agrupacion;
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
													echo trim($fila1['nombre_agrupacion']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR-->
						<!--------------------------------------------------------------------->
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
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarNoticia.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5) and ($_PERFIL!=15)and($_PERFIL!=16)){ //FINANCIERO Y  CONTADOR?>
										<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaNoticia.php3?noticia=<?php echo $noticia?>&caso=3">&nbsp;
										<INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaNoticia.php3?caso=9;">&nbsp;
											<?php }?>
									<?php } //ACADEMICO Y LEGAL?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarNoticia.php3">&nbsp;
								<?php };?>

								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaNoticia.php3?noticia=<?php echo $noticia?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>NOTICIA <?php echo trim($fila1['nombre_agrupacion'])?></strong>
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
												<STRONG>FECHA</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input type=text name="txtFECHA" size=8 maxlength=10>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_pub']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="txtFECHA" size=8 maxlength=10 value=<?php impF($fila['fecha_pub'])?>>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
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
												<STRONG>TITULAR</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtTITULAR size=80 maxlength=100>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['titular']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtTITULAR size=80 maxlength=100  value="<?php echo trim($fila['titular'])?>">
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
												<STRONG>RESUMEN</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtRESUMEN" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['resumen']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtRESUMEN" cols="60" rows="3"> <?php echo ($fila['resumen'])?></textarea>
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
												<STRONG>CONTENIDO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="txtCONTENIDO" cols="60" rows="5"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['contenido']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="txtCONTENIDO" cols="60" rows="5"> <?php echo ($fila['contenido'])?></textarea>
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=right>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ESTADO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<?php if(($_PERFIL==14)||($_PERFIL==0)){?>
													<Select name="cmbESTADO">
														<option value=0 selected>NO publicada</option>
														<option value=1>Publicada</option>
													</Select>
												<?php }else{
													imp('NO publicada');
													echo "<input type=hidden name=cmbESTADO value=0>";
													};?>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($fila["estado"]) {
														 case 0:
															 imp('NO Publicada');
															 break;
														 case 1:
															 imp('Publicada');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<?php if(($_PERFIL==14)||($_PERFIL==0)){?>
													<Select name="cmbESTADO">
														<option value=0 selected>NO publicada</option>
														<option value=1>Publicada</option>
													</Select>
												<?php }else{
													switch ($fila["estado"]) {
														 case 0:
															 imp('NO publicada');
															echo "<input type=hidden name=cmbESTADO value=0>";
															 break;
														 case 1:
															 imp('publicada');
															echo "<input type=hidden name=cmbESTADO value=1>";
															 break;
													 };
													};?>
											<?php };?>
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
											<HR width="100%" color=#003b85>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2>
								<?php 
									if(($frmModo=="mostrar")&&(($_PERFIL!=2)&&($_PERFIL!=4) and ($_PERFIL!=15)and($_PERFIL!=16)))
										echo "<INPUT TYPE=button value=IMAGEN onClick=window.open('fotonoticia.php?rut=",$institucion,"&agrup=".$agrupacion."&id=".$fila[id_noticia]."','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')			
										>";
									else 
										//echo "<INPUT TYPE=button value=IMAGEN disabled>";
								?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>