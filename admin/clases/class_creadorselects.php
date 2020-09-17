<?  
require "../../util/connect.php";
//include('class_MotorBusqueda.php');

$select = $_POST[select];

 
//************INICIO******************
switch ($select) {   

	case "curso" :

         /*$ob_motor = new MotorBusqueda();
		 $ob_motor->ano= $idano;
		 $resul = $ob_motor->curso($conn);*/
		 
		 $sql= "SELECT DISTINCT 
				curso.id_curso, 
				(curso.grado_curso || ' - ' || curso.letra_curso || '  ' || tipo_ensenanza.nombre_tipo ) as curso ,
				tipo_ensenanza.nombre_tipo,
				curso.ensenanza, curso.cod_decreto 
				FROM curso 
				INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo 
				WHERE curso.id_ano = ".$_POST[idano]." ORDER BY 3,4";
					
		 $resul = @pg_exec($conn,$sql) or die ("Select falló Crear Curso : ".$sql);
		
		 echo   '<select name="cmb_curso" id="cmb_curso" class="ddlb_x" >';
         echo   '<option value="0" selected>(Seleccione un Curso)</option> ';
			 	   
		 for($i=0 ; $i < @pg_numrows($resul) ;++$i)
			{   $fila = @pg_fetch_array($resul,$i);
		 
		 echo "<option value=".$fila['id_curso'].">".$fila['curso']."</option>";
		
			  }
	
	break;

	case "alumno":
	
	      echo "alumno";
	
	break;
	
	case "instituciones":
	
	      echo "instituciones";
	
	break;


} 

// *************TERMINIO******************** */


?>