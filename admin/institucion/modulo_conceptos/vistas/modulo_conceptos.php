<?  	
session_start();	
require_once('../../../../util/header.inc');
require_once('../Controlador_Masivo.php');

$Obj = new Controlador_Masivo($conn,"modulo_conceptos.php","ModuloConceptosModelo",$_ANO,$_INSTIT);

//respetar la secuencia en el SWITCH de los Valores Ingresados...

		switch ($_GET['var']) {
			case 1:
				//Nombre a los campos y nombre a las acciones sino se toman los por defecto
			   echo "<h1>Listado de Conceptos</h1>";
			   $result = $Obj->Listado_Datos($Campos=array(),$Accion=array());
			   break;
			case 2:
		       echo $Obj->Form_Agregar();
			   break;
			case 3:
		       echo $Obj->Guardar($_GET);
			   break;
			case 4:
		       echo $Obj->Form_Modificar($_GET);
			   break;   
			case 5:
		       echo $Obj->Modificar($_GET);
			   break;
		   case 6:
			   echo $Obj->Eliminar($_GET);
			   break;         
		    }

?>