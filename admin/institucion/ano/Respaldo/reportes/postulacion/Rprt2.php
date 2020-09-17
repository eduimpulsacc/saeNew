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
		form.action = 'Rprt2.php';
		form.submit(true);
	}	
}
function enviacmb(form){
	if (form.cmb_grado.value!=0){
		form.cmb_grado.target="self";
		form.target="_parent";
		form.action = 'Rprt2.php';
		form.submit(true);
	}	
}
function abrir(direccion, pantallacompleta, herramientas, direcciones, estado, barramenu, barrascroll, cambiatamano, ancho, alto, izquierda, arriba, sustituir){
     var opciones = "fullscreen=" + pantallacompleta +
                 ",toolbar=" + herramientas +
                 ",location=" + direcciones +
                 ",status=" + estado +
                 ",menubar=" + barramenu +
                 ",scrollbars=" + barrascroll +
                 ",resizable=" + cambiatamano +
                 ",width=" + ancho +
                 ",height=" + alto +
                 ",left=" + izquierda +
                 ",top=" + arriba;
     var ventana = window.open(direccion,"venta",opciones,sustituir);

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
                              
                              <td colspan="3"><center>
                                REPORTE POSTULACI&Oacute;N
                              </center></td>
                            </tr>
                            <tr>
							  
                              <td width="147" align="left" >  
								  Institucion:
						      <div align="right">        </div></td>
							  <td width="553" align="left"><?  
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
                              <td width="98" align="left">&nbsp;</td>
                            </tr>
                                  <tr><td align="left">                 Curso:  </td>
						            <td colspan="2" align="left"><?
$sqlano="SELECT id_ano from ano_escolar where id_institucion=".$_POST["cmb_insti"]." order by id_ano desc";
$resultano= pg_exec($conn,$sqlano);
$filano = @pg_fetch_array($resultano,0);
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto,tipo_ensenanza.cod_tipo  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$filano["id_ano"].")) $whe_perfil_curso";
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
                                      </select></td>
                            <tr>
							  <td height="36" colspan="3"><br>
							  <table width="631" border="1" cellspacing="0">
							  
							 <tr class="tableindex">
								<td width="117">rut</td>
							  	<td width="86">Nombre</td>
							  	<td width="150">Apellido Paterno</td>
							  	<td width="163">Apellido Materno</td>
							  
							  </tr>
							  <? $sqlistado="select * from postulaciones where grado=".$_POST["cmb_grado"];
							  	$resultlistado= pg_exec($conn,$sqlistado);
								for($w=0 ; $w < @pg_numrows($resultlistado) ; $w++){
									$filalistado= @pg_fetch_array($resultlistado,$w);
									$sqldato="select * from formulario_postulacion where rut=".$filalistado["rut_alumno"];
							  		$resultdato= pg_exec($conn,$sqldato);
									$filadato= @pg_fetch_array($resultdato,0);
									if(@pg_numrows(resultdato)==0){
										$sqldato="select * from alumno where rut_alumno=".$filalistado["rut_alumno"];
										$resultdato= pg_exec($conn,$sqldato);
										$filadato2= @pg_fetch_array($resultdato,0);
									}
							  ?>
							  <tr><td><?= $filalistado["rut_alumno"];?></td>
							  <td><?= $filadato["nombres"];if(@pg_numrows(resultdato)==0){echo $filadato2["nombre_alu"]; }?></td>
							  <td><?= $filadato["ape_pat"];if(@pg_numrows(resultdato)==0){echo $filadato2["ape_pat"]; }?></td>
							  <td><?= $filadato["ape_mat"];if(@pg_numrows(resultdato)==0){echo $filadato2["ape_mat"]; }?></td>
							  </tr>
							  <? }?>
							  </table>
							  
							   </td>
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
