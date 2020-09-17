<?php
//print_r($_POST);
//exit;
require('../../../util/header.inc');?>
<?php

$rdb    = $_INSTIT;
$frmModo= $_FRMMODO;

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}

if (($pesta==2) and ($eli==1)){
    $q1 = "delete from habilitaciones where id_aux = '$id_aux'";
	$r1 = pg_Exec($conn,$q1);	
	
	
	echo "<script>window.location='empleado.php3?pesta=2&m1=1'</script>";
	exit();	
	
}	   



if (($pesta==2) and ($h==1)){   
    // primero consutlo si existe tal registro
	$q1 = "select * from habilitaciones where rut_emp = '$rut_emp' and id_ano = '$_ANO' and cod_subsector = '$cmb_subsector' and tipo_ense = '$cmb_tipoensenanza'";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	
	if (($c1!=1) OR (!isset($c1))){
	    $c1=0;
	}
	if (($c2!=1) OR (!isset($c2))){
	    $c2=0;
	}
	if (($c3!=1) OR (!isset($c3))){
	    $c3=0;
	}
	if (($c4!=1) OR (!isset($c4))){
	    $c4=0;
	}
	if (($c5!=1) OR (!isset($c5))){
	    $c5=0;
	}
	if (($c6!=1) OR (!isset($c6))){
	    $c6=0;
	}
	if (($c7!=1) OR (!isset($c7))){
	    $c7=0;
	}
	if (($c8!=1) OR (!isset($c8))){
	    $c8=0;
	}
	if (($EP!=1) OR (!isset($EP))){
	    $EP=0;
	}
	if (($EDA!=1) OR (!isset($EDA))){
	    $EDA=0;
	}
	if (($EDM!=1) OR (!isset($EDM))){
	    $EDM=0;
	}
	if (($EDV!=1) OR (!isset($EDV))){
	    $EDV=0;
	}
	if (($EAL!=1) OR (!isset($EAL))){
	    $EAL=0;
	}
	if (($ETM!=1) OR (!isset($ETM))){
	    $ETM=0;
	}
	if (($EA!=1) OR (!isset($EA))){
	    $EA=0;
	}
	
	
		
	$dd = substr($h_fecha,0,2);
	$mm = substr($h_fecha,3,2);
	$aa = substr($h_fecha,6,4);
	$h_fecha = "$aa-$mm-$dd";
		
			
	if ($n1==0){ // ingreso la habilitacion
	
	$sql ="SELECT max(id_aux) FROM habilitaciones";
	$rs_hab = @pg_exec($conn,$sql);
	$id_aux= @pg_result($rs_hab,0) + 1;
	   $q2 = "insert into habilitaciones (id_aux,rut_emp, fecha, id_ano, resolucion, inscripcion, tipo_aut, cod_subsector, tipo_ense, c1, c2, c3, c4, c5, c6, c7, c8, EP, EDA, EDM, EDV, EAL, ETM, EA)
		values ('$id_aux','$rut_emp','$h_fecha','$_ANO','$h_resolucion','$h_inscripcion','$h_tipo_aut','$cmb_subsector','$cmb_tipoensenanza','$c1','$c2','$c3','$c4','$c5','$c6','$c7','$c8','$EP','$EDA','$EDM','$EDV','$EAL','$ETM','$EA')";   
        $r2 = pg_Exec($conn,$q2);
		
		// actualizo en la tabla empleado
		$q22 = "update empleado set titulo = '0', habilitado = '1', fecha_resol = '$h_fecha', nu_resol = '$h_resolucion' where rut_emp = '$rut_emp'";
		
		$r22 = @pg_Exec($conn,$q22);
	}	
		
			
	echo "<script>window.location='empleado.php3?pesta=2&m1=1'</script>";
	exit();	
}		





if (($pesta == 5) and ($borrar == 1)){
       // borrar
	   $q1 = "delete from relacion_grupo where rut_integrante = '".trim($_EMPLEADO)."' and id_grupo = '$id_grupo'";
	   $r1 = pg_Exec($conn,$q1);
	   
	   echo "<script>window.location='empleado.php3?pesta=5'</script>";
	   	
	   exit();
}	


if (($pesta==5) and ($graba==1)){
       // Agregar grupo al alumno
	   $q1 = "select * from grupos where rdb = '".trim($rdb)."' order by id_grupo Desc";
	   $r1 = pg_Exec($conn,$q1);
	   $n1 = pg_numrows($r1);	   
	   $i = 0;
	   while ($i < $n1){
	      $f1 = pg_fetch_array($r1,$i);
	      $id_grupo = $f1['id_grupo'];
	       	      
		   for($x=0;$x<$n1;$x++)
		   {
		   	   $chg = "chg".$x;
		       $chg = $$chg;	   
	
		   if (trim($chg) == trim($id_grupo)){		     			  			   
		      // antes de agregar consultar si ya existe
			  $q3 = "select * from relacion_grupo where id_grupo = '$id_grupo' and rut_integrante = '".trim($_EMPLEADO)."'";
			  $r3 = pg_Exec($conn,$q3);
			  $n3 = pg_numrows($r3);
			  if ($n3==0){  // Inserto		   
			      // debo rescatar el perfil del empleado
				  //$q3 = "select * from accede, usuario where accede.id_usuario = usuario.id_usuario and usuario.nombre_usuario = '$_EMPLEADO'    
			  			  
		   		  // Agrego al alumno en detalle_grupos			   
				  $q2 = "insert into relacion_grupo (id_grupo, rut_integrante, id_ano)
				  values ($id_grupo,".trim($_EMPLEADO).",$_ANO)";
				  $r2 = pg_Exec($conn,$q2)or die("Fallo Insert");
								   
				  // registro insertado
			   }	   
		   }
		  }
		   $i++;
	   }	   	    

	    //fin proceso
	   echo "<script>window.location = 'empleado.php3?pesta=5'</script>";
	   	
	   //exit();
}		 



/*print_r($tipo_titulo);
print_r($cod_subsector);
echo $cod_subsector;*/

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

"<br>combo=".$cmbCARGO;
"<br>combo0=".$cmbCARGO0;
"<br>combo1=".$cmbCARGO1;
"<br>combo2=".$cmbCARGO2;
"<br>cargo2=".$cmbCARGO1;
"<br>cargo1=".$cmbCARGO0;

$dia = substr($txtFECHA,0,2);
$mes = substr($txtFECHA,3,2);
$ano = substr($txtFECHA,6,4);
$txtFECHA = "$ano$mes$dia";
if($txtFECHA=="--")$txtFECHA = "";
$cmbTITULO=0;
//$habilitado_para=serialize($cod_subsector);
if (!$cmbCARGO0){$cmbCARGO0=0;}
if (!$cmbCARGO1){$cmbCARGO1=0;}


if (!$tipo_titulo){$tipo_titulo=array();}
if (in_array("1",$tipo_titulo)){$habilitado=1;}else{$habilitado=0;}
if (in_array("2",$tipo_titulo)){$titulado=1;}else{$titulado=0;}
if (in_array("3",$tipo_titulo)){$tit_otras=1;}else{$tit_otras=0;}


if (!isset($txtNROres)){ $txtNROres=0;}
//if (is_array($tipo_titulo)){}else{echo "no es un arreglo";} 
//exit();

if($Region=="")		$Region=1;
if($Provincia=="")	$Provincia=1;
if($Comuna=="")		$Comuna=1;

if ($txtNROres==""){ $txtNROres=0;}
if ($txtEXPERIENCIA==""){ $txtEXPERIENCIA=0;}
//txtEXPERIENCIA
//echo $txtNROres;
//echo $txtEXPERIENCIA;
if ($frmModo=="ingresar"){
$nombre = $_FILES['file']['name'];
$ext=substr($nombre, strrpos($nombre, '.'));
$newFileName=$txtRUT.$ext;
$tempFile = $_FILES['file']['tmp_name'];
$targetPath = "firma_digital/";
$targetFile =  str_replace('//','/',$targetPath) . $newFileName;
if(move_uploaded_file ($tempFile,$targetFile)){
	?>
	
	<script>alert('Archivo Cargardo Correctamente');</script>
<? }else{?>
	
<?	}



	//VERIFICAR EXISTENCIA PREVIA
	$dd = substr($fecha_nacimiento,0,2);
	$mm = substr($fecha_nacimiento,3,2);
	$aa = substr($fecha_nacimiento,6,4);
    $fecha_nacimiento = "$aa-$mm-$dd";
	
	$dd = substr($fecha_ingreso,0,2);
	$mm = substr($fecha_ingreso,3,2);
	$aa = substr($fecha_ingreso,6,4);
	$fecha_ingreso = "$aa-$mm-$dd";	
	
		
	$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$txtRUT;
	$result = pg_Exec($conn,$qry);
	$result_sop = @pg_Exec($conn2,$qry);
	if (!$result){error('<B> ERROR :</b>Error al acceder a la BD. (65)</B>');
		}else{
			if(pg_numrows($result)!=0){/*-----PREGUNTA SI EXISTE EL EMPLEADO  EXISTE-----*/
			
				if($txtFECHA==""){
					 $qry="UPDATE empleado 	
					 SET nombre_emp = '".trim($txtNOMBRE)."', 
					 ape_pat = '".trim($txtAPEPAT)."', 
					 ape_mat = '".trim($txtAPEMAT)."', 
					 fecha_nacimiento = '".trim($fecha_nacimiento)."', 
					 fecha_ingreso = '".trim($fecha_ingreso)."', 
					 horas_presente_ano = ".intval($horas_presente_ano).", 
					 prevision = '".trim($prevision)."', 
					 sistema_salud = '".trim($sistema_salud)."', 
					 calle = '".trim($txtCALLE)."', 
					 nro = '".trim($txtNRO)."', 
					 depto = '".trim($txtDEP)."', 
					 block = '".trim($txtBLO)."', 
					 villa = '".trim($txtVIL)."', 
					 region = ".$Region.", 
					 ciudad = ".$Provincia.", 
					 comuna = ".$Comuna.", 
					 telefono = '".trim($txtTELEF)."', 
					 sexo = ".$cmbSEXO.",
					  titulo = '".trim($txtTITULO)."', 
					  email = '".trim($txtEMAIL)."', 
					  estado_civil = ".$cmbCIVIL." , 
					  estudios ='".$txtESTUDIOS."' ,
					  nu_resol ='".trim($txtNROres)."', 
					  tipo_titulo=".$cmbTITULO.", 
					  telefono2 = '".trim($txtTELEF2)."', 
					  telefono3 = '".trim($txtTELEF3)."', 
					  idiomas='".trim($txtIDIOMAS)."', 
					  anos_exp='".trim($txtEXPERIENCIA)."', 
					  nacionalidad=".$cmbNac.", 
					  atencion = '".$txtAtencion."' ,
					  celular = '".$txtCELULAR."'
					  WHERE rut_emp = ".$txtRUT."; ";
				}else{
					 $qry="UPDATE empleado SET 
					 nombre_emp = '".trim($txtNOMBRE)."', 
					 ape_pat = '".trim($txtAPEPAT)."', 
					 ape_mat = '".trim($txtAPEMAT)."',  
					 fecha_nacimiento = '".trim($fecha_nacimiento)."', 
					 fecha_ingreso = '".trim($fecha_ingreso)."', 
					 horas_presente_ano = ".intval($horas_presente_ano).", 
					 prevision = '".trim($prevision)."', 
					 sistema_salud = '".trim($sistema_salud)."', 
					 calle = '".trim($txtCALLE)."', 
					 nro = '".trim($txtNRO)."', 
					 depto = '".trim($txtDEP)."', 
					 block = '".trim($txtBLO)."', 
					 villa = '".trim($txtVIL)."', 
					 region = ".$Region.", 
					 ciudad = ".$Provincia.", 
					 comuna = ".$Comuna.", 
					 telefono = ".trim($txtTELEF).", 
					 sexo = ".$cmbSEXO.", 
					 titulo = '".trim($txtTITULO)."', 
					 email = '".trim($txtEMAIL)."', 
					 estado_civil = ".$cmbCIVIL." , 
					 estudios ='".$txtESTUDIOS."' ,
					 nu_resol ='".trim($txtNROres)."' ,
					 fecha_resol ='".trim($txtFECHA)."' ,
					 tipo_titulo=".$cmbTITULO.", 
					 telefono2 = '".trim($txtTELEF2)."', 
					 telefono3 = '".trim($txtTELEF3)."', 
					 idiomas='".trim($txtIDIOMAS)."', 
					 anos_exp='".trim($txtEXPERIENCIA)."', 
					 nacionalidad=".$cmbNac.", 
					 atencion = '".$txtAtencion."' ,
					  celular = '".$txtCELULAR."'
					 WHERE rut_emp = ".$txtRUT."; ";
				}

//***********************************ACTUALIZA DATOS DE EMPLEADO EN BD. SOPORTE******************************************//
		if(@pg_numrows($result_sop)!=0){
		
		$qry_sop="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', telefono = '".trim($txtTELEF)."', email = '".trim($txtEMAIL)."', celular = '".trim($txtCELULAR)."' WHERE (((rut_emp)=".$txtRUT."))";
		$result_sop =pg_Exec($conn2,$qry_sop);
		
				if(!$result_sop){?>
				<script>alert('No se pudo ingresar datos en BD soporte  1');</script>
				<? //error('<B> ERROR :</b>Error al acceder a la BD. (soporte)'.$qry_sop);?>
				<? }		
				}else{
				
		$qry_sop="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, TELEFONO, EMAIL,CELULAR) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtTELEF)."','".trim($txtEMAIL)."','".trim($txtCELULAR)."')";
		//$result_sop =@pg_Exec($conn2,$qry_sop);	
							
				//if(!$result_sop){?>
				<!--<script>alert('No se pudo ingresar datos en BD soporte  2');</script>-->
				<? //error('<B> ERROR :</b>Error al acceder a la BD. (soporte)'.$qry_sop);?>
				<? //}		
				
				}
				
//*******************************************************************************************************************//				
				//$result =pg_Exec($conn,$qry) or die("Error".$qry);		
				
				if (!$result){ 
				
				echo "ERRO $%R$";
				
				?>
				    <!--<script>alert('Atención: Uno o más campos viene vacío. Ingrese fecha de nacimiento, Calle, Número, Fecha de ingreso, entre otros datos requeridos  1');</script>
					<script>window.location='seteaEmpleado.php3?caso=1&pesta=<?=$pesta?>&empleado=<?=$_EMPLEADO?>'</script>-->
					<?
					
				}else{
				
				
	  $qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	$result_sop2 =@pg_Exec($conn2,$qry);
	$autoriza_firma=1;

	if(!$result){
	error('<B> ERROR :</b>Error al acceder a la BD. (60)</B>');
	}else{
						
	
	if(pg_numrows($result)==0){
						
		if ($cmbCARGO1!=0){
					
	 $qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO,AUTORIZA_FIRMA) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO1.",".$autoriza_firma.")";
	$result =@pg_Exec($conn,$qry);
								
			if(@pg_numrows($result_sop2)==0){
			$result_sop =@pg_Exec($conn2,$qry); //***** INSERTA EN BD. SOPORTE ***/////
			 }	
								
		}
				
		if ($cmbCARGO2!=0){
					
	 $qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO,RESP_ANOTACION,AUTORIZA_FIRMA) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO2.",".$anotacion.",".$autoriza_firma.")";
					$result =@pg_Exec($conn,$qry);
								
			if(pg_numrows($result_sop2)==0){
			$result_sop =@pg_Exec($conn2,$qry);  //***** INSERTA EN BD. SOPORTE ***/////
			}							
		
		}
	
	}

					
				
				}
			}
////COMO ESTA INGRESADO VERIFICA LOS TITULOS, ETC....///////
				$sql_del_tit="delete from empleado_estudios where rut_empleado='".$_EMPLEADO."'";
				$res_del_tit = pg_exec($conn, $sql_del_tit);
				if (!$res_del_tit)
							error('<b> ERROR :</b>Error al acceder a la BD.(34)');

/// ---TITULOS tipo=1///
				for($k_tit=1 ; $k_tit<=3 ; $k_tit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if ((trim($txtTITULO[$k_tit])!="")&&(is_numeric($año[$k_tit]))){ 
						$sql_orden_tit = "SELECT MAX(orden) AS orden_tit from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=1";
						//exit;
						$res_orden_tit = pg_exec($conn, $sql_orden_tit);
						$fila_orden_tit = pg_fetch_array($res_orden_tit, 0);
						$new_orden_tit = $fila_orden_tit['orden_tit'] + 1;
						
						 // ANTES DE INSERTAR TOMO EL NUEVO ID
						// antes de insertar tomo al maximo valor de id_estudios
						$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
						$r6 = pg_Exec($conn,$q6); 
						$f6 = pg_fetch_array($r6,0);
						$id_estudio_new = $f6['id_estudio'];
						$id_estudio_new++;
							
							$sql_tit = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, institucion, ano, tipo, orden) ";
							$sql_tit = $sql_tit . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtTITULO[$k_tit])."', '".trim($institucion[$k_tit])."', '".trim($año[$k_tit])."' ";
							$sql_tit = $sql_tit . ", 1, ".$new_orden_tit.")";
							$res_tit = pg_exec($conn, $sql_tit);
							if (!$res_tit)
								error('<b> ERROR :</b>Error al acceder a la BD.(35)');

					}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTITULOS tipo=2///
				for($k_postit=1 ; $k_postit<=2 ; $k_postit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtPOSTITULO[$k_postit])!=""){
						$sql_orden_postit = "SELECT MAX(orden) AS orden_postit FROM empleado_estudios WHERE rut_empleado='".trim($txtRUT)."' AND tipo=2";
						$res_orden_postit = pg_exec($conn, $sql_orden_postit);
						$fila_orden_postit = pg_fetch_array($res_orden_postit, 0);
						$new_orden_postit = $fila_orden_postit['orden_postit'] + 1;
						
						// ANTES DE INSERTAR TOMO EL NUEVO ID
						// antes de insertar tomo al maximo valor de id_estudios
						$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
						$r6 = pg_Exec($conn,$q6); 
						$f6 = pg_fetch_array($r6,0);
						$id_estudio_new = $f6['id_estudio'];
						$id_estudio_new++;
							
							$sql_postit = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden) ";
							$sql_postit = $sql_postit . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtPOSTITULO[$k_postit])."' ";
							$sql_postit = $sql_postit . ", 2, ".$new_orden_postit.")";
							$res_postit = pg_exec($conn, $sql_postit);
							if (!$res_postit)
								error('<b> ERROR :</b>Error al acceder a la BD.(36)');
					
					}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTGRADOS tipo=3///
				for($k_posgra=1 ; $k_posgra<=2 ; $k_posgra++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					if (trim($txtPOSTGRADO[$k_posgra])!=""){
						$sql_orden_posgra = "SELECT MAX(orden) AS orden_posgra from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=3";
						$res_orden_posgra = pg_exec($conn, $sql_orden_posgra);
						$fila_orden_posgra = pg_fetch_array($res_orden_posgra, 0);
						$new_orden_posgra = $fila_orden_posgra['orden_posgra'] + 1;
						
						     // ANTES DE INSERTAR TOMO EL NUEVO ID
							// antes de insertar tomo al maximo valor de id_estudios
							$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
							$r6 = pg_Exec($conn,$q6); 
							$f6 = pg_fetch_array($r6,0);
							$id_estudio_new = $f6['id_estudio'];
							$id_estudio_new++;

							$sql_posgra = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden) ";
							$sql_posgra = $sql_posgra . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtPOSTGRADO[$k_posgra])."' ";
							$sql_posgra = $sql_posgra . ", 3, ".$new_orden_posgra.")";
							$res_posgra = pg_exec($conn, $sql_posgra);
							if (!$res_posgra)
								error('<b> ERROR :</b>Error al acceder a la BD.(37)');
					}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)

/// ---CURSOS RECONOCIDOS tipo=4///
				for($k_cu=1 ; $k_cu<=4 ; $k_cu++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
				if (trim($txtCURSO[$k_cu])!=""){
					$sql_orden_cu = "SELECT MAX(orden) AS orden_cu from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=4";
					$res_orden_cu = pg_exec($conn, $sql_orden_cu);
					$fila_orden_cu = pg_fetch_array($res_orden_cu, 0);
					$new_orden_cu = $fila_orden_cu['orden_cu'] + 1;
							// ANTES DE INSERTAR TOMO EL NUEVO ID
							// antes de insertar tomo al maximo valor de id_estudios
							$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
							$r6 = pg_Exec($conn,$q6); 
							$f6 = pg_fetch_array($r6,0);
							$id_estudio_new = $f6['id_estudio'];
							$id_estudio_new++;
					

							$sql_cu = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, ano, horas, tipo, orden) ";
							$sql_cu = $sql_cu . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtCURSO[$k_cu])."', '".trim($año[$k_cu])."' ";
							$sql_cu = $sql_cu . ", '".$horas[$k_cu]."', 4, ".$new_orden_cu.")";
							$res_cu = pg_exec($conn, $sql_cu);
							if (!$res_cu)
								error('<b> ERROR :</b>Error al acceder a la BD.(38)');
				}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)



				
				echo "<html><title>ADVERTENCIA</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ADVERTENCIA: EL EMPLEADO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.";
				echo "<BR>";
				echo "LA INFORMACION HA SIDO ACTUALIZADA...";
				echo "<BR><BR><BR>";
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarEmpleado.php3\";>";
				echo "</center></body></html>";
				/*----------TERMINA DE ACTUALIZAR UANDO YA EXISTIA--------------*/
				
				
			}else{/*----------COMIENZA A INSERTAR CUANDO NO EXISTE--------------*/
			$cmbTITULO=0;
			    if ($te==1 OR $to==1){
				    $txtTITULO=1;
				}			
				
				if($txtCALLE==""){$txtCALLE="-";}	
				if($txtNRO==""){$txtNRO="-";}
				if($txtDEP==""){$txtDEP="-";}
				if($txtBLO==""){$txtBLO="-";}
				if($txtVIL==""){$txtVIL="-";}
				if($txtTELEF==""){$txtTELEF="-";}
				if($txtEMAIL==""){$txtEMAIL="-";}
				if($txtTITULO==""){$txtTITULO="0";}
				if($txtESTUDIOS==""){$txtESTUDIOS="0";}
				if($txtNROres==""){$txtNROres="0";}
				if($txtIDIOMAS==""){$txtIDIOMAS="0";}
				if($txtEXPERIENCIA==""){$txtEXPERIENCIA="0";}
				if($txtAtencion==""){$txtAtencion="0";}
				if($habilitado==""){$habilitado="0";}
				if($tit_otras==""){$tit_otras="0";}
				if(strlen($horas_presente_ano)==0){$horas_presente_ano="0";}	
				if($sistema_salud==""){$sistema_salud="0";}
				if($txtTELEF2==""){$txtTELEF2="0";}
				if($txtCELULAR==""){$txtCELULAR="0";}
				if($fecha_nacimiento==""){$fecha_nacimiento="0";}
				if($fecha_ingreso==""){$fecha_ingreso="01/01/2001";}
				$titulado=1;
				
					
				
				if($txtFECHA==""){
				
					
					
				
				$qry="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, TITULO, EMAIL, ESTADO_CIVIL, ESTUDIOS, NU_RESOL, TIPO_TITULO, IDIOMAS, ANOS_EXP, NACIONALIDAD, ATENCION,habilitado,titulado,tit_otras, horas_presente_ano, prevision,sistema_salud,telefono2, telefono3, fecha_nacimiento,fecha_ingreso,celular) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($Region).",".trim($Provincia).",".trim($Comuna).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtTITULO)."','".trim($txtEMAIL)."',".$cmbCIVIL.",'".$txtESTUDIOS."','".trim($txtNROres)."',".$cmbTITULO.", '".trim($txtIDIOMAS)."', '".trim($txtEXPERIENCIA)."', ".$cmbNac.",'".$txtAtencion."','$habilitado','$titulado','$tit_otras','".intval($horas_presente_ano)."','$prevision','$sistema_salud','$txtTELEF2','$txtTELEF3','$fecha_nacimiento','$fecha_ingreso','$txtCELULAR')";
				
				}else{
					  
					  $qry="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, CALLE, NRO, DEPTO, BLOCK, VILLA, REGION, CIUDAD, COMUNA, TELEFONO, SEXO, TITULO, EMAIL, ESTADO_CIVIL, ESTUDIOS, NU_RESOL, FECHA_RESOL, TIPO_TITULO, IDIOMAS, ANOS_EXP, NACIONALIDAD, ATENCION,habilitado,titulado,tit_otras, horas_presente_ano, prevision,sistema_salud,telefono2, telefono3, fecha_nacimiento,fecha_ingreso,celular) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtCALLE)."','".trim($txtNRO)."','".trim($txtDEP)."','".trim($txtBLO)."','".trim($txtVIL)."',".trim($Region).",".trim($Provincia).",".trim($Comuna).",'".trim($txtTELEF)."',".trim($cmbSEXO).",'".trim($txtTITULO)."','".trim($txtEMAIL)."',".$cmbCIVIL.",'".$txtESTUDIOS."','".trim($txtNROres)."','".trim($txtFECHA)."',".$cmbTITULO.", '".trim($txtIDIOMAS)."', '".trim($txtEXPERIENCIA)."', ".$cmbNac.", '".$txtAtencion."','$habilitado','$titulado','$tit_otras','".intval($horas_presente_ano)."','$prevision','$sistema_salud','$txtTELEF2','$txtTELEF3','$fecha_nacimiento','$fecha_ingreso','$txtCELULAR')";
					  
				}
				
				$result =pg_Exec($conn,$qry)or die("error al Ingreso".$qry);


//******************************************INSERTA A EMPLEADOS EN BD. SOPORTE **********************************//				
			
		if(pg_numrows($result_sop)==0){
				
		$qry_sop="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, TELEFONO, EMAIL,CELULAR) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtTELEF)."','".trim($txtEMAIL)."','$txtCELULAR')";
		//$result_sop =pg_Exec($conn2,$qry_sop);
	
				}
				
				
				
				/// NUEVO CÓDIGO, INSERTAMOS EN LA BASE DE DATOS MAESTRA COI_FINAL SI ES QUE ES DE UNA CORPORACIÓN
				$sql_corp = "select num_corp from corp_instit where rdb = '".$_INSTIT."'";
			
				//$res_corp = @pg_Exec($conn, $sql_corp);
				//$num_corp = @pg_numrows($res_corp);
				
				
				if ($num_corp>0){ 
				
						$qry_emp="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, TELEFONO, EMAIL,CELULAR) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtTELEF)."','".trim($txtEMAIL)."','$txtCELULAR')";
						$result_emp =pg_Exec($conn,$qry_emp);
						
						/// insertamos en trabaja
						echo  $sql_trabaja = "insert into trabaja (rdb, rut_emp, cargo,autoriza_firma) values ('".$_INSTIT."', '".trim($txtRUT)."', '5',".$autoriza_firma.")";
						//$result_trabaja = pg_Exec($conn3, $sql_trabaja);
				}
				//// FIN NUEVO CODIGO  /////  .. by David
				
//***************************************************************************************************************//		
			
						
				if (!$result){
					//error('<b> ERROR :</b>Error al acceder a la BD.(63)'.$qry);
				}else{
//				vhs
					$qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					//$result =pg_Exec($conn,$qry);
					//$result_sop2 =pg_Exec($conn2,$qry);
					if(!$result){
						//error('<B> ERROR :</b>Error al acceder a la BD. (81)</B>');
					}else{
					
						
					if ($cmbCARGO2!=0){
							//$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO2.")";
							echo $qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO2.")";
							//$result =@pg_Exec($conn,$qry);
							//if(pg_num_rows($result_sop2)==0){
							//$result_sop =@pg_Exec($conn2,$qry); //<--------- INSERTA EN BD. SOPORTE ***/////
								//}
							}
					if ($cmbCARGO1!=0){
							 //$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO1.")";
						echo 	$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO1.")";
							$result =pg_Exec($conn,$qry);
							//if(pg_numrows($result_sop2)==0){
							//$result_sop =@pg_Exec($conn2,$qry); //<-------- INSERTA EN BD. SOPORTE ***/////
							//}
						}
						
							
					}	

				}				
					
				}

/////******COMIENZA A INSERTAR TITULOS, POSTGRADOS, ETC*******/////
				
/// ---TITULOS tipo=1///
				for($k_tit=1 ; $k_tit<=3 ; $k_tit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_tit = "SELECT MAX(orden) AS orden_tit from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=1";
					//exit;
					$res_orden_tit = pg_exec($conn, $sql_orden_tit);
					$fila_orden_tit = pg_fetch_array($res_orden_tit, 0);
					$new_orden_tit = $fila_orden_tit['orden_tit'] + 1;
						if (trim($txtTITULO[$k_tit])!=""){
						     // ANTES DE INSERTAR TOMO EL NUEVO ID
							 // antes de insertar tomo al maximo valor de id_estudios
							 $q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
							 $r6 = pg_Exec($conn,$q6); 
							 $f6 = pg_fetch_array($r6,0);
							 $id_estudio_new = $f6['id_estudio'];
							 $id_estudio_new++;
						
							$sql_tit = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, institucion, ano, tipo, orden) ";
							$sql_tit = $sql_tit . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtTITULO[$k_tit])."', '".trim($institucion[$k_tit])."', '".trim($año[$k_tit])."', ";
							$sql_tit = $sql_tit . " 1, ".$new_orden_tit.")";
							$res_tit = pg_exec($conn, $sql_tit);
							if (!$res_tit)
								error('<b> ERROR :</b>Error al acceder a la BD.(21)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTITULOS tipo=2///
				for($k_postit=1 ; $k_postit<=2 ; $k_postit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_postit = "SELECT MAX(orden) AS orden_postit from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=2";
					$res_orden_postit = pg_exec($conn, $sql_orden_postit);
					$fila_orden_postit = pg_fetch_array($res_orden_postit, 0);
					$new_orden_postit = $fila_orden_postit['orden_postit'] + 1;
						if (trim($txtPOSTITULO[$k_postit])!=""){
						     // ANTES DE INSERTAR TOMO EL NUEVO ID
							 // antes de insertar tomo al maximo valor de id_estudios
							 $q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
							 $r6 = pg_Exec($conn,$q6); 
							 $f6 = pg_fetch_array($r6,0);
							 $id_estudio_new = $f6['id_estudio'];
							 $id_estudio_new++;
							 
						
							$sql_postit = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden) ";
							$sql_postit = $sql_postit . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtPOSTITULO[$k_postit])."' ";
							$sql_postit = $sql_postit . ", 2, ".$new_orden_postit.")";
							$res_postit = pg_exec($conn, $sql_postit);
							if (!$res_postit)
								error('<b> ERROR :</b>Error al acceder a la BD.(22)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTGRADOS tipo=3///
				for($k_posgra=1 ; $k_posgra<=2 ; $k_posgra++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_posgra = "SELECT MAX(orden) AS orden_posgra from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=3";
					$res_orden_posgra = pg_exec($conn, $sql_orden_posgra);
					$fila_orden_posgra = pg_fetch_array($res_orden_posgra, 0);
					$new_orden_posgra = $fila_orden_posgra['orden_posgra'] + 1;
						if (trim($txtPOSTGRADO[$k_posgra])!=""){
						     // ANTES DE INSERTAR TOMO EL NUEVO ID
							 // antes de insertar tomo al maximo valor de id_estudios
							 $q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
							 $r6 = pg_Exec($conn,$q6); 
							 $f6 = pg_fetch_array($r6,0);
							 $id_estudio_new = $f6['id_estudio'];
							 $id_estudio_new++;
						
						
							$sql_posgra = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden) ";
							$sql_posgra = $sql_posgra . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtPOSTGRADO[$k_posgra])."' ";
							$sql_posgra = $sql_posgra . ", 3, ".$new_orden_posgra.")";
							$res_posgra = pg_exec($conn, $sql_posgra);
							if (!$res_posgra)
								error('<b> ERROR :</b>Error al acceder a la BD.(23)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---CURSOS RECONOCIDOS tipo=4///
				for($k_cu=1 ; $k_cu<=4 ; $k_cu++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$sql_orden_cu = "SELECT MAX(orden) AS orden_cu from empleado_estudios where rut_empleado='".trim($txtRUT)."' AND tipo=4";
					$res_orden_cu = pg_exec($conn, $sql_orden_cu);
					$fila_orden_cu = pg_fetch_array($res_orden_cu, 0);
					$new_orden_cu = $fila_orden_cu['orden_cu'] + 1;
					
					   if (trim($txtCURSO[$k_cu])!=""){
						     // ANTES DE INSERTAR TOMO EL NUEVO ID
							 // antes de insertar tomo al maximo valor de id_estudios
							 $q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
							 $r6 = pg_Exec($conn,$q6); 
							 $f6 = pg_fetch_array($r6,0);
							 $id_estudio_new = $f6['id_estudio'];
							 $id_estudio_new++;
						
						
							$sql_cu = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, ano, horas, tipo, orden) ";
							$sql_cu = $sql_cu . "VALUES ('$id_estudio_new','".trim($txtRUT)."', '".trim($txtCURSO[$k_cu])."', '".trim($año[$k_cu])."' ";
							$sql_cu = $sql_cu . ", '".$horas_curso[$k_cu]."', 4, ".$new_orden_cu.")";
							$res_cu = pg_exec($conn, $sql_cu);
							if (!$res_cu)
								error('<b> ERROR :</b>Error al acceder a la BD.(24)');
						}
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)

				/////******TERMINA DE INSERTAR TITULOS, POSTGRADOS, ETC*******/////

/*vhs				echo "<script>window.location = 'listarEmpleado.php3'</script>";*/
echo "<script>alert('Datos Guardados Correctamente');</script>";
echo "<script>window.location = 'listarEmpleado.php3'</script>";
if($_PERFIL!=0){
 echo "<script>window.location = 'listarEmpleado.php3'</script>";
}else{
	echo"";
	}
			}/*----------TERMINA DE INSERTAR CUANDO NO EXISTE--------------*/
		}
		


 if ($frmModo=="modificar") {
	 
    if ($horasxcontrato==NULL){
	   $horasxcontrato = 0;
	}
	if ($horasxclase== NULL){
	   $horasxclase = 0;
	}
	if ($txtIDIOMAS==NULL){
	   $txtIDIOMAS=="Ninguno";
	}         

    if ($pesta == "3"){
	   	    
        if ($t_institucion1==NULL){
		    $t_institucion1 = " ";
		}
		if ($t_institucion2==NULL){
		    $t_institucion2 = " ";
		}
		if ($t_institucion3==NULL){
		    $t_institucion3 = " ";
		}
		if ($t_hora1==NULL){
		    $t_hora1 = " ";
		}
		if ($t_hora2==NULL){
		    $t_hora2 = " ";
		}
		if ($t_hora3==NULL){
		    $t_hora3 = " ";
		}	
	
	    
	
	////  INSERT CURRICULUM///
   
	$tamano = $_FILES["archivo"]['size'];
    $tipo = $_FILES["archivo"]['type'];
	$archivo = $_FILES["archivo"]['name'];
    $newfile = $_FILES['archivo']['name'];		
	if ($archivo != "" && ($tipo=="application/msword" || $tipo=="application/pdf")) {
       $destino =  "../../../tmp/".trim($archivo);
        if (copy($_FILES['archivo']['tmp_name'],$destino)) {
            $status = "Archivo subido: <b>".$archivo."</b>";
        } else {
            $status = "Error al subir el archivo";
        }
    } else {
	       $status = "Error al subir archivo";
    }

	 //////********MODIFICAR FIRMA DIGITAL******////
$nombre = $_FILES['file']['name'];
$ext=substr($nombre, strrpos($nombre, '.'));
$newFileName=$_EMPLEADO.$ext;
$tempFile = $_FILES['file']['tmp_name'];
$targetPath = "firma_digital/";
$targetFile =  str_replace('//','/',$targetPath) . $newFileName;

if(move_uploaded_file ($tempFile,$targetFile)){
	?>
	<script>alert('Firma Digital Modificada');</script>
<? }else{?>
	
<?	}
	 
	 
	 

	echo $qry="UPDATE empleado SET idiomas='".trim($txtIDIOMAS)."', anos_exp='".trim($txtEXPERIENCIA)."', hxcontrato = '$horasxcontrato', t_institucion1 = '$t_institucion1' , t_institucion2 = '$t_institucion2' , t_institucion3 = '$t_institucion3' , t_hora1 = '$t_hora1' , t_hora2 = '$t_hora2' , t_hora3 = '$t_hora3' , hxclase = '$horasxclase', curriculum='$newfile' WHERE (((rut_emp)=".$_EMPLEADO."))";
	$result =@pg_Exec($conn,$qry);
       if (!$result) {
	      error('<b> ERROR :</b>Error al acceder a la BD. (40)'.$qry);
       }
	   
	  // proceso para actualizar los cargos del empleador  

$cargos ="2";

		if($cargos == 2)
		{
			 $qry="delete from  TRABAJA WHERE (RDB=".$rdb.") AND (RUT_EMP=".$_EMPLEADO.")";
			$result =@pg_Exec($conn,$qry);
			$result_sop =@pg_Exec($conn2,$qry); //<------------BORRA EN BD. SOPORTE ***********//
			
			
			$tiempo = time();
			if($anotacion!=1) $anotacion=0;
	 		 $qry2 = "insert into trabaja (rdb,rut_emp,cargo,identificador,resp_anotacion,autoriza_firma) values ('".trim($rdb)."','".trim($_EMPLEADO)."', '".trim($cmbCARGO0)."','$tiempo',".$anotacion.",".$autoriza_firma.")";
			$result2= pg_Exec($conn,$qry2)or die ("fallo".$sql);

			
			//********************* INSERTA NUEVAMENTE LOS DATOS MODIFICADOS EN BD. SOPORTE ****************//
			
		 	 $qry2_sop = "insert into trabaja (rdb,rut_emp,cargo,autoriza_firma) values ('".trim($rdb)."', '".trim($_EMPLEADO)."', '".trim($cmbCARGO0)."',".$autoriza_firma.")";	
			$result2_sop= @pg_Exec($conn2,$qry2_sop);	
			
			//***********************************************************************************************//
			
			$tiempo = $tiempo + "1";		
			if($cmbCARGO1!="0"){ 
		  	$qry3 = "insert into trabaja (rdb,rut_emp,cargo,identificador,resp_anotacion,autoriza_firma) values ('".trim($rdb)."','".trim($_EMPLEADO)."', '".trim($cmbCARGO1)."','$tiempo',".$anotacion.",".$autoriza_firma.")";
				$result3= pg_Exec($conn,$qry3);	
				
			//********************* INSERTA NUEVAMENTE LOS DATOS MODIFICADOS EN BD. SOPORTE ****************//
				
				 $qry3_sop = "insert into trabaja (rdb,rut_emp,cargo) values ('".trim($rdb)."', '".trim($_EMPLEADO)."', '".trim($cmbCARGO1)."')";
				$result3_sop= pg_Exec($conn2,$qry3_sop);			
			}
			
		
		
		//if($bool_er){
			
		if (!$bool_er){$bool_er=0;}
		if($bool_er && strlen($fecha_retiroe)>0) { echo $fecha_retiro = "'".CambioFE($fecha_retiroe)."'"; }
		else{
		$fecha_retiro="NULL";
		$bool_er=0;	
		}
		/*$fecha_retiro=(!$bool_er)?"NULL":"'".CambioFE($fecha_retiroe."'");	*/
			
		 $sql_ret = "update trabaja set bool_er=$bool_er,fecha_retiro=$fecha_retiro where rut_emp=$_EMPLEADO and rdb=".trim($rdb);	
		$result4_ret= pg_Exec($conn,$sql_ret);
		//exit;
		//}
			//************************************************************************************************//
			?>
			
		<!--<script>window.location = 'seteaEmpleado.php3?caso=1&pesta=3&empleado=<?=$_EMPLEADO?>'</script>-->
			<? 
		
		}
	   
	}else{	
	    /// aqui doy vuelta las fechas
	    $dd = substr($fecha_nacimiento,0,2);
	    $mm = substr($fecha_nacimiento,3,2);
	    $aa = substr($fecha_nacimiento,6,4);
	    $fecha_nacimiento = "$aa$mm$dd";
		
		if ($fecha_nacimiento==NULL){
		    $fecha_nacimiento = "19800101";
		}
				
	  
	    $dd = substr($fecha_ingreso,0,2);
	    $mm = substr($fecha_ingreso,3,2);
	    $aa = substr($fecha_ingreso,6,4);
	    $fecha_ingreso = "$aa$mm$dd";
	
	    if ($fecha_ingreso==NULL){
		    $fecha_ingreso = "19800101";
		}
	
	      if ($fecha_nacimiento==NULL or $fecha_nacimiento== "--"){
				      
			  $parte1 = "fecha_nacimiento = null";				      
		  }else{
			  $parte1 = "fecha_nacimiento = '$fecha_nacimiento'";				  
		  }
		  
		  if ($fecha_ingreso==NULL or $fecha_ingreso== "--"){
			 
			  $parte2 = "fecha_ingreso = null"; 
		  }else{
			  $parte2 = "fecha_ingreso = '$fecha_ingreso'";				  
		  }
		  
		  if (strlen($horas_presente_ano)==0){
			  $horas_presente_ano = 0;
		  }	
		if($m3!=0){
			list($Comuna,$Provincia,$Region)=split("_",$m3);
			
		}
		
			
		
	
	
	
	   
		if($txtFECHA=="" and $pesta==1){
		   
		$qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', fecha_nacimiento = '".trim($fecha_nacimiento)."', fecha_ingreso = '".trim($fecha_ingreso)."', horas_presente_ano = '".intval($horas_presente_ano)."', prevision = '".trim($prevision)."', sistema_salud = '".trim($sistema_salud)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$Region.", ciudad = ".$Provincia.", comuna = ".$Comuna.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' , telefono2 = '".trim($txtTELEF2)."', telefono3 = '".trim($txtTELEF3)."', idiomas='".trim($txtIDIOMAS)."', anos_exp='".trim($txtEXPERIENCIA)."', nacionalidad=".$cmbNac.", atencion = '".$txtAtencion."', habilitado='$habilitado', titulado='$titulado',tit_otras='$tit_otras',celular='$txtCELULAR' 
			 WHERE (((rut_emp)=".$_EMPLEADO."))";
		}else{
		     if (($pesta==2) and ($h==2)){  // actualizamos solo algunos datos
			 
			      if (trim($txtNROres)=="/"){
				     $txtNROres = 0;
				  }
			      
			      if (($txtFECHA==NULL)||($txtFECHA=="--/")){	
				       			  
				       $qry="UPDATE empleado SET nu_resol ='".trim($txtNROres)."' , fecha_resol = null, habilitado='$habilitado', titulado='$titulado',tit_otras='$tit_otras'  WHERE (((rut_emp)=".$_EMPLEADO."))";
				  }else{	
				      				 
			           $qry="UPDATE empleado SET nu_resol ='".trim($txtNROres)."' ,fecha_resol ='".trim($txtFECHA)."', habilitado='$habilitado', titulado='$titulado',tit_otras='$tit_otras'  WHERE (((rut_emp)=".$_EMPLEADO."))";
		          }
			 }else{	  
				  
				 $qry="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', $parte1, $parte2, horas_presente_ano = '".intval($horas_presente_ano)."', prevision = '".trim($prevision)."', sistema_salud = '".trim($sistema_salud)."', calle = '".trim($txtCALLE)."', nro = '".trim($txtNRO)."', depto = '".trim($txtDEP)."', block = '".trim($txtBLO)."', villa = '".trim($txtVIL)."', region = ".$Region.", ciudad = ".$Provincia.", comuna = ".$Comuna.", telefono = '".trim($txtTELEF)."', sexo = ".$cmbSEXO.", titulo = '".trim($txtTITULO)."', email = '".trim($txtEMAIL)."', estado_civil = ".$cmbCIVIL." , estudios ='".$txtESTUDIOS."' ,nu_resol ='".trim($txtNROres)."' ,fecha_resol =to_date('" . $txtFECHA . "','DD MM YYYY'), telefono2 = '".trim($txtTELEF2)."', telefono3 = '".trim($txtTELEF3)."', idiomas='".trim($txtIDIOMAS)."', anos_exp='".trim($txtEXPERIENCIA)."', nacionalidad=".$cmbNac.", atencion = '".$txtAtencion."', habilitado='$habilitado', titulado='$titulado', tit_otras='$tit_otras',celular='$txtCELULAR' 	
				WHERE (((rut_emp)=".$_EMPLEADO."))";           
		     }
			
         }
		 
		
		 
		$result = pg_Exec($conn,$qry);
		
		
		
	//*******************************ACTUALIZA EMPLEADO EN BD. SOPORTE *************************************************//			
				
		/* $qry_sop="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', telefono = '".trim($txtTELEF)."', email = '".trim($txtEMAIL)."' WHERE rut_emp=".$_EMPLEADO."";		
		$result_sop =@pg_Exec($conn2,$qry_sop);
		
		if(!$result_sop){?>
		<script>alert('No se pudo actualizar datos en BD soporte');</script>
		<? //error('<B> ERROR :</b>Error al acceder a la BD. (soporte)'.$qry_sop);?>
		<? }*/
				
	//*********************************************************************************************************//	
		
		

		if (!$result) {
			    ?>
				<script>alert('Atención: Uno o más campos viene vacío. Ingrese fecha de nacimiento, Calle, Número, Fecha de ingreso, entre otros datos requeridos');</script>
				<!--<script>window.location='seteaEmpleado.php3?caso=1&pesta=<?=$pesta?>&empleado=<?=$_EMPLEADO?>'</script>-->
				<?
		}else{	
		
	          
			  if ($pesta==3){	
					 $qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$_EMPLEADO." AND RDB=".$_INSTIT;
					$result =@pg_Exec($conn,$qry);
					if(!$result){
						error('<B> ERROR :</b>Error al acceder a la BD. (68)</B>');
					}else{					
						
						if(pg_numrows($result)==0){
/*							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($rdb).",".trim($_EMPLEADO).",".$cmbCARGO1.")";
							$result =@pg_Exec($conn,$qry);*/
							if (!$result) {error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);}
						}else{
							for ($i=0;$i<=pg_numrows($result);$i++){
								$row_cargo=pg_fetch_array($result);
								$arreglo_cargo[]=$row_cargo[cargo];
							}
							/*
						 	$qry="UPDATE TRABAJA SET CARGO= '$cmbCARGO1' WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$_EMPLEADO.") and cargo=$arreglo_cargo[0]";
							$result =pg_Exec($conn,$qry);
							if (!$result){error('<b> ERROR :</b>Error al acceder a la BD.(2)'.$qry);}*/
							}
							
														
				 $qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO,AUTORIZA_FIRMA) VALUES (".trim($rdb).",".trim($_EMPLEADO).",".$cmbCARGO2.",".$autoriza_firma.")";
							$result =@pg_Exec($conn,$qry);
							
							
						 if (($cmbCARGO2)&&(!$arreglo_cargo[1])){ //si no exite en la db
  							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO,AUTORIZA_FIRMA) VALUES (".trim($rdb).",".trim($_EMPLEADO).",".$cmbCARGO2.",".$autoriza_firma.")";
							$result =@pg_Exec($conn,$qry);
						 }
						 if (($cmbCARGO2)&&($arreglo_cargo[1])){ //si  exite en la db
/*							$qry="UPDATE TRABAJA SET CARGO=".$cmbCARGO2." WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$_EMPLEADO.") and cargo=$arreglo_cargo[1]";
							$result =@pg_Exec($conn,$qry);*/
						 }
						 if ((!$cmbCARGO2)&&($arreglo_cargo[1])){ //si  exite en la db
					/*	 $qry="delete from  TRABAJA WHERE (RDB=".$_INSTIT.") AND (RUT_EMP=".$_EMPLEADO.") and cargo=$arreglo_cargo[1]";
							$result =@pg_Exec($conn,$qry);*/
						 }					 
					}
			  }	
		}
		
		
		
/// ---TITULOS tipo=1///
				$sql_del_tit="delete from empleado_estudios where rut_empleado='".$_EMPLEADO."'";
				$res_del_tit = pg_exec($conn, $sql_del_tit);
				if (!$res_del_tit){
							error('<b> ERROR :</b>Error al acceder a la BD.(33)');
				}else{
				    $qry_upemp = "update empleado set titulo = '1' where rut_emp = '".$_EMPLEADO."'";
					$res_upemp = pg_exec($conn, $qry_upemp);
				} 			

				for($k_tit=1 ; $k_tit<=3 ; $k_tit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
									
					$txtTITULO = "txtTITULO_".$k_tit;
					$txtTITULO = $$txtTITULO;
					
					$c_ano     = "c_ano_".$k_tit;
					$c_ano     = $$c_ano;
					
					$institucion = "institucion_".$k_tit;
					$institucion = $$institucion;				
									
					
					if ((trim($txtTITULO)!="")&&($c_ano > 0) && ($c_ano < 3000)){
						
						$sql_orden_tit = "SELECT MAX(orden) AS orden_tit from empleado_estudios where rut_empleado='".trim($_EMPLEADO)."' AND tipo=1";
						$res_orden_tit = pg_exec($conn, $sql_orden_tit);
						$fila_orden_tit = pg_fetch_array($res_orden_tit, 0);
						$new_orden_tit = $fila_orden_tit['orden_tit'] + 1;
						
						// antes de insertar tomo al maximo valor de id_estudios
						$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
						$r6 = pg_Exec($conn,$q6); 
						$f6 = pg_fetch_array($r6,0);
						$id_estudio_new = $f6['id_estudio'];
						$id_estudio_new++;
						
																	
						    $sql_tit = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, institucion, ano, tipo, orden) ";
							$sql_tit = $sql_tit . "VALUES ('$id_estudio_new','".trim($_EMPLEADO)."', '".trim($txtTITULO)."', '".trim($institucion)."', '".trim($c_ano)."' ";
							$sql_tit = $sql_tit . ", 1, ".$new_orden_tit.")";
							$res_tit = pg_exec($conn, $sql_tit);
							
													
							if (!$res_tit)
								error('<b> ERROR :</b>Error al acceder a la BD.(33)');		
					}//fin if (trim($txtTITULO[$k_tit])!=""){		
					
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)
				
			
				


/// ---POSTITULOS tipo=2///
				for($k_postit=1 ; $k_postit<=2 ; $k_postit++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					
					$txtPOSTITULO = "txtPOSTITULO_".$k_postit;
					$txtPOSTITULO = $$txtPOSTITULO;					
					
					
					if (trim($txtPOSTITULO)!=""){
						$sql_orden_postit = "SELECT MAX(orden) AS orden_postit FROM empleado_estudios WHERE rut_empleado='".trim($_EMPLEADO)."' AND tipo=2";
						$res_orden_postit = pg_exec($conn, $sql_orden_postit);
						$fila_orden_postit = pg_fetch_array($res_orden_postit, 0);
						$new_orden_postit = $fila_orden_postit['orden_postit'] + 1;
						
						
						// ANTES DE INSERTAR TOMO EL NUEVO ID
						// antes de insertar tomo al maximo valor de id_estudios
						$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
						$r6 = pg_Exec($conn,$q6); 
						$f6 = pg_fetch_array($r6,0);
						$id_estudio_new = $f6['id_estudio'];
						$id_estudio_new++;
						
						$sql_postit = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden) ";
						$sql_postit = $sql_postit . "VALUES ('$id_estudio_new','".trim($_EMPLEADO)."', '".trim($txtPOSTITULO)."' ";
						$sql_postit = $sql_postit . ", 2, ".$new_orden_postit.")";
						$res_postit = pg_exec($conn, $sql_postit);
						if (!$res_postit)
							error('<b> ERROR :</b>Error al acceder a la BD.(35)');
					}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---POSTGRADOS tipo=3///
				for($k_posgra=1 ; $k_posgra<=2 ; $k_posgra++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$txtPOSTGRADO = "txtPOSTGRADO_".$k_posgra;
					$txtPOSTGRADO = $$txtPOSTGRADO;
					
					if ((trim($txtPOSTGRADO)!=NULL) OR (trim($txtPOSTGRADO)!='2')){
						$sql_orden_posgra = "SELECT MAX(orden) AS orden_posgra from empleado_estudios where rut_empleado='".trim($_EMPLEADO)."' AND tipo=3";
						$res_orden_posgra = pg_exec($conn, $sql_orden_posgra);
						$fila_orden_posgra = pg_fetch_array($res_orden_posgra, 0);
						$new_orden_posgra = $fila_orden_posgra['orden_posgra'] + 1;
						
						// ANTES DE INSERTAR TOMO EL NUEVO ID
						// antes de insertar tomo al maximo valor de id_estudios
						$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
						$r6 = pg_Exec($conn,$q6); 
						$f6 = pg_fetch_array($r6,0);
						$id_estudio_new = $f6['id_estudio'];
						$id_estudio_new++;

						$sql_posgra = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, tipo, orden) ";
						$sql_posgra = $sql_posgra . "VALUES ('$id_estudio_new','".trim($_EMPLEADO)."', '".trim($txtPOSTGRADO)."' ";
						$sql_posgra = $sql_posgra . ", 3, ".$new_orden_posgra.")";
						$res_posgra = pg_exec($conn, $sql_posgra);
						if (!$res_posgra)
							error('<b> ERROR :</b>Error al acceder a la BD.(37)');

					}

				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)


/// ---CURSOS RECONOCIDOS tipo=4///
				for($k_cu=1 ; $k_cu<=4 ; $k_cu++){
					//TRAIGO EL ULTIMO NRO DE ORDEN PARA EL RUT
					$txtCURSO = "txtCURSO_".$k_cu;
					$txtCURSO = $$txtCURSO;
					
					
					$ano_curso = "ano_curso_".$k_cu;
					$ano_curso = $$ano_curso;
					
					$horas_curso = "horas_curso_".$k_cu;
					$horas_curso = $$horas_curso;
					
									
					if ((trim($txtCURSO)!="")&&($ano_curso > 0)&&($horas_curso > 0)){
					    
						$sql_orden_cu = "SELECT MAX(orden) AS orden_cu from empleado_estudios where rut_empleado='".trim($_EMPLEADO)."' AND tipo=4";
						$res_orden_cu = pg_exec($conn, $sql_orden_cu);
						$fila_orden_cu = pg_fetch_array($res_orden_cu, 0);
						$new_orden_cu = $fila_orden_cu['orden_cu'] + 1;
						
						// ANTES DE INSERTAR TOMO EL NUEVO ID
						// antes de insertar tomo al maximo valor de id_estudios
						$q6 = "SELECT MAX(ID_ESTUDIO) AS ID_ESTUDIO FROM EMPLEADO_ESTUDIOS";
						$r6 = pg_Exec($conn,$q6); 
						$f6 = pg_fetch_array($r6,0);
						$id_estudio_new = $f6['id_estudio'];
						$id_estudio_new++;
						
											
							$sql_cu = "INSERT INTO empleado_estudios (id_estudio,rut_empleado, nombre, ano, horas, tipo, orden) ";
							$sql_cu = $sql_cu . "VALUES ('$id_estudio_new','".trim($_EMPLEADO)."', '".trim($txtCURSO)."', '".trim($ano_curso)."' ";
							$sql_cu = $sql_cu . ", '".$horas_curso."', 4, ".$new_orden_cu.")";
							$res_cu = pg_exec($conn, $sql_cu);
							if (!$res_cu)
								error('<b> ERROR :</b>Error al acceder a la BD.(39)');
				
					}
					
				}//fin for ($k_tit=1 ; $k_tit==3 ; $k_tit++)
				
				 $qry="UPDATE empleado SET estudios ='".$txtESTUDIOS."'  WHERE rut_emp='".trim($_EMPLEADO)."'";
				$rsqry = pg_Exec($conn,$qry);

				
					
		
		}
		
		
/*vhs 		echo "<script>window.location = 'seteaEmpleado.php3?caso=1&empleado=".$_EMPLEADO."'</script>";*/

 echo "<script>window.location = 'seteaEmpleado.php3?caso=1&pesta=".$pesta."&empleado=".$_EMPLEADO."'</script>";
}//FIN MODIFICAR




if ($frmModo=="eliminar"){
	$qry="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO='".$_EMPLEADO."'";
	$result = @pg_Exec($conn,$qry);
	$result_sop = @pg_Exec($conn2,$qry);
	$fila	= @pg_fetch_array($result,0); 
	$fila_sop	= @pg_fetch_array($result_sop,0); 

// BORRANDO LOS ACCESOS

//-----> AQUI EXISTE UN ERROR EN EL ID_USUARIO DEL DELETE!!!!!!!------------//
	$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".$fila['id_usuario']." AND RDB=".$_INSTIT; 
	$result =@pg_Exec($conn,$qry);
	
	 //********* BORRA EN BD. SOPORTE ************//
	$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".$fila_sop['id_usuario']." AND RDB=".$_INSTIT; 
	$result_del =@pg_Exec($conn2,$qry);
	//********************************************//
	
	$qry="DELETE FROM TRABAJA WHERE RUT_EMP='".$_EMPLEADO."' AND RDB=".$_INSTIT;
	$result =@pg_Exec($conn,$qry);
	$result_del =@pg_Exec($conn2,$qry); //<---------- BORRA EN BD. SOPORTE ************//

	//$sql_del_tit="DELETE FROM empleado_estudios WHERE rut_empleado='".$_EMPLEADO."'";
	//$result = pg_exec($conn, $sql_del_tit);

	//echo "<center><font face=arial><b></b></font></center>";
//	exit();
	if (!$result) {
		error('<b> ERROR :</b>Error al eliminar.');
	}else{
		echo  "<script>window.location = 'listarEmpleado.php3'</script>";
	}
}






?>