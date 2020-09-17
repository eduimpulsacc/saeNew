<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$tipoense		=$_TIPOENSE;
	$frmModo		=$_FRMMODO;
	$ensenanza		=$_ENSENANZA;
    $plan			=$_PLAN;
?>
<?php
  
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM tipo_ense_inst WHERE rdb=".$institucion." AND cod_tipo=".$ensenanza." AND cod_decreto=".$plan;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$qry);
					exit();
				}
			}
		}
	}
 
?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../util/td.css" TYPE="text/css">
	
<?php// if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		
    <?php if($frmModo=="modificar"){ ?>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					return false;
				};

				if(!chkFecha(form.txtFECHA,'Fecha invalida.')){
					return false;
				};
				
                if(!chkFecha(form.txtFECHAcierre,'Fecha invalida.')){
					return false;
				};

				if(!chkVacio(form.txtNUME2,'Ingresar NUMERO.')){
					return false;
				};
				
				if(!nroOnly(form.txtNUME2,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
				};				
				
				if(!nroOnly(form.txtNUMERO,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
				};

				if(!chkVacio(form.txtNUMdif,'Ingresar NUMERO DE GRUPOS DIFERENCIALES.')){
					return false;
				};
				
				function chkENS(form){
				         tipo=form.cmbTipoEnse.value;
				           if((tipo==110)){//ENSENANZA BASICA
					           form.cmbTipoEnse.disabled=true;
					         }else{
					           form.cmbEVAL.disabled=false;
				           };
				}
				return true;
			}
		
		</SCRIPT>
<?php }?>

          <?php if($frmModo=="ingresar"){ ?>
				<SCRIPT language="JavaScript">
				function valida(form){
						if(!chkVacio(form.txtNUME2,'Ingresar Número de resolución.')){
							return false;
						};

						if(!nroOnly(form.txtNUME2,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
						};
                        if(!nroOnly(form.txtNUMERO,'Se permiten sólo numeros en el Número de resolución.')){
							return false;
						};

						if(!chkVacio(form.txtNumDif,'Ingresar Nº de grupos Diferenciales.')){
							return false;
						};

                        if(!chkFecha(form.txtFECHA,'Fecha inválida.')){
					        return false;
				        };
                        if(!chkVacio(form.txtFECHA,'Ingresar FECHA.')){
					       return false;
				        };
						function chkENS(form){
				         tipo=form.cmbTipoEnse.value;
				           if((tipo<>110)){//ENSENANZA BASICA
					           form.txtNumDif.disabled=true;
					         }else{
					           form.txtNumDif.disabled=false;
				           };
						return true;
					}
				</SCRIPT>
		<?php };?>
	<?php //};?>
	</HEAD>
<BODY >
	<?php echo tope("../../../util/");?>
	<FORM method=post name="frm" action="../ensenanza/procesoEnsenanza.php3">
	<?php 
		echo "<input type=hidden name=rdb value=".$institucion.">";
		echo "<input type=hidden name=agrupacion value=".$ensenanza.">";
		echo "<input type=hidden name=plan value=".$plan.">";
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
                                            if($frmModo!="ingresar"){
											$qryEN="SELECT * FROM tipo_ensenanza WHERE cod_tipo=".$ensenanza;
											$resultEN =@pg_Exec($conn,$qryEN);
											if (!$resultEN) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
									 		}else{
												if (pg_numrows($resultEN)!=0){
													$fila1 = @pg_fetch_array($resultEN,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													            }
                                                           }                                                
												        }                                                    
											        }
                                                     $qry2="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											      $result2 =@pg_Exec($conn,$qry2);
                                                    $fila2 = @pg_fetch_array($result2,0);
													echo ($fila2['nombre_instit']);
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
              &nbsp; <input type="submit" value="GUARDAR"   name=btnGuardar2 onclick="return valida(this.form);">
              <INPUT TYPE="button" value="CANCELAR" name=btnCancelar onClick="window.history.go(-2)">&nbsp;
								<?php };?>

								<?php if($frmModo=="mostrar"){ ?>
									<?php if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
											<?php if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
										<INPUT TYPE="button" value="MODIFICAR" name=btnModificar  onClick=document.location="seteaTipoEnse.php3?ensenanza=<?php echo $ensenanza ?>&caso=3&plan=<?php echo $plan ?>&corre=<?php echo $corre ?>">&nbsp;
										<INPUT TYPE="button" value="ELIMINAR"  name=btnEliminar onClick=document.location="seteaTipoEnse.php3?caso=9;">&nbsp;
											<?php }?>
									<?php } //ACADEMICO Y LEGAL?>
									<INPUT TYPE="button" value="LISTADO" onClick=document.location="listarTiposEnsenanza.php3">&nbsp;
								<?php };?>
								<?php if($frmModo=="modificar"){ ?>
									<INPUT TYPE="submit" value="GUARDAR"   name=btnGuardar onclick="return valida(this.form);">&nbsp;
									<INPUT TYPE="button" value="CANCELAR" name=btnCancelar onclick="window.history.go(-3)">&nbsp;
								<?php };?>
							</TD>
						</TR>
						<TR align="left" bgcolor=#0099cc height=20>
							
            <TD colspan=2> <FONT face="arial, geneva, helvetica" size=2 color=White> 
              <strong>TIPO DE ENSE&Ntilde;ANZA&nbsp&nbsp&nbsp: </strong> </FONT><FONT face="arial, geneva, helvetica" size=3 color=White> <strong><?php echo ($fila1['cod_tipo'])?>&nbsp;-&nbsp;<?php echo ($fila1['nombre_tipo'])?></strong> 
              </FONT> </TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
									<TR>
							<?php if($frmModo=="ingresar"){ ?>			
                  <TD width="51%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>TIPOS DE ENSE&Ntilde;ANZAS</STRONG></FONT> &nbsp;&nbsp;&nbsp;</TD> <?php } ?>
                           <TD width="49%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>ESTADO DEL TIPO DE ENSEÑANZA </STRONG></FONT> </TD> 
									</TR>
									<TR>
										<TD align="left">
											<?php   if($frmModo=="ingresar"){   ?>                                                    
												<?php  if(($_PERFIL==1)||($_PERFIL==0)){                                                                                                                                                                               
                                                        $qry2="SELECT * FROM tipo_ensenanza ORDER BY cod_tipo ASC";                                                                                                              
		                                                   $result2	=@pg_Exec($conn,$qry2);
                                                            if (@pg_numrows($result2)!=0){;?>
                                                               <Select name="cmbTipoEnse" onChange="chkENS(this.form)">                                                                                                                      
                                                              <?php for($i=0 ; $i < @pg_numrows($result2) ; $i++){ 
                                                                 $fila2 = @pg_fetch_array($result2,$i);
                                                                  echo "<OPTION value=\"".trim($fila2['cod_tipo'])."\">".trim($fila2['nombre_tipo'])." </OPTION>\n";
                                                                   ?>
                                                               <?php };//for resultT                                                                                                                                                                               
	                                                                     ?>
													            </Select>
												<?php }else{
													imp('YA INGRESADAS');
												echo "<input type=hidden name=cmbESTADO value=0>";
													};?>
											<?php  };
                                                  };  ?>
                        <?php 
												if($frmModo=="mostrar"){ 
													switch ($fila["estado"]) {
														 case 0:
															 imp('FUNCIONANDO');
															 break;
														 case 1:
															 imp('AUTORIZADO SIN MATRICULA');
															 break;
														 case 2:
															 imp('CERRADO');
															 break;
													 };
												};
											?>
                                                      <?php if($frmModo=="modificar"){ ?>
                                                       <?php if(($_PERFIL==1)||($_PERFIL==0)){
													       ?>
                                                        <Select name="cmbESTADO">
														<?php if (pg_numrows($result)==0){?>
														
														   <option value=0>FUNCIONANDO </option>
														   <option value=1>AUTORIZADO SIN MATRICULA </option>
                                                           <option value=2 selected>CERRADO </option> <?php }
														    else{?>
														<?php  switch ($fila["estado"]) {
														 case 0:
															 echo "<option value=0 selected>".('FUNCIONANDO')."</option>"; ?>
															       <option value=1>AUTORIZADO SIN MATRICULA </option>
                                                        		   <option value=2>CERRADO </option>
															<?php break;
														 case 1:
															 echo "<option value=1 selected>".('AUTORIZADO SIN MATRICULA')."</option>";?>
															       <option value=2>CERRADO </option>
                                                               	   <option value=0>FUNCIONANDO </option>
															<? break;
														 case 2:
															 echo "<option value=2 selected>".('CERRADO')."</option>";?>
															  <option value=0>FUNCIONANDO</option>
                                                              <option value=1>AUTORIZADO SIN MATRICULA</option>   
															<?php break;
													 } };?>
														
													</Select>
												<?php }else{
													switch ($fila["estado"]) {
														 case 0:
															 imp('FUNCIONANDO');
															echo "<input type=hidden name=cmbESTADO value=0>";
															 break;
														 case 1:
															 imp('AUTORIZADO SIN MATRICULA');
															echo "<input type=hidden name=cmbESTADO value=1>";
															 break;
                                                          case 2:
															 imp('CERRADO');
															echo "<input type=hidden name=cmbESTADO value=2>";
															 break;
													 };
													};?>
											<?php };?>
                                       
										</TD>
                                             <TD align="left"><?php if($frmModo=="ingresar"){ ?>
												<?php if(($_PERFIL==1)||($_PERFIL==0)){?>
													<Select name="cmbESTADO">
														<option value=0 selected>FUNCIONANDO</option>
														<option value=1>AUTORIZADO SIN MATRICULA</option>
                                                        <option value=2>CERRADO</option>
													</Select>
                                             <?php 
													};?>
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
                  <TD width="56%" height="13"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>RESOLUCION DE AUTORIZACION DE TIPO DE ENSE&Ntilde;ANZA 
                    </strong></FONT> </TD>
									<TR>
               
										
                  <TD width="56%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>NUMERO</strong> </FONT> </TD>
                      <TD width="44%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <strong>FECHA</strong> </FONT> </TD>
									</TR>
									<TR>
										
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="text" name="txtNUME2" size=10 maxlength=10 onChange="nroOnly(this);"> 
                    <br>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    </FONT> 
                    <?php };?>
                    <?php 
												if($frmModo=="mostrar"){ 
													echo($fila['nu_resolucion']);
												};
											?>
                    <?php if($frmModo=="modificar"){ ?>
                    <input type=text name="txtNUME2" size=10 maxlength=10 value="<?php echo($fila['nu_resolucion'])?>"> 
                    <br>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                    </FONT> 
                    <?php };?>
                  </TD>
                                              <TD> <?php if($frmModo=="ingresar"){ ?>
												<input type="text" name="txtFECHA" size=15 maxlength=10>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													echo($fila['fecha_res']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="txtFECHA" size=15 maxlength=10 value=<?php impF($fila['fecha_res']);?>>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
                        <?php if($frmModo!="ingresar"){ ?>   
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100%>
                                    <TD width="56%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                                           <strong>RESOLUCION DE CIERRE DE TIPO DE ENSE&Ntilde;ANZA </strong></FONT> 
                                   </TD>
									<TR>
										<TD width="56%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                                           <strong>NUMERO</strong> </FONT> </TD>
                                             <TD width="44%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                                              <strong>FECHA</strong> </FONT> </TD>
									</TR>
									<TR>
										<TD>
											
                                          <?php if($frmModo=="ingresar"){ ?>
												<INPUT type="text" name="txtNUMERO" size=10 maxlength=10 >
												<br>
                                                <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                                                </FONT> 
                                               <?php };?>
                                          <?php 
												if($frmModo=="mostrar"){ 
													imp($fila['nu_resolucion_cierre']);
												};
											?>
                                          <?php if($frmModo=="modificar"){?>
                                               <INPUT type="text" name="txtNUMERO" size=10 maxlength=10 value="<?php echo($fila['nu_resolucion_cierre'])?>">
												<br>
                                                
                                              <?php };?>
                                       </TD>
                                              <TD> <?php if($frmModo=="ingresar"){ ?>
												<input type="text" name="txtFECHAcierre" size=15 maxlength=10>
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													impF($fila['fecha_res_cierre']);
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
												<input type=text name="txtFECHAcierre" size=15 maxlength=10 value="<?php impF($fila['fecha_res_cierre'])?>">
												<br>
												<FONT face="arial, geneva, helvetica" size=1 color=#000000>
													<STRONG>(DD-MM-AAAA)</STRONG>
												</FONT>
											<?php };?></TD>
									</TR>
								</TABLE>
							</TD>
						</TR>
                        <?php };?>  
						<TR>
							<TD width=30></TD>
							<TD>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width=100% align="top">
									<TR>
										
                                         <TD width="56%" height="15"> <FONT face="arial, geneva, helvetica" size=1 color=#000000>                                          
                                          EXISTENCIA DE CENTRO DE PADRES </FONT> </TD>
                                         <TD width="44%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                                        
                                          PERSONALIDAD JURIDICA </FONT> </TD>
									</TR>
									<TR>
										
                  <TD> 
                   <?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=ecp size=83 maxlength=50 >
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_ecp']==0)?"NO":"SI");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name=ecp size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila['bool_ecp']==1)?"checked":"";
											?>>
											<?php };?>
                  </TD>
                    <TD><?php if($frmModo=="ingresar"){ ?>
												<INPUT type="checkbox" name=pj size=83 maxlength=50 >
												
											<?php };?>
											<?php 
												if($frmModo=="mostrar"){ 
													imp( ($fila['bool_pj']==0)?"NO":"SI");
												};
											?>
											<?php if($frmModo=="modificar"){ ?>
											<INPUT type="checkbox" name=pj size=83 maxlength=50 value=1 
											<?php 
											  echo ($fila['bool_pj']==1)?"checked":"";
											?>>
											<?php };?>
                  </TD>
                                  

 
									</TR>
								</TABLE>
							</TD>
						</TR>
						<TR>
							<TD width=30></TD>
							<TD><?php if($ensenanza==110){ ?>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=0 width="100%">
                                   
                  <TD width="56%" height="13" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0> 
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>GRUPO DIFERENCIAL</STRONG> </FONT> </TD>
                                           <TD width="44%" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0>
                                              </TD>
									<TR>
										<TD>
											<FONT face="arial, geneva, helvetica" size=1 color=#000000>
												<STRONG>Nº DE GRUPOS DIFERENCIALES</STRONG>
											</FONT>
										</TD>
                                        <TD width="44%" valign="middle">
											
                                          <?php if($frmModo=="ingresar"){ ?>
												<input type=text name="txtNumDif" size=8 maxlength=10>
												<br>
                                               <FONT face="arial, geneva, helvetica" size=1 color=#000000>&nbsp; 
                                              </FONT> 
                                              <?php };?>
                                           <?php 
												if($frmModo=="mostrar"){ 
													echo($fila['nu_grupos_dif']);
												};
											?>
                                            <?php if($frmModo=="modificar"){ ?>
                                             <input type=text name="txtNumDif" size=8 maxlength=10 value=<?php echo($fila['nu_grupos_dif']);?> >
                                            <?php };?>
                  </TD>
									</TR>
									<TR>
										<TD>
										
										</TD>
									</TR>
								</TABLE>
								<?php }?>
							</TD>
						</TR>             <?php
                                          $qryH="SELECT * FROM hora_jm, tipo_ense_inst WHERE (hora_jm.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                       $resultH	=@pg_Exec($conn,$qryH);
                                                        if (@pg_numrows($resultH)!=0){;
                                                         $filaH = @pg_fetch_array($resultH,0);
                                                         };
                                           $qryT="SELECT * FROM hora_jt, tipo_ense_inst WHERE (hora_jt.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                       $resultT	=@pg_Exec($conn,$qryT);
                                                        if (@pg_numrows($resultT)!=0){;
                                                         $filaT = @pg_fetch_array($resultT,0);
													     };   
                                             $qryMT="SELECT * FROM hora_mt, tipo_ense_inst WHERE (hora_mt.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                           $resultMT	=@pg_Exec($conn,$qryMT);
                                                           if (@pg_numrows($resultMT)!=0){;
                                                           $filaMT = @pg_fetch_array($resultMT,0);
                                                           };
                                             $qryVN="SELECT * FROM hora_vn, tipo_ense_inst WHERE (hora_vn.corre = tipo_ense_inst.corre) AND (rdb=".$institucion.") AND (cod_decreto=".$plan.") and (cod_tipo=".$ensenanza.")";
                                                           $resultVN	=@pg_Exec($conn,$qryVN);
                                                           if (@pg_numrows($resultVN)!=0){;
                                                           $filaVN = @pg_fetch_array($resultVN,0);
												        };   
                                            

                                           ?>
                              <TR>
							<TD width=30 height="50"></TD>
							<TD valign="top">
                              <?php if($frmModo!="ingresar"){
							        if (pg_numrows($result)!=0){ ?>
								<TABLE BORDER=0 CELLSPACING=0 CELLPADDING=1 width="100%">
                <TD width="50%" align="left" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                  <STRONG>HORARIO</STRONG> </FONT> </TD>
                 <TD width="50%" align="left" bgcolor=#cccccc Border=0 cellpadding=1 cellspacing=0></TD>
                <TR> <?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                  <TD> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                   JORNADA MA&Ntilde;ANA</FONT> </TD> <?php };?>
                    <?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <TD><FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                        <strong>JORNADA MA&Ntilde;ANA Y TARDE </strong></FONT> </TD> <?php };?>
                </TR>
                <TR> 
                  <TD align="left" valign="top" nowrap> <p><FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <input type="checkbox" name="_JM" size=83 maxlength=50 >
                      <?php };?>
                      <?php 
												if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)) {
													imp("SI");
												};
											?>
                      <?php if($frmModo=="modificar"){ ?>
                      <INPUT type="checkbox" name="_JM" size=83 maxlength=50 value=1 
											<?php 
											  echo (@pg_numrows($resultH)!=0)?"checked":"";
											?>>
                      <?php };?>
                      </FONT></p></TD>
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="checkbox" name="_JMT" size=83 maxlength=50 > 
                    <?php };?>
                                          <FONT face="arial, geneva, helvetica" size=1 color=#000000>                   
                    <?php                                                      
												 if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)) { 
													imp("SI");
												    };
                                       ?>
                                          </FONT>
                    <?php if($frmModo=="modificar"){ 
					  ?>
                    <INPUT type="checkbox" name="_JMT" size=83 maxlength=50 value=1 
											<?php 
											  echo (@pg_numrows($resultMT)!=0)?"checked":"";
											?>> 
                    <?php };?></FONT></p>
                    </TD>
                </TR>
                     <TR>
                       
                  <TD align="left" valign="top"> 
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>HORA 
                    INICIO &nbsp;&nbsp;&nbsp;&nbsp;</STRONG> </FONT> 
                    <?php }; ?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraIni size=10 maxlength=50> 
                    <?php };?>
                    <?php 
											 if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)) { 
												imp($filaH['hora_ini']);
											
                                           };
										?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtHoraIni size=10 maxlength=50 value="<?php echo trim($filaH['hora_ini'])?>"> 
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                    </FONT>
                    <?php }; ?>
                  </TD>
                        
                  <TD align="left" valign="top"> 
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>HORA 
                    INICIO &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</STRONG> </FONT> 
                    <?php }; ?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraIniMT size=10 maxlength=50> 
                    <?php };?>
                    <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)) { 
											imp($filaMT['hora_ini']);
											};
                                           
										?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtHoraIniMT size=10 maxlength=50 value="<?php echo trim($filaMT['hora_ini'])?>"> 
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                    </FONT>
                    <?php }; ?>
                  </TD>
									</TR>

                                           <TR> 	
                  <TD align="left" valign="top">
                      <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                     <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>HORA TERMINO</STRONG> </FONT> <?php }; ?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraFin size=10 maxlength=50>
										<?php };?>
										<?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultH)!=0)){
                                               if (@pg_numrows($resultH)!=0){ 
												imp($filaH['hora_ter']);
											};
                                           };
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtHoraFin size=10 maxlength=50 value="<?php echo trim($filaH['hora_ter'])?>">
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultH)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                    </FONT> <?php }; ?></TD>
                              
                  <TD valign="top"> 
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>HORA 
                    TERMINO&nbsp;</STRONG> </FONT> 
                    <?php }; ?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraFinMT size=10 maxlength=50> 
                    <?php };?>
                    <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0)){
                                             if (@pg_numrows($resultMT)!=0){ 
												imp($filaMT['hora_ter']);
											};
                                          };
										?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtHoraFinMT size=10 maxlength=50 value="<?php echo trim($filaMT['hora_ter'])?>"> 
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultMT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                    </FONT> 
                    <?php }; ?>
                  </TD>
									</TR>

                                    <TR> 	
                                                    <TR>
                               </TR>
                                                                 
							<TR>
						<?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?> 			  
                        <TD width="33%" height="12"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                          JORNADA TARDE</FONT> </TD> <?php }; ?>
                         <?php if(($frmModo=="mostrar")or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>                
                          
						<?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>
						<TD width="33%"> <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                         <strong>JORNADA VESPERTINO/ NOCTURNA</strong></FONT> </TD> <?php } }; ?>
                                    
                                    </TR>
                                  <TR> 	
                  		<TD align="left" valign="top"> <p><FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <?php if($frmModo=="ingresar"){ ?>
                      <input type="checkbox" name="_JT" size=83 maxlength=50 >
                      <?php };?>
                      <?php             
                                               
												if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
													imp("SI");
												};
                                                   
											?>
                      <?php if($frmModo=="modificar"){ ?>
                      <INPUT type="checkbox" name="_JT" size=83 maxlength=50 value=1 
											<?php 
											  echo (@pg_numrows($resultT)!=0)?"checked":"";
											?>>
                                      <?php };?>
                      </FONT></p>
                    
                            </TD>
							    <?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>
                                        
                  <TD> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <input type="checkbox" name="_JVN" size=83 maxlength=50 >
                      <?php };?>
                                             <FONT face="arial, geneva, helvetica" size=1 color=#000000>       
                      <?php 
                                              
												if(($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0)){
 													imp("SI");
												};
                                          ?>
                                             </FONT>
                      <?php if($frmModo=="modificar"){
					       ?>
                      <INPUT type="checkbox" name="_JVN" size=83 maxlength=50 value=1 
											<?php 
											  echo (@pg_numrows($resultVN)!=0)?"checked":"";
											?>>
                      <?php };?>
                      </FONT></p>
                    

                                </TD>  
								<?php } ?>             
									</TR>
									<TR>
									 <BR>                                                                        
                                    </TR>
                                  <TR> 
                               	
                      
                  <TD align="left" valign="top"> 
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>HORA 
                    INICIO &nbsp;&nbsp;&nbsp;&nbsp;</STRONG> </FONT> 
                    <?php };?>
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraIniT size=10 maxlength=50> 
                    <?php };?>
                    <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
                                                if (@pg_numrows($resultT)!=0){ 
												imp($filaT['hora_ini']);
											  };
                                           };
										?>
                    <?php if($frmModo=="modificar"){ ?>
                    <INPUT type="text" name=txtHoraIniT size=10 maxlength=50 value="<?php echo trim($filaT['hora_ini'])?>"> 
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                    </FONT> 
                    <?php };?>
                  </TD>  
				   <?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>  
                   <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                 
                  <TD align="left" valign="top"> <p><FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                      <STRONG>HORA INICIO &nbsp;&nbsp;&nbsp;&nbsp;</STRONG> </FONT> 
                      <?php };?>
                      <?php if($frmModo=="ingresar"){ ?>
                      <INPUT type="text" name=txtHoraIniVN size=10 maxlength=50>
                      <?php };?>
                      <?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0)){
                                                 if (@pg_numrows($resultVN)!=0){
												imp($filaVN['hora_ini']);
											};
                                          };
										?>
                      <?php if($frmModo=="modificar"){ ?>
                      <INPUT type="text" name=txtHoraIniVN size=10 maxlength=50 value="<?php echo trim($filaVN['hora_ini'])?>">
                      <?php }; ?>
                      <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                      <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                      </FONT> 
                      <?php // };?>
                  </TD>
				     <?php } };?>
									</TR>

                                           <TR> 	
                  <TD align="left" valign="top">
                      <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                     <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                    <STRONG>HORA TERMINO</STRONG> </FONT> <?php };?> 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraFinT size=10 maxlength=50>
										<?php };?>
										<?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultT)!=0)){
                                               if (@pg_numrows($resultT)!=0){ 
												imp($filaT['hora_ter']);
											};
                                           };
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtHoraFinT size=10 maxlength=50 value="<?php echo trim($filaT['hora_ter'])?>">
                                       <?php }; ?>
                                       <?php if((($frmModo=="mostrar") and (@pg_numrows($resultT)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                                       <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                                       </FONT>  <?php }; ?></TD>
                       <?php if(($plan==771982) or ($plan==1901975) or ($plan==121987) or ($plan==1521989)) { ?>  
                      <TD align="left" valign="top">
                                      <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>
                                     <FONT face="arial, geneva, helvetica" size=1 color=#000000> 
                                       <STRONG>HORA TERMINO</STRONG> </FONT><?php }; ?>
										 
                    <?php if($frmModo=="ingresar"){ ?>
                    <INPUT type="text" name=txtHoraFinVN size=10 maxlength=50>
										<?php };?>
										<?php 
											if(($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0)){
                                               if (@pg_numrows($resultVN)!=0){
												imp($filaVN['hora_ter']);
											};
                                          };
										?>
										<?php if($frmModo=="modificar"){ ?>
												<INPUT type="text" name=txtHoraFinVN size=10 maxlength=50 value="<?php echo trim($filaVN['hora_ter'])?>">
                    <?php }; ?>
                    <?php if((($frmModo=="mostrar") and (@pg_numrows($resultVN)!=0))or($frmModo=="ingresar") or ($frmModo=="modificar")) { ?>  
                    <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>(HH:MM)</STRONG> 
                    </FONT> </TD> <?php  } }; ?>
                               
                                      
                                         
                                 
									</TR>
									<TR>
										<TD>
											
										</TD>
									</TR>
								</TABLE>
                         <?php } }; ?>
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
						<TR height=15>
							<TD width="100%" colspan=2>
								
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
</BODY>
</HTML>