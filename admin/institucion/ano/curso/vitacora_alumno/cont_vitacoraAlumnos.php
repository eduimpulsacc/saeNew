<? include_once('../../../../../util/header.inc');

include "mod_vitacoraAlumno.php";
//require("class/Coneccion.class.php");

//$conn=pg_connect("dbname=coi_final host=192.168.100.203 port=5432 user=postgres password=300600");
$institucion	=$_INSTIT;
$funcion = $_POST['funcion'];
$id_vitacora = $_POST['id_vitacora'];
$id_vitacora_destaca = $_POST['id_vitacora_destaca'];
$rdb	 = $_INSTIT;
$tipo 	 = $_POST['tipo'];
$ano	 = $_ANO;
$fecha = $_REQUEST['fecha'];

/*if($nombrebase=="coi_antofagasta"){ 
		   $fecha = fEs2En233($fecha); 
		}
		
		if($nombrebase=="coi_final"){
		   $fecha = fEs2En222($fecha); 
		} 
		
		if($nombrebase=="coi_final_vina"){
		   $fecha = fEs2En22445($fecha); 
		} */
	//echo $fecha;

$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
											$result =@pg_Exec($conn,$qry);
											if (!$result){
												error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													$nroAno=$fila1['nro_ano'];
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
														//exit();
													}
													trim($nroAno);
													$situacion = $fila1['situacion']; 
												}
											}
/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
		
	}





$ob_Vitacora = new Vitacora($conn);


if($funcion==0){
	$result = $ob_Vitacora->insertarantec($rutusuario,$ano,$periodo,$fecha,$obser,$tipo,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 0
 
 
if($funcion==1){
	$result = $ob_Vitacora->actualizarantec($periodo,$fecha,$obser,$id_vitacora);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 0
  
 
 
if($funcion==2){

$result = $ob_Vitacora->cargaantec($rut_alumno,$rdb,$curso);
	if($result){
	   $tabla1 = '  <label for="listaevaluadores">Datos Antecedentes</label>
	  <table width="100" id="flex1"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="355" >Curso</th>
		  <th width="200" >Periodo</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
		  <th width="50" >Ver Datos</th>
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	 $nro_ano = $fila['nro_ano'];
		
	  if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaAnte(".$fila['id_vitacora'].")'><img src='img/PNG-48/Delete.png' width='18' height='18' border='0'/></a>";
		   }}
	    if($modifica==1){
		   if($nro_ano==$nroAno){	   
	  $modificar = "<a onclick='buscarante(".$fila['id_vitacora'].")'><img src='img/PNG-48/Modify.png' width='18' height='18' border='0'/></a>";
		   }}
	  $buscar="<a onclick='DialogAnte(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
	  
      $tabla1 .= '<tr align="center">
	  <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
	  <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'</td>
	  <td width="50" style="cursor:pointer">'.$buscar.'</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 1
 
 if($funcion==3){

 	$result = $ob_Vitacora->buscarante($_POST['id_vitacora']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora" type="hidden" value="'.$id_vitacora.'" />';
				echo '<input id="_rut_alumno" type="hidden" value="'.$rut_alumno.'" />';
				echo '<input id="_nombreper" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodo" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_obs" type="hidden" value="'.$fila['observacion'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}


}

if($funcion==4){
 	$result = $ob_Vitacora->EliminaAnte($id_vitacora);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }




if($funcion==5){
	$result = $ob_Vitacora->insertarDae($periodo,$fecha,$concepto,$docente,$obser,$ano,$rutalumno,$tipo,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 0
 
 
if($funcion==6){
	$result = $ob_Vitacora->actualizarDae($periodo,$fecha,$concepto,$docente,$obser,$id_vitacora);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 0


if($funcion==7){
$result = $ob_Vitacora->cargaDae($rut_alumno,$rdb);
	if($result){
	    $tabla1 = '  <label for="listaevaluadores4">Datos Dae</label>
	  <table width="100" id="flex4"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="100" >Periodo</th>
		  <th width="150" >Curso</th>
		  <th width="100" >Situaci&oacute;n</th>
		  <th width="200" >Docente</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
		  <th width="50" >Ver</th>
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano'];
	  $i = $e;
	  $i++;
	  
	   if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaAnteDae(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
		   }}
		     if($modifica==1){
		   if($nro_ano==$nroAno){
	  $modificar = "<a onclick='buscarDae(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	  }}
	  $buscar = "<a onclick='DialogDae(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre_empleado'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$buscar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 7
 
 if($funcion==8){

 	$result = $ob_Vitacora->buscaDae($_POST['id_vitacora']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora_Dae" type="hidden" value="'.$id_vitacora.'" />';
				echo '<input id="_nombreper_Dae" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodoDae" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano_Dae" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_concepto" type="hidden" value="'.$fila['concepto'].'" />';
				echo '<input id="_docente_Dae" type="hidden" value="'.$fila['rut_emp'].'" />';
				echo '<input id="nom_docente_Dae" type="hidden" value="'.$fila['nombre_empleado'].'" />';
				echo '<input id="_obs_Dae" type="hidden" value="'.$fila['observacion'].'" />';
				echo '<input id="_situ_Dae" type="hidden" value="'.$fila['nombre'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
}

	if($funcion==9){
 	$result = $ob_Vitacora->EliminaDae($id_vitacora);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }
 
 
 
 if($funcion==10){
	$result = $ob_Vitacora->insertarApo($periodo,$fecha,$evaluador,$rutApo,$docente,$obser,$ano,$rutalumno,$tipo,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 10

if($funcion==11){
$result = $ob_Vitacora->cargaApo($rut_alumno,$rdb);
	if($result){
	    $tabla1 = '  <label for="listaevaluadores5">Datos Entrevista Apoderado</label>
	  <table width="100" id="flex5"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="100" >Periodo</th>
		  <th width="150" >Curso</th>
		  <th width="100" >Evaluador </th>
		  <th width="200" >Apoderado</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
		  <th width="50" >Ver</th>
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano'];
	  $i = $e;
	  $i++;
	    if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaAnteApo(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
		   }}
		     if($modifica==1){
		   if($nro_ano==$nroAno){
	  $modificar = "<a onclick='buscarApo(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	  }}
	   $buscar = "<a onclick='DialogApo(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre_apoderado'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$buscar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 11


if($funcion==12){

 	$result = $ob_Vitacora->buscaApo($_POST['id_vitacora']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora_Apo" type="hidden" value="'.$id_vitacora.'" />';
				echo '<input id="_nombreper_Apo" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodo_Apo" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano_Apo" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_rut_Apo" type="hidden" value="'.$fila['rut_apo'].'" />';
				echo '<input id="_docente_Apo" type="hidden" value="'.$fila['rut_emp'].'" />';
				echo '<input id="nom_docente_Apo" type="hidden" value="'.$fila['nombre_empleado'].'" />';
				echo '<input id="_obs_Apo" type="hidden" value="'.$fila['observacion'].'" />';
				echo '<input id="_evaluador" type="hidden" value="'.$fila['nombre'].'" />';
				echo '<input id="_id_concepto_vitacora" type="hidden" value="'.$fila['id_conceptos_vitacora'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
}//fin funcion 12

if($funcion==13){
	$result = $ob_Vitacora->actualizarApo($periodo,$fecha,$evaluador,$rutApo,$docente,$obser,$id_vitacora);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 13

if($funcion==14){
 	$result = $ob_Vitacora->EliminaApo($id_vitacora);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }
 
  if($funcion==15){
	$result = $ob_Vitacora->insertarAlum($periodo,$fecha,$evaluador,$docente,$obser,$ano,$rutalumno,$tipo,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 15
 
 
 	if($funcion==16){
$_ano = $_POST['ano'];
$result = $ob_Vitacora->cargaAlum($rut_alumno,$rdb);
if($result){
	    $tabla1 = '  <label for="listaevaluadores6">Datos Entrevista Alumno</label>
	  <table width="100" id="flex6"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="150" >Periodo</th>
		  <th width="150" >Curso</th>
		  <th width="250" >Evaluador</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
		  <th width="50" >Ver</th>
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano'];
	  $i = $e;
	  $i++;
	   if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaAnteAlum(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
		}}
	  if($modifica==1){
		if($nro_ano==$nroAno){	   
	  $modificar = "<a onclick='buscarAlum(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	  }}
	   $buscar = "<a onclick='DialogAlum(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$buscar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 16

	
	if($funcion==17){

 	$result = $ob_Vitacora->buscaAlum($_POST['id_vitacora']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora_Alum" type="hidden" value="'.$id_vitacora.'" />';
				echo '<input id="_nombreper_Alum" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodo_Alum" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano_Alum" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_docente_Alum" type="hidden" value="'.$fila['rut_emp'].'" />';
				echo '<input id="nom_docente_Alum" type="hidden" value="'.$fila['nombre_empleado'].'" />';
				echo '<input id="_obs_Alum" type="hidden" value="'.$fila['observacion'].'" />';
				echo '<input id="_evaluador_alum" type="hidden" value="'.$fila['nombre'].'" />';
				echo '<input id="_id_concepto_vitacora_alum" type="hidden" value="'.$fila['id_conceptos_vitacora'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
}//fin funcion 17


if($funcion==18){
	$result = $ob_Vitacora->actualizarAlum($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 18


	if($funcion==19){
 	$result = $ob_Vitacora->EliminaAlum($id_vitacora);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }
 
 	if($funcion==20){
	$result = $ob_Vitacora->insertarDerInt($periodo,$fecha,$evaluador,$docente,$obser,$ano,$rutalumno,$tipo,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 15
 
 	if($funcion==21){
$result = $ob_Vitacora->cargaDerInt($rut_alumno,$rdb);
if($result){
	    $tabla1 = '  <label for="listaevaluadores7">Datos Derivacion Interna</label>
	  <table width="100" id="flex7"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="100" >Periodo</th>
		  <th width="200" >Curso</th>
		  <th width="250" >Evaluador</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
		  <th width="50" >Ver</th>
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano'];
	  $i = $e;
	  $i++;
	   if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaDerInt(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
	   }}
	    if($modifica==1){
		   if($nro_ano==$nroAno){
	  $modificar = "<a onclick='buscarDerInt(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	  }}
	  $buscar = "<a onclick='DialogDerInt(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$buscar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 20

 
 	if($funcion==22){

 	$result = $ob_Vitacora->buscaDerInt($_POST['id_vitacora']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora_DerInt" type="hidden" value="'.$id_vitacora.'" />';
				echo '<input id="_nombreper_DerInt" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodo_DerInt" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano_DerInt" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_docente_DerInt" type="hidden" value="'.$fila['rut_emp'].'" />';
				echo '<input id="nom_docente_DerInt" type="hidden" value="'.$fila['nombre_empleado'].'" />';
				echo '<input id="_obs_DerInt" type="hidden" value="'.$fila['observacion'].'" />';
				echo '<input id="_evaluador_DerInt" type="hidden" value="'.$fila['nombre'].'" />';
				echo '<input id="_id_concepto_vitacora_DerInt" type="hidden" value="'.$fila['id_conceptos_vitacora'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
}//fin funcion 22


	if($funcion==23){
	$result = $ob_Vitacora->actualizarDerInt($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 23


	if($funcion==24){
 	$result = $ob_Vitacora->EliminaDerInt($id_vitacora);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }
 
 	if($funcion==25){
	$result = $ob_Vitacora->insertarDerExt($periodo,$fecha,$evaluador,$docente,$obser,$ano,$rutalumno,$tipo,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 25
 
 
 	if($funcion==26){
$_ano = $_POST['ano'];
$result = $ob_Vitacora->cargaDerExt($rut_alumno,$rdb);
if($result){
	    $tabla1 = '  <label for="listaevaluadores8">Datos Derivacion Externa</label>
	  <table width="100" id="flex8"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="150" >Periodo</th>
		  <th width="150" >Curso</th>
		  <th width="250" >Evaluador</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
	      <th width="50" >Ver</th>	
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano'];
	  $i = $e;
	  $i++;
	    if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaDerExt(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
		 }}
		 if($modifica==1){
		   if($nro_ano==$nroAno){
	  $modificar = "<a onclick='buscarDerExt(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	      }}
	  $buscar = "<a onclick='DialogDerExt(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$buscar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 26


	if($funcion==27){

 	$result = $ob_Vitacora->buscaDerExt($_POST['id_vitacora']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora_DerExt" type="hidden" value="'.$id_vitacora.'" />';
				echo '<input id="_nombreper_DerExt" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodo_DerExt" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano_DerExt" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_docente_DerExt" type="hidden" value="'.$fila['rut_emp'].'" />';
				echo '<input id="nom_docente_DerExt" type="hidden" value="'.$fila['nombre_empleado'].'" />';
				echo '<input id="_obs_DerExt" type="hidden" value="'.$fila['observacion'].'" />';
				echo '<input id="_evaluador_DerExt" type="hidden" value="'.$fila['nombre'].'" />';
				echo '<input id="_id_concepto_vitacora_DerExt" type="hidden" value="'.$fila['id_conceptos_vitacora'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
}//fin funcion 28

	if($funcion==28){
	$result = $ob_Vitacora->actualizarDerExt($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 28
 
 	if($funcion==29){
 	$result = $ob_Vitacora->EliminaDerExt($id_vitacora);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }
 
 
 	if($funcion==30){
	$result = $ob_Vitacora->insertarAcTom($periodo,$fecha,$evaluador,$docente,$obser,$ano,$rutalumno,$tipo,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 30
 
 	if($funcion==31){
$_ano = $_POST['ano'];
$result = $ob_Vitacora->cargaAcTom($rut_alumno,$rdb);
if($result){
	    $tabla1 = '  <label for="listaevaluadores9">Datos Acuerdos Tomados</label>
	  <table width="100" id="flex9"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="150" >Periodo</th>
		  <th width="200" >Curso</th>
		  <th width="200" >Evaluador</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
		  <th width="50" >Ver</th>
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano'];
	  $i = $e;
	  $i++;
	   if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaAcTom(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
	    }}
		  if($modifica==1){
		   if($nro_ano==$nroAno){
	  $modificar = "<a  onclick='buscarAcTom(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	  }}
	  $buscar = "<a  onclick='DialogAcTom(".$fila['id_vitacora'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="200">'.$fila['nombre'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$buscar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 31
 
 	if($funcion==32){

 	$result = $ob_Vitacora->buscaAcTom($_POST['id_vitacora']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora_AcTom" type="hidden" value="'.$id_vitacora.'" />';
				echo '<input id="_nombreper_AcTom" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodo_AcTom" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano_AcTom" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_docente_AcTom" type="hidden" value="'.$fila['rut_emp'].'" />';
				echo '<input id="nom_docente_AcTom" type="hidden" value="'.$fila['nombre_empleado'].'" />';
				echo '<input id="_obs_AcTom" type="hidden" value="'.$fila['observacion'].'" />';
				echo '<input id="_evaluador_AcTom" type="hidden" value="'.$fila['nombre'].'" />';
				echo '<input id="_id_concepto_vitacora_AcTom" type="hidden" value="'.$fila['id_conceptos_vitacora'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
}//fin funcion 32

	if($funcion==33){
	$result = $ob_Vitacora->actualizarAcTom($periodo,$fecha,$evaluador,$docente,$obser,$id_vitacora);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 33
 
 
 	if($funcion==34){
 	$result = $ob_Vitacora->EliminaAcTom($id_vitacora);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }// fin funcion 34
 
 
 	if($funcion==35){
	$result = $ob_Vitacora->insertarDestaca($periodo,$fecha,$destaca1,$destaca2,$destaca3,$destaca4,$ano,$rutalumno,$rdb,$curso);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 35

	
	if($funcion==36){
$_ano = $_POST['ano'];
$result = $ob_Vitacora->cargaDestaca($rut_alumno,$rdb);
if($result){
	    $tabla1 = '  <label for="listaevaluadores2">Datos Destaca</label>
	  <table width="100" id="flex2"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="100" >Periodo</th>
		  <th width="100" >Curso</th>
		  <th width="90" >Destaca por 1</th>
		  <th width="90" >Destaca por 2</th>
		  <th width="90" >Destaca por 3</th>
		  <th width="100" >Destaca por 4</th>
		  <th width="50" >Modificar</th>
		  <th width="50" >Eliminar</th>
		  <th width="50" >Buscar</th>
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano'];
	  $i = $e;
	  $i++;
	    if($elimina==1){
		   if($nro_ano==$nroAno){
	  $eliminar = "<a onclick='EliminaDestaca(".$fila['id_vitacora_destaca'].")' ><img src='img/PNG-48/Delete.png' width='18' height='18' border='0' /></a>";
		 }}
	   if($modifica==1){
 	     if($nro_ano==$nroAno){
	  $modificar = "<a  onclick='buscarDestaca(".$fila['id_vitacora_destaca'].")' ><img src='img/PNG-48/Modify.png' width='18' height='18' border='0' /></a>";
	  }}
	   $buscar="<a onclick='DialogDestaca(".$fila['id_vitacora_destaca'].")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="50">'.$fila['nro_ano'].'&nbsp;</td>
      <td width="150">'.$fila['nombre_periodo'].'&nbsp;</td>
	 <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="200">'.$fila['destaca1'].'&nbsp;</td>
	  <td width="200">'.$fila['destaca2'].'&nbsp;</td>
	  <td width="200">'.$fila['destaca3'].'&nbsp;</td>
	  <td width="200">'.$fila['destaca4'].'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="50" style="cursor:pointer">'.$eliminar.'&nbsp;</td>
	   <td width="50" style="cursor:pointer">'.$buscar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 36
 
 if($funcion==37){

 	$result = $ob_Vitacora->buscaDestaca($_POST['id_vitacora_destaca']);
	
	if($result){
		if(pg_numrows($result)>0){
				$fila = pg_fetch_array($result,0); 
				echo '<input id="_id_vitacora_Destaca" type="hidden" value="'.$id_vitacora_destaca.'" />';
				echo '<input id="_nombreper_Destaca" type="hidden" value="'.$fila['nombre_periodo'].'" />';
				echo '<input id="_id_periodo_Destaca" type="hidden" value="'.$fila['id_periodo'].'" />';
				echo '<input id="_ano_Destaca" type="hidden" value="'.$fila['fecha'].'" />';
				echo '<input id="_destaca1" type="hidden" value="'.$fila['destaca_1'].'" />';
				echo '<input id="_destaca2" type="hidden" value="'.$fila['destaca_2'].'" />';
				echo '<input id="_destaca3" type="hidden" value="'.$fila['destaca_3'].'" />';
				echo '<input id="_destaca4" type="hidden" value="'.$fila['destaca_4'].'" />';
				echo '<input id="_id_concepto_vitacora_Destaca" type="hidden" value="'.$fila['id_conceptos_vitacora'].'" />';
		}else{
		echo 0;
		}
	}else{
		echo 0;
	}
}//fin funcion 37

	
	if($funcion==38){
	$result = $ob_Vitacora->actualizarDestaca($periodo,$fecha,$destaca1,$destaca2,$destaca3,$destaca4,$id_vitacora_destaca);
	if($result){
	   echo 1;
	}else{ 
	   echo 0; 
	}

 } // fin funcion 38
 
 	if($funcion==39){
 	$result = $ob_Vitacora->EliminaDestaca($id_vitacora_destaca);
	if($result){
		echo 1;
	}else{
		echo 0;
	}
 }// fin funcion 39
 
 
 
 	if($funcion==40){
$_ano = $_POST['ano'];
$result = $ob_Vitacora->cargaRendimiento($rut_alumno,$rdb,$periodo,$nro_ano);
if($result){
	    $tabla1 = '<label for="cargartablaramos">Datos Rendimiento</label>
	  <table width="100" id="flex3"  style="display:none" >
	  <thead>
		<tr align="center" >
		  <th width="270" >Asignatura</th>
		  <th width="75" >Nota</th>
		 
		  <th width="230" >Observaci&oacute;n</th>
		  <th width="100" >Notas Parciales</th>
		  <th width="50" >Guardar</th>
		  
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $nro_ano = $fila['nro_ano']; 
	 $promedio=$fila['promedio'];
	$nombreramo=$fila['nombre'];
	 if($promedio==0){
			$concepto= "&nbsp;";
				}
			else if ($promedio<40 and $promedio>0 ){
			 $concepto= "Insuficiente";
			}else{
			  $concepto="Suficiente";
				}
	  $i = $e;
	  $i++;
	 
	$modificar = "<img title='Ver Notas Parciales' onclick='buscarNotas(".$fila['id_ramo'].")' src='img/PNG-48/Modify.png' width='18' height='18' border='0'/>";
	if($ingreso==1){
		 //if($nro_ano==$nroAno){
	$guardar = "<img title='Guardar Registro' onclick='cargardatosRendimiento(".$fila['id_ramo'].",".$i.")' src='img/PNG-48/Add.png' width='18' height='18' border='0'/>";
	}//}
	$tabla1 .= '<tr align="center">
	<td><label id="nombreramo">'.$nombreramo.'</label>&nbsp;
	<input type="hidden" name="id_ramo" id="id_ramo" disabled="disabled" size="%" value='.$fila['id_ramo'].'>&nbsp;</td>
	<td width=""><label>'.$promedio.'</label>
	<input type="hidden" name="nota'.$i.'" id="nota'.$i.'" value='.$promedio.'>&nbsp;</td>
	
	<td width=""><INPUT  type="text" size="65" name="observacionren'.$i.'" id="observacionren'.$i.'" value='.$fila['observacion'].' ></td>
	  <td width="" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  <td width="" style="cursor:pointer">'.$guardar.'&nbsp;</td>
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 36
 
 		
if($funcion==41){
$resultnotas = $ob_Vitacora->buscaNotas($rut_alumno,$rdb,$periodo,$nro_ano,$id_ramo,$textoEscogidonota);

		if($resultnotas){
	   $tablanotas = '<label>'.$textoEscogidonota.'</label>
	  <table width="70" id="tablanotas" class="textosimple" >
		<tr class="textosimple" >
		  <td width="2" > N&deg;1</td>
		  <td width="2" > N&deg;2</td>
		  <td width="2" > N&deg;3</td>
		  <td width="2" > N&deg;4</td>
		  <td width="2" > N&deg;5</td>
		  <td width="2" > N&deg;6</td>
		  <td width="2" > N&deg;7</td>
		  <td width="2" > N&deg;8</td>
		  <td width="2" > N&deg;9</td>
		  <td width="2" > N&deg;10</td>
		  <td width="2" > N&deg;11</td>
		  <td width="2" > N&deg;12</td>
		  <td width="2" > N&deg;13</td>
		  <td width="2" > N&deg;14</td>
		  <td width="2" > N&deg;15</td>
		  <td width="2" > N&deg;16</td>
		  <td width="2" > N&deg;17</td>
		  <td width="2" > N&deg;18</td>
		  <td width="2" > N&deg;19</td>
		  <td width="2" > N&deg;20</td>
		  <td width="10" >Promedio</td>
		</tr><br>';
	  for($j=0;$j<pg_numrows($resultnotas);$j++){
	  $filanotas = pg_fetch_array($resultnotas,$j);
	  echo $nombreramos=$filanotas['nombre']."<br>";
	  $promedio=$filanotas['promedio'];
	 
     $tablanotas .= '<tr class="textosimple">
	 
	  
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota1'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota2'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota3'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota4'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota5'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota6'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota7'].'></td>
	   <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota8'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota9'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota10'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota11'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota12'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota13'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota14'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota15'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota16'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota17'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota18'].'></td>
	  <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota19'].'></td>
	 <td><input type="text" name="id_ramo" id="id_ramo" disabled="disabled" size="1" value='.$filanotas['nota20'].'></td>
	 <td><input type="text" name="promedio" id="promedio" disabled="disabled" size="1" value='.$filanotas['promedio'].'></td>
    </tr>';																																																																																																																																				
     }// fin for
    $tablanotas .= "</table>";																																	
    echo $tablanotas;	
			}else{ 
	   echo "Sin Notas"; 
	}
	 
		}

		
		if($funcion==42){
	$result = $ob_Vitacora->insertarRendimento($periodo,$fecha,$ano,$rutalumno,$observacion,$id_ramo,$rdb,$nota,$id_vitacora_nota,$curso);
	if($result ){
	   echo 1;
	}else{ 
	   echo 0; 
	}
 } // fin funcion 42
 
 		
	if($funcion==43){
$_ano = $_POST['ano'];
$result = $ob_Vitacora->cargatablaRendimiento($rut_alumno,$rdb,$periodo,$nro_ano);
if($result){
	    $tabla1 = '<label for="listaevaluadores10">Tabla Rendimiento</label>
	  <table width="100" id="flexRen" >
	  <thead>
		<tr align="center" >
		  <th width="50" >A&ntilde;o</th>
		  <th width="150" >Periodo</th>
		  <th width="150" >Curso</th>
		  <th width="100" >Ver Observaciones</th>
		 
		</tr>
		</thead>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $i = $e;
	  $i++;
	
	  $modificar = "<a  onclick='cargadatosRendimiento(".$fila['id_ano'].",".$i.")' ><img src='img/PNG-48/Search.png' width='18' height='18' border='0' /></a>";
      $tabla1 .= '<tr align="center">
      <td width="100">'.$fila['nro_ano'].'
	  <input type="hidden" name="id_del_ano'.$i.'" id="id_del_ano'.$i.'" value='.$fila['id_ano'].'>
	  </td>
      <td width="200">'.$fila['nombre_periodo'].'&nbsp;</td>
	  <td width="150">'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
	  <td width="100" style="cursor:pointer">'.$modificar.'&nbsp;</td>
	  
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 43
 
 
 	if($funcion==44){
$_ano = $_POST['ano'];
$result = $ob_Vitacora->cargadatosRendimiento($rut_alumno,$rdb,$periodo,$nro_ano);
if($result){
	    $tabla1 = '
	  <table width="100%" border="1" >
		<tr align="center" class="textonegrita" bgcolor="#CCCCCC" >
		  <td  ">Fecha</td>
		  <td  ">Asignatura</td>
		  <td " >Observacion</td>
		</tr>
		<tbody>';
	  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);
	  $i = $e;
	  $i++;
      $tabla1 .= '<tr align="center" class="textosimple">
	   <td >'.$fila['fecha'].'&nbsp;</td>
      <td >'.$fila['nombre'].'&nbsp;</td>
	  <td >'.$fila['observacion'].'&nbsp;</td>
	  
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 44
 
 	
	if($funcion==45){
$result = $ob_Vitacora->dialogAnte($id_vitacora);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '  <label >Datos Antecedentes</label>
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >Fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Observaci&oacute;n:</td>
		  <td ><textarea name="observDae" cols="60" rows="3" id="observDae">'.$fila['observacion'].'</textarea>&nbsp;</td>
		</tr>
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 45
 
 
  if($funcion==46){
$result = $ob_Vitacora->dialogDestaca($id_vitacora_destaca);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Destaca Por 1:</td>
		   <td >'.$fila['destaca1'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Destaca Por 2:</td>
		   <td >'.$fila['destaca2'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Destaca Por 3:</td>
		   <td >'.$fila['destaca3'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Destaca Por 4:</td>
		   <td >'.$fila['destaca4'].'&nbsp;</td>
		</tr>
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 46		
 
 
 		if($funcion==47){
$result = $ob_Vitacora->dialogDae($id_vitacora);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >Fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Situacion Actual:</td>
		   <td >'.$fila['nombre'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Docente:</td>
		   <td >'.$fila['nombre_empleado'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Observaci&oacute;n:</td>
		   <td ><textarea name="observDae" cols="60" rows="3" id="observDae">'.$fila['observacion'].'</textarea>&nbsp;</td>
		</tr>
		
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 47
 
 
 	if($funcion==48){
$result = $ob_Vitacora->dialogApo($id_vitacora);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >Fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Evaluador:</td>
		   <td >'.$fila['nombre'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Docente:</td>
		   <td >'.$fila['nombre_empleado'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Apoderado:</td>
		   <td >'.$fila['nombre_apoderado'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Observacion:</td>
		   <td ><textarea name="observApo" cols="60" rows="3" id="observApo">'.$fila['observacion'].'</textarea>&nbsp;</td>
		</tr>
		
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 48			
 
 
 	if($funcion==49){
$result = $ob_Vitacora->dialogAlum($id_vitacora);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >Fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Evaluador:</td>
		   <td >'.$fila['nombre'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Docente:</td>
		   <td >'.$fila['nombre_empleado'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Observacion:</td>
		   <td ><textarea name="observAlum" cols="60" rows="3" id="observAlum" >'.$fila['observacion'].'</textarea>&nbsp;</td>
		</tr>
		
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 49					
 
 
 	if($funcion==50){
$result = $ob_Vitacora->dialogDerInt($id_vitacora);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >Fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Evaluador:</td>
		   <td >'.$fila['nombre'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Docente:</td>
		   <td >'.$fila['nombre_empleado'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Observacion:</td>
		   <td ><textarea name="observAlum" cols="60" rows="3" id="observAlum" >'.$fila['observacion'].'</textarea>&nbsp;</td>
		</tr>
		
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 50					
 
 	
	if($funcion==51){
$result = $ob_Vitacora->dialogDerExt($id_vitacora);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >Fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Evaluador:</td>
		   <td >'.$fila['nombre'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Docente:</td>
		   <td >'.$fila['nombre_empleado'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Observacion:</td>
		   <td ><textarea name="observAlum" cols="60" rows="3" id="observAlum" >'.$fila['observacion'].'</textarea>&nbsp;</td>
		</tr>
		
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 50	
 
 
 	
	if($funcion==52){
$result = $ob_Vitacora->dialogAcTom($id_vitacora);
	if($result){
		  for($e=0;$e<pg_numrows($result);$e++){
	  $fila = pg_fetch_array($result,$e);

	   $tabla1 = '
	  <table class="textosimple" width="100%" border="0" cellpadding="2" cellspacing="1" >
	  <thead>
		<tr class="textosimple" >
		  <td >Fecha: </td>
		  <td >'.$fila['fecha'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td  >Periodo:</td>
		  <td >'.$fila['nombre_periodo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Curso:</td>
		  <td >'.$fila['grado_curso']."-".$fila['letra_curso']." ".$fila['nombre_tipo'].'&nbsp;</td>
		  </tr>
		  <tr class="textosimple" >
		  <td >Evaluador:</td>
		   <td >'.$fila['nombre'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Docente:</td>
		   <td >'.$fila['nombre_empleado'].'&nbsp;</td>
		</tr>
		<tr class="textosimple" >
		  <td >Observacion:</td>
		   <td ><textarea name="observAlum" cols="60" rows="3" id="observAlum" >'.$fila['observacion'].'</textarea>&nbsp;</td>
		</tr>
		
		</thead>
		<tbody>';
	
      $tabla1 .= '<tr align="center">
	
    </tr>';																																																																																																																																				
     }// fin for
    $tabla1 .= "<tbody></table>";																																	
    echo $tabla1;	   
	   
	}else{ 
	   echo 0; 
	}

 } // fin funcion 50				
 	
	
	if($funcion==53){ // INGRESO DE APODERADO NUEVO

	$rut_apo = $_REQUEST['rut_apo'];

	$dig_rut = $rut_apo{strlen($rut_apo)-1}; 

	$rut_apo = str_replace('.','',$rut_apo);
	$rut_apo = str_replace('-','',$rut_apo);
	$rut_apo = substr($rut_apo,0,-1);

	$nombre_apo = $_REQUEST['nombre_apo'];
	$apaterno_apo = $_REQUEST['apaterno_apo'];
	$amaterno_apo = $_REQUEST['amaterno_apo'];
	$telefono_apo = $_REQUEST['telefono_apo'];
	$email_apo = $_REQUEST['email_apo'];
	$rut_alumno = $_REQUEST['rut_alumno'];
$regis = $ob_Vitacora->ingreso_apoderado($rut_apo,$dig_rut,$nombre_apo,$apaterno_apo,$amaterno_apo,$telefono_apo,$email_apo, $rut_alumno);
  
  }
	
 	if($funcion==54){
	
	$regis = $ob_Vitacora->cargaSelectApo($rutusuario);
		
		?>
		&nbsp;
        <Select name="cmbApo" id="cmbApo" >
                      <option value="0" selected>Apoderado</option>
                      <?php
								for($i=0 ; $i < @pg_numrows($regis) ; $i++){
									$filaap = @pg_fetch_array($regis,$i);
									$rut_apo=$filaap['rut_apo'];
		echo  "<option value=".$rut_apo.">".$filaap["ape_pat"]." ".$filaap["ape_mat"].", ".$filaap["nombre_apo"]."</option>";
								}
							
						?>
                    </Select>  
            <a onclick='ingreso_apoderado(0)' ><img src='img/PNG-48/Add.png' align="top"  width='25' height='25' border='0' style="cursor:pointer" title="Agregar Apoderado" /></a>       
                <?	} 
 
		
		 ?>