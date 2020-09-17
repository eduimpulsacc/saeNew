<?	header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();

//print_r($_POST);
require "Mod_AtrasosMinutosEmp.php";

$funcion=$_POST['funcion'];

"funcion-->".$funcion;


 $separaDatos=explode("*",$funcion);

//print_r($separaDatos);

$separar=explode("/",$separaDatos[0]);

//print_r($separar);
$cantidad=$separar[1];
$separaCant=explode("=",$cantidad);
$separaCant[0];
 "nomerofor-->".$numerofor= $separaCant[1];
//$fecha = date("Y-m-d");



for($i=0; $i < $numerofor; $i++){
	
 //echo "Datos-->".$separaDatos[$i];


$separa1=explode("/",$separaDatos[$i]);
//print_r($separa1);

	 $id_ano=$separa1[2];
     $fecha=$separa1[3];
	 $rut_alumno=$separa1[4];
	 $minutos=$separa1[5];
	
	if($minutos==""){
		continue;
		}
	
	 $sql_insert = "INSERT INTO atraso_minutosemp
	(id_ano,fecha_atraso,rut_empleado,minutos_atraso) 
	VALUES
(".$id_ano.",'".$fecha."',".$rut_alumno.",".$minutos.");";

	$regis = @pg_Exec($conn,$sql_insert);		

	}
		if($regis){
		echo 1;
		}else{
		echo 0;
		}
 


?>