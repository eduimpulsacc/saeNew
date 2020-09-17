<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
 	$alumno			=$_ALUMNO;
	echo $curso			=$_CURSO;
	$ramo			=$_RAMO;
	$gen =0;
	$divisor=0;
//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
?>

<?php	/************************************************************************************/
		/*--------------------------- FUNCION NOTAS CONCEPTUALES ---------------------------*/
		/************************************************************************************/	
			/*function  conceptual1($nota1,$nota2,$nota3,$periodo){
				$ArrayNotas[0][0] = "MB";
				$ArrayNotas[0][1] = 60;
				$ArrayNotas[0][2] = 70;
				$ArrayNotas[1][0] = "B";
				$ArrayNotas[1][1] = 50;
				$ArrayNotas[1][2] = 60;
				$ArrayNotas[2][0] = "S";
				$ArrayNotas[2][1] = 40;
				$ArrayNotas[2][2] = 50;
				$ArrayNotas[3][0] = "I";
				$ArrayNotas[3][1] = 30;
				$ArrayNotas[3][2] = 40;
				$valnota1 = 0;
				$valnota2 = 0;
				$valnota3 = 0;
				$sumanotas = 0;
				$promedio = "";
				//echo ("Nota1=".$nota1." Nota2=".$nota2." Nota3=".$nota3."<br>");
				for($i=0;$i<count($ArrayNotas);$i++){
					if ($nota1 == $ArrayNotas[$i][0]){
						$valnota1 = $ArrayNotas[$i][2];
					};
					if ($nota2 == $ArrayNotas[$i][0]){
						$valnota2 = $ArrayNotas[$i][2];
					};
					if ($nota3 == $ArrayNotas[$i][0]){
						$valnota3 = $ArrayNotas[$i][2];
					};
				};
				//echo ("Valor1=".$valnota1." Valor2=".$valnota2. "Valor3=".$valnota3."<br>");
				$sumanotas = intval($valnota1) + intval($valnota2) + intval($valnota3);
				//echo ("Sumatoria=".$sumanotas." Periodo=" . $periodo . "<br>");

				if ($periodo!=0)
				$sumanotas = round($sumanotas / $periodo);

				//echo ("Resultado=".$sumanotas. "<br>");
				for($i=0;$i<count($ArrayNotas);$i++){
					if ((round($sumanotas/10)*10> $ArrayNotas[$i][1]) && (round($sumanotas/10)*10 <= $ArrayNotas[$i][2])){
						//echo ("i=".$i."<br>");
						$promedio = $ArrayNotas[$i][0];
						break;
					};
				};
	
				//echo ("Promedio=".$promedio);
				//exit();
				return $promedio;
			};*/
		
		/************************************************************************************/
		/*------------------------- FIN FUNCION NOTAS CONCEPTUALES -------------------------*/
		/************************************************************************************/
?>

<?php
	/*if($frmModo!="ingresar"){
		$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
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
*/
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
		//-->
		</style>
			<SCRIPT language="JavaScript">
			
				function round(number,X) {
					// rounds number to X decimal places, defaults to 2
					X = (!X ? 0 : X);
					return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
				}
			</SCRIPT>
	
<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</HEAD>
<BODY >
	<?php //echo tope("../../../../../util/");?>
	<FORM method=post name="frm" action="procesoSituacionFinal.php3">
		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> <?php
											$qry="SELECT nombre_instit,tipo_regimen FROM INSTITUCION WHERE RDB=".$institucion;
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
													$TipoRegimen = intval(Trim($fila1['tipo_regimen']));
													if ($TipoRegimen==2){ /*--- Trimestre ---*/
														$TipoRegimen = 3;
													}else{ /*--- Semestre ---*/
														$TipoRegimen = 2;
													};
												}
											}
										?> </strong> </FONT> </TD>
          </TR>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
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
              </strong> </FONT> </TD>
          </TR>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </TD>
            <TD> <FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>'.$qry);
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
											
										?>
              </strong> </FONT> </TD>
          </TR>
          <TR>
            <TD align=left><font face="arial, geneva, helvetica" size=2><strong>PLAN DE ESTUDIO</strong></font></TD>
            <TD align=left><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></TD>
            <TD align=left><font face="arial, geneva, helvetica" size=2><strong>
              <?php
									$qry4="SELECT curso.truncado_per, curso.id_curso,curso.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
										$result4 =@pg_Exec($conn,$qry4);
										$fila4= @pg_fetch_array($result4,0);
										echo trim($fila4['nombre_decreto']);
										$truncado_per = $fila4['truncado_per'];
										//echo $truncado_per." ".truncado_per;
									?>
              </strong></font></TD>
          </TR>
          <TR> 
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2>SUBSECTOR</FONT> 
            </TD>
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2>: </FONT> 
            </TD>
            <TD align=left><?php $qry="SELECT subsector.nombre, ramo.conex, ramo.pct_examen, nota_exim, ramo.pct_ex_escrito,ramo.pct_ex_oral FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
											$result =@pg_Exec($conn,$qry);
											if (@pg_numrows($result)!=0){
												$fila1 = @pg_fetch_array($result,0);
												$exim = $fila1['nota_exim'];
												echo trim($fila1['nombre']);
												$pct_examen = $fila1['pct_ex_escrito'];
												if($pct_examen!="0"){
													$examen = 1;	
												}
											}
			?>
			</TD>
          </TR>
          <TR> </TR>
        </TABLE>
				</TD>
			</TR>
			<TR height=15>
				<TD>
					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
						<TR height="50">
							<TD align=right><input type="hidden" name="modo"> 
              <?php if($frmModo=="mostrar"){ ?>
              <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button1" TYPE="button" onClick=document.location="seteaSituacionFinal.php3?caso=3&curso=<?php echo $_CURSO ?>" value="MODIFICAR">
			     <INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button3" TYPE="button" onClick=document.location="ramo.php3" value="VOLVER">
					
											<?php } ?>
	    	    	    		  			<?php if ($frmModo=="modificar"){ ?>
											<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="submit" value="GUARDAR" name=btnGuardar onclick="return valida(this.form)?;"> 
											<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button3" TYPE="button" onClick=document.location="seteaSituacionFinal.php3?caso=1&curso=<?php echo $_CURSO ?>" value="VOLVER">
											<?php } ?>
							</TD>
						</TR>
						<TR height=20 bgcolor=#003b85>
							<TD align=center>
								<FONT face="arial, geneva, helvetica" size=2 color=White>
									<strong>SITUACION FINAL DEL SUBSECTOR</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD>


						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
							<TR>
                  <TD> <table border=1 cellspacing=2 cellpadding=2 width=100%>
                      <tr> 
                        <td colspan=45 align="center">NOTAS</td>
                      </tr>
                      <tr> 
                        <td width="50%">ALUMNOS</td>
                        <td width="11%"align="center">PROM. GRAL.</td>
                        <? if($examen==1){?>
                        <td width="11%"align="center">EXAMEN ESCRITO</td>
                        <td width="11%"align="center">EXAMEN ORAL</td>
                        <? }else{?>
                        <td width="11%"align="center">EXAMEN</td>
                        <? } ?>
                        <td width="12%"align="center">PRUEBA ESPECIAL</td>
                        <td width="16%"align="center">NOTA FINAL</td>
                        <!--TD>PC</TD-->
                      </tr>
                      <?php
									if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
									if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
									      
										//ALUMNOS DEL CURSO
  									$qry="SELECT tiene$nro_ano.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno)   WHERE (((tiene$nro_ano.id_ramo)=".$ramo.") AND((tiene$nro_ano.id_curso)=".$curso.")) order by ape_pat, ape_mat, nombre_alu asc ";
									$result =pg_Exec($conn,$qry);
								
											for($i=0 ; $i < pg_numrows($result) ; $i++){
												$fila1 = pg_fetch_array($result,$i);
												  $div =0;
												  $cont=$i;

												  $qry5="select count(promedio) as sum from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." and id_ramo=".$ramo." and promedio >'0'";
																 $result5 =pg_Exec($conn,$qry5); 
																   $fila5= @pg_fetch_array($result5,0); 
																     $div = $div + $fila5['sum'];

												 $qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											     $result6 =pg_Exec($conn,$qry6);
												        $promedi =0;
												         for($j=0 ; $j < pg_numrows($result6) ; $j++){
															$fila6 = pg_fetch_array($result6,$j);
																$prome =0;
																$qry8="select promedio from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$fila6['id_periodo']." and id_ramo=".$ramo." and promedio >'0'";
																$result8 =pg_Exec($conn,$qry8);
																for($k=0 ; $k < pg_numrows($result8) ; $k++){
																	$fila8= @pg_fetch_array($result8,$k);
																	$promed = $fila8['promedio'];
																	$prome =($prome + $promed);
																};
															  	$promedi = $promedi + $prome;
																
														};
																	
														?>
                      <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='cursor' onMouseOut=this.style.background='transparent'> 
                        <td><font  color="#333333" size="2" face="Arial, Helvetica, sans-serif"> 
                          <input name="rut_Alu[<?php echo $cont ?>]" type="hidden" value="<?php echo $fila1["rut_alumno"]?>">
                          <?php echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];?> 
                          </font></td>
                        <td align="center">&nbsp; 
                          <?php 
																	if ($div!=0) {
																	   $res = Promediar($promedi,$div,$truncado_per);
																	   	if ($institucion == 12086){
																			   if (($exim)>(round($res))){
																					$res = Promediar($promedi,$div,2);
																				} else {
																					$res = Promediar($promedi,$div,$truncado_per);
																			   }
																		} else {
																			  $res = Promediar($promedi,$div,$truncado_per);
																	    }
																		imp (round($res));
																		$gen = $gen +$res;
																		?>
                          <input name="prom[<?php echo $cont ?>]" type="hidden" value="<?php echo round($res)?>"> 
                          <?php
																		}
																		if ($promedi !=0){
																		$divisor= $divisor + 1;
																		}
																		
																?>
                          <?php 
															
															$qry9="SELECT * FROM situacion_final WHERE (((situacion_final.rut_alumno)='".$fila1['rut_alumno']."') AND((situacion_final.id_ramo)=".$ramo.")) ";
																$result9 =pg_Exec($conn,$qry9);
																if (pg_numrows($result9)!=0){
																$fila9 = pg_fetch_array($result9,0);
																}
															?>
                        </td>
                        <? if($examen!="1"){?>
						<td align="center"><div align="center">&nbsp; 
                            <?php 
						  /*  $qry7="SELECT count(tiene3.rut_alumno)as suma FROM (alumno INNER JOIN tiene3 ON alumno.rut_alumno = tiene3.rut_alumno)   WHERE (((tiene3.id_ramo)=".$ramo.") AND((tiene3.id_curso)=".$curso.")) ";
							$result7 =pg_Exec($conn,$qry7);
							$fila7 = pg_fetch_array($result7,0);*/
						    $contalum = pg_numrows($result);

						 ?>
                            <?php if ($frmModo=="modificar"){ ?>
                            <input type="hidden" name="contalum" value="<?php echo $contalum ?>">
                            <?php if (($exim)<=(round($res))){
											echo "EXIM";
										  	 }else{ ?>
                            <input name="txtExamen[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['nota_examen'] ?>">
                            <?php 	 }									
								}?>
                            <?php if ($frmModo=="mostrar"){
						     if (($exim)<=(round($res))){
							    echo "EXIM";
							 }else{
						        echo $fila9['nota_examen'];
						        }
							}?>
                          </div></td>
						  <? }else{ 
								 $contalum = pg_numrows($result);
								if ($frmModo=="modificar"){?>
								 <td><div align="center"><?php if (($exim)<=(round($res))){
												echo "EXIM";
										   }else{ ?>
										   <input name="txtExamenEsc[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['nota_exam_esc'] ?>">
										   <? } ?>
										   </div></td>
								 <td><div align="center">
											<?php if ((40)<=($fila9['nota_final'])&&($fila9['nota_exam_oral']==0)){
												echo "EXIM";
										   }elseif($fila9['nota_exam_esc']==""){ 
											echo "&nbsp;";?>
										   <? }else{?>
												<input name="txtExamenOral[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['nota_exam_oral'] ?>">
										  <?  }?>
										   </div></td>
							<? 	}
								if ($frmModo=="mostrar"){?>
								<td><div align="center"><?php if (($exim)<=(round($res))){
												echo "EXIM";
										   }else{ ?>
												<? echo $fila9['nota_exam_esc']; ?>&nbsp;
											<? } ?>	
											</div></td>
								<td><div align="center"><?php if ((40)<=($fila9['nota_final'])&&($fila9['nota_exam_oral']==0)){
												echo "EXIM";
										   }else{ ?>
										   <? echo $fila9['nota_exam_oral']; ?>&nbsp;
										   <? } ?>
										   </div></td>
								<? 						     
								}
							 } ?>						
                        <td> <div align="center"> 
                            <?php if ($frmModo=="modificar"){ 
						?>
                            <input type="hidden" name="contalum" value="<?php echo $contalum ?>">
                            <input name="txtEspecial[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['prueba_especial'] ?>">
                            <?php } ?>
                            <?php if ($frmModo=="mostrar"){
						        echo $fila9['prueba_especial']."&nbsp;";
							}?>
                          </div></td>
                        <?php if (($frmModo=="modificar")||($frmModo=="mostrar")){ ?>
                        <td align="center">&nbsp;<?php echo $fila9['nota_final']; ?> 
                        </td>
                        <?php
											 } 
											 
										 }
									}
							}
						
								?>
                      <tr height=5 bgcolor=black> 
                        <td colspan=41></td>
                      </tr>
                      <tr> </tr>
                      <tr height=20> 
                        <td colspan=40></td>
                      </tr>
                      <tr> 
                        <td width ="50%">PROMEDIO DEL CURSO</td>
                        <td width="11%"align="center"> 
                          <?php 
										if($divisor >0 ){
										echo (round($gen/$divisor));
											}							
												?>
                        </td>
                        <input type="hidden" name=cont value=<?php echo $cont ?>>
                        <td width="11%"align="center">&nbsp; </td>
                        <td width="12%"align="center">&nbsp; </td>
                        <td width="12%"align="center">&nbsp; </td>
						  <td width="12%"align="center">&nbsp; </td>
                      </tr>
                    </table></TD>
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
					</TABLE>
				</TD>
			</TR>
		</TABLE>
	</FORM>
 </BODY>
 <? echo $fila9['nota_exam_oral']; ?>

</HTML>