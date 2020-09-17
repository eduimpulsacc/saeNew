<?	require('../../util/header.inc');
	//include('../clases/class_MotorBusqueda.php');
	//include('../clases/class_Membrete.php');
	//include('../clases/class_Reporte.php');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$_POSP = 2;
	$_bot = 8;


	$sql = "select a.*,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' '  as varchar) || ape_mat as empleado FROM proyecto_grupo a INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$institucion." AND id_proy=".$id_pro."";
	$rs_proy = @pg_exec($conn,$sql);
	$fila = @pg_fetch_array($rs_proy,0);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
function txt_ciclo(){
	document.form.txt_ciclo.focus();
}
function elimina_curso(id_curso,id_ciclo,ensenanza){
	window.location="procesa_ciclo.php?tipo=3&id_curso="+id_curso+"&id_ciclo="+id_ciclo+"&ensenanza="+ensenanza;
	//form.submit(true);
}
function Show_cursos(id_ciclo){
	var ensenanza = document.form.cmb_ensenanza.value;
	window.location="asignar_ciclo.php?tipo=2&id_ciclo="+id_ciclo+"&cmb_ensenanza="+ensenanza;
}
function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function enviapag(form){
	form.action='inscribeAlumnosProyecto.php';
	form.submit(true);
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
//-->
</script>
<style type="text/css">
<!--
.Estilo3 {font-family: Verdana, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 10px; }
.Estilo6 {font-family: Verdana, Arial, Helvetica, sans-serif}
.Estilo9 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }
.Estilo11 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10; }
.Estilo12 {font-size: 12px}
.Estilo13 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>"></td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><?
				include("../../cabecera/menu_superior.php");
				?></td>
              </tr>
          </table></td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><?
						$menu_lateral=3;
						include("../../menus/menu_lateral.php");
						?>              </td>
              <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  
                  <tr>
                    <td height="395" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td valign="top"><!-- INCLUYO CODIGO DE LOS BOTONES -->
                              <table width="" height="49" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                  <td width="" height="30" align="center" valign="top">&nbsp;</td>
                                </tr>
                              </table>
                            <form id="form" name="form" action="procesoInscribeAlumno.php" method="post">
                              <input name="caso" value="<?=$caso;?>" type="hidden">
                                <input name="id_pro" value="<?=$id_pro;?>" type="hidden">
                                <table width="650" border="0" align="center" cellpadding="5" cellspacing="0">
                                  <tr>
                                    <td width="186"><span class="Estilo3">NOMBRE <? if($fila['tipo']==1) echo "PROYECTO"; else echo "GRUPO"; ?> </span></td>
                                    <td width="8"><span class="Estilo3">:</span></td>
                                    <td width="426" class="Estilo6 Estilo12">&nbsp;<?=$fila['nombre'];?></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo3">PROFESIONAL A CARGO </span></td>
                                    <td><span class="Estilo3">:</span></td>
                                    <td class="Estilo13">&nbsp;<?=$fila['empleado'];?></td>
                                  </tr>
                                  <tr>
                                    <td><span class="Estilo3">CURSO</span></td>
                                    <td><span class="Estilo3">:</span></td>
                                    <td>
			                          <font size="1" face="arial, geneva, helvetica">
									  <?  $sql_curso  = "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo  WHERE (((curso.id_ano)=".$ano."))ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso;  ";
										  $resultado_query_cue = pg_exec($conn,$sql_curso); ?>
			                          <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
                                        <option value=0 selected>(Seleccione Curso)</option>
                                        <?
										  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
										  {
										  $fila = @pg_fetch_array($resultado_query_cue,$i); 
										  if (($resultado_query_cue[grado_curso]==5)&&($resultado_query_cue[grado_curso]!=10)) {}else{
											  if ($fila["id_curso"]==$cmb_curso){
													$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
													echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
											  }else{
													$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
													echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
											  }
										  }
										  } ?>
                                      </select>
		                            </font></td>
                                  </tr>
                                  <tr>
                                    <td colspan="3">&nbsp;</td>
                                  </tr>
                                </table>
								<br>
								<table width="650" border="0" cellspacing="0" cellpadding="3" align="center">
								  <tr>
									<td align="right">&nbsp;<input name="GUARDAR" type="submit" value="GUARDAR" class="botonXX">&nbsp;<input name="VOLVER" type="button" value="VOLVER"  class="botonXX" onClick="window.location='listaProyectoGrupo.php'"></td>
									
								  </tr>
								</table>

								<table width="650" border="0" cellpadding="3" cellspacing="0" align="center">
								  <tr>
									<td colspan="2" class="tableIndex">&nbsp;ALUMNOS NO INSCRITOS</td>
								  </tr>
								  <? $sql = " SELECT b.rut_alumno,b.nombre_alu || cast(' ' as varchar) || b.ape_pat || CAST(' ' as varchar ) || ape_mat as nombre FROM matricula a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno WHERE id_curso =".$cmb_curso." AND a.rut_alumno not in (SELECT rut_alumno FROM inscribe_proyecto WHERE id_proy=".$id_pro.")";
								  	$rs_alumno = @pg_exec($conn,$sql);
									
									for($i=0;$i<@pg_numrows($rs_alumno);$i++){
										$fila_alu = @pg_fetch_array($rs_alumno,$i);
									?>	 
								  <tr>
									<td width="50"><span class="Estilo9">&nbsp;
									  <input name="noinscrito<?=$i;?>" type="checkbox" value="<?=$fila_alu['rut_alumno'];?>">
									</span></td>
									<td><span class="Estilo9">&nbsp;
									  <?=strtoupper($fila_alu['nombre']);?>
									</span></td>
								  </tr>
								  <input name="cont" type="hidden" value="<?=@pg_numrows($rs_alumno);?>">
								  <? } ?>
								</table>
								<br>
								<? 	$sql = "SELECT count(*) FROM inscribe_proyecto WHERE id_proy=".$id_pro."";
									$rs_count = @pg_exec($conn,$sql);
									$total_inscritos = @pg_result($rs_count,0);
								?>
								<table width="650" border="0" cellspacing="0" cellpadding="3" align="center">
								  <tr>
									<td colspan="3"  class="tableIndex">ALUMNOS INSCRITOS (total inscritos:<?=$total_inscritos;?>)</td>
								  </tr>
								  <? $sql = "  SELECT b.rut_alumno,b.nombre_alu || cast(' ' as varchar) || b.ape_pat || CAST(' ' as varchar ) || ape_mat as nombre, id_curso FROM inscribe_proyecto a INNER JOIN alumno b ON a.rut_alumno=b.rut_alumno INNER JOIN matricula c ON (a.rut_alumno=c.rut_alumno AND b.rut_alumno=c.rut_alumno) WHERE c.id_ano=".$ano." AND id_proy=".$id_pro." ORDER BY id_curso ASC";
								  		$rs_inscrito = @pg_exec($conn,$sql);
										
										for($i=0;$i<@pg_numrows($rs_inscrito);$i++){
											$fila_inscrito = @pg_fetch_array($rs_inscrito,$i);
									?>

								  <tr>
									<td width="50"><input name="inscrito<?=$i;?>" type="checkbox" class="Estilo6" value="<?=$fila_inscrito['rut_alumno'];?>"></td>
									<td><span class="Estilo11">&nbsp;
									  <?=strtoupper($fila_inscrito['nombre']);?>
									</span></td>
									<td><span class="Estilo11">&nbsp;
									  <?=CursoPalabra($fila_inscrito['id_curso'], 1, $conn);?>
									</span></td>
								  </tr>
								  <? } ?>
								  <input type="hidden" name="cuenta" value="<?=$i;?>">
								</table>


                            </form></td>
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
    </table></td>
    <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table>
 </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>