<?
@session_start();
include('conn.php');

// recibo las variables del formulario
$tamano_archivo     = $_FILES['file']['size'];
$archivo_nombre     = $_FILES['file']['name'];
$archivo_nombre_tmp = $_FILES['file']['tmp_name'];


$tiempo = time();
$tiempo = substr($tiempo,5,5);
$archivo_nombre = $tiempo.$archivo_nombre;

/// ingresamos la carga en la tabla carga_facturas

if ($tamano_archivo>0){
    
	// cargamos el archivo al servidor
	if (!copy("$archivo_nombre_tmp","archexcel/$archivo_nombre")){
	     echo "Error, archivo no se pudo copiar";
	}else{
	     
		 // ingresado el archivo, procedemos a leerlo y a guardarlo en base de datos
		 require_once 'Excel/reader.php';		 
		 $data = new Spreadsheet_Excel_Reader();
		 $data->setOutputEncoding('CP1251');
		 $data->read('archexcel/'.$archivo_nombre);
		 
		 error_reporting(E_ALL ^ E_NOTICE);

         for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
		 
		     echo "ano -->".$nro_ano	       			= $data->sheets[0]['cells'][$i][1];
			 echo "  ..rdb -->".$rdb		       		= $data->sheets[0]['cells'][$i][2];
			 echo "  ..tipo_ense -->".$tipo_ense		= $data->sheets[0]['cells'][$i][3];
			 echo "  ..grado_curso -->".$grado_curso    = $data->sheets[0]['cells'][$i][4];
			 echo "  ..desc_curso -->".$desc_grado		= $data->sheets[0]['cells'][$i][5];
			 echo "  ..letra_curso -->".$letra_curso	= $data->sheets[0]['cells'][$i][6];
			 echo "  ..rut_alumno -->".$rut_alumno		= $data->sheets[0]['cells'][$i][7];
			 echo "  ..dig_rut -->".$dig_rut			= $data->sheets[0]['cells'][$i][8];
			 echo "  ..nombres -->".$nombres			= $data->sheets[0]['cells'][$i][9];
			 echo "  ..ape_pat -->".$ape_pat			= $data->sheets[0]['cells'][$i][10];
			 echo "  ..ape_mat -->".$ape_mat			= $data->sheets[0]['cells'][$i][11];
			 echo "  ..sexo -->".$sexo					= $data->sheets[0]['cells'][$i][12];
			 echo "  ..fecha_nac -->".$fecha_nac		= $data->sheets[0]['cells'][$i][13];
			 echo "  ..direc -->".$direc				= $data->sheets[0]['cells'][$i][14];
			 echo "  ..ethnia -->".$ethnia				= $data->sheets[0]['cells'][$i][15];
			 echo "  ..fecha_mat -->".$fecha_mat		= $data->sheets[0]['cells'][$i][16];
			 echo "  ..fecha_ret -->".$fecha_ret		= $data->sheets[0]['cells'][$i][17];
			 echo "<br>";
		     // insertamos el registro en la base de datos			 
			// $sql_insertamos = mysql_query("insert into curso_cursos (id_area, programa, nombre_otec, nombre_curso, codigo_sence, horas_totales, fecha_inicio, fecha_termino, valor_curso, descuento, valor_total, lugar_ejecucion) values ('$area','$programa','$nombre_otec','$nombre_curso','$codigo_sence','$horas_totales','$fecha_inicio','$fecha_termino','$valor_curso','$descuento','$valor_total','$lugar_ejecucion')");				
			
         }	 
		 		 
	}	

}

//echo "<script>window.location='../cursos.php';</script>";

?>