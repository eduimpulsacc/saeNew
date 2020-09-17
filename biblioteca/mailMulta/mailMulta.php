<?
error_reporting(E_ALL);
ini_set('display_errors', '1');
$fecha =date("Y-m-d");
$ano = date("Y");


$connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_Usuario ");

 function CambioFD($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}
 

//1.- nececito desde la base de usuarios a los colegios que tienen biblioteca
$sql_tiene = "select rdb,biblioteca,base_datos,nombre_instit from institucion where biblioteca = 13 order by base_datos,rdb";
$rs_tiene= pg_exec($connection,$sql_tiene);

//2.- conectar todas las bases de datos de colegios
$conn1=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	

$conn2=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	

$conn4=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");

//3.- buscar en biblioteca los prestamos atrasados basandome en el la fecha actual
$asunto="Recordatorio préstamos atrasados biblioteca";

if(pg_numrows($rs_tiene)>0){
	
	

    for($t=0;$t<pg_numrows($rs_tiene);$t++){
        $fila_tiene=pg_fetch_array($rs_tiene,$t);
        
		if($fila_tiene['base_datos']==1){
		$conn=$conn1;
		}
		if($fila_tiene['base_datos']==2){
		$conn=$conn2;
		}
		if($fila_tiene['base_datos']==4){
		$conn=$conn4;
		}
		
        $sql_ano = "select id_ano from ano_escolar where id_institucion = ".$fila_tiene['rdb']." and nro_ano=$ano";
        $rs_ano = pg_exec($conn,$sql_ano) or die("no conecto");  
		
		 $id_ano = pg_result($rs_ano,0);
		 if($id_ano){

       $sql_pres = "select distinct(rut_usuario) rut_usuario,
 tipo_usuario,count(*) atrasos 
 from biblio.prestamo 
 where estado_prestamo=3 and id_ano = $id_ano 
 and fecha_devolucion<='$fecha' 
 group by 1,2
 order by 1,2";
		 $rs_pres = pg_exec($conn,$sql_pres) or die("no conecto");
		 
		if(pg_numrows($rs_pres)>0){
		for($a=0;$a<pg_numrows($rs_pres);$a++){
		$fila_prestamo = pg_fetch_array($rs_pres,$a);
		
		$tipo =  $fila_prestamo['tipo_usuario'];
		$usuario =  $fila_prestamo['rut_usuario'];
		$atrasos =  $fila_prestamo['atrasos'];
		
		if($tipo==3){
			$sql_us = "select rut_alumno as rut,upper(ape_pat||' '||ape_mat||' '||nombre_alu) as nombre,email from alumno where rut_alumno=$usuario ";
		}
		
		if($tipo==2){
			$sql_us = "select rut_apo as rut,upper(ape_pat||' '||ape_mat||' '||nombre_apo) as nombre,email from apoderado where rut_apo=$usuario ";
		}
		
		if($tipo==1){
			$sql_us = "select rut_emp as rut,upper(ape_pat||' '||ape_mat||' '||nombre_emp) as nombre,email from empleado where rut_emp=$usuario ";
		}
		
		//echo $sql_us;
		$rs_us = pg_exec($conn,$sql_us);
		$fila_us = pg_fetch_array($rs_us,0);
		
		 $sql_dpre= " select l.titulo,p.fecha_devolucion
 from biblio.libro l
 inner join biblio.prestamo p on p.id_libro = l.id_libro
 where estado_prestamo=3 and id_ano = $id_ano 
 and fecha_devolucion<='$fecha' and rut_usuario = $usuario";
 $rs_dpre = pg_exec($conn,$sql_dpre);
		
		
$mensaje='<font style="font-family:verdana;font-size:12px">Estimado(a) <b>'.$fila_us['nombre'].'</b>:<br />
<br />
<br />
Le recordamos que al d&iacute;a de '.CambioFD($fecha).', usted tiene <b>'.$atrasos.'</b> pr&eacute;stamo(s) en calidad de atrasado(s):<br />
<br />';

for($dp=0;$dp<pg_numrows($rs_dpre);$dp++){
	$fila_dpre = pg_fetch_array($rs_dpre,$dp);

$mensaje.='- <b>'.$fila_dpre['titulo'].'</b>. Fecha de devoluci&oacute;n: '.CambioFD($fila_dpre['fecha_devolucion']).'.<br />';

}
$mensaje.='<br />
<br />
Le rogamos acercarse a la biblioteca del establecimiento para regularizar su situaci&oacute;n.<br />
<br />
<br />
<br />
Si ya regulariz&oacute; su situaci&oacute;n, favor omitir este mensaje.
<br />
<br />
Atte:<br />
'.$fila_tiene['nombre_instit'].'<br />
<br />
<br />
(Este correo es generado autom&aacute;ticamente, favor no responder a esta direcci&oacute;n)</font><br>';
		
		
		if( trim($fila_us['email'])!="" && strpos($fila_us['email'],'@')){
			//echo $mensaje;
			//mando mail
			$to      = "'".$fila_us['email']."'";
			//$to      = 'claudia.canto@eduimpulsa.com';
			$subject = $asunto ;
			$message = $mensaje ;
			$header = "From: soporte@eduimpulsa.com\r\n"; 
			$header.= "MIME-Version: 1.0\r\n"; 
			$header.= "Content-Type: text/html; charset=utf-8\r\n"; 
			$header.= "X-Priority: 1\r\n"; 
			mail($to, $subject, $message, $header);
			/*if(mail($to, $subject, $message, $header))
			{echo "<br>".$usuario.'-'.$fila_us['nombre'].'-'.$fila_us['email']."si";}
			else{echo "<br>".$fila_us['usuario'].'-'.$fila_us['nombre'].'-'.$fila_us['email']."no";}*/
			}
		}
		
		}//iftiene prestamos
		
		 
		 }//if tiene año

    }//for tiene bibloteca
}//if tiene biblioteca





?>
