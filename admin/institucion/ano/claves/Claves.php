<?php require('../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 4;
	$_bot = 0;
	
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
<link  rel="shortcut icon" href="file:///C|/Documents and Settings/Administrador/images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

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
//-->
</script>
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
<script type="text/javascript">

$(document).ready(function(){
	Listado();
});

function Listado(){
	var parametros="funcion=1";
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })		
}

function AdminClaves(tipo){
	var parametros="funcion=2&tipo="+tipo;
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })		
}

function ClavesCurso(tipo){
	var parametros="funcion=3&tipo="+tipo;
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })		
}

function MuestraClaves(tipo,curso){
	var parametros="funcion=3&tipo="+tipo+"&curso="+curso;
	//alert(parametros);
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#tabla").html(data);
		  }
	  })		
		
}

function ModificaClave(rut,estado,tipo){
	var curso= $("#cmb_curso").val();
	var parametros="funcion=4&rut="+rut+"&estado="+estado;
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   	if(data==1){
				MuestraClaves(tipo,curso);
			}else{
				alert("ERROR AL MODIFICAR");	
			}
		  }
	  })	
}

function ModificaBloqueo(rut,estado,tipo){
	var curso= $("#cmb_curso").val();
	var parametros="funcion=5&rut="+rut+"&estado="+estado;
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   	if(data==1){
				MuestraClaves(tipo,curso);
			}else{
				alert("ERROR AL MODIFICAR");	
			}
		  }
	  })	
}

function UsuarioCurso(estado,tipo){
	var curso= $("#cmb_curso").val();
	var parametros="funcion=6&estado="+estado+"&curso="+curso+"&tipo="+tipo;
	//alert(parametros);
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   	if(data==1){
				MuestraClaves(tipo,curso);
			}else{
				alert("ERROR AL MODIFICAR");	
			}
		  }
	  })	
}
function BloqueoCurso(estado,tipo){
	var curso= $("#cmb_curso").val();
	var parametros="funcion=7&estado="+estado+"&curso="+curso+"&tipo="+tipo;
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   	if(data==1){
				MuestraClaves(tipo,curso);
			}else{
				alert("ERROR AL MODIFICAR");	
			}
		  }
	  })	
}

function BusquedaRUT(tipo){
	var curso= $("#cmb_curso").val();
	var parametros="funcion=8&tipo="+tipo;
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   	$("#tabla").html(data);
			
		  }
	  })	
}

function BuscaClave(tipo){
	var usuario= $("#nombre_usuario").val();
	var parametros="funcion=8&tipo="+tipo+"&usuario="+usuario;
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		   	$("#tabla").html(data);
			
		  }
	  })	
}

function GeneraClavesAlumno(){
	var base =<?=$_ID_BASE;?>;
	var ano  =<?=$_ANO;?>;
	var rdb  =<?=$_INSTIT;?>;
	var parametros="funcion=10&ano="+ano+"&base="+base+"&rdb="+rdb;
	$('#login').html('<div align="center"><img src="loading.gif"/></div>');
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //console.log(data);
		   	if(data==1){
				Listado();
				$('#login').remove();
			}else{
				alert("ERROR AL GENERAR LA CLAVES");	
			}
		  }
	  })	
}

function GeneraClavesApoderado(){
	var base =<?=$_ID_BASE;?>;
	var ano  =<?=$_ANO;?>;
	var rdb  =<?=$_INSTIT;?>;
	var parametros="funcion=11&ano="+ano+"&base="+base+"&rdb="+rdb;
	$('#login').html('<div align="center"><img src="loading.gif"/></div>');
	$.ajax({
	  url:'cont_claves.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  console.log(data);
		   	if(data==1){
				Listado();
				$('#login').remove();
			}else{
				$('#login').remove();
				alert("ERROR AL GENERAR LA CLAVES");	
			}
		  }
	  })		
}
</script>



<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}
</script> 


<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					    
						<table width="70%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="right" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             <div id="tabla">&nbsp;</div>
                             <div id="login">&nbsp;</div>
							 </td>							  
                          </tr>
						  <tr id="mensaje" style="display:none">
						    <td><br>
						    <table align="center">
						      <tr>
						        <td nowrap="nowrap" class="cuadro01"><div align="center">Por favor espere un momento....<br>
						          La informaci&oacute;n se est&aacute; procesando.</div></td>
						        </tr>
						      </table>
                           </td></tr>
						   
                      </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php");?> </td>
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
<?
pg_close($conn);
?>
</body>
</html>
