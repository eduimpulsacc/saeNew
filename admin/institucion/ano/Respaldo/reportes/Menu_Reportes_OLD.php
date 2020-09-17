<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP = 4;
	$_bot  =8;
	
 ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript" src="../../../../util/chkform.js">
function generar(){
	if(confirm('!!ESTE PROCESO AGREGA TODOS LOS ALUMNOS PROMOVIDOS Y NO RETIRADOS DEL AÑO ANTERIOR¡¡') == false){ return; };
	document.location="../procesoMatAuto.php3"
};


function Confirmacion(){
if(alert('¡EL INGRESO DE REGIMEN ES IRREVERSIBLE, DEBE ESTAR SEGURO DEL REGIMEN PARA ESTE AÑO ESCOLAR!') == false){ return; };
};
//-->
</script>

<SCRIPT language="JavaScript">
	//	var modo.value = <? echo $_FRMMODO ?>;
	/*
	function generar(){
		if(confirm('!!ESTE PROCESO AGREGARA A TODOS LOS ALUMNOS PROMIVIDOS Y NO RETIRADOIS EL AÑO ANTERIOR¡¡') == false){ return; };{
				document.location="procesoMatAuto";
	}*/
	
//function Confirmacion(){
	
		/*alert(modo.value);
		}*/
			//document.location="seteaCurso.php3?caso=9"
		
			//function Confirmacion(){
				//	if(confirm('¡¡SI ELIMINA EL AÑO ESCOLAR SE PERDERAN TODOS LOS DATOS!!') == false){ return; };
					//	document.location="seteaAno.php3?caso=9"
				//	};
</script>
<?php

$qry1="SELECT tipo_regimen FROM institucion WHERE rdb=".$_INSTIT;
	$result1 =@pg_Exec($conn,$qry1);
	$fila1 = @pg_fetch_array($result1,0);
	$regimen=$fila1['tipo_regimen'];

?>

	<?php if($frmModo!="ingresar"){
		$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$qry);
		if (!$result) {
			//error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
		}else{
			if (pg_numrows($result)!=0){
				$fila = @pg_fetch_array($result,0);	
				if (!$fila){
					//error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
					//exit();
				}
			}
		}
	}
?>
	<HEAD>
<?php if($frmModo!="mostrar"){?>
		<SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
		<SCRIPT language="JavaScript">
			function valida(form){
				if(!chkVacio(form.txtANO,'Ingresar AÑO.')){
					return false;
				};
				
				if(!chkSelect(form.cmbREGIMEN,'Debe Seleccionar Régimen.')){
					return false;
				};

				if(!nroOnly(form.txtANO,'Se permiten sólo números en el AÑO.')){
					return false;
				};

				if(!chkVacio(form.txtFECHAINI,'Ingresar FECHA INICIO.')){
					return false;
				};

				if(!chkFecha(form.txtFECHAINI,'Fecha Inicio inválida.')){
					return false;
				};

				if(!chkVacio(form.txtFECHATER,'Ingresar FECHA TERMINO.')){
					return false;
				};
				
				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};

				if(!chkFecha(form.txtFECHATER,'Fecha Término inválida.')){
					return false;
				};
				
				//VALIDACION INTERVALO DE FECHAS
				if(amd(form.txtFECHAINI.value)>=amd(form.txtFECHATER.value)){
					alert("Fecha de término no puede ser mayor o igual a la Fecha de inicio");
					return false;
				}

				return true;
			}
		</SCRIPT>
<?php }?>
	
	
	<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>
	
<style type="text/css">
<!--
.Estilo1 {color: #0033FF}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  
								  
								  <?php if(($_PERFIL!=17) &&  ($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)&&($_PERFIL!=23)&&($_PERFIL!=24)&&($_PERFIL!=25)&&($_PERFIL!=26)){?>

<?
include("../../../../cabecera/menu_inferior.php");
?>


<? } ?>
	<FORM method=post name="frm">
	  <TABLE WIDTH=600 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
	  <TR height=15>
				<TD>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD width="597" align=left>
								<div align="right">
								
								  <!--input class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' name="button" type="button" onClick=document.location="../ano_escolar.php3"  value="VOLVER"-->
						      </div></td>
						</tr>
					</table>
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 align="center">
						
						<TR>
							<TD align=left class="textonegrita"><strong>AÑO ESCOLAR</strong>							</TD>
							<TD>
									<strong>:</strong>							</TD>
							<TD>
									<strong>
										<?php
											$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila = @pg_fetch_array($result,0);	
													if (!$fila){
														error('<B> ERROR :</b>Error al acceder a la BD. (4)</B>');
														exit();
													}
													echo trim($fila['nro_ano']);
												}
											}
										?>
									</strong>							</TD>
						</TR>
					</TABLE>				</TD>
		</TR>
	  </TABLE>
	  
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="811" height="508" align="center" valign="top"> 
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="100%" align="center" valign="top"><div align="left"> 
              <p class="fondo">Reportes</p>
            </div></td>
        </tr>
        <tr> 
          <td height="640" align="center" valign="top"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="5">
              <tr> 
                <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="5">
                    <tr align="left" valign="top"> 
                      <td width="52%" height="582"> <table width="100%" border="0" cellspacing="0" cellpadding="5">
                          <tr> 
                            <td class="cuadro02"><strong>Alumnos</strong></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="FichaAlumno.php">1. Ficha Personal del Alumno</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeAnotaciones.php">2. Anotaciones</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><? if ($_INSTIT!=24988){?><a href="CertificadoAlumnoRegular.php"><? } else {?><a href="CertificadoAlumnoRegular_almenar.php"><? } ?>3. Certificado Alumno Regular</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeAlumnoApoderado.php">65. Informe Alumnos con Apoderados</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="FichaApoderado.php?ai_institucion=<?=($institucion)?>">4. Informe de Apoderados</a></td>
                                </tr>						
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="alumnos_retirados.php">5. Alumnos Retirados</a></td>
                                </tr>
								 <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="alumnos_extranjeros.php">6. Alumnos Extranjeros</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="alumnos_licenciados.php">7. Alumnos Licenciados</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="carta_apoderado.php">8. Carta a Apoderados</a></td>
                                </tr>
								
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="carta_apoderado_alumno.php">9. Carta a Apoderados basadas en alumnos</a></td>
                                </tr>
								
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeAlumnosSexo.php">10. Cantidad de alumnos por tipo de enseñanza</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeEntrevistas.php">11. Informe de Entrevistas</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeAnotacionesCurso.php">58. Cantidad de anotaciones por Curso</a></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td class="cuadro02"><strong>Notas Parciales</strong></td>
                          </tr>
                          <tr> 
                            <td height="80" align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="NotasParciales_Taller.php?flag=0">12. Parciales por Alumno</a></td>
                                </tr>
                                 <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="NotasParciales_Taller_sc.php?flag=0">64. Parciales por Alumno Sin Colilla Apoderados</a></td>
                                </tr>
								<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="NotasParciales_Taller_2.php?flag=0">13. Parciales por Alumno Anotaciones</a></td>
                                </tr>
								<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="InformeGraficoNotasGeneralesPeriodo.php?flag=0">14. Informe Gráfico Notas Generales Período</a></td>
                                </tr>
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="NotasParciales_Taller.php?flag=1">15. Parciales y Taller 
                                    por Alumno</a></td>
                                </tr>

                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="NotasParciales_Taller_Ingles.php?flag=0">16. Report Card</a></td>
                                </tr>
								
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="Notassubsectorcursos.php?flag=0">17. Cantidad de notas en Cursos por Subsector </a></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td class="cuadro02"><strong>Orientaci&oacute;n</strong></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">

                                
                                <?
								if ($institucion == 9071){ ?>
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="../../Colegio_restore/Reportes/Rpt19/rpt19_formato.php?ai_institucion=<?=($institucion)?>">18. Informe de Desarrollo 
                                    Personal y Social</a></td>
                                </tr>
							 <? } else { ?>							
								
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="../../Colegio_restore/Reportes/Rpt19/rpt19_formato_rapido.php?ai_institucion=<?=($institucion)?>">18. Informe de Desarrollo 
                                    Personal y Social</a></td>
                                </tr>
							 <? } ?>                                
                                
                                
                                
                                
                                <?
								if ($_PERFIL==0){ ?>
		    					 <tr> 
                                       <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                       <td class="cuadro01"><a href="../../Colegio_restore/Reportes/Rpt18/rpt18.php?ai_institucion=<?=($institucion)?>">19. Informe Educacional</a></td>
                                     </tr>
							 <? } else { ?>							
								
								     <tr> 
                                       <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                       <td class="cuadro01"><a href="../../Colegio_restore/Reportes/Rpt18/rpt18.php?ai_institucion=<?=($institucion)?>">19. Informe Educacional</a></td>
                                     </tr>
							 <? } ?>	
							 
							       <tr> 
                                       <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                       <td class="cuadro01"><a href="../../Colegio_restore/Reportes/Rpt18/rpt18_curso.php?ai_institucion=<?=($institucion)?>">57. Informe Educacional por Curso</a></td>
                                     </tr>	 
								
								
								
								<? if($institucion==25452 || $_PERFIL==0){  ?>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="Trebulco/rpt18.php?ai_institucion=<?=($institucion)?>">20. Personal Development</a></td>
                                </tr>
								<? }	?>
                              </table></td>
                          </tr>
						  
						  
						  
                          <tr> 
                            <td class="cuadro02"><strong>Cierre de A&ntilde;o </strong></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top">
							
							 <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="InformeNotasFinales.php">21. Informe de Notas 
                                    Finales</a></td>
                                </tr>
								<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="InformeNotasFinalesyParciales.php">56. Informe de Notas parciales y promedio por curso</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="certificadoEBasicaMedia.php">22. Licencia de ense&ntilde;anza b&aacute;sica y pre-b&aacute;sica</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="CertificadoEstudios.php">23. Certificado Anual de Estudio</a></td>
                                </tr>
								<!----<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="CertificadoEstudios_electivos.php">59. Certificado Anual de Estudio<br> 
                                    (Diferencia en electivos)</a></td>
                                </tr>
                                ---->
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="concentracionnotas.php">24. Concentraci&oacute;n de Notas</a></td>
                                </tr>
								
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01">
								  <?
								  if ($_INSTIT==1593){
								        ?><a href="ActaDeCalificacionCara_1593.php">25. Acta de Calificaciones Finales y Promoci&oacute;n Escolar </a><?
								  
								  }else{ ?>
								        <a href="ActaDeCalificacionCara_d.php">25. Acta de Calificaciones Finales y Promoci&oacute;n Escolar </a>
								<? } ?></td>
                                </tr>
							  
                                <!---<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="ActaDeCalificacionCara.php">Acta de Calificaciones Finales 
                                    y Promoci&oacute;n Escolar </a></td>
                                </tr>
								--->
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="PlanillaNotasFinales.php">26. Planilla de Notas Finales</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="PlanillaNotasGeneralesPeriodo.php">27. Planilla de Promedios Generales 
                                    por Per&iacute;odo</a></td>
                                </tr>
								
                                 <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="NotasSemestrales_Taller.php">66. Informe de Notas Finales</a></td>
                                </tr>
                                
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="Resumen_4_medios2.php">62. Informe Demre</a></td>
                                </tr>
								
                              </table></td>
                          </tr>
                          <tr>
                            <td class="cuadro02"><strong>Subvención </strong></td>
                          </tr>
                          <tr>
                            <td align="left" valign="top"><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                              <tr>
                                <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                <td width="92%" class="cuadro01"><a href="Subvencion.php">28. Proyecci&oacute;n de Subvenci&oacute;n mensual</a></td>
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
						
					      
						
						
                      <td width="50%"> <table width="100%" border="0" cellspacing="0" cellpadding="5">
                          <tr> 
                            <td class="cuadro02"><strong>Lista</strong></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="Lista_Alumnos_Curso_3.php">29. Curso por Comuna</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="Lista_Alumnos_Curso_2.php">30. Curso con fecha Nacimiento</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="Lista_Alumnos_Curso.php">31. Lista de Curso</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="Lista_Curso_adap.php">32. Lista del Curso Adaptable</a></td> 
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td class="cuadro02"><strong>Asistencia</strong></td>
                          </tr>
                          <tr> 
                            <td height="80"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="AsistenciaMes.php">33. Asistencia del 
                                    Mes (por curso)</a></td>
                                </tr>
								<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="AsistenciaMes_conret.php">61. Asistencia del 
                                    Mes (por curso), con alumnos retirados</a></td>
                                </tr>								
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeGeneralAsistencia.php">34. Informe General de Asistencia</a></td>
                                </tr>
								
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeAsistenciaPeriodo.php">35. Informe de Asistencia</a></td>
                                </tr>
								
								<tr> 
								  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
								  <td class="cuadro01"><a href="../../../../admin/institucion/ano/reportes/InformeAsistenciaporhorasperiodo.php">36. Informe de Asistencia por horas de clase por periodos </a></td>
								</tr>
								
								
								<tr> 
								  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
								  <td class="cuadro01"><a href="../../../../admin/institucion/ano/reportes/InformeAsistenciaporhoras.php">37. Informe de Asistencia por horas de clase mensual </a></td>
								</tr>
								
								<tr> 
								  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
								  <td class="cuadro01"><a href="../../../../admin/institucion/ano/reportes/InformeAsistenciaGraficoAlumnos.php">38. Informe de Asistencia Gráfico por Alumnos </a></td>
								</tr>
								
								<tr> 
								  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
								  <td class="cuadro01"><a href="../../../../admin/institucion/ano/reportes/InformeAsistenciaGraficoAlumnos_conret.php">60. Informe de Asistencia Gráfico por Alumnos, con alumnos retirados </a></td>
								</tr>
								
								<tr> 
								  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
								  <td class="cuadro01"><a href="../../../../admin/institucion/ano/reportes/AsistenciaMes_apo.php">39. Informe de Asistencia de Apoderados </a></td>
								</tr>
								<tr> 
								  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
								  <td class="cuadro01"><a href="../../../../admin/institucion/ano/reportes/Asistencia_apoderado.php">40. Informe mensual de Asistencia Apoderados </a></td>
								</tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td class="cuadro02"><strong>Rendimiento Escolar</strong></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="InformeRendimientoEscolar.php">41. Informe Rendimiento Escolar</a></td>
                                </tr>
								<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="InformeRendimientoCritico.php">42. Informe Rendimiento Crítico</a></td>
                                </tr>
								<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="InformeRendimientoCriticoFinal.php">43. Informe Rendimiento Crítico Final</a></td>
                                </tr>
								<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="notas_por_asignatura.php">44. Informe de Notas 
                                    por Asignatura</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeRendimiento.php">45. Rendimiento del Curso</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeGraficoCursos.php">46. Informe Gr&aacute;fico de Cursos</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeGraficoTipoEnsenanza.php">47. Informe Gr&aacute;fico Tipos de Enseñanza</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeRepitentesporCurso.php">48. Informe de Alumnos Reprobados</a></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr> 
                            <td class="cuadro02"><strong>Matr&iacute;cula</strong></td>
                          </tr>
                          <tr> 
                            <td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
							 <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01">
								  <a href="formulario_idoneidad.php">49. Formulario Idoneidad Docente A&ntilde;o <br>
								  <? echo trim($fila['nro_ano']) ;?> </a>								</td>
                                </tr> 
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="RegistroMatricula3.php">50. Libro de Matr&iacute;cula por Curso</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="RegistroMatricula.php">51. Libro de Matr&iacute;cula</a></td>
                                </tr>
							    <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="ficha_matricula.php3">52. Ficha de Matrícula</a></td>
                                </tr>
                              </table></td>
                          </tr>
						  		<tr> 
		                            <td class="cuadro02"><strong>Personal</strong></td>
        	                  	</tr>
								<td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
							 	<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01">
								  <a href="InformeAnotacionesPersonal.php">53. Anotaciones del Personal</a>								</td>
                                </tr>
								
								<!---<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01">
								  <a href="InformePlanificacion.php">54. Informe planificación docente</a>								</td>
                                </tr>
								---->
								</table></td>
								
								<tr> 
		                            <td class="cuadro02"><strong>Postulaciones a Becas</strong></td>
        	                  	</tr>
								<td><table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
							 	<tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01">
								  <a href="InformeMejoresPromedios.php">55. Informe mejores promedios de cuartos medios (5%)</a>								</td>
                                </tr>
								
								</table>
								    
								    </td>
									
									
								<tr> 
		                            <td class="cuadro02"><strong>Atrasos</strong></td>
        	                  	</tr>
								
								<td>
								     <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
							 	      <tr> 
                                       <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                       <td width="92%" class="cuadro01">
								       <a href="InformeAtrasoPeriodo.php">63. Informe de atrasos por periodos</a></td>
                                      </tr>
									</table>
							   </td>
								 	
									
								
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr> 
          <td height="44" align="center" valign="middle"> <table width="40%" border="0" cellpadding="0" cellspacing="0" class="boton02">
              <tr align="center" valign="middle"> 
                <td height="23"><img src="../../../../cortes/atras.gif" width="11" height="11"> 
                  Volver</td>
                <td><img src="../../../../cortes/subir.gif" width="11" height="11"> Subir</td>
                </tr>
            </table></td>
        </tr>
      </table>
      <p>&nbsp;</p></td>
  </tr>
</table>
    </FORM>
	
	
								 
   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2007 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>