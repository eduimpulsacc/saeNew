<?php 	require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	
?>

<SCRIPT language="JavaScript">

function enviapag(form){
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'asistencia.php3';
				form.submit(true);
	
				}	
			}
</SCRIPT>

<html>
<head>
<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
</head>

<body>
<?php echo tope("../../../../../util/");?>
<form name="form1" method="post" action="procesoAsistencia.php3">
  <table width="64%" border="0" align="center" cellpadding="5" cellspacing="5">
    <tr>

    </tr>
    <tr> 
      <td><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
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
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												//if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila1['nombre_instit']);
												//}
 											}
										?>
              </strong> </FONT> </TD>
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
													$nroAno=trim($fila1['nro_ano']);
												}
											}
										?>
              </strong> </FONT> </TD>
          </TR>
          <TR>
            <TD align=left><font size="2" face="Arial, Helvetica, sans-serif"><strong>CURSO
              </strong></font></TD>
            <TD><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></TD>
            <TD><strong><font size="2" face="Arial, Helvetica, sans-serif">
			<?php 	$qry="SELECT * FROM CURSO WHERE ID_CURSO=".$curso;
					$result =@pg_Exec($conn,$qry);
						if (!$result) {
							error('<B> ERROR :</b>Error al acceder a la BD. (51)</B>');
						}else{
							if (pg_numrows($result)!=0){
								$fila11 = @pg_fetch_array($result,0);	
								if (!$fila11){
									error('<B> ERROR :</b>Error al acceder a la BD. (52)</B>');
									exit();
								}
								$qry2="select nombre_tipo from tipo_ensenanza where cod_tipo=".$fila11[ensenanza];
									$result2 =@pg_Exec($conn,$qry2);
										if (!$result2) {
											error('<B> ERROR :</b>Error al acceder a la BD. (53)</B>');
										}else{
											if (pg_numrows($result2)!=0){
												$fila12 = @pg_fetch_array($result2,0);	
												if (!$fila12){
													error('<B> ERROR :</b>Error al acceder a la BD. (54)</B>');
													exit();
												}
											}
										}
								}
						}
						echo $fila11[grado_curso] , "-" , $fila11[letra_curso] , " " , $fila12[nombre_tipo] ; ?>
						
			&nbsp;</font></strong></TD>
          </TR>
        </TABLE>
        <table width="100%" border="0" cellpadding="5" cellspacing="5">
          <tr> 
            <td height="33" align="right"> 
              <?php if (($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
              <input type="submit" name="Button" value="GUARDAR"> 
			  <input type="button" name="Button32" value="VOLVER" onClick=document.location="seteaAsistencia.php3?caso=2">
              <?php } ?>
              <?php if ($frmModo=="mostrar") { ?>
              <input type="button" name="Button2" value="MODIFICAR" onClick=document.location="seteaAsistencia.php3?caso=1&mes=<?php echo $cmbMes ?>"> 
              <input type="button" name="Button3" value="VOLVER" onClick=document.location="../curso.php3">
               <?php } ?>
            </td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="5" cellspacing="5">
          <tr> 
            <td width="17%" height="20" align="left" bgcolor="#0099CC"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>ASISTENCIA</strong></font><font face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			  <select name="cmbMes" onChange="enviapag(this.form);">
			   <option value="0" selected>Selecciones Mes</option>
			    <?php
				if($cmbMes==""){
				$fecha=getdate();
				$cmbMes=$fecha["mon"];
				}
				if ($cmbMes=="01"){
               		 echo "<option value=01 selected>ENERO</option>";
				 }else	 
					echo "<option value=01>ENERO</option>";
				 if ($cmbMes=="02"){
               	 	echo "<option value=02 selected>FEBRERO</option>";
				  }else 
					echo "<option value=02>FEBRERO</option>";
				 if ($cmbMes=="03"){
                echo "	<option value=03 selected>MARZO</option>";
				 }else 
					echo "<option value=03>MARZO</option>";
				 if ($cmbMes=="04"){
                	echo "<option value=04 selected>ABRIL</option>";
				 }else 
					echo "<option value=04>ABRIL</option>";
				 if ($cmbMes=="05"){
                	echo "<option value=05 selected>MAYO</option>";
				 }else
					echo "<option value=05>MAYO</option>";
				 if ($cmbMes=="06"){
               		echo "<option value=06 selected>JUNIO</option>";
				 }else
					echo "<option value=06>JUNIO</option>";
				
				 if ($cmbMes=="07"){
                echo "	<option value=07 selected>JULIO</option>";
				 }else
					echo "<option value=07>JULIO</option>";
				 if ($cmbMes=="08"){
                echo "	<option value=08 selected>AGOSTO</option>";
				 }else
					echo "<option value=08>AGOSTO</option>";
				 if ($cmbMes=="09"){
                	echo "<option value=09 selected>SEPTIEMBRE</option>";
				 }else
					echo "<option value=09>SEPTIEMBRE</option>";
				 if ($cmbMes=="10"){
                	echo "<option value=10 selected>OCTUBRE</option>";
				 }else
					echo "<option value=10>OCTUBRE</option>";
				 if ($cmbMes=="11"){
                echo "<option value=11 selected>NOVIEMBRE</option>";
				 }else
					echo "<option value=11>NOVIEMBRE</option>";
				 if ($cmbMes=="12"){
                echo "<option value=12 selected>DICIEMBRE</option>";
				 }else	echo "<option value=12>DICIEMBRE</option>";
				 ?>
				

               
              </select>
              </font></td>
          </tr>
        </table>
        <table width="100%" border="0" cellpadding="2" cellspacing="2">
		<?php
									//ALUMNOS DEL CURSO
                                    $qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) WHERE ((matricula.id_curso=".$curso.") AND (matricula.bool_ar=0)) ORDER BY ape_pat,ape_mat asc";
									$result =@pg_Exec($conn,$qry);
									if(!$result)
										error('<B> ERROR :</b>Error al acceder a la BD. (75)</B>');
									else{
										if(pg_numrows($result)!=0){
												echo "<TR>";
												echo "<TD align=center size=50><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>ALUMNO</STRONG></FONT>";
												echo "</TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(1)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(2)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(3)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(4)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(5)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(6)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(7)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(8)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(9)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(10)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(11)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(12)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(13)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(14)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(15)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(16)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(17)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(18)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(19)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(20)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(21)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(22)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(23)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(24)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(25)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(26)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(27)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(28)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(29)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(30)</STRONG></FONT></TD>";
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>(31)</STRONG></FONT></TD>";
												if ($frmModo=="mostrar"){
												echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>Inasistencias Mes</STRONG></FONT></TD>";
												}
												echo "</TD>";
												echo "</TR>";
												$X=0;
											for($i=0 ; $i < @pg_numrows($result) ; $i++){
												$X++;
												$Y=0;
												$fila1 = @pg_fetch_array($result,$i);
												if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
													if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
														?>
															<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'>
														<?php
													}else{
														echo "<TR bgcolor=#ffffff>";
													}
												}else{
													echo "<TR bgcolor=#ffffff>";
												}
												echo "<TD align=left width=100><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>";
												echo  trim($fila1["ape_pat"])." ".trim($fila1["ape_mat"]).", ".trim($fila1["nombre_alu"]);
												echo "</STRONG></FONT></TD>";

												//NOTAS ALUMNO POR RAMO Y PERIODO
												
											if ($cmbMes!=""){
													//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
													if (($cmbMes==2) and ($nroAno%4==0)){
														 $diaFinal=29;
													}else{
														 $diaFinal=28;
													}
													if ($cmbMes==1) $diaFinal=31;
													if ($cmbMes==3) $diaFinal=31;
													if ($cmbMes==4) $diaFinal=30;
													if ($cmbMes==5) $diaFinal=31;
													if ($cmbMes==6) $diaFinal=30;
													if ($cmbMes==7) $diaFinal=31;
													if ($cmbMes==8) $diaFinal=31;
													if ($cmbMes==9) $diaFinal=30;
													if ($cmbMes==10) $diaFinal=31;
													if ($cmbMes==11) $diaFinal=30;
													if ($cmbMes==12) $diaFinal=31;
													//FIN AJUSTA
													}
												$qry9="select count (rut_alumno) as cantidad from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno=".trim($fila1["rut_alumno"]);
												$result9 =@pg_Exec($conn,$qry9);
												$fila9 = @pg_fetch_array($result9,0);
												$cant=$fila9["cantidad"];
												if (!$result9) {
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry9);
													}
													
												$qry2="select rut_alumno, ano, id_curso, date_part('day',asistencia.fecha) AS day, date_part('month',asistencia.fecha), date_part('year',asistencia.fecha) AS year from asistencia where fecha between '".$cmbMes."-01-".$nroAno."' and '".$cmbMes."-".$diaFinal."-".$nroAno."' and rut_alumno='".trim($fila1["rut_alumno"])."'";
												$result2 =@pg_Exec($conn,$qry2);
												if (!$result2) {
													error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$qry2);
												}else{
														if ($frmModo=="mostrar"){
																$p=1;
																for($ñ=0 ; $ñ<pg_numrows($result2) ; $ñ++){
																	$fila2 = @pg_fetch_array($result2,$ñ);
																		for ($u=$p ; $u<=$fila2["day"] ; $u++){
																			if ($u==trim($fila2["day"])){
																				echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>";
																				echo $u;
																				echo "</font></strong></TD>";
																			}else{
																				echo "<TD align=center>";
																				echo "</TD>";
																			}
																		}
																	$p=($fila2["day"]+1);
																}
																		for($t=$p ; $t<34 ; $t++){
																			if ($t==32){
																					echo "<TD align=center><FONT face=\"arial, geneva, helvetica\" size=1 color=#000000><STRONG>";
																					echo "$cant";
																					echo "</font></strong></TD>";
																			}else{
																					echo "<TD align=center>";
																					echo "&nbsp;";
																					echo "</TD>";
																			}
																		}
														   
																		
																			
														
														
														}else{
															if ($frmModo=="ingresar"){
																if (pg_numrows($result2)==0){
																		for ($j=1 ; $j < 32 ; $j++){
																			echo "<TD align=center>";
																		 	echo "<INPUT TYPE=checkbox NAME=\"a[".$X."][".$j."]\">";
																		 	echo "</TD>";
																		}
																}else{
																	  	if (pg_numrows($result2)!=0){
																		$q=1;
																	  		for($k=0 ; $k<pg_numrows($result2) ; $k++){
																				$fila2 = @pg_fetch_array($result2,$k);
																					for ($j=$q ; $j<=$fila2["day"] ; $j++){
																						if ($j==trim($fila2["day"])){
																							echo "<TD align=center>";
																							//echo trim($fila1["rut_alumno"]);
																							echo "<INPUT TYPE=checkbox NAME=\"a[".$X."][".$j."]\" checked>";
																							echo "</TD>";
																						}else{
																							echo "<TD align=center>";
																							//echo trim($fila1["rut_alumno"]);
																							echo "<INPUT TYPE=checkbox NAME=\"a[".$X."][".$j."]\">";
																							echo "</TD>";
																						}
																					}
																				$q=($fila2["day"]+1);
																			}//for($k=0 ; $k<pg_numrows($result2) ; $k++)
																			for($p=$q ; $p<32 ; $p++){
																				echo "<TD align=center>";
																				//echo trim($fila1["rut_alumno"]);
																				echo "<INPUT TYPE=checkbox NAME=\"a[".$X."][".$p."]\">";
																				echo "</TD>";
																			}//for($p=$j ; $p<34 ; $p++)
																		}//if
															}//else
															}//ingresar
												  };//else
											echo "</TD>";
											echo "</TR>";
											}/**else**/
											};
										};
									};
								?>
          <tr>
            <td>&nbsp;</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</form>
</body>
</html>
