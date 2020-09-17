<?	header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
//print_r($_POST);


$funcion=$_POST['funcion'];
"funcion-->".$funcion;


require "mod_ficha_academica_curso.php";

$institucion=$_INSTIT;
$objMembrete= new Membrete($_IPDB,$_DBNAME);
$Obj_FichaAcademica_curso = new FichaAcademica_curso($_IPDB,$_DBNAME);




$separaDatos=explode("*",$funcion);

$separar=explode("/",$separaDatos[0]);
$cantidad=$separar[1];
$separaCant=explode("=",$cantidad);
$separaCant[0];
 "nomerofor-->".$numerofor= $separaCant[1];
$fecha = date("Y-m-d");


for($i=0; $i < $numerofor; $i++){
	
	
echo"Datos-->".$separaDatos[$i];


$separa1=explode("/",$separaDatos[$i]);

	$rut_alum=$separa1[2];
	$rut=explode("-",$rut_alum);
	 "Rut_alumno-->".$rut_alumno=$rut[0];
	"promedio_interno-->".$promedio_interno=$separa1[3];
	"notaExt-->".$notaExt=$separa1[4];
	"promedio-->".$promedio=$separa1[5];
	"id_nivel_final-->".$id_nivel_final=$separa1[6];
	"diferencia-->".$diferencia=$separa1[7];
	"observacion-->".$observacion=$separa1[8];
	"id_ramo-->".$id_ramo=$separa1[9];
	"id_periodo-->".$id_periodo=$separa1[10];
	"id_curso-->".$id_curso=$separa1[11];
	"id_ano-->".$id_ano=$separa1[12];
	"id_conf-->".$id_conf=$separa1[13];	
	"id_nivel-->".$id_nivel_interno=$separa1[14];	
	
	
	if($notaExt==""){
		continue;
		}
	
	echo $sql_insert = "INSERT INTO cede.notas_evaluacion
	(id_ano,id_curso,id_ramo,rut_alumno,fecha,id_periodo,prom_interno,id_nivel_interno,notas_externas,id_nivel_externo,
	nota_diferencia,observaciones,id_conf,promedio_final) 
	VALUES
(".$id_ano.",".$id_curso.",".$id_ramo.",".$rut_alumno.",'".$fecha."',".$id_periodo.",".trim($promedio_interno).",".$id_nivel_interno.",".$notaExt.",".$id_nivel_final.",".$diferencia.",'".$observacion."',".$id_conf.",".$promedio.");";

exit;
	$regis = @pg_Exec($Obj_FichaAcademica_curso->Conec->conectar(),$sql_insert)or die( "Error bd insert 1" );
		

	}
		if($regis){
		return 1;
		}else{
		return 0;
		}
 


?>