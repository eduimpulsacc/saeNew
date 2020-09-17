<?	header( 'Content-type: text/html; charset=iso-8859-1' );
session_start();
//print_r($_POST);


$funcion=$_POST['funcion'];
"funcion-->".$funcion;


require "Mod_Ensayo_PSU.php";

$institucion=$_INSTIT;
//$objMembrete= new Membrete($_IPDB,$_DBNAME);
$Obj_Ensayo_Psu = new EnsayoPSU($conn);



$separaDatos=explode("*",$funcion);

$separar=explode("|",$separaDatos[0]);
$cantidad=$separar[1];
$separaCant=explode("=",$cantidad);
$separaCant[0];
 "numerofor-->".$numerofor= $separaCant[1];


for($i=0; $i < $numerofor; $i++){
	
	
"Datos-->".$separaDatos[$i];


 $separa1=explode("|",$separaDatos[$i]);

	
	"Rut_alumno-->".$rut_alumno=$separa1[2];
	"puntaje-->".$puntaje=$separa1[3];
	"id_curso-->".$id_curso=$separa1[4];
    "id_ramo-->".$id_ramo=$separa1[5];
	"Fecha-->".$fecha=$separa1[6];
	"ano-->".$ano=$separa1[7];
	
	
	if($puntaje==""){
		continue;
		}
	
	 $sql_insert = "INSERT INTO ensayos_psu(id_ano,id_ramo,id_curso,rut_alumno,fecha,puntaje) 
	                 VALUES
                     (".$ano.",".$id_ramo.",".$id_curso.",".$rut_alumno.",'".$fecha."',".$puntaje.");";
					 
					 
					 if($_PERFIL==0){echo $sql_insert;}

	                $regis=pg_Exec($conn,$sql_insert);
		

	}
		if($regis){
		echo 1;
		}else{
		echo 0;
		}
 


?>