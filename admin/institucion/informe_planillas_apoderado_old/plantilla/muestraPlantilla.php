<?php 
require('../../../../util/header.inc');
if($_PLANTILLA!=""){
	$plantilla	=$_PLANTILLA;
}

$_POSP = 4;
$_bot = 7;


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
						$menu_lateral=2;
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
								  
								
								  <?php if($_PERFIL!=17){?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      
	   <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	  
	  
	  
	   </td>
  </tr>
</table>
<?php } ?>
<table width="76%" border="0" align="center">
  <tr> 
    <td><table width="100%" border="0">
        <tr> 
          <td width="100%">&nbsp;</td>
        </tr>
        <tr align="center" bgcolor="#003b85"> 
          <td class="tableindex">INFORME 
            EDUCACIONAL</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Alumno</font></td>
          <td width="50%">: </td>
          <td width="5%"><font size="2" face="Arial, Helvetica, sans-serif">RUT</font></td>
          <td width="36%">: </td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Curso</font></td>
          <td width="31%">: </td>
          <td width="13%"><font size="2" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
          <td width="47%">: </td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Establecimiento</font></td>
          <td width="83%">: </td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Profesor 
            Jefe</font></td>
          <td width="83%">: </td>
        </tr>
      </table>

      <table width="100%" border="0">
	  <?	
	  		$sql_titulo = "select titulo_informe1,titulo_informe2 from informe_plantilla where id_plantilla=".$plantilla." ";
			$res_titulo = @pg_exec($conn,$sql_titulo);
			$filaPlantilla=@pg_fetch_array($res_titulo);
	  ?>
        <tr> 
          <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Título Reporte 3</font></td>
          <td width="83%">: &nbsp; <? echo $filaPlantilla['titulo_informe1'];?></td>
        </tr>
        <tr> 
          <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Título Reporte 18</font></td>
          <td width="83%">: &nbsp; <? echo $filaPlantilla['titulo_informe2'];?></td>
        </tr>
      </table>

      <table width="100%" border="0">
        <tr> 
          <td colspan="2">&nbsp;</td>
        </tr>
      </TABLE>
      
      <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
        <?php 
			$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$plantilla;
			$resultTraeConcepto=pg_Exec($conn, $sqlTraeConcepto);
			//trae areas
			$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$plantilla."ORDER BY id_area";
			$resultTraeArea=pg_Exec($conn, $sqlTraeArea);
			for($countArea=0 ; $countArea<pg_numrows($resultTraeArea) ; $countArea++){
				$filaTraeArea=pg_fetch_array($resultTraeArea, $countArea);
				echo "<tr><td><font size=2 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
          		echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
				
					//trae subareas para cada area y las imprime
					$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area']."ORDER BY id_subarea";
					$resultTraeSubarea=pg_Exec($conn, $sqlTraeSubarea);
					for($countSubarea=0 ; $countSubarea<pg_numrows($resultTraeSubarea) ; $countSubarea++){
						$filaTraeSubarea=pg_fetch_array($resultTraeSubarea, $countSubarea);
						if ($filaTraeArea['con_subarea']==1){
						echo "<tr><td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font></td>";
   						echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						}//else{
          					//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
							$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea']."ORDER BY id_item";
							$resultTraeItem=pg_Exec($conn, $sqlTraeItem);
							for($countItem=0 ; $countItem<pg_numrows($resultTraeItem) ; $countItem++){
								$filaTraeItem=pg_fetch_array($resultTraeItem, $countItem);
								//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
								echo "<tr><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font></td>";
										if($filaTraeItem['tipo']==0){
											echo "<td>&nbsp;&nbsp;<SELECT name=\"cmbConcepto[".$countItem."]\">";
											echo "<option value=0>Seleccione Concepto</option>"; 
													for($countConc=0 ; $countConc<pg_numrows($resultTraeConcepto) ; $countConc++){
														$filaConc=pg_fetch_array($resultTraeConcepto, $countConc);
											echo "<option value=".$filaConc['id_concepto'].">".$filaConc['nombre']."</option>";
													}//fin for($countConc.....
											echo "</select></td>";
										}else if($filaTraeItem['tipo']==2){
											echo "<td>&nbsp;&nbsp;<input name=text type=text maxlength=200></td>";
										}else if($filaTraeItem['tipo']==1){
											echo "<td>&nbsp;&nbsp;<input type=radio name=radio value=1><font size=2 face=Arial, Helvetica, sans-serif>SI</font></label><label>";
											echo "<input type=radio name=radio value=0><font size=2 face=Arial, Helvetica, sans-serif>NO</font></label></td>";										
										}
									
							}//fin for($countItem....
					}//fin for($countSubarea....
					
			}//fin for($countArea....
			
		  ?>
      </table>
      <table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#999999">
        <tr> 
          <td bordercolor="#999999"><font size="2" face="Arial, Helvetica, sans-serif">Observaciones:</font></td>
        </tr>
      </table>
      <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#999999">
        <tr> 
          <td align="center"><font size="2" face="Arial, Helvetica, sans-serif"> 
            <TEXTAREA NAME="txtObs" ROWS="20" COLS="60"></TEXTAREA>
            &nbsp;</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">
            <input type="hidden" name="fecha">
            </font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr align="center"> 
          <td width="45%"><font size="1" face="Arial, Helvetica, sans-serif">PROFE 
            JEFE</font></td>
          <td width="55%"><font size="1" face="Arial, Helvetica, sans-serif">JEFE 
            ESTABLECIMIENTO</font></td>
        </tr>
      </table>
      <table width="100%" border="0">
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td>&nbsp;</td>
        </tr>
        <tr> 
          <td align="center"><font size="1" face="Arial, Helvetica, sans-serif">ORIENTADOR</font></td>
        </tr>
        <tr> 
          <td align="center">&nbsp;</td>
        </tr>
        <tr> 
          <td align="center"></font></td>
        </tr>
      </table>
      <table width="100%">
        <tr> 
          <td align="center" class="tableindex">ESCALA 
            DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</td>
        </tr>
        <tr>
        </tr>

      </table>

	  <table width="100%" border="0">
        <tr>
        <?php 
			$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$plantilla;
			$resultConc=pg_Exec($conn, $sqlConc);
			for($countConc=0 ; $countConc<pg_numrows($resultConc) ; $countConc++){
				$filaConc=pg_fetch_array($resultConc,$countConc);
				echo"<tr><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."</font></td>";
				echo "<td><font size=2 face=Arial, Helvetica, sans-serif>:</font></td>";
				echo "<td><font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['glosa']."</font><td></tr>";
			}	
		/**
		***DESPUES DE MOSTRAR LA PLANTILLA FINAL ELIMINO LAS COOKIES PARA PODER CREAR MAS PLANTILLAS
		***SI NO LAS ELIMINARA ME DARIA ERROR AL CREAR EN procesoPlantilla.php
		*/
		if(session_is_registered('_PLANTILLA')){
			session_unregister('_PLANTILLA');
		};
		if(session_is_registered('_AREA')){
			session_unregister('_AREA');
		};
		if(session_is_registered('_CONCEPTO')){
			session_unregister('_CONCEPTO');
		};
	
		?>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
									
   								  <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
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
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
