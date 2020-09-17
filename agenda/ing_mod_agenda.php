<?
require('../util/header.inc');
$institucion	=$_INSTIT;
$ano			=$_ANO;
$_POSP = 2;
$_bot = 0;
$_MDINAMICO = 1;
$perfil = $_PERFIL; 
$usuarioensesion = $_USUARIOENSESION;

if ($fecha_caduca == NULL OR $fecha_caduca == ""){
   $fecha_caduca = "01-01-2001";
}

$dia  = substr($fecha_inicio,8,2);
$diac = substr($fecha_caduca,8,2); 

$tiempo = time();
$tiempo = substr($tiempo,4,3);

$file1   = $_FILES['file']['name'];
$imagen1 = $_FILES['imagen']['name'];

$sql = "select * from agenda where rdb = $institucion and id_padre = $id_padre";
$result = pg_Exec($conn,$sql);
$fila = pg_fetch_array($result);

if ($_FILES['file']['size']!= 0){
   $file1   = "$tiempo$file1";
}elseif($fila['file']!=NULL)
{ 
	$file1 = $fila['file'];
}
	
if ($_FILES['imagen']['size']!= 0){   
   $imagen1 = "$tiempo$imagen1";
   }elseif($fila['imagen']!=NULL)
{
	$imagen1 = $fila['imagen'];	
}	
   $n_fecha=$fecha_inicio; 
//-------------------------- Cuenta dias a ingresar
function CalculaDias($fec0, $fec1){ 
	$s = strtotime($fec1)-strtotime($fec0);
	$d = intval($s/86400);
	$s -= $d*86400;
	$h = intval($s/3600);
	$s -= $h*3600;
	$m = intval($s/60);
	$s -= $m*60;
	return $d;
}

$dia1= $fecha_inicio;
$dia2= $fecha_caduca;
$a=CalculaDias($dia1, $dia2);
$cont_dias = 0;

//-----------------------------

$qry = "delete from agenda where rdb = $institucion and id_padre = $id_padre";
$res = pg_Exec($conn,$qry);


if ($a >= 0){
   
   $aume=0;
  
   while ($cont_dias <= $a){   			

			$sqlInsert = "insert into agenda 
	   		(rdb,id_curso,id_ano,id_usuario,fecha,caduca,titulo,detalle,file,imagen,para,id_padre)     values 
	   		('$institucion','$cmb_curso','$ano','$perfil','$n_fecha','$fecha_caduca','$titulo','$detalle','$file1','$imagen1','$cmb_curso','$id_padre')";
		    $rsInsert = pg_Exec($conn,$sqlInsert);
 
		
	   $aume++; 
	   $n_fecha=suma_dias($fecha_inicio,$aume);
       $cont_dias++;

	   
	   }
}else{
			$sqlInsert = "insert into agenda 
	   		(rdb,id_curso,id_ano,id_usuario,fecha,caduca,titulo,detalle,file,imagen,para,id_padre)     values 
	   		('$institucion','$cmb_curso','$ano','$perfil','$n_fecha','$fecha_caduca','$titulo','$detalle','$file1','$imagen1','$cmb_curso','$id_padre')";
		    $rsInsert = pg_Exec($conn,$sqlInsert);
		
}

if (!$rsInsert){
    echo "ERROR EN: $sqlInsert"; 
    exit;
}else{
    // copiamos ahora el archivo en el servidor
	//$newfile = "/var/www/html/coeint_ver9.1/tmp/".$txtNOMBRE;
	if ($_FILES['file']['size'] != 0){
       if (!copy($file,"files/".$file1)) {
          echo "No se puede subir el archivo adjunto";
       }
	}
	if ($_FILES['imagen']['size'] != 0){
	   if (!copy($imagen,"images/".$imagen1)) {
           echo "No se puede subir la foto";
       }
	}   
}	



function suma_dias($fecha,$ndias)
{
      if (preg_match("/[0-9]{1,2}\/[0-9]{1,2}\/([0-9][0-9]){1,2}/",$fecha))
              list($año,$mes,$dia)=split("/", $fecha);
      if (preg_match("/[0-9]{1,2}-[0-9]{1,2}-([0-9][0-9]){1,2}/",$fecha))
              list($año,$mes,$dia)=split("-",$fecha);

      $nueva = mktime(0,0,0, $mes,$dia,$año) + $ndias * 24 * 60 * 60;
      $nuevafecha=date("Y-m-d",$nueva);
      return ($nuevafecha);  
}



	

?>

<script language="javascript">window.location="lista_agenda.php?sw=1"</script>