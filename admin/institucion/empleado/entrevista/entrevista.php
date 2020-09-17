<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP           =4;
	$ano	=$_ANO;
	

	$sql="";
	$sql ="SELECT * FROM cargo";
	$Rs_Cargo =@pg_exec($conn,$sql);
	
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
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" src="../../../util/chkform.js"></script>
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../clases/jqueryui/jquery.ui.datepicker.js"></script>

<script>
$( document ).ready(function() {
    cargaAno(<?php echo $institucion ?>);
	cargaDocente(<?php echo $institucion ?>);
});

function cargaAno(rdb){
var funcion=1;
var parametros = "funcion="+funcion+"&rdb="+rdb;
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  $("#ano").html(data);
			 
		  } 
	  })
}

function cargaDocente(rdb){
var funcion=2;
var parametros = "funcion="+funcion+"&rdb="+rdb;
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  $("#entrevistado").html(data);
			 
		  } 
	  })
}

function buscarEntrevista(){
var funcion=3;
var ano  =  $("#cmbAno").val();
var rut =  $("#cmbEntrevistado").val();
var parametros = "funcion="+funcion+"&ano="+ano+"&rut="+rut;
if(ano==0 || rut ==0){
	alert("Seleccione Año y entrevistado")
}else{
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
		  $("#listaEntre").html(data);
			 
		  } 
	  })
}
} 

function agrega(){
var funcion=4;
var ano  =  $("#cmbAno").val();
var rut =  $("#cmbEntrevistado").val();
var rdb = <?php echo $institucion ?>;
var parametros = "funcion="+funcion+"&ano="+ano+"&rut="+rut+"&rdb="+rdb;

$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	
		  $("#listaEntre").html(data);
			 
		  } 
	  })

} 

function cancela(){
	if(confirm("¿Seguro desea cancelar?")){
	buscarEntrevista();
	}
}

function guardaNuevo(){
var funcion=5;
var ano  =  $("#cmbAno").val();
var entrevistado =  $("#cmbEntrevistado").val();
var entrevistador =  $("#cmbEntrevistador").val();
var fecha =  $("#fecha").val();
var observaciones =  $("#observaciones").val();
var acuerdos =  $("#acuerdos").val();
var compromisos =  $("#compromisos").val();
var asunto =  $("#cmbAsunto").val();

if(entrevistador==0){
alert("Seleccione Entrevistador")
}
else if(asunto==0){
alert("Seleccione Asunto")
}
else if(fecha==""){
alert("Seleccione Fecha")
}
else if(observaciones==""){
alert("Ingrese Observaciones")
}
else{
	
	var parametros = "funcion="+funcion+"&id_ano="+ano+"&entrevistado="+entrevistado+"&entrevistador="+entrevistador+"&fecha="+fecha+"&observaciones="+observaciones+"&asunto="+asunto+"&acuerdos="+acuerdos+"&compromisos="+compromisos;
	$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	
	
		  if(data==0){
			 alert("Error al guadar");
			 }else{
			alert("Datos Guardados");
			buscarEntrevista();	 
			}
			
			 
		  } 
	  })
}
}


function agregaAsunto(){
var funcion=6;
var parametros = "funcion="+funcion;
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	
	//console.log(data);
		 $("#asun").html(data);
		$("#asun").dialog({ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
   Width: 400,
   Height: 300,
   minWidth: 400,
   minHeight: 300,
   maxWidth: 400,
   maxHeight: 300,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		
	 "Guardar Datos": function(){
		 if($('#nom_asunto').val()==""){
			alert("Escriba asunto");
			$('#nom_asunto').focus();
			return false;
		}
		   ingresar_Asunto();
		   cargaAsunto();
		  
		   $(this).dialog("close");
	     } ,
	 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }) 	
			 
		  } 
	  })
}

function ingresar_Asunto(){
var funcion=7;
var rdb=<?php echo $institucion ?>;
var txt= $('#nom_asunto').val();
var parametros = "funcion="+funcion+"&rdb="+rdb+"&txt="+txt;
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  if(data==0){
			 alert("Error al guadar");
			 }else{
			alert("Datos Guardados");	 
			}
	
	//console.log(data);
		  //$("#listaEntre").html(data);
			
			 
		  } 
	  })
}

function cargaAsunto(){
var funcion=8;
var rdb=<?php echo $institucion ?>;
var parametros = "funcion="+funcion+"&rdb="+rdb;
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		$("#asunto").html(data);
			
			 
		  } 
	  })
}

function traeEntrevista(id){
var funcion=9;
var rdb=<?php echo $institucion ?>;
var parametros = "funcion="+funcion+"&id="+id+"&rdb="+rdb;
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  $("#listaEntre").html(data);
			
			 
		  } 
	  })

}



function guardaEdita(){
var funcion=10;
var id_entrevista = $("#id_entrevista").val();
var ano  =  $("#cmbAno").val();
var entrevistado =  $("#cmbEntrevistado").val();
var entrevistador =  $("#cmbEntrevistador").val();
var fecha =  $("#fecha").val();
var observaciones =  $("#observaciones").val();
var acuerdos =  $("#acuerdos").val();
var compromisos =  $("#compromisos").val();
var asunto =  $("#cmbAsunto").val();

if(entrevistador==0){
alert("Seleccione Entrevistador")
}
else if(asunto==0){
alert("Seleccione Asunto")
}
else if(fecha==""){
alert("Seleccione Fecha")
}
else if(observaciones==""){
alert("Ingrese Observaciones")
}
else{
	
	var parametros = "funcion="+funcion+"&id_ano="+ano+"&entrevistado="+entrevistado+"&entrevistador="+entrevistador+"&fecha="+fecha+"&observaciones="+observaciones+"&asunto="+asunto+"&id_entrevista="+id_entrevista+"&acuerdos="+acuerdos+"&compromisos="+compromisos;
	$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	console.log(data);
	
		  if(data==0){
			 alert("Error al guadar");
			 }else{
			alert("Datos Guardados");
			buscarEntrevista();	 
			}
			
			 
		  } 
	  })
}
}




function elimina(id){
var funcion=11;
var parametros = "funcion="+funcion+"&id="+id;
if(confirm("¿Seguro desea eliminar?")){
$.ajax({
	  url:'cont_entrevista.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 if(data==0){
			 alert("Error al guadar");
			 }else{
			alert("Datos Eliminados");	
			buscarEntrevista();	 
			}
			
			 
		  } 
	  })
}
}
</script>
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//-->


//-->>






</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../Sea/cortes/b_ayuda_r.jpg','../../../../Sea/cortes/b_info_r.jpg','../../../../Sea/cortes/b_mapa_r.jpg','../../../../Sea/cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
		  <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> <? include("../../../../cabecera/menu_superior.php"); ?></td>
        </tr>
        <tr align="left" valign="top"> 
          <td height="83" colspan="3">
		  		<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
					  <?  $menu_lateral="6";?><? include("../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top">
					  	<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><!-- inicio codigo antiguo -->
								  
								  
	<center>
		<table WIDTH="100%" BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=15>
				<TD width="382">
					<TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1>
						<TR>
							<TD align=left>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>INSTITUCION</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
									<? if ($_PERFIL==15 or $_PERFIL==16) {?>
										<script language="javascript">
											 alert ("No Autorizado");
											 window.location="../../../index.php";
										 </script>
										 <? } ?>
										<?php
											$qry="SELECT * FROM INSTITUCION WHERE RDB=".$institucion;
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
											}else{
												if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
														exit();
													}
												}
												echo trim($fila1['nombre_instit']);
											}
										?>
									</strong>								</FONT>							</TD>
						</TR>
					</TABLE>				</TD>
			</TR>
			<tr>
				<td align=center width="100%">&nbsp;</td>
			</tr>
			<tr height="20" class="tableindex">
				<td align="middle">ENTREVISTA DOCENTE POR JEFATURA</td>
			</tr>
		<tr><td>&nbsp;</td></tr>
        <tr>
          <td>
          <form id="frm" name="frm">
          <input type="hidden" name="x">
          <table width="100%" border="0" cellspacing="0">
            <tr>
              <td width="21%" class="textonegrita">A&Ntilde;O</td>
              <td width="79%"><div id="ano">
                <select name="cmbAno" id="cmbAno">
                 <option value="0">seleccione...</option>
                </select>
              </div></td>
            </tr>
            <tr>
              <td class="textonegrita">ENTREVISTADO</td>
              <td><div id="entrevistado">
                <select name="cmbEntrevistado" id="cmbEntrevistado">
                  <option value="0">seleccione...</option>
                </select>
              </div></td>
            </tr>
          </table>
          </form>
          <br>
<br>
<br>
<div id="listaEntre"></div>
<div id="asun"></div>
</td></tr>
			<tr>
				<td>
				<hr width="100%" color="#0099cc">				</td>
			</tr>
		</table>
	</center>

								  
								  <!-- fin codigo antiguo --></td>
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
</body>
</html>
