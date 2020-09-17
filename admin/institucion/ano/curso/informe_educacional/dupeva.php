<?php require('../../../../../util/header.inc');

foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}

if($funcion==1){
	 $sql_per = "select id_periodo,nombre_periodo from periodo where id_ano = $ano order by fecha_inicio";
$rs_per = pg_exec($conn,$sql_per);

?>
<table width="85%" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse" >
  <tr>
    <td width="29%" class="cuadro02">Copiar desde</td>
    <td width="71%" class="cuadro01">
      <select name="perdesde" id="perdesde">
      <option value="0">Seleccione</option>
     <?php  for($pd=0;$pd<pg_numrows($rs_per);$pd++){
		 $fper = pg_fetch_array($rs_per,$pd);
		 ?>
       <option value="<?php echo $fper['id_periodo'] ?>"><?php echo $fper['nombre_periodo'] ?></option>
      <?php }?>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">Copiar A</td>
    <td class="cuadro01"><select name="perhasta" id="perhasta">
    <option value="0">Seleccione</option>
     <?php  for($pd=0;$pd<pg_numrows($rs_per);$pd++){
		 $fper = pg_fetch_array($rs_per,$pd);
		 ?>
       <option value="<?php echo $fper['id_periodo'] ?>"><?php echo $fper['nombre_periodo'] ?></option>
      <?php }?>
    </select>
    </select></td>
  </tr>
  <tr>
    <td class="cuadro02">Tipo Informe</td>
    <td class="cuadro01"> <input name="tipo_planilla" type="radio" id="tipo_planilla0" value="0" checked="CHECKED">
                                    Personalidad 
                                    <input name="tipo_planilla" type="radio" id="tipo_planilla1" value="1" >
    Diagn&oacute;stico</td>
  </tr>
</table>

<?
}
if($funcion==2){
	show($_POST);
$qry_temp="SELECT * from curso where id_curso = $curso ";

$institucion = $_INSTIT;
												$result_temp =@pg_Exec($conn,$qry_temp);
												$fila_temp=@pg_fetch_array($result_temp);
											
$id_curso = $fila_temp['id_curso'];
												$grado_curso= $fila_temp['grado_curso'];
												$ensenanza= $fila_temp['ensenanza'];
												
if($grado_curso==1) $gr="pa";
if($grado_curso==2) $gr="sa";
if($grado_curso==3) $gr="ta";
if($grado_curso==4) $gr="cu";
if($grado_curso==5) $gr="qu";
if($grado_curso==6) $gr="sx";
if($grado_curso==7) $gr="sp";
if($grado_curso==8) $gr="oc";	
												
$tipo = $plantilla;										

$sqlTraePlantilla="SELECT informe_plantilla.titulo_informe1, informe_plantilla.nuevo_sis, informe_plantilla.id_plantilla FROM informe_plantilla WHERE tipo_ensenanza=".$ensenanza." AND ".$gr."=1 and activa=1 AND rdb=".$institucion." and tipo=$tipo ";
												$resultPlantilla=@pg_Exec($conn, $sqlTraePlantilla);
												$filaPlantilla=@pg_fetch_array($resultPlantilla);	
$nuevo = $filaPlantilla['nuevo_sis'];

$id_plantilla = $filaPlantilla['id_plantilla'];

//revisar al curso 
$sql_cur = "select rut_alumno from matricula where id_curso = $curso and bool_ar=0";
$rs_cur = pg_exec($conn,$sql_cur);

for($c=0;$c<pg_numrows($rs_cur);$c++){
$fcur = pg_fetch_array($rs_cur,$c);
$alumno=$fcur['rut_alumno'];

$sql_infd = "select * from informe_evaluacion2 where rut_alumno = $alumno and id_ano =$ano  and id_curso = $curso and id_periodo = $periodod and id_plantilla=$id_plantilla";
$rd_infd = pg_exec($conn,$sql_infd);

$sql_infh = "select * from informe_evaluacion2 where rut_alumno = $alumno and id_ano =$ano and id_curso = $curso and id_periodo = $periodoh and id_plantilla=$id_plantilla";
$rd_infh = pg_exec($conn,$sql_infh);


if(pg_numrows($rd_infd)>0 && pg_numrows($rd_infh)==0){
  $sq_ins = "insert into informe_evaluacion2 (id_ano,id_periodo,id_curso,id_plantilla,id_informe_area_item,respuesta,concepto,fecha,rut_alumno) (select $ano,$periodoh,$curso,$id_plantilla,id_informe_area_item,respuesta,concepto,'".date("Y-m-d")."',rut_alumno from informe_evaluacion2 where rut_alumno = $alumno and id_ano = $ano and id_curso = $curso and id_periodo = $periodod and id_plantilla=$id_plantilla)"; 
 pg_exec($conn,$sq_ins);
 
 
 $sql_insO = "insert into informe_observaciones (id_periodo,id_ano,id_plantilla,rut_alumno,glosa,fecha_creacion,observaciones,sedestaca)(select $periodoh,$ano,$id_plantilla,rut_alumno,glosa,'".date("Y-m-d")."',observaciones,sedestaca from informe_observaciones where id_periodo = $periodod and id_ano=$ano and id_plantilla=$id_plantilla and rut_alumno=$alumno  )";
 pg_exec($conn,$sql_insO);
}

}

}

?>