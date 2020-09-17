<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$_POSP = 5;
	$_bot = 8;
	
	if (trim($_url)=="") $_url=0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>

<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
<!--
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
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

function enviacmb(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'Rprt5.php';
		form.submit(true);
	}	
}
function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function enviapag(form){
	if (form.cmb_insti.value!=0){
		form.cmb_insti.target="self";
		form.target="_parent";
		form.action = 'Rprt7.php';
		form.submit(true);
	}	
}
//-->

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="6" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="965" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
				$sql_grado="select * from curso where id_curso=".$_POST["cmb_grado"];
				$resultgrado= @pg_Exec($conn,$sql_grado);
				$filagr = @pg_fetch_array($resultgrado,0);
				$grado=$filagr["grado_curso"];
									
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td align="left" valign="top">
					  <form name="form" method="post">
					  <table width="700" height="179" cellpadding="0" cellspacing="0" border="1">
                          <tr class="tableindex" align="center">
                            <td colspan="6"><center>
                                <font face="Arial, Helvetica, sans-serif" size="2"> TOTAL DE POSTULACIONES A ESTABLECIMIENTO CORPORACI&Oacute;N </font>
                            </center></td>
                          </tr>
                          <tr>
                            <td height="31" colspan="2" align="left">Institucion Origen </td>
							<td width="327"><select name="cmb_insti" class="ddlb_9_x" onChange="enviapag(this.form);"s>
                                <? $sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
							  		$resultcorp= @pg_Exec($conn,$sqlcorp);
									$filacorp = @pg_fetch_array($resultcorp,0);
									$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
									$result2= @pg_Exec($conn,$sqlinsti);
									
								?>
                                <option value=0 selected>(Seleccione Institucion)</option>
                                <?
								 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
									{  
									$fila = @pg_fetch_array($result2,$z); 
									
									if (($fila['rdb'] == $_POST["cmb_insti"]) or ($fila['rdb'] == $_POST["cmb_insti"])){
									   echo "<option value=".$fila['rdb']." selected>".$fila['nombre_instit']." </option>";
									}else{	    
									   echo "<option value=".$fila['rdb'].">".$fila['nombre_instit']." </option>";
									}
								 } 
								 ?>
                              </select></td>
				  </tr>
						<tr>
						<td>Año Escolar</td>
						<td colspan="2">
						             <?php				
											
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion." $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				$filann = @pg_fetch_array($result,0);	?>
					<input type="hidden" name="frmModo" value="<?=$frmModo ?>">
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  if ($id_ano == $cmb_ano){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."</option>";
                              }
							} ?>
							</select>
						</td>
						</tr>
				  
                          
                          <? 				$sqlinst="select nombre_instit from  institucion where rdb =".$_POST["cmb_insti"];
											$resultinst= pg_exec($conn,$sqlinst);
		        							$filainst = @pg_fetch_array($resultinst,0); 
									  ?>
                          <tr>
                            <td width="370" height="31"><font face="Arial, Helvetica, sans-serif" size="2">Nombre Establecimiento Origen:</font></td>
                            <td colspan="5"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;
                                  <?= $filainst["nombre_instit"]?>
                            </font></td>
                          </tr>
                          <tr>
                            <td><font face="Arial, Helvetica, sans-serif" size="2">A&ntilde;o: </font></td>
                            <td colspan="5">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2">
                              <? $sql4="select nro_ano from  ano_escolar where id_ano =".$cmb_ano;
									$result3= pg_exec($conn,$sql4);
		        					$fila2 = @pg_fetch_array($result3,0); 
									$ano_esco = $fila2["nro_ano"];
									echo $ano_esco;
									?>
                            </font></td>
                          </tr>
                          <tr>
                            <td height="49" colspan="3">
							<table width="635" border="1" align="center" cellspacing="0" cellpadding="0">
                              <tr class="tableindex">
                                <td width="407" align="center">Establecimiento Destino </td>
                                <td colspan="100" align="center"><font face="Arial, Helvetica, sans-serif" size="2">Cursos</font></td>
                              </tr>
                              <tr class="tableindex">
                                <td><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
                                <td width="42" align="center">1</td>
                                <td width="58" align="center">2</td>
                                <td width="58" align="center">3</td>
                                <td width="58" align="center">4</td>
							    <!---------curso II-------------------->
                              </tr>
                              <tr>
                                <td><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
                                <td width="42">&nbsp;</td>
                                <td width="58">&nbsp;</td>
                                <td width="58">&nbsp;</td>
                                <td width="58">&nbsp;</td>
                                <!---------curso II-------------------->
                              </tr>
                              <tr>
                                <td>&nbsp;<?= $filainst["nombre_instit"];?></td>
                                <td width="42"><?
								
							   	$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=1";
								$prefe1= @pg_Exec($conn,$sqlprefe1);
								$filaprefe1_1 = @pg_fetch_array($prefe1,0);
								
								$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$_POST["cmb_insti"]." and preferencia=2 and id_estado=0 and grado=1";
								$prefe2= @pg_Exec($conn,$sqlprefe2);
								$filaprefe2_1 = @pg_fetch_array($prefe2,0);
								
							   	$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=1";
								$prefe3= @pg_Exec($conn,$sqlprefe3);
								$filaprefe3_1 = @pg_fetch_array($prefe3,0);
								
								$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=1";
								$prefe4= @pg_Exec($conn,$sqlprefe4);
								$filaprefe4_1 = @pg_fetch_array($prefe4,0);
								
								$sqlprefe5="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=1";
								$prefe5= @pg_Exec($conn,$sqlprefe5);
								$filaprefe5_1 = @pg_fetch_array($prefe5,0);
								
								echo $filaprefe1_1["cuenta"]+$filaprefe2_1["cuenta"]+$filaprefe3_1["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"];?>&nbsp;</td>
                                <td width="58"><?
								
								
							   	$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=2";
								$prefe1= @pg_Exec($conn,$sqlprefe1);
								$filaprefe1_1 = @pg_fetch_array($prefe1,0);
								
								$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$_POST["cmb_insti"]." and preferencia=2 and id_estado=0 and grado=2";
								$prefe2= @pg_Exec($conn,$sqlprefe2);
								$filaprefe2_1 = @pg_fetch_array($prefe2,0);
								
							   	$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=2";
								$prefe3= @pg_Exec($conn,$sqlprefe3);
								$filaprefe3_1 = @pg_fetch_array($prefe3,0);
								
								$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=2";
								$prefe4= @pg_Exec($conn,$sqlprefe4);
								$filaprefe4_1 = @pg_fetch_array($prefe4,0);
								
								$sqlprefe5="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=2";
								$prefe5= @pg_Exec($conn,$sqlprefe5);
								$filaprefe5_1 = @pg_fetch_array($prefe5,0);
								
								echo $filaprefe1_1["cuenta"]+$filaprefe2_1["cuenta"]+$filaprefe3_1["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"];
								?>&nbsp;</td>
                                <td width="58"><?
								
								
							   	$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=3";
								$prefe1= @pg_Exec($conn,$sqlprefe1);
								$filaprefe1_1 = @pg_fetch_array($prefe1,0);
								
								$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$_POST["cmb_insti"]." and preferencia=2 and id_estado=0 and grado=3";
								$prefe2= @pg_Exec($conn,$sqlprefe2);
								$filaprefe2_1 = @pg_fetch_array($prefe2,0);
								
							   	$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=3";
								$prefe3= @pg_Exec($conn,$sqlprefe3);
								$filaprefe3_1 = @pg_fetch_array($prefe3,0);
								
								$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=3";
								$prefe4= @pg_Exec($conn,$sqlprefe4);
								$filaprefe4_1 = @pg_fetch_array($prefe4,0);
								
								$sqlprefe5="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=3";
								$prefe5= @pg_Exec($conn,$sqlprefe5);
								$filaprefe5_1 = @pg_fetch_array($prefe5,0);
								
								echo $filaprefe1_1["cuenta"]+$filaprefe2_1["cuenta"]+$filaprefe3_1["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"];
								?>&nbsp;</td>
                                <td width="58"><?
								
								
							   	$sqlprefe1="select count(*) as cuenta from formulario_postulacion where prefe_1= ".$_POST["cmb_insti"]." and preferencia=1 and id_estado=0 and grado=4";
								$prefe1= @pg_Exec($conn,$sqlprefe1);
								$filaprefe1_1 = @pg_fetch_array($prefe1,0);
								
								$sqlprefe2="select count(*) as cuenta from formulario_postulacion where prefe_2= ".$_POST["cmb_insti"]." and preferencia=2 and id_estado=0 and grado=4";
								$prefe2= @pg_Exec($conn,$sqlprefe2);
								$filaprefe2_1 = @pg_fetch_array($prefe2,0);
								
							   	$sqlprefe3="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=4";
								$prefe3= @pg_Exec($conn,$sqlprefe3);
								$filaprefe3_1 = @pg_fetch_array($prefe3,0);
								
								$sqlprefe4="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=4";
								$prefe4= @pg_Exec($conn,$sqlprefe4);
								$filaprefe4_1 = @pg_fetch_array($prefe4,0);
								
								$sqlprefe5="select count(*) as cuenta from formulario_postulacion where prefe_3= ".$_POST["cmb_insti"]." and preferencia=3 and id_estado=0 and grado=4";
								$prefe5= @pg_Exec($conn,$sqlprefe5);
								$filaprefe5_1 = @pg_fetch_array($prefe5,0);
								
								echo $filaprefe1_1["cuenta"]+$filaprefe2_1["cuenta"]+$filaprefe3_1["cuenta"]+$filaprefe4_1["cuenta"]+$filaprefe5_1["cuenta"];
								?>&nbsp;</td>
								
                              </tr>
							  	<? 
								 ?>
                              <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td width="58">&nbsp;</td>
                                <td width="58">&nbsp;</td>
                              </tr>
							  <? 
							  
							  ?>
                              <tr>
                                <td><font face="Arial, Helvetica, sans-serif" size="2"><b>Total Postulaciones </b></font></td>
                                <td width="42"><?= $total1?>&nbsp;</td>
                                <td width="58"><?= $total2?>&nbsp;</td>
                                <td width="58"><?= $total3?>&nbsp;</td>
                                <td width="58"><?= $total4?>&nbsp;</td>
								
                              </tr>
                              <tr>
							  
                                <td><font face="Arial, Helvetica, sans-serif" size="2"><b>Total Alumno Curso</b> </font></td>
                            
							  <? 	$sql5="select rdb_destino,nombre_instit,id_ano";
									$sql5=$sql5." from postulaciones";
									$sql5=$sql5." inner join institucion on postulaciones.rdb_destino=institucion.rdb";
									$sql5=$sql5." inner join ano_escolar on postulaciones.rdb_destino=ano_escolar.id_institucion";
								 	$sql5=$sql5." where rdb_origen=".$_POST["cmb_insti"]." and nro_ano=".$ano_esco." group by rdb_destino,rdb_origen,nombre_instit,ano_escolar.id_ano order by rdb_destino asc";
									$result4= @pg_Exec($conn,$sql5);	
								 for($n=0 ; $n < @pg_numrows($result4) ; $n++)
									{ 
										$cuenta=0;
										$fila4 = @pg_fetch_array($result4,$n);
										for ($l=1 ; $l <=8 ; $l++){
												$sql6="select count(matricula.id_curso) as cuenta,rdb,grado_curso from matricula"; 
												$sql6=$sql6." inner join curso";
												$sql6=$sql6." on matricula.id_ano=curso.id_ano";
												 $sql6=$sql6." where matricula.id_ano= ".$fila4["id_ano"]." and curso.grado_curso= ".$l." group by rdb,curso.grado_curso";
										 		$result5= @pg_Exec($conn,$sql6);	
												$fila5 = @pg_fetch_array($result5,0);
												$cuenta=$fila5["cuenta"]."<br>";
												
														if($fila5["grado_curso"]==$l){
															//$cuenta=$cuenta+$cuenta;
														}
												
												if($n<1){
													echo "  <td>&nbsp;".$cuenta."</td>";
													
										 		}
										 }
									  } 
									  ?>  
								
							  </tr>
                            </table>
							<? ?>
                              <p>&nbsp;</p>
                            </td>
                          </tr>
                        </table>
					  
					  </form>
					  &nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="24" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
