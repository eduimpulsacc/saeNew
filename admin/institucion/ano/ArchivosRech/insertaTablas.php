<?
	require('../../../../util/header.inc');

	$institucion	= $_INSTIT;
	$ano			= $_ANO;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<!-- subir los archivos a una carpeta y desde ahi tomarlos y copiarlos en tablas temporales -->
<?   

// 	busca archivos que no han sido subidos 
	$sql_busca = "SELECT * FROM archivo_rech WHERE rdb=".$institucion." AND estado_archivo=0";
	$result_busca = pg_exec($conn,$sql_busca);	
	
	

// $archivo_21 = "Archivos/m14300_21.txt";
	if(pg_numrows($result_busca)>0){
		for($i=0;$i<pg_numrows($result_busca);$i++){
			$fila_busca = pg_fetch_array($result_busca,$i);
//
			if($fila_busca['numero']==4){
				$archivo_04 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_04),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A04 = explode("\t", $buffer);
				
				    
					
					if (strlen(trim($A04[12]))==1){
					    $var_A04 = trim($A04[12]).".0";
					}else{
					    $var_A04 = trim($A04[12]);
					}	
				
					
					if($A04[9]==NULL)	$A04[9]=0;
			
				$qry_04= "INSERT INTO archivo_04 VALUES (".trim($A04[0]).",".trim($A04[1]).",".trim($A04[2]).",".trim($A04[3]).",".trim($A04[4]).",'".trim($A04[5])."',".trim($A04[6]).",".trim($A04[7]).",'".trim($A04[8])."',".trim($A04[9]).",".trim($A04[10]).",".trim($A04[11]).",'".trim($var_A04)."','".trim($A04[13])."','".trim($A04[14])."')";
					$result= pg_exec($conn,$qry_04);
			
				}
				
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}

// archivo 01
			if($fila_busca['numero']==1){
				$archivo_01 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_01),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					//$buffer=utf8_encode($buffer);
					$A01 = explode("\t", $buffer);
				
				$fecha=explode("/",trim($A01[9]));
			 	$qry_01= "INSERT INTO archivo_01 VALUES (".trim($A01[0]).",".trim($A01[1]).",".trim($A01[2]).",".trim($A01[3]).",'".trim($A01[4])."','".trim($A01[5])."','".trim($A01[6])."','".trim($A01[7])."',".trim($A01[8]).",'".$fecha[2].$fecha[1].$fecha[0]."',".trim($A01[10]).")";
			
//				$qry_01= "INSERT INTO archivo_01 VALUES (".trim($A01[0]).",".trim($A01[1]).",".trim($A01[2]).",".trim($A01[3]).",'".trim($A01[4])."','".trim($A01[5])."','".trim($A01[6])."','".trim($A01[7])."',".trim($A01[8]).",to_date('".trim($A01[9])."','DD MM YYYY'),".trim($A01[10]).")";
					$result= pg_exec($conn,$qry_01);
			
				}
				
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}

// archivo 03

			if($fila_busca['numero']==3){
				$archivo_03 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_03),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A03 = explode("\t", $buffer);

				$qry_03= "INSERT INTO archivo_03 VALUES (".trim($A03[0]).",".trim($A03[1]).",".trim($A03[2]).",".trim($A03[3]).",".trim($A03[4]).",'".trim($A03[5])."',".trim($A03[6]).",".trim($A03[7]).",'".trim($A03[8])."',".trim($A03[9]).")";
					$result= pg_exec($conn,$qry_03);
			
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}
//
// archivo 05
if($fila_busca['numero']==5){
				$archivo_05 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_05),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A05 = explode("\t", $buffer);
					
				if($A05[9]==NULL || $A05[9]=='')	
					$A05[9] = 0;
				if(substr($A05[9],1,1)==','){	
					$A05[9] = str_replace(",","",$A05[9]);	}
				if(substr($A05[9],1,1)=='.'){	
					$A05[9] = str_replace(".","",$A05[9]);	}
				if($A05[12]==P || $A05[12]=='P')	
					$A05[12] = 1;
				if($A05[12]==R || $A05[12]=='R')	
					$A05[12] = 2;
				if($A05[12]==Y || $A05[12]=='Y')	
					$A05[12] = 3;

//$qry_05= "INSERT INTO archivo_05 VALUES (".trim($A05[0]).",".trim($A05[1]).",".trim($A05[2]).",".trim($A05[3]).",".trim($A05[4]).",'".trim($A05[5])."',".trim($A05[6]).",".trim($A05[7]).",'".trim($A05[8])."',".trim(str_replace(".","",$A05[9])).",".trim($A05[10]).",'".trim($A05[11])."','".trim($A05[12])."',".trim($A05[13]).")";

$qry_05= "INSERT INTO archivo_05 VALUES (".trim($A05[0]).",".trim($A05[1]).",".trim($A05[2]).",".trim($A05[3]).",".trim($A05[4]).",'".trim($A05[5])."',".trim($A05[6]).",".trim($A05[7]).",'".trim($A05[8])."',".trim($A05[9]).",".trim($A05[10]).",'".trim($A05[11])."','".trim($A05[12])."',".trim($A05[13]).")";
					$result= pg_exec($conn,$qry_05);
			
				}
				fclose ($fd);	

// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}

// archivo 06
			if($fila_busca['numero']==6){
				$archivo_06 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_06),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A06 = explode("\t", $buffer);

				$qry_06= "INSERT INTO archivo_06 VALUES (".trim($A06[0]).",".trim($A06[1]).",".trim($A06[2]).",".trim($A06[3]).",".trim($A06[4]).",'".trim($A06[5])."',".trim($A06[6]).",".trim($A06[7]).",".trim($A06[8]).",".trim($A06[9]).",".trim($A06[10]).",'".trim($A06[11])."','".trim($A06[12])."','".trim($A06[13])."','".trim($A06[14])."')";
					$result= pg_exec($conn,$qry_06);
			
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}
//
// archivo 23
			if($fila_busca['numero']==23){
				$archivo_23 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_23),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$M23 = explode("\t", $buffer);

					if(trim($M23[8])==1){	// masculino RECH
						$sexo = 2;	// masculino SAE
					}
					else if(trim($M23[8])==2){
						$sexo = 1;
					}

					if(trim($M23[12])=='' || trim($M23[12])==NULL){	
						$M23[12] = 0;	
					}
					if(trim($M23[13])=='' || trim($M23[13])==NULL){
						$M23[13]= 0;
					}


				$qry_23= "INSERT INTO archivo_23 VALUES (".trim($M23[0]).",".trim($M23[1]).",".trim($M23[2]).",".trim($M23[3]).",'".trim($M23[4])."','".trim($M23[5])."','".trim($M23[6])."','".trim($M23[7])."',".$sexo.",to_date('".trim($M23[9])."','DD MM YYYY'),".trim($M23[10]).",".trim($M23[11]).",".trim($M23[12]).",".trim($M23[13]).")";

					$result= pg_exec($conn,$qry_23);
			
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}
//
// archivo 24
			if($fila_busca['numero']==24){
				$archivo_24 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_24),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$M24 = explode("\t", $buffer);

				$qry_24= "INSERT INTO archivo_24 VALUES (".trim($M24[0]).",".trim($M24[1]).",".trim($M24[2]).",".trim($M24[3]).",".trim($M24[4]).",'".trim($M24[5])."',".trim($M24[6]).",".trim($M24[7]).",".trim($M24[8]).",".trim($M24[9]).",".trim($M24[10]).",".trim($M24[11]).",".trim($M24[12]).",".trim($M24[13]).",".trim($M24[14]).",'".trim($M24[15])."','".trim($M24[16])."','".trim($M24[17])."','".trim($M24[18])."')";
					$result= pg_exec($conn,$qry_24);
			
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}
//
// archivo 25
			if($fila_busca['numero']==25){
				$archivo_25 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_25),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$M25 = explode("\t", $buffer);

				$qry_25= "INSERT INTO archivo_25 VALUES (".trim($M25[0]).",".trim($M25[1]).",".trim($M25[2]).",".trim($M25[3]).",".trim($M25[4]).",'".trim($M25[5])."',".trim($M25[6]).",".trim($M25[7]).",'".trim($M25[8])."',".trim($M25[9]).",".trim($M25[10]).",".trim($M25[11]).",".trim($M25[12]).",".trim($M25[13]).",".trim($M25[14]).",".trim($M25[15]).",".trim($M25[16]).",".trim($M25[17]).")";
					$result= pg_exec($conn,$qry_25);
			
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}
//
// archivo 26
			if($fila_busca['numero']==26){
				$archivo_26 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_26),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$M26 = explode("\t", $buffer);

				$qry_26= "INSERT INTO archivo_26 VALUES (".trim($M26[0]).",".trim($M26[1]).",".trim($M26[2]).",".trim($M26[3]).",".trim($M26[4]).",".trim($M26[5]).",'".trim($M26[6])."','".trim($M26[7])."','".trim($M26[8])."','".trim($M26[9])."',".trim($M26[10]).",to_date('".trim($M26[11])."','DD MM YYYY'),".trim($M26[12]).",".trim($M26[13]).")";
					$result= pg_exec($conn,$qry_26);
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE rdb=".$institucion." AND nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
			}
//

		}		
	}

	echo "<script>window.location = 'ArchRech.php?caso=3'</script>";

?>

<!-- copy archivo_01 from '/var/www/html/coeint_ver9.1/admin/institucion/ano/ActasMatricula/Rech/Archivos/a25131_1.txt' -->

</body>
</html>
