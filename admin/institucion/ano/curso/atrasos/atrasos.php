<?php 	require('../../../../../util/header.inc');
 //$tabla = ($_PERFIL==0)?"anotacion_new":"anotacion";
$tabla = ($_PERFIL==0)?"anotacion":"anotacion";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>
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
	 "m-".$menu;
	 "c-".$categoria;
	 "i-".$item;
	 "n-".$nw;
	
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$empleado		=$_EMPLEADO;
	$_POSP          =5;
	$_bot           =5;
	$codbarra =$_CODBARRA;
	//print_r($_GET);
	
	if(!isset($_GET['_JORNADA'])){
		 /*$Jornada=$_JORNADA;*/
		 $Jornada=1;
	}else{
		 $Jornada =	$_GET['_JORNADA'];
	}
	//echo $Jornada;
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//AND curso.ensenanza=".pg_result($rs_acceso,3)."
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso="  AND id_curso in(";
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
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=19)){$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=1) &&($_PERFIL!=19)&&($_PERFIL!=29)&&($_PERFIL!=32)&&($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=35)&&($_PERFIL!=6)&&($_PERFIL!=28)&&($_PERFIL!=30)&&($_PERFIL!=31)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
if($frmModo=="")
{
$frmModo = "mostrar";
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
				
				
//revisar periodos
	$qry_rp="select * from periodo where id_ano=$ano and (fecha_inicio is null or fecha_termino is null)";
	$result =@pg_Exec($conn,$qry_rp);
	if(pg_num_rows($result)>0)
	{$err = 1;}
	else {$err=0;}
	
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die("Select Fallo: ".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
?>
	
    				

<SCRIPT language="JavaScript">

function enviapag3(form){
			if (form.cmbMes.value!=0){
				form.cmbMes.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'atrasos.php';
				form.submit(true);
	
				}	
			}
			
//periodos
function compPeriodo(){
var cont = <?php echo $err ?>;
//alert (cont);
if(cont>0){
	alert ("Faltan datos de periodo para configurar.\nSerá redirigido a la configuración de periodo para solucionar el problema");
	location.href="../../periodo/listarPeriodo.php3";
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
	var contenedor = document.getElementById("jornada");
		if(contenedor != null)	{
	 for(i=0; i <document.form1.jornada.length; i++){
        if(document.form1.jornada[i].checked){
            Jornada = document.form1.jornada[i].value;
		}
	 }
}else{Jornada=1}

		    var frmModo="<?=$frmModo?>"; 
			var curso2=form.cmb_curso.value;
			//var Jornada=1;
			//alert(Jornada);
			
			var menu="<?=$menu;?>";
			var categoria="<?=$categoria;?>";
			var item = "<?=$item?>";
			var nw ="<?=$nw;?>";
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=15&curso="+curso2+"&frmModo="+frmModo+"&Jornada="+Jornada+"&menu="+menu+"&categoria="+categoria+"&item="+item+"&nw="+nw;
				form.action = pag;
				form.submit(true);	
				//form1.submit(true);
			}		
		 }
		 
		 function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=13&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }


function otra_jornada(x,y){
	
	//alert(x);
	//alert(y);
	            pag="atrasos.php?_JORNADA="+x+"&cmbMes="+y
				//alert(pag);
				document.forms['form'].action = pag;
				document.forms['form'].submit(true);	
	}
	
	function detallea(){
	 $( "#marcatraso" ).dialog({
        modal: true,
        height: 300,
        width: 400
    });
	}
	
	
function asisCOD(d){
var curso = $("#cmb_curso").val();
var ano = $("#cmb_ano").val();
var mes = $("#cmbMes").val();
var jornada =(!$('input[name=jornada]:checked').val())?1:$('input[name=jornada]:checked').val(); 
var funcion =1;

if(!$('input[name=jornada]').is(":checked")){
alert("Debe marcar jornada de atraso");
return false;
}

var parametros = "funcion="+funcion+"&curso="+curso+"&ano="+ano+"&mes="+mes+"&jornada="+jornada+"&d="+d;


 var parametros="funcion=1&curso="+curso+"&ano="+ano+"&mes="+mes+"&d="+d;
  	$.ajax({
	   url:'codbarra/codbarra.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $("#ingco" ).html(data);
		$("#ingco" ).dialog(
		 {
			    open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			  closeOnEscape: false,
			  resizable: true,
			  height: "auto",
			  width: 800,
			  modal: true,
			  buttons: {
				"Cerrar": function() {
				  $( this ).dialog( "close" );
				 parent.location.reload();
				}
			  }
    }
		 );
		 $("#irut_alumno" ).focus();
		 
		
		  }
	  })
	  

}

function guardInas(){
var funcion=2;
var fecha = $("#ifecha" ).val();
var rut = $("#irut_alumno" ).val();
var curso = $("#icurso" ).val();
var ano  = $("#iano" ).val();
var jornada  = $("#jornada" ).val();
var parametros = "funcion="+funcion+"&rut="+rut+"&curso="+curso+"&fecha="+fecha+"&ano="+ano+"&jornada="+jornada;

		$.ajax({
				url:"codbarra/codbarra.php",
				data:parametros,
				type:'POST',
				success:function(data){
				$("#dalu" ).html(data);
				$("#irut_alumno" ).val("");
				$("#irut_alumno" ).focus();
									
		  }
		});

}

function atrasoCODAll(){
	var ano = <?php echo $_ANO ?>;
	var jornada =(!$('input[name=jornada]:checked').val())?1:$('input[name=jornada]:checked').val(); 
	
   var parametros="funcion=3&ano="+ano+"&jornada="+jornada;
  	$.ajax({
	   url:'codbarra/codbarra.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#ingco" ).html(data);
		$("#ingco" ).dialog(
		 {
			  open: function(event, ui) { $(".ui-dialog-titlebar-close", ui.dialog).hide(); },
			  closeOnEscape: false,
			  resizable: true,
			  height: "auto",
			  width: 800,
			  modal: true,
			  buttons: {
				"Cerrar": function() {
				  $( this ).dialog( "close" );
				 parent.location.reload();
				}
			  }
    }
		 );
		 $("#irut_alumno" ).focus();
		 
		
		  }
	  })
}

function guardAtrasoAll(){
var funcion=4;
var fecha = $("#ifecha" ).val();
var rut = $("#irut_alumno" ).val();
var ano  = $("#iano" ).val();
var jornada  = $("#jornada" ).val();
var parametros = "funcion="+funcion+"&rut="+rut+"&fecha="+fecha+"&ano="+ano+"&jornada="+jornada;

		$.ajax({
				url:"codbarra/codbarra.php",
				data:parametros,
				type:'POST',
				success:function(data){
				$("#dalu" ).html(data);
				$("#irut_alumno" ).val("");
				$("#irut_alumno" ).focus();
									
		  }
		});

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

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="compPeriodo();MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
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
					
                      <td width="100%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top" colspan="50"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
                          </tr>
                          <tr> 
						  <td> 
						 
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


	  	<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1  width="100%">
          <TR> 
            <TD valign="top"> <div align="left"><FONT face="arial, geneva, helvetica" size=2> <strong>AÑO 
              ESCOLAR</strong> </FONT> </div></TD>
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
			 <form name="form" id="form"  action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">

						<select name="cmb_ano" class="ddlb_x" id="cmb_ano" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);++$i){
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
              </form>
          </TR>
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
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" id="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i)
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
//if (($curso != 0) or ($curso != NULL)){
	
	
//$ruta = ($institucion!=24756)?"procesoAtrasos":"procesoAtrasosP";	
$ruta = "procesoAtrasos";	
	
	 ?>		
<form name="form1" id="form1" method="post" action="procesoAtrasos.php?">
        <input type="hidden" name="cmbMes2" value="<? echo $cmbMes; ?>" >
		<input type="hidden" name="ensenanza" value="<?=$filan['ensenanza']; ?>">
        
        <table  width="100%" cellpadding="5" cellspacing="5" align="center" border="0">
          <tr> 
            <td height="20"><div align="right">
           <? if($codbarra==16){?>	  
<input type="button" value="INGRESO POR CODIGO DE BARRAS" class="botonXX" onClick="atrasoCODAll()">&nbsp;&nbsp;
<? } ?>
               <input class="botonXX"  type="button" name="Button" value="DETALLE" onClick="location.href='motivo_atraso/motivo.php'" >
              &nbsp;&nbsp;
             
              <input class="botonXX"  type="button" name="Button" value="JUSTIFICAR" onClick="location.href='justifica_atrasos/justifica.php'" >
              &nbsp;&nbsp;
              <?php if (($frmModo=="ingresar") OR ($frmModo=="modificar")){?>
              
              <input class="botonXX"  type="submit" name="Button" value="GUARDAR">
              <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="seteaAtrasos.php?caso=2"> 
              <?php } ?>
              <?php if ($frmModo=="mostrar") {
			  			if(($_PERFIL!=20)&&($_PERFIL!=1)) {
							   if($fila1106['situacion']==0){//CERRADO NO MOSTRAR LOS BOTONES INGRESAR
				                      if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==24977)){ 
			                               // no muestro
			                          }else{	  
			                                if (($_PERFIL!=2) and ($_PERFIL!=20)){ ?>
				                               <input class="botonXX"  type="button" name="Button2" value="MODIFICAR"> 
								         <? }  
								      }  ?>
									  <?
								}else{
								      if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==516)){ 
			                               // no muestro
			                          }else{									  
									      if (($_PERFIL!=2) and ($_PERFIL!=20)){
										      ?>
									          <input class="botonXX"  type="button" name="Button2" value="MODIFICAR" onClick=window.location="seteaAtrasos.php?caso=1&mes=<?php echo $cmbMes ?>">
								       <? }
								      } 
									// if (($_PERFIL == 19) AND ($_PERFIL == 0) AND ($_PERFIL == 14)){ ?>
									    <input class="botonXX" type="button" name="botton3" value="VOLVER" onClick=window.location="../alumno/listarAlumnos.php3?menu=6&categoria=3&item=2&nw=1#?menu=<?=$menu?>&categoria=<?=$categoria?>&item=<?=$item?>&nw=<?=$nw?>">
								  <? //} ?>		
								  <? }?>								
              		            <? } ?>
                             <?php } ?>
              </div></td>
          </tr>
</table>
        <table width="100%" border="0" align="center">
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
<br>
        <table width="100%" border="0" cellpadding="1" cellspacing="1" align="center">
          <tr> 
            <td width="25%" height="26" align="left" class="tableindex">ATRASOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
              <select name="cmbMes" id="cmbMes" onChange="enviapag3(this.form);">
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
				 if ($cmbMes=="3"){
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
              </select>
             </td>
         
         <td width="75%" height="26" align="left" class="tableindex">
          JORNADA:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          
          <? if($Jornada==1){?>
          Mañana&nbsp;<input type="radio" name="jornada" id="jornada" value="1" checked>
          <? }else{?>
         Mañana&nbsp; <input type="radio" name="jornada" id="jornada" value="1" onClick="otra_jornada(this.value,<?=$cmbMes;?>)">
          <? }
		  if($Jornada==2){?>
          Tarde&nbsp;<input type="radio" name="jornada" id="jornada" value="2" checked>
          <? }else{?>
         Tarde&nbsp; <input type="radio" name="jornada" id="jornada" value="2" onClick="otra_jornada(this.value,<?=$cmbMes;?>)">
          <? }?>
          </td>
             </tr>
</table>

<br>
<? 

//----------------feriados para esconder botones
 $sql_fercur ="select * from feriado_curso where id_curso=".$_CURSO;
 $rs_fercur = pg_exec($conn,$sql_fercur);
 //ver los feriados del curso 
if(pg_numrows($rs_fercur)==0){ 
										 
 $sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
}
else{
	 $sqlFer="select feriado.id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado inner join feriado_curso on feriado_curso.id_feriado=feriado.id_feriado where date_part('month',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano."  and id_curso =".$curso." order by dia_ini";	 
	 }
	


$resultFer=@pg_Exec($conn,$sqlFer);
if (!$resultFer) {
	error('<B> ERROR :</b>Error al acceder a la BD. (77)</B>'.$sqlFer);
}
 $m=0;
 $ñ=0;
 $cDias=$diaFinal;
 
 for($df=0;$df<pg_numrows($resultFer);$df++){
	$filaFer=@pg_fetch_array($resultFer,$df);
	
	 $inic  = $filaFer['dia_ini'];
	 $finc  = $filaFer['dia_fin'];
	 
	 for($c=$parte;$c<=$diaFinal;$c++){
	 $ard[$c][]=($c>= $inic && $c<=$finc)?1:0;		
	 }
	 
}
//tengo que limpiar el arreglo para sacar los ceros si el dia es feriado
 for($c=$parte;$c<=$diaFinal;$c++){
	 $ard[$c]=max($ard[$c]);		
 }
 
// show($ard);
//----------------fin feriados para esconder botones



 
//Nombres de los alumnos				
	$qry = " SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.nro_lista ";
	$qry = $qry . " FROM (alumno INNER JOIN matricula ON alumno.rut_alumno = matricula.rut_alumno) ";
	$qry = $qry . " WHERE ((matricula.id_curso=".$curso.") AND matricula.rdb='".$institucion."' AND ((matricula.bool_ar=0)or(matricula.bool_ar is null))) ";
	$qry = $qry . "ORDER BY matricula.nro_lista asc, ape_pat,ape_mat,nombre_alu asc";
	//if ($_INSTIT==769){
	     
	/*}else{
	     $qry = $qry . "ORDER BY ape_pat,ape_mat,nombre_alu asc";	
	//}*/
	
	/*echo $qry;
	exit;*/
	
	$res = pg_Exec($conn,$qry);
	
?>
<center>



		   <?php

						$sqlFer="select id_feriado, date_part('day', feriado.fecha_inicio) AS dia_ini, date_part('month',feriado.fecha_inicio) AS mes_ini, date_part('year',feriado.fecha_inicio) AS ano_ini, date_part('day', feriado.fecha_fin) AS dia_fin, date_part('month',feriado.fecha_fin) AS mes_fin, date_part('year',feriado.fecha_fin) AS ano_fin from feriado where date_part('mon',feriado.fecha_inicio)=".$cmbMes." and id_ano=".$ano." order by dia_ini";
						$resultFer=@pg_Exec($conn,$sqlFer);
						if (!$resultFer) {
							error('<B> ERROR :</b>Error al acceder a la BD. (76)</B>'.$sqlFer);
						}


				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila1 = @pg_fetch_array($result,0);	
						if (!$fila1){
							error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
							exit();
						}
						$nroAno=trim($fila1['nro_ano']);
					}
				}
	
				if ($cmbMes!=""){
					//AJUSTA NRO DEL ULTIMO DIA SEGUN EL MES
					if(($cmbMes==2) and ($nroAno%4==0)){
						 $diaFinal=29;
						 $mes="02"; 
					}else{
						 $diaFinal=28;
						 $mes="02";
						 
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
	?>
				
	<input type="hidden" name="diaFinal" value="<?=$diaFinal?>">
	
	<!--<div id="contenedor" onscroll="desplaza()" style="width:900px">-->
		<table width="1020" bordercolor="#666666" id="contenido" border="1">		
        <tr>
								<td width="200">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<?							for($count=1 ; $count<=$diaFinal ; $count++){
	
	
	 $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno)));		
 

					
					$colof="#FFFFFF";
					if($dia==0 || $dia ==6){
						$colof="#E2E2E2";
					}
					if($ard[$count]==1){
					$colof="#FFE6E6";
					}
						 if($diaFinal==29 || $diaFinal==28){
		
									if ($count<10){ ?>
										<TD width="24" align="center" >
                                       <?php  echo $ard[$count];?>
                                        <img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG> 0<? echo $count; ?> </STRONG></FONT>
                                          
                                          </TD>
                                        <?									}else{  ?>
										<TD width="155" align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>&nbsp;<? echo $count; ?></STRONG></FONT>
                                          
                                          </TD>
                                        <?									}
								}
								else{
									if ($count<10){
										
										//echo $ard[$count];
										 $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno))); ?>
										<TD width="174" align="center"  ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										   <?php if(($dia!=0 && $dia !=6) && $ard[$count]==0 && $codbarra==16){?><input type="button" value="<?php echo ($count<10)?"0".$count:$count ?>" onclick="asisCOD(this.value)" class="botonXX">  <?php } else{ ?>
         <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>0<? echo $count; ?></STRONG></FONT>
                                           <? } //fin quitar boton fin de semana?>				
                                          </TD>
                                        <?									}else{  $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno)));
										//echo 
										$colof="#FFFFFF";
					if($dia==0 || $dia ==6){
						$colof="#E2E2E2";
					}
					if($ard[$count]==1){
					$colof="#FFE6E6";
					}
					//$ard[$count];
										
										?>
										<TD width="155" align="center"  ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
										  
                                          <?php if(($dia!=0 && $dia !=6) && $ard[$count]==0 && $codbarra==16){?>
                                          <input type="button" value="<?php echo ($count<10)?"0".$count:$count ?>" onclick="asisCOD(this.value)" class="botonXX">   <?php } else{?>
   <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG><? echo $count; ?></STRONG></FONT>
                                          <?
										}//fin quitar boton fin de semana?>				
                                          </TD>
                                        <?									}
								}
							} // fin for $count
					//}	 fin if
					 if($cmbMes!=""){?>
						<TD width="158" align="center" ><img src="../../../../../cortes/p.gif" width="20" height="1"><br>
					  <FONT face="arial, geneva, helvetica" size=1 color=#000000><STRONG>A.M.</STRONG></FONT></TD>
						<? } ?>	
						</tr>
       
<?	
				
 					$ultima_fetch = $nroAno=trim($fila1['nro_ano'])."-".$mes."-".$diaFinal;	
					$primera_fech = $nroAno=trim($fila1['nro_ano'])."-".$mes."-"."01";
							
				for($i=0;$i<@pg_numrows($res);++$i)	
				{
					$fila = pg_fetch_array($res,$i);	
					 $qry_atraso = "select fecha, id_anotacion from  $tabla where rut_alumno = '$fila[rut_alumno]' and tipo = 2 and fecha >= '$primera_fech' and fecha <= '$ultima_fetch' and jornada=".$Jornada;
					 //if($_PERFIL==0){echo $qry_atraso."<br>";}
					
					$res_atraso = @pg_Exec($conn,$qry_atraso);	
					$num_anota = @pg_numrows($res_atraso);
					
					?>					
					<tr >
				 <td valign="top" width="200" class="textosesion">
				 <?=$fila['ape_pat']." ".$fila['ape_mat']."<br>".$fila['nombre_alu'];?>
                 </td>						
					<?	for($count=1 ; $count<=$diaFinal ; $count++){			
					 $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno)));
					
					$colof="#FFFFFF";
					if($dia==0 || $dia ==6){
						$colof="#E2E2E2";
					}
					if($ard[$count]==1){
					$colof="#FFE6E6";
					}
								 										
						if($diaFinal==29 || $diaFinal==28){
							
							 $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno)));
					
					$colof="#FFFFFF";
					if($dia==0 || $dia ==6){
						$colof="#E2E2E2";
					}
					if($ard[$count]==1){
					$colof="#FFE6E6";
					}
							
							if ($count<10){
								
								 ?>	
							    <TD align="center" bgcolor="<?php echo $colof ?>"><div >								
								<?		$continua = true;									
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);										
										$cont="0".$count;										
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){ //de l hasta final de mes y estan activados?>
												<input type="checkbox" checked="checked" disabled="disabled" title="<?=$count;?>">
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>">
										<?	}										 
										}
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 10 hasta final de mes y estan desactivados ?>
								<input type="checkbox" disabled="disabled" title="<?=$count;?>">
										<? }
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>">												                                                			
										<?	}										 
										}?>											
								</td>
									<?	}else{
										 $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno)));
					
					$colof="#FFFFFF";
					$stat="";
					if($dia==0 || $dia ==6){
						$colof="#E2E2E2";
						$stat="disabled";
					}
					if($ard[$count]==1){
					$colof="#FFE6E6";
					$stat="disabled";
					}
										
										  ?> 
								<TD align="center" bgcolor="<?php echo $colof ?>">
							<?			$continua = true;									
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);						
									 	$cont = $count;
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){ //de 1 hasta final de mes y estan activados?>
												<input type="checkbox" checked="checked" disabled="disabled" title="<?=$count;?>">
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>">
                                                
										<?	}										 
										}
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 10 hasta final de mes y estan desactivados
											 ?>
											<input type="checkbox" disabled="disabled" title="<?=$count;?>">
										<? }
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>">
                                                	
										<?	}										 
										}?>											 
								</TD>
								<?	}
							}else{
									if($count<10){
										


										 $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno)));
					
					$colof="#FFFFFF";
					$stat="";
					if($dia==0 || $dia ==6){
						$colof="#E2E2E2";
						$stat="disabled";
					}
					if($ard[$count]==1){
					$colof="#FFE6E6";
					$stat="disabled";
					}
					
								
										 ?>
								<TD align="center" bgcolor="<?php echo $colof ?>" <?php echo $stat ?>>	
                               <?php //echo  $ard[$count] ?>
								<?		$continua = true;																	
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);										
										$cont="0".$count;										
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){  //del 01 al 09 y estan activados?>
												<font  class="textonegrita">A</font> 
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>" <?php echo $stat; ?>>
										<?	}
										} 
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 01 al 09 y estan desactivados	?>
										<input type="checkbox" disabled="disabled" title="<?=$count;?>">
										<? 	}
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>" <?php echo $stat; ?>>
										<?	}										 
										}?></TD>
									<? 	}else{
										
					 $dia = (date("w", mktime(0,0,0,$cmbMes,$count,$nroAno)));
					
					$colof="#FFFFFF";
					$stat="";
					if($dia==0 || $dia ==6){
						$colof="#E2E2E2";
						$stat="disabled";
					}
					if($ard[$count]==1){
					$colof="#FFE6E6";
					$stat="disabled";
					}
									 	 ?>																
								<TD align="center" bgcolor="<?php echo $colof ?>">
                                <?php //echo $ard[$count] ?>
							<?			$continua = true;									
									for($x=0;$x<=$num_anota;$x++){
										$fila_atraso = @pg_fetch_array($res_atraso,$x);					
										$fech_compa = substr($fila_atraso['fecha'],8,2);						
									 	$cont = $count;
										if($fech_compa==$cont){	
											$continua = false;
											if($frmModo==mostrar){ //del hasta final de mes y estan activados?>
												<font  class="textonegrita">A</font>
										<?	}
											if($frmModo==ingresar){?>
												<input type="checkbox" checked="checked" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>" <?php echo $stat; ?>>
										<?	}										 
										}
										}
										if($continua==true){ 
											if($frmModo==mostrar){ //del 10 hasta final de mes y estan desactivados ?>
									<input type="checkbox" disabled="disabled" title="<?=$count;?>">
										<? }
											if($frmModo==ingresar){?>
												<input type="checkbox" name="alu_<?=$i?>_<?=$count?>" title="<?=$count;?>" <?php echo $stat; ?>>
                                                
                                               
										<?	}										 
										}?></TD>
									<?  } 
								}
							} 
							?>			
						<td align="center" class="textonegrita"><?=$num_anota?></td>
						</tr>
			<?	}	?>
					<tr>
						<? if($cmbMes!=""){ ?>
						<td width="200">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>						
						<td colspan="<?=$diaFinal?>">&nbsp;</td>
						<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
						<? } ?>
					</tr>											
		</table>
	<!--</div>-->
</form>

				
					  
								  
								  
						 <!--AQUI TERMINA -->
						 
						 
						 </td>
						 
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
<div id="ingco" title="Ingresar atraso por código de barras"></div>
<?
pg_close($conn);
pg_close($connection);
?>
</body>
</html>
