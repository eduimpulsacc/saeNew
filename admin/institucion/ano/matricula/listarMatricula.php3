

<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 

</script>

<?
require('../../../../util/header.inc');
//include ("../calendario/calendario.php");


	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	 $ano			=$_ANO;
	$_POSP = 4;
	$_bot = 6;
	
	$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '".$_ANO."'";
	$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
	$fil_ano_actual = @pg_fetch_array($res_ano_actual,0);
	$nro_ano = $fil_ano_actual['nro_actual'];
		
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	
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
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=". 
		$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 00px;
}
-->
</style><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">



<script type="text/javascript" src="../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.core.js"></script>



<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function valida_ingreso(){
	if((document.frm1.BUSCARX[0].checked)&&(document.frm1.filtroRUT.value=="")){
		alert("Debe ingresar Rut");
		return;
	}
	if((document.frm1.BUSCARX[1].checked)&&(document.frm1.Apellido.value=="")){
		alert("Debe ingresar Apellido");
		return;
	}
	document.frm1.submit();
}
//-->


//-->>
function elimina_matricula(xrut,xinstitucion,xano,xcurso){ 
		
	if(!confirm('¿Desea Eliminar Este Registro?'))
       { 
	     return false; 
	   }
	else
	   {	
	   
	     var parametros = "xrut="+xrut+"&xinstitucion="+xinstitucion+"&xano="+xano+"&xcurso="+xcurso;
	     
		 //alert(parametros);
		 
		  	$.ajax({
		 		  url:'elimina_matricula.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
		 			      if (data==1){ 
					        alert("Se ha eliminado El Registro"); 
					       // window.location = 'listarMatricula.php3';
							window.location.reload();
					      } 
		 			  } 
		 		  })
	   }
	   
} // FIN FUNCION  


function ingreso_curso(x,y,j)
{
	
	var cargando ='<br><h5>Espere Por Favor Procesando...</h5><br>';
    cargando = cargando+'<img src="../../../clases/img_jquery/ajax-loader.gif"><br><br><br><br><br><br><br>'; 
   $("#dialog_ing_curso").html(cargando);
	
	 var funcion = 1;
	 var parametros = "rut="+x+"&institucion="+y+"&ano="+j+"&funcion="+funcion;
	 
	    $.ajax({
	  url:'ingresa_curso.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	    //alert(data);
		$("#dialog_ing_curso").html(data);
		
			   $("#dialog_ing_curso").dialog({
				  modal: true,
				  text: '',
				  width: 550,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
		
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
        {
            text: "Guardar",
            "class": 'saveButtonClass',
            click: function() {
               actualiza_matricula(x,y,j);
            }
        }],
   
			   });
		  }
	  });   
	 
}


function actualiza_matricula(x,y,j)
{
	var id_curso = $('#cmb_curso').val();
	 var funcion = 2;
	 var nro_ano="<?=$fil_ano_actual[0]?>";
	 var parametros = "rut="+x+"&institucion="+y+"&ano="+j+"&id_curso="+id_curso+"&nro_ano="+nro_ano+"&funcion="+funcion;
	//alert(parametros);
	    $.ajax({
	  url:'ingresa_curso.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	   // alert(data);
		if(data==1){
			alert("Alumno Asignado a Nuevo Curso");
			location.reload();
		$('#dialog_ing_curso').dialog("close");
		
		}else{
			alert("tudo benne ");
			
		}
		  }
	  });   
	
}
function cambiofecha(){
	var funcion=1;
	var ano =<?php echo $ano ?>;
	var parametros="funcion="+funcion+"&ano="+ano;
	$.ajax({
	  url:'cambioMAT/cambioMAT.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	    //alert(data);
		$("#dialog_fmat").html(data);
		
			   $("#dialog_fmat").dialog({
				  modal: true,
				  text: '',
				  width: 550,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
		
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
        {
            text: "Guardar",
            "class": 'saveButtonClass',
            click: function() {
               guardaFechaNew();
            }
        }],
   
			   });
		  }
	  });   
}
function guardaFechaNew(){
var funcion=2;
var fmay=$("#selfecha").val();
var ano = <?php echo $ano ?>;
var parametros = "funcion="+funcion+"&ano="+ano+"&fmay="+fmay;
$.ajax({
			 url:'cambioMAT/cambioMAT.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 
					  if (data==1){ 
						alert("Se han actualizado los registros"); 
					   // window.location = 'listarMatricula.php3';
						//window.location.reload();
					  } 
				  } 
			  })

}
function cambionumero(){
	var funcion=3;
	var ano =<?php echo $ano ?>;
	var parametros="funcion="+funcion+"&ano="+ano;
	$.ajax({
	  url:'cambioMAT/cambioMAT.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	    //alert(data);
		$("#dialog_fmat").html(data);
		
			   $("#dialog_fmat").dialog({
				  modal: true,
				  text: '',
				  width: 550,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
		
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
        {
            text: "Guardar",
            "class": 'saveButtonClass',
            click: function() {
               guardaNumeroNew();
            }
        }],
   
			   });
		  }
	  });   
}
function guardaNumeroNew(){
var funcion=4;
var ord=$("#selOrden").val();
var ano = <?php echo $ano ?>;
var parametros = "funcion="+funcion+"&ano="+ano+"&ord="+ord;
if(ord>0){
$.ajax({
			 url:'cambioMAT/cambioMAT.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				// console.log(data);
					 // if (data==1){ 
						alert("Se han actualizado los registros"); 
					   // window.location = 'listarMatricula.php3';
						//window.location.reload();
					  //} 
				  } 
			  })
}
	else{
		alert("Seleccioar tipo de ordenamiento");
	}
}
 function cambiolista(){

var funcion=5;
var ano = <?php echo $ano ?>;
var parametros = "funcion="+funcion+"&ano="+ano;
$.ajax({
			 url:'cambioMAT/cambioMAT.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				
					  
						alert("Se han actualizado los registros"); 
					   // window.location = 'listarMatricula.php3';
						//window.location.reload();
					  
				  } 
			  })

	
}
function datoApo(){
var funcion=6;
var ano = <?php echo $ano ?>;
var parametros = "funcion="+funcion+"&ano="+ano;
$.ajax({
			 url:'cambioMAT/cambioMAT.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				
					 
						alert("Se han actualizado los registros"); 
					   // window.location = 'listarMatricula.php3';
						//window.location.reload();
					  
				  } 
			  })

}

function fechaCur(){

	var funcion=7;
	var ano =<?php echo $ano ?>;
	var parametros="funcion="+funcion+"&ano="+ano;
	$.ajax({
	  url:'cambioMAT/cambioMAT.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	    //alert(data);
		$("#dialog_fmat").html(data);
		
			   $("#dialog_fmat").dialog({
				  modal: true,
				  text: '',
				  width: 550,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
		
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
        {
            text: "Guardar",
            "class": 'saveButtonClass',
            click: function() {
               guardaFechaNewC();
			    $(this).dialog("close");
			  
            }
        }],
   
			   });
		  }
	  });   

}

function guardaFechaNewC(){
var funcion=8;
var ano = <?php echo $ano ?>;
var fecha_inicio = $("#finicio").val();
var fecha_fin = $("#ffin").val();
var searchID = [];
$("input.curso[type=checkbox]:checked").map(function(){
    searchID.push($(this).val());
  });

var cursos = searchID;
if(cursos.length>0){
var parametros = "funcion="+funcion+"&ano="+ano+"&cursos="+cursos+"&fecha_inicio="+fecha_inicio+"&fecha_fin="+fecha_fin;
$.ajax({
			 url:'cambioMAT/cambioMAT.php',
			  data:parametros,
			  type:'POST',
			  success:function(data){
				 
				 alert("Se han actualizado los registros");
				 
					  
				  } 
			  })
}else{
	alert("No seleccionaron cursos");
	}

}

        
</script>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						 $menu_lateral=3; 
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
						</td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
								  <br>
								  <!-- AQUÍ INSERTAMOS EL NUEVO CÓDIGO -->
								  
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../index.php";
		 </script>

<? } ?>								  
								  
								
			<? if($modo=="ini"){ ?>
				<form method="post" name="frm1" action="listarMatricula.php3?sw_lista=1">
				  <center>
				</center>
				</form>
			<? }else{?>
				<form method="post" name="frm1" action="listarMatricula.php3?sw_lista=1">
					<center>
					<table  border="0" cellpadding="0" cellspacing="0" width=600>
						<tr>
							<td align="left">
								<table align=center width="100%">
									<tr valign=bottom>
										<td>
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK>&nbsp;											</FONT><br>								      </td>
										<td align="left" valign="top">
										<input class="botonXX"  type="submit" name="submit2" value="LISTAR">										</td>
										<td align="left" valign="middle">
										<input name="BUSCARX" type="radio" value="1" onClick="LayerRut.style.visibility='visible'; LayerApe.style.visibility='hidden'">
										  <FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>BUSCAR POR RUT </strong></FONT><br>
									    <input name="BUSCARX" type="radio" value="2" onClick="LayerRut.style.visibility='hidden'; LayerApe.style.visibility='visible'">
									    <FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>BUSCAR POR APELLIDO </strong></FONT></td>
										<!------------------/filtro por RBD/-------------->
										<td>
										<div id="LayerRut" style="visibility:hidden ">
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK>
											<strong>INGRESE RUT(sin verificador)<br></strong>											</FONT>
											<input type="text" name="filtroRUT"  size="12" >
											<input type="hidden" name="swrbd"  value=1 size="12" >	
									    </div>
										<div id="LayerApe" style="visibility:hidden ">
											<FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>INGRESE APELLIDO<br>
											<input name="Apellido" type="text"  size="20" maxlength="40" >
											</strong></FONT>									    </div>									   </td>
											<td><FONT face="arial, geneva, helvetica" size=1 color=BLACK><strong>										    </strong></FONT></td>
											<td align="right" valign="top">
												<div align="left">
												<input class="botonXX"  type="button" name="submit2" value="BUSCAR" onClick="valida_ingreso()"></div>											</td>
									<!------------------/find filtro por RBD/-------------->
									</tr>
									<tr valign=bottom>
									  <td>&nbsp;</td>
									  <td align="left" valign="top">&nbsp;</td>
									  <td align="left" valign="middle">&nbsp;</td>
									  <td>&nbsp;</td>
									  <td>&nbsp;</td>
									  <td align="right" valign="top">&nbsp;
									   </td>
									  </tr>
								</table>
							</td>
						</tr>
						<tr>
							<td align="center" colspan="2">
								<table>
									<tr>
	<td><a HREF="listarMatricula.php3?pag=1&listar=A&sw_lista=1"><strong><h4>A</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=B&sw_lista=1"><strong><h4>B</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=C&sw_lista=1"><strong><h4>C</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=D&sw_lista=1"><strong><h4>D</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=E&sw_lista=1"><strong><h4>E</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=F&sw_lista=1"><strong><h4>F</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=G&sw_lista=1"><strong><h4>G</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=H&sw_lista=1"><strong><h4>H</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=I&sw_lista=1"><strong><h4>I</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=J&sw_lista=1"><strong><h4>J</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=K&sw_lista=1"><strong><h4>K</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=L&sw_lista=1"><strong><h4>L</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=LL&sw_lista=1"><strong><h4>LL</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=M&sw_lista=1"><strong><h4>M</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=N&sw_lista=1"><strong><h4>N</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=Ñ&sw_lista=1"><strong><h4>Ñ</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=O&sw_lista=1"><strong><h4>O</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=P&sw_lista=1"><strong><h4>P</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=Q&sw_lista=1"><strong><h4>Q</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=R&sw_lista=1"><strong><h4>R</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=S&sw_lista=1"><strong><h4>S</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=T&sw_lista=1"><strong><h4>T</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=U&sw_lista=1"><strong><h4>U</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=V&sw_lista=1"><strong><h4>V</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=W&sw_lista=1"><strong><h4>W</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=X&sw_lista=1"><strong><h4>X</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=Y&sw_lista=1"><strong><h4>Y</h4></strong></a></td>
	<td><a HREF="listarMatricula.php3?pag=1&listar=Z&sw_lista=1"><strong><h4>Z</h4></strong></a></td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					</center>
				</form>
				
<?

// Evitamos la inyeccion SQL 

// Modificamos las variables pasadas por URL 
foreach( $_GET as $variable => $valor ){ 
$_GET [ $variable ] = str_replace ( "'" , "'" , $_GET [ $variable ]); 
} 
// Modificamos las variables de formularios 
foreach( $_POST as $variable => $valor ){ 
$_POST [ $variable ] = str_replace ( "'" , "'" , $_POST [ $variable ]); 
} 



	$filRUT=(trim($swrbd)=='1')?$filtroRUT:"";
	

	if ($filRUT!=''){
		if ($BUSCARX==1){
								
			$qry = "SELECT matricula$nro_ano.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula$nro_ano.id_curso, matricula$nro_ano.bool_ar  FROM MATRICULA$nro_ano, ALUMNO WHERE matricula$nro_ano.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula$nro_ano.rut_alumno = alumno.rut_alumno  ORDER BY alumno.ape_pat, alumno.ape_mat ";
			//				$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso, ALUMNO WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matriculatpsincurso.rut_alumno = alumno.rut_alumno";		
						}
} else { 
		if ($BUSCARX==2){	
		
			$qry = "SELECT matricula$nro_ano.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula$nro_ano.id_curso, matricula$nro_ano.bool_ar FROM MATRICULA$nro_ano INNER JOIN ALUMNO ON alumno.rut_alumno = matricula$nro_ano.rut_alumno WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%') and matricula.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			//$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON alumno.rut_alumno = matriculatpsincurso.rut_alumno WHERE (lower(alumno.ape_pat) LIKE '%".strtolower($Apellido)."%')and matriculatpsincurso.id_ano = ".$ano." and matricula$nro_ano.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
		}
	 }
	 
	 
	 //------
	if ($BUSCARX==0){	 
		if ($filRUT!=''){
		  
			$qry = "SELECT matricula$nro_ano.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula$nro_ano.id_curso, matricula$nro_ano.bool_ar  FROM MATRICULA$nro_ano INNER JOIN ALUMNO ON matricula$nro_ano.rut_alumno=alumno.rut_alumno WHERE matricula$nro_ano.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula$nro_ano.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
		 //	$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON matriculatpsincurso.rut_alumno=alumno.rut_alumno WHERE matriculatpsincurso.rut_alumno =".$filtroRUT." and id_ano =".$ano." and matricula$nro_ano.rdb= ".$institucion;		
		 } else {
		    
		$qry = "SELECT matricula.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu, matricula$nro_ano.id_curso, matricula.bool_ar FROM MATRICULA INNER JOIN ALUMNO ON alumno.rut_alumno = matricula.rut_alumno WHERE   (upper (alumno.ape_pat) like'$listar%') and matricula.id_ano = ".$ano." and matricula.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";
			//$qry2 = "SELECT DISTINCT matriculatpsincurso.rut_alumno, alumno.dig_rut,  alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu FROM matriculatpsincurso INNER JOIN ALUMNO ON alumno.rut_alumno = matriculatpsincurso.rut_alumno WHERE (upper (alumno.ape_pat)  like '$listar%') and matriculatpsincurso.id_ano = ".$ano." and matricula$nro_ano.rdb= ".$institucion." ORDER BY alumno.ape_pat, alumno.ape_mat ";		

		 }	 
	}
	if($sw=="")
	{
		$sw_lista=1;
	}
	if ($sw_lista==1){
		

		$result  =@pg_Exec($conn,$qry);
		$result3 =@pg_Exec($conn,$qry2);
	?>
	<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=670 align=center>
		<tr>
			<td colspan=5>
				<table width="100%" cellpadding="0" cellspacing="0" >
					<tr>
					  <td align="left">                       
<? if($ingreso==1 ){ //ACADEMICO Y LEGAL?>
					<?php if ($situacion==0){?>
					<input class= "botonXX" type="button" value="AGREGAR" onClick=document.location="nueva_ficha3.php">
                    <?php  } ?>
					<? 
					if ($situacion!=0 || $_PERFIL==0){
						
					if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR?>
					<? if($institucion==24511){?><INPUT class="botonXX"  TYPE="button" value="POSTULACION" onClick=document.location="SaintAngela/ListadoPostulantes.php?ano_escolar2<? echo $ano_escolar2?>"><? }?>
<?php 
	//veo si es de valpo o no
	//echo "link=$link<br>";
	//if($institucion==11209){
?>
<input class= "botonXX" type="button" value="AGREGAR" onClick=document.location="nueva_ficha3.php">

<? //}else{?>
<!--<input name="button"  type="button" class="botonXX" onclick=document.location="seteaMatricula.php3?caso=2" value="AGREGAR" />-->
<? // } ?>
						<? if($_PERFIL==0){?>
<input class="botonXX" type="button" name="notas" value="NOTA INICIAL" id="notas" onClick="window.location='notas_iniciales/notas_iniciales.php'">   
                  
<input name="mat_inicial"  type="button" class="botonXX" onclick=document.location="matriculaINI/matricula_inicial.php" value="MATRICULA INICIAL" />

<input name="subir_prom"  type="button" class="botonXX" onclick=document.location="subir_promocion/subir_promocion_2.php" value="SUBIR PROMOCI&Oacute;N" />
 <?
					if($_PERFIL==0){?>
                   
					<INPUT class="botonXX"  TYPE="button" value="INSCRIBIR RAMOS" onClick=document.location="inscribirRamo.php">
                    <INPUT class="botonXX"  TYPE="button" value="COMPLETAR DATOS" onClick=document.location="completarDatos.php">
                    <INPUT class="botonXX"  TYPE="button" value="FECHA MATRICULA" onClick="cambiofecha()">
                    <INPUT class="botonXX"  TYPE="button" value="NÚMERO MATRICULA" onClick="cambionumero()">
                     <INPUT class="botonXX"  TYPE="button" value="NÚMERO LISTA" onClick="cambiolista()">
                      <INPUT class="botonXX"  TYPE="button" value="DATOS APODERADO" onClick="datoApo()">
                       <INPUT class="botonXX"  TYPE="button" value="FECHAS CURSOS" onClick="fechaCur()">
                     
                    
					<? } ?>
						<? } 
					}?>
                    
                    <? if($institucion==4655 or $institucion==19921 or $institucion==12086 or $institucion==11209){?>
						<!--<input class= "botonXX" type="button" value="NUEVA FICHA" onClick=document.location="nueva_ficha2.php">-->
					<? }?>
						
<input class= "botonXX" type="button" value="IMPRIMIR" onClick="javascript:window.open('print_matricula.php3', '', 'width=900, height=600, scrollbars=YES')">
						<? }?>
                    <? }?>
                    
					<? 
					if ($situacion==0){
					if(($institucion==15707)) {?>
<input name="button"  type="button" class="botonXX" onclick=document.location="nueva_ficha2.php" value="AGREGAR" />
					<?php }
					}?>
                    
					<?
					if($_PERFIL!=20){?>
					<INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick=document.location="listarMatricula.php3">
                     </td> 
					<? } ?>
                   <br>

				  </tr>
					<tr>
						<td align=center>
							<H1><? echo trim($listar)?></H1></td>
					</tr>
				</table>			</td>
		</tr>
		<tr height="20">
			<td align="center" colspan="5" class="tableindex">
				MATRICULA <? echo @pg_numrows($result)+@pg_numrows($resul3)?> ALUMNOS			</td>
		</tr>
		<tr bgcolor="#48d1cc">
			<td ALIGN=CENTER class="tablatit2-1">
				RUT			</td>
			<td ALIGN=CENTER class="tablatit2-1">
				NOMBRE ALUMNO </td>
			<td ALIGN=CENTER class="tablatit2-1">
				CURSO</font></td>
			<td ALIGN=CENTER valign="top" class="tablatit2-1"><img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/icono_papelera.png" width="19" height="21"></td>
			<td ALIGN=CENTER class="tablatit2-1">&nbsp;</td>
		</tr>
		<?

for($i=0 ; $i < @pg_numrows($result) ; ++$i){
	$fila = @pg_fetch_array($result,$i);
		
	
if ($fila['bool_ar'] == 1){
	
	$tachado = "tachado";
						    ?>

<tr title="Alumno Retirado"
onmouseover=this.style.background='yellow';this.style.cursor='hand' 
onmouseout=this.style.background='transparent'>
		                     					
							<?
					    }else{
						     $tachado = "";
						     ?>

<tr bgcolor=#ffffff 
onmouseover=this.style.background='yellow' 
onmouseout=this.style.background='transparent' >
		                     
							 <?
					     } ?>	  

<td align="left" class="<?=$textosimple ?>" ><!---->
<font face="arial, geneva, helvetica" size="1" color="#000000">
<strong>
<? echo $fila["rut_alumno"]."-".$fila["dig_rut"];?>
</strong>
</font>
</td>

<td align="left" class="<?=$tachado ?>" ><!---->

<font face="arial, geneva, helvetica" size="1" color="#000000">
<strong>
<? echo ucwords(strtolower(trim($fila["ape_pat"]." ".$fila["ape_mat"]." ".$fila["nombre_alu"])));?>
</strong></font>
			  
<font face="arial, geneva, helvetica" size="1" color="#000000">
<strong></strong></font>

<font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;</font>		    
<font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;</font>		  

</td>
		  
<td align="left" class="<?=$tachado ?>"><!-- -->
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>
				  <?
				  $Curso_pal = CursoPalabra($fila["id_curso"], 0, $conn);
				  if (empty($Curso_pal))
				  	$Curso_pal = "Sin Curso";
   			  	  $Curso_pal = trim(ucwords($Curso_pal));
				  echo $Curso_pal;
				  
				  ?>
	</strong>
	</font>
</td>
			
<td id="" style="cursor:pointer" title="Elimina el Alumno" onClick="elimina_matricula(<? echo $fila["rut_alumno"].",".$institucion.",".$ano.",".$fila['id_curso']; ?>)" 
align="center">
<? if($_PERFIL!=26 && $_PERFIL!=44){?>
<img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/cruz_ELIMINA2.png" width="18" height="18" border="0" />
<? } ?>
</td>

<?	 
	if($fila['id_curso']==0 || $fila['id_curso']==NULL){
?>
	  <td align="center" style="cursor:pointer" title="Agregar Curso" onClick="ingreso_curso(<? echo $fila["rut_alumno"].",".$institucion.",".$ano;?>)">
      <? if($_PERFIL!=26 && $_PERFIL!=44){?>
      <img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/Add.png" width="18" height="18" border="0" />
      <? } ?>
        </td>
        <?
	}
		?>
			
			
			</tr>
		<? }?>
		<?
			for($i=0 ; $i < @pg_numrows($result3) ; ++$i){
				$fila = @pg_fetch_array($result3,$i);
		?>

		<tr bgcolor=#ffffff onmouseover=this.style.background='yellow';this.style.cursor='hand';this.style.cursor='pointer'  onmouseout=this.style.background='transparent' ><!--onClick=go('seteaMatriculaTP.php3?alumno=<?php echo trim($fila["rut_alumno"]);?>&caso=1')-->
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><? echo $fila["rut_alumno"]."-".$fila["dig_rut"];?></strong>			  </font>		  </td>
		  <td align="left" >
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong><? echo ucwords(strtolower(trim($fila["ape_pat"]." ".$fila["ape_mat"]." ".$fila["nombre_alu"])));?></strong>			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">
				  <strong>  				  </strong>			  </font>
			  <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;</font>		    <font face="arial, geneva, helvetica" size="1" color="#000000">&nbsp;
  			  </font>		  </td>
		  <td align="left">			  <font face="arial, geneva, helvetica" size="1" color="#000000">
			  <strong>
				  SIN CURSO			  </strong>
		  </font>		  </td>


<td id="" onClick="elimina_matricula(<? echo $fila["rut_alumno"].",".$institucion.",".$ano.",".$fila['id_curso']; ?>)" 
align="center">
<img src="../../../clases/img_jquery/iconos/Web-Application-Icons-Set/PNG-48/cruz_ELIMINA2.png" width="18" height="18" border="0" />
</td>


</tr>
		<? }?>		
		<tr>
			<td colspan="5">
			<hr width="100%" color="#003b85">			</td>
		</tr>
	</table>
	<? }?>
	<? }?>
<? 
	
if ($sw_lista==1){
 $query_mat="select count(rut_alumno) as mat from matricula where matricula.rdb='$institucion' and matricula.id_ano='$ano' and matricula.bool_ar=0";
 


  $filsMatriculados=pg_fetch_array(pg_exec($conn,$query_mat));
  $query_ret="select count(rut_alumno) as ret from matricula where matricula.rdb='$institucion' and matricula.id_ano='$ano' and matricula.bool_ar=1";
  $filsRetirados=pg_fetch_array(pg_exec($conn,$query_ret));
  
   
?>
<table border="0" cellpadding="1" cellspacing="1" bgcolor="white" WIDTH=650 align=center>
<TR>
	<TD WIDTH="70%"> <font face="arial, geneva, helvetica" size="1">Total Alumnos Matriculados</font></TD>
	<TD> <font face="arial, geneva, helvetica" size="1" color="#000000" title="Alumnos en Matricula"><? echo $filsMatriculados['mat'];?></font></TD>
</TR>
<TR>
	<TD WIDTH="30%"> <font face="arial, geneva, helvetica" size="1">Total Alumnos Retirados</font></TD>
	<TD> <font face="arial, geneva, helvetica" size="1" color="#000000" title="Alumnos Retirados"><? echo $filsRetirados['ret'];?></font></TD>
</TR>
</TABLE>
<? } ?>


     <!-- FIN DEL NUEVO CÓDIGO -->
	 
	 
								  
								  
								  
								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</tr>
</tr>
<div id="dialog_ing_curso"></div>
<div id="dialog_fmat"></div>

</body>
</html>
<? pg_close($conn);?>