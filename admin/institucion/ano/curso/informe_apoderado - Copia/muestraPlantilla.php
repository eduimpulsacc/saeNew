<?php 
require('../../../../../util/header.inc');
//$plantilla	=$_PLANTILLA;

$institucion =$_INSTIT;

if($tipo_hoja!=1){
	$ano		 =$_ANO;
}else{
	/************VARIABLES PARA HOJA DE VIDA********/
	$ano = $_GET['c_ano'];
	$curso = $_GET['c_curso'];
	$alumno = $_GET['c_alumno'];
	/***********************/
}
$_POSP       = 5;
$_bot        = 5;
//$modificar= $_GET[modificar];
		/*if(session_is_registered('_PLANTILL')){
			session_unregister('_CURSO');
		};*/


	$sqlTraeCurso="SELECT * FROM curso WHERE ";
	if($tipo_hoja!=1){
	$sqlTraeCurso.="id_curso=".$_CURSO;
	}else{
	$sqlTraeCurso.="id_curso=".$curso;
	}
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	   if($tipoEns=="")
	      $tipoEns=$filaCurso['ensenanza'];
		  if($tipo_hoja==1){
		  $grado = $filaCurso['grado_curso'];
			}


if($grado==1) $gr="pa";
if($grado==2) $gr="sa";
if($grado==3) $gr="ta";
if($grado==4) $gr="cu";
if($grado==5) $gr="qu";
if($grado==6) $gr="sx";
if($grado==7) $gr="sp";
if($grado==8) $gr="oc";
if($grado==9) $gr="nv";
if($grado==10) $gr="dc";
if($grado==11) $gr="un";
if($grado==12) $gr="duo";
if($grado==13) $gr="tre";
if($grado==14) $gr="cat";


	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$tipoEns." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;

// echo $sqlTraePlantilla;	
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	
	//print_r($filaPlantilla);
//imprime_array($filaPlantilla);
	if ($filaPlantilla[nuevo_sis]==1){

			if($_PERFIL == 0){
			
			?>
				<script>
					window.location="muestraPlantilla3.php?alumno=<? echo $alumno;?>&creada=1&grado=<? echo $grado;?>";
				</script>
			<? 
			}
			
			else{
			?>
				<script>
					window.location="muestraPlantilla3.php?alumno=<? echo $alumno;?>&creada=1&grado=<? echo $grado;?>";
				</script>
			<? 				
			}
			
			?>
	<? }
	
	
	else{
	//imprime_array($_GET);
//	imprime_array($filaPlantilla);
	}	
	$sqlTraeAlumno="SELECT * FROM alumno WHERE rut_alumno=".$alumno;
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno);
	
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$tipoEns;
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	$sqlProfe="select * from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$_CURSO;
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);
	$rut_jefe = $filaProfe['rut_emp'];	
	$ver = 0;
	if($rut_jefe==$_NOMBREUSUARIO){
		$ver = 1;
	}
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	
?>
<SCRIPT language="JavaScript">
function enviapag(form){
			if (form.periodo.value!=0){
				form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				
				form.action = 'muestraPlantilla.php?periodo='+form.periodo.value+'&creada=1&grado=<? echo $grado;?>&alumno=<?php echo trim($alumno);?>&tipo_hoja=<?=$tipo_hoja?>&c_curso=<?=$curso?>&c_alumno=<?=$alumno?>&c_ano=<?=$ano?>';
				form.submit(true);
	
				}	
			}
			
			
			/*function enviar(form){
			//if (form.periodo.value!=0){
				//form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;
				//var periodo=form.periodo.value;
				form.action = 'muestraPlantilla.php?creada=0';
				form.submit(true);
				//}	
			}*/
</SCRIPT>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral="3_1"; ?><? include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390">
								  <!-- inicio codigo nuevo -->
								  
								  
<?php if($_PERFIL!=17){ ?>
<table width="739" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top">&nbsp; 
       </td>
  </tr>
</table>
<?php } 

?>

<?php if($creada!=1){/*creando por 1ra vez*/  ?>
<form action="proceso_informe.php?ano=<?=$c_ano?>&curso=<?=$c_curso?>&alumno=<?=$c_alumno?>&tipo_hoja=<?=$tipo_hoja?>" method="post">
<?php }else{/*modificando */   ?>
<form action="muestraPlantilla.php?creada=0&c_ano=<?=$ano?>&c_curso=<?=$curso?>&c_alumno=<?=$alumno?>&tipo_hoja=<?=$tipo_hoja?>" method="post">
<?php } ?>
  <table width="76%" border="0" align="center">
    <tr> 
      <td><table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
            <td width="19%">&nbsp;</td>
            <td width="28%">&nbsp;</td>
          </tr>
          <tr> 
            <td width="11%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; 
              <font size="1">PERIODO</font></font></td>
            <td width="42%"><font size="2" face="Arial, Helvetica, sans-serif"> 
              : 
              <?php $sqlPeriodo="select * from periodo where id_ano=".$ano." order by nombre_periodo";
					$resultPeriodo=@pg_Exec($conn, $sqlPeriodo);
			 ?>
              <select name="periodo" onChange="enviapag(this.form);">
                <option value="0">Seleccione Periodo</option>
                <?php
				for($countPer=0 ; $countPer<@pg_numrows($resultPeriodo) ; $countPer++){
					$filaPeriodo=@pg_fetch_array($resultPeriodo, $countPer);
					if($filaPeriodo['id_periodo']==$periodo){
					echo "<option selected value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}else{
					echo "<option value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
					}
				}
				?>
              </select>
            </font></td>
            <td><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
            <td align="right"><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php if(($creada!=1) and ($periodo!="")){?>
              <input class="botonXX"  type="submit" name="Submit" value="GUARDAR">
              <?php } ?>
              <?php if($creada==1){
                          if (($_PERFIL==17) AND ($_INSTIT==9566)){ 
			                  // no muestro
			              }
							else if($institucion==24977 && $_PERFIL==17 && $ver==0){
								// no muestra boton
							}
							else if($institucion==24977 && $_PERFIL==17 && $ver==1){
?>
				  <input class="botonXX"  type="submit" name="modificar" value="MODIFICAR">											
<?								
								}else{ 
								 ?>
			                  <input class="botonXX"  type="submit" name="Submit3" value="MODIFICAR">
                       <? 		
					   	} ?>
			  <?php } ?>
			  
			  <? if($tipo_hoja!=1){?>
              <input class="botonXX"  type="button" name="Submit2" value="VOLVER" onClick="window.location='listarAlumnos.php'"><? }else{?>
			  <input class="botonXX"  type="button" name="Submit2" value="VOLVER" onClick="window.location='../alumno/HojaDeVida.php?c_ano=<?=$ano?>&c_curso=<?=$curso?>&c_alumno=<?=$alumno?>'">
			  <? }?>
              </font></td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr align="center" class="tableindex"> 
            <td colspan="4">INFORME</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Alumno</font></td>
            <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
            <td width="5%"><font size="2" face="Arial, Helvetica, sans-serif">RUT</font></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Curso</font></td>
            <td width="91%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaCurso['grado_curso']. "-".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></td>
          </tr>
        </table>
        <? // if($tipoEns>310){?><br>
        <?php  "<br>tipo_ense=".$tipoEns; if($tipoEns>310){ echo "si";?>
        <table width="100%" border="0">
          <tr> 
            <td width="14%"><font size="2" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
            <td width="86%">: <font size="2" face="Arial, Helvetica, sans-serif">
              <?php  $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaCurso['cod_es']." and cod_sector=".$filaCurso['cod_sector']." and cod_rama=".$filaCurso['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];
								echo $modificar;?>
              </font></td>
          </tr>
        </table>
        <?php } ?>
        <table width="100%" border="0">
          <tr> 
            <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Establecimiento</font></td>
            <td width="83%">:<font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php echo $cmbConcepto[0]; echo $filaInstit['nombre_instit']?></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Profesor 
              Jefe</font></td>
            <td width="83%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td colspan="2"><font size="" face="Arial, Helvetica, sans-serif"><strong> 
              <?php if(!$filaPlantilla){
			echo "NO EXISTE UNA PLANTILLA DE EVALUACION PARA ESTE GRADO Y TIPO DE ENSEÑANZA";
			}?>
              &nbsp;</strong></font></td>
          </tr>
        </TABLE>
        <table width="100%" border="0"  cellspacing="0">
          <?php if(($creada!=1) and ($periodo!="")) {
				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
		        	$sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						?><tr><td></td></tr>
						<tr><td class='tableindex'><? echo $filaTraeArea['nombre']; ?></td><?
						echo "<td></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=@pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<@pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=@pg_fetch_array($resultTraeSubarea, $countSubarea);
								echo "<tr><td><font color=\"#0099CC\" size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font></td>";
								echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
								
									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
								    $sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea']." order by id_item";
									$resultTraeItem=@pg_Exec($conn, $sqlTraeItem);
									for($countItem=0 ; $countItem<pg_numrows($resultTraeItem) ; $countItem++){
									$countI++;
										$filaTraeItem=@pg_fetch_array($resultTraeItem, $countItem);
										if($countItem%2==0){
											$color="#CDCDCD";
										}else{
											$color="#B5B5B5";
										}
										//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
										echo "<tr bgcolor=".$color."><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font></td>";
												if($filaTraeItem['tipo']==0){
													echo "<td>&nbsp;&nbsp;<SELECT name=\"cmbConcepto[".$countI."]\">";
													echo "<option value=0>Seleccione Concepto</option>"; 
															for($countConc=0 ; $countConc<@pg_numrows($resultTraeConcepto) ; $countConc++){
																$filaConc=@pg_fetch_array($resultTraeConcepto, $countConc);
																if($filaConc['id_concepto']==$cmbConcepto[$countI]){//
																	echo "<option selected value=".$filaConc['id_concepto'].">".$filaConc['nombre']."</option>";//
																}else{//
																	echo "<option value=".$filaConc['id_concepto'].">".$filaConc['nombre']."</option>";
																}//
															}//fin for($countConc.....
													echo "</select></td>";
												}else if($filaTraeItem['tipo']==2){
													if($text[$countI]!=""){
														echo "<td>&nbsp;&nbsp;<input name=\"text[".$countI."]\" type=text maxlength=200 value=".$text[$countI]."></td>";// "<td>&nbsp;&nbsp;".$text[$countI]."</td>";
													}else{
														echo "<td>&nbsp;&nbsp;<input name=\"text[".$countI."]\" type=text maxlength=200></td>";
													}
												}else if($filaTraeItem['tipo']==1){
												if($radio[$countI]!=""){
													if($radio[$countI]==1){
													echo "<td>&nbsp;&nbsp;<input type=radio name=\"radio[".$countI."]\" value=1 checked><font size=2 face=Arial, Helvetica, sans-serif>SI</font></label><label>";
													echo "<input type=radio name=\"radio[".$countI."]\" value=0 ><font size=2 face=Arial, Helvetica, sans-serif>NO</font></label></td>";
													}elseif ($radio[$countI]==0){
													echo "<td>&nbsp;&nbsp;<input type=radio name=\"radio[".$countI."]\" value=1 checked><font size=2 face=Arial, Helvetica, sans-serif>SI</font></label><label>";
													echo "<input type=radio name=\"radio[".$countI."]\" value=0 checked><font size=2 face=Arial, Helvetica, sans-serif>NO</font></label></td>";
													}
												}else{
													echo "<td>&nbsp;&nbsp;<input type=radio name=\"radio[".$countI."]\" value=1><font size=2 face=Arial, Helvetica, sans-serif>SI</font></label><label>";
													echo "<input type=radio name=\"radio[".$countI."]\" value=0><font size=2 face=Arial, Helvetica, sans-serif>NO</font></label></td>";
												}
												}
									}//fin for($countItem....
							}//fin for($countSubarea....
							
					}//fin for($countArea....
			}//fin if($creada!=1)
			
			if($creada==1){
			//$countI=0;
				$sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				$resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
				    $sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						echo "<tr><td></td></tr>";
						echo "<tr bgcolor=\"#0099CC\"><td><font color=\"#FFFFFF\" size=2 face=Arial, Helvetica, sans-serif><strong>".$filaTraeArea['nombre']."</strong></font></td>";
						echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
						
							//trae subareas para cada area y las imprime
							$sqlTraeSubarea="SELECT * FROM informe_subarea WHERE id_area=".$filaTraeArea['id_area'];
							$resultTraeSubarea=pg_Exec($conn, $sqlTraeSubarea);
							for($countSubarea=0 ; $countSubarea<pg_numrows($resultTraeSubarea) ; $countSubarea++){
								$filaTraeSubarea=pg_fetch_array($resultTraeSubarea, $countSubarea);
								echo "<tr><td><font color=\"#0099CC\" size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;&nbsp;<strong>".$filaTraeSubarea['nombre']."</strong></font></td>";
								echo "<td><font face=Arial, Helvetica, sans-serif>&nbsp;</font></td></tr>";
								
									//trae itemes para cada subarea y los imprime junto con los conceptos para cada item				
								$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea']." order by id_item";
									$resultTraeItem=pg_Exec($conn, $sqlTraeItem);
									
									for($countItem=0 ; $countItem<pg_numrows($resultTraeItem) ; $countItem++){
									$countI++;
										$filaTraeItem=pg_fetch_array($resultTraeItem, $countItem);
										//PRIMERO TENGO QUE PREGUNTAR SI EL ITEM SE EVALUA CON CONCEPTOS, SI/NO(RADIO), TEXTO
										
										if($countItem%2==0){
											$color="#CDCDCD";
										}else{
											$color="#B5B5B5";
										}
										//echo "<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand' onmouseout=this.style.background='transparent'><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font></td>";
										echo "<tr bgcolor=".$color."><td><font size=2 face=Arial, Helvetica, sans-serif>".$filaTraeItem['glosa']."</font></td>";
												if($filaTraeItem['tipo']==0){
/*echo"<br>".	*/										$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$ano." and id_periodo=".$periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													
													$sqlTraeConc="select * from informe_concepto_eval where id_concepto=".$filaEval['id_concepto'];
													$resultConc=@pg_Exec($conn, $sqlTraeConc);
													$filaConc=@pg_fetch_array($resultConc,0);
													
													echo "<td>&nbsp;&nbsp;";
													echo "<input type=\"hidden\" name=\"cmbConcepto[".$countI."]\" value=".$filaConc['id_concepto'].">";
													echo "<font size=2 face=Arial, Helvetica, sans-serif>".$filaConc['nombre']."</font>";
													echo "</td>";
												}else if($filaTraeItem['tipo']==2){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$ano." and id_periodo=".$periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													echo "<input type=\"hidden\" name=\"text[".$countI."]\" value=".$filaEval['text'].">";
													echo "<td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;".$filaEval['text']."</font></td>";
												}else if($filaTraeItem['tipo']==1){
													$sqlTraeEval="select * from informe_evaluacion where id_item=".$filaTraeItem['id_item']." and id_ano=".$ano." and id_periodo=".$periodo." and rut_alumno='".$alumno."'";
													$resultEval=@pg_Exec($conn, $sqlTraeEval);
													$filaEval=@pg_fetch_array($resultEval,0);
													echo "<input type=\"hidden\" name=\"radio[".$countI."]\" value=".$filaEval['radio'].">";
														if(($filaEval['radio']==0) and ($filaEval['radio']!="")){
															echo "<td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;No</font></td>";	
														}else if($filaEval['radio']==1){
															echo "<td><font size=2 face=Arial, Helvetica, sans-serif>&nbsp;&nbsp;Si</font></td>";
														}
												}
											
									}//fin for($countItem....
							}//fin for($countSubarea....
							
					}//fin for($countArea....
			}//fin if($creada==1)
			
		  ?>
          <input name="plantilla" type="hidden" value="<?php echo $filaPlantilla['id_plantilla']?>">
          <input name="alumno" type="hidden" value="<?php echo $alumno?>">
        </table>
        <table width="100%" border="0">
          <tr> 
            <td>&nbsp;</td>
          </tr>
        </table>
		
		<?
		if ($periodo != ""){ ?>
           <table width="100%" border="0" cellpadding="0" cellspacing="0">
             <tr> 
               <td class="tablatit2-1">Observaciones:</td>
             </tr>
           </table>
    <?  } ?>	   

        <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr> 
            <td ><font size="2" face="Arial, Helvetica, sans-serif"> 
              <?php if($creada!=1){
		  			if($txtO!=""){
						echo "<TEXTAREA NAME=txtObs ROWS=20 COLS=60>";
						print trim($txtO);
//						echo trim($txtO);
						echo "</TEXTAREA>";
					}elseif ($filaPlantilla){
					        if ($periodo!=""){
            			      echo "<TEXTAREA NAME=txtObs ROWS=20 COLS=60></TEXTAREA>";
					        }
					}
				}elseif ($creada==1){;
					$sqlTraeObs="select * from informe_observaciones where id_periodo=".$periodo." and id_ano=".$ano." and id_plantilla=".$filaPlantilla['id_plantilla']." and rut_alumno='".$alumno."'";
					$resultObs=@pg_Exec($conn, $sqlTraeObs);
					$filaObs=@pg_fetch_array($resultObs,0);
					echo nl2br (trim($filaObs['glosa']));
					//echo "<input type=\"hidden\" name=\"txtO\" value=".$filaObs['glosa'].">";
					echo "<input type=\"hidden\" name=\"txtO\" value=\"".trim($filaObs['glosa'])."\">";
				}
			?>
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
              <?php //echo getdate() ?>
              <input type="hidden" name="fecha">
              <input type="hidden" name="tipoEns" value="<?php echo $tipoEns ?>">
              <input type="hidden" name="grado" value="<?php echo $grado ?>">
              <?php 

			$flag=0;
			for($i=1;$i<$countI;$i++){
				if($cmbConcepto[$i]!=""){
					$flag=1;
				}
			}


			if($creada!=1){//creando por 1ra vez
				$modificar=0;
			}

/*			if(($creada==0) and ($cmbConcepto[1]!="")){
				echo $creada." ".$cmbConcepto[1];
				$modificar=1;
			}
*/
			if(($creada==0) and $flag==1){
				echo $creada." ".$cmbConcepto[1];
				$modificar=1;
			}



			if(($creada==0) and ($txtO!=NULL)){
				$modificar=1;
			}

			?>
              <input type="hidden" name="modificar" value="<?php echo $modificar ?>">
              </font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr> 
            <td width="45%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
              <?php // echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?>
              &nbsp;</strong></font></td>
            <td width="55%" align="center"><font size="1" face="Arial, Helvetica, sans-serif"><strong>
              <?php //echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_pat']?>
              &nbsp;</strong></font></td>
          </tr>
        </table>
        <table width="100%" border="0">
          <tr align="center"> 
            <td width="45%">&nbsp;</td>
            <td width="55%">&nbsp;</td>
          </tr>
        </table> 
        <table width="100%" border="0">
          <tr> 
            <td align="center"></td>
          </tr>
        </table>
        <table width="100%">
          <!--tr> 
          <td align="center" bgcolor="#003B85"><strong><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif">ESCALA 
            DE EVALUACI&Oacute;N / AREAS DE DESARROLLO</font></strong></td>
        </tr-->
          <tr> </tr>
        </table>
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

								  
								  
								  <!-- fin codigo nuevo -->
								  
								   </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
<? pg_close($conn);?>