<?
echo "<script>alert('llegada valida Notas')</script>";
require('../../../../../util/header.inc');

$institucion	= $_INSTIT;

	if (!empty($_FILES)) {
		$tempFile = $_FILES['archivo']['tmp_name'];
		$targetPath = "files/";
		$tiempo      = time();
		$newFileName = $institucion."_".$tiempo.".xls";
		$targetFile =  str_replace('//','/',$targetPath) . $newFileName;

		$sql="DELETE FROM tmp_notas WHERE rdb=".$institucion."";
		$rs_xxx = pg_exec($conn,$sql);
		
		$sql = "INSERT INTO tmp_notas(rdb,nombre) VALUES (".$institucion.",'".trim($newFileName)."')";
		$rs_tmp = pg_exec($conn,$sql);
		
		move_uploaded_file($tempFile,$targetFile);
	}

	$institucion	=$_INSTIT;
    $ano			=$_ANO;
	
	$cont=0;
	require_once("Excel/reader.php");		 
	$data = new Spreadsheet_Excel_Reader();
	$data->setOutputEncoding('CP1251');
	
	
$sql ="SELECT nombre FROM tmp_notas WHERE rdb=".$institucion;
	$rs_tmp = @pg_exec($conn,$sql)or die("Fallo ".$sql);
	
	pg_numrows($rs_tmp);


	for($j=0;$j<@pg_numrows($rs_tmp);$j++){
		$fila =@pg_fetch_array($rs_tmp,$j);
		$archivo_nombre = $fila['nombre'];
		
	
		// ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
			
		 $data->read('files/'.$archivo_nombre);
		 	
		 error_reporting(E_ALL ^ E_NOTICE);
		echo "<br>"."Nº".$data->sheets[0]['numRows'];
		
         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		
		
		   $sw=0;
		     echo "<br>";
			 
				echo "nro año-->".$nro_ano	    = $data->sheets[0]['cells'][$i][1];
				echo ".. rdb -->".$rdb		    = $data->sheets[0]['cells'][$i][2];
				echo ".. rut -->".$rut_alumno	= $data->sheets[0]['cells'][$i][3];
				echo ".. dig rut -->".$dig_rut		= $data->sheets[0]['cells'][$i][4];
				echo ".. nombres -->".$nombres		= $data->sheets[0]['cells'][$i][5];
				echo ".. paterno -->".$ape_pat		= $data->sheets[0]['cells'][$i][6];
				echo ".. materno -->".$ape_mat		= $data->sheets[0]['cells'][$i][7];
				echo ".. codigo -->".$codigo		= $data->sheets[0]['cells'][$i][8];
				echo ".. tipo ensenanza -->".$tipo_ense= $data->sheets[0]['cells'][$i][9];
				echo ".. cod grado -->".$cod_grado   = $data->sheets[0]['cells'][$i][10];
				echo ".. grado curso -->".$grado_curso	= $data->sheets[0]['cells'][$i][11];
				echo ".. letra -->".$letra_curso	= $data->sheets[0]['cells'][$i][12];
				echo ".. cod subsector -->".$cod_subsec	= $data->sheets[0]['cells'][$i][13];
				echo ".. desc subsectot -->".$desc_subsec	= $data->sheets[0]['cells'][$i][14];
				echo ".. alumno eximido -->".$alumno_ex	= $data->sheets[0]['cells'][$i][15];
				echo ".. nota conceptual -->".$nota_conceptual	= $data->sheets[0]['cells'][$i][16];
				echo ".. calificacion -->".$calificacion	= $data->sheets[0]['cells'][$i][17];

			$cursos = $desc_grado."º".$letra_curso;
			 echo "<br>".$codigo."--".$codigo2;
			 echo "<br>".$cod_grado."--".$cod_grado2;
			 echo "<br>".$letra_curso."--".$letra_curso2;
			
		if($codigo!=$codigo2 or $cod_grado!=$cod_grado2 or $letra_curso!=$letra_curso2){
				echo "<br>".$sql = "SELECT * FROM curso WHERE id_ano=".$ano." AND ensenanza=".$codigo." AND grado_curso=".$cod_grado." AND letra_curso='".$letra_curso."'";
				$rs_curso = @pg_exec($conn,$sql)or die("Fallo ".$sql);
				$fila=pg_fetch_array($rs_curso);
				$id_curso=$fila['id_curso'];
				
				if($cursos2!=$cursos){
					if(@pg_numrows($rs_curso)==0){
						$cont++;
						$curso[$cont] = "<br>curso :".$cursos;
						
					}	
				}
			}else{
				echo "<br> no entro";
			}
			$cursos2= $desc_grado."º".$letra_curso;	 
			$codigo2 = $codigo;	
			$cod_grado2 = $cod_grado;
			$letra_curso2 = $letra_curso;
		
			
		$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
		$result_ano =@pg_Exec($conn,$sql_ano);
		$fila_ano = @pg_fetch_array($result_ano,0);
		$nro_ano = $fila_ano['nro_ano'];	
			
		  $sql="select * from ramo where id_curso=".$id_curso." and cod_subsector=".$cod_subsec.";";
		 $resultado = pg_Exec($conn,$sql)or die("Fallo " .$sql);
		 $fila_curso=pg_fetch_array($resultado,0);
		 $id_ramo=$fila_curso['id_ramo'];
		 
		 $qry="select * from notas$nro_ano where rut_alumno=".$rut_alumno." and id_ramo=".$id_ramo;
		 $res = pg_Exec($conn,$qry)or die ("PLW ".$qry);
		 
		 if($sw==0){
				for($k=0;$k<pg_numrows($resultado);$k++){
					$sql_del="DELETE from notas$nro_ano where id_ramo=".$id_ramo." and rut_alumno=".$rut_alumno;
					$rs_del=pg_Exec($conn,$sql_del)or die("No se puede borrar ".$sql_del);
					echo "<br>"."ID RAMO".$id_ramo;
					
					}
			$sw=1;
			
			
				}
		 
		  $cadena = $calificacion;
          $nota = ereg_replace("[.]", "", $cadena);
		  if($nota_conceptual!=""){
			  $nota=$nota_conceptual;
		  }
		  
		
		$qry="select id_periodo from periodo where id_ano=".$ano;
		$res_per=pg_Exec($conn,$qry)or die("Fallo periodo ".$qry); 
	
		
		for($j=0;$j<pg_numrows($res_per);$j++){
			$fila_per = @pg_fetch_array($res_per,$j);
			$sql = "INSERT INTO notas$nro_ano (rut_alumno,id_ramo,id_periodo,nota1,promedio) values(".$rut_alumno.",".$id_ramo.",".$fila_per['id_periodo'].",'".$nota."','".$nota."')";
			$rs_insert=pg_Exec($conn,$sql)or die("Fallo insert ".$sql);
			
		   }
		  
         }		
		 echo "<script>alert('Datos Guardados con Exito')</script>";
		  echo "<script>window.location='notas_iniciales.php'</script>";
			
   	 }
	  

	/*fclose('files/'.$archivo_nombre);
	if($cont==0){
		 "<script>window.location='inscribe_alumnos.php'</script>";
	}*/
	



pg_close($conn);?>