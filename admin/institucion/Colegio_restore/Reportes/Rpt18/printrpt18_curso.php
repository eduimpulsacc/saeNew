<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.displlay='block';
}
</script>

<?
require('../../../../../util/header.inc');
//include"../Coneccion/conexion.php";
$ano		= $_ANO;
//$conn		= $conexion;
$curso		= $cmb_curso;
$periodo    = $cmb_periodos;
$institucion= $_INSTIT;
$_POSP = 5;
$_bot = 8;



if(!empty($curso)){
	//echo "$cmb_curso<br>";
	
	$qry_temp="SELECT * from curso where id_curso = $curso ";
	$result_temp =@pg_Exec($conn,$qry_temp);
	$fila_temp=@pg_fetch_array($result_temp);

	
	$id_curso = $fila_temp['id_curso'];
	$grado_curso= $fila_temp['grado_curso'];
	$ensenanza= $fila_temp['ensenanza'];
	
	if($grado_curso==1) $gr="pa";
	if($grado_curso==2) $gr="sa";
	if($grado_curso==3) $gr="ta";
	if($grado_curso==4) $gr="cu";
	if($grado_curso==5) $gr="qu";
	if($grado_curso==6) $gr="sx";
	if($grado_curso==7) $gr="sp";
	if($grado_curso==8) $gr="oc";
	if($grado_curso==9) $gr="nv";
	if($grado_curso==10) $gr="dc";
	if($grado_curso==11) $gr="un";
	if($grado_curso==12) $gr="duo";
	if($grado_curso==13) $gr="tre";
	if($grado_curso==14) $gr="cat";
	if($grado_curso==15) $gr="quince";
	if($grado_curso==16) $gr="diezseis";
	if($grado_curso==17) $gr="diecisiete";
	if($grado_curso==18) $gr="dieciocho";
	if($grado_curso==19) $gr="diecinueve";
	if($grado_curso==20) $gr="veinte";
	if($grado_curso==21) $gr="veintiuno";
	if($grado_curso==22) $gr="veintidos";
	if($grado_curso==23) $gr="veintitres";
	if($grado_curso==24) $gr="veinticuatro";
	if($grado_curso==25) $gr="veinticinco";
	if($grado_curso==31) $gr="treintauno";
	if($grado_curso==32) $gr="treintados";	
	
	
	$sqlTraePlantilla="SELECT informe_plantilla.titulo_informe1, informe_plantilla.nuevo_sis, informe_plantilla.id_plantilla FROM informe_plantilla WHERE tipo_ensenanza=".$ensenanza." AND ".$gr."=1 and activa=1 AND rdb=".$institucion;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);	
	$nuevo = $filaPlantilla['nuevo_sis'];
		
}


	$qryDIR="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultDIR =@pg_Exec($conn,$qryDIR);
	$filaDIR=@pg_fetch_array($resultDIR);
	
	$qryORI="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=11)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultORI =@pg_Exec($conn,$qryORI);
	$filaORI=@pg_fetch_array($resultORI);

	//$sqlPeriodo="select nombre_periodo from periodo where id_ano=".$filaAno['id_ano']." order by nombre_periodo asc";
	$sqlPeriodo="select nombre_periodo, id_periodo from periodo where id_ano=".$ano." order by nombre_periodo asc";
	$resultPeriodo=@pg_exec($conn, $sqlPeriodo);

	
	$sqlInstit="select * from institucion where rdb=".$institucion;
	$resultInstit=@pg_Exec($conn, $sqlInstit);
	$filaInstit=@pg_fetch_array($resultInstit);
	
	
	$qryEmp="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
    $resultEmp =@pg_Exec($conn,$qryEmp);
	$filaEmp=@pg_fetch_array($resultEmp);
	
	$sql_peri = "select * from periodo where id_periodo = '$periodo' order by id_periodo";
	$res_peri = @pg_Exec($conn,$sql_peri);
	
	for($countP=0 ; $countP<@pg_numrows($res_peri); $countP++){
	    $filaPeriodo=@pg_fetch_array($res_peri, $countP);
	    $id_peri[$countP] = $filaPeriodo['id_periodo'];
	}
	
	
	$sqlTraeCurso="SELECT curso.grado_curso, curso.letra_curso FROM curso WHERE id_curso=".$curso;
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	
	$sqlEns="select tipo_ensenanza.nombre_tipo from tipo_ensenanza where cod_tipo=".$filaCurso['ensenanza'];
	$resultEns=@pg_Exec($conn, $sqlEns);
	$filaEns=@pg_fetch_array($resultEns);
	
	$sqlProfe="select empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from supervisa inner join empleado on supervisa.rut_emp=empleado.rut_emp where supervisa.id_curso=".$curso;
	$resultProfe=@pg_Exec($conn, $sqlProfe);
	$filaProfe=@pg_fetch_array($resultProfe);





if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_educacional_curso_$fecha_actual.xls"); 	 
}	 

?>	
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<SCRIPT language="JavaScript">
<!--
function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'printrpt18_curso.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
		
		function exportar(){
			window.location='printrpt18_curso.php?cmb_curso=<?=$curso?>&cmb_periodos=<?=$periodo?>&xls=1';
			return false;
		  }
			
			
//-->
</script>

<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg','../../botones/periodo_roll.gif','../../botones/feriados_roll.gif','../../botones/planes_roll.gif','../../botones/tipos_roll.gif','../../botones/cursos_roll.gif','../../botones/matricula_roll.gif','../../botones/informe_roll.gif','../../botones/actas_roll.gif','../../botones/generar_roll.gif')">
			  
						  
<? if($curso > 0 and $periodo > 0){ ?> 						  
						  
						<div id="capa0">   
						<table width="700" border="0" align="center" cellpadding="0" cellspacing="0">
						  <tr> 
							<td>
							 <input name="cmdimprimiroriginal" type="button" class="botonXX" id="cmdimprimiroriginal" onClick="imprimir()" 	value="Imprimir">
						<? if($_PERFIL==0 or $_PERFIL==14){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="Exportar">
			<? }?>	 
						    </td>
						  </tr>
						</table>
						</div>
						  <br>
						  
						  <table width="700" border="0" align="center" cellpadding="0" cellspacing="4">
                            <tr>
                              <td width="17%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Institucion : </b></font></td>
                              <td width="83%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><? echo $filaInstit['nombre_instit']; ?></font></td>
                            </tr>
                            <tr>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>Curso : </b></font></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><?php echo $filaCurso['grado_curso']. " - ".$filaCurso['letra_curso']."  ".$filaEns['nombre_tipo'] ?></font></td>
                            </tr>
                            <tr>
                              <td><span class="Estilo1"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Profesor Jefe</font> : </span></td>
                              <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></td>
                            </tr>
</table></td>
                        </tr>
                        <tr>
                          <td valign="top"><!-- tabla que contine todo -->
                              <br>
                         
						 <table width="700" border="1" align="center" cellpadding="2" cellspacing="0" >
		                 
						 <?
						 
					 if ($_INSTIT!=1517){ // informe sin TRES etapas solo tiene DOS  ?>
						  <tr >
		                    <td width="100" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">AREA</font></td>
                           <?
						 
						  $sqlTraeArea = "SELECT  informe_area_item.id, informe_area_item.id_plantilla, informe_area_item.id_padre, informe_area_item.glosa, informe_area_item.con_concepto from informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND id_padre=0 ORDER BY id";
				          $resultTraeArea=@pg_Exec($conn, $sqlTraeArea);	
				          for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){	
					          $Total = 0;
					          $filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);	
				
					          $sql_Tot_SubArea = "SELECT * FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto IS NULL AND id_padre=".$filaTraeArea['id']." ORDER BY id";
					          $resultTotSubArea=@pg_Exec($conn, $sql_Tot_SubArea);	

					          for($i=0;$i<@pg_numrows($resultTotSubArea);$i++){
						          $Tot_SubArea = @pg_fetch_array($resultTotSubArea, $i);								
						          $sql_Tot_ItemT = "SELECT count(*) FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto=1 AND id_padre=".$Tot_SubArea['id'];
						          $resultTotItemT = @pg_Exec($conn, $sql_Tot_ItemT);
						          $fila_total = @pg_fetch_array($resultTotItemT,0);
						          $Sub_item = $fila_total[0];	
						          $Total = $Total + $Sub_item;
					          }	?>
		                    <td colspan="<? echo $Total;?>" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $filaTraeArea['glosa'];?></font></td>
  <?				         } ?>			  
	                       </tr>
					<? } ?>
						   
						   
						  <?
						  if ($_INSTIT!=1517){ // muestro las sub-categorias, sino voy a mostrar recien las categorias  ?> 
								  <tr >
									<td width="100" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">SUBAREA</font></td>
								   
	<?				           $sqlTraeSubArea="SELECT id,glosa FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto IS NULL AND id_padre<>0 ORDER BY id";
							   $resultTraeSubArea=@pg_Exec($conn, $sqlTraeSubArea);	
							   for($countSubArea=0 ; $countSubArea<@pg_numrows($resultTraeSubArea) ; $countSubArea++){	
								   $filaTraeSubArea=@pg_fetch_array($resultTraeSubArea, $countSubArea);	
	
								   $sql_Tot_Item = "SELECT count(*) FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto=1 AND id_padre=".$filaTraeSubArea['id'];
								   $resultTotItem=@pg_Exec($conn, $sql_Tot_Item);	
								   $Tot_Item = @pg_fetch_array($resultTotItem,0);		
								   ?>
									<td colspan="<? echo $Tot_Item[0];?>" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $filaTraeSubArea['glosa'];?></font></td>
							  <? }?>			  
							   </tr>
						<? }else{  ?>
						       <tr >
								<td width="100" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">AREA</font></td>
							   <?
							 
							  $sqlTraeArea = "SELECT  informe_area_item.id, informe_area_item.id_plantilla, informe_area_item.id_padre, informe_area_item.glosa, informe_area_item.con_concepto from informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND id_padre=0 ORDER BY id";
							  $resultTraeArea=@pg_Exec($conn, $sqlTraeArea);	
							  for($countArea=0 ; $countArea<@pg_numrows($resultTraeArea) ; $countArea++){	
								  $Total = 0;
								  $filaTraeArea=@pg_fetch_array($resultTraeArea, $countArea);	
					
								  $sql_Tot_SubArea = "SELECT * FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto = '1' AND id_padre=".$filaTraeArea['id'];
								  $resultTotSubArea=@pg_Exec($conn, $sql_Tot_SubArea);	
								  
								  $Total = @pg_numrows($resultTotSubArea);							 
								  
								  ?>
								<td colspan="<? echo $Total;?>" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $filaTraeArea['glosa'];?></font></td>
	  <?				         } ?>			  
							   </tr>						
						
						<? } ?>	                    
						  
						  
						  
						  <tr >
                              <td width="100" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">ALUMNO / ITEM</font></td>
                           <?	$sqlTraeAreaItem="SELECT id,glosa FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto=1 ORDER BY id_padre,id";
				         $resultTraeAreaItem=@pg_Exec($conn, $sqlTraeAreaItem);
				         for($countAreaItem=0 ; $countAreaItem<@pg_numrows($resultTraeAreaItem) ; $countAreaItem++){	
					            $filaTraeAreaItem=@pg_fetch_array($resultTraeAreaItem, $countAreaItem);
							 	$nro_glosa = substr($filaTraeAreaItem['glosa'],0,2);
								?>
                                <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? //$nro_glosa;  ?> 
								<?php 
								if($filaPlantilla['id_plantilla']==1604 && $filaTraeAreaItem['id']==82573){echo "a.";}
								elseif($filaPlantilla['id_plantilla']==1604 && $filaTraeAreaItem['id']==82574){echo "b.";}
								elseif($filaPlantilla['id_plantilla']==1604 && $filaTraeAreaItem['id']==82575){echo "c.";}
								elseif($filaPlantilla['id_plantilla']==1604 && $filaTraeAreaItem['id']==82576){echo "d.";}
								elseif($filaPlantilla['id_plantilla']==1604 && $filaTraeAreaItem['id']==82577){echo "e.";}
								
								elseif($filaPlantilla['id_plantilla']==1605 && $filaTraeAreaItem['id']==82614){echo "a.";}
								elseif($filaPlantilla['id_plantilla']==1605 && $filaTraeAreaItem['id']==82615){echo "b.";}
								elseif($filaPlantilla['id_plantilla']==1605 && $filaTraeAreaItem['id']==82616){echo "c.";}
								elseif($filaPlantilla['id_plantilla']==1605 && $filaTraeAreaItem['id']==82617){echo "d.";}
								elseif($filaPlantilla['id_plantilla']==1605 && $filaTraeAreaItem['id']==82618){echo "e.";}
								
								else{echo $countAreaItem+1;} ?></font></td>
                         <? }
					   	$Total_Item = $countAreaItem;	?>			  
                         </tr>
						   
						   
						   
						   
						   
                         <?					  
					   $sql_Alumno = "SELECT * FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE m.rdb=".trim($institucion)." AND m.id_ano=".trim($ano)." AND m.id_curso=".trim($cmb_curso)." AND m.bool_ar=0 ORDER BY m.nro_lista, a.ape_pat";
			           $resultAlumno = @pg_Exec($conn, $sql_Alumno); ?>	 
						 
						 
						  <tr>			
                                <? for($j=0 ; $j<@pg_numrows($resultAlumno) ; $j++){	
					      $filaAlum=@pg_fetch_array($resultAlumno, $j);	?>
                                <td width="100" align="left"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $filaAlum['ape_pat']." ".$filaAlum['ape_mat']." ".$filaAlum['nombre_alu'];?></font></td>
			      	        
                          <?
						  
						  /// esto hacer leyendo el archivo
						  $nombre = $_ANO."-".$id_peri['0']."-".$filaAlum['rut_alumno']."-".$filaPlantilla['id_plantilla'];
						  
						  //echo "nombre: $nombre <br>";
						 /* if (file_exists("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt")) {
							  $archivo=fopen("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt" , "r");
							  
							  if ($archivo) {
								  $linea=1;
								  while (!feof($archivo)) {
									  $cadena = fgets($archivo, 500);
									  									  
									  $trozos = explode('#', $cadena);
									  if (count($trozos[1])==1){
									      ?>
                                <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $trozos[1]; ?></font></td>								 
									        <?
									  }	  								 
								   }
								
									fclose ($archivo);
							   }
						  }else{*/
						       //echo "Archivo no encontrado <br>";
							    for($countAreaItem=0 ; $countAreaItem<@pg_numrows($resultTraeAreaItem) ; $countAreaItem++){	
					           $filaTraeAreaItem=@pg_fetch_array($resultTraeAreaItem, $countAreaItem);
							   
							    $sql_valor = "select i.sigla as glosa
								from informe_concepto_eval i
								inner join informe_evaluacion2 e
								on i.id_concepto = cast(e.respuesta as integer)
								where e.id_plantilla = ".$filaPlantilla['id_plantilla']."
								and e.rut_alumno=".$filaAlum['rut_alumno']." and e.id_periodo = ".$cmb_periodos."  
								and e.id_informe_area_item =".$filaTraeAreaItem['id']."
								and e.id_ano=".trim($ano);
								
								//die($sql_valor);
								$rs_valor=@pg_Exec($conn, $sql_valor);	
								$valor_sigla = @pg_fetch_array($rs_valor,0);
							   
							   // $nro_glosa = substr($filaTraeAreaItem['glosa'],0,2);	?>
                                <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">&nbsp;<?  echo $valor_sigla['glosa'];?></font></td>
                              <? //}
						  }
						  
						  	  		
						
						  /*
				          for($k=0;$k<$Total_Item;$k++){	
					          $filaTraeAreaItem=@pg_fetch_array($resultTraeAreaItem, $k);						  
					          $query_respuesta="select respuesta from informe_evaluacion2 a  where a.id_ano=".$_ANO." and a.id_periodo=".$id_peri['0']." and a.id_plantilla=".$filaPlantilla['id_plantilla']." and a.id_informe_area_item=".$filaTraeAreaItem['id']." and a.rut_alumno=".$filaAlum['rut_alumno']."";
					          $result_respuesta=@pg_exec($conn,$query_respuesta);		
					          $fila_respuesta=@pg_fetch_array($result_respuesta,0);	
							  $sigla = $fila_respuesta['respuesta'];
							  
							  							  							  
							  ?>
						      <td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:9px"><? echo $sigla;?></font></td>
                       		    					  
					    <? } ?>			  
		      	        */
						?>
                           </tr>			
                              <? }?>
                            </table>
						 
						 
						 
						 
						 
						 
						 
						 
						 
						 <!-- inicio comentario a reemplazar 
						 
						 <table width="750" border="1"  cellpadding="2" cellspacing="0" >
		                  <tr >
		                    <td width="150" align="center" ><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">AREA</font></td>
                           <?
						 
						  $sqlTraeArea = "SELECT  informe_area_item.id, informe_area_item.id_plantilla, informe_area_item.id_padre, informe_area_item.glosa, informe_area_item.con_concepto from informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND id_padre=0 ORDER BY id";
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
		                    <td colspan="<? echo $Total;?>" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $filaTraeArea['glosa'];?></font></td>
  <?				         } ?>			  
		                    </tr>
                              <tr >
                                <td width="150" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">SUBAREA</font></td>
		      	          	   
<?				         
if ($_INSTIT==1914){
    $orden_subarea = "  id";
}else{
    $orden_subarea = " id_padre";
}

  $sqlTraeSubArea="SELECT id,glosa FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto IS NULL AND id_padre<>0 ORDER BY $orden_subarea ";
				           $resultTraeSubArea=@pg_Exec($conn, $sqlTraeSubArea);	
				           for($countSubArea=0 ; $countSubArea<@pg_numrows($resultTraeSubArea) ; $countSubArea++){	
					           $filaTraeSubArea=@pg_fetch_array($resultTraeSubArea, $countSubArea);	

					           $sql_Tot_Item = "SELECT count(*) FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto >=0 AND id_padre=".$filaTraeSubArea['id'];
					           $resultTotItem=@pg_Exec($conn, $sql_Tot_Item);	
					           $Tot_Item = @pg_fetch_array($resultTotItem,0);		
					           ?>
                                <td colspan="<? echo $Tot_Item[0];?>" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $filaTraeSubArea['glosa'];?></font></td>
                          <? }?>			  
                              </tr>		
                              <tr >
                                <td width="150" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">ALUMNO / ITEM</font></td>
                           <?	 $sqlTraeAreaItem="SELECT id,glosa FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto >=0  ORDER BY id_padre,id";
				         $resultTraeAreaItem=@pg_Exec($conn, $sqlTraeAreaItem);
				         for($countAreaItem=0 ; $countAreaItem<@pg_numrows($resultTraeAreaItem) ; $countAreaItem++){	
					         $filaTraeAreaItem=@pg_fetch_array($resultTraeAreaItem, $countAreaItem);
							    $nro_glosa = substr($filaTraeAreaItem['glosa'],0,2);	?>
                                <td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><?=$nro_glosa;  ?><? // echo $filaTraeAreaItem['glosa'];?></font></td>
                         <? }
					   	$Total_Item = $countAreaItem;	?>			  
                              </tr>
                              <?
					  
					   $sql_Alumno = "SELECT * FROM alumno a INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno WHERE m.rdb=".trim($institucion)." AND m.id_ano=".trim($ano)." AND m.id_curso=".trim($curso)." AND m.bool_ar=0 ORDER BY m.nro_lista, a.ape_pat";
			           $resultAlumno = @pg_Exec($conn, $sql_Alumno);				?>
                              
                              <tr>			
                                <? for($j=0 ; $j<@pg_numrows($resultAlumno) ; $j++){	
					      $filaAlum=@pg_fetch_array($resultAlumno, $j);	?>
                                <td width="150" align="left"><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px"><? echo $filaAlum['ape_pat']." ".$filaAlum['ape_mat']." ".$filaAlum['nombre_alu'];?></font></td>
			      	        
                          <?
								$nombre = $_ANO."-".$id_peri['0']."-".$filaAlum['rut_alumno']."-".$filaPlantilla['id_plantilla'];
								
								$sqlTraeAreaItem2="SELECT id FROM informe_area_item WHERE id_plantilla=".$filaPlantilla['id_plantilla']." AND con_concepto >= 0  ORDER BY id_padre,id";
				         		$resultTraeAreaItem2=@pg_Exec($conn, $sqlTraeAreaItem2);
				        		for($countAreaItem2=0 ; $countAreaItem2<@pg_numrows($resultTraeAreaItem2) ; $countAreaItem2++){
									$filaTraeAreaItem2=@pg_fetch_array($resultTraeAreaItem2, $countAreaItem2);
									
									$sqlfilaob="select respuesta,id_informe_area_item from informe_evaluacion2 where rut_alumno=".$filaAlum['rut_alumno']." and id_ano=".$_ANO." and id_plantilla=".$filaPlantilla['id_plantilla']." and id_periodo=".$periodo." and id_informe_area_item =".$filaTraeAreaItem2['id'];
									$resultob = @pg_Exec($conn, $sqlfilaob);
									$filaob=@pg_fetch_array($resultob,0);
											
									$sqlsigla="select sigla from informe_concepto_eval where id_concepto=".$filaob['respuesta']." and id_plantilla =".$filaPlantilla['id_plantilla'];
									$resultsigla = @pg_Exec($conn, $sqlsigla);
									$filasigla=@pg_fetch_array($resultsigla,0);
									
									if(@pg_numrows($resultsigla)==0){
										$concepto = $filaob['respuesta'];
									}else{
										$concepto = $filasigla["sigla"];
									}
										//for($countAreaItem=0 ; $countAreaItem<	$Total_Item ; $countAreaItem++){
								?>
								
                                			<td><font face="Verdana, Arial, Helvetica, sans-serif" style="font-size:8px">&nbsp;<?= $concepto;?></font></td>
								<?
										$filasigla["sigla"]=" ";
									}
									 
							 //echo $sqlfilaob="select id_plantilla from informe_evaluacion2 where rut_alumno= ".$filaAlum['rut_alumno'];
						  //$resultAlumno = @pg_Exec($conn, $sqlfilaob);			
						  //echo "nombre: $nombre <br>";
						 // if (file_exists("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt")) {
							 // $archivo=fopen("../../../ano/curso/informe_educacional/archivos/".$nombre.".txt" , "r");
							  
							 /* if ($archivo) {
								  $linea=1;
								  while (!feof($archivo)) {
									  $cadena = fgets($archivo, 500);
									  									  
									  $trozos = explode('#', $cadena);
									  if (count($trozos[1])==1){*/
									 // }  								 
								  // }
								
									//fclose ($archivo);
							  // }
						 // }else{
						       //echo "Archivo no encontrado <br>";
							   
							   //for($countAreaItem=0 ; $countAreaItem<@pg_numrows($resultTraeAreaItem) ; $countAreaItem++){
					           //$filaTraeAreaItem=@pg_fetch_array($resultTraeAreaItem, $countAreaItem);
							   
                               //}
							   
						// }				  	  		
						
						  
						?>
						</tr>			
					  <? }?>
					  </table>				  
					
					
					 fin comentario a reemplazar -->	  
<? } ?>                           
                       
</body>
</html>
