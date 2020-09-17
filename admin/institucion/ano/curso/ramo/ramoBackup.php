<?php require('../../../../../util/header.inc');
       require('../../../../../util/LlenarCombo.php3');
	    require('../../../../../util/SeleccionaCombo.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
//	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$plan			=$_PLAN;
	$docente		=5; //Codigo Docente
	
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
?>
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbSEC.value!=0){
				form.cmbSEC.target="self";
				form.action = 'ramo.php3?institucion=$institucion&$frmModo=ingresar';
				form.submit(true);
				}	
			}
			
			function enviapag(form){
			if (form.cmbSECDIF.value!=0){
				form.cmbSECDIF.target="self";
				form.action = 'ramo.php3?institucion=$institucion&$frmModo=ingresar';
				form.submit(true);
				}	
			}
			
			function ChequearTodos(chkbox)
				{
				for (var i=0;i < document.forms[0].elements.length;i++)
					{
				var elemento = document.forms[0].elements[i];
				if (elemento.type == "checkbox")
					{
					elemento.checked = chkbox.checked
					}
				}
			}
</SCRIPT>


<?php
	if($frmModo!="ingresar"){
		$qry="SELECT subsector.nombre, ramo.modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
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

	switch ($fila['modo_eval']) {
		 case 0:
			$_MODOEVAL	=	0;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 1:
			$_MODOEVAL	=	1;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
		 case 2:
			$_MODOEVAL	=	2;
			if(!session_is_registered('_MODOEVAL')){
				session_register('_MODOEVAL');
			};
			 break;
	 };

?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	<?php if($_TIPOINSTIT==1){//COLEGIO ?>
	<!--AQUI DETERMINAR SI EL CURSO ES KINDER O OTRO DE LOS CABROS CHICOS-->
		<?php if($frmModo=="ingresar"){ ?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkSelect(form.cmbSUB,'Seleccionar SUBSECTOR AL QUE CORRESPONDE.')){
							return false;
						};

						if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
							return false;
						};

						if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
							return false;
						};

						return true;
					}
				</SCRIPT>
		<?php }else{?>
				<SCRIPT language="JavaScript">
					function valida(form){
						if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
							return false;
						};

						if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
							return false;
						};

						return true;
					}
				</SCRIPT>
		<?php }?>
	<?php }?>
	<?php if(($_TIPOINSTIT==2)||($_TIPOINSTIT==3)){//JARDIN O SALACUNA ?>
			<SCRIPT language="JavaScript">
				function valida(form){
					if(!chkSelect(form.cmbMODO,'Seleccionar MODO DE EVALUACION.')){
						return false;
					};

					if(!chkSelect(form.cmbDOC,'Seleccionar DOCENTE.')){
						return false;
					};

					return true;
				}
			</SCRIPT>
	<?php }?>
<?php }?>
	</HEAD>
<BODY >
	<?php echo tope("../../../../../util/");?>
	<FORM method=post name="frm" action="procesoRamo.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=ano value=".$ano.">";
		echo "<input type=hidden name=curso value=".$curso.">";
	?>
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
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
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
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
											$qry="SELECT curso.*, tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila3 = @pg_fetch_array($result,0);	
													if (!$fila3){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila3['grado_curso'])." - ".trim($fila3['letra_curso'])." ".trim($fila3['nombre_tipo']);
												}
											}
											
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left>
							<?php if (($frmModo=="mostrar") or ($frmModo=="modificar")){ ?>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>SUBSECTOR</strong>
								</FONT>
							
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							<?php }?>
							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT subsector.nombre, ramo.sub_obli, ramo.sub_elect, ramo.bool_ip, ramo.bool_sar FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (@pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);	
												echo trim($fila1['nombre']);
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
									<INPUT TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida(this.form);" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick=document.location="listarRamos.php3">&nbsp;
								<?php };?>
								<?php if($frmModo=="mostrar"){ ?>
								<?php if($_PERFIL==17){ ?>
									<INPUT TYPE="button" value="INICIO" onClick=document.location="../../../../../session/perfilDocente.php3">
								<?php }?>
									<?php if($_PERFIL!=17){?>
										<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
												<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
												<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaRamo.php3?ramo=<?php echo $ramo?>&caso=3">&nbsp;
												<INPUT TYPE="button" value="ELIMINAR" name=btnEliminar onClick=document.location="seteaRamo.php3?caso=9;">&nbsp;
											<?php }?>
										<?php }?>
										<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarRamos.php3">&nbsp;
									<?php }?>
								<?php if($_TIPODOCENTE==1){?>
										<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarRamos.php3">&nbsp;
									<?php }?>
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida(this.form)?;" >&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick=document.location="seteaRamo.php3?ramo=<?php echo $ramo?>&caso=1">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle colspan=2>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>SUBSECTOR</strong>
								</FONT>
							</TD>
						</TR>
						
				<?php if($_TIPOINSTIT==1){//COLEGIO
				 ?>
				
				<?php if (($fila3['cod_tipo']==410) or($fila3['cod_tipo']==510) or ($fila3['cod_tipo']==610) or ($fila3['cod_tipo']==710) or ($fila3['cod_tipo']==810)){?>
				<?php  } ?>
					<?php
					//TIPO DE ENSEÑANZA AL QUE CORRESPONDE
					$qry="SELECT curso.id_curso, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
					$result =@pg_Exec($conn,$qry);
					$fila4= @pg_fetch_array($result,0);
					?>
					<?php  /*if(($fila4["cod_tipo"]!=10)&&($fila4["cod_tipo"]!=20)&&($fila4["cod_tipo"]!=30)&&($fila4["cod_tipo"]!=40)&&($fila4["cod_tipo"]!=50)&&($fila4["cod_tipo"]!=60)){//DISTINTO DE ENSEÑANZA PRE-BASICA
					}  */?>
						<TR>
							<TD width=21></TD>
							
            <TD> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
				<?php 
				      $qry5="SELECT * FROM curso WHERE ID_CURSO=".$curso; 
					    $result5 =@pg_Exec($conn,$qry5);
						$fila5= @pg_fetch_array($result5,0);
						   if(($fila3["cod_tipo"]==110) or ((($fila3["cod_tipo"]==310)||($frmModo=="mostrar") || ($frmModo=="modificar")) and ($fila5['grado_curso']==1) or ($fila5['grado_curso']==2)) OR ((($fila3["cod_tipo"]>=410)||($frmModo=="mostrar") || ($frmModo=="modificar")) and (($fila5['grado_curso']==3) or ($fila5['grado_curso']==4)))){ ?>
							  <td width="131"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
								<strong>SUBSECTOR</strong> </font> </td>
						 	 
								
							  	<?php if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310) and ($frmModo=="ingresar")) { ?>
                  			<td width="226"> <font face="arial, geneva, helvetica" size=1 color=#000000><strong>SECTOR</strong></font></td>
							  <td width="182"> <font face="arial, geneva, helvetica" size=1 color=#000000><font face="arial, geneva, helvetica" size=1 color=#000000>SUBSECTOR</font> 
								</font> </td>
								<?php } ?>
							</tr>
							<tr> 
				
                  <td> 
                    <?php if($frmModo=="ingresar"){ ?>
					<?php  //if($fila5["cod_tipo"]<>310){ ?>
                    	<select name="cmbSUB">
                      	<option value=0 selected>Seleccione Subsector</option>
					<?php
						//SUBSECTORES QUE CORRESPONDEN AL CURSO DE ACUERDO AL PLAN DE ESTUDIO
						$qry2="SELECT * FROM curso WHERE ID_CURSO=".$curso;
						$result2 =@pg_Exec($conn,$qry2);
						$fila2= @pg_fetch_array($result2,0);
						$qry=0;

							if (($fila3['ensenanza']==110) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989"))){
								$qry="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
							
							}elseif (($fila3['ensenanza']>=310) AND (($fila2['grado_curso']==1) OR ($fila2['grado_curso']==2)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989"))){
								$qry="SELECT subsector.cod_subsector, subsector.nombre FROM subsector INNER JOIN ((curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto) INNER JOIN incluye ON plan_estudio.cod_decreto = incluye.cod_decreto) ON subsector.cod_subsector = incluye.cod_subsector WHERE (((curso.id_curso)=".$curso.")) union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
							
							}elseif (($fila3['ensenanza']>=410) AND (($fila2['grado_curso']==3) OR ($fila2['grado_curso']==4)) and (($plan=="5451996") or ($plan=="5521997") or ($plan=="2201999") or ($plan=="812000") or ($plan=="4812000") or ($plan=="922002") or ($plan=="771999") or ($plan=="832000") or ($plan=="272001") or ($plan=="1022002") or ($plan=="4592002") or ($plan=="771982") or ($plan=="1901975") or ($plan=="121987") or ($plan=="1521989")))  {
								$qry="select subsector.cod_subsector, subsector.nombre from incluye_tp inner join subsector on incluye_tp.cod_subsector=subsector.cod_subsector where incluye_tp.cod_esp=".$fila3['cod_es']." and incluye_tp.cod_rama=".$fila3['cod_rama']." and incluye_tp.cod_sector=".$fila3['cod_sector']." and complementario=1 and curso.id_curso=".$curso." union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
							
							}elseif (($plan!="5451996") and ($plan!="5521997") and ($plan!="2201999") and ($plan!="812000") and ($plan!="4812000") and ($plan!="922002") and ($plan!="771999") and ($plan!="832000") and ($plan!="272001") and ($plan!="1022002") and ($plan!="4592002") and ($plan!="771982") and ($plan!="1901975") and ($plan!="121987") and ($plan!="1521989")){
								$qry="select * from incluye_propio inner join subsector on incluye_propio.cod_subsector =subsector.cod_subsector where incluye_propio.cod_decreto=".$plan;
							}  
					//} 
					 
						$result =@pg_Exec($conn,$qry);
						if (!$result) 
							error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>'.$qry);
						else{
																		
						for($i=0 ; $i < @pg_numrows($result) ; $i++){
							$fila1 = @pg_fetch_array($result,$i);
							//RAMOS INGRESADOS AL CURSO
							$qry2="SELECT subsector.cod_subsector, subsector.nombre FROM (curso INNER JOIN ramo ON curso.id_curso = ramo.id_curso) INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((curso.id_curso)=".$curso.") AND ((subsector.cod_subsector)=".$fila1["cod_subsector"]."))";
							$result2 =@pg_Exec($conn,$qry2);
								if (!$result2) 
									error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
								else{
									if (pg_numrows($result2)==0){
										echo  "<option value=".$fila1["cod_subsector"].">".$fila1["nombre"]."</option>";
									};
								}
								};
						};//fin if modo ingresar
													?>
                    </select> 
                    <?php }  }; //}?>
					 
                    <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nombre']);
													
												};
											?>
                    <?php 
												if($frmModo=="modificar"){ 
													imp($fila['nombre']);
												};
											?>
                  </td>
                  <td> 
				  	<?php if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310)) { ?>
                    <?php if($frmModo=="ingresar"){ ?>
                   
                    <select name="cmbSECDIF" onchange="enviapag(this.form);">
                      <option value=0 selected>Seleccione Sector</option>
					  <?php if ($cmbSECDIF==1) {
					  			echo "<option value=1 selected>Lengua Castellana y Comunicación</option>";
					   		}else echo "<option value=1>Lengua Castellana y Comunicación</option>";
					  		if ($cmbSECDIF==2) {
								echo "<option value=2 selected>Idioma Extranjero</option>";
					  		}else echo "<option value=2>Idioma Extranjero</option>";
					  		if ($cmbSECDIF==3){ 
								echo "<option value=3 selected>Matemáticas</option>";
					  		}else echo "<option value=3>Matemáticas</option>";
					  		if ($cmbSECDIF==4){
					  			echo "<option value=4 selected>Historia y Ciencias Sociales</option>";
					  		}else echo "<option value=4>Historia y Ciencias Sociales</option>";
					  		if ($cmbSECDIF==5){
					  			echo "<option value=5 selected>Filosofía y Psicología</option>";
					  		}else echo "<option value=5 >Filosofía y Psicología</option>";
							if ($cmbSECDIF==6){
					  			echo "<option value=6 selected>Biología</option>";
					  		}else echo "<option value=6 >Biología</option>";
					  		if ($cmbSECDIF==7){ 
					  			echo "<option value=7 selected>Física</option>";
					  		}else echo "<option value=7>Física</option>";
					  		if ($cmbSECDIF==8){ 
								echo "<option value=8>Química</option>";
					  		}else echo "<option value=8>Química</option>";
					  		if ($cmbSECDIF==9){ 
								echo "<option value=9 selected>Educación Técnologica</option>";
					  		}else echo "<option value=9>Educación Técnologica</option>";
					  		if ($cmbSECDIF==10){
					  			echo "<option value=10 selected>Artes Visuales</option>";
					  		}else echo "<option value=10>Artes Visuales</option>";
					  		if ($cmbSECDIF==11){
								echo "<option value=11 selected>Artes Musical</option>";
					  		}else echo "<option value=11>Artes Musical</option>";
					  		if ($cmbSECDIF==12){
					  			echo "<option value=12 selected>Educación Física</option>";
					  		}else echo "<option value=12>Educación Física</option>";
					?>
                    </select>
                  </td>
                  <td align="top">
				   <select name="cmbSUB">
                      <option value=0 selected>Selecione Subsector</option>
				  <?php 
				   	$qry="select subsector.cod_subsector, subsector.nombre from (subsector inner join sector_sub on subsector.cod_subsector=sector_sub.cod_subsector) where sector_sub.id_sector=".$cmbSECDIF."union select subsector.cod_subsector, subsector.nombre from subsector where nombre like'IDIOMA%' GROUP BY subsector.nombre,subsector.cod_subsector";
					$result =@pg_Exec($conn,$qry);
					for($i=0 ; $i < @pg_numrows($result) ; $i++){ 
					 $fila= @pg_fetch_array($result,$i);
						echo  "<option value=".$fila["cod_subsector"]." >".$fila["nombre"]."</option>";
					}
				
				?>
				</select>
			 <?php }
			 };?>
				  </td>
                </tr>
              </table></TD>
						</TR>

			<?php// if ((($fila3['grado_curso']==3) or ($fila3['grado_curso']==4)) and ($fila3['cod_tipo']==310)) { ?>
					<TR>
					<TD width=21></TD>
							
            <TD> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
                  
                </tr>
				<tr> 
                  <td width="22"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                   </td>
                 
                  <td width="303">  
                  </td>
                </tr>
                <tr>
				
				   <td align="top" width="310">
				   <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>SUBSECTOR OBLIGATORIO</strong></font>
                        <?php 
						if($frmModo=="ingresar"){ ?>
                    <input name="sub_ob" type="radio" value="1" checked> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													imp(($fila1['sub_obli']==1)?"SI":"NO");
												};
											?>
                                           <?php if($frmModo=="modificar"){ ?>
                                            <input name="sub_ob" type="radio" value=1 checked
											<?php 
											  echo ($fila1['sub_obli']==1)?"checked":"";
											?>>
											<?php };?>
                    </td>
                   
                  <td align="top" width="206"> 
				  <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>SUBSECTOR ELECTIVO</strong></font>
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="radio" name="sub_ob" value="2"> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila1['sub_obli']==2)?"SI":"NO");
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type="radio" name="sub_ob" value=2
											<?php 
											  echo ($fila1['sub_obli']==2)?"checked":"";
											?>>
											<?php };?>
                    </td>
                </tr>
				
              </table></TD>
						</TR>						

                          <TR>
							<TD width=21></TD>
							
            <TD> <table border=0 cellspacing=2 cellpadding=2>
                <tr> 
                  <td width="262"> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>INCIDE EN PROMOCION (SE IMPRIME EN EL ACTA)</strong></font> </td>
                  <td width="254"> <font face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    SUBSECTOR ASOCIADO A RELIGION</font> </td>
                 
                </tr>
                <tr> 
                  	<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=ip size=83 maxlength=50 >
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila1['bool_ip']==0)?"NO":"SI");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name=ip size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila1['bool_ip']==1)?"checked":"";
											?>>
											<?php };?>
										</TD>
                 	
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="checkbox" name=sar size=83 maxlength=50 > 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila1['bool_sar']==0)?"NO":"SI");
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="checkbox" name=sar size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila1['bool_sar']==1)?"checked":"";
											?>>
											<?php };?>
										</TD>
                </tr>
              </table></TD>
						</TR>

					<?php }else{?>
							<input type=hidden name=cmbSUB value=0> <!--SUBSECTOR INDETERMINADO-->
				<?php // }//FIN ENSEÑANZA CURSO?>
				<?php }//FIN TIPO ENSEÑANZA COLEGIO?>
				<?php if(($_TIPOINSTIT==2)||($_TIPOINSTIT==3)){//JARDIN O SALACUNA ?>
					<input type=hidden name=cmbSUB value=0> <!--SUBSECTOR INDETERMINADO-->
				<?php }?>
						<TR>
							<TD width=21></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
									<TR>
										
                  <TD colspan="2"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>MODO DE EVALUACION<FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp; 
                    &nbsp; <font face="Courier New, Courier, mono">&nbsp;</font></STRONG></FONT></STRONG></FONT> 
                  </TD>
                                        
									</TR>
									<TR>
										<TD width="39%">
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbMODO" >
													<option value=0 selected></option>
													<option value=1 >Numérico</option>
													<option value=2 >Conceptual</option>
												</Select>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													switch ($fila['modo_eval']) {
														 case 0:
															 imp('INDETERMINADO');
															 break;
														 case 1:
															 imp('Numérico');
															 break;
														 case 2:
															 imp('Conceptual');
															 break;
													 };
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<Select name="cmbMODO" >
													<option value=0></option>
											<option value=1 <?php echo ($fila['modo_eval'])==1?"selected":"" ?>>Numérico</option>
											<option value=2 <?php echo ($fila['modo_eval'])==2?"selected":"" ?>>Conceptual</option>
												</Select>
											    <?php };?>
										          </TD>
                                         
                                                  
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=21></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=2 CELLPADDING=2 width=100%>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>DOCENTE</STRONG>
											</FONT>
										</TD>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>AYUDANTE</STRONG>
											</FONT>
										</TD>
									</TR>
									<TR>
										<TD>
											<?php if($frmModo=="ingresar"){?>
												<Select name="cmbDOC">
													<option value=0 selected></option>;

													<?php
														$qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((trabaja.rdb)=".$institucion.")) order by empleado.ape_mat,empleado.ape_mat asc";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if(!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
																	exit();
																};
															}
															for($i=0 ; $i < @pg_numrows($result) ; $i++){
																$fila1 = @pg_fetch_array($result,$i);
																echo  "<option value=".$fila1["rut_emp"].">".$fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]."</option>";
															}
														};
													?>
												</Select>
											<?php };?>
											<?php 
												$qry2="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp) INNER JOIN ramo ON dicta.id_ramo = ramo.id_ramo WHERE (((ramo.id_ramo)=".$ramo.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
												$result2 =@pg_Exec($conn,$qry2);
												$fila2 = @pg_fetch_array($result2,0);	

												if($frmModo=="mostrar"){ 
													imp($fila2['ape_pat']." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"]);
												};
											?>
											<?php if($frmModo=="modificar"){?>
												<Select name="cmbDOC">
													<option value=0 selected></option>;
													<?php
														$qry2="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp) INNER JOIN ramo ON dicta.id_ramo = ramo.id_ramo WHERE (((ramo.id_ramo)=".$ramo.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
														$result2 =@pg_Exec($conn,$qry2);
														$fila2 = @pg_fetch_array($result2,0);	

														$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((institucion.rdb)=".$institucion.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
														$result5 =@pg_Exec($conn,$qry5);
														if (!$result5) 
															error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
														else{
															if (pg_numrows($result5)!=0){
																$fila5 = @pg_fetch_array($result5,0);
																if (!$fila5){
																	error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
																	exit();
																};
															}
															for($i=0 ; $i < @pg_numrows($result5) ; $i++){
																$fila5 = @pg_fetch_array($result5,$i);
																if($fila2["rut_emp"]!=$fila5["rut_emp"]){
																	echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
																}else{
																	echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
																}
															}
														};
													?>
												</Select>
											<?php };?>
										</TD>
										<TD>
											<?php if($frmModo=="ingresar"){ ?>
												<Select name="cmbAYU">
													<option value=0 selected></option>;
													<?php
														$qry="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((institucion.rdb)=".$institucion.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (13)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (14)</B>');
																	exit();
																};
															}
															for($i=0 ; $i < @pg_numrows($result) ; $i++){
																$fila1 = @pg_fetch_array($result,$i);
																echo  "<option value=".$fila1["rut_emp"].">".$fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]."</option>";
															}
														};
													?>
												</Select>
											<?php };?>
											<?php if($frmModo=="mostrar"){ ?>
													<?php
														$qry="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, ayuda.id_ramo FROM ayuda INNER JOIN empleado ON ayuda.rut_emp = empleado.rut_emp WHERE (((ayuda.id_ramo)=".$ramo.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
														$result =@pg_Exec($conn,$qry);
														if (!$result) 
															error('<B> ERROR :</b>Error al acceder a la BD. (13)</B>');
														else{
															if (pg_numrows($result)!=0){
																$fila1 = @pg_fetch_array($result,0);	
																if (!$fila1){
																	error('<B> ERROR :</b>Error al acceder a la BD. (14)</B>');
																	exit();
																};
																imp($fila1['ape_pat']." ".$fila1["ape_mat"].", ".$fila1["nombre_emp"]);
															};
														};
													?>
											<?php };?>
											<?php if($frmModo=="modificar"){?>
												<Select name="cmbAYU">
													<option value=0 ></option>;
													<?php 
														// ACTAL AYUDANTE DEL RAMO
														$qry8="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, ayuda.id_ramo FROM ayuda INNER JOIN empleado ON ayuda.rut_emp = empleado.rut_emp WHERE (((ayuda.id_ramo)=".$ramo.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";
														$result8 =@pg_Exec($conn,$qry8);
														$fila8  = @pg_fetch_array($result8,0);

														//TODOS LOS DOCENTES
														$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((trabaja.cargo)=".$docente.") AND ((institucion.rdb)=".$institucion.")) ORDER BY empleado.ape_mat,empleado.ape_mat ASC";

														$result5 =@pg_Exec($conn,$qry5);
														if (!$result5) 
															error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>');
														else{
															if (pg_numrows($result5)!=0){
																$fila5 = @pg_fetch_array($result5,0);
																if (!$fila5){
																	error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
																	exit();
																};
															}
															for($i=0 ; $i < @pg_numrows($result5) ; $i++){
																$fila5 = @pg_fetch_array($result5,$i);
																if($fila8["rut_emp"]!=$fila5["rut_emp"]){
                                                                   
																	echo  "<option value=".$fila5["rut_emp"].">".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
																}else{
																	echo  "<option value=".$fila5["rut_emp"]." selected>".$fila5["ape_pat"]." ".$fila5["ape_mat"].", ".$fila5["nombre_emp"]."</option>";
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
						<TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										   <TD>
											 <HR width="100%" color=#0099cc>
										   </TD>
									</TR>
  								</TABLE>
							</TD>
						</TR>
                         <TR>
							<TD colspan=4>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										 
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS INSCRITOS EN EL SUBSECTOR</strong></font> 
                  </td>
									</TR>
                                   <tr bgcolor="#0099cc">
                
				            
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>ELIMINAR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; </strong> 
                    </font>  
                    <?php  }  ?>&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; 
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>NOMBRE</strong> </font> </td>
				
			</tr>
			<?php    if(($frmModo=="modificar")||($frmModo=="mostrar")) {  ?>
                     <?php
				$qryP="SELECT tiene$nro_ano.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno)   WHERE (((tiene$nro_ano.id_ramo)=".$ramo.") AND((tiene$nro_ano.id_curso)=".$curso.")) order by ape_pat, ape_mat, nombre_alu asc ";
				$resultP =@pg_Exec($conn,$qryP);			
				if (pg_numrows($resultP)!=0){
					$filaP = @pg_fetch_array($resultP,0);	
					}
				?>
				<?php if ($frmModo=="modificar"){ ?>
			 <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong>
               <!--   <td><input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);">
                   Todos</td>-->
                       </strong></font>
					 <?php  }?>	
			<?php
					for($i=0 ; $i < @pg_numrows($resultP) ; $i++){
						$filaP = @pg_fetch_array($resultP,$i);
                           
			?>   
                  <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>           
                  <td align="left"> 
                    
					<?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alum[]" value=<?php echo $filaP["rut_alumno"];?>>  
					<?php } ?>                     
                               <?php    // }  ?> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                                <?php    if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?> 
								<font face="arial, geneva, helvetica" size="1" color="#000000">
									<strong><?php echo $filaP["ape_pat"]." ".$filaP["ape_mat"].", ".$filaP["nombre_alu"];?></strong>
								</font>
                                 <?php     } } ?>
							</td>
						</tr>
			<?php
					}
                  
                  
//				}
			?>
			<tr>
				<td colspan="3">
				<hr width="100%" color="#0099cc">
				</td>
			</tr>

                  <tr>
                    
                  <td> <font face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>ALUMNOS NO INSCRITOS</strong></font> </td>
									</TR>
                                   <tr bgcolor="#0099cc">
                
				            
                  <td align="left" width="289"> 
                    <?php    if($frmModo=="modificar"){  ?>
                    <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong>INSCRIBIR &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; </strong> </font> 
                    <?php    }  ?>
                    &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; <font face="arial, geneva, helvetica" size="1" color="#FFFFFF"> 
                    <strong> NOMBRE</strong> </font> </td>
				
			</tr>
					<?php    if(($frmModo=="modificar")|| ($frmModo=="mostrar")){  ?>
                       <?php
                 $qryA="SELECT * FROM (alumno inner join matricula on alumno.rut_alumno=matricula.rut_alumno) inner join curso on curso.id_curso=matricula.id_curso WHERE  curso.id_curso='".$curso."' and  alumno.rut_alumno NOT IN (SELECT rut_alumno FROM tiene$nro_ano WHERE tiene$nro_ano.id_ramo='".$ramo."')"; 
				    $resultA =@pg_Exec($conn,$qryA);
  					$filaA = @pg_fetch_array($resultA,0);
			                   ?>
							   <?php if ($frmModo=="modificar"){ ?>
			 						<font face="arial, geneva, helvetica" size="1" color="#FFFFFF"><strong>
                  <!--						<td><input type="checkbox" name="checkbox11" value="checkbox" onClick="ChequearTodos(this);">
                   						Todos</td>-->
                       				</strong></font>
					 		   <?php  }?>
			         <?php
					for($i=0 ; $i < @pg_numrows($resultA) ; $i++){
						$filaA = @pg_fetch_array($resultA,$i);
                           
			                ?>              
                                 
                   <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>							
                  <td align="left"> 
                    <?php if ($frmModo=="modificar"){ ?>
                    <input type="checkbox" name="alu[]" value=<?php echo $filaA["rut_alumno"];?>>                       
					<?php } ?>
                                  <?php  //  }  ?> &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; 
                                <?php   // if(($frmModo=="modificar")or($frmModo=="mostrar")) {  ?> 
								<font face="arial, geneva, helvetica" size="1" color="#666666">
									<strong><?php echo $filaA["ape_pat"]." ".$filaA["ape_mat"].", ".$filaA["nombre_alu"];?></strong>
								</font>
                                 <?php  }  ?>
							</td>
						</tr>
			<?php
					}
//				}
			?>
			<tr>
				<td colspan="3">
				<hr width="100%" color="#0099cc">
				</td>
  								</TABLE>
							</TD>
						</TR>
						<TR height=15>
							<TD colspan=2>
								<?php if($frmModo=="mostrar"){?>
										<?php
											$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
											$result =@pg_Exec($conn,$qry);
											if (pg_numrows($result)!=0){?>
												<INPUT TYPE="button" value="EVALUACION" onClick=document.location="notas/mostrarNotas.php3">
												<!--<input name="button" type="button" onClick=document.location="situacionFinal.php3?frmModo=mostrar" value="SITUACION FINAL ALUMNOS">--->
											<?php
												}else{
											?>
												<INPUT TYPE="button" value="EVALUACION" disabled> 
											<?php
												}
											?>
									<?php if($_PLAN>=2){ //PLUS O +?>
										<INPUT TYPE="button" value="CONTENIDO" onClick=document.location="contenido/listarContenidos.php3">
									<?php }?>
								<?php }else{?>
										<INPUT TYPE="button" value="EVALUACION" disabled>
									<?php if($_PLAN>=2){ //PLUS O +?>
										<INPUT TYPE="button" value="CONTENIDO" disabled>
									<?php }?>
								<?php }?>
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
														<li>Una vez finalizado el ingreso de la información presionar "GUARDAR" para grabar los datos, o bien "CANCELAR" para volver al listado de subsectores.</li>
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
													<li>"MODIFICAR" : Modifica la información del subsector ingresado.</li>
													<li>"ELIMINAR" : Elimina toda la información del subsector ingresado.</li>
													<li>"LISTADO" : Despliega el total de subsectores ingresadas.</li>
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