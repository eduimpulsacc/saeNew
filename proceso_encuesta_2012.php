<? 

header( 'Content-type: text/html; charset=iso-8859-1' ); 
 
require('util/header.inc');

			
			$id_pregunta = $_POST['id_pregunta'];
			
			$rdb  = $_POST['rdb'];
			$id_perfil  = $_POST['id_perfil'];
			$rut_empleado  = $_POST['rut_empleado'];
			$ano  = $_POST['ano'];
			
			$notas = $_POST['nota'];
			$mensajes = $_POST['mensaje'];
			$afirmaciones = $_POST['afirmacion'];


			$x1="";
			foreach ($notas as $key => $value) 
			{
				if( $value != "")
				{
				    $x1++;	
				}
			}
		
			
		    $x2="";
			foreach ($afirmaciones as $key => $value) 
			{
				if( $value != "")
				{
				    $x2++;	
				}
			}


		if(	(count($id_pregunta)-1)  >  ($x1+$x2)		) {
			echo "Porfavor Completar Toda la Encuesta ";
			return;
		}  


		for ($i=0; $i < count($id_pregunta) ; $i++) 
		{
				 
			if(!empty($notas[$i]))
			{
				
			$sql =  "INSERT INTO encuesta.respuestas_encuestas ( id, rdb,  id_perfil,  rut_usuario,  id_ano,   for_id_preg,   respuestas,   fecha_registro ) 
		VALUES (  DEFAULT,".$rdb[$i].", ".$id_perfil[$i].",".$rut_empleado[$i].",".$ano[$i].",".$id_pregunta[$i].",'".$notas[$i]."',   DEFAULT );";
		   $result = @pg_Exec($connection,$sql);
		
		   }
			
			
			if(!empty($mensajes[$i]))
			{
					
			$sql =  "INSERT INTO encuesta.respuestas_encuestas ( id, rdb,  id_perfil,  rut_usuario,  id_ano,   for_id_preg,   respuestas,   fecha_registro ) 
		VALUES (  DEFAULT,".$rdb[$i].", ".$id_perfil[$i].",".$rut_empleado[$i].",".$ano[$i].",".$id_pregunta[$i].",'".$mensajes[$i]."',   DEFAULT );";
		$result = @pg_Exec($connection,$sql);
				
			}
		
			
			if(!empty($afirmaciones[$i]))
			{
					
			$sql =  "INSERT INTO encuesta.respuestas_encuestas ( id, rdb,  id_perfil,  rut_usuario,  id_ano,   for_id_preg,   respuestas,   fecha_registro ) 
		VALUES (  DEFAULT,".$rdb[$i].", ".$id_perfil[$i].",".$rut_empleado[$i].",".$ano[$i].",".$id_pregunta[$i].",'".$afirmaciones[$i]."',   DEFAULT );";
		   $result = @pg_Exec($connection,$sql);
			
			}
			
			
		 }

		  echo 1;
		  

?>