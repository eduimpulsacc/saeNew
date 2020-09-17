<? //require('../util/header.inc'); 

$conn=pg_connect("dbname=coi_final host=200.29.21.124 port=5432 user=postgres password=cole#newaccess"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0//EN">
  <html>
  <head>
    <title>Leer archivo</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <meta name="GENERATOR" content="Quanta Plus KDE">
  </head>
  <body bgcolor="#ffffff" text="#000000">
  <table border="1">
  <?
 
	$hora=date("G:i");  
	if($hora > "10:00" && $hora < "16:00"){
		  $fch = "ASISTENCIA_".date("Ymd")."1000.txt";
	}else{
		  $fch = "ASISTENCIA_".date("Ymd")."1600.txt";
	}

	$fch = "ASISTENCIA_201206221000.txt";    
	$lines = file($fch);
  ?>
  
  <tr style="text-align:center;background-color:#4a6890;color:#fff;">
  <td>RDB</td>
  <td>RUT</td>
  <td>FECHA</td>
  <td>HORA</td>
  <td>ESTADO</td>
  </tr>
  
  <?
  foreach ($lines as $line_num => $line) {
          
		  
		  $line=str_replace(" ","\t",$line);
          $datos = explode("\t", $line);
		  if($datos[4]==1){
  ?>      <tr>
          <td><?=$datos[0]?></td>
          <td><?=$datos[1]?></td>
          <td><?=$datos[2]?></td>
          <td><?=$datos[3]?></td>
          <td><?=$datos[4]?></td>
          </tr>
  <?      
		 
		$fecha = explode("/", $datos[2]);	
		$dia=$fecha[0];
		$mes=$fecha[1];
		$ano=$fecha[2];
		//$fecha_new = $mes."-".$dia."-".$ano;
		$fecha_new = $ano."-".$mes."-".$dia;	
 	$sql=" select id_ano, id_curso from matricula where rdb=".substr($datos[0],0,4)." and rut_alumno=".$datos[1]." and id_ano in (select id_ano from ano_escolar where id_institucion=".substr($datos[0],0,4)." and nro_ano=".$ano.")";
	$result_busca = @pg_exec($conn,$sql);		
	
	if(@pg_numrows($result_busca)!=0){
		for($i=0;$i<pg_numrows($result_busca);$i++){
				$fila_busca = pg_fetch_array($result_busca,$i);		
				$id_curso=$fila_busca['id_curso'];
				$id_ano=$fila_busca['id_ano'];
		}
		
		echo "<br>".$qry="INSERT INTO public.asistencia_mensual (rut_alumno,ano,id_curso,fecha,hora) VALUES (".$datos[1].", ".$id_ano.", ".$id_curso.", '".$fecha_new."','".$datos[3]."')";
		// $qry ="DELETE FROM asistencia WHERE rut_alumno=".$datos[1]." and ano=".$id_ano." and id_curso=".$id_curso." and  fecha= '".$fecha_new."' and hora='".$datos[3]."'";
		$result_insert = @pg_exec($conn,$qry)or die("Fallo : ".$qry);	
		
		
			
		
		/* $sql_peri = "select * from periodo where id_ano = $id_ano order by fecha_inicio";
		$result_peri = pg_exec($conn,$sql_peri) or die ("Select falló: " .$sql);
		for($k=0;$k<pg_numrows($result_peri);$k++){
		$fila_peri=pg_fetch_array($result_peri,$k); 
		
		 $fecha_inicio=$fila_peri['fecha_inicio'];
		  $fecha_termino=$fila_peri['fecha_termino'];
		 $fecha_new;*/
		 
		 $sql="select * from periodo where fecha_inicio<='$fecha_new' AND fecha_termino >= '$fecha_new' and id_ano = $id_ano";
			$result_p=@pg_Exec($conn,$sql)or die("Fallo...!!");
			$fila_p=@pg_fetch_array($result_p,0);
			 "Periodo->".$nombre_periodo=$fila_p['nombre_periodo'];
			   "idp->".$id_periodo=$fila_p['id_periodo'];
			
		//}
		$qry_max = "select max(id_anotacion) from anotacion";
		$res_max = pg_Exec($conn,$qry_max);
		$fila_max = pg_fetch_array($res_max);
		 "ID_MAX->".$id_max = $fila_max['max']+1;
	
		
		$sqlh="SELECT hora_entrada FROM ano_escolar WHERE id_ano=".$id_ano;
		$resulth=pg_Exec($conn,$sqlh)or die ("Fallo".$sqlh);
		$fila_h	= @pg_fetch_array($resulth,0);
		 $hora_entrada=$fila_h['hora_entrada'];
		 "<br>".$datos[3];
		if($datos[3]>$hora_entrada){
			 $id_max;
			 $qry_atraso = "insert into anotacion(id_anotacion,tipo,fecha,observacion,rut_alumno,id_periodo) values ('$id_max',2,'$fecha_new','Atrasado','$datos[1]','$id_periodo')";
			
			$res_atraso = pg_Exec($conn,$qry_atraso)or die ("Fallo Insert ".$qry_atraso);
			
			 
			}
			
					
		
			
	}
	 }else{
		 
	?>      <tr>
          <td><?=$datos[0]?></td>
          <td><?=$datos[1]?></td>
          <td><?=$datos[2]?></td>
          <td><?=$datos[3]?></td>
          <td><?=$datos[4]?></td>
          </tr>
  <?      
		 
		$fecha = explode("/", $datos[2]);	
		$dia=$fecha[0];
		$mes=$fecha[1];
		$ano=$fecha[2];
		$fecha_new = $mes."/".$dia."/".$ano;
			
 	$sql=" select id_ano, id_curso from matricula where rdb=".substr($datos[0],0,4)." and rut_alumno=".$datos[1]." and id_ano in (select id_ano from ano_escolar where id_institucion=".substr($datos[0],0,4)." and nro_ano=".$ano.")";
	$result_busca = @pg_exec($conn,$sql);		
	
	if(@pg_numrows($result_busca)!=0){
		for($i=0;$i<pg_numrows($result_busca);$i++){
				$fila_busca = pg_fetch_array($result_busca,$i);		
				$id_curso=$fila_busca['id_curso'];
				$id_ano=$fila_busca['id_ano'];
		}
		
		$qry="INSERT INTO public.asistencia (rut_alumno,ano,id_curso,fecha,hora) VALUES (".$datos[1].", ".$id_ano.", ".$id_curso.", '".$fecha_new."','".$datos[3]."')";
		//$qry ="DELETE FROM asistencia WHERE rut_alumno=".$datos[1]." and ano=".$id_ano." and id_curso=".$id_curso." and  fecha= '".$fecha_new."' and hora='".$datos[3]."'";
		$result_insert = @pg_exec($conn,$qry)or die("Fallo : ".$qry);		
	}	 
		 
	}
	 
	 
	 
} //fin foreach
  ?>
</table>  
  </body>
  </html>
