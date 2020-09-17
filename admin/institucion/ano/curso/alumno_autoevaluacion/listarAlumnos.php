<?php require('../../../../../util/header.inc');?>

<?php 
	if ($ano){
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
	  	};
	}
	if ($curso){
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
	  	};
	}

//echo $_MENU."--".$_CATEGORIA."---".$_ITEM;
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;	
	$_POSP          = 5;
	
	$_bot           = 5;
	
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//curso.ensenanza=".pg_result($rs_acceso,3)."
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			/*$whe_perfil_curso=" AND curso.ensenanza in (";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['cod_tipo'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['cod_tipo'];
				}
			}*/
			$whe_perfil_curso.= /*)*/"  AND id_curso in(";
			
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=2)&&($_PERFIL!=20)&&($_PERFIL!=27)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
	if (trim($_url)=="") $_url=0;
	//imprime_array($_SESSION);

?>


 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar   </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--p
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

 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="listarAlumnos.php?caso=10&pa=1&ano="+ano2+"&frmModo="+frmModo+"&from=2";
				form.action = pag;
				form.submit(true);	
			}		
		 }
        function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="listarAlumnos.php?caso=10&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}		 
		
//-->
</script>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

	


</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><? $menu_lateral="3_1";?><?
					  
						 include("../../../../../menus/menu_lateral.php");
						 
						 
						 ?>
						 
						 
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr>
                                <td valign="top"><table WIDTH="600" BORDER="0" CELLSPACING="1" CELLPADDING="3">
                                  <TR height=15>
                                    <TD COLSPAN=2><table border=0 cellspacing=1 cellpadding=1>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>INSTITUCION</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>
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
                                        </strong> </font> </td>
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                        <td><?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
                                            <form name="form"   action="" method="post">
                                              <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
                                              <select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                                                <option value=0 selected>(Seleccione un A&ntilde;o)</option>
                                                <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
                                              </select>
                                            </form>
                                            <? }	?>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td align=left><font face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </font> </td>
                                        <td><font face="arial, geneva, helvetica" size=2> <strong>:</strong> </font> </td>
                                        <form name="form"   action="" method="post">
                                          <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
                                          <td  valign="bottom"><font face="arial, geneva, helvetica" size=2> <strong>
                                            <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
                                            <? 
			  //Aqui Rescado el grado del curso
			 
			  								
			  $qry1     = "select * from curso where id_curso = '".trim($curso)."'";
			  $res1     =   @pg_Exec($conn,$qry1);
			  $fila11   = @pg_fetch_array($res1,0);
			  $grado    = $fila11['grado_curso'];
			  $tipoense = $fila11['ensenanza'];
			  								
											
											
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
//echo $sql_curso;
$resultado_query_cue = pg_exec($conn,$sql_curso);
                                            ?>
                                            <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
                                              <option value=0 selected>(Seleccione un Curso)</option>
                                              <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
                                            </select>
                                          </strong> </font> </td>
                                        </form>
										
					
										
                                      </tr>
                                    </table></TD>
                                  </TR>
								  <? if ($curso){?>
                                  <tr>
                                    <td colspan=2 align=right>
									    <?
									    
												$qry_temp="SELECT * from curso where id_curso = $curso ";
												$result_temp =@pg_Exec($conn,$qry_temp);
												$fila_temp=@pg_fetch_array($result_temp);
											
												
												$id_curso = $fila_temp['id_curso'];
												$grado_curso= $fila_temp['grado_curso'];
												$ensenanza= $fila_temp['ensenanza'];
												
												if($grado_curso==1) $gr="pa";
												if($grado_curso==2) $gr="sa";
												if($grado_curso==3) $gr="ta";
												if($grado_curso==4) $gr="cu";
												if($grado_curso==5) $gr="qu";
												if($grado_curso==6) $gr="sx";
												if($grado_curso==7) $gr="sp";
												if($grado_curso==8) $gr="oc";	
												
												
												$sqlTraePlantilla="SELECT informe_plantilla.titulo_informe1, informe_plantilla.nuevo_sis, informe_plantilla.id_plantilla FROM informe_plantilla WHERE tipo_ensenanza=".$ensenanza." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
												$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
												$filaPlantilla=@pg_fetch_array($resultPlantilla);	
												$nuevo = $filaPlantilla['nuevo_sis'];
												
												if($nuevo == 1){
													
												}										    
									    		else{
												    if (($_PERFIL!=15) AND ($_PERFIL!=16) and ($_PERFIL!=2) and ($_PERFIL!=20)){ 
														/*if($_PERFIL==0 or $_PERFIL==14 or $_PERFIL==17){ ?>
													   <label>
			<!--                                             <input name="Submit" type="submit" class="botonXX" onClick="MM_goToURL('parent','muestraPlantilla_new.php?tipoEns=<?php echo trim($fila["cod_tipo"]);?>&grado=<?=$grado ?>&cmb_curso=<?=$cmb_curso ?>');return document.MM_returnValue" value="INFORME DE PERSONALIDAD POR CURSO">-->
			                                             <input name="Submit" type="submit" class="botonXX" onClick="MM_goToURL('parent','muestraPlantilla_curso.php?tipoEns=<?php echo trim($tipoense);?>&grado=<?=$grado ?>&cmb_curso=<?=$cmb_curso ?>');return document.MM_returnValue" value="INFORME DE PERSONALIDAD POR CURSO">
			
			                                           </label>
											       	<? 
												   		}*/
									   				} 
									   	
									    		}
									   	?>
									    <!--<input name="button" type="button" onClick=document.location="situacionFinal.php3?caso=1" value="SITUACION FINAL ALUMNOS"> -->
                                        <!--AGREGAR UN ALUMNO, OSEA INSCRIBIRLO EN UN CURSO SE REALIZA AL MOMENTO DE MATRICULARLO-->
                                       <? if ($_PERFIL==0){?>  <input name="Submit" type="submit" class="botonXX" onClick="MM_goToURL('parent','muestraPlantilla_curso.php?tipoEns=<?php echo trim($tipoense);?>&grado=<?=$grado ?>&cmb_curso=<? echo $curso; ?>');return document.MM_returnValue" value="INFORME DE PERSONALIDAD POR CURSO">
			<? } ?>
                                        <?php if(($_PERFIL!=15)and($_PERFIL!=16) and ($_PERFIL!=2) and ($_PERFIL!=20)) { ?>
                                                 <INPUT class="botonXX" TYPE="button" value="VOLVER" onClick=document.location="../seteaCurso.php3?caso=4">
                                        <?php } ?>
                                    </td>
                                  </tr>
                                  <tr height="20" >
                                    <td colspan="2" align="middle" class="tableindex"> TOTAL DE ALUMNOS = <b>
                                      <?php

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
                                    </b></td>
                                  </tr>
                                  <tr class="tablatit2-1">
                                    <td align="center" width="80"> RUT </td>
                                    <td align="center" width="520"> NOMBRE </td>
                                  </tr>
                                  <?php

				$qry="SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso, matricula.bool_ar FROM (curso INNER JOIN matricula ON curso.id_curso = matricula.id_curso) INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno WHERE (((matricula.id_curso)=".$curso.") AND ((matricula.id_ano)=".$ano.")) order by nro_lista,ape_pat ASC ";

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
                                  <tr onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent' onClick=go('muestraPlantilla.php?tipoEns=<?=$tipoense ?>&grado=<?=$grado ?>&alumno=<?php echo trim($fila8["rut_alumno"]);?>')>
                                    <?php }else{ ?>
                                  <tr>
                                    <?php } ?>
									<td align="center" ><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong><?php echo $fila8["rut_alumno"]." - ".$fila8["dig_rut"];?></strong> </font> </td>
                                    <td align="left" <? if ($fila8['bool_ar'] == 1){?>class="tachado"<? }else{?>class="textosimple"<? }?>><font face="arial, geneva, helvetica" size="1" color="#000000"> <strong><?php echo $fila8["ape_pat"]." ".$fila8["ape_mat"].", ".$fila8["nombre_alu"];?></strong> </font> </td>
									
                                  </tr>
                                  <?php

					}

				}

			?>
                                  <tr>
                                    <td colspan="4"><hr width="100%" color="#003b85">
                                    </td>
                                  </tr>
                                  <?php if(($_PERFIL!=15)and($_PERFIL!=15)) { ?>
                                  <tr>
                                    <td align="left" colspan="2"><font face="arial, geneva, helvetica" size="1" color="#666666"> <strong>ALUMNOS DE SEXO MASCULINO = <b>
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
                                    <td align="left" colspan="2"><font face="arial, geneva, helvetica" size="1" color="#666666"> <strong>ALUMNOS DE SEXO FEMENINO = <b>
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
                                    <td align="left" colspan="2"><font face="arial, geneva, helvetica" size="1" color="#666666"> <strong>ALUMNAS EMBARAZADAS = <b>
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
  <td align="left" colspan="2"><font face="arial, geneva, helvetica" size="1" color="#666666"> <strong>ALUMNOS DE ORIGEN INDIGENA DE SEXO MASCULINO= <b>
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
  <td align="left" colspan="2"><font face="arial, geneva, helvetica" size="1" color="#666666"> <strong>ALUMNOS DE ORIGEN INDIGENA DE SEXO FEMENINO= <b>
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
  </tr><? }?>
  <?php } ?>
                                </table></td>
                              </tr></table>                         </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>