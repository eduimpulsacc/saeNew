<?
require('../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$ano3			=$_ANO;
$curso          =$_CURSO;
$_POSP = 2;
$_bot = 0;
    
$perfil = $_PERFIL; 

$usuarioensesion = $_USUARIOENSESION;


if ($borra_g==1){
    // borrar
	$q1 = "delete from grupos where id_grupo = '$id_grupo'";
	$r1 = pg_Exec($conn,$q1);
	
	
	echo "<script>window.location='adm_grupos.php'</script>"; 
    exit();
	
}	

if ($id_grupo!=NULL){
    // es actualizar
	$q1 = "update grupos set nombre = '$nombre', descripcion = '$descripcion' where id_grupo = '$id_grupo' and rdb = '".trim($institucion)."'";
	$r1 = pg_Exec($conn,$q1);
	
	echo "<script>window.location='adm_grupos.php'</script>"; 
    exit();
}



// grabo el grupo
$q1 = "insert into grupos (rdb,nombre,descripcion) values ('".trim($institucion)."','$nombre','$descripcion')";
$r1 = pg_Exec($conn,$q1);

echo "<script>window.location='adm_grupos.php'</script>"; 


?>
