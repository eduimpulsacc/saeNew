<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	
?>


<HTML>
  <HEAD>
		<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
		
						<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>

<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		

	<?php if($_TIPOINSTIT==1){//COLEGIO?>
		<SCRIPT language="JavaScript">
			function chkENS(form){
				tipo=form.cmbENS.value;
				if((tipo==10)||(tipo==20)||(tipo==30)||(tipo==40)||(tipo==50)||(tipo==60)){//SALA CUNA MENOR A KINDER
					form.cmbEVAL.disabled=true;
					form.cmbPLAN.disabled=true;
					form.cmbEVAL.value=0;
					form.cmbPLAN.value=0;
					}else{
					form.cmbEVAL.disabled=false;
					form.cmbPLAN.disabled=false;
					form.cmbEVAL.selectedIndex=0;
					form.cmbPLAN.selectedIndex=0;
				};
			};
		</SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtGRA,'Ingresar GRADO del curso.')){
					return false;
				};
				if(!nroOnly(form.txtGRA,'Se permiten sólo números para el GRADO del curso.')){
					return false;
				};
				//if(!chkVacio(form.txtLETRA,'Ingresar LETRA del curso.')){
				//	return false;
				//};
				//if(!letraOnly(form.txtLETRA,'Se permiten sólo letras para la LETRA del curso.')){
				//	return false;
				//};
				if(!chkSelect(form.cmbENS,'Seleccionar TIPO DE ENSEÑANZA del curso.')){
					return false;
				};

				if(!form.cmbPLAN.disabled){
					if(!chkSelect(form.cmbPLAN,'Seleccionar DECRETO DE PLAN DE ESTUDIO del curso.')){
						return false;
					};
				};
				if(!form.cmbEVAL.disabled){
					if(!chkSelect(form.cmbEVAL,'Seleccionar DECRETO DE EVALUACION del curso.')){
						return false;
					};
				};

				if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
					return false;
				};
				//VALIDACION TIPO DE ENSEÑANZA
				/* if(form.cmbENS.value==110){
					if(form.txtGRA.value>8){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					}
				}else{
					if(form.txtGRA.value>5){
						alert('TIPO DE ENSENANZA no corresponde al grado del curso.');
						return false;
					};
				};
				//FIN VALIDACION TPO DE ENSEÑANZA

				if(!form.cmbEVAL.disabled){
					//VALIDACION DECRETO EVALUACION
					if(form.cmbEVAL.value==5111997){
						if((form.txtGRA.value>8)||(form.txtGRA.value<1)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE EVALUACION no corresponde al curso.');
								return false;
							};
						};
					};
					if(form.cmbEVAL.value==1121999){
						if((form.txtGRA.value!=1)&&(form.txtGRA.value!=2)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE EVALUACION no corresponde al curso.');
								return false;
							};
						};
					};
					if(form.cmbEVAL.value==832001){
						if((form.txtGRA.value!=4)&&(form.txtGRA.value!=3)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE EVALUACION no corresponde al curso.');
								return false;
							};
						};
					};
					if(form.cmbEVAL.value==1461988){
						if((form.txtGRA.value!=8)&&(form.txtGRA.value!=4)){
							alert('DECRETO DE EVALUACION no corresponde al curso.');
							return false;
						}else{
							if((form.txtGRA.value==8)){
								if(form.cmbENS.value!=110){
									alert('DECRETO DE EVALUACION no corresponde al curso.');
									return false;
								};
							};
							if((form.txtGRA.value==4)){
								if(form.cmbENS.value==110){
									alert('DECRETO DE EVALUACION no corresponde al curso.');
									return false;
								};
							};

						};
					};
				};
				//FIN VALIDACION DECRETO EVALUACION

				if(!form.cmbPLAN.disabled){
					//VALIDACION DECRETO PLAN ESTUDIO
					if(form.cmbPLAN.value==5451996){
						if((form.txtGRA.value!=1)&&(form.txtGRA.value!=2)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
				  			};
						};
					};

					if(form.cmbPLAN.value==5521997){
						if((form.txtGRA.value!=3)&&(form.txtGRA.value!=4)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};

					if(form.cmbPLAN.value==2201999){
						if((form.txtGRA.value!=5)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};
					
					if(form.cmbPLAN.value==812000){
						if((form.txtGRA.value!=6)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};

					if(form.cmbPLAN.value==4812000){
						if((form.txtGRA.value!=7)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==922002){
						if((form.txtGRA.value!=8)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value!=110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};

					if(form.cmbPLAN.value==771999){
						if((form.txtGRA.value!=1)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==832000){
						if((form.txtGRA.value!=2)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==272001){
						if((form.txtGRA.value!=3)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				
					
					if(form.cmbPLAN.value==1022002){
						if((form.txtGRA.value!=4)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};				

					if(form.cmbPLAN.value==4592002){
						if((form.txtGRA.value!=4)){
							alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
							return false;
						}else{
							if((form.cmbENS.value==110)){
								alert('DECRETO DE PLAN DE ESTUDIO no corresponde al curso.');
								return false;
							};
						};
					};*/

					//FIN VALIDACION DECRETO PLAN ESTUDIO
				}
				if(!chkFecha(form.txtFECHARES,'Fecha inválida.')){
					        return false;
				        };
				return true;
			}
		</SCRIPT>
	<?php }//FIN COLEGIO?>
	<?php if(($_TIPOINSTIT==2)||($_TIPOINSTIT==3)){//JARDIN O SALA CUNA?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtGRA,'Ingresar GRADO del curso.')){
					return false;
				};
				if(!nroOnly(form.txtGRA,'Se permiten sólo números para el GRADO del curso.')){
					return false;
				};
				if(!chkSelect(form.cmbENS,'Seleccionar TIPO DE ENSEÑANZA del curso.')){
					return false;
				};
				if(!chkSelect(form.cmbSUP,'Seleccionar SUPERVISOR del curso.')){
					return false;
				};
				return true;
			}
		</SCRIPT>
	<?php }//FIN JARDIN O SALA CUNA?>
<?php }?>
	
<link href="../../../util/objeto.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"><style type="text/css">
<!--
body {
	background-image: url(../../../../menu/adm/imag/fondomain.gif);
	margin-left: 75px;
}
-->
</style></HEAD>
<body topmargin="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">
<!--table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr> 
          <td width="81" height="30"><a href="../ano/periodo/listarPeriodo.php3"><img src="../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/feriado/listaFeriado.php3"><img src="../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><img src="../botones/planes_roll.gif" name="Image4" width="81" height="30" border="0" id="Image4"></a></td>
          <td width="81" height="30"><a href="../atributos/listarTiposEnsenanza.php3"><img src="../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/curso/listarCursos.php3"><img src="../botones/cursos.gif" name="Image6" width="81" height="30" border="0" id="Image6" onMouseOver="MM_swapImage('Image6','','../botones/cursos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../ano/matricula/listarMatricula.php3"><img src="../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ano/reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
		  <td width="81" height="30"><a href="../ano/ActasMatricula/Menu_Actas.php?botonera=1"><img src="../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
          <td width="81" height="30"><a href="#"><img src="../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>
        </tr>
      </table> </td>
  </tr>
</table -->

	<?php //echo tope("../../../util/");?>
	<FORM method=post name="frm" action="procesoPlanEstudio.php">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
	?>
		<TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 >
			<TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
										 
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (31)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (41)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												}
 											}
										?>
										
								<?php
										 
										$qry2="SELECT * FROM PLAN_ESTUDIO WHERE COD_DECRETO=$plan AND RDB=$institucion";
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (31)</B>'.$qry2);
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (42)</B>');
														exit();
													}
													
												}
 											}
										?>						
										
              </strong> </FONT> </TD>
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
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" value="GUARDAR"   name=btnGuardar2 onClick="return valida(this.form);" > 
              &nbsp; 
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarPlanesEstudio.php">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
									<!--PENDIENTE POR MUCHO ENRREDO-->
									<!--INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaCurso.php3?curso=<?php echo $curso?>&caso=3"-->&nbsp;
									<?php if($_PERFIL!=17){?>
										
										<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="LISTADO" onClick=document.location="listarPlanesEstudio.php">
              &nbsp; 
              <?php }?>
              <?php };?>
              <?php if($frmModo=="modificar"){ ?>
              <input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' type="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form)?decreto=<?php echo $plan ?>;" >
              &nbsp; 
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="listarPlanesEstudio.php">&nbsp;
								<?php };?>
						  </TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							
            <TD align=middle colspan=2> <FONT face="arial, geneva, helvetica" size=2 color=White> 
              <strong>MODIFICAR PLAN DE ESTUDIO PROPIO</strong> </FONT> </TD>
						</TR>
						<TR>
							<TD width=40></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2>
									<TR>
										<TD width="166">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>Nº RES. O DECRETO</STRONG>
											</FONT>
										</TD>
										<TD width="170">
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>FECHA</STRONG>
											</FONT>
										</TD>
										 
										
										
										
                  <TD width="183"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>NOMBRE DECRETO ej.( 10 de 2000)</strong> </FONT> </TD>
									</TR>
									<TR>
										<TD align=left>
											<input name="cod_decreto" type="hidden" value="<?php echo ($fila2['cod_decreto']) ?>">
                    						<?php 
												//if($frmModo=="mostrar"){ 
													echo ($fila2['cod_decreto']);
													
												//};
											?>
                    
										</TD>
										<TD align=left>
											
											
											<?php 
												//if($frmModo=="mostrar"){ 
													impF($fila2['fecha_decreto']);
												//};
											?>
											
										</TD>
										<TD>
											
											<?php 
												//if($frmModo=="mostrar"){ 
													echo ($fila2['nombre_decreto']);
												//};
											?>
											
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
	<?php if($_TIPOINSTIT==1){//COLEGIO?>
		<?php
			//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
			$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
			$result =@pg_Exec($conn,$qry);
			$fila4= @pg_fetch_array($result,0);
		?>
		<?php					if(($fila4["cod_tipo"]!=10)&&($fila4["cod_tipo"]!=20)&&($fila4["cod_tipo"]!=30)&&($fila4["cod_tipo"]!=40)&&($fila4["cod_tipo"]!=50)&&($fila4["cod_tipo"]!=60)){//ENSEÑANZA KINDER U OTRO CABRO CHICO
		?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
									<TR>
										
                  <TD width="49%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>TIPOS DE ENSEÑANZA</STRONG> 
                    </FONT> </TD>
										
                  <TD width="51%" align="left"> <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    AGREGAR TIPO DE ENSEÑANZA </FONT> </TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="modificar"){ ?>
												<?php if($_TIPOINSTIT==1){//COLEGIO?>
													<Select name="cmbENSP" onChange="chkENS(this.form);">
												<?php }else{ ?>
													<Select name="cmbENSP">
												<?php }?>
													
													<?php
													
														$qry="SELECT * FROM PLAN_TIPO WHERE COD_DECRETO=".$plan;
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (71)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (81)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila = @pg_fetch_array($result,$i);
																	//if($_TIPOINSTIT==1){//COLEGIO
																	//	if($fila["cod_tipo"]>100) PARA QUE MUESTRE TODO
																	       $qry="SELECT  plan_tipo.cod_tipo,tipo_ensenanza.nombre_tipo FROM PLAN_TIPO INNER JOIN TIPO_ENSENANZA ON PLAN_TIPO.COD_TIPO=TIPO_ENSENANZA.COD_TIPO WHERE PLAN_TIPO.COD_DECRETO=".$plan." order by tipo_ensenanza.cod_tipo";
																			$result =@pg_Exec($conn,$qry);
																			 $fila9 = @pg_fetch_array($result,$i);
																			echo  "<option value=".$fila["cod_tipo"].">".$fila9["nombre_tipo"]."</option>";
																	
																	
																}
															}
														};
													?>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													$qry="SELECT * FROM PLAN_TIPO WHERE COD_DECRETO=$plan";
													$result =@pg_Exec($conn,$qry);
													if (!$result) {
														error('<B> ERROR :</b>Error al acceder a la BD. (32)</B>');
													}else{
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															if (!$fila1){
																error('<B> ERROR :</b>Error al acceder a la BD. (42)</B>');
																exit();
															}
															//echo trim($fila1['nombre_tipo']);
														}
													}
												};
											?>
											<?php if($frmModo=="ingresar"){ ?>
												<?php if($_TIPOINSTIT==1){//COLEGIO?>
													<Select name="cmbENSP" onChange="chkENS(this.form);">
												<?php }else{ ?>
													<Select name="cmbENSP">
												<?php }?>
													<option value=0></option>;
													<?php
														//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
														$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
														$result =@pg_Exec($conn,$qry);
														$fila4= @pg_fetch_array($result,0);

														//TIPOS DE ENSENANZA
														$qry="SELECT * from tipo_ensenanza  WHERE COD_TIPO<>0";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (91)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	if($fila4["cod_tipo"]!=$fila1["cod_tipo"]){
																		echo "<option value=".$fila1["cod_tipo"].">".$fila1["nombre_tipo"]."</option>";
																	}else{
																		echo "<option value=".$fila1["cod_tipo"]." selected >".$fila1["nombre_tipo"]."</option>";
																	}
																}
															}
														};
													?>

												</Select>
											<?php };?>
											
										</TD>
										<TD>
											<?php if($frmModo=="modificar"){ ?>
												<?php if($_TIPOINSTIT==1){//COLEGIO?>
													<Select name="cmbENS" onChange="chkENS(this.form);">
												<?php }else{ ?>
													<Select name="cmbENS">
												<?php }?>
													<option value=0 selected></option>
													<?php
													
														$qry="SELECT * FROM TIPO_ENSENANZA";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (71)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (81)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila = @pg_fetch_array($result,$i);
																	//if($_TIPOINSTIT==1){//COLEGIO
																	//	if($fila["cod_tipo"]>100) PARA QUE MUESTRE TODO
																	echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";
																	
																	
																}
															}
														};
													?>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													$qry="SELECT * FROM PLAN_TIPO WHERE COD_DECRETO=$plan";
													$result =@pg_Exec($conn,$qry);
													if (!$result) {
														error('<B> ERROR :</b>Error al acceder a la BD. (32)</B>');
													}else{
														if (pg_numrows($result)!=0){
															$fila1 = @pg_fetch_array($result,0);	
															if (!$fila1){
																error('<B> ERROR :</b>Error al acceder a la BD. (42)</B>');
																exit();
															}
															//echo trim($fila1['nombre_tipo']);
														}
													}
												};
											?>
											<?php if($frmModo=="ingresar"){ ?>
												<?php if($_TIPOINSTIT==1){//COLEGIO?>
													<Select name="cmbENS" onChange="chkENS(this.form);">
												<?php }else{ ?>
													<Select name="cmbENS">
												<?php }?>
													<option value=0></option>;
													<?php
														//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
														$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
														$result =@pg_Exec($conn,$qry);
														$fila4= @pg_fetch_array($result,0);

														//TIPOS DE ENSENANZA
														$qry="SELECT * from tipo_ensenanza  WHERE COD_TIPO<>0";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (91)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (101)</B>');
																	exit();
																};
																for($i=0 ; $i < @pg_numrows($result) ; $i++){
																	$fila1 = @pg_fetch_array($result,$i);
																	if($fila4["cod_tipo"]!=$fila1["cod_tipo"]){
																		echo "<option value=".$fila1["cod_tipo"].">".$fila1["nombre_tipo"]."</option>";
																	}else{
																		echo "<option value=".$fila1["cod_tipo"]." selected >".$fila1["nombre_tipo"]."</option>";
																	}
																}
															}
														};
													?>

												</Select>
											<?php };?>
											
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
		<?php }//FIN ENSEÑANZA CURSO?>
	<?php }//COLEGIO?>
	
					 <?php
			//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
			$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
			$result =@pg_Exec($conn,$qry);
			$fila4= @pg_fetch_array($result,0);
		?>
		<?php					if(($fila4["cod_tipo"]!=10)&&($fila4["cod_tipo"]!=20)&&($fila4["cod_tipo"]!=30)&&($fila4["cod_tipo"]!=40)&&($fila4["cod_tipo"]!=50)&&($fila4["cod_tipo"]!=60)){//ENSEÑANZA KINDER U OTRO CABRO CHICO
		?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
									<TR>
										
                  
										
                  <TD width="56%" align="left"> <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    DESCRIPCION (RANGO ENTRE CURSOS) ej. 1 A 2 Medio </FONT> </TD>
									</TR>
									<TR>
										<TD>
                    						<?php 
												//if($frmModo=="mostrar"){ 
													//echo($fila2['cursos']);
												//};
											?>
                  								 <input name=cursos type=text value="<?php echo trim($fila2['cursos'])?>" size=25 maxlength=25>															
										</TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
		<?php }//FIN ENSEÑANZA CURSO?>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										
                  <TD bgcolor=#003b85><strong> <FONT face="arial, geneva, helvetica" size=2 color=WHITE>&nbsp; 
                    GRADOS PARA EL PLAN DE ESTUDIO</FONT></strong> </TD>
				
					
					</TR>
									<TR>
										<TD>
										<?php $qry="SELECT * FROM cursos_plan WHERE cod_decreto=".$plan;
														$result =@pg_Exec($conn,$qry);
														$fila8= @pg_fetch_array($result,0);
														?>
														<? if ($fila8['pa']=="1"){ ?>
																<input name="PA" type="checkbox" value="1" checked><strong><font face="arial, genova, helvetica" size=1>PRIMER AÑO</font></strong>
														<?php }else{?>
																<input name="PA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>PRIMER AÑO</font></strong><? } ?>
														<? if ($fila8['sa']==1){ ?>
																<input name="SA" type="checkbox" value="1" checked><strong><font face="arial, genova, helvetica" size=1>SEGUNDO AÑO</font></strong>
														<?php }else{ ?>
																<input name="SA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>SEGUNDO AÑO</font></strong><? }?>
														<? if ($fila8['ta']==1){ ?>
																<input name="TA" type="checkbox" value="1" checked ><strong><font face="arial, genova, helvetica" size=1>TERCER AÑO</font></strong>&nbsp;
														<?php }else{ ?> 
																<input name="TA" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>TERCER AÑO</font></strong>&nbsp;<? }?>
														<? if ($fila8['cu']==1){ ?>
					    						                <input name="CU" type="checkbox" value="1" checked><strong><font face="arial, genova, helvetica" size=1>CUARTO AÑO</font></strong>
														<?php }else{ ?> 
																<input name="CU" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>CUARTO AÑO</font></strong><? }?>
														<br><br>
														<? if ($fila8['qu']==1){ ?>
																<input name="QU" type="checkbox" value="1" checked><strong><font face="arial, genova, helvetica" size=1>QUINTO AÑO</font></strong>
														<?php }else{ ?>
																<input name="QU" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>QUINTO AÑO</font></strong><? }?>
														<? if ($fila8['sx']==1){ ?>
																<input name="SX" type="checkbox" value="1" checked><strong><font face="arial, genova, helvetica" size=1>SEXTO AÑO</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;
														<?php }else{ ?>
																<input name="SX" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>SEXTO AÑO</font></strong>&nbsp;&nbsp;&nbsp;&nbsp;<? }?>
														<? if ($fila8['sp']==1){ ?>
																<input name="SP" type="checkbox" value="1" checked><strong><font face="arial, genova, helvetica" size=1>SEPTIMO AÑO</font></strong>
														<?php }else{ ?> 
																<input name="SP" type="checkbox" value="1"><strong><font face="arial, genova, helvetica" size=1>SEPTIMO AÑO</font></strong><? }?>
														<? if ($fila8['oc']==1){ ?>
					                    						<input name="OC" type="checkbox" value="1" checked><strong><font face="arial, genova, helvetica" size=1>OCTAVO AÑO</font></strong>
														<?php }else{ ?> 
																<input name="OC" type="checkbox" value="1" ><strong><font face="arial, genova, helvetica" size=1>OCTAVO AÑO</font></strong><? }?>
						<?php if($frmModo=="mostrar"){ ?>
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													$qry55="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM curso INNER JOIN (empleado INNER JOIN supervisa ON empleado.rut_emp = supervisa.rut_emp) ON curso.id_curso = supervisa.id_curso WHERE (((curso.id_curso)=".$fila['id_curso']."))";
													$result55 =@pg_Exec($conn,$qry55);
													$fila55 = @pg_fetch_array($result55,0);
													imp($fila55["ape_pat"]." ".$fila55["ape_mat"].", ".$fila55["nombre_emp"]);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
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
												
						  <TD bgcolor=#003b85><strong> <FONT face="arial, geneva, helvetica" size=2 color=WHITE>&nbsp; 
							SUBSECTORES DEL PLAN PROPIO</FONT></strong> </TD>
							</TR>
							<TR>
							<TD>
							<?php
							
								$qry7 = "select * from incluye_propio where cod_decreto=".$plan ;
								$result7 = @pg_Exec($conn,$qry7);
								
								//$fila8 = @pg_numrows($result7);
								
							?>
							
							<table width="549" border="0">
								<tr>
								<td width="543"><table width="%" border="0">
								<tr>
								<td width="71"><strong> <font face="arial, geneva, helvetica" size=1.5>ELIMINAR</font></strong></td>
								<td width="79"><strong> <font face="arial, geneva, helvetica" size=1.5>CODIGO</font></strong></td>
                                <td width="%"><strong> <font face="arial, geneva, helvetica" size=1.5>NOMBRE SUBSECTOR</font></strong></td>
							  	</tr>
								
								<?php 
								
								for($i=0 ; $i < @pg_numrows($result7); $i++){
								$fila7 = @pg_fetch_array($result7);
								$qry8 ="SELECT * from subsector where cod_subsector=".$fila7["cod_subsector"] ;
								$result8 = @pg_exec($conn,$qry8);
								$fila8 = @pg_fetch_array($result8); 
								if ($fila8["nombre"]!=' ') {?>
							   <tr>
								
                              <td><font size="1">&nbsp;</font>
								<input type="checkbox" name="subsector[]" value=<?php echo $fila7["cod_subsector"];?>></td>
								<td><font face="arial, geneva, helvetica" size=1><?php echo $fila7["cod_subsector"]; ?></font></td>
								<td><font face="arial, geneva, helvetica" size=1><?php echo $fila8["nombre"]; ?></font></td>
							   </tr>
							     
							  <?php } 
							      } ?>
						</table>
						</td>		
					 	</tr>	 
						</table> </TD>
					</TR>
					</TABLE>
					</TD>
					</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
										
                  <TD bgcolor=#003b85><strong> <FONT face="arial, geneva, helvetica" size=2 color=WHITE>&nbsp; 
                    AGREGAR SUBSECTORES PARA PLAN PROPIO</FONT></strong> </TD>
					</TR>
					<TR>
				    <TD><table width="534" border="0">
                      <tr>
									
									    <td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+1) ?></font></strong></td>
										<td width="%"><input name="sub1" type="text" size="5" maxlength="5"></td>
			                        <td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+2) ?></font></strong></td>
										<td width="%"><input name="sub2" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+3) ?></font></strong></td>
										<td width="%"><input name="sub3" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+4) ?></font></strong></td>
										<td width="%"><input name="sub4" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+5) ?></font></strong></td>
										<td width="%"><input name="sub5" type="text" size="5" maxlength="5"></td>
					  </tr>
								  <tr>
									<td colspan="8">&nbsp;</td>
								  </tr>
								  <tr>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+6) ?></font></strong></td>
										<td width="%"><input name="sub6" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+7) ?></font></strong></td>
										<td width="%"><input name="sub7" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+8) ?></font></strong></td>
										<td width="%"><input name="sub8" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+9) ?></font></strong></td>
										<td width="%"><input name="sub9" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+10) ?></font></strong></td>
										<td width="%"><input name="sub10" type="text" size="5" maxlength="5"></td>
								  </tr>
								  <tr>
									<td colspan="8">&nbsp;</td>
								  </tr>
								  <tr>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+11) ?></font></strong></td>
										<td width="%"><input name="sub11" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+12) ?></font></strong></td>
										<td width="%"><input name="sub12" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+13) ?></font></strong></td>
										<td width="%"><input name="sub13" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+14) ?></font></strong></td>
										<td width="%"><input name="sub14" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+15) ?></font></strong></td>
										<td width="%"><input name="sub15" type="text" size="5" maxlength="5"></td>
								  </tr>	
								   <tr>
									<td colspan="8">&nbsp;</td>
								  </tr> 
								   <tr>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+16) ?></font></strong></td>
										<td width="%"><input name="sub16" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+17) ?></font></strong></td>
										<td width="%"><input name="sub17" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+18) ?></font></strong></td>
										<td width="%"><input name="sub18" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+19) ?></font></strong></td>
										<td width="%"><input name="sub19" type="text" size="5" maxlength="5"></td>
									<td width="%"><strong><font face="arial, genova, helvetica" size=1>SUBSECTOR <?php echo ($i+20) ?></font></strong></td>
										<td width="%"><input name="sub20" type="text" size="5" maxlength="5"></td>
								  </tr>	 
								  
								</table> </TD>
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
						  </TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<?php if($frmModo=="ingresar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													
                    <ul>
                      
                      <li>SI DESEA INGRESAR MAS DE VEINTE SUBSECTORES PRESIONE 
                        &quot;GUARDAR&quot; Y REGRESE A ESTA PAGINA PARA CONTINUAR. 
                      </li>
                      <li>Una vez finalizado el ingreso de la información presionar 
                        "GUARDAR" para grabar los datos, o bien "CANCELAR" para 
                        volver al listado de planes de estudio ingresados al sistema.</li>
                      <li>Para abandonar la sesión de usuario presionar "CERRAR 
                        SESION".</li>
                      <li>Luego de GUARDAR podra realizar modificaciones, agregar 
                        nuevos Tipos de Enseñanza, seleccionar subsectores etc. 
                        .</li>
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
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
													
                     						 <li>"ELIMINAR" : Elimina toda la información del plan ingresado</li>
													
                      						<li>"LISTADO" : Despliega el total de planes de estudio 
                     									   ingresados ingresadas.</li>
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
			<?php if($frmModo=="modificar"){?>
				<tr>
					<td colspan=3 align=center>
						<table WIDTH="85%" CELLSPACING="0" CELLPADDING="1" bgcolor="#48d1cc">
							<tr>
								<td>
									<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="1" bgcolor=white>
										<tr>
											<td>
												<font face="arial, geneva, helvetica" size="1" color=black>
													<ul>
													   <li>Una vez finalizada la modificación de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para no realizar las modificaciones.</li>
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
</FORM
></BODY>
</HTML>