<?php 	require('../../../../../util/header.inc');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript">
<!--



function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<head>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion_ano=pg_result($result,0);
	
	
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//curso.ensenanza=".pg_result($rs_acceso,3)." AND
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND  id_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=6)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=30)){$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=6)&&($_PERFIL!=17)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=30)&&($_PERFIL!=32)&&($_PERFIL!=2)&&($_PERFIL!=31)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
if($frmModo=="")
{
$frmModo = mostrar;
}


	$fecha=getdate();
	$diaActual=$fecha["mday"];
	
	
	
	
	
	$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result1106 =@pg_Exec($conn,$qry1106);
				
				if (!$result1106){
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result1106)!=0){
						$fila1106 = @pg_fetch_array($result1106,0);	
						if (!$fila1106){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}else{
						  $fila1106 = @pg_fetch_array($result1106,0);
					    }	  
					}
											
				}
	
?>
					

<SCRIPT language="JavaScript">

function enviapag3(form){
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'justifica_inasistencia.php';
				form.submit(true);
	
				}	
			}
</SCRIPT>
<script language= "JavaScript">
var ancho , alto , cCeldas , celdas , pasoH , pasoV;

/*
function iniciar(){
	celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
	celdas1 = document.getElementById("contenido").getElementsByTagName("td").length;

	for (i=0; i<celdas0;i++){
		cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";
	}

	for (j=0; j<celdas1;j++){
		cCeldas = document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML;
		document.getElementById("contenido").getElementsByTagName("td").item(j).innerHTML = cCeldas+"<img class=\"rell\">";
	}
}
*/


function iniciar(){
	celdas0 = document.getElementById("encCol").getElementsByTagName("td").length;
	
	for (i=0; i<celdas0;i++){
		cCeldas = document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("encCol").getElementsByTagName("td").item(i).innerHTML = cCeldas+"<img class=\"rell\">";

		cCeldas2 = document.getElementById("contenido").getElementsByTagName("td").item(i).innerHTML;
		document.getElementById("contenido").getElementsByTagName("td").item(i).innerHTML = cCeldas2+"<img class=\"rell\">";
	}
}


function desplaza(){
	pasoH = document.getElementById("contenedor").scrollLeft;
	pasoV = document.getElementById("contenedor").scrollTop;
	document.getElementById("contEncCol").scrollLeft = pasoH;
//	document.getElementById("contEncFil").scrollTop = pasoV;
}

function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=16&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=14&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }

		 function printPageJI(){

		 	var a = document.getElementById("getAno");
		 	var strAno = a.options[a.selectedIndex].value;

		 	var g = document.getElementById("getGrade");
			var strGrade = g.options[g.selectedIndex].value;

			var m = document.getElementById("getMonth");
			var strMonth = m.options[m.selectedIndex].value;

		 	window.open("justifica_inasistenciaPrint.php?mes="+strMonth+"&curso="+strGrade+"&ano="+strAno);
		 }



function detalleJus(campo){

	var ano = <?php echo $ano ?>;
	var mes = $("#getMonth").val();
	
   var parametros="funcion=1&ano="+ano+"&r="+campo+"&m="+mes;
  	$.ajax({
	   url:'justifica_inasistencia/cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#ingco" ).html(data);
		$("#ingco" ).dialog(
		 {
			  open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide();
			   },
			   position: { my: 'top', at: 'top+150' },
			  closeOnEscape: false,
			  resizable: true,
			  height: "auto",
			  width: 800,
			  modal: true,
			  buttons: {
				  "Guardar": function() {
				  guardaHistoria();
				// parent.location.reload();
				},
				"Cerrar": function() {
				  $( this ).dialog( "close" );
				// parent.location.reload();
				}
			  }
    }
		 );
		 
		 
		
		  }
	  })
}

function IngresoTipo(){
var funcion=2;
var parametros = "funcion="+funcion;
	$.ajax({
	   url:'justifica_inasistencia/cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#nt" ).html(data);
		$("#nt" ).dialog(
		 {
			  open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			  position: { my: 'top', at: 'top+150' },
			  closeOnEscape: false,
			  resizable: true,
			  height: "auto",
			  width: 280,
			  modal: true,
			  buttons: {
				  "Guardar": function() {
				  //$( this ).dialog( "close" );
				// parent.location.reload();
				guardaTipo();
				 
				},
				"Cerrar": function() {
				  $( this ).dialog( "close" );
				// parent.location.reload();
				}
			  }
    }
		 );
		 
		 
		
		  }
	  })
}	
function guardaTipo(){
var funcion=3;
var rbd=<?php echo $_INSTIT; ?>;
var nombre = $("#txt_nombre").val();
var parametros = "funcion="+funcion+"&rbd="+rbd+"&nombre="+nombre;
if(nombre==""){
alert("Ingrese datos");
}
else{
$.ajax({
	  url:'justifica_inasistencia/cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $("#nt").dialog( "close" );
		tipoinas();
	   
		  }
	  })
}
}
function tipoinas(){
var funcion=4;
var rbd=<?php echo $_INSTIT; ?>;
var parametros = "funcion="+funcion+"&rbd="+rbd;
$.ajax({
	  url:'justifica_inasistencia/cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	  // console.log(data);
	   $("#tipoinas").html(data);
		  }
	  })
}

function guardaHistoria(){
var funcion=5;
var fdesde = $("#fecha_desde").val();
var fhasta = $("#fecha_hasta").val();
var tipo = $("#tipo_jistifica").val();
var detalle = $("#descripcion").val();
var rut = $("#rut_alumno").val();
var curso = $("#getGrade").val();
var fd = new FormData();
var formData = new FormData();
var files = document.getElementById('archivo').files[0];
  fd.append('archivo', files);
  fd.append('funcion', funcion);
  
  if(fdesde=="" || fhasta =="" || tipo==0 || detalle==""){
	 alert("Debe completar campos"); 
	 return false;
	 }
	 else{
	 fd.append('archivo', files);
  	 fd.append('funcion', funcion);
	 fd.append('fdesde', fdesde);
	 fd.append('fhasta', fhasta);
	 fd.append('tipo', tipo);
	 fd.append('detalle', detalle);
	 fd.append('rut', rut);
	 fd.append('curso', curso);
  
	$.ajax({
	   url: 'justifica_inasistencia/cont_justifica.php',
	   data: fd,
	   type: 'POST',
	   contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
		processData: false, // NEEDED, DON'T OMIT THIS
		success: function (data) {
		arcHisto();
		}
	
	});
}
}
function quitaHistoria(id){
var funcion=6;
var parametros = "funcion="+funcion+"&id="+id;
if(confirm("Seguro de eliminar registro?")){

$.ajax({
	  url:'justifica_inasistencia/cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	  
	   arcHisto();
		  }
	  })
 }
}
function arcHisto(){
var funcion=7;
var rut = $("#rut_alumno").val();
var curso = $("#getGrade").val();
var mes = $("#getMonth").val();
var ano =<?php echo $_ANO ?>;

var parametros = "funcion="+funcion+"&rut="+rut+"&curso="+curso+"&mes="+mes+"&ano="+ano;
$.ajax({
	  url:'justifica_inasistencia/cont_justifica.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data);
	 
	   $("#hisj").html(data);
		  }
	  })
}
</script>
<!--
<style>
table{border-collapse:collapse}
table td{font:12px monospace; border:0px solid; text-align:center; height:1.5em}
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; width:40em}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em}
#contenedor{overflow:auto; width:40em; height:20em}
#contenido{}
.tabla td{border:1px solid; width:2em}
.rell{width:2em; height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red}
</style>
-->
<LINK REL="STYLESHEET" HREF="../../../../util/td.css" TYPE="text/css">
<style>
.tachado {
    text-decoration: line-through;
}
</style>
<style>
.td_temp{font:12px monospace; border:3px solid; text-align:center; height:1.5em; vertical-align:top}
.td_temp2{font:12px monospace; border:0px solid; text-align:center; height:1.5em; vertical-align:top }
#contEncCol{overflow:hidden; overflow-y:scroll; background:#99CCFF; vertical-align:top}
#encCol{}
#contEncFil{overflow:hidden; overflow-x:scroll; background:#FFFFFF; height:20em; vertical-align:top}
#contenedor{overflow:auto; height:20em; vertical-align:top; vertical-align:top}
#contenido{}
.tabla td{border:1px solid;  vertical-align:top}
.rell{ height:0; position:relative; top:-1em; z-index:0; bor der:1px solid red; vertical-align:top}
</style>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<!--
<style type="text/css">
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
</style>
-->
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53"  align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <table width="100%">
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="1%" height="363" align="left" valign="top">
					  <table>
					  <tr> 
					  <td>&nbsp;
						</td>
						</tr>
						</table>
					  </td>
					
                      <td width="85%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 
						  <table><tr><td  valign="top" width="1%">
						 <?  $menu_lateral="3_1";?> <? include("../../../../../menus/menu_lateral.php"); ?>
						 </td>
						 <td valign="top" width="100%"  class="cajaborde">
						  <!--- AQUI ENPIEMZA-->
						 <!-- inicio codigo nuevo -->
								  
								  				  
								  
								   
<!--<body onload=iniciar()>-->

<?php /*if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="30" align="center" valign="top"> 
      <? include("../../../../../cabecera/menu_inferior.php"); ?> </td>
  </tr>
</table>
<?php } */?>


<?php //echo tope("../../../../../util/");?>


	  	<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1  width="90%">
          <TR> 
            <TD valign="top"> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> </div></TD>
            <TD valign="top"> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </FONT> </div></TD>
            <TD valign="top"> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong> 
              <?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					} ?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>" id="getModo">

						<select name="cmb_ano" class="ddlb_x" id="getAno" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un A&ntilde;o)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
				<? }	?>
              </form>          </TR>
          <TR>
            <TD><div align="left"><font size="2" face="Arial, Helvetica, sans-serif"><strong>CURSO
              </strong></font></div></TD>
            <TD><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">:</font></strong></div></TD>
            <TD><div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">
		    <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
//echo $sql_curso;
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" id="getGrade" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
		  
		        if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
		           echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select>
						  

			&nbsp;</font></strong></div></TD></form>
          </TR>
        </TABLE>
		
<?
if (($curso != 0) or ($curso != NULL)){ ?>		
<form name="form1" method="post" action="procesojustifica.php?">
        <input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
		<input type="hidden" name="ensenanza" value="<?=$filan['ensenanza']; ?>">
        <table  width="740" cellpadding="5" cellspacing="5" align="center" border="0">
          <tr> 
            <td height="20"><div align="right">
              <?php if (($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
              <input class="botonXX"  type="submit" name="Button" value="GUARDAR">
              <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="seteaAsistencia.php3?caso=11&mes=<?=$cmbMes?>"> 
                <?php } ?>
                <?php 
				
				if ($frmModo=="mostrar") {
			  			if($_PERFIL!=20) {
						       
							   
							   if($situacion_ano==0){
									 // NO SE MUESTRA EL BOTON MODIFICAR YA QUE AÑO ESTA CERRADO 
								}else{
								      if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==516)){ 
			                               // no muestro
			                          }else{									  
									      if (($_PERFIL!=2) and ($_PERFIL!=20) ){										  
										      ?>
									          <input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAsistencia.php3?caso=10&mes=<?php echo $cmbMes ?>">

									          <input class="botonXX"  type="button" name="ButtonPrint" value="IMPRIMIR" onClick="printPageJI()">
								       <? }
								   
								      } ?>	  
									  
									
									<?
									 if (($_PERFIL == 19) || ($_PERFIL == 0) || ($_PERFIL == 14) || ($_PERFIL!=2) || ($_PERFIL!=20)){ ?>
									    <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../curso.php3">
								  <? } ?>		
									      
									  <?
								}?>								
								
									  
									  
              		            <? } ?>
                             <?php } ?>
              </div></td>
          </tr>
</table>
        <table width="740" border="0" align="center">
        <!--  <tr> 
            <td width="48"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Feriado:</font></strong></td>
            <td width="21" bgcolor="#FFE6E6">&nbsp;</td>
            <td width="33">&nbsp;</td>
            <td width="47"><strong><font size="1" face="Arial, Helvetica, sans-serif">Fin 
              de Semana:</font></strong></td>
            <td width="21" bgcolor="#EAEAEA">&nbsp;</td>
			<td width="33">&nbsp;</td>
            <td width="33"><strong><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Actua:</font></strong></td>
            <td width="21" bgcolor="#FFFFD7">&nbsp;</td>
			<td width="33">&nbsp;</td>
            <td width="57" ><font size="1" face="Arial, Helvetica, sans-serif">D&iacute;a 
              Inasistencia:</font></td>
            <td width="21" bgcolor="#E1EFFF" ><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;</font></td>
			<td width="33">&nbsp;</td>
            <td width="58" ><font size="1" face="Arial, Helvetica, sans-serif">Inasistencias del Mes:</font></td>
            <td width="114"><font size="1" face="Arial, Helvetica, sans-serif">&nbsp;I.M.</font></td>           
          </tr>
	-->
        </table>
<!--<div class="cajamenu2" align="center">NOTA: Al justificar un alumno, se descuenta autom&aacute;ticamente un d&iacute;a de asistencia</div><br>-->
        <table width="740" border="0" cellpadding="1" cellspacing="1" align="center">
          <tr> 
            <td width="17%" height="20" align="left" class="tableindex">JUSTIFICAR INASISTENCIA &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <select name="cmbMes" id="getMonth" onChange="enviapag3(this.form);">
			   <option value="0" selected>Selecciones Mes</option>
			    <?php 
				if($cmbMes==""){
				$fecha=getdate();
				$cmbMes=$fecha["mon"];
				}
				if ($cmbMes=="01"){
               		 echo "<option value=01 selected>ENERO</option>";
				 }else	 
					echo "<option value=01>ENERO</option>";
				 if ($cmbMes=="02"){
               	 	echo "<option value=02 selected>FEBRERO</option>";
				  }else 
					echo "<option value=02>FEBRERO</option>";
				 if ($cmbMes=="03"){
                echo "	<option value=03 selected>MARZO</option>";
				 }else 
					echo "<option value=03>MARZO</option>";
				 if ($cmbMes=="04"){
                	echo "<option value=04 selected>ABRIL</option>";
				 }else 
					echo "<option value=04>ABRIL</option>";
				 if ($cmbMes=="05"){
                	echo "<option value=05 selected>MAYO</option>";
				 }else
					echo "<option value=05>MAYO</option>";
				 if ($cmbMes=="06"){
               		echo "<option value=06 selected>JUNIO</option>";
				 }else
					echo "<option value=06>JUNIO</option>";
				
				 if ($cmbMes=="07"){
                echo "	<option value=07 selected>JULIO</option>";
				 }else
					echo "<option value=07>JULIO</option>";
				 if ($cmbMes=="08"){
                echo "	<option value=08 selected>AGOSTO</option>";
				 }else
					echo "<option value=08>AGOSTO</option>";
				 if ($cmbMes=="09"){
                	echo "<option value=09 selected>SEPTIEMBRE</option>";
				 }else
					echo "<option value=09>SEPTIEMBRE</option>";
				 if ($cmbMes=="10"){
                	echo "<option value=10 selected>OCTUBRE</option>";
				 }else
					echo "<option value=10>OCTUBRE</option>";
				 if ($cmbMes=="11"){
                echo "<option value=11 selected>NOVIEMBRE</option>";
				 }else
					echo "<option value=11>NOVIEMBRE</option>";
				 if ($cmbMes=="12"){
                echo "<option value=12 selected>DICIEMBRE</option>";
				 }else	echo "<option value=12>DICIEMBRE</option>";
				 ?>
              </select>             </td>
          </tr>
</table>

<br>
<?
				if ($cmbMes!=""){
					//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
					if(($cmbMes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
					}else{
						 $diaFinal=28;
					}
					if($cmbMes==1){ 
						$diaFinal=31; 
						$mes="01";
					}
					if($cmbMes==2){ 
						$mes="02";
					}
					if($cmbMes==3){ 
						$diaFinal=31; 
						$mes="03";
					}
					if($cmbMes==4){ 
						$diaFinal=30; 
						$mes="04";
					}
					if($cmbMes==5){ 
						$diaFinal=31; 
						$mes="05";
					}
					if($cmbMes==6){ 
						$diaFinal=30; 
						$mes="06";
					}
					if($cmbMes==7){ 
						$diaFinal=31; 
						$mes="07";
					}
					if($cmbMes==8){ 
						$diaFinal=31; 
						$mes="08";
					}
					if($cmbMes==9){ 
						$diaFinal=30; 
						$mes="09";
					}
					if($cmbMes==10){ 
						$diaFinal=31; 
						$mes="10";
					}
					if($cmbMes==11){ 
						$diaFinal=30; 
						$mes="11";
					}
					if($cmbMes==12){ 
						$diaFinal=31; 
						$mes="12";
					}
					//FIN AJUSTA
				}
    //Nombres de todos los alumnos				
	$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND ((matricula.bool_ar=0)or(matricula.bool_ar isnull))) ";
	$qry = $qry . "ORDER BY ape_pat,ape_mat,nombre_alu asc";
	$res_alu = pg_Exec($conn, $qry);
	$tot_alum = pg_numrows($res_alu);
//Inasistencias por alumno
	$qry_ano = "select * from ANO_ESCOLAR where id_ano = '$_ANO'";
	$res_ano = pg_Exec($conn, $qry_ano);
	$fila_ano = pg_fetch_array($res_ano);
	$fila_ano['nro_ano'];
	
	$_CURSO;	
	
	$fecha_ini = $fila_ano['nro_ano']."-".$mes."-"."01";
	$fecha_fin = $fila_ano['nro_ano']."-".$mes."-".$diaFinal;
			
?>
<center>
<? if($frmModo == "mostrar"){?>
<table><tr><td class="textosesion"><img src="vb.gif"> JUSTIFICADOS</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="textosesion" valign="top"><img src="b_drop.png"> NO JUSTIFICADOS</td><td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td class="tabla03" align="center" width="30">N&deg;</td><td class="textosesion">DIA DE LA INASISTENCIA</td></tr></table>
<? } ?>
<table border="1" width="95%">
<?  $msj = false;

  

	for($xa=0; $xa < $tot_alum; $xa++){
		$alumnos = pg_fetch_array($res_alu);
		$rut_alumno = $alumnos['rut_alumno'];
		
		$stjus ="SELECT * FROM justifica_inasistencia 
WHERE rut_alumno = '$rut_alumno' 
AND ano = '$ano' AND id_curso = '$curso' AND date_part('month',fecha)='$mes'";
	    $rtjus = pg_exec($conn,$stjus);
		 

		$qry2 = "SELECT * FROM asistencia WHERE id_curso = $_CURSO AND rut_alumno = '$rut_alumno' AND ano = '$ano' AND fecha >= '$fecha_ini' AND fecha <= '$fecha_fin' ORDER BY rut_alumno";
		$res2 = @pg_Exec($qry2);		
		if(@pg_numrows($res2)!=0){
		$msj = true; ?>
			<tr <?php if(pg_numrows($rtjus)>0){?>onmouseover="this.style.background='yellow';this.style.cursor='hand'" onmouseout="this.style.background='transparent'" <?php }?>>			
				<td class="textosesion" width="280" <?php if(pg_numrows($rtjus)>0){?>onClick="detalleJus(<?=$rut_alumno?>)" style="cursor:pointer"<?php }?>><?=trim($alumnos['ape_pat'])." ".trim($alumnos['ape_mat']).", ".trim($alumnos['nombre_alu'])?> <?=$rut_alumno ?></td>
<?			for($z=0;$z<pg_numrows($res2);$z++){
				$fila_inasistencia = pg_fetch_array($res2,$z);
				$fech_inasist = $fila_inasistencia['fecha'];
				$separa = explode("-",$fech_inasist);

				$qry3 = "SELECT * FROM justifica_inasistencia WHERE rut_alumno = '$rut_alumno' AND ano = '$ano' AND id_curso = '$curso' AND fecha = '$fech_inasist'";
				$res3 = pg_Exec($qry3);
				 pg_numrows($res3);
				
				if($frmModo=="mostrar"){?>
					<td class="tabla03" align="center" width="40"><?=$separa[2]?><br>
						<? if(pg_numrows($res3)==0){?>
							<img src="b_drop.png">
						<? }else{?>
							<img src="vb.gif" >
						<? }?>						
					</td>
<?				}
				if($frmModo=="ingresar"){?>
					<td class="tabla03" align="center" width="40"><?=$separa[2]?><br>
						<? if(pg_numrows($res3)==0){?>
							<input type="checkbox" name="<?=$rut_alumno."_".$separa[2]?>">
						<? }else{?>
							<input type="checkbox"  checked="checked" name="<?=$rut_alumno."_".$separa[2]?>" >
						<? }?>										
					</td>					
		<? 		}
			} ?>
			</tr>
<?		}
	}	?>		
</table>

<?	} ?>
</center>
</form>
<center>
<? if($msj==false){?>
<br><br><br><br>
	<DIV  class="cajamenu2">NO SE REGISTRAN INASISTENCIAS</DIV>
<? } ?>
</center>
							  
						 <!--AQUI TERMINA -->						 </td>
						 
						 </tr></table>
						  </td>
                            <td height="395" align="left" valign="top"> 
                     
						    </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
			    </td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
	  </td>
  </tr>
</table>
</td></tr></table>
<div id="ingco"></div>
<div id="nt" title="Tipo Justificación"></div>
</body>
</html>
