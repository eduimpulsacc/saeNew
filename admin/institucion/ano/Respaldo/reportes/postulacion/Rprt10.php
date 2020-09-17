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

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function enviapag(form){
	if (form.cmb_insti.value!=0){
		form.cmb_insti.target="self";
		form.target="_parent";
		form.action = 'Rprt1.php';
		form.submit(true);
	}	
}

function enviacmb(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'Rprt10.php';
		form.submit(true);
	}	
}
//-->
//-->
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
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
                      <td width="73%" align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
                          <p>&nbsp;</p>
                          <table width="798" height="138" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tableindex">
                              
                              <td width="739" align="center">Instituci&oacute;n</td>
                            </tr>
                            <tr>
							  
                              <td align="center">  
								  <?  $sqlniv="select * from niveles where tipo_ense=310 order by nombre asc"; 
						$result = @pg_Exec($conn,$sqlniv);
						  ?>
						  &nbsp;<select name="cmb_grado" class="ddlb_x" onChange="enviacmb(this.form);">
                                        <option value=0 selected>(Seleccione un Nivel)</option>
                                        <?
		    for($x=0 ; $x < @pg_numrows($result) ; $x++)
		        {  
		        $fila = @pg_fetch_array($result,$x); 
		        
		        if ((substr($fila['nombre'],2,3) == $_POST["cmb_grado"]) or (substr($fila['nombre'],2,3) == $_POST["cmb_grado"])){
		           echo "<option value=".substr($fila['nombre'],2,3)." selected>".$fila['nombre']." </option>";
		        }else{	    
		           echo "<option value=".substr($fila['nombre'],2,3).">".$fila['nombre']." </option>";
                }
		     } ?>
                                      </select>&nbsp;                                <div align="right">
        </div></td>
							
							</tr>
                                <td align="center" valign="top">
		                          <p>&nbsp;</p>
		                          <table width="575" border="0" cellspacing="0">
                                    <tr>
                                      <td colspan="5" class="tableindex"><center>Selecci&oacute;n de Alumno por Nivel</center></td>                                    
                                    </tr>
                                    <tr>
                                      <td width="169" class="textosimple"><b>Nombre Establecimiento</b></td>
                                      <td width="165" class="textosimple">
									  <?
									$sql2="select nombre_instit from  institucion where rdb=".$institucion;
									$result= pg_exec($conn,$sql2);
		        					$fila = @pg_fetch_array($result,0); 
									echo $fila["nombre_instit"];
									?>
									  &nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td class="textosimple"><b>Nivel</b></td>
                                      <td class="textosimple">
									  <? 
									    $sqlniv2="select * from niveles where id_nivel= ".$_POST["cmb_grado"]; 
										$resultniv2=pg_exec($conn,$sqlniv2);
										$fila2 = @pg_fetch_array($resultniv2,0);
										echo $fila2["nombre"];
										
										?>
									  &nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td class="textosimple"><b>A&ntilde;o</b></td>
                                      <td class="textosimple">
									  
							<?
							$sqlano0="SELECT nro_ano from ano_escolar where id_ano = ".$ano;
							$resultano0= pg_exec($conn,$sqlano0);
							$filano0 = @pg_fetch_array($resultano0,0);
							echo $filano0["nro_ano"];
							?>
									  &nbsp;</td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                    <tr class="textosimple">
                                      <td>Rut Alumnos</td>
									  <td>Nombres</td>
									  <td width="57">Apellido Paterno</td>
									  <td width="57">Apellido materno</td>
                                      <td width="176">Aceptado/ No Aceptado </td>
                                    </tr>
							<? 	$a=0;
								$n=0;
										$sqlpos="select preferencia,id_estado,rut from formulario_postulacion where grado =".$_POST["cmb_grado"]." and id_estado > 0";
										$resultpos= pg_exec($conn,$sqlpos);
								  for($i=0 ; $i < @pg_numrows($resultpos) ; $i++){
										$filapos = @pg_fetch_array($resultpos,$i);
										if($filapos["rut"]!=null){
												$sqlcont="select formulario_postulacion.id_estado,formulario_postulacion.rut,alumno.nombre_alu,alumno.ape_pat,alumno.ape_mat from formulario_postulacion inner join alumno on formulario_postulacion.rut=alumno.rut_alumno where prefe_".$filapos["preferencia"]." = ".$institucion." and rut=".$filapos["rut"];
												$resultcont= pg_exec($conn,$sqlcont);
												$filacont= @pg_fetch_array($resultcont,0);
							?>
                                    <tr class="textosimple">
                                      <td>&nbsp;<?= $filacont["rut"];?></td>
                                      <td>&nbsp;<?= $filacont["nombre_alu"];?></td>
                                      <td>&nbsp;<?= $filacont["ape_pat"];?></td>
                                      <td>&nbsp;<?= $filacont["ape_mat"];?></td>
                                      <td>&nbsp;<?
									  
									  if($filacont["id_estado"]==1){
									  		echo "<center>A</center>";
											$a++;
									  }
									  if($filacont["id_estado"]==2){
									  		echo "<center>N</center>";
											$n++;
									  }
									  ?></td>
                                    </tr>
                                    <? } 
										}
									?>
									<tr>
									<td>&nbsp;</td>
									</tr>
									<tr class="textosimple">
                                      <td><b>Aceptados</b></td>
                                      <td><?= $a?>&nbsp;</td>
                                    </tr>
                                    <tr class="textosimple">
                                      <td><b>No Aceptados</b></td>
                                      <td><?= $n?>&nbsp;</td>
                                    </tr>
                                    <tr class="textosimple">
                                      <td><b>Total</b></td>
                                      <td>&nbsp;<?= $n+$a ?></td>
                                    </tr>
                                  </table>						
								</td>
                            <tr>
                              <td colspan="8">&nbsp;</td>
                            </tr>
							
                          </table>
                          <p>&nbsp;                          </p>
                        </form>&nbsp;</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
