<?
require('../../../../../util/header.inc');
include('clase_cambiaFormato.php');


$objetoDatos = new Datos();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<script>

function eliminaalum(rutA){
	if(confirm(" Esta seguro que desea eliminar?")){
	 
 var rut_alumno= rutA;	 
 var rut_apo="<?=$rut_apo;?>";
 var guarda=1;		  
	
	
	var parametros = "rut_alumno="+rut_alumno+"&rut_apo="+rut_apo+"&guarda="+guarda;
	//alert(parametros);
	

	$.ajax({
		  url:'guardarelacion.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==1){
					alert("Datos Eliminados");
					veralum(rut_apo);
					}else{
						alert("Error al ELiminar");
						}
				     }
		         })
				 
	}else{
		return false;}
		
	}

</script>
<table align="left">
<tr class="textonegrita">
<td>Apoderado  :</td>
<?
 $qry=" select * from apoderado where rut_apo = ".$rut_apo;
$rs=pg_Exec($conn,$qry);
for($j=0 ; $j < @pg_numrows($rs) ; $j++){
	$filas = @pg_fetch_array($rs,$j);
	 $nombre_apo=$filas['nombre_apo'];
	 $ape_pat=$filas['ape_pat'];
	 $ape_mat=$filas['ape_mat'];
	 
	?>
	<td><?=$nombre_apo.$ape_pat.$ape_mat;?></td></tr>
    </table><br />
    <? 
}
?>

</head>

<body>
<div id="listaApoderado">
<table border="1" width="100%">
<tr class="textonegrita" bgcolor="#FFCC00" align="center">
<td>Rut</td>
<td>Nombre</td>
<td>Curso</td>
<td>Eliminar</td>
</tr>
<?
 $sql="select al.rut_alumno,al.dig_rut, al.nombre_alu, al.ape_pat, al.ape_mat 
, mat.id_curso
from alumno al
inner join tiene2 on al.rut_alumno=tiene2.rut_alumno
inner join matricula mat on al.rut_alumno=mat.rut_alumno
where tiene2.rut_apo=$rut_apo  and id_ano=$ano order BY al.nombre_alu";

$result=pg_Exec($conn,$sql)or die("FAllo ");
for($i=0 ; $i < @pg_numrows($result) ; $i++){
	$fila = @pg_fetch_array($result,$i);
	
	
	$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	
	        $rutA=$fila['rut_alumno'];
			$dig=$fila['dig_rut'];
			
			$nombre=$fila['nombre_alu'];
			$ape_pat_al=$fila['ape_pat'];
		    $ape_mat_al=$fila['ape_mat'];
			$nombrecurso=$Curso_pal;
	?>
				 
    <tr class="textosimple">
    <td><?=$rutA.'-'.$dig;?></td>
    <td><?=$nombre.$ape_pat_al.$ape_mat_al?></td>
    <td><?=$objetoDatos->tilde($nombrecurso)?></td>
    <td align="center"><a onclick='eliminaalum(<?=$rutA;?>)' ><img src='../vitacora_alumno/img/PNG-48/Delete.png' align="top"  width='25' height='25' border='0' style="cursor:pointer" title="Eliminar Relaci&oacute;n" /></a> </td>
    </tr>
    			 
<? } ?>
</table>
</div>		
</body>
</html>