<?php require('../../../../../../util/header.inc');?>
<?php 
	$frmModo		=$_FRMMODO;
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$alumno			=$_ALUMNO;
	$hermano		=$_HERMANO;
	$pago			=$_PAGOS;
	$_POSP          =6;
	$_bot           =5;
?>
<?php
	if($frmModo!="ingresar" or $frmModo!="mostrar") {
		$qry="SELECT hermanos.* FROM hermanos where rut_hermano = '".$hermano."'";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			echo '<B> ERROR :</b>Error al acceder a la BD. (1)</B>'; exit;
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					echo '<B> ERROR :</b>Error al acceder a la BD. (2)</B>'; exit;
					exit();
				}
			}
		}
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../Sea/estilos.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
		<LINK REL="STYLESHEET" HREF="../../../../../../util/td.css" TYPE="text/css">
									<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>

<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>
<?php if($frmModo=="modificar"){?>
		<?php include('../../../../../../util/rpc.php3');?>
		<SCRIPT language="JavaScript">
			function valida(form){
			
				if(!chkVacio(form.nombre_hermano,'Ingresar NOMBRE del Hermano.')){
					return false;
				};

				if(!alfaOnly(form.nombre_hermano,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.ape_pat,'Ingresar APELLIDO PATERNO del Hermano.')){
					return false;
				};

				if(!alfaOnly(form.ape_pat,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.ape_mat,'Ingresar APELLIDO MATERNO del Hermano.')){
					return false;
				};

				if(!alfaOnly(form.ape_mat,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkVacio(form.estudios,'Ingresar CALLE.')){
					return false;
				};
				
				if(!chkFecha(form.fecha_nac,'FECHA NACIMIENTO Inválida.')){
					return false;
				};
				
				return true;
			}
		</SCRIPT>
<?php }?>
<?php if($frmModo=="ingresar"){?>
		<?php include('../../../../../../util/rpc.php3');?>
		<SCRIPT language="JavaScript">
			function valida(form){
			
				if(!chkVacio(form.rut_hermano,'Ingresar RUT.')){
					return false;
				};
							
				if(!chkVacio(form.nombre_hermano,'Ingresar NOMBRE del Hermano.')){
					return false;
				};

				if(!alfaOnly(form.nombre_hermano,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.ape_pat,'Ingresar APELLIDO PATERNO del Hermano.')){
					return false;
				};

				if(!alfaOnly(form.ape_pat,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.ape_mat,'Ingresar APELLIDO MATERNO del Hermano.')){
					return false;
				};

				if(!alfaOnly(form.ape_mat,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkVacio(form.estudios,'Ingresar CALLE.')){
					return false;
				};
				
				if(!chkFecha(form.fecha_nac,'FECHA NACIMIENTO Inválida.')){
					return false;
				};
				if(!nroOnly(form.rut_hermano,'Se permiten sólo numeros en el RUT.')){
					return false;
       			};

				if(!nroOnly(form.rut_hermano,form.dig_rut,' RUT Inválido.')){ 
						return false;
				};
				
				return true;
			}
		</SCRIPT>
<?php }?>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? include("../../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  
								  <!-- inicio codigo antiguo -->
								  
								  

<? if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? include("../../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>	
<? } ?>
<?php //echo tope("../../../../../../util/");?>
	<FORM method=post name="frm" action="../../../../../../procesoHermano.php">
	<INPUT TYPE="hidden" name="rut_alumno" value="<?php echo trim($alumno)?>">
	<center>
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
												echo '<B> ERROR :</b>Error al acceder a la BD. (3)</B>'; exit;
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														echo '<B> ERROR :</b>Error al acceder a la BD. (4)</B>'; exit;
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
												echo '<B> ERROR :</b>Error al acceder a la BD. (5)</B>'; exit;
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														echo '<B> ERROR :</b>Error al acceder a la BD. (6)</B>'; exit;
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
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, empleado.ape_mat, empleado.ape_pat, empleado.nombre_emp FROM (tipo_ensenanza INNER JOIN (curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												echo '<B> ERROR :</b>Error al acceder a la BD. (7)</B>'; exit;
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														echo '<B> ERROR :</b>Error al acceder a la BD. (8)</B>'; exit;
														exit();
													}
													echo trim($fila1['grado_curso'])."-".trim($fila1['letra_curso'])."    ".trim($fila1['nombre_tipo']);
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])."-".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</td>
			</tr>
		</table>
		<table width="600" border="0" cellspacing="1" cellpadding="3">
          <tr>
							<TD align=right colspan=2>
							<?php if($frmModo=="ingresar"){ ?>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarHermanos.php">&nbsp;
							<?php };?>
							<?php if($frmModo=="mostrar"){ ?>
								<?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==1)){ ?>
									<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaHermano.php?hermano=<?php echo trim($hermano)?>&caso=3">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaHermano.php?caso=9;">&nbsp;
								<?php }?>
								<INPUT class="botonXX"  TYPE="button" value="ALUMNO" onClick=document.location="../alumno.php3">&nbsp;
							<?php };?>
							<?php if($frmModo=="modificar"){ ?>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaHermano.php?hermano=<?php echo trim($hermano)?>&caso=1">&nbsp;
							<?php };?>

							</TD>
          </tr>
        </table>
		<table width="600" border="0" cellspacing="1" cellpadding="3">
			<TR height=20 class="tableindex">
				<TD align=center colspan=2>
					HERMANO
				</TD>
			</TR>
		</table>
        <table width="600" border="0" cellspacing="1" cellpadding="3">
          <tr height="5">
            <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>RUT</STRONG></FONT></td>
            <td><FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp;</FONT></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><?php if($frmModo=="ingresar"){ ?>
						<INPUT type="text" name="rut_hermano" size=10 maxlength=10 onChange="checkRutField(this);">
					<?php };?>
					<?php 
						if($frmModo=="mostrar" or $frmModo=="modificar"){ 
							imp($fila['rut_hermano']);
						};
				?> - 
				<?php if($frmModo=="ingresar"){ ?>
						<INPUT type="text" name="dig_rut" size=2 maxlength=1 >
					<?php };?>
					<?php 
						if($frmModo=="mostrar" or $frmModo=="modificar"){ 
							imp($fila['dig_rut']);
						};
				?>
			</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>NOMBRES</STRONG></FONT></td>
            <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>APELLIDO PATERNO </STRONG></FONT></td>
            <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>APELLIDO MATERNO </STRONG></FONT></td>
          </tr>
          <tr>
            <td>
		<?php if($frmModo=="ingresar"){ ?>
			<INPUT type="text" name="nombre_hermano" size=25 maxlength=50>
		<?php };?>
		<?php 
			if($frmModo=="mostrar"){ 
				imp($fila['nombre_hermano']);
			};
		?>
		<?php if($frmModo=="modificar"){ ?>
			<INPUT type="text" name="nombre_hermano" size=25 maxlength=50 value="<?php echo trim($fila['nombre_hermano']);?>">
		<?php };?>			</td>
            <td>
		<?php if($frmModo=="ingresar"){ ?>
			<INPUT type="text" name="ape_pat" size=25 maxlength=50>
		<?php };?>
		<?php 
			if($frmModo=="mostrar"){ 
				imp($fila['ape_pat']);
			};
		?>
		<?php if($frmModo=="modificar"){ ?>
			<INPUT type="text" name="ape_pat" size=25 maxlength=50 value="<?php echo trim($fila['ape_pat']);?>">
		<?php };?>			
			
			</td>
            <td>
		<?php if($frmModo=="ingresar"){ ?>
			<INPUT type="text" name="ape_mat" size=25 maxlength=50>
		<?php };?>
		<?php 
			if($frmModo=="mostrar"){ 
				imp($fila['ape_mat']);
			};
		?>
		<?php if($frmModo=="modificar"){ ?>
			<INPUT type="text" name="ape_mat" size=15 maxlength=10 value="<?php echo trim($fila['ape_mat']);?>">
		<?php };?>						
			</td>
          </tr>
          <tr>
            <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>FECHA DE NACIMIENTO </STRONG></FONT></td>
            <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>ESTUDIOS</STRONG></FONT></td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>
		<?php if($frmModo=="ingresar"){ ?>
			<INPUT type="text" name="fecha_nac" size=10 maxlength=10><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>DD-MM-AAAA</STRONG></FONT>
		<?php };?>
		<?php 
			if($frmModo=="mostrar"){ 
				imp(Cfecha($fila['fecha_nac']));
			};
		?>
		<?php if($frmModo=="modificar"){ ?>
			<INPUT type="text" name="fecha_nac" size=10 maxlength=10 value="<?php echo trim((Cfecha($fila['fecha_nac'])));?>"><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>DD-MM-AAAA</STRONG></FONT>
		<?php };?>	 </td>
            <td colspan="2">
		<?php if($frmModo=="ingresar"){ ?>
			<INPUT type="text" name="estudios" size=50 maxlength=50>
		<?php };?>
		<?php 
			if($frmModo=="mostrar"){ 
				imp($fila['estudios']);
			};
		?>
		<?php if($frmModo=="modificar"){ ?>
			<INPUT type="text" name="estudios" size=50 maxlength=50 value="<?php echo trim($fila['estudios']);?>">
		<?php };?>									
			</td>
          </tr>
        </table>
		<TABLE WIDTH="600" BORDER=0 CELLSPACING=0 CELLPADDING=0>
			<TR>
				<TD>
					<HR width="100%" color=#003b85>
				</TD>
			</TR>
		</TABLE>
	</center>
	</form>

								  
								  <!-- fin codigo antiguo -->
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
