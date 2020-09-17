<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$_POSP = 4;
	$_bot = 6;
?>

<SCRIPT language="JavaScript">
			function enviapagENS(form){
			if (form.cmbENS.value!=0){
				form.cmbENS.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'matriculaTP.php3?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
			function enviapagSEC(form){
			if (form.cmbSEC.value!=0){
				form.cmbSEC.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'matriculaTP.php3?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			
</script>

<?php 
	if($frmModo!="ingresar"){
	$qry="SELECT alumno.*, curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, date_part('day',matricula.fecha) AS day, date_part('month',matricula.fecha) AS month, date_part('year',matricula.fecha) AS year FROM (tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ON curso.id_curso = matricula.id_curso WHERE (((matricula.id_ano)=".$ano.") AND ((alumno.rut_alumno)='".$alumno."'))";
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
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

		<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		<?php include('../../../../util/rpc2.php3');?>
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
				
				if(!chkSelect(form.cmbENS,'Seleccionar ENSEÑAÑZA.')){
					return false;
				};
				
				if(!chkSelect(form.cmbSEC,'Seleccionar RAMA/SECTOR.')){
					return false;
				};
				
				if(!chkSelect(form.cmbESP,'Seleccionar ESPECIALIDAD.')){
					return false;
				};

				
				if(form.cmbNac.value==2){
					if(!chkVacio(form.txtDIGRUT,'Ingresar dígito verificador del RUT.')){
						return false;
					};
				}

				if(form.cmbNac.value==2){
					if(!chkCod(form.txtRUT,form.txtDIGRUT,'RUT inválido.')){
						return false;
					};
				}
				
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
	
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</HEAD>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
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
								  
								  
								  <!-- AQUÍ CODIGO ANTIGUO -->




	<FORM method=post name="frm" action="procesoMatriculaTP.php3">
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
												error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
														exit();
													}
													echo trim($fila1['nro_ano']);
												}
											}
								$qrySM="select * from (matriculatpsincurso inner join alumno on matriculatpsincurso.rut_alumno=alumno.rut_alumno) where matriculatpsincurso.id_ano=".$ano." and alumno.rut_alumno=".$alumno;//fila['rut_alumno'];
								$resultSM=@pg_Exec($conn,$qrySM);
								$filaSM = @pg_fetch_array($resultSM,0);
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
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarMatricula.php3">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
								<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
									<INPUT class="botonXX"  TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaMatriculaTP.php3?matricula=<?php echo $matricula?>&caso=3">&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaMatriculaTP.php3?caso=9">&nbsp;
											<?php }?>
								<?php }?>
									
          <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarMatricula.php3">
          &nbsp;
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<INPUT class="botonXX"  TYPE="submit" value="GUARDAR"   name=btnGuardar onClick="return valida(this.form);" >&nbsp;
									<INPUT class="botonXX"  TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaMatriculaTP.php3?alumno=<?php echo $alumno?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						
						<TR height=20>
							<TD align=middle colspan=2 class="tableindex">
								MATRICULA ALUMNO
							</TD>
						</TR>
                           <TR>
							<TD width=30></TD>
							<TD>
								<TABLE width="654" BORDER=0 CELLPADDING=2 CELLSPACING=2>
            <TR>
                                       <TD class="datos_campo"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                                          <STRONG>TIPO DE ENSENANZA</STRONG> </FONT> </TD>
									
                                       
              <TD > <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                <STRONG>RAMA / SECTOR</STRONG> </FONT> </TD>
									</TR>
										
									<TR>
										<TD width="417">
											<?php
											  if($frmModo=="ingresar"){   ?>
												<?php  if(($_PERFIL==14)||($_PERFIL==0)){ ?>
                                                        
                                                               <select name="cmbENS" onChange="enviapagENS(this.form);">
															   
																	<option value=0>Seleccione Tipo de Enseñanza</option>
																<?php													 
																		//$sqlENS="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from (tipo_ensenanza inner join tipo_ense_inst on tipo_ensenanza.cod_tipo=tipo_ense_inst.cod_tipo) where tipo_ense_inst.cod_decreto=".$cmbPLAN." and tipo_ense_inst.estado=0";
																		/*$sqlENS="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from (tipo_ensenanza inner join tipo_ense_inst on tipo_ensenanza.cod_tipo=tipo_ense_inst.cod_tipo) where tipo_ense_inst.cod_decreto=".$cmbPLAN." and tipo_ense_inst.estado=0 and tipo_ense_inst.rdb=".$institucion;*/
																		$sqlENS="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from (tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo) where tipo_ense_inst.rdb=".$institucion." and tipo_ensenanza.cod_tipo>310 and estado=0";
																		$resultENS= @pg_Exec($conn,$sqlENS);
																			for($i=0 ; $i < @pg_numrows($resultENS) ; $i++){
																				$filaENS = @pg_fetch_array($resultENS,$i);
																					if ($filaENS["cod_tipo"]==$cmbENS){
																						echo  "<option selected value=".$filaENS["cod_tipo"]." >".$filaENS["nombre_tipo"]."</option>";
																					}else{
																						echo  "<option value=".$filaENS["cod_tipo"]." >".$filaENS["nombre_tipo"]."</option>";
																					}
																								
																			}
																			
																	?>
																</select>
											<?php  };
                                                  };  ?>
												  <?php 
												 $qryENS="select * from tipo_ensenanza where cod_tipo=".$filaSM['cod_tipo'];
												 $resultENS=@pg_Exec($conn,$qryENS);
												 $filaENS=@pg_fetch_array($resultENS,0);
														
														if($frmModo=="mostrar"){
														//$qry="select * from enseñanza where cod_tipo=".$filaSM['cod_tipo'];
															imp($filaENS['nombre_tipo']);
														};
											
											
															if($frmModo=="modificar"){ ?>
															
													<Select name="cmbENS" onChange="enviapagENS(this.form);">
													<option value=0></option>;
													<?php
														
														$qryE="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from (tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo) where tipo_ense_inst.rdb=".$institucion." and tipo_ensenanza.cod_tipo>310 and estado=0";
														$resultE =@pg_Exec($conn,$qryE);
														if (!$resultE) 
															error('<B> ERROR :</b>Error al acceder a la BD. (21)</B>');
														else{
															if (pg_numrows($resultE)!=0){
																$filaE = @pg_fetch_array($resultE,0);	
																if (!$filaE){
																	error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($resultE) ; $i++){
																	$filaE = @pg_fetch_array($resultE,$i);
																	if($filaE["cod_tipo"]==$filaENS["cod_tipo"] or $filaE["cod_tipo"]==$cmbENS){
																		echo "<option  selected value=".$filaE["cod_tipo"]."> ".$filaE["nombre_tipo"]."</option>\n";
																	}else{
																		echo "<option value=".$filaE["cod_tipo"].">".$filaE["nombre_tipo"]."</option>\n";
																	}
																}
															}
														};
													?>
												</Select>
											<?php } ?>
                                                        
										</TD>
										<TD width="319">
											<?php 
											/*if ($cmbENS){
													$qrySEC="select * from (sector_eco inner join rama on sector_eco.cod_rama=rama.cod_rama) where rama.cod_tipo=".$cmbENS." and sector_eco.cod_sector=".$filaSM["cod_sector"];
												}else{*/
												if (!$cmbSEC){
													$qrySEC="select * from (sector_eco inner join rama on sector_eco.cod_rama=rama.cod_rama) where rama.cod_tipo=".$filaSM['cod_tipo']." and sector_eco.cod_sector=".$filaSM["cod_sector"];
													$resultSEC=@pg_Exec($conn,$qrySEC);
													$filaSEC=@pg_fetch_array($resultSEC,0);
												}
												//}
											
											  if($frmModo=="ingresar"){   ?>
												<?php  if(($_PERFIL==14)||($_PERFIL==0)){
                                                            ?>
                                                    
	                                                 <select name="cmbSEC" onChange="enviapagSEC(this.form);">
															<option value=0>Seleccione Sector Economico</option>
														  <?php  
																$sqlSEC="select * from (sector_eco inner join rama on sector_eco.cod_rama=rama.cod_rama) where rama.cod_tipo=".$cmbENS;
																$resultSEC= @pg_Exec($conn,$sqlSEC);
																	for($i=0 ; $i < @pg_numrows($resultSEC) ; $i++){
																		$filaSEC = @pg_fetch_array($resultSEC,$i);
																			if ($filaSEC["cod_sector"]==$cmbSEC){
																				echo  "<option selected value=".$filaSEC["cod_sector"]." >".$filaSEC["nombre_sector"]."</option>";
																			}else{
																				echo  "<option value=".$filaSEC["cod_sector"]." >".$filaSEC["nombre_sector"]."</option>";
																			}
																		$rama=$filaSEC["cod_rama"];		
																	}
															?>
														</select>
                                                   <?php }
  										            	}  
											
													if($frmModo=="mostrar"){ 
													imp($filaSEC['nombre_sector']);
												};
												
												if ($frmModo=="modificar"){?>
												<select name="cmbSEC" onChange="enviapagSEC(this.form);">
													<option value=0></option>
												<?php
												if (!$cmbENS)	{
													$sqlS="select * from (sector_eco inner join rama on sector_eco.cod_rama=rama.cod_rama) where rama.cod_tipo=".$filaSM['cod_tipo'];
												}else{
													$sqlS="select * from (sector_eco inner join rama on sector_eco.cod_rama=rama.cod_rama) where rama.cod_tipo=".$cmbENS;
													}
													$resultS= @pg_Exec($conn,$sqlS);
														for($i=0 ; $i < @pg_numrows($resultS) ; $i++){
															$filaS = @pg_fetch_array($resultS,$i);
																if ($filaS["cod_sector"]==$filaSEC["cod_sector"] or $filaS["cod_sector"]==$cmbSEC){
																	echo  "<option selected value=".$filaS["cod_sector"]." >".$filaS["nombre_sector"]."</option>";
																	}else{
																	echo  "<option value=".$filaS["cod_sector"]." >".$filaS["nombre_sector"]."</option>";
																	}
																$rama=$filaS["cod_rama"];		
															}
												 } ?>
												</select>
												
													     </TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
                              <TR>
							<TD width=30></TD>
							<TD>
								<TABLE width="300" BORDER=0 CELLPADDING=2 CELLSPACING=2>
            <TR> 
              <TD > <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                <strong>ESPECIALIDAD</strong> </FONT> </TD>
            </TR>
            <TR> 
              <TD width="117"> 
                <?php if($frmModo=="ingresar"){ ?>
                <?php  if(($_PERFIL==14)||($_PERFIL==0)){
                                                            ?>
                <select name="cmbESP">
                  <option value=0>Seleccione Especialidad</option>
                  <?php 
																$sqlESP="select * from especialidad where cod_sector =".$cmbSEC." and cod_rama=".$rama;
																$resultESP= @pg_Exec($conn,$sqlESP);
																	for($i=0 ; $i < @pg_numrows($resultESP) ; $i++){
																		$filaESP = @pg_fetch_array($resultESP,$i);
																			if ($filaESP["cod_esp"]==$cmbESP){
																				echo  "<option selected value=".$filaESP["cod_esp"]." >".$filaESP["nombre_esp"]."</option>";
																			}else{
																				echo  "<option value=".$filaESP["cod_esp"]." >".$filaESP["nombre_esp"]."</option>";
																			}
																	}
															?>
                </select> 
                <?php
                                                        };
                                                       }
												$qryESP="select * from especialidad where cod_sector =".$filaSM['cod_sector']." and cod_rama=".$filaSEC['cod_rama']." and cod_esp=".$filaSM['cod_esp'];
												$resultESP=@pg_Exec($conn,$qryESP);
												$filaESP=@pg_fetch_array($resultESP,0);
												
												if($frmModo=="mostrar"){
													imp($filaESP['nombre_esp']);
												};
												
												if ($frmModo=="modificar"){?>
													<select name="cmbESP">
    								        	      <option value=0>Seleccione Especialidad</option>
                  							<?php 
											if (!$cmbSEC){
													$sqlES="select * from especialidad where cod_sector =".$filaSM['cod_sector']." and cod_rama=".$rama;
												}else{
													$sqlES="select * from especialidad where cod_sector =".$cmbSEC." and cod_rama=".$rama;
												}
												$resultES= @pg_Exec($conn,$sqlES);
													for($i=0 ; $i < @pg_numrows($resultES) ; $i++){
														$filaES = @pg_fetch_array($resultES,$i);
															if ($filaES["cod_esp"]==$filaESP["cod_esp"]){
																echo  "<option selected value=".$filaES["cod_esp"]." >".$filaES["nombre_esp"]."</option>";
															}else{
																echo  "<option value=".$filaES["cod_esp"]." >".$filaES["nombre_esp"]."</option>";
															}
													}
												}
															?>
               										 </select>
												
              </TD>
            </TR>
          </TABLE>
							            </TD>
						           </TR>
						      <TR>
							<TD width=30></TD>
							<TD>
								<TABLE width="300" BORDER=0 CELLPADDING=2 CELLSPACING=2>
            <TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>RUT</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD width="79">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtRUT size=10 maxlength=10 onChange="checkRutField(this);">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp($filaSM['rut_alumno']);
												};
												
												if ($frmModo=="modificar"){
													imp($filaSM['rut_alumno']);?>
													<INPUT  type="hidden" name=txtRUT size=10 maxlength=10 value="<?php echo($filaSM['rut_alumno']);?>" onChange="checkRutField(this);">
												<?php }	?>
										</TD>
										<TD width="34">&nbsp;-&nbsp;</TD>
										<TD width="167">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtDIGRUT size=1 maxlength=1 >
											<?php };?>
											<?php 
												if(($frmModo=="mostrar")||($frmModo=="modificar")){ 
													imp($filaSM['dig_rut']);
												};
											?>
										</TD>
									</TR>
								</TABLE>
								
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE width="557" BORDER=0 CELLPADDING=2 CELLSPACING=2>
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
													imp($filaSM['nombre_alu']);
												}
																								
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtNOMBRE size=25 maxlength=50 value="<?php echo ($filaSM['nombre_alu']);?>">
												<?php }; ?>
											
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name=txtAPEPAT size=25 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){
													imp($filaSM['ape_pat']);
												}
												
												if($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtAPEPAT size=25 maxlength=50 value="<?php echo ($filaSM['ape_pat']);?>">
												<?php }; ?>
											
										</TD>
										
              <TD> 
                <?php if($frmModo=="ingresar"){ ?>
                	<input type="text" name=txtAPEMAT size=25 maxlength=50> 
                <?php };?>
                <?php 
					if($frmModo=="mostrar"){
						imp($filaSM['ape_mat']);
					}
					
					if($frmModo=="modificar"){ ?>
						<INPUT type="text" name=txtAPEMAT size=25 maxlength=50 value="<?php echo ($filaSM['ape_mat']);?>">
					<?php };?>
											
              </TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD align=LEFT>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=97%>
									<TR>
										<TD width="37%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA<BR>NACIMIENTO</STRONG>
											</FONT>
										</TD>
										<TD width="33%">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>SEXO</STRONG>
											</FONT>
										</TD>
										<TD width="30%">
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
												if($frmModo=="mostrar"){
													impF($filaSM['fecha_nac']);
												}
												
												if ($frmModo=="modificar"){ ?>
													<INPUT type="text" name=txtNAC size=10 maxlength=10 value="<?php impF($filaSM['fecha_nac']);?>" onChange="chkFecha(form.txtNAC,'Fecha nacimiento  invalida.');">
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
												if($frmModo=="mostrar"){ 
													switch ($filaSM['sexo']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 1:
															 imp('Femenino');
															 break;
														 case 2:
															 imp('Masculino');
															 break;
													 };
												};
										
											if ($frmModo=="modificar"){?>
													<Select name="cmbSEXO" >
														<?php if ($filaSM['sexo']==0){?>
															<option value=0 selected>Indeterminado</option>
														<?php }else{ ?>
															<option value=0>Indeterminado</option>
														<?php }if ($filaSM['sexo']==1){?>
															<option value=1 selected>Femenino</option>
														<?php }else{ ?>
															<option value=1>Femenino</option>
														<?php }if ($filaSM['sexo']==2){?>
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
												</select>
											<?php }; ?>
											<?php if ($frmModo=="mostrar"){ 
														switch ($filaSM['nacionalidad']){
															case 0:
																imp('INDETERMINADO');
																break;
															case 1:
																imp('Extranjera');
																break;
															case 2:
																imp('Chilena');
																break;
														};
												  };?> 
												 
										<?php if ($frmModo=="modificar"){?>
												<Select name="cmbNac">
													<?php if ($filaSM['nacionalidad']==0){?>
														<option value=0 selected>Indeterminada</option>
													<?php }else{?>
														<option value=0></option>
													<?php }if ($filaSM['nacionalidad']==1){?>
														<option value=1 selected>Extranjera</option>
													<?php }else{?>
														<option value=1>Extranjera</option>
													<?php }if ($filaSM['nacionalidad']==2){?>
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
										<TD width="37%">
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD width="192">
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
															if($frmModo=="mostrar"){
																imp($filaSM['telefono']);
															}
															if($frmModo=="modificar"){ ?>
																<INPUT type="text" name=txtTELEF value="<?php echo ($filaSM['telefono']);?>" size=20 maxlength=30>
															<?php } ?>
														
													</TD>
												</TR>
											</TABLE>
										</TD>
										<TD width="63%">
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
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
															if($frmModo=="mostrar"){ 
																imp($filaSM['email']);
															};
															
															if($frmModo=="modificar"){?>
																<INPUT type="text" name=txtEMAIL size=40 value="<?php echo ($filaSM['email']);?>" maxlength=50>
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
							<TD align=LEFT>
								<TABLE bgcolor=White BORDER=0 CELLSPACING=2 CELLPADDING=0 WIDTH=100%>
									<TR align=LEFT>
										<TD>
											<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													
													
													<TD width="428">
														<FONT face="arial, geneva, helvetica" size=1 color=#000000>
															<STRONG>FECHA MATRICULA</STRONG>
														</FONT>
													</TD>
												</TR>
												<TR>
													
													
								<?php	//*************** MODIFICACION 07-02-2003 ********************** 
											//----------- Agregar campo Fecha Matricula --------------------	?>
													<TD>
													<?php if($frmModo=="ingresar"){ ?>
															<INPUT TYPE="text" NAME="FechaMatric" value="" size="10" onChange="chkFecha(form.FechaMatric,'Fecha Matricula invalida.');">
															
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(DD-MM-AAAA)</STRONG>
															</FONT>
													<?php	}; ?>
													<?php if($frmModo=="mostrar"){ 
																impF($filaSM['fecha']);
															/*$Dia = Trim($filaSM['day']);
															if (strlen($Dia)==1){ $Dia = "0" . $Dia; };
															$Mes = Trim($filaSM['month']);
															if (strlen($Mes)==1){ $Mes = "0" . $Mes; };
															$Ano = Trim($filaSM['year']);
															if ($Dia!="" && $Mes!="" && $Ano!="" && $Ano!="0"){
																echo($Dia . "-" . $Mes . "-" . $Ano);
															}else{ 
																echo(" "); 
															};*/
														  }; ?>
													<?php if ($frmModo=="modificar"){ ?>
															<INPUT type="text" name=FechaMatric size=10 maxlength=10 value="<?php impF($filaSM['fecha']);?>" onChange="chkFecha(form.FechaMatric,'Fecha Matricula invalida.');">
															
															<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																<STRONG>(DD-MM-AAAA)</STRONG>
															</FONT>
													<?php }; ?>
													</TD>
								<?php	//***************** FIN MODIFICACION *************************** ?>
												</TR>
											</TABLE>
										</TD>
									</TR>
                                      <TR>
                                          <TD>
                                             <TABLE width="557" BORDER=0 CELLPADDING=2 CELLSPACING=2>
									<TR>
										<TD width=262 valign="top">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>INTEGRADO</STRONG>
											</FONT>
										</TD>
										<TD width=650 valign="top">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>ALUMNO DE ORIGEN INDIGENA</STRONG>
											</FONT>
										</TD>
										
									</TR>
									<TR>
										<TD height="20">
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=int size=83 maxlength=50 >
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaSM['integrado']==0)?"NO":"SI");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name=int size=83 maxlength=50 value=1 
											<?php 
											  echo ($filaSM['integrado']==1)?"checked":"";
											?>>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=aoi size=83 maxlength=50>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaSM['indigena']==0)?"NO":"SI");
													
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
													<INPUT type="checkbox" name=aoi size=83 maxlength=50	value=1 <?php echo ($filaSM['indigena']==1)? "checked":"" ?>>
											<?php };?>
										</TD>
										
									</TR>
								</TABLE>
                                          </TD>
                                       </TR>
                                          <TR>
                                          <TD>
                                             <TABLE width="557" BORDER=0 CELLPADDING=2 CELLSPACING=2>
									<TR>
										
                                            <TD width=207 valign="top"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                                                  <strong>EN PRACTICA</strong> </FONT> </TD>
										<TD width=207 valign="top">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>EGRESADO</STRONG>
											</FONT>
										</TD>
										   <TD width=249 valign="top">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>TITULADO</STRONG>
											</FONT>
										</TD>
                                           <TD width=298 valign="top">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>CODIGO DEL TITULO</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD height="22">
											<?php if($frmModo=="ingresar"){ ?>
												<input name="enP" type="radio" value="1">
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaSM['estado']==1)?"SI":"NO");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<input name="enP" type="radio" value=1
                                               <?php echo ($filaSM['estado']==1)?"checked":"";?> >
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input name="enP" type="radio" value="2">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaSM['estado']==2)?"SI":"NO");
													
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
													<input name="enP" type="radio" value=2
                                                   <?php echo ($filaSM['estado']==2)? "checked":"" ?> >
											<?php };?>
										</TD>
										     <TD>
											<?php if($frmModo=="ingresar"){ ?>
												<input name="enP" type="radio" value="3">
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($filaSM['estado']==3)?"SI":"NO");
													
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
													<input name="enP" type="radio" value=3
                                                     <?php echo ($filaSM['estado']==3)? "checked":"" ?>>
											<?php };?>
										</TD>
                                                <TD>
																<?php if($frmModo=="ingresar"){ ?>
																	<INPUT type="text" name=txtTITULO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($filaSM['titulo']);
																	};
																?>
																<?php if($frmModo=="modificar"){ ?>
																	<INPUT type="text" name=txtTITULO size=12 maxlength=5 value="<?php echo ($filaSM['titulo']);?>" >
																<?php };?>
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
							<TD>
								<TABLE width=520 bgcolor=#cccccc height=99 Border=0 cellpadding=1 cellspacing=0>
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
																		imp($filaSM['calle']);
																	};
																 
																	if($frmModo=="modificar"){ ?>
																		<INPUT type="text" name=txtCALLE size=35 value="<?php echo ($filaSM['calle']);?>" maxlength=50>
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
																	if($frmModo=="mostrar"){ 
																		imp($filaSM['nro']);
																	};
																
																	if($frmModo=="modificar"){ ?>
																		<INPUT type="text" name=txtNRO size=10  maxlength=5 value="<?php echo ($filaSM['nro']);?>">
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
															<TD width="54%">
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>DEPTO</STRONG>
																</FONT>
															</TD>
															<TD width="46%">
																<FONT face="arial, geneva, helvetica" size=1 color=#000000>
																	<STRONG>BLOCK</STRONG>
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
																		imp($filaSM['depto']);
																	};
																 
																	if($frmModo=="modificar"){ ?>
																		<INPUT type="text" name=txtDEP size=12 maxlength=10 value="<?php echo ($filaSM['depto']);?>">
																	<?php }; ?>
															</TD>
															<TD>
																<?php if($frmModo=="ingresar"){?>
																			<INPUT type="text" name=txtBLO size=12 maxlength=10>
																<?php };?>
																<?php 
																	if($frmModo=="mostrar"){ 
																		imp($filaSM['block']);
																	};
																
																	if($frmModo=="modificar"){?>
																		<INPUT type="text" name=txtBLO value="<?php echo ($filaSM['block']);?>" size=12 maxlength=10>
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
																	<STRONG>VILLA/POBL</STRONG>
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
																		imp($filaSM['villa']);
																	};
																?>
																<?php 
																	if($frmModo=="modificar"){ ?>
																		<INPUT type="text" name=txtVIL value="<?php echo ($filaSM['villa']);?>" size=34 maxlength=50>
																	<?php };?>
																
															</TD>
														</TR>
													</TABLE>
													</TD>
													</TR>

													<?php if($frmModo=="modificar"){ ?>
														<INPUT type="hidden" name=txtREG value=<?php echo $filaSM['region']?>>
														<INPUT type="hidden" name=txtCIU value=<?php echo $filaSM['ciudad']?>>
														<INPUT type="hidden" name=txtCOM value=<?php echo $filaSM['comuna']?>>
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
																	$qryREG		="SELECT * FROM REGION WHERE COD_REG=".$filaSM['region'];
																	$resultREG	=@pg_Exec($conn,$qryREG);
																	$filaREG	= @pg_fetch_array($resultREG,0);
																	imp($filaREG['nom_reg']);
																						};
																					?>
			<?php if($frmModo=="modificar"){ ?>
				<!--INPUT type="text" name=txtREG size=20 value="<?php echo $filaSM['region']?>"-->


<FORM method=post name=f1 onSubmit="return false;">
	<SELECT class=saveHistory id=m1 name=m1 onChange="relate(this.form,0,this.selectedIndex);document.frm.txtREG.value=document.f1.m1.value;">
	<?php
		//SELECCIONAR TODAS LAS REGIONES
		$qryREG		="SELECT * FROM REGION ORDER BY COD_REG ASC";
		$resultREG	=@pg_Exec($connRPC,$qryREG);
		for($i=0 ; $i < @pg_numrows($resultREG) ; $i++){
			$filaREG = @pg_fetch_array($resultREG,$i);
			if($filaREG['cod_reg']==$filaSM['region'])
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
										$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$filaSM['region']." AND COR_PRO=".$filaSM['ciudad'];
										$resultPRO	=@pg_Exec($conn,$qryPRO);
										$filaPRO	= @pg_fetch_array($resultPRO,0);
										imp($filaPRO['nom_pro']);
																						};
																					?>
<?php if($frmModo=="modificar"){ ?>
	<!--INPUT type="text" name=txtCIU size=20 value=<?php echo $filaSM['ciudad']?>-->

<FORM method=post name=f2 onSubmit="return false;">
	<SELECT class=saveHistory id=m2 name=m2 onChange="relate2(this.form,0,this.selectedIndex,0);document.frm.txtCIU.value=document.f2.m2.value;"> 
	<?php
		//SELECCIONAR TODAS LAS PROVINCIAS
		$qryPRO		="SELECT * FROM PROVINCIA WHERE COD_REG=".$filaSM['region']." ORDER BY NOM_PRO ASC";
		$resultPRO	=@pg_Exec($connRPC,$qryPRO);
		for($i=0 ; $i < @pg_numrows($resultPRO) ; $i++){
			$filaPRO = @pg_fetch_array($resultPRO,$i);
			if($filaPRO['cor_pro']==$filaSM['ciudad'])
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
			$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$filaSM['region']." AND COR_PRO=".$filaSM['ciudad']." AND COR_COM=".$filaSM['comuna'];
			$resultCOM	=@pg_Exec($conn,$qryCOM);
			$filaCOM	= @pg_fetch_array($resultCOM,0);
			imp($filaCOM['nom_com']);
																						};
																					?>
																					<?php if($frmModo=="modificar"){ ?>
											<!--INPUT type="text" name=txtCOM size=20 value=<?php echo $filaSM['comuna']?>-->

<FORM method=post name=f3 onSubmit="return false;">
	<SELECT class=saveHistory id=m3 name=m3 onChange="document.frm.txtCOM.value=document.f3.m3.value;"> 
	<?php
		//SELECCIONAR TODAS LAS COMUNAS
		$qryCOM		="SELECT * FROM COMUNA WHERE COD_REG=".$filaSM['region']." AND COR_PRO=".$filaSM['ciudad']." ORDER BY NOM_COM ASC";
		$resultCOM	=@pg_Exec($connRPC,$qryCOM);
		for($i=0 ; $i < @pg_numrows($resultCOM) ; $i++){
			$filaCOM = @pg_fetch_array($resultCOM,$i);
			if($filaCOM['cor_com']==$filaSM['comuna'])
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
	
	
	
	
					
						<TR height=15>
							<TD width="100%" colspan=4>
								<?php if($frmModo=="mostrar"){?>
									<?php }else{?>
									<!--INPUT TYPE="button" value="CERTIFICADO" disabled-->
								<?php  }?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			
			
			
		</TABLE>
	</FORM>
	
	<!-- FIN CODIGO ANTIGUO -->
	
  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
