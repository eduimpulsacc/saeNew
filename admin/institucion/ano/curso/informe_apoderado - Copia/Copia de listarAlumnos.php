<?php require('../../../../../util/header.inc');?>

<?php 

	$institucion	=$_INSTIT;

	$ano			=$_ANO;

	$curso			=$_CURSO;
	
	$_POSP          = 5;
	
	$_bot           = 5;

	if (trim($_url)=="") $_url=0;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../Sea/estilos.css" rel="stylesheet" type="text/css">
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
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

	

<link href="../../../../../util/objeto.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../Sea/cortes/b_ayuda_r.jpg','../../../../../Sea/cortes/b_info_r.jpg','../../../../../Sea/cortes/b_mapa_r.jpg','../../../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../Sea/<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7">  
             <? include("../../../../../cabecera/menu_superior.php"); ?>
                           
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?  // include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390"><!-- inicio nuevo codigo -->
								  
								  
								  
								  
								  
								  
<?php if($_PERFIL!=17){ ?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? include("../../../../../cabecera/menu_inferior.php"); ?> 
	  </td>
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../util/");?>

	<center>

		<table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">

			<TR height=15>

			  <TD COLSPAN=2>

					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>

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

												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila = @pg_fetch_array($result,0);	

													if (!$fila){

														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');

														exit();

													}

													echo trim($fila['nombre_instit']);

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

													$fila = @pg_fetch_array($result,0);	

													if (!$fila){

														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');

														exit();

													}

													echo trim($fila['nro_ano']);

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

											$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";



											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

											}else{



												$fila = @pg_fetch_array($result,0);	

												if (!$fila){

													error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');

													exit();

												}

												echo trim($fila['grado_curso'])."-".trim($fila['letra_curso'])." ".trim($fila['nombre_tipo']);

											}

										?>

									</strong>

								</FONT>

							</TD>

						</TR>

					</TABLE>

				</TD>

			</TR>

			<tr>

				

      <td colspan=2 align=right> <!--<input name="button" type="button" onClick=document.location="situacionFinal.php3?caso=1" value="SITUACION FINAL ALUMNOS"> -->

        <!--AGREGAR UN ALUMNO, OSEA INSCRIBIRLO EN UN CURSO SE REALIZA AL MOMENTO DE MATRICULARLO-->

		<?php if(($_PERFIL!=15)and($_PERFIL!=16)) { ?>

		<input class="botonXX"  TYPE="button" onClick=window.open("ImprimeListaAlumnos.php?_url=0","","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=700,height=650,top=85,left=140") value="IMPRIMIR">										

        <INPUT class="botonXX" TYPE="button" value="VOLVER" onClick=document.location="../seteaCurso.php3?caso=4">

		<?php } ?>

				</td>

			</tr>

			<tr height="20" bgcolor="#003b85">

				<td colspan="2" align="middle" class="tableindex">

					TOTAL DE ALUMNOS =

						<b><?php

											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA WHERE ID_ANO=(".$ano.")  AND ID_CURSO=(".$curso.")";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila7 = @pg_fetch_array($result,0);	

													if (!$fila7){

														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');

														exit();

													}

													echo trim($fila7['suma']);

												}

											}

										?>

						                

						

				</td>

			</tr>

			<tr class="tablatit2-1">

				<td align="center" width="80">

					RUT

				</td>

				<td align="center" width="520">

					NOMBRE

				</td>

			</tr>

			<?php

				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by ape_pat, ape_mat, nombre_alu asc ";

				$result =@pg_Exec($conn,$qry);

				if (!$result) {

					error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');

				}else{

				if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.

					$fila8 = @pg_fetch_array($result,0);	

					if (!$fila8){

						error('<B> ERROR :</b>Error al acceder a la BD. (8) No hay alumnos inscritos en este curso</B>');

						exit();

					}

				}

			?>

			<?php

					for($i=0 ; $i < @pg_numrows($result) ; $i++){

						$fila8 = @pg_fetch_array($result,$i);

			?>

						<?php if(($_PERFIL!=15)and($_PERFIL!=16)) { ?>

						<!--tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('muestraPlantilla.php?tipoEns=<?php /*echo $tipoEns;?>&grado=<?php echo $grado?>&alumno=<?php echo trim($fila["rut_alumno"]);*/?>')-->
						<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('muestraPlantilla.php?tipoEns=<?php echo trim($fila["cod_tipo"]);?>&grado=<?php echo trim($fila["grado_curso"])?>&alumno=<?php echo trim($fila8["rut_alumno"]);?>')>

						<?php }else{ ?>

						<tr>

						<?php } ?>

							<td align="center" >

								<font face="arial, geneva, helvetica" size="1" color="#000000">

                                <strong><?php echo $fila8["rut_alumno"]." - ".$fila8["dig_rut"];?></strong> </font>

							</td>

							<td align="left" >

								<font face="arial, geneva, helvetica" size="1" color="#000000">

									<strong><?php echo $fila8["ape_pat"]." ".$fila8["ape_mat"].", ".$fila8["nombre_alu"];?></strong>

								</font>

							</td>

						</tr>

			<?php

					}

				}

			?>

			<tr>

				<td colspan="4">

				<hr width="100%" color="#003b85">

				</td>

			</tr>

<?php if(($_PERFIL!=15)and($_PERFIL!=15)) { ?>			

              <tr>

      <td align="left" colspan="2"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 

        <strong>ALUMNOS DE SEXO MASCULINO = <b> 

        <?php

											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND SEXO = '2')";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila5 = @pg_fetch_array($result,0);	

													if (!$fila5){

														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

														exit();

													}

													echo trim($fila5['suma']);

												}

											}

										?>

        </b></strong> </font> </td>

			</tr>

                     <tr>

                  

          <td align="left" colspan="2"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 

               <strong>ALUMNOS DE SEXO FEMENINO = <b> 

        <?php

											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND SEXO = '1')";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila5 = @pg_fetch_array($result,0);	

													if (!$fila5){

														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

														exit();

													}

													echo trim($fila5['suma']);

												}

											}

										?>

                </b></strong> </font> </td>

			</tr>

               <tr>

                  

                <td align="left" colspan="2"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 

                  <strong>ALUMNAS EMBARAZADAS = <b> 

                 <?php

				 

											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND matricula.bool_ae = '1')";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila5 = @pg_fetch_array($result,0);	

													if (!$fila5){

														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

														exit();

													}

													echo trim($fila5['suma']);

												}

											}

										?>

                </b></strong> </font> </td>

			</tr>

                    <td align="left" colspan="2"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 

                       <strong>ALUMNOS DE ORIGEN INDIGENA DE SEXO MASCULINO= <b> 

                 <?php

											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND matricula.bool_aoi= '1' AND SEXO='2')";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila5 = @pg_fetch_array($result,0);	

													if (!$fila5){

														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

														exit();

													}

													echo trim($fila5['suma']);

												}

											}

										?>

                  </b></strong> </font> </td>

			  </tr>



              </tr>

                    <td align="left" colspan="2"> <font face="arial, geneva, helvetica" size="1" color="#666666"> 

                       <strong>ALUMNOS DE ORIGEN INDIGENA DE SEXO FEMENINO= <b> 

                 <?php

											$qry="SELECT COUNT(*) AS SUMA FROM MATRICULA INNER JOIN ALUMNO ON MATRICULA.rut_alumno = ALUMNO.rut_alumno WHERE (MATRICULA.ID_ANO=(".$ano.")  AND MATRICULA.ID_CURSO=(".$curso.") AND matricula.bool_aoi= '1' AND SEXO='1')";

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');

											}else{

												if (pg_numrows($result)!=0){

													$fila5 = @pg_fetch_array($result,0);	

													if (!$fila5){

														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');

														exit();

													}

													echo trim($fila5['suma']);

												}

											}

										?>

                  </b></strong> </font> </td>

			  </tr>
			

			<?php } ?>

		</table>

	</center>


								  
								  
								  
								  
								  
								  
								  
								  <!-- fin nuevo codigo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../Sea/<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
