<?php 
require('../../util/header.inc');

/*echo $qry="select * from perfil where id_perfil not in (SELECT accede.id_perfil FROM (accede 
	INNER JOIN perfil ON accede.id_perfil = perfil.id_perfil) INNER JOIN usuario ON 
	accede.id_usuario = usuario.id_usuario WHERE ((accede.rdb)=".$_POST['xinstitucion'].")) order by nombre_perfil asc";*/
//$result =pg_Exec($connection,$qry);

//actualizar estado

 foreach($_REQUEST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
//echo "asignacion=$asignacion<br>";

   } 

//2 saemovil - 3 evados - 4 reca - 7 cede
switch($xsistema){
	
	case 1:
	$columna = "estado_colegio";
	break;
	
	case 2:
	$columna = "saemovil";
	break;
	
	case 3:
	$columna = "evados";
	break;
	
	case 4:
	$columna = "reca";
	break;
	
	case 7:
	$columna = "cede";
	break;
	
	case 9:
	$columna = "web";
	break;
	
	case 10:
	$columna = "aemail";
	break;
	
	case 11:
	$columna = "sueldos";
	break;
	
	case 12:
	$columna = "planificacion";
	break;
	
	case 13:
	$columna = "biblioteca";
	break;
	
	case 14:
	$columna = "edugestor";
	break;
	
	case 15:
	$columna = "sms";
	break;
	
	case 16:
	$columna = "codbarra";
	break;
	
	case 17:
	$columna = "comunicapp";
	break;
}

switch ($xstatus){
	case 0:
	$boton ="<a href=\"#\" onClick=\"activate(".$xinstitucion.",".$xsistema.",".$xsistema.")\"><img src=\"../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/NO.png\" border=\"0\"></a>";
	if($xsistema != 9 || $xsistema !=10){
	$qry_del = "update accede set estado = 0 where rdb = $xinstitucion and id_sistema= $xsistema ";
 	$result =pg_Exec($connection,$qry_del);
	}
	break;
	
	case $xsistema:
	$boton ="<a href=\"#\" onClick=\"activate(".$xinstitucion.",0,".$xsistema.")\"><img src=\"../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-24/OK.png\" border=\"0\"></a>";
	if($xsistema != 9 || $xsistema !=10){
	$qry_del = "update accede set estado = 1 where rdb = $xinstitucion and id_sistema= $xsistema ";
 	$result =pg_Exec($connection,$qry_del);
	}
	break;
}

 $qry_up = "update institucion set $columna = $xstatus where rdb = $xinstitucion";
 $result =pg_Exec($connection,$qry_up);
echo $boton;





//var_dump($_POST);?>