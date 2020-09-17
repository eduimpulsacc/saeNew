<? 
	require('../../../../util/header.inc');
	include('../../../../util/rpc.php3');
	
	foreach($_POST as $nombre_campo => $valor)
   { 
     
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
	
   }
   
    foreach($_GET as $nombre_campo => $valor)
   { 
   
   
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
   }
	

	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	
	function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}
			
			
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Carga archivos...</title>
</head>

<body>
<!-- subir los archivos a una carpeta y desde ahi tomarlos y copiarlos en tablas temporales -->
<?   


// 	busca archivos que no han sido subidos 
	
	$sql_busca="Select * from archivo_rech where rdb=".$rdb." and estado_archivo=0 order by numero";
	  $result_busca=@pg_exec($conn,$sql_busca) or die ('no busca'); 
		
if(pg_numrows($result_busca)>0)
{
//echo "pase x aki, encontro cosas";
		 for($i=0;$i<pg_numrows($result_busca);$i++)
		 {
			$fila_busca = pg_fetch_array($result_busca,$i); 
			
			// archivo 2
			if($fila_busca['numero']==2)
			{
				$archivo_2 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_2),"r");
				//echo "archivo_2=$archivo_2<br>";
				while (!feof($fd)) 
				{
					$buffer = fgets($fd,4096);
					$A02 = explode("\t", $buffer);

				$qry_02= "INSERT INTO archivo_02 (nro,rdb,dig_rdb,cod_ense,grado,letra,ano_escolar,cod_dec_eval,cod_dec_o_res_plan_est,plan_estudio,rut_prof_jefe,dig_rut) VALUES (".trim($A02[0]).",".trim($A02[1]).",".trim($A02[2]).",".trim($A02[3]).",".trim($A02[4]).",'".trim($A02[5])."',".$anio_escolar.",".trim($A02[7]).",".trim($A02[8]).",".trim($A02[9]).",".trim($A02[10]).",'".trim($A02[11])."')";
				//echo "qry_02=$qry_02<br>"; 
					$result= @pg_exec($conn,$qry_02);		
			
			//busca planes de estudio
					
					 $sql_busca_plan_est="select distinct plan_estudio from archivo_02";
					$result_plan_est= pg_exec($conn,$sql_busca_plan_est)or die('no busque sql_busca_plan_est<br>sql='.$sql_busca_plan_est.'<br>'); 
					//echo "sql_busca_plan_est=$sql_busca_plan_est<br>"; 
					
					
					for ($i=0;$i<pg_numrows($result_plan_est);$i++)
					{
						
					$plan_est=pg_result($result_plan_est,$i,"plan_estudio");
						
					
					
					//ver si existen o no
					
					$sql_ver="select * from plan_inst where rdb=".$rdb."and cod_decreto=".$plan_est;
					//echo "sql_ver=$sql_ver<br>";
					$result_ver= pg_exec($conn,$sql_ver);
					$encontrados_ver=pg_numrows($result_ver);
					//echo "encontrados_ver=$encontrados_ver<br>";
					
					if($encontrados_ver==0)
					{
					//inserta plan_inst	
					$sql_plan_inst="insert into plan_inst values (".$rdb.",".$plan_est.")";
					$result_plan_inst= @pg_exec($conn,$sql_plan_inst); 
					//echo "sql_plan_inst=$sql_plan_inst<br>";
					}
					
					
					}  
			
				}
				fclose ($fd);	
				
				
				
				// modificar el estado del archivo al valor 1 indicando 
					$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica);
					//echo "inserte archivo 2<br>";
			}
			
			
			
//
			//archivo 21 
			if($fila_busca['numero']==21)
			{
				$archivo_21 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_21),"r");
				while (!feof($fd))
				{
					$buffer = fgets($fd,4096);
					$M21 = explode("\t", $buffer);
					
				//busca dentro del campo 'localidad' la regiom, la provincia y la comuna
				 $qry_rpc="select * from comuna where nom_com ='".trim($M21[8])."'";
				 $result_rpc= pg_exec($conn,$qry_rpc);
				 $cod_reg=trim(pg_result($result_rpc,"cod_reg"));
				 $cod_prov=trim(pg_result($result_rpc,"cor_pro")); 
				 $cod_com=trim(pg_result($result_rpc,"cor_com"));
				 //echo "qry_rpc=$qry_rpc<br>"; 
				
			// inserta en tabla temporal para esta clase de archivo
				 $qry_21= "INSERT INTO archivo_21 VALUES (".trim($M21[0]).",".trim($M21[1]).",".trim($M21[2]).",'".trim($M21[3])."','".trim($M21[4])."','".trim($M21[5])."','".trim($M21[6])."','".trim($M21[7])."','".trim($M21[8])."',".trim($M21[9]).",'".CambioFecha(trim($M21[10]))."',".trim($M21[11]).",'".trim($M21[12])."','".trim($M21[13])."','".trim($M21[14])."','".trim($M21[15])."')";
				$result_21=@pg_exec($conn,$qry_21);
				//echo "sql=$qry_21<br>"; 
				
				//busca si existe institucion
				$sql_bins="select * from institucion where rdb=".trim($M21[1]);
				$result_bins= pg_exec($conn,$sql_bins);
				//echo "sql_bins=$sql_bins<br>"; 
				$encontrados_bins=pg_numrows($result_bins);
				 
				
				//echo "encontrados_bins=$encontrados_bins<br>"; 
				
				if ($encontrados_bins==0)
				{
				//inserto datos de la institucion
				$qry_ins="INSERT INTO institucion (rdb,dig_rdb,nombre_instit,calle,region,ciudad,comuna,telefono,email,nu_resolucion,fecha_resolucion,tipo_regimen,tipo_instit,idioma,sexo,estado_colegio,metodo) values(".trim($M21[1]).",'".trim($M21[2])."','".trim($M21[3])."','".trim($M21[4])."',".$cod_reg.",".$cod_prov.",".$cod_com.",'".trim($M21[5])."','".trim($M21[7])."',".trim($M21[9]).",'".CambioFecha(trim($M21[10]))."',".$regimen.",1,1,1,1,1)";
				$result_ins= @pg_exec($conn,$qry_ins);
				//echo "qry_ins=$qry_ins<br><br>";
				}
				
				
				//busco año escolar
				$sql_bano="select * from ano_escolar where nro_ano=".$anio_escolar." and id_institucion=".trim($M21[1]);
				$result_bano= pg_exec($conn,$sql_bano);
				//echo "sql_bano=$sql_bano<br>"; 
				$encontrados_bano=pg_numrows($result_bano);
				 
				
				//echo "encontrados_bano=$encontrados_bano<br>"; 
				
				if ($encontrados_bano==0)
				{
				//ahora inserto el año escolar
				$qry_anio="insert into ano_escolar (nro_ano,id_institucion,tipo_regimen,fecha_inicio,fecha_termino) values (".$anio_escolar.",".trim($M21[1]).",".$regimen.",'$anio_escolar-03-01','$anio_escolar-12-31')";
				$result_anio= @pg_exec($conn,$qry_anio);
				//echo "qry_anio=$qry_anio<br>";
				}
				//busco oid
				$sql_oid="select id_ano from ano_escolar where id_institucion=".$rdb." order by id_ano desc limit 1";
				//echo "sql_oid=$sql_oid<br>"; 			
				$result_oid= pg_exec($conn,$sql_oid);
				$moid_anio=pg_result($result_oid,0,"id_ano");
				//echo "moid_anio=$moid_anio<br><br>";
				
				//inserto datos del director
				$sql_emp="insert into empleado (rut_emp,dig_rut,nombre_emp,ape_pat,ape_mat) values (".trim($M21[11]).",'".trim($M21[12])."','".trim($M21[15])."','".trim($M21[13])."','".trim($M21[14])."')";
							$result_emp= pg_exec($conn,$sql_emp);
							
							
							
				$sql_trab="insert into trabaja (rdb,rut_emp,cargo) values (".trim($M21[1]).",".trim($M21[11]).",1)";
				$result_trab= pg_exec($conn,$sql_trab);
				
				
				//inserto datos en la tabla periodo, segun tipo regimen
				switch($regimen)
				{
					//trimestres
					case 2:
					$reg=3;
					$nom="TRIMESTRE";
					break;
					
					//semestres
					case 3:
					$reg=2;
					$nom="SEMESTRE";
					break;
					
				}
				
					for ($j=0;$j<$reg;$j++)
					{
						//busco si periodos existen
					 	$sql_bus_per="select * from periodo where id_ano=".$moid_anio;
						//echo "sql_bus_per=$sql_bus_per<br>"; 			
						$result_bus_per= pg_exec($conn,$sql_bus_per);
						$encontrados_bus_per=pg_numrows($result_bus_per);
						
						switch ($j)
						{
							case 0:
							$pre="PRIMER";
							break;
							
							case 1:
							$pre="SEGUNDO";
							break;
							
							case 1:
							$pre="TERCER";
							break;
						
						} 
						
						if($encontrados_bus_per<$reg)
						{
							$sql_per="insert into periodo (id_ano,nombre_periodo) values (".$moid_anio.",'".$pre." ".$nom."')";
							$result_per= @pg_exec($conn,$sql_per);
							//echo "sql_per=$sql_per<br>"; 
						}
					}
				
				
				}
				 fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
				$result_modifica = pg_exec($conn,$sql_modifica);
				//echo "sql_modifica=$sql_modifica<br>"; 
				//echo "inserté archivo 21<br>";
				
				
			}
			
			//archivo 22
			if($fila_busca['numero']==22)
			{
				$archivo_22 = "Archivos/".$fila_busca['nombre_archivo'];
				//echo "pase por archivo 22<br>";
				$fd = fopen(trim($archivo_22),"r");
				while (!feof($fd))
				{
					$buffer = fgets($fd,4096);
					$M22 = explode("\t", $buffer);
					
					 if(strlen($M22[8])<1)
					$M22[8]='0';
								
					if(strlen($M22[9])<4)
					$M22[9]='11/11/1111'; 
					
					//echo "fecha2=$M22[9]<br>";
					if(strlen($M22[10])<1)
					$M22[10]='0';
					
					 if(strlen($M22[11])<1)
					$M22[11]='00:00:00';
					
					if(strlen($M22[12])<1)
					$M22[12]='00:00:00';
					
					if(strlen($M22[13])<1)
					$M22[13]='00:00:00';
					
					if(strlen($M22[14])<1)
					$M22[14]='00:00:00';
					
					if(strlen($M22[15])<1)
					$M22[15]='00:00:00';
					
					if(strlen($M22[16])<1)
					$M22[16]='00:00:00';
					
					if(strlen($M22[17])<1)
					$M22[17]='00:00:00';
					
					if(strlen($M22[18])<1)
					$M22[18]='00:00:00'; 
					
					
					
					
					$qry_22= "INSERT INTO archivo_22 VALUES (".trim($M22[0]).",".trim($M22[1]).",".trim($M22[2]).",".trim($M22[3]).",'".trim($M22[4])."','".trim($M22[5])."',".trim($M22[6]).",'".CambioFecha(trim($M22[7]))."',".trim($M22[8]).",'".CambioFecha(trim($M22[9]))."',".trim($M22[10]).",'".trim($M22[11])."','".trim($M22[12])."','".trim($M22[13])."','".trim($M22[14])."','".trim($M22[15])."','".trim($M22[16])."','".trim($M22[17])."','".trim($M22[18])."',".trim($M22[19]).",".trim($M22[20]).",".trim($M22[21]).",".trim($M22[22]).",".trim($M22[23]).",".trim($M22[24]).",".trim($M22[25]).",".trim($M22[26]).",".trim($M22[27]).",".trim($M22[28]).",".trim($M22[29]).")";
					$result_22= @pg_exec($conn,$qry_22);
					//echo "sql=$qry_22<br>";
					
					 if ((strlen($M22[8])>1) && (strlen($M22[9])<4))
					{
						//veo si estan los tipos de enseñanza
						$sql_bus_res="select * from tipo_ense_inst where rdb=".$rdb."and cod_tipo=".trim($M22[3])." and nu_resolucion=".trim($M22[6]);		
						$result_bus_res= pg_exec($conn,$sql_bus_res);
						//echo "sql_bus_res=$sql_bus_res<br>";
						$encontrados_bus_res=pg_numrows($result_bus_res);
						//echo "encontrados_bus_res=$encontrados_bus_res<br>";
						if($encontrados_bus_res==0)
						{		
							$qry_tipo_ense="insert into tipo_ense_inst (rdb,cod_tipo,estado,nu_resolucion,fecha_res,nu_resolucion_cierre,fecha_res_cierre,nu_grupos_dif) values (".trim($M22[1]).",".trim($M22[3]).",".trim($M22[19]).",".trim($M22[6]).",'".CambioFecha(trim($M22[7]))."',".trim($M22[8]).",'".CambioFecha(trim($M22[9]))."',".trim($M22[10]).")";
							//echo "qry_tipo_ense=$qry_tipo_ense<br>";
							$result_tipo_ense= @pg_exec($conn,$qry_tipo_ense);
						}	
					}
					else
					{
						//veo si estan los tipos de enseñanza
						$sql_bus_res="select * from tipo_ense_inst where rdb=".$rdb."and cod_tipo=".trim($M22[3])." and nu_resolucion=".trim($M22[6]);		
						$result_bus_res= pg_exec($conn,$sql_bus_res);
						//echo "sql_bus_res=$sql_bus_res<br>";
						$encontrados_bus_res=pg_numrows($result_bus_res);
						//echo "encontrados_bus_res=$encontrados_bus_res<br>";
						if($encontrados_bus_res==0)
						{		
							$qry_tipo_ense="insert into tipo_ense_inst(rdb,cod_tipo,estado,nu_resolucion,fecha_res,nu_grupos_dif) values (".trim($M22[1]).",".trim($M22[3]).",".trim($M22[19]).",".trim($M22[6]).",'".CambioFecha(trim($M22[7]))."',".trim($M22[10]).")";
							//echo "qry_tipo_ense=$qry_tipo_ense<br>";
							$result_tipo_ense= @pg_exec($conn,$qry_tipo_ense);
						}
					}	 
					 $sql_corre="select * from tipo_ense_inst where rdb=".$rdb."order by corre desc limit 1";
					$result_corre= pg_exec($conn,$sql_corre)or die('no busque oid<br>sql_corre='.$sql_corre.'<br><br>');
					$mcorre=trim(pg_result($result_corre,"corre"));
					
					//echo "mcorre=$mcorre<br>";
					
					if(($M22[11]!="00:00:00")&& ($M22[12]!="00:00:00"))
					{
						$sql_jm="insert into hora_jm values (".$mcorre.",'".trim($M22[11])."','".trim($M22[12])."')";
						//echo "sql_jm=$sql_jm<br>";
						$result_jm= @pg_exec($conn,$sql_jm);
					}
					
					if(($M22[13]!="00:00:00")&& ($M22[14]!="00:00:00"))
					{
						$sql_jt="insert into hora_jt values (".$mcorre.",'".trim($M22[13])."','".trim($M22[14])."')";
						//echo "sql_jt=$sql_jt<br>";
						$result_jt= @pg_exec($conn,$sql_jt);
					}
					
					if(($M22[15]!="00:00:00")&& ($M22[16]!="00:00:00"))
					{
						$sql_mt="insert into hora_mt values (".$mcorre.",'".trim($M22[15])."','".trim($M22[16])."')";
						//echo "sql_mt=$sql_mt<br>";
						$result_mt= @pg_exec($conn,$sql_mt);
					}
					
					if(($M22[17]!="00:00:00")&& ($M22[18]!="00:00:00"))
					{
						$sql_vn="insert into hora_vn values (".$mcorre.",'".trim($M22[17])."','".trim($M22[18])."')";
						//echo "sql_vn=$sql_vn<br>";
						$result_vn= @pg_exec($conn,$sql_vn);
					} 
					
				
					
				}
				
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
				//echo "sql_modifica=$sql_modifica<br>";
				$result_modifica = pg_exec($conn,$sql_modifica);
					
					//echo "inserté archivo 22<br>";

			}
			
			//archivo 01
			if($fila_busca['numero']==1)
			{
				$archivo_01 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_01),"r");
				while (!feof($fd))
				{
					$buffer = fgets($fd,4096);
					$A01 = explode("\t", $buffer);
						
						 

					if(trim($A01[8])==1){	// masculino RECH
						$sexo = 2;	// masculino SAE
					}
					else if(trim($A01[8])==2){ //femenino rech
						$sexo = 1; //femenino sae
					}

					
				$qry_01= "INSERT INTO archivo_01 VALUES (".trim($A01[0]).",".trim($A01[1]).",".trim($A01[2]).",".trim($A01[3]).",'".trim($A01[4])."','".trim($A01[5])."','".trim($A01[6])."','".trim($A01[7])."',".$sexo.",to_date('".trim($A01[9])."','DD MM YYYY'),".trim($A01[10]).")";
				//echo "qry_01=$qry_01<br>";
				$result= @pg_exec($conn,$qry_01);
				//echo "qry_01=$qry_01<br>";
					
				//veo si alumno existe en el sistema
				$sql_bus_res="select * from alumno where rut_alumno=".trim($A01[3]);		
						$result_bus_res= pg_exec($conn,$sql_bus_res);
						//echo "sql_bus_res=$sql_bus_res<br>";
						$encontrados_bus_res=pg_numrows($result_bus_res);
						//echo "encontrados_bus_res=$encontrados_bus_res<br>";
						if($encontrados_bus_res==0)
						{		
					
							$qry_alum="insert into alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,sexo,fecha_nac) values (".trim($A01[3]).",'".trim($A01[4])."','".trim($A01[7])."','".trim($A01[5])."','".trim($A01[6])."',".$sexo.",'".CambioFecha(trim($A01[9]))."')";
							//echo "qry_alum=$qry_alum<br>";
							$result_alum= @pg_exec($conn,$qry_alum);	
					
						}				
					
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica); 
					//echo "inserté archivo 23<br>";
					

			}
			
			//archivo 24
			if($fila_busca['numero']==24)
			{
				$archivo_24 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_24),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$M24 = explode("\t", $buffer);

				  $qry_24= "INSERT INTO archivo_24 VALUES(".trim($M24[0]).",".trim($M24[1]).",".trim($M24[2]).",".trim($M24[3]).",".trim($M24[4]).",'".trim($M24[5])."',".$anio_escolar.",".trim($M24[7]).",".trim($M24[8]).",".trim($M24[9]).",".trim($M24[10]).",".trim($M24[11]).",".trim($M24[12]).",".trim($M24[13]).",".trim($M24[14]).",'".trim($M24[15])."','".trim($M24[16])."','".trim($M24[17])."','".trim($M24[18])."')";
					$result= @pg_exec($conn,$qry_24); 
				//	echo "qry_24=$qry_24<br>"; 
					
						
					//busca ultimo año escolar de institucion
					
					$sql_bucanio="select id_ano from ano_escolar where id_institucion=".$rdb." order by id_ano desc limit 1";
					$result_buscanio= pg_exec($conn,$sql_bucanio); 
					$cod_anio=trim(pg_result($result_buscanio,"id_ano"));
					//echo "sql_bucanio=$sql_bucanio<br>"; 
					
					
					//busco si el curso existe
					$sql_bus_res="select * from curso where id_ano=".$cod_anio." and grado_curso=".trim($M24[4])." and letra_curso='".trim($M24[5])."' and ensenanza=".trim($M24[3]);		
						$result_bus_res= pg_exec($conn,$sql_bus_res);
						//echo "sql_bus_res=$sql_bus_res<br>";
						$encontrados_bus_res=pg_numrows($result_bus_res);
						//echo "encontrados_bus_res=$encontrados_bus_res<br>";
						if($encontrados_bus_res==0)
						{		
//inserta curso
							$sql_cur="insert into curso (grado_curso,letra_curso,ensenanza,id_ano,bool_jor) values (".trim($M24[4]).",'".trim($M24[5])."',".trim($M24[3]).",".$cod_anio.",".trim($M24[7]).")";
							$result_cur= pg_exec($conn,$sql_cur);
							//echo "sql_cur=$sql_cur<br>";  			
						}
						
					$sql_dec="select * from archivo_02 where rdb=".$rdb." and ano_escolar=".$anio_escolar." and grado=".trim($M24[4])." and letra='".trim($M24[5])."'";
					$result_dec= pg_exec($conn,$sql_dec); 
					//echo "sql_dec=$sql_dec<br>";
					$encontrados=pg_numrows($result_dec);
					
					for($i=0;$i<$encontrados;$i++)
					{
					$cod_dec=trim(pg_result($result_dec,$i,"cod_dec_eval"));
					$cod_dec_eval=trim(pg_result($result_dec,$i,"cod_dec_o_res_plan_est"));
					
					
					
					//echo "cod_dec=$cod_dec<br>";
					//echo "cod_dec_eval=$cod_dec_eval<br>";								
					
					//actualiza descetos curso
					$sql_updte="update curso set cod_decreto=".$cod_dec.", cod_eval=".$cod_dec_eval." where id_ano=".$cod_anio." and grado_curso=".trim($M24[4])." and letra_curso='".trim($M24[5])."'and ensenanza=".trim($M24[3]);
					$result_updte= pg_exec($conn,$sql_updte); 
					//echo "sql_updte=$sql_updte<br>"; 
					
					
														
					}
					
					
					//veo si esta empleado
					$sql_bus_emp="select * from empleado where rut_emp=".trim($M24[14]);		
						$result_bus_emp= pg_exec($conn,$sql_bus_emp);
						//echo "sql_bus_emp=$sql_bus_emp<br>";
						$encontrados_bus_emp=pg_numrows($result_bus_emp);
						//echo "encontrados_bus_emp=$encontrados_bus_emp<br>";
						if($encontrados_bus_emp==0)
						{	
							//inserta empleado
							$sql_emp="insert into empleado (rut_emp,dig_rut,nombre_emp,ape_pat,ape_mat) values (".trim($M24[14]).",'".trim($M24[15])."','".trim($M24[18])."','".trim($M24[16])."','".trim($M24[16])."')";
							$result_emp= pg_exec($conn,$sql_emp);
							//echo "sql_emp=$sql_emp<br>";
						}
						
						//veo si empleado trabaja en colegio
						$sql_bus_trab="select * from trabaja where rut_emp=".trim($M24[14])."and rdb=".$rdb;		
						$result_bus_trab= pg_exec($conn,$sql_bus_trab);
						//echo "sql_bus_res=$sql_bus_res<br>";
						$encontrados_bus_trab=pg_numrows($result_bus_trab);
						//echo "encontrados_bus_res=$encontrados_bus_res<br>";
						if($encontrados_bus_trab==0)
						{	
					//inserta trabaja
					$sql_trab="insert into trabaja (rdb,rut_emp,cargo) values (".trim($M24[1]).",".trim($M24[14]).",5)";
					$result_trab= pg_exec($conn,$sql_trab);
					//echo "sql_trab=$sql_trab<br>"; 
					}
					
					
					
					
					//busca id curso para actualizar supervisa
					
					$sql_id_curso="select * from curso where id_ano=".$cod_anio." and grado_curso=".trim($M24[4])." and letra_curso='".trim($M24[5])."' and ensenanza=".trim($M24[3]);
					$result_id_curso= pg_exec($conn,$sql_id_curso);
					//echo "sql_id_curso=$sql_id_curso<br>"; 
					$encontrados=pg_numrows($result_id_curso);
					for($z=0;$z<$encontrados;$z++)
					{
						
						$id_curso=trim(pg_result($result_id_curso,$z,"id_curso"));
					
							//veo si el profesor jefe existe
						$sql_bus_sup="select * from supervisa where rut_emp=".trim($M24[14])."and id_curso=".$id_curso;		
						$result_bus_sup= pg_exec($conn,$sql_bus_sup);
						//echo "sql_bus_sup=$sql_bus_sup<br>";
						$encontrados_bus_sup=pg_numrows($result_bus_sup);
						//echo "encontrados_bus_res=$encontrados_bus_res<br>";
						if($encontrados_bus_sup==0)
						{	
							//inserta supervisa
							$sql_sup="insert into supervisa values (".trim($M24[14]).",".$id_curso.")";
							//echo "sql_sup=$sql_sup<br>"; 
							$result_sup= pg_exec($conn,$sql_sup);
						} 
					} 
					
					
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
					$result_modifica = pg_exec($conn,$sql_modifica); 
					//echo "inserté archivo 24<br>";
					
					//borro archivo 2 porque aqui ya no lo necesito
					$sql_bor02="delete from archivo_02";
					$result_02= @pg_exec($conn,$sql_bor02);
			}
			
			//archivo 25
			if($fila_busca['numero']==3)
			{
				$archivo_03 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_03),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A03 = explode("\t", $buffer);

				$qry_03= "INSERT INTO archivo_03 VALUES (".trim($A03[0]).",".trim($A03[1]).",".trim($A03[2]).",".trim($A03[3]).",".trim($A03[4]).",'".trim($A03[5])."',".$anio_escolar.",".trim($A03[7]).",'".trim($A03[8])."',".trim($A03[9]).")";
					$result= pg_exec($conn,$qry_03);
					//echo "qry_03=$qry_03<br>";
					
					//busco año escolar
		$sql_bucanio="select id_ano from ano_escolar where id_institucion=".$rdb." order by id_ano desc limit 1";
		$result_buscanio= pg_exec($conn,$sql_bucanio)or die('no busque sql_bucanio<br>sql='.$sql_bucanio.'<br>'); 
		//echo "sql_bucanio=$sql_bucanio<br>";
		$cod_anio=trim(pg_result($result_buscanio,"id_ano"));
					
					//busco id cursos
					$sql_bus_cur="select id_curso from curso where id_ano=".$cod_anio." and grado_curso= ".trim($A03[4])." and letra_curso= '".trim($A03[5])."' and ensenanza=".trim($A03[3]);
					//echo "sql_bus_cur=$sql_bus_cur<br>";
					$result_cur= pg_exec($conn,$sql_bus_cur);
					$encontrados=pg_numrows($result_cur);
					//echo "encontrados=$encontrados<br>";
					
					for ($i=0;$i<$encontrados;$i++)
					{
						$id_curso=pg_result($result_cur,$i,"id_curso");
						//echo "id_curso=$id_curso<br>";
						
						//veo si alumno existe en la tabla este año
						
						$sql_bus_mat="select * from matricula where rut_alumno=".trim($A03[7])." and rdb=".$rdb;		
						$result_bus_mat= pg_exec($conn,$sql_bus_mat);
						//echo "sql_bus_mat=$sql_bus_mat<br>";
						$encontrados_bus_mat=pg_numrows($result_bus_mat);
						//echo "encontrados_bus_mat=$encontrados_bus_mat<br>";
						if($encontrados_bus_mat==0)
						{	
						//inserto matricula
						 $sql_ins_mat="insert into matricula(rut_alumno,rdb,id_ano,id_curso) values(".trim($A03[7]).",".$rdb.",".$cod_anio.",".$id_curso.")";
						//echo "sql_ins_mat=$sql_ins_mat<br>";
						$result_matricula= pg_exec($conn,$sql_ins_mat); 
						
						}			
						
					
					} 
					
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
				$result_modifica = pg_exec($conn,$sql_modifica);
					//echo "inserté archivo 25<br>";
			}
			

			// archivo 6
		if($fila_busca['numero']==6)
			{
				$archivo_06 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_06),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A06 = explode("\t", $buffer);

				$qry_06= "INSERT INTO archivo_06 VALUES (".trim($A06[0]).",".trim($A06[1]).",".trim($A06[2]).",".trim($A06[3]).",".trim($A06[4]).",'".trim($A06[5])."',".$anio_escolar.",".trim($A06[7]).",".trim($A06[8]).",".trim($A06[9]).",".trim($A06[10]).",'".trim($A06[11])."','".trim($A06[12])."','".trim($A06[13])."','".trim($A06[14])."')";
				//echo "qry_06=$qry_06<br>"; 
					$result= pg_exec($conn,$qry_06);
					
					$sql_bucanio="select id_ano from ano_escolar where id_institucion=".$rdb." order by id_ano desc limit 1";
		$result_buscanio= pg_exec($conn,$sql_bucanio)or die('no busque sql_bucanio<br>sql='.$sql_bucanio.'<br>'); 
		//echo "sql_bucanio=$sql_bucanio<br>";
		$cod_anio=trim(pg_result($result_buscanio,"id_ano"));
						
					//inserto dicta
					$sql_ins_dic="insert into dicta values(".trim($A06[10]).",0)";
					//echo "sql_ins_dic=$sql_ins_dic<br>";
					$result_dic= @pg_exec($conn,$sql_ins_dic);		
							
					$sql_bus_cur="select id_curso from curso where id_ano= ".$cod_anio." and grado_curso= ".trim($A06[4])." and letra_curso= '".trim($A06[5])."' and ensenanza=".trim($A06[3]);
					//echo "sql_bus_cur=$sql_bus_cur<br>";
					$result_cur= pg_exec($conn,$sql_bus_cur);
					$encontrados=pg_numrows($result_cur);
					//echo "encontrados=$encontrados<br>";
					
					for ($i=0;$i<$encontrados;$i++)
					{
						$id_curso=pg_result($result_cur,$i,"id_curso");
						//echo "id_curso=$id_curso<br>";
						
						
						
						
						//inserto ramo prueba 
						$sql_ins_ramo="insert into ramo (id_curso,cod_subsector) values (".$id_curso.",".trim($A06[9]).")";
						//echo "sql_ins_ramo=$sql_ins_ramo<br>";
						$result_ramo= @pg_exec($conn,$sql_ins_ramo);		
						
						//intento rescatar idramo
						
						$sql_bus_ramo="select id_ramo from ramo where id_curso=".$id_curso." and cod_subsector=".trim($A06[9]);	
						//echo "sql_bus_ramo=$sql_bus_ramo<br>";
						$result_bus_ramo= pg_exec($conn,$sql_bus_ramo);
						$encontrados2=pg_numrows($result_bus_ramo);
						//echo "encontrados2=$encontrados2<br>";
						
						for ($j=0;$j<$encontrados2;$j++)
						{
							$id_ramo=pg_result($result_bus_ramo,$j,"id_ramo");
							//echo "id_ramo=$id_ramo<br>";
							
							//update dicta
							$sql_up_dic="update dicta set id_ramo=".$id_ramo." where rut_emp=".trim($A06[10])."and id_ramo=0";
							//echo "sql_up_dic=$sql_up_dic<br>";
							$result_up_dic= pg_exec($conn,$sql_up_dic);
							
													
						 	//busco alumnos en tabla matricula por cursp
							$sql_bus_mat="select * from matricula where id_curso=".$id_curso;
							//echo "sql_bus_mat=$sql_bus_mat<br>";
							$result_bus_mat= pg_exec($conn,$sql_bus_mat);
							$encontrados3=pg_numrows($result_bus_mat);
							//echo "encontrados3=$encontrados3<br>";
							
							for ($k=0;$k<$encontrados3;$k++)
							{	
								
								$rut_alumno=pg_result($result_bus_mat,$k,"rut_alumno");
								//ver si existe
								$sql_alum="select * from tiene".$anio_escolar." where rut_alumno=".$rut_alumno."and id_ramo=".$id_ramo." and id_curso=".$id_curso;
								//echo "sql_alum=$sql_alum<br>";
								$result_alum= pg_exec($conn,$sql_alum);
								$encontrados_alum=pg_numrows($result_alum);
								//echo "encontrados_alum=$encontrados_alum<br>"; 
								if ($encontrados_alum==0)
								{
									
									//insert en tiene año prueba
									$sql_ins_tiene="insert into tiene".$anio_escolar." values(".$rut_alumno.",".$id_ramo.",".$id_curso.")";								//echo "sql_ins_tiene=$sql_ins_tiene<br>";
									$result_ins_tiene=@pg_exec($conn,$sql_ins_tiene);
								}									
							}
														
						}
												
					}
						
					
						
									
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
				$result_modifica = pg_exec($conn,$sql_modifica); 
			}	
							

// archivo 4
		if($fila_busca['numero']==4)
			{
				$archivo_04 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_04),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A04 = explode("\t", $buffer);

				$qry_04= "INSERT INTO archivo_04 VALUES (".trim($A04[0]).",".trim($A04[1]).",".trim($A04[2]).",".trim($A04[3]).",".trim($A04[4]).",'".trim($A04[5])."','".$anio_escolar."',".trim($A04[7]).",'".trim($A04[8])."',".trim($A04[9]).",".trim($A04[10]).",".trim($A04[11]).",'".trim($A04[12])."','".trim($A04[13])."','".trim($A04[14])."')";
				//echo "qry_04=$qry_04<br>"; 
					$result= pg_exec($conn,$qry_04);	
					
					//busco año escolar
					$sql_bucanio="select id_ano from ano_escolar where id_institucion=".$rdb." order by id_ano desc limit 1";
					$result_buscanio= pg_exec($conn,$sql_bucanio); 
					//echo "sql_bucanio=$sql_bucanio<br>";
					$cod_anio=trim(pg_result($result_buscanio,"id_ano"));
					//echo "cod_anio=$cod_anio<br>";
					
					
					//busco los cursos
					$sql_bus_cur="select * from curso where id_ano=".$cod_anio;
					//echo "sql_bus_cur=$sql_bus_cur<br>";
					$result_bus_cur= pg_exec($conn,$sql_bus_cur); 
					$encontrados_cur=pg_numrows($result_bus_cur);
					
					for ($h=0;$h<$encontrados_cur;$h++)
					{					
						$id_curso=trim(pg_result($result_bus_cur,$h,"id_curso"));
						//echo "id_curso=$id_curso<br>";
						
						//veo si ramo y curso existen
						//veo si estan los tipos de enseñanza
												
						//busco los ramos de un curso
						$sql_bus_ram="select * from ramo where cod_subsector=".trim($A04[11])."and id_curso=".$id_curso;
						//echo "sql_bus_ram=$sql_bus_ram<br>";
						$result_ramo = pg_exec($conn,$sql_bus_ram);
						$encontrados_ram=pg_numrows($result_ramo);
						//echo "encontrados_ram=$encontrados_ram<br>";
						
						// si ese curso tiene x ramo, busca a los alumnos que lo tienen
							for ($i=0;$i<$encontrados_ram;$i++)
						{
							$id_ramo=pg_result($result_ramo,$i,"id_ramo");
							$cod_subsector=pg_result($result_ramo,$i,"cod_subsector");
							
							//busco todos los alumnos que tienen ese ramo
							$sql_bus_alu="select * from tiene".$anio_escolar." where rut_alumno=".trim($A04[7])." and id_ramo=".$id_ramo;
							//echo "sql_bus_alu=$sql_bus_alu<br>";
							$result_alu = pg_exec($conn,$sql_bus_alu);
							$encontrados_alu=pg_numrows($result_alu);
							//echo "encontrados_alu=$encontrados_alu<br>";
							for($j=0;$j<$encontrados_alu;$j++)
							{
								$sql_bus_per="select * from periodo where id_ano=".$cod_anio;
								$result_per = pg_exec($conn,$sql_bus_per); 
								//echo "sql_bus_per=$sql_bus_per<br>";
								$encontrados_per=pg_numrows($result_per);
								//echo "encontrados_per=$encontrados_per<br>";
								
								for ($k=0;$k<$encontrados_per;$k++)
								{
									$id_periodo=pg_result($result_per,$k,"id_periodo");
									//echo "id_periodo=$id_periodo<br>";	
									
									$sql_bus_per="select * from notas".$anio_escolar." where rut_alumno=".trim($A04[7])." and id_ramo=".$id_ramo." and id_periodo=".$id_periodo;
									//echo "sql_bus_per=$sql_bus_per<br>"; 			
									$result_bus_per= pg_exec($conn,$sql_bus_per);
									$encontrados_bus_per=pg_numrows($result_bus_per);
									//echo "encontrados_bus_per=$encontrados_bus_per<br>";
									
									for ($l=0;$l<$encontrados_per;$l++)
									{
										$sql_ins_notas="insert into notas".$anio_escolar."  values (".trim($A04[7]).",".$id_ramo.",".$id_periodo.",'".trim($A04[12])."',0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,'".trim($A04[12])."')";
										//echo "sql_ins_notas=$sql_ins_notas<br>";
										$result_ins_notas = @pg_exec($conn,$sql_ins_notas);		
									}
								}
							}
							
										
						}
						
					}
					
					
						
					
							
									
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				$sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
				$result_modifica = pg_exec($conn,$sql_modifica); 
			}	



// archivo 5
		if($fila_busca['numero']==5)
			{
				$archivo_05 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_05),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A05 = explode("\t", $buffer);

					if(strlen($A05[9])<1)
					   $A05[9]=0;
					   
					if(strlen($A05[10])<1)
					   $A05[10]=0;
					   
				   if(strlen($A05[11])>1)
   				   {
				   	$mes = substr($A05[11],-2,2);
				   	$dia = substr($A05[11],-5,2);
				   	$fecha_retiro=$anio_escolar.'-'.$mes.'-'.$dia;
				   }
				   else
				   $fecha_retiro='1111-11-11';
				   
					if($A05[12]=='P')
					   $A05[12]=1;
					elseif($A05[12]=='R')
					   $A05[12]=2;
					elseif($A05[12]=='Y')
				   $A05[12]=3;  
				 
					   
					   if(strlen($A05[13])<1)
					   $A05[13]=0;
					   
					   

				 $qry_05= "INSERT INTO archivo_05 VALUES (".trim($A05[0]).",".trim($A05[1]).",".trim($A05[2]).",".trim($A05[3]).",".trim($A05[4]).",'".trim($A05[5])."',".trim($A05[6]).",".trim($A05[7]).",'".trim($A05[8])."',".trim($A05[9]).",".trim($A05[10]).",'".trim($A05[11])."','".trim($A05[12])."',".trim($A05[13]).")";
				//echo "qry_05=$qry_05<br>"; 
					$result= pg_exec($conn,$qry_05);
					
					//busco año escolar
					$sql_bucanio="select id_ano from ano_escolar where id_institucion=".$rdb." order by id_ano desc limit 1";
					$result_buscanio= pg_exec($conn,$sql_bucanio); 
					//echo "sql_bucanio=$sql_bucanio<br>";
					$cod_anio=trim(pg_result($result_buscanio,"id_ano"));
					//echo "cod_anio=$cod_anio<br>";
					
					//busco los cursos
					
					$sql_bus_cur="select * from curso where id_ano=".$cod_anio;
					//echo "sql_bus_cur=$sql_bus_cur<br>";
					$result_bus_cur= pg_exec($conn,$sql_bus_cur); 
					$encontrados_cur=pg_numrows($result_bus_cur);
					
					for ($i=0;$i<$encontrados_cur;$i++)
					{					
						$id_curso=trim(pg_result($result_bus_cur,$i,"id_curso"));
						//echo "id_curso=$id_curso<br>";
						
						
						
						//busco alumnos (tabla matricula)
						$sql_bus_alum="select * from matricula where id_curso=".$id_curso."and rut_alumno=".trim($A05[7]);
						//echo "sql_bus_alum=$sql_bus_alum<br>";
						$result_bus_alum= pg_exec($conn,$sql_bus_alum); 
						$encontrados_alu=pg_numrows($result_bus_alum);
						
						//echo "encontrados_alu=$encontrados_alu<br>";
						
						for ($j=0;$j<$encontrados_alu;$j++)
						{
							$rut_alumno=trim(pg_result($result_bus_alum,$j,"rut_alumno"));
							
							//busco si alumno existe
							$sql_bus_prom="select * from promocion where rut_alumno=".$rut_alumno." and rdb=".$rdb." and id_ano=".$cod_anio." and id_curso=".$id_curso;		
							$result_bus_prom= pg_exec($conn,$sql_bus_prom);
							//echo "sql_bus_prom=$sql_bus_prom<br>";
							$encontrados_bus_prom=pg_numrows($result_bus_prom);
							//echo "encontrados_bus_prom=$encontrados_bus_prom<br>";
							if($encontrados_bus_prom==0)
							{	
								// insertar en promocion
								$sql_ins_prom="insert into promocion (rdb,id_ano,id_curso,rut_alumno,promedio,situacion_final,fecha_retiro,asistencia) values (".$rdb.",".$cod_anio.",".$id_curso.",".$rut_alumno.",'".trim($A05[9])."',".$A05[12].",'".$fecha_retiro."',".$A05[10].")"; 
								//echo "sql_ins_prom=$sql_ins_prom<br>";
								$result_ins_prom = pg_exec($conn,$sql_ins_prom);
							}
						}
						
					}
					
					
					
							
									
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				 $sql_modifica = "UPDATE archivo_rech SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
				$result_modifica = pg_exec($conn,$sql_modifica);  
			}	
			/* 
			//archivo 01
			if($fila_busca['numero']==7)
			{
				$archivo_07 = "Archivos/".$fila_busca['nombre_archivo'];
				$fd = fopen(trim($archivo_07),"r");
				while (!feof($fd)) {
					$buffer = fgets($fd,4096);
					$A07 = explode("\t", $buffer);

				$qry_07= "INSERT INTO archivo_07 VALUES (".trim($A07[0]).",".trim($A07[1]).",".trim($A07[2]).",".trim($A07[3]).",".trim($A07[4]).",'".trim($A07[5])."',".$anio_escolar.",".trim($A07[7]).",".trim($A07[8]).",".trim($A07[9]).",".trim($A07[10]).",".trim($A07[11]).",".trim($A07[12]).",".trim($A07[13]).",'".trim($A07[14])."','".CambioFecha(trim($A07[15]))."','".trim($A07[16])."','".trim($A07[17])."')";
				echo "qry_07=$qry_07<br>"; 
					$result= pg_exec($conn,$qry_07);			
									
				}
				fclose ($fd);	
				// modificar el estado del archivo al valor 1 indicando 
				//$sql_modifica = "UPDATE archivo_rech_prueba SET estado_archivo=1 WHERE nombre_archivo='".$fila_busca['nombre_archivo']."' ";
				//$result_modifica = pg_exec($conn,$sql_modifica); 
			}	

			 */
		 }//termina for
 
}

		
			
			$sql_bor06="delete from archivo_06";
			$sql_bor21="delete from archivo_21";
			$sql_bor22="delete from archivo_22";
			$sql_bor01="delete from archivo_01";
			$sql_bor24="delete from archivo_24";
			$sql_bor03="delete from archivo_03";
			$sql_bor04="delete from archivo_04";
			$sql_bor05="delete from archivo_05";
			
			$result_06= pg_exec($conn,$sql_bor06);
			$result_21= pg_exec($conn,$sql_bor21);
			$result_22= pg_exec($conn,$sql_bor22);
			$result_01= pg_exec($conn,$sql_bor01);
			$result_24= pg_exec($conn,$sql_bor24);
			$result_03= pg_exec($conn,$sql_bor03);
			$result_04= pg_exec($conn,$sql_bor04);
			$result_05= pg_exec($conn,$sql_bor05); 

?>
<script language="javascript">
alert('Alta efectuada con éxito');
window.open ('CargaNew.php?rdb=<?php echo $rdb ?>&caso=1&anio_escolar=<?php echo $anio_escolar ?>&regimen=<?php echo $regimen ?>','_self');
</script>
<!-- copy archivo_01 from '/var/www/html/coeint_ver9.1/admin/institucion/ano/ActasMatricula/Rech/Archivos/a25131_1.txt' -->

</body>
</html>
