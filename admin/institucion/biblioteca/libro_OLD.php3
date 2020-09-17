<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$libro			=$_LIBRO;
	$frmModo		=$_FRMMODO;
	$agrupacion		=$_AGRUPACION;	//	1:CP	2:CA	3:WS	4:CP
	$agrupacion		=1;
//	$frmModo		="ingresar";
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM LIBRO WHERE ID=".$libro;
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
				if(!chkSelect(form.COD_EDIT,'INGRESE EDITORIAL.')){
					return false;
				};
				if(!chkVacio(form.TITULO,'Ingresar TITULO.')){
					return false;
				};
				if(!chkVacio(form.AUTOR,'Ingresar AUTOR.')){
					return false;
				};

				return true;
			}
		</SCRIPT>
<?php }?>
	</HEAD>
<BODY >
	<FORM method=post name="frm" action="procesoLibro.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
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
									<INPUT TYPE="submit" value="GUARDAR" name=btnGuardar 
									onclick="return valida(this.form);">&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarLibros.php">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaLibro.php3?libro=<?php echo $libro?>&caso=3">&nbsp;
										<INPUT TYPE="button" value="ELIMINAR" name=btnEliminar onClick="window.location='elimlibro.php?id=<?php echo $libro?>'">
										&nbsp;
											<?php }?>
									<?php }//ACADEMICO Y LEGAL?>
										<INPUT TYPE="button" value="VOLVER" onClick=document.location="listarLibros.php">&nbsp;
								<?php };?>

								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaLibro.php3?libro=<?php echo $libro?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>LIBROS</strong>
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
												<STRONG>ISBN</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input type=text name="ISBN" size=12 maxlength=12>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['isbn']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="ISBN" VALUE=<?php echo $fila['isbn'] ?> size=12 maxlength=12>
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
												<STRONG>TITULO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=TITULO size=80 maxlength=100>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['titulo']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=TITULO size=80 VALUE="<?php echo $fila['titulo'] ?>" maxlength=100>
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
												<STRONG>SUB TITULO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=SUBTITULO size=80 maxlength=100>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['subtitulo']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=SUBTITULO size=80 VALUE="<?php echo $fila['subtitulo'] ?>" >
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
												<STRONG>NOTAS</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<textarea name="NOTA" cols="60" rows="3"></textarea>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['notas']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<textarea name="NOTA" cols="60" rows="3"><?php echo trim($fila['notas']) ?></textarea>
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
												<STRONG>AUTOR</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input type=test name="AUTOR" size="60" >
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($fila['autor']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=test name="AUTOR" size="60" VALUE="<?php echo $fila['autor'] ?>">
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
										<STRONG>AÑO EDICION</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
									<?php if($frmModo=="ingresar"){ ?>
										<input name="ANO" size="4" maxlength=4><font size="1"> Ej. 2002</font>
									<?php };?>
									<?php 
										if($frmModo=="mostrar"){ 
											imp($fila['ano']);
										};
									?>
									<?php if($frmModo=="modificar"){ ?>
										<input name="ANO" size="4" VALUE="<?php echo $fila['ano'] ?>"><font size="1"> Ej. 2002</font>
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
										<STRONG>EDICION</STRONG>
									</FONT>
								</TD>
							</TR>
							<TR>
								<TD>
									<?php if($frmModo=="ingresar"){ ?>
										<input name="EDICION" size="50">
									<?php };?>
									<?php 
										if($frmModo=="mostrar"){ 
											imp($fila['edicion']);
										};
									?>
									<?php if($frmModo=="modificar"){ ?>
										<input name="EDICION" size="50" VALUE="<?php echo $fila['edicion'] ?>">
									<?php };?>
								</TD>
							</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>EDITORIAL</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
										<?php
										if(($frmModo=="ingresar")||($frmModo=="modificar")){
											$qry="SELECT * FROM editorial";
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD.(1)</B>');
											$sele="";
											if ($fila['cod_edit']!=0) {
												$sele="SELECTED";
											}
											echo "<select name=COD_EDIT >";
											echo "<option value='' ",$sele,">--SELECCIONE UNA--</option>";
											for ($x=0 ; $x<@pg_numrows($result);$x++){
													$row = @pg_fetch_array($result,$x);
													echo "<option value=",$row[cod_edit]," ".$sele.">",$row[nombre]," ",$row[APE_PAT],"</option>";
											}
											echo "</select>";	
											
										?>
										<INPUT TYPE="button" value="AGREGAR EDITORIAL" onClick=window.open('addedit.htm','Editorial','height=200,width=380,scrollbar=no,location=no,resizable=no')>
										<?php 
										}
										if($frmModo=="mostrar"){ 
											$qry="SELECT * FROM editorial where COD_EDIT=".$fila[cod_edit];
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD.(1)</B>');
											$row = @pg_fetch_array($result,0);

											echo $row[nombre];
										}
										?>
										<input type=hidden name=id value=<?php echo trim($libro)?>>
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