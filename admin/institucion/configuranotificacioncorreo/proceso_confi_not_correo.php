<? require('../../../util/header.inc');

$institucion = $_INSTIT;

$ruts="NULL";
$tipoensenanza="NULL";
$select_cargo="NULL";
$checkboxnotas="NULL";
$cant_notas="NULL";
$nota_def="NULL";
$checkboxAsistencia="NULL";
$dias_not="NULL";
$selec_periodo="NULL";
$checkboxAnotaciones="NULL";
$cant_anot="NULL";
$nombre_configuracion="NULL";
$id_notifica_correo_configuracion="NULL";

if(trim($_REQUEST['ruts'])!=""){
  $ruts = trim($_REQUEST['ruts']);
  $elrut = explode(" ",$ruts); 
 }

if($_POST['id_notifica_correo_configuracion']!="") $id_notifica_correo_configuracion = $_POST['id_notifica_correo_configuracion'];
if($_POST['tipoensenanza']!="") $tipoensenanza=$_POST['tipoensenanza'];
if($_POST['select_cargo']!="") $select_cargo=$_POST['select_cargo'];
if($_POST['checkboxnotas']!="") $checkboxnotas=$_POST['checkboxnotas'];
if($_POST['cant_notas']!="") $cant_notas=$_POST['cant_notas'];
if($_POST['nota_def']!="") $nota_def=$_POST['nota_def'];
if($_POST['checkboxAnotaciones']!="") $checkboxAnotaciones=trim($_POST['checkboxAnotaciones']);
if($_POST['cant_anot']!="") $cant_anot=$_POST['cant_anot'];
if($_POST['checkboxAsistencia']!="") $checkboxAsistencia=$_POST['checkboxAsistencia'];
if($_POST['dias_not']!="") $dias_not=$_POST['dias_not'];
if($_POST['selec_periodo']!="") $selec_periodo=$_POST['selec_periodo'];
if($_POST['nombre_configuracion']!="") $nombre_configuracion=$_POST['nombre_configuracion'];

/*$sql="SELECT * FROM notifica_correo_configuracion as ncc 
WHERE ncc.rbd = $institucion  AND ncc.tipo_ensenanza = $tipoensenanza"; 
$rs_ncc = pg_exec($conn,$sql); //or die (pg_last_error($conn));
*/

if ($id_notifica_correo_configuracion==0){

echo "0"; //"INSERT";
	
$sql0 = "INSERT INTO notifica_correo_configuracion
	     (id_notifica_correo_configuracion,rbd,tipo_ensenanza,
	     cargo,notifica_notas,nro_notas,nota_deficiente,notifica_anotaciones,
	     nro_anotaciones,notifica_asistencia,dias_asistencia,periodo_notificacion,nombre_configuracion ) 
	     VALUES
	     (DEFAULT,$_INSTIT,$tipoensenanza,$select_cargo,$checkboxnotas,$cant_notas,$nota_def,
	     $checkboxAnotaciones,$cant_anot,$checkboxAsistencia,$dias_not,$selec_periodo,'$nombre_configuracion')";
	     pg_exec($conn,$sql0) or die (pg_last_error($conn).'Li53');
	
$sq="SELECT id_notifica_correo_configuracion FROM notifica_correo_configuracion ORDER BY 1 DESC LIMIT 1";
$rs = pg_exec($conn,$sq) or die (pg_last_error($conn).'Li56');
$id_configuracion = pg_result($rs,0);

// Lista de empleados ha enviar correo notificacion
	$sql1  .=  "";
	
	for( $i = 0; $i < count($elrut); $i ++){

       $sql1 .= "INSERT INTO notifica_correo_empleados    
	(id_notifica_correo_empleados,id_notifica_correo_configuracion,rut_empleado) VALUES"; 
	   $sql1 .= "(DEFAULT,$id_configuracion,".$elrut[$i].");";

	   }
	
	$sql1 = substr ($sql1,0,-1);
    $rs_empleados = pg_exec($conn,$sql1) or die (pg_last_error($conn).'Li66');


 }else{ 

    echo "1";  //"UPDATE";

    if( ($checkboxnotas=='NULL') and ($checkboxAnotaciones=='NULL')  and  ($checkboxAsistencia=='NULL') ){
		
		// Eliminar Configuracion...
		$sql4 = "DELETE FROM notifica_correo_configuracion WHERE id_notifica_correo_configuracion = 
		$id_notifica_correo_configuracion";
		$rg_delete = pg_exec ($conn,$sql4) or die ( pg_last_error($conn.'Li84') );
		
		// Elimino Todos los Relacionados al ID...
		$sql4 = "DELETE FROM notifica_correo_empleados WHERE id_notifica_correo_configuracion = 
		$id_notifica_correo_configuracion";
		$rg_delete = pg_exec ($conn,$sql4) or die ( pg_last_error($conn.'Li89') );
		
		}else{
	
	$sql3 = "UPDATE notifica_correo_configuracion SET cargo = $select_cargo,
	notifica_notas = $checkboxnotas,nro_notas = $cant_notas,
	nota_deficiente = $nota_def,notifica_anotaciones = $checkboxAnotaciones,
	nro_anotaciones = $cant_anot,notifica_asistencia = $checkboxAsistencia,
	dias_asistencia = $dias_not,periodo_notificacion = $selec_periodo,nombre_configuracion = '$nombre_configuracion' 
	WHERE id_notifica_correo_configuracion = $id_notifica_correo_configuracion";
	$rg_update = pg_exec($conn,$sql3); //or die (pg_last_error());

	// Elimino Todos los Relacionados al ID
	$sql4 = "DELETE FROM notifica_correo_empleados WHERE id_notifica_correo_configuracion = 
	$id_notifica_correo_configuracion";
	$rg_delete = pg_exec ($conn,$sql4) or die ( pg_last_error($conn.'Li103') );

    // Ingreso la nueva lista
    // lista de empleados ha enviar correo notificacion
	$sql1 = ""; 
	
	for( $i = 0; $i < count($elrut); $i ++){
		      $sql1 .= "INSERT INTO notifica_correo_empleados    
			  (id_notifica_correo_empleados,id_notifica_correo_configuracion,rut_empleado) 
			   VALUES (DEFAULT,$id_notifica_correo_configuracion,".$elrut[$i].");";
	        }
	
	$rs_empleados = pg_exec($conn,$sql1) or die ( pg_last_error($conn).'Li117' );
	//$sql1 .= " RETURNING id_notifica_correo_empleados;";
	//$id_correo_empleados = @pg_result($rs_empleados,0);
	
	 };

   } // Fin de Validacion

?>