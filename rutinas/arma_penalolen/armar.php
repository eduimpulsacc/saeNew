<?php
// $conn=pg_connect("dbname=coi_corporaciones host=190.196.143.173 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	;
 
//include_once('../../util/funciones_utiles.php');

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
 // echo "<br>".$asignacion;
}

if($base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vi�a");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi�a");	
	}

  if($base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
	$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }

if($funcion==1){
  $srdb = "select ins.rdb,ins.nombre_instit from institucion ins inner join corp_instit on corp_instit.rdb=ins.rdb where num_corp=38 order by nombre_instit";
$rrdb=pg_exec($conn,$srdb);
?>
<select name="rdb" id="rdb" onchange="listaAno()">
<option value="0">Seleccione institución</option>
<?php for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
     <option value="<?php echo $ff['rdb'] ?>"><?php echo utf8_encode($ff['nombre_instit']) ?></option>
    <?php
	}
	?>
</select>
<?php
	
}
if($funcion==2){
	
 	 $srdb = "select distinct(id_ano),nro_ano from
 ano_escolar where id_institucion=$rdb and nro_ano >= 2016  order by nro_ano
";
$rrdb=pg_exec($conn,$srdb);
?>
<select name="cmbANO" id="cmbANO">
<option value="0">SELECCIONE A&Ntilde;O</option>
<?php
   for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
    
    <option value="<?php echo $ff['id_ano'] ?>"><?php echo $ff['nro_ano'] ?></option>
    
      
      <?php
      }
	  ?>
	  </select>
      <?php
}
if($funcion==3){
 	 $srdb = "select distinct(id_ano),nro_ano from
 ano_escolar where id_institucion=$rdb   order by nro_ano
";
$rrdb=pg_exec($conn,$srdb);
?>
<select name="cmbANO" id="cmbANO">
<option value="0">SELECCIONE A&Ntilde;O</option>
<?php
   for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
    
    <option value="<?php echo $ff['id_ano'] ?>"><?php echo $ff['nro_ano'] ?></option>
    
      
      <?php
      }
	  ?>
	  </select>
      <?php
}

?>