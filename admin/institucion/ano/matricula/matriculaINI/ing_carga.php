<?

@session_start();
require('../../../../clases/OpenConnect.php');

$institucion	= $_INSTIT;

$sql ="SELECT nombre FROM tmp_matricula WHERE rdb=".$institucion;
$rs_tmp = @pg_exec($conn,$sql);

for($j=0;$j<@pg_numrows($rs_tmp);$j++){
	$fila =@pg_fetch_array($rs_tmp,$j);
	$archivo_nombre = $fila['nombre'];
		
	
	 // ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
		 require_once 'Excel/reader.php';		 
		 $data = new Spreadsheet_Excel_Reader();
		 $data->setOutputEncoding('CP1251');
		 $data->read('files/'.$archivo_nombre);
		 
		 error_reporting(E_ALL ^ E_NOTICE);

         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		 
		     $nro_ano	    = $data->sheets[0]['cells'][$i][1];
			 $rdb		    = $data->sheets[0]['cells'][$i][2];
			 $tipo_ense		= $data->sheets[0]['cells'][$i][3];
			 $grado_curso   = $data->sheets[0]['cells'][$i][4];
			 $desc_grado	= $data->sheets[0]['cells'][$i][5];
			 $letra_curso	= $data->sheets[0]['cells'][$i][6];
			 $rut_alumno	= $data->sheets[0]['cells'][$i][7];
			 $dig_rut		= $data->sheets[0]['cells'][$i][8];
			 $nombres		= $data->sheets[0]['cells'][$i][9];
			 $ape_pat		= $data->sheets[0]['cells'][$i][10];
			 $ape_mat		= $data->sheets[0]['cells'][$i][11];
			 $sexo			= $data->sheets[0]['cells'][$i][12];
			 $fecha_nac		= $data->sheets[0]['cells'][$i][13];
			 $direc			= $data->sheets[0]['cells'][$i][14];
			 $ethnia		= $data->sheets[0]['cells'][$i][15];
			 $fecha_mat		= $data->sheets[0]['cells'][$i][16];
			 $fecha_ret		= $data->sheets[0]['cells'][$i][17];
			 
			 
			 if($sexo=="F"){
			 	$sex = 1;
			} else{
			 	$sex = 2;
			}	
			if(strlen($direc)==5){
				echo "<br>region ".$region = substr($direc,0,2);
				echo "--- ciudad ".$ciudad = substr($direc,2,1);
				echo "--- comuna ".$comuna = substr($direc,4,2);
			}else{
				echo "<br>region ".$region = substr($direc,0,1);
				echo "--- ciudad ".$ciudad = substr($direc,1,1);
				echo "--- comuna ".$comuna = substr($direc,3,2);
			}
			 
			/* $sql ="SELECT * FROM alumno WHERE rut_alumno=".$rut_alumno;
			 $rs_existe_alu = @pg_exec($conn,$sql);
			 
			 if(@pg_numrows($rs_existe_alu)==0){
			 	$sql = "INSERT INTO alumno (rut_alumno,dig_rut,nombre_alu,ape_pat,ape_mat,sexo,fecha_nac,region,ciudad,comuna) VALUES()";
				
			 }*/
		     // insertamos el registro en la base de datos			 
			// $sql_insertamos = mysql_query("insert into curso_cursos (id_area, programa, nombre_otec, nombre_curso, codigo_sence, horas_totales, fecha_inicio, fecha_termino, valor_curso, descuento, valor_total, lugar_ejecucion) values ('$area','$programa','$nombre_otec','$nombre_curso','$codigo_sence','$horas_totales','$fecha_inicio','$fecha_termino','$valor_curso','$descuento','$valor_total','$lugar_ejecucion')");				
			
         }	 exit;
}


//echo "<script>window.location='../cursos.php';</script>";

?>