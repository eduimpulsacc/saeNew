<?php 

	require('../../../util/header.inc');

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;

    $_POSP = 3;
    $_bot  = 3;
    

	$largoPagina=40;

	$pagOffset=$largoPagina*($pag-1);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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



		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		</head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../Sea/cortes/b_ayuda_r.jpg','../../../Sea/cortes/b_info_r.jpg','../../../Sea/cortes/b_mapa_r.jpg','../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
		  <td width="0%" align="left" valign="top" bgcolor="f7f7f7">
          <? include("../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=2; include("../../../menus/menu_lateral.php"); ?>
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <!--<td height="395" align="left" valign="top"> -->
                              <table width="10%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="">
								  

										<?php

											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;

											$result =@pg_Exec($conn,$qry);

											if (!$result) {

												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');

											}
										?>

  
				<form method="post" name="frm1" action="../atributos/listarInstituciones.php?listar=A&pag=1">

					<table  border="0" cellpadding="0" cellspacing="0" width=600>

						<tr>

							<td align="left" width=0>

								<table width="99%" align=center>

            <tr valign=bottom>

										<td width="17%">

											

										</td>

							<?php $qry3="SELECT  plan_estudio.* FROM plan_estudio  WHERE plan_estudio.cod_decreto=".$plan;

									$result3 =@pg_Exec($conn,$qry3);

									if (pg_numrows($result3)!=0){

										$fila = @pg_fetch_array($result3,0);	

									if (!$fila){

										error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>'.$qry3);

										exit();

										

									};

									};

									

									if ($fila['rdb']!=0){

							?>

										<td width="70%" align="right"><INPUT class="botonXX"  TYPE="button" value="MODIFICAR" onClick=document.location="ModPlanPropio.php3?plan=<?php echo $plan ?>&<? $_FRMMODO='modificar'?>"> 

             							</td>

									<?php }; ?>

										<!------------------/filtro por RBD/-------------->

											

              <td width="13%" align=right>

			  <INPUT class="botonXX" TYPE="button" value="VOLVER" onClick=document.location="listarPlanesEstudio.php3"> </td>

									<!------------------/find filtro por RBD/-------------->

								  </tr>

									

								</table>

							</td>

						</tr>


					</table>

	

				</form>

<?php

	if($frmModo=="mostrar"){

	   $qry="SELECT  plan_estudio.* FROM plan_estudio, institucion  WHERE ((institucion.rdb)=".$institucion.")AND ((plan_estudio.cod_decreto)=".$plan.") ORDER BY cursos";	

		//$qry="SELECT DISTINCT plan_estudio.* FROM (plan_estudio INNER JOIN curso ON plan_estudio.cod_decreto = curso.cod_decreto) INNER JOIN (institucion INNER JOIN matricula ON institucion.rdb = matricula.rdb) ON  curso.id_ano = matricula.id_ano WHERE (((institucion.rdb)=".$institucion.")AND ((plan_estudio.cod_decreto)=".$plan.")) ORDER BY cursos";

		$result =pg_Exec($conn,$qry);

		if (!$result) {

			error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>'.qry);

		}else{

			if (pg_numrows($result)!=0){

				$fila = @pg_fetch_array($result,0);	

				if (!$fila){

					error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');

					exit();

				};

			};

		};

	};

?>



	

<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=600 >

  <tr>

			<td colspan=6>

				<table width="100%" cellpadding="0" cellspacing="0" >

					<tr>

												

					</tr>

                        

				</table>

			</td>

  </tr>

		<tr height="20" >

			

    <td colspan="6" align="center" class="tableindex">  Plan de Estudio </td>

		</tr>

		

    <td ALIGN=CENTER WIDTH=187> <font face="arial, geneva, helvetica" size="1" color="#000000"> 

      <strong>CODIGO DE RESOLUCION</strong> </font> </td>

			

    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 

      <strong>NOMBRE DE RESOLUCION</strong> </font> </td>

			 

    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 

      <strong>DESCRIPCION</strong> </font> </td>

 		</tr>

				

				<td align="center"><font face="arial, geneva, helvetica" size="2" color="#000000">

						<strong><?php 

							 echo($fila['cod_decreto']) 

						?>

						</strong>

					</font>

				</td>

				<td align="center">

					<font face="arial, geneva, helvetica" size="2" color="#000000">

						<strong>

						<?php echo $fila["nombre_decreto"];?>

						</strong>

					</font>

				</td>

				<td align="center">

					<font face="arial, geneva, helvetica" size="2" color="#000000">

						<strong>

						<?php echo $fila["cursos"];?>

						</strong>

					</font>

				</td>

			</tr>

		

		<tr>

			<td colspan="6">

			<br>

  <tr>

			<td colspan=6>

				<table width="100%" cellpadding="0" cellspacing="0" >

					<tr>

												

					</tr>

                        

				</table>

			</td>

  </tr>

		

  <tr height="20" bgcolor="#009999"> 

    <td colspan="6" align="center" class="tablatit2-1">  Tipos de Enseñanza Asociados </td>

  </tr>

		

    <td ALIGN=CENTER WIDTH=187> <font face="arial, geneva, helvetica" size="1" color="#000000"> 

      <strong>CODIGO</strong> </font> </td>

			

    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 

      <strong>DESCRIPCION</strong> </font> </td>

			 

    <td width="231" ALIGN=CENTER> <font face="arial, geneva, helvetica" size="1" color="#000000"> 

      <strong>GRADOS</strong> </font> </td>

 		</tr>

				<?php

				

				

//		if($frmModo=="mostrar"){

		  $qry5=" select * from plan_tipo inner join cursos_plan on plan_tipo.cod_decreto=cursos_plan.cod_decreto where cursos_plan.cod_decreto=".$plan." ORDER BY cod_tipo";

	  	  //$qry5="SELECT * FROM cursos_plan  WHERE ((cursos_plan.cod_decreto)=".$plan.") ORDER BY cod_tipo";	

			$result5 =@pg_Exec($conn,$qry5);

				if (!$result5) {

				error('<B> ERROR :</b>Error al acceder a la BD. (11)</B>'.$qry5);

				}else{

					if (pg_numrows($result5)!=0){

				$fila5 = @pg_fetch_array($result5,0);	

					if (!$fila5){

					error('<B> ERROR :</b>Error al acceder a la BD. (22)</B>');

					exit();

						};

					};

				};

			

			

			for($i=0 ; $i < @pg_numrows($result5) ; $i++){

				$fila5 = @pg_fetch_array($result5,$i);

			   

		?>

				<tr VALIGN=TOP bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('../atributos/seteaTipoEnse.php3?ensenanza=<?php echo trim($fila5["cod_tipo"]);?>&plan=<?php echo trim($fila["cod_decreto"]);?>&caso=3&institucion1=<?php echo $institucion ?>')>

				<td align="center"><font face="arial, geneva, helvetica" size="1" color="#000000">

						<strong><?php 

							 echo($fila5['cod_tipo']) 

						?>

						</strong>

					</font>

				</td>

				<td align="center">

					<font face="arial, geneva, helvetica" size="1" color="#000000">

						<strong>

						<?php $qry2="SELECT * from tipo_ensenanza WHERE ((tipo_ensenanza.cod_tipo)=".$fila5['cod_tipo'].")"; 

						  $result2 =@pg_Exec($conn,$qry2);

						   if (pg_numrows($result2)!=0){

							$fila2 = @pg_fetch_array($result2,0);	

							};

						 echo $fila2['nombre_tipo'];?>

						</strong>

					</font>

				</td>

				<td align="center">

					<font face="arial, geneva, helvetica" size="1" color="#000000">

						<strong>

						<?php

								if ($fila5['pa']==1){

										echo('Primer Año'.' ');

								}

								if ($fila5['sa']==1){

										echo('Segundo Año'.' ');

								}

								if ($fila5['ta']==1){

										echo('Tercer Año'.' ');

								}

								if ($fila5['cu']==1){

										echo('Cuarto Año'.' ');

								}

								if ($fila5['qu']==1){

										echo('Quinto Año'.' ');

								}

								if ($fila5['sx']==1){

										echo('Sexto Año'.' ');

								}

								if ($fila5['sp']==1){

										echo('Septimo Año'.' ');

								}

								if ($fila5['oc']==1){

										echo('Octavo Año'.' ');

								}

								switch ($fila5["grado"]) {

														 case 1:

															 imp('Primer Año');

															 break;

														 case 2:

															 imp('Segundo Año');

															 break;

														 case 3:

															 imp('Tercer Año');

															 break;

														 case 4:

															 imp('Cuarto Año');

															 break;

														 case 5:

															 imp('Quinto Año');

															 break;

														 case 6:

															 imp('Sexto Año');

															 break;

														 case 7:

															 imp('Septimo Año');

															 break;

														 case 8:

															 imp('Octavo Año');

															 break;

													 };

							 ?>

						</strong>

					</font>

				</td>

			</tr>

		<?php };

	//	   };?>

		<tr>
			<td>
					<?php if($frmModo=="ingresar"){ ?>

													

												<?php  if($_TIPOINSTIT==1){//COLEGIO?>

													<Select name="menu1" onChange="combo();">

												<?php  }else{ ?>

													<!--<Select name="cmbENS"> -->

												<?php }?>

													<option value=0 selected></option>

												 

													<?php 

														$qry="SELECT * FROM plan_estudio";

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

																	if($_TIPOINSTIT==1){//COLEGIO

																		if($fila["cod_tipo"]>100) // PARA QUE MUESTRE TODO

																			echo  "<option value=".$fila["cod_decreto"].">".$fila["nombre_decreto"]."</option>";

																	}

																	if($_TIPOINSTIT==2){//JARDIN INFANTIL

																		if(($fila["cod_tipo"]<100)&&($fila["cod_tipo"]>40)) //AGREGANDO LAS SC

																		if(($fila["cod_tipo"]<100))

																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";

																	}

																	if($_TIPOINSTIT==3){//SALACUNA

																		if($fila["cod_tipo"]<=40) // SOLO SALACUNA

																			echo  "<option value=".$fila["cod_tipo"].">".$fila["nombre_tipo"]."</option>";

																	}

																}

															} 

														}; 

													?>

												</Select>

											

											<?php };?>	

			</td>

		</tr>



		 <tr>

			<td colspan="6">

			<hr width="100%" color="#0099cc">

			</td>

		</tr>

		<tr height="50" bgcolor="white">

			<td align="middle" colspan="6">



				<?php 

                      

                      if($pag!=0){?>

					<a HREF="../atributos/listarTiposEnsenanza.php?pag=<?php echo ($pag-1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">

						<font face="arial, geneva, helvetica" size="2" color="black">

							<strong>Anteriores <?php echo $largoPagina?> ...</strong>

						</font>

					</a>

					<?php if(pg_numrows($result)==$largoPagina){?>

						&nbsp;&nbsp;&nbsp;

						<font face="arial, geneva, helvetica" size="5" color="black">

							<strong>-</strong>

						</font>

						&nbsp;&nbsp;&nbsp;

					<?php }?>



				<?php }?>

				<?php if(pg_numrows($result)==$largoPagina){?>

					<a HREF="../atributos/listarTiposEnsenanza.php?pag=<?php echo ($pag+1)?>&listar=<?php echo trim($listar)?>&tipoIns=<?php echo trim($tipoIns) ?>">

						<font face="arial, geneva, helvetica" size="2" color="black">

							<strong>Siguientes <?php echo $largoPagina?> ...</strong>

						</font>

					</a>

				<?php }?>

			</td>

		</tr>

<!--</table>-->

	<?php //}  ?>


</table>
								  
								  
								  <!-- fin nuevo -->
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
								  
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
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
