<?php 
require('../../../../../util/header.inc');



	$institucion	=$_INSTIT;
	$ano			=$_ANO;

	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function enviapag1(form){
			if (form.c_ano.value!=0){
				form.c_ano.target="self";
				form.action = 'HojaDeVida.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}

function enviapag2(form){
			if (form.c_curso.value!=0){
				form.c_curso.target="self";
				form.action = 'HojaDeVida.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}

function enviapag3(form){
			if (form.c_alumno.value!=0){
				form.c_alumno.target="self";
				form.action = 'HojaDeVida.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			

</script>		

<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
	
<style type="text/css">

</style>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="70%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="" valign="top">
								  <!--inicio codigo nuevo -->
								  </br>
								  <center>
								  <?php
									
						
									
					$sql_ano ="SELECT * FROM ano_escolar WHERE id_institucion=".$institucion." ORDER BY nro_ano ASC";
					$rs_ano=@pg_exec($conn,$sql_ano);
						
						
					$sql_curso = "SELECT DISTINCT curso.id_curso, curso.grado_curso, curso.letra_curso,";
					$sql_curso.="tipo_ensenanza.nombre_tipo,curso.ensenanza, curso.cod_decreto ";
					$sql_curso.= "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
					$sql_curso.= "WHERE (((curso.id_ano)=".$c_ano.")) ";
					$sql_curso.= "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
					$result=@pg_exec($conn,$sql_curso);
								
								
								?>
													  
								<form name="form" method="post">			  
				  
								    <table width="80%" border="0" cellpadding="5" cellspacing="0">
                                      <tr>
                                        <td align="center" class="tableindex" colspan="4">Buscador Avanzado</td>
                                      </tr>
                                      <tr  class="cuadro01">
                                        <td>A&ntilde;o</strong></td>
                                        <td><select name="c_ano" class="ddlb_9_x" onChange="enviapag1(this.form)">
                                            <option value="0">(Seleccione A&ntilde;o)</option>
                                            <? for($i=0;$i<@pg_numrows($rs_ano);$i++){
								$fila = @pg_fetch_array($rs_ano,$i);?>
                                            <? if($fila['id_ano']==$c_ano){?>
                                            <option value="<?=$fila['id_ano'];?>" selected="selected">
                                            <?=$fila['nro_ano']?>
                                            </option>
                                            <? }else{?>
                                            <option value="<?=$fila['id_ano'];?>">
                                            <?=$fila['nro_ano'];?>
                                            </option>
                                            <? }
							} ?>
                                        </select></td>
                                        <td colspan="2" rowspan="3" valign="top"></td>
                                      </tr>
                                      <tr  class="cuadro01">
                                        <td>Curso</td>
                                        <td><select name="c_curso" class="ddlb_9_x" onChange="enviapag2(this.form);">
                                            <option value="0">(Seleccione Curso)</option>
                                            <? 
								for($i=0;$i<@pg_numrows($result);$i++)
								{
									$fila = pg_fetch_array($result,$i);
									$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
									if($c_curso==$fila["id_curso"]){?>
                                            <option selected="selected" value="<?=$fila['id_curso']?>">
                                            <?=$Curso_pal?>
                                            </option>
                                            <?  }else{ ?>
                                            <option value="<?=$fila['id_curso']?>">
                                            <?=$Curso_pal?>
                                            </option>
                                            <?	}		}?>
                                        </select></td>
                                      </tr>
                                      <tr  class="cuadro01">
                                        <td>Alumno</td>
                                        <td><select name="c_alumno" class="ddlb_9_x" onChange="enviapag3(this.form)">
                                            <option value=0 selected>(Seleccione Alumno)</option>
                                            <?
									
		$sql_alu =" select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu from matricula, alumno ";
		$sql_alu.=" where id_curso = ".$c_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ";
		$sql_alu.=" ape_mat, nombre_alu";
		if($c_curso!=0){			
		$result_alumno=@pg_exec($conn,$sql_alu);
		}							
								for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++){
									$fila = @pg_fetch_array($result_alumno,$i);
									$rutalumno = $fila["rut_alumno"];
									if ($rutalumno == $c_alumno){
									?>
                                            <option value="<? echo $fila["rut_alumno"]; ?>" <? if ($fila["rut_alumno"]==$c_alumno){ echo "selected";}?>	><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
                                            <? }else{ ?>
                                            <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
                                            <?
	       }
		}
		?>
                                        </select></td>
                                      </tr>
                                  </table>
									</br>
									<? if($c_alumno!=0 & $c_curso!=0 & $c_ano!=0){?>
									<table width="80%" border="0" cellpadding="0" cellspacing="0">
                                      <tr>
                                        <td class="tableindex">Men&uacute; Hoja de Vida </td>
                                      </tr>
                                      <tr class="cuadro01" onClick="window.location='alumno.php3?tipo_hoja=1&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>&c_alumno=<?=$c_alumno?>&pesta=4'" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF'>
                                        <td><div align="center">Observaciones</div></td>
                                      </tr>
                                      <tr class="cuadro01" onClick="window.location=''" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF'>
                                        <td><div align="center">Actividades Extraprogram&aacute;ticas </div></td>
                                      </tr>
                                      <tr class="cuadro01" onClick="window.location=''" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF'>
                                        <td><div align="center">Accidentes</div></td>
                                      </tr>
                                      <tr class="cuadro01" onClick="window.location='../../fichas/medicas/listarFichasAlumno.php3?alumno=<?=$c_alumno?>&caso=1&curso=<?=$c_curso?>&c_ano=<?=$c_ano?>&tipo_hoja=1'" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF'>
                                        <td><div align="center">Certificados M&eacute;dicos </div></td>
                                      </tr>
                                      <tr class="cuadro01" onClick="window.location='../informe_educacional/muestraPlantilla.php?tipo_hoja=1&c_ano=<?=$c_ano?>&c_curso=<?=$c_curso?>&c_alumno=<?=$c_alumno?>'" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF'>
                                        <td><div align="center">Desarrollo Personal y Social </div></td>
                                      </tr>
                                      <tr class="cuadro01" onClick="window.location=''" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF'>
                                        <td><div align="center">Citaciones a Apoderados </div></td>
                                      </tr>
                                      <tr class="cuadro01" onClick="window.location=''" onmouseover=this.style.background='#FFFF33';this.style.cursor='hand' onmouseout=this.style.background='#FFFFFF'>
                                        <td><div align="center">Otros</div></td>
                                      </tr>
                                    </table>
									<? }?>
								</form>
								  </center>
</td>
		 </tr>
		 </table>
	 							  
								  
								  <!-- fin codigo nuevo --></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr>
                            <td height="" align="left" valign="top">&nbsp;</td>
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
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
