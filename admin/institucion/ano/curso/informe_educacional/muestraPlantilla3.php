<?php 
require('../../../../../util/header.inc');
//$plantilla	=$_PLANTILLA;
$institucion =$_INSTIT;
$ano		 =$_ANO;
$_POSP       = 5;
$_bot        = 5;

echo $id_plantilla;

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=6 AND id_categoria=3 AND id_item=16";
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}	


$sql="select situacion from ano_escolar where id_ano=$_ANO";
$result =pg_exec($conn,$sql);
$situacion=pg_result($result,0);


if($_PERFIL == 0){
	$hora = date("H:i:s");
	//echo "<h1>$hora</h1>";
}

if ($guardar){

	//////// Guardar campos en la base de datos ///////////
	$query_cat="select * from informe_area_item where id_plantilla='$id_plantilla' and id_padre=0 order by id";
	
	
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);

	for ($i=0;$i<$num_cat;$i++){
		  $row_cat=pg_fetch_array($result_cat);
		  $query_sub="select * from informe_area_item where id_plantilla='$id_plantilla' and id_padre<>0 and id_padre=$row_cat[id] order by id";
		  $result_sub=pg_exec($conn,$query_sub);
		  $num_sub=pg_numrows($result_sub);
		  for ($j=0;$j<$num_sub;$j++){
			  $row_sub=pg_fetch_array($result_sub);
			  $id_reg = $row_sub['id'];
              if ($row_sub['tipo_txt']==1){
			      $tipo_txt = "tipo_txt".$i;
				  $tipo_txt = $$tipo_txt;
				  /// actualizar la tabla informe_area_item
				  $sql_act = "update informe_area_item set glosa = '$tipo_txt' where id = '$id_reg'";
				  $reg_act = pg_Exec($conn,$sql_act);
			  }
		  }
	 }						  
	/////////////////////////////////					  
	
	
	
	$largo=count($id_informe_area_item);
	
			
	$total = array();
	
	for ($i=0;$i<$largo;$i++){
		$query_val="select * from informe_area_item where id='$id_informe_area_item[$i]'";
		$result_val=pg_exec($conn,$query_val);
		$num_val=pg_numrows($result_val);
		if ($num_val>0){
			$row_val=pg_fetch_array($result_val);
			if ($row_val[con_concepto]==1){$concepto=1;}else{$concepto=0;}
			
			 $query_val2="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$id_plantilla' and id_informe_area_item='$id_informe_area_item[$i]' and rut_alumno='$alumno' ";
			//echo $query_val2."<br>";
			$result_val2=pg_exec($conn,$query_val2);
			$num_val2=pg_numrows($result_val2);
			if ($num_val2>0){
				$query="UPDATE informe_evaluacion2 SET tipo_txt = '$tipo_txt[$i]', respuesta='$respuesta[$i]',concepto='$concepto'  WHERE id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$id_plantilla' and id_informe_area_item='$id_informe_area_item[$i]' and rut_alumno='$alumno'";			
			}else{
				$query="INSERT INTO informe_evaluacion2 (id_ano, id_periodo, id_curso, id_plantilla, id_informe_area_item,respuesta,concepto,rut_alumno,tipo_txt) 
				VALUES('$_ANO','$periodo','$_CURSO','$id_plantilla','$id_informe_area_item[$i]','$respuesta[$i]','$concepto','$alumno','$tipo_txt[$i]')";
			}
			//echo $query."<br>";
			$result=pg_exec($conn,$query);
			
			
			
			
			//GUARDAMOS A ARCHIVO
			$id_item = $id_informe_area_item[$i];
			$nombre_item = $row_val['glosa'];
			$id_respuesta = $respuesta[$i];
						
			
			
			$respuesta_texto = "";
			$sigla_texto = "";
			
			if($concepto == 1){
				$query_uno=" select nombre,sigla from informe_concepto_eval  where id_concepto ='$id_respuesta'";
				$result_uno=pg_exec($conn,$query_uno);
				$row_uno=pg_fetch_array($result_uno);
				$respuesta_texto = $row_uno['nombre'];
				$sigla_texto = $row_uno['sigla'];
			}
			else{
				

				$respuesta_texto = $respuesta[$i];
				$sigla_texto = ""	;		
				
				
			}
			
			
			$query_dos=" select id_padre, tipo_txt, glosa, id  from informe_area_item  where id ='$id_item'";
			
			$result_dos=pg_exec($conn,$query_dos);
			$row_dos=pg_fetch_array($result_dos);			
			$id_padre_sub = $row_dos['id_padre'];
			$tipo_txt     = $row_dos['tipo_txt'];
			$glosa_txt    = $row_dos['glosa'];
			$id_txt       = $row_dos['id'];
			
									
			$query_tres=" select id_padre,glosa  from informe_area_item  where id ='$id_padre_sub'";
			$result_tres=pg_exec($conn,$query_tres);
			$row_tres=pg_fetch_array($result_tres);			
			$id_padre_cat = $row_tres['id_padre'];
			$nombre_sub = $row_tres['glosa'];
			
			
			$query_cua=" select glosa  from informe_area_item  where id ='$id_padre_cat'";
			$result_cua=pg_exec($conn,$query_cua);
			$row_cua=pg_fetch_array($result_cua);			
			$nombre_cat = $row_cua['glosa'];			
			
			if ($tipo_txt==1){
			    $total[$i]['id_cat']    = $id_txt;
			    $total[$i]['glosa_cat'] = $glosa_txt;
								
				
				$tipo_txt=0;
			}else{
			    if ($id_padre_cat==0){
				    $id_padre_cat = $id_padre_sub;
				}	
				
				$total[$i]['id_cat'] = $id_padre_cat;
				$total[$i]['glosa_cat'] = $nombre_cat;
				$total[$i]['id_sub'] = $id_padre_sub;
				$total[$i]['glosa_sub'] = $nombre_sub;
				$total[$i]['id_item'] = $id_item;
				$total[$i]['glosa_item'] = $nombre_item;
				
				if($respuesta_texto == ""){
					$total[$i]['respuesta'] = $respuesta_texto;	
				}
				else{
					$total[$i]['respuesta'] = $respuesta_texto."#".$sigla_texto;	
				}
			
			}		

			//echo "$nombre_cat <tab>  $nombre_sub <tab> $nombre_item <tab> $respuesta_texto<br>";
			
			
			
			
			
		}
	}
	
	
	
	
	//print_r($total);
	
	$nuevos = array();
	$cont = 0;
	
	for($p=0;$p<count($total);$p++){
		if($p == 0){
			$nuevos[$cont]['id'] = $total[$p]['id_cat'];
			$nuevos[$cont]['glosa_cat'] = $total[$p]['glosa_cat'];
			$cont++;
		}
		else{
			$bandera = 0;
			for($x=0;$x<count($nuevos);$x++){
				if($nuevos[$x]['id'] == $total[$p]['id_cat']){
					$bandera = 1;
				}
			}
			if($bandera == 0){
				$nuevos[$cont]['id'] = $total[$p]['id_cat'];
				$nuevos[$cont]['glosa_cat'] = $total[$p]['glosa_cat'];
				$cont++;				
			}	
		}	
	}
	
	//print_r($nuevos);
	
	
	for($x=0;$x<count($nuevos);$x++){
		
		for($q=0;$q<count($total);$q++){
		
			if($nuevos[$x]['id'] == $total[$q]['id_cat']){
				
				if($q==0){								
					$nuevos[$x]['sub'][] = array('id' => $total[$q]['id_sub'], 'glosa' => $total[$q]['glosa_sub']);
					
				}
				else{
					$bandera = 0;
					for($y=0;$y<count($nuevos);$y++){
						
						for($h=0;$h<count($nuevos[$y]['sub']);$h++){
							if($nuevos[$y]['sub'][$h]['id'] == $total[$q]['id_sub']){
								$bandera = 1;
							}
							
						}
						
					}
					
					if($bandera == 0){
						$nuevos[$x]['sub'][] = array('id' => $total[$q]['id_sub'], 'glosa' => $total[$q]['glosa_sub']);
						
					}
					
				}
				
				
				
			}
				
		}
		
	}
	
	
	
	for($x=0;$x<count($nuevos);$x++){
		
		$temp = $nuevos[$x]['sub'];
		$conta = count($temp);
		
		for($r=0;$r<$conta;$r++){
			//print_r($temp[$r]);
			
			$temp_id_sub = $temp[$r]['id'];
			
			for($q=0;$q<count($total);$q++){
				
				if($total[$q]['id_sub'] == $temp_id_sub){
					
					$nuevos[$x]['sub'][$r]['item'][] = array('glosa_item' => $total[$q]['glosa_item'], 'respuesta' =>$total[$q]['respuesta']  );
				}
			}
			
			
		}
		
		
	}
			
	//print_r($nuevos);
	
		/*$nombre = $ano."-".$periodo."-".$alumno."-".$id_plantilla;
		
	
		
		$archivo=fopen("archivos/".$nombre.".txt" , "w");
		if ($archivo) {
			
			for($x=0;$x<count($nuevos);$x++){
				
				$glosa_cat = $nuevos[$x]['glosa_cat']."\n";
				fputs ($archivo, $glosa_cat);
				
				$temp = $nuevos[$x]['sub'];
				
				for($r=0;$r<count($temp);$r++){
					
					$glosa_sub = "\t".$temp[$r]['glosa']."\n";
					fputs ($archivo, $glosa_sub);
					
					$temp2 = $temp[$r]['item'];
					
					//print_r($temp2);
					
					for($n=0;$n<count($temp2);$n++){
						$glosa_item = "\t\t".$temp2[$n]['glosa_item']."\t".$temp2[$n]['respuesta']."\n";
						fputs ($archivo, $glosa_item);
					}
					
				}
				
			}
			
			
		}
		fclose ($archivo); */
		
		
		
	
	
	//// AQUI GUARDO LAS OBSERVACIONES DEL INFORME PARA EL ALUMNO
	/// verificamos si ya tiene observaciones para este informe
	
	
	$sql_observ1 = "select rut_alumno from informe_observaciones where id_periodo = '".trim($periodo)."' and id_ano = '".trim($_ANO)."' and id_plantilla = '".trim($id_plantilla)."' and rut_alumno = '".trim($alumno)."'";
	$res_observ1 = @pg_Exec($conn,$sql_observ1);
	$num_observ1 = @pg_numrows($res_observ1);
	
	if ($num_observ1>0){
	      // existe, debo actualizar
	     $sql_observ2 = "update informe_observaciones set observaciones = '$observaciones', sedestaca = '$sedestaca' where  id_periodo = '".trim($periodo)."' and id_ano = '".trim($_ANO)."' and id_plantilla = '".trim($id_plantilla)."' and rut_alumno = '".trim($alumno)."'";
		 $res_observ2 = @pg_Exec($conn,$sql_observ2);	  
		  
	}else{
	      /// no existe debo ingresar
		  /// antes debo tomar la fecha de creacion del informe
		  $sql_fecha_inf = "select fecha_creacion from informe_plantilla where id_plantilla = '".trim($id_plantilla)."'";
		  $res_fecha_inf = @pg_Exec($conn,$sql_fecha_inf);
		  $num_fecha_inf = @pg_numrows($res_fecha_inf);
		  
		  if (($num_fecha_inf==NULL) or ($num_fecha_inf == 0)){
		       if ($_PERFIL == 0){
			         echo "<script>Atencion. no coincide el ID_plantilla en la tabla informe_plantilla, favor revisar proceso.</script>";
					 exit();
			   }
		  }else{
		       $fila_fecha_inf = @pg_fetch_array($res_fecha_inf,0);
			   $fecha_creacion = $fila_fecha_inf['fecha_creacion'];
			   
			   /// tengo la fecha de creacion, ahora insertar la observacion			  
			     
			   $sql_observ3 = "insert into informe_observaciones (id_periodo, id_ano, id_plantilla, rut_alumno, observaciones, fecha_creacion, sedestaca)
			   values ('".trim($periodo)."','".trim($_ANO)."','".trim($id_plantilla)."','".trim($alumno)."','$observaciones','$fecha_creacion','$sedestaca')";
			   $res_observ3 = @pg_Exec($conn,$sql_observ3);			     		   
		  } 	  
	}
	
	
	/*imprime_array($_GET);
	imprime_array($_POST);
	imprime_array($_SESSION);*/
	
	
}


	
	if (!$periodo){$periodo=0;}
	if ($cmb_periodo){$periodo=$cmb_periodo;}

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
	if($grado==15) $gr="quince";
	if($grado==16) $gr="diezseis";
	if($grado==17) $gr="diecisiete";
	if($grado==18) $gr="dieciocho";
	if($grado==19) $gr="diecinueve";
	if($grado==20) $gr="veinte";
	if($grado==21) $gr="veintiuno";
	if($grado==22) $gr="veintidos";
	if($grado==23) $gr="veintitres";
	if($grado==24) $gr="veinticuatro";
	if($grado==25) $gr="veinticinco";
	if($grado==31) $gr="treintauno";
	if($grado==32) $gr="treintados";


	$sqlTraeCurso="SELECT * FROM curso WHERE id_curso=".$_CURSO;
	$resultCurso=@pg_Exec($conn, $sqlTraeCurso);
	$filaCurso=@pg_fetch_array($resultCurso);
	   if($tipoEns=="")
	      $tipoEns=$filaCurso['ensenanza'];


	 $sqlTraePlantilla="SELECT * FROM informe_plantilla WHERE tipo_ensenanza=".$tipoEns." AND ".$gr."=1 and activa=1 AND rdb=".$institucion." and tipo=".$tipo;
	$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
	$filaPlantilla=@pg_fetch_array($resultPlantilla);
	$num_xxx=pg_numrows($resultPlantilla);
	//print_r($num_xxx);
//imprime_array($filaPlantilla);
//if($_PERFIL==0){echo $sqlTraePlantilla; }


	$plantilla=$filaPlantilla[id_plantilla];
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
	
	

	
	///////////////////////////////////////////////////////////////////////	
	/// AQUI TOMO LAS OBSERVACIONES DEL INFORME PARA ESTE ALUMNO
	$sql_observ1 = "select rut_alumno, glosa, observaciones, sedestaca from informe_observaciones where id_periodo = '".trim($periodo)."' and id_ano = '".trim($_ANO)."' and id_plantilla = '".trim($plantilla)."' and rut_alumno = '".trim($alumno)."'";
	$res_observ1 = @pg_Exec($conn,$sql_observ1);
	$num_observ1 = @pg_numrows($res_observ1);
	
	
	     	
	if ($num_observ1>0){
	   $fila_observ1  =  @pg_fetch_array($res_observ1,0);
	   $observaciones =  $fila_observ1['observaciones'];
	   $sedestaca     =  $fila_observ1['sedestaca']; 
	   
	  
	}
        	
	
?>
<SCRIPT language="JavaScript">
function enviapag(form){

			if (form.cmb_periodo.value!=0){
				//form.periodo.target="self";
//				form.action = form.cmbPERIODO.value;

		form.action = 'muestraPlantilla3.php?periodo='+form.cmb_periodo.value+'&creada=1&grado=<? echo $grado;?>&alumno=<?php echo trim($alumno);?>&tipo='+form.tipo_planilla.value;
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
                      <? $menu_lateral="3_1"; ?>  <? include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"><form name="form1" method="post"><table width="100%" border="0">
                              <tr>
                                <td width="16%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; <font size="1">PERIODO</font></font></td>
                                <td width="37%">    <font size="2" face="Arial, Helvetica, sans-serif"> :
                               
								      <?php $sqlPeriodo="select * from periodo where id_ano=".$ano." order by nombre_periodo";
					$resultPeriodo=@pg_Exec($conn, $sqlPeriodo);
			 ?>
                                      <select name="cmb_periodo" onChange="enviapag(this.form);">
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
                                <td width="3%"><font size="2" face="Arial, Helvetica, sans-serif">&nbsp; </font></td>
                                <td width="44%" align="right"><font size="2" face="Arial, Helvetica, sans-serif">
								<input name="id_plantilla" type="hidden" value="<? echo $plantilla;?>">
								<input name="grado" type="hidden" value="<? echo $grado;?>">
								<input name="alumno" type="hidden" value="<? echo $alumno;?>">
								<input name="periodo" type="hidden" value="<? echo $periodo;?>">
								<input name="creada" type="hidden" value="<? echo $creada;?>">
								
								
                                  <?php if($modificar){?>
                                  <input class="botonXX"  type="submit" name="guardar" value="GUARDAR">
                                  <?php } ?>
                                  <?php 
								  if($modifica==1 ||  $ingreso==1){
								  if (($creada==1)&&(!$modificar)&&($periodo!=0)){
									  
								  			if($institucion==24977 && $_PERFIL==17 && $ver==0){
												
												
												// no muestra boton
												// pero si la institucion es 516 y perfil es 17 y es profesor jefe ahi si muestro el boton modificar
											}else{
												$qry_projefe="SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, ano_escolar.nro_ano, institucion.nombre_instit, supervisa.rut_emp, ano_escolar_1.id_ano, institucion.rdb FROM institucion INNER JOIN (((tipo_ensenanza INNER JOIN (curso INNER JOIN supervisa ON curso.id_curso = supervisa.id_curso) ON tipo_ensenanza.cod_tipo = curso.ensenanza) INNER JOIN ano_escolar ON curso.id_ano = ano_escolar.id_ano) INNER JOIN ano_escolar AS ano_escolar_1 ON curso.id_ano = ano_escolar_1.id_ano) ON institucion.rdb = ano_escolar_1.id_institucion WHERE (((supervisa.rut_emp)=".$_EMPLEADO.") and institucion.rdb = '".trim($_INSTIT)."') ORDER BY curso.grado_curso ASC";
												$result_projefe =@pg_Exec($conn,$qry_projefe);
												$num_projefe = @pg_numrows($result_projefe);
											
										
												if ($situacion !=0){												
												if ($institucion==516 and $_PERFIL==17 and $num_projefe){
												   ?>
												   <input class="botonXX"  type="submit" name="modificar" value="MODIFICAR">
												   <?
												}   
												
											
								  			else if($institucion==24977 && $_PERFIL==17  && $ver==1){	?>
                                                  <input class="botonXX"  type="submit" name="modificar" value="MODIFICAR">											
<?											}else{ ?>

                                                  <input class="botonXX"  type="submit" name="modificar" value="MODIFICAR">
												  
                                  <?		} 
											}//cierre if año escolar
											
											}?>
                                  <?php }
								  }?>
                                  <input class="botonXX"  type="button" name="Submit2" value="VOLVER" onClick="window.location='listarAlumnos.php'">
                                </font></td>
                              </tr>
                               <tr>
                                <td class="textosimple">Tipo</td>
                                <td class="textosimple"><input name="tipo_planilla" type="radio" id="tipo_planilla0" value="0" onChange="enviapag(this.form);" <? if($tipo==0) echo "checked"; ?>>
                                    Informe de Personalidad <input name="tipo_planilla" type="radio" id="tipo_planilla1" value="1" <? if($tipo==1) echo "checked"; ?> onChange="enviapag(this.form);">
                                    Informe Diagn&oacute;stico</td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                              </tr>

                              <tr>
                                <td class="textosimple"> &nbsp;Orden de Concepto </td>
                                <td class="textosimple"><input name="orden" type="radio" value="1" <? if($orden==1) echo "checked"; ?>  onChange="enviapag(this.form);">
                                  Ascendente
                                    <input name="orden" type="radio" value="2"  <? if($orden==2) echo "checked"; ?> onChange="enviapag(this.form);">
                                    Descendente</td>
                                <td>&nbsp;</td>
                                <td align="right">&nbsp;</td>
                              </tr>
                             

  
                              <tr>
                                <td colspan="4">&nbsp;</td>
                              </tr>
                              <tr align="center" class="tableindex">
                                <td colspan="4">INFORME EDUCACIONAL</td>
                              </tr>
                              <tr>
                                <td colspan="4"><table width="100%" border="0">
                                  <tr>
                                    <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Alumno</font></td>
                                    <td width="50%"><font size="2" face="Arial, Helvetica, sans-serif">: <?php echo $filaAlumno['nombre_alu']. " " . $filaAlumno['ape_pat']. " " . $filaAlumno['ape_mat']?></font></td>
                                    <td width="5%"><font size="2" face="Arial, Helvetica, sans-serif">RUT</font></td>
                                    <td width="36%"><font size="2" face="Arial, Helvetica, sans-serif">: <?php echo $alumno."-". $filaAlumno['dig_rut']?></font></td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td colspan="4"><table width="100%" border="0">
                                  <tr>
                                    <td width="9%"><font size="2" face="Arial, Helvetica, sans-serif">Curso</font></td>
                                    <td width="91%"><font size="2" face="Arial, Helvetica, sans-serif">: <?php 
   		       						 $Curso_pal = CursoPalabra($filaCurso['id_curso'], 1, $conn);
									echo $Curso_pal?></font></td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td colspan="4">    
                                
                                
                                				<?php if($tipoEns>310){?>
                                					<table width="100%" border="0">
						                                  <tr>
						                                    <td width="14%"><font size="2" face="Arial, Helvetica, sans-serif">Especialidad</font></td>
						                                    <td width="86%">: <font size="2" face="Arial, Helvetica, sans-serif">
						                                      <?php  $sqlTraeEsp="SELECT nombre_esp FROM especialidad WHERE cod_esp=".$filaCurso['cod_es']." and cod_sector=".$filaCurso['cod_sector']." and cod_rama=".$filaCurso['cod_rama'];
																$resultEsp=@pg_Exec($conn, $sqlTraeEsp);
																$filaEsp=@pg_fetch_array($resultEsp,0);
																echo $filaEsp['nombre_esp'];
																echo $modificar;
																?>
						                                    </font></td>
						                                  </tr>
                                					</table>
                                					
                            					<? }?>                            	</td>
                              </tr>
                              <tr>
                                <td colspan="4"><table width="100%" border="0">
                                  <tr>
                                    <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Establecimiento</font></td>
                                    <td width="83%">:<font size="2" face="Arial, Helvetica, sans-serif"> <?php echo $cmbConcepto[0]; echo $filaInstit['nombre_instit']?></font></td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td colspan="4"><table width="100%" border="0">
                                  <tr>
                                    <td width="17%"><font size="2" face="Arial, Helvetica, sans-serif">Profesor Jefe</font></td>
                                    <td width="83%"><font size="2" face="Arial, Helvetica, sans-serif">: <?php echo $filaProfe['nombre_emp']." ".$filaProfe['ape_pat']." ".$filaProfe['ape_mat']?></font></td>
                                  </tr>
                                </table></td>
                              </tr>
                              <tr>
                                <td colspan="4"><table width="100%" border="1">
								
<?							  
	if($_PERFIL == 0){
		$hora = date("H:i:s");
		//echo "<h1>$hora</h1>";
	}	 

	
?>  	



    <? 
	if($modificar == "MODIFICAR"){
		
	
	?>

		<?
		$contador=0;
	  	$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0 order by id";
		$result_cat=pg_exec($conn,$query_cat);
		$num_cat=pg_numrows($result_cat);

	
		?>
     <? for ($i=0;$i<$num_cat;$i++){
			  $row_cat=pg_fetch_array($result_cat);
		      ?>
              <tr>
                <td class="tabla04"><? echo $row_cat['glosa'];?> </td>
				<td class="tabla04">Evaluaci&oacute;n</td>
              </tr>
             <?
			 
			
			 
			
			  $query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id] order by id";
			  $result_sub=pg_exec($conn,$query_sub);
			  $num_sub=pg_numrows($result_sub);
			  
			  //if($_PERFIL==0){echo $query_sub;}
		      ?>
			

            <? for ($j=0;$j<$num_sub;$j++){
				 $row_sub=pg_fetch_array($result_sub);
             	  ?>
                  <tr>
                    <td>
					<img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
					<!-- nuevo código para determinar si este concepto es editable o no  -->
					<?
					if ($row_sub['tipo_txt']==1){ ?>
					      <?
						  
						  
						  
						  
						   $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
						   $result_respuesta=pg_exec($conn,$query_respuesta);
						   $num_respuesta=pg_numrows($result_respuesta);
						   if ($num_respuesta>0){
							  $row_respuesta=pg_fetch_array($result_respuesta);
						   }
						   ?>	  
					      <textarea name="tipo_txt<?=$i ?>" cols="70" rows="4"><? echo trim($row_sub['glosa']); ?></textarea>
						 
						
					
				 <? }else{ ?>					
					      <? echo $row_sub['glosa'];?>
				 <? } ?>					</td>
			     <? if ($modificar){?>
                        <td width="1%" nowrap>
						   <? if ($row_sub[con_concepto]==null){?>
                                    &nbsp;
									<? if ($row_sub['tipo_txt']==1){
									         ?> 
									         <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>"> 
											 <?
											 $contador++;
									   }?>
																		
                          <? }else{?>
	                                <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>">
	                       <? }?>
				 
	             <? if ($row_sub[con_concepto]=="0"){?>
	                   <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
					   
	                    $result_respuesta=pg_exec($conn,$query_respuesta);
	                    $num_respuesta=pg_numrows($result_respuesta);
	                    if ($num_respuesta>0){
	                        $row_respuesta=pg_fetch_array($result_respuesta);
	                        $valor=$row_respuesta[respuesta];
	                    } ?>
                        <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
                        <? $contador++;}?>
                        <? if ($row_sub[con_concepto]=="1"){?>
	                           <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
	                           $result_respuesta=pg_exec($conn,$query_respuesta);
	                           $num_respuesta=pg_numrows($result_respuesta);
	                           if ($num_respuesta>0){
	                                $row_respuesta=pg_fetch_array($result_respuesta);
	                                $valor=$row_respuesta[respuesta];
	                           } ?>
                               <? 
							  // if ($plantilla=="1373" or $plantilla=="1374" or $plantilla=="1375" or $plantilla=="1377" or $plantilla=="1380" or $plantilla=="1311" or $plantilla=="1303" or $plantilla=="1304" or $plantilla=="1305" or $plantilla=="1306" or $plantilla=="1101" or $plantilla=="1102" or $plantilla=="1103" or $plantilla=="1104" or $plantilla=="1398" or $plantilla=="1399" or $plantilla=="1400" or $plantilla=="1401" or $plantilla=="1402"){
							 
							
							  if($orden!=1){
							        $query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla order by orden,id_concepto DESC";
							   }else{						   
					                $query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla order by orden,id_concepto ASC";
							   }

					           $result_concep=pg_exec($conn,$query_concep);
					           $num_concep=pg_numrows($result_concep);?>
                               <select name="respuesta[<? echo $contador;?>]">
                              <? for ($ii=0;$ii<$num_concep;$ii++){
							         $row_concep=pg_fetch_array($result_concep);
					                 ?>
                                     <option  value="<? echo $row_concep[id_concepto];?>"<? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[nombre];?></option>
                              <? }?>
                              </select>
                              <? $contador++;}?> </td>
						 <? }
									
									
						  ?>
                          </tr>
                          <? 
						  
						  if(($plantilla==1693 || $plantilla==1694) && ($row_sub['id']==90741 || $row_sub['id']==90864 || $row_sub['id']==90835)){
								$ors = "orden";
							}else{
								$ors = "id";
							}
						  
						   $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] order by $ors";
					      $result_item=pg_exec($conn,$query_item);
					      $num_item=pg_numrows($result_item);?>
                          <? for ($z=0;$z<$num_item;$z++){
						          $row_item=pg_fetch_array($result_item);

					              ?>
                                  <tr class="tablatit2-1">
                                  <td><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
                                  <? 
								  if ($modificar){?>
								        <td width="1%" nowrap><input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_item[id];?>">
                                          <? if ($row_item['con_concepto']=="0"){?>							                
                                          <? $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
										// if($_PERFIL==0){echo $query_respuesta;}
												$result_respuesta=pg_exec($conn,$query_respuesta);
												$num_respuesta=pg_numrows($result_respuesta);
												if ($num_respuesta>0){
												    $row_respuesta=pg_fetch_array($result_respuesta);
												    $valor=$row_respuesta[respuesta];
												}else{
$valor="";													}
												?>
                                                <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
                                                <? $contador++;}?>
                                                <? if ($row_item[con_concepto]=="1"){?>
                                                      <? 
													   //if ($plantilla=="1373" or $plantilla=="1374" or $plantilla=="1375" or $plantilla=="1377" or $plantilla=="1380" or $plantilla=="1311" or $plantilla=="1303" or $plantilla=="1304" or $plantilla=="1305" or $plantilla=="1306" or $plantilla=="1101" or $plantilla=="1102" or $plantilla=="1103" or $plantilla=="1104" or $plantilla=="1398" or $plantilla=="1399" or $plantilla=="1400" or $plantilla=="1401" or $plantilla=="1402"){
													   if($orden!=1){
													        $query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla order by orden ASC";
													   }else{													  
													       $query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla order by orden DESC";
													   }	
													 
													  $result_concep=pg_exec($conn,$query_concep);
													  $num_concep=pg_numrows($result_concep);?>
							                          <?
													  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
													  $result_respuesta=pg_exec($conn,$query_respuesta);
													  $num_respuesta=pg_numrows($result_respuesta);
													  if ($num_respuesta>0){
														  $row_respuesta=pg_fetch_array($result_respuesta);
														  $valor=$row_respuesta[respuesta];
													  }
	                                                  ?>
                                                      <select  name="respuesta[<? echo $contador;?>]">
                                                      <?
													  for ($ii=0;$ii<$num_concep;$ii++){
									                      $row_concep=pg_fetch_array($result_concep);
							                              ?>
                                                          <option value="<? echo $row_concep[id_concepto];?>" <? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[nombre];?></option>
                                                   <? }?>
                                                      </select>
                                                      <? $contador++;
												}?>										  </td>
										<? }else{?>
										       <td width="1%" nowrap><? 
											   $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
										       $result_respuesta=pg_exec($conn,$query_respuesta);
										       $num_respuesta=pg_numrows($result_respuesta);
										       if ($num_respuesta>0){
											      $row_respuesta=pg_fetch_array($result_respuesta);
											      if ($row_respuesta[concepto]==1){
												      $query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												      $result_con=pg_exec($conn,$query_con);
												      $num_con=pg_numrows($result_con);
												      if ($num_con>0){
													      $row_con=pg_fetch_array($result_con);
													      echo $row_con[nombre];
												      }
											      }else{
											          echo $row_respuesta[respuesta];
											      }
										       }								
									           ?>&nbsp;</td>
									   <? }?>
                                     </tr>							  			
								<? }?>
                             <? }?>
                         <? }?>	
	<? 	
	}else{
	     ?>
		                       
		<?
		$contador=0;
	  	$query_cat="select * from informe_area_item where id_plantilla='$plantilla' and id_padre=0 order by id";
		$result_cat=pg_exec($conn,$query_cat);
		$num_cat=pg_numrows($result_cat);

	
		?>
     <? for ($i=0;$i<$num_cat;$i++){
			  $row_cat=pg_fetch_array($result_cat);
		      ?>
              <tr>
                <td height="24"  class="tabla04"><? echo $row_cat['glosa'];?> </td>
				<td width="1%" class="tabla04">
									<?		$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]' and rut_alumno='$alumno' ";
											$result_respuesta=pg_exec($conn,$query_respuesta);
											$num_respuesta=pg_numrows($result_respuesta);
											if ($num_respuesta>0){
												$row_respuesta=pg_fetch_array($result_respuesta);
												if ($row_respuesta[concepto]==1){
													$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
													$result_con=pg_exec($conn,$query_con);
													$num_con=pg_numrows($result_con);
													if ($num_con>0){
														$row_con=pg_fetch_array($result_con);
														echo $row_con[sigla];
													}
												}else{
													echo $row_respuesta[respuesta];
												}
											}		?>
										<!--	&nbsp; -->
									<? 		if($i==0){	?>Evaluación
										<?	}else{	?> 
												&nbsp;
										<?	} 	?>											</td>
              </tr>
             <?
			 
			
			  $query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id] order by id";
			  $result_sub=pg_exec($conn,$query_sub);
			  $num_sub=pg_numrows($result_sub);
		      ?>
			

            <? for ($j=0;$j<$num_sub;$j++){
				 $row_sub=pg_fetch_array($result_sub);
             	  ?>
                  <tr>
                    <td>
					<img src="../../../../../cortes/p.gif" width="10" height="1" border="0">
					<!-- nuevo código para determinar si este concepto es editable o no  -->
					<?
					if ($row_sub['tipo_txt']==1){ ?>
					      <?
						   echo $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
						   $result_respuesta=pg_exec($conn,$query_respuesta);
						   $num_respuesta=pg_numrows($result_respuesta);
						   if ($num_respuesta>0){
							  $row_respuesta=pg_fetch_array($result_respuesta);
						   }
						   ?>	  
					      <textarea name="tipo_txt<?=$i ?>" cols="70" rows="4"><? echo trim($row_sub['glosa']); ?></textarea>
						 
						
					
				 <? }else{ ?>					
					      <? echo $row_sub['glosa'];?>
				 <? } ?>					</td>
			     <? if ($modificar){?>
                        <td width="1%" nowrap>
						   <? if ($row_sub[con_concepto]==null){?>
                                    &nbsp;
									<? if ($row_sub['tipo_txt']==1){
									         ?> 
									         <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>"> 
											 <?
											 $contador++;
									   }?>
																		
                          <? }else{?>
	                                <input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_sub[id];?>">
	                       <? }?>
				 
	             <? if ($row_sub[con_concepto]=="0"){?>
	                   <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
					   
	                    $result_respuesta=pg_exec($conn,$query_respuesta);
	                    $num_respuesta=pg_numrows($result_respuesta);
	                    if ($num_respuesta>0){
	                        $row_respuesta=pg_fetch_array($result_respuesta);
	                        $valor=$row_respuesta[respuesta];
	                    } ?>
                        <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
                        <? $contador++;}?>
                        <? if ($row_sub[con_concepto]=="1"){?>
	                           <?  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_sub[id]'  and rut_alumno='$alumno'";
	                           $result_respuesta=pg_exec($conn,$query_respuesta);
	                           $num_respuesta=pg_numrows($result_respuesta);
	                           if ($num_respuesta>0){
	                                $row_respuesta=pg_fetch_array($result_respuesta);
	                                $valor=$row_respuesta[respuesta];
	                           } ?>
                               <? 
					           $query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla order by orden,id_concepto ASC";
					           $result_concep=pg_exec($conn,$query_concep);
					           $num_concep=pg_numrows($result_concep);?>
                               <select name="respuesta[<? echo $contador;?>]">
                              <? for ($ii=0;$ii<$num_concep;$ii++){
							         $row_concep=pg_fetch_array($result_concep);
					                 ?>
                                     <option  value="<? echo $row_concep[id_concepto];?>"<? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[nombre];?></option>
                              <? }?>
                              </select>
                              <? $contador++;}?> </td>
						 <? }
									
									
						  ?>
                          </tr>
                          <? 
						  if(($plantilla==1693 || $plantilla==1694) && ($row_sub['id']==90741 || $row_sub['id']==90864 || $row_sub['id']==90835)){
							$ors = "orden";
						}else{
							$ors = "id";
						}
						   $query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] order by $ors";
						  // if($_PERFIL==0){echo $query_item;}
					      $result_item=pg_exec($conn,$query_item);
					      $num_item=pg_numrows($result_item);?>
                          <? for ($z=0;$z<$num_item;$z++){
						          $row_item=pg_fetch_array($result_item);

					              ?>
                                  <tr class="tablatit2-1">
                                  <td><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
                                  <? if ($modificar){?>
								        <td width="1%" nowrap><input name="id_informe_area_item[<? echo $contador;?>]" type="hidden"  value="<? echo $row_item[id];?>">
                                          <? if ($row_item[con_concepto]=="0"){?>							                
                                          <? $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
										  
												$result_respuesta=pg_exec($conn,$query_respuesta);
												$num_respuesta=pg_numrows($result_respuesta);
												if ($num_respuesta>0){
												    $row_respuesta=pg_fetch_array($result_respuesta);
												    $valor=$row_respuesta[respuesta];
												}
												?>
                                                <input name="respuesta[<? echo $contador;?>]" type="text" value="<? echo $valor;?>">
                                                <? $contador++;}?>
                                                <? if ($row_item['con_concepto']=="1"){?>
                                                      <? 
													  $query_concep="select * FROM informe_concepto_eval where id_plantilla=$plantilla order by orden,id_concepto ASC";
													  $result_concep=pg_exec($conn,$query_concep);
													  $num_concep=pg_numrows($result_concep);?>
							                          <?
													  $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
													    if($_PERFIL==0) echo $query_respuesta;
													  $result_respuesta=pg_exec($conn,$query_respuesta);
													  $num_respuesta=pg_numrows($result_respuesta);
													  if ($num_respuesta>0){
														  $row_respuesta=pg_fetch_array($result_respuesta);
														  $valor=$row_respuesta[respuesta];
													  }
	                                                  ?>
                                                      <select  name="respuesta[<? echo $contador;?>]">
                                                      <?
													  for ($ii=0;$ii<$num_concep;$ii++){
									                      $row_concep=pg_fetch_array($result_concep);
							                              ?>
                                                          <option value="<? echo $row_concep[id_concepto];?>" <? if ($valor==$row_concep[id_concepto]){echo "selected";}?>><? echo $row_concep[nombre];?></option>
                                                   <? }?>
                                                      </select>
                                                      <? $contador++;
												}?>										  </td>
										<? }else{?>
										       <td width="1%" nowrap><? 
											   $query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
											 
										       $result_respuesta=pg_exec($conn,$query_respuesta);
										       $num_respuesta=pg_numrows($result_respuesta);
										       if ($num_respuesta>0){
											      $row_respuesta=pg_fetch_array($result_respuesta);
											      if ($row_respuesta[concepto]==1){
												      $query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
												      $result_con=pg_exec($conn,$query_con);
												      $num_con=pg_numrows($result_con);
												      if ($num_con>0){
													      $row_con=pg_fetch_array($result_con);
													      echo $row_con[nombre];
												      }
											      }else{
											          echo $row_respuesta[respuesta];
											      }
										       }								
									           ?>&nbsp;</td>
									   <? }?>
                                     </tr>							  			
								<? }?>
                             <? }?>
                         <? }?>	

		 <?
	/*$contador=0;
	$query_cat="select * from informe_area_item where id_plantilla='$id_plantilla' and id_padre=0 order by id";
	$result_cat=pg_exec($conn,$query_cat);
	$num_cat=pg_numrows($result_cat);

	for ($i=0;$i<$num_cat;$i++){
		  $row_cat=pg_fetch_array($result_cat);
		 	$query_sub="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_cat[id] order by id";
			  $result_sub=pg_exec($conn,$query_sub);
			  $num_sub=pg_numrows($result_sub);
		      for ($j=0;$j<$num_sub;$j++){
				 $row_sub=pg_fetch_array($result_sub);
		 				$query_item="select * from informe_area_item where id_plantilla='$plantilla' and id_padre<>0 and id_padre=$row_sub[id] order by id";
					      $result_item=pg_exec($conn,$query_item);
					      $num_item=pg_numrows($result_item);
						  for ($z=0;$z<$num_item;$z++){
						          $row_item=pg_fetch_array($result_item);?>
                                  <td><img src="../../../../../cortes/p.gif" width="20" height="8" border="0"><? echo $row_item['glosa'];?></td>
								  <?
							$query_respuesta="select * from informe_evaluacion2 where id_ano='$_ANO' and id_periodo='$periodo' and id_plantilla='$plantilla' and id_informe_area_item='$row_item[id]'  and rut_alumno='$alumno'";
							$result_respuesta=pg_exec($conn,$query_respuesta);
							$num_respuesta=pg_numrows($result_respuesta);
									if ($num_respuesta>0){
										$row_respuesta=pg_fetch_array($result_respuesta);
										if ($row_respuesta[concepto]==1){
											$query_con="select * from informe_concepto_eval  where id_concepto='$row_respuesta[respuesta]'";
											$result_con=pg_exec($conn,$query_con);
												$num_con=pg_numrows($result_con);
												 if ($num_con>0){
													$row_con=pg_fetch_array($result_con);
													echo $row_con[nombre];
												 }
											      }else{
											          echo $row_respuesta[respuesta];
											      }
										       }
									}				
								}   	
							}							
									           */?>
			  	
			<? /*if($periodo != 0){
				$nombre = $ano."-".$periodo."-".$alumno."-".$id_plantilla;
				
					
			
				if (file_exists("archivos/".$nombre.".txt")) {
					$archivo=fopen("archivos/".$nombre.".txt" , "r");	    
					
				
					if ($archivo) {
						while (!feof($archivo)) {
							$cadena = fgets($archivo, 500);
							$temp = split("[\t]",$cadena);
							//print_r($temp);
							
							$cont_car= count($temp);
							
							if($cont_car == 1){
								
								echo "
					              <tr>
					                <td colspan=2  class=tabla04>".$temp[0]."</td>
					              </tr>		";			
			
							}
							
							if($cont_car == 2){
								echo "
			                                  <tr class='tabla04'>
			                                    <td><img src='../../../../../cortes/p.gif' width=10 height=1 border=0>".$temp[1]."</td>
												
			                                    <td width=1% nowrap>		</td>
			                                  </tr>  
			                                    ";			
								
								
							}
							
							if($cont_car == 4){
								echo "				
			  						<tr class='tablatit2-1'>
			                        <td><img src='../../../../../cortes/p.gif' border=0 height=8 width=20>".$temp[2]."</td>
			                        				
								";
								if($temp[3] == ""){
									echo "<td nowrap='nowrap' width='5%'>".$temp[3]."</td>";
								}
								else{
									list($nombre_uno,$sigla) = split("#",$temp[3]);
									echo "<td nowrap='nowrap' width='5%'>".$nombre_uno."</td>";
								}
								
							}
							
							
						}
					}
					fclose ($archivo);
				}
				
				
			}*/

	    
	    
	    
	}
    	
    ?>
								  
								<?
								  if (($periodo!=0 ) OR ($periodo!=NULL)){
									  ?>
										
										<tr>
										<td colspan="3">									
										<table width="100%" border="1" cellspacing="0" cellpadding="0">
										  <tr>
											<td width="15%" class="tabla04">Se destaca en:</td>
										    <td width="85%" class="tablatit2_1">
											<input type="text" name="sedestaca" size="60" value="<?=$sedestaca ?>" <? if ($modificar){ /*vista para modificar*/}else{ ?> disabled="disabled"  <? } ?>>
											</div></td>
										 </tr>
									   </table>									   </td>
									   </tr>
									   
									   
										<tr>
										<td colspan="3">									
										<table width="100%" border="1" cellspacing="0" cellpadding="0">
										  <tr>
											<td class="tabla04">Observaciones</td>
										  </tr>
										  <tr class="tablatit2-1">
											<td><div align="center">
											  <label>
											  <textarea name="observaciones" cols="50" rows="8" <? if ($modificar){ /*vista para modificar*/}else{ ?> disabled="disabled"  <? } ?>><?=$observaciones ?></textarea>
											  </label>
											</div></td>
										 </tr>
									   </table>									   </td>
									   </tr>
									 <?  } ?>								 
								  
						  
                        </table></td>
                      </tr>
                    </table>
                            </form></td>
                  </tr>
                </table></td>
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


<?
if($_PERFIL == 0){
	$hora = date("H:i:s");
	//echo "<h1>$hora</h1>";
}
?>
</body>
</html>
<? pg_close($conn);?>