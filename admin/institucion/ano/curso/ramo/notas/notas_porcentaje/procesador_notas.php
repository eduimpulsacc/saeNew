<?php 
require('../../../../../../../util/header.inc');
require('../../../../../../../util/registro.php');



header ("Expires: Thu, 27 Mar 1980 23:59:00 GMT"); //la pagina expira en una fecha pasada
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); //ultima actualizacion ahora cuando la cargamos
header ("Cache-Control: no-cache, must-revalidate"); //no guardar en CACHE
header ("Pragma: no-cache");


	/*if($_PERFIL==0){
		echo "<pre>";
			print_r($_POST);
		echo "</pre>";
		
	}*/
$rs_registro =RegistroUsuario($conn,3,$_NOMBREUSUARIO,$_PERFIL,$_INSTIT,'notas',pg_dbname($conn));

$ano = $_ANO; // varibla año del servidor //
$Xreg = $_POST[Xreg]; // cantidad alumnos 
$cont = 0;

		$sql="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		$result =@pg_Exec($conn,$sql);
		
			if (!$result) {
				echo "Error al acceder a la BD. (5)";
			}else{
		
				if (pg_numrows($result)!=0){
					$fila1 = @pg_fetch_array($result,0);
						
					if (!$fila1){
						echo "Error al acceder a la BD. (6)";
					}
					
				$ano_act = trim($fila1['nro_ano']);
				
			   }
																
			}
		

for( $X=1; $X <=$Xreg; $X++ )   {  // FOR 1 recorre cantidad alumnos 
	
	$sql="SELECT * FROM porc_notas$ano_act WHERE RUT_ALUMNO=".trim($_POST[rut_alumno.$X])." AND ID_RAMO=".$_POST[id_ramo.$X]." AND ID_PERIODO=".$_POST[id_periodo.$X];
		$result = @pg_Exec($conn,$sql);
				
		$notas="";					
		$nn = 0;
				
			  if (@pg_numrows($result)!=0){    // _#########    ACTUALIZAR REGISTROS    //##########
						
							for($nn=1;$nn<21;$nn++){  // For Notas 
								
								$paso="a_".$X."_".$nn;
								
								if( ($_POST[$paso] =="")  ){
											 
								   $notas.=" NOTA$nn='101',";
											     
									}else{ 		
											
									$notas.=" NOTA$nn='".strtoupper($_POST[$paso])."',";
											
								  }
								
															
							}						
				
							$p_promedio="a_".$X."_21";
				
					   $sql="UPDATE porc_notas$ano_act SET ".$notas." PROMEDIO='".$_POST[$p_promedio]."' WHERE RUT_ALUMNO=".$_POST[rut_alumno.$X]."  AND ID_RAMO=".$_POST[id_ramo.$X]." AND ID_PERIODO=".$_POST[id_periodo.$X]."";
						
			}else{   // _ ###########    INSERTAR REGISTROS    //##########
							
							$sql="INSERT INTO porc_notas$ano_act (RUT_ALUMNO, ID_RAMO, ID_PERIODO, NOTA1, NOTA2, 
								  NOTA3, NOTA4, NOTA5, NOTA6, NOTA7, NOTA8, NOTA9, NOTA10, NOTA11, 
								  NOTA12, NOTA13, NOTA14, NOTA15, NOTA16, NOTA17, NOTA18, NOTA19, NOTA20,PROMEDIO) 
								  VALUES (".trim($_POST[rut_alumno.$X]).",".$_POST[id_ramo.$X].",".$_POST[id_periodo.$X].",";
				
										for($nn=1;$nn<22;$nn++){  // For Notas 
										
											$paso="a_".$X."_".$nn;
											
										  if($_POST[$paso] ==""){
											 
											$notas.=" '101',";
											     
										    }else{ 		
											
											$notas.=" '".strtoupper($_POST[$paso])."',";
											
											  }
																					
									
										}
										
										$notas=substr($notas,0,strlen($notas)-1);
										$sql.=$notas.")";
				
						}
						
						
								$result = @pg_Exec($conn,$sql);
								//echo "<br>".$sql."<br>";
								
								if (!$result){
									echo  "Error al acceder a la BD Nº 34565";
								}

    } // FOR 1*/

								
?>

