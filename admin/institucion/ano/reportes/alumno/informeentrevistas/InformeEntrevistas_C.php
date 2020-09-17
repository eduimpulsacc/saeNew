<SCRIPT language="JavaScript">
	function enviapag(form){
	if (form.cmb_curso.value!=0){
		form.target="_self";
		form.action = 'InformeEntrevistas_C.php?institucion=$institucion';
		form.submit(true);

		}	
	}
	

	
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
</script>
<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');

	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$reporte		=$c_reporte;
	$alumno 		=$c_alumno;
	$_POSP = 6;
	$_bot = 8;
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE ACÁ DEBE IR CON INCLUDE -->
            <?
			  include("../../../../../../cabecera/menu_superior.php");
			  ?>
            <!-- FIN DE COPIA DE CABECERA -->        </td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><!-- AQUI VA EL MEN{U LATERAL -->
                  <?
						 $menu_lateral=3;
						 include("../../../../../../menus/menu_lateral.php");
						 ?>
                  <!--  FIN MENU LATERAL -->              </td>
              <td width="73%" align="left" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><!-- COPIO LOS BOTONES PARA QUE NO ESTÉN SEPARADOS -->
                              <!-- FIN DE COPIA DE BOTONES -->
                              <!-- AQUÍ EL CONTENIDO CENTRAL DE LA PÁGINA --><br>
                            <br>
                           
                              <form method "post" action="printInformeEntrevistas_C.php" name="form" target="_blank">
							  <input name="c_reporte" type="hidden" value="<?=$reporte;?>">
                              <input name="nombre" type="hidden" value="<?=$nombre;?>">
                              <input name="numero" type="hidden" value="<?=$numero;?>">
                                <? 
									$ob_motor = new MotorBusqueda();
									$ob_motor ->ano = $ano;
									$ob_motor->perfil=$_PERFIL;
									$ob_motor->curso=$_CURSO;
									$ob_motor->usuario=$_NOMBREUSUARIO;
									$ob_motor->rdb=$institucion;
									$resultado_query_cue = $ob_motor ->curso2($conn);
									
									//------------------
								?>
                                <center>
                                  <table width="90%" border="1" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
                                          </tr>
                                          <tr>
                                            <td height="27"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                  <td width="269" class="cuadro01">Curso<br>
                                                       <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
														<option value=0 selected>(Seleccione Curso)</option>
														<?
														  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
														  {
														  $fila = @pg_fetch_array($resultado_query_cue,$i); 
														  if ($fila["id_curso"]==$cmb_curso){
																$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
																echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
														  }else{
																$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
																echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
														  }
														  } ?>
													  </select>
                                                      <br>
                                                    Alumno<br>
                                                    <select name="cmb_alumno" class="ddlb_9_x">
                                                      <option value=0 selected>(Todos los alumnos)</option>
                                                      <?
														$ob_motor->cmb_curso = $cmb_curso;
														$result=$ob_motor->alumno($conn);
														for($i=0 ; $i < @pg_numrows($result) ; $i++){
															$fila = @pg_fetch_array($result,$i);
															$rutalumno = $fila["rut_alumno"];
															if ($rutalumno == $c_alumno){  ?>
																  <option value="<? echo $fila["rut_alumno"]; ?>" <? if ($fila["rut_alumno"]==$c_alumno){ echo "selected";}?>	><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
														 <? }else{ ?>
																 <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>  <?
														   }
														}
														?>
                                                    </select>
                                                    <br>
                                                    <br>
                <input name="cb_ok" type="submit" class="botonXX"  id="cb_ok"  value="Buscar">
					<? if($_PERFIL==0){?>		  
				<input name="cb_exp" type="submit" class="botonXX"  id="cb_exp" value="Exportar">
										<? }?>	                                                  
										<input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2"  value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'"></td>
                                                </tr>
                                            </table></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                  </table>
                                </center>
                              </form>
                            <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->                          </td>
                        </tr>
                    </table></td>
                  </tr>
              </table></td>
            </tr>
            <tr align="center" valign="middle">
              <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
            </tr>
        </table></td>
      </tr>
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>