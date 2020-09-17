<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	 $frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
	//$empleado="88888888";

	$qry="SELECT * FROM INSTITUCION WHERE RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	$fila = @pg_fetch_array($result,0);	
	$regINS = $fila['region'];
	$proINS = $fila['ciudad'];
	$comINS = $fila['comuna'];

?>
<? function chekear($num){
global $fila;
//echo "entro";
//echo $num;
	if (($num==1)&&($fila[habilitado]==1)){echo " checked";}
	if (($num==2)&&($fila[titulado]==1)){echo " checked";}
	if (($num==3)&&($fila[tit_otras]==1)){echo " checked";}

}?>
<?php
		$qryV ="select * from (supervisa inner join trabaja on supervisa.rut_emp=trabaja.rut_emp) where trabaja.rdb=".$institucion." and supervisa.rut_emp='".$empleado."'";
		$resultV =@pg_Exec($conn,$qryV);
		$filaV = @pg_fetch_array($resultV,0);
		/*echo $filaV["id_curso"];
		exit;*/
		if (@pg_numrows($resultV)>0){
			$qryVV="select * from (curso inner join ano_escolar on curso.id_ano=ano_escolar.id_ano) where ano_escolar.id_institucion=".$institucion." and curso.id_curso=".$filaV["id_curso"];
			$resultVV =@pg_Exec($conn,$qryVV);
			if (pg_numrows($resultVV)>0){?>
				<SCRIPT language="JavaScript">///$resV=1;
				window.alert("ESTE EMPLEADO ES PROFESOR JEFE. SI DESEA ELIMINARLO PRIMERO DEBE ASIGNAR UN NUEVO PROFESOR JEFE AL CURSO")
				</SCRIPT>
			<!--?php }else{ ?>
					<SCRIPT language="JavaScript">///$resV=1;
						document.location="seteaEmpleado.php3?caso=9";
					</SCRIPT-->
				
		<?php }}?>
	
	<?php
	if($frmModo!="ingresar"){
		$qry="SELECT trabaja.fecha_ingreso, trabaja.fecha_retiro, trabaja.cargo, empleado.*, empleado.rut_emp FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.rdb)=".$institucion.") AND ((empleado.rut_emp)=".$empleado."))";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
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
		<?php include('../../../util/rpc.php3');?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
	<?php if($frmModo=="modificar"){ ?>
		<SCRIPT language="JavaScript">
			function valida(form){

		/*		if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
				};*/

			/*	if(!nroOnly(form.txtRUT,'Se permiten sólo números en el RUT.')){
					return false;
				};*/


			/*	if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
					return false;
				};*/
				
				/*if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
					return false;
				};*/
				
				if (form.cmbCARGO1.value==0){
					alert ('Ingrese por lo menos el primer cargo')	;
					return false;
				}
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};
				
				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};
				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
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

				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};
						/*
						if(!chkSelect2(f1.m1,'Seleccionar REGION.')){
							return false;
						};
						*/
						if(!chkSelect2(f2.m2,'Seleccionar PROVINCIA.')){
							return false;
						};

						if(!chkSelect2(f3.m3,'Seleccionar COMUNA.')){
							return false;
						};
			//alert ('hola');
				/*if(!alfaOnly(form.txtTITULO,'Se permiten sólo caracteres alfanuméricos en el campo TITULO.')){
					return false;
				};*/

				if(!chkSelect2(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkSelect2(form.cmbCIVIL,'Seleccionar ESTADO CIVIL.')){
					return false;
				};

					
				if(!chkSelect2(form.cmbCARGO1,'Seleccionar CARGO.')){
					return false;
				};
			
                if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
	<?php }?>
	<?php if($frmModo=="ingresar"){ ?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtRUT,'Ingresar RUT.')){
					return false;
				};

				if(!nroOnly(form.txtRUT,'Se permiten sólo números en el RUT.')){
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
				
				if(!chkVacio(form.txtNOMBRE,'Ingresar NOMBRE.')){
					return false;
				};

				if(!alfaOnly(form.txtNOMBRE,'Se permiten sólo caracteres alfanuméricos en el campo NOMBRE.')){
					return false;
				};
				if (form.cmbCARGO1.value==0){
					alert ('Ingrese por lo menos el primer cargo')	;
					return false;
				}

				if(!chkVacio(form.txtAPEPAT,'Ingresar APELLIDO PATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEPAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO PATERNO.')){
					return false;
				};

				if(!chkVacio(form.txtAPEMAT,'Ingresar APELLIDO MATERNO.')){
					return false;
				};

				if(!alfaOnly(form.txtAPEMAT,'Se permiten sólo caracteres alfanuméricos en el campo APELLIDO MATERNO.')){
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

				if(form.txtEMAIL.value!=''){
					if(!isEmail(form.txtEMAIL,'Formato EMAIL incorrecto.')){
						return false;
					};
				};


				if(!alfaOnly(form.txtTITULO,'Se permiten sólo caracteres alfanuméricos en el campo TITULO.')){
					return false;
				};

				if(!chkSelect2(form.cmbSEXO,'Seleccionar SEXO.')){
					return false;
				};

				if(!chkSelect2(form.cmbCIVIL,'Seleccionar ESTADO CIVIL.')){
					return false;
				};

				if(!chkSelect2(form.cmbCARGO,'Seleccionar CARGO.')){
					return false;
				};
				function Confirmacion()
				{
					if(confirm('¿Esta seguro de querer realizar esta operación?') == false) 
					{
						return; 
					}
						document.form.Accion.value = "3";
						document.form.submit();
				}

				return true;
			}
		</SCRIPT>
	<?php }?>
<?php }?>
<script language="javascript" type="text/javascript">
function getElementObject(elementID) {
    var elemObj = null;
    if (document.getElementById) {
        elemObj = document.getElementById(elementID);
    }
    return elemObj;
} 

function mostrar_ocultar(obj){
a=getElementObject(obj);
	if (a.style.display==""){
		a.style.display="none";
	}else{
		a.style.display="";
	}
	
}
function chekear(obj){

	//a=getElementObject(obj);
	a=window.document.frm.cod_subsector;

	largo=	window.document.frm.cod_subsector.length;
	
	for (i=0;i<largo;i++)	{
	if (a[i].checked==true){
		a[i].checked=false;
	}else{
		a[i].checked=true;
		
	}

}
	
/*	alert(a[1].checked);
	alert(a[2].checked);
	alert(a[3].checked);
	alert(a[4].checked);*/
//	 largo=a.length;
//	alert(largo);
}	
function posicion(valor,nombre)
{
form=window.document.frm;
largo=form.elements.length;	
	for (i=0;i<largo;i++)	{
		if ((form.elements[i].type=="checkbox")&&(form.elements[i].value==valor)&&(form.elements[i].name==nombre)){
		return i;
		}
	}

}

function  titulado(obj,valor,nombre){
	pos=posicion(valor,nombre);
	pos++;
	form=window.document.frm;
	if (obj.checked==true){
		form.elements[pos].checked=false;
	}
	
}
function tit_otras(obj,valor,nombre){
	pos=posicion(valor,nombre);
	pos--;
	form=window.document.frm;
	if (obj.checked==true){
		form.elements[pos].checked=false;
	}

}
</script>
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url();
	margin-left: 30px;
}
-->
</style></HEAD>
<BODY>
	<?php //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoEmpleado.php3" onSubmit="return valida(this.form);">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0>
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50" >
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
												if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
												}
												echo trim($fila1['nombre_instit']);
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
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarEmpleado.php3">&nbsp;
								<?php };?>
								
								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=3">&nbsp;
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaEmpleado.php3?caso=9">&nbsp;
											<?php }?>
									<?php }//ACADEMICO Y LEGAL?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarEmpleado.php3">&nbsp;
								<?php };?>


								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR"   name=btnGuardar  onclick="return valida(this.form);" >&nbsp;
									<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaEmpleado.php3?empleado=<?php echo $empleado?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>PERSONAL</strong>
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
										<td width="80">&nbsp;</td>
										<TD width="182" colspan=3>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>NACIONALIDAD</STRONG>
											</FONT>
										</TD>

									</TR>
									<TR>
										
              <TD width="%"> 
                <?php if($frmModo=="ingresar"){ ?>
                <input type="text" name=txtRUT size=10 maxlength=10 > <!-- onChange="checkRutField(this);" -->
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['rut_emp']);
												};
											?>
                <?php 
												if($frmModo=="modificar"){ 
													imp(trim($fila['rut_emp']));
												};
											?>
              </TD>
										<TD width="14">&nbsp;-&nbsp;</TD>
										
              <TD width="61" align="left"> 
                <?php if($frmModo=="ingresar"){ ?>
                <INPUT type="text" name=txtDIGRUT size=1 maxlength=1>
											<?php };?>
											<?php
												if($frmModo=="mostrar"){ 
													imp($fila['dig_rut']);
												};
											?>
											<?php
												if($frmModo=="modificar"){ 
													imp($fila['dig_rut']);
												};
											?>
										</TD>
										<td>&nbsp;</td>
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
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												
                <INPUT type="text" name=txtNOMBRE size=25 maxlength=50>
											<?php };?>
											<?php
												if($frmModo=="mostrar"){ 
													imp($fila['nombre_emp']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo trim($fila['nombre_emp'])?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												
                <INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php
												if($frmModo=="mostrar"){ 
													imp($fila['ape_pat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo trim($fila['ape_pat'])?>">
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												
                <INPUT type="text" name=txtAPEMAT size=25 maxlength=50>
											<?php };?>
											<?php
												if($frmModo=="mostrar"){ 
													imp($fila['ape_mat']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo trim($fila['ape_mat'])?>">
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
									<TR>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TELEFONO</STRONG>
														</FONT>
													</TD>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TELEFONO 2</STRONG>
														</FONT>
													</TD>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>TELEFONO 3</STRONG>
														</FONT>
													</TD>

												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtTELEF size=20 maxlength=30>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																echo trim($fila['telefono']), "&nbsp;";
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
														     <? if ($fila['telefono']=="");
															    $fila['telefono']=""; ?> 
															<INPUT type="text" name="txtTELEF" size=20 maxlength=30 value="<?php echo $fila['telefono']?>">
														<?php };?>
													</TD>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
														<INPUT type="text" name=txtTELEF2 size=20 maxlength=30>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																imp($fila['telefono2']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtTELEF2 size=20 maxlength=30 value="<?php echo $fila['telefono2']?>">
														<?php };?>
												  </TD>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<INPUT type="text" name=txtTELEF3 size=20 maxlength=30>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																imp($fila['telefono3']);
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<INPUT type="text" name=txtTELEF3 size=20 maxlength=30 value="<?php echo $fila['telefono3']?>">
														<?php };?>
													</TD>

												</TR>
											</TABLE>
										</TD>
			
              <TD> 
</TD>
									</TR>
								</TABLE>
			  <table border=0 cellspacing=0 cellpadding=0 width=100%>
                  <tr> 
                    <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                      <strong>EMAIL</strong> </font> </td>
                  </tr>
                  <tr> 
                    <td> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <input type="text" name=txtEMAIL size=40 maxlength=50> 
                      <?php };?>
                      <?php
															if($frmModo=="mostrar"){ 
																echo trim($fila['email']),"&nbsp;";
															};
														?>
                      <?php if($frmModo=="modificar"){ ?>
                      <input type="text" name=txtEMAIL size=40 maxlength=50 value="<?php echo trim($fila['email'])?>"> 
                      <?php };?>
                    </td>
                  </tr>
                </table>								
							</TD>
						</TR>
                        
                    


						<TR>
							<TD width=30></TD>
							<TD align=center>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 width=100%>
            <TR align="left"> 
              <TD> 
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>SEXO</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbSEXO" >
																<option value=0 selected></option>
																<option value=1 >Masculino</option>
																<option value=2 >Femenino</option>
															</Select>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																switch ($fila['sexo']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Masculino');
																		 break;
																	 case 2:
																		 imp('Femenino');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbSEXO" >
																<option value=1 <?php echo ($fila['sexo'])==1?" selected ":"" ?>>Masculino</option>
																<option value=2 <?php echo ($fila['sexo'])==2?" selected ":"" ?>>Femenino</option>
															</Select>
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
															<STRONG>ESTADO CIVIL</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													<TD>
														<?php if($frmModo=="ingresar"){ ?>
															<Select name="cmbCIVIL" >
																<option value=0 selected></option>
																<option value=1 >Soltero(a)</option>
																<option value=2 >Casado(a)</option>
																<option value=3 >Viudo(a)</option>
															</Select>
														<?php };?>
														<?php
															if($frmModo=="mostrar"){ 
																switch ($fila['estado_civil']) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Soltero(a)');
																		 break;
																	 case 2:
																		 imp('Casado(a)');
																		 break;
																	 case 3:
																		 imp('Viudo(a)');
																		 break;
																 };
															};
														?>
														<?php if($frmModo=="modificar"){ ?>
															<Select name="cmbCIVIL" >
													<option value=1 <?php echo ($fila['estado_civil'])==1?" selected ":"" ?>>Soltero(a)</option>
													<option value=2 <?php echo ($fila['estado_civil'])==2?" selected ":"" ?>>Casado(a)</option>
													<option value=3 <?php echo ($fila['estado_civil'])==3?" selected ":"" ?>>Viudo(a)</option>
															</Select>
														<?php };?>
													</TD>
												</TR>
											</TABLE>
										</TD>
										
              <TD colspan=2> 
                <TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width="100%">
                  <TR> 
				  <? for ($i=1;$i<=2;$i++){?>
                    <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <STRONG>CARGO <? echo $i;?></STRONG> </FONT> </TD>
					<? }?>

                  </TR>
                  <TR> 
				  <? 
				   $query_trabaja="select * from trabaja  where rut_emp=$fila[rut_emp] and rdb=$_INSTIT";
				  $result_trabaja=@pg_exec($conn,$query_trabaja);
				  $num_trabaja=@pg_numrows($result_trabaja);
				//  echo "|||||".$num_trabaja;
				  for ($i=1;$i<=2;$i++){
				  $row_trabaja=@pg_fetch_array($result_trabaja);
				  	?>
                    <TD> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <Select name="cmbCARGO<? echo $i?>">
                        <option value=0 selected></option>
                        <option value=1 >Director(a)</option>
                        <option value=2 >Jefe UTP</option>
                        <option value=3 >Enfermeria</option>
                        <option value=4 >Contador(a)</option>
                        <option value=5 >Docente</option>
                        <option value=6 >Sub-Director</option>
                        <option value=7 >Inspector General</option>
                        <option value=8 >Titulación</option>
                        <option value=9 >Curriculista</option>
                        <option value=10 >Evaluador</option>
                        <option value=11 >Orientador(a)</option>
                        <option value=12 >Sicopedagogo(a)</option>
                        <option value=13 >Sicólogo(a)</option>
                        <option value=14 >Inspector(a)</option>
                        <option value=15 >Auxiliar</option>
                        <option value=16 >Coordinación CRA</option>
                        <option value=17 >Coordinación Pastoral</option>
                        <option value=18 >Coordinación ACLE</option>
                        <option value=19 >Secretaria</option>
                        <option value=20 >Tesorero(a)</option>
                        <option value=21 >Asistente Social</option>
                        <option value=22 >Coordinación Mantenimiento</option>
                      </Select> 
                      <?php };?>
                      <?php
															if($frmModo=="mostrar"){ 
																															
																switch ($row_trabaja[cargo]) {
																	 case 0:
																		 imp('INDETERMINADO');
																		 break;
																	 case 1:
																		 imp('Director(a)');
																		 break;
																	 case 2:
																		 imp('Jefe UTP');
																		 break;
																	 case 3:
																		 imp('Enfermeria');
																		 break;
																	 case 4:
																		 imp('Contador');
																		 break;
																	 case 5:
																		 imp('Docente');
																		 break;
																	 case 6:
																		 imp('Sub-Director');
																		 break;
																   	 case 7:
																		 imp('Inspector General');
																		 break;
																 	 case 8:
																		 imp('Titulacion');
																		 break;
																	 case 9:
																		 imp('Curriculista');
																		 break;
																	 case 10:
																		 imp('Evaluador');
																		 break;
																	 case 11:
																		 imp('Orientador(a)');
																		 break;
																	 case 12:
																		 imp('Sicopedagogo(a)');
																		 break;
																	 case 13:
																		 imp('Sicologo(a)');
																		 break;
																	 case 14:
																		 imp('Inspector(a)');
																		 break;
																	 case 15:
																		 imp('Auxiliar');
																		 break;
																	 case 16:
																		 imp('Coordinación CRA');
																		 break;
																	 case 17:
																		 imp('Coordinación Pastoral');
																		 break;
																	 case 18:
																		 imp('Coordinación ACLE');
																		 break;
																	 case 19:
																		 imp('Secretaria');
																		 break;
															 		 case 20:
																		 imp('Tesorero(a)');
																		 break;
																	 case 21:
																		 imp('Asistente Social');
																		 break;
															    	 case 22:
																		 imp('Coordinación Mantenimiento');
																		 break;
																 };
															};
														?>
                      <?php if($frmModo=="modificar"){ ?>
                      <Select name="cmbCARGO<? echo $i;?>">
					  	<option ></option>
                        <option value=1 <?php echo ($row_trabaja['cargo'])==1?" selected ":"" ?>>Director(a)</option>
                        <option value=2 <?php echo ($row_trabaja['cargo'])==2?" selected ":"" ?>>Jefe 
                        UTP</option>
                        <option value=3 <?php echo ($row_trabaja['cargo'])==3?" selected ":"" ?>>Enfermeria</option>
                        <option value=4 <?php echo ($row_trabaja['cargo'])==4?" selected ":"" ?>>Contador(a)</option>
                        <option value=5 <?php echo ($row_trabaja['cargo'])==5?" selected ":"" ?>>Docente</option>
                        <option value=6 <?php echo ($row_trabaja['cargo'])==6?" selected ":"" ?>>Sub-Director</option>
                        <option value=7 <?php echo ($row_trabaja['cargo'])==7?" selected ":"" ?>>Inspector 
                        General</option>
                        <option value=8 <?php echo ($row_trabaja['cargo'])==8?" selected ":"" ?>>Titulación</option>
                        <option value=9 <?php echo ($row_trabaja['cargo'])==9?" selected ":"" ?>>Curriculista</option>
                        <option value=10 <?php echo ($row_trabaja['cargo'])==10?" selected ":"" ?>>Evaluador</option>
                        <option value=11 <?php echo ($row_trabaja['cargo'])==11?" selected ":"" ?>>Orientador(a)</option>
                        <option value=12 <?php echo ($row_trabaja['cargo'])==12?" selected ":"" ?>>Sicopedagogo(a)</option>
                        <option value=13 <?php echo ($row_trabaja['cargo'])==13?" selected ":"" ?>>Sicólogo(a)</option>
                        <option value=14 <?php echo ($row_trabaja['cargo'])==14?" selected ":"" ?>>Inspector(a)</option>
                        <option value=15 <?php echo ($row_trabaja['cargo'])==15?" selected ":"" ?>>Auxiliar</option>
                        <option value=16 <?php echo ($row_trabaja['cargo'])==16?" selected ":"" ?>>Coordinación 
                        CRA</option>
                        <option value=17 <?php echo ($row_trabaja['cargo'])==17?" selected ":"" ?>>Coordinación 
                        Pastoral</option>
                        <option value=18 <?php echo ($row_trabaja['cargo'])==18?" selected ":"" ?>>Coordinación 
                        ACLE</option>
                        <option value=19 <?php echo ($row_trabaja['cargo'])==19?" selected ":"" ?>>Secretaria</option>
                        <option value=20 <?php echo ($row_trabaja['cargo'])==20?" selected ":"" ?>>Tesorero(a)</option>
                        <option value=21 <?php echo ($row_trabaja['cargo'])==21?" selected ":"" ?>>Asistente 
                        Social</option>
                        <option value=22 <?php echo ($row_trabaja['cargo'])==22?" selected ":"" ?>>Coordinación 
                        Mantenimiento</option>
                      </Select> 
                      <?php };?>
                    </TD>
					<? }?>
                  </TR>
                </TABLE>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=left>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													
              <TD>&nbsp;</TD>
												</TR>

											</TABLE>
							
          <table width="650" border="0" cellspacing="0" cellpadding="0">
            <tr> 
              <td width="339" valign="top"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">MANEJO 
                DE IDIOMAS </font></td>
              <td width="14" valign="top">&nbsp;</td>
              <td width="297" valign="top"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;OS 
                DE EXPERIENCIA</font></td>
            </tr>
            <tr> 
              <td valign="top"> 
                <?php if($frmModo=="ingresar"){ ?>
                <input name="txtIDIOMAS" type="text" id="txtIDIOMAS2" size="30" maxlength="100"> 
                <?php };?>
                <?php
					if($frmModo=="mostrar"){ 
						echo trim($fila['idiomas']);
					};
				?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="txtIDIOMAS" type="text" id="txtIDIOMAS2" value="<?php echo trim($fila['idiomas'])?>" size="30" maxlength="100"> 
                <?php };?>
              </td>
              <td valign="top">&nbsp;</td>
              <td valign="top"> 
                <?php if($frmModo=="ingresar"){ ?>
                <input name="txtEXPERIENCIA" type="text" id="txtEXPERIENCIA2" size="5" maxlength="5"> 
                <?php };?>
                <?php
					if($frmModo=="mostrar"){ 
						echo trim($fila['anos_exp']);
					};
				?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="txtEXPERIENCIA" type="text" id="txtEXPERIENCIA2" value="<?php echo trim($fila['anos_exp'])?>" size="5" maxlength="5"> 
                <?php };?>
              </td>
            </tr>
			 <tr>
              <td valign="top"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">DIA Y HORARIO DE ANTENCI&Oacute;N </font></td>
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
            </tr>
            <tr>
              <td valign="top">
			  <?php if($frmModo=="ingresar"){ ?>
			  <input name="txtAtencion" type="text" size="30" maxlength="100">
                <?php };?>
 				<?
				if($frmModo=="mostrar"){ 
						echo imp(trim($fila['atencion']));
				};
				?>
                <?php if($frmModo=="modificar"){ ?>			
			  <input name="txtAtencion" type="text" value="<?php echo trim($fila['atencion'])?>" size="30" maxlength="100">
			  <? } ?>
			  </td>
              <td valign="top">&nbsp;</td>
              <td valign="top">&nbsp;</td>
            </tr>
          </table></TD>
						</TR>
                         <TR>
							<TD width=30></TD>
							<TD >
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0>
									<TR>
										<TD>
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=1 width=98%>
            <TR> 
              <TD colspan="4" bgcolor=#cccccc> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                <STRONG>AUTORIZACION EJERCICIO DOCENTE</STRONG> </FONT> </TD>
            </TR>
            <TR> 
              <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                <STRONG>Nº RESOLUCION</STRONG> </FONT> </TD>
              <TD> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                <strong>FECHA</strong> </font> </TD>
              <TD colspan="2"><font face="arial, geneva, helvetica" size=1 color=#000000> 
                <strong>NIVEL</strong> </font> </TD>
            </TR>
            <TR> 
              <TD width="270" valign="top"> 
                <?php if($frmModo=="ingresar"){ ?>
                <INPUT type="text" name=txtNROres size=20 maxlength=10> 
                <?php };?>
                <?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['nu_resol']);
																	};
																?>
                <?php if($frmModo=="modificar"){ ?>
                <INPUT type="text" name=txtNROres size=20 maxlength=10 value=<?php echo $fila['nu_resol']?> > 
                <?php };?>
              </TD>
              <TD width="173" valign="top"> 
                <?php if($frmModo=="ingresar"){ ?>
                <input type="text" name="txtFECHA" size=20 maxlength=10 onChange="chkFecha(form.txtFECHA,'Fecha invalida.');"> 
                <?php };?>
                <?php 
																	if($frmModo=="mostrar"){ 
																		impF($fila['fecha_resol']);
																	};
																?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtFECHA" size=20 maxlength=10  value=<?php impF ($fila['fecha_resol'])?> > 
                <?php };?>
              </TD>
              <TD colspan="2" valign="top">
               <!-- <?php if($frmModo=="ingresar"){ ?>
                <select name="cmbTITULO" >
                  <option value=0 selected></option>
                  <option value=1 >HABILITADO</option>
                  <option value=2 >TITULADO EN EDUCACION</option>
                  <option value=3 >TITULADO EN OTRAS AREAS</option>
                </select>
                <?php };?>
                <?php
															if($frmModo=="mostrar"){ 
																switch ($fila['tipo_titulo']) {
																	 case 0:
																		 echo ('INDETERMINADO');
																		 break;
																	 case 1:
																		 echo ('HABILITADO');
																		 break;
																	 case 2:
																		 echo ('TITULADO EN EDUCACION');
																		 break;
																	 case 3:
																		 echo ('TITULADO EN OTRAS AREAS');
																		 break;
																 };
															};
														?>
                <?php if($frmModo=="modificar"){ ?>
                <select name="cmbTITULO" >
                  <option value=0 <?php echo ($fila['tipo_titulo'])==0?" selected ":"" ?>></option>
                  <option value=1 <?php echo ($fila['tipo_titulo'])==1?" selected ":"" ?>>HABILITADO</option>
                  <option value=2 <?php echo ($fila['tipo_titulo'])==2?" selected ":"" ?>>TITULADO 
                  EN EDUCACION</option>
                  <option value=3 <?php echo ($fila['tipo_titulo'])==3?" selected ":"" ?>>TITULADO 
                  EN OTRAS AREAS</option>
                </select>
                <?php };?>
                </em>-->

				<? $query_tipo_titulo="select * from tipo_titulo order by codigo";
					$result_tipo_titulo=pg_exec($conn,$query_tipo_titulo);
					$num_tipo_titulo=pg_numrows($result_tipo_titulo);
				?>
				<table>
					<tr>
						<td>
						<table><tr>
						<? for ($iii=0;$iii<$num_tipo_titulo;$iii++){
							$row_tipo_tit=pg_fetch_array($result_tipo_titulo)?>
							
						<td>
						
						<?  if ($row_tipo_tit[codigo]=='1'){$var_click="mostrar_ocultar('tabla_sub_sector');";}
							if ($row_tipo_tit[codigo]=='2'){$var_click="titulado(this,this.value,this.name);";}
							if ($row_tipo_tit[codigo]=='3'){$var_click="tit_otras(this,this.value,this.name);";}
						
						?>
						<input name="tipo_titulo[]" value="<? echo $row_tipo_tit[codigo];?>" type="checkbox" onClick="<? echo $var_click;?>" <? if ($frmModo=="mostrar"){echo "disabled";}?> <? chekear($row_tipo_tit[codigo]);?> ></td>
						<td nowrap="nowrap">
						<font face="arial, geneva, helvetica" size=1 color=#000000><strong>
						<? echo $row_tipo_tit['nombre'];?> 
						</strong></font>						</td>
						<? }?>
					</tr></table>					</tr>
				</table>
				
			  </TD>
            </TR>
			<tr><td colspan="6" id="tabla_sub_sector" <? if ($fila[habilitado]!=1){echo "style=\"display:none\"";}?>>
					<? 
						$query_plan="select plan2.rdb,plan2.cod_decreto
								from plan_inst as plan,plan_estudio as plan2
								where plan.rdb='$institucion'  and plan.cod_decreto=plan2.cod_decreto
								Group by plan2.rdb,plan2.cod_decreto"; 
/*					$query_sub="select sub.cod_subsector,sub.nombre
								from plan_inst as plan,subsector as sub
								where plan.rdb='$institucion' and sub.cod_subsector=incluye.cod_subsector
								Group by sub.cod_subsector,sub.nombre"; 
*/								
/*						$query_sub="select sub.cod_subsector,sub.nombre
								from plan_inst as plan,incluye ,subsector as sub
								where rdb='$institucion' and incluye.cod_decreto=plan.cod_decreto and sub.cod_subsector=incluye.cod_subsector
								Group by sub.cod_subsector,sub.nombre";*/ 
																
//								plan_estudio

					$result_plan=pg_exec($conn,$query_plan);
					$num_plan=pg_numrows($result_plan);
					?>
					<table><tr>
					<? 
					$arreglo_temp=array();
					$jj=1 ;
					for ($yy=0;$yy<$num_plan;$yy++){
						$row_plan=pg_fetch_array($result_plan);
							if (($row_plan[rdb]==0)||($row_plan[rdb]==NULL)){
								$query_sub="select sub.nombre,sub.cod_subsector 
									from incluye as incluye,subsector as sub 
									where incluye.cod_decreto='$row_plan[cod_decreto]' and sub.cod_subsector=incluye.cod_subsector";
							}else{
								$query_sub="select * 
									from incluye_propio as incluye,subsector as sub 
									where incluye.cod_decreto='$row_plan[cod_decreto]' and sub.cod_subsector=incluye.cod_subsector";
							}
							//echo "<br><br>".$query_sub."<br><br>";
							$result_sub=pg_exec($conn,$query_sub);
							$num_sub=pg_numrows($result_sub);
						
				
						
					?>
					<? $cod_subsector=unserialize($fila[habilitado_para]);

					?>
				
						<? 
						for ($xx=0;$xx<$num_sub;$xx++){
						$row_sub=pg_fetch_array($result_sub);
						
						if (!in_array($row_sub[cod_subsector],$arreglo_temp)){
								$arreglo_temp[]=$row_sub[cod_subsector]
						?>
							
								<td><input name="cod_subsector[]" type="checkbox" value="<? echo $row_sub[cod_subsector];?>" id="cob_subsector" <? if ($frmModo=="mostrar"){echo "disabled";}?>  <? if ((is_array($cod_subsector))&&(in_array ($row_sub[cod_subsector], $cod_subsector))){echo "checked";}?>></td>
								<td nowrap>
									<font face="arial, geneva, helvetica" size=1 color=#000000><strong>
										<? echo $row_sub['nombre'];?>
								  </strong></font>							  </td>
								  
							<? if ($jj==2){ echo "</tr><tr>";$jj=1;}else{$jj++;}?>
							<? }?>
						<? }?>
						<? }?></tr>
						</table>
					</td></tr>
            <TR> 
              <TD height="15" colspan="4">&nbsp;</TD>
            </TR>
			<?php 	$sql_tit="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=1 order by orden"; 
					$res_tit = pg_exec($conn, $sql_tit);
					$cant_tit = pg_numrows($res_tit);
			?>

            <TR> 
              <TD colspan="2"><font face="arial, geneva, helvetica" size=1 color=#000000><strong>TITULOS</strong></font></TD>
              <TD width="221"><strong><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">INSTITUCION</font></strong></TD>
              <TD><strong><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O</font></strong></TD>
            </TR>
            <TR> 
              <TD colspan="2"> 
			  <?php $row_tit_0 = @pg_fetch_array($res_tit,0); 
			 
			  ?>
                <?php if($frmModo=="ingresar"){ ?>
                <input type="text" name="txtTITULO[1]" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_tit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_0['nombre']);
					};
				}//fin if($row_tit_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtTITULO[1]" size=50 maxlength=1000 value="<?php echo trim($row_tit_0['nombre'])?>"> 
                <?php };?>
              </TD>
              
			  <TD><?php 
			  
			  if($frmModo=="ingresar"){ ?>
			    <input name="institucion[1]" type="text" id="institucion1">
			  <?php };?>
			  <?php if($row_tit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_0['institucion']);
					};
				}//fin if($row_tit_0!=""){?>
				<?php if($frmModo=="modificar"){ ?>
				<input name="institucion[1]" type="text" id="institucion1" value="<?php echo trim($row_tit_0['institucion'])?>">
			  <?php };?></TD>
			  
              <TD>
			  <?php 
			  
			  if($frmModo=="ingresar"){ ?>
			    <input name="año[1]" type="text" id="a&ntilde;o1" size="5" maxlength="4">
			  <?php };?>
			  <?php if($row_tit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_0['ano']);
					};
				}//fin if($row_tit_0!=""){?>
				<?php if($frmModo=="modificar"){ ?>
			    <input name="año[1]" type="text" id="a&ntilde;o1" size="5" maxlength="4" value="<?php echo trim($row_tit_0['ano'])?>">
				<?php };?>
			  </TD>
            </TR>
            <TR> 
              <TD colspan="2"> 
			  <?php $row_tit_1 = @pg_fetch_array($res_tit,1); ?>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input type="text" name="txtTITULO[2]" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_tit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_1['nombre']);
					};
				}//fin if($row_tit_1!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtTITULO[2]" size=50 maxlength=1000 value="<?php echo trim($row_tit_1['nombre'])?>"> 
                <?php };
				?>
              </TD>
              <TD>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="institucion[2]" type="text" id="institucion2">
                <?php };?>
                <?php if($row_tit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_1['institucion']);
					};
				}//fin if($row_tit_1!=""){)?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="institucion[2]" type="text" id="institucion2" value="<?php echo trim($row_tit_1['institucion'])?>">
                <?php };?>
              </TD>
              <TD>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="a&ntilde;o[2]" type="text" id="a&ntilde;o2" size="5" maxlength="4">
                <?php };?>
                <?php if($row_tit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_1['ano']);
					};
				}//fin if($row_tit_1!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="a&ntilde;o[2]" type="text" id="a&ntilde;o2" size="5" maxlength="4" value="<?php echo trim($row_tit_1['ano'])?>">
                <?php };?>
              </TD>
            </TR>
            <TR> 
              <TD colspan="2"> 
			  <?php 
			  
			  $row_tit_2 = @pg_fetch_array($res_tit,2); ?>
                <?php if($frmModo=="ingresar"){ ?>
                <input type="text" name="txtTITULO[3]" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_tit_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_2['nombre']);
					};
				}//fin if($row_tit_2!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtTITULO[3]" size=50 maxlength=1000 value="<?php echo trim($row_tit_2['nombre'])?>"> 
                <?php };
				?>
              </TD>
              <TD> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="institucion[3]" type="text" id="institucion3">
                <?php };?>
                <?php if($row_tit_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_2['institucion']);
					};
				}//fin if($row_tit_2!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="institucion[3]" type="text" id="institucion3" value="<?php echo trim($row_tit_2['institucion'])?>">
                <?php };?>
              </TD>
              <TD>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="año[3]" type="text" id="a&ntilde;o3" size="5" maxlength="4">
                <?php };?>
                <?php if($row_tit_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_tit_2['ano']);
					};
				}//fin if($row_tit_2!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="año[3]" type="text" id="a&ntilde;o3" value="<?php echo trim($row_tit_2['ano'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
            </TR>
			
            <TR> 
              <TD colspan="4">&nbsp;</TD>
            </TR>
			<?php 	$sql_postit="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=2 order by orden"; 
					$res_postit = @pg_exec($conn, $sql_postit);
					$cant_postit = @pg_numrows($res_postit);

			?>
            <TR> 
              <TD colspan="4"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">POSTITULOS</font></TD>
            </TR>
            <TR> 
              <TD colspan="4"> 
			  <?php $row_postit_0 = @pg_fetch_array($res_postit,0); ?>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="txtPOSTITULO[1]" type="text" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_postit_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_postit_0['nombre']);
					};
				}//fin if($row_postit_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtPOSTITULO[1]" size=50 maxlength=1000 value="<?php echo trim($row_postit_0['nombre'])?>"> 
                <?php };?>
                &nbsp;</TD>
            </TR>
            <TR> 
              <TD colspan="4"> 
			  <?php $row_postit_1 = @pg_fetch_array($res_postit,1); ?>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="txtPOSTITULO[2]" type="text" size=50 maxlength=1000>
                <?php };?>
                <?php if($row_postit_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_postit_1['nombre']);
					};
				}//fin if($row_postit_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtPOSTITULO[2]" size=50 maxlength=1000 value="<?php echo trim($row_postit_1['nombre'])?>"> 
                <?php };?>
                &nbsp;</TD>
            </TR>
			

            <TR> 
              <TD colspan="4">&nbsp;</TD>
            </TR>
			<?php 	$sql_posgra="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=3 order by orden"; 
					$res_posgra = @pg_exec($conn, $sql_posgra);
					$cant_posgra = @pg_numrows($res_posgra);
					
			?>

            <TR> 
              <TD colspan="4"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">POSTGRADOS</font></TD>
            </TR>
            <TR> 
              <TD colspan="4"> 
			  <?php $row_posgra_0 = @pg_fetch_array($res_posgra,0); ?>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="txtPOSTGRADO[1]" type="text" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_posgra_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_posgra_0['nombre']);
					};
				}//fin if($row_posgra_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtPOSTGRADO[1]" size=50 maxlength=1000 value="<?php echo trim($row_posgra_0['nombre'])?>"> 
                <?php };?>
                &nbsp;&nbsp;</TD>
            </TR>
            <TR> 
              <TD colspan="4"> 
			  <?php $row_posgra_1 = @pg_fetch_array($res_posgra,1); ?>
                <?php
				
				 if($frmModo=="ingresar"){ ?>
                <input name="txtPOSTGRADO[2]" type="text" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_posgra_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_posgra_1['nombre']);
					};
				}//fin if($row_posgra_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtPOSTGRADO[2]" size=50 maxlength=1000 value="<?php echo trim($row_posgra_1['nombre'])?>"> 
                <?php };?>
                &nbsp;&nbsp;</TD>
            </TR>

            <TR> 
              <TD colspan="4">&nbsp;</TD>
            </TR>
			<?php 	$sql_cu="SELECT * FROM empleado_estudios WHERE rut_empleado='".$empleado."' AND tipo=4 order by orden"; 
					$res_cu = @pg_exec($conn, $sql_cu);
					$cant_cu = @pg_numrows($res_cu);

			?>

            <TR> 
              <TD colspan="2"><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">CURSOS 
                RECONOCIDOS</font></TD>
              <TD><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">A&Ntilde;O</font></TD>
              <TD><font color="#000000" size="1" face="Arial, Helvetica, sans-serif">HORAS</font></TD>
            </TR>

            <TR> 
              <TD colspan="2"> 
			  <?php $row_cu_0 = @pg_fetch_array($res_cu,0); ?>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="txtCURSO[1]" type="text" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_cu_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_0['nombre']);
					};
				}//fin row_cu_0?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtCURSO[1]" size=50 maxlength=1000 value="<?php echo trim($row_cu_0['nombre'])?>"> 
                <?php };?>
                &nbsp;&nbsp;&nbsp;</TD>
              <TD valign="top"> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="a&ntilde;o_curso[1]" type="text" id="a&ntilde;o_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_0['ano']);
					};
				}//fin if($row_cu_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="año_curso[1]" type="text" id="a&ntilde;o_curso[1]" value="<?php echo trim($row_cu_0['ano'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
              <TD valign="top"> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="horas_curso[1]" type="text" id="horas_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_0!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_0['horas']);
					};
				}//fin if($row_cu_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="horas_curso[1]" type="text" id="horas_curso1" value="<?php echo trim($row_cu_0['horas'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
            </TR>
            <TR> 
              <TD colspan="2"> 
                <?php $row_cu_1 = @pg_fetch_array($res_cu,1); ?>
				<?php 
				
				if($frmModo=="ingresar"){ ?>
			  
                <input name="txtCURSO[2]" type="text" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_cu_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_1['nombre']);
					};
				}//fin if($row_cu_0!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtCURSO[2]" size=50 maxlength=1000 value="<?php echo trim($row_cu_1['nombre'])?>"> 
                <?php };?>
                &nbsp;&nbsp;&nbsp;</TD>
              <TD valign="top"> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="año_curso[2]" type="text" id="a&ntilde;o_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_1['ano']);
					};
				}//fin if($row_cu_1!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="año_curso[2]" type="text" id="a&ntilde;o_curso1" value="<?php echo trim($row_cu_1['ano'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
              <TD valign="top"> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="horas_curso[2]" type="text" id="horas_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_1!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_1['horas']);
					};
				}//fin if($row_cu_1!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="horas_curso[2]" type="text" id="horas_curso1" value="<?php echo trim($row_cu_1['horas'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
            </TR>
            <TR> 
              <TD colspan="2">
			  <?php $row_cu_2 = @pg_fetch_array($res_cu,2); ?>
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input type="text" name="txtCURSO[3]" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_cu_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_2['nombre']);
					};
				}//fin if($row_cu_1!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtCURSO[3]" size=50 maxlength=1000 value="<?php echo trim($row_cu_2['nombre'])?>"> 
                <?php };?>
                &nbsp;&nbsp;&nbsp;&nbsp;</TD>
              <TD valign="top"> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="año_curso[3]" type="text" id="a&ntilde;o_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_2['ano']);
					};
				}//fin if($row_cu_2!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="año_curso[3]" type="text" id="a&ntilde;o_curso1" value="<?php echo trim($row_cu_2['ano'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
              <TD valign="top"> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input name="horas_curso[3]" type="text" id="horas_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_2!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_2['horas']);
					};
				}//fin if($row_cu_2!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="horas_curso[3]" type="text" id="horas_curso1" value="<?php echo trim($row_cu_2['horas'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
            </TR>
            <TR> 
              <TD colspan="2">
  			  <?php $row_cu_3 = @pg_fetch_array($res_cu,3); ?> 
                <?php 
				
				if($frmModo=="ingresar"){ ?>
                <input type="text" name="txtCURSO[4]" size=50 maxlength=1000> 
                <?php };?>
                <?php if($row_cu_3!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_3['nombre']);
					};
				}//fin if($row_cu_3!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input type="text" name="txtCURSO[4]" size=50 maxlength=1000 value="<?php echo trim($row_cu_3['nombre'])?>"> 
                <?php };?>
                &nbsp;&nbsp;&nbsp;&nbsp;</TD>
              <TD valign="top"> 
                <?php 
				if($frmModo=="ingresar"){ ?>
                <input name="año_curso[4]" type="text" id="a&ntilde;o_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_3!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_3['ano']);
					};
				}//fin if($row_cu_3!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="año_curso[4]" type="text" id="a&ntilde;o_curso1" value="<?php echo trim($row_cu_3['ano'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
              <TD valign="top"> 
                <?php
				 
				if($frmModo=="ingresar"){ ?>
                <input name="horas_curso[4]" type="text" id="horas_curso1" size="5" maxlength="4">
                <?php };?>
                <?php if($row_cu_3!=""){
					if($frmModo=="mostrar"){ 
						imp($row_cu_3['horas']);
					};
				}//fin if($row_cu_3!=""){?>
                <?php if($frmModo=="modificar"){ ?>
                <input name="horas_curso[4]" type="text" id="horas_curso1" value="<?php echo trim($row_cu_3['horas'])?>" size="5" maxlength="4">
                <?php };?>
              </TD>
            </TR>

            <TR> 
              <TD colspan="4">&nbsp;</TD>
            </TR>
            <TR> 
              <TD colspan="4">&nbsp;</TD>
            </TR>
              <TD colspan="4"><font face="arial, geneva, helvetica" size=1 color=#000000>RESUMEN 
                DE ESTUDIOS</font></TD>
            </TR>
            <TR> 
              <TD colspan="4"> 
                <?php if($frmModo=="ingresar"){ ?>
                <textarea name="txtESTUDIOS" cols="60" rows="3"></textarea> 
                <?php };?>
                <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['estudios']);
												};
											?>
                <?php if($frmModo=="modificar"){ ?>
                <textarea name="txtESTUDIOS" cols="60" rows="3"> <?php echo trim($fila['estudios'])?></textarea> 
                <?php };?>
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
																	if($frmModo=="mostrar"){ 
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
															
                      <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <STRONG>NRO</STRONG> 
                        <?php 
																						if($frmModo=="mostrar"){
																						 
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$fila['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																						};
																					?>
                        </FONT> </TD>
														</TR>
														<TR>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	
                        <INPUT type="text" name=txtNRO size=10 maxlength=5>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
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
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($fila['depto']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtDEP size=12 maxlength=10 value="<?php echo $fila['depto']?>" >
																<?php };?>
															</TD>
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtBLO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
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
															<TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtVIL size=34 maxlength=50>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
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
														<INPUT type="hidden" name=txtREG value=<?php echo trim($regINS)?> >
														<INPUT type="hidden" name=txtCIU value=<?php echo trim($proINS)?> >
														<INPUT type="hidden" name=txtCOM value=<?php echo trim($comINS)?> >
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
																	imp($filaREG['nom_reg']);
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
										
        <TD> <hr width="100%" color=#003b85></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD width="100%" colspan=2>
								<?php if($frmModo=="mostrar"){?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)&&($_PERFIL!=6)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=22)){ //ACADEMICO Y LEGAL?>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ACCESO WEB" onClick=document.location="usuario/usuario.php3">
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ANOTACIONES" onClick=document.location="anotacion/listarAnotacion.php3">
										<?php
											echo "<INPUT class='botonX' onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE=button value=FOTO onClick=window.open('frmFoto.php3?rut=",$empleado,"','CodigoProducto','height=200,width=380,scrollbar=no,location=no,resizable=no')			
											>";
										?>
									<?php }?>
								<?php }else{?>
										<!--INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ACCESO WEB" disabled>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="ANOTACIONES" disabled>
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="FOTO" disabled-->
								<?php }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>

</BODY>
</HTML>