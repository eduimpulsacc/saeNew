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
		form.action = 'Rprt4.php';
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
		form.action = 'Rprt4.php';
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
      <td width="70" align="left" ><font face="Arial, Helvetica, sans-serif" size="2">Institucion:</font></td>
							  <td width="153" align="left"><?  
								  for ($ipos=0;$ipos<=$i;$ipos++){
										//$cmb_insti[$ipos]=$_POST["cmb_insti_".$ipos];
										$cmb_insti=$_POST["cmb_insti".$ipos];
									}
									
									$sqlcorp="select num_corp from corp_instit where rdb=".$institucion;
							  		$resultcorp= @pg_Exec($conn,$sqlcorp);
									$filacorp = @pg_fetch_array($resultcorp,0);
									$sqlinsti="select nombre_instit,rdb from institucion where rdb in(select rdb from corp_instit where num_corp =".$filacorp["num_corp"].")";
									$result2= @pg_Exec($conn,$sqlinsti);
									
								?>
                                <select name="cmb_insti" class="ddlb_9_x" onChange="enviapag(this.form);"s>
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
                                </select>
                              &nbsp; </td>
                              <td width="149" align="left">&nbsp;</td>
   </tr>
                                  <tr><td align="left"><font face="Arial, Helvetica, sans-serif" size="2">Curso:</font></td>
						            <td colspan="2" align="left"><?
$sqlano="SELECT id_ano from ano_escolar where id_institucion=".$_POST["cmb_insti"]." order by id_ano desc";
$resultano= pg_exec($conn,$sqlano);
$filano = @pg_fetch_array($resultano,0);
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto,tipo_ensenanza.cod_tipo  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$filano["id_ano"].")) $whe_perfil_curso and curso.ensenanza=310";
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
		        
		        if (($fila['grado_curso'] == $_POST["cmb_grado"]) or ($fila['grado_curso'] == $_POST["cmb_grado"])){
		           echo "<option value=".$fila['grado_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['grado_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
                                      </select></td></tr>
                                  <tr>
                                    <td colspan="3">
									<table width="700">
									<tr class="tableindex" align="center">
									<td colspan="2"><center>TOTAL DE POSTULACIONES A UN ESTABLECIMIENTO POR ALUMNO</center></td>
									</tr>
									<tr>
									  <td width="239"><font face="Arial, Helvetica, sans-serif" size="2" >Nombre Establecimiento Destino:</font></td>
									  <td width="449"><font face="Arial, Helvetica, sans-serif" size="2">
									  <?
									$sql2="select nombre_instit from  institucion where rdb=".$_POST["cmb_insti"];
									$result= pg_exec($conn,$sql2);
		        					$fila = @pg_fetch_array($result,0); 
									echo $fila["nombre_instit"];
									?></font>
									  &nbsp;</td>
									</tr>
									<tr>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">Nivel:</font></td>
									  <td><font face="Arial, Helvetica, sans-serif" size="2">
									 <?  $sql3="select grado_curso,id_nivel from  curso where grado_curso =".$_POST["cmb_grado"]." and ensenanza=310 order by id_nivel asc ";
									$result2= pg_exec($conn,$sql3);
		        					$fila = @pg_fetch_array($result2,0); 
									
									 $sql7="select * from niveles where id_nivel=".$fila["id_nivel"];
									$result4= pg_exec($conn,$sql7);
		        					$fila4 = @pg_fetch_array($result4,0); 
									echo $fila4["nombre"];
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
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  </tr>
									<tr class="tableindex">
									  <td colspan="3" align="center">ALUMNOS</td>
									  </tr>
									<? 
									$y=0;
									 $sql5="select preferencia,rut from formulario_postulacion where grado =".$_POST["cmb_grado"]." and id_estado=0";
									$result = pg_exec($conn,$sql5);
		  						  for($x=0 ; $x < @pg_numrows($result) ; $x++){
		        					$fila = @pg_fetch_array($result,$x);
									  $sql6="select formulario_postulacion.*,alumno.* from formulario_postulacion inner join alumno on formulario_postulacion.rut=alumno.rut_alumno where prefe_".$fila["preferencia"]." =".$_POST["cmb_insti"]." and rut=".$fila["rut"];
									$resultalum = pg_exec($conn,$sql6);
									$fila2 = @pg_fetch_array($resultalum,0);
									if($fila2["nombre_alu"]!=""){
									$y++;
								  ?>
									<tr>  
										<td><font face="Arial, Helvetica, sans-serif" size="2"><?= $y?></font></td>
									  <td colspan="3">&nbsp;<font face="Arial, Helvetica, sans-serif" size="2"> <?= $fila2["nombre_alu"]." ".$fila2["ape_pat"]." ".$fila2["ape_mat"];?></font></td>
									  </tr>
									<? }
									}
									?>
									<tr>
									  <td>&nbsp;</td>
									  </tr>
									<tr>
									  <td align="right"><font face="Arial, Helvetica, sans-serif" size="2">TOTAL&nbsp;</font></td>
									  <td>&nbsp;<?= $x?></td>
									  </tr>
									
									</table>
									
									
									 </td>
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
