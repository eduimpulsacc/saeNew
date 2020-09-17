<?php require('../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$_ALUMNO;
	$curso			=$_CURSO;
	$frmModo		="mostrar";

?>
<?php
	if($frmModo!="ingresar"){
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
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
		<style type="text/css">
		<!--
			table  { 
				color: black; 
				font-style: normal; 
				font-weight: bold; 
				font-size: 11px; 
				font-family: arial, geneva, helvetica; 
				text-decoration: none 
			}

			.button {
				font-family :  Arial,Verdana, Helvetica, sans-serif;
				font-size : 10px;
				font-weight : bold;
			}
		//-->
		</style>

			<SCRIPT language="JavaScript">
				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}
			</SCRIPT>
	</HEAD>
<BODY leftMargin=0 topMargin=0 marginwidth="0" marginheight="0">
	    
<TABLE WIDTH=100% align="center" cellpadding="0" cellspacing="0" background="imagenes/background.gif">
  <TR> 
    <TD height="100"> 
      <div align="center"><img src="imagenes/superior_alumno.gif" height="99 width="600"></div></TD>
  </TR>
</TABLE>
		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 width=100%>
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
							<td rowspan=4>
								<TABLE BORDER=3 CELLSPACING=5 CELLPADDING=5>
									<TR>
										<TD>
											<?php
											
												$result = @pg_Exec($conn,"select * from alumno where rut_alumno=".$alumno);
												$arr=@pg_fetch_array($result,0);

												$output= "select lo_export(".$arr[foto].",'/var/www/html/tmp/".$arr[rut_alumno]."');";
												$retrieve_result = @pg_exec($conn,$output);
												
											?>
											<img src=../../tmp/<?php echo $arr[rut_alumno] ?> ALT="NO DISPONIBLE" width=150>
										</TD>
									</TR>
								</TABLE>
							</td>
						</TR>
						<TR>
							
          <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
            ESCOLAR</strong> </FONT> </TD>
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
						 	// --- se agrego al query "tipo_ensenanza.cod_tipo" (pmeza) -----------
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo,tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
							// ---------------------------------------------------------------------
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
													$tipo=$fila1['cod_tipo'];
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
											$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO=".$alumno;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['ape_pat'])." ".trim($fila1['ape_mat'])." ".trim($fila1['nombre_alu']);
													
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
						<TR height="50">
							<TD align=right>
							<INPUT TYPE="button" value="CONTENIDOS"  class="button" onClick=document.location="fichaContenidos.php3">
							<INPUT TYPE="button" value="FICHA MEDICA"  class="button"onClick=document.location="seteaFichaMed.php3">
							<INPUT TYPE="button" value="FICHA DEPORTIVA"  class="button"onClick=document.location="fichaDeportiva.php3">
							<INPUT TYPE="button" value="FICHA APODERADOS"  class="button"onClick=document.location="fichaApoderados.php3">
							<INPUT TYPE="button" value="SALIR"  class="button" onClick="window.open('../util/logout.php3', '_parent')">
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>EVALUACION</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			</TR>

	<?php if($tipo>100){ //ENSEÑANZA BASICA O SUPERIOR?>
			<TR height=15>
			<!-- INICIO FILA -->						
				<TD>
					<?php if($_TIPOREGIMEN==2 ){//TRIMESTRAL?>
					<!-- INICIO TRES PERIDOS -->						
						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
							<TR>
								
                  <TD> <table border=1 cellspacing=2 cellpadding=2 width=100%>
                      <tr> 
                        <!--TD COLSPAN=46>NOTAS</TD-->
                        <td colspan=40>NOTAS</td>
                      </tr>
                      <tr> 
                        <?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												
												?>
                        <td width="15%">SUBSECTORES</td>
                        <td width="1%"></td>
                        <td colspan=20> 
                          <?php 
															$fila6 = @pg_fetch_array($result6,0);
															echo trim($fila6['nombre_periodo']);
															$idPer1=$fila6['id_periodo'];
														?>
                        </td>
                        <td width="1%"></td>
                        <td width="3%">PT</td>
                        <!--TD>PC</TD-->
                        <td width="3%"></td>
                        <td width="3%"></td>
                        <td width="3%"></td>
                        <?php
												}
											}
										?>
                      </tr>
                      <!--OBTENER RAMOS DEL CURSO Y POR CADA RAMO LAS NOTAS DEL ALUMNO-->
                      <?php
											$PTot	=0;	//PROMEDIO TOTAL
											$cantT	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TOTAL
											$PP1	=0;	//PROMEDIO PRIMER PERIODO
											$cantP1	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO PRIMER PERIODO
											$PP2	=0;	//PROMEDIO SEGUNDO PERIODO
											$cantP2	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO SEGUNDO PERIODO
											$PP3	=0;	//PROMEDIO TERCER PERIODO
											$cantP3	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TERCER PERIODO

											$qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene3 ON (ramo.id_curso = tiene3.id_curso)and (ramo.id_ramo =tiene3.id_ramo) WHERE (((tiene3.id_curso)=".$curso.")and ((tiene3.rut_alumno)=".$alumno."))";

											$result3 =@pg_Exec($conn,$qry3);
											if (!$result3) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result3)!=0){
													$fila3 = @pg_fetch_array($result3,0);	
													if (!$fila3){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result3) ; $i++){//TOTAL RAMOS DEL CURSO
														//POR CADA RAMO DEL CURSO, PARA LOS TRES PERIODOS
														$fila3 = @pg_fetch_array($result3,$i);
														$PGral	=0;	//PROMEDIO GENERAL
														$cant	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO
										?>
                      <tr> 
                        <td><?php echo trim($fila3['nombre_ramo']);?></td>
                        <?php
																//PRIMER PERIODO
																$qry8="SELECT notas.* FROM notas WHERE (((notas.rut_alumno)=".$alumno.") AND ((notas.id_periodo)=".$idPer1.") AND ((notas.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
                        <td></td>
                        <!--PRIMER PERIODO-->
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 }
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 }
																				?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 }
																				?>
                        </td>
                        <td width="1%"></td>
                        <td width="3%"> 
                          <?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo trim($fila8['promedio']);
																	if ($fila3['modo_eval']!=2){
																		if ((trim($fila8['promedio'])!="") and (trim($fila8['promedio'])!=0)) {
																			$PGral=(int) trim($fila8['promedio']);
																			$cant=1;

																			$PP1	=$PP1 + (int) trim($fila8['promedio']);
																			$cantP1	=$cantP1 + 1;

																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[0] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
                        </td>
                        <!--TD>3c</TD-->
                        <td width="3%"></td>
                        <?php //}	?>
                        <td width="3%"></td>
                        <?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
                        <!--FIN RAMO-->
                        <td> </td>
                      <tr> 
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=20>&nbsp; </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>PG1</td>
                        <td width="3%"></td>
                        <td width="3%"> 
                          <?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas.* from notas inner join tiene3 on notas.id_ramo=tiene3.id_ramo where notas.rut_alumno='".$alumno."'and id_periodo=".$idPer1;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						if ($cont > 0){
						$Gen1=($prom/$cont);
						echo (round($Gen1));	
						  }						
						 ?>
                        </td>
                      </tr>
                      <?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
                      <td>SUBSECTORES</td>
                      <td></td>
                      <td colspan=20> 
                        <?php 
															$fila6 = @pg_fetch_array($result6,1);
															echo trim($fila6['nombre_periodo']);
															$idPer2=$fila6['id_periodo'];
														?>
                      </td>
                      <!--TD>PC</TD-->
                      <!--TD>PC</TD-->
                      <td></td>
                      <td>PT</td>
                      <!--TD>PC</TD-->
                      <td></td>
                      <td width="3%"></td>
                      </tr>
                      <?php
												}
											}
										?>
                      <!--OBTENER RAMOS DEL CURSO Y POR CADA RAMO LAS NOTAS DEL ALUMNO-->
                      <?php
											$PTot	=0;	//PROMEDIO TOTAL
											$cantT	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TOTAL
											$PP1	=0;	//PROMEDIO PRIMER PERIODO
											$cantP1	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO PRIMER PERIODO
											$PP2	=0;	//PROMEDIO SEGUNDO PERIODO
											$cantP2	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO SEGUNDO PERIODO
											$PP3	=0;	//PROMEDIO TERCER PERIODO
											$cantP3	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TERCER PERIODO

											$qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene3 ON (ramo.id_curso = tiene3.id_curso)and (ramo.id_ramo =tiene3.id_ramo) WHERE (((tiene3.id_curso)=".$curso.")and ((tiene3.rut_alumno)=".$alumno."))";

											$result3 =@pg_Exec($conn,$qry3);
											if (!$result3) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result3)!=0){
													$fila3 = @pg_fetch_array($result3,0);	
													if (!$fila3){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result3) ; $i++){//TOTAL RAMOS DEL CURSO
														//POR CADA RAMO DEL CURSO, PARA LOS TRES PERIODOS
														$fila3 = @pg_fetch_array($result3,$i);
														$PGral	=0;	//PROMEDIO GENERAL
														$cant	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO
										?>
                      <tr> 
                        <td><?php echo trim($fila3['nombre_ramo']);?></td>
                        <?php
																//PRIMER PERIODO
																
																$qry8="SELECT notas.* FROM notas WHERE (((notas.rut_alumno)=".$alumno.") AND ((notas.id_periodo)=".$idPer2.") AND ((notas.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
                        <td></td>
                        <!--PRIMER PERIODO-->
                        <td > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																				?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																				?>
                        </td>
                        <td></td>
                        <td> 
                          <?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo (trim($fila8['promedio']));
																	
																	if ($fila3['modo_eval']!=2){
																		if (trim($fila8['promedio'])!=""){
																			$PGral=((int) trim($fila8['promedio'])) + $PGral;
																			$cant=$cant + 1;

																			$PP2	=$PP2 + (int) trim($fila8['promedio']);
																			$cantP2	=$cantP2 + 1;
																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[1] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
                        </td>
                        <!--TD>3c</TD-->
                        <td></td>
                        <?php //}	?>
                        <td></td>
                        <td width="3%"></td>
                        <?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
                        <!--FIN RAMO-->
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=20>&nbsp; </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>PG2</td>
                        <td width="3%"></td>
                        <td width="3%"> 
                          <?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas.* from notas inner join tiene3 on notas.id_ramo=tiene3.id_ramo where notas.rut_alumno='".$alumno."'and id_periodo=".$idPer2;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						 if ($cont >0){
						$Gen2=($prom/$cont);
						echo (round($Gen2));	
						  }						
						 ?>
                        </td>
                      </tr>
                      <tr> 
                        <?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
                        <td>SUBSECTORES</td>
                        <td></td>
                        <td colspan=20> 
                          <?php 
															$fila6 = @pg_fetch_array($result6,2);
															echo trim($fila6['nombre_periodo']);
															$idPer3=$fila6['id_periodo'];
														?>
                        </td>
                        <!--TD>PC</TD-->
                        <!--TD>PC</TD-->
                        <td></td>
                        <td>PT</td>
                        <!--TD>PC</TD-->
                        <td></td>
                        <?php
												}
											}
										?>
                      </tr>
                      <!--OBTENER RAMOS DEL CURSO Y POR CADA RAMO LAS NOTAS DEL ALUMNO-->
                      <?php
											$PTot	=0;	//PROMEDIO TOTAL
											$cantT	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TOTAL
											$PP1	=0;	//PROMEDIO PRIMER PERIODO
											$cantP1	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO PRIMER PERIODO
											$PP2	=0;	//PROMEDIO SEGUNDO PERIODO
											$cantP2	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO SEGUNDO PERIODO
											$PP3	=0;	//PROMEDIO TERCER PERIODO
											$cantP3	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TERCER PERIODO

											$qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene3 ON (ramo.id_curso = tiene3.id_curso)and (ramo.id_ramo =tiene3.id_ramo) WHERE (((tiene3.id_curso)=".$curso.")and ((tiene3.rut_alumno)=".$alumno."))";

											$result3 =@pg_Exec($conn,$qry3);
											if (!$result3) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result3)!=0){
													$fila3 = @pg_fetch_array($result3,0);	
													if (!$fila3){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result3) ; $i++){//TOTAL RAMOS DEL CURSO
														//POR CADA RAMO DEL CURSO, PARA LOS TRES PERIODOS
														$fila3 = @pg_fetch_array($result3,$i);
														$PGral	=0;	//PROMEDIO GENERAL
														$cant	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO
										?>
                      <tr> 
                        <td><?php echo trim($fila3['nombre_ramo']);?></td>
                        <?php
																//PRIMER PERIODO
																
																$qry8="SELECT notas.* FROM notas WHERE (((notas.rut_alumno)=".$alumno.") AND ((notas.id_periodo)=".$idPer3.") AND ((notas.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
                        <td></td>
                        <!--PRIMER PERIODO-->
                        <td > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																				?>
                        </td>
                        <td width="3%" > 
                          <?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																				?>
                        </td>
                        <td></td>
                        <td> 
                          <?php 
																				if($fila8['mostrar_notas'])
																				echo ("&nbsp;");
																				echo trim($fila8['promedio']);
																				if ($fila3['modo_eval']!=2){
																					if (trim($fila8['promedio'])!=""){
																						$PGral=((int) trim($fila8['promedio'])) + $PGral;
																						$cant=$cant + 1;

																						$PP3	=$PP3 + (int) trim($fila8['promedio']);
																						$cantP3	=$cantP3 + 1;
																					};
																				}else{
																					if ($fila3['modo_eval']==2){
																						if (trim($fila8['promedio'])!=""){
																							$notacon[2] = trim($fila8['promedio']);
																						};
																					};
																				};
																			?>
                        </td>
                        <!--TD>3c</TD-->
                        <td></td>
                        <?php //}	?>
                        <td width="3%"></td>
                        <td></td>
                        <?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=20>&nbsp; </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>PG3</td>
                        <td width="3%"></td>
                        <td width="3%"> 
                          <?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas.* from notas inner join tiene3 on notas.id_ramo=tiene3.id_ramo where notas.rut_alumno='".$alumno."'and id_periodo=".$idPer3;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						if($cont > 0){
						$Gen3=($prom/$cont);
						echo (round($Gen3));	
						  }						
						 ?>
                        </td>
                      </tr>
                      <tr> 
                        <td>&nbsp;</td>
                        <td></td>
                        <td colspan=9>&nbsp; </td>
                        <!--TD>PC</TD-->
                        <td colspan=9>&nbsp; </td>
                        <!--TD>PC</TD-->
                        <td colspan=2>&nbsp; </td>
                        <td></td>
                        <td>&nbsp;</td>
                        <!--TD>PC</TD-->
                       
                      </tr>
                      <!--FIN RAMO-->
                      <tr height=5 bgcolor=black> 
                        <td colspan=39></td>
                      </tr>
                      <tr> 
                        <td colspan=12></td>
                        <td colspan=11></td>
                        <td colspan=9></td>
                        <td width="3%"></td>
                        <td width="2%"></td>
                        <td width="4%"></td>
                      </tr>
                      <tr height=20> 
                        <td colspan=38></td>
                      </tr>
                      <tr> 
                        <td colspan=24></td>
                        <td colspan=10>PROMEDIO GENERAL</td>
                        <td> 
                          <?php 
						  $sum=0; 
						  	   $Total=$Gen1+$Gen2+$Gen3;
							   if ($Gen1 >0){
							    $sum=$sum+1;
								}
								if ($Gen2 >0){
								$sum=$sum+1;
								}
								if ($Gen3 >0){
								$sum=$sum+1;
								}
								if ($sum > 0){
								$PromGen=($Total/$sum);
								echo (round($PromGen));
								}									
													?>
                        </td>
                      </tr>
                    </table></TD>
							</TR>
						</TABLE>
					<!-- FIN TRES PERIODOS-->
					<?php }//FIN TRIMESTRAL?>
					
					<?php if($_TIPOREGIMEN==3){//SEMESTRAL?>
					<!-- INICIO DOS PERIDOS -->						
						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
							<TR>
								<TD>
									<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
										<TR>
											<!--TD COLSPAN=46>NOTAS</TD-->
											<TD COLSPAN=40>NOTAS</TD>
										</TR>
										<TR>
										<?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
													 <td width="10%">SUBSECTORES</td>
													<td width="1%"></td>
													<TD colspan=9>
														<?php 
															$fila6 = @pg_fetch_array($result6,0);
															echo trim($fila6['nombre_periodo']);
															$idPer1=$fila6['id_periodo'];
														?>
													</TD>
													
													
                        
													<!--TD>PC</TD-->
													
													
                        <TD colspan=11>&nbsp; </TD>
													 <td width="1%"></td>
													
                        <td width="3%">PS</td>
													<!--TD>PC</TD-->
													<td width="3%"></td>
													<td width="3%"></td>
													<td width="3%"></td>
												<?php
												}
											}
										?>
													</TR>
										<!--OBTENER RAMOS DEL CURSO Y POR CADA RAMO LAS NOTAS DEL ALUMNO-->
										<?php
											$PTot	=0;	//PROMEDIO TOTAL
											$cantT	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TOTAL
											$PP1	=0;	//PROMEDIO PRIMER PERIODO
											$cantP1	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO PRIMER PERIODO
											$PP2	=0;	//PROMEDIO SEGUNDO PERIODO
											$cantP2	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO SEGUNDO PERIODO
                                            $qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene3 ON (ramo.id_curso = tiene3.id_curso)and (ramo.id_ramo =tiene3.id_ramo) WHERE (((tiene3.id_curso)=".$curso.")and ((tiene3.rut_alumno)=".$alumno."))";
											//$qry3="SELECT subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
											$result3 =@pg_Exec($conn,$qry3);
											if (!$result3) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result3)!=0){
													$fila3 = @pg_fetch_array($result3,0);	
													if (!$fila3){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};

													for($i=0 ; $i < @pg_numrows($result3) ; $i++){//TOTAL RAMOS DEL CURSO
														//POR CADA RAMO DEL CURSO, PARA LOS TRES PERIODOS
														$fila3 = @pg_fetch_array($result3,$i);
														$PGral	=0;	//PROMEDIO GENERAL
														$cant	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO
										?>
														<TR>
															<TD><?php echo trim($fila3['nombre_ramo']);?></TD>
															<?php
																//PRIMER PERIODO
																
																$qry8="SELECT notas.* FROM notas WHERE (((notas.rut_alumno)=".$alumno.") AND ((notas.id_periodo)=".$idPer1.") AND ((notas.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);
															?>
															<TD></TD>		<!--PRIMER PERIODO-->
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if((trim($fila8['nota1'])==0)or(trim($fila8['nota1'])=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 

																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?> 
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
																</TD> 
															
															
                       
															<!--TD>1c</TD-->
															
																	<!--SEGUNDO PERIODO-->
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																	?>
																</TD> 
															<TD></TD>
															<TD>
																<?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo trim($fila8['promedio']);
																	if ($fila3['modo_eval']!=2){
																		if ((trim($fila8['promedio'])!="") and (trim($fila8['promedio'])!=0)) {
																			$PGral=(int) trim($fila8['promedio']);
																			$cant=1;

																			$PP1	=$PP1 + (int) trim($fila8['promedio']);
																			$cantP1	=$cantP1 + 1;

																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[0] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
															</TD>
															<!--TD>2c</TD-->
															<?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
															
                        <TD>PG1</TD>
								<?php //}	?>
															<TD>
																<?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas.* from notas inner join tiene3 on notas.id_ramo=tiene3.id_ramo where notas.rut_alumno='".$alumno."'and id_periodo=".$idPer1;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						if ($cont > 0){
						$Gen1=($prom/$cont);
						echo (round($Gen1));	
						  }
						
						 ?>
															</TD>
									
	<!--FIN RAMO-->
	
									<TR>
										<?php
											$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
												?>
													<TD>SUBSECTORES</TD>
													<TD></TD>
													<TD colspan=9>
														<?php 
															$fila6 = @pg_fetch_array($result6,1);
															echo trim($fila6['nombre_periodo']);
															$idPer2=$fila6['id_periodo'];

														?>
													</TD>
													
													
                       
													<!--TD>PC</TD-->
													
													
                        <TD colspan=11>&nbsp; </TD>
													<TD></TD>
													<TD>PS</TD>
													<!--TD>PC</TD-->
													<TD></TD>
													<TD></TD>
												<?php
												}
											}
										?>
													</TR>
										<!--OBTENER RAMOS DEL CURSO Y POR CADA RAMO LAS NOTAS DEL ALUMNO-->
										<?php
											$PTot	=0;	//PROMEDIO TOTAL
											$cantT	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO TOTAL
											$PP1	=0;	//PROMEDIO PRIMER PERIODO
											$cantP1	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO PRIMER PERIODO
											$PP2	=0;	//PROMEDIO SEGUNDO PERIODO
											$cantP2	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO SEGUNDO PERIODO
                                            $qry3="SELECT  subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM (ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector) INNER JOIN tiene3 ON (ramo.id_curso = tiene3.id_curso)and (ramo.id_ramo =tiene3.id_ramo) WHERE (((tiene3.id_curso)=".$curso.")and ((tiene3.rut_alumno)=".$alumno."))";
											//$qry3="SELECT subsector.nombre as nombre_ramo, ramo.id_ramo, ramo.modo_eval FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
											$result3 =@pg_Exec($conn,$qry3);
											if (!$result3) 
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											else{
												if (pg_numrows($result3)!=0){
													$fila3 = @pg_fetch_array($result3,0);	
													if (!$fila3){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result3) ; $i++){//TOTAL RAMOS DEL CURSO
														//POR CADA RAMO DEL CURSO, PARA LOS TRES PERIODOS
														$fila3 = @pg_fetch_array($result3,$i);
														$PGral	=0;	//PROMEDIO GENERAL
														$cant	=0;	//CANTIDAD DE NOTAS PARA PROMEDIO

												?>
														<TR>
															<TD><?php echo trim($fila3['nombre_ramo']);?></TD>
															<?php
																//PRIMER PERIODO
																
																$qry8="SELECT notas.* FROM notas WHERE (((notas.rut_alumno)=".$alumno.") AND ((notas.id_periodo)=".$idPer2.") AND ((notas.id_ramo)=".$fila3['id_ramo']."))";
																$result8 =@pg_Exec($conn,$qry8);

															?>
															<TD></TD>		<!--SEGUNDO PERIODO-->
								<td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota1']==0)or($fila8['nota1']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota1']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota2']==0)or($fila8['nota2']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota2']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota3']==0)or($fila8['nota3']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota3']));
																		 } 
																	?> 
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota4']==0)or($fila8['nota4']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota4']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota5']==0)or($fila8['nota5']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota5']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota6']==0)or($fila8['nota6']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota6']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota7']==0)or($fila8['nota7']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota7']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota8']==0)or($fila8['nota8']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota8']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota9']==0)or($fila8['nota9']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota9']));
																		 } 
																	?>
																</TD> 
															
															
                       
															<!--TD>1c</TD-->
															
																	<!--SEGUNDO PERIODO-->
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota10']==0)or($fila8['nota10']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota10']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota11']==0)or($fila8['nota11']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota11']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota12']==0)or($fila8['nota12']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota12']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota13']==0)or($fila8['nota13']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota13']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota14']==0)or($fila8['nota14']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota14']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota15']==0)or($fila8['nota15']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota15']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota16']==0)or($fila8['nota16']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota16']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota17']==0)or($fila8['nota17']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota17']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota18']==0)or($fila8['nota18']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota18']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota19']==0)or($fila8['nota19']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota19']));
																		 } 
																	?>
																</TD> 
																 <td width="3%" >
																	<?php 
																		$fila8 = @pg_fetch_array($result8,0);
																		if(($fila8['nota20']==0)or($fila8['nota20']=="")){
																		imp(trim("."));
																		}else{
																		 imp(trim($fila8['nota20']));
																		 } 
																	?>
																</TD> 
															<TD></TD>
															<TD>
																<?php 
																	if($fila8['mostrar_notas'])
																	echo ("&nbsp;");
																	echo trim($fila8['promedio']);
																	if ($fila3['modo_eval']!=2){
																		if ((trim($fila8['promedio'])!="") and (trim($fila8['promedio'])!=0)) {
																			$PGral=(int) trim($fila8['promedio']);
																			$cant=1;

																			$PP1	=$PP1 + (int) trim($fila8['promedio']);
																			$cantP1	=$cantP1 + 1;

																		};
																	}else{
																		if ($fila3['modo_eval']==2){
																			if (trim($fila8['promedio'])!=""){
																				$notacon[0] = trim($fila8['promedio']);
																			};
																		};
																	};
																?>
															</TD>
															<!--TD>2c</TD-->
																<?php

													}//FIN TOTAL RAMOS DEL CURSO
												}//FIN SI LA CANTIDAD DE RESULTADOS ES <> 0
											};//FIN ELSE CONEXION RESULT3
										?>
															
                        <TD>PG2</TD>
								<?php //}	?>
															<TD>
																<?php 
						$cont=0;
						$prom=0;
						
						 $qry77="Select distinct notas.* from notas inner join tiene3 on notas.id_ramo=tiene3.id_ramo where notas.rut_alumno='".$alumno."'and id_periodo=".$idPer2;
						 $result77 =@pg_Exec($conn,$qry77);
						    if(@pg_numrows($result77)==0){
							
							}
						 for($i=0 ; $i < @pg_numrows($result77) ; $i++){
						 $fila77 = @pg_fetch_array($result77,$i);
						  if (($fila77['promedio']!=0) and ($fila77['promedio']!="")){
						    $prom=$prom + $fila77['promedio'];
						     $cont=$cont+1;
							}
						}
						 if ($cont >0){
						$Gen2=($prom/$cont);
						echo (round($Gen2));	
						  }
						
						 ?>
															</TD>
									
	<!--FIN RAMO-->
														
														<TR height=5 bgcolor=black>
															<TD colspan=29></TD>
														</TR>
														<TR>
															<TD colspan=12></TD>
															
															<TD colspan=11></TD>
															
															<TD></TD>
															
                        <TD></TD>
																<TD></TD>
														</TR>
														<TR height=20>
															<TD colspan=31></TD>
														</TR>
														<TR>
															<TD colspan=24></TD>
															<TD colspan=10>PROMEDIO GENERAL</TD>
															<TD>
																<?php 
						  $sum=0; 
						  	   $Total=$Gen1+$Gen2+$Gen3;
							   if ($Gen1 >0){
							    $sum=$sum+1;
								}
								if ($Gen2 >0){
								$sum=$sum+1;
								}
								
								if ($sum > 0){
								$PromGen=($Total/$sum);
								echo (round($PromGen));
								}									
													?>
															</TD>
														</TR>
									</TABLE>
								</TD>
							</TR>
						</TABLE>
					
              <!-- FIN DOS PERIDOS -->
              <?php 
			     }//FIN SEMESTRAL?>				</TD>
			<!-- FIN FILA -->						
			</TR>
	<?php } //FIN ENSEÑANZA BASICA O SUPERIOR?>

	<?php if ( trim($tipo)==10 || trim($tipo)==20){ //ENSEÑANZA SALACUNA?>			
		<TR height=15>
		<!-- INICIO FILA -->						
			<TD>
				<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
					<TR height=20 bgcolor=#0099cc>
						<TD align=middle BGCOLOR=WHITE>

						<?php
						//------------------------------------------------/ SALAS CUNAS /----------------------------------------
						 if ( trim($tipo)==10 || trim($tipo)==20) {

							 
						$qry="select * from maestrto_evaluacion where nivel_ev=1";
						$qry_det="SELECT ed.nro_eva, ed.evaluacion AS ES0, (SELECT   evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=1  AND   nivel_ev=ed.nivel_ev  AND  rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES1, (SELECT   evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=2  AND   nivel_ev=ed.nivel_ev  AND  rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES2, (SELECT   evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=3  AND   nivel_ev=ed.nivel_ev  AND  rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES3 FROM evaluacion_detalle_nin AS ed WHERE (((ed.semestre)=0) AND ((ed.nivel_ev)=1) AND ((ed.rut_alumno)=$alumno) AND ((ed.ano)=$ano));";

							$rt = @pg_Exec($conn,$qry_det);
							$result = @pg_Exec($conn,$qry);
							if ((!$result) && (!$rt))
								error('<B> ERROR :</b>Error al acceder a la BD. </B>');
							else {
							?>
						<!---------------------------/ encabezado / -----------------------------------------!-->
						<?php

						// 2 trimestral  ; 3 semestral 

						$resultTPR  = @pg_Exec($conn,"SELECT tipo_regimen from institucion where rdb=".$institucion);
						$fla     = @pg_fetch_array($resultTPR,0);
						if (trim($fla[0])=="2") 
							  $N=3;
						if (trim($fla[0])=="3") 
							  $N=2;
						//------------------------------
							include('cabecera3.php');
						//------------------------------
						?>

						<table border="0" cellpadding="0" cellspacing="1" width="100%" bgcolor="black">
						<tr>
						   <td>
							  <table border="0" cellpadding="0" cellspacing="1" width="100%" height="51">
								   <tr height="29">
										  <td height="29" bgcolor="#336699" width="33">
												  <div align="center">
														<font color="white" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1">
															<b>N&ordm; Preg.</b>
											</font>
										</div>
									</td>
									<td height="29" bgcolor="#336699" width="191">
										<font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
													Pregunta 
											</font>
									</td>
									<td height="29" bgcolor="#336699">
										<div align="center">
											<font color="white" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1">
													Evaluaci&oacute;n Diagn&oacute;stica
											</font>
										</div>
									</td>
								<?php

								$letra=array (
									  0 =>"b", 
									  1 =>"c",
									  2 =>"d");
								
									$semestre=array (
									  0 =>"Primer ", 
									  1 =>"Segundo",
									  2 =>"Tercer");
									$tipo=array (
									  3 =>"trimestre", 
									  2 =>"Semestre");

									for($i=0;$i<$N;$i++) {
								?>
									<td height="29" bgcolor="#336699">
										<div align="center">
											<font color="white" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1">
													<?php echo $semestre[$i]," ",$tipo[$N] ?>
											</font>
										</div>
									</td>
								<?php
								}
								?>
									</tr>
									<tr height="19">
										<td width="33" height="19" bgcolor="#336699">
									</td>
										<td height="19" bgcolor="#add8e6"></td>
									<td height="19" bgcolor="#add8e6">
										<table border="0" cellpadding="0" cellspacing="0" width="162" height="19">
											<tr height="19">
												<td width="25" height="19">
													<div align="center">
																<font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1">
																	SI
																</font>
													</div>
												</td>
												<td height="19" width="82">
													<div align="center">
																<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
																		AVECES
																</font>
													</div>
												</td>
												<td height="19" width="45">
													<div align="center">
															<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
																NO
															</font>
													</div>
												</td>
											</tr>
										</table>
								</td>
						<?php
							for($i=0;$i<$N;$i++) {
						 ?>
								<td height="19" bgcolor="#add8e6">
										<table border="0" cellpadding="0" cellspacing="0" width="162" height="19">
															<tr height="19">
																<td width="25" height="19">
																	<div align="center">
																				<font face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" size="1">
																					SI
																				</font>
																	</div>
																</td>
																<td height="19" width="82">
																	<div align="center">
																				<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
																						AVECES
																				</font>
																	</div>
																</td>
																<td height="19" width="45">
																	<div align="center">
																			<font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
																				NO
																			</font>
																	</div>
																</td>
															</tr>
										</table>
								</td>
						<?php }  ?>
						</tr>

						<!--------------/ fin encabezado / ------------------------------------!-->
										<?php
						//	$imag="<img src='../../../fichas/medicas/tic.gif' border=0>";
							$imag="<font face=arial size=2><li></font>";
							for ($i=0;$i<=pg_numrows($result);$i++){
								$fla  = @pg_fetch_array($result,$i);	
								$fla2 = @pg_fetch_array($rt,$i);	
								?>
										<tr>
											<td bgcolor="#336699" width="33">
												<center>
													<font color="white" face="arial" size=2><b><?php echo $fla[id] ?></b></font>
											</td>
											<td bgcolor="#add8e6"><font face="arial" size=1 color="black"><?php echo $fla[pregunta] ?></font></td>
											<td bgcolor="white">
												<table border="0" cellpadding="0" cellspacing="0" width="171" height="19">
													<tr height="19">
														<td width="25" height="19">
															<div align="center">
																<?php echo (trim($fla2[1])==1)?$imag:"" ?>
															</div>
														</td>
														<td width="80" height="19">
															<div align="center">
																<?php echo (trim($fla2[1])==2)?$imag:"" ?>
															</div>
														</td>
														<td width="56" height="19">
															<div align="center">
															<div align="center">
																<?php echo (trim($fla2[1])==3)?$imag:"" ?>
															</div>
															</div>
														</td>
													</tr>
												</table>
											</td>
											<?php 
												for($x=0;$x<$N;$x++) {
											?>
											<td bgcolor="white">
												<table border="0" cellpadding="0" cellspacing="0" width="162" height="19">
													<tr height="19">
														<td width="25" height="19">
															<div align="center">
																<?php echo (trim($fla2[$x+2])==1)?$imag:"" ?>
															</div>
														</td>
														<td width="82" height="19">
															<div align="center">
																<?php echo (trim($fla2[$x+2])==2)?$imag:"" ?>
															</div>
														</td>
														<td width="45" height="19">
															<div align="center">
																<?php echo (trim($fla2[$x+2])==3)?$imag:"" ?>
															</div>

														</td>
													</tr>
												</table>
											</td>
										<?php 
											}
										?>
										</tr>
										<?php 
							
								}
							}
							?>

						<!--/table>
						</td></tr>
						</table-->
						</td></tr>
						</table>
						<!--
							<center><input type="button" onclick="history.back()" value="VOLVER"></center> 
						!-->
						<?php  }?>
						
						</TD>
					</TR>
				</TABLE>
			</TD>
		<!-- FIN FILA -->						
		</TR>
	<?php } //FIN ENSEÑANZA SALACUNA?>






	<?php if ( trim($tipo)==30 || trim($tipo)==40){ //NIVEL MEDIO?>			
			<TR height=15>
			<!-- INICIO FILA -->						
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle BGCOLOR=WHITE>
<?php
 

 //------------------------------------------------/ NIVEL MEDIO /-------------------------------------
 if ( trim($tipo)==30 || trim($tipo)==40) {

	 $qry_dte="SELECT ed.nro_eva, ed.evaluacion AS ES0, (SELECT   evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=1  AND   nivel_ev=ed.nivel_ev  AND  rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES1, (SELECT   evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=2  AND   nivel_ev=ed.nivel_ev  AND  rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES2, (SELECT evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=3  AND   nivel_ev=ed.nivel_ev  AND rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES3,(SELECT peso3  from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS peso3,(SELECT peso7  from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS peso7,(SELECT peso12  from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS peso12,(SELECT talla3  from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS talla3,(SELECT talla7  from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS talla7,(SELECT talla12  from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS talla12,(SELECT obs from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS obs FROM evaluacion_detalle_nin AS ed WHERE (((ed.semestre)=0) AND ((ed.nivel_ev)=2) AND ((ed.rut_alumno)=$alumno) AND ((ed.ano)=$_ANO));";
	
											 

$rt = @pg_Exec($conn,$qry_dte);

if (!$rt) {
		error('<B> ERROR :</b>Error al acceder a la BD. (70)</B>');
}

$qry="select * from maestrto_evaluacion where nivel_ev=2";
	$result = @pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. </B>');
		exit();
	}
$resultTPR  = @pg_Exec($conn,"SELECT tipo_regimen from institucion where rdb=".$institucion);
$fla     = @pg_fetch_array($resultTPR,0);
if (trim($fla[0])=="2") 
	  $N=3;
if (trim($fla[0])=="3") 
	  $N=2;
//------------/saca el peso y la talla / --------------------
  $pesoytalla = @pg_fetch_array($rt,0);	
//-----------------------------------------------------------

//------------------------------
    include('cabecera3.php');
//------------------------------


?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="black">
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="1" cellpadding="0">
						<tr>
							<td width="71" bgcolor="#336699"><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">&nbsp;</font></td>
							<td width="139" bgcolor="#336699">
								<div align="center">
									<b><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Marzo</font></b></div>
							</td>
							<td width="138" bgcolor="#336699">
								<div align="center">
									<b><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Julio</font></b></div>
							</td>
							<td width="130" bgcolor="#336699">
								<div align="center">
									<b><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Diciembre</font></b></div>
							</td>
						</tr>
						<tr>
							<td bgcolor="#336699" width="71">
								<div align="center">
									<b><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Peso</font></b></div>
							</td>
							<td width="139" bgcolor="white"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><center><?php echo $pesoytalla[5] ?></font></td>
							<td width="138" bgcolor="white"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><center><?php echo $pesoytalla[6] ?></font></td>
							<td width="130" bgcolor="white"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><center><?php echo $pesoytalla[7] ?></font></td>
						</tr>
						<tr>
							<td bgcolor="#336699" width="71">
								<div align="center">
									<b><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Talla</font></b></div>
							</td>
							<td width="139" bgcolor="white"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><center><?php echo $pesoytalla[8] ?></font></td>
							<td width="138" bgcolor="white"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><center><?php echo $pesoytalla[9] ?></font></td>
							<td width="130" bgcolor="white"><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><center><?php echo $pesoytalla[10] ?></font></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<p></p>
		<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="black">
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="1" height="63">
						<tr>
							<td bordercolor="#FFFFFF" width="18" rowspan="2" bgcolor="#336699">
								<div align="center">
									<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></b></div>
							</td>
							<td width="232" rowspan="2" bgcolor="#336699">
								<div align="center"><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><b>
								  Area Emocional Social</b></font>
								</div>
							</td>
							<td colspan="3" bgcolor="#336699">
								<div align="center">
									<font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><b>Evaluaci&oacute;n Diagn&oacute;stica</b></font></div>
							</td>
							<?php 

							$letra=array (
										  0 =>"b", 
										  1 =>"c",
										  2 =>"d");
										$semestre=array (
										  0 =>"Primer ", 
										  1 =>"Segundo",
										  2 =>"Tercer");
										$tipo=array (
										  3 =>"trimestre", 
										  2 =>"Semestre"
										);
									
							for($i=0;$i<$N;$i++){  ?>
							<td colspan="3" bgcolor="#336699">
								<div align="center">
									<font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
									<b>
									<?php echo $semestre[$i]," ",$tipo[$N] ?>
									</b>
									</font>
							    </div>
							</td>
							<?php } ?>
						</tr>
						<tr height="10">
						    <td width="40" bgcolor="#add8e6" height="10">
								<div align="center">
									<font color="#000066"><b><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Si</font></b></font></div>
							</td>
							<td width="57" bgcolor="#add8e6" height="10">
								<div align="center">
									<font color="#000066"><b><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">A Veces</font></b></font></div>
							</td>
							<td width="50" bgcolor="#add8e6" height="10">
								<div align="center">
									<font color="#000066"><b><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">No</font></b></font></div>
							</td>
						
						 <?php	for($i=0;$i<$N;$i++) { ?>
										<td width="40" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Si</font></b></font></div>
										</td>
										<td width="57" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">A Veces</font></b></font></div>
										</td>
										<td width="50" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">No</font></b></font></div>
										</td>
							
						<?php 	} ?>
						</tr>
			<!-----------------------/ cuerpo /---------------------!--> 
					<?php	for($x=0;$x< pg_numrows($result);$x++) { 
							$fla  = @pg_fetch_array($result,$x);	
							$fla2  = @pg_fetch_array($rt,$x);	
							if (trim($fla[id])==9) {
								echo "</tr></table></td></tr></table><p><br></p>";
								$area="Area Autonomia";
								include('cabecera.php');
							}
							if (trim($fla[id])==17) {
								echo "</tr></table></td></tr></table><p><br></p>";
								$area="Area Psicomotricidad Fina y Gruesa";
								include('cabecera.php');

							}
					?>
						<tr>
							<td width="18" bgcolor="#336699">
								<div align="center">
								<font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
								  <?php	echo $fla[id]; ?>
								</font>
								</div>
							</td>
							<td bgcolor="#add8e6">
								<div align="left">
								<font color="black" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
								<?php	echo $fla[pregunta]; ?>
								</font>
								</div>
							</td>

							<td width="40" bgcolor="white">
								<div align="center">
								  <?php echo (trim($fla2[1])==1)?" <li> ":""; ?>
								</div>
							</td>
							<td width="40" bgcolor="white">
								<div align="center">
								  <?php echo (trim($fla2[1])==2)?" <li> ":""; ?>
								</div>
							</td>
							<td width="40" bgcolor="white">
								<div align="center">
								  <?php echo (trim($fla2[1])==3)?" <li> ":""; ?>
								</div>					
							</td>

					<?php	for($j=0;$j<$N;$j++) { 	?>

							<td width="40" bgcolor="white">
								<div align="center">
								  <?php echo (trim($fla2[$j+2])==1)?" <li> ":""; ?>
								</div>					
							</td>
							<td width="40" bgcolor="white">
								<div align="center">
								  <?php echo (trim($fla2[$j+2])==2)?" <li> ":""; ?>
								</div>					
							</td>
							<td width="40" bgcolor="white">
								<div align="center">
								  <?php echo (trim($fla2[$j+2])==3)?" <li> ":""; ?>
								</div>					
							</td>
					<?php 	} ?>

							
						</tr>
						<?php 	} ?>
	<!---------------------/ Fin cuerpo /------------------------!-->
					</table>
				</td>
			</tr>
		</table>
		<p align=left><font color="black" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><b>Observaciones:</b></font></p>
		<table border="0" cellpadding="0" cellspacing="1"  width="100%" bgcolor="black">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="white">
						<tr>
							<td><?php echo trim($pesoytalla[11]) ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
<p><br></p>


<?php
 }
?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			<!-- FIN FILA -->						
			</TR>
	<?php } //FIN NIVEL MEDIO?>



	<?php if ( trim($tipo)==50 || trim($tipo)==60){ //KINDER - PREKINDER?>			
			<TR height=15>
			<!-- INICIO FILA -->						
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle BGCOLOR=WHITE>


<?php



 //------------------------------------------------/ KINDER Y PREKINDE /----------------------------
 if ( trim($tipo)==60 || trim($tipo)==50) {

	 
$qry_dte="SELECT ed.nro_eva,(SELECT  evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=1  AND   nivel_ev=ed.nivel_ev  AND  rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES1, (SELECT  evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=2  AND   nivel_ev=ed.nivel_ev  AND  rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES2, (SELECT  evaluacion FROM evaluacion_detalle_nin  WHERE   semestre=3  AND   nivel_ev=ed.nivel_ev  AND rut_alumno=ed.rut_alumno  AND  ano=ed.ano and nro_eva=ed.nro_eva) AS ES3,(SELECT  obs from evaluacion_nin where rut_alumno=ed.rut_alumno and ano=ed.ano and nivel_ev=ed.nivel_ev) AS obs FROM evaluacion_detalle_nin AS ed WHERE (((ed.semestre)=1) AND ((ed.nivel_ev)=3) AND ((ed.rut_alumno)=$alumno) AND ((ed.ano)=$_ANO))";

$rt = @pg_Exec($conn,$qry_dte);

$qry="select * from maestrto_evaluacion where nivel_ev=3";
	$result = @pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. </B>');
		exit();
	}
$resultTPR  = @pg_Exec($conn,"SELECT tipo_regimen from institucion where rdb=".$institucion);
$fla     = @pg_fetch_array($resultTPR,0);
if (trim($fla[0])=="2") 
	  $N=3;
if (trim($fla[0])=="3") 
	  $N=2;
//------------/saca las obs / --------------------
  $obs = @pg_fetch_array($rt,0);	
//------------------------------------------------


//------------------------------
    include('cabecera3.php');
//------------------------------


?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="black">
			<tr>
				<td>
					<table width="100%" border="0" cellpadding="0" cellspacing="1" height="63">
						<tr>
							<td bordercolor="#FFFFFF" width="18" rowspan="2" bgcolor="#336699">
								<div align="center">
									<b><font size="2" face="Verdana, Arial, Helvetica, sans-serif"></font></b>
									<font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><b>Nº</b></font> 
									</div>
							</td>
							<td width="232" rowspan="2" bgcolor="#336699">
								<div align="center"><font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular"><b>Area Cognoscitiva</b></font>
								</div>
							</td>
							<?php 

							$letra=array (
										  0 =>"a", 
										  1 =>"b",
										  2 =>"c",
										  3 =>"d");
										$semestre=array (
										  0 =>"Primer ", 
										  1 =>"Segundo",
										  2 =>"Tercer");
										$tipo=array (
										  3 =>"trimestre", 
										  2 =>"Semestre"
										);
									
							for($i=0;$i<$N;$i++){  ?>
							<td colspan="4" bgcolor="#336699">
								<div align="center">
									<font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
									<b>
									<?php echo $semestre[$i]," ",$tipo[$N] ?>
									</b>
									</font>
							    </div>
							</td>
							<?php } ?>
						</tr>
						<tr height="10">
						

						<?php	for($i=0;$i<$N;$i++) { ?>
										<td width="40" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Siempre</font></b></font></div>
										</td>
										<td width="57" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Frecuente mente</font></b></font></div>
										</td>
										<td width="50" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Rara Vez</font></b></font></div>
										</td>
										<td width="50" bgcolor="#add8e6" height="10">
											<div align="center">
												<font color="#000066"><b><font size="1" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">Nunca</font></b></font></div>
										</td>
							
						<?php 	} ?>
						</tr>
			<!-----------------------/ cuerpo /---------------------!--> 
					<?php	for($x=0;$x< pg_numrows($result);$x++) { 
							$fla  = @pg_fetch_array($result,$x);	
							$fla2  = @pg_fetch_array($rt,$x);	
							if (trim($fla[id])==28 ) {
								echo "</tr></table></td></tr></table><p><br></p>";
								$area="II Area psicomotriz";
								include('cabecera2.php');
							}
							if (trim($fla[id])==33) {
								echo "</tr></table></td></tr></table><p><br></p>";
								$area="III Area emocional - Social";
								include('cabecera2.php');

							}

							if (trim($fla[id])==1) {
								echo "<tr bgcolor=#F0F0F0><td  colspan='14' ><font color='#000066'><b><font size='1' face='Arial,Helvetica,Geneva,Swiss,SunSans-Regular'> Volición</font></td></tr>";
								
							}
							if (trim($fla[id])==3) {
								echo "<tr bgcolor=#F0F0F0><td  colspan='14' ><font color='#000066'><b><font size='1' face='Arial,Helvetica,Geneva,Swiss,SunSans-Regular'>Lenguaje</font></td></tr>";
								
							}
							if (trim($fla[id])==8) {
								echo "<tr bgcolor=#F0F0F0><td  colspan='14' ><font color='#000066'><b><font size='1' face='Arial,Helvetica,Geneva,Swiss,SunSans-Regular'>Persepción auditiva</font></td></tr>";
								
							}
							if (trim($fla[id])==12) {
								echo "<tr bgcolor=#F0F0F0><td  colspan='14' ><font color='#000066'><b><font size='1' face='Arial,Helvetica,Geneva,Swiss,SunSans-Regular'>Persepción visual</font></td></tr>";
								
							}
							if (trim($fla[id])==20) {
								echo "<tr bgcolor=#F0F0F0><td  colspan='14' ><font color='#000066'><b><font size='1' face='Arial,Helvetica,Geneva,Swiss,SunSans-Regular'>Relación Temporal Espacial</font></td></tr>";
								
							}
							
					?>
						<tr>
							<td width="18" bgcolor="#336699">
								<div align="center">
								<font color="white" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
								  <?php	echo $fla[id]; ?>
								</font>
								</div>
							</td>
							<td bgcolor="#add8e6" width="100%">
								<div align="left">
								<font color="black" size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular">
								<?php	echo $fla[pregunta]; ?>
								</font>
								</div>
							</td>

					<?php	for($j=0;$j<$N;$j++) { 	?>

							<td width="40" bgcolor="white">
								<div align="center">
								  <?php echo (trim($fla2[$j+1])==1)?"<li>":""; ?>
								</div>
							</td>
							<td width="40" bgcolor="white">
								<div align="center">
								 <?php echo (trim($fla2[$j+1])==2)?"<li>":""; ?>
								</div>
							</td>
							<td width="40" bgcolor="white">
								<div align="center">
								 <?php echo (trim($fla2[$j+1])==3)?"<li>":""; ?>
								</div>
							</td>
							<td width="40" bgcolor="white">
							<div align="center">
								<?php echo (trim($fla2[$j+1])==4)?"<li>":""; ?>
							</div>
							</td>
					<?php 	} ?>

							
						</tr>
						<?php 	} ?>
	<!---------------------/ Fin cuerpo /------------------------!-->
					</table>
				</td>
			</tr>
		</table>
		<p></br></p>
		<table border="0" cellpadding="0" cellspacing="1"  width="100%" bgcolor="black">
			<tr>
				<td>
					<table border="0" cellpadding="0" cellspacing="0" width="100%" bgcolor="white">
						<tr>
							<td><?php echo trim($obs[4]) ?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<p></br></p>
		<!--
		<center><input type="button" onclick="history.back()" value=" VOLVER " ></center>
		!-->

<?php

 }

?>
<!-------------------------------------------/ end informes /-------------------------------------!-->
							</TD>
						</TR>
					</TABLE>
				</TD>
			<!-- FIN FILA -->						
			</TR>
	<?php } //FIN KINDER - PREKINDER?>

			<TR height=15>
			<!-- INICIO FILA -->						
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>ASISTENCIAS Y ATRASOS</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			<!-- FIN FILA -->						
			</TR>

			<TR height=15>
			<!-- INICIO FILA -->						
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle BGCOLOR=WHITE>
								<?php
									$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
									$result =@pg_Exec($conn,$qry);
									if (!$result) {
										error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
									}else{
										if (pg_numrows($result)!=0){//SI EXISTEN PERIODOS INGRESADOS

									?>
						<?php if($_TIPOREGIMEN==2){//TRIMESTRAL?>
								<!-- ASISTENCIAS -->
								<!-- INICIO TRES PERIDOS -->
								<TABLE WIDTH="100%" BORDER=0 BGCOLOR=WHITE>
									<TR>
										<TD>
											<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
												<TR>
												<?php
													$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
													$result6 =@pg_Exec($conn,$qry6);
													if (!$result6) {
														error('<B> ERROR :</b>Error al acceder a la BD. (31)</B>');
													}else{
														if (pg_numrows($result6)!=0){
														?>
															<TD COLSPAN=3></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,0);
																	echo trim($fila6['nombre_periodo']);
																	$idPer1=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,1);
																	echo trim($fila6['nombre_periodo']);
																	$idPer2=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,2);
																	echo trim($fila6['nombre_periodo']);
																	$idPer3=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																TOTAL AÑO
															</TD>
														<?php
														}
													}
												?>
												</TR>
												<TR>
													<TD COLSPAN=3 ROWSPAN=3>ASISTENCIAS</TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD>
												</TR>
												<TR>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer1;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (32)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP1  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
																$cantInasist1	= @pg_numrows($result);
																$cantAsist1		= ($hP1-$cantInasist1);
															}
														}
													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP1;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist1;?></TD>
													<?php if ($cantInasist1!=0) { ?>
														<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist1;?></TD>
													<?php } else { ?>
														<TD colspan=3 ALIGN=CENTER>0</TD>
													<?php } ?>
													<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist1*100)/$hP1));?>%</TD>
													<TD></TD>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer2;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (33)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP2  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
																$cantInasist2	=@pg_numrows($result);
																$cantAsist2		= ($hP2-$cantInasist2);
															}
														}
													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP2;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist2;?></TD>
													<?php if ($cantInasist2!=0) { ?>
														<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist2;?></TD>
													<?php } else { ?>
														<TD colspan=3 ALIGN=CENTER>0</TD>
													<?php } ?>
													<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist2*100)/$hP2),0);?>%</TD>
													<TD></TD>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer3;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (34)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP3  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
																$cantInasist3	=@pg_numrows($result);
																$cantAsist3		= ($hP3-$cantInasist3);
															}
														}
													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP3;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist3;?></TD>
													<?php if ($cantInasist3!=0) { ?>
														<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist3;?></TD>
													<?php } else { ?>
														<TD colspan=3 ALIGN=CENTER>0</TD>
													<?php } ?>
													<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist3*100)/$hP3),0);?>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo ($hP1+$hP2+$hP3);?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo ($cantAsist1+$cantAsist2+$cantAsist3);?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist1+$cantInasist2+$cantInasist3;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantAsist1+$cantAsist2+$cantAsist3)*100)/($hP1+$hP2+$hP3)),1);?>%</TD>
												</TR>
												<TR>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
									<!-- FIN TRES PERIDOS -->
									<!-- ATRASOS -->
									<!-- INICIO TRES PERIDOS -->
									<TR>
										<TD>
											<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
												<TR>
												<?php
													$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
													$result6 =@pg_Exec($conn,$qry6);
													if (!$result6) {
														error('<B> ERROR :</b>Error al acceder a la BD. (35)</B>');
													}else{
														if (pg_numrows($result6)!=0){
														?>
															<TD COLSPAN=3></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,0);
																	echo trim($fila6['nombre_periodo']);
																	$idPer1=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,1);
																	echo trim($fila6['nombre_periodo']);
																	$idPer2=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,2);
																	echo trim($fila6['nombre_periodo']);
																	$idPer3=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																TOTAL AÑO
															</TD>
														<?php
														}
													}
												?>
												</TR>
												<TR>
													<TD COLSPAN=3 ROWSPAN=3>ATRASOS</TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<TD colspan=3 ALIGN=CENTER>%</TD>
												</TR>
												<TR>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer1;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (36)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP1  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
															//	$cantDiasAt1	=pg_numrows($result);

															}
														}
													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP1;?></TD>
													<?php if ($result!=0) { ?>
												        <TD colspan=6 ALIGN=CENTER><?php echo $result;?></TD>
													<?php } else { ?>
													    <TD colspan=6 ALIGN=CENTER>0</TD>
													<?php } ?> 
													<!--TD colspan=6 ALIGN=CENTER><?php echo $cantHrAt1;?></TD-->
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($hP1 - $result)*100)/($hP1)),1);?>%</TD>
													<TD></TD>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer2;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (37)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP2  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
															//	$cantDiasAt2	=pg_numrows($result);

															}
														}
													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP2;?></TD>
													<?php if ($result!=0) { ?>
												        <TD colspan=6 ALIGN=CENTER><?php echo $result;?></TD>
													<?php } else { ?>
													    <TD colspan=6 ALIGN=CENTER>0</TD>
													<?php } ?> 
													<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt2;?></TD-->
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($hP2 - $result)*100)/($hP2)),1);?>%</TD>
													<TD></TD>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer3;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (38)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP3  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
															//	$cantDiasAt3	=pg_numrows($result);

															}
														}
													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP3;?></TD>
													<?php if ($result!=0) { ?>
												        <TD colspan=6 ALIGN=CENTER><?php echo $result;?></TD>
													<?php } else { ?>
													    <TD colspan=6 ALIGN=CENTER>0</TD>
													<?php } ?> 
													<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt3;?></TD-->
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($hP3 - $result)*100)/($hP3)),1);?>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo ($hP1+$hP2+$hP3);?></TD>
													<TD colspan=6 ALIGN=CENTER><?php echo ($cantDiasAt1+$cantDiasAt2+$cantDiasAt3);?></TD>
													<TD colspan=3 ALIGN=CENTER><?php 
													if(($hP1+$hP2+$hP3)!=0)	
													echo round(((($hP1 + $hP2 + $hP3 + $cantDiasAt1+$cantDiasAt2+$cantDiasAt3)*100)/($hP1+$hP2+$hP3)),1);?>%</TD>

												</TR>
												<TR>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
						<?php }//TRIMESTRAL?>
						<!-- FIN TRES PERIODOS -->
						<!-- FIN DESPLIEGUE PARA 3 PERIODOS -->
						
						<?php if($_TIPOREGIMEN==3){//SEMESTRAL?>
								<!-- ASISTENCIAS -->
								<!-- INICIO DOS PERIDOS -->						
								<TABLE WIDTH="100%" BORDER=0 BGCOLOR=WHITE>
									<TR>
										<TD>
											<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
												<TR>
												<?php
													$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
													$result6 =@pg_Exec($conn,$qry6);
													if (!$result6) {
														error('<B> ERROR :</b>Error al acceder a la BD. (39)</B>');
													}else{
														if (pg_numrows($result6)!=0){
														?>
															<TD COLSPAN=3></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,0);
																	echo trim($fila6['nombre_periodo']);
																	$idPer1=$fila6['id_periodo'];

																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,1);
																	echo trim($fila6['nombre_periodo']);
																	$idPer2=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<!--TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,2);
																	echo trim($fila6['nombre_periodo']);
																	$idPer3=$fila6['id_periodo'];
																?>
															</TD-->
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																TOTAL AÑO
															</TD>
														<?php
														}
													}
												?>
												</TR>
												<TR>
													<TD COLSPAN=3 ROWSPAN=3>ASISTENCIAS</TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<!--TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD-->
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=3 ALIGN=CENTER>SI ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>NO ASIST.</TD>
													<TD colspan=3 ALIGN=CENTER>%</TD>
												</TR>
												<TR>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer1;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (310)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP1  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];


																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
																$cantInasist1	=pg_numrows($result);
																$cantAsist1		= ($hP1-$cantInasist1);
															}
														}

													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP1;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist1;?></TD>
													<?php if ($cantInasist1!=0) { ?>
														<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist1;?></TD>
													<?php } else { ?>
														<TD colspan=3 ALIGN=CENTER>0</TD>
													<?php } ?>
													<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist1*100)/$hP1));?>%</TD>
													<TD></TD>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer2;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (311)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP2  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];


																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
																$cantInasist2	=pg_numrows($result);
																$cantAsist2		= ($hP2-$cantInasist2);
															}
														}

													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP2;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist2;?></TD>
													<?php if ($cantInasist2!=0) { ?>
														<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist2;?></TD>
													<?php } else { ?>
														<TD colspan=3 ALIGN=CENTER>0</TD>
													<?php } ?>
													<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist2*100)/$hP2),0);?>%</TD>
													<TD></TD>
													<?php
														/*
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer3;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (312)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP3  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT * FROM ANOTACION WHERE TIPO=3 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
																$result			=@pg_Exec($conn,$qry);
																$cantInasist3	=pg_numrows($result);
																$cantAsist3		= ($hP3-$cantInasist3);
															}
														}
														*/
													?>
													<!--TD colspan=3 ALIGN=CENTER><?php echo $hP3;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantAsist3;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist3;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo round((($cantAsist3*100)/$hP3),0);?>%</TD-->
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo ($hP1+$hP2);?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo ($cantAsist1+$cantAsist2);?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo $cantInasist1+$cantInasist2;?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantAsist1+$cantAsist2)*100)/($hP1+$hP2)),1);?>%</TD>
												</TR>
												<TR>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<!--TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD-->
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
									<!-- FIN DOS PERIDOS -->
									<!-- ATRASOS -->
									<!-- INICIO DOS PERIDOS -->
									<TR>
										<TD>
											<TABLE BORDER=1 CELLSPACING=2 CELLPADDING=2 width=100%>
												<TR>
												<?php
													$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
													$result6 =@pg_Exec($conn,$qry6);
													if (!$result6) {
														error('<B> ERROR :</b>Error al acceder a la BD. (313)</B>');
													}else{
														if (pg_numrows($result6)!=0){
														?>
															<TD COLSPAN=3></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,0);
																	echo trim($fila6['nombre_periodo']);
																	$idPer1=$fila6['id_periodo'];

																?>
															</TD>
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,1);
																	echo trim($fila6['nombre_periodo']);
																	$idPer2=$fila6['id_periodo'];
																?>
															</TD>
															<TD></TD>
															<!--TD colspan=12 ALIGN=CENTER>
																<?php 
																	$fila6 = @pg_fetch_array($result6,2);
																	echo trim($fila6['nombre_periodo']);
																	$idPer3=$fila6['id_periodo'];
																?>
															</TD-->
															<TD></TD>
															<TD colspan=12 ALIGN=CENTER>
																TOTAL AÑO
															</TD>
														<?php
														}
													}
												?>
												</TR>
												<TR>
													<TD COLSPAN=3 ROWSPAN=3>ATRASOS</TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<TD colspan=3 ALIGN=CENTER>%</TD>
													<TD></TD>
													<!--TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<!--TD colspan=3 ALIGN=CENTER>%</TD-->
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER>DIAS HABILES</TD>
													<TD colspan=6 ALIGN=CENTER>DIAS ATRASADOS</TD>
													<!--TD colspan=3 ALIGN=CENTER>TIEMPO ATRASO</TD-->
													<TD colspan=3 ALIGN=CENTER>%</TD>
												</TR>
												<TR>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer1;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (314)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP1  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
																$cantDiasAt1	=pg_numrows($result);

															}
														}

													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP1;?></TD>
													<?php if ($result!=0) { ?>
												        <TD colspan=6 ALIGN=CENTER><?php echo $cantDiasAt1;?></TD>
													<?php } else { ?>
													    <TD colspan=6 ALIGN=CENTER>0</TD>
													<?php } ?> 
													<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt1;?></TD-->
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($hP1-$cantDiasAt1)*100)/($hP1)),1);?>%</TD>
													<TD></TD>
													<?php
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer2;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (315)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP2  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT COUNT(*) FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."' AND WHERE RUT_ALUMNO=.$alumno";
																$result			=@pg_Exec($conn,$qry);
																$cantDiasAt2	=pg_numrows($result);

															}
														}

													?>
													<TD colspan=3 ALIGN=CENTER><?php echo $hP2;?></TD>
													<?php if ($result!=0) { ?>
												        <TD colspan=6 ALIGN=CENTER><?php echo $cantDiasAt2;?></TD>
													<?php } else { ?>
													    <TD colspan=6 ALIGN=CENTER>0</TD>
													<?php } ?> 
													<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt2;?></TD-->
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($hP2-$cantDiasAt2)*100)/($hP2)),1);?>%</TD>
													<TD></TD>
													<?php
														/*
														$qry="SELECT * FROM PERIODO WHERE ID_PERIODO=".$idPer3;
														$result =@pg_Exec($conn,$qry);
														if (!$result) {
															error('<B> ERROR :</b>Error al acceder a la BD. (316)</B>');
														}else{
															if (pg_numrows($result)!=0){
																$fila = @pg_fetch_array($result,0);	
																if (!$fila){
																	error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
																	exit();
																}
																$hP3  =$fila['dias_habiles'];
																$fIni =$fila['fecha_inicio'];
																$fTer =$fila['fecha_termino'];

																$qry="SELECT * FROM ANOTACION WHERE TIPO=2 AND FECHA BETWEEN '".$fIni."' AND '".$fTer."'";
																$result			=@pg_Exec($conn,$qry);
																$cantDiasAt3	=pg_numrows($result);

															}
														}
														*/
													?>
													<!--TD colspan=3 ALIGN=CENTER><?php echo $hP3;?></TD>
													<TD colspan=6 ALIGN=CENTER><?php echo $cantDiasAt3;?></TD-->
													<!--TD colspan=3 ALIGN=CENTER><?php echo $cantHrAt3;?></TD-->
													<!--TD colspan=3 ALIGN=CENTER><?php echo round(((($cantDiasAt3)*100)/($hP3)),1);?>%</TD-->
													<TD></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo ($hP1+$hP2);?></TD>
													<TD colspan=6 ALIGN=CENTER><?php echo ($cantDiasAt1+$cantDiasAt2);?></TD>
													<TD colspan=3 ALIGN=CENTER><?php echo round(((($cantDiasAt1+$cantDiasAt2)*100)/($hP1+$hP2)),1);?>%</TD>

												</TR>
												<TR>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
													<TD></TD>
													<!--TD colspan=12 ALIGN=CENTER><!--GRAFICO--><!--/TD-->
													<TD></TD>
													<TD colspan=12 ALIGN=CENTER><!--GRAFICO--></TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
						<?php }//SEMESTRAL?>

									<!-- FIN DOS PERIDOS -->
									<!-- FIN DESPLIEGUE PARA 2 PERIODOS -->
									<?php
									}else{
									?>
								<TABLE>
									<TR>
										<TD colspan=4>
											<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
												<TR>
													<TD>
														<FONT face="arial, geneva, helvetica" size=2 color=#000000>
															<STRONG>(No existen PERIODOS ingresados para este AÑO ACADEMICO)</STRONG>
														</FONT>
													</TD>
												</TR>
											</TABLE>
										</TD>
									</TR>
								</TABLE>
									<?php
									}
									}?>
							</TD>
						</TR>
					</TABLE>
				</TD>
			<!-- FIN FILA -->						
			</TR>
			<TR height=15>
			<!-- INICIO FILA -->						
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height=20 bgcolor=#0099cc>
							<TD align=middle>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>OBSERVACIONES</strong>
								</FONT>
							</TD>
						</TR>
					</TABLE>
				</TD>
			<!-- FIN FILA -->						
			</TR>
			<TR height=15>
			<!-- INICIO FILA -->						
				<TD>
					<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
						<TR height=15>
							<TD>
								<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
									<?php
										$qry="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
										$result =@pg_Exec($conn,$qry);
										if (!$result) {
											error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
										}else{
											if (pg_numrows($result)!=0){//SI EXISTEN PERIODOS INGRESADOS

										?>

										<!--NOMBRES DE LOS PERIODOS-->
										<?php
											$qry6="SELECT periodo.fecha_inicio,periodo.fecha_termino, periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											$result6 =@pg_Exec($conn,$qry6);
											if (!$result6) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result6)!=0){
													$fila6 =@pg_fetch_array($result6,0);
													$nbPer1=$fila6['nombre_periodo'];
													$idPer1=$fila6['id_periodo'];
													$fInip1=$fila6['fecha_inicio'];
													$fFinp1=$fila6['fecha_termino'];
													
													$fila6 =@pg_fetch_array($result6,1);
													$nbPer2=$fila6['nombre_periodo'];
													$idPer2=$fila6['id_periodo'];
													$fInip2=$fila6['fecha_inicio'];
													$fFinp2=$fila6['fecha_termino'];

													$fila6 =@pg_fetch_array($result6,2);
													$nbPer3=$fila6['nombre_periodo'];
													$idPer3=$fila6['id_periodo'];
													$fInip3=$fila6['fecha_inicio'];
													$fFinp3=$fila6['fecha_termino'];
												}
											}

										?>
										
										<?php if($_TIPOREGIMEN==2){//TRIMESTRAL?>
											<!-- INICIO TRES PERIDOS -->						
											<!-- PRIMER PERIODO -->
											<TR>
												<TD align=CENTER>
													<? echo $nbPer1?>
												</TD>
											</TR>
										<?php
										if (($fInip1!='')and ($fFinp1!='')){
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip1."' AND '".$fFinp1."'";
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
														?>
															<TR>
																<TD >
																	<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
																		<TR valign=top>
																			<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
																		</TR>
																		<TR>
																			<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD align=center>
																	<hr width="80%" color="black">
																</TD>
															</TR>
														<?php
													}
												}else{
												?>
												<TR>
													<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
													</TD>
												</TR>
												<?php
												}
											  }
											};
										?>

										<!-- SEGUNDO PERIODO -->
										<TR>
											<TD align=CENTER>
												<? echo $nbPer2?>
											</TD>
										</TR>
										<?php
											if (($fInip2!='')and ($fFinp2!='')){
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip2."' AND '".$fFinp2."'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
											else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result) ; $i++){
														$fila1 = @pg_fetch_array($result,$i);
														?>
															<TR>
																<TD >
																	<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
																		<TR valign=top>
																			<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
																		</TR>
																		<TR>
																			<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD align=center>
																	<hr width="80%" color="black">
																</TD>
															</TR>
														<?php
													}
												}else{
												?>
												<TR>
													<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
													</TD>
												</TR>
												<?php
												}
											  }
											};
										?>

										<!-- TERCER PERIODO -->
										<TR>
											<TD align=CENTER>
												<? echo $nbPer3?>
											</TD>
										</TR>
										<?php
											if (($fInip3!='')and ($fFinp3!='')){
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip3."' AND '".$fFinp3."'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>'.$qry);
											else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (12)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result) ; $i++){
														$fila1 = @pg_fetch_array($result,$i);
														?>
															<TR>
																<TD >
																	<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
																		<TR valign=top>
																			<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
																		</TR>
																		<TR>
																			<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD align=center>
																	<hr width="80%" color="black">
																</TD>
															</TR>
														<?php
													}
												}else{
												?>
												<TR>
													<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
													</TD>
												</TR>
												<?php
												}
											  }
											};
										?>
									<!-- FIN 3 PERIODOS -->
									<?php }//FIN TRIMESTRAL?>

									<?php if($_TIPOREGIMEN==3){//SEMESTRAL?>
											<!-- INICIO 2 PERIDOS -->						
										<!-- PRIMER PERIODO -->
										<TR>
											<TD align=CENTER>
												<? echo $nbPer1?>
											</TD>
										</TR>
										<?php
											if (($fInip1!='')and ($fFinp1!='')){
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip1."' AND '".$fFinp1."'";
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
														?>
															<TR>
																<TD >
																	<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
																		<TR valign=top>
																			<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
																		</TR>
																		<TR>
																			<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD align=center>
																	<hr width="80%" color="black">
																</TD>
															</TR>
														<?php
													}
												}else{
												?>
												<TR>
													<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
													</TD>
												</TR>
												<?php
												}
											   }
											};
										?>

										<!-- SEGUNDO PERIODO -->
										<TR>
											<TD align=CENTER>
												<? echo $nbPer2?>
											</TD>
										</TR>
										<?php if (($fInip2!='')and ($fFinp2!='')){
											$qry="SELECT anotacion.fecha, anotacion.observacion, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM ((anotacion INNER JOIN alumno ON anotacion.rut_alumno = alumno.rut_alumno) INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) INNER JOIN empleado ON anotacion.rut_emp = empleado.rut_emp WHERE (((matricula.rut_alumno)=".$alumno.") AND ((matricula.rdb)=".$institucion.") AND ((matricula.id_ano)=".$ano.") AND ((anotacion.tipo)=1)) AND anotacion.fecha BETWEEN '".$fInip2."' AND '".$fFinp2."'";
											$result =@pg_Exec($conn,$qry);
											if (!$result) 
												error('<B> ERROR :</b>Error al acceder a la BD. (9)</B>');
											else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
														exit();
													};
													for($i=0 ; $i < @pg_numrows($result) ; $i++){
														$fila1 = @pg_fetch_array($result,$i);
														?>
															<TR>
																<TD >
																	<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
																		<TR valign=top>
																			<TD width=50>FECHA</TD><TD>:</TD><TD><?php impF($fila1["fecha"])?></TD>
																		</TR>
																		<TR>
																			<TD>OBS</TD><TD>:</TD><TD>&nbsp;&nbsp;&nbsp;<?php echo $fila1['observacion']?></TD>
																		</TR>
																	</TABLE>
																</TD>
															</TR>
															<TR>
																<TD align=center>
																	<hr width="80%" color="black">
																</TD>
															</TR>
														<?php
													}
												}else{
												?>
												<TR>
													<TD>NO EXISTEN OBSERVACIONES REGISTRADAS
													</TD>
												</TR>
												<?php
												}
											   }	
										   		
											};
										?>
									<?php }//FIN SEMESTRAL?>
						
									<?php
										}else{
										?>
											<TR>
												<TD colspan=4>
													<TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
														<TR>
															<TD>
																<FONT face="arial, geneva, helvetica" size=2 color=#000000>
																	<STRONG>(No existen PERIODOS ingresados para este AÑO ACADEMICO)</STRONG>
																</FONT>
															</TD>
														</TR>
													</TABLE>
												</TD>
											</TR>
										<?php
										}
									}
								?>
								</TABLE>
							</TD>
						</TR>
					</TABLE>		
				</TD>
			<!-- FIN FILA -->						
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
		</TABLE>
			</TD>
			</TR>
		</TABLE>
	</BODY>
</HTML>