<?php 
require('../../../../util/header.inc');

///////////////////
$institucion = $_INSTIT;
$ano		 = $_ANO;

//print_r($_GET);




 if (isset($ordenar)){
 
	 // se guarda el orden para soplo un alumno
	echo  $sql_sub = "select orden_concentracion_notas.cod_subsector, orden_concentracion_notas.orden, subsector.nombre from orden_concentracion_notas inner join subsector on subsector.cod_subsector=orden_concentracion_notas.cod_subsector where id_curso = '$curso' ";
	
	if($_PERFIL==0){
	echo  $sql_sub;
	}
	
	
	 $sql_sub .="  order by orden";
	 $res_sub = pg_Exec($conn, $sql_sub);
	 $num_sub = pg_numrows($res_sub);
	 
	 for ($i=0; $i < $num_sub; $i++){	
		 $fil_sub = pg_fetch_array($res_sub, $i);
		 $nombre_subsector = $fil_sub['nombre'];
		 $cod_subsector    = $fil_sub['cod_subsector'];
		 		 
		 $orden_sub = "orden_sub".$i;
		 $orden_sub = $$orden_sub;
		 
		 $actualizar = "update orden_concentracion_notas set orden = '$orden_sub' where cod_subsector = '$cod_subsector' and id_curso = '$curso'";
		 $res_actualizar = pg_Exec($conn, $actualizar);	
		 
	/*if($_PERFIL==0){
	 echo  $sql_sub;
	 echo "<br>".$actualizar;
	 exit;
	}	*/	 		
	
	 }		 ?>
	 <script type="text/javascript">
opener.location.reload();
window.close();

</script>
	 <?
}





// recibimos las variables del formulario de búsqueda.

if ($curso>0){
     // subsectores del alumno en la institución
	$sql="select matricula.rut_alumno from matricula where id_curso = '".$curso."'";
	$result= @pg_Exec($conn,$sql);
	for($j=0 ; $j < @pg_numrows($result) ; ++$j){
		$fila = @pg_fetch_array($result,$j);
		$rut_alumno = $fila['rut_alumno'];	 

		$query_matricula="select subsector.cod_subsector, subsector.nombre from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select curso.id_curso from matricula as mat, ano_escolar as ano, curso as curso  where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and curso.ensenanza > '300' and mat.bool_ar = '0' and mat.id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by ano.nro_ano Desc) group by subsector.cod_subsector, subsector.nombre ";
	 
        $rs_mat = pg_exec($conn, $query_matricula);
	 
	    $num_mat = pg_numrows($rs_mat);	
	 
	    if ($num_mat > 0){
	        for ($i=0; $i < $num_mat; $i++){
			    $fil_sub = pg_fetch_array($rs_mat, $i);
			    $nombre_subsector = $fil_sub['nombre'];
			    $cod_subsector    = $fil_sub['cod_subsector'];
			    
				$sql_orden = "select orden from orden_concentracion_notas where id_curso = '$curso' order by orden desc limit 1";
				$res_orden = pg_exec($conn, $sql_orden);
				$fil_orden = pg_fetch_array($res_orden,0);
				$orden = $fil_orden['orden'];
				$orden++;
				
				// insertamos en la nueva tabla, si está no deberia insertarlo
			    $sql_insert = "insert into orden_concentracion_notas (cod_subsector, orden, id_curso) values ('$cod_subsector','$orden','$curso')";
			    $res_insert = pg_Exec($conn, $sql_insert);
		    }
	    }
	 
	    // subsectores del alumno ingresados a mano
	    $sql_concentracion_detalle = "select * from concentracion_detalle inner join subsector on concentracion_detalle.subsector=subsector.cod_subsector  where concentracion_detalle.rut_alumno = '$rut_alumno'";
	    $res_concentracion_detalle = @pg_exec($conn, $sql_concentracion_detalle);
	    $num_concentracion_detalle = @pg_numrows($res_concentracion_detalle);
	 
	 // consulta para rescatar el campo orden
	    $sql_orden = "select orden from orden_concentracion_notas where id_curso = '$curso' order by orden desc limit 1";
	    $res_orden = pg_exec($conn, $sql_orden);
	    $fil_orden = pg_fetch_array($res_orden,0);
	    $orden = $fil_orden['orden'];
	    $orden++;
	 
	    for ($i=0; $i < $num_concentracion_detalle; $i++){
	        $fil_concentracion_detalle = pg_fetch_array($res_concentracion_detalle, $i);
		    $nombre_subsector = $fil_concentracion_detalle['nombre'];
		    $cod_subsector    = $fil_concentracion_detalle['cod_subsector'];	
		 
		    /// insertamos en la tabla orden_concentracion_notas
		    $sql_insert = "insert into orden_concentracion_notas (cod_subsector, orden, id_curso) values ('$cod_subsector','$orden','$curso')";
		    $res_insert = pg_Exec($conn, $sql_insert);
		    $orden++;	  
	 
	    }
		
	}
			 
	 
	    $sql_sub = "select orden_concentracion_notas.cod_subsector, orden_concentracion_notas.orden, subsector.nombre from orden_concentracion_notas inner join subsector on subsector.cod_subsector=orden_concentracion_notas.cod_subsector where id_curso = '$curso' order by orden";
	    $res_sub = pg_Exec($conn, $sql_sub);
	    $num_sub = pg_numrows($res_sub);
	 		 	 
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="javascript1.1" type="text/javascript">
function enviapag(form){
      document.form.submit();
}


function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

</script>	
<script> 
function cerrar(){ 
window.close() 
} 
</script>

<body>
<form name="form1" method="post" action="concentracionnotas_2009.php">
<input type="hidden" name="rut_alumno" value="<?=$rut_alumno?>">
<input type="hidden" name="curso" value="<?=$curso?>">
<table width="500">
	<tr>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2" ><b>Ordenar Subsectores</b></font></td>
	</tr>
</table>

<table width="500">
	<tr>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><b>Nro.</b></font></td>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><b>Orden</b></font></td>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><b>Nombre</b></font></td>
	<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><b>Código</b></font></td>
	</tr>
	<?
	for ($i=0; $i < $num_sub; $i++){
	    $fil_sub = pg_fetch_array($res_sub, $i);
	    $nombre_subsector = $fil_sub['nombre'];
		$cod_subsector    = $fil_sub['cod_subsector'];
		$orden            = $fil_sub['orden'];
		//echo "<br>".$sql_sub;	 
	    ?>
		<tr>
			<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><?=$i+1?></font></td>
			<td align="center"><label>
			  <input name="orden_sub<?=$i?>" type="text" id="orden_sub<?=$i?>" size="3" value="<?=$orden?>">
			</label></td>
			<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><?=$nombre_subsector.$fil_sub['id_ramo'];?></font></td>
			<td align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><?=$cod_subsector?></font></td>
		</tr>
 <? } ?>	
</table>



<table width="500">
  <tr>
    <td align="center"><label>
      <input name="ordenar" type="submit" id="ordenar" value="ORDENAR SUBSECTORES" class="botonXX">
      <input name="sierraventana" type="button" id="sierraventana" value="Cerrar" onClick="cerrar();" class="botonXX">
    </label></td>
  </tr>
</table>
</form>
</body>
</head>
</html>