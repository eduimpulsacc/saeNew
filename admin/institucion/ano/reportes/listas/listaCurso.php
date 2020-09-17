<?php 
require('../../../../../util/header.inc');
	include('../../../../clases/class_MotorBusqueda.php');
	include('../../../../clases/class_Membrete.php');
	include('../../../../clases/class_Reporte.php');

$institucion=$_INSTIT;
$ano=$c_ano;	


$ob_reporte = new Reporte();
$ob_membrete = new Membrete();
$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$result_curso = $ob_motor ->curso2($conn);

	
?>
<select name="c_curso"  class="ddlb_9_x" id="c_curso" onChange="buscaAlumno()">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select>