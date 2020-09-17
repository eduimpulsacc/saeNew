<?php require('../../../util/header.inc');?>
<?php

$_INSTIT = $_GET['rdb'];
$frmModo = $_GET['frmModo'];
$txtRUT = $_GET['rut'];
$txtDIGRUT = $_GET['dig_rut'];
$_EMPLEADO = $_GET['rut_emp'];


$txtNOMBRE = $_GET['nombre'];
$txtAPEPAT = $_GET['apepat'];
$txtAPEMAT = $_GET['apemat'];
$txtTELEF = $_GET['telefono'];
$txtEMAIL = $_GET['email'];
$pesta = $_GET['pesta'];

$cmbCARGO0 = $_GET['cargo0'];
$cmbCARGO1 = $_GET['cargo1'];
$cmbCARGO2 = $_GET['cargo2'];

$servidor = $_GET['servidor'];
//$_PERFIL = 0;
/*$rdb    = $_INSTIT;
$frmModo= $_FRMMODO;*/


"<br>combo=".$cmbCARGO;
"<br>combo0=".$cmbCARGO0;
"<br>combo1=".$cmbCARGO1;
"<br>combo2=".$cmbCARGO2;
"<br>cargo2=".$cmbCARGO1;
"<br>cargo1=".$cmbCARGO0;


//$habilitado_para=serialize($cod_subsector);
if (!$cmbCARGO0){$cmbCARGO0=0;}
if (!$cmbCARGO1){$cmbCARGO1=0;}


if ($frmModo=="ingresar"){

	$qry="SELECT * FROM EMPLEADO WHERE RUT_EMP=".$txtRUT;
	$result_sop = pg_Exec($conn2,$qry);
	
	
			if(pg_numrows($result_sop)!=0){/*-----PREGUNTA SI EXISTE EL EMPLEADO-----*/
			
//***********************************ACTUALIZA DATOS DE EMPLEADO EN BD. SOPORTE******************************************//
		if(pg_numrows($result_sop)!=0){
		
		$qry_sop="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', telefono = '".trim($txtTELEF)."', email = '".trim($txtEMAIL)."' WHERE (((rut_emp)=".$txtRUT."))";
		$result_sop =pg_Exec($conn2,$qry_sop);
		
				if(!$result_sop){?>
				<script>alert('No se pudo ingresar datos en BD soporte1');</script>
				<? //error('<B> ERROR :</b>Error al acceder a la BD. (soporte)'.$qry_sop);?>
				<? }		
				}else{
				
		$qry_sop="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, TELEFONO, EMAIL) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtTELEF)."','".trim($txtEMAIL)."')";
		$result_sop =pg_Exec($conn2,$qry_sop);
							
				if(!$result_sop){?>
				<script>alert('No se pudo ingresar datos en BD soporte2');</script>
				<? //error('<B> ERROR :</b>Error al acceder a la BD. (soporte)'.$qry_sop);?>
				<? }		
				
				}
				
//*******************************************************************************************************************//				
				

					$qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					$result_sop2 =@pg_Exec($conn2,$qry);
					if(!$result_sop2){
						error('<B> ERROR :</b>Error al acceder a la BD. (soporte_0)</B>');
					}else{
					
					$qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					$result_sop2 =@pg_Exec($conn2,$qry);
					if(!$result_sop2){
						error('<B> ERROR :</b>Error al acceder a la BD. (soporte_1)</B>');
					}else{
									
							if ($cmbCARGO1!=0){
							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO1.")";
							if(pg_numrows($result_sop2)==0){
								$result_sop =@pg_Exec($conn2,$qry); //***** INSERTA EN BD. SOPORTE ***/////
								}	
							
							}
							if ($cmbCARGO2!=0){
							$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO2.")";
							if(pg_numrows($result_sop2)==0){
							$result_sop =@pg_Exec($conn2,$qry);  //***** INSERTA EN BD. SOPORTE ***/////
								}							
							}
							//echo "vhs";
					
					

						 
					}
					
				
				}
			
				
				echo "<html><title>ADVERTENCIA</title></head>";
				echo "<body><center>";
				echo "<BR><BR><BR><BR><BR><BR><BR><BR><BR>";
				echo "ADVERTENCIA: EL EMPLEADO YA SE ENCUENTRA PREVIAMENTE INGRESADO AL SISTEMA.";
				echo "<BR>";
				echo "LA INFORMACION HA SIDO ACTUALIZADA...";
				echo "<BR><BR><BR>";
				if($servidor==NULL){
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location=\"listarEmpleado.php3\";>";
				}
				if($servidor=="antofagasta"){
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location='http://www.cmds.cl/admin/institucion/empleado/listarEmpleado.php3';>";
				}
				if($servidor=="zapallar"){
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location='http://200.29.22.36/admin/institucion/empleado/listarEmpleado.php3';>";
				}
				if($servidor=="murialdo"){
				echo "<INPUT TYPE=button value=CONTINUAR onClick=document.location='http://190.162.116.194/admin/institucion/empleado/listarEmpleado.php3';>";
				}
				echo "</center></body></html>";
				/*----------TERMINA DE ACTUALIZAR UANDO YA EXISTIA--------------*/
			}else{/*----------COMIENZA A INSERTAR CUANDO NO EXISTE--------------*/
					


//******************************************INSERTA A EMPLEADOS EN BD. SOPORTE **********************************//				
			
		if(pg_numrows($result_sop)==0){
				
		$qry_sop="INSERT INTO EMPLEADO (RUT_EMP, DIG_RUT, NOMBRE_EMP, APE_PAT, APE_MAT, TELEFONO, EMAIL) VALUES (".trim($txtRUT).",'".trim($txtDIGRUT)."','".trim($txtNOMBRE)."','".trim($txtAPEPAT)."','".trim($txtAPEMAT)."','".trim($txtTELEF)."','".trim($txtEMAIL)."')";
		$result_sop =pg_Exec($conn2,$qry_sop);
							
				if(!$result_sop){?>
				<script>alert('No se pudo ingresar datos en BD soporte3');</script>
				<? //error('<B> ERROR :</b>Error al acceder a la BD. (soporte)'.$qry_sop);?>
				<? }
				}
				
//***************************************************************************************************************//		
						
				if (!$result_sop){
					error('<b> ERROR :</b>Error al acceder a la BD.(soporte_3)'.$qry);
				}else{
//				vhs
					 $qry="SELECT * FROM TRABAJA WHERE RUT_EMP=".$txtRUT." AND RDB=".$_INSTIT;
					$result_sop2 =pg_Exec($conn2,$qry);
					if(!$result_sop2){
						error('<B> ERROR :</b>Error al acceder a la BD. (soporte_4)</B>');
					}else{
					
						
					if ($cmbCARGO2!=0){
							 $qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO2.")";
							if(pg_numrows($result_sop2)==0){
							$result_sop =@pg_Exec($conn2,$qry); //<--------- INSERTA EN BD. SOPORTE ***/////
								}
							}
					if ($cmbCARGO1!=0){
							 $qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO) VALUES (".trim($_INSTIT).",".trim($txtRUT).",".$cmbCARGO1.")";
							if(pg_numrows($result_sop2)==0){
							$result_sop =@pg_Exec($conn2,$qry); //<-------- INSERTA EN BD. SOPORTE ***/////
							}
						}
							//echo "vhs";
					}	

				}
					
				}


if($servidor==NULL){
echo "<script>window.location = 'listarEmpleado.php3'</script>";
}

if($servidor=="antofagasta"){
echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/listarEmpleado.php3'</script>";
}

if($servidor=="zapallar"){
echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/listarEmpleado.php3'</script>";
}

if($servidor=="murialdo"){
echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/listarEmpleado.php3'</script>";
}

			}/*----------TERMINA DE INSERTAR CUANDO NO EXISTE--------------*/
		//}
		



//<---------------------- FALTA MODIFICAR ESTO PARA QUE ACTUALICE EN SOPORTE DESDE CUALQUIER COLEGIO  ---------------------->


 if ($frmModo=="modificar") {

    if ($pesta == "3"){


	   
	  // proceso para actualizar los cargos del empleador  

$cargos ="2";
	

/*	  
	   if ($cargos == "0"){
	   
	        // podemos insertar dos cargos
			$tiempo = time();
			$sql_ver = "select * from trabaja where rdb = '$rdb' and rut_emp = '$_EMPLEADO'";

			//$res_ver = pg_Exec($conn,$sql_ver);
			 
					
			if ($cmbCARGO0!=0){
			    // insertamos el primer cargo
				$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO,IDENTIFICADOR) VALUES (".trim($rdb).",".trim($_EMPLEADO).",".$cmbCARGO0.",".$tiempo.")";  
				$result =pg_Exec($conn,$qry);
	            if (!$result){
				     echo "Error, no se ha insertado el cargo 1".$qry;
					 exit();
				}
		    }			
			if ($cmbCARGO1!=0){
			    // insertamos el segundo cargo
				$tiempo++;
				$qry="INSERT INTO TRABAJA (RDB,RUT_EMP,CARGO,IDENTIFICADOR) VALUES (".trim($rdb).",".trim($_EMPLEADO).",".$cmbCARGO1.",".$tiempo.")";  
				$result =pg_Exec($conn,$qry);
	            if (!$result){
				     echo "Error, no se ha insertado el cargo 2".$qry;
					 exit();
				}
		    }
			echo "<script>window.location = 'seteaEmpleado.php3?caso=1&pesta='3'&empleado=".$_EMPLEADO."'</script>";		
					
	    }
		
		
		
		if ($cargos == "1"){

		    // actualizamos el primer cargo
			$tiempo = time();
			
			$qry="select * from trabaja where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";
			$result=pg_Exec($conn,$qry);
			if (!$result){
			    echo "Error, ningun dato encontrado";
			    exit();
			}else{
			    $fila=pg_fetch_array($result,0);
			    $identificador1 = $fila['identificador'];

			    $fila2=pg_fetch_array($result,1);
			    $identificador2 = $fila2['identificador'];				
		    }
			
			if ($cmbCARGO0>0){
			    //echo "entro aquí 1 <br>";
			    if ($identificador!=NULL){
				    //echo "entro aquí 2 <br>"; 			    
			        $qry="update trabaja set cargo = '".trim($cmbCARGO0)."' where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."' and identificador = '$identificador1'";
				}else{
				    $qry="update trabaja set cargo = '".trim($cmbCARGO0)."', identificador = '$tiempo'  where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";
			        //echo "entro aqui 3 <br>";
				}			
				
	            $result= pg_Exec($conn,$qry);
				if (!$result){
				    echo "Error, cargo 1 no actualizado.".$qry;
					exit();
				}
				
				//echo "debe haber algun cambio...";
				//exit();				 				
			}else{
			     // para dejar el campo cargo en blanco
				  if ($identificador!=NULL){
				      //echo "entro aquí 2 <br>"; 			    
			          $qry="update trabaja set cargo = '0' where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."' and identificador = '$identificador1'";
				  }else{
				      $qry="update trabaja set cargo = '0', identificador = '$tiempo'  where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";
			          //echo "entro aqui 3 <br>";
			      }
			 }
			 
			 	
			 	 
			 

			
			if ($cmbCARGO1>0){
			    $tiempo++;
			    // insertamos este registro
				$qry = "insert into trabaja (rdb,rut_emp,cargo,identificador) values ('".trim($rdb)."', '".trim($_EMPLEADO)."', '".trim($cmbCARGO1)."','$tiempo')";
				$result= pg_Exec($conn,$qry);
				if (!$result){
				   echo "Error, no se ha ingresado el cargo 2. ".$qry;
				   exit();
				}
		     }else{
			 		$qry = "insert into trabaja (rdb,rut_emp,cargo,identificador) values ('".trim($rdb)."', '".trim($_EMPLEADO)."', '".trim($cmbCARGO1)."','$tiempo')";
					$result= pg_Exec($conn,$qry);
			}
			 					 
			 
					 
			 
			 echo "<script>window.location = 'seteaEmpleado.php3?caso=1&pesta='3'&empleado=".$_EMPLEADO."'</script>";
		}
*/

/*********************** CARGOS ************/		
		if($cargos == 2)
		{
			

			$qry="delete from  TRABAJA WHERE (RDB=".$rdb.") AND (RUT_EMP=".$_EMPLEADO.")";
			$result_sop =@pg_Exec($conn2,$qry); //<------------BORRA EN BD. SOPORTE ***********//
			
			
			//********************* INSERTA NUEVAMENTE LOS DATOS MODIFICADOS EN BD. SOPORTE ****************//
			
			$qry2_sop = "insert into trabaja (rdb,rut_emp,cargo) values ('".trim($rdb)."', '".trim($_EMPLEADO)."', '".trim($cmbCARGO0)."')";	
			$result2_sop= pg_Exec($conn2,$qry2_sop);	
			
			//***********************************************************************************************//
				
			if($cmbCARGO1!="0"){ 

				
			//********************* INSERTA NUEVAMENTE LOS DATOS MODIFICADOS EN BD. SOPORTE ****************//
				
			$qry3_sop = "insert into trabaja (rdb,rut_emp,cargo) values ('".trim($rdb)."', '".trim($_EMPLEADO)."', '".trim($cmbCARGO1)."')";
				$result3_sop= pg_Exec($conn2,$qry3_sop);			
			}
			
			//************************************************************************************************//
			
			if($servidor=="antofagasta"){
			echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=3&empleado=$_EMPLEADO'</script>";
			}
			
			if($servidor=="zapallar"){
			echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=3&empleado=$_EMPLEADO'</script>";
			}
			
			if($servidor=="murialdo"){
			echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=3&empleado=$_EMPLEADO'</script>";
			}
			
			?>
			
		<?php /*?><script>window.location = 'seteaEmpleado.php3?caso=1&pesta=3&empleado=<?=$_EMPLEADO?>'</script><?php */?>
			<? 
		
		}
/**VEL**/


/*		if ($cargos == 2){ 
		   // debemos actualizar los cargos
		       $tiempo = time();

		       $qry="select * from trabaja where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";

			   $result=pg_Exec($conn,$qry);
			   if (!$result){
			       echo "Error, ningun dato encontrado";
				   exit();
			   }else{
			       $fila=pg_fetch_array($result,0);
				   $identificador1 = $fila['identificador'];
				   $fila2=pg_fetch_array($result,1);
				   $identificador2 = $fila2['identificador'];
			   }
			   
			   if ($cmbCARGO0>0)
			   { 
			   		
			       //actualizamos el primer cargo
				   if ($identificador1!=NULL)
				   {
				       $qry="update trabaja set cargo = '".trim($cmbCARGO0)."' where identificador = '$identificador1' and rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";
				   }else{ 				   		
					
				       $qry="update trabaja set cargo = '".trim($cmbCARGO0)."', identificador = '$tiempo' where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";   
				   }
				   $result = pg_Exec($conn,$qry);
				   if (!$result){
				       echo "Error, no se ha actualizado el primero cargo.".$qry;
					   exit();
				   }	    
			   }else{
			       if ($identificador1!=NULL){
				       $qry="update trabaja set cargo = '0' where identificador = '$identificador1' and rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";
				   }else{
				       $qry="update trabaja set cargo = '0', identificador = '$tiempo' where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";   
				   }
				   	   
				   $result = pg_Exec($conn,$qry);
				   if (!$result){
				       echo "Error, no se ha actualizado el primero cargo.".$qry;
					   exit();
				   }
			   }		   
			   
	   
			   
			   
			   if ($cmbCARGO1>0){
			       //actualizamos el segundo cargo
				   $tiempo++;
				   if ($identificador2!=NULL){
				      $qry="update trabaja set cargo = '".trim($cmbCARGO1)."' where identificador = '$identificador2'";
				   }else{
				      $tiempo++;
				      $qry="update trabaja set cargo = '".trim($cmbCARGO1)."', identificador = '$tiempo' where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."' and identificador = NULL";  
				   
				   }	  
				   $result = pg_Exec($conn,$qry);
				   if (!$result){
				       echo "Error, no se ha actualizado el primero cargo.".$qry;
					   exit();
				   }	    
			   }else{
			       // actualizamos el cargo 2 en NULL
				   
			       if ($identificador2!=NULL){
				      $qry="update trabaja set cargo = '0' where identificador = '$identificador2' and rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."'";
				   }else{
				      $tiempo++;
				      $qry="update trabaja set cargo = '0', identificador = '$tiempo' where rdb = '".trim($rdb)."' and rut_emp = '".trim($_EMPLEADO)."' and identificador = NULL";  
				   
				    }	  
				    $result = pg_Exec($conn,$qry);
				    if (!$result){
				       echo "Error, no se ha actualizado el primero cargo.".$qry;
					   exit();
				    }
				}	   
			   
			   
			   echo "<script>window.location = 'seteaEmpleado.php3?caso=1&pesta='3'&empleado=".$_EMPLEADO."'</script>";	
		  }	   	     
*/				   
			   	   
			// fin con la actualizacion de los cargos		   
	        // ********************************************************** //
	   
	}else{	
	  

		
	//*******************************ACTUALIZA EMPLEADO EN BD. SOPORTE *************************************************//			
				
		$qry_sop="UPDATE empleado SET nombre_emp = '".trim($txtNOMBRE)."', ape_pat = '".trim($txtAPEPAT)."', ape_mat = '".trim($txtAPEMAT)."', telefono = '".trim($txtTELEF)."', email = '".trim($txtEMAIL)."' WHERE rut_emp=".$_EMPLEADO."";		
		$result_sop =@pg_Exec($conn2,$qry_sop);
		
		if(!$result_sop){?>
		<script>alert('No se pudo actualizar datos en BD soporte4');</script>
		<? //error('<B> ERROR :</b>Error al acceder a la BD. (soporte)'.$qry_sop);?>
		<? }
				
	//*********************************************************************************************************//	
		
		

		if (!$result_sop) {
			    ?>
				<script>alert('Atención: Uno o más campos viene vacío. Ingrese los datos requeridos');</script>
				<? if($servidor==NULL){?>
				<script>window.location='seteaEmpleado.php3?caso=1&pesta=<?=$pesta?>&empleado=<?=$_EMPLEADO?>'</script>
				<? }
				
				if($servidor=="antofagasta"){?>
				<script>window.location='http://www.cmds.cl/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=<?=$pesta?>&empleado=<?=$_EMPLEADO?>'</script>
				<? }
				
				if($servidor=="zapallar"){?>
				<script>window.location='http://200.29.22.36/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=<?=$pesta?>&empleado=<?=$_EMPLEADO?>'</script>
				<? }
				if($servidor=="murialdo"){?>
				<script>window.location='http://190.162.116.194/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=<?=$pesta?>&empleado=<?=$_EMPLEADO?>'</script>
				<? }
		}
		

/*vhs 		echo "<script>window.location = 'seteaEmpleado.php3?caso=1&empleado=".$_EMPLEADO."'</script>";*/

if($servidor=="antofagasta"){
echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=".$pesta."&empleado=".$_EMPLEADO."'</script>";
}

if($servidor=="zapallar"){
echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=".$pesta."&empleado=".$_EMPLEADO."'</script>";
}

if($servidor=="murialdo"){
echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/seteaEmpleado.php3?caso=1&pesta=".$pesta."&empleado=".$_EMPLEADO."'</script>";
}


/*echo "<script>window.location = 'seteaEmpleado.php3?caso=1&pesta=".$pesta."&empleado=".$_EMPLEADO."'</script>";*/

}
}//FIN MODIFICAR




if ($frmModo=="eliminar"){
	$qry="SELECT * FROM USUARIO WHERE NOMBRE_USUARIO='".$_EMPLEADO."'";
	$result_sop = @pg_Exec($conn2,$qry); 
	$fila_sop	= @pg_fetch_array($result_sop,0); 

// BORRANDO LOS ACCESOS

//-----> AQUI EXISTE UN ERROR EN EL ID_USUARIO DEL DELETE!!!!!!!------------//

	
	 //********* BORRA EN BD. SOPORTE ************//
	$qry="DELETE FROM ACCEDE WHERE ID_USUARIO=".$fila_sop['id_usuario']." AND RDB=".$_INSTIT; 
	$result_del =@pg_Exec($conn2,$qry);
	//********************************************//
	
	$qry="DELETE FROM TRABAJA WHERE RUT_EMP='".$_EMPLEADO."' AND RDB=".$_INSTIT;
	$result_del =@pg_Exec($conn2,$qry); //<---------- BORRA EN BD. SOPORTE ************//

	//$sql_del_tit="DELETE FROM empleado_estudios WHERE rut_empleado='".$_EMPLEADO."'";
	//$result = pg_exec($conn, $sql_del_tit);

	//echo "<center><font face=arial><b></b></font></center>";
//	exit();
	if (!$result_sop) {
		error('<b> ERROR :</b>Error al eliminar.');
	}else{
		if($servidor=="antofagasta"){
		echo "<script>window.location = 'http://www.cmds.cl/admin/institucion/empleado/listarEmpleado.php3'</script>";
		}
		
		if($servidor=="zapallar"){
		echo "<script>window.location = 'http://200.29.22.36/admin/institucion/empleado/listarEmpleado.php3'</script>";
		}
		
		if($servidor=="murialdo"){
		echo "<script>window.location = 'http://190.162.116.194/admin/institucion/empleado/'listarEmpleado.php3'</script>";
		}
	}
}

?>