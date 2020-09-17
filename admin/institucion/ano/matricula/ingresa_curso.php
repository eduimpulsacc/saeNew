<?
require('../../../../util/header.inc');
//print_r($_POST);

$funcion = $_POST['funcion'];

if($funcion==1){
$sql2="select nombre_alu||' '|| ape_pat||' '||ape_mat as nom_alumno from alumno where rut_alumno = $rut";
$rs_al = pg_exec($conn,$sql2);
$nombre_al = pg_result($rs_al,0);


?>
<br>
<table width="90%" align="center" style="border-collapse:collapse" border="0">
<tr>
<td class="cuadro02">Nombre Alumno:</td>
<td class="cuadro01"><?=$nombre_al?></td>
</tr>
<tr>
<tr>
<td class="cuadro02">&nbsp;</td>
<td class="cuadro01">&nbsp;</td>
</tr>
<tr>

<td class="cuadro02">Curso:</td>
<td class="cuadro01">

  <? // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS // 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = @pg_exec($conn,$sql_curso); ?>
				 
<select name="cmb_curso" id="cmb_curso" class="ddlb_x">
<option value=0 selected>(Seleccione un Curso)</option><?
  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){  
	$filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        				$Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
	if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
	echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        				}else{	    
	echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
     }
   } ?>
</select>

</td>
</tr>
</table>
<br>
<? } ?>

<?
	if($funcion==2){
		
		$sql="update matricula set id_curso=$id_curso where id_ano=$ano and rut_alumno=$rut";
		$result = pg_exec($conn,$sql)or die("Fallo ".$sql);
		
		
		$sql_c="select id_ramo from ramo where id_curso=$id_curso";
		$rs_curso=pg_exec($conn,$sql_c);
		for($i=0;$i<pg_numrows($rs_curso);$i++){
			
		$fila = pg_fetch_array($rs_curso,$i);
		
		$sql_i="insert into tiene$nro_ano values($rut,".$fila['id_ramo'].",$id_curso)";
		$re_c = pg_exec($conn,$sql_i);	
		}
		
		if($result){
			echo 1;
			}else{
			echo 0;	
			}
		
		}





?>
