<?php


require('../../../../../../util/header.inc');

include('../../../../../clases/class_MotorBusqueda.php');

$_POSP = 6;
$_bot = 8;

//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$periodo		=$c_periodos;
	$reporte		=$c_reporte;
	
	$fecha =date("d-m-Y");	

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"> 
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<style>
.medida{
	width:150px; 	display:inline-block;
}
</style>
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
<SCRIPT language="JavaScript">

	$( document ).ready(function() {
	carga_ano();
	carga_curso(<?php echo $ano ?>);
	});	
			
			
	function carga_ano(){
		  //alert("llego");
		  var rdb=<?=$institucion;?>;
		var funcion=1; 
		var parametros='funcion='+funcion+'&rdb='+rdb;
		//alert(parametros);	 
		$.ajax({
		  url:'cont_ensayoSimce.php',
		  data:parametros,
		  type:'POST',
		  success:function(data){
			 // alert(data);
			$("#an").html(data);
			  }
		  })
	}	
	
	function carga_curso(id_ano){
	//var anio = $("#select_anos").val();
	var funcion =2;
	var parametros='funcion='+funcion+"&anio="+id_ano;
	//alert(parametros);
		$.ajax({
	  url:'cont_ensayoSimce.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data);
		 //alert(data);
	    $("#cr").html(data);
		 //var ano=$('#select_anos').val();
		 //$("#select_anos option[value="+ano+"]").attr("selected",true);
		 
		  }
	  })
	}
	
	
	function carga_ramos(id_curso){
		
		var funcion=3;
		
		var parametros='funcion='+funcion+'&id_curso='+id_curso;
	//alert(parametros);
		$.ajax({
	  url:'cont_ensayoSimce.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		//  console.log(data);
		// alert(data);
	    $("#ra").html(data);
		  }
	  })
	}	
	
	
	function validaform(){
	
		if($('#select_anos').val()==0){
			alert("Seleccione Año");
			return false;
			}
		else if($('#select_cursos').val()==0){
		alert("Seleccione Curso");
		return false;
		}
		else if($('#sel_ramo').val()==0){
		alert("Seleccione Ramo");
		return false;
		}
		
	else{ 			
	
	
	document.form.submit(); 
	}
	
	}
	
	
	
				
</script>
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
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
//-->
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../../../menus/menu_lateral.php");
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
                                  <td><center>

<br>
</center>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->


	<form method "post" action="printensayoSimce.php" name="form" target="_blank">

<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 

$ob_motor = new MotorBusqueda();
$ob_motor ->ano =$ano;
$ob_motor->perfil=$_PERFIL;
$ob_motor->curso=$_CURSO;
$ob_motor->usuario=$_NOMBREUSUARIO;
$ob_motor->rdb=$institucion;
$result_curso = $ob_motor ->curso2($conn);

$result_peri = $ob_motor ->periodo($conn);

//------------------
?>
<center>
<table width="" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="">
	<table width="" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="" border="0" cellspacing="0" cellpadding="3">
  <tr>
    <td width="98" class="textosimple">&nbsp;</td>
    <td>&nbsp;</td>
    <td width="80">&nbsp;</td>
  </tr>
  
  <tr>
    <td class="textosimple">A&ntilde;o</td>
    <td><div id="an">
      <select name="sel_ano" id="sel_ano">
        <option value="0">seleccione...</option>
      </select>
    </div></td>
  </tr>
  <tr>
    <td class="textosimple">Curso</td>
    <td width="506">
      <div id="cr">
        <select name="select_cursos" id="select_cursos">
        <option value="0">seleccione...</option>
        </select>
      </div></td>
    
  </tr>
  
  <tr>
    <td class="textosimple">Ramo</td>
    <td><div id="ra">
      <select name="sel_ramo" id="sel_ramo">
      <option value="0">seleccione...</option>
      </select>
    </div></td>
    <td></td>
  </tr>
  <tr>
    <td class="textosimple">&nbsp;</td>
    <td align="right">  
        <input name="BUSCAR" type="button" id="BUSCAR" value="BUSCAR" class="botonXX" onClick="validaform()">
      
      <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver" onClick="window.location='../../Menu_Reportes_new2.php'"></td>
    <td>&nbsp;</td>
  </tr>
  <!--<tr>
    <td class="textosimple">&nbsp;</td>
    <td class="textosimple"><input name="opcion_periodo" type="radio" value="1" >
      Si 
        <input name="opcion_periodo" type="radio" value="0" checked>
        No </td>
    <td>&nbsp;</td>
  </tr>-->
  
  
  
  
  
</table>	
	</td>
  </tr>
</table>	</td>
  </tr>
</table>
</center>
</form>
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->								  </td>
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
<? pg_close($conn);?>