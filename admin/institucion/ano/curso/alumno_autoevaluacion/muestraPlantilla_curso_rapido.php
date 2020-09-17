<?php 
require('../../../../../util/header.inc');	

	$institucion =$_INSTIT;
	$ano		 =$_ANO;
	$curso		 =$_CURSO;
	$_POSP       = 5;
	$_bot        = 5;

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
	$filaCurso=@pg_fetch_array($resultCurso);
	if($tipoEns==""){
		$tipoEns=$filaCurso['ensenanza'];
	}

	$sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$tipoEns." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);

	/* Si el informe no esta creado en el nuevo sistema se va a buscar en las tablas del antiguo sistema*/
	if (trim($filaPlantilla[nuevo_sis])!=1){	?>
		<script>
			window.location="muestraPlantilla_curso2.php?tipoEns=<? echo trim($tipoEns);?>&grado=<? echo $grado;?>&cmb_curso=<? echo $curso;?>";
		</script>
<? 	}	

	$sqlTraeAlumno="SELECT alumno.rut, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat WHERE rut_alumno=".$alumno;
	$resultAlumno=@pg_Exec($conn, $sqlTraeAlumno);
	$filaAlumno=@pg_fetch_array($resultAlumno);
	
	
	$sqlEns="select * from tipo_ensenanza where cod_tipo=".$tipoEns;
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlInstit="select  institucion.rbd, institucion.nombre_instit where institucion.rdb=".$institucion;
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


	$sql_concepto = "SELECT nombre,id_concepto FROM informe_concepto_eval WHERE id_plantilla=".$filaPlantilla['id_plantilla'];
	$resultConcepto = @pg_Exec($conn, $sql_concepto);		
?>

<SCRIPT language="JavaScript">
	function enviapag(form){
		if (form.cmb_periodo.value!=0){
			form.action = 'muestraPlantilla_curso_rapido.php?periodo='+form.cmb_periodo.value+'&creada=1&modificar=1&grado=<? echo $grado;?>&curso=<? echo $curso;?>';
			form.submit(true);
		}	
	}
</SCRIPT>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
   <tr>
      <td height="589" align="left" valign="top">
	     <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  		    <tr>
			   <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
			   <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
				  <? include("../../../../../cabecera/menu_superior.php"); ?>
			   </td>
		    </tr>
		    <tr align="left" valign="top"> 
			   <td height="83" colspan="3">
			      <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                     <tr> 
                        <td width="27%" height="363" align="left" valign="top"> 
                           <? $menu_lateral="3_1"; ?><? include("../../../../../menus/menu_lateral.php"); ?></td>
                        <td width="73%" align="left" valign="top">
						   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                              <tr> 
                                 <td align="left" valign="top">&nbsp;</td>
                              </tr>
                              <tr> 
                                 <td height="395" align="left" valign="top"> 
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                       <tr> 
                                          <td height="390">
										  <!-- inicio codigo nuevo -->


   <form action="proceso_informe_curso.php" method="post">

				<font size="1" face="Arial, Helvetica, sans-serif">PERIODO</font>
				<font size="2" face="Arial, Helvetica, sans-serif"> :
				
			<?	$sqlPeriodo="select * from periodo where id_ano=".$ano." order by nombre_periodo";
				$resultPeriodo=@pg_Exec($conn, $sqlPeriodo);				?>
				<select name="cmb_periodo" onChange="enviapag(this.form);">
				<!--<select name="cmb_periodo">-->
					<option value="0">Seleccione Periodo</option>
				<?	for($countPer=0 ; $countPer<@pg_numrows($resultPeriodo) ; $countPer++){
						$filaPeriodo=@pg_fetch_array($resultPeriodo, $countPer);
						if($filaPeriodo['id_periodo']==$periodo){
							echo "<option selected value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
						}else{
							echo "<option value=".$filaPeriodo['id_periodo'].">".$filaPeriodo['nombre_periodo']."</option>";
						}
					}
					?>
				</select>
				</font>
<? if (($creada==1)&&($modificar==1)&&($periodo!=0)){   	?>
	   <input class="botonXX"  type="button" name="modificar" value="MODIFICAR" onClick="window.location='muestraPlantilla_curso_rapido.php?periodo=<? echo $periodo;?>&plantilla=<? echo $filaPlantilla['id_plantilla'];?>&creada=1&modificar=0&grado=<? echo $grado;?>&curso=<? echo $curso;?>'">
	   <input class="botonXX"  type="button" name="cancelar" value="CANCELAR" onClick="window.location='listarAlumnos.php?ano=<? echo $ano;?>&curso=<? echo $curso;?>'">
<?	}	?>

<? if (($creada==1)&&($modificar==0)&&($periodo!=0)){   	?>
	   <input class="botonXX"  type="submit" name="guardar" value="GUARDAR">
	   <input class="botonXX"  type="button" name="cancelar" value="CANCELAR" onClick="window.location='listarAlumnos.php?ano=<? echo $ano;?>&curso=<? echo $curso;?>'">
<?	}	?>

   <input type="hidden" name="grado" value="<? echo $grado;?>">			 
   <table width="900" border="0" align="center" class="tabla02">	  
      <tr>
		<td width="25" valign="bottom"><font face="arial, geneva, helvetica" size=2>&nbsp; &nbsp; CURSO </font> </td>
		<td width="10" valign="bottom"><font face="arial, geneva, helvetica" size=2> : </font> </td>
		  
		<td width="200" valign="bottom" ><font face="arial, geneva, helvetica" size=2> 
			 <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
             <? 
			$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
			$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
			$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso ";
			$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
			$resultado_query_cue = pg_exec($conn,$sql_curso);
	        for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
	        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		             echo $Curso_pal;
		        }
		    } ?>
			 </font> 
		</td>
	  </tr>      
    </table>
	
	<table width="900" border="0" align="center" class="tabla02">
		  <tr class="tablatit2-1">
			 <td width="150">&nbsp;&nbsp;AREA&nbsp;&nbsp; </td>
<?				$sqlTraeArea = "SELECT  informe_area_item.id, informe_area_item.id_plantilla, informe_area_item.id_padre, informe_area_item.glosa, informe_area_item.con_concepto WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND id_padre=0 ORDER BY id_padre";
				$resultTraeArea=@pg_Exec($conn, $sqlTraeArea);	
				for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){	
					$Total = 0;
					$filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);	
				
					$sql_Tot_SubArea = "SELECT * FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto IS NULL AND id_padre=".$filaTraeArea['id'];
					$resultTotSubArea=@pg_Exec($conn, $sql_Tot_SubArea);	

					for($i=0;$i<@pg_numrows($resultTotSubArea);$i++){
						$Tot_SubArea = @pg_fetch_array($resultTotSubArea, $i);								
						$sql_Tot_ItemT = "SELECT count(*) FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto=1 AND id_padre=".$Tot_SubArea['id'];
						$resultTotItemT = @pg_Exec($conn, $sql_Tot_ItemT);
						$fila_total = @pg_fetch_array($resultTotItemT,0);
						$Sub_item = $fila_total[0];	
						$Total = $Total + $Sub_item;
					}	?>
				<td colspan="<? echo $Total;?>"><center><? echo $filaTraeArea['glosa'];?></center></td>
<?				}	?>			  
		  </tr>
		  <tr class="tablatit2-1">
			 <td width="150">&nbsp;&nbsp;SUBAREA&nbsp;&nbsp; </td>
		      	<input type="hidden" name="plantilla" value="<? echo $filaPlantilla['id_plantilla'];?>">			 
<?				$sqlTraeSubArea="SELECT id,glosa FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto IS NULL AND id_padre<>0 ORDER BY id_padre";
				$resultTraeSubArea=@pg_Exec($conn, $sqlTraeSubArea);	
				for($countSubArea=0 ; $countSubArea<@pg_numrows($resultTraeSubArea) ; $countSubArea++){	
					$filaTraeSubArea=@pg_fetch_array($resultTraeSubArea, $countSubArea);	

					$sql_Tot_Item = "SELECT count(*) FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto=1 AND id_padre=".$filaTraeSubArea['id'];
					$resultTotItem=@pg_Exec($conn, $sql_Tot_Item);	
					$Tot_Item = @pg_fetch_array($resultTotItem,0);		
					?>
					<td colspan="<? echo $Tot_Item[0];?>"><center><? echo $filaTraeSubArea['glosa'];?></center></td>
<?				}	?>			  
		  </tr>		
		  <tr class="tablatit2-1">
			 <td width="150">&nbsp;&nbsp;ALUMNO / ITEM&nbsp;&nbsp; </td>
<?				$sqlTraeAreaItem="SELECT id,glosa FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto=1 ORDER BY id_padre,id";
				$resultTraeAreaItem=@pg_Exec($conn, $sqlTraeAreaItem);
				for($countAreaItem=0 ; $countAreaItem<@pg_numrows($resultTraeAreaItem) ; $countAreaItem++){	
					$filaTraeAreaItem=@pg_fetch_array($resultTraeAreaItem, $countAreaItem);	?>
					<td><? echo $filaTraeAreaItem['glosa'];?></td>
<?				}
				$Total_Item = $countAreaItem;	?>			  
		  </tr>
		  
		  
		  
<? 			$sql_Alumno = "SELECT * FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE m.rdb=".trim($institucion)." AND m.id_ano=".trim($ano)." AND m.id_curso=".trim($_CURSO)." AND m.bool_ar=0 ORDER BY m.nro_lista, a.ape_pat";
			$resultAlumno = @pg_Exec($conn, $sql_Alumno);				?>


			<? 	if($modificar==0 && ($periodo!=NULL || $periodo!='')){		?>
		  
			
			
			
			<?	}	// fin if(modificar==0)	
											 
											 
											 
											 
			else if($modificar==1 && ($periodo!=NULL || $periodo!='')){	?>
		  
		<?	}		// fin if(modificar==1)	?>			  


	      	<input type="hidden" name="cont_alum" value="<? echo $j;?>">
	</table>
	</form>
	

										  
										  <!-- fin codigo nuevo -->
									      </td>
                                       </tr>
                                    </table>
								 </td>
                              </tr>
                           </table>
                         </td>
                       </tr>
                       <tr align="center" valign="middle"> 
                          <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                       </tr>
                    </table>
				 </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	</td>
  </tr>
</table>
</body>
</html>
