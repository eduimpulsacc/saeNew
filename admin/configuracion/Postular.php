<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$_MDINAMICO = 1;	
	$cmb_curso=$_POST["cmb_curso"];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=508, height=365, top=85, left=140";
window.open(pagina,"",opciones);
}
</script>
<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.cmb_curso.target="self";
		form.target="_parent";
		form.action = 'Postular.php';
		form.submit(true);
	}	
}

				
</script>
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
//-->
</script>

		<?php include('../../util/rpc.php3');?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="16%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="84%" align="left" valign="top">
                        <form name="form" method="post" action="guardar_postulacion.php">
                          <p>Curso:
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $cmb_curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select> 
						  </p>
                          <table width="798" height="104" border="0" cellspacing="0" cellpadding="0">
                            <tr class="tableindex">
                              <td width="70" height="39">Rut Alumno </td>
                              <td width="106">Nombre</td>
							  <td width="24">&nbsp;</td>
                              <td width="166">Instituci&oacute;n</td>
                              <td width="192">Grado-Ense&ntilde;anza</td>
                              <td width="85">Vacantes</td>
                              <td width="75">Criterios de Postulaci&oacute;n </td>
                              <td width="51">Postular</td>
                            </tr>
                            <tr>
							<?  $sql="select matricula.rut_alumno,matricula.num_mat,alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
								$result= @pg_Exec($conn,$sql);
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
									$fila = @pg_fetch_array($result,$i);
									?>
								<script language="javascript">
								
								function enviapag<?= $i?>(form){
									if (form.cmb_insti<?= $i?>.value!=0){
										form.cmb_insti<?= $i?>.target="self";
										form.target="_parent";
										form.action = 'Postular.php';
										form.submit(true);
									}	
								}
								function enviacmb<?= $i?>(form){
									if (form.cmb_grado<?= $i?>.value!=0){
										form.cmb_grado<?= $i?>.target="self";
										form.target="_parent";
										form.action = 'Postular.php';
										form.submit(true);
									}	
								}
								</script>
								<input type="hidden" name="rut_alumno<?= $i?>" value="<?=$fila["rut_alumno"]; ?>">
                              <td>&nbsp;<font face="Arial, Helvetica, sans-serif" size="1"><?=$fila["rut_alumno"]; ?></font></td>
                              <td>&nbsp;<font face="Arial, Helvetica, sans-serif" size="1"><?=$fila["ape_pat"]." ".$fila["nombre_alu"]; ?></font></td>
							  <td>&nbsp;
							  <? 
							  for ($ipos=0;$ipos<=$i;$ipos++){
										//$cmb_insti[$ipos]=$_POST["cmb_insti_".$ipos];
										$cmb_insti=$_POST["cmb_insti".$ipos];
									}
							  ?>
							  </td>
							  
                              <td>  
								  <?  
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
							  <select name="cmb_insti<?= $i?>" class="ddlb_9_x" onChange="enviapag<?= $i?>(this.form);"s> 
							<option value=0 selected>(Seleccione Institucion)</option>
								 <?
								 for($z=0 ; $z < @pg_numrows($result2) ; $z++)
									{  
									$fila2 = @pg_fetch_array($result2,$z);
									$rdb=$fila2['rdb'];
									$nombre_instit=$fila2['nombre_instit'];
									$sqled="select postulaciones.*,institucion.nombre_instit from postulaciones INNER JOIN institucion ON institucion.rdb = postulaciones.rdb_destino where  rut_alumno=".$fila["rut_alumno"]." and rdb_destino=".$fila2['rdb'];
							  		$resulted= pg_Exec($conn,$sqled);
									$filaed = pg_fetch_array($resulted,0);
									
									if ($filaed["rdb_destino"]>0 and $cmb_insti==0){
										echo "<option value=".$rdb." selected>".$nombre_instit." </option>";
										$cmb_insti=$filaed["rdb_destino"];
									}elseif($rdb == $cmb_insti) {
										echo "<option value=".$rdb." selected>".$nombre_instit." </option>";
									} else {
										echo "<option value=".$rdb.">".$nombre_instit." </option>";
									}
								 } 
								 ?>
                            </select>&nbsp;
							<? 
							/*if($insti !="" ){
							echo "<span class='textosimple'>Ya postula a: ".$insti."</span>"; 
							}*/
							?>
							<? //if ($insti!=0){?>
							<input type="hidden" value="<?= $instinom?>"  name="insti_<?= $i?>">
							<? //} ?>
							</td>
                              <td>
							    
                 <?

$sqlano="SELECT id_ano from ano_escolar where id_institucion=".$cmb_insti." order by id_ano desc";
$resultano= pg_exec($conn,$sqlano);
$filano = @pg_fetch_array($resultano,0);
$filano=$filano["id_ano"];
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto,tipo_ensenanza.cod_tipo  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$filano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso";
$resultado_query_cue = pg_exec($conn,$sql_curso);
@pg_numrows($resultado_query_cue);
                 ?>
		  <select name="cmb_grado<?= $i?>" class="ddlb_x" onChange="enviacmb<?= $i?>(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		    for($x=0 ; $x < @pg_numrows($resultado_query_cue) ; $x++)
		        {  
				$sqlcu="select id_curso,ensenanza from postulaciones where rut_alumno=".$fila["rut_alumno"];
				$resultcu= @pg_Exec($conn,$sqlcu);
				$filacu = @pg_fetch_array($resultcu,0);
		        $fila2= @pg_fetch_array($resultado_query_cue,$x); 
   		        $Curso_pal = CursoPalabra($fila2['id_curso'], 1, $conn);
   		        $Curso_pal2 = CursoPalabra($filacu["id_curso"], 1, $conn);
								for ($xpos=0;$xpos<=$i;$xpos++){
									 	$cmb_grado=$_POST["cmb_grado".$xpos];
									}
									if ($filacu["id_curso"]==$fila2['id_curso']  and $cmb_grado==0){
										echo "<option value=".$fila2['id_curso']." selected>".$Curso_pal." </option>";
									}elseif($fila2['id_curso'] == $cmb_grado) {
										echo "<option value=".$fila2['id_curso']." selected>".$Curso_pal." </option>";
									} else {
										echo "<option value=".$fila2['id_curso'].">".$Curso_pal." </option>";
									}
								 } ?>
          </select>   &nbsp;<br>
							</td>
                              <td>
							  
							  <? 
									$sqlense="select ensenanza from curso where id_ano=".$filano." and id_curso=".$cmb_grado;
									$resultense= @pg_Exec($conn,$sqlense);
									$filaense= @pg_fetch_array($resultense,0);
									?>
									
				<input type="hidden" name="tipo_ensenanza<?= $i?>" value="<?= $filaense['ensenanza']?>"> 
							<? 
							$sqlcurso="select grado_curso from curso where id_curso=".$cmb_grado;
							$resultcurso = pg_exec($conn,$sqlcurso);
							$fila2 = @pg_fetch_array($resultcurso,0);
							
							$sqlvac ="select vac_dis from  vacantes where grado=".$fila2["grado_curso"]." and ensenanza=".$filaense['ensenanza'];
							$resultado_vac = pg_exec($conn,$sqlvac);
							$filavac = @pg_fetch_array($resultado_vac,0); 
							echo "<font face='Arial, Helvetica, sans-serif' size='1'><center>".$filavac["vac_dis"]."</center></font>";
							?>
							  
							  &nbsp;</td>
                              <td>
							  <a href="javascript:Abrir_ventana('popup.php?cmb_grado=<?=$cmb_grado?>&tipo_ensenanza=<?=$filaense['ensenanza']?>')">Ver</a></td>
							  	<? 	
									echo $postula=$_POST['postula'.$i];
				 					$sqles="select estado from postulaciones where rut_alumno=".$fila["rut_alumno"];
									$resultes= @pg_Exec($conn,$sqles);
									$filaes = @pg_fetch_array($resultes,0);
									if ($filaes["estado"]==1 or $postula==1){?>
									<td><input type="checkbox" id="lenguaje" name="postula<?= $i?>" value="1" checked></td>
									<?
									}else{
								?>
                              <td width="29"><input type="checkbox" id="lenguaje" name="postula<?= $i?>" value="1"></td>
                            	<? }?>
							</tr>
							<? }?>
							<input type="hidden" name="indice" value="<?= $i ?>" > 
                            <tr>
                              <td colspan="8"><input type="submit" name="Enviar" value="Enviar" class="botonXX" ></td>
                              
                            </tr>
							
                          </table>
                          <p>&nbsp;                          </p>
                        </form></td>
                    </tr>	
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
