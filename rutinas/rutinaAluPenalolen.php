
<?php 

$id_base =4; 
$corp=38;
//$nano = 2017;
//$rdb =9121;  
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


 if($id_base ==1){
  $conn=pg_connect("dbname=coi_final host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");	
//	 $conn=pg_connect("dbname=coi_final host=200.29.21.125 port=5432 user=postgres password=cole#newaccess") or die ("Error 
//de conexion Coi_final");	
   }

  if($id_base==2){ 
	$conn=pg_connect("dbname=coi_final_vina host=ip-172-31-11-223.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Coi_final_Vina");	
	//$conn=pg_connect("dbname=coi_final_vina host=200.29.21.124 port=5432 user=postgres password=cole#newaccess") or die ("Error de conexion Coi_final_Vi?a");	
	}

  if($id_base==4){ 
	/*echo "<script>window.location='http://www.colegiointeractivo.com'</script>";*/
$conn=pg_connect("dbname=coi_corporaciones host=ip-172-31-13-9.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error de conexion Corporacion222.");
	 }
	

	
	if(isset($b_bus)){
		
	foreach($_POST as $nombre_campo => $valor){ 
   $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
   eval($asignacion); 
}
	
	
	$connection=pg_connect("dbname=coi_usuario host=ip-172-31-0-119.ec2.internal port=5432 user=postgres password=f4g5h6.j") or die ("Error 
de conexion Coi_final");
	 
	  $alsql="SELECT rdb 
			FROM corp_instit
			WHERE num_corp=$corp
			ORDER BY 1 ASC";
			//mejorar esto para hacerlo global
	$rs_all = pg_exec($connection,$alsql);
	
	$dcad_ins="";
	
for($i=0;$i<pg_numrows($rs_all);$i++){
	$ffI=pg_fetch_array($rs_all,$i);
	$dcad_ins.=$ffI['rdb'].",";
}
 $dcad_ins = substr($dcad_ins, 0, -1);
	//	var_dump($_POST);
	
	$instu = ($cmbINSTITUCION!=0)?$cmbINSTITUCION:$dcad_ins;
	
	 $sql_a = "select * from ano_escolar where id_institucion in ($instu) and nro_ano=$cmbANO order by id_ano";
	$rs_ano = pg_exec($conn,$sql_a);
	
	$dcad_ano = "";
	
for($aa=0;$aa<pg_numrows($rs_ano);$aa++){
	$ffA=pg_fetch_array($rs_ano,$aa);
	$dcad_ano.=$ffA['id_ano'].",";
	
	}
	 $dcad_ano = substr($dcad_ano, 0, -1);

	
 $sql="SELECT 
i.rdb,
i.rdb||'-'||i.dig_rdb as rdb_ins,
i.nombre_instit,
a.rut_alumno, 
dig_rut, 
nombre_alu, 
ape_pat ||' '|| ape_mat as apellidos, 
fecha_nac,
case when (a.sexo=2) then 'Masculino' else 'Femenino' end as genero,
case when (a.nacionalidad=2) then 'Chilena' else 'Extranjera' end as nac,
case when (m.bool_ae=1) then 'SI' else 'NO' end as embarazada,
case when (m.bool_aoi=1) then 'SI' else 'NO' end as indigena,
a.cq_vive,
a.calle ||' '|| a.nro as direccion,
a.telefono, 
a.celular, 
c.grado_curso,
c.letra_curso,
te.nombre_tipo,
c.ensenanza,c.id_curso,
case when (bool_ar=0) THEN 'Vigente' else 'Retirado' end as estado_matricula, 
m.fecha_retiro,
case when (m.motivo_retiro='1') THEN 'Cambio de Domicilio'
when (m.motivo_retiro='2') THEN 'Traslado de establecimiento'
when (m.motivo_retiro='3') THEN 'Deserción'
when (m.motivo_retiro='4') THEN 'Motivos de salud'
when (m.motivo_retiro='5') THEN 'Otros'
END AS motivo_re,
case when (m.curso_rep=1) then 'SI' else 'NO' end as curso_rep,
case when (m.condicionalidad=1) THEN 'Rendimiento'
 when (m.condicionalidad=2) THEN 'Disciplina'
 when (m.condicionalidad=3) THEN 'Otro'
 when (m.condicionalidad=4) THEN 'Observaciones'
else '' END as condicional,
case when (m.sancion=1) THEN 'SI' else 'NO' END as sancion,
case when (m.bool_i=1) THEN 'SI' else 'NO' END  as integrado,
case when (m.bool_neurologo=1) THEN 'SI' else 'NO' END  as bool_neurologo,
case when (m.bool_psicopedagogo=1) THEN 'SI' else 'NO' END  as bool_psicopedagogo,
case when (m.bool_psiquiatra=1) THEN 'SI' else 'NO' END  as bool_psiquiatra,
case when (m.trat_especialista='' or m.trat_especialista='0' or m.trat_especialista is null) THEN 'NO' else 'SI' END  as trat_especialista,
case when (m.bool_psicologo=1) THEN 'SI' else 'NO' END  as bool_psicologo,
case when (m.bool_tastornosaprendizaje=1) THEN 'SI' else 'NO' END  as bool_tastornosaprendizaje,
case when (m.bool_pvision=1) THEN 'SI' else 'NO' END  as bool_pvision,
case when (m.bool_paudicion=1) THEN 'SI' else 'NO' END  as bool_paudicion,
case when (m.ben_pie=1) THEN 'SI' else 'NO' END as pie,
case when (m.bool_tastornosaprendizaje=1) THEN 'SI' else 'NO' END  as bool_tastornosaprendizaje,
case when (m.bool_fonoaudiologo=1) THEN 'SI' else 'NO' END  as bool_fonoaudiologo,
c.fecha_inicio,
c.fecha_termino,
m.bool_ar,
m.fecha,
pai.nombre as nombre_pais,
etn.nombre as nombre_etnia
FROM alumno a 
INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno 
INNER JOIN institucion i ON i.rdb=m.rdb
LEFT JOIN curso c ON c.id_curso=m.id_curso
INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
LEFT JOIN paises pai on pai.id = a.pais_origen
LEFT join etnia etn on etn.nombre = a.txt_etnia
WHERE m.id_ano in ($dcad_ano)
ORDER BY i.rdb,c.ensenanza, c.grado_curso, c.letra_curso, a.ape_pat, a.ape_mat ASC";
	
$rs_matricula = pg_exec($conn,$sql);
	
	
}
?>
<!DOCTYPE HTML>
<html>
<head>
<link  rel="shortcut icon" href="../../images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script src="../admin/clases/jquery/jquery.js"></script>
<script>
$( document ).ready(function() {
 //  listaAno();
});


function listaAno(){

var funcion=2;
var base = <?php echo $id_base ?>;
var rdb = $('#cmbINSTITUCION').val();
var aan = parseInt(<?php echo $_POST['cmbANO'] ?>);


var parametros = "funcion="+funcion+"&rdb="+rdb+"&base="+base;
//alert(parametros)
	  $.ajax({
			url:"arma_penalolen/con_armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
			console.log(data);
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#aa").html(data);
					 $('#cmbANO > option[value="'+aan+'"]').attr('selected', 'selected');
					}
		        }
		    })

}

function mandaExcel(){
var ruta = "rutinaAluPenalolen_print.php";
form.target="_blank";
		form.action = ruta;
		//form.method = "post";
		form.submit(true);	
}
</script>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post"  name="form">

<table width="80%" border="1" align="center" style="border-collapse:collapse">
  <tr>
    <td width="11%">Institucion</td>
    <td width="3%">&nbsp;</td>
    <td width="86%">&nbsp;
    <? $sql="SELECT i.rdb, i.nombre_instit 
			FROM corp_instit ci 
			INNER JOIN institucion i ON ci.rdb=i.rdb  
			WHERE num_corp=38
			ORDER BY 2 ASC"; 
			//mejorar esto para hacerlo global
	$rs_institucion = pg_exec($conn,$sql);
	?> 
    <select name="cmbINSTITUCION" id="cmbINSTITUCION" >
    	<option value="0">TODOS</option>
     <? for($i=0;$i<pg_numrows($rs_institucion);$i++){
		 	$fila = pg_fetch_array($rs_institucion,$i);
			if($_POST['cmbINSTITUCION']==$fila['rdb']){
	 ?>
     	<option value="<?=$fila['rdb'];?>" selected ><?=$fila['nombre_instit'];?></option>
        
      <? }else{ ?>
		       	<option value="<?=$fila['rdb'];?>"><?=$fila['nombre_instit'];?></option>
	<?  }
	} ?>
		   
    </select>
    <input name="id_base" type="hidden" id="id_base" value="<?php echo $id_base ?>">
     <input name="corp" type="hidden" id="id_base" value="<?php echo $corp ?>">
    </td>
  </tr> 
  <tr>
    <td>A&ntilde;o</td>
    <td>&nbsp;</td>
    <td>&nbsp;
   <span id="aa"> 
   <select name="cmbANO" id="cmbANO">
   <option	value="0">SELECCIONE...</option>
   <?php for($y=2016;$y<=date("Y");$y++){?>
   <option	value="<?php echo $y ?>" <?php echo ($y==date("Y"))?"selected":"" ?>><?php echo $y ?></option>
   <?php }?>
   </select>
    </span>
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><input type="submit" name="b_bus" id="b_bus" value="VER EN PANTALLA">  <input name="b_exp" id="b_exp" type="button" value="EXPORTAR A EXCEL" onClick="mandaExcel()" ></td>
  </tr>
    </table>
</form>
<br>
<br>
<br>
<br>
<?php if(isset($b_bus) ){
?>
<table width="100%" border="1" style="border-collapse:collapse">
  <tr class="tableindex">
 	<td>A&Ntilde;O</td>
     <td>RDB</td>
    <td>ESTABLECIMIENTO</td>
    <td>CURSO</td>
    <td>RUT</td>
    <td>APELLIDOS</td>
    <td>NOMBRE</td>
    <td>FEC. NAC.</td>
    <td>SEXO</td>
    <td>NACIONALIDAD</td>
    <td>PA&Iacute;S ORIGEN ESTUDIANTE</td>
    <td>&Eacute;TNIA O PUEBLO ORIGINARIO</td>
    <td>PA&Iacute;S ORIGEN APODERADO(A) O TUTOR(A)</td>
    <td>EST. INDIGENA</td>
    <td>DIRECCION</td>
    <td>EST. EMBARAZADA</td>
    <td>CON QUIEN VIVE</td>
    <td>FECHA MATRICULA</td>
    <td>ESTADO</td>
    <td>FECHA RETIRO</td>
    <td>MOTIVO RETIRO</td>
    <td>REPITIO CURSO</td>
    <td>CONDICIONAL</td>
    <td>SANCION</td>
    <td>INTEGRADO</td>
    <td>ESTUDIANTE PIE</td>
    <td>TRATAMIENTO ESPECIALISTA</td>
    <td>TRATAMIENTO NEUROLOGICO</td>
    <td>TRATAMIENTO PSICOPEDAGOGO</td>
    <td>TRATAMIENTO PSICOLOGO</td>
    <td>TRATAMIENTO PSIQUIATRICO</td>
    <td>TRASTORNOS DE APRENDIZAJE, DEFICIT ATENCIONAL</td>
    <td>TRATAMIENTO FONOAUDIOLOGO</td>
    <td>PROBLEMAS DE VISION</td>
    <td>PROBLEMAS DE AUDICION</td>
     
    
  </tr>
  <? for($i=0;$i<pg_numrows($rs_matricula);$i++){
	  	$fila = pg_fetch_array($rs_matricula,$i);
		
		
		
		
		?>
  <tr class="tableindex">
   	<td nowrap="nowrap"><?php echo $cmbANO ?></td>
    <td nowrap="nowrap"><?=$fila['rdb_ins'];?></td>
    <td nowrap="nowrap"><?=$fila['nombre_instit'];?></td>
    <td nowrap="nowrap"><?=$fila['grado_curso'];?>-<?=$fila['letra_curso'];?> <?=$fila['nombre_tipo'];?></td>
    <td nowrap="nowrap"><?=$fila['rut_alumno'];?>-<?=$fila['dig_rut'];?></td>
    <td nowrap="nowrap"><?=$fila['apellidos'];?></td>
    <td nowrap="nowrap"><?=$fila['nombre_alu'];?></td>
    <td nowrap="nowrap"><?=CambioFD($fila['fecha_nac']);?></td>
    <td nowrap="nowrap"><?=$fila['genero'];?></td>
    <td nowrap="nowrap"><?=$fila['nac'];?></td>
    <td nowrap="nowrap"><?=$fila['nombre_pais'];?></td>
    <td nowrap="nowrap"><?=$fila['nombre_etnia'];?></td>
    <td nowrap="nowrap"><?php echo $fila_tutor['nombre_pais'] ?></td>
    <td nowrap="nowrap"><?=$fila['indigena'];?></td>
    <td nowrap="nowrap"><?=$fila['direccion'];?></td>
    <td nowrap="nowrap"><?=$fila['embarazada'];?></td>
    <td nowrap="nowrap"><?=$fila['cq_vive'];?></td>
    <td nowrap="nowrap"><?=cambioFD($fila['fecha']);?></td>
    <td nowrap="nowrap"><?=$fila['estado_matricula'];?></td>
    <td nowrap="nowrap"><?=cambioFD($fila['fecha_retiro']);?></td>
    <td nowrap="nowrap"><?=$fila['motivo_re'];?></td>
    <td nowrap="nowrap"><?=$fila['curso_rep'];?></td>
    <td nowrap="nowrap"><?=$fila['condicional'];?></td>
    <td nowrap="nowrap"><?=$fila['sancion'];?></td>
    <td nowrap="nowrap"><?=$fila['integrado'];?></td>
    <td nowrap="nowrap"><?=$fila['pie'];?></td>
    <td nowrap="nowrap"><?=$fila['trat_especialista'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_neurologo'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_psicopedagogo'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_psicologo'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_psiquiatra'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_tastornosaprendizaje'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_fonoaudiologo'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_pvision'];?></td>
    <td nowrap="nowrap"><?=$fila['bool_paudicion'];?></td>
    
  </tr>
  
 <?php }?>
</table>
<?php }?>

</head></html>