<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$_POSP = 4;
	$_bot = 6;
	if($Modo==1)
	{
		$frmModo = "mostrar";
	}
?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT matricula.*, alumno.*, matricula.fecha as fecha_entera, date_part('day',matricula.fecha) AS day, date_part('month',matricula.fecha) AS month, date_part('year',matricula.fecha) AS year FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE (((matricula.id_ano)=".$ano.") AND ((alumno.rut_alumno)=".$alumno."))";
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

<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>			
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
				
				 if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
			    };
				
			    if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
					return false;
			    };
				
				
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE del alumno.')){
					return false;
				};

				

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO del alumno.')){
					return false;
				};

				

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO del alumno.')){
					return false;
				};

/*				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};
*/
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
				
				if (!chkVacio(form.NumerMatric,'Debe ingresar NRO. DE MATRICULA')){
				   return false;
				}
				
				if (form.NumerMatric.value==0){
				   alert ('Debe ingresar un número mayor que cero en campo NRO. DE MATRICULA');
				   return false;
				}
				
				return true;
			}
		</SCRIPT>
<?php }?>
<?php if($frmModo=="modificar"){?>
		<SCRIPT language="JavaScript">
<!--
function valida(form){
			   if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE del alumno.')){
					return false;
				};

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO del alumno.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO del alumno.')){
					return false;
				};

/*				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
					return false;
				};
*/				
				
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
			    
				if(!chkSelect(form.cmbCURSO,'Seleccionar CURSO.')){
					return false;
				};

				if(!chkFecha(form.FechaMatric,'FECHA MATRICULA inválida.')){
					return false;
				};
				
				if(!chkVacio(form.FechaMatric,'Ingresar FECHA MATRICULA.')){
					return false;
				};
				
				if(!chkFecha(form.FechaMatric,'FECHA MATRICULA inválida.')){
					return false;
				};
										
				/*if (!chkVacio(form.NumerMatric,'Debe ingresar NRO. DE MATRICULA')){
				   return false;
				}   
				
				if (form.NumerMatric.value==0){
				   alert ('Debe ingresar un número mayor que cero en campo NRO. DE MATRICULA');
				   return false;
				}   
				*/
				
				return true;
			}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>
<?php }?>

<script language="javascript">
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</SCRIPT>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <? include("../../../../cabecera/menu_superior.php"); ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=3; include("../../../../menus/menu_lateral.php"); ?>
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
	 <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
     
     <div id="gif_sige" style="text-align:right"><img src="../../../clases/soap/gif_sige.gif"></div>

	<FORM method="post" name="frm" action="procesoMatricula.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
		if(($frmModo=="modificar")||($frmModo=="eliminar"))
			echo "<input type=hidden name=alumno value=".$fila['rut_alumno'].">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						
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
						<TR >
							<TD align=right colspan=3>
								<?php if($frmModo=="ingresar"){ ?>
								<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" >&nbsp;
                                <INPUT class="botonXX"  TYPE="submit" value="VALIDAR EN SIGE" name="btnGuardarSige" onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarMatricula.php3">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
								<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=19)&&($_PERFIL!=21)&&($_PERFIL!=22) ){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)&&($_PERFIL!=6)&&($_PERFIL!=26)){ //FINANCIERO Y  CONTADOR?>
									<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaMatricula.php3?matricula=<?php echo $matricula?>&caso=3">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaMatricula.php3?caso=9">&nbsp;
											<?php }?>
											
											
								<?php }
		if($_PERFIL==19 or $_PERFIL==20 or $_PERFIL==0){?>								
		<?php											
		$qry="select id_curso from matricula where rut_alumno=".$alumno." and rdb=".$institucion." and id_ano=".$ano;
		$result =@pg_Exec($conn,$qry);
		$fila4= @pg_fetch_array($result,0);
		?>
		<!---- <INPUT class="botonXX"  TYPE="button" value="ANOTACIONES" onClick=document.location="../curso/alumno/alumno.php3?pesta=4&curso_act=<?//=//$fila4[id_curso]?>">--->
		<?	}	?>
		<? if(($_PERFIL==19)&&($institucion==1525))
		
		{?> 
		
        <INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaMatricula.php3?matricula=<?php echo $matricula?>&caso=3">&nbsp;
		<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaMatricula.php3?caso=9">
		
		<? } ?>
        <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarMatricula.php3">
        &nbsp;
		
		<?php };?>
		<?php if($frmModo=="modificar"){ ?>
		
        <INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaMatricula.php3?alumno=<?php echo $alumno?>&caso=1">&nbsp;
								<?php };?>							</TD>
						</TR>
						<tr>
						  <td><label>
						    <input name="bot_post" class="botonXX" type="button" id="bot_post" onClick="MM_openBrWindow('../reportes/printComprobantePostulacion.php?alumno=<?=$alumno ?>','','resizable=yes,width=650,height=400')" value="COMPROBANTE DE POSTULACION">
						  </label></td>
						</tr>
						
						<TR height=20 bgcolor="">
							<TD align=middle colspan=3 class="tableindex">MATRICULA ALUMNO</TD>
						</TR>
						<TR>
							<TD colspan="3" >
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										<TD colspan=3 class="cuadro02">RUT</TD>
										<TD class="cuadro01"><strong>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtRUT" size="10" maxlength="11">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><?php imp($fila['rut_alumno']);?> <?php };
												
												if ($frmModo=="modificar"){
													imp($fila['rut_alumno']);?>
													<INPUT  type="hidden" name=txtRUT size=10 maxlength=11 value="<?php echo($fila['rut_alumno']);?>" onChange="checkRutField(this);">
												<?php }	?>
										</strong>										</TD>
										<? $rut_alu = $fila['rut_alumno'];?>
										<TD class="cuadro01">&nbsp;-&nbsp;</TD>
										<TD class="cuadro01">
											<?
							 if($frmModo=="ingresar"){ ?>
												 <INPUT type="text" name="txtDIGRUT" size="1" maxlength="1" >
				    <? //if ($_PERFIL==0 or $_PERFIL==14){?>
												         <!-- <input name="crea_rut" type="button" class="botonXX" onClick="window.open('crea_rut.php','a','left=100,top=100,width=250,height=150');" value="Crear Rut"> -->
													<? //} ?>
										 <? };?>
											
							                <?php if(($frmModo=="mostrar")||($frmModo=="modificar")){ ?><strong><?php	imp($fila['dig_rut']);?></strong> <?php };?>
										</TD>
								<!-- INGRESO DE CAMPO DE NUMERO DE PASAPORTE -->
										<TD>&nbsp;</TD>
										<?php if($institucion==9071){ ?>
										<TD colspan=3 class="cuadro02">PASAPORTE</TD>
										<TD class="cuadro01"><strong>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtPASAPORTE" size="10" maxlength="10">
											<?php };?>

<?php 

if($frmModo=="mostrar"){ ?>&nbsp;<?php echo $fila['pasaporte'];?> <?php };
if ($frmModo=="modificar"){?>

	<INPUT  type="txt" name=txtPASAPORTE size=10 maxlength=10 value="<?php echo trim($fila['pasaporte']);?>">
    
<?php }	?>
</strong></TD>
<TD class="cuadro01">
</TD>
<? } ?>

<!--- TERMINO NUMERO DE PASAPORTE -->
</TR>								
</TABLE>

<?	
if ($frmModo=="ingresar"){  ?>
						    <br>	
							<table width="100%" border="1" bordercolor="#FF0000" cellpadding="5" cellspacing="0">
							 <tr>
							   <td bgcolor="#FFFFFF"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#FF0000">Atención:  <br>
							   Si necesita matricular a un alumno extranjero sin rut nacional válido, primero debe matricularlo en el SIGE
							   y luego con el rut que le asignó dicho sistema matricular en nuestra plataforma.</font>
							   </td>
							 </tr>
							 </table>  
					 <? } ?>		
							
							</TD>
						</TR>
			            <TR class="cuadro02">
							<TD><strong>NOMBRES</strong></TD>
							<TD><strong>APELLIDO PATERNO</strong></TD>
							<TD><strong>APELLIDO MATERNO</strong></TD>
						</TR>
						<TR class="cuadro01">
							<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><strong><?php imp($fila['nombre_alu']);?></strong><?php };
												
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo trim ($fila['nombre_alu']);?>">
												<?php }; ?>							</TD>
							<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><strong><?php imp($fila['ape_pat']);?></strong><?php };
												
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo trim ($fila['ape_pat']);?>">
												<?php }; ?>							</TD>
							<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><strong><?php
													imp($fila['ape_mat']);?>
													</strong>
												<?php };
												
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo trim ($fila['ape_mat']);?>">
												<?php };?>							</TD>
						</TR>
						<TR class="cuadro02">
							<TD><strong>FECHA<BR>NACIMIENTO</strong></TD>
							<TD><strong>SEXO</strong></TD>
							<TD><strong>NACIONALIDAD</strong></TD>
						</TR>
						<TR class="cuadro01">
							<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtNAC size=12 maxlength=10 onChange="chkFecha(form.txtNAC,'Fecha nacimiento  invalida.');"><br>(DD-MM-AAAA)
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><strong><?php
													impF($fila['fecha_nac']);?>
													</strong>
												<?php };
												
												if ($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtNAC size=12 maxlength=10 value="<?php impF($fila['fecha_nac']);?>" onChange="chkFecha(form.txtNAC,'Fecha nacimiento  invalida.');"><br>(DD-MM-AAAA)
												<?php }?>							</TD>
							<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbSEXO" >
													<option value=0 selected></option>
													<option value=2 >Masculino</option>
													<option value=1 >Femenino</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ ?><strong><?php
													switch ($fila['sexo']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 2:
															 imp('Masculino');
															 break;
														 case 1:
															 imp('Femenino');
															 break;
													 };?>
													 </strong>
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
											<?php } ?>							</TD>
							<TD>
											<?php if ($frmModo=="ingresar"){ ?>
												<Select name="cmbNac">
												<option value=0 selected></option>
												<option value=2>Chilena</option>
												<option value=1>Extranjera</option>
												</Select>
											<?php }; ?>
											<?php if ($frmModo=="mostrar")
											{ 
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
														
											 <?php }
											 if($frmModo=="modificar"){?>
												<select name="cmbNac">
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
												</select>
											<?php } ?>						</TD>
					</TR>
					<TR class="cuadro02">
						<TD><strong>TELEFONO</strong></TD>
						<TD><strong>EMAIL</strong></TD>
						<TD><strong>CURSO</strong></TD>
					</TR>
					<TR class="cuadro01">
						<TD>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT type="text" name=txtTELEF size=20 maxlength=30>
								<?php };?>
								<?php 
									if($frmModo=="mostrar"){ ?><strong><?php
										imp($fila['telefono']);?>
										</strong>
									<?php };
							
								
								if($frmModo=="modificar"){ ?>
										<INPUT type="text" name=txtTELEF value="<?php echo trim ($fila['telefono']);?>" size=20 maxlength=30>
									<?php } ?>						</TD>
						<TD>
								<?php if($frmModo=="ingresar"){ ?>
									<INPUT type="text" name=txtEMAIL size=40 maxlength=50>
								<?php };?>
								<?php 
									if($frmModo=="mostrar"){ ?><strong><?php
										imp($fila['email']);?>
										</strong>
									<?php };
									
									if($frmModo=="modificar"){?>
										<INPUT type="text" name=txtEMAIL size=40 value="<?php echo trim ($fila['email']);?>" maxlength=50>
									<?php }?>						</TD>
						<TD>
								<?php if($frmModo=="ingresar"){ ?>
								<select name="cmbCURSO">
                                  <option value=0 selected></option>
                                  <?php
											//TOTAL DE CURSOS INGRESADOS
											$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.id_curso FROM tipo_ensenanza INNER JOIN (institucion INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON institucion.rdb = ano_escolar.id_institucion) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) order by curso.ensenanza, curso.grado_curso, curso.letra_curso";
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
														}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
															$grado="TRANSICIÓN 1do NIVEL";
														}else{
															$grado=$fila1['grado_curso'];
														}
														
														echo  "<option value=".$fila1["id_curso"].">".$grado."-".$fila1["letra_curso"]." ".$fila1["nombre_tipo"]."</option>";
													}
												}
											};
										?>
                                </select>
								<?php };?>
								<?php 
									if($frmModo=="mostrar"){?><strong><?php
									 
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
														}else if ( ($fila1['grado_curso']==4) || ($filaC['cod_decreto']==1000)){
															$grado="TRANSICIÓN 1er NIVEL";
												        }else if ( ($fila1['grado_curso']==5) || ($filaC['cod_decreto']==1000)){
															$grado="TRANSICIÓN 2er NIVEL";
														}else{
															$grado=$filaC['grado_curso'];
														}
													
										
										imp($grado."-".$filaC["letra_curso"]." ".$filaC["nombre_tipo"]);
										echo "<input type=hidden name=curso value=".$filaC['id_curso'].">";
										?>
										</strong>
									<?php };
								?>
								<?php if($frmModo=="modificar"){ ?>
									<Select name="cmbCURSO">
										<option value=0></option>
										<?php
											//CURSO EN EL QUE SE ENCUENTRA MATRICULADO
											$qry="select id_curso from matricula where rut_alumno=".$alumno." and rdb=".$institucion." and id_ano=".$ano;
											$result =@pg_Exec($conn,$qry);
											$fila4= @pg_fetch_array($result,0);

											//TOTAL DE CURSOS INGRESADOS
											$qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.id_curso FROM tipo_ensenanza INNER JOIN (institucion INNER JOIN (curso INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) ON institucion.rdb = ano_escolar.id_institucion) ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((ano_escolar.id_ano)=".$ano.")) ORDER BY ensenanza, grado_curso, letra_curso";
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
								<?php };?>						</TD>
					<TR class="cuadro02">
						<TD><strong>FECHA MATRICULA</strong></TD>
						<TD><strong>N&ordm; DE MATRICULA</strong></TD>
	                    <TD><strong>COMUNA</strong></TD>
					</TR>
					<TR class="cuadro01">
						<TD>
						
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
													
												}
											}
										?>
							<?php if($frmModo=="ingresar"){ ?>
<INPUT TYPE="text" NAME="FechaMatric" value="01-03-<? echo trim($fila1['nro_ano']);?>" size="12"><br>(DD-MM-AAAA)
							<?php	}; ?>
							<?php if($frmModo=="mostrar"){?><strong>
								<?php 
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
															</strong>
							<?php }; ?>
							<?php if ($frmModo=="modificar"){ 
										$Dia = Trim($fila['day']);
										if (strlen($Dia)==1){ $Dia = "0" . $Dia; };
										$Mes = Trim($fila['month']);
										if (strlen($Mes)==1){ $Mes = "0" . $Mes; };
										$Ano = Trim($fila['year']); ?>
									  <input type="text" name="FechaMatric" value="<?php if ($Dia!="" && $Mes!="" && $Ano!="" && $Ano!="0"){ echo($Dia . "-" . $Mes . "-" . $Ano); }else{ echo(""); }; ?>" size="12">
									 <br>(DD-MM-AAAA)
								<?php }; ?>							</TD>
							<TD>
	                           <?php if($frmModo=="ingresar"){ ?>
									<INPUT TYPE="text" value="1" NAME="NumerMatric"  size="10">
								<?php  }; ?>
								<?php  if($frmModo=="mostrar"){ ?>
										<strong><?php  imp($fila['num_mat']);?></strong>
								<?php }; ?>
								<?php if ($frmModo=="modificar"){ ?>
									<INPUT TYPE="text"  NAME="NumerMatric" value="<? echo trim(($fila['num_mat'])); ?>" size="10">
								<?php }; ?>							</TD>
																				
							<td>
							<?      
							if($frmModo=="mostrar" or $frmModo=="modificar" ){ 
									$sql_ver = "select a.*, c.* 
												from alumno a, comuna c 
												where a.rut_alumno = '$rut_alu' and a.comuna = c.cor_com  and a.ciudad = cor_pro and a.region = cod_reg";		
									$res_ver = pg_Exec($conn, $sql_ver);
									$fila_ver = pg_fetch_array($res_ver);
							}?>
																
							<?php if($frmModo=="ingresar"){ ?>	
							<Select name="txtCOM">
                              		<option value=0 selected>Seleccione Comuna</option>
                              		<?php 	$qry = "select * from comuna order by nom_com";
											$res = pg_Exec($conn,$qry);
											$nfilas = pg_num_rows($res);
											for($i=0; $i<$nfilas; $i++){
												$fila_com = pg_fetch_array($res,$i); ?>
												<option value="<?=$fila_com['cor_com']."_".$fila_com['cor_pro']."_".$fila_com['cod_reg'];?>"><? echo $fila_com['nom_com']?></option>
 											<? } ?>
                            	</Select>
							<? }?>			 
							<?php  if($frmModo=="mostrar"){ ?><strong><? echo $fila_ver['nom_com'];?></strong><? }?>
							<?php if ($frmModo=="modificar"){ ?> 
								<Select name="txtCOM">
	                              	<option value=0></option>
									
                              		<?php 	$qry = "select * from comuna order by nom_com";
											$res = pg_Exec($conn,$qry);
											$nfilas = pg_num_rows($res);									
									 for($i=0; $i<$nfilas; $i++){
												$fila_com = pg_fetch_array($res,$i);
												if( ($fila_ver['comuna']==$fila_com['cor_com']) and ($fila_ver['ciudad']==$fila_com['cor_pro']) and ($fila_ver['region']==$fila_com['cod_reg']) ) { ?>
													<option value="<?=$fila_com['cor_com']."_".$fila_com['cor_pro']."_".$fila_com['cod_reg'];?>" selected="selected"><? echo $fila_com['nom_com']?></option>
												<? }else{?>
												<option value="<?=$fila_com['cor_com']."_".$fila_com['cor_pro']."_".$fila_com['cod_reg'];?>"><? echo $fila_com['nom_com']?></option>
 											<? } }?>
								</select>								
							
							 <? }?>							</td>
						</TR>
						<TR class="cuadro02">
							<TD><strong>CALLE</strong></TD>
							<TD><strong>NRO.</strong></TD>
							<TD><strong>BLOCK</strong></TD>
						</TR>
						<TR class="cuadro01">
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								<INPUT type="text" name=txtCALLE Value="S/C" size="30" maxlength="50">
							<? }?>
							<? if($frmModo=="mostrar"){ ?><strong><? echo $fila_ver['calle'];?></strong><? }?>
							<?php if ($frmModo=="modificar"){ ?>
								<INPUT type="text" name=txtCALLE size=30 maxlength=50 value="<?=trim($fila_ver['calle'])?>">
							<? }?>							
							</TD>								
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								<INPUT type="text" name=txtNRO size=10 maxlength=5>
							<? }?>
							<? if($frmModo=="mostrar"){ ?><strong><? echo $fila_ver['nro'];?></strong><? }?>							
							<?php if ($frmModo=="modificar"){ ?>
								<INPUT type="text" name=txtNRO size=10 maxlength=5 value="<?=trim($fila_ver['nro'])?>">
							<? }?>
							</TD>
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								<INPUT type="text" name=txtBLO size=10 maxlength=10>
							<? }?>
							<? if($frmModo=="mostrar"){ ?><strong><? echo $fila_ver['block'];?></strong><? }?>							
							<?php if ($frmModo=="modificar"){ ?>
								<INPUT type="text" name=txtBLO size=10 maxlength=10 value="<?=trim($fila_ver['block'])?>">
							<? }?>
							</TD>
						</TR>
						<TR class="cuadro02">
							<TD><strong>DEPARTAMENTO</strong></TD>
							<TD><strong>VILLA / POBLACION</strong></TD>
                            <TD><strong>SISTEMA DE SALUD</strong></TD>
						<TR>
						<TR class="cuadro01">
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								<INPUT type="text" name=txtDEP size=20 maxlength=20>
							<? }?>
							<? if($frmModo=="mostrar"){ ?><strong><? echo $fila_ver['depto'];?></strong><? }?>							
							<?php if ($frmModo=="modificar"){ ?>
								<INPUT type="text" name=txtDEP size=20 maxlength=20 value="<?=trim($fila_ver['depto'])?>">
							<? }?>
							</TD>	
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								<INPUT type="text" name=txtVIL size=30 maxlength=30>
							<? }?>
							<? if($frmModo=="mostrar"){ ?><strong><? echo $fila_ver['villa'];?></strong><? }?>							
							<?php if ($frmModo=="modificar"){ ?>
								<INPUT type="text" name=txtVIL size=30 maxlength=30 value="<?=trim($fila_ver['villa'])?>"> 
							<? }?>
							</TD>
                            <TD>
							<?php if($frmModo=="ingresar"){ ?>
								      <INPUT type="text" name=txtSALUD size=20>
							   <? }?>
							   
							   <? if($frmModo=="mostrar"){ ?>
							         <strong><? echo $fila_ver['salud'];?></strong>
							   <? }?>							
					 		   <?php if ($frmModo=="modificar"){ ?>
								     <INPUT type="text" name=txtSALUD size=20 value="<?=trim($fila_ver['salud'])?>">
							   <? }?>
							</TD>
						<TR>
						
						
						
						
						<TR class="cuadro02">
							<TD><strong>COLEGIO DE PROCEDENCIA</strong></TD>
							<TD><strong>RELIGIÓN</strong></TD>
                            <TD><strong>SISTEMA INFORMATICO DE JUNAEB</strong></TD>
						<TR>
						<TR class="cuadro01">
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								      <INPUT type="text" name=txtCOLEGIOPROCEDENCIA size=20>
							   <? }?>
							   
							   <? if($frmModo=="mostrar"){ ?>
							         <strong><? echo $fila_ver['colegioprocedencia'];?></strong>
							   <? }?>							
							 
							 
							   <?php if ($frmModo=="modificar"){ ?>
								     <INPUT type="text" name=txtCOLEGIOPROCEDENCIA size=20 value="<?=trim($fila_ver['colegioprocedencia'])?>">
							   <? }?>
							</TD>
							<TD>
							
							<?php if($frmModo=="ingresar"){ ?>
								   <INPUT type="text" name=txtREL size=30 >
							<? }?>
							
							<? if($frmModo=="mostrar"){ ?>
							       <strong><? echo $fila_ver['religion'];?></strong>
							<? }?>							
							
							<?php if ($frmModo=="modificar"){ ?>
								   <INPUT type="text" name=txtREL size=30  value="<?=trim($fila_ver['religion'])?>"> 
							<? }?>
							</TD>
                            <TD>
							<?php if($frmModo=="ingresar"){ ?>
								      <INPUT type="text" name=txtJUNAEB size=20>
							   <? }?>
							   
							   <? if($frmModo=="mostrar"){ ?>
							         <strong><? echo $fila_ver['junaeb'];?></strong>
							   <? }?>							
							 
							 
							   <?php if ($frmModo=="modificar"){ ?>
								     <INPUT type="text" name=txtJUNAEB size=20 value="<?=trim($fila_ver['junaeb'])?>">
							   <? }?>
							</TD>	
						<TR>
						
						
						<!-- colegio de procedencia -->
						<TR class="cuadro02">
							<TD><strong>INGRESADO POR EL ESTABLECIMIENTO</strong></TD>
							<TD><strong>CURSOS REPETIDOS</strong></TD>
                            <TD><strong>&nbsp;</strong></TD>
						<TR>
						<TR class="cuadro01">
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								      <INPUT type="text" name=txtJUNAEB size=20>
							   <? }?>
							   
							   <? if($frmModo=="mostrar"){ ?>
							         <strong><? echo $fila_ver['junaeb'];?></strong>
							   <? }?>							
							 
							 
							   <?php if ($frmModo=="modificar"){ ?>
								     <INPUT type="text" name=txtJUNAEB size=20 value="<?=trim($fila_ver['junaeb'])?>">
							   <? }?>
							</TD>
							<TD>
							
							<?php if($frmModo=="ingresar"){ ?>
								   <INPUT type="text" name=txtCURSOSREP size=30 >
							<? }?>
							
							<? if($frmModo=="mostrar"){ ?>
							       <strong><? echo $fila_ver['cursosrep'];?></strong>
							<? }?>							
							
							<?php if ($frmModo=="modificar"){ ?>
								   <INPUT type="text" name=txtCURSOSREP size=30  value="<?=trim($fila_ver['cursosrep'])?>"> 
							<? }?>
							</TD>
                            <TD>&nbsp;</TD>
						<TR>
						
						
						<!-- colegio de procedencia -->
																				
																	

										
						<!-- Inicio Direccion-->
						
						
						<!-- Alumno Prioritario -->
						<TR class="cuadro02">
							<TD><strong>ALUMNO SEP</strong></TD>
							<TD><strong>&nbsp;ALUMNO RETOS MULTIPLES</strong></TD>
                            <TD><strong>&nbsp;ALUMNO PIE</strong></TD>
						<TR>
						<TR class="cuadro01">
                         <!--ALUMNO SEP-->
							<TD>
							<?php if($frmModo=="ingresar"){ ?>
								      <input type="checkbox" name="sep" value="1">
							   <? }?>
							   <strong>
							   <? if($frmModo=="mostrar"){ 
							          if ($fila['ben_sep']==1){ 						       
							            echo "SI";
									 }else{
										echo "NO";	
									}?>	   
							   <? }?>							
							 </strong>
							 
							   <?php if ($frmModo=="modificar"){ ?>
			 <input type="checkbox" name="sep" value="1" <? if ($fila['ben_sep']==1){ ?> checked="checked" <? } ?> >
							   <? }?>
							</TD>
                             <!--FIN ALUMNO SEP-->
							 <!--ALUMNO RETOS MULTIPLES-->
                            <TD><?php if($frmModo=="ingresar"){ ?>
								      <input type="checkbox" name="retos" value="1">
							   <? }?>
							   <strong>
							   <? if($frmModo=="mostrar"){ 
							          if ($fila['bool_retos']==1){ 
									  	echo "SI";	
									   }else{
										echo "NO";	
									}?>	   
							   <? }?>							
							 </strong>
							 
							   <?php if ($frmModo=="modificar"){ ?>
			 <input type="checkbox" name="retos" value="1" <? if ($fila['bool_retos']==1){ ?> checked="checked" <? } ?> >
							   <? }?></TD>
                              <!--ALUMNO RETOS MULTIPLES-->
                              <!--ALUMNO PIE-->
                            <TD>
                            <?php if($frmModo=="ingresar"){ ?>
								      <input type="checkbox" name="pie" value="1">
							   <? }?>
							   <strong>
							   <? if($frmModo=="mostrar"){ 
							          if ($fila['ben_pie']==1){
										echo "SI";	  
									 }else{
										echo "NO";	
									}?>	   </strong>
							   <? }?>							
							
							 
							   <?php if ($frmModo=="modificar"){ ?>
			 <input type="checkbox" name="pie" value="1" <? if ($fila['ben_pie']==1){ ?> checked="checked" <? } ?> >
							   <? }?>
                                <!--FIN ALUMNO PIE-->
                               </TD>	
						<TR>	
						
						
						
						<!-- Fin Direccion-->
						<TR height=15>
							<TD width="100%" colspan=4>
								<?php  if($frmModo=="mostrar"){?>
								<?php 	if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
									<INPUT class="botonXX"  TYPE="button" value="CERTIFICADO" onClick=document.location="certificado.php3">
									<?php }
									}else{?>
									<!--<INPUT TYPE="button" value="CERTIFICADO" disabled>-->
								<?php  }
								if (($_PERFIL==21)||($_PERFIL==6)){?>
										<INPUT class="botonXX"  TYPE="button" value="FICHA MEDICA" onClick=document.location="../fichas/medicas/listarFichasAlumno.php3?alumno=<?php echo $alumno?>">
										<INPUT class="botonXX"  TYPE="button" value="FICHA PSICOLOGICA" onClick=document.location="../fichas/psicologica/listaFichaAlumnos.php?alumno=<?php echo $alumno?>">
								<? 		
								}?>							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>			
		</TABLE>
	</FORM>							 


   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
