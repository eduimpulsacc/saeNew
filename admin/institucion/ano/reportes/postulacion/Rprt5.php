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
		form.action = 'Rprt5.php';
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
                      <td align="left" valign="top"><form name="form" method="post" action="guardar_postulacion.php">
   <table>
   <tr>
      <td width="70" align="left" ><font face="Arial, Helvetica, sans-serif" size="2">:</font></td>
							  <td width="153" align="left">&nbsp;
                        </td>
                              <td width="149" align="left">&nbsp;</td>
   </tr>
                                  <tr><td align="left"><font face="Arial, Helvetica, sans-serif" size="2">Curso:</font></td>
						            <td colspan="2" align="left"><?
$sqlano="SELECT id_ano from ano_escolar where id_institucion=".$institucion." order by id_ano desc";
$resultano= pg_exec($conn,$sqlano);
$filano = @pg_fetch_array($resultano,0);
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto,tipo_ensenanza.cod_tipo  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$filano["id_ano"].")) $whe_perfil_curso and ensenanza=310";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso";
//echo $sql_curso;
$resultado_query_cue = pg_exec($conn,$sql_curso);

							for ($xpos=0;$xpos<=$i;$xpos++){
										$cmb_grado=$_POST["cmb_grado".$xpos];
									}
                 ?>
                                      <select name="cmb_grado" class="ddlb_x" onChange="enviacmb(this.form);">
                                        <option value=0 selected>(Seleccione un Curso)</option>
                                        <?
		    for($x=0 ; $x < @pg_numrows($resultado_query_cue) ; $x++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$x); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $_POST["cmb_grado"]) or ($fila['id_curso'] == $_POST["cmb_grado"])){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
                                      </select></td></tr>
                                  <tr>
                                    <td colspan="3">
									<table width="700">
									<tr class="tableindex" align="center">
									<td colspan="2"><center>
									  TOTAL DE POSTULACIONES A UN ESTABLECIMIENTO POR GRADO 
									</center></td>
									</tr>
									<tr>
									  <td width="239"><font face="Arial, Helvetica, sans-serif" size="2" >Nombre Establecimiento Destino:</font></td>
									  <td width="449"><font face="Arial, Helvetica, sans-serif" size="2">
									  <?
									$sql2="select nombre_instit from  institucion where rdb=".$institucion;
									$result= pg_exec($conn,$sql2);
		        					$fila = @pg_fetch_array($result,0); 
									echo $fila["nombre_instit"];
									?></font>
									  &nbsp;</td>
									</tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">Nivel:</font></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">
									 <? 
									 $sql3="select grado_curso,letra_curso,id_nivel from  curso where id_curso =".$_POST["cmb_grado"];
									$result2= pg_exec($conn,$sql3);
		        					$filag = @pg_fetch_array($result2,0); 
									$sqlnivel="select * from niveles where id_nivel=".$filag["id_nivel"];
									$resultn= pg_exec($conn,$sqlnivel);
		        					$filan = @pg_fetch_array($resultn,0); 
									echo $filan["nombre"];
									?>
									</font>
									  &nbsp;</td>
									  </tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">A&ntilde;o:</font></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">
								<? $sql4="select nro_ano from  ano_escolar where id_ano =".$ano;
									$result3= pg_exec($conn,$sql4);
		        					$fila2 = @pg_fetch_array($result3,0); 
									echo $fila2["nro_ano"];
									?></font>
									  &nbsp;</td>
									  </tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">Vacantes Por Curso </font></td>
									  <td>
									<?  $sql6="select * from  vacantes where grado =".$grado." and id_ano =".$ano;
									$result5= pg_exec($conn,$sql6);
		        					$fila4 = @pg_fetch_array($result5,0); 
									echo $fila4["vac_ini"];
									?>
									  &nbsp;</td>
									  </tr>
									 <? $sql8="select ensenanza from curso where id_curso=".$_POST["cmb_grado"];
									 	$result7= pg_exec($conn,$sql8);
		        						$fila5 = @pg_fetch_array($result7,0); 
										if($fila5["ensenanza"]>310){ ?>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">Especialidad Curso</font>&nbsp;</td>
									  <td>&nbsp;<font face="Arial, Helvetica, sans-serif" size="2">
									  <? $sql9="select nombre_tipo from tipo_ensenanza where cod_tipo=".$fila5["ensenanza"];
									 	$result8= pg_exec($conn,$sql9);
		        						$fila6 = @pg_fetch_array($result8,0); 
										echo $fila6["nombre_tipo"]; ?></font></td>
									  </tr>
									  <? } ?>
									<tr>  
										<td></td>
										<td> <?  ?></td>
									  </tr>
									<tr>
									  <td colspan="5">
									<table width="723" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td width="168" align="center" class="tableindex">Grado</td>
                                        <td width="168" align="center" class="tableindex">Cantidad</td>
                                        <td width="168" align="center" class="tableindex">Vacantes Disponibles </td>
                                        <td width="191" align="center" class="tableindex">Total</td>
                                      </tr>
                                      <tr>
                                        <td align="center">
									<? echo $filag['grado_curso'];?>&nbsp;</td>
                                        <td align="center">
									<? $sql7="select count(*) as total  from matricula".$fila2["nro_ano"]." where id_curso=".$_POST["cmb_grado"]; 
										$result6= pg_exec($conn,$sql7);
		        						$fila5 = @pg_fetch_array($result6,0); 
										echo $fila5["total"];
									?>
										&nbsp;</td>
                                        <td align="center"><? echo $fila4["vac_dis"];?>&nbsp;</td>
                                        <td align="center"><? echo $fila5["total"]+$fila4["vac_dis"]; ?>&nbsp;</td>
                                      </tr>
                                    </table>
									 </td>
									  </tr>
									
									</table></td>
                                  </tr>
   </table>
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
          <td width="24" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
