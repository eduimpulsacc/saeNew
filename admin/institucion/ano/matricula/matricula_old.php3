<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT matricula.*, alumno.*, date_part('day',matricula.fecha) AS day, date_part('month',matricula.fecha) AS month, date_part('year',matricula.fecha) AS year FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE (((matricula.id_ano)=".$ano.") AND ((alumno.rut_alumno)=".$alumno."))";

		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					exit();
				};
			};
		};
	};
?>
<HTML>
	<HEAD>
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

		<!--<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">-->
		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<?php include('../../../../util/rpc.php3');?>
<?php if($frmModo=="ingresar"){?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
				};

				if(!nroOnly(form.txtRUT,'Se permiten sólo numeros en el RUT.')){
					return false;
				};
				
				if(form.cmbNac.value==2){
					if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
						return false;
					};
				};

				if(form.cmbNac.value==2){
					if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
						return false;
					};
				};
				
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE del alumno.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO del alumno.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO del alumno.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};

				if(!chkSelect(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkSelect(form.cmbNac,'Seleccionar NACIONALIDAD.')){
					return false;
				};

				if(!chkVacio(form.txtNAC,'Ingresar FECHA NACIMIENTO.')){
					return false;
				};

				if(!chkFecha(form.txtNAC,'FECHA NACIMIENTO inválida.')){
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

				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
				//PENDIENTE HASTA TENER LA FUNCION DEL DESPLIEGUE DE LAS REGIONES EN COMBOS
/*
				if(!chkSelect(form.cmbREG,'Seleccionar REGION.')){
					return false;
				};

				if(!chkSelect(form.cmbCIU,'Seleccionar CIUDAD.')){
					return false;
				};

				if(!chkSelect(form.cmbCOM,'Seleccionar COMUNA.')){
					return false;
				};
*/
				if(!chkSelect(form.cmbCURSO,'Seleccionar CURSO.')){
					return false;
				};
				
				if(!chkVacio(form.FechaMatric,'Ingresar FECHA MATRICULA.')){
					return false;
				};
				
				if(!chkFecha(form.FechaMatric,'FECHA MATRICULA inválida.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
<?php }?>
<?php if($frmModo=="modificar"){?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkSelect(form.cmbCURSO,'Seleccionar CURSO.')){
					return false;
				};
				if(!chkFecha(form.FechaMatric,'FECHA MATRICULA inválida.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
<?php }?>
	
	
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<?php if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../periodo/listarPeriodo.php3"><img src="../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../feriado/listaFeriado.php3"><img src="../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../planEstudio/listarPlanesEstudio.php3"><img src="../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../../atributos/listarTiposEnsenanza.php3"><img src="../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../curso/listarCursos.php3"><img src="../../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../../botones/matricula_roll.gif" name="Image7" width="81" height="30" border="0" id="Image7" ></a></td>
          <td width="81" height="30"><a href="../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table>
<? } ?>
	<?php //echo tope("../../../../util/");?>
	<FORM method=post name="frm" action="procesoMatricula.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
		if(($frmModo=="modificar")||($frmModo=="eliminar"))
			echo "<input type=hidden name=alumno value=".$fila['rut_alumno'].">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
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
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
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
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
							<TD align=right colspan=2>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarMatricula.php3">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
								<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaMatricula.php3?matricula=<?php echo $matricula?>&caso=3">&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaMatricula.php3?caso=9">&nbsp;
											<?php }?>
								<?php }?>
									
          <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="listarMatricula.php3">
          &nbsp;
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaMatricula.php3?alumno=<?php echo $alumno?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor="#003b85">
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>MATRICULA ALUMNO</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD colspan=3>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>RUT</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtRUT size=10 maxlength=10 onChange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp($fila['rut_alumno']);?>
													</strong></font>
												<?php };
												
												if ($frmModo=="modificar"){
													imp($fila['rut_alumno']);?>
													<INPUT  type="hidden" name=txtRUT size=10 maxlength=10 value="<?php echo($fila['rut_alumno']);?>" onChange="checkRutField(this);">
												<?php }	?>
										
										</TD>
										<TD>&nbsp;-&nbsp;</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtDIGRUT size=1 maxlength=1 >
                <?php };?>
                <?php 
												if(($frmModo=="mostrar")||($frmModo=="modificar")){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp($fila['dig_rut']);?>
													</strong></font>
												<?php };
											?>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 width=81%>
            <TR>
										<TD width="25%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NOMBRES</STRONG>
											</FONT>
										</TD>
										<TD width="30%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>APELLIDO PATERNO</STRONG>
											</FONT>
										</TD>
										<TD width="45%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>APELLIDO MATERNO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp($fila['nombre_alu']);?>
													</strong></font>
												<?php };
												
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo ($fila['nombre_alu']);?>">
												<?php }; ?>
											
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp($fila['ape_pat']);?>
													</strong></font>
												<?php };
												
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo ($fila['ape_pat']);?>">
												<?php }; ?>
										
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													imp($fila['ape_mat']);?>
													</strong></font>
												<?php };
												
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo ($fila['ape_mat']);?>">
												<?php };?>
												
											
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=LEFT>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=81%>
									<TR>
										<TD width="37%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA<BR>NACIMIENTO</STRONG>
											</FONT>
										</TD>
										<TD width="28%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>SEXO</STRONG>
											</FONT>
										</TD>
										<TD width="35%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NACIONALIDAD</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNAC size=10 maxlength=10 onChange="chkFecha(form.txtNAC,'Fecha nacimiento  invalida.');">
												
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													impF($fila['fecha_nac']);?>
													</strong></font>
												<?php };
												
												if ($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtNAC size=10 maxlength=10 value="<?php impF($fila['fecha_nac']);?>" onChange="chkFecha(form.txtNAC,'Fecha nacimiento  invalida.');">
													<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
												<?php }?>

										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbSEXO" >
													<option value=0 selected></option>
													<option value=1 >Femenino</option>
													<option value=2 >Masculino</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
													switch ($fila['sexo']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 1:
															 imp('Femenino');
															 break;
														 case 2:
															 imp('Masculino');
															 break;
													 };?>
													 </strong></font>
												<?php };
												
												if ($frmModo=="modificar"){?>
													<Select name="cmbSEXO" >
														<?php if ($fila['sexo']==0){?>
															<option value=0 selected>Indeterminado</option>
														<?php }else{ ?>
															<option value=0>Indeterminado</option>
														<?php }if ($fila['sexo']==1){?>
															<option value=1 selected>Femenino</option>
														<?php }else{ ?>
															<option value=1>Femenino</option>
														<?php }if ($fila['sexo']==2){?>
															<option value=2 selected>Masculino</option>
														<?php }else{?>
															<option value=2 >Masculino</option>
															<?php } ?>
														</Select>
											<?php } ?>
												
											
										</TD>
										<TD>
											<?php if ($frmModo=="ingresar"){ ?>
												<Select name="cmbNac">
												<option value=0 selected></option>
												<option value=2>Chilena</option>
												<option value=1>Extranjera</option>
											<?php }; ?>
											<?php if ($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
														switch ($fila['nacionalidad']){
															case 0:
																imp('INDETERMINADO');
																break;
															case 1:
																imp('Extranjera');
																break;
															case 2:
																imp('Chilena');
																break;
														};?>
														</strong></font>
												  <?php }; 
												  
											 if($frmModo=="modificar"){?>
												<Select name="cmbNac">
													<?php if ($fila['nacionalidad']==0){?>
														<option value=0 selected>Indeterminada</option>
													<?php }else{?>
														<option value=0></option>
													<?php }if ($fila['nacionalidad']==1){?>
														<option value=1 selected>Extranjera</option>
													<?php }else{?>
														<option value=1>Extranjera</option>
													<?php }if ($fila['nacionalidad']==2){?>
														<option value=2 selected>Chilena</option>
													<?php }else{?>
														<option value=2 >Chilena</option>
														<?php }?>
												</Select>
											<?php } ?>
												  
									
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=LEFT>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=100%>
									<TR align=LEFT>
										<TD width="43%">
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD width="278">
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TELEFONO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
																imp($fila['telefono']);?>
																</strong></font>
															<?php };
													
														
														if($frmModo=="modificar"){ ?>
																<INPUT type="text" name=txtTELEF value="<?php echo ($fila['telefono']);?>" size=20 maxlength=30>
															<?php } ?>
														
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD width="57%">
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD width="388">
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>EMAIL</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtEMAIL size=40 maxlength=50>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
																imp($fila['email']);?>
																</strong></font>
															<?php };
															
															if($frmModo=="modificar"){?>
																<INPUT type="text" name=txtEMAIL size=40 value="<?php echo ($fila['email']);?>" maxlength=50>
															<?php }?>
															

													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=CENTER>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=100%>
									<TR align=LEFT>
										<TD>
											<TABLE width="653" BORDER=0 CELLPADDING=0 CELLSPACING=0>
                  <TR>
													<TD width="223">
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>CURSO</STRONG>
														</FONT>
													</TD>
													<TD width="8">&nbsp;&nbsp;</TD>
													<TD width="203">
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>FECHA MATRICULA</STRONG>
														</FONT>
													</TD>
													<TD width="10">&nbsp;&nbsp;</TD>
													
                    <TD width="211"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <STRONG>N&ordm; DE MATRICULA</STRONG> </FONT> </TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbCURSO">
																<option value=0 selected></option>
																<?php
																	//TOTAL DE CURSOS INGRESADOS
																	$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.id_curso FROM tipo_ensenanza INNER JOIN (institucion INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON institucion.rdb = ano_escolar.id_institucion) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano."))";
																	$result =@pg_Exec($conn,$qry);
																	if (!$result) 
																		error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
																	else{
																		if (pg_numrows($result)!=0){
																			$fila1 = @pg_fetch_array($result,0);	
																			if (!$fila1){
																				error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
												
																				exit();
																			};
																			for($i=0 ; $i < @pg_numrows($result) ; $i++){
																				$fila1 = @pg_fetch_array($result,$i);
																				
																				if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
																					$grado="PRIMER NIVEL";
																				}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
																					$grado="PRIMER CICLO";
																				}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
																					$grado="SALA CUNA";
																				}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
																					$grado="SEGUNDO NIVEL";
																				}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
																					$grado="SEGUNDO CICLO";
																				}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
																					$grado="NIVEL MEDIO MENOR";
																				}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
																					$grado="TERCER NIVEL";
																				}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
																					$grado="NIVEL MEDIO MAYOR";
																				}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
																					$grado="TRANSICIÓN 1er NIVEL";
																				}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
																					$grado="TRANSICIÓN 2do NIVEL";
																				}else{
																					$grado=$fila1['grado_curso'];
																				}
																				
																				echo  "<option value=".$fila1["id_curso"].">".$grado."-".$fila1["letra_curso"]." ".$fila1["nombre_tipo"]."</option>";
																			}
																		}
																	};
																?>
															</Select>
														<?php };?>
														<?php 
															if($frmModo=="mostrar"){?><FONT face="arial, geneva, helvetica" size=2><strong><?php 
															  $qryC = "SELECT cod_decreto, grado_curso, letra_curso, nombre_tipo FROM ((curso INNER JOIN matricula ON curso.id_curso=matricula.id_curso) INNER JOIN tipo_ensenanza ON tipo_ensenanza.cod_tipo=curso.ensenanza) WHERE matricula.rut_alumno=".$fila["rut_alumno"]." and matricula.id_ano=".$ano; 
								  								$resultC =@pg_Exec($conn,$qryC);
								 							    $filaC = @pg_fetch_array($resultC,0); 
																
																if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
																					$grado="PRIMER NIVEL";
																				}else if ( ($filaC['grado_curso']==1) and (($filaC['cod_decreto']==121987) or ($filaC['cod_decreto']==1521989)) ){
																					$grado="PRIMER CICLO";
																				}else if ( ($filaC['grado_curso']==1) and ($filaC['cod_decreto']==1000)){
																					$grado="SALA CUNA";
																				}else if ( ($filaC['grado_curso']==2) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
																					$grado="SEGUNDO NIVEL";
																				}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==121987) ){
																					$grado="SEGUNDO CICLO";
																				}else if ( ($filaC['grado_curso']==2) and ($filaC['cod_decreto']==1000)){
																					$grado="NIVEL MEDIO MENOR";
																				}else if ( ($filaC['grado_curso']==3) and (($filaC['cod_decreto']==771982) or ($filaC['cod_decreto']==461987)) ){
																					$grado="TERCER NIVEL";
																				}else if ( ($filaC['grado_curso']==3) and ($filaC['cod_decreto']==1000)){
																					$grado="NIVEL MEDIO MAYOR";
																				}else if ( ($fila1['grado_curso']==4) and ($filaC['cod_decreto']==1000)){
																					$grado="TRANSICIÓN 1er NIVEL";
																				}else if ( ($filaC['grado_curso']==5) and ($filaC['cod_decreto']==1000)){
																					$grado="TRANSICIÓN 2do NIVEL";
																				}else{
																					$grado=$filaC['grado_curso'];
																				}
																
																imp($grado."-".$filaC["letra_curso"]." ".$filaC["nombre_tipo"]);
																echo "<input type=hidden name=curso value=".$filaC['id_curso'].">";
																?>
																</strong></font>
															<?php };
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbCURSO">
																<option value=0></option>;
																<?php
																	//CURSO EN EL QUE SE ENCUENTRA MATRICULADO
																	$qry="select id_curso from matricula where rut_alumno=".$alumno." and rdb=".$institucion." and id_ano=".$ano;
																	$result =@pg_Exec($conn,$qry);
																	$fila4= @pg_fetch_array($result,0);

																	//TOTAL DE CURSOS INGRESADOS
																	$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.id_curso FROM tipo_ensenanza INNER JOIN (institucion INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON institucion.rdb = ano_escolar.id_institucion) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano."))";
																	$result =@pg_Exec($conn,$qry);
																	if (!$result) 
																		error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
																	else{
																		if (pg_numrows($result)!=0){
																			$fila1 = @pg_fetch_array($result,0);	
																			if (!$fila1){
																				error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
																				exit();
																			};
																			for($i=0 ; $i < @pg_numrows($result) ; $i++){
																				$fila1 = @pg_fetch_array($result,$i);
																				if($fila4["id_curso"]!=$fila1["id_curso"]){
																				
																				if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
																					$grado="PRIMER NIVEL";
																				}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
																					$grado="PRIMER CICLO";
																				}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
																					$grado="SALA CUNA";
																				}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
																					$grado="SEGUNDO NIVEL";
																				}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
																					$grado="SEGUNDO CICLO";
																				}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
																					$grado="NIVEL MEDIO MENOR";
																				}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
																					$grado="TERCER NIVEL";
																				}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
																					$grado="NIVEL MEDIO MAYOR";
																				}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
																					$grado="TRANSICIÓN 1er NIVEL";
																				}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
																					$grado="TRANSICIÓN 2do NIVEL";
																				}else{
																					$grado=$fila1['grado_curso'];
																				}
																				
																					echo  "<option value=".$fila1["id_curso"].">".$grado."-".$fila1["letra_curso"]." ".$fila1["nombre_tipo"]."</option>";
																				}else{
																					$grado=$fila1['grado_curso'];
																					echo  "<option value=".$fila1["id_curso"]." selected>".$grado."-".$fila1["letra_curso"]." ".$fila1["nombre_tipo"]."</option>";
																				}
																			}
																		}
																	};
																?>
															</Select>
														<?php };?>
													</TD>
													<TD>&nbsp;&nbsp;</TD>
								<?php	//*************** MODIFICACION 07-02-2003 ********************** 
											//----------- Agregar campo Fecha Matricula --------------------	?>
													<TD>
													<?php if($frmModo=="ingresar"){ ?>
															<INPUT TYPE="text" NAME="FechaMatric" value="" size="10">
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>(DD-MM-AAAA)</STRONG>
														</FONT>
                      
                      <?php	}; ?>
                      <?php if($frmModo=="mostrar"){?><FONT face="arial, geneva, helvetica" size=2><strong><?php 
															$Dia = Trim($fila['day']);
															if (strlen($Dia)==1){ $Dia = "0" . $Dia; };
															$Mes = Trim($fila['month']);
															if (strlen($Mes)==1){ $Mes = "0" . $Mes; };
															$Ano = Trim($fila['year']);
															if ($Dia!="" && $Mes!="" && $Ano!="" && $Ano!="0"){
																echo($Dia . "-" . $Mes . "-" . $Ano);
															}else{ 
																echo(" "); 
															};?>
															</strong></font>
														  <?php }; ?>
                      <?php if ($frmModo=="modificar"){ 
															$Dia = Trim($fila['day']);
															if (strlen($Dia)==1){ $Dia = "0" . $Dia; };
															$Mes = Trim($fila['month']);
															if (strlen($Mes)==1){ $Mes = "0" . $Mes; };
															$Ano = Trim($fila['year']); ?>
                      <input type="text" name="FechaMatric" value="<?php if ($Dia!="" && $Mes!="" && $Ano!="" && $Ano!="0"){ echo($Dia . "-" . $Mes . "-" . $Ano); }else{ echo(""); }; ?>" size="10">
                     <FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>(DD-MM-AAAA)</STRONG>
														</FONT>
					  <!--br>
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(DD-MM-AAAA)</STRONG>
															</FONT-->
													<?php }; ?>
													</TD>
								<?php	//***************** FIN MODIFICACION *************************** ?>
								                   <TD>&nbsp;&nbsp;</TD>
								<?php	//*************** MODIFICACION 07-02-2003 ********************** 
											//----------- Agregar campo Fecha Matricula --------------------	?>
													<TD>
													<?php if($frmModo=="ingresar"){ ?>
                      <INPUT TYPE="text" NAME="NumerMatric" value="" size="10">
															
													<?php	}; ?>
													<?php if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
															imp($fila['num_mat']);?>
															</strong></font>
														  <?php }; ?>
													<?php if ($frmModo=="modificar"){ ?>
															<INPUT TYPE="text" NAME="NumerMatric" value="<?php echo ($fila['num_mat']); ?>" size="10">
													<?php }; ?>
													</TD>
								<?php	//***************** FIN MODIFICACION *************************** ?>
												</TR>
											</TABLE>
										</TD>
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
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
																		imp($fila['calle']);?>
																		</strong></font>
																	<?php };
																
																if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtCALLE size=35 value="<?php echo ($fila['calle']);?>" maxlength=50>
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
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtNRO size=10 maxlength=5>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
																		imp($fila['nro']);?>
																		</strong></font>
																	<?php };
																	
																	if($frmModo=="modificar"){ ?>
																		<INPUT type="text" name=txtNRO size=10  maxlength=5 value="<?php echo ($fila['nro']);?>">
																	<?php }; ?>
																
																	
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
																	<STRONG>DEPTO&nbsp;&nbsp;&nbsp;</STRONG>
																</FONT>
															</TD>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>BLOCK&nbsp;&nbsp;&nbsp;</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ ?><FONT face="arial, geneva, helvetica" size=2><strong><?php
																		imp($fila['depto']);?>
																		</strong></font>
																	<?php };
																
																	if($frmModo=="modificar"){ ?>
																		<INPUT type="text" name=txtDEP size=12 maxlength=10 value="<?php echo ($fila['depto']);?>">
																	<?php }; ?>
															</TD>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['block']);
																	};
																	if($frmModo=="modificar"){?>
																		<INPUT type="text" name=txtBLO value="<?php echo ($fila['block']);?>" size=12 maxlength=10>
																	<?php }; ?>
															</TD>
														</TR>
													</TABLE>
													</TD>
													<TD width="48%">
													<TABLE WIDTH=100% BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>VILLA/POBL&nbsp;&nbsp;&nbsp;</STRONG>
																</FONT>
															</TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['villa']);
																	};
																if($frmModo=="modificar"){ ?>
																		<INPUT type="text" name=txtVIL value="<?php echo ($fila['villa']);?>" size=34 maxlength=50>
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
<!-------------------// COMBO REGION-PROVINCIA-COMUNA//------------------------------------------------>

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
																				<TD>
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
																						if($frmModo=="mostrar"){ 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	?><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo ($filaREG['nom_reg']);?> </strong></font><?
																						};
																					?>
			<?php if($frmModo=="modificar"){ ?>
				<!--INPUT type="text" name=txtREG size=20 value="<?php echo $fila['region']?>"-->


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
																				<TD>
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
																						if($frmModo=="mostrar"){ 
										$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad'];
										$resultPRO	=@pg_Exec($conn,$qryPRO);
										$filaPRO	= @pg_fetch_array($resultPRO,0);
										?><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo ($filaPRO['nom_pro']);?> </strong></font><?
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
																				<TD>
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
																						if($frmModo=="mostrar"){ 
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$fila['region']." AND COR_PRO=".$fila['ciudad']." AND COR_COM=".$fila['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			?><font face="Arial, Helvetica, sans-serif" size="2"><strong><? echo ($filaCOM['nom_com']);?></strong> </font><?
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
							<TD width="100%" colspan=4>
								<?php  if($frmModo=="mostrar"){?>
								<?php 	if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CERTIFICADO" onClick=document.location="certificado.php3">
									<?php }
									}else{?>
									<!--<INPUT TYPE="button" value="CERTIFICADO" disabled>-->
								<?php  }
								if (($_PERFIL==21)||($_PERFIL==6)){?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="FICHA MEDICA" onClick=document.location="../fichas/medicas/listarFichasAlumno.php3?alumno=<?php echo $alumno?>">
										<INPUT class="botonZ" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="FICHA PSICOLOGICA" onClick=document.location="../fichas/psicologica/listaFichaAlumnos.php?alumno=<?php echo $alumno?>">
								<? 		
								}?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<?php if($frmModo=="ingresar"){?>
				<tr>
					<td colspan=4 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Para los Alumnos Extranjeros no ingresar el d&iacute;gito verificador.</li>
														<li>Una vez finalizado el ingreso de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para volver al listado de metriculas ingresadas al sistema.</li>
														<li>Para abandonar la sesión de usuario presionar "CERRAR SESSION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="mostrar"){?>
				<tr>
					<td colspan=4 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
													<li>"MODIFICAR" : Modifica la información de la matrícula ingresada.</li>
													<li>"ELIMINAR" : Elimina toda la información de la matricula ingresada.</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
			<?php if($frmModo=="modificar"){?>
				<tr>
					<td colspan=4 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
														<li>Una vez finalizada la modificación de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para no realizar modificaciones.</li>
														<li>Para abandonar la sesión de usuario presionar "CERRAR SESION".</li>
													</ul>
												</font>
											</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			<?php }?>
		</TABLE>
	</FORM>
</BODY>
</HTML>