<?php
	header('Content-Type: application/force-download');

	require('mod_entrevista_profesional.php');
	
	$obj_descarga= new EntrevistaProf($_IPDB,$_ID_BASE);
	

	if (!isset($_GET['id']) || empty($_GET['id'])) {
    exit();
}

 $sql=" select archivo from cede.entrevista_profecional  ent where ent.id_entrevista=".$_GET['id']; 
 $result = @pg_Exec($obj_descarga->Conec->conectar(),$sql);
 $fila = @pg_fetch_array($result,0);	
    $archivo = $fila[0];
 
	
	 header('Content-Disposition: attachment; filename=' . $archivo);
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
		$fp=fopen("$archivo", "r");
		download_file($fp);
	

?>