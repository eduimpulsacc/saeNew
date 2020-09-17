
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


function mandaExcel(){
var values = $("#cmbINSTITUCION :selected").length;
var mes = $("#cmbMES").val();
var semanainicio=$("#semanadesde").val();
var semanatermino=$("#semanahasta").val();

var ruta = "rutina_penalolen_print_anotacion.php";
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

var ruta = "rutina_penalolen_anotacion.php";
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
   <td nowrap>COLEGIO</td>
    <td nowrap>NIVEL</td>
    <td nowrap>CURSO</td>
    <td nowrap>LETRA</td>
    <td nowrap>RUT</td>
    <td nowrap>DIGITO</td>
    <td nowrap>NOMBRE 
      ALUMNO</td>
    <td nowrap>APELLIDO 
      PATERNO</td>
    <td nowrap>APELLIDO 
    MATERNO</td>
    
    <td nowrap>TIPO 
    ANOTACI&Oacute;N</td>
    <td nowrap>TIPO CONDUCTA</td>
    <td nowrap>DETALLE</td>
    <td nowrap>FECHA</td>
    <td nowrap>USUARIO 
      REGISTRO</td>
  </tr>
  	<?php //ahora necesito años escolares
	$cole = "";
	for($ii=0;$ii<count($cmbINSTITUCION);$ii++){
	$cole.=$cmbINSTITUCION[$ii].",";
	}
	$cmbINSTITUCION=substr($cole,0,-1);
	
	
	 //ver si rangos vienen de semana o vienen de mes
	 if($_POST['cmbMES']>0 && ($_POST['semanadesde']==99 && $_POST['semanahasta']==99))
	 {
		 //	switch
		 $mm = ($cmbMES<10)?"0".$cmbMES:$cmbMES;
			
		$diai = ($fitt[1]==$mm)?$fitt[2]:"01";
			
		$diaf = finmes($mm,$nano,$fett[2]);
		
		
		$fm = explode("-",$fano);
		$parte = ($cmbMES==3)?$fm[1]:"01";
		$fechainicio="$cmbANO-".$mm."-".$parte;
		$fechafin=$cmbANO."-".$mm."-".$diaf;	 
		 
	}
	 if($_POST['cmbMES']==0 && ($_POST['semanadesde']!=99 && $_POST['semanahasta']!=99))
	 { 
	 	$fechainicio=$_POST['semanadesde'];
		$fechafin=$_POST['semanahasta'];
	 }
	
		
	  $sql_a = "select * from ano_escolar where id_institucion in($cmbINSTITUCION) and nro_ano=$cmbANO order by id_institucion";
	$rs_ano = pg_exec($conn,$sql_a);
	for($an=0;$an<pg_numrows($rs_ano);$an++){
	$fila_aa = pg_fetch_array($rs_ano,$an);
	$id_ano = $fila_aa['id_ano'];
	$nano = $fila_aa['nro_ano'];
	$fano = $fila_aa['fecha_inicio'];
	$tano = $fila_aa['fecha_termino'];
	
	//vamos a montar el listado de alumnos que tienen anotaciones
	 $sql_anot="SELECT i.rdb,a.rut_alumno, a.dig_rut, nombre_alu, a.ape_pat, a.ape_mat,
i.nombre_instit, c.grado_curso, c.letra_curso, te.nombre_tipo ,c.ensenanza,c.id_curso,
ano.tipo,ano.fecha as fecha_anotacion,ano.observacion,ano.rut_emp,ano.tipo_conducta,
emp.ape_pat||' '||emp.ape_mat||' '||emp.nombre_emp as empleado
FROM alumno a 
INNER JOIN matricula m ON a.rut_alumno=m.rut_alumno and m.bool_ar=0
INNER JOIN institucion i ON i.rdb=m.rdb
LEFT JOIN curso c ON c.id_curso=m.id_curso
INNER JOIN tipo_ensenanza te ON te.cod_tipo=c.ensenanza
INNER JOIN anotacion ano ON ano.rut_alumno = m.rut_alumno
INNER JOIN empleado emp ON emp.rut_emp = ano.rut_emp
where tipo!= 2
and m.id_ano in (select id_ano from ano_escolar where id_institucion in($cmbINSTITUCION) and nro_ano= $cmbANO)
and ano.fecha between '$fechainicio' and '$fechafin'
ORDER BY c.ensenanza, c.grado_curso, c.letra_curso, a.ape_pat, a.ape_mat,ano.fecha ASC";
$rs_matricula = pg_exec($conn,$sql_anot);
	for($i=0;$i<pg_numrows($rs_matricula);$i++){
	  	$fila = pg_fetch_array($rs_matricula,$i);
	
		 
	?>
  <tr class="tableindex">
    <td><?=$fila['rdb'];?></td>
    <td><?=$fila['nombre_instit'];?></td>
    <td><?=$fila['nombre_tipo'];?></td>
    <td><?=$fila['grado_curso'];?></td>
    <td><?=$fila['letra_curso'];?></td>
    <td><?=$fila['rut_alumno'];?></td>
    <td><?=$fila['dig_rut'];?></td>
    <td><?=$fila['nombre_alu'];?></td>
    <td><?=$fila['ape_pat'];?></td>
    <td><?=$fila['ape_mat'];?></td>
    <td><?
    if($fila['tipo']==1){
		echo "CONDUCTA";
		}
		 if($fila['tipo']==3){
		echo "RESPONSABILIDAD";
		}
	?></td>
    <td><?
    if($fila['tipo_conducta']==1){
		echo "POSITIVA";
		}
		 if($fila['tipo_conducta']==2){
		echo "NEGATIVA";
		}
	?></td>
    <td><?=$fila['observacion'];?></td>
    <td><?=CambioFD($fila['fecha_anotacion']);?></td>
    <td><?=$fila['empleado'];?></td>
  </tr>
  <?php } //fin for matrícula?>
 <?php  } //fin for año?>
 <?php }?>
 </table>

</head>
</html>