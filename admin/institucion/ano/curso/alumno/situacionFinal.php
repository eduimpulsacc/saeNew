<?php require('../../../../../util/header.inc');?>

<?php 

	$institucion	=$_INSTIT;

	$frmModo		=$_FRMMODO;

	$ano			=$_ANO;

	$alumno			=$_ALUMNO;

	$curso			=$_CURSO;

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

			function  conceptual($nota1,$nota2,$nota3,$periodo){

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

			};

		

		/************************************************************************************/

		/*------------------------- FIN FUNCION NOTAS CONCEPTUALES -------------------------*/

		/************************************************************************************/

?>



<?php

	if($frmModo!="ingresar"){

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('botones/generar_roll.gif','botones/periodo_roll.gif','botones/feriados_roll.gif','botones/planes_roll.gif','botones/tipos_roll.gif','botones/cursos_roll.gif','botones/matricula_roll.gif','botones/reportes_roll.gif')">

<?php if($_PERFIL!=17){?>

<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">

  <tr> 

    <td height="30" align="center" valign="top"> 

      <table width="729" border="0" align="left" cellpadding="0" cellspacing="0">

        <tr> 

          <td width="81" height="30"><a href="../../periodo/listarPeriodo.php3"><img src="../../../botones/periodo.gif" name="Image2" width="81" height="30" border="0" id="Image2"onMouseOver="MM_swapImage('Image2','','../../../botones/periodo_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="../../feriado/listaFeriado.php3"><img src="../../../botones/feriados.gif" name="Image3" width="81" height="30" border="0" id="Image3" onMouseOver="MM_swapImage('Image3','','../../../botones/feriados_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="../../../planEstudio/listarPlanesEstudio.php3"><img src="../../../botones/planes.gif" name="Image4" width="81" height="30" border="0" id="Image4" onMouseOver="MM_swapImage('Image4','','../../../botones/planes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="../../../atributos/listarTiposEnsenanza.php3"><img src="../../../botones/tipos.gif" name="Image5" width="81" height="30" border="0" id="Image5" onMouseOver="MM_swapImage('Image5','','../../../botones/tipos_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><img src="../../../botones/cursos_roll.gif" name="Image6" width="81" height="30" border="0" id="Image6"></a></td>

          <td width="81" height="30"><a href="../../matricula/listarMatricula.php3"><img src="../../../botones/matricula.gif" name="Image7" width="81" height="30" border="0" id="Image7" onMouseOver="MM_swapImage('Image7','','../../../botones/matricula_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="../../../informe_planillas/plantilla/listaPlantillas.php?botonera=1"><img src="../../../botones/informe.gif" name="Image0" width="81" height="30" border="0" id="Image0" onMouseOver="MM_swapImage('Image0','','../../../botones/informe_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

		  <td width="81" height="30"><a href="../../reportes/Menu_Reportes.php?ai_institucion=<?php echo $_INSTIT ;?>"><img src="../../../botones/reportes.gif" name="Image8" width="81" height="30" border="0" id="Image8" onMouseOver="MM_swapImage('Image8','','../../../botones/reportes_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

		  <td width="81" height="30"><a href="../../ActasMatricula/Menu_Actas.php?botonera=1"><img src="../../../botones/actas.gif" name="Image9" width="81" height="30" border="0" id="Image9" onMouseOver="MM_swapImage('Image9','','../../../botones/actas_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

          <td width="81" height="30"><a href="#"><img src="../../../botones/generar.gif" name="Image1" width="81" height="30" border="0" id="Image1" onMouseOver="MM_swapImage('Image1','','../../../botones/generar_roll.gif',1)" onMouseOut="MM_swapImgRestore()"></a></td>

        </tr>

      </table>

	  <?php } ?>

	   </td>

  </tr>

</table>

	<?php //echo tope("../../../../../util/");?>

	<FORM method=post name="frm" action="procesoAlumno.php3">

		<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>

			<TR>

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

											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";

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

												}

											}

										?>

									</strong>

								</FONT>

							</TD>

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

			          <FONT face="arial, geneva, helvetica" size=2>

									<strong>

              <?php

									$qry4="SELECT curso.id_curso, plan_estudio.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";

										$result4 =@pg_Exec($conn,$qry4);

														$fila4= @pg_fetch_array($result4,0);

													

												echo trim($fila4['nombre_decreto']);

									?>

									</strong>

								</FONT>

              </TD>

				</TR>

						<TR>

							

							

							

						</TR>

					</TABLE>

				</TD>

			</TR>

			<TR height=15>

				<TD>

					<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">

						<TR height="50">

							<TD align=right>

								<INPUT class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' TYPE="button" value="VOLVER" onClick=document.location="listarAlumnos.php3">

							</TD>

						</TR>

						<TR height=20 bgcolor=#003b85>

							<TD align=middle>

								<FONT face="arial, geneva, helvetica" size=2 color=White>

									<strong>INFORME DE NOTAS FINALES</strong>

								</FONT>

							</TD>

						</TR>

						<TR>

							<TD>





						<TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">

							<TR>

                  <TD> <table border=1 cellspacing=2 cellpadding=2 width=100%>

                      <tr> 

                        <td colspan=43 align="center">NOTAS</td>

                      </tr>

                      <tr> 

                        <td width="81%">ALUMNOS</td>

                        <td width="19%"align="center">PROMEDIO FINAL</td>

                        <!--TD>PC</TD-->

                      </tr>

                      <?php

									if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL

									if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR

									      

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

															//cantidad de ramos

													        $qry5="SELECT COUNT(promedio) AS sum FROM NOTAS WHERE RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$fila6['id_periodo']." AND PROMEDIO <>' ' AND PROMEDIO<>'0'";

																 $result5 =pg_Exec($conn,$qry5); 

																   $fila5= @pg_fetch_array($result5,0); 

																     $div = $div + $fila5['sum'];

													  //ramos

               /*										$qry7="SELECT ramo.id_ramo, subsector.nombre, ramo.modo_eval FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))";

                                                             $result7 =pg_Exec($conn,$qry7);

																$prome =0;

																	for($k=0 ; $k < pg_numrows($result7) ; $k++){

															           $fila7 = pg_fetch_array($result7,$k);

														*/			   

														?> 

															

														<?php            

																			$prome =0;

																			$qry8="SELECT * FROM notas INNER JOIN tiene$nro_ano ON ((notas.id_ramo =tiene$nro_ano.id_ramo) AND (notas.rut_alumno = tiene$nro_ano.rut_alumno)) WHERE notas.RUT_ALUMNO=".$fila1['rut_alumno']." AND notas.ID_PERIODO=".$fila6['id_periodo'];

																			//$qry8="SELECT * FROM (CALIFICA INNER JOIN RAMO ON califica.id_ramo = ramo.id_ramo) INNER JOIN TIENE3 ON ((ramo.id_curso =tiene3.id_curso) AND (califica.rut_alumno = tiene3.rut_alumno)) WHERE CALIFICA.RUT_ALUMNO=".$fila1['rut_alumno']." AND CALIFICA.ID_PERIODO=".$fila6['id_periodo']." AND CALIFICA.ID_RAMO=".$fila7['id_ramo'];

																			$result8 =pg_Exec($conn,$qry8);

																			for($k=0 ; $k < pg_numrows($result8) ; $k++){

																			$fila8= @pg_fetch_array($result8,$k);

						                     								$promed = $fila8['promedio'];

																			$prome =($prome + $promed);

																	};

															  		 $promedi = $promedi + $prome;

															};

																	

														?>

                      

											

                      <tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='cursor' onmouseout=this.style.background='transparent'>

                        <td><?php echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];?></td>

                      

                        <td align="center"> 

                          <?php 

																	if ($div!=0) {

																		$res = $prome/$div;

																		imp (round($res));

																		$gen = $gen +$res;

																		}

																		if ($promedi !=0){

																		$divisor= $divisor +1;

																		}

																		

																?>

                        </td>

                        <?php				};

									}

							}

						

								?>

								

                      <tr height=5 bgcolor=black> 

                        <td colspan=39></td>

                      </tr>

                      <tr> </tr>

                      <tr height=20> 

                        <td colspan=38></td>

                      </tr>

                      <tr> 

                        <td width ="81%">PROMEDIO FINAL DEL CURSO</td>

                        <td width="19%"align="center"> 

                          <?php 

																	if($gen!=0)

																		echo (round($gen/$divisor));

																		

																?>

                        </td>

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
<? pg_close($conn); ?>
</BODY>
</HTML>