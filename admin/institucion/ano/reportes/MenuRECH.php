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

<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>

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
?><HEAD>
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
<?php }?></head>
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
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						
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
<!--                      <td width="52%" height="582"> 
					  <table width="100%" border="0" cellspacing="0" cellpadding="5">
                          <tr> 
                            <td class="cuadro02"><strong>Alumnos</strong></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="FichaAlumno.php">Ficha Personal</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="InformeAnotaciones.php">Anotaciones</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="CertificadoAlumnoRegular.php">Certificado Alumno Regular</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="FichaApoderado.php?ai_institucion=<?=($institucion)?>">Informe de Apoderados</a></td>
                                </tr>						
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="alumnos_retirados.php">Alumnos Retirados</a></td>
                                </tr>
								<tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="carta_apoderado.php">Carta a Apoderados</a></td>
                                </tr>
                              </table></td>
                          </tr-->

                          <tr> 
                            <td class="cuadro02"><strong>Men&uacute; Informes Actas Matricula </strong></td>
                          </tr>
						 
						  <tr> 
                            <td align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="Formulario1.php">Formulario N &ordm;1 </a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="formulario3.php">Formulario N&ordm;3 </a></td>
                                </tr>
                              </table></td>
                          </tr>					  
						  
						  
						  
						  
						  <tr> 
                            <td class="cuadro02">&nbsp;</td>
                          </tr>
							  <tr> 
								<td width="50%">
									<tr> 
								<td height="80" align="left" valign="top">&nbsp;</td>
							  </tr>
                                <!--tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="NotasParciales_Taller.php?flag=1">Parciales y Taller 
                                    por Alumno</a></td>
                                </tr>

                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="NotasParciales_Taller_Ingles.php?flag=0">Report Card</a></td>
                                </tr>
                              </table></td>
                          </tr>
                          <tr--> 
                         
						 
						 <tr> 
                            <td height="80">&nbsp;</td>
                          </tr>
						 
						 
						 <?  if ($_INSTIT!=9074) {?>
						 
						
                       
						  <? } ?>
                          <!--tr> 
                            <td class="cuadro02"><strong>Cierre</strong></td>
                          </tr>
                          <tr> 
                            <td align="left" valign="top"> <table width="100%" border="0" cellpadding="5" cellspacing="0" class="datosC">
                                <tr> 
                                  <td width="8%" align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td width="92%" class="cuadro01"><a href="InformeNotasFinales.php">Informe de Notas 
                                    Finales</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="certificadoEBasicaMedia.php">Certificado de Ense&ntilde;anza 
                                    B&aacute;sica y Media</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="CertificadoEstudios.php">Certificado Anual de Estudio</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="concentracionnotas.php">Concentraci&oacute;n de Notas</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="ActaDeCalificacionCara.php">Acta de Calificaciones Finales 
                                    y Promoci&oacute;n Escolar </a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="PlanillaNotasFinales.php">Planilla de Notas Finales</a></td>
                                </tr>
                                <tr> 
                                  <td align="center" valign="middle"><img src="../../../../cortes/arrow.png" width="9" height="9"></td>
                                  <td class="cuadro01"><a href="PlanillaNotasGeneralesPeriodo.php">Planilla de Promedios Generales 
                                    por Per&iacute;odo</a></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
						
						-->
						
                      <td width="50%">&nbsp;</td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <tr> 
          <td align="center" valign="top">&nbsp;</td>
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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