<?php require('../../util/header.inc');
	

$corporacion   =$_CORPORACION;
$ano		   = $_ANO;

//echo $cantidad;
//$corporacion=8;
foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor ."';"; 
	eval($asignacion);
	
	//echo "asignacion=$asignacion<br>";
   } 	

$sql_corp="select * from corp_instit where num_corp=".$corporacion;
$res_corp=pg_exec($conn,$sql_corp);
$fila_corp = @pg_fetch_array($res_corp,0);
$corp = $fila_corp['num_corp']; 


$sql_corp2="select * from corporacion where num_corp=".$corporacion;
$res_corp2=pg_exec($conn,$sql_corp2);
$fila_corp2 = @pg_fetch_array($res_corp2,0);
$nombre_corp = $fila_corp2['nombre_corp']; 


$dias=array("","","",31,30,31,30,31,31,30,31,30,31);
$meses=array("","","","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE");

switch ($mes)
{

	case 3:
	$fin_dia=31;
	$mes_ant=3;
	$dia_ant=31;
	break;
	
	case 4:
	$fin_dia=30;
	$mes_ant=3;
	$dia_ant=31;
	break;
	
	case 5:
	$fin_dia=31;
	$mes_ant=4;
	$dia_ant=30;
	break;
	
	case 6:
	$fin_dia=30;
	$mes_ant=5;
	$dia_ant=31;
	break;
	
	case 7:
	$fin_dia=31;
	$mes_ant=6;
	$dia_ant=30;
	break;
	
	case 8:
	$fin_dia=31;
	$mes_ant=7;
	$dia_ant=31;
	break;
	
	case 9:
	$fin_dia=30;
	$mes_ant=8;
	$dia_ant=31;
	break;
	
	case 10:
	$fin_dia=31;
	$mes_ant=9;
	$dia_ant=30;
	break;
	
	case 11:
	$fin_dia=30;
	$mes_ant=10;
	$dia_ant=31;
	break;
	
	case 12:
	$fin_dia=31;
	$mes_ant=11;
	$dia_ant=30;
	break;


}
function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>

		 	
<script type="text/JavaScript">
<!--
num=0;
resta=0;
curso=0;
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function muestra_tabla(tabla,span){
	t=document.getElementById(tabla);
	span2=document.getElementById(span);
	temp=document.getElementById(tabla).style.display;
	document.getElementById('matricula').style.display='none';
	document.getElementById('asistencia').style.display='none';
	document.getElementById('notas').style.display='none';
	document.getElementById('opcion4').style.display='none';
	document.getElementById('opcion5').style.display='none';
	document.getElementById('proyecto').style.display='none';
	document.getElementById('gestion').style.display='none';
	document.getElementById('evaluaciones').style.display='none';
	document.getElementById('simce').style.display='none';
	document.getElementById('becas').style.display='none';
	document.getElementById('practica').style.display='none';
	document.getElementById('pesta1').className='span_normal';
	document.getElementById('pesta2').className='span_normal';
	document.getElementById('pesta3').className='span_normal';
	document.getElementById('pesta4').className='span_normal';
	document.getElementById('pesta5').className='span_normal';
	document.getElementById('pesta6').className='span_normal';
	document.getElementById('pesta7').className='span_normal';
	document.getElementById('pesta8').className='span_normal';
	document.getElementById('pesta9').className='span_normal';
	document.getElementById('pesta10').className='span_normal';
	document.getElementById('pesta11').className='span_normal';
	t.style.display="";
	span2.className='span_seleccionado';
}

function enviapag2(form){
    form.submit(true);		
}
function enviapag3(form2){
    form2.submit(true);		
}

function enviapagP(form){
    form.submit(true);		
}
function enviapagg(form){
    form.submit(true);		
}


function enviapagNOTAS(form3){
    form3.submit(true);		
}
function enviapag4(f1){
    f1.submit(true);		
}
function enviapag5(f2){
    f2.submit(true);		
}

nume=0;
x=0;
function crear(obj) {
  nume++;
  var valor=document.getElementById(obj).checked;
  //arreglo=new array();
  //arreglo[nume]=valor;
  //alert(arreglo[nume]);
  //fi = document.getElementById('fiel'); 
  //contenedor = document.createElement('div'); 
  //contenedor.id = 'div'+nume; 
  //fi.appendChild(contenedor); 

  //ele = document.createElement('input'); 
  //ele.type = 'text'; 
 // ele.name = 'cursos'+nume; 
 // ele.value = document.getElementById(obj).value;
  //contenedor.appendChild(ele); 
  if(valor==true){
  num++;
 // alert(num);
  }else{
  --num;
  //alert(num);
  }
  //alert('resta:'+x);       
}

//function enviapag6(idInput){
/*if(document.getElementById(idInput).cheched=true){
num++;		
  	var valor=document.getElementById(idInput).value;
		// Obtenemos el div contenedor del futuro input
		//var divContenedor = document.createElement("contenedores"); 
		//divContenedor.id=curso;
		//fi.appendChild(divContenedor); 
		var divContenedor=document.getElementById("contenedores");
		// Creamos el input
		alert(idInput);
		alert(curso);
		divContenedor.innerHTML="<input type='text' id='curso"+curso+"' name='curso"+curso+"' value='"+valor+"'>";
		// Colocamos el cursor en el input creado
		//document.getElementById(idInput).focus();
		//document.getElementById(idInput).select();
		// Establecemos a true la variable para especificar que hay un input en pantalla y no se debe crear otro hasta que este se oculte
	//	mostrandoInput=true;
	//}
 curso++;
 }
 */
  
//}

function enviapag7(f4){
    f4.action='reporteCalificacionesCorporacion2.php';
	f4.submit(true);
}
function enviapag8(idInput){
resta++;		
	var valor=document.getElementById(idInput).value;
//	f3.action='reportesCorporativos.php?cantidad='+num;

}

function enviapagano(form,pa){
	var ano, frmModo; 
	ano2=form.cmb_ano.value;
		
	if (form.cmb_ano.value!="0"){		
		pag="../institucion/ano/seteaAno.php3?caso=10&pa="+pa+"&ano="+ano2;
		form.action = pag;
		form.submit(true);	
	}		
 }
 
 
function ver(f3){
//alert(num);
valor = num;
f3.action='reportesCorporativos.php?cantidad='+valor;
f3.submit(true);

}
function enviapagReporte(form3){
	form3.target='_blank';
	form3.action='reporteCalificacionesCorporacion2.php';
	form3.submit(true);
}

function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
function visible(opcion,form){
	if(document.getElementById(opcion).value==1){
		combo1.style.visibility='visible';
		combo11.style.visibility='visible';
		combo21.style.visibility='hidden';
		combo22.style.visibility='hidden';
		combo31.style.visibility='hidden';
		combo32.style.visibility='hidden';
		combo33.style.visibility='hidden';
		combo4.style.visibility='hidden';
		combo51.style.visibility='hidden';
		combo61.style.visibility='hidden';
		combo62.style.visibility='hidden';
	}
	if(document.getElementById(opcion).value==2){
		combo1.style.visibility='hidden';
		combo11.style.visibility='hidden';
		combo21.style.visibility='visible';
		combo22.style.visibility='visible';
		combo31.style.visibility='hidden';
		combo32.style.visibility='hidden';
		combo33.style.visibility='hidden';
		combo4.style.visibility='hidden';
		combo51.style.visibility='hidden';
		combo61.style.visibility='hidden';
		combo62.style.visibility='hidden';
	}
	if(document.getElementById(opcion).value==3){
		combo1.style.visibility='hidden';
		combo11.style.visibility='hidden';
		combo21.style.visibility='hidden';
		combo22.style.visibility='hidden';
		combo31.style.visibility='visible';
		combo32.style.visibility='visible';
		combo33.style.visibility='visible';
		combo4.style.visibility='hidden';
		combo51.style.visibility='hidden';
		combo61.style.visibility='hidden';
		combo62.style.visibility='hidden';
	}
	if(document.getElementById(opcion).value==4){ 
		combo1.style.visibility='hidden';
		combo11.style.visibility='hidden';
		combo21.style.visibility='hidden';
		combo22.style.visibility='hidden';
		combo31.style.visibility='hidden';
		combo32.style.visibility='hidden';
		combo33.style.visibility='hidden';
		combo4.style.visibility='visible';
		combo51.style.visibility='hidden';
		combo61.style.visibility='hidden';
		combo62.style.visibility='hidden';
	}
	if(document.getElementById(opcion).value==5){ 
		combo1.style.visibility='hidden';
		combo11.style.visibility='hidden';
		combo21.style.visibility='hidden';
		combo22.style.visibility='hidden';
		combo31.style.visibility='hidden';
		combo32.style.visibility='hidden';
		combo33.style.visibility='hidden';
		combo4.style.visibility='hidden';
		combo51.style.visibility='visible';
		combo61.style.visibility='hidden';
		combo62.style.visibility='hidden';
	}
	if(document.getElementById(opcion).value==6){ 
		combo1.style.visibility='hidden';
		combo11.style.visibility='hidden';
		combo21.style.visibility='hidden';
		combo22.style.visibility='hidden';
		combo31.style.visibility='hidden';
		combo32.style.visibility='hidden';
		combo33.style.visibility='hidden';
		combo4.style.visibility='hidden';
		combo51.style.visibility='hidden';
		combo61.style.visibility='visible';
		combo62.style.visibility='visible';
	}
	
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
}
.Estilo2 {font-size: 12px}
.Estilo4 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; font-weight: bold; }
.Estilo8 {font-size: 10px}
.Estilo10 {color: #0099FF}
#subsectores { width: 400px;
height: 200px;
/*background-color: #366;*/
float: left;
position:relative; 
border: 1px solid #808080; 
overflow: auto; 
top:0px; 
left:0px; 

}
.Estilo11 {font-size: 9px}
.Estilo20 {
	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo21 {font-size: 9}
.Estilo25 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; }
.Estilo26 {font-size: 9; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo28 {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 10px; }

-->
</style>
</head>
<script>
	document.getElementById('matricula').style.display='none';
	document.getElementById('asistencia').style.display='none';
	document.getElementById('notas').style.display='none';
	document.getElementById('opcion4').style.display='none';
	document.getElementById('opcion5').style.display='none';
	document.getElementById('proyecto').style.display='none';
	document.getElementById('gestion').style.display='none';
	document.getElementById('evaluaciones').style.display='none';
	document.getElementById('simce').style.display='none';
	document.getElementById('becas').style.display='none';
	document.getElementById('practica').style.display='none';
	t.style.display="";
</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="
<? 
if (($pesta == "") or ($pesta == NULL) or ($pesta == " ") or ($pesta == 1) or (!isset($pesta))){ ?>
      muestra_tabla('matricula','pesta1'); <?
   } 
   if ($pesta == 2){ ?>
      muestra_tabla('asistencia','pesta2'); <?
   }
   if ($pesta == 3){ ?>
      muestra_tabla('notas','pesta3'); <?
   }
   if ($pesta == 4){ ?>
      muestra_tabla('opcion4','pesta4'); <?
   }
   if ($pesta == 5){ ?>
      muestra_tabla('opcion5','pesta5'); <?
   }
    if ($pesta == 6){ ?>
      muestra_tabla('proyecto','pesta6'); <?
   }
   if ($pesta == 7){ ?>
      muestra_tabla('gestion','pesta7'); <?
   }
   if ($pesta == 8){ ?>
      muestra_tabla('evaluaciones','pesta8'); <?
   }
   if ($pesta == 9){ ?>
      muestra_tabla('simce','pesta9'); <?
   }
    if ($pesta == 10){ ?>
      muestra_tabla('becas','pesta10'); <?
   }
    if ($pesta == 11){ ?>
      muestra_tabla('practica','pesta11'); <?
   }
   ?>
   
MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><table width="100%"><tr><td><table width="100%"><tr><td>&nbsp;</td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../menus/menu_lateral.php");
						 ?>					  </td>
                      <td width="73%" align="left" valign="top"><!--- CUERPO DE LA PÁGINA REPORTES CORPORACIONES -->
                        <table width="100%" border="0" cellpadding="5" cellspacing="0">
                          <tr>
                          <td><span class="Estilo1">REPORTES NIVEL CORPORACI&Oacute;N </span></td>
                        </tr></table>
						
                        <table width="100%" border="3" cellpadding="3" cellspacing="3" bordercolor="#999999">
					   <tr>
					     <td>
						   <table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#000000">
						      <tr>
						        <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('matricula','pesta1');"><span id="pesta1" class="span_normal" >Matricula</span></a></div></td>
						        <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('asistencia','pesta2');"><span id="pesta2" class="span_normal" >Asistencia </span></a></div></td>
						        <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('notas','pesta3');"><span id="pesta3" class="span_normal" >Calificaciones </span></a></div></td>
						        <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion4','pesta4');"><span id="pesta4" class="span_normal" >Dotacion Docente </span></a></div></td>
						        <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('opcion5','pesta5');"><span id="pesta5" class="span_normal" >Postulacion </span></a></div></td>
								
						      </tr>
						   </table>						 </td>
					   </tr>
					   </tr>
					   <tr>
					   <td>
					   <table width="100%" border="1" align="center" cellpadding="3" cellspacing="1" bordercolor="#000000">
						      <tr>
							  <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('proyecto','pesta6');"><span id="pesta6" class="span_normal" >Proyecto Int y Grupo Dif </span></a></div></td>
								  <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('gestion','pesta7');"><span id="pesta7" class="span_normal" >Gesti&oacute;n Curricular</span></a></div> </td>
						          <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('evaluaciones','pesta8');"><span id="pesta8" class="span_normal" >Evaluaciones</span></a></div></td>
								   <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('simce','pesta9');"><span id="pesta9" class="span_normal" >SIMCE - PSU</span></a></div></td>
								   <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('becas','pesta10');"><span id="pesta10" class="span_normal" >Becas y Beneficios</span></a></div></td>
								    <td width="14%"><div align="center" class="Estilo4"><a href="javascript:;" onClick="muestra_tabla('practica','pesta11');"><span id="pesta11" class="span_normal" >Práctica Profesional</span></a></div></td>
						      </tr>
						   </table>	
					   </td>
					   </tr>
					   <tr>
					     <td height="400" valign="top">
						   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="matricula">
                               <td valign="top" class="Estilo1">MATR&Iacute;CULA<br>
                                 <br>
								   <table width="100%" border="0" cellpadding="5" cellspacing="0">
								    <tr>
								      <td>
									  <form name="form"   action="" method="post">
									    <span class="Estilo8">A&ntilde;o escolar:</span> 
										<input type="hidden" value="<?=$txt ?>" name="txt">
										<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
										   <option value="0">Seleccione Año</option>
										   <option value="2009" <? if ($cmb_ano=="2009"){ ?> selected="selected" <? } ?>>2009</option>
                                           <option value="2008" <? if ($cmb_ano=="2008"){ ?> selected="selected" <? } ?>>2008</option>
										   <option value="2007" <? if ($cmb_ano=="2007"){ ?> selected="selected" <? } ?>>2007</option>
										   <option value="2006" <? if ($cmb_ano=="2006"){ ?> selected="selected" <? } ?>>2006</option>
										   <option value="2005" <? if ($cmb_ano=="2005"){ ?> selected="selected" <? } ?>>2005</option>
										   <option value="2004" <? if ($cmb_ano=="2004"){ ?> selected="selected" <? } ?>>2004</option>
										</select>
									    <input name="cmb_inst" type="hidden" id="cmb_inst" value="<?=$cmb_inst ?>">
									 </form>					               </td>
								    </tr>
									<tr>
									  <td>
									  
									   <? 
									   if ($op==NULL and $cmb_ano > 0){ ?>
									   <table width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>">Matr&iacute;cula Total Corporaci&oacute;n </a></td>
									      </tr>
										  <tr>
										    <td><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=8&cmb_ano=<?=$cmb_ano ?>">Matr&iacute;cula Mensual de la Corporaci&oacute;n</a> </td>
									      </tr>
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=2&cmb_ano=<?=$cmb_ano ?>">Alumnos Retirados de la Corporaci&oacute;n </a></td>
									      </tr>
										  <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=3&cmb_ano=<?=$cmb_ano ?>">Matrícula de alumnos sexo Masculino de la Corporaci&oacute;n </a></td>
									      </tr>
										   <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=4&cmb_ano=<?=$cmb_ano ?>">Matrícula de alumnos sexo Femenino de la Corporaci&oacute;n </a></td>
									      </tr>
										   <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=5&cmb_ano=<?=$cmb_ano ?>">Matrícula de alumnos origen indígena de la Corporaci&oacute;n </a></td>
										   </tr>
										   <tr>
										    <td width="1%"><img src="images/flecha.gif" width="18" height="18"></td>
										    <td class="Estilo8"><a href="reportesCorporativos.php?pesta=1&op=6&cmb_ano=<?=$cmb_ano ?>">Matrícula a partir del 30 de Abril de la Corporaci&oacute;n </a></td>
										   </tr>
										   <tr>
										     <td colspan="2" valign="middle">
											 <form name="form2" method="post" action="reportesCorporativos.php?pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>">
											 <div align="center" class="Estilo8"><br>
											   <br>
											   B&uacute;squeda de alumnos 
													   <label>
													   <input name="txt" type="text" id="txt" size="20">
													   </label>
													   <label>
													   &nbsp;Establecimiento
													   <select name="cmb_inst" id="cmb_inst">
													      <option value="0">Buscar en todos</option>
														  <? 
														  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												          $result_ins=@pg_Exec($conn,$qry_ins);
												          for($i=0;$i<pg_numrows($result_ins);$i++){	
													          $fila_ins = pg_fetch_array($result_ins,$i);
													          $rdb = $fila_ins['rdb'];
													          $establecimiento = $fila_ins['nombre_instit']; 
															  ?>
													          <option value="<?=$rdb ?>"><?=$establecimiento ?></option>
															  <?
														  }
														  ?>	  
                                                       </select>
													     &nbsp; <input name="buscar" type="image" src="images/lupa.gif" align="bottom" width="21" height="20">
													   </label>
													    <label></label>
													    <br>
											   <span class="Estilo10">Criterios de b&uacute;squeda<br> 
											 (Rut sin d&iacute;gito verificador, nombre, apellido paterno, apellido materno del alumno)</span> </div>
											 </form>											 </td>
								          </tr>				
										</table> 
										<? } ?>
										 
									    <?
										if ($pesta==1 and $op==1 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td>
												<?php if($corp==8)
												{
												?>
												<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <tr>
    <td colspan="14"><div align="center">Total matr&iacute;cula corporaci&oacute;n</div></td>
    </tr>
  <tr>
    <td bgcolor="#999999" class="Estilo4">Establecimiento</td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">MAR</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">ABR</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">MAY</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">JUN</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">JUL</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">AUG</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">SEP</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">OCT</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">NOV</div></td>
    <td bgcolor="#999999" class="Estilo4"><div align="center">DIC</div></td>
    </tr>
	<?php
											 $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = ".$corporacion." and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												 // echo "encontrados=".pg_numrows($result_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													 $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													  
													  //busco año escolar
													$sql_bus_anio="select * from ano_escolar where id_institucion=".$rdb." and nro_ano=".$cmb_ano;
													$res_bus_anio=@pg_Exec($conn,$sql_bus_anio);  
													for($h=0;$h<pg_numrows($res_bus_anio);$h++)
													{ 
													 $fila_anio = pg_fetch_array($res_bus_anio,$h); 
														$id_anio = $fila_anio['id_ano'];
														//busco cursos con ese año
														

													   ?>
  <tr>
    <td class="Estilo4"><span class="Estilo11"><?php echo $establecimiento ?> </span></td>
	<?php for ($a=0;$a<=12;$a++)
	{
		
		if ($a>2)
		{
		//empezar a hacer calculo
		
	?>
    <td >
	  <div align="center" class="Estilo11" >
	    <?php   
		//retirados
		 $sql_calc="select count (*) as calc1 from matricula where id_ano=".$id_anio." and fecha_retiro<=".$cmb_ano."-".$a."-".$dias[$a];
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				 $calc_1=$fila_calc_1['calc1'];
				} 
				
				//matricula total
			$sql_calc="select count (*) as calc2 from matricula where id_ano=".$id_anio;
				$res_calc=pg_exec($conn,$sql_calc);
				for($c=0;$c<pg_numrows($res_calc);$c++)
				{
				$fila_calc_2 = pg_fetch_array($res_calc,$c);
				$calc_2=$fila_calc_2['calc2'];
				
				$total=$total+$calc_2;
				} 
				
	  $calc_total=$calc_2-$calc_1;
	echo $calc_total;
	?>
	    </div></td>
    <?php
	 }
	}
	}
	?>
    </tr>
	<?php  }?>
	 <tr>
    <td bgcolor="#999999" class="Estilo4">Totales</td>
	<?php for ($a=0;$a<=12;$a++)
	{
		
		if ($a>2)
		{
		//empezar a hacer calculo
		
	?>
    <td bgcolor="#999999" class="Estilo4"><div align="center"><span class="Estilo11"><?php   
		//retirados
		   $sql_calc="select count(rut_alumno) as calc1 from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = $cmb_ano and id_institucion in (select rdb from corp_instit where num_corp=$corporacion)) and fecha_retiro<".$cmb_ano."-".$a."-".$dias[$a];
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				 $calc_1=$fila_calc_1['calc1'];
				} 
				
				//matricula total
		$sql_calc="select count(rut_alumno) as calc2 from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = $cmb_ano and id_institucion in (select rdb from corp_instit where num_corp=$corporacion))";
				$res_calc=pg_exec($conn,$sql_calc);
				for($c=0;$c<pg_numrows($res_calc);$c++)
				{
				$fila_calc_2 = pg_fetch_array($res_calc,$c);
				$calc_2=$fila_calc_2['calc2'];
				
				$total=$total+$calc_2;
				} 
				
	  $calc_total=$calc_2-$calc_1;
	echo $calc_total;
	?></span></div></td>
    <?php }
	}?>
    </tr>
</table>
												<?	

												}
												else
												{?>
												<table width="100%" border="1" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Total matr&iacute;cula corporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Matricula</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as mat from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $matriculados = $filsMatriculados['mat'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$matriculados ?></b></div></td>
													   </tr>
													   <?
													   $total_matriculados = $total_matriculados + $matriculados;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_matriculados ?></div></td>
												  </tr>
												</table>
												<?php }?></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><a href="print_mat_anual_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										  
										  
										  <?
										if ($pesta==1 and $op==2 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Alumnos retirados corporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													    $query_mat="select count(rut_alumno) as ret from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar='1'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $retirados = $filsMatriculados['ret'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$retirados ?></b></div></td>
													   </tr>
													   <?
													   $total_retirados = $total_retirados + $retirados;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_retirados ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><a href="print_mat_ret_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										   <?
										if ($pesta==1 and $op==3 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos sexo Masculino de la orporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as mascu from alumno where rut_alumno in (select rut_alumno from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1) and sexo = '2'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $mascu = $filsMatriculados['mascu'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$mascu ?></b></div></td>
													   </tr>
													   <?
													   $total_mascu = $total_mascu + $mascu;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_mascu ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><a href="print_mat_masc_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										   <?
										if ($pesta==1 and $op==4 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos sexo Femenino de la orporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as feme from alumno where rut_alumno in (select rut_alumno from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1) and sexo = '1'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $feme = $filsMatriculados['feme'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$feme ?></b></div></td>
													   </tr>
													   <?
													   $total_feme = $total_feme + $feme;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_feme ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><a href="print_mat_fem_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										   <?
										if ($pesta==1 and $op==5 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos origen indígena de la orporaci&oacute;n </div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as indi from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1 and bool_aoi = '1'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $indi = $filsMatriculados['indi'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$indi ?></b></div></td>
													   </tr>
													   <?
													   $total_indi = $total_indi + $indi;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_indi ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><a href="print_mat_ind_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										  <?
										if ($pesta==1 and $op==6 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td colspan="2"><div align="center">Matrícula de alumnos después del 30 de abril</div></td>
												  </tr>
												  <tr>
													<td class="Estilo4">Establecimiento</td>
													<td width="20%" class="Estilo4"><div align="right">Cantidad</div></td>
												  </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as abril from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1 and fecha > '$cmb_ano-04-30'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $abril = $filsMatriculados['abril'];
													   ?>
													   <tr>
														<td class="Estilo8"><?=$establecimiento ?></td>
														<td class="Estilo8"><div align="right"><b><?=$abril ?></b></div></td>
													   </tr>
													   <?
													   $total_abril = $total_abril + $abril;
												  }
												  ?>
												  <tr>
													<td class="Estilo4"><div align="right">Total</div></td>
													<td class="Estilo4"><div align="right"><?=$total_abril ?></div></td>
												  </tr>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><a href="print_mat_304_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										  
										  
										  <?
										if ($pesta==1 and $op==8 and $cmb_ano!=0){ ?>
											<table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td><table width="100%" border="0" cellspacing="0" cellpadding="3">
												  <tr>
													<td width="20%" colspan="6"><div align="center">Matrícula de alumnos Mensual Corporaci&oacute;n </div></td>
												  </tr>
												  
												  <tr>
												    <td colspan="6" class="Estilo4"> <form name="formes" method="post">Al mes de
												        <select name="mes" >
												          <option value="0">--Seleccione--</option>
												          <?php  for($z=0;$z<12;$z++)
													  {
													  	if ($z>2)
														{
															$selected="";
															if($z==$mes)
															$selected="selected";
													  ?>
												          <option value="<?php echo $z ?>" <?php echo $selected ?>><?php echo $meses[$z] ?></option>
												          <?
														}
														}
														?>
                                                        </select> 
												        &nbsp;
												        <input type="hidden" name="cmb_ano" value="<?php echo $cmb_ano ?>">
												        &nbsp;&nbsp;&nbsp;
												        <input type="submit" name="Submit3" value="Enviar">
												    </form>                                                                                                         </td>
											      </tr>
												  <tr>
												    <td colspan="6" class="Estilo4">A&ntilde;o
												      <?php echo $cmb_ano ?></td>
											      </tr>
												  <tr>
												    <td class="Estilo4">Establecimiento</td>
												    <td class="Estilo4"><div align="center">Matr&iacute;cula Mes </div></td>
												    <td class="Estilo4"><div align="center">Matr&iacute;cula Mes Anterior </div></td>
												    <td class="Estilo4"><div align="center">Altas</div></td>
												    <td class="Estilo4"><div align="center">Bajas</div></td>
												    <td class="Estilo4"><div align="center">Total</div></td>
											      </tr>
													<?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = ".$corporacion." and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													 $sql_bus_anio="select * from ano_escolar where id_institucion=".$rdb." and nro_ano=".$cmb_ano;
													$res_bus_anio=@pg_Exec($conn,$sql_bus_anio);  
													for($h=0;$h<pg_numrows($res_bus_anio);$h++)
													{ 
													 $fila_anio = pg_fetch_array($res_bus_anio,$h); 
													$id_anio = $fila_anio['id_ano'];
														//busco cursos con ese año
													}	

													   ?>
													   
													  <tr>
												    <td class="Estilo4"><?php echo $establecimiento ?></td>
												    <td class="Estilo11"><div align="center"><?php    $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($id_anio) and fecha<='$cmb_ano-$mes-$fin_dia' and ID_CURSO>0 ) and rut_alumno not in (select rut_alumno from matricula where id_ano = ($id_anio) and fecha_retiro <= '$cmb_ano-$mes-$fin_dia' ) ";
													  
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
																									
													echo $totalmes = $fila2['suma2'];
													$tot_ens_mes=$tot_ens_mes+$totalmes;
													
												}
											} ?></div></td>
												    <td class="Estilo11"><div align="center">
													
<?php  $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($id_anio) and fecha<='$cmb_ano-$mes_ant-$dia_ant' and ID_CURSO>0 ) and rut_alumno not in (select rut_alumno from matricula where id_ano = ($id_anio) and fecha_retiro <= '$cmb_ano-$mes_ant-$dia_ant' ) ";
		
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
																									
													if ($mes==3)
													echo "0";
													else
													echo $totalmesant = $fila2['suma2'];
													
													$tot_mes_ant=$tot_mes_ant+$totalmesant;
												}
											} ?></div></td>
												    <td class="Estilo11"><div align="center">
												      <?php   
		
	$sql_calc="select count (*) as calc1 from matricula where id_ano=".$id_anio." and fecha>='".$cmb_ano."-".$mes."-1' and fecha<='".$cmb_ano."-".$mes."-".$fin_dia."'";
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				echo $calc_1=$fila_calc_1['calc1'];
				
				$tot_alt=$tot_alt+$calc_1;
				} 
				
				
		
	 
	?>
												    </div></td>
												    <td class="Estilo11"><div align="center"><?php   
		
	$sql_calc="select count (*) as calc1 from matricula where id_ano=".$id_anio." and fecha_retiro>='".$cmb_ano."-".$mes."-1' and fecha_retiro<='".$cmb_ano."-".$mes."-".$fin_dia."'";
			$res_calc=pg_exec($conn,$sql_calc);
				for($b=0;$b<pg_numrows($res_calc);$b++)
				{
				$fila_calc_1 = pg_fetch_array($res_calc,$b);
				echo $bajas=$fila_calc_1['calc1'];
				
				$bajas_total=$bajas_total+$bajas;
				} 
				
				
		
	 
	?></div></td>
												    <td class="Estilo11"><div align="center"><?php    $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($id_anio) and fecha<='$cmb_ano-$mes-$fin_dia' and ID_CURSO>0 ) and rut_alumno not in (select rut_alumno from matricula where id_ano = ($id_anio) and fecha_retiro <= '$cmb_ano-$mes-$fin_dia' ) ";
													  
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
																									
													echo $totalmes2 = $fila2['suma2'];
													$tot_ens_mes2=$tot_ens_mes2+$totalmes2;
													
												}
											} ?></div></td>
												    </tr>
													<?php }?>
												  <tr>
												    <td class="Estilo4">Total</td>
												    <td class="Estilo11"><div align="center"><?php echo $tot_ens_mes ?></div></td>
												    <td class="Estilo11"><div align="center"><?php 
													if ($mes==3)
													echo "0";
													else
													echo $tot_mes_ant ?></div></td>
												    <td class="Estilo11"><div align="center"><?php echo $tot_alt ?></div></td>
												    <td class="Estilo11"><div align="center"><?php echo $bajas_total ?></div></td>
												    <td class="Estilo11"><div align="center"><?php echo $tot_ens_mes2 ?></div></td>
											      </tr>
												  <?php
												  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													   $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													   $query_mat="select count(rut_alumno) as abril from matricula where id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and bool_ar<>1 and fecha > '$cmb_ano-04-30'";
                                                       $filsMatriculados=@pg_fetch_array(pg_exec($conn,$query_mat));
													   
													   $abril = $filsMatriculados['abril'];
													   ?>
													   <?
													   $total_abril = $total_abril + $abril;
												  }
												  ?>
												</table></td>
											  </tr>
											</table>
										    <table width="600" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><a href="print_mat_mes_corp.php?pesta=1&op=1&cmb_ano=<?=$cmb_ano ?>&mes=<?php echo $mes ?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"  ></a></td>
                                              </tr>
                                            </table>
									      <? } ?>
										  
										  
										  
										  
									   <?
										if ($pesta==1 and $op==7 and $cmb_ano!=0 and $rut_alumno!=NULL){
										    //// consulta que trae casi todos la información
										 	$sql_1 = "select institucion.nombre_instit, curso.ensenanza, curso.grado_curso, curso.letra_curso, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, alumno.rut_alumno, alumno.dig_rut, alumno.fecha_nac, alumno.sexo, alumno.telefono, alumno.email, matricula.fecha, matricula.num_mat, alumno.calle, alumno.nro, alumno.depto, alumno.block, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((((((((matricula inner join ano_escolar on matricula.id_ano = ano_escolar.id_ano) inner join alumno on matricula.rut_alumno = alumno.rut_alumno and matricula.rut_alumno = '$rut_alumno')   inner join curso on curso.id_curso = matricula.id_curso) inner join supervisa on curso.id_curso = supervisa.id_curso) inner join empleado on supervisa.rut_emp = empleado.rut_emp)  inner join institucion on matricula.rdb = institucion.rdb) inner join region on alumno.region = region.cod_reg) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on provincia.cor_pro = comuna.cor_pro  where ano_escolar.id_institucion = '$rdb' and ano_escolar.nro_ano = '$cmb_ano' and provincia.cor_pro = alumno.ciudad and comuna.cor_com = alumno.comuna and comuna.cod_reg = alumno.region";
											$res_1 = pg_Exec($conn,$sql_1);
											$fil_1 = pg_fetch_array($res_1);
											
																						
											$nombre_instit    = $fil_1[0];
											$ensenanza        = $fil_1[1];
											$grado_curso      = $fil_1[2];
											$letra_curso      = $fil_1[3];
											$nombre_emp       = $fil_1[4];
											$ape_pat_emp      = $fil_1[5];
											$ape_mat_emp      = $fil_1[6];
											$nombre_alu       = $fil_1[7];
											$ape_pat_alu      = $fil_1[8];
											$ape_mat_alu      = $fil_1[9];
											$rut_alumno       = $fil_1[10];
											$dig_alumno       = $fil_1[11];
											$fecha_nac        = $fil_1[12];
											$sexo_alu         = $fil_1[13];
											$fono_alu         = $fil_1[14];
											$email_alu        = $fil_1[15];
											$fecha_mat        = $fil_1[16];
											$num_mat          = $fil_1[17];
											$calle_alu        = $fil_1[18];
											$nro_alu          = $fil_1[19];
											$depto_alu        = $fil_1[20];
											$block_alu        = $fil_1[21];
											$region_alu       = $fil_1[22];
											$ciudad_alu       = $fil_1[23];
											$comuna_alu       = $fil_1[24];
											
											
											if ($ensenanza==10){
											    $ensenanza = "Parvularia";
											}
											if ($ensenanza==110){
											    $ensenaza = "Básica";
											}
											if ($ensenanza==310){
											    $ensenanza = "Media";
											}
											$dd = substr($fecha_nac,8,2);
											$mm = substr($fecha_nac,5,2);
											$aa = substr($fecha_nac,0,4);
											
											$fecha_nac = "$dd-$mm-$aa";
											
											if ($sexo_alu==2){
											    $sexo_alu = "Masculino";
											}
											if ($sexo_alu==1){
											   $sexo_alu = "Femenino";
											}    				
										    $dd = substr($fecha_mat,8,2);
											$mm = substr($fecha_mat,5,2);
											$aa = substr($fecha_mat,0,4);
											
											$fecha_mat = "$dd-$mm-$aa";
										    ?>										
											<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                  <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td width="20%" class="Estilo4">Establecimiento</td>
                                                        <td class="Estilo8"><?=$nombre_instit ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="Estilo4">A&ntilde;o escolar </td>
                                                        <td class="Estilo8"><?=$cmb_ano ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="Estilo4">Curso</td>
                                                        <td class="Estilo8"><? echo "$grado_curso-$letra_curso Ensenanza $ensenanza"; ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td class="Estilo4">Profesor Jefe </td>
                                                        <td class="Estilo8"><? echo "$nombre_emp $ape_pat_emp $ape_mat_emp"; ?></td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="2"><div align="center"><b>FICHA DE MATRICULA</b> </div></td>
                                                      </tr>
                                                      <tr>
                                                        <td colspan="2"><hr></td>
                                                      </tr>
                                                    </table></td>
                                                  </tr>
                                                  <tr>
                                                    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td class="Estilo4">I. Informaci&oacute;n del alumno <br>
                                                          <br>
                                                          <br></td>
                                                        <td width="150" rowspan="2" valign="top">
														<div align="center">
                                                          <table width="100%" height="160" border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                              <td><div align="center"><img src="../../infousuario/images/<?=trim($rut_alumno)  ?>" width="110" height="130"></div></td>
                                                            </tr>
                                                          </table>
                                                        </div>														</td>
                                                      </tr>
                                                      <tr>
                                                        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                          <tr>
                                                            <td colspan="2" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                            </tr>
                                                          <tr>
                                                            <td colspan="2" class="Estilo8"><? echo "$nombre_alu $ape_pat_alu $ape_mat_alu"; ?></td>
                                                            </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><? echo "$rut_alumno-$dig_alumno"; ?></td>
                                                            <td class="Estilo8"><?=$fecha_nac ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Sexo</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$sexo_alu ?></td>
                                                            <td class="Estilo8"><?=$fono_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td colspan="2" bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                            </tr>
                                                          <tr>
                                                            <td colspan="2" class="Estilo8"><?=$email_alu ?></td>
                                                            </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Fecha Matr&iacute;cula </td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Nro. Matricula </td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$fecha_mat ?></td>
                                                            <td class="Estilo8"><?=$num_mat ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Nro</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$calle_alu ?></td>
                                                            <td class="Estilo8"><?=$nro_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Block</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Dpto.</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$block_alu ?></td>
                                                            <td class="Estilo8"><?=$depto_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$region_alu ?></td>
                                                            <td class="Estilo8"><?=$ciudad_alu ?></td>
                                                          </tr>
                                                          <tr>
                                                            <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                            <td class="Estilo4">.</td>
                                                          </tr>
                                                          <tr>
                                                            <td class="Estilo8"><?=$comuna_alu ?></td>
                                                            <td class="Estilo8">&nbsp;</td>
                                                          </tr>
                                                          
                                                        </table></td>
                                                      </tr>
                                                    </table>
                                                      <br>
                                                      <br>
													  <?
													  ////////// tomamos la informacion del apodera responsable //////
												      $sql_2 = "select apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.rut_apo, apoderado.dig_rut, apoderado.fecha_nac, apoderado.telefono, apoderado.relacion, apoderado.email, apoderado.nivel_edu, apoderado.calle, apoderado.nro, apoderado.villa, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((apoderado inner join region on region.cod_reg = apoderado.region) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on comuna.cor_pro = provincia.cor_pro where apoderado.rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' and responsable = '1') and provincia.cor_pro = apoderado.ciudad and comuna.cor_com = apoderado.comuna and region.cod_reg = comuna.cod_reg"; 
													  $res_2 = pg_Exec($conn,$sql_2);
													  $num_2 = pg_numrows($res_2);
													  
													  if ($num_2 > 0){
													      $fil_2 = pg_fetch_array($res_2,0);
														  $nombre_apo   = $fil_2['nombre_apo'];
														  $ape_pat_apo  = $fil_2['ape_pat'];
														  $ape_mat_apo  = $fil_2['ape_mat'];
														  $rut_apo      = $fil_2['rut_apo'];
														  $dig_rut      = $fil_2['dig_rut'];
														  $fecha_nac    = $fil_2['fecha_nac'];
														  $fono_apo     = $fil_2['telefono'];
														  $relacion     = $fil_2['relacion'];
														  $email        = $fil_2['email'];
														  $nivel_edu    = $fil_2['nivel_edu'];
														  $calle        = $fil_2['calle'];
														  $nro          = $fil_2['nro'];
														  $villa        = $fil_2['villa'];
														  $region       = $fil_2['nom_reg'];
														  $ciudad       = $fil_2['nom_pro'];
														  $comuna       = $fil_2['nom_com'];
														  
														  $dd = substr($fecha_nac,8,2);
														  $mm = substr($fecha_nac,5,2);
														  $aa = substr($fecha_nac,0,4);
														  
														  $fecha_nac = "$dd-$mm-$aa";
														  
														  if ($relacion == 2){
														      $relacion = "Madre";
														  }
														  if ($relacion == 1){
														     $relacion = "Padre";
														  }	 	  
													  }else{
													      $nombre_apo   = "&nbsp;";
														  $ape_pat_apo  = "&nbsp;";
														  $ape_mat_apo  = "&nbsp;";
														  $rut_apo      = "&nbsp;";
														  $dig_rut      = "&nbsp;";
														  $fecha_nac    = "&nbsp;";
														  $fono_apo     = "&nbsp;";
														  $relacion     = "&nbsp;";
														  $email        = "&nbsp;";
														  $nivel_edu    = "&nbsp;";
														  $calle        = "&nbsp;";
														  $nro          = "&nbsp;";
														  $villa        = "&nbsp;";
														  $region       = "&nbsp;";
														  $ciudad       = "&nbsp;";
														  $comuna       = "&nbsp;";
													  }	  
													  
													  ?>
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td class="Estilo4">II. Informaci&oacute;n del Apoderado  <br>
                                                              <br></td>
                                                        </tr>
                                                        <tr>
                                                          <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                            <tr>
                                                              <td colspan="3" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                            </tr>
                                                            <tr>
                                                              <td colspan="3" class="Estilo8"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><? echo "$rut_apo-$dig_rut"; ?></td>
                                                              <td class="Estilo8"><?=$fecha_nac ?></td>
                                                              <td class="Estilo8"><?=$fono_apo ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Relaci&oacute;n</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Nivel Educacional</td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><?=$relacion ?></td>
                                                              <td class="Estilo8"><?=$email ?></td>
                                                              <td class="Estilo8"><?=$nivel_edu ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Nro.</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Villa / Poblaci&oacute;n </td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><?=$calle ?></td>
                                                              <td class="Estilo8"><?=$nro ?></td>
                                                              <td class="Estilo8"><?=$villa ?></td>
                                                            </tr>
                                                            <tr>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                              <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                            </tr>
                                                            <tr>
                                                              <td class="Estilo8"><?=$region ?></td>
                                                              <td class="Estilo8"><?=$ciudad ?></td>
                                                              <td class="Estilo8"><?=$comuna ?></td>
                                                            </tr>
                                                            
                                                            
                                                            
                                                          </table></td>
                                                        </tr>
                                                      </table>
                                                      <br>
                                                      <br>
													  <?
													  ////////// tomamos la informacion del la MADRE //////
												      $sql_2 = "select apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.rut_apo, apoderado.dig_rut, apoderado.fecha_nac, apoderado.telefono, apoderado.relacion, apoderado.email, apoderado.nivel_edu, apoderado.calle, apoderado.nro, apoderado.villa, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((apoderado inner join region on region.cod_reg = apoderado.region) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on comuna.cor_pro = provincia.cor_pro where apoderado.rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' ) and provincia.cor_pro = apoderado.ciudad and comuna.cor_com = apoderado.comuna and region.cod_reg = comuna.cod_reg and apoderado.relacion = '2'"; 
													  $res_2 = pg_Exec($conn,$sql_2);
													  $num_2 = pg_numrows($res_2);
													  
													  if ($num_2 > 0){
													      $fil_2 = pg_fetch_array($res_2,0);
														  $nombre_apo   = $fil_2['nombre_apo'];
														  $ape_pat_apo  = $fil_2['ape_pat'];
														  $ape_mat_apo  = $fil_2['ape_mat'];
														  $rut_apo      = $fil_2['rut_apo'];
														  $dig_rut      = $fil_2['dig_rut'];
														  $fecha_nac    = $fil_2['fecha_nac'];
														  $fono_apo     = $fil_2['telefono'];
														  $relacion     = $fil_2['relacion'];
														  $email        = $fil_2['email'];
														  $nivel_edu    = $fil_2['nivel_edu'];
														  $calle        = $fil_2['calle'];
														  $nro          = $fil_2['nro'];
														  $villa        = $fil_2['villa'];
														  $region       = $fil_2['nom_reg'];
														  $ciudad       = $fil_2['nom_pro'];
														  $comuna       = $fil_2['nom_com'];
														  
														  $dd = substr($fecha_nac,8,2);
														  $mm = substr($fecha_nac,5,2);
														  $aa = substr($fecha_nac,0,4);
														  
														  $fecha_nac = "$dd-$mm-$aa";
														  
														  if ($relacion == 2){
														      $relacion = "Madre";
														  }
														  if ($relacion == 1){
														     $relacion = "Padre";
														  }	 	  
													  }else{
													      $nombre_apo   = "&nbsp;";
														  $ape_pat_apo  = "&nbsp;";
														  $ape_mat_apo  = "&nbsp;";
														  $rut_apo      = "&nbsp;";
														  $dig_rut      = "&nbsp;";
														  $fecha_nac    = "&nbsp;";
														  $fono_apo     = "&nbsp;";
														  $relacion     = "&nbsp;";
														  $email        = "&nbsp;";
														  $nivel_edu    = "&nbsp;";
														  $calle        = "&nbsp;";
														  $nro          = "&nbsp;";
														  $villa        = "&nbsp;";
														  $region       = "&nbsp;";
														  $ciudad       = "&nbsp;";
														  $comuna       = "&nbsp;";
													  }	  
													  
													  ?>
                                                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                          <td class="Estilo4">III. Informaci&oacute;n de la Madre <br>
                                                              <br></td>
                                                        </tr>
                                                        <tr>
                                                          <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                              <tr>
                                                                <td colspan="3" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" class="Estilo8"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><? echo "$rut_apo-$dig_apo"; ?></td>
                                                                <td class="Estilo8"><?=$fecha_nac ?></td>
                                                                <td class="Estilo8"><?=$fono_apo ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Relaci&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nivel Educacional</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$relacion ?></td>
                                                                <td class="Estilo8"><?=$email ?></td>
                                                                <td class="Estilo8"><?=$nivel_edu ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nro.</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Villa / Poblaci&oacute;n </td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$calle ?></td>
                                                                <td class="Estilo8"><?=$nro ?></td>
                                                                <td class="Estilo8"><?=$villa ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$region ?></td>
                                                                <td class="Estilo8"><?=$ciudad ?></td>
                                                                <td class="Estilo8"><?=$comuna ?></td>
                                                              </tr>
                                                          </table></td>
                                                        </tr>
                                                      </table>
                                                      <br>
                                                    <br>
													<?
													  ////////// tomamos la informacion del la PADRE //////
												      $sql_2 = "select apoderado.nombre_apo, apoderado.ape_pat, apoderado.ape_mat, apoderado.rut_apo, apoderado.dig_rut, apoderado.fecha_nac, apoderado.telefono, apoderado.relacion, apoderado.email, apoderado.nivel_edu, apoderado.calle, apoderado.nro, apoderado.villa, region.nom_reg, provincia.nom_pro, comuna.nom_com from ((apoderado inner join region on region.cod_reg = apoderado.region) inner join provincia on region.cod_reg = provincia.cod_reg) inner join comuna on comuna.cor_pro = provincia.cor_pro where apoderado.rut_apo in (select rut_apo from tiene2 where rut_alumno = '$rut_alumno' ) and provincia.cor_pro = apoderado.ciudad and comuna.cor_com = apoderado.comuna and region.cod_reg = comuna.cod_reg and apoderado.relacion = '1'"; 
													  $res_2 = pg_Exec($conn,$sql_2);
													  $num_2 = pg_numrows($res_2);
													  
													  if ($num_2 > 0){
													      $fil_2 = pg_fetch_array($res_2,0);
														  $nombre_apo   = $fil_2['nombre_apo'];
														  $ape_pat_apo  = $fil_2['ape_pat'];
														  $ape_mat_apo  = $fil_2['ape_mat'];
														  $rut_apo      = $fil_2['rut_apo'];
														  $dig_rut      = $fil_2['dig_rut'];
														  $fecha_nac    = $fil_2['fecha_nac'];
														  $fono_apo     = $fil_2['telefono'];
														  $relacion     = $fil_2['relacion'];
														  $email        = $fil_2['email'];
														  $nivel_edu    = $fil_2['nivel_edu'];
														  $calle        = $fil_2['calle'];
														  $nro          = $fil_2['nro'];
														  $villa        = $fil_2['villa'];
														  $region       = $fil_2['nom_reg'];
														  $ciudad       = $fil_2['nom_pro'];
														  $comuna       = $fil_2['nom_com'];
														  
														  $dd = substr($fecha_nac,8,2);
														  $mm = substr($fecha_nac,5,2);
														  $aa = substr($fecha_nac,0,4);
														  
														  $fecha_nac = "$dd-$mm-$aa";
														  
														  if ($relacion == 2){
														      $relacion = "Madre";
														  }
														  if ($relacion == 1){
														     $relacion = "Padre";
														  }	 	  
													  }else{
													      $nombre_apo   = "&nbsp;";
														  $ape_pat_apo  = "&nbsp;";
														  $ape_mat_apo  = "&nbsp;";
														  $rut_apo      = "&nbsp;";
														  $dig_rut      = "&nbsp;";
														  $fecha_nac    = "&nbsp;";
														  $fono_apo     = "&nbsp;";
														  $relacion     = "&nbsp;";
														  $email        = "&nbsp;";
														  $nivel_edu    = "&nbsp;";
														  $calle        = "&nbsp;";
														  $nro          = "&nbsp;";
														  $villa        = "&nbsp;";
														  $region       = "&nbsp;";
														  $ciudad       = "&nbsp;";
														  $comuna       = "&nbsp;";
													  }  	  
													  
													  ?>
                                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                      <tr>
                                                        <td class="Estilo4">IV. Informaci&oacute;n del Padre <br>
                                                            <br></td>
                                                      </tr>
                                                      <tr>
                                                        <td><table width="100%" border="0" cellspacing="1" cellpadding="3">
                                                              <tr>
                                                                <td colspan="3" bgcolor="#E2E2E2" class="Estilo4">Nombre</td>
                                                              </tr>
                                                              <tr>
                                                                <td colspan="3" class="Estilo8"><? echo "$nombre_apo $ape_pat_apo $ape_mat_apo"; ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Rut</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fecha de Nacimiento </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Fono</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><? echo "$rut_apo-$dig_apo"; ?></td>
                                                                <td class="Estilo8"><?=$fecha_nac ?></td>
                                                                <td class="Estilo8"><?=$fono_apo ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Relaci&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">E-mail</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nivel Educacional</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$relacion ?></td>
                                                                <td class="Estilo8"><?=$email ?></td>
                                                                <td class="Estilo8"><?=$nivel_edu ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Direcci&oacute;n, calle </td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Nro.</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Villa / Poblaci&oacute;n </td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$calle ?></td>
                                                                <td class="Estilo8"><?=$nro ?></td>
                                                                <td class="Estilo8"><?=$villa ?></td>
                                                              </tr>
                                                              <tr>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Regi&oacute;n</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Ciudad</td>
                                                                <td bgcolor="#E2E2E2" class="Estilo4">Comuna</td>
                                                              </tr>
                                                              <tr>
                                                                <td class="Estilo8"><?=$region ?></td>
                                                                <td class="Estilo8"><?=$ciudad ?></td>
                                                                <td class="Estilo8"><?=$comuna ?></td>
                                                              </tr>
                                                          </table></td>
                                                      </tr>
                                                    </table></td>
                                                  </tr>
                                                  
                                                  
                                                </table></td>
											  </tr>
										  </table>
										    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=7&cmb_ano=<?=$cmb_ano ?>&txt=<?=$txt ?>&cmb_inst=<?=$cmb_inst ?>&pesta=1"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                          </table>
									      <? } ?>	  
										  
										  <?
										if ($pesta==1 and $op==7 and $cmb_ano!=0 and $rut_alumno==NULL){ ?>
											<table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
												  <tr>
												   <td>
												   
												       <form name="form2" method="post" action="reportesCorporativos.php?pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>">
													   <div align="center" class="Estilo8">
													     <input name="cmb_ano" type="hidden" id="cmb_ano" value="<?=$cmb_ano ?>">
													     B&uacute;squeda de alumnos 
													   <label>
													   <input name="txt" type="text" id="txt" value="<?=$txt ?>" size="20">
													   </label>
													   <label>
													   &nbsp;Establecimiento
													   <select name="cmb_inst" onChange="enviapag3(this.form);">
													    
                                                         <option value="0" selected="selected">Buscar en todos</option>
														  <?
														  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												          $result_ins=@pg_Exec($conn,$qry_ins);
												          for($i=0;$i<pg_numrows($result_ins);$i++){	
													          $fila_ins = pg_fetch_array($result_ins,$i);
													          $rdb = $fila_ins['rdb'];
													          $establecimiento = $fila_ins['nombre_instit']; 
															  ?>
													          <option value="<?=$rdb ?>" <? if ($rdb==$cmb_inst){ ?> selected="selected" <? } ?> ><?=$establecimiento ?></option>
															  <?
														  }
														  ?>
													   </select>
													     &nbsp; <input name="buscar" type="image" src="images/lupa.gif" align="bottom" width="21" height="20">
													   </label>
													    <label></label>
													    <br>
													   <span class="Estilo10">Criterios de b&uacute;squeda<br> 
													   (Rut sin d&iacute;gito verificador, nombre, apellido paterno, apellido materno del alumno)</span> </div>
													   </form>											       </td>
												  </tr> 
												  
                                                  <tr>
                                                    <td><div align="center">Alumnos encontrados para texto <b>&quot;<?=$txt ?>&quot;</b> </div></td>
                                                  </tr>
                                                  <tr>
                                                    <td>
													<?
													if (strlen($txt) > 2){ ?>
													
													<table width="100%" border="0" cellspacing="0" cellpadding="2">
														 <tr>
														 <td width="30%" height="22" bgcolor="#CCCCCC" class="Estilo4">Establecimiento</td>
														 <td width="15%" bgcolor="#CCCCCC" class="Estilo4">Rut Alumno </td>
														 <td width="40%" bgcolor="#CCCCCC" class="Estilo4">Nombre</td>
														 <td width="15%" bgcolor="#CCCCCC" class="Estilo4">Curso</td>
														 </tr>
													<?
													///// consulta de busqueda de alumno en la coooorporacion  ////
													$txt2 = $txt;
													$txt=strtoupper($txt);
													$qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
												    $result_ins=@pg_Exec($conn,$qry_ins);
												    for($i=0;$i<pg_numrows($result_ins);$i++){	
													    $fila_ins = pg_fetch_array($result_ins,$i);
													    $rdb = $fila_ins['rdb'];
													    $establecimiento = $fila_ins['nombre_instit'];
													   
													    $query_mat="select matricula.id_curso, matricula.rut_alumno, matricula.id_ano, alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, curso.ensenanza, curso.grado_curso, curso.letra_curso from (matricula inner join alumno on matricula.rut_alumno = alumno.rut_alumno) inner join curso on matricula.id_curso = curso.id_curso where matricula.id_ano in (select id_ano from ano_escolar where nro_ano = '$cmb_ano' and id_institucion = '$rdb') and (alumno.rut_alumno like '%$txt%' or alumno.nombre_alu like '%$txt%' or alumno.ape_pat like '%$txt%' or alumno.ape_mat like '%$txt%' or alumno.rut_alumno like '%$txt2%' or alumno.nombre_alu like '%$txt2%' or alumno.ape_pat like '%$txt2%' or alumno.ape_mat like '%$txt2%')  order by curso.ensenanza, curso.grado_curso, curso.letra_curso";
                                                        $res_mat  = @pg_Exec($conn,$query_mat);
														$num_mat  = @pg_numrows($res_mat);
														
														for ($j=0; $j < $num_mat; $j++){
														    $fil_mat = @pg_fetch_array($res_mat,$j);
														    $rut_alumno = $fil_mat['rut_alumno'];
															$dig        = $fil_mat['dig_rut'];
															$nombre_alu = $fil_mat['nombre_alu'];
															$ape_pat    = $fil_mat['ape_pat'];
															$ape_mat    = $fil_mat['ape_mat'];
															$ensenanza  = $fil_mat['ensenanza'];
															$grado_curso= $fil_mat['grado_curso'];
															$letra_curso= $fil_mat['letra_curso'];
														    if ($ensenanza==10){
															   $ensenanza = "Ed. Parvularia";
															}
															if ($ensenanza==110){
															   $ensenanza = "Ed. Básica";
															}
															if ($ensenanza > 300){
															   $ensenanza = "Ed. Media";
															}         
														
														    if ($cmb_inst=="0"){ ?>
															     <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' onClick=go('reportesCorporativos.php?rut_alumno=<?=$rut_alumno ?>&pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>&rdb=<?=$rdb ?>&txt=<?=$txt ?>&cmb_inst=<?=$cmb_inst ?>')>
															     <td width="30%" class="Estilo8"><?=$establecimiento ?></td>
															     <td width="15%" class="Estilo8"><? echo "$rut_alumno-$dig"; ?></td>
															     <td width="40%" class="Estilo8"><? echo "$ape_pat $ape_mat $nombre_alu"; ?></td>
															     <td width="15%" class="Estilo8"><? echo "$letra_curso-$grado_curso $ensenanza"; ?></td>
															     </tr> <?															
															}else{															
															     if ($cmb_inst==$rdb){  ?>													
																	 <tr bgcolor=#ffffff onMouseOver=this.style.background='yellow';this.style.cursor='hand' onMouseOut=this.style.background='ffffff' onClick=go('reportesCorporativos.php?rut_alumno=<?=$rut_alumno ?>&pesta=1&op=7&cmb_ano=<?=$cmb_ano ?>&rdb=<?=$rdb ?>&txt=<?=$txt ?>&cmb_inst=<?=$cmb_inst ?>')>
															         <td width="30%" class="Estilo8"><?=$establecimiento ?></td>
															         <td width="15%" class="Estilo8"><? echo "$rut_alumno-$dig"; ?></td>
															         <td width="40%" class="Estilo8"><? echo "$ape_pat $ape_mat $nombre_alu"; ?></td>
															         <td width="15%" class="Estilo8"><? echo "$letra_curso-$grado_curso $ensenanza"; ?></td>
															         </tr>
															  <? } 
															}  		 
																														
													    }
												   }
												   ?>	
												      </table>	
												  <? } ?>												   </td>
                                                  </tr>
                                                </table></td>
											  </tr>
										  </table>
										    <table width="100%" border="0" align="center" cellpadding="5" cellspacing="0">
                                              <tr>
                                                <td width="50%"><div align="right"><a href="reportesCorporativos.php?op=&cmb_ano=<?=$cmb_ano ?>"><img src="images/volver.gif" width="60" height="14" border="0"></a></div></td>
                                                <td width="50%"><img src="images/imprimir_reporte.gif" width="118" height="14"></td>
                                              </tr>
                                          </table>
									      <? } ?>										</td>
									</tr>
								   </table>								 </td>
							 </tr>
							</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="asistencia">
                               <td valign="top"><br>
                                 <br>
								  <form method="post" name="form" action="reportesCorporativos.php">
									<input name="pesta" type="hidden" value="2">
									<? if($opc==""){?>
                                 <table width="80%" border="0" align="center" cellpadding="3" cellspacing="0">
                                   <tr>
                                     <td>&nbsp;</td>
                                     <td colspan="4" class="Estilo8"><div align="center" class="Estilo1">Informe de Asistencia </div></td>
                                   </tr>
                                   <tr>
                                     <td>&nbsp;</td>
                                     <td colspan="4" class="Estilo8">&nbsp;</td>
                                   </tr>
                                   <tr>
                                     <td width="1%"><input name="opc" type="radio" value="1" onClick="visible(this.id,this.form)" id="opc"></td>
                                     <td class="Estilo8">Informe Mensual por Establecimiento </td>
                                     
                                       
                                           <td class="Estilo8">
										   <div id="combo1" style="visibility:hidden">
										   <select name="cmbMES1">
                                               <option value="0">seleccione mes</option>
                                               <option value="3">MARZO</option>
                                               <option value="4">ABRIL</option>
                                               <option value="5">MAYO</option>
                                               <option value="6">JUNIO</option>
                                               <option value="7">JULIO</option>
                                               <option value="8">AGOSTO</option>
                                               <option value="9">SEPTIEMBRE</option>
                                               <option value="10">OCTUBRE</option>
                                               <option value="11">NOVIEMBRE</option>
                                               <option value="12">DICIEMBRE</option>
                                             </select>
											 </div>										  </td>
											
											 <td class="Estilo8">
											 <div id="combo11" style="visibility:hidden">
											 <select name="cmbANO1">
                                               <option value="0">seleccione a&ntilde;o</option>
                                               <option value="2008">2008</option>
                                               <option value="2007">2007</option>
                                               <option value="2006">2006</option>
                                               <option value="2005">2005</option>
                                               <option value="2004">2004</option>
                                             </select>
											 </div>											 </td>
											 <td colspan="2" class="Estilo8">&nbsp;</td>
                                   </tr>
                                   <tr>
                                     <td><input name="opc" type="radio" value="2" id="opc2" onClick="visible(this.id,this.form)" ></td>
                                     <td class="Estilo8">Informe Mensual por Ciclos  </td>
                                     
                                       <td class="Estilo8">
									   <div id="combo21" style="visibility:hidden">
									   <select name="cmbMES2">
                                           <option value="0">seleccione mes</option>
                                           <option value="3">MARZO</option>
                                           <option value="4">ABRIL</option>
                                           <option value="5">MAYO</option>
                                           <option value="6">JUNIO</option>
                                           <option value="7">JULIO</option>
                                           <option value="8">AGOSTO</option>
                                           <option value="9">SEPTIEMBRE</option>
                                           <option value="10">OCTUBRE</option>
                                           <option value="11">NOVIEMBRE</option>
                                           <option value="12">DICIEMBRE</option>
                                       </select>
									   </div>									   </td>
                                       <td class="Estilo8">
									   <div id="combo22" style="visibility:hidden">
									   <select name="cmbANO2">
                                           <option value="0">seleccione a&ntilde;o</option>
                                           <option value="2008">2008</option>
                                           <option value="2007">2007</option>
                                           <option value="2006">2006</option>
                                           <option value="2005">2005</option>
                                           <option value="2004">2004</option>
                                       </select>
									   </div>									   </td>
                                       <td class="Estilo8">&nbsp;</td>
                                     </div>
                                   </tr>
                                   <tr>
                                     <td width="1%"><input name="opc" type="radio" value="3" id="opc3" onClick="visible(this.id,this.form)"></td>
                                     <td class="Estilo8">informe Mensual por Niveles </td>
                                     
                                       <td class="Estilo8">
									   <div id="combo31" style="visibility:hidden">
									   <select name="cmbMES31">
                                           <option value="0">seleccione mes</option>
                                           <option value="3">MARZO</option>
                                           <option value="4">ABRIL</option>
                                           <option value="5">MAYO</option>
                                           <option value="6">JUNIO</option>
                                           <option value="7">JULIO</option>
                                           <option value="8">AGOSTO</option>
                                           <option value="9">SEPTIEMBRE</option>
                                           <option value="10">OCTUBRE</option>
                                           <option value="11">NOVIEMBRE</option>
                                           <option value="12">DICIEMBRE</option>
                                       </select>
									   </div>									   </td>
                                       <td class="Estilo8">
									   <div id="combo32" style="visibility:hidden">
									   <select name="cmbANO3">
                                           <option value="0">seleccione a&ntilde;o</option>
                                           <option value="2008">2008</option>
                                           <option value="2007">2007</option>
                                           <option value="2006">2006</option>
                                           <option value="2005">2005</option>
                                           <option value="2004">2004</option>
                                       </select>
									   </div>									   </td>
                                       <td class="Estilo8"><? 	$sql ="	SELECT id_nivel, nombre FROM NIVELES ";
												$rs_nivel = @pg_exec($conn,$sql);
											?>
											<div id="combo33" style="visibility:hidden">
                                           <select name="cmbNIVEL"	>
                                             <option value="0">seleccione</option>
                                             <? for($x=0;$x<@pg_numrows($rs_nivel);$x++){
												$fila_nivel = @pg_fetch_array($rs_nivel,$x);
											?>
                                             <option value="<?=$fila_nivel['id_nivel'];?>">
                                               <?=$fila_nivel['nombre'];?>
                                              </option>
                                             <? } ?>
                                         </select>
										 </div>										 </td>
                                     </div>
                                   </tr>
                                   <tr>
                                     <td width="1%"><input name="opc" type="radio" value="4" id="opc4" onClick="visible(this.id,this.form)"></td>
                                     <td class="Estilo8">Informe Anual por Establecimiento </td>
                                       <td class="Estilo8">
									   <div id="combo4" style="visibility:hidden">
									   <select name="cmbANO4">
                                           <option value="0">seleccione a&ntilde;o</option>
                                           <option value="2008">2008</option>
                                           <option value="2007">2007</option>
                                           <option value="2006">2006</option>
                                           <option value="2005">2005</option>
                                           <option value="2004">2004</option>
                                       </select>
									   </div>									   </td>
                                       <td class="Estilo8">&nbsp;</td>
                                       <td class="Estilo8">&nbsp;</td>
                                     </div>
                                   </tr>
                                   <tr>
                                     <td width="1%"><input name="opc" type="radio" value="5" id="opc5" onClick="visible(this.id,this.form)"></td>
                                     <td class="Estilo8">Informe Anual por Ciclos </td>
                                     
                                       <td class="Estilo8">
									   <div id="combo51" style="visibility:hidden">
									   <select name="cmbANO5">
                                           <option value="0">seleccione a&ntilde;o</option>
                                           <option value="2008">2008</option>
                                           <option value="2007">2007</option>
                                           <option value="2006">2006</option>
                                           <option value="2005">2005</option>
                                           <option value="2004">2004</option>
                                       </select>
									   </div>									   </td>
                                       <td class="Estilo8">&nbsp;</td>
                                       <td class="Estilo8">&nbsp;</td>
                                     </div>
                                   </tr>
                                   <tr>
                                     <td width="1%"><input name="opc" type="radio" value="6" id="opc6" onClick="visible(this.id,this.form)"></td>
                                     <td class="Estilo8">Informe Anual por Niveles </td>
                                     
                                       <td class="Estilo8">
									   <div id="combo61" style="visibility:hidden">
									     <select name="cmbANO6">
                                           <option value="0">seleccione a&ntilde;o</option>
                                           <option value="2008">2008</option>
                                           <option value="2007">2007</option>
                                           <option value="2006">2006</option>
                                           <option value="2005">2005</option>
                                           <option value="2004">2004</option>
                                         </select>
									   </div>									   </td>
                                       <td class="Estilo8">
									   <? 	$sql ="	SELECT id_nivel, nombre FROM NIVELES ";
											$rs_nivel = @pg_exec($conn,$sql);
										?>
											<div id="combo62" style="visibility:hidden">
                                           <select name="cmbNIVEL2"	>
                                             <option value="0">seleccione</option>
                                             <? for($x=0;$x<@pg_numrows($rs_nivel);$x++){
												$fila_nivel = @pg_fetch_array($rs_nivel,$x);
											?>
                                             <option value="<?=$fila_nivel['id_nivel'];?>">
                                               <?=$fila_nivel['nombre'];?>
                                              </option>
                                             <? } ?>
                                           </select>
										   </div>										  </td>
                                       <td class="Estilo8"><input name="buscar" type="submit" id="buscar" value="BUSCAR" class="botonXX"></td>
                                     </div>
                                   </tr>
                                   <tr>
                                     <td colspan="5" valign="middle"><div align="center" class="Estilo25">Modulo en Construccion </div></td>
                                   </tr>
                                 </table>
								 <? } ?>
								 </form>
								 <? if($opc==1 AND $pesta==2){ ?>
								  		<table width="100%" border="1" cellpadding="3" cellspacing="0">
										  <tr>
											<td colspan="34"><div align="center"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">TOTAL ASISTENCIA MENSUAL DE TODOS LOS ESTABLECIMIENTOS </font></div></td>
										  </tr>
										  <tr>
										    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">MES</font></td>
											<td colspan="32"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><? echo envia_mes($cmbMES1);?></font></td>
										    <td>&nbsp;</td>
									      </tr>
										  <tr>
										    <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">A&Ntilde;O</font></td>
											<td colspan="32"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$cmbANO1?></font></td>
										    <td>&nbsp;</td>
									      </tr>
										  <tr>
											<td colspan="34">&nbsp;</td>
										  </tr>
										  <tr>
											<td rowspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Establecimientos</font></td>
											<td rowspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Matricula</font></td>
											<td colspan="31"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Dias</font></td>
											<td rowspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Total</font></td>
										  </tr>
										  <tr>
											<? for($x=1;$x<32;$x++){?>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$x;?></font></td>
											<? } ?>
										  </tr>
										  <? 	$sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO1."";
										  		$rs_instit = @pg_exec($conn,$sql);
												for($k=0;$k<@pg_numrows($rs_instit);$k++){
													$fila_inst = @pg_fetch_array($rs_instit,$k);
													 $sql = "SELECT count(*) FROM matricula WHERE id_ano=".$fila_inst['id_ano']." and date_part('month',fecha)<=".$cmbMES1."";
													 $rs_mat = @pg_exec($conn,$sql);
													 $tot_mat = @pg_result($rs_mat,0);
													 
													$sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)=".$cmbMES1." AND date_part('year',fecha)=".$cmbANO1." GROUP BY fecha";
													$rs_asis = @pg_exec($conn,$sql);
													
											?>
										  		
										  <tr>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$fila_inst['nombre_instit'];?>
											</font></td>
											<td align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($tot_mat,'0',',','.');?>&nbsp;</font></td>
											<? for($x=1;$x<32;$x++){
												if($x<10) $d="0".$x; else $d=$x;
												if($cmbMES1<10) $mes="0".$cmbMES1; else $mes=$cmbMES1;
												$dia = $d."-".$mes."-".$cmbANO1;
												$dia_f=$x."-".$cmbMES1."-".$cmbANO1;
												//$dia = $x."-".$cmbMES1."-".$cmbANO1;
												$inasis=0;
												$tot_asis=0;
												for($o=0;$o<@pg_numrows($rs_asis);$o++){
													$fila_asis = @pg_fetch_array($rs_asis,$o);
													if(Cfecha($fila_asis['fecha'])==$dia){
														$inasis = $fila_asis['count'];
														break;
													}
													
													
												}											
												$fecha = $cmbANO1."-".$cmbMES1."-".$x;
												$fechaH = $cmbMES1."-".$x."-".$cmbANO1;
												$fecha_f = mktime(0,0,0,$cmbMES1,$dia_f,$cmbANO1);
												$dia_pal_f = strftime("%a",$fecha_f); 
												if(($cmbMES1=="04" || $cmbMES1=="06" || $cmbMES1=="09" || $cmbMES1=="11") and $x==31){
													$habil=0;
												}else{
													$sql ="SELECT * FROM feriado WHERE id_ano=".$cmbANO1." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
													$rs_feriado = @pg_exec($conn,$sql);
													$habil = @pg_result($result,0);
												}
												if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
													$color="bgcolor=#FFFFFF";
													$tot_asis = $tot_mat - $inasis;
													$total_colegio = $total_colegio + $tot_asis;
													$total_dia[$x] = $total_dia[$x] + $tot_asis;
												}else{
													$color="bgcolor=#999999";
													$total_asis=" ";
												}
												
												?>
    										<td <?=$color;?>><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$tot_asis;?></font></td>
											<? } ?>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_colegio,'0',',','.');?></font></td>
										  </tr>
										  <? } ?>
										  <tr>
											<td><span class="Estilo25">Total</span></td>
											<td>&nbsp;</td>
											<? for($x=1;$x<32;$x++){?>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_dia[$x],'0',',','.');?></font></td>
											<? } ?>
										   <td>&nbsp;</td>
										  </tr>
									</table>
									<br>
										<table width="200" border="0" align="center">
										  <tr>
											<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=2&opc=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
											<td class="Estilo4"><a href="reporteAsistencia.php?opcion=1&cmbMES=<?=$cmbMES1;?>&cmbANO=<?=$cmbANO1;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
										  </tr>
										</table>	 
								<?	} 
								if($opc==2 AND $pesta==2){?>
								<table width="100%" border="1" cellpadding="3" cellspacing="0" align="center">
								  <tr>
									<td colspan="35" class="Estilo25"><div align="center"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">TOTAL MENSUAL DE ASISTENCIA DE TODOS LOS ESTABLECIMIENTOS POR CICLOS</font> </div></td>
								  </tr>
								  <tr>
									<td colspan="2" class="Estilo25">MES</td>
									<td colspan="33" class="Estilo25"><? echo envia_mes($cmbMES2);?></td>
								  </tr>
								  <tr>
									<td colspan="2" class="Estilo25">A&Ntilde;O</td>
									<td colspan="33" class="Estilo25"><?=$cmbANO2?></td>
								  </tr>
								  <tr>
									<td colspan="35">&nbsp;</td>
								  </tr>
								  </table>
								  <br />
								  <? $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO2."";
									 $rs_instit = @pg_exec($conn,$sql);
										
										for($v=0;$v<@pg_numrows($rs_instit);$v++){
											$fila_inst = @pg_fetch_array($rs_instit,$v);
											$sql = "SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE rdb=".$fila_inst['rdb']." AND id_ano=".$fila_inst['id_ano'];
											$rs_ciclo = @pg_exec($conn,$sql);
									?>
								  <table cellpadding="3" cellspacing="0" border="1" width="100%">
								  <tr>
									<td class="Estilo25"><span class="Estilo25">Establecimientos</span></td>
									<td class="Estilo25"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$fila_inst['nombre_instit'];?></font></td>
									<td rowspan="2" class="Estilo25"><span class="Estilo25">Matricula</span></td>
									<td colspan="31" class="Estilo25"><div align="center" class="Estilo25">Dias</div></td>
									<td rowspan="2" class="Estilo25"><span class="Estilo25">Total</span></td>
								  </tr>
								  
								  <tr>
									<td colspan="2" class="Estilo25">CICLOS</td>
									<? for($x=1;$x<32;$x++){?>
									<td><span class="Estilo25">&nbsp;<?=$x;?></span></td>
									<? } ?>
								  </tr>
								  <? 	
										$total_matricula = 0;
										for($k=0;$k<@pg_numrows($rs_ciclo);$k++){
											$fila_ciclo = @pg_fetch_array($rs_ciclo,$k);
											 $sql = "select count(*) as cuenta,b.id_ano from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano 
														INNER JOIN curso c ON (c.id_ano=a.id_ano AND c.id_curso=a.id_curso AND c.id_ano=b.id_ano) INNER JOIN ciclos d ON
														(d.id_ano=a.id_ano AND d.id_curso=a.id_curso AND d.id_ano=b.id_ano AND d.id_ano=c.id_ano AND d.id_curso=c.id_curso) 
														WHERE nro_ano=".$cmbANO2." AND d.id_ciclo=".$fila_ciclo['id_ciclo']." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$cmbMES2." GROUP BY b.id_ano  ";
											 $rs_mat = @pg_exec($conn,$sql);
											 $tot_mat = @pg_result($rs_mat,0);
											 $total_matricula = $total_matricula + $tot_mat;
											$sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)=".$cmbMES2." AND date_part('year',fecha)=".$cmbANO2." GROUP BY fecha";
											$rs_asis = @pg_exec($conn,$sql);
											$total_colegio=0;
											
																			?>
								  <tr>
									<td colspan="2"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><span class="Estilo25">
									  <?=$fila_ciclo['nomb_ciclo'];?>
									</span></font></td>
									<td align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($tot_mat,'0',',','.');?>
									  &nbsp;</font></td>
									<? for($x=1;$x<32;$x++){
										$dia = $x."-".$cmbMES2."-".$cmbANO2;
										$inasis=0;
										$tot_asis=0;
										for($o=0;$o<@pg_numrows($rs_asis);$o++){
											$fila_asis = @pg_fetch_array($rs_asis,$o);
											if($fila_asis['fecha']==$dia){
												$inasis = $fila_asis['count'];
												break;
											}
										}
										$fecha = $cmbANO2."-".$cmbMES2."-".$x;
										$fechaH = $cmbMES2."-".$x."-".$cmbANO2;
										$fecha_f = mktime(0,0,0,$cmbMES,$dia,$cmbANO2);
										$dia_pal_f = strftime("%a",$fecha_f); 
										if(($cmbMES2=="04" || $cmbMES2=="06" || $cmbMES2=="09" || $cmbMES2=="11") and $x==31){
											$habil=0;
										}else{
											$sql ="SELECT * FROM feriado WHERE id_ano=".$cmbANO2." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
											$rs_feriado = @pg_exec($conn,$sql);
											$habil = @pg_result($result,0);
										}
										if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
											$color="bgcolor=#FFFFFF";
											$tot_asis = $tot_mat - $inasis;
											$total_colegio = $total_colegio + $tot_asis;
											$total_dia[$v][$x] = $total_dia[$v][$x] + $tot_asis;
										}else{
											$color="bgcolor=#999999";
											$total_asis="&nbsp;";
										}
										
										?>
									<td <?=$color;?>><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=$tot_asis;?></font></td>
									<? } ?>
									<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_colegio,'0',',','.');?></font></td>
								  </tr>
								  <? } ?>
								  <tr>
									<td colspan="2"><span class="Estilo25">Total</span></td>
									<td><div align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">&nbsp;<?=number_format($total_matricula,'0',',','.');?></font></div></td>
									<? for($x=1;$x<32;$x++){
										$total_gral = $total_gral + $total_dia[$v][$x];
									?>
									<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_dia[$v][$x],'0',',','.');?>&nbsp;</font></td>
									<? } ?>
									<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_gral,'0',',','.');?>&nbsp;</font></td>
								  </tr>
								</table>
								<? } ?>
								

								<br>
								<table width="200" border="0" align="center">
								  <tr>
									<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=2&opc=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
									<td class="Estilo4"><a href="reporteAsistencia.php?opcion=2&cmbMES=<?=$cmbMES2;?>&cmbANO=<?=$cmbANO2;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
								  </tr>
								</table>


								<? }
								if($opc==3 AND $pesta==2){
									$sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
									$rs_nivel=@pg_exec($conn,$sql);  ?>
								<table width="100%" border="1" cellpadding="3" cellspacing="0">
										  <tr>
											<td colspan="34"><div align="center">Total de Asistencia Mensual de todos los Establecimientos por Niveles</div></td>
										  </tr>
										  <tr>
											<td class="Estilo25">NIVEL</td>
										    <td colspan="33" class="Estilo25"><? echo @pg_result($rs_nivel,0);?></td>
									      </tr>
										  <tr>
										    <td class="Estilo25">MES</td>
										    <td colspan="33" class="Estilo25"><? echo envia_mes($cmbMES31);?></td>
								      </tr>
										  <tr>
										    <td class="Estilo25">A&Ntilde;O</td>
										    <td colspan="33" class="Estilo25"><? echo $cmbANO3;?></td>
								      </tr>
										  <tr>
											<td colspan="34">&nbsp;</td>
										  </tr>
										  <tr>
											<td rowspan="2"><span class="Estilo25">Establecimientos</span></td>
											<td rowspan="2"><span class="Estilo25">Matricula</span></td>
											<td colspan="31"><div align="center" class="Estilo25">Dias</div></td>
											<td rowspan="2"><span class="Estilo25">Total</span></td>
										  </tr>
										  <tr>
											<? for($x=1;$x<32;$x++){?>
											<td><span class="Estilo25">&nbsp;
										    <?=$x;?>
											</span></td>
											<? } ?>
										  </tr>
										  <? 	$sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO3."";
										  		$rs_instit = @pg_exec($conn,$sql);
												for($k=0;$k<@pg_numrows($rs_instit);$k++){
													$fila_inst = @pg_fetch_array($rs_instit,$k);
													 $sql = "SELECT count(*) FROM matricula INNER JOIN curso ON matricula.id_ano=curso.id_ano AND matricula.id_curso=curso.id_curso WHERE matricula.id_ano=".$fila_inst['id_ano']." and date_part('month',fecha)<=".$cmbMES31." AND id_nivel=".$cmbNIVEL."";
													 $rs_mat = @pg_exec($conn,$sql);
													 $tot_mat = @pg_result($rs_mat,0);
													 $total_matricula = $total_matricula + $tot_mat;
													$sql = "SELECT count(*), fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." and date_part('month',fecha)<=".$cmbMES31." AND date_part('year',fecha)=".$cmbANO3." GROUP BY fecha";
													$rs_asis = @pg_exec($conn,$sql);
													$total_colegio=0;
											?>
										  		
										  <tr>
											<td><span class="Estilo26">&nbsp;
										    <?=$fila_inst['nombre_instit'];?>
											</span></td>
											<td align="right"><span class="Estilo21"><?=number_format($tot_mat,'0',',','.');?>&nbsp;</span></td>
											<? for($x=1;$x<32;$x++){
													if($x<10) $d="0".$x; else $d=$x;	
													if($cmbMES31<10) $mes="0".$cmbMES31; else $mes=$cmbMES31;
													$dia = $d."-".$mes."-".$cmbANO3;
												//$dia = $x."-".$cmbMES31."-".$cmbANO3;
												$inasis=0;
												$tot_asis=0;
												for($o=0;$o<@pg_numrows($rs_asis);$o++){
													$fila_asis = @pg_fetch_array($rs_asis,$o);
													if(Cfecha($fila_asis['fecha'])==$dia){
														$inasis = $fila_asis['count'];
														break;
													}
													
												}
												$fecha = $cmbANO3."-".$cmbMES31."-".$x;
												$fechaH = $cmbMES31."-".$x."-".$cmbANO3;
												$fecha_f = mktime(0,0,0,$cmbMES31,$dia,$cmbANO3);
												$dia_pal_f = strftime("%a",$fecha_f); 
												if(($cmbMES31=="04" || $cmbMES31=="06" || $cmbMES31=="09" || $cmbMES31=="11") and $x==31){
													$habil=0;
												}else{
													$sql ="SELECT * FROM feriado WHERE id_ano=".$cmbANO3." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
													$rs_feriado = @pg_exec($conn,$sql);
													$habil = @pg_result($result,0);
												}
												if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
													$color="bgcolor=#FFFFFF";
													$tot_asis = $tot_mat - $inasis;
													$total_colegio = $total_colegio + $tot_asis;
													$total_dia[$x] = $total_dia[$x] + $tot_asis;
												}else{
													$color="bgcolor=#999999";
													$total_asis="&nbsp;";
												}
												?>
											<td <?=$color;?>><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=$tot_asis;?>&nbsp;</font></td>
											<? } ?>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</font></td>
										  </tr>
										  <? } ?>
										  <tr>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">Total</font></td>
											<td><div align="right"><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px">
											<?=number_format($total_matricula,'0',',','.');?>
											&nbsp;</font></div></td>
											<? for($x=1;$x<32;$x++){
												$total_gral = $total_gral + $total_dia[$x];?>
											<td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_dia[$x],'0,',',','.');?>&nbsp;</font></td>
											<? } ?>
										   <td><font style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:9px"><?=number_format($total_gral,'0,',',','.');?>&nbsp;</font></td>
										  </tr>
								  </table>
									<br>
										<table width="200" border="0" align="center">
										  <tr>
											<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=2&opc=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
											<td class="Estilo4"><a href="reporteAsistencia.php?opcion=3&cmbMES=<?=$cmbMES31;?>&cmbANO=<?=$cmbANO3;?>&cmbNIVEL=<?=$cmbNIVEL;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
										  </tr>
										</table>	 
								<? } 
								if($opc==4 AND $pesta==2){?>
								<table width="100%" border="1" cellpadding="3" cellspacing="0">
                                 <tr>
                                   <td colspan="12" class="Estilo25"><div align="center"><strong>Total de Asistencia Anual de Todos los Establecimientos </strong></div></td>
                                 </tr>
                                 <tr>
                                   <td class="Estilo1">A&Ntilde;O</td>
                                   <td colspan="11" class="Estilo25">&nbsp;<?=$cmbANO4;?></td>
                                   </tr>
                                 <tr>
                                   <td colspan="12" class="Estilo25">&nbsp;</td>
                                   </tr>
                                 <tr>
                                   <td rowspan="2" class="Estilo1">ESTABLECIMIENTOS</td>
                                   <td colspan="10" class="Estilo25"><div align="center"><strong>MESES</strong></div></td>
                                   <td rowspan="2" class="Estilo25"><div align="center"><strong>TOTAL</strong></div></td>
                                 </tr>
								 <? $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO4." ORDER BY nombre_instit ASC";
									$rs_instit = @pg_exec($conn,$sql); 
									
									
									?>
									
                                 <tr>
                                   <? for($i=3;$i<13;$i++){?>
                                   <td class="Estilo25">&nbsp;
                                       <?=substr(envia_mes($i),0,6);?></td>
                                   <? } ?>
                                 </tr>
								 <? for($k=0;$k<@pg_numrows($rs_instit);$k++){
										$fila_inst = @pg_fetch_array($rs_instit,$k);
										$total_colegio=0;

										?>
                                 <tr>
                                   <td class="Estilo25"><?=$fila_inst['nombre_instit'];?></td>
                                   <? for($i=3;$i<13;$i++){
								   		$sql = "select count(*) as cuenta,id_institucion from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano WHERE nro_ano=".$cmbANO4." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$i." group by id_institucion ";
										$rs_mat = @pg_exec($conn,$sql);
										
										
										
										?>
                                   <td class="Estilo25"><div align="right"><?=number_format(pg_result($rs_mat,0),'0',',','.');?>&nbsp;</div></td>
                                   <? 	$total_colegio = $total_colegio + pg_result($rs_mat,0);
								   		$total_mes[$i] = $total_mes[$i] + pg_result($rs_mat,0);
								   } ?>
                                   <td class="Estilo25"><div align="right"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</div></td>
                                 </tr>
								 <? } ?>
                                 <tr>
                                   <td class="Estilo1">TOTAL</td>
                                   <? for($i=3;$i<13;$i++){?>
                                   <td class="Estilo25"><?=number_format($total_mes[$i],'0',',','.');?>&nbsp;</td>
                                   <? $total_gral = $total_gral + $total_mes[$i];
								   } ?>
                                   <td class="Estilo25"><?=number_format($total_gral,'0',',','.');?>&nbsp;</td>
                                 </tr>
                               </table>
								<br>
								<table width="200" border="0" align="center">
								  <tr>
									<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=2&opc=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
									<td class="Estilo4"><a href="reporteAsistencia.php?opcion=4&cmbANO=<?=$cmbANO4;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
								  </tr>
								</table>
								<? }
								if($opc==5 AND $pesta==2){?>
								<table width="100%" border="1" cellpadding="3" cellspacing="0">
								 <tr>
								   <td colspan="13" class="Estilo25"><div align="center"><strong>TOTAL DE ASISTENCIA ANUAL TODOS LOS ESTABLECIMIENTOS POR CICLOS </strong></div></td>
								 </tr>
								 <tr>
								   <td colspan="2" class="Estilo1">A&Ntilde;O</td>
								   <td colspan="11" class="Estilo25">&nbsp;<?=$cmbANO5;?></td>
								  </tr>
								 <tr>
								   <td colspan="13" class="Estilo25">&nbsp;</td>
								  </tr>
								</table>
								   <? 
								 $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO5." ORDER BY nombre_instit ASC";
									$rs_instit = @pg_exec($conn,$sql); 
									
									for($v=0;$v<pg_numrows($rs_instit);$v++){
										$fila_inst=@pg_fetch_array($rs_instit,$v);
										$sql = "SELECT id_ciclo,nomb_ciclo FROM ciclo_conf WHERE rdb=".$fila_inst['rdb']." AND id_ano=".$fila_inst['id_ano'];
										$rs_ciclo = @pg_exec($conn,$sql);
										$total_gral=0;
									?>
								  
								  <br />
								   <table width="100%" border="1" align="center" cellpadding="3" cellspacing="0">
								 <tr>
								   <td rowspan="2" class="Estilo1">ESTABLECIMIENTO</td>
								   <td rowspan="2" class="Estilo1"><span class="Estilo25">
									 <?=$fila_inst['nombre_instit'];?>
								   </span></td>
								   <td colspan="10" class="Estilo25">&nbsp;</td>
								   <td rowspan="3" class="Estilo25"><div align="center"><strong>TOTAL</strong></div></td>
								   </tr>
								 <tr>
								   <td colspan="10" class="Estilo25"><div align="center"><strong>MESES</strong></div></td>
								   </tr>
								
									
								 <tr>
								   <td colspan="2" class="Estilo1">CICLOS</td>
								   <? for($i=3;$i<13;$i++){?>
								   <td class="Estilo25">&nbsp;
									   <?=substr(envia_mes($i),0,6);?></td>
								   <? } ?>
								 </tr>
								 <? 
								 for($k=0;$k<@pg_numrows($rs_ciclo);$k++){
										$fila_ciclo = @pg_fetch_array($rs_ciclo,$k);
										$total_colegio=0;
										$sql = "SELECT count(*) as cuenta,date_part('month',fecha) as fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." AND date_part('year',fecha)=".$cmbANO5." group by date_part('month',fecha) ";
										$rs_asistencia = @pg_exec($conn,$sql);
										?>
								 <tr>
								   <td height="33" colspan="2" class="Estilo25">&nbsp;
								   <?=$fila_ciclo['id_ciclo']."--".$fila_ciclo['nomb_ciclo'];?></td>
								   <? 
								   
								   for($i=3;$i<13;$i++){
										$sql = "select count(*) as cuenta,b.id_ano from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano 
						INNER JOIN curso c ON (c.id_ano=a.id_ano AND c.id_curso=a.id_curso AND c.id_ano=b.id_ano) INNER JOIN ciclos d ON
						(d.id_ano=a.id_ano AND d.id_curso=a.id_curso AND d.id_ano=b.id_ano AND d.id_ano=c.id_ano AND d.id_curso=c.id_curso) 
						WHERE nro_ano=".$cmbANO5." AND d.id_ciclo=".$fila_ciclo['id_ciclo']." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$i." GROUP BY b.id_ano  ";
						
										
										$rs_mat = @pg_exec($conn,$sql);
										$fila_cont = pg_fetch_array($rs_mat,0);
										$ano_matricula = $fila_cont['id_ano'];
										
										
										for($xx=0;$xx<pg_numrows($rs_asistencia);$xx++){
											$fila = @pg_fetch_array($rs_asistencia,$xx);
											if($fila['fecha']==$i){
												$inasistencia = $fila['cuenta'];
												break;
											}
										}
						
										if($i<10){
											$mes="0".$i;
										}else{
											$mes=$i;
										}
										$dia_termino =dia_mes($mes,$cmbANO6);
										$dia_fin = $mes."-".$dia_termino."-".$cmbANO6;
										$dia_inicio = "01-".$mes."-".$cmbANO6;
										$total_habiles=0;
										for($c=1;$c<=$dia_termino;$c++){
											if($c<10){
												$dia="0".$c;
											}else{
												$dia=$c;
											}
											$fecha = $cmbANO5."-".$mes."-".$dia;
											$fechaH = $mes."-".$dia."-".$cmbANO6;
											$fecha_f = mktime(0,0,0,$mes,$dia,$cmbANO5);
											$dia_pal_f = strftime("%a",$fecha_f); 
											$cmbANO69 = $ano_matricula;
											if(($mes=="04" || $mes=="06" || $mes=="09" || $mes=="11") and $dia==31){
												$habil=0;
											}else{
												$sql ="SELECT * FROM feriado WHERE id_ano=".$fila_inst['rdb']." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
												$rs_feriado = @pg_exec($conn,$sql);
												$habil = @pg_result($result,0);
											}
											if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
												$total_habiles++;
											}
											
											
										}
										
										$matricula = (pg_result($rs_mat,0) * $total_habiles) - $inasistencia;
										
										?>
								   <td class="Estilo25"><div align="right"><?=number_format($matricula,'0',',','.');?>&nbsp;</div></td>
								   <? 	$total_colegio = $total_colegio + $matricula;
										$total_mes[$v][$i] = $total_mes[$v][$i] + $matricula;
								   } ?>
								   <td class="Estilo25"><div align="right"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</div></td>
								 </tr>
								 <? } ?>
								 <tr>
								   <td colspan="2" class="Estilo1">TOTAL</td>
								   <? for($i=3;$i<13;$i++){?>
								   <td class="Estilo25"><div align="right">
									 <?=number_format($total_mes[$v][$i],'0',',','.');?>
								   &nbsp;</div></td>
								   <? $total_gral = $total_gral + $total_mes[$v][$i];
								   } ?>
								   <td class="Estilo25"><div align="right">
									 <?=number_format($total_gral,'0',',','.');?>
								   &nbsp;</div></td>
								 </tr>
						</table>
						<? } ?>
						<br>
								<table width="200" border="0" align="center">
								  <tr>
									<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=2&opc=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
									<td class="Estilo4"><a href="reporteAsistencia.php?opcion=5&cmbANO=<?=$cmbANO5;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
								  </tr>
								</table>
						<? }
								if($opc==6 AND $pesta==2){
								
								$sql="SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL2;
								$rs_nivel=@pg_exec($conn,$sql);
								?>
								<table width="100%" border="1" cellpadding="3" cellspacing="0">
                                 <tr>
                                   <td colspan="12" class="Estilo25"><div align="center"><strong>Total de Asistencia Anual de Todos los Establecimientos por Niveles </strong></div></td>
                                 </tr>
                                 <tr>
                                   <td class="Estilo1">A&Ntilde;O</td>
                                   <td colspan="11" class="Estilo25">&nbsp;<?=$cmbANO6;?></td>
                                   </tr>
                                 <tr>
                                   <td class="Estilo1">NIVEL</td>
                                   <td colspan="11" class="Estilo25">&nbsp;<?=pg_result($rs_nivel,0);?></td>
                                 </tr>
                                 <tr>
                                   <td colspan="12" class="Estilo25">&nbsp;</td>
                                   </tr>
                                 <tr>
                                   <td rowspan="2" class="Estilo1">ESTABLECIMIENTOS</td>
                                   <td colspan="10" class="Estilo25"><div align="center"><strong>MESES</strong></div></td>
                                   <td rowspan="2" class="Estilo25"><div align="center"><strong>TOTAL</strong></div></td>
                                 </tr>
								 <? 
								 $sql ="SELECT a.rdb,nombre_instit,c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON  (a.rdb=c.id_institucion AND b.rdb=c.id_institucion) where  num_corp=".$corporacion."  AND nro_ano=".$cmbANO6." ORDER BY nombre_instit ASC";
									$rs_instit = @pg_exec($conn,$sql); 
									
									
									?>
									
                                 <tr>
                                   <? for($i=3;$i<13;$i++){?>
                                   <td class="Estilo25">&nbsp;
                                       <?=substr(envia_mes($i),0,6);?></td>
                                   <? } ?>
                                 </tr>
								 <? 
								 for($k=0;$k<@pg_numrows($rs_instit);$k++){
										$fila_inst = @pg_fetch_array($rs_instit,$k);
										$total_colegio=0;
										$sql = "SELECT count(*) as cuenta,date_part('month',fecha) as fecha FROM asistencia WHERE ano=".$fila_inst['id_ano']." AND date_part('year',fecha)=".$cmbANO6." group by date_part('month',fecha) ";
										$rs_asistencia = @pg_exec($conn,$sql);
										?>
                                 <tr>
                                   <td class="Estilo25"><?=$fila_inst['nombre_instit'];?></td>
                                   <? 
								   
								   for($i=3;$i<13;$i++){
								   		$sql = "select count(*) as cuenta,b.id_ano from matricula a INNER JOIN ano_escolar b ON a.id_ano=b.id_ano INNER JOIN curso c ON c.id_ano=a.id_ano AND c.id_curso=a.id_curso AND c.id_ano=b.id_ano WHERE nro_ano=".$cmbANO6." AND id_institucion=".$fila_inst['rdb']." AND date_part('month',fecha)<=".$i." AND c.id_nivel=".$cmbNIVEL2." GROUP BY b.id_ano ";
										$rs_mat = @pg_exec($conn,$sql);
										$fila_cont = pg_fetch_array($rs_mat,0);
										$ano_matricula = $fila_cont['id_ano'];
										
										
										for($xx=0;$xx<pg_numrows($rs_asistencia);$xx++){
											$fila = @pg_fetch_array($rs_asistencia,$xx);
											if($fila['fecha']==$i){
												$inasistencia = $fila['cuenta'];
												break;
											}
										}
			
										if($i<10){
											$mes="0".$i;
										}else{
											$mes=$i;
										}
										$dia_termino =dia_mes($mes,$cmbANO6);
										$dia_fin = $mes."-".$dia_termino."-".$cmbANO6;
										$dia_inicio = "01-".$mes."-".$cmbANO6;
										$total_habiles=0;
										for($c=1;$c<=$dia_termino;$c++){
											if($c<10){
												$dia="0".$c;
											}else{
												$dia=$c;
											}
											$fecha = $cmbANO6."-".$mes."-".$dia;
											$fechaH = $mes."-".$dia."-".$cmbANO6;
											$fecha_f = mktime(0,0,0,$mes,$dia,$cmbANO6);
											$dia_pal_f = strftime("%a",$fecha_f); 
											$cmbANO69 = $ano_matricula;
											if(($mes=="04" || $mes=="06" || $mes=="09" || $mes=="11") and $dia==31){
												$habil=0;
											}else{
												$sql ="SELECT * FROM feriado WHERE id_ano=".$cmbANO69." and (fecha_inicio<='".$fecha."' AND fecha_fin>='".$fecha."')";
												$rs_feriado = @pg_exec($conn,$sql);
												$habil = @pg_result($result,0);
											}
											if($habil==0 AND ($dia_pal_f <> "Sat" and $dia_pal_f <> "Sun" )){
												$total_habiles++;
											}
											/*$sql = "SELECT count(*) as cuenta FROM asistencia WHERE ano=".$cmbANO69." AND fecha=".$fecha."";
											$rs_asistencia = @pg_exec($conn,$sql);
											$inasistencia = @pg_result($rs_asistencia,0);*/
											
										}
										
										$matricula = (pg_result($rs_mat,0) * $total_habiles) - $inasistencia;
										
										?>
                                   <td class="Estilo25"><div align="right"><?=number_format($matricula,'0',',','.');?>&nbsp;</div></td>
                                   <? 	$total_colegio = $total_colegio + $matricula;
								   		$total_mes[$i] = $total_mes[$i] + $matricula;
								   } ?>
                                   <td class="Estilo25"><div align="right"><?=number_format($total_colegio,'0',',','.');?>&nbsp;</div></td>
                                 </tr>
								 <? } ?>
                                 <tr>
                                   <td class="Estilo1">TOTAL</td>
                                   <? for($i=3;$i<13;$i++){?>
                                   <td class="Estilo25"><?=number_format($total_mes[$i],'0',',','.');?>&nbsp;</td>
                                   <? $total_gral = $total_gral + $total_mes[$i];
								   } ?>
                                   <td class="Estilo25"><?=number_format($total_gral,'0',',','.');?>&nbsp;</td>
                                 </tr>
                               </table>
								<br>
								<table width="200" border="0" align="center">
								  <tr>
									<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=2&opc=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
									<td class="Estilo4"><a href="reporteAsistencia.php?opcion=6&cmbANO=<?=$cmbANO6;?>&cmbNIVEL=<?=$cmbNIVEL2;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
								  </tr>
								</table>
								<? } ?>                               </td>
                             </tr>
							</table>
							
							<table width="100%" border="0"  cellpadding="0" cellspacing="0">
                             <tr id="notas" >
                               <td valign="top">
							   <form name="frm_aux" method="post">
							   <input name="pesta" value="3" type="hidden">
							   <br>
							   <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                 <tr class="Estilo4">
                                   <td height="19">&nbsp;Buscador </td>
                                   <td height="19">:</td>
                                   <td height="19">&nbsp;</td>
                                 </tr>
                                 <tr class="Estilo4">
                                   <td width="23%" height="19">&nbsp;Instituciones</td>
                                   <td width="2%">: </td>
								   <td width="75%"><form method="post" name="f1"  action="">
                                     <select name="cmb_ins" id="cmb_ins" class="ddlb_x" onChange="enviapag4(this.form);">
                                       <option value="0" selected="selected">Seleccione Institucion</option>
                                       <?
								 	$sql = "select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit ";
									$sql.= "from corp_instit,institucion where corp_instit.num_corp = '$corporacion' ";
									$sql.= "and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
									
									$rs_inst= @pg_exec($conn,$sql);  
								    for($i=0;$i<pg_numrows($rs_inst);$i++){
										  $combo=pg_fetch_array($rs_inst,$i);
									      if($combo['rdb']==$cmb_ins){								   				   
								   ?>
                                       <option value="<?=$combo['rdb'];?>" selected="selected">
                                       <?=ucfirst($combo['nombre_instit']);?>
                                       </option>
                                       <? }else{ ?>
                                       <option value="<?=$combo['rdb'];?>">
                                       <?=ucfirst($combo['nombre_instit']);?>
                                       </option>
                                       <? }
		 } ?>
                                     </select>
                                   </form>								   </td>
                               <?
												   if($cmb_ins!=0){
				   	$sql_ano="select max(id_ano) as ano_escolar from ano_escolar where id_institucion=$cmb_ins";
								   	$rs_ano= @pg_exec($conn,$sql_ano);
								   	$ano_2 = pg_result ($rs_ano,0);
								   	
								   }
								   ?>
                             </tr>
                                 <tr class="Estilo4">
                                   <td>&nbsp;Tipo Ense&ntilde;anza </td>
                                   <td>:</td>
                                   <td><FORM method="post" name="f2" action="">
								   <input name="pesta" value="3" type="hidden">
								   <select name="cmb_en" id="cmb_en" class="ddlb_x"  onChange="enviapag5(this.form);">
								   		<option value="0" selected="selected">Seleccione Tipo Enseñanza</option>
										<?
										$sql_ense = "select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo";
										$sql_ense.= " from tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = ";
										$sql_ense.= "tipo_ensenanza.cod_tipo  ";
									if($cmb_ins==0){
										$sql_ense.= "and rdb in (select rdb from corp_instit where num_corp='$corporacion') ";	
											}else{
										$sql_ense.= "and tipo_ense_inst.rdb='$cmb_ins' ";
											}	
																								
  										$rs_ense= pg_exec($conn,$sql_ense);  
								    for($j=0;$j<pg_numrows($rs_ense);$j++){
										  $combo_ense=pg_fetch_array($rs_ense,$j);
									      if($combo_ense['cod_tipo']==$cmb_en){			
										?>
		<option value="<?=$combo_ense['cod_tipo'];?>" selected="selected"><?=ucfirst($combo_ense['nombre_tipo']);?></option>
            <? }else{ ?>
         <option value="<?=$combo_ense['cod_tipo'];?>"><?=ucfirst($combo_ense['nombre_tipo']);?></option>
          <? }
		 } ?>
                                     </select>
									 <?
									$ano1=$ano_2;
									$inst1=$cmb_ins;
								//	echo $sql_ense;
								//  echo "ano:".$ano1;
								//  echo "<br>rdb:".$cmb_ins;
								//  echo "<br>ense:".$cmb_en;
									 
									 
									 ?>
									<input type="hidden" name="cmb_ins" value="<?=$inst1?>">
									 </FORM></td>
								</tr>
                                 <tr class="Estilo4">
								 <FORM method="post" name="f3" action="">
								 <input name="pesta" value="3" type="hidden">
								 <input type="hidden" name="cmb_ins" value="<?=$inst1?>">
								 <input type="hidden" name="cmb_en" value="<?=$cmb_en?>">
								 
                                   <td>&nbsp;Curso								   </td>
                                   <td>:</td>
                                   <td>
								   
								   <? if($cmb_ins!=0){ //or $cmb_en!=0?>
								   <?
								   		$sql_ens1 ="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo ";
								  		$sql_ens1.="from tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = ";
							  		    $sql_ens1.="tipo_ensenanza.cod_tipo";
							if($cmb_ins==0){	
										
								}else{
								 	    $sql_ens1.=" and tipo_ense_inst.rdb='$cmb_ins' ";
								}
								if($cmb_en==0){                          
								   				
									}else{
									    $sql_ens1.=" and tipo_ense_inst.cod_tipo=$cmb_en";
									}	
									$rs_ense1= pg_exec($conn,$sql_ens1);	
									$dig=0;				   
								   for($x=0;$x<pg_numrows($rs_ense1);$x++){
								   	 $ense=pg_fetch_array($rs_ense1,$x);
									 echo "<br>";
									 echo $ense['nombre_tipo'];
									 echo "<br>";
									 $cod_tipo=$ense['cod_tipo'];
									
								 $sql_cursos="SELECT distinct curso.ensenanza, curso.grado_curso,tipo_ensenanza.nombre_tipo ";
								 $sql_cursos.="FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = ";
								 $sql_cursos.="tipo_ensenanza.cod_tipo WHERE (((curso.id_ano)=$ano_2)) and ";
								 $sql_cursos.=" curso.ensenanza=$cod_tipo ORDER BY curso.ensenanza";
								 $rs_cursos= @pg_exec($conn,$sql_cursos);
								for($k=0;$k<pg_numrows($rs_cursos);$k++){
								   $cursos=pg_fetch_array($rs_cursos,$k);
								  if($cursos['ensenanza']!=NULL){
								  	$grado=$cursos['grado_curso'];
									echo $cursos['grado_curso'];
									$check="checkbox".$dig;
								//	if ($caso != $cod_tipo."_".$grado){
								//	echo "<input type='checkbox' name='".$cod_tipo."_".$grado."' id='".$cod_tipo."_".$grado."' value='".$cod_tipo."_".$grado."' checked='checked' onClick='enviapag6(this.form,this.id);'  />";
								//	}else{
									echo "<input onClick='crear(this.id)' type='checkbox' name=".$check." value='".$cod_tipo."_".$grado."' id='checkbox".$x.$k."'/>";
									//}
								  }else{
								 	echo "No Hay Cursos";
								   	}
									$dig++;
								}
								   ?>
								
								   <? }?>
								   <? }else{// sin nada ni tipo ense e insti 
								 $sql1="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo from ";
								 $sql1.="tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = tipo_ensenanza.cod_tipo ";
								 $sql1.="and rdb in (select rdb from corp_instit where num_corp='$corporacion')";
							  if($cmb_en==0){
							   							  
							  	}else{
							     $sql1.=" and tipo_ensenanza.cod_tipo=$cmb_en";
							 	 }
								 $rs_sql1=pg_exec($conn,$sql1);
								 $dig=0;
							for($y=0;$y<pg_numrows($rs_sql1);$y++){  
								 $fila=pg_fetch_array($rs_sql1,$y);
								 echo "<br>";
								 echo $fila['nombre_tipo'];
								 echo "<br>";
								 $cod_tipo=$fila['cod_tipo'];
								   
									$sql="SELECT distinct a.ensenanza,grado_curso,b.nombre_tipo FROM curso a INNER JOIN ";
									$sql.="tipo_ensenanza b ON (a.ensenanza =b.cod_tipo) INNER JOIN ano_escolar c ON ";
									$sql.="(a.id_ano=c.id_ano) INNER JOIN corp_instit d ON (c.id_institucion=d.rdb) ";
					   	    	    $sql.="where d.num_corp='$corporacion' and a.ensenanza=$cod_tipo ";
							
									$rs_sql=pg_exec($conn,$sql);
								      for($z=0;$z<pg_numrows($rs_sql);$z++){
									     $curso=pg_fetch_array($rs_sql,$z);
								 			 if($curso['ensenanza']!=NULL){
											    $grado=$curso['grado_curso'];
												$check = "checkbox".$dig;
												//echo $value = $cod_tipo."_".$grado;
								    			echo $curso['grado_curso'];
												echo "<input onClick='crear(this.id)' type='checkbox' name='".$check."' value='".$cod_tipo."_".$grado."' id='checkbox".$y.$z."' />";
								  }else{
								 				echo "No Hay Cursos";
								   	   }
									   $dig++;
								     }
								   }
								 }
								   ?><br>
								   <input align="right" type="button" name="Submit" value="Ver Asignaturas" onClick="ver(this.form)">
                                  <div id="fiel"></div>								   </td>
								   </FORM>
                                 </tr>
                                 <tr class="Estilo4">
                                   <td valign="top">&nbsp;Asignaturas</td>
                                   <td valign="top">:</td>
								    <td valign="top">
								<? 
								
				if($cantidad!=0){
				
					if($cmb_ins!=0 and $cmb_en==0){ 
					      $sql_3.=" select distinct a.cod_subsector, b.nombre from ramo a inner join subsector b on ";
						  $sql_3.=" (a.cod_subsector=b.cod_subsector) inner join curso c on (a.id_curso=c.id_curso) ";
						  $sql_3.=" inner join ano_escolar d on (d.id_ano=c.id_ano) inner join corp_instit e on ";
						  $sql_3.=" (e.rdb=d.id_institucion) where e.num_corp='$corporacion' and e.rdb='$cmb_ins' and d.id_ano='$ano1' ";
					  
					 }else{
					 
					   if($cmb_ins==0 and $cmb_en==0){
					      $sql_3.=" select distinct a.cod_subsector, b.nombre from ramo a inner join subsector b on ";
						  $sql_3.=" (a.cod_subsector=b.cod_subsector) inner join curso c on (a.id_curso=c.id_curso) ";
						  $sql_3.=" inner join ano_escolar d on (d.id_ano=c.id_ano) inner join corp_instit e on ";
						  $sql_3.=" (e.rdb=d.id_institucion) where e.num_corp='$corporacion' ";
					   }else{
					   	   
											
						if($cmb_ins!=0){
						
						    $sql_3="select distinct ramo.cod_subsector,subsector.nombre from ramo inner join subsector on ";
							$sql_3.=" ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso ";
							$sql_3.=" from curso where id_ano=$ano1 and id_ano in (select id_ano from ano_escolar where ";
							$sql_3.=" id_institucion in (select rdb from corp_instit where num_corp='$corporacion' ) and id_institucion='$cmb_ins') ";
											
						}else{
							$sql_3="select distinct ramo.cod_subsector,subsector.nombre from ramo inner join subsector on ";
							$sql_3.=" ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso ";
							$sql_3.=" from curso where id_ano in (select id_ano from ano_escolar where ";
							$sql_3.=" id_institucion in (select rdb from corp_instit where num_corp='$corporacion'))";
					      }
						}
					}	   					
							$xx=0;
							$var3=0;
						    $var4=0;
							$sql_tipo_ense="select distinct tipo_ense_inst.cod_tipo,tipo_ensenanza.nombre_tipo from ";
							$sql_tipo_ense.="tipo_ense_inst, tipo_ensenanza where tipo_ense_inst.cod_tipo = tipo_ensenanza.cod_tipo ";
							$sql_tipo_ense.="and rdb in (select rdb from corp_instit where num_corp='$corporacion')";
							$rs_sql_tipo_ense=pg_exec($conn,$sql_tipo_ense);	
							  
						   
						for($a=0;$a<pg_numrows($rs_sql_tipo_ense);$a++){  
								 $fila_tipo_ense=pg_fetch_array($rs_sql_tipo_ense,$a);
								 $cod_tipo_ense=$fila_tipo_ense['cod_tipo'];
								 $var=0;
							     $var2=0;
									$sql_cursos="SELECT distinct a.ensenanza,grado_curso,b.nombre_tipo FROM curso a INNER JOIN ";
									$sql_cursos.="tipo_ensenanza b ON (a.ensenanza =b.cod_tipo) INNER JOIN ano_escolar c ON ";
									$sql_cursos.="(a.id_ano=c.id_ano) INNER JOIN corp_instit d ON (c.id_institucion=d.rdb) ";
					   	    	    $sql_cursos.="where d.num_corp='$corporacion' and a.ensenanza=$cod_tipo_ense ";
									$rs_sql_cursos=pg_exec($conn,$sql_cursos);
									
								      for($b=0;$b<pg_numrows($rs_sql_cursos);$b++){
									     $cursos=pg_fetch_array($rs_sql_cursos,$b);	
										 $valor = $_POST["checkbox".$var3];
										//echo "<br/>";
										// $valor3 = strstr($valor,"_");
									   //  $grado_prueba = substr($valor3,1);
										 if(trim($valor)==NULL){
																				
										 }else{
										 
										$arreglo[$xx]=$valor;
									//	echo "<br/>";
										 $xx++;
										 }
										
									//	 $var=0;
						//------------------------VER------------------------	
						      
						if($cmb_ins!=0 and $cmb_en==0){  //-------($cmb_ins==0 or agregar?
					//	echo "aca";
						  if($valor==NULL){
								
								
								}else{		 
								  if($cmb_ins!=0 and $cmb_en==0){
									   $ense2 = strtok($valor,"_");
								  if($var2==0){
									 if($var4==0){
									   $sql_3.=" and ((c.ensenanza=$ense2";
									  }else{
									   $sql_3.=" and (c.ensenanza=$ense2";
									  }
									   $var2=$ense2;
									   $var3=$ense2;
									   $var4=$ense2;
									     }else{
									if($var3==$ense2){
									
									     }else{
									   $sql_3.=" or (c.ensenanza=$ense2";
									       }
									     }
									   
									   }
						  if($ense2==NULL){
						  
						       }else{
							   
								  if($var==0){
								      $valor2 = strstr($valor,"_");
									  $grado = substr($valor2,1);
									  $sql_3.= " and (c.grado_curso=$grado ";
									  $var++;
									}else{
								      $valor2 = strstr($valor,"_");
									  $grado = substr($valor2,1);
									  $sql_3.= " or c.grado_curso=$grado ";
									// $var++;
									}
						            $sql_3.="))";
							    }
							  }
							
						//---------------------------------------------------------
						}else{
						//echo "aki";
						    if($valor!=NULL){
									if($var==0){
										 $ense = strtok($valor,"_");
										  }else{
										 
										 }
									  if(trim($ense)!=$var){ 
									 	 $sql_3.=" and (ensenanza=$ense";
										 $var=$ense;
										   }else{
										 $sql3.=" or (ensenanza=$ense";
										  
										   }
									
									    $valor2 = strstr($valor,"_");
										$grado = substr($valor2,1);
									if($var2==0){
										
									    $sql_3.=" and (grado_curso=$grado ";
							   	        $var2++;
									  }else{
												
										$sql_3.=" or grado_curso=$grado";
									  }		
																											
									     }else{
																				 										 
								     } 
								}	
									
								$var3++;									   
							}//$sql_3.="))";
							
						}	$sql_3.="))";		
						if($cmb_ins!=0 and $cmb_en==0){   //--------------($cmb_ins==0 or agregar?
								//echo "entre";							
								$sql4 = eregi_replace( " )) or ", " or ", $sql_3);
								$sql5 = eregi_replace( " )) and ",")) or ", $sql4);
						 		$sql5.=")";
								$sql6= eregi_replace( ")))",")", $sql5);
								$sql_3=$sql6;
								
																			
								}
		                         if($cmb_ins!=0 and $cmb_en==0){ //--------($cmb_ins==0 or agregar?
								
								 }else{
								 
								 
								 $sql_3 = ereg_replace( " and  "," )) or ", $sql_3);
								// $sql5 = eregi_replace( " )) and ",")) or ", $sql4);
								 $sql_3.=")";
								// $sql_3;
								// $sql_3=$sql4;
									 }
						             
								 $rs_sql3=pg_exec($conn,$sql_3);
							     $sql_3;
						}
								 ?>
								 <br>
								 <form action="" method="post" name="f4" target="_blank">
								
								 
								 <div id="subsectores" > 
								 	 
								<?   
																	
									 $total=pg_numrows($rs_sql3);
								for($f=0;$f<pg_numrows($rs_sql3);$f++){ 
									 $sub=pg_fetch_array($rs_sql3,$f);
									 $nombre=$sub['nombre'];
									 $cod_ensen=$sub['ensenanza'];
									 $cod=$sub['cod_subsector'];
									 
				echo "<input type='checkbox' name='chek".$f."' value='".$nombre."_".$cod."' checked='checked' />".$sub['nombre'];
				echo "<br>";
						
								   
								  }
								 
								?>
								 </div>
								  
                                 <tr>
								 
                                   <td valign="top" colspan="3">								   </td>
                                 </tr>
                                 <tr>
                                   <td colspan="3">&nbsp;</td>
                                 </tr>
                                 <tr>
								 <?   for($g=0;$g<$cantidad;$g++){
								    
									//echo $arreglo[$g];
								      
								  ?>
								 		
                                <input type="hidden" name="arreglo[]" value="<?=$arreglo[$g];?>">	  
									 	 		 
								 <? }?>                        
                                  <td  align="center"colspan="3">
								 <? if($cmb_ins!=0){?>
								 <input type="hidden" value="<?=$cmb_ins;?>" name="rdb">
								 <? }?>
								 <? if($cmb_en!=0){?>
								 <input type="hidden" value="<?=$cmb_en;?>" name="ensenanza">
								 <? }?>			
                                					
								<input type="hidden" value="<?=$cantidad;?>" name="cantidad">
								<input type="hidden" value="<?=$total;?>" name="total">
								<input  align="middle" type="button" name="Submit" value="Buscar" onClick="enviapag7(this.form)"/>
								</form>								</td>
								 </tr>
                            </table>
							   
							   <br>
							   << Reporte en proceso de construcción >>
							   <!--
							   <table width="100%" border="0" cellpadding="3" cellspacing="3">
                                   <tr>
                                     <td colspan="3" class="Estilo1">CALIFICACIONES POR INSTITUCI&Oacute;N </td>
                                   </tr>
                                   <tr>
                                     <td width="37%" class="Estilo1">&nbsp;</td>
                                     <td width="60%">&nbsp;</td>
                                     <td width="3%" rowspan="7">&nbsp;</td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo1"><div align="right" class="Estilo4">A&Ntilde;O ESCOLAR (*)</div></td>
                                     <td><select name="cmbANO" onChange="javascript:enviapagNOTAS(this.form)">
									 <option value="0">Seleccione</option>
									 <? $sql ="SELECT DISTINCT nro_ano FROM ano_escolar WHERE id_institucion in (SELECT rdb FROM corp_instit WHERE num_corp=$_CORPORACION)";
									 	$result = @pg_exec($conn,$sql);
										for($i=0; $i<@pg_numrows($result); $i++){
											$fila = @pg_fetch_array($result,$i);
											if($cmbANO==$fila['nro_ano']){ ?>
											 	<option value="<?=$fila['nro_ano'];?>" selected="selected"><?=$fila['nro_ano'];?></option>
										<? }else{ ?>
											 	<option value="<?=$fila['nro_ano'];?>"><?=$fila['nro_ano'];?></option>
									<? 	   }
										}
									 ?>
                                     </select></td>
                                   </tr>
								   <? if($pesta==3 && $cmbANO!=""){?>
                                   <tr>
                                     <td class="Estilo4"><div align="right">INSTITUCION</div></td>
                                     <td><select name="cmbINST" onChange="javascript:enviapagNOTAS(this.form)">
									 <option value="0">Seleccione</option>
									 <? if($cmbANO!=0){
									 		 $inner = " INNER JOIN ano_escolar ON institucion.rdb=ano_escolar.id_institucion ";
									  		 $wer = "  AND ano_escolar.nro_ano=$cmbANO";
										}	
									 	$sql = "SELECT rdb,nombre_instit FROM institucion $inner WHERE rdb in(SELECT rdb FROM corp_instit WHERE num_corp=$_CORPORACION) $wer";
									 	$result = @pg_exec($conn,$sql);
										for($i=0; $i<@pg_numrows($result); $i++){
											$fila = @pg_fetch_array($result,$i);
											if($cmbINST==$fila['rdb']){ ?>
												<option value="<?=$fila['rdb'];?>" selected="selected"><?=$fila['nombre_instit'];?></option>
											<? }else{ ?>
												<option value="<?=$fila['rdb'];?>" ><?=$fila['nombre_instit'];?></option>
											<? }
										} ?>
                                     </select>                                     </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">TIPO ENSE&Ntilde;ANZA (*) </div></td>
                                     <td><select name="cmbENSENANZA" onChange="javascript:enviapagNOTAS(this.form)">
									 <option value="0">Seleccione</option>
									 <? $sql = "SELECT DISTINCT a.cod_tipo, b.nombre_tipo FROM tipo_ense_inst a INNER JOIN tipo_ensenanza b ON ";
									 	$sql.="a.cod_tipo=b.cod_tipo WHERE  a.rdb IN (select RDB from corp_instIT WHERE num_corp=$_CORPORACION) AND a.cod_tipo<>10 ";
									 	if($cmbINST!=0){
											$sql.=" AND a.rdb=".$cmbINST;
										}
										$resultTE = @pg_exec($conn,$sql);
										for($i=0; $i<@pg_numrows($resultTE); $i++){
											$fila= @pg_fetch_array($resultTE,$i);
											if($cmbENSENANZA==$fila['cod_tipo']){ ?>
											<option value="<?=$fila['cod_tipo'];?>" selected="selected"><? echo $fila['cod_tipo'].",".$fila['nombre_tipo'];?></option>
										<?	}else{ ?>
											<option value="<?=$fila['cod_tipo'];?>"	><? echo $fila['cod_tipo'].",".$fila['nombre_tipo'];?></option>	
										
									<? }
									} ?>		
										
                                     </select>
                                       </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">GRADO</div></td>
                                     <td class="Estilo8">1
                                       <input type="checkbox" name="grado1" value="1"> 
                                       2
                                       <input type="checkbox" name="grado2" value="2"> 
                                       3
                                       <input type="checkbox" name="grado3" value="3"> 
                                       4
                                       <input type="checkbox" name="grado4" value="4">
                                       5
                                       <input type="checkbox" name="grado5" value="5"> 
                                       6
                                       <input type="checkbox" name="grado6" value="6"> 
                                       7 
                                       <input type="checkbox" name="grado7" value="7"> 
                                       8 
                                       <input type="checkbox" name="grado8" value="8">
                                       9
                                       <input type="checkbox" name="grado9" value="9">
                                       10
                                       <input type="checkbox" name="grado10" value="10">
                                       11
                                       <input type="checkbox" name="grado11" value="11">
                                       12
                                       <input type="checkbox" name="grado12" value="12">
									 </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">ASIGNATURA (*)</div></td>
                                     <td><div style="overflow:auto; height:185px">
									 <? $sql = "SELECT DISTINCT ramo.cod_subsector,subsector.nombre FROM ramo INNER JOIN subsector ON ";
									 	$sql.= " ramo.cod_subsector=subsector.cod_subsector WHERE id_curso in (SELECT id_curso FROM curso WHERE id_ano in ";
										$sql.= "(SELECT id_ano FROM ano_escolar WHERE id_institucion in (select rdb FROM corp_instit WHERE num_corp=$_CORPORACION) ";
										if($cmbINST!=0){
											$sql.=" AND id_institucion=".$cmbINST." ";
										}
											$sql.=") ";
										if($cmbENSENANZA!=0){
											$sql.=" AND ensenanza=".$cmbENSENANZA." ";
										}
											$sql.=")";
										$result = pg_exec($conn,$sql);
										$contSubsector = pg_numrows($result);
									?>
									<input name="contSubsector" type="hidden" value="<?=$contSubsector;?>">
									 <table width="%" border="1" cellpadding="2" cellspacing="0">
									  <? for($i=0; $i<pg_numrows($result); $i++){
									  		$fils = pg_fetch_array($result,$i);	?>
									  <tr>
										<td class="Estilo8"><input name="cod_subsector<?=$i;?>" type="checkbox" value="<?=$fils['cod_subsector'];?>"><? echo $fils['cod_subsector']." ".$fils['nombre'];?></td>
										<? 	$i++;
											$fils = pg_fetch_array($result,$i);
										?>
										<td class="Estilo8"><input name="cod_subsector<?=$i;?>" type="checkbox" value="<?=$fils['cod_subsector'];?>"><?=$fils['cod_subsector']." ".$fils['nombre'];?></td>
									  </tr>
									 <? } ?>
									</table>
									 </div>
                                     </td>
                                   </tr>
                                   <tr>
                                     <td class="Estilo4"><div align="right">&nbsp;</div></td>
                                     <td>&nbsp;</td>
                                   </tr>
                                   <tr>
                                     <td colspan="3"><input name="buscar" type="button" onClick="javascript:enviapagReporte(this.form);" value="BUSCAR"> </td>
                                   </tr>
								   <? } ?>
                                 </table>-->
								 </form></td>
						  </tr>
						</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="opcion4">
							   <td valign="top">
									   <form method="post" name="form" action="reportesCorporativos.php">
										<input name="caso" type="hidden" value="2">
										<input name="pesta" type="hidden" value="4">
								  
										<center>
										<? if($caso==""){ ?>
										  <table width="650" border="0" cellpadding="5" cellspacing="0">
											<tr>
											  <td align="center" colspan="2" class="tableindex">Buscador Avanzado</td>
											</tr>
											<tr>
											  <td class="Estilo4">A&ntilde;o</td>
											  <td><select name="cmbANOS">
											    <option value="0">selecione</option>
											    <option value="2002">2002</option>
											    <option value="2003">2003</option>
											    <option value="2004">2004</option>
											    <option value="2005">2005</option>
											    <option value="2006">2006</option>
											    <option value="2007">2007</option>
											    <option value="2008">2008</option>
											    <option value="2009">2009</option>
											    </select>
											  </td>
										    </tr>
											<tr>
											  <td><span class="Estilo4">Tipo Profesional </span></td>
											  <td class="Estilo25">
												<input name="docente" type="radio" value="1">
											  Docentes
											  <input name="docente" type="radio" value="2">
											  Directivo Docente 
											  <input name="docente" type="radio" value="3">
											  T&eacute;cnico-Pedag&oacute;gico</td>
											</tr>
											<tr>
											  <td><span class="Estilo4">Seleccione Institucion </span></td>
											  <td>
											  <div id="subsectores">
											  <table width="100%" border="0" cellpadding="3" cellspacing="0">
												 
		
											 <? $sql ="SELECT rdb, nombre_instit FROM institucion WHERE rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
												$rs_corp = @pg_exec($conn,$sql);
												
												for($i=0;$i<@pg_numrows($rs_corp);$i++){
													$fila = @pg_fetch_array($rs_corp,$i);
											?>
											 <tr>
													<td><input name="instit<?=$i;?>" type="checkbox" value="<?=$fila['rdb'];?>"></td>
													<td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><?="(".$fila['rdb'].") ".$fila['nombre_instit'];?></font></td>
											    </tr>
												
												<? } ?>
												<input name="cont" type="hidden" value="<?=$i;?>">
												</table>
											  </div> 									  </td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td><input type="submit" name="Submit2" value="BUSCAR" class="botonXX"></td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td><p>&nbsp;</p>
											    <table width="85%" border="1" cellspacing="0" cellpadding="5">
                                                  <tr>
                                                    <td><span class="Estilo25">INFORME CONSOLIDADO </span></td>
                                                    <td><a href="reportesCorporativos.php?pesta=4&caso=1" class="Estilo25">ver</a></td>
                                                  </tr>
                                                </table></td>
											</tr>
										  </table>
										  <? } ?>
										 
										</center>
									</form>
									<? if($caso==1){ 
										$sql = "SELECT nombre_corp FROM corporacion WHERE num_corp=".$corporacion;
										$rs_corp = @pg_exec($conn,$sql);
										$nombre_corp = @pg_result($rs_corp,0);
										
										$sql ="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
										$rs_ano = @pg_exec($conn,$sql);
										$nro_ano = @pg_result($rs_ano,0);
										
										$sql="SELECT a.nombre_instit,sum(b.hrs_contrato) as contrato, sum(b.art_69) as art, sum(b.amp_simple) as simple , sum(b.amp_jec) as jec, sum(total_aula) as aula FROM institucion a INNER JOIN dotacion_docente b ON a.rdb=b.rdb WHERE b.rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") GROUP BY nombre_instit ";
										$rs_informe = @pg_exec($conn,$sql);
										
										
										
									?>
										<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
										<tr>
											<td align="center"><div align="center">CORPORACI&Oacute;N DE <?=strtoupper($nombre_corp);?> </div></td>
										</tr>
										<tr>
											<td align="center"><div align="center" class="Estilo7">DOTACI&Oacute;N DOCENTE </div></td>
										</tr>
										<tr>
											<td align="center"><span class="Estilo7"><strong><? echo trim(strtoupper("AÑO ".$nro_ano)) ;?></strong></span></td>
										</tr>
										</table>
										<br>
										<table width="650" border="1" align="center" cellpadding="5" cellspacing="0">
										  <tr>
											<td><span class="Estilo8">INSTITUCION</span></td>
											<td><span class="Estilo8">HORAS<br />
											CONTRATO</span></td>
											<td><span class="Estilo8">ART.69</span></td>
											<td><span class="Estilo8">HORAS<br />
											  AMPLIACI&Oacute;N<br />
											  SIMPLES</span></td>
											<td><span class="Estilo8">HORAS<br />
											  AMPLIACI&Oacute;N <br />
											  JEC </span></td>
											<td><span class="Estilo8">TOTAL<br />
											  HORAS<br />
											  AULA</span></td>
										  </tr>
										  <? for($i=0;$i<@pg_numrows($rs_informe);$i++){
												$fila = @pg_fetch_array($rs_informe,$i);?>
										  <tr>
											<td><span class="Estilo8"><?=$fila['nombre_instit'];?></span></td>
											<td><span class="Estilo8"><?=$fila['contrato'];?></span></td>
											<td><span class="Estilo8"><?=$fila['art'];?></span></td>
											<td><span class="Estilo8"><?=$fila['simple'];?></span></td>
											<td><span class="Estilo8"><?=$fila['jec'];?></span></td>
											<td><span class="Estilo8"><?=$fila['aula'];?></span></td>
										  </tr>
										  <? } ?>
										</table>
										<br>
										<table width="200" border="0" align="center">
										  <tr>
											<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=4&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
											<td class="Estilo4"><a href="printDotacionDocenteConsolidado.php" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
										  </tr>
										</table>
										<? } ?>
									
										<? if($caso==2){
										/*$sql ="SELECT nro_ano FROM ano_escolar WHERE id_ano=".$ano;
										$rs_ano = @pg_exec($conn,$sql);
										$nro_ano = @pg_result($rs_ano,0);*/
												if($docente==1){
												$primera=0;
												for($i=0;$i<$cont;$i++){
													if(${"instit".$i}!="" and $primera==0){
														$rdb.=${"instit".$i};
														$primera=1;
													}elseif(${"instit".$i}!="" and $primera==1){
														$rdb.=",".${"instit".$i};
													}
												}
												$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql);
												
										?>
													<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
													  <tr>
														<td align="center" class="tableindex"><div align="center">DOTACI&Oacute;N DOCENTE </div></td>
													  </tr>
													  <tr>
														<td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$cmbANOS)) ;?></strong></span>
														</td>
													 </tr>
													</table><br>
													<table width="100%" border="0" cellspacing="0" cellpadding="0" align="center">
													<? for($x=0;$x<@pg_numrows($rs_instit);$x++){
															$fila_inst = @pg_fetch_array($rs_instit,$x);
													?>
															
													  <tr>
														<td class="Estilo20"><b><?=strtoupper($fila_inst['nombre_instit']);?></b></td>
													  </tr>
													  <tr>
														<td><table width="100%" border="1" cellpadding="5" cellspacing="0">
											  <tr>
												<td colspan="11" class="Estilo8">DOCENTES</td>
											  </tr>
											  <tr>
												<td class="Estilo11">RUT</td>
												<td class="Estilo11">CALIDAD <br />
												CONT. </td>
												<td class="Estilo11">NOMBRE</td>
												<td class="Estilo11">HORAS<br />
												CONT.</td>
												<td class="Estilo11">ART.69</td>
											  <td class="Estilo11">HORAS<br />
												  AMPLIAC. <br />
												  SIMPLES</td>
												<td class="Estilo11">HORAS<br />
												  AMPLIAC.<br />
												  JEC</td>
											  <td class="Estilo11">TOTAL<br />
												  HORAS<br />
												  AULA</td>
												<td class="Estilo11">HORAS<br />
												EXCED.</td>
												<td class="Estilo11">CARGO /<br />
												ASIG. / <br />
												ESPECIALIDAD </td>
												<td class="Estilo11">OBSERVACI&Oacute;N</td>
											  </tr>
											  <? 
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANOS."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																				
												$sql =" SELECT a.*,b.dig_rut,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ";
												$sql.=" b.ape_mat as nombre FROM dotacion_docente a ";
												$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst." ";
												$sql.=" AND cargo=5 ORDER BY ape_pat ASC ";
												$rs_empleado = @pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												
												$total_contrato = 0;
												$total_69 = 0;
												$total_simple = 0;
												$total_jec = 0;
												$total_aula = 0;
												$total_ex = 0;
											  for($i=0;$i<@pg_numrows($rs_empleado);$i++){
													$fila_emp = @pg_fetch_array($rs_empleado,$i);
													if($fila_emp['tipo_emp']==0)
														$contrato = "&nbsp;";
													elseif($fila_emp['tipo_emp']==1)
														$contrato="INDEFINIDO";
													elseif($fila_emp['tipo_emp']==2)
														$contrato="PLAZO FIJO";
													elseif($fila_emp['tipo_emp']==3)
														$contrato="HONORARIOS";
											  ?>
											  <tr>
												<td class="Estilo20"><div align="right">
													<?=$fila_emp['rut_emp']."-".$fila_emp['dig_rut'];?>
												</div></td>
												<td class="Estilo20"><?=$contrato;?></td>
												<td class="Estilo20"><div align="left"><?=strtoupper($fila_emp['nombre']);?></div></td>
												<td class="Estilo20"><?=$fila_emp['hrs_contrato'];?></td>
												<td class="Estilo20"><?=$fila_emp['art_69'];?></td>
												<td class="Estilo20"><?=$fila_emp['amp_simple'];?></td>
												<td class="Estilo20"><?=$fila_emp['amp_jec'];?></td>
												<td class="Estilo20"><?=$fila_emp['total_aula'];?></td>
												<td class="Estilo20"><?=$fila_emp['hrs_excedente'];?></td>
												<td class="Estilo20"><?=strtoupper($fila_emp['cargo_asig']);?></td>
												<td class="Estilo20"><?=$fila_emp['obs'];?></td>
											  </tr>
											  <? 	$total_contrato += $fila_emp['hrs_contrato'];
											  		$total_69 += $fila_emp['art_69'];
													$total_simple += $fila_emp['amp_simple'];
													$total_jec += $fila_emp['amp_jec'];
													$total_aula += $fila_emp['total_aula'];
													$total_ex += $fila_emp['hrs_excedente'];
													
											  } ?>
											  <tr>
												<td colspan="3" class="Estilo20">TOTALES (<?=$i;?>)</td>
												<td class="Estilo20"><?=$total_contrato;?></td>
												<td class="Estilo20"><?=$total_69;?></td>
												<td class="Estilo20"><?=$total_simple;?></td>
												<td class="Estilo20"><?=$total_jec;?></td>
												<td class="Estilo20"><?=$total_aula;?></td>
												<td class="Estilo20"><?=$total_ex;?></td>
												<td colspan="2" class="Estilo20">&nbsp;</td>
											  </tr>
								 		</table></td>
													  </tr>
													  <tr>
													  	<td>&nbsp;</td>
													  </tr>
													  <? } ?>
													</table>
								 	<table width="200" border="0" align="center">
											  <tr>
												<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=4&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
												<td class="Estilo4"><a href="printDotacionDocente_C.php?rdb=<?=$rdb;?>&cmbANOS=<?=$cmbANOS;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
											  </tr>
									</table>		
											<? }
												if($docente==2){
												$primera=0;
												for($i=0;$i<$cont;$i++){
													if(${"instit".$i}!="" and $primera==0){
														$rdb.=${"instit".$i};
														$primera=1;
													}elseif(${"instit".$i}!="" and $primera==1){
														$rdb.=",".${"instit".$i};
													}
												}
												$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql);
												
												
												?>
											<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td align="center" class="tableindex"><div align="center">DOTACI&Oacute;N DOCENTE </div></td>
                                              </tr>
                                              <tr>
                                                <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$cmbANOS)) ;?></strong></span></td>
                                              </tr>
                                            </table><br>
											<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
											<? for($x=0;$x<@pg_numrows($rs_instit);$x++){
													$fila_inst = @pg_fetch_array($rs_instit,$x);
											?>
											  <tr>
												<td class="Estilo20"><b><?=strtoupper($fila_inst['nombre_instit']);?></b></td>
											  </tr>
											  <tr>
												<td><table width="750" border="1" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td colspan="7" class="Estilo20">    DIRECTIVOS DOCENTES </td>
											  </tr>
											  <tr>
												<td class="Estilo20">RUT</td>
												<td class="Estilo20">CALIDAD <br />
											    CONTRATO </td>
												<td class="Estilo20">NOMBRE</td>
												<td class="Estilo20">HORAS<br />
											    CONTRATO</td>
												<td class="Estilo20">AMPLIACI&Oacute;N<br />
											    HORARIA</td>
												<td class="Estilo20">TOTAL</td>
												<td class="Estilo20">TIPO<br />
												  FUNCI&Oacute;N</td>
											  </tr>
											   <? 
											  	
												
												$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANOS."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																						
												$sql =" SELECT a.*,b.dig_rut,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ";
												$sql.=" b.ape_mat as nombre FROM dotacion_docente a ";
												$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst." ";
												$sql.=" AND cargo in (1,2,6) ORDER BY ape_pat ASC ";
												$rs_empleado = pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
												
												$total_contrato = 0;
												$total_simple	= 0;
												$total_aula		= 0;
											   	for($i=0;$i<@pg_numrows($rs_empleado);$i++){
													$fila_emp = @pg_fetch_array($rs_empleado,$i);
													if($fila_emp['tipo_emp']==0)
														$contrato = "&nbsp;";
													elseif($fila_emp['tipo_emp']==1)
														$contrato="INDEFINIDO";
													elseif($fila_emp['tipo_emp']==2)
														$contrato="PLAZO FIJO";
													elseif($fila_emp['tipo_emp']==3)
														$contrato="HONORARIOS";
												?>
											  <tr>
												<td class="Estilo20"><div align="right" class="Estilo21">
													<?=$fila_emp['rut_emp']."-".$fila_emp['dig_rut'];?>
											    </div></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$contrato;?>
												</span></td>
												<td class="Estilo20"><div align="left" class="Estilo21"><?=strtoupper($fila_emp['nombre']);?></div></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$fila_emp['hrs_contrato'];?>
												</span></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$fila_emp['amp_simple'];?>
												</span></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$fila_emp['total_aula'];?>
												</span></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=strtoupper($fila_emp['tipo_func']);?>
												</span></td>
											  </tr>
											  <? 	$total_contrato = $total_contrato + $fila_emp['hrs_contrato'];
													$total_simple	= $total_simple + $fila_emp['amp_simple'];
													$total_aula		= $total_aula + $fila_emp['total_aula'];
															
											 } ?>
											  <tr>
												<td colspan="3" class="Estilo20">TOTALES (<?=$i;?>)</td>
												<td class="Estilo20"><?=$total_contrato;?></td>
												<td class="Estilo20"><?=$total_simple;?></td>
												<td class="Estilo20"><?=$total_aula;?></td>
												<td class="Estilo20">&nbsp;</td>
											  </tr>
										    </table></td>
											  </tr>
											  <tr>
											  	<td>&nbsp;</td>
											  </tr>
											  <? } ?>
											</table>

											
													<table width="200" border="0" align="center">
											  <tr>
												<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=4&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
												<td class="Estilo4"><a href="printDotacionNoDocente_C.php?rdb=<?=$rdb;?>&cmbANOS=<?=$cmbANOS;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
											  </tr>
											</table>	
											<? }
											if($docente==3){
																 
												$primera=0;
												for($i=0;$i<$cont;$i++){
													if(${"instit".$i}!="" and $primera==0){
														$rdb.=${"instit".$i};
														$primera=1;
													}elseif(${"instit".$i}!="" and $primera==1){
														$rdb.=",".${"instit".$i};
													}
												}
												
												$sql = "SELECT nombre_instit, rdb FROM institucion WHERE rdb in (".$rdb.")";
												$rs_instit = @pg_exec($conn,$sql);
												
												?>
											<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                              <tr>
                                                <td align="center" class="tableindex"><div align="center">DOTACI&Oacute;N TÉCNICO PEDAGÓGICOS </div></td>
                                              </tr>
                                              <tr>
                                                <td align="center"><span class="Estilo2"><strong><? echo trim(strtoupper("AÑO ".$cmbANOS)) ;?></strong></span></td>
                                              </tr>
                                            </table>
											<br>
											<table width="750" border="0" cellspacing="0" cellpadding="0" align="center">
											<? for($v=0;$v<@pg_numrows($rs_instit);$v++){
												$fila_inst=@pg_fetch_array($rs_instit,$v);
												
												
											?>
											  <tr>
												<td class="Estilo20"><b><?=strtoupper($fila_inst['nombre_instit']);?></b></td>
											  </tr>
											  <tr>
												<td><table width="750" border="1" align="center" cellpadding="5" cellspacing="0">
											  <tr>
												<td colspan="7" class="Estilo20">TÉCNICO PEDAGÓGICOS </td>
											  </tr>
											  <tr>
												<td class="Estilo20">RUT</td>
												<td class="Estilo20">CALIDAD <br />
											    CONTRATO </td>
												<td class="Estilo20">NOMBRE</td>
												<td class="Estilo20">HORAS<br />
											    CONTRATO</td>
												<td class="Estilo20">AMPLIACI&Oacute;N<br />
											    HORARIA</td>
												<td class="Estilo20">TOTAL</td>
												<td class="Estilo20">TIPO<br />
												  FUNCI&Oacute;N</td>
											  </tr>
											   <? 
											  	$sql = "SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_inst['rdb']." AND nro_ano=".$cmbANOS."  ";
												$rs_ano = pg_exec($conn,$sql);
												$ano_inst = pg_result($rs_ano,0);
												
												if($ano_inst=="") $ano_inst=0;
																						
												$sql =" SELECT a.*,b.dig_rut,b.nombre_emp || cast(' ' as varchar) || b.ape_pat || cast(' ' as varchar) || ";
												$sql.=" b.ape_mat as nombre FROM dotacion_docente a ";
												$sql.=" INNER JOIN empleado b ON a.rut_emp=b.rut_emp WHERE rdb=".$fila_inst['rdb']." and id_ano=".$ano_inst." ";
												$sql.=" AND cargo not in (1,2,5,6) ORDER BY ape_pat ASC ";
												$rs_empleado = pg_exec($conn,$sql) or die ("SELECT FALLÓ (DotacionDocente):".$sql);
											  		$total_contrato =0;
													$total_simple	=0;
													$total_aula		=0;
											   for($i=0;$i<@pg_numrows($rs_empleado);$i++){
													$fila_emp = @pg_fetch_array($rs_empleado,$i);
													if($fila_emp['tipo_emp']==0)
														$contrato = "&nbsp;";
													elseif($fila_emp['tipo_emp']==1)
														$contrato="Indefinido";
													elseif($fila_emp['tipo_emp']==2)
														$contrato="Plazo Fijo";
													elseif($fila_emp['tipo_emp']==3)
														$contrato="Honorarios";
													
													
												?>
											  <tr>
												<td class="Estilo20"><div align="right" class="Estilo21">
													<?=$fila_emp['rut_emp']."-".$fila_emp['dig_rut'];?>
											    </div></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$contrato;?>
												</span></td>
												<td class="Estilo20"><div align="left" class="Estilo21"><?=strtoupper($fila_emp['nombre']);?></div></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$fila_emp['hrs_contrato'];?>
												</span></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$fila_emp['amp_simple'];?>
												</span></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$fila_emp['total_aula'];?>
												</span></td>
												<td class="Estilo20"><span class="Estilo21">
											    <?=$fila_emp['tipo_func'];?>
												</span></td>
											  </tr>
											  <? 	$total_contrato = $total_contrato + $fila_emp['hrs_contrato'];
													$total_simple	= $total_simple + $fila_emp['amp_simple'];
													$total_aula		= $total_aula + $fila_emp['total_aula'];
															
													  } ?>
											  <tr>
												<td colspan="3" class="Estilo20">TOTALES (<?=$i;?>)</td>
												<td class="Estilo20"><?=$total_contrato;?></td>
												<td class="Estilo20"><?=$total_simple;?></td>
												<td class="Estilo20"><?=$total_aula;?></td>

												<td class="Estilo20">&nbsp;</td>
											  </tr>
										    </table></td>
											  </tr>
											  <tr>
											  	<td>&nbsp; </td>
											  </tr>
											 <? } ?>
											</table>

											
													<table width="200" border="0" align="center">
											  <tr>
												<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=4&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
												<td class="Estilo4"><a href="printDotacionTecnico_C.php?rdb=<?=$rdb;?>&cmbANOS=<?=$cmbANOS;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
											  </tr>
											</table>	
											<? }?>
																
									   <? } ?>
									   
		
		
		
		
										
							   </td>
							 </tr>
							</table>
							
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="opcion5">
                               <td valign="top"><table width="704" border="0">
                                 <tr>
                                   <td height="37" colspan="2" class="Estilo1">Reportes&nbsp;</td>
                                   
                                 </tr>
                                 <tr>
                                   <td width="575" height="10" class="Estilo25">01 Total de Postulaciones de Todos los Establecimientos</td>
                                   <td width="119"><a href="../institucion/ano/reportes/postulacion/Rprt6.php" target="_blank">Click Acá</a></td>
                                 </tr>
								 <tr>
								 <td height="10" class="Estilo25">02 Total de Postulaciones a Establecimientos Corporación</td>
								 <td> <a href="../institucion/ano/reportes/postulacion/Rprt7.php" target="_blank">Click Acá</a></td>
								 </tr>
								 <tr>
								 <td height="10" class="Estilo25">03 Total de Postulaciones de Todos Los Establecimientos</td>
								 <td> <a href="../institucion/ano/reportes/postulacion/Rprt8.php" target="_blank">Click Acá</a></td>
								 </tr>
								 <tr>
								 <td height="10" class="Estilo25">04 Total Aceptados de Todos Los Establecimientos</td>
								 <td> <a href="../institucion/ano/reportes/postulacion/Rprt9.php" target="_blank">Click Acá</a></td>
								 </tr>
                               </table>
							   </td>
							 </tr>
							</table>
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
                             <tr id="proyecto">
							 	<td><BR>
								 <form method="post" name="form" action="reportesCorporativos.php">
								<input name="pesta" type="hidden" value="6">
								
								<table width="518" border="0" align="center" cellpadding="5">
								  <tr>
								    <td colspan="4" class="tableindex">PROYECTO INTEGACION Y/O GRUPO DIFERENCIAL </td>
							      </tr>
								  <tr>
								    <td>&nbsp;</td>
								    <td><span class="Estilo25">A&ntilde;o escolar :</span>
										<select name="cmbANO_P" class="ddlb_x" onChange="enviapagP(this.form)">
											<option value="0">seleccione</option>
											<? for($i=2002;$i<2010;$i++){
												if($i==$cmbANO_P){?>
													<option value="<?=$i;?>" selected="selected"><?=$i;?></option>
											<?  }else{?>		
													<option value="<?=$i;?>"><?=$i;?></option>
											<? 	}
											}?>										
										</select>									</td>
								    <td>&nbsp;</td>
								    <td>&nbsp;</td>
							      </tr>
								  
								  <? if($caso_p=="" AND $cmbANO_P!=0){ ?>
								  <tr>
								    <td>&nbsp;</td>
								    <td>&nbsp;</td>
								    <td class="tableindex">VER</td>
								    <td class="tableindex">IMPRIMIR</td>
							      </tr>
								  <tr>
									<td width="30"><span class="Estilo25">1.-</span></td>
									<td width="361"><span class="Estilo25">Escuelas con Proyecto de Integraci&oacute;n </span></td>
								    <td><div align="center">
								      <input name="VER1" type="button" id="VER1" value="V" class="botonXX" onClick="window.location='reportesCorporativos.php?caso_p=2&pesta=6&cmbANO_P=<?=$cmbANO_P;?>'">
							        </div></td>
							        <td><div align="center">
							          <input name="IMPRIMIR1" type="button" class="botonXX" id="IMPRIMIR1" onClick="MM_openBrWindow('printProyectoGrupo.php?caso_p=2&cmbANO_P=<?=$cmbANO_P;?>','','scrollbars=yes')" value="I" alt="IMPRIMIR" >
						            </div></td>
								  </tr>
								  <tr>
									<td><span class="Estilo25">2.-</span></td>
									<td><span class="Estilo25">Seguimiento de Proyectos de Integraci&oacute;n </span></td>
								    <td><div align="center">
								      <input name="VER2" type="button" id="VER2" value="V" class="botonXX"  onClick="window.location='reportesCorporativos.php?caso_p=3&pesta=6&cmbANO_P=<?=$cmbANO_P;?>'">
							        </div></td>
								    <td><div align="center">
								      <input name="IMPRIMIR2" type="button" class="botonXX" id="IMPRIMIR2" onClick="MM_openBrWindow('printProyectoGrupo.php?caso_p=3&cmbANO_P=<?=$cmbANO_P;?>','','scrollbars=yes')" value="I" >
							        </div></td>
								  </tr>
								  <tr>
									<td><span class="Estilo25">3.-</span></td>
									<td><span class="Estilo25">Escuelas con Grupo Diferencial </span></td>
								    <td><div align="center">
								      <input name="VER3" type="button" id="VER3" value="V" class="botonXX"  onClick="window.location='reportesCorporativos.php?caso_p=4&pesta=6&cmbANO_P=<?=$cmbANO_P;?>'">
							        </div></td>
								    <td><div align="center">
								      <input name="IMPRIMIR3" type="button" class="botonXX" id="IMPRIMIR3" onClick="MM_openBrWindow('printProyectoGrupo.php?caso_p=4&cmbANO_P=<?=$cmbANO_P;?>','','scrollbars=yes')" value="I" >
							        </div></td>
								  </tr>
								  <tr>
									<td><span class="Estilo25">4.-</span></td>
									<td><span class="Estilo25">Seguimiento de Grupo Diferencial </span></td>
								    <td><div align="center">
								      <input name="VER4" type="button" id="VER4" value="V" class="botonXX"  onClick="window.location='reportesCorporativos.php?caso_p=5&pesta=6&cmbANO_P=<?=$cmbANO_P;?>'">
							        </div></td>
								    <td><div align="center">
								      <input name="IMPRIMIR4" type="button" class="botonXX" id="IMPRIMIR4" onClick="MM_openBrWindow('printProyectoGrupo.php?caso_p=5&cmbANO_P=<?=$cmbANO_P;?>','','status=yes,scrollbars=yes')" value="I" >
							        </div></td>
								  </tr>
								 <? } ?>
								  <tr>
								    <td>&nbsp;</td>
								    <td>&nbsp;</td>
							        <td width="38">&nbsp;</td>
								    <td width="39">&nbsp;</td>
								  </tr>
								</table>
								
								</form>
								<? if($caso_p==2){
										/*$sql = "SELECT count(e.*) as total,a.nombre_instit,b.nombre,c.hrs_contrato,c.total_aula, d.nombre_emp || ";
										$sql.=" cast(' ' as varchar) || d.ape_pat || cast(' ' as  varchar) as nombre_emp,b.objetivo  FROM institucion a ";
										$sql.=" INNER JOIN proyecto_grupo b ON a.rdb=b.rdb INNER JOIN dotacion_docente c ON b.rut_emp=c.rut_emp  INNER JOIN ";
										$sql.=" empleado d ON (b.rut_emp=d.rut_emp AND c.rut_emp=d.rut_emp) LEFT JOIN inscribe_proyecto e ON  ";
										$sql.=" b.id_proy=e.id_proy WHERE b.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND ";
										$sql.= " b.tipo=1 GROUP BY a.nombre_instit,b.nombre,c.hrs_contrato,c.total_aula, d.nombre_emp,d.ape_pat,b.objetivo ";*/
										$sql = "SELECT count(a.*) as total,b.nombre as diag,c.nombre_instit, e.nombre_emp || cast(' ' as varchar) || e.ape_pat || ";
										$sql.= "cast(' ' as varchar) as nombre_emp, f.hrs_contrato,f.total_aula,d.objetivo ";
										$sql.= "FROM alumno_proyecto a INNER JOIN diagnostico b ON  a.id_dignos=b.id_dignos ";
										$sql.= "INNER JOIN institucion c ON a.rdb=c.rdb INNER JOIN proyecto_grupo d ON a.id_proy=d.id_proy AND d.rdb=c.rdb ";
										$sql.= "INNER JOIN empleado e ON d.rut_emp=e.rut_emp INNER JOIN dotacion_docente f ON f.rut_emp=e.rut_emp AND f.rut_emp=d.rut_emp ";
										$sql.= "AND f.rdb=a.rdb AND f.rdb=c.rdb AND f.rdb=d.rdb INNER JOIN ano_escolar g ON a.id_ano=g.id_ano ";
										$sql.= "WHERE c.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND d.tipo=1 AND g.nro_ano=".$cmbANO_P."";
										$sql.= "group by b.nombre,c.nombre_instit,e.nombre_emp,e.ape_pat, f.hrs_contrato,f.total_aula ,d.objetivo ";
										$rs_proyecto = @pg_exec($conn,$sql);
								?>
									<table width="100%" border="1" cellpadding="3" cellspacing="0" >
									  <tr>
										<td colspan="9" class="tableindex">DATOS ESCUELAS CON PROYECTO DE INTEGRACI&Oacute;N </td>
									  </tr>
									  <tr class="tabla04">
										<td>N&ordm;</td>
										<td>ESTABLECIMIENTO</td>
										<td>PROFESOR</td>
										<td>PROYECTO<br>
									    INTEGRACI&Oacute;N</td>
										<td><p>N&ordm; 
										  ALUMNOS<br>
										  POR PROYECTO </p>
									    </td>
										<td>HORAS<br>
									    CONTRATO</td>
										<td>HORAS <br>
									    AULA</td>
										<td>RANGO<br>
									    ATENCI&Oacute;N</td>
										<td>OBSERVACIONES</td>
									  </tr>
									  <? for($i=0;$i<@pg_numrows($rs_proyecto);$i++){
									  		$fila_pro =@pg_fetch_array($rs_proyecto,$i);
											$cont_pro++;
										?>
									  	
									  <tr>
										<td class="datos"><?=$cont_pro;?></td>
										<td class="datos"><?=$fila_pro['nombre_instit'];?></td>
										<td class="datos"><?=$fila_pro['nombre_emp'];?></td>
										<td class="datos"><?=$fila_pro['diag'];?></td>
										<td class="datos"><?=$fila_pro['total'];?></td>
										<td class="datos"><?=$fila_pro['hrs_contrato'];?></td>
										<td class="datos"><?=$fila_pro['total_aula'];?></td>
										<td class="datos">&nbsp;</td>
										<td class="datos"><?=$fila_pro['objetivo'];?></td>
									  </tr>
									  <? 	$cont_alumno = $cont_alumno + $fila_pro['total'];
									  		$cont_contrato = $cont_contrato + $fila_pro['hrs_contrato'];
											$cont_aula = $cont_aula + $fila_pro['total_aula'];
									  } ?>
									  <tr class="tabla04">
										<td>&nbsp;</td>
										<td>TOTAL</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><?=$cont_alumno;?>&nbsp;</td>
										<td><?=$cont_contrato;?>&nbsp;</td>
										<td><?=$cont_aula;?>&nbsp;</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									  </tr>
									</table>
									<br>
					
									<table width="200" border="0" align="center">
									  <tr>
										<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=6&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
										<td class="Estilo4"><a href="printProyectoGrupo.php?caso_p=2" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
									  </tr>
									</table>	
								<? } 
								if($caso_p==3){
								$sql = "SELECT rdb,nombre_instit,id_ano FROM institucion INNER JOIN ano_escolar ON rdb=id_institucion WHERE rdb IN(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_P."";
	$rs_instit = @pg_exec($conn,$sql);?>
<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
  <tr>
	<td colspan="14"  class="tableindex">FICHA SEGUIMIENTO PROYECTO INTEGRACI&Oacute;N POR ESTABLECIMIENTO </td>
  </tr>
  <? 	$sql = "select id_dignos,nombre from diagnostico where rdb IN (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") and tipo=1";
  		$rs_diag = @pg_exec($conn,$sql);
  ?>	
  <tr  class="tabla04">
	<td>N&ordm;</td>
	<td>ESTABLECIMIENTO</td>
	<? for($i=0;$i<@pg_numrows($rs_diag);$i++){
			$fila_d = @pg_fetch_array($rs_diag,$i);
	?>
	<td><?=$fila_d['nombre'];?></td>
	<? } ?>
	<td>TOTAL<br> PROYECTO<br>INTEGRACI&Oacute;N</td>
	<td>APROBADOS</td>
	<td>REPROBADOS</td>
	<td>MEJORA<br>RENDIMIENTO<br> LENGUAJE</td>
	<td>MEJORA<br>RENDIMIENTO<br>MATEMATICAS</td>
	<td>RETIRADO</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
  		$fila_ins = @pg_fetch_array($rs_instit,$i);
		$cont++;
		
		/*$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE   ";
		$sql.="b.rdb=".$fila_ins['rdb']." AND id_ano=".$fila_ins['id_ano']." AND lenguaje=1 AND tipo=1";
		$rs_lenguaje =@pg_exec($conn,$sql);
		$cont_lenguaje = @pg_result($rs_lenguaje,0);
		
		$sql ="SELECT count(*) as mental FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND deficit_mental=1 AND tipo=1";
		$rs_mental =@pg_exec($conn,$sql);
		$cont_mental = @pg_result($rs_mental,0);
		
		$sql ="SELECT count(*) as audicion FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND audicion=1 AND tipo=1";
		$rs_audicion =@pg_exec($conn,$sql);
		$cont_audicion = @pg_result($rs_audicion,0);*/
		
		$sql="SELECT COUNT(*) as proyecto FROM proyecto_grupo WHERE rdb=".$fila_ins['rdb']." AND tipo=1";
		$rs_total = @pg_exec($conn,$sql);
		$cont_total = @pg_result($rs_total,0);
		
		$sql ="SELECT count(*) as mlenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_lenguaje=1 AND tipo=1";
		$rs_mlenguaje =@pg_exec($conn,$sql);
		$cont_mlenguaje = @pg_result($rs_mlenguaje,0);
		
		$sql ="SELECT count(*) as matematica FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_matematica=1 AND tipo=1";
		$rs_matematica =@pg_exec($conn,$sql);
		$cont_matematica = @pg_result($rs_matematica,0);
		
		$sql ="SELECT count(*) as aprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND aprobado=1 AND tipo=1";
		$rs_aprobado =@pg_exec($conn,$sql);
		$cont_aprobado = @pg_result($rs_aprobado,0);
		
		$sql ="SELECT count(*) as reprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND reprobado=1 AND tipo=1";
		$rs_reprobado =@pg_exec($conn,$sql);
		$cont_reprobado = @pg_result($rs_reprobado,0);
		
		$sql ="SELECT count(*) as retirado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
		$sql.="id_ano=".$fila_ins['id_ano']." AND retirado=1 AND tipo=1";
		$rs_retirado =@pg_exec($conn,$sql);
		$cont_retirado = @pg_result($rs_retirado,0);
	?>
  <tr>
	<td class="datos"><?=$cont;?></td>
	<td class="datos"><?=$fila_ins['nombre_instit'];?></td>
	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){
			$fila_di = @pg_fetch_array($rs_diag,$j);
			$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE   ";
			$sql.="b.rdb=".$fila_ins['rdb']." AND id_ano=".$fila_ins['id_ano']." AND id_dignos=".$fila_di['id_dignos']." AND tipo=1";
			$rs_lenguaje =@pg_exec($conn,$sql);
			$cont_diag = @pg_result($rs_lenguaje,0);
			$total_dig[$j]=$total_dig[$j] + $cont_diag;
	?>
	<td class="datos"><?=$cont_diag;?></td>
	<? } ?>
	<td class="datos"><?=$cont_total;?></td>
	<td class="datos"><?=$cont_aprobado;?></td>
	<td class="datos"><?=$cont_reprobado;?></td>
	<td class="datos"><?=$cont_mlenguaje;?></td>
	<td class="datos"><?=$cont_matematica;?></td>
	<td class="datos"><?=$cont_retirado;?></td>
  </tr>
  <? 	/*$total_lenguaje = $total_tea + $cont_lenguaje;
		$total_mental = $total_mental + $cont_mental;
		$total_audicion = $total_audicion + $cont_audicion;*/
		$total_reprobado = $total_reprobado + $cont_reprobado;
		$total_retirado = $total_retirado + $cont_retirado;
		$total_aprobado = $total_aprobado + $cont_aprobado;
		$total_mlenguaje = $total_mlenguaje + $cont_mlenguaje;
		$total_matematica = $total_matematica + $cont_matematica;
		$total_alum = $total_alum + $cont_total;
  } ?>
  <tr  class="tabla04">
	<td>&nbsp;</td>
	<td>TOTAL</td>
	<? for($j=0;$j<@pg_numrows($rs_diag);$j++){ ?>
	<td><?=$total_dig[$j];?></td>
	<? } ?>
	<td><?=$total_alum;?></td>
	<td><?=$total_aprobado;?></td>
	<td><?=$total_reprobado;?></td>
	<td><?=$total_mlenguaje;?></td>
	<td><?=$total_matematica;?></td>
	<td><?=$total_retirado;?></td>
  </tr>
</table>
								<br>
                                <table width="200" border="0" align="center">
                                  <tr>
                                    <td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=6&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
                                    <td class="Estilo4"><a href="printProyectoGrupo.php?caso_p=3&cmbANO_P=<?=$cmbANO_P;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
                                  </tr>
                                </table>
                             

								<? } 
									if($caso_p==4){ 
									/*$sql ="SELECT count(e.*) as total,a.nombre_instit,b.nombre,c.hrs_contrato,c.total_aula,d.nombre_emp || cast(' ' as varchar) || ";
									$sql.=" d.ape_pat || cast(' ' as  varchar) as nombre_emp,b.objetivo  FROM institucion a INNER JOIN proyecto_grupo b ";
									$sql.=" ON a.rdb=b.rdb INNER JOIN dotacion_docente c ON b.rut_emp=c.rut_emp  INNER JOIN empleado d ON ";
									$sql.=" (b.rut_emp=d.rut_emp AND c.rut_emp=d.rut_emp) LEFT JOIN inscribe_proyecto e ON  b.id_proy=e.id_proy ";
									$sql.=" WHERE b.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND b.tipo=2 GROUP BY  a.nombre_instit, ";
									$sql.=" b.nombre,c.hrs_contrato,c.total_aula, d.nombre_emp,d.ape_pat,b.objetivo  ";*/
									$sql = "SELECT count(a.*) as total,b.nombre as diag,c.nombre_instit, e.nombre_emp || cast(' ' as varchar) || e.ape_pat || ";
									$sql.= "cast(' ' as varchar) as nombre_emp, f.hrs_contrato,f.total_aula,d.objetivo ";
									$sql.= "FROM alumno_proyecto a INNER JOIN diagnostico b ON  a.id_dignos=b.id_dignos ";
									$sql.= "INNER JOIN institucion c ON a.rdb=c.rdb INNER JOIN proyecto_grupo d ON a.id_proy=d.id_proy AND d.rdb=c.rdb ";
									$sql.= "INNER JOIN empleado e ON d.rut_emp=e.rut_emp INNER JOIN dotacion_docente f ON f.rut_emp=e.rut_emp AND f.rut_emp=d.rut_emp ";
									$sql.= "AND f.rdb=a.rdb AND f.rdb=c.rdb AND f.rdb=d.rdb INNER JOIN ano_escolar g ON a.id_ano=g.id_ano ";
									$sql.= "WHERE c.rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND d.tipo=2 AND g.nro_ano=".$cmbANO_P."";
									$sql.= "group by b.nombre,c.nombre_instit,e.nombre_emp,e.ape_pat, f.hrs_contrato,f.total_aula ,d.objetivo ";
									$rs_grupo=@pg_exec($conn,$sql);
									
									
							?>		
									<table width="100%" border="1" cellspacing="0" cellpadding="3">
									  <tr>
										<td colspan="9" class="tableindex">DATOS ESCUELAS CON GRUPO DIFERENCIAL </td>
									  </tr>
									  <tr  class="tabla04">
										<td>N&ordm;</td>
										<td>ESTABLECIMIENTO</td>
										<td>PROFESOR</td>
										<td>GRUPO<br>DIFERENCIAL</td>
										<td><p>N&ordm; ALUMNOS<br>POR GRUPO</p></td>
										<td><p>HORAS<br>
										  CONTRATO</p>
									    </td>
										<td>HORAS<br>AULA</td>
										<td>RANGO<br>ATENCI&Oacute;N</td>
										<td>OBSERVACIONES</td>
									  </tr>
									  <? for($i=0;$i<@pg_numrows($rs_grupo);$i++){
									  		$fila_grupo= @pg_fetch_array($rs_grupo,$i);
											$cont_g++;
										?>
									  <tr>
										<td class="datos"><?=$cont_g;?></td>
										<td class="datos"><?=$fila_grupo['nombre_instit'];?></td>
										<td class="datos"><?=$fila_grupo['nombre_emp'];?></td>
										<td class="datos"><?=$fila_grupo['diag'];?></td>
										<td class="datos"><?=$fila_grupo['total'];?></td>
										<td class="datos"><?=$fila_grupo['hrs_contrato'];?></td>
										<td class="datos"><?=$fila_grupo['total_aula'];?></td>
										<td class="datos">&nbsp;</td>
										<td class="datos"><?=$fila_grupo['objetivo'];?></td>
									  </tr>
									  <? 	$total_alum_g = $total_alum_g + $fila_grupo['total'];
									  		$total_contrato_g = $total_contrato_g + $fila_grupo['hrs_contrato'];
											$total_aula_g = $total_aula_g + $fila_grupo['total_aula'];
									  
									  } ?>
									  <tr class="tabla04">
										<td>&nbsp;</td>
										<td>TOTAL</td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><?=$total_alum_g;?></td>
										<td><?=$total_contrato_g;?></td>
										<td><?=$total_aula_g;?></td>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
									  </tr>
									</table>
									<br>
                                <table width="200" border="0" align="center">
                                  <tr>
                                    <td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=6&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
                                    <td class="Estilo4"><a href="printProyectoGrupo.php?caso_p=4" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
                                  </tr>
                                </table>
                             
								<? } 
								if($caso_p==5){
								$sql = "SELECT rdb,nombre_instit,id_ano FROM institucion INNER JOIN ano_escolar ON rdb=id_institucion WHERE rdb IN(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_P."";
								$rs_instit = @pg_exec($conn,$sql);?>
							<table width="850" border="1" align="center" cellpadding="3" cellspacing="0">
							  <tr>
								<td colspan="16"  class="tableindex">FICHA SEGUIMIENTO GRUPO DIFERENCIAL POR ESTABLECIMIENTO </td>
							  </tr>
							   <? 	$sql = "select id_dignos,nombre from diagnostico where tipo=2";
  									$rs_diag = @pg_exec($conn,$sql);
  ?>	
							  <tr  class="tabla04">
								<td>N&ordm; </td>
								<td>ESTABLECIMIENTO</td>
								<? for($i=0;$i<@pg_numrows($rs_diag);$i++){
										$fila_d = @pg_fetch_array($rs_diag,$i);
								?>
								<td><?=$fila_d['nombre'];?></td>
								<? } ?>
								<td>TOTAL<br>
								GD</td>
								<td>APROBADOS</td>
								<td>REPROBADOS</td>
								<td><p>MEJORA<br>
								  RENDIMIENTO<br>
								LENGUAJE</p>
								</td>
								<td>MEJORA<br>
								  RENDIMIENTO<br>
								  MATEMATICAS</td>
								<td>RETIRADOS</td>
							  </tr>
							  <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
									$fila_ins = @pg_fetch_array($rs_instit,$i);
									$cont++;
									
									/*$sql ="SELECT count(*) as pa FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND pa=1 AND tipo=2";
									$rs_pa =@pg_exec($conn,$sql);
									$cont_pa = @pg_result($rs_pa,0);
									
									$sql ="SELECT count(*) as tea FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND tea=1 AND tipo=2";
									$rs_tea =@pg_exec($conn,$sql);
									$cont_tea = @pg_result($rs_tea,0);
									
									$sql ="SELECT count(*) as sda FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND sda=1 AND tipo=2";
									$rs_sda =@pg_exec($conn,$sql);
									$cont_sda = @pg_result($rs_sda,0);
									
									$sql ="SELECT count(*) as l FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND l=1 AND tipo=2";
									$rs_l =@pg_exec($conn,$sql);
									$cont_l = @pg_result($rs_l,0);*/
									
									$sql="SELECT COUNT(*) as proyecto FROM proyecto_grupo WHERE rdb=".$fila_ins['rdb']." AND tipo=2";
									$rs_total = @pg_exec($conn,$sql);
									$cont_total = @pg_result($rs_total,0);
									
									$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_lenguaje=1 AND tipo=2";
									$rs_lenguaje =@pg_exec($conn,$sql);
									$cont_lenguaje = @pg_result($rs_lenguaje,0);
									
									$sql ="SELECT count(*) as matematica FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND mejora_matematica=1 AND tipo=2";
									$rs_matematica =@pg_exec($conn,$sql);
									$cont_matematica = @pg_result($rs_matematica,0);
									
									$sql ="SELECT count(*) as aprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND aprobado=1 AND tipo=2";
									$rs_aprobado =@pg_exec($conn,$sql);
									$cont_aprobado = @pg_result($rs_aprobado,0);
									
									$sql ="SELECT count(*) as reprobado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND reprobado=1 AND tipo=2";
									$rs_reprobado =@pg_exec($conn,$sql);
									$cont_reprobado = @pg_result($rs_reprobado,0);
									
									$sql ="SELECT count(*) as retirado FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy WHERE b.rdb=".$fila_ins['rdb']." AND ";
									$sql.="id_ano=".$fila_ins['id_ano']." AND retirado=1 AND tipo=2";
									$rs_retirado =@pg_exec($conn,$sql);
									$cont_retirado = @pg_result($rs_retirado,0);
								?>
							  <tr>
								<td class="datos"><?=$cont;?></td>
								<td class="datos"><?=$fila_ins['nombre_instit'];?></td>
								<? for($j=0;$j<@pg_numrows($rs_diag);$j++){
										$fila_di = @pg_fetch_array($rs_diag,$j);
										$sql ="SELECT count(*) as lenguaje FROM alumno_proyecto a INNER JOIN proyecto_grupo b ON a.id_proy=b.id_proy AND a.rdb=b.rdb WHERE   ";
										$sql.="b.rdb=".$fila_ins['rdb']." AND id_ano=".$fila_ins['id_ano']." AND id_dignos=".$fila_di['id_dignos']." AND tipo=2";
										$rs_lenguaje =@pg_exec($conn,$sql);
										$cont_diag = @pg_result($rs_lenguaje,0);
										$total_dig[$j]=$total_dig[$j] + $cont_diag;
								?>
								<td class="datos"><?=$cont_diag;?></td>
								<? } ?>
								<td class="datos"><?=$cont_total;?></td>
								<td class="datos"><?=$cont_aprobado;?></td>
								<td class="datos"><?=$cont_reprobado;?></td>
								<td class="datos"><?=$cont_lenguaje;?></td>
								<td class="datos"><?=$cont_matematica;?></td>
								<td class="datos"><?=$cont_retirado;?></td>
							  </tr>
							  <? 	/*$total_pa = $total_pa + $cont_pa;
									$total_tea = $total_tea + $cont_tea;
									$total_sda = $total_sda + $cont_sda;
									$total_l = $total_l + $cont_l;*/
									$total_reprobado = $total_reprobado + $cont_reprobado;
									$total_retirado = $total_retirado + $cont_retirado;
									$total_aprobado = $total_aprobado + $cont_aprobado;
									$total_lenguaje = $total_lenguaje + $cont_lenguaje;
									$total_matematica = $total_matematica + $cont_matematica;
									$total_alum = $total_alum + $cont_total;
							  } ?>
							  <tr class="tabla04">
								<td>&nbsp;</td>
								<td>TOTAL</td>
								<? for($j=0;$j<@pg_numrows($rs_diag);$j++){ ?>
								<td><?=$total_dig[$j];?></td>
								<? } ?>
								<td><?=$total_alum;?></td>
								<td><?=$total_aprobado;?></td>
								<td><?=$total_reprobado;?></td>
								<td><?=$total_lenguaje;?></td>
								<td><?=$total_matematica;?></td>
								<td><?=$total_retirado;?></td>
							  </tr>
							</table>
								<br>
                                <table width="200" border="0" align="center">
                                  <tr>
                                    <td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=6&caso=" ""><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
                                    <td class="Estilo4"><a href="printProyectoGrupo.php?caso_p=5&cmbANO_P=<?=$cmbANO_P;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
                                  </tr>
                                </table>
								<? } ?>
								</td>
							</tr>
							</table>
							<br>
<br>
<form method="post" name="form" action="reportesCorporativos.php">
<input name="pesta" type="hidden" value="7">
							<table width="80%" border="0" align="center" id="gestion" cellpadding="0" cellspacing="0">
								<tr class="tableindex" >
									<td colspan="4"><div align="center">Gesti&oacute;n Curricular  </div></td>
							    </tr>
								<tr class="Estilo25">
								  <td colspan="3">&nbsp;</td>
								  <td>&nbsp;</td>
							    </tr>
								<tr class="Estilo25">
								  <td colspan="3"><strong>Corporaci&oacute;n</strong></td>
							      <td width="83%"><?php echo $nombre_corp ?></td>
								</tr>
								<tr class="Estilo25">
								  <td colspan="3"><strong>A&ntilde;o</strong></td>
							      <td><select name="cmb_anog" class="ddlb_x" onChange="enviapagg(this.form);">
										   <option value="0">Seleccione Año</option>
										   <option value="2009" <? if ($cmb_anog=="2009"){ ?> selected="selected" <? } ?>>2009</option>
                                           <option value="2008" <? if ($cmb_anog=="2008"){ ?> selected="selected" <? } ?>>2008</option>
										   <option value="2007" <? if ($cmb_anog=="2007"){ ?> selected="selected" <? } ?>>2007</option>
										   <option value="2006" <? if ($cmb_anog=="2006"){ ?> selected="selected" <? } ?>>2006</option>
										   <option value="2005" <? if ($cmb_anog=="2005"){ ?> selected="selected" <? } ?>>2005</option>
										   <option value="2004" <? if ($cmb_anog=="2004"){ ?> selected="selected" <? } ?>>2004</option>
									</select></td>
								</tr>
								<tr >
								  <td colspan="4">&nbsp;</td>
							    </tr>
								<tr >
								  <td colspan="4">
								  <?php
											 $qry_ins="select corp_instit.rdb, corp_instit.estado, 

institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = ".$corporacion." and corp_instit.rdb = institucion.rdb order by 

nombre_instit asc";
												  $result_ins=@pg_Exec($conn,$qry_ins);
												 // echo "encontrados=".pg_numrows($result_ins);
												  for($i=0;$i<pg_numrows($result_ins);$i++){	
													   $fila_ins = pg_fetch_array($result_ins,$i);
													 $rdb = $fila_ins['rdb'];
													   $establecimiento = $fila_ins['nombre_instit'];
													   
													  
													 //busco año escolar
													$sql_bus_anio="select * from ano_escolar where 

id_institucion=".$rdb." and nro_ano=".$cmb_anog;
													$res_bus_anio=@pg_Exec($conn,$sql_bus_anio);  
													for($h=0;$h<pg_numrows($res_bus_anio);$h++)
													{ 
													 $fila_anio = pg_fetch_array($res_bus_anio,$h); 
														$id_anio = $fila_anio['id_ano']; 
														//busco cursos con ese año
														
														//busco planificacion
								 
								
													   ?>
								  <table width="100%" border="1" cellpadding="3" cellspacing="0" class="Estilo2 Estilo1">
  <tr>
    <td width="13%" rowspan="2" valign="top" bgcolor="#CCCCCC"><strong>Instituci&oacute;n</strong></td>
    <td colspan="2" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
  
  <tr>
    <td colspan="2" valign="top">
	<?php 
									  //muestro planis
									  
									  $sql_plan="SELECT * FROM plani INNER JOIN ramo ON (plani.id_ramo = ramo.id_ramo) INNER JOIN curso ON (ramo.id_curso = curso.id_curso) where curso.id_ano=$id_anio";
									  $res_plan=@pg_exec($conn,$sql_plan);
									  for ($x=0;$x<pg_numrows($res_plan);$x++)
									  {			  
									  		$fil_plan=@pg_fetch_array($res_plan,$x);						  
									  ?><table width="100%" height="100%" border="1" cellpadding="0" cellspacing="0" class="Estilo1">
      <tr>
        <td bgcolor="#CCCCCC"><strong>Curso </strong></td>
        <td colspan="4" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
      <tr>
        <td bgcolor="#CCCCCC"><strong>Subsector</strong></td>
        <td colspan="4" bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
      <tr>
        <td width="23%" bgcolor="#CCCCCC"><strong>Planificación</strong></td>
        <td width="23%" bgcolor="#CCCCCC"><strong>Fec. Inicio </strong></td>
        <td width="20%" bgcolor="#CCCCCC"><strong>Fec. T&eacute;rmino </strong></td>
        <td width="17%" bgcolor="#CCCCCC"><strong>Fec. Abordaje </strong></td>
        <td width="17%" bgcolor="#CCCCCC"><strong>Estado</strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td bgcolor="#CCCCCC"><div align="right"><strong>Porcentaje Avance </strong></div></td>
        <td bgcolor="#CCCCCC"><div align="right"></div></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td bgcolor="#CCCCCC"><div align="right"><strong>Promedio Curso </strong></div></td>
        <td bgcolor="#CCCCCC"><div align="right"></div></td>
      </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        <td bgcolor="#CCCCCC"><div align="right"><strong>Porcentaje Logro </strong></div></td>
        <td bgcolor="#CCCCCC"><div align="right"></div></td>
      </tr>
    </table>
	 <?php }?>	
	</td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  
  
  <tr>
    <td colspan="3" valign="top"><hr /></td>
  </tr>
</table>
<?php }}?>
</td>
							    </tr>
							</table>
	
</form> 


						<!--  evaluaciones -->
                 
							<table width="80%" border="0" align="center" id="evaluaciones" cellpadding="0" cellspacing="0">
								<tr class="tableindex" >
									<td colspan="4"><div align="center">Evaluaciones  </div></td>
							    </tr>
								<tr class="Estilo25">
								  <td colspan="3">&nbsp;</td>
								  <td>&nbsp;</td>
							    </tr>
								<tr class="Estilo25">
								  <td colspan="3"><strong>Corporaci&oacute;n</strong></td>
							      <td width="83%"><?php echo $nombre_corp ?></td>
								</tr>
								
								<tr >
								  <td colspan="4"><br>
								  
							       <?
								   if (!isset($bus)){ ?> 
								    <table width="600" border="0" align="center">
                                    <tr>
                                      <td width="3%"><img src="images/flecha.gif" width="18" height="18"></td>
                                      <td width="97%"><a href="reportesCorporativos.php?pesta=8&bus=1">Promedios de Establecimientos Cient&iacute;fico Human&iacute;stico por Nivel </a></td>
                                    </tr>
                                    <tr>
                                      <td><img src="images/flecha.gif" width="18" height="18"></td>
                                      <td><a href="reportesCorporativos.php?pesta=8&bus=2">Promedios de Establecimientos T&eacute;cnico Profesional por Nivel </a></td>
                                    </tr>
                                    <tr>
                                      <td><img src="images/flecha.gif" width="18" height="18"></td>
                                      <td><a href="reportesCorporativos.php?pesta=8&bus=3">Cantidad de Aprobados y Reprobados de todos los Establecimientos </a></td>
                                    </tr>
                                    <tr>
                                      <td><img src="images/flecha.gif" width="18" height="18"></td>
                                      <td><a href="reportesCorporativos.php?pesta=8&bus=4">Cantidad de Aprobados y Reprobados de todos los Establecimientos por Nivel </a></td>
                                    </tr>
                                    <tr>
                                      <td><img src="images/flecha.gif" width="18" height="18"></td>
                                      <td><a href="reportesCorporativos.php?pesta=8&bus=5">Cantidad de Aprobados y Reprobados de todos los Establecimientos por Subsector </a></td>
                                    </tr>                                    
                                    <tr>
                                      <td><img src="images/flecha.gif" width="18" height="18"></td>
                                      <td><a href="reportesCorporativos.php?pesta=8&bus=6">Cantidad de Aprobados y Reprobados de todos los Establecimientos por Subsector y Nivel </a></td>
                                    </tr>
                                    
                                  </table>
								  <? } ?>				   
						      <br>
						   
					
					
						    <?
								if ($bus==1){ ?>
							
								<!-- buscador de la primera opcion -->
								
								<form method="post" name="form" action="reportesCorporativos.php" >
								  <input name="pesta" type="hidden" value="8">
								  <input name="bus" type="hidden" value="1">
								  <table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
								  <tr>
									<td class="tableindex">Buscador Avanzado </td>
								  </tr>
								  <tr>
									<td height="27"><table width="100%" border="1">
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A&ntilde;o escolar </font></td>
										<td width="50%">
												<select name="cmb_ano" class="ddlb_x" >
												   <option value="0" selected>(Seleccione un Año)</option>
												   <option value="2002" >2002</option>
												   <option value="2003" >2003</option>
												   <option value="2004" >2004</option>
												   <option value="2005" >2005</option>
												   <option value="2006" >2006</option>
												   <option value="2007" >2007</option>
												   <option value="2008" >2008</option>
												   <option value="2009" >2009</option>														   
											    </select>													
									    </td>
										<td width="50%" align="center"><label>
										  <input type="submit" name="buscar1" value="Buscar" class="BotonXX">
										</label></td>
									  </tr>
									  <tr>
										<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Per&iacute;odo</font></td>
										<td>
										  
										  <select name="cmbPERIODO"  class="ddlb_x">
												 <option value="0">Seleccione Período</option>
												 <option value="PRIMER SEMESTRE">Primer Semestre</option>
												 <option value="SEGUNDO SEMESTRE">Segundo Semestre</option>
												
										  </Select>        </td>
										<td><div align="center">
										  <label>
										  <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
										  </label>
										</div></td>
									  </tr>
									  <tr>
										<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel</font></td>
										<td>
										
										  <select name="cmbNIVEL" class="ddlb_x" >
										  <option value="0">Seleccione Nivel </option>
										  <?
										  // tomar los niveles asociados
											$qry7 = "select id_nivel, nombre from niveles where id_nivel > 6 order by id_nivel";
											$result7 =@pg_Exec($conn,$qry7);
											for ($i=0; $i < @pg_numrows($result7); $i++){
												 $fila7 = @pg_fetch_array($result7,$i);	
												 $nombre_nivel_[]  = $fila7['nombre'];
												 $id_nivel_[]      = $fila7['id_nivel'];
												 ?>
												   <option value="<?=$id_nivel_[$i]; ?>"><?=$nombre_nivel_[$i]?></option>
												 <? 
											}		  
										  
										  ?>		  
										  </select>        </td>
										<td>&nbsp;</td>
									  </tr>
									  
									  
									</table></td>
								  </tr>
								</table>
								</form>	
								
								<!-- fin buscador -->							
							
							  <? } ?>
							  
							  
							  <?
								if ($bus==2){ ?>
							
								<!-- buscador de la primera opcion -->
								
								<form method="post" name="form" action="reportesCorporativos.php" >
								  <input name="pesta" type="hidden" value="8">
								  <input name="bus" type="hidden" value="2">
								  <table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
								  <tr>
									<td class="tableindex">Buscador Avanzado </td>
								  </tr>
								  <tr>
									<td height="27"><table width="100%" border="1">
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A&ntilde;o escolar </font></td>
										<td width="50%">
										        <select name="cmb_ano" class="ddlb_x" >
												   <option value="0" selected>(Seleccione un Año)</option>
												   <option value="2002" >2002</option>
												   <option value="2003" >2003</option>
												   <option value="2004" >2004</option>
												   <option value="2005" >2005</option>
												   <option value="2006" >2006</option>
												   <option value="2007" >2007</option>
												   <option value="2008" >2008</option>
												   <option value="2009" >2009</option>														   
											    </select>
									    </td>
										<td width="50%" align="center"><label>
										  <input type="submit" name="buscar2" value="Buscar" class="BotonXX">
										</label></td>
									  </tr>
									  <tr>
										<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Per&iacute;odo</font></td>
										<td>
										   <select name="cmbPERIODO"  class="ddlb_x">
												 <option value="0">Seleccione Período</option>
												 <option value="PRIMER SEMESTRE">Primer Semestre</option>
												 <option value="SEGUNDO SEMESTRE">Segundo Semestre</option>												
										  </Select> 								  
										  
									    </td>
										<td><div align="center">
										  <label>
										  <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
										  </label>
										</div></td>
									  </tr>
									  <tr>
										<td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel</font></td>
										<td>
										
										  <select name="cmbNIVEL" class="ddlb_x" >
										  <option value="0">Seleccione Nivel </option>
										  <?
										  // tomar los niveles asociados
											$qry7 = "select id_nivel, nombre from niveles where id_nivel > 6 order by id_nivel";
											$result7 =@pg_Exec($conn,$qry7);
											for ($i=0; $i < @pg_numrows($result7); $i++){
												 $fila7 = @pg_fetch_array($result7,$i);	
												 $nombre_nivel_[]  = $fila7['nombre'];
												 $id_nivel_[]      = $fila7['id_nivel'];
												 ?>
												   <option value="<?=$id_nivel_[$i]; ?>"><?=$nombre_nivel_[$i]?></option>
												 <? 
											}		  
										  
										  ?>		  
										  </select>        </td>
										<td>&nbsp;</td>
									  </tr>
									  
									  
									</table></td>
								  </tr>
								</table>
								</form>	
								
								<!-- fin buscador -->							
							
							  <? } ?>
							  
							  
							<?
							  if ($bus==3){ ?>
							
								<!-- buscador de la primera opcion -->
								
								<form method="post" name="form" action="reportesCorporativos.php" >
								  <input name="pesta" type="hidden" value="8">
								  <input name="bus" type="hidden" value="3">
								  <table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
								  <tr>
									<td class="tableindex">Buscador Avanzado </td>
								  </tr>
								  <tr>
									<td height="27"><table width="100%" border="1">
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A&ntilde;o escolar </font></td>
										<td width="50%">
										       <select name="cmb_ano" class="ddlb_x" >
												   <option value="0" selected>(Seleccione un Año)</option>
												   <option value="2002" >2002</option>
												   <option value="2003" >2003</option>
												   <option value="2004" >2004</option>
												   <option value="2005" >2005</option>
												   <option value="2006" >2006</option>
												   <option value="2007" >2007</option>
												   <option value="2008" >2008</option>
												   <option value="2009" >2009</option>														   
									      </select>
									    </td>
										  <td width="50%" align="center"><label>
										  <input type="submit" name="buscar3" value="Buscar" class="BotonXX">
										  </label></td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><div align="center">
										  <label>
										  <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
										  </label>
										</div></td>
									  </tr>								  
									  									  
									</table>
									</td>
								  </tr>
								</table>
								</form>	
								
								<!-- fin buscador -->							
							
							  <? } ?>
							  
							  
							  <?
							  if ($bus==4){ ?>
							
								<!-- buscador de la primera opcion -->
								
								<form method="post" name="form" action="reportesCorporativos.php" >
								  <input name="pesta" type="hidden" value="8">
								  <input name="bus" type="hidden" value="4">
								  <table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
								  <tr>
									<td class="tableindex">Buscador Avanzado </td>
								  </tr>
								  <tr>
									<td height="27"><table width="100%" border="1">
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A&ntilde;o escolar </font></td>
										<td width="50%">
										  <select name="cmb_ano" class="ddlb_x" >
												   <option value="0" selected>(Seleccione un Año)</option>
												   <option value="2002" >2002</option>
												   <option value="2003" >2003</option>
												   <option value="2004" >2004</option>
												   <option value="2005" >2005</option>
												   <option value="2006" >2006</option>
												   <option value="2007" >2007</option>
												   <option value="2008" >2008</option>
												   <option value="2009" >2009</option>														   
									      </select>
									    </td>
										  <td width="50%" align="center"><label>
										  <input type="submit" name="buscar4" value="Buscar" class="BotonXX">
										  </label></td>
									  </tr>
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel </font></td>
										<td width="50%">
										   	 <select name="cmbNIVEL" class="ddlb_x" >
											  <option value="0">Seleccione Nivel </option>
											  <?
											  // tomar los niveles asociados
												$qry7 = "select id_nivel, nombre from niveles order by id_nivel";
												$result7 =@pg_Exec($conn,$qry7);
												for ($i=0; $i < @pg_numrows($result7); $i++){
													 $fila7 = @pg_fetch_array($result7,$i);	
													 $nombre_nivel_[]  = $fila7['nombre'];
													 $id_nivel_[]      = $fila7['id_nivel'];
													 ?>
													   <option value="<?=$id_nivel_[$i]; ?>"><?=$nombre_nivel_[$i]?></option>
													 <? 
												}										  
											   ?>		  
										  </select> 								
										</td>
										  <td width="50%" align="center">&nbsp;</td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><div align="center">
										  <label>
										  <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
										  </label>
										</div></td>
									  </tr>								  
									  									  
									</table>
									</td>
								  </tr>
								</table>
								</form>	
								
								<!-- fin buscador -->							
							
							  <? } ?>
							  
							  
							  <?
							  if ($bus==5){ ?>
							
								<!-- buscador de la primera opcion -->
								
								<form method="post" name="form" action="reportesCorporativos.php" >
								  <input name="pesta" type="hidden" value="8">
								  <input name="bus" type="hidden" value="5">
								  <table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
								  <tr>
									<td class="tableindex">Buscador Avanzado </td>
								  </tr>
								  <tr>
									<td height="27"><table width="100%" border="1">
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A&ntilde;o escolar </font></td>
										<td width="50%">
										        <select name="cmb_ano" class="ddlb_x" >
												   <option value="0" selected>(Seleccione un Año)</option>
												   <option value="2002" >2002</option>
												   <option value="2003" >2003</option>
												   <option value="2004" >2004</option>
												   <option value="2005" >2005</option>
												   <option value="2006" >2006</option>
												   <option value="2007" >2007</option>
												   <option value="2008" >2008</option>
												   <option value="2009" >2009</option>														   
											    </select>
										</td>
										  <td width="50%" align="center"><label>
										  <input type="submit" name="buscar5" value="Buscar" class="BotonXX">										 
										  </label></td>
									  </tr>
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Subsector </font></td>
										<td width="50%">
										    <?
											$sql_sub = "select subsector.nombre, subsector.cod_subsector from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion in (select rdb from corp_instit where num_corp = '".$_CORPORACION."'))) group by subsector.nombre, subsector.cod_subsector order by subsector.nombre";
											$result_sub =@pg_Exec($conn,$sql_sub );
											?>
										   	 <select name="cmbSUBSECTOR" class="ddlb_x" >
											  <option value="0">Seleccione Subsector </option>
											  <?
											  // tomar los subsectores de la corporacion
												// Subsectores
												//-----------------------------------------
											
												//-----------------------------------------		
												for ($i=0; $i < @pg_numrows($result_sub); $i++){
													 $fila_sub = pg_fetch_array($result_sub,$i);        
													 $subsector_nombre_[] = $fila_sub['nombre'];
													 $cod_subsector_[]    = $fila_sub['cod_subsector'];
													 ?>
													   <option value="<?=$cod_subsector_[$i]?>"><?=$subsector_nombre_[$i]?></option>
													 <? 
												}										  
											   ?>		  
										  </select> 								
										</td>
										  <td width="50%" align="center">&nbsp;</td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><div align="center">
										  <label>
										  <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
										  </label>
										</div></td>
									  </tr>								  
									  									  
									</table>
									</td>
								  </tr>
								</table>
								</form>	
								
								<!-- fin buscador -->							
							
							  <? } ?>
							  
							  
							  <?
							  if ($bus==6){ ?>
							
								<!-- buscador de la primera opcion -->
								
								<form method="post" name="form" action="reportesCorporativos.php" >
								  <input name="pesta" type="hidden" value="8">
								  <input name="bus" type="hidden" value="6">
								  <table align="center" width="90%" height="43" border="1" cellpadding="0" cellspacing="0">
								  <tr>
									<td class="tableindex">Buscador Avanzado </td>
								  </tr>
								  <tr>
									<td height="27"><table width="100%" border="1">
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">A&ntilde;o escolar </font></td>
										<td width="50%">
										   <select name="cmb_ano" class="ddlb_x" >
											   <option value="0" selected>(Seleccione un Año)</option>
											   <option value="2002" >2002</option>
											   <option value="2003" >2003</option>
											   <option value="2004" >2004</option>
											   <option value="2005" >2005</option>
											   <option value="2006" >2006</option>
											   <option value="2007" >2007</option>
											   <option value="2008" >2008</option>
											   <option value="2009" >2009</option>														   
										  </select>
										</td>
										  <td width="50%" align="center"><label>
										  <input type="submit" name="buscar6" value="Buscar" class="BotonXX">
										  </label></td>
									  </tr>
									  <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Subsector </font></td>
										<td width="50%">
										    <?
											$sql_sub = "select subsector.nombre, subsector.cod_subsector from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion in (select rdb from corp_instit where num_corp = '".$_CORPORACION."'))) group by subsector.nombre, subsector.cod_subsector order by subsector.nombre";
											$result_sub =@pg_Exec($conn,$sql_sub );
											?>
										   	 <select name="cmbSUBSECTOR" class="ddlb_x" >
											  <option value="0">Seleccione Subsector </option>
											  <?
											  // tomar los subsectores de la corporacion
												// Subsectores
												//-----------------------------------------
											
												//-----------------------------------------		
												for ($i=0; $i < @pg_numrows($result_sub); $i++){
													 $fila_sub = pg_fetch_array($result_sub,$i);        
													 $subsector_nombre_[] = $fila_sub['nombre'];
													 $cod_subsector_[]    = $fila_sub['cod_subsector'];
													 ?>
													   <option value="<?=$cod_subsector_[$i]?>"><?=$subsector_nombre_[$i]?></option>
													 <? 
												}										  
											   ?>		  
										  </select> 								
										</td>
										  <td width="50%" align="center">&nbsp;</td>
									  </tr>
									   <tr>
										<td width="20%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Nivel </font></td>
										<td width="50%">
										    <select name="cmbNIVEL" class="ddlb_x" >
											  <option value="0">Seleccione Nivel </option>
											  <?
											  // tomar los niveles asociados
												$qry7 = "select id_nivel, nombre from niveles order by id_nivel";
												$result7 =@pg_Exec($conn,$qry7);
												for ($i=0; $i < @pg_numrows($result7); $i++){
													 $fila7 = @pg_fetch_array($result7,$i);	
													 $nombre_nivel_[]  = $fila7['nombre'];
													 $id_nivel_[]      = $fila7['id_nivel'];
													 ?>
													   <option value="<?=$id_nivel_[$i]; ?>"><?=$nombre_nivel_[$i]?></option>
													 <? 
												}										  
											   ?>		  
										  </select> 									
										 </td>
										  <td width="50%" align="center">&nbsp;</td>
									  </tr>
									  <tr>
										<td>&nbsp;</td>
										<td>&nbsp;</td>
										<td><div align="center">
										  <label>
										  <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
										  </label>
										</div></td>
									  </tr>								  
									  									  
									</table>
									</td>
								  </tr>
								</table>
								</form>	
								
								<!-- fin buscador -->							
							
							  <? } ?>
							
							   
				        
						<?
						if (isset($buscar1)){
						     //// llenamos los arregloa que vamos a necesitar
							 // tomar Los datos del nivel seleccionado
								$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$cmbNIVEL'";
								$result7 =@pg_Exec($conn,$qry7);
								for ($i=0; $i < @pg_numrows($result7); $i++){
									 $fila7 = @pg_fetch_array($result7,$i);	
									 $nombre_nivel  = $fila7['nombre'];
									 $id_nivel      = $fila7['id_nivel'];
								}
							    
								
							    /// tomar nombre las instituciones de la corporacion de tipo de enseñanza 310								
								$qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb inner join tipo_ense_inst on corp_instit.rdb = tipo_ense_inst.rdb WHERE corp_instit.num_corp = '".$_CORPORACION."' and tipo_ense_inst.cod_tipo = 310  group by institucion.rdb, institucion.nombre_instit";
								$result2 =@pg_Exec($conn,$qry2);
								for ($i=0; $i < @pg_numrows($result2); $i++){
								    $fila2 = @pg_fetch_array($result2,$i);
								    $nombre_institucion_[] = $fila2['nombre_instit'];
									$rdb_[] = $fila2['rdb'];
									
									/// tomar el número número de año seleccionado
									$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
									$result4 =@pg_Exec($conn,$qry4);
									if (pg_numrows($result4)==0){
									    $id_ano_[] = 0;
									}else{
									    $fila4 = @pg_fetch_array($result4,0);
									    $id_ano_[] = $fila4['id_ano'];
								    }
									
									/// tomar período
									$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE nombre_periodo = '".$cmbPERIODO."' and id_ano = '$id_ano_[$i]'";
									$result =@pg_Exec($conn,$qry);
									if ($id_ano_[$i]==0){
									    $id_periodo_[]  =  0;										
									}else{
									    $fila1 = @pg_fetch_array($result,0);
									    $id_periodo_[]  = $fila1['id_periodo'];									    	
									}
								}										
						
						     ?>						 
							 				     
							 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
                               <tr>
                                 <td valign="top">
                                     <table width="100%" border="0">
                                       <tr>
                                         <td><label>
                                           <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
                                         </label></td>
                                         <td><div align="right">
                                           <label>
                                           <input name="Submit7" type="button" class="BotonXX" id="Submit7" onClick="MM_openBrWindow('printNotasFinalesporNivelCH_corp.php?id_nivel=<?=$cmbNIVEL?>&cmbPERIODO=<?=$cmbPERIODO?>&cmb_ano=<?=$cmb_ano?>','','scrollbars=yes,resizable=yes,width=1000,height=600')"  value="Imprimir">
                                           </label>
                                         </div></td>
                                       </tr>
                                     </table>
                                     <table width="650" border="1" cellspacing="0" cellpadding="3">
                                       <tr >
                                         <td colspan="5" class="tableindex"><div align="center">PROMEDIOS ESTABLECIMIENTOS CIENTIFICO HUMANISTICO POR NIVEL </div></td>
                                       </tr>
                                       <tr>
                                         <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
                                       </tr>
                                       <tr>
                                         <td width="178" class="Estilo10"><strong>Nivel</strong></td>
                                         <td width="472" class="Estilo7">&nbsp;
                                             <?=$nombre_nivel?></td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo10"><b>Semestre</b></td>
                                         <td class="Estilo7">&nbsp;
                                             <?=$cmbPERIODO?></td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo10"><b>A&ntilde;o</b></td>
                                         <td class="Estilo7">&nbsp;
                                             <?=$cmb_ano ?></td>
                                       </tr>
                                     </table>
                                   <br>
                                     <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
                                       <tr>
                                         <td>&nbsp;</td>
                                         <td  align="center" class="Estilo28">Promedios</td>
                                         <td>&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28">Establecimientos</td>
                                        <?
										if ($id_nivel==7){ ?>
                                            <td align="center"><span class="Estilo28"> 1&ordm; E. M. </span></td>
                                       <? } 
									   
									    if ($id_nivel==8){ ?>									   
                                            <td align="center"><span class="Estilo28"> 2&ordm; E. M. </span></td>
                                       <? }
									   
									    if ($id_nivel==9){ ?>  
										    <td align="center"><span class="Estilo28"> 3&ordm; E. M. </span></td>
                                        <? }
										
										if ($id_nivel==10){ ?>
										    <td align="center"><span class="Estilo28"> 4&ordm; E. M. </span></td>
                                        <? } ?>										
										 <td align="center"><span class="Estilo28">Prom. Final </span></td>
                                       </tr>
                                      
									  <!-- ciclo de establecimientos -->	
									      <?
										  for ($i=0; $i < @pg_numrows($result2); $i++){
								              //$rdb_[] = $fila2['rdb'];
											  $suma_promedio = 0;
											  
								              ?>								  
										      <tr>
											    <td class="Estilo28"><?=$nombre_institucion_[$i]?></td>		
												
												<?
										        if ($id_nivel==7){ ?>							
													<td align="center" class="Estilo28">&nbsp;
													<?
													$sql_curso1 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '310' and grado_curso = '1'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
													$result_curso1 = @pg_Exec($conn, $sql_curso1);
													$fila_curso1 = @pg_fetch_array($result_curso1,0);
													$cantidad = $fila_curso1['cantidad'];
													$suma     = $fila_curso1['suma'];
													$promedio1 = round($suma / $cantidad);
												 
													if ($promedio1>0){
													   echo $promedio1;
													   $suma_promedio = $suma_promedio + $promedio1;
													   $contador_promedios++;
													}
													
													?>												</td>   
												<? } ?>
												
												<?
										        if ($id_nivel==8){ ?>	                                    
													<td align="center" class="Estilo28">&nbsp;
													<?
													$sql_curso2 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '310' and grado_curso = '2'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
													$result_curso2 = @pg_Exec($conn, $sql_curso2);
													$fila_curso2 = @pg_fetch_array($result_curso2,0);
													$cantidad = $fila_curso2['cantidad'];
													$suma     = $fila_curso2['suma'];
													$promedio2 = round($suma / $cantidad);
												 
													if ($promedio2>0){
													   echo $promedio2;
													   $suma_promedio = $suma_promedio + $promedio2;
													   $contador_promedios++;
													}
													
													?></td>
												<? } ?>
												
												<?
										        if ($id_nivel==9){ ?>
													   <td align="center" class="Estilo28">&nbsp;
													   <?
														$sql_curso3 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '310' and grado_curso = '3'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
														$result_curso3 = @pg_Exec($conn, $sql_curso3);
														$fila_curso3 = @pg_fetch_array($result_curso3,0);
														$cantidad = $fila_curso3['cantidad'];
														$suma     = $fila_curso3['suma'];
														$promedio3 = round($suma / $cantidad);
													 
														if ($promedio3>0){
														   echo $promedio3;
														   $suma_promedio = $suma_promedio + $promedio3;
														   $contador_promedios++;
														}
													
													?></td>
												<? } ?>
												
												<?
										        if ($id_nivel==10){ ?>
													   <td align="center" class="Estilo28">&nbsp;
													   <?
														$sql_curso4 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '310' and grado_curso = '4'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
														$result_curso4 = @pg_Exec($conn, $sql_curso4);
														$fila_curso4 = @pg_fetch_array($result_curso4,0);
														$cantidad = $fila_curso4['cantidad'];
														$suma     = $fila_curso4['suma'];
														$promedio4 = @round($suma / $cantidad);
													 
														if ($promedio4>0){
														   echo $promedio4;
														   $suma_promedio = $suma_promedio + $promedio4;
														   $contador_promedios++;
														}
														?></td>
												<? }
												
												$prom_establecimiento = @round($suma_promedio / $contador_promedios);
												
												 ?>
												
											       <td align="center" class="Estilo28">&nbsp;<?=$prom_establecimiento?></td>
										      </tr>
											  <?
										  } ?>	  
									  <!-- fin ciclo de establecimientos -->  
                                      
                                       <tr>
                                         <td>Promedio Final </td>
                                        
                                         <td align="center">&nbsp;</td>
                                        
                                         <td>&nbsp;</td>
                                         
                                       </tr>
                                   </table></td>
                               </tr>
                             </table>
																			
						<? } ?>
						
						
						<?
						if (isset($buscar2)){
						     //// llenamos los arregloa que vamos a necesitar
							 // tomar Los datos del nivel seleccionado
								$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$cmbNIVEL'";
								$result7 =@pg_Exec($conn,$qry7);
								for ($i=0; $i < @pg_numrows($result7); $i++){
									 $fila7 = @pg_fetch_array($result7,$i);	
									 $nombre_nivel  = $fila7['nombre'];
									 $id_nivel      = $fila7['id_nivel'];
								}
							    
								/// tomar nombre las instituciones de la corporacion de tipo de enseñanza 310								
								$qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb inner join tipo_ense_inst on corp_instit.rdb = tipo_ense_inst.rdb WHERE corp_instit.num_corp = '".$_CORPORACION."' and tipo_ense_inst.cod_tipo = 410  group by institucion.rdb, institucion.nombre_instit";
								$result2 =@pg_Exec($conn,$qry2);
								for ($i=0; $i < @pg_numrows($result2); $i++){
								    $fila2 = @pg_fetch_array($result2,$i);
								    $nombre_institucion_[] = $fila2['nombre_instit'];
									$rdb_[] = $fila2['rdb'];
									
									/// tomar el número número de año seleccionado
									$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
									$result4 =@pg_Exec($conn,$qry4);
									if (pg_numrows($result4)==0){
									    $id_ano_[] = 0;
									}else{
									    $fila4 = @pg_fetch_array($result4,0);
									    $id_ano_[] = $fila4['id_ano'];
								    }
									
									/// tomar período
									$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE nombre_periodo = '".$cmbPERIODO."' and id_ano = '$id_ano_[$i]'";
									$result =@pg_Exec($conn,$qry);
									if ($id_ano_[$i]==0){
									    $id_periodo_[]  =  0;										
									}else{
									    $fila1 = @pg_fetch_array($result,0);
									    $id_periodo_[]  = $fila1['id_periodo'];									    	
									}
								}
						     ?>		
							 					
									
							 
							 				     
							 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
                               <tr>
                                 <td valign="top">
                                     <table width="100%" border="0">
                                       <tr>
                                         <td><label>
                                           <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
                                         </label></td>
                                         <td><div align="right">
                                           <label>
                                           <input name="Submit7" type="button" class="BotonXX" id="Submit7" onClick="MM_openBrWindow('printNotasFinalesporNivelTP_corp.php?id_nivel=<?=$cmbNIVEL?>&cmbPERIODO=<?=$cmbPERIODO?>&cmb_ano=<?=$cmb_ano?>','','scrollbars=yes,resizable=yes,width=1000,height=600')"  value="Imprimir">
                                           </label>
                                         </div></td>
                                       </tr>
                                     </table>
                                     <table width="650" border="1" cellspacing="0" cellpadding="3">
                                       <tr >
                                         <td colspan="5" class="tableindex"><div align="center">PROMEDIOS ESTABLECIMIENTOS TECNICO PROFESIONAL POR NIVEL </div></td>
                                       </tr>
                                       <tr>
                                         <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
                                       </tr>
                                       <tr>
                                         <td width="178" class="Estilo28"><strong>Nivel</strong></td>
                                         <td width="472" class="Estilo28">&nbsp;
                                             <?=$nombre_nivel?></td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28"><b>Semestre</b></td>
                                         <td class="Estilo28">&nbsp;
                                             <?=$cmbPERIODO?></td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28"><b>A&ntilde;o</b></td>
                                         <td class="Estilo28">&nbsp;
                                             <?=$cmb_ano ?></td>
                                       </tr>
                                     </table>
                                   <br>
                                     <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
                                       <tr>
                                         <td>&nbsp;</td>
                                         <td align="center" class="Estilo28">Promedios</td>
                                         <td>&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28">Establecimientos</td>
                                         
										 <?
										 if ($id_nivel==7){ ?>
                                             <td align="center"><span class="Estilo28"> 1&ordm; E. M. </span></td>                                       
                                      <? }  
										 
										 if ($id_nivel==8){ ?>
										     <td align="center"><span class="Estilo28"> 2&ordm; E. M. </span></td>
                                      <? }
									  
									     if ($id_nivel==9){ ?>										 
										     <td align="center"><span class="Estilo28"> 3&ordm; E. M. </span></td>
                                      <? }
									  
									  	 if ($id_nivel==10){ ?>										 
										     <td align="center"><span class="Estilo28"> 4&ordm; E. M. </span></td>
                                      <? } ?>								         
										 
										 <td align="center"><span class="Estilo28">Prom. Final </span></td>
                                       </tr>
                                      
									  <!-- ciclo de establecimientos -->	
									      <?
										  for ($i=0; $i < @pg_numrows($result2); $i++){
								              //$rdb_[] = $fila2['rdb'];
											  $suma_promedio = 0;
											  
								              ?>								  
										      <tr>
											    <td class="Estilo28"><?=$nombre_institucion_[$i]?></td>
												
												<?
										 		if ($id_nivel==7){ ?>									
													<td align="center" class="Estilo28">&nbsp;
													<?
													$sql_curso1 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '410' and grado_curso = '1'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
													$result_curso1 = @pg_Exec($conn, $sql_curso1);
													$fila_curso1 = @pg_fetch_array($result_curso1,0);
													$cantidad = $fila_curso1['cantidad'];
													$suma     = $fila_curso1['suma'];
													$promedio1 = round($suma / $cantidad);
												 
													if ($promedio1>0){
													   echo $promedio1;
													   $suma_promedio = $suma_promedio + $promedio1;
													   $contador_promedios++;
													}
													
													?> </td>                                       
											   <? } ?>    
												 <?
										 		if ($id_nivel==8){ ?>  
													   <td align="center" class="Estilo28">&nbsp;
													   <?
													$sql_curso2 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '410' and grado_curso = '2'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
													$result_curso2 = @pg_Exec($conn, $sql_curso2);
													$fila_curso2 = @pg_fetch_array($result_curso2,0);
													$cantidad = $fila_curso2['cantidad'];
													$suma     = $fila_curso2['suma'];
													$promedio2 = round($suma / $cantidad);
												 
													if ($promedio2>0){
													   echo $promedio2;
													   $suma_promedio = $suma_promedio + $promedio2;
													   $contador_promedios++;
													}
												
												    ?></td>
											    <? } ?>
												
												<?
										 		if ($id_nivel==9){ ?>		
													   <td align="center" class="Estilo28">&nbsp;
													   <?
														$sql_curso3 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '410' and grado_curso = '3'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
														$result_curso3 = @pg_Exec($conn, $sql_curso3);
														$fila_curso3 = @pg_fetch_array($result_curso3,0);
														$cantidad = $fila_curso3['cantidad'];
														$suma     = $fila_curso3['suma'];
														$promedio3 = round($suma / $cantidad);
													 
														if ($promedio3>0){
														   echo $promedio3;
														   $suma_promedio = $suma_promedio + $promedio3;
														   $contador_promedios++;
														}
														
														?></td>
												<? } ?>
												
												<?
										 		if ($id_nivel==10){ ?>		
													   <td align="center" class="Estilo28">&nbsp;
													   <?
														$sql_curso4 = "select  sum(CAST(promedio AS integer)) as suma, count(promedio) as cantidad from notas$cmb_ano where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and ensenanza = '410' and grado_curso = '4'))   and id_periodo = '$id_periodo_[$i]' and promedio > 0";
														$result_curso4 = @pg_Exec($conn, $sql_curso4);
														$fila_curso4 = @pg_fetch_array($result_curso4,0);
														$cantidad = $fila_curso4['cantidad'];
														$suma     = $fila_curso4['suma'];
														$promedio4 = @round($suma / $cantidad);
													 
														if ($promedio4>0){
														   echo $promedio4;
														   $suma_promedio = $suma_promedio + $promedio4;
														   $contador_promedios++;
														}
														
														?></td>
												<? } 
												   
												   $prom_establecimiento = @round($suma_promedio / $contador_promedios);
												
												   ?>		
											       <td align="center" class="Estilo28">&nbsp;<?=$prom_establecimiento?></td>
										      </tr>
											  <?
										  } ?>	  
									  <!-- fin ciclo de establecimientos -->  
                                      
                                       <tr>
                                         <td class="Estilo28">Promedio Final </td>
                                        
                                         <td align="center">&nbsp;</td>         
                                        
                                         <td>&nbsp;</td>
                                       </tr>
                                   </table></td>
                               </tr>
                             </table>
																			
						<? } ?>
						
						<?
						if (isset($buscar3)){
						        /// tomar nombre las instituciones de la corporacion de tipo de enseñanza 310								
								$qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb  WHERE corp_instit.num_corp = '".$_CORPORACION."'  group by institucion.rdb, institucion.nombre_instit";
								$result2 =@pg_Exec($conn,$qry2);
								for ($i=0; $i < @pg_numrows($result2); $i++){
								    $fila2 = @pg_fetch_array($result2,$i);
								    $nombre_institucion_[] = $fila2['nombre_instit'];
									$rdb_[] = $fila2['rdb'];
									
									/// tomar el número número de año seleccionado
									$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
									$result4 =@pg_Exec($conn,$qry4);
									if (pg_numrows($result4)==0){
									    $id_ano_[] = 0;
									}else{
									    $fila4 = @pg_fetch_array($result4,0);
									    $id_ano_[] = $fila4['id_ano'];
								    }						
									
								}						  			
						
						        ?>			 
							 				     
							 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
                               <tr>
                                 <td valign="top">
                                     <table width="100%" border="0">
                                       <tr>
                                         <td><label>
                                           <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
                                         </label></td>
                                         <td><div align="right">
                                           <label>
                                           <input name="Submit7" type="button" class="BotonXX" id="Submit7" onClick="MM_openBrWindow('printCantAprobReprobados_corp.php?cmb_ano=<?=$cmb_ano?>','','scrollbars=yes,resizable=yes,width=1000,height=600')"  value="Imprimir">
                                           </label>
                                         </div></td>
                                       </tr>
                                     </table>
                                     <table width="650" border="1" cellspacing="0" cellpadding="3">
                                       <tr >
                                         <td colspan="5" class="tableindex"><div align="center">CANTIDAD APROBADOS Y REPROBADOS DE TODOS LOS ESTABLECIMIENTOS </div></td>
                                       </tr>
                                       <tr>
                                         <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
                                       </tr>
                                      
                                       <tr>
                                         <td width="10%" class="Estilo28"><b>A&ntilde;o</b></td>
                                         <td width="90%" class="Estilo28">&nbsp;
                                             <?=$cmb_ano ?></td>
                                       </tr>
                                     </table>
                                   <br>
                                     <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
                                       <tr>
                                         <td>&nbsp;</td>
                                         <td colspan="<?=$num_est?>" align="center" class="Estilo28">Establecimientos</td>
                                         <td>&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28">&nbsp;</td>
                                          <?
										  for ($i=0; $i < @pg_numrows($result2); $i++){
										      
								              ?>
                                              <td align="center"><span class="Estilo28"><?=$nombre_institucion_[$i]?></span></td>
                                              <?
										  }
										  ?>                                         
                                         <td align="center"><span class="Estilo28">Total </span></td>
                                       </tr>
                                      
									
									    							  
										      <tr>
											    <td class="Estilo28">Aprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // consultar en promoción la situación de los alumnos
												      $sql_apro = "select count(*) as cantidad from promocion where id_ano = $id_ano_[$i] and  situacion_final = '1'";
													  $res_apro = @pg_Exec($conn, $sql_apro);
													  $fil_apro = @pg_fetch_array($res_apro);
													  $suma1 = $suma1 + $fil_apro['cantidad'];
													  													  
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_apro['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma1?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Reprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados
												      $sql_rep = "select count(*) as cantidad from promocion where id_ano = $id_ano_[$i] and  situacion_final = '2'";
													  $res_rep = @pg_Exec($conn, $sql_rep);
													  $fil_rep = @pg_fetch_array($res_rep);
													  $suma2 = $suma2 + $fil_rep['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma2?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Por Inasistencia</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados por Inasistencia
												      $sql_rep_ina = "select count(*) as cantidad from promocion where id_ano = $id_ano_[$i] and  situacion_final = '2' and tipo_reprova = '2'";
													  $res_rep_ina = @pg_Exec($conn, $sql_rep_ina);
													  $fil_rep_ina = @pg_fetch_array($res_rep_ina);
													  $suma3 = $suma3 + $fil_rep_ina['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep_ina['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma3?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Por Rendimiento</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados por Rendimiento
												      $sql_rep_ren = "select count(*) as cantidad from promocion where id_ano = $id_ano_[$i] and  situacion_final = '2' and tipo_reprova = '1'";
													  $res_rep_ren = @pg_Exec($conn, $sql_rep_ren);
													  $fil_rep_ren = @pg_fetch_array($res_rep_ren);
													  $suma4 = $suma4 + $fil_rep_ren['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep_ren['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp; <?=$suma4?></td>
										      </tr>                                       
                                   </table></td>
                               </tr>
                             </table>
																			
						<? } ?>
						
						
						<?
						if (isset($buscar4)){
						        // tomar Los datos del nivel seleccionado
								$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$cmbNIVEL'";
								$result7 =@pg_Exec($conn,$qry7);
								for ($i=0; $i < @pg_numrows($result7); $i++){
									 $fila7 = @pg_fetch_array($result7,$i);	
									 $nombre_nivel  = $fila7['nombre'];
									 $id_nivel      = $fila7['id_nivel'];
								}								
						
						       $qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb  WHERE corp_instit.num_corp = '".$_CORPORACION."'  group by institucion.rdb, institucion.nombre_instit";
								$result2 =@pg_Exec($conn,$qry2);
								for ($i=0; $i < @pg_numrows($result2); $i++){
								    $fila2 = @pg_fetch_array($result2,$i);
								    $nombre_institucion_[] = $fila2['nombre_instit'];
									$rdb_[] = $fila2['rdb'];
									
									/// tomar el número número de año seleccionado
									$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
									$result4 =@pg_Exec($conn,$qry4);
									if (pg_numrows($result4)==0){
									    $id_ano_[] = 0;
									}else{
									    $fila4 = @pg_fetch_array($result4,0);
									    $id_ano_[] = $fila4['id_ano'];
								    }						
									
								}	
						        ?>			 
							 				     
							 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
                               <tr>
                                 <td valign="top">
                                     <table width="100%" border="0">
                                       <tr>
                                         <td><label>
                                           <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
                                         </label></td>
                                         <td><div align="right">
                                           <label>
                                           <input name="Submit7" type="button" class="BotonXX" id="Submit7" onClick="MM_openBrWindow('printCantAprobReprobados_Nivel_corp.php?id_nivel=<?=$cmbNIVEL?>&cmb_ano=<?=$cmb_ano?>','','scrollbars=yes,resizable=yes,width=1000,height=600')"  value="Imprimir">
                                           </label>
                                         </div></td>
                                       </tr>
                                     </table>
                                     <table width="650" border="1" cellspacing="0" cellpadding="3">
                                       <tr >
                                         <td colspan="5" class="tableindex"><div align="center">CANTIDAD APROBADOS Y REPROBADOS DE TODOS LOS ESTABLECIMIENTOS POR NIVEL </div></td>
                                       </tr>
                                       <tr>
                                         <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
                                       </tr>
                                      
                                       <tr>
                                         <td width="10%" class="Estilo28"><b>A&ntilde;o</b></td>
                                         <td width="90%" class="Estilo28">&nbsp;
                                             <?=$nombre_nivel ?></td>
                                       </tr>
									   
									   <tr>
                                         <td width="10%" class="Estilo28"><b>A&ntilde;o</b></td>
                                         <td width="90%" class="Estilo28">&nbsp;
                                             <?=$cmb_ano ?></td>
                                       </tr>
                                     </table>
                                   <br>
                                     <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
                                       <tr>
                                         <td>&nbsp;</td>
                                         <td colspan="<?=@pg_numrows($result2)?>" align="center" class="Estilo28">Establecimientos</td>
                                         <td>&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28">&nbsp;</td>
                                          <?
										  for ($i=0; $i < @pg_numrows($result2); $i++){
										      
								              ?>
                                              <td align="center"><span class="Estilo28"><?=$nombre_institucion_[$i]?></span></td>
                                              <?
										  }
										  ?>                                         
                                         <td align="center"><span class="Estilo28">Total </span></td>
                                       </tr>
                                      
									
									    							  
										      <tr>
											    <td class="Estilo28">Aprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // consultar en promoción la situación de los alumnos
												      $sql_apro = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$cmbNIVEL') and situacion_final = '1'";
													  $res_apro = @pg_Exec($conn, $sql_apro);
													  $fil_apro = @pg_fetch_array($res_apro);
													  $suma1 = $suma1 + $fil_apro['cantidad'];
													  													  
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_apro['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma1?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Reprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados
												      $sql_rep = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$cmbNIVEL') and situacion_final = '2'";
													  $res_rep = @pg_Exec($conn, $sql_rep);
													  $fil_rep = @pg_fetch_array($res_rep);
													  $suma2 = $suma2 + $fil_rep['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma2?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Por Inasistencia</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados por Inasistencia
												      $sql_rep_ina = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$cmbNIVEL') and situacion_final = '2' and tipo_reprova = '2'";
													  $res_rep_ina = @pg_Exec($conn, $sql_rep_ina);
													  $fil_rep_ina = @pg_fetch_array($res_rep_ina);
													  $suma3 = $suma3 + $fil_rep_ina['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep_ina['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma3?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Por Rendimiento</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados por Rendimiento
												      $sql_rep_ren = "select count(*) as cantidad from promocion where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$cmbNIVEL') and situacion_final = '2' and tipo_reprova = '1'";
													  $res_rep_ren = @pg_Exec($conn, $sql_rep_ren);
													  $fil_rep_ren = @pg_fetch_array($res_rep_ren);
													  $suma4 = $suma4 + $fil_rep_ren['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep_ren['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp; <?=$suma4?></td>
										      </tr>                                       
                                   </table></td>
                               </tr>
                             </table>
																			
						<? } ?>
						
						
						<?
						if (isset($buscar5)){
						        
								// buscamos el nombre del subsector
								$sql_sub = "select subsector.nombre, subsector.cod_subsector from subsector where cod_subsector = '$cmbSUBSECTOR'";
								$result_sub =@pg_Exec($conn,$sql_sub );
								$fila_sub         = @pg_fetch_array($result_sub,0);
								$nombre_subsector = $fila_sub['nombre'];
								$cod_subsector    = $fila_sub['cod_subsector'];				
												
											       
								$qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb  WHERE corp_instit.num_corp = '".$_CORPORACION."'  group by institucion.rdb, institucion.nombre_instit";
								$result2 =@pg_Exec($conn,$qry2);
								for ($i=0; $i < @pg_numrows($result2); $i++){
									$fila2 = @pg_fetch_array($result2,$i);
									$nombre_institucion_[] = $fila2['nombre_instit'];
									$rdb_[] = $fila2['rdb'];
									
									/// tomar el número número de año seleccionado
									$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
									$result4 =@pg_Exec($conn,$qry4);
									if (pg_numrows($result4)==0){
										$id_ano_[] = 0;
									}else{
										$fila4 = @pg_fetch_array($result4,0);
										$id_ano_[] = $fila4['id_ano'];
									}						
									
								}
								
								// fin funcion
								?>
								<table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
                               <tr>
                                 <td valign="top">
                                     <table width="100%" border="0">
                                       <tr>
                                         <td><label>
                                           <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
                                         </label></td>
                                         <td><div align="right">
                                           <label>
                                           <input name="Submit7" type="button" class="BotonXX" id="Submit7" onClick="MM_openBrWindow('printCantAprobReprobados_Subsector_corp.php?cod_subsector=<?=$cod_subsector?>&cmb_ano=<?=$cmb_ano?>','','scrollbars=yes,resizable=yes,width=1000,height=600')"  value="Imprimir">
                                           </label>
                                         </div></td>
                                       </tr>
                                     </table>
                                     <table width="650" border="1" cellspacing="0" cellpadding="3">
                                       <tr >
                                         <td colspan="5" class="tableindex"><div align="center">CANTIDAD APROBADOS Y REPROBADOS DE TODOS LOS ESTABLECIMIENTOS POR SUBSECTOR </div></td>
                                       </tr>
                                       <tr>
                                         <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
                                       </tr>
                                      
                                       <tr>
                                         <td width="10%" class="Estilo28"><b>Subsector</b></td>
                                         <td width="90%" class="Estilo28">&nbsp;
                                             <?=$nombre_subsector ?></td>
                                       </tr>
									   
									   <tr>
                                         <td width="10%" class="Estilo28"><b>A&ntilde;o</b></td>
                                         <td width="90%" class="Estilo28">&nbsp;
                                             <?=$cmb_ano ?></td>
                                       </tr>
                                     </table>
                                   <br>
                                     <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
                                       <tr>
                                         <td>&nbsp;</td>
                                         <td colspan="<?=@pg_numrows($result2)?>" align="center" class="Estilo28">Establecimientos</td>
                                         <td>&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28">&nbsp;</td>
                                          <?
										  for ($i=0; $i < @pg_numrows($result2); $i++){
										      
								              ?>
                                              <td align="center"><span class="Estilo28"><?=$nombre_institucion_[$i]?></span></td>
                                              <?
										  }
										  ?>                                         
                                         <td align="center"><span class="Estilo28">Total </span></td>
                                       </tr>
                                      
									
									    							  
										      <tr>
											    <td class="Estilo28">Aprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // consultar en promoción la situación de los alumnos
													  $sql_sub    = "select count(*) as cantidad from promedio_sub_alumno where id_ramo in (select id_ramo from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]')) and subsector.cod_subsector = '$cod_subsector') and promedio > 39";
													  $res_apro = @pg_Exec($conn,$sql_sub);
													  $fil_apro = @pg_fetch_array($res_apro);
													  $suma1 = $suma1 + $fil_apro['cantidad'];
													 							  													  
													  ?>																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																																	
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_apro['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma1?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Reprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados
												      $sql_rep = "select count(*) as cantidad from promedio_sub_alumno where id_ramo in (select id_ramo from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]')) and subsector.cod_subsector = '$cod_subsector') and promedio < 40";
													  $res_rep = @pg_Exec($conn, $sql_rep);
													  $fil_rep = @pg_fetch_array($res_rep);
													  $suma2 = $suma2 + $fil_rep['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma2?></td>
										      </tr>											 
											                                   
                                   </table></td>
                               </tr>
                             </table>
							 <?
						
						} ?>
						
						<?
						if (isset($buscar6)){
						       
								
								// buscamos el nombre del subsector
								$sql_sub = "select subsector.nombre, subsector.cod_subsector from subsector where cod_subsector = '$cmbSUBSECTOR'";
								$result_sub =@pg_Exec($conn,$sql_sub );
								$fila_sub         = @pg_fetch_array($result_sub,0);
								$nombre_subsector = $fila_sub['nombre'];
								$cod_subsector    = $fila_sub['cod_subsector'];		
								
								
								// tomar Los datos del nivel seleccionado
								$qry7 = "select id_nivel, nombre from niveles where id_nivel = '$cmbNIVEL'";
								$result7 =@pg_Exec($conn,$qry7);
								for ($i=0; $i < @pg_numrows($result7); $i++){
									 $fila7 = @pg_fetch_array($result7,$i);	
									 $nombre_nivel  = $fila7['nombre'];
									 $id_nivel      = $fila7['id_nivel'];
								}	
												
											       
						        $qry2="SELECT institucion.nombre_instit, institucion.rdb FROM institucion inner join corp_instit on institucion.rdb = corp_instit.rdb  WHERE corp_instit.num_corp = '".$_CORPORACION."'  group by institucion.rdb, institucion.nombre_instit";
								$result2 =@pg_Exec($conn,$qry2);
								for ($i=0; $i < @pg_numrows($result2); $i++){
									$fila2 = @pg_fetch_array($result2,$i);
									$nombre_institucion_[] = $fila2['nombre_instit'];
									$rdb_[] = $fila2['rdb'];
									
									/// tomar el número número de año seleccionado
									$qry4="SELECT nro_ano, id_ano FROM ano_escolar WHERE nro_ano = '".$cmb_ano."' and id_institucion = '$rdb_[$i]'";
									$result4 =@pg_Exec($conn,$qry4);
									if (pg_numrows($result4)==0){
										$id_ano_[] = 0;
									}else{
										$fila4 = @pg_fetch_array($result4,0);
										$id_ano_[] = $fila4['id_ano'];
									}						
									
								}					
						
						        ?>			 
							 				     
							 <table width="650" border="1" align="center" cellpadding="0" cellspacing="0">
                               <tr>
                                 <td valign="top">
                                     <table width="100%" border="0">
                                       <tr>
                                         <td><label>
                                           <input name="Submit6" type="button" onClick="MM_goToURL('parent','reportesCorporativos.php?pesta=8');return document.MM_returnValue" value="Volver" class="BotonXX">
                                         </label></td>
                                         <td><div align="right">
                                           <label>
                                           <input name="Submit7" type="button" class="BotonXX" id="Submit7" onClick="MM_openBrWindow('printCantAprobReprobados_Subsector_Nivel_corp.php?cod_subsector=<?=$cod_subsector?>&id_nivel=<?=$id_nivel?>&cmb_ano=<?=$cmb_ano?>','','scrollbars=yes,resizable=yes,width=1000,height=600')"  value="Imprimir">
                                           </label>
                                         </div></td>
                                       </tr>
                                     </table>
                                     <table width="650" border="1" cellspacing="0" cellpadding="3">
                                       <tr >
                                         <td colspan="5" class="tableindex"><div align="center">CANTIDAD APROBADOS Y REPROBADOS DE TODOS LOS ESTABLECIMIENTOS POR SUBSECTOR Y NIVEL </div></td>
                                       </tr>
                                       <tr>
                                         <td colspan="5"><div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </strong></font></div></td>
                                       </tr>
                                      
                                       <tr>
                                         <td width="10%" class="Estilo28"><b>Subsector</b></td>
                                         <td width="90%" class="Estilo28">&nbsp;
                                             <?=$nombre_subsector ?></td>
                                       </tr>
									   
									   <tr>
                                         <td width="10%" class="Estilo28"><b>A&ntilde;o</b></td>
                                         <td width="90%" class="Estilo28">&nbsp;
                                             <?=$cmb_ano ?></td>
                                       </tr>
                                     </table>
                                   <br>
                                     <table width="650" border="1" cellpadding="2" cellspacing="0" class="Estilo7">
                                       <tr>
                                         <td>&nbsp;</td>
                                         <td colspan="<?=@pg_numrows($result2)?>" align="center" class="Estilo28">Establecimientos</td>
                                         <td>&nbsp;</td>
                                       </tr>
                                       <tr>
                                         <td class="Estilo28">&nbsp;</td>
                                          <?
										  for ($i=0; $i < @pg_numrows($result2); $i++){
										      
								              ?>
                                              <td align="center"><span class="Estilo28"><?=$nombre_institucion_[$i]?></span></td>
                                              <?
										  }
										  ?>                                         
                                         <td align="center"><span class="Estilo28">Total </span></td>
                                       </tr>
                                      
									
									    							  
										      <tr>
											    <td class="Estilo28">Aprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // consultar en promoción la situación de los alumnos
													  $sql_sub    = "select count(*) as cantidad from promedio_sub_alumno where id_ramo in (select id_ramo from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$cmbNIVEL') and subsector.cod_subsector = '$cod_subsector') and promedio > 39";
													  $res_apro = @pg_Exec($conn,$sql_sub);
													  $fil_apro = @pg_fetch_array($res_apro);
													  $suma1 = $suma1 + $fil_apro['cantidad'];
													 							  													  
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_apro['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma1?></td>
										      </tr>
											  <tr>
											    <td class="Estilo28">Reprobados</td>									
											       <?
												   for ($i=0; $i < @pg_numrows($result2); $i++){
												      // alumnos reporbados
												      $sql_rep = "select count(*) as cantidad from promedio_sub_alumno where id_ramo in (select id_ramo from ramo inner join subsector on ramo.cod_subsector=subsector.cod_subsector where id_curso in (select id_curso from curso where id_ano in (select id_ano from ano_escolar where id_institucion = '$rdb_[$i]' and id_ano = '$id_ano_[$i]') and id_nivel = '$cmbNIVEL') and subsector.cod_subsector = '$cod_subsector') and promedio < 40";
													  $res_rep = @pg_Exec($conn, $sql_rep);
													  $fil_rep = @pg_fetch_array($res_rep);
													  $suma2 = $suma2 + $fil_rep['cantidad'];
													  ?>
													  <td align="center"><span class="Estilo28">&nbsp;<?=$fil_rep['cantidad'];?></span></td>
													  <?
												   }
												   ?> 
											       <td align="center" class="Estilo28">&nbsp;<?=$suma2?></td>
										      </tr>											 
											                                   
                                   </table></td>
                               </tr>
                             </table>
																			
						<? } ?>
						
						
				</td>
				</tr>								
			</table>
						 
							
<!-- fin evaluaciones -->
			<!-- SIMCE Y PSU-->
			<table width="650" border="0" cellspacing="0" cellpadding="0" id="simce" align="center">
			  <tr>
				<td>
				<? if($ck_PSU!="BUSCAR"){?>
				<form name="form_psu" action="reportesCorporativos.php" method="post">
				<input name="pesta" value="9" type="hidden">
				<table width="650" border="0" cellspacing="0" cellpadding="5" align="center">
				  <tr>
					<td colspan="3"  class="tableindex">BUSCADOR SIMCE - PSU (modulo en construcci&oacute;n) </td>
					</tr>
				  <tr>
					<td width="99">&nbsp;</td>
					<td width="281">&nbsp;</td>
					<td width="262">&nbsp;</td>
				  </tr>
				  <tr>
					<td><span class="Estilo20">PRUEBA</span></td>
					<td><span class="Estilo20">
					  <input name="prueba" type="radio" value="1" onClick="enviapag2(this.form)" <? if($prueba==1) echo "checked";?>>
					  SIMCE 
					    <input name="prueba" type="radio" value="2" onClick="enviapag2(this.form)" <? if($prueba==2) echo "checked";?>>
					    PSU</span></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td><span class="Estilo20">A&Ntilde;O</span></td>
					<td><span class="Estilo20">
					  <select name="cmbANO_SP" onChange="enviapag2(this.form)">
					    <option value="0">seleccione</option>
						<? for($i=2002;$i<2010;$i++){ 
					    	if($cmbANO_SP==$i){ ?>
						<option value="<?=$i;?>" selected="selected"><?=$i;?></option>
						<? 	}else{ ?>	
					    <option value="<?=$i;?>"><?=$i;?></option>
						<? 	} 
						   }
						 ?>	
					    </select>
					</span> </td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td><span class="Estilo20">SUBSECTOR</span></td>
					<td><span class="Estilo20">
					<? 	if($prueba==1){
							$sql = "SELECT distinct a.cod_subsector,b.nombre  FROM simce_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
							$sql.="INNER JOIN ano_escolar c ON a.id_ano=c.id_ano WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") ";
							$sql.="AND nro_ano=".$cmbANO_SP;
						}else{
							$sql ="SELECT distinct a.cod_subsector,b.nombre FROM psu_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
							$sql.="INNER JOIN ano_escolar c ON a.cod_ano=c.id_ano WHERE c.id_institucion in (SELECT rdb FROM corp_instit ";
							$sql.="WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_SP;
						}
						$rs_subsector = @pg_exec($conn,$sql);
					?>
					
					  <select name="cmbSUBSECTOR">
					  	<option value=0>seleccione</option>
					  	<? for($i=0;$i<@pg_numrows($rs_subsector);$i++){
								$fila_sub = @pg_fetch_array($rs_subsector,$i);
						?>
						<option value="<?=$fila_sub['cod_subsector'];?>"><?=$fila_sub['nombre'];?></option>
						<? } ?>
					  </select>
					</span></td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td><span class="Estilo20">NIVEL</span></td>
					<td> <select name="cmbNIVEL" class="ddlb_x Estilo20 Estilo11" >
						  <option value="0">Seleccione Nivel </option>
						  <?
						  // tomar los niveles asociados
							$qry7 = "select id_nivel, nombre from niveles  WHERE id_nivel in (2,6,8,10) order by id_nivel";
							$result7 =@pg_Exec($conn,$qry7);
							for ($i=0; $i < @pg_numrows($result7); $i++){
								 $fila7 = @pg_fetch_array($result7,$i);	
								 $nombre_nivel  = $fila7['nombre'];
								 $id_nivel      = $fila7['id_nivel'];
								 ?>
								   <option value="<?=$id_nivel;?>"><?=$nombre_nivel?></option>
								 <? 
							}										  
						   ?>		  
						  </select>					</td>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
					<td>&nbsp;</td>
					<td><input type="submit" name="ck_PSU" value="BUSCAR" class="botonXX"></td>
				  </tr>
				</table>
				</form>
				<? } ?>
				</td>
			  </tr>
			  <? 
			  if(($prueba==1 && $pesta==9) && ($cmbANO_SP!=0 && $cmbNIVEL==0 && $cmbSUBSECTOR=="0") && $ck_PSU=="BUSCAR"){
			  		$sql ="SELECT nombre_instit, rdb FROM institucion a INNER JOIN ano_escolar b ON a.rdb=b.id_institucion WHERE rdb in ";
					$sql.=" (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_SP."";
					$rs_instit = @pg_exec($conn,$sql);
					
					$sql = "SELECT distinct a.cod_subsector,b.nombre  FROM simce_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
					$sql.="INNER JOIN ano_escolar c ON a.id_ano=c.id_ano WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") ";
					$sql.="AND nro_ano=".$cmbANO_SP;
					$rs_subsector = @pg_exec($conn,$sql);
			?>
			  <tr>
				<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td class="tableindex" align="center">RESULTADO PRUEBA SIMCE DE TODOS LOS ESTABLECIMIENTOS </td>
				  </tr>
				  <tr>
					<td align="center" class="Estilo25">AÑO&nbsp;<?=$cmbANO_SP;?></td>
				  </tr>
				  <tr>
					<td>&nbsp;</td>
				  </tr>
				  <tr>
					<td>
						<table width="100%" border="1" cellspacing="0" cellpadding="3">
						
						  <tr>
							<td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
							<td colspan="<?=pg_numrows($rs_subsector);?>" align="center" class="tableindex">SUBSECTOR</td>
							<td rowspan="2" class="tableindex">RESULTADO<br>PUNTAJE</td>
						  </tr>
						 
						  <tr>
						  <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){
									$fila_sub = @pg_fetch_array($rs_subsector,$x);
							?>
							<td class="tableindex"><? InicialesSubsector($fila_sub['nombre']);?></td>
							<? } ?>
						  </tr>
						   <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
					       ?>
						  <tr>
							<td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
						  <? 	$prom_inst=0;
								$cont_sub=0;
						  		for($x=0;$x<@pg_numrows($rs_subsector);$x++){
								$fila_sub = @pg_fetch_array($rs_subsector,$x);
								
								$sql ="SELECT avg(nota) FROM simce_notas_2009 WHERE id_ano in (SELECT id_ano FROM ano_Escolar WHERE "; 
								$sql.="id_institucion=".$fila_instit['rdb']."";
								$sql.=" AND nro_ano=".$cmbANO_SP.") AND id_sub_sim in (SELECT id_sub_sim FROM simce_conf_2009 WHERE ";
								$sql.=" cod_subsector=".$fila_sub['cod_subsector'].")";
								$rs_puntaje = @pg_exec($conn,$sql);	
								$puntaje = @pg_result($rs_puntaje,0);
						  ?>	
							<td class="Estilo25"><?=intval($puntaje);?></td>
						<? 		$prom_inst += $puntaje;
								$prom_sub[$x] +=$puntaje;
								$valor[$x] = $puntaje;
								if($valor[$x] !=""){
								 	$cont_sub[$x]=$cont_sub[$x] + 1;
								}
									
						} 
						?>

							<td class="Estilo25"><?=round($prom_inst / @pg_numrows($rs_subsector));?></td>
						  </tr>
						  <? } ?>
						  <tr>
							<td class="tableindex">RESULTADO PUNTAJE </td>
						 <? for($x=0;$x<@pg_numrows($rs_subsector);$x++){?>	
							<td class="tableindex"><?=intval($prom_sub[$x]);?></td>
						<? } ?>
							<td class="tableindex">&nbsp;</td>
						  </tr>
						</table><br>
						
						<table width="200" border="0" align="center">
						  <tr>
							<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=9&cmbANO_SP=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
							<td class="Estilo4"><a href="printPSUSIMCE.php?caso=1&cmbANO_SP=<?=$cmbANO_SP;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
						  </tr>
							</table>



					</td>
				  </tr>
				</table>
				</td>
			  </tr>
			  <? } 
				  if($prueba==2 && $pesta==9 && $cmbANO_SP!=0 && $cmbNIVEL==0 && $cmbSUBSECTOR==0 && $ck_PSU=="BUSCAR"){
				  	$sql  ="SELECT nombre_instit, rdb, id_ano FROM institucion a INNER JOIN ano_escolar b ON a.rdb=b.id_institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_SP;
					$rs_instit = @pg_exec($conn,$sql);
					
					$sql = "SELECT distinct a.cod_subsector,b.nombre FROM psu_conf_2009 a INNER JOIN subsector b ON a.cod_subsector=b.cod_subsector ";
					$sql.= "INNER JOIN ano_escolar c ON a.cod_ano=c.id_ano WHERE c.id_institucion in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") ";
					$sql.= " AND nro_ano=".$cmbANO_SP;
					$rs_subsector = @pg_exec($conn,$sql);
					
			?>
			  <tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="tableindex" align="center">RESULTADO PRUEBA PSU DE TODOS LOS ESTABLECIMIENTOS</td>
                  </tr>
                  <tr>
                    <td align="center" class="Estilo25">A&Ntilde;O&nbsp;
                        <?=$cmbANO_SP;?></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
                          <td colspan="<?=pg_numrows($rs_subsector);?>" align="center" class="tableindex">SUBSECTOR</td>
                          <td rowspan="2" class="tableindex">RESULTADO<br>PUNTAJE</td>
                        </tr>
                        <tr>
						<? for($x=0;$x<@pg_numrows($rs_subsector);$x++){
								$fila_sub = @pg_fetch_array($rs_subsector,$x);
						?>
					      <td class="tableindex"><? InicialesSubsector($fila_sub['nombre']);?></td>
						<? } ?>
                        </tr>
                        <? 	for($i=0;$i<@pg_numrows($rs_instit);$i++){
						   		$fila_instit = @pg_fetch_array($rs_instit,$i);
								
								
					   ?>
                        <tr>
                          <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
                          <? $puntaje_inst=0;
						  for($x=0;$x<@pg_numrows($rs_subsector);$x++){
								$fila_sub = @pg_fetch_array($rs_subsector,$x);
								
								$sql =" SELECT avg(puntaje) FROM psu_notas_2009 WHERE cod_ano in (SELECT id_ano FROM ano_Escolar WHERE ";
								$sql.=" id_institucion=".$fila_instit['rdb']." AND nro_ano=".$cmbANO_SP.") AND cod_sub_psu in (SELECT cod_sub_psu ";
								$sql.=" FROM psu_conf_2009 WHERE cod_subsector=".$fila_sub['cod_subsector'].") 	";
								$rs_puntaje = @pg_exec($conn,$sql);
								$puntaje = @pg_result($rs_puntaje,0);
						  ?>
						  <td class="Estilo25"><?=round($puntaje,1);?></td>
                          <? 
						  	$puntaje_inst += $puntaje;
							$puntaje_sub[$x] +=$puntaje;
						  } ?>
						  <td class="Estilo25"><?=round($puntaje_inst,1);?></td>
                        </tr>
                        <? } ?>
                        <tr>
                          <td class="tableindex">RESULTADO PUNTAJE </td>
						<? for($x=0;$x<@pg_numrows($rs_subsector);$x++){
							$fila_sub = @pg_fetch_array($rs_subsector,$x);
						?>
                          <td class="tableindex"><?=round($puntaje_sub[$x],1);?></td>
                        <? } ?>
                          <td class="tableindex">&nbsp;</td>
                        </tr>
                    </table><br>
					<table width="200" border="0" align="center">
						  <tr>
							<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=9&cmbANO_SP=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
							<td class="Estilo4"><a href="printPSUSIMCE.php?caso=2&cmbANO_SP=<?=$cmbANO_SP;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
						  </tr>
							</table>
					</td>
                  </tr>
                </table></td>
			  </tr>
 			  <? } 
				  if($prueba==1 && $pesta==9 && $cmbANO_SP!=0 && $cmbNIVEL==0 && $cmbSUBSECTOR!="0" && $ck_PSU=="BUSCAR"){
				  	$sql  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion." AND rdb in (SELECT id_institucion FROM ano_escolar WHERE nro_ano=".$cmbANO_SP."))";
					$rs_instit = @pg_exec($conn,$sql);
					
					$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
					$rs_sub = @pg_exec($conn,$sql);
					$nombre_sub = @pg_result($rs_sub,0);
					
					$sql =" SELECT DISTINCT id_curso FROM simce_notas_2009 WHERE id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion in ";
					$sql.="(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")) AND id_sub_sim IN (SELECT id_sub_sim FROM simce_conf_2009 ";
					$sql.=" WHERE cod_subsector=".$cmbSUBSECTOR.")";
					$rs_curso = @pg_exec($conn,$sql);			
					
			  ?>
			  <tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA SIMCE DE TODOS LOS ESTABLECIMIENTOS</td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="18%" class="Estilo25">SUBSECTOR</td>
                    <td width="82%" class="Estilo25"><?=$nombre_sub;?></td>
                  </tr>
                  <tr>
                    <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
                    <td><span class="Estilo25">
                      <?=$cmbANO_SP;?>
                    </span></td>
                  </tr>
                  <tr>
                    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
                          <td colspan="<?=@pg_numrows($rs_curso);?>" align="center"class="tableindex">CURSOS</td>
                          <td rowspan="2" class="tableindex">RESULTADO<br>
                            PUNTAJE</td>
                        </tr>
                        <tr>
						<? for($x=0;$x<@pg_numrows($rs_curso);$x++){
								$fila_curso = @pg_fetch_array($rs_curso,$x);
						?>					
                          <td class="tableindex"><? echo CursoPalabra($fila_curso['id_curso'],2,$conn);?></td>
                       <? } ?>
                        </tr>
                        <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
								$prom_inst=0;
					       ?>
                        <tr>
                          <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
                          <? for($x=0;$x<@pg_numrows($rs_curso);$x++){
								$fila_curso = @pg_fetch_array($rs_curso,$x);
								
								$sql ="SELECT avg(nota) FROM simce_notas_2009 a INNER JOIN simce_conf_2009 b ON (a.id_ano=b.id_ano) WHERE rdb=".$fila_instit['rdb']."";
								$sql.="  AND b.id_ano IN (SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." AND nro_ano=".$cmbANO_SP.") ";
								$sql.=" AND cod_subsector=".$cmbSUBSECTOR." AND id_curso=".$fila_curso['id_curso'];
								$rs_nota =@pg_exec($conn,$sql);
						  ?>	
						  <td class="Estilo25"><?=round(pg_result($rs_nota,0));?></td>
                          <? 	$prom_inst += round(pg_result($rs_nota,0));
						  		$prom_curso[$x] +=round(pg_result($rs_nota,0));
						  	} ?>
                          <td class="Estilo25"><?=$prom_inst;?></td>
                        </tr>
                        <? } ?>
                        <tr>
                          <td class="tableindex">RESULTADO PUNTAJE </td>
						  <? for($x=0;$x<@pg_numrows($rs_curso);$x++){?>	
                          <td class="tableindex"><?=$prom_curso[$x];?></td>
                        <? } ?>
                          <td class="tableindex">&nbsp;</td>
                        </tr>
                    </table><br>
					<table width="200" border="0" align="center">
						  <tr>
							<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=9&cmbANO_SP=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
							<td class="Estilo4"><a href="printPSUSIMCE.php?caso=3&cmbANO_SP=<?=$cmbANO_SP;?>&cmbSUBSECTOR=<?=$cmbSUBSECTOR;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
						  </tr>
							</table>
					</td>
                  </tr>
                </table></td>
			  </tr>
 			  <? } 
				  if($prueba==2 && $pesta==9 && $cmbANO_SP!=0 && $cmbNIVEL==0 && $cmbSUBSECTOR!=0 && $ck_PSU=="BUSCAR"){
				  	$sql = "SELECT nombre_instit, a.rdb, c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON ";
					$sql.= " a.rdb=c.id_institucion AND b.rdb=c.id_institucion WHERE num_corp=".$corporacion." AND nro_ano=".$cmbANO_SP; 
					$rs_instit = @pg_exec($conn,$sql);
					
					
					$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
					$rs_sub = @pg_exec($conn,$sql);
					$nombre_sub = @pg_result($rs_sub,0);
					
					$sql = "SELECT DISTINCT curso, id_ano FROM psu_promedios_2009 WHERE id_ano in (SELECT id_ano FROM ano_escolar WHERE id_institucion in ";
					$sql.= "(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.") AND nro_ano=".$cmbANO_SP.") AND id_subsector=".$cmbSUBSECTOR;
					$rs_curso = @pg_exec($conn,$sql);	
			  ?>
			  <tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA PSU DE TODOS LOS ESTABLECIMIENTOS </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="18%" class="Estilo25">SUBSECTOR</td>
                    <td width="82%" class="Estilo25"><?=$nombre_sub;?></td>
                  </tr>
                  <tr>
                    <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
                    <td><span class="Estilo25">
                      <?=$cmbANO_SP;?>
                    </span></td>
                  </tr>
                  <tr>
                    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td rowspan="2" class="tableindex">ESTABLECIMIENTO</td>
                          <td colspan="<?=@pg_numrows($rs_curso);?>" align="center"class="tableindex">4TOS MEDIOS </td>
                          <td rowspan="2" class="tableindex">RESULTADO<br>
                            PUNTAJE</td>
                        </tr>
                        <tr>
					<? for($x=0;$x<@pg_numrows($rs_curso);$x++){
							$fila_curso = @pg_fetch_array($rs_curso,$x);
							
					?>				
                          <td class="tableindex"><? echo CursoPalabra($fila_curso['curso'],3,$conn)."---".$fila_curso['curso'];?></td>
					<? } ?>
                        </tr>
                        <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
								$prom_inst=0;
					       ?>
                        <tr>
                          <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
                         <? for($x=0;$x<@pg_numrows($rs_curso);$x++){
							$fila_curso = @pg_fetch_array($rs_curso,$x);
							$promedio =0;
							
							
							$sql ="SELECT avg(puntaje) FROM psu_promedios_2009 WHERE curso=".$fila_curso['curso']." AND id_ano=".$fila_instit['id_ano'];
							$rs_promedio =@pg_exec($conn,$sql);
							$promedio = @pg_result($rs_promedio,0);
							
						?>	
						  <td class="Estilo25"><?=round($promedio);?></td>
                       <? 	$prom_inst +=$promedio; 
					   		$prom_curso[$x] +=$promedio;
					   		} ?>
                          <td class="Estilo25"><?=round($prom_inst);?></td>
                        </tr>
                        <? } ?>
                        <tr>
                          <td class="tableindex">RESULTADO PUNTAJE </td>
                         <? for($x=0;$x<@pg_numrows($rs_curso);$x++){ ?>	
						  <td class="tableindex"><?=round($prom_curso[$x]);?></td>
					    <? } ?>
                          <td class="tableindex">&nbsp;</td>
                        </tr>
                    </table><br>
					<table width="200" border="0" align="center">
						  <tr>
							<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=9&cmbANO_SP=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
							<td class="Estilo4"><a href="printPSUSIMCE.php?caso=4&cmbANO_SP=<?=$cmbANO_SP;?>&cmbSUBSECTOR=<?=$cmbSUBSECTOR;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
						  </tr>
							</table>
					</td>
                  </tr>
                </table></td>
			  </tr>
			  <? } 
				  if($prueba==1 && $pesta==9 && $cmbANO_SP!=0 && $cmbNIVEL!=0 && $cmbSUBSECTOR!=0 && $ck_PSU=="BUSCAR"){
				  	$sql = "SELECT nombre_instit, a.rdb, c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON ";
					$sql.= " a.rdb=c.id_institucion AND b.rdb=c.id_institucion WHERE num_corp=".$corporacion." AND nro_ano=".$cmbANO_SP; 
					$rs_instit = @pg_exec($conn,$sql);
					
					$sql = "SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
					$rs_nivel = @pg_exec($conn,$sql);
					$nombre_nivel = @pg_result($rs_nivel,0);
					
					$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
					$rs_sub = @pg_exec($conn,$sql);
					$nombre_sub = @pg_result($rs_sub,0);
			  ?>
			  <tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA SIMCE DE TODOS LOS ESTABLECIMIENTOS </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="Estilo25">NIVEL</td>
                    <td class="Estilo25"><?=$nombre_nivel;?></td>
                  </tr>
                  <tr>
                    <td width="18%" class="Estilo25">SUBSECTOR</td>
                    <td width="82%" class="Estilo25"><?=$nombre_sub;?></td>
                  </tr>
                  <tr>
                    <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
                    <td><span class="Estilo25">
                      <?=$cmbANO_SP;?>
                    </span></td>
                  </tr>
                  <tr>
                    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td class="tableindex">ESTABLECIMIENTO</td>
                          <td align="center"class="tableindex">PROMEDIO FINAL </td>
                          <td class="tableindex">PUNTAJE SIMCE </td>
                        </tr>
                        
                        <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
								$sql =" SELECT avg(puntaje) FROM simce_inst_2009 WHERE id_ano=".$fila_instit['id_ano']." AND id_curso in ";
								$sql.=" (SELECT id_curso FROM curso WHERE id_nivel=".$cmbNIVEL." AND id_ano=".$fila_instit['id_ano'].")";
								$rs_puntaje = @pg_exec($conn,$sql);
								$puntaje = @pg_result($rs_puntaje,0);
								
								$sql =" SELECT avg(puntaje_final) FROM simce_final_2009 WHERE id_ano=".$fila_instit['id_ano']." AND id_curso in ";
								$sql.=" (SELECT id_curso FROM curso WHERE id_nivel=".$cmbNIVEL." AND id_ano=".$fila_instit['id_ano'].")";
								$rs_promedio = @pg_exec($conn,$sql);
								$promedio = @pg_result($rs_promedio,0);
					       ?>
                        <tr>
                          <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
                          <td class="Estilo25"><?=round($promedio);?></td>
                          <td class="Estilo25"><?=round($puntaje);?></td>
                        </tr>
                        <? 	$promedio_inst +=$promedio;
							$puntaje_inst +=$puntaje;
						
							} ?>
                        <tr>
                          <td class="tableindex">PROMEDIO</td>
                          <td class="tableindex"><?=round($promedio_inst);?></td>
                          <td class="tableindex"><?=round($puntaje_inst);?></td>
                        </tr>
                    </table><br>
					<table width="200" border="0" align="center">
						  <tr>
							<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=9&cmbANO_SP=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
							<td class="Estilo4"><a href="printPSUSIMCE.php?caso=5&cmbANO_SP=<?=$cmbANO_SP;?>&cmbSUBSECTOR=<?=$cmbSUBSECTOR;?>&cmbNIVEL=<?=$cmbNIVEL;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
						  </tr>
							</table>
					</td>
                  </tr>
                </table></td>
			  </tr>
  			  <? } 
				  if($prueba==2 && $pesta==9 && $cmbANO_SP!=0 && $cmbNIVEL!=0 && $cmbSUBSECTOR!=0 && $ck_PSU=="BUSCAR"){
				  	$sql = "SELECT nombre_instit, a.rdb, c.id_ano FROM institucion a INNER JOIN corp_instit b ON a.rdb=b.rdb INNER JOIN ano_escolar c ON ";
					$sql.= " a.rdb=c.id_institucion AND b.rdb=c.id_institucion WHERE num_corp=".$corporacion." AND nro_ano=".$cmbANO_SP; 
					$rs_instit = @pg_exec($conn,$sql);
					
					$sql = "SELECT nombre FROM niveles WHERE id_nivel=".$cmbNIVEL;
					$rs_nivel = @pg_exec($conn,$sql);
					$nombre_nivel = @pg_result($rs_nivel,0);
					
					$sql = "SELECT nombre FROM subsector WHERE COD_SUBSECTOR=".$cmbSUBSECTOR;
					$rs_sub = @pg_exec($conn,$sql);
					$nombre_sub = @pg_result($rs_sub,0);
					
			  ?>
			  <tr>
				<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="2" align="center" class="tableindex">RESULTADO POR SUBSECTOR PRUEBA PSU DE TODOS LOS ESTABLECIMIENTOS </td>
                  </tr>
                  <tr>
                    <td colspan="2" align="center" class="Estilo25">&nbsp;</td>
                  </tr>
                  <tr>
                    <td class="Estilo25">NIVEL</td>
                    <td class="Estilo25"><?=$nombre_nivel;?></td>
                  </tr>
                  <tr>
                    <td width="18%" class="Estilo25">SUBSECTOR</td>
                    <td width="82%" class="Estilo25"><?=$nombre_sub;?></td>
                  </tr>
                  <tr>
                    <td><span class="Estilo25">A&Ntilde;O&nbsp;</span></td>
                    <td><span class="Estilo25">
                      <?=$cmbANO_SP;?>
                    </span></td>
                  </tr>
                  <tr>
                    <td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
                        <tr>
                          <td class="tableindex">ESTABLECIMIENTO</td>
                          <td align="center"class="tableindex">PROMEDIO FINAL </td>
                          <td class="tableindex">PUNTAJE PSU </td>
                        </tr>
                        <? for($i=0;$i<@pg_numrows($rs_instit);$i++){
								$fila_instit = @pg_fetch_array($rs_instit,$i);
								
								$sql ="SELECT avg(puntaje) FROM psu_promedios_2009 WHERE id_ano=547 AND curso IN (SELECT id_curso FROM curso ";
								$sql.="WHERE id_nivel=".$cmbNIVEL." AND id_ano=".$fila_instit['id_ano'].") AND id_subsector=".$cmbSUBSECTOR;
								$rs_promedio = @pg_exec($conn,$sql);
								$promedio = @pg_result($rs_promedio,0);
								
								$sql ="SELECT avg(puntaje) FROM psu_notas_2009 WHERE cod_ano=".$fila_instit['id_ano']." AND cod_sub_psu in ";
								$sql.="(SELECT cod_sub_psu FROM psu_conf_2009 WHERE cod_ano=".$fila_instit['id_ano']." AND cod_subsector=".$cmbSUBECTOR.")";
								$rs_puntaje = @pg_exec($conn,$sql);
								$puntaje = @pg_result($rs_puntaje,0);
								
								

					       ?>
                        <tr>
                          <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
                          <td class="Estilo25"><?=round($promedio);?></td>
                          <td class="Estilo25"><?=round($puntaje);?></td>
                        </tr>
                        <? 	$promedio_inst +=$promedio;
							$puntaje_inst +=$puntaje;
							} ?>
                        <tr>
                          <td class="tableindex">PROMEDIO</td>
                          <td class="tableindex"><?=$promedio_inst;?></td>
                          <td class="tableindex"><?=$puntaje_inst;?></td>
                        </tr>
                    </table><br>
					<table width="200" border="0" align="center">
						  <tr>
							<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=9&cmbANO_SP=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
							<td class="Estilo4"><a href="printPSUSIMCE.php?caso=6&cmbANO_SP=<?=$cmbANO_SP;?>&cmbSUBSECTOR=<?=$cmbSUBSECTOR;?>&cmbNIVEL=<?=$cmbNIVEL;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
						  </tr>
							</table>
					</td>
                  </tr>
                </table></td>
			  </tr>
			  <? } ?>
			</table>

			<!--FIN SIMCE - PSU -->

			<!--BECAS Y BENEFICIOS-->
			<table width="650" border="0" cellspacing="0" cellpadding="0" id="becas" align="center">
						  <tr>
							<td>
							<? if($ck_BECAS!="BUSCAR" or $ck_BECAS=="BUSCAR" and $cmb_ano2==0 and $consultar==1 or $ck_BECAS=="BUSCAR" and $cmb_beca==0 and $consultar==2 or $ck_BECAS=="BUSCAR" and $cmb_ano2==0 and $consultar==0 or $ck_BECAS=="BUSCAR" and $cmb_beca==0 and $consultar==0 or $ck_BECAS=="BUSCAR" and $cmb_beca!=0 and $cmb_ano2!=0 and $consultar==0){?>
							
							<form name="form" action="reportesCorporativos.php" method="post">
							<input name="pesta" value="10" type="hidden">
							<table width="650" border="0" cellspacing="0" cellpadding="5" align="center">
							  <tr>
								<td colspan="3"  class="tableindex">BUSCADOR BECAS Y BENEFICIOS </td>
								</tr>
							  <tr>
								<td width="99">&nbsp;</td>
								<td width="281">&nbsp;</td>
								<td width="262">&nbsp;</td>
							  </tr>
							   <tr>
								<td><span class="Estilo20">A&Ntilde;O ESCOLAR:</span></td>
								<td><select name="cmb_ano2" class="ddlb_x" onChange="enviapag2(this.form);">
								  <option value="0">Seleccione A&ntilde;o</option>
								  <option value="2009" <? if ($cmb_ano2=="2009"){ ?> selected="selected" <? } ?>>2009</option>
								  <option value="2008" <? if ($cmb_ano2=="2008"){ ?> selected="selected" <? } ?>>2008</option>
								  <option value="2007" <? if ($cmb_ano2=="2007"){ ?> selected="selected" <? } ?>>2007</option>
								  <option value="2006" <? if ($cmb_ano2=="2006"){ ?> selected="selected" <? } ?>>2006</option>
								  <option value="2005" <? if ($cmb_ano2=="2005"){ ?> selected="selected" <? } ?>>2005</option>
								  <option value="2004" <? if ($cmb_ano2=="2004"){ ?> selected="selected" <? } ?>>2004</option>
								</select>
								  <input name="cmb_inst2" type="hidden" id="cmb_inst2" value="<?=$cmb_inst ?>"></td>
								<td>&nbsp;</td>
							   </tr>
							  <tr>
								<td><span class="Estilo20">CONSULTAR POR </span></td>
								<td><span class="Estilo20">
								  <input name="consultar" type="radio" value="1" onClick="enviapag2(this.form)" <? if($consultar==1) echo "checked";?>>
								  ESTABLECIMIENTOS
								  <input name="consultar" type="radio" value="2" onClick="enviapag2(this.form)" <? if($consultar==2) echo "checked";?>>
								  BECAS
								</span></td>
								<td>&nbsp;</td>
							  </tr>
							 <?php /*?> <tr>
								<td><span class="Estilo20">ESTABLECIMIENTOS</span></td>
								<td><select name="cmb_establecimiento" id="select">
								  <option value="0">Buscar en todos</option>
								  <? 
																	  $qry_ins="select corp_instit.rdb, corp_instit.estado, institucion.nombre_instit from corp_instit, institucion where corp_instit.num_corp = '$_CORPORACION' and corp_instit.rdb = institucion.rdb order by nombre_instit asc";
																	  $result_ins=@pg_Exec($conn,$qry_ins);
																	  for($i=0;$i<pg_numrows($result_ins);$i++){	
																		  $fila_ins = pg_fetch_array($result_ins,$i);
																		  $rdb = $fila_ins['rdb'];
																		  $establecimiento = $fila_ins['nombre_instit']; 
																		  ?>
								  <option value="<?=$rdb ?>">
									<?=$establecimiento ?>
									</option>
								  <?
																	  }
																	  ?>
								</select></td>
								<td>&nbsp;</td>
							  </tr><?php */?>
							 
							 <? if($consultar==2){?>
							  <tr>
								<td><span class="Estilo20">BECAS</span></td>
								<td><span class="Estilo20">
								  <?		
								  $sql_inst  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in ";
								  $sql_inst.="(SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
								$rs_instit = @pg_exec($conn,$sql_inst);
								for($i=0;$i<@pg_numrows($rs_instit);$i++){
											$fila_instit = @pg_fetch_array($rs_instit,$i);
										$sql_ano  ="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." ";
										$sql_ano.="and nro_ano=".$cmb_ano2."";
										$rs_ano = @pg_exec($conn,$sql_ano);
										$id_ano[$i]= pg_result($rs_ano,0);			
								
								
								$sql="SELECT * FROM becas_conf WHERE ";
							
								if($id_ano[0]!=NULL){
								$sql.="id_ano=".$id_ano[0];
								}
								if($i>=1 and $id_ano[1]!=NULL and $id_ano[0]!=NULL){
								$sql.=" or ";
								}
								if($id_ano[1]!=NULL){
								$sql.="id_ano=".$id_ano[1];
								}
								if($i>=2 and $id_ano[2]!=NULL and $id_ano[1]!=NULL){
								$sql.=" or ";
								}
								if($id_ano[2]!=NULL){
								$sql.="id_ano=".$id_ano[2];
								} 
								if($i>=3 and $id_ano[3]!=NULL and $id_ano[2]!=NULL){
								$sql.=" or ";
								} 
								if($id_ano[3]!=NULL){
								$sql.="id_ano=".$id_ano[3];
								} 
								if($i>=4 and $id_ano[4]!=NULL and $id_ano[3]!=NULL){
								$sql.=" or ";
								} 
								if($id_ano[4]!=NULL){
								$sql.="id_ano=".$id_ano[4];
								} 
								if($i>=5 and $id_ano[5]!=NULL and $id_ano[4]!=NULL){
								$sql.=" or ";
								} 
								if($id_ano[5]!=NULL){
								$sql.="id_ano=".$id_ano[5];
								} 
								if($i>=6 and $id_ano[6]!=NULL and $id_ano[5]!=NULL){
								$sql.=" or ";
								} 
								if($id_ano[6]!=NULL){
								$sql.="id_ano=".$id_ano[6];
								} 
								if($i>=7 and $id_ano[7]!=NULL and $id_ano[6]!=NULL){
								$sql.=" or ";
								} 
								if($id_ano[7]!=NULL){
								$sql.="id_ano=".$id_ano[7];
								} 
								if($i>=8 and $id_ano[8]!=NULL and $id_ano[7]!=NULL){
								$sql.=" or ";
								} 
								if($id_ano[8]!=NULL){
								$sql.="id_ano=".$id_ano[8];
								} 
								if($i>=9 and $id_ano[9]!=NULL and $id_ano[8]!=NULL){
								$sql.=" or ";
								}
								if($id_ano[9]!=NULL){
								$sql.="id_ano=".$id_ano[9];
								} 
								if($i>=10 and $id_ano[10]!=NULL and $id_ano[9]!=NULL){
								$sql.=" or ";
								} 
								if($id_ano[10]!=NULL){
								$sql.="id_ano=".$id_ano[10];
								}
											
								}
			
								$resp_cmb = pg_exec($conn,$sql);
								$num_becas = pg_numrows($resp_cmb);
				  ?>
								  <select name="cmb_beca" class="ddlb_x">
									<option value="0" selected>Seleccione Beca</option>
									<?  for($i=0;$i<$num_becas;$i++){
							$fila_cmb = @pg_fetch_array($resp_cmb,$i); 
								if ($fila_cmb['id_beca'] == $cmb_beca){?>
									<option value="<?=$fila_cmb['id_beca']?>" selected>
									  <?=$fila_cmb['nomb_beca']?>
									  </option>
									<? }else{?>
									<option value="<?=$fila_cmb['id_beca']?>">
									  <?=$fila_cmb['nomb_beca']?>
									  </option>
									<?	}
						}?>
								  </select>
								</span></td>
								<td>&nbsp;</td>
							  </tr>
							  <? }?>
							  
							  <tr>
								<td>&nbsp;</td>
								<td>&nbsp;</td>
								<td><input type="submit" name="ck_BECAS" value="BUSCAR" class="botonXX"></td>
							  </tr>
							</table>
							</form>
							<? } ?>
							</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
						  </tr>
						  <tr>
							<td>&nbsp;</td>
						  </tr>
						  
						  
						  <? 
							  if($consultar==1 && $pesta==10 && $cmb_ano2!=0 && $ck_BECAS=="BUSCAR"){
								$sql  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
								$rs_instit = @pg_exec($conn,$sql);
								
						  ?>
						  <tr>
							<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td colspan="2" align="center" class="tableindex">ALUMNOS BECADOS DE TODOS LOS ESTABLECIMIENTOS </td>
							  </tr>
							  <tr>
								<td colspan="2" align="center" class="Estilo25">&nbsp;</td>
							  </tr>
							  <tr>
								<td width="8%"><span class="Estilo25">A&Ntilde;O:&nbsp;</span></td>
								<td width="92%"><span class="Estilo25">
								  <?=$cmb_ano2;?>
								</span></td>
							  </tr>
							  <tr>
								<td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
									<tr>
									  <td class="tableindex">ESTABLECIMIENTO</td>
									  <td align="center"class="tableindex">CANTIDAD</td>
									</tr>
									<? for($i=0;$i<@pg_numrows($rs_instit);$i++){
											$fila_instit = @pg_fetch_array($rs_instit,$i);
									   ?>
									<tr>
									  <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
									  <? 
								$sql_ano  ="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." ";
								$sql_ano.="and nro_ano=".$cmb_ano2."";
								$rs_ano = @pg_exec($conn,$sql_ano);
								$id_ano = pg_result($rs_ano,0);
								//echo $fila_instit['rdb']."=".$id_ano;
								
								$sql_becados  ="SELECT COUNT(*) FROM becas_benef WHERE id_ano=".$id_ano." ";
								$rs_becados = @pg_exec($conn,$sql_becados);
								$becados = pg_result($rs_becados,0);
								
									  ?>
									  <td class="Estilo25"><?=$becados?></td>
									  <? $total= $total+$becados; 
									  ?>
									</tr>
									<? } ?>
									<tr>
									  <td class="Estilo1">TOTAL BECADOS </td>
									  <td class="Estilo1"><?=$total?></td>
									</tr>
								</table><br>
								<table width="200" border="0" align="center">
									  <tr>
										<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=10&cmb_ano2=0&cmb_beca=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
										<td class="Estilo4"><a href="printBecasBeneficios.php?consultar=1&cmb_ano2=<?=$cmb_ano2;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
									  </tr>
								  </table>
								</td>
							  </tr>
							</table></td>
						  </tr>
						  <? } ?>
						  
						  
						  <? 
							  if($consultar==2 && $pesta==10 && $cmb_ano2!="" && $cmb_beca!=0 && $ck_BECAS=="BUSCAR"){
								$sql  ="SELECT nombre_instit, rdb FROM institucion WHERE rdb in (SELECT rdb FROM corp_instit WHERE num_corp=".$corporacion.")";
								$rs_instit = @pg_exec($conn,$sql);
								
						  ?>
						  <tr>
							<td><table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td colspan="2" align="center" class="tableindex">ALUMNOS BECADOS DE TODOS LOS ESTABLECIMIENTOS POR BECA </td>
							  </tr>
							  <tr>
								<td colspan="2" align="center" class="Estilo25">&nbsp;</td>
							  </tr>
							   <tr>
								<td width="8%"><span class="Estilo25">BECA:&nbsp;</span></td>
								<? $sql_beca  ="SELECT nomb_beca FROM becas_conf WHERE id_beca=".$cmb_beca."";
								$rs_beca = @pg_exec($conn,$sql_beca);
								$beca = pg_result($rs_beca,0);?>
								<td width="92%"><span class="Estilo25">
								  <?=$beca;?>
								</span></td>
							  </tr>
							  <tr>
								<td width="8%"><span class="Estilo25">A&Ntilde;O:&nbsp;</span></td>
								<td width="92%"><span class="Estilo25">
								  <?=$cmb_ano2;?>
								</span></td>
							  </tr>
							  <tr>
								<td colspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="3">
									<tr>
									  <td class="tableindex">ESTABLECIMIENTO</td>
									  <td align="center"class="tableindex">CANTIDAD</td>
									</tr>
									<? for($i=0;$i<@pg_numrows($rs_instit);$i++){
											$fila_instit = @pg_fetch_array($rs_instit,$i);
									   ?>
									<tr>
									  <td class="Estilo25"><?=$fila_instit['nombre_instit'];?></td>
									  <? 
								$sql_ano  ="SELECT id_ano FROM ano_escolar WHERE id_institucion=".$fila_instit['rdb']." ";
								$sql_ano.="and nro_ano=".$cmb_ano2."";
								$rs_ano = @pg_exec($conn,$sql_ano);
								$id_ano = pg_result($rs_ano,0);
								//echo $fila_instit['rdb']."=".$id_ano;
								
								$sql_becados  ="SELECT COUNT(*) FROM becas_benef WHERE id_ano=".$id_ano." and id_beca=".$cmb_beca;
								$rs_becados = @pg_exec($conn,$sql_becados);
								$becados = pg_result($rs_becados,0);
								
									  ?>
									  <td class="Estilo25"><?=$becados?></td>
									  <? $total= $total+$becados; 
									  ?>
									</tr>
									<? } ?>
									<tr>
									  <td class="Estilo1">TOTAL BECADOS 
									    <?
			   include("../../cabecera/menu_superior.php");
			   ?></td>
									  <td class="Estilo1"><?=$total?></td>
									</tr>
								</table>
								<br>
								<table width="200" border="0" align="center">
									  <tr>
										<td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=10&cmb_ano2=0&cmb_beca=0"><img src="images/volver.gif" width="60" height="14" border="0"></a></span></td>
										<td class="Estilo4"><a href="printBecasBeneficios.php?consultar=2&cmb_ano2=<?=$cmb_ano2;?>&cmb_beca=<?=$cmb_beca;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
									  </tr>
								  </table>
								</td>
							  </tr>
							</table></td>
						  </tr>
						  <? } ?>
						  
						  
						</table>
			<!-- FIN BECAS Y BENEFICIOS-->
			
			<!--PRACTICAS Y TITULACIÓN  -->
           <? if($cmbANOS==0){?>
			<table width="650" border="0" cellspacing="0" cellpadding="5" align="center" id="practica">
			<form name="form_practica" action="reportesCorporativos.php?caso=0" method="post">
			<input name="pesta" value="11" type="hidden">
			
						<tr>	
							<td align="center" colspan="2" class="tableindex">Buscador Practicas y Titulaci&oacute;n</td>
						</tr>
						<tr>
						  <td class="Estilo4">A&ntilde;o</td>
						  <td><select name="cmbANOS">
							<option value="0">Selecione el año</option>
							<option value="2002">2002</option>
							<option value="2003">2003</option>
							<option value="2004">2004</option>
							<option value="2005">2005</option>
							<option value="2006">2006</option>
							<option value="2007">2007</option>
							<option value="2008">2008</option>
							<option value="2009">2009</option>
							</select>											  </td>
						</tr>
						<tr>
					  <td><span class="Estilo4">Seleccione Estado </span></td>
					  <td><select name="cmb_estados" id="cmb_estados">
						  <option value="0">Seleccione el Estado</option>
						  <option value="100">(Todos)</option>
						  <?
						$sql_es="select * from estado_practica order by cod_estado DESC ";
						$rs_estado = pg_exec($conn,$sql_es);
						
					for($x=0;$x<pg_numrows($rs_estado);$x++){
						$combo_es=pg_fetch_array($rs_estado,$x);
						if($combo_es['cod_estado']==$cmb_estados){
					
				  ?>
							  <option value="<?=$combo_es['cod_estado'];?>" selected="selected">
							  <?=$combo_es['nombre_estado'];?>
							  </option>
							  <? }else{ ?>
							  <option value="<?=$combo_es['cod_estado'];?>">
							  <?=$combo_es['nombre_estado'];?>
							  </option>
							  <? }
			 } ?>
							</select></td>
						  </tr>
														<tr>
														  <td>&nbsp;</td>
														  <td><input type="submit" name="buscar" value="BUSCAR" class="botonXX"></td>
														</tr>
					    </form>
						</table><? }else{?>
                        <table width="650" border="0" cellspacing="0" cellpadding="5" align="center" id="practica">                 
											<tr>
											  <td rowspan="2">&nbsp;</td>
											  <td>
                                              
                                              <? //if($caso==1){?>
                                              <table width="100%" border="0">
                                                <tr>
                                                  <td colspan="7" class=" Estilo20 Estilo1">INSTITUCIONES</td>
                                                </tr>
                                                <tr>
                                                <? 
									$sql=" select b.* from corp_instit a inner join institucion b on (a.rdb=b.rdb)  where num_corp=".$corporacion;
									$resp=pg_exec($conn,$sql);
									
								for($i=0;$i<pg_numrows($resp);$i++){	
									$fila_inst=pg_fetch_array($resp,$i);
									$rdb=$fila_inst['rdb'];		
												
												?>
                                                  <td width="45%" colspan="7" class="Estilo25"><?=ucfirst($fila_inst['nombre_instit']);?>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                 <td valign="top">
                                                  <table width="100" border="1"> 
												
                                                    <tr>
                                                     <?  
														$sql2="select * from estado_practica ";
														if($cmb_estados!=100){
														   $sql2.=" where cod_estado=$cmb_estados";														
														}else{
																													
														}
														$resp2=pg_exec($conn,$sql2);
														//echo $sql2;
													for($j=0;$j<pg_numrows($resp2);$j++){
														$fila=pg_fetch_array($resp2,$j);
														$cod_estado=$fila['cod_estado'];
													 ?>
                                                      <td  align="center" width="90" height="55" class="Estilo4"><?=$fila['nombre_estado'];?>&nbsp;</td>
                                                    <? } ?>
                                                    </tr>
                                                    <tr>
                                                   <?
								$sql_ano=" select id_ano from ano_escolar where nro_ano=$cmbANOS and id_institucion=$rdb";	
								$resp_ano=pg_exec($conn,$sql_ano);
								$ano_inst=pg_result($resp_ano,0);
													
											for($x=0;$x<pg_numrows($resp2);$x++){
											$fila=pg_fetch_array($resp2,$x);
											$cod_estado=$fila['cod_estado'];				
                                $sql3="select DISTINCT a.* from practicas a inner join matricula b on (a.rut_alu=b.rut_alumno) where a.estado=$cod_estado and b.rdb=$rdb and a.id_ano=$ano_inst";
								//echo $sql3;
								$resp3=pg_exec($conn,$sql3);
								$total=pg_numrows($resp3);														
													
													?>
                                                      <td align="center" class="Estilo1"><?=$total;?>&nbsp;</td>
                                                       <? }?>
													</tr> 
                                                  </table>
												 </td>
                                                </tr>
												<? }?>
                                              </table>	
                                              <p>&nbsp;</p>											    
										</td>
           							 </tr>
											<tr align="center">
											  <td class="Estilo4"><span class="Estilo8"><a href="reportesCorporativos.php?pesta=11&cmbANOS=0&caso=1"><img src="images/volver.gif" width="60" height="14" border="0"></a></span>
							<a href="printPRACTICA.php?caso=6&cmbANOS=<?=$cmbANOS;?>&cmb_estados=<?=$cmb_estados;?>" target="_blank"><img src="images/imprimir_reporte.gif" width="118" height="14" border="0"></a></td>
								  </tr><? }?>	
           
                </table>
 <!--FIN PRACTICAS Y TITULACIÓN  -->


					</td>
					     </tr>
					  </table>
					 
					  <!-- FIN CUERPO REPORTE DE CORPORACIONES -->					  </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
</table>
</body>
</html>
