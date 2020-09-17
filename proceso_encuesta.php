<? 

header( 'Content-type: text/html; charset=iso-8859-1' ); 
 
require('util/header.inc');

			
$contador	= $_POST['contador'];
$rdb		= $_INSTIT;
$ano 		= $_ANO;
$perfil 	= $_PERFIL;
$rut 		= $_NOMBREUSUARIO;

for($i=0;$i<$contador;$i++){
	$pregunta = ${"id_pregunta".$i};
	$nota = ${"cmbNOTA".$i};
	$observacion = ${"cmbOBS".$i};
	
						
	$sql =  "INSERT INTO encuesta.respuestas_encuestas ( id, rdb,  id_perfil,  rut_usuario,  id_ano,   for_id_preg,   respuestas,   fecha_registro ) 
	VALUES (  DEFAULT,".$rdb.", ".$perfil.",".$rut.",".$ano.",".$pregunta.",'".$nota."',   DEFAULT );";
	$result = @pg_Exec($connection,$sql);
	
	if($observacion!=""){
		$sql =  "INSERT INTO encuesta.respuestas_encuestas ( id, rdb,  id_perfil,  rut_usuario,  id_ano,   for_id_preg,   respuestas,   fecha_registro ) 
	VALUES (  DEFAULT,".$rdb.", ".$perfil.",".$rut.",".$ano.",".$pregunta.",'".$observacion."',   DEFAULT );";
		$result = @pg_Exec($connection,$sql);
	}
}
	
	echo "<script>window.close()</script>";	  

?>