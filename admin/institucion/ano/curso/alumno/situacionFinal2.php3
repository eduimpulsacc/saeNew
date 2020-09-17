<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO;
	$docente		=5; //Codigo Docente
	$i =0;
	$j =0;
	$k =0;
	$promedi =0;
	$prome = 0;
	$div = 0;
	$res = 0;
	//------------------------
	// Año Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	
	if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY NOMBRE_PERIODO";
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
				$periodo	= $fila1['id_periodo'];
			}else{
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
			}
		};
	}

	$_PERIODORAMO	=	$periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
?>
<HTML>
	<HEAD>
		<LINK REL="STYLESHEET" HREF="../../../../../util/td.css" TYPE="text/css">
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

		<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'mostrarNotas.php3?aux=1&periodo='+ form.cmbPERIODO.value;
				form.submit(true);
				}
			}
		</SCRIPT>

	</HEAD>
<BODY>
	<?php echo tope("../../../../../util/");?>
	<FORM method=post name="frm">
		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
			<TR height=15>
				
      <TD height="113"> 
        <TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>
								</FONT>
							</TD>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD align=left>
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
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD align=left>
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
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo WHERE (((curso.id_curso)=".$curso."))";
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
													echo trim($fila1['grado_curso'])." - ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
												}
											}
										?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							
							
						</TR>
                          <TR>
							
                   
            <TD align=left> <FONT face="arial, geneva, helvetica" size=2> <strong>PLAN 
              DE ESTUDIO</strong> </FONT> </TD>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>
								</FONT>
							</TD>
                             
            <TD align=left>
              <?php
									$qry4="SELECT curso.id_curso, plan_estudio.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
										$result4 =@pg_Exec($conn,$qry4);
														$fila4= @pg_fetch_array($result4,0);
													
												echo trim($fila4['nombre_decreto']);
									?>
              </TD>
				</TR>
					<TR>
						<BR>
						<BR>
						
						</TR>
						<TR>
							<TD>
								<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=5 width=100% bgcolor=#C0C0C0>
								<?php
									
									//if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
									//if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
									        echo "<TR>";
												echo "<TD align=center>ALUMNO";
												echo "</TD>";
												echo "<TD align=center>PROM";
												echo "</TD>";
												echo "</TR>";
												
										//ALUMNOS DEL CURSO
  									$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";
									$result =pg_Exec($conn,$qry);
								
											for($i=0 ; $i < pg_numrows($result) ; $i++){
												$fila1 = pg_fetch_array($result,$i);
												
												
												  $div =0;
												   //periodo
												 $qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
											     $result6 =pg_Exec($conn,$qry6);
											          
												        $promedi =0;
												         for($j=0 ; $j < pg_numrows($result6) ; $j++){
															$fila6 = pg_fetch_array($result6,$j);
															
															//cantidadd de ramos
													        $qry5="SELECT COUNT(promedio) AS sum FROM CALIFICA WHERE RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$fila6['id_periodo']." AND PROMEDIO <>' ' ";
															$result5 =pg_Exec($conn,$qry5); 
																$fila5= @pg_fetch_array($result5,0); 
																 $div = $div + $fila5['sum'];
															//	echo $div;	
																//echo "hola";
													 
													  //ramos

               										$qry7="SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";
                                                             $result7 =pg_Exec($conn,$qry7);
																$prome =0;
																	for($k=0 ; $k < pg_numrows($result7) ; $k++){
															           $fila7 = pg_fetch_array($result7,$k);
																	   
														?> 
															<TR >
														<?php            
																			 
																		$qry8="SELECT * FROM (CALIFICA INNER JOIN RAMO ON califica.id_ramo = ramo.id_ramo) INNER JOIN tiene$nro_ano ON ((ramo.id_curso =tiene$nro_ano.id_curso) AND (califica.rut_alumno = tiene$nro_ano.rut_alumno)) WHERE CALIFICA.RUT_ALUMNO=".$fila1['rut_alumno']." AND CALIFICA.ID_PERIODO=".$fila6['id_periodo']." AND CALIFICA.ID_RAMO=".$fila7['id_ramo'];
																			$result8 =pg_Exec($conn,$qry8);
																			$fila8= @pg_fetch_array($result8,0);
						                     								$promed = $fila8['promedio'];
																			$prome =($prome + $promed);
															};
															   $promedi = $promedi + $prome;
																//echo $promedi;
																 //echo "chao";				
													};
															
															
																	echo "<TR bgcolor=#ffffff>";
																	echo "<TR bgcolor=#ffffff>";
																	echo "<TD align=left width=400>";
																	echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];
																	echo "</TD>";
																	echo "<TD align=center>";
																	    if ($div!=0) {
																		$res = $promedi/$div;
																		imp (round($res)); }
																		 
																	echo "</TD>";
																	echo "</TR>";
											};
								?>
								</TABLE>
							</TD>
						</TR>
						<TR>
							
            <TD height="23" colspan=4> 
              <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
									<TR>
										
                  <TD height="21"> 
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
	</FORM>
<? pg_close($conn); ?>	
</BODY>
</HTML>