
<?php 

$id_base =4; 
//$nano = 2017;
//$rdb =9121;  
 //var_dump($_POST);
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

	
	//ano escolar
//dias habiles por rango fijo, sin feriados
function hbl($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
		
		//echo  $fechainicio.".....".$fechafin;
		
        $fechainicio = strtotime($fechainicio." 00:00:00");
	 $fechafin = strtotime($fechafin." 23:59:59");
       
        // Incremento en 1 dia
        $diainc = 24*60*60;
       
        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();
       
        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                        if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                                array_push($diashabiles, date('Y-m-d', $midia));
                        }
                }
        }
      //echo "--". count($diashabiles)."<br>";
	  
        return count($diashabiles);
}	

function envia_mes($mes){
		
		if($mes=="01"){$t_mes="Enero";}
		if($mes=="02"){$t_mes="Febrero";}
		if($mes=="03"){$t_mes="Marzo";}
		if($mes=="04"){$t_mes="Abril";}
		if($mes=="05"){$t_mes="Mayo";}
		if($mes=="06"){$t_mes="Junio";}
		if($mes=="07"){$t_mes="Julio";}
		if($mes=="08"){$t_mes="Agosto";}
		if($mes=="09"){$t_mes="Septiembre";}
		if($mes=="10"){$t_mes="Octubre";}
		if($mes=="11"){$t_mes="Noviembre";}
		if($mes=="12"){$t_mes="Diciembre";}	
		return ($t_mes);			
	  
	  }
	  
	
function finmes($mes,$ano){
if($mes==1 || $mes==3 || $mes==5 || $mes==7 || $mes==8 || $mes==10 || $mes==12){
		$dia=31;
	}elseif($mes==4 || $mes==6 || $mes==9 || $mes==11){
		$dia=30;
	}elseif(($ano%4)==0){
		$dia=29;
	}else{
		$dia==28;
	}
	return $dia;
}	
	
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
  // listaAno();
  semanasAno();
 

});


function semanasAno(){
	
	var nano = $("#cmbANO").val();
	var funcion =4;
var parametros = "funcion="+funcion+"&nano="+nano;
$.ajax({
	  url:"arma_penalolen/con_armar.php",
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	    $("#seman").html(data);
		 $( '#semanadesde' ).find('option[value="<?php echo $_POST['semanadesde'] ?>"]').attr('selected','selected');
		 $( '#semanahasta' ).find('option[value="<?php echo $_POST['semanahasta'] ?>"]').attr('selected','selected');
		
		  }
	  })	
	
}

/*function listaAno(){

var funcion=2;
var base = <?php echo $id_base ?>;
var rdb = $('#cmbINSTITUCION').val();
var aan = parseInt(<?php echo $_POST['cmbANO'] ?>);


var parametros = "funcion="+funcion+"&rdb="+rdb+"&base="+base;
//alert(parametros)
	  $.ajax({
			url:"arma_penalolen/armar.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
			console.log(data);
					if(data == 0){
					   alert("Error al cargar");
					}else{
					 $("#aa").html(data);
					// $('#cmbANO > option[value="'+aan+'"]').attr('selected', 'selected');
					}
		        }
		    })

}*/

function mandaExcel(){
var values = $("#cmbINSTITUCION :selected").length;
var mes = $("#cmbMES").val();
var semanainicio=$("#semanadesde").val();
var semanatermino=$("#semanahasta").val();

var ruta = "rutina_penalolen_print2.php";
form.target="_blank";
		form.action = ruta;
		form.method = "post";

if(values==0){
		 alert("Seleccione instituci\xF3n");
		 return false;
		}
else if(mes==0 && (semanainicio==99 || semanatermino==99)){
alert("Defina periodo a consultar (elegir mes o rango de semanas)");	
}
else if(mes!=0 && (semanainicio!=99 || semanatermino!=99)){
alert("Defina periodo a consultar (elegir mes o rango de semanas)");	
}
else if(mes==0 && (semanainicio >  semanatermino)){
alert("Semana inicio no puede ser mayor a semana de t\xE9rmino");	
}
else{
		
		form.submit(true);
		}
}

function validaform(){
	var values = $("#cmbINSTITUCION :selected").length;
var mes = $("#cmbMES").val();
var semanainicio=$("#semanadesde").val();
var semanatermino=$("#semanahasta").val();

var ruta = "rutina_penalolen2.php";
form.target="_self";
		form.action = ruta;
		form.method = "post";

if(values==0){
		 alert("Seleccione instituci\xF3n");
		 return false;
		}
else if(mes==0 && (semanainicio==99 || semanatermino==99)){
alert("Defina periodo a consultar (elegir mes o rango de semanas)");	
}		
else if(mes!=0 && (semanainicio!=99 || semanatermino!=99)){
alert("Defina periodo a consultar (elegir mes o rango de semanas)");	
}
else if(mes==0 && (semanainicio >  semanatermino)){
alert("Semana inicio no puede ser mayor a semana de t\xE9rmino");	
}
else{
		$("#b_bus").removeAttr("type");
		$("#b_bus").attr("type","submit");
		form.submit(true);
		}

}
</script>
<form action="" method="post"  name="form" >

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
	?> <!--onchange="listaAno()"-->
    <select name="cmbINSTITUCION[]" size="4"  multiple id="cmbINSTITUCION" >
    	     <? for($i=0;$i<pg_numrows($rs_institucion);$i++){
		 	$fila = pg_fetch_array($rs_institucion,$i);
			
	 ?>
     	<option value="<?=$fila['rdb'];?>" <?php echo (in_array($fila['rdb'],$_POST['cmbINSTITUCION']))?"selected":"" ?> ><?=$fila['nombre_instit'];?></option>
        
     
	<? } ?>
		   
    </select>
    <input name="id_base" type="hidden" id="id_base" value="<?php echo $id_base ?>">
    </td>
  </tr> 
  <tr>
    <td>A&ntilde;o</td>
    <td>&nbsp;</td>
    <td>&nbsp;
   <span id="aa"> 
   <select name="cmbANO" id="cmbANO" onChange="semanasAno()">
    <?php for($y=date("Y");$y>=2016;$y--){?>
    <option	value="<?php echo $y ?>" <?php echo ($y==$_POST['cmbANO'])?"selected":"" ?> ><?php echo $y ?></option>
    <?php }?>
   </select>
    </span>
    </td>
  </tr>
  <tr>
    <td>Mes</td>
    <td>&nbsp;</td>
    <td>&nbsp;
    <select name="cmbMES" id="cmbMES">
    	<option value="0">SELECCIONE...</option>
        <? for($i=1;$i<13;$i++){ ?>
		<option value="<?=$i;?>" <?php  echo($_POST['cmbMES']==$i)?"selected":"";?>><?=envia_mes($i);?></option>
        <? }?>
    </select>
    </td>
  </tr>
  <tr>
    <td>Semana</td>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;
    <span id="seman"> </span> 
      </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right"><input type="button" name="b_bus" id="b_bus" value="VER EN PANTALLA" onclick="validaform()">  <input name="b_exp" id="b_exp" type="button" value="EXPORTAR A EXCEL" onClick="mandaExcel()" ></td>
  </tr>
  </table>
</form>
<br>
<br>
<br>
<br>
<?php if(isset($b_bus)){ ?>
<table width="100%" border="1" style="border-collapse:collapse; font-family:Verdana, Geneva, sans-serif; font-size:10px">
  <tr class="tableindex">
   <td nowrap>RDB</td>
    <td nowrap>RUT</td>
    <td nowrap>DIGITO</td>
    <td nowrap>NOMBRES</td>
    <td nowrap>APELLIDOS</td>
    <td nowrap>GENERO</td>
    <td nowrap>DIRECCION</td>
    <td nowrap>TELEFONO</td>
    <td nowrap>CELULAR</td>
    <td nowrap>COLEGIO</td>
    <td nowrap>NIVEL</td>
    <td nowrap>CURSO</td>
    <td nowrap>LETRA</td>
    <td nowrap>DIAS<br />
    HABILES</td>
    <td nowrap>DIAS<br />
    ASISTENCIA</td>
    <td nowrap>DIAS <br />
      INASISTENCIA</td>
    <td nowrap>INASISTENCIA<br>
JUSTIFICADA</td>
    <td nowrap>INASISTENCIA<br>
NO JUSTIFICADA</td>
    <td nowrap>MOTIVO<BR>INASISTENCIA</td>
    <td nowrap>DETALLE<br>
      INASISTENCIA</td>
    <td nowrap>MATRICULA</td>
    <td nowrap>MES DE RETIRO</td>
    <td nowrap>FECHA DE RETIRO</td>
    <td nowrap>PROMEDIO</td>
  </tr>
  	<?php //ahora necesito años escolares
	$cole = "";
	for($ii=0;$ii<count($cmbINSTITUCION);$ii++){
	$cole.=$cmbINSTITUCION[$ii].",";
	}
	$cmbINSTITUCION=substr($cole,0,-1);
		
	  $sql_a = "select * from ano_escolar where id_institucion in($cmbINSTITUCION) and nro_ano=$cmbANO order by id_institucion";
	$rs_ano = pg_exec($conn,$sql_a);
	for($an=0;$an<pg_numrows($rs_ano);$an++){
	$fila_aa = pg_fetch_array($rs_ano,$an);
	$id_ano = $fila_aa['id_ano'];
	$nano = $fila_aa['nro_ano'];
	$fano = $fila_aa['fecha_inicio'];
	$tano = $fila_aa['fecha_termino'];
	
	$sql="SELECT i.rdb,a.rut_alumno, dig_rut, nombre_alu, ape_pat ||' '|| ape_mat as apellidos, fecha_nac,
		 case when (a.sexo=2) then 'Masculino' else 'Femenino' end as genero,a.calle ||' '|| a.nro as direccion, a.telefono, 
		 celular, i.nombre_instit, c.grado_curso, c.letra_curso, te.nombre_tipo ,c.ensenanza,c.id_curso,
		case when (bool_ar=0) THEN 'Vigente' else 'Retirado' end as estado_matricula, m.fecha_retiro,c.fecha_inicio,c.fecha_termino,m.bool_ar,m.fecha
		FROM alumno a 
		INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno 
		INNER JOIN institucion i ON i.rdb=m.rdb
		LEFT JOIN curso c ON c.id_curso=m.id_curso
		INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
		WHERE m.id_ano=".$id_ano."
		ORDER BY c.ensenanza, c.grado_curso, c.letra_curso, a.ape_pat, a.ape_mat ASC";
	$rs_matricula = pg_exec($conn,$sql);
	for($i=0;$i<pg_numrows($rs_matricula);$i++){
	  	$fila = pg_fetch_array($rs_matricula,$i);
	 
	 
	 //ver si rangos vienen de semana o vienen de mes
	 if($_POST['cmbMES']>0 && ($_POST['semanadesde']==99 && $_POST['semanahasta']==99))
	 {
		 //	switch
		 $mm = ($cmbMES<10)?"0".$cmbMES:$cmbMES;
			
		$diai = ($fitt[1]==$mm)?$fitt[2]:"01";
			
		$diaf = finmes($mm,$nano,$fett[2]);
		
		
		$fm = explode("-",$fano);
		$parte = ($cmbMES==3)?$fm[1]:"01";
		$fechainicio="$nano-".$mm."-".$parte;
		$fechafin=$nano."-".$mm."-".$diaf;	 
		 
	}
	 if($_POST['cmbMES']==0 && ($_POST['semanadesde']!=99 && $_POST['semanahasta']!=99))
	 { 
	 	$fechainicio=$_POST['semanadesde'];
		$fechafin=$_POST['semanahasta'];
	 }
	 
	 $nombre_mes="";
		
		
		  $corte_r="";
		 	 $corte_a="";
		 
		
		 if($fila['bool_ar']==1){
		  $df = explode("-",$fila['fecha_retiro']); 
		  $corte_r= " and date_part('day',fecha_fin) <=".$df[2];
		  $corte_a = " AND date_part('day',fecha)<=".$df[2]; 
		  $fechafin = $fila['fecha_retiro'];
		  
		  $mes = $df[1];
		  
			switch($mes){
				case 01:
					$nombre_mes ="ENERO";
					break;
				case 02:
					$nombre_mes ="FEBRERO";
					break;	
				case 03:
					$nombre_mes ="MARZO";
					break;
				case 04:
					$nombre_mes ="ABRIL";
					break;
				case 05:
					$nombre_mes ="MAYO";
					break;
				case 06:
					$nombre_mes ="JUNIO";
					break;
				case 07:
					$nombre_mes ="JULIO";
					break;
				case 08:
					$nombre_mes ="AGOSTO";
					break;
				case 09:
					$nombre_mes ="SEPTIEMBRE";
					break;
				case 10:
					$nombre_mes ="OCTUBRE";
					break;
				case 11:
					$nombre_mes ="NOVIEMBRE";
					break;
				case 12:
					$nombre_mes ="DICIEMBRE";
					break;
				default :
					$nombre_mes=" ";
			}
		
		  
		  
		  
		 }
		 else{
			$df = explode("-",$fila['fecha']);
			if($df[1]==$mm && ($df[2]!="01" && $df[2]!=$diaf) ){
			 $corte_a = " AND date_part('day',fecha)>=".$df[2]; 
			 $corte_r= " and date_part('day',fecha_inicio) >=".$df[2];
			 $fechainicio = $fila['fecha'];
			}
			else{
			
			 // $fechainicio = $fechainicio="$nano-".$mm."-".$$diaf;
			
			}
		 
		 }
		 	 
		
		  $sql="select sum((feriado.fecha_fin - feriado.fecha_inicio) + 1) as dia_feriado 
from feriado inner join feriado_curso
 on feriado_curso.id_feriado = feriado.id_feriado 
	 where id_ano=".$id_ano." and  feriado_curso.id_curso =".$fila['id_curso'];
	 
	  if($_POST['cmbMES']==0){
		$sql.=" and fecha_inicio>='".$_POST['semanadesde']."' and fecha_fin<='".$_POST['semanahasta']."'  ";  
		 }
		
	else{
		  $sql.=" and date_part('month',fecha_inicio)=".$cmbMES." $corte_r ";  
		 }
	// echo "<br>".$sql;
	
	$rs_feriado = pg_exec($conn,$sql);
	$dias_feriado = pg_result($rs_feriado,0);
	$dias_habiles = hbl($fechainicio,$fechafin) - $dias_feriado;
	//exit;
		
	 	  $sql="SELECT count(*) FROM asistencia WHERE ano=".$id_ano." AND rut_alumno=".$fila['rut_alumno'];
		  
		    if($_POST['cmbMES']==0){
		$sql.=" and fecha between'".$_POST['semanadesde']."' and '".$_POST['semanahasta']."' ";  
		 }
		
	else{
		  $sql.=" AND date_part('year',fecha)=$nano AND date_part('month',fecha)=".$mm ." $corte_a";  
		 }
		  
		 
		$rs_inasistencia = pg_exec($conn,$sql);
		$inasistencia = pg_result($rs_inasistencia,0);
		$dias_asistencia = $dias_habiles - $inasistencia;
		
		
		//justificadas
		$sql="SELECT count(*) FROM justifica_inasistencia WHERE ano=".$id_ano." AND rut_alumno=".$fila['rut_alumno'];
		  
		    if($_POST['cmbMES']==0){
		$sql.=" and fecha between'".$_POST['semanadesde']."' and '".$_POST['semanahasta']."' ";  
		 }
		
	else{
		  $sql.=" AND date_part('year',fecha)=$nano AND date_part('month',fecha)=".$mm ." $corte_a";  
		 }
		  //echo "<br>".$sql;
		 
		$rs_justifica = pg_exec($conn,$sql);
		$justifica = pg_result($rs_justifica,0);
		
		
		$njustifica = $inasistencia-$justifica;
		
		
		//conteo motivos inasistencia
		$sql_tj=" select distinct tid.nombre,det.detalle,det.fecha_desde,det.fecha_hasta
  from justifica_inasistencia_tipo tid
  inner join justifica_inasistencia_detalle det
  on det.tipo_justificacion = tid.id_tipo
  where det.rut_alumno = ".$fila['rut_alumno']."
  and id_curso = ".$fila['id_curso'];
		  
		    if($_POST['cmbMES']==0){
		$sql_tj.=" and fecha_desde>='".$_POST['semanadesde']."' and fecha_hasta<= '".$_POST['semanahasta']."' ";  
		 }
		
	else{
		$fmes = finmes($_POST['cmbMES'],$_POST['cmbANO']);
		$mmm = ($_POST['cmbMES']<10)?"0".$_POST['cmbMES']:$_POST['cmbMES'];
		
		$fechainicio= $_POST['cmbANO']."-".$mmm."-01";
		
		$fechafin= $_POST['cmbANO']."-".$mmm."-".$fmes;
		
		  $sql_tj.=" and fecha_desde>='".$fechainicio."' and fecha_hasta<= '".$fechafin."' "; 
		 }
		 
		 $sql_tj.=" order by fecha_desde";
		$rs_cjud = pg_exec($conn,$sql_tj);
		
		
		
		
		
		
		if($fila['ensenanza']>10){
		
		 //echo "<br>". 
		 //$sql="select avg(cast(promedio as integer)) from notas".$nano." where rut_alumno=".$fila['rut_alumno'];
		 $sql="select avg(cast(promedio as integer)) from notas".$nano." 
inner join ramo on ramo.id_ramo = notas".$nano.".id_ramo
where rut_alumno=".$fila['rut_alumno']." and bool_pgeneral=1";
		$rs_notas = pg_exec($conn,$sql);
		$promedio = pg_result($rs_notas,0);
		$promedio = round($promedio);
		}else{
			$promedio="-";
			}
		 
	?>
  <tr class="tableindex">
    <td><?=$fila['rdb'];?></td>
    <td><?=$fila['rut_alumno'];?></td>
    <td><?=$fila['dig_rut'];?></td>
    <td><?=$fila['nombre_alu'];?></td>
    <td><?=$fila['apellidos'];?></td>
    <td><?=$fila['genero'];?></td>
    <td><?=$fila['direccion'];?></td>
    <td><?=$fila['telefono'];?></td>
    <td><?=$fila['celular'];?></td>
    <td><?=$fila['nombre_instit'];?></td>
    <td><?=$fila['nombre_tipo'];?></td>
    <td><?=$fila['grado_curso'];?></td>
    <td><?=$fila['letra_curso'];?></td>
    <td><?=$dias_habiles;?></td>
    <td><?=$dias_asistencia;?></td>
    <td><?=$inasistencia;?></td>
    <td><?=$justifica ?></td>
    <td><?=$njustifica ?></td>
    <td><?php 
	for($tjus=0;$tjus<pg_numrows($rs_cjud);$tjus++){
	$fjus = pg_fetch_array($rs_cjud,$tjus);
	echo "-".$fjus['nombre']."<br>";	
	}
	
	?></td>
    <td><?php 
	for($tjus=0;$tjus<pg_numrows($rs_cjud);$tjus++){
	$fjus = pg_fetch_array($rs_cjud,$tjus);
	echo "- (".CambioFD($fjus['fecha_desde'])." a ".CambioFD($fjus['fecha_hasta']).") ".utf8_decode($fjus['detalle'])."<br>";	
	}
	
	?></td>
    <td><?=$fila['estado_matricula'];?></td>
    <td><?=$nombre_mes;?></td>
    <td><?=CambioFD($fila['fecha_retiro']);?></td>
    <td><?=$promedio;?></td>
  </tr>
  <?php } //fin for matrícula?>
 <?php  } //fin for año?>
 </table>
 <?php 
	
 }?>
</head>
</html>