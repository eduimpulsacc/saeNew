<?php 
require('../../../../util/header.inc');
//$plantilla	=$_PLANTILLA;
$institucion =$_INSTIT;
$_POSP = 4;
$_bot = 7;
$ano		=$_ANO;
//$modificar= $_GET[modificar];
		/*if(session_is_registered('_PLANTILL')){
			session_unregister('_CURSO');
		};*/

if($grado==1) $gr="pa";
if($grado==2) $gr="sa";
if($grado==3) $gr="ta";
if($grado==4) $gr="cu";
if($grado==5) $gr="qu";
if($grado==6) $gr="sx";
if($grado==7) $gr="sp";
if($grado==8) $gr="oc";

	//$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=110 AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE id_plantilla=".$hiddenPlantilla;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);

	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno=".$alumno;
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno);
	
	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$_CURSO;
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$tipoEns;
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$_CURSO;
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../estilos.css" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript">
/*function enviapag(form){
			if (form.periodo.value!=0){
				form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				
				form.action = 'modificarPlantilla.php?periodo=$periodo&creada=1';
				form.submit(true);
	
				}	
}*/
			
			
			function enviar(form){
			//if (form.periodo.value!=0){
				//form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				
				form.action = 'string1.php';
				form.submit(true);
	
				//}	
			}
</SCRIPT>
</head>
<link href="../../../../util/objeto.css" rel="stylesheet" type="text/css">
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="90" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
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
								  
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								 
							
							  <?php if($_PERFIL!=17){?>
<table width="739"  border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"> 
     
	 <?
						 include("../../../../cabecera/menu_inferior.php");
						 ?>
	 
	 
	 
	  </td>
  </tr>
</table>
<?php } ?>

<?php //if($creada!=1){//creando por 1ra vez?>
<!-- <form action="proceso_informe.php" method="post">
 --><?php //}else{//modificando?>
<!-- <form action="muestraPlantilla.php?creada=0" method="post">
 --><?php //} ?><form action="" method="post">
  <table width="76%" border="0" align="center">
    <tr> 
      <td><table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="32%">&nbsp;</td>
            <td width="17%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="10%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
            <td width="41%"><font size="2" face="Arial, Helvetica, sans-serif"> <input name="nroplantilla" type="hidden" value="<? $filaPlantilla['id_plantilla']?>">
              <?php $sqlPeriodo="select * from periodo where id_ano=".$ano." order by nombre_periodo";
					$resultPeriodo=@pg_Exec($conn, $sqlPeriodo);
			 ?>
              <!--               <select name="periodo" onChange="enviapag(this.form);">
                <option value="0">Seleccione Periodo</option>
 -->
              <?php /*
				for($countPer=0 ; $countPer<@pg_numrows($resultPeriodo) ; $countPer++){
					$filaPeriodo=@pg_fetch_array($resultPeriodo, $countPer);
					if($filaPeriodo['id_periodo']==$periodo){
					echo "<option selected value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}else{
					echo "<option value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}
				}*/
				?>
              <!--               </select>
 -->
              <?php echo $periodo;?></font></td>
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              </font></td>
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php if(($creada!=1) and ($periodo!="")){?>
              <?php } ?>
              <?php //if($creada==1){?>
              <?php //} ?>
              </font></td>
          </tr>
          <tr align="right"> 
            <td colspan="4"> 
              <input class="botonXX"  type="button" name="Submit2" value="LISTADO" onClick="window.location='../plantilla/listaPlantillas.php?botonera=1'">
              &nbsp;</td>
          </tr>
          <tr align="center" bgcolor="#003b85"> 
            <td colspan="4" class="tableindex">AGREGAR 
              REGISTROS A INFORME EDUCACIONAL</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td><font size="2" face="Arial, Helvetica, sans-serif">Debe seleccionar 
              que tipo de informacion desea agregar:</font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td><a href="../../planilla/plantillaModifica/plantilla.php?plantilla=<?php echo $hiddenPlantilla;?>"><font size="2" face="Arial, Helvetica, sans-serif">Agregar 
              AREAS, SUBAREAS E ITEMES</font></a></td>
          </tr>
          <tr>
            <td><a href="../../planilla/plantillaModifica/plantillaPaso2.php?plantilla=<?php echo $hiddenPlantilla;?>"><font size="2" face="Arial, Helvetica, sans-serif">Agregar 
              SUBAREAS E ITEMES</font></a></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td><a href="../../planilla/plantillaModifica/plantillaPaso2.php?plantilla=<?php echo $hiddenPlantilla;?>&cItem=si"><font size="2" face="Arial, Helvetica, sans-serif">Agregar 
              ITEMES</font></a></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td height="21">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="" face="Arial, Helvetica, sans-serif"><strong> 
              </strong></font></td>
          </tr>
        </TABLE>
        
        <table width="100%" border="0">
          <tr> 
            <?php 
			/*$sqlConc="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
			$resultConc=pg_Exec($conn, $sqlConc);
			for($countConc=0 ; $countConc<pg_numrows($resultConc) ; $countConc++){
				$filaConc=pg_fetch_array($resultConc,$countConc);
				echo"<tr><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."</font></td>";
				echo "<td><font size=2 face=Arial, Helvetica, sans-serif>:</font></td>";
				echo "<td><font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['glosa']."</font><td></tr>";
			}		*/
		?>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
							
							
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
          <td width="90" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
