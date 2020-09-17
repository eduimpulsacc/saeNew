<?php require('../../../../../../util/header.inc');?>
<?php 
     $_POSP = 6;
	 $_bot  = 5;
	if($frmModo==NULL)
		$frmModo		=$_FRMMODO;
	if($institucion==NULL)
		$institucion	=$_INSTIT;
	if($ano==NULL)
		$ano			=$_ANO;
	if($curso==NULL)
		$curso			=$_CURSO;
	if($alumno==NULL)
		$alumno			=$_ALUMNO;
	if($apoderado==NULL && $frmModo=="reporte"){

		echo "<script>window.location = '../../../reportes/FichaApoderado.php?c_curso=".$curso."&c_alumno=0&_INSTIT=".$institucion."&_ANO=".$ano."' </script>";
		exit;		
	}
	if($apoderado==NULL)
		$apoderado		=$_APODERADO;

	$pago			=$_PAGOS;


?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT apoderado.*, tiene2.responsable, tiene2.sostenedor FROM alumno INNER JOIN (apoderado INNER JOIN tiene2 ON apoderado.rut_apo = tiene2.rut_apo) ON alumno.rut_alumno = tiene2.rut_alumno WHERE (((apoderado.rut_apo)=".trim($apoderado).") and tiene2.rut_alumno=".$alumno.")";

		
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
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE del apoderado.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO del Apoderado.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO del Apoderado.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkSelect(form.cmbRELACION,'Seleccionar RELACION con el Alumno.')){
					return false;
				};

				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo numeros telefónicos en el campo TELEFONO.')){
						return false;
					};
				};
				if(form.txtCelular.value!=''){
					if(!phoneOnly(form.txtCelular,'Se permiten sólo numeros telefónicos en el campo CELULAR.')){
						return false;
					};
				};
				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
/*
						if(!chkSelect(f1.m1,'Seleccionar REGION.')){
							return false;
						};
*/
						if(!chkSelect(f2.m2,'Seleccionar PROVINCIA.')){
							return false;
						};

						if(!chkSelect(f3.m3,'Seleccionar COMUNA.')){
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
				if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
				};

				if(!nroOnly(form.txtRUT,'Se permiten sólo numeros en el RUT.')){
					return false;
       			};
				/*if(!nroOnly(form.txtDIGRUT,'Ingresar digito verificador del RUT.')){
						return false;
				};*/
				if(!nroOnly(form.txtRUT,form.txtDIGRUT,' RUT Inválido.')){ 
						return false;
				};

				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE del Apoderado.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO del Apoderado.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO del Apoderado.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkSelect(form.cmbRELACION,'Seleccionar RELACION con el Alumno.')){
					return false;
				};

				if(!chkVacio(form.txtCALLE,'Ingresar CALLE.')){
					return false;
				};

				if(form.txtTELEF.value!=''){
					if(!phoneOnly(form.txtTELEF,'Se permiten sólo números telefónicos en el campo TELEFONO.')){
						return false;
					};
				};
				if(form.txtCelular.value!=''){
					if(!phoneOnly(form.txtCelular,'Se permiten sólo numeros telefónicos en el campo CELULAR.')){
						return false;
					};
				};
				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
				return true;
			}
		</SCRIPT>
<?php }?>
	
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<table width="100%"  border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="650" align="left" valign="top" width="100%">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
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
                        <? include("../../../../../../menus/menu_lateral.php") ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390">
								  
								  <!-- inicio codigo nuevo -->
								  
								  
	<FORM method=post name="frm" action="../../../../../../procesoApoderado.php3">
	<INPUT TYPE="hidden" name=alumno value="<?php echo trim($alumno)?>">
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
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
										$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo as tpe FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
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
												
																									if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "PRIMER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
														echo "PRIMER CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
														echo "SALA CUNA"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
														echo "SEGUNDO NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
														echo "SEGUNDO CICLO"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MENOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														echo "TERCER NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
														echo "NIVEL MEDIO MAYOR"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICIÓN 1er NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
														echo "TRANSICIÓN 2do NIVEL"."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}else{
														echo $fila1['grado_curso']."-".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													}

												
												
												//	echo trim($fila1['grado_curso'])."-".trim($fila1['letra_curso'])."    ".trim($fila1['nombre_tipo']);
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
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2 class="cuadro01">
							<?php if($frmModo=="ingresar"){ ?>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarApoderado.php3">&nbsp;
							<?php };?>
							<?php if($frmModo=="mostrar"){ ?>
								<?php if(($_PERFIL==14)||($_PERFIL==0)||($_PERFIL==1)){ ?>
									<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaApoderado.php3?apoderado=<?php echo trim($apoderado)?>&caso=3">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaApoderado.php3?caso=9;">&nbsp;
								<?php }?>
								<INPUT class="botonXX"  TYPE="button" value="ALUMNO" onClick=document.location="../alumno.php3">&nbsp;
							<?php };?>
							<?php if($frmModo=="modificar"){ ?>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
								<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaApoderado.php3?apoderado=<?php echo trim($apoderado)?>&caso=1">&nbsp;
							<?php };?>

							</TD>
						</TR>
						<TR height=20 class="tableindex">
							<TD align=middle colspan=2>
								
									APODERADO
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
            <TR>
										<TD colspan=4>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>RUT</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD valign=top class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtRUT size=10 maxlength=10 onChange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar" || $frmModo=="reporte"){ 
													imp($fila['rut_apo']);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($fila['rut_apo']);
												};
											?>
										</TD>
										<TD valign=top>&nbsp;-&nbsp;</TD>
										<TD valign=top class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtDIGRUT size=1 maxlength=1 >
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($fila['dig_rut']);
												};
											?>
											<?php 
												if($frmModo=="modificar"){ 
													imp($fila['dig_rut']);
												};
											?>
										</TD>
										
										<TD align=right width=90% class="cuadro01">
											<?php if($frmModo=="ingresar"){ ?>
												
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=300>
                  <TR align=center> 
                    <TD width="136" align="left" class="cuadro01"> <INPUT TYPE="checkbox" NAME="chkRESP" value=1>
                      APODERADO </TD>
                    <TD width="164" align="left" class="cuadro01"><input type="checkbox" name="chkSOS" value="1">
					 SOSTENEDOR </TD>
                  </TR>
                </TABLE>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													if(($fila['responsable']==1) and ($fila['sostenedor']==0)){ 
														imp("APODERADO RESPONSABLE");
													};
													if(($fila['sostenedor']==1) and ($fila['responsable']==0)){
														imp("SOSTENEDOR");
													}
													if(($fila['sostenedor']==1) and ($fila['responsable']==1)){
														imp("APODERADO RESPONSABLE Y SOSTENEDOR");
													}
												};
											?>
											<?php 
												if($frmModo=="modificar"){ ?>
													
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 WIDTH=300>
                  <TR align=center> 
                    <TD width="136" align="left"> <INPUT TYPE="checkbox" NAME="chkRESP" <?php if($fila['responsable']==1) echo "checked"?> value=1>
                      APODERADO </TD>
                    <TD width="164" align="left"><input type="checkbox" name="chkSOS" <?php if($fila['sostenedor']==1) echo "checked"?> value=1>
					 SOSTENEDOR </TD>
                  </TR>
                </TABLE>
											<? };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NOMBRES</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>APELLIDO PATERNO</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>APELLIDO MATERNO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR class="cuadro01">
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($fila['nombre_apo']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo trim($fila['nombre_apo']);?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($fila['ape_pat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo trim($fila['ape_pat']);?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
													imp($fila['ape_mat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo trim($fila['ape_mat']);?>">
											<?php };?>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
									<TR align=CENTER>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TELEFONO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD class="cuadro01">
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																imp($fila['telefono']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30 value="<?php echo trim($fila['telefono']);?>">
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>EMAIL</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD class="cuadro01">
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtEMAIL size=40 maxlength=50>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																imp($fila['email']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtEMAIL size=40 maxlength=50 value="<?php echo trim($fila['email']);?>">
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD align=CENTER>
											<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=50%>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>RELACION</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD class="cuadro01">
														<?php if($frmModo=="ingresar"){?>
															<Select name="cmbRELACION" >
																<option value=0 selected></option>
																<option value=1 >Padre</option>
																<option value=2 >Madre</option>
																<option value=3 >Otro</option>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																switch ($fila['relacion']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Padre');
																		 break;
																	 case 2:
																		 imp('Madre');
																		 break;
																	 case 3:
																		 imp('Otro');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbRELACION">
																<option value=0></option>
														<option value=1 <?php echo ($fila['relacion'])==1?"selected":"" ?>>Padre</option>
														<option value=2 <?php echo ($fila['relacion'])==2?"selected":"" ?>>Madre</option>
														<option value=3 <?php echo ($fila['relacion'])==3?"selected":"" ?>>Otro</option>
															</Select>
														<?php };?>

													</TD>
												</TR>
											</TABLE>
										</TD>
												<td>
<!---------------------------------------------------------------------------------------------------------->
	<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
															<TR>
																<TD>
																	<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																		<STRONG>DIA PAGO</STRONG>
																	</FONT>
																</TD>
															</TR>
															<TR>
																<TD class="cuadro01">
					<?php
						$qry="SELECT anxapoderado.fecha, institucion.rdb, anxapoderado.rut_apo FROM (anxapoderado INNER JOIN apoderado ON anxapoderado.rut_apo = apoderado.rut_apo) INNER JOIN institucion ON anxapoderado.rdb = institucion.rdb WHERE (((institucion.rdb)=".$_INSTIT.") AND ((anxapoderado.rut_apo)=".$_APODERADO."))";
						$resultanx =@pg_Exec($conn,$qry);
						if (@pg_numrows($resultanx)!=0){
							$filaanx = @pg_fetch_array($resultanx,0);
							$dia = $filaanx['fecha'];
						}else
							$dia =5;
					?>																		

																	<?php if($frmModo=="ingresar"){ ?>
																		<Select name="cmbDIA">
																			<option value=5 selected>Día 5</option>
																			<option value=10 >Día 10</option>
																			<option value=15 >Día 15</option>
																			<option value=20 >Día 20</option>
																			<option value=25 >Día 25</option>
																		</Select>
																	<?php };?>
																	<?php if($frmModo=="mostrar"  || $frmModo=="reporte"){ ?>
																			<?if($dia==5) echo " Dia 5 "?>
																			<?if($dia==10) echo " Dia 10 "?>
																			<?if($dia==15) echo " Dia 15 "?>
																			<?if($dia==20) echo " Dia 20 "?>
																			<?if($dia==25) echo " Dia 25 "?>
																	<?php };?>
																	<?php if($frmModo=="modificar"){ ?>
																		<Select name="cmbDIA">
																			<option value=5 <?php if($dia==5) echo " selected "?>>Día 5</option>
																			<option value=10 <?php if($dia==10) echo " selected "?>>Día 10</option>
																			<option value=15 <?php if($dia==15) echo " selected "?>>Día 15</option>
																			<option value=20 <?php if($dia==20) echo " selected "?>>Día 20</option>
																			<option value=25 <?php if($dia==25) echo " selected "?>>Día 25</option>
																		</Select>
																	<?php };?>
																</TD>
															</TR>
														</TABLE>
<!------------------------------------------------------------------------------------------------------------>
												</td>
									</TR>
									<TR align=CENTER>
									  <TD colspan="4"><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                        <tr>
                                          <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>CELULAR</STRONG></FONT></td>
                                        </tr>
                                        <tr>
                                          <td class="cuadro01">
                                            <?php if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                                            <INPUT type="text" name=txtCelular size=10 maxlength=10 value="<?php echo trim($fila['celular']);?>">
                                            <? } else { imp(trim($fila['celular']))?>
                                            <?php };?></td>
                                        </tr>
                                      </table></TD>
								  </TR>
									<TR align=CENTER>
									  <TD colspan="4"><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                        <tr>
                                          
                    <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>NIVEL 
                      EDUCACIONAL</STRONG></FONT></td>
                                        </tr>
                                        <tr>
                                          <td class="cuadro01">
                                            <?php if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                                            <INPUT type="text" name="nivel_edu" size=60 maxlength=100 value="<?php echo trim($fila['nivel_edu']);?>">
                                            <? } else { imp(trim($fila['nivel_edu']))?>
                                            <?php };?></td>
                                        </tr>
                                      </table></TD>
								  </TR>
									<TR align=CENTER>
									  <TD colspan="4"><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                        <tr>
                                          <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>PROFESI&Oacute;N</STRONG></FONT></td>
                                        </tr>
                                        <tr>
                                          <td class="cuadro01">
                                            <?php if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                                            <INPUT type="text" name="profesion" size=60 maxlength=100 value="<?php echo trim($fila['profesion']);?>">
                                            <? } else { imp(trim($fila['profesion']))?>
                                            <?php };?></td>
                                        </tr>
                                      </table></TD>
								  </TR>
									<TR align=CENTER>
									  <TD colspan="4"><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                        <tr>
                                          <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>LUGAR DE TRABAJO </STRONG></FONT></td>
                                        </tr>
                                        <tr>
                                          <td class="cuadro01">
                                            <?php if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                                            <INPUT type="text" name="lugar_trabajo" size=60 maxlength=100 value="<?php echo trim($fila['lugar_trabajo']);?>">
                                            <? } else { imp(trim($fila['lugar_trabajo']))?>
                                            <?php };?></td>
                                        </tr>
                                      </table></TD>
								  </TR>
									<TR align=CENTER>
									  <TD colspan="4"><table width="100%"  border="0" cellspacing="1" cellpadding="1">
                                        <tr>
                                          <td><FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>CARGO</STRONG></FONT></td>
                                        </tr>
                                        <tr>
                                          <td class="cuadro01">
                                            <?php if($frmModo=="modificar" or $frmModo=="ingresar"){ ?>
                                            <INPUT type="text" name="cargo" size=60 maxlength=100 value="<?php echo trim($fila['cargo']);?>">
                                            <? } else { imp(trim($fila['cargo']))?>
                                            <?php };?></td>
                                        </tr>
                                      </table></TD>
								  </TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE width=520 bgcolor=#cccccc height=100 Border=0 cellpadding=1 cellspacing=0>
									<TR>
										<TD align=left height=10>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>&nbsp;&nbsp;DIRECCION</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<TABLE width=100% height=100% bgcolor=White BORDER=0>
												<TR>
													<TD>
													<TR height="100%">
													<TD width="4%"></TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>CALLE</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD class="cuadro01">
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($fila['calle']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50 value="<?php echo trim($fila['calle'])?>" >
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD><TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>NRO</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD class="cuadro01">
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($fila['nro']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5 value=<?php echo $fila['nro']?> >
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD></TR>
													<!--F7-->
													<TR height="100%">
													<TD width="4%"></TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>DEPTO&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>BLOCK&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD class="cuadro01">
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($fila['depto']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10 value="<?php echo $fila['depto']?>" >
																<?php };?>
															</TD>
															<TD class="cuadro01">
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($fila['block']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10 value="<?php echo $fila['txtBLO']?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>VILLA/POBL&nbsp;&nbsp;&nbsp;(OPCIONAL)</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD class="cuadro01">
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																		imp($fila['villa']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50 value="<?php echo trim($fila['villa'])?>">
																<?php };?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													</TR>

													<?php if($frmModo=="modificar"){ ?>
														<INPUT type="hidden" name=txtREG value=<?php echo $fila['region']?>>
														<INPUT type="hidden" name=txtCIU value=<?php echo $fila['ciudad']?>>
														<INPUT type="hidden" name=txtCOM value=<?php echo $fila['comuna']?>>
													<?php }else{?>
														<INPUT type="hidden" name=txtREG>
														<INPUT type="hidden" name=txtCIU>
														<INPUT type="hidden" name=txtCOM>
													<?php }?>
	</FORM>
													<TR height="100%">
														<TD width="4%"></TD>
														<TD COLSPAN=2>
															<TABLE width=100% height=100% bgcolor=White BORDER=0  CELLSPACING=0 CELLPADDING=0>
																<TR>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>REGION</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD class="cuadro01">
																					<?php if($frmModo=="ingresar"){ ?>
<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																						};
																					?>
			<?php if($frmModo=="modificar"){ ?>

<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			if($filaREG['cod_reg']==$fila['region'])
				echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\" selected>".trim($filaREG['nom_reg'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaREG['cod_reg'])."\">".trim($filaREG['nom_reg'])." </OPTION>\n";
		}//for resultREG
	?>
	</SELECT>
</FORM>

			<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>PROVINCIA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD class="cuadro01">
																					<?php if($frmModo=="ingresar"){ ?>
<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=1 ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>

																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
										$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
										$resultPRO	=@pg_Exec($conn,$qryPRO);
										$filaPRO	= @pg_fetch_array($resultPRO,0);
										imp($filaPRO['nom_pro']);
																						};
																					?>
<?php if($frmModo=="modificar"){ ?>
	<!--INPUT type="text" name=txtCIU size=20 value=<?php echo $fila['ciudad']?>-->

<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			if($filaPRO['cor_pro']==$fila['ciudad'])
				echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\" selected>".trim($filaPRO['nom_pro'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaPRO['cor_pro'])."\">".trim($filaPRO['nom_pro'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT>
</FORM>


<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																	<TD>
																		<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
																			<TR>
																				<TD>
																					<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																						<STRONG>COMUNA</STRONG>
																					</FONT>
																				</TD>
																			</TR>
																			<TR>
																				<TD class="cuadro01">
																					<?php if($frmModo=="ingresar"){ ?>
<FORM  method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=1 AND COR_PRO=1 ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\">".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
</FORM>
																					<?php };?>
																					<?php 
																						if($frmModo=="mostrar"  || $frmModo=="reporte"){ 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			imp($filaCOM['nom_com']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
											<!--INPUT type="text" name=txtCOM size=20 value=<?php echo $fila['comuna']?>-->

<FORM method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			if($filaCOM['cor_com']==$fila['comuna'])
				echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" selected>".trim($filaCOM['nom_com'])." </OPTION>\n";
				else
					echo "<OPTION value=\"".trim($filaCOM['cor_com'])."\" >".trim($filaCOM['nom_com'])." </OPTION>\n";
		}//for resultPRO
	?>
	</SELECT> 
</FORM>

																					<?php };?>
																				</TD>
																			</TR>
																		</TABLE>
																	</TD>
																</TR>
															</TABLE>
														</TD>
													</TR>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>						
							</TD>
						</TR>
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD align=center>
											<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=200>
												<TR align=center>
													<TD colspan=2>
<!---------------------------------------------------------------------------------------------------------------->
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>

						
						<TR height=15>
							<TD width="100%" colspan=2 class="cuadro01">
								<?php if($frmModo=="mostrar"){?>
									<? if(($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>
									<?php
										echo "<INPUT class='botonX' onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE=button value=FOTO onClick=window.open('frmFoto.php3?rut=",$apoderado,"','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')>";
									?>
									<INPUT class="botonXX"  TYPE="button" value="ACCESO WEB"  onClick=document.location="usuario/usuario.php3">
									<!--INPUT TYPE="button" value="FICHA ALUMNO"  onClick=document.location="fichaAlumno.php3"-->
								<?php }}else{?>
										<!--INPUT TYPE="button" value="FOTO" disabled>
										<INPUT TYPE="button" value="ACCESO WEB" disabled>
										<!--INPUT TYPE="button" value="FICHA ALUMNO" disabled-->
								<?php }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>		
		</TABLE>
						 
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  <!-- fin codigo nuevo -->
								  
								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
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
</body>
</html>
