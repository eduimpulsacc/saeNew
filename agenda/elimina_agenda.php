<? 
require('../util/header.inc');

$institucion	=$_INSTIT;
$ano			=$_ANO;
$ano3			=$_ANO;
$curso          =$_CURSO;
$_POSP = 2;
$_bot = 0;

if ($ano > 0){
   $_MDINAMICO = 1;
}else{
   $_MDINAMICO = 0;
}
      
$perfil = $_PERFIL; 



	
$usuarioensesion = $_USUARIOENSESION;


	
	$sqlDelete =  "delete from agenda where id_padre = $id_padre";
	$rsDelete = @pg_Exec($conn,$sqlDelete);
	
?>

<script language="javascript">window.location="lista_agenda.php?sw=1"</script>









