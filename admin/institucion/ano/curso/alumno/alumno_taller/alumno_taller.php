<?php
	
 require_once('../../../../../../util/header.inc');

	//print_r($_GET);
	$institucion	=$_INSTIT;
//	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
    $alumno			=$_ALUMNO;
	$id_curso 		=$_CURSO;
	$_POSP = 4;
	$_bot = 6;
	if($Modo==1)
	{
	//	$frmModo = "mostrar";
	}
	
	
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
			$_ITEM =$item;
			session_register('_ITEM');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
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

<style type="text/css">
	div.ui-datepicker{
	font-size:12px;
	}
	textarea:focus, input[type=password]:focus, input[type=text]:focus, select :focus{
	border: 1px solid #79b7e7; background: #fff;
	outline: none; box-shadow: 0 1px 4px #c5c5a2;
	-webkit-box-shadow: 0 1px 4px #c5c5a2;
	-moz-box-shadow: 0 1px 4px #c5c5a2; }
	
</style>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.widget.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.core.js"></script>
<script type="text/javascript" src="valida_rut_simple.js"></script>
<script type="text/javascript" src="formatea_rut.js"></script>
<script language="javascript">
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

 $(document).ready(function() {

 carga_taller()	 
	 
 });
 
 function carga_taller()
 {
	var rdb = "<?=$institucion?>";
	var id_ano = "<?=$ano?>";
	var rut_alumno = "<?=$alumno?>";
	var funcion = 1;
	
	
	
	
	 var parametros = 'funcion='+funcion+'&rdb='+rdb+'&id_ano='+id_ano+'&rut_alumno='+rut_alumno;
	 
	  $.ajax({
	  url:'cont_alumno_taller.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data)
	    $("#modulodatos").html(data);
	   }
	 })
 }
 
 function incribe_taller(id_taller,nombre_chk)
 {
	 if($("#"+nombre_chk+"").is(':checked'))
	 {
	  var funcion=2;
	   var mensaje="Desea Agregar al Taller"
	   var mensaje2="Inscrito Correctamente"
	  
	 }else{
	  var funcion=3;
	  var mensaje="Desea Eliminar del Taller"
	   var mensaje2="Eliminado del Taller"
	 }
	
	
	 var rut_alumno = "<?=$alumno;?>";
	 
	 var parametros = 'funcion='+funcion+'&id_taller='+id_taller+'&rut_alumno='+rut_alumno;
	//alert(parametros);
	 
	 if(confirm(""+mensaje+""))
	 {
	  $.ajax({
	  url:'cont_alumno_taller.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data);
		if(data==1){
			alert(mensaje2);
			}else{
			alert("Error");	
			}
	   }
	 })
    }
 }
 
   
</SCRIPT>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			   <? include("../../../../../../cabecera/menu_superior.php"); ?>			
                <!-- FIN DE COPIA DE CABECERA -->
                   </td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <? $menu_lateral=3; include("../../../../../../menus/menu_lateral.php"); ?>
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
     
     <div id="gif_sige" style="text-align:right"><img src="../../../../../clases/soap/gif_sige.gif"></div>
     <br>
     
      <table width="100%" align="center">
       <tr class="tableindex">
        <td  align="center"><strong>TALLERES&nbsp;</strong><div style="size:10; float:inherit" id="ano_acad"></div></td>
       </tr>
       <tr>
       <td>
<!--<div id="foto_alumno" style="width:80; height:90; float:right"  >
<img src="../../../../../../../infousuario/images/<?=trim($alumno)  ?>" width="80" height="90"></div>-->
</td>
       </tr>
    </table>
	<br>
<div id="modulodatos" align="center" ></div>
<div id="dialog_rut" align="center" title="Modifica Rut Alumno" ></div>
<div id="valida_rut"></div>

     <!-- FIN DEL NUEVO CÓDIGO -->
	 							  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>

</body>
</html>
