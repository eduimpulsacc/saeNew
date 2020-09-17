<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	
	$menu = $_GET['menus'];
	
	if ($menu == ''){
	
	$menu =0 ;
	
	}
	
   $_MDINAMICO = 1;	
   
   //show($_SESSION); 
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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

		<?php include('../../util/rpc.php3');?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT></head>

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
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
					            	
									<!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
	<center>
	REPORTES CORPORACION:
	  <table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr align="left" valign="top">
                <td width="52%" height="582"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr>
                      <td class="cuadro02"><strong>Matricula</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeMatriculaTotal.php">1. Total Corporaci&oacute;n </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeMatriculaMensual.php">2. Mensual por Corporaci&oacute;n </a> </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeMatriculaRetirados.php">                                  3. Alumnos Retirados por Corporaci&oacute;n </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeMatriculaMasculino.php">4. Matricula de alumnos de sexo masculino </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeMatriculaFemenino.php?ai_institucion=<?=($institucion)?>&c_reporte=5">5. Matricula de alumnos de sexo femenino </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeMatriculaIndigena.php?c_reporte=6">6. Matricula de alumnos de origen Indigena </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeMatriculaAbril.php">7. Matricula a partir del 30 de Abril </a></td>
                          </tr>
                          

                          <? if($_PERFIL==0){ ?>

                          <? }?>

                      </table></td>
                    </tr>
                    <tr>
                      <td class="cuadro02"><strong>Asistencia</strong></td>
                    </tr>
                    <tr>
                      <td height="80" align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeAsistenciaMensual.php?flag=0">8. Informe Mensual por Establecimientos </a></td>
                          </tr>
                         <!-- <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeAsistenciaMensualCiclos.php?flag=0">9. Informe Mensual por ciclos (en construcci&oacute;n) </a></td>
                          </tr>-->
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeAsistenciaMensualNivel.php?flag=0">9. Informe Mensual por niveles </a></td>
                          </tr>
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeAsistenciaAnual.php?flag=0">10. Informe Anual por Establecimientos </a></td>
                          </tr>
                         <!-- <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeAsistenciaAnualCiclos.php?flag=1">12. Informe Anual por ciclos (en construcci&oacute;n) </a></td>
                          </tr>-->
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeAsistenciaAnualNivel.php?flag=0">13. Informe Anual por niveles </a></td>
                          </tr>

                      </table></td>
                    </tr>


                    <tr>
                      <td class="cuadro02"><strong>Evaluaciones</strong></td>
                    </tr>
                    <tr>
                      <td align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeEvaluacionCientHum.php">14.- Promedios de Establecimientos Cientifico Humanista por Nivel </a></td>
                          </tr>
                        
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeEvaluacionTecnico.php">15. Promedios por Establecimientos T&eacute;cnico Profesional por Nivel </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeEvalaucionAprobReprov.php">16. Cantidad de Aprobados y reprobados </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeEvalaucionAprobReprovNivel.php">17. Cantidad de aprobados y reprobados por nivel </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeEvaluacionSubsector.php">18. Cantidad de aprobados y reprobados por subsector </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformeEvaluacionAprobReprovSubsectorNivel.php">19. Cantidad e aprobados y reprobados por subsector y nivel </a></td>
                          </tr>

                          <!---<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="ActaDeCalificacionCara.php">Acta de Calificaciones Finales 
                                    y Promoci&oacute;n Escolar </a></td>
                                </tr>
								--->
                      </table></td>
                    </tr>
                </table></td>
                <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="5">

                    <tr>
                      <td class="cuadro02"><strong>Dotaci&oacute;n Docente </strong></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeDD.php">20. Informe Consolidado </a></td>
                          </tr>
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformeDotacionporProfesional.php">21. Informe por tipo de profesional </a></td>
                          </tr>

                      </table></td>
                    </tr>

                    <!--  COMENTADO HASTA NUEVO AVISO------------------------------------------------------------------/////
					<tr>
                      <td class="cuadro02"><strong>Postulaci&oacute;n</strong></td>
                    </tr>
                    <tr>
                      <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                          <tr>
                            <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td width="92%" class="cuadro01"><a href="reportes/InformePostulacionAnual.php">22. Total de postulaciones de todos los establecimientos </a> </td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformePostulacionAnualInstit.php">23. Total des postulaciones a establecimientos de la corporaci&oacute;n </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformePostulacionOrigenDestino.php">24. Total de postulaciones de todos los establecimientos </a></td>
                          </tr>
                          <tr>
                            <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                            <td class="cuadro01"><a href="reportes/InformePostulacionAceptados.php">25. Total aceptados de todos los establecimientos </a></td>
                          </tr>
                      </table></td>
                    </tr>------------------------------------------------------------------------------------------->
                    <tr>
                      <td class="cuadro02"><strong>Personal</strong></td>
                    </tr>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                    <tr>
                      <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td width="92%" class="cuadro01"><a href="reportes/InformePI.php">26. Escuelas con proyecto de integraci&oacute;n </a> </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td class="cuadro01"><a href="reportes/InformeSeguimientoPI.php">27. Seguimientos de proyectos de integraci&oacute;n</a> </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td class="cuadro01"><a href="reportes/InformeGD.php">28. Escuelas con grupo diferencial</a> </td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td class="cuadro01"><a href="reportes/InformeSeguimientoGD.php">29. Seguimientos de grupo diferencial </a></td>
                    </tr>
                   
                  </table></td>
                  <!----------- COMENTADO HASTA NUEVO AVISO--------------------------------------------
				  <tr>
                    <td class="cuadro02"><strong>Gesti&oacute;n Curricular </strong></td>
                  </tr>-->
                  <td><!--<table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                    <tr>
                      <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td width="92%" class="cuadro01"><a href="reportes/InformeGestionCurricular.php">30. Informe Detallado de Curso </a></td>
                    </tr>
                  </table>--------------------------------------------------------------------------></td>
                  </tr>
                  <tr>
                    <td class="cuadro02"><strong>Pruebas Simce-Psu</strong></td>
                  </tr>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                    <tr>
                      <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td width="92%" class="cuadro01"><a href="reportes/InformeSimce.php">31. Informe resultados Simce</a></td>
                    </tr>
                    <tr>
                      <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td width="92%" class="cuadro01"><a href="reportes/InformePSU.php">32. Informe resultados Psu</a></td>
                    </tr>
                  </table></td>
                  </tr>
                  <tr>
                    <td class="cuadro02"><strong>Becas y Beneficios</strong></td>
                  </tr>
                  <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                    <tr>
                      <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td width="92%" class="cuadro01"><a href="reportes/InformeBecasInstit.php">33. Por establecimientos </a></td>
                    </tr>
                    <tr>
                      <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                      <td class="cuadro01"><a href="reportes/InformeBecas.php">34. Por Becas </a></td>
                    </tr>
                  </table></td>
                  </tr><tr>
                     <td class="cuadro02"><strong>Practica Profesional </strong></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                      <tr>
                        <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                        <td width="92%" class="cuadro01"><a href="reportes/InformePracticaProf.php">35. Informe General </a></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr>
          </table></td>
        </tr>
        <tr>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td height="44" align="center" valign="middle"><table width="40%" border="0" cellpadding="0" cellspacing="0" class="boton02">
              <tr align="center" valign="middle">
                <td height="23"><img src="../../../../cortes/atras.gif" width="11" height="11"> Volver</td>
                <td><img src="../../../../cortes/subir.gif" width="11" height="11"> Subir</td>
              </tr>
          </table></td>
        </tr>
      </table>
	</center>
	<?
	$ano			=$_ANO;
	?>
									 
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
									
									
									
								  </td>
							   </tr>
							 </table>							  
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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
