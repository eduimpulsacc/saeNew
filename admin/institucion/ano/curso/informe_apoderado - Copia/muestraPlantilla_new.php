<?php 
require('../../../../../util/header.inc');
//$plantilla	=$_PLANTILLA;
    if ($ano){
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
	  	};
	}
	if ($curso){
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
	  	};
	}
	
$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso			=$_CURSO;
$_POSP       = 5;
$_bot        = 5;
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

	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$_CURSO;
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso,0);
	   
	$tipoEns=$filaCurso['ensenanza'];


    $sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$tipoEns." AND ".$gr."=1 and activa=1 AND rdb=".$institucion." order by id_plantilla Asc";
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla,0);	
	$numerodeplantillas = @pg_numrows($resultPlantilla);	
	$id_plantilla = $filaPlantilla['id_plantilla'];	
	
		

	
//imprime_array($filaPlantilla);
	if ($filaPlantilla[nuevo_sis]==1){
//echo "hioola";

      
      /* ?>
	   <script>
		window.location="muestraPlantilla_new.php?alumno=<? echo $alumno;?>&creada=1&grado=<? echo $grado;?>";
	   </script>
	   
	   <? 
	    exit(); */	  
	
	}else{
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
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
$ii = 1;

	
?>
<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.periodo.value!=0){
		form.periodo.target="self";
		
		form.action = 'muestraPlantilla_new.php?periodo='+form.periodo.value+'&creada=1&grado=<? echo $grado;?>&alumno=<?php echo trim($alumno);?>';
		form.submit(true);

		}	
	}	
	
function enviapag3(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
						
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="muestraPlantilla_new.php?caso=10&curso="+curso2+'&creada=1&grado=<? echo $grado;?>&periodo='+form.periodo.value+'grado=<? echo $grado; ?>';
				form.action = pag;
				form.submit(true);	
			}		
		 }		
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
    <td height="30" align="center" valign="top"> 
      <? include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<?php } ?>


<form action="proceso_informe_new.php" method="post">
   <table width="100%">	  
      <tr>
		<td width="11%" align=left><font face="arial, geneva, helvetica" size=1>&nbsp; &nbsp; CURSO </font> </td>
		<td width="0%"><font face="arial, geneva, helvetica" size=2> : </font> </td>
		  
		<td  valign="bottom" width="89%"><font face="arial, geneva, helvetica" size=2> 
			 <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
             <? 
			$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
			$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
			$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso ";
			$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
			$resultado_query_cue = pg_exec($conn,$sql_curso);
            ?>
			<!--<select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
			  <option value="0" selected>(Seleccione un Curso)</option> -->
			  <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		             echo $Curso_pal;
		        }else{	    
		             //echo "<option value=".$fila['id_curso'].">bbb".$Curso_pal."</option>";
                }
		     } ?>
			<!-- </select>  -->
						
			 </font> </td>
	  </tr>      
    </table>


  <table width="100%" border="0" align="center">
    <tr> 
      <td>
	   <table width="100%">	  
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
              <?
			  if (($periodo!=0) OR ($periodo!=NULL)){  ?>			  
			       <input class="botonXX"  type="submit" name="Submit" value="GUARDAR">
             <? } ?>
			 
			  <?php if($creada==1){?>
               <!--  <input class="botonXX"  type="submit" name="Submit3" value="MODIFICAR">  -->
              <?php } ?>
              <input class="botonXX"  type="button" name="Submit2" value="VOLVER" onClick="window.location='listarAlumnos.php'">
              </font>
			 </td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
          <tr align="center" class="tableindex"> 
            <td colspan="4">INFORME DE PERSONALIDAD POR CURSO</td>
          </tr>
          <tr> 
            <td colspan="4">&nbsp;</td>
          </tr>
        </table>
        
	<!--	<table width="100%" border="0">
          <tr> 
            <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Alumno</font></td>
            <td width="42%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
            <td width="5%"><font size="2" face="Arial, Helvetica, sans-serif">RUT</font></td>
            <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
          </tr>
        </table>  -->
		
      <!--  <table width="100%" border="0">
          <tr> 
            <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Curso</font></td>
            <td width="83%"><font size="2" face="Arial, Helvetica, sans-serif">: 
              <?php echo $filaCurso['grado_curso']. "-".$filaCurso['letra_curso']."     ".$filaEns['nombre_tipo'] ?></font></td>
          </tr>
        </table>   -->
        <?php if($tipoEns>310){?>
        <!--  <table width="100%" border="0">
          <tr> 
            <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
            <td width="83%">: <font size="2" face="Arial, Helvetica, sans-serif">
              <?php  $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaCurso['cod_es']." and cod_sector=".$filaCurso['cod_sector']." and cod_rama=".$filaCurso['cod_rama'];
								$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
								$filaEsp=@pg_fetch_array($resultEsp,0);
								echo $filaEsp['nombre_esp'];
								echo $modificar;?>
              </font></td>
          </tr>
        </table>  -->	
		
        <?php } ?>
      <!--  <table width="100%" border="0">
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
        </table>  -->
		
		<?
		if (($periodo!=NULL) OR ($periodo!=0)){  ?>
		
		 <table width="100%" border="2" cellpadding="0" cellspacing="0">
          <tr> 
            <td width="100%">&nbsp;	
		<!-- Aqui nuevo codigo -->
        <table width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
         <tr class="tablatit2-1">
            <td width="20%">&nbsp;&nbsp;ALUMNO&nbsp;&nbsp; </td>
            <td width="80%" valign="top">			
			    <div id="contEncCol">
                  <table width="100%" border="1" cellspacing="0" cellpadding="0">
                  <tr>			       
					<?
				    $sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				    $resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
				    $sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					$variable = @pg_numrows($resultTraeArea);
					
									
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						$id_area = $filaTraeArea['id_area'];
						
						$sqsubarea = "select * from informe_subarea where id_area = '$id_area'";
						$rssubarea = pg_Exec($conn,$sqsubarea);
						
						for ($consubarea=0; $consubarea<@pg_numrows($rssubarea); $consubarea++){
						     $filasubarea = @pg_fetch_array($rssubarea,$consubarea);
							 $id_subarea = $filasubarea['id_subarea'];
							 
							 $sqitem = "select * from informe_item where id_subarea = '$id_subarea'";
							 $rsitem = pg_Exec($conn,$sqitem);
							 
							 for ($conitem = 0; $conitem<@pg_numrows($rsitem); $conitem++){
							     $filaitem = @pg_fetch_array($rsitem,$conitem);
								 $id_item = $filaitem['id_item'];
								 $tipo    = $filaitem['tipo'];
																
								 ?>				  
				  
                                  <td width="50" align="center">&nbsp;<?=$conitem + 1 ?></td>
								  
								 <?
							 
							}						 
						}						
							
					}//fin for($countArea....			
				  ?> 			   
                  </tr>
                </table>
                </div>			
		   </td>
          </tr>
          <tr>
            <td width="300" valign="top" valing=top>
			<div id="contEncFil">
			    <?
				$q1 = "select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '".trim($_ANO)."' and id_curso = '".trim($_CURSO)."') order by ape_pat";
			    $r1 = pg_Exec($conn,$q1);
				$n1 = pg_numrows($r1);
				
				$i = 0;
				while ($i < $n1){ 
				    $f1 = pg_fetch_array($r1,$i);
				    $nombre = $f1['ape_pat'];
					$nombre.= $f1['ape_mat'];
					$nombre.= $f1['nombre_alu'];
					
					
					?>
					<table width="100%" border="1" height="60">
					  <tr>
					  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?=$nombre ?> </font></td></tr>
					</table>	
					<?					
						
					$i++;
				}
				?>	
            </div>
			</td>
            <td valign="top"><div id="contenedor" onscroll="desplaza()">
              <table width="100%" border="1" cellspacing="0" cellpadding="0">
                <tr>
                  <td>
				  <!-- AQUI DESPLIEGO EL INFORME HACIA EL LADO -->
				 
				<?
							
				$q1 = "select * from alumno where rut_alumno in (select rut_alumno from matricula where rdb = '".trim($_INSTIT)."' and id_ano = '".trim($_ANO)."' and id_curso = '".trim($_CURSO)."') order by ape_pat";
			    $r1 = pg_Exec($conn,$q1);
				$n1 = pg_numrows($r1);
				
				
				$i = 0;
				while ($i < $n1){ 
				    $f1 = pg_fetch_array($r1,$i);
				    $nombre = $f1['ape_pat'];
					$nombre.= $f1['ape_mat'];
					$nombre.= $f1['nombre_alu'];
					$rut_alumno = $f1['rut_alumno'];					
					?>			  
				    <table border="0" bordercolor="#990000" height="60" width="100%">
				    <tr>			  
				    <?
				    $sqlTraeConcepto="SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
				    $resultTraeConcepto=@pg_Exec($conn, $sqlTraeConcepto);
					//trae areas
//echo				    $sqlTraeArea="SELECT * FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
echo				    $sqlTraeArea="SELECT * FROM informe_area WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
					$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);
					$variable = @pg_numrows($resultTraeArea);
					
									
					for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){
						$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);
						$id_area = $filaTraeArea['id_area'];
						
						$sqsubarea = "select * from informe_subarea where id_area = ".$id_area."";
						$rssubarea = pg_Exec($conn,$sqsubarea);
						
						for ($consubarea=0; $consubarea<@pg_numrows($rssubarea); $consubarea++){
						     $filasubarea = @pg_fetch_array($rssubarea,$consubarea);
							 $id_subarea = $filasubarea['id_subarea'];
							 
							 $sqitem = "select * from informe_item where id_subarea = '$id_subarea'";
							 $rsitem = pg_Exec($conn,$sqitem);
							 
							 for ($conitem = 0; $conitem<@pg_numrows($rsitem); $conitem++){
							     $filaitem = @pg_fetch_array($rsitem,$conitem);
								 $id_item = $filaitem['id_item'];
								 $tipo    = $filaitem['tipo'];
																
								 ?>
								 <td width="50" align="center">
								 <select name="sigla<?=$ii ?>">
								    <?
								   if ($tipo==0){
								     // busco sus opciones de sigle
									 $sqsigla = "SELECT * FROM informe_concepto_eval where id_plantilla=".$filaPlantilla['id_plantilla'];
									 $rssigla = pg_Exec($conn,$sqsigla);
																	 
									 for ($consigla=0; $consigla<@pg_numrows($rssigla); $consigla++){
									     $filasigla = @pg_fetch_array($rssigla,$consigla);
										 $concepto  = $filasigla['id_concepto'];
										 $sig       = $filasigla['sigla'];
																 
										 
										 // acá debo buscar si esta seleccionado
									     $q100 = "select * from informe_evaluacion where id_item = '".trim($id_item)."' and id_periodo = '".trim($periodo)."' and id_ano = '".trim($_ANO)."' and rut_alumno = '".trim($rut_alumno)."' and id_concepto = '".trim($concepto)."' and id_plantilla = ".$filaPlantilla['id_plantilla'];
										 $r100 = pg_Exec($conn,$q100);
										 $n100 = pg_numrows($r100);
										 
																		 
										 if ($n100==0){										  										   						 
											 ?>
											 <option value="<?=$concepto ?>"><?=$sig ?></option>
											 <?
										 }else{
										     ?>
											 <option value="<?=$concepto ?>" selected="selected"><?=$sig ?></option>
											 <?
										 }	 
									 }	 
								 }
								 $ii++;
								 		 
								 ?>
								</select> 
								 </td>
							     <?
							 
							 }						 
						}						
							
					}//fin for($countArea....
			
				  ?>
				  </tr>
				  </table>			 
				 <?
					$i++;
				}
				?>			  
				  <!-- FIN DEL INFORME HACIA EL LADO -->
				  
				  </td>
                  </tr>
              </table>
            </div></td>
          
          </tr>
        </table>
      <!-- fin codigo -->		
			
			
			</td>
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
								    $sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
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
								$sqlTraeItem="SELECT * FROM informe_item WHERE id_subarea=".$filaTraeSubarea['id_subarea'];
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
										
										$alumno="999999999";  // para que no muestre nada por alumno
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
		
		<? } ?>
		
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
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
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
