<?php 
//$conn=pg_connect("dbname=coe host=localhost 		 user=postgres password=123456");
require('../../../../../util/header.inc');


?>
	<? if ($guardar){
	 $query_insert="insert into concentracion_notas (rut_alumno,institucion,ano,curso,promedio,asistencia,ciudad,comuna,plan,decreto) 
	 values('$rut_alumno','$institucion','$ano','$curso','$promedio','$asistencia','$ciudad','$comuna','$plan','$decreto')";
	
	 
		$result_insert=pg_exec($conn,$query_insert);
		
		$largo=count($notas);
		
		for ($i=0;$i<$largo;$i++){
			if ($notas[$i]!=""){
				if($subsector[$i]=='13'){
					$query_insert_detalle="insert into concentracion_detalle (rut_alumno,curso,subsector,religion) values('$rut_alumno','$curso','$subsector[$i]','$notas[$i]')";
					$result_insert_detalle=@pg_exec($conn,$query_insert_detalle);
				}else{
					$query_insert_detalle="insert into concentracion_detalle (rut_alumno,curso,subsector,promedio) values('$rut_alumno','$curso','$subsector[$i]','$notas[$i]')";
					$result_insert_detalle=@pg_exec($conn,$query_insert_detalle);
				}
			}
		}
	

//header ("Location: ../concentracionnotas.php?cmb_alumno=$rut_alumno&cmb_curso=$cmb_curso");
//exit();?>
<script language="javascript" type="text/javascript">
opener.location.reload();
window.close();


</script>
<? }
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">
	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo3 {font-size: 10px}
.Estilo4 {color: #666666}
-->
    </style>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Ingreso de informe</title>
<script type="text/JavaScript">
<!--
var abre_pop=0;
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function cambia_estado(valor) {
abre_pop=valor;
}

function window_open(url){
var opciones="left=100,top=100,width=250,height=400,scrollbars=yes,resizable=yes", i= 0;

 window.open(url,"bb",opciones); 
 }
 
 
 j=0;
function delRow(a)
{
alert (a)
x=document.getElementById('mytable').deleteRow(a)
}

function insRow(valor,nombre)
{
	largo=document.getElementById('mytable').rows.length;
	//	largo=largo+1;
	//alert(largo);
//	count()
	var x=document.getElementById('mytable').insertRow(largo);
	j=largo;
	var y=x.insertCell(0)
	var z=x.insertCell(1)
	y.className="td2";
	y.innerHTML="<input name='subsector[]' type='hidden' id='subsector[]'  value="+valor+">"+nombre+"<br>";
	z.innerHTML='<input name="notas[]" class="editbox" size="5" maxlength="2" >';
}

function ignorar(num){
alert (num);
	document.form.notas[num].disabled=true;	
}
//-->
</script>
<script language="javascript" type="text/javascript">
function IsNumeric(strString)
   //  check for valid numeric strings	
   {
   var strValidChars = "0123456789.-";
   var strChar;
   var blnResult = true;

   if (strString.length == 0) return false;

   //  test strString consists of valid characters listed above
   for (i = 0; i < strString.length && blnResult == true; i++)
      {
      strChar = strString.charAt(i);
      if (strValidChars.indexOf(strChar) == -1)
         {
         blnResult = false;
         }
      }
   return blnResult;
   }
function valida(){
	a=document.form;
	error="";
	arreglo=a.curso;
	if ((arreglo[0].checked==false)&&(arreglo[1].checked==false)&&(arreglo[2].checked==false)&&(arreglo[3].checked==false)){
		error=error+'----Seleccionar un curso----\r';
	}
	if (a.institucion.value==''){
		error=error+'Ingresar establecimiento\r';
	}
	
	
	if (a.ciudad.value==''){
		error=error+'Ingresar ciudad\r';
	}
	if (a.ano.value==''){
		error=error+'Ingresar año\r';
	}else{
		if (IsNumeric(a.ano.value)==false){
			error=error+'El año debe de ser numerico\r';
		}

	}
	
	if (a.promedio.value==''){
		error=error+'Ingresar promedio final\r';
	}else{
		if (IsNumeric(a.promedio.value)==false){
			error=error+'El promedio debe de ser numerico\r';
		}
	}
	if (a.asistencia.value==''){
		error=error+'Ingresar asistencia\r';
	}else{
		if (IsNumeric(a.asistencia.value)==false){
			error=error+'La Asistencia debe de ser numerico\r';
		}
	}
	
	if (error!=""){
		alert (error);
		return false;
	}else{
		return true;
	}
}/*
var myElem = self;
setmyfocus();
setTimeout('setmyfocus()',30);
function setmyfocus()
{
	if (abre_pop==0){
		myElem.focus();
	}
	setTimeout('setmyfocus()',30);

}
*/
</script>
</head>
<body >

<form name="form"  method="post" onSubmit="return valida()">
<?  for ($i=1;$i<=4;$i++){
					/*$query_matricula="select * 
					from matricula as mat,ano_escolar as ano,curso as curso 
					where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and curso.grado_curso='$i' and curso.ensenanza>300 AND mat.bool_ar<>1
					order by ano.nro_ano;";*/
//					echo "<br>$query_matricula<br>";

					$query_matricula="select * from matricula as mat,ano_escolar as ano,curso as curso, promocion where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and curso.grado_curso='$i' AND promocion.rut_alumno=mat.rut_alumno AND curso.ensenanza>300 AND mat.bool_ar<>1  AND situacion_final=1 AND promocion.id_ano=ano.id_ano	order by ano.nro_ano";
					$result_matricula=pg_exec($conn,$query_matricula);
					$num_matricula=pg_numrows($result_matricula);
					if ($num_matricula>0){
						$row_matricula=pg_fetch_array($result_matricula);
						$arreglo_curso[]=$row_matricula[grado_curso];
					}
	}
					
				$query_concentracion="select * from concentracion_notas where rut_alumno='$rut_alumno'";
				$result_concentracion=@pg_exec($conn,$query_concentracion);
				$num_concentracion=@pg_numrows($result_concentracion);
				
				
					
				for ($k=0; $k < $num_concentracion; $k++){
				
					
					$row_concentracion=pg_fetch_array($result_concentracion,$k);
					$arreglo_curso[]=$row_concentracion[curso];
						
				}				
				?>
					
					
<?

//print_r($arreglo_curso);
?>					
<table width="1%" border="1" align="center" class="td2">
	<tr><td colspan="2" class="td2">curso:</td>
	</tr>
	<tr>
	<acronym title="si no puede selecionar un curso, significa que ya estan todos los datos en el sistema">
		<td  colspan="2" class="td2">
		
			<table>
				<tr>
					<? for ($i=1;$i<=3;$i++){?>
				  <td class="td2"><input name="curso" type="radio" value="<? echo $i;?>" <? if (@in_array($i,$arreglo_curso)){ echo "disabled";}?>><? echo $i;?></td>
					<? }?>
				</tr>
	  </table></td></acronym>	</tr>
	<tr>
		<td class="td2 Estilo3 Estilo4">ESTABLECIMIENTO</td>
	<td class="td2"><input name="institucion" class="editbox " />	</tr>
	<tr>
	<td class="td2 Estilo3 Estilo4">CIUDAD</td>
	<td class="td2"><input name="ciudad" class="editbox " /></td>
	</tr>
	<tr>
	<td class="td2 Estilo3 Estilo4">COMUNA</td>
	<td class="td2"><input name="comuna" class="editbox " /></td>
	</tr>
	<tr>
		<td class="td2 Estilo3 Estilo4">A&Ntilde;O DEL CURSO </td>
	<td class="td2"><input name="ano" class="editbox " maxlength="4" /></td>	
	</tr>
	<tr>
		<td class="td2 Estilo3 Estilo4">PLAN DE ESTUDIO</td>
	    <td class="td2"><input name="plan" class="editbox " maxlength="30" /></td>
	</tr>
	<tr>
		<td class="td2 Estilo3 Estilo4">DECRETO DE EVALUACION</td>
	<td class="td2"><input name="decreto" class="editbox " maxlength="30" /></td>	
	</tr>
	
<? 	$query_matricula="select * from matricula as mat,ano_escolar as ano,curso as curso where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso order by ano.nro_ano;";
$result_matricula=@pg_exec($conn,$query_matricula);
 $num_matricula=@pg_numrows($result_matricula);
$ramo_id=array();
$ramo_nombre=array();
$cod_subsector=array();
for ($i=0;$i<$num_matricula;$i++){
	$row_matricula=pg_fetch_array($result_matricula);
	//imprime_arreglo($row_matricula);
	$anos_id[]=$row_matricula[id_ano];
	$grado_curso[]=$row_matricula[grado_curso];
	$nro_ano[]=$row_matricula[nro_ano];
	$aproxima[]=$row_matricula[truncado_per];
	$curso_id[]=$row_matricula[id_curso];
	
	 $query_tiene="select ramo.id_ramo,sub.nombre ,ramo.modo_eval ,ramo.cod_subsector from tiene$row_matricula[nro_ano] as tiene, ramo as ramo, subsector as sub where tiene.rut_alumno='$rut_alumno' 
	and tiene.id_ramo=ramo.id_ramo and ramo.cod_subsector=sub.cod_subsector";
	$result_tiene=pg_exec($conn,$query_tiene);
	$num_tiene=pg_numrows($result_tiene);
	for ($j=0;$j<$num_tiene;$j++){
		$row_tiene=pg_fetch_array($result_tiene);
			if (!in_array($row_tiene[cod_subsector],$cod_subsector)){
			$ramo_id[]=$row_tiene[id_ramo];
			$ramo_nombre[]=$row_tiene[nombre];
			$ramo_modo_eval[]=$row_tiene[modo_eval];
			$cod_subsector[]=$row_tiene[cod_subsector];
		}
	}
	
}?>
<tr><td colspan="2" class="td2 Estilo3 Estilo4"><table width="100%" class="td2" id="mytable" >
  <tr>
    <td class="td2">SUBSECTOR</td>
    <td class="td2">PROM</td>
  </tr>
  <? for ($i=0;$i<count($ramo_nombre);$i++){?>
  <tr>
    <td nowrap="nowrap" class="td2"><? echo $ramo_nombre[$i];?>
        <input name="subsector[]" type="hidden"  value="<? echo $cod_subsector[$i];?>" /></td>
    <td nowrap="nowrap" class="td2"><acronym title="para ignorar una asignatura solo deje en blanco el promedio"><input name="notas[]" class="editbox" size="5" maxlength="2" /></acronym></td>
  </tr>
  <? }?>
  </table>
  <table width="100%">
  <tr>
    <td colspan=2 align="center"><a href="javascript:;"  onclick="window_open('buscador.php');"><b>&lt;---Agregar---&gt;</b></a></td>
  </tr>
  <tr>
    <td class="td2">P. GENERAL</td>
    <td nowrap="nowrap" class="td2"><input name="promedio" type="text" class="editbox" value="" size="5" maxlength="2" /></td>
  </tr>
  <tr>
    <td class="td2">ASISTENCIA</td>
    <td nowrap="nowrap" class="td2"><input name="asistencia" type="text" class="editbox" value="" size="5" maxlength="3" />
      %</td>
  </tr>
</table></td>
</tr>
<tr>
	<td colspan="2" align="center">
		<input name="cmb_curso" type="hidden" value="<? echo $cmb_curso;?>" />
		<input name="rut_alumno" type="hidden" value="<? echo $rut_alumno;?>">
		<input name="guardar" type="submit" class="botonXX" id="cb_ok" value="Guardar"/></td>
</tr>
</table>

<p>&nbsp;</p>
</form>
</body>
</html>
