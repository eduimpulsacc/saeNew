<?php 
$nro_ano = 2019;
$id_base=4;

if($id_base ==1){
$conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
}
if($id_base ==2){
$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
}
if($id_base ==4){
$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
}


//agregar la lista al feriado del año 
$arr_feriado = array(
array("$nro_ano-04-19","$nro_ano-04-19","Viernes Santo"),
array("$nro_ano-05-01","$nro_ano-05-01","Día del Trabajo"),
array("$nro_ano-05-21","$nro_ano-05-21","Días de las Glorias Navales"),
array("$nro_ano-08-15","$nro_ano-08-15","Ascención de la Virgen"),
array("$nro_ano-09-18","$nro_ano-09-20","Fiestas Patrias"),
array("$nro_ano-10-31","$nro_ano-10-31","Día de las iglesias evangélicas"),
array("$nro_ano-11-01","$nro_ano-11-01","Todos los santos"));

//vacaciones de invierno
$arr_vacas = array(
array("$nro_ano-07-15","$nro_ano-07-19","Vacaciones de Invierno"),
array("$nro_ano-07-22","$nro_ano-07-26","Vacaciones de Invierno")
);

//hacer el insert para los feriados del año
for($fg=0;$fg<count($arr_feriado);$fg++){
echo "<br>".$sql_insglobal = "insert into feriado_ano(nro_ano,fecha_inicio,fecha_termino,descripcion) values($nro_ano,'".$arr_feriado[$fg][0]."','".$arr_feriado[$fg][1]."','".utf8_decode($arr_feriado[$fg][2])."')";
$rs_insglobal = pg_exec($conn,$sql_insglobal);
}

//buscamos los colegios que tengan 2019
$sql_ano = "select id_ano from ano_escolar where nro_ano=$nro_ano order by id_ano";
$rs_ano = pg_exec($conn,$sql_ano);

for($an=0;$an<pg_numrows($rs_ano);$an++){
$fila_ano = pg_fetch_array($rs_ano,$an);
$id_ano = $fila_ano['id_ano'];

//periodo del año 
echo "<br>".$sql_per = "select * from periodo where id_ano = $id_ano order by nombre_periodo";
$rs_per = pg_exec($conn,$sql_per);
 
if(pg_numrows($rs_per)==2){
	for($pr=0;$pr<pg_numrows($rs_per);$pr++){
		$fila_periodo = pg_fetch_array($rs_per,$pr);
		 $id_periodo =   $fila_periodo['id_periodo'];
		 $nombre_periodo =   explode(" ",$fila_periodo['nombre_periodo']);
		 
		if($nombre_periodo[0]=="PRIMER"){
				
		  $finiper = "$nro_ano-03-05";
		  $fterper = "$nro_ano-07-12";
		}
		 
		if($nombre_periodo[0]=="SEGUNDO"){
		  $finiper = "$nro_ano-07-29";
		  $fterper = "$nro_ano-12-20";
		 }
		 
		 //actualizo las fechas de periodo 
		echo "<br>".$sql_acper ="update periodo set fecha_inicio='$finiper',fecha_termino='$fterper' where id_periodo = $id_periodo"; 
		$rs_acper = pg_exec($conn,$sql_acper);
		 
 
	
	}
}

 //ahora vuelvo a revisar las fechas para ver a que periodo pertenecen
		for($fg=0;$fg<count($arr_feriado);$fg++){
		echo "<br>".$selipf = "select id_periodo from periodo where fecha_inicio <='".$arr_feriado[$fg][0]."' and fecha_termino >='".$arr_feriado[$fg][1]."' and id_ano = $id_ano ";
		$rs_selipf=pg_exec($conn,$selipf);
		$fec = pg_fetch_array($rs_selipf,0);
		$perisert =$fec['id_periodo'];
		//inserto los feriados
		echo "<br>".$sqlinferr="insert into feriado (id_ano,fecha_inicio,fecha_fin,bool_fer,id_periodo,descripcion) values($id_ano,'".$arr_feriado[$fg][0]."','".$arr_feriado[$fg][1]."',1,$perisert,'".utf8_decode($arr_feriado[$fg][2])."')";
		$rslinferr = pg_exec($conn,$sqlinferr);
		
		}
		
		
		 //insertar las vacaciones de invierno
		for($fg=0;$fg<count($arr_vacas);$fg++){
		echo "<br>".$selipf = "select id_periodo from periodo where id_ano = $id_ano and nombre_periodo like 'PRIMER%' ";
		$rs_selipf=pg_exec($conn,$selipf);
		$fec = pg_fetch_array($rs_selipf,0);
		$perisert2 =$fec['id_periodo'];
		//inserto los feriados
		echo "<br>".$sqlinferr2="insert into feriado (id_ano,fecha_inicio,fecha_fin,bool_fer,id_periodo,descripcion) values($id_ano,'".$arr_vacas[$fg][0]."','".$arr_vacas[$fg][1]."',1,$perisert2,'".utf8_decode($arr_vacas[$fg][2])."')";
		$rslinferr2 = pg_exec($conn,$sqlinferr2);
		
		}


//busco los curso del año
echo "<br>".$sqlcur="select * from curso where id_ano =$id_ano";
$rc= pg_exec($conn,$sqlcur);
for($cc=0;$cc<pg_numrows($rc);$cc++){
	$fla_cur = pg_fetch_array($rc,$cc);
	$id_curso = $fla_cur['id_curso'];
	
	//buscar los feriados para hacer el insert en el curso
	echo "<br>".$sql_ferppp="select id_feriado from feriado where id_ano = $id_ano";
	$rs_ferppp = pg_exec($conn,$sql_ferppp);
	for($fff=0;$fff<pg_numrows($rs_ferppp);$fff++){
		$fila_ferppp = pg_fetch_array($rs_ferppp,$fff);
echo "<br>".$ins_cur = "insert into feriado_curso (id_feriado,id_curso) values (".$fila_ferppp['id_feriado'].",$id_curso)";
		$rs_cur = pg_exec($conn,$ins_cur);
	}

}

}
?>