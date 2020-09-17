<?php require('../../../../util/header.inc');
$institucion=$_INSTIT;
$_POSP = 4;
$_bot = 7;

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


if(session_is_registered('_PLANTILLAPEI')){
			session_unregister('_PLANTILLAPEI');
		};
if(session_is_registered('_AREAPEI')){
			session_unregister('_AREAPEI');
		};
if(session_is_registered('_SUBAREAPEI')){
			session_unregister('_SUBAREAPEI');
		};		

	//$sqlTraePlantillas="SELECT * FROM informe_plantilla where tipo_ensenanza=".$tipoEns;
	$sqlTraePlantillas="SELECT * FROM pei_plantilla where rdb=".$institucion." order by fecha_creacion asc";
	$resultTraePlantillas=pg_Exec($conn, $sqlTraePlantillas);
	if (!$resultTraePlantillas) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlTraePlantillas);
	}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../clases/jquery/jquery.js"></script>
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
<script>
$( document ).ready(function() {
   listaPlantila(<?php echo $institucion ?>);
});
function est(plantilla,estado){
	var cambio = (estado==1)?"ACTIVAR":"DESACTIVAR";
	if(confirm("¿Seguro desea "+cambio+" esta plantilla?")){
	var parametros="funcion=9&estado="+estado+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	 location.reload();
		  }
	  })
	}
	
}

function modPlantila(plantilla){
	var funcion=10;
	var parametros = "funcion="+funcion+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	$("#dplan").html(data);
		  }
	  })
}

function listaPlantila(rdb){
	var funcion=11;
	var parametros = "funcion="+funcion+"&rdb="+rdb;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	$("#dplan").html(data);
		  }
	  })
}
function confquitar(plantilla,rdb){
var funcion=12;
var parametros = "funcion="+funcion+"&plantilla="+plantilla;

	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	//$("#dplan").html(data);
	//console.log(data);
	if(data==1){
	alert("Plantilla tiene evaluaciones previas. No puede ser eliminada")	
	}else{
		if(confirm("¿Seguro desea eliminar esta plantilla?")){
			quitaPlantilla(plantilla,rdb);
		}	
	}
	
		  }
	  })
}

function quitaPlantilla(plantilla,rdb){
var funcion=13;	
var parametros = "funcion="+funcion+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	//$("#dplan").html(data);
	 listaPlantila(rdb);
		  }
	  })
}

function previa(plantilla,rdb){
var funcion=14;	
var parametros = "funcion="+funcion+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	$("#dplan").html(data);
	// listaPlantila(rdb);
		  }
	  })
}

function configura(plantilla,rdb){
var funcion=15;	
var parametros = "funcion="+funcion+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	$("#dplan").html(data);
	// listaPlantila(rdb);
		  }
	  })
}
function cambiaConc(plantilla,rdb){
var funcion=16;	
//var frm=$("#gc").serialize();

var searchIDs = [];
$("input.itm[type=checkbox]:checked").map(function(){
    searchIDs.push($(this).val());
  });
  
var parametros = "funcion="+funcion+"&plantilla="+plantilla+"&searchIDs="+searchIDs;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	
	alert("Datos almacenados exitosamente");
	modPlantila(plantilla);
		  }
	  })
}
function psalto(plantilla,rdb){
var funcion=17;	
var parametros = "funcion="+funcion+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	$("#dplan").html(data);
	// listaPlantila(rdb);
		  }
	  })
}
function cambiaSalto(plantilla,rdb){
var funcion=18;	
//var frm=$("#gc").serialize();

var searchIDs = [];
$("input.itm[type=checkbox]:checked").map(function(){
    searchIDs.push($(this).val());
  });
  
var parametros = "funcion="+funcion+"&plantilla="+plantilla+"&searchIDs="+searchIDs;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	
	alert("Datos almacenados exitosamente");
	modPlantila(plantilla);
		  }
	  })
}
function lcon(plantilla,rdb){
var funcion=19;	
var parametros = "funcion="+funcion+"&plantilla="+plantilla;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		
	$("#dplan").html(data);
	// listaPlantila(rdb);
		  }
	  })
}
function cambia(tr1,tr2){
	document.getElementById(tr1).style.display="none";
	document.getElementById(tr2).style.display="";
}

function eliminarconc(nombre,id_concepto,plantilla){
var funcion=20;	
var parametros = "funcion="+funcion+"&id_concepto="+id_concepto;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		console.log(data);
	if(data==0){
			if(confirm("\xBFSeguro que desea eliminar este concepto de la plantilla?")){
				quitacnc(id_concepto,plantilla);
				}
				
			}
	else{
			alert("Concepto "+nombre+" tiene evaluaciones asociadas. No se puede eliminar.");	
			}
			
		  
		}
	  })	
}



function quitacnc(id_concepto,plantilla){
	var funcion=21;	
var parametros = "funcion="+funcion+"&id_concepto="+id_concepto;
	$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		console.log(data);
		lcon(plantilla);
	//$("#dplan").html(data);
	// listaPlantila(rdb);
		  }
	  })
}

function gcoo(){
var funcion=22;
var plantilla=$("#ipp").val();
var nombre=$("#n_nombre").val();
var sigla=$("#n_sigla").val();
var glosa=$("#n_glosa").val();
var parametros = "funcion="+funcion+"&plantilla="+plantilla+"&nombre="+nombre+"&sigla="+sigla+"&glosa="+glosa;
$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//console.log(data);
	//$("#dplan").html(data);
	// listaPlantila(rdb);
	lcon(plantilla);
		  }
	  })	
}

function modc(concepto,plantilla){
var funcion=23;
var nombre=$("#nombre_"+concepto).val();
var sigla=$("#sigla_"+concepto).val();
var glosa=$("#glosa_"+concepto).val();

var parametros = "funcion="+funcion+"&concepto="+concepto+"&nombre="+nombre+"&sigla="+sigla+"&glosa="+glosa;

//alert(parametros);
$.ajax({
	  url:'cont_pei.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		lcon(plantilla);
		  }
	  })	
}
</script>

<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>
		
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
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
    					 $menu_lateral=2;
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
								  
 <div id="dplan"> 
<table width="520" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table></div>
</td></tr></table>
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
</body>
</html>
