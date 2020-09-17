<?php
 $conn=pg_connect("dbname=coi_corporaciones host=192.168.1.12 port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion.");	;
 
//include_once('../../util/funciones_utiles.php');

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
  // echo "<br>".$asignacion;
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
 	 $srdb = "select distinct(nro_ano) from
 ano_escolar where id_institucion=$rdb and nro_ano >= 2016  order by nro_ano
";
$rrdb=pg_exec($conn,$srdb);
?>
<select name="ano" id="ano" onchange="listaEnse()">
<option value="0">Seleccione año</option>
<?php
   for($r=0;$r<pg_numrows($rrdb);$r++){
	$ff=pg_fetch_array($rrdb,$r);
	?>
    
    <option value="<?php echo $ff['nro_ano'] ?>"><?php echo $ff['nro_ano'] ?></option>
    
      
      <?php
      }
	  ?>
	  </select>
      <?php
}
if($funcion==3){
 $sql_c ="select DISTINCT(cur.ensenanza), tip.nombre_tipo
from curso cur inner join tipo_ensenanza tip
on cur.ensenanza = tip.cod_tipo
inner join ano_escolar an on an.id_ano = cur.id_ano
where an.id_institucion = $rdb and an.nro_ano = $ano
order by cur.ensenanza ";
	$rs_c=pg_exec($conn,$sql_c);
	?>
	<select name="ensenanza" id="ensenanza" onchange="listaGrado()" >
<option value="0">Seleccione tipo ensenanza</option>
<?php
   for($r=0;$r<pg_numrows($rs_c);$r++){
	$ff=pg_fetch_array($rs_c,$r);
	
	
	?>
    
    <option value="<?php echo $ff['ensenanza'] ?>"><?php echo utf8_encode($ff['nombre_tipo']) ?></option>
    
      
      <?php
      }
	  ?>
	  </select>
	<?
}
if($funcion==4){
	
  $sql_c ="select DISTINCT(cur.grado_curso)
from curso cur 
inner join ano_escolar an on an.id_ano = cur.id_ano
where an.id_institucion = $rdb and an.nro_ano = $ano
and cur.ensenanza = $ense
order by cur.grado_curso ";
	$rs_c=pg_exec($conn,$sql_c);
	?>
	<select name="grado" id="grado" onchange="listaLetra()"  >
<option value="0">Seleccione grado curso</option>
<?php
   for($r=0;$r<pg_numrows($rs_c);$r++){
	$ff=pg_fetch_array($rs_c,$r);
	
	
	?>
    
    <option value="<?php echo $ff['grado_curso'] ?>"><?php echo utf8_encode($ff['grado_curso']) ?></option>
    
      
      <?php
      }
	  ?>
	  </select>
<?
}
if($funcion==5){
	
  $sql_c ="select DISTINCT(cur.letra_curso)
from curso cur 
inner join ano_escolar an on an.id_ano = cur.id_ano
where an.id_institucion = $rdb and an.nro_ano = $ano
and cur.ensenanza = $ense
and cur.grado_curso=$grado
order by cur.letra_curso";
	$rs_c=pg_exec($conn,$sql_c);
	?>
	<select name="letra" id="letra"  >
<option value="0">Seleccione letra curso</option>
<?php
   for($r=0;$r<pg_numrows($rs_c);$r++){
	$ff=pg_fetch_array($rs_c,$r);
	
	
	?>
    
    <option value="<?php echo $ff['letra_curso'] ?>"><?php echo utf8_encode($ff['letra_curso']) ?></option>
    
      
      <?php
      }
	  ?>
</select>
<?
}
?>