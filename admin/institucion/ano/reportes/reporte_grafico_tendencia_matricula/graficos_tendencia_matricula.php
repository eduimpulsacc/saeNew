 <?php
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');

	
	$_POSP = 4;
	$_bot = 8;
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	
    $reporte		= $c_reporte;

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.css">
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script language="JavaScript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>
<script language="JavaScript" src="../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script language="JavaScript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script type="text/javascript">

	$(document).ready(function() {
		 
	carga_tipo_ense();	
		 
      });

</script>



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
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

.mayuscula{text-transform:uppercase;}


div.ui-datepicker{
                font-size:14px;
                  }
-->
    </style>
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
	
<SCRIPT language="JavaScript">

	function carga_tipo_ense(){
		var rdb="<?=$institucion;?>"
		 funcion=1;
	var parametros='funcion='+funcion+'&rdb='+rdb;
	//alert(parametros);	 
	$.ajax({
	  url:'cont_graficos_tendencia_matricula.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	//	 alert(data);
	    $("#tipo_ense").html(data);
		  }
	  })
	} 
	

function nombre_tipo(x)
{
	
	var nombre_tipo=$('#select_tipo_ense option:selected').html();
	//alert(nombre_tipo);
	
	$('#hidden_nombre_tipo').val(''+nombre_tipo+'');
	
}


function validaform(){
	
	
	/*	if($('#select_tipo_ense').val()==0){
		alert("Seleccione Tipo Enseñanza");
		return false;
		}*/
	
	
	document.form.action="graficos/Graficos_tendencia_matricula.php";
	document.form.submit(); 
	
	//RecargaPagina();
	}
	
	
	function RecargaPagina(){
		location.reload();
		//$('#form')[0].reset();
}
	
										
</script>

<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
}

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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr align="left" valign="top">
                <td height="75" valign="top"><table width="100%"><tr><td><?
				include("../../../../../cabecera/menu_superior.php");
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
						include("../../../../../menus/menu_lateral.php");
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
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <div id="layer2"></div>
<br>
<form name="form" id="form" method="post" action="graficos/GraficosEnsayosPsu.php" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">

<input type="hidden" name="hidden_nombre_tipo" id="hidden_nombre_tipo" >
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">

  <center>
    <table width="90%" border="0" cellspacing="0" cellpadding="3">
    <tr>
      <td colspan="2" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
      </tr>
       <tr>
      <td width="18%">Tipo Ense&ntilde;anza:</td>
      <td width="82%">
      <div id="tipo_ense">
      <select name="tipo_ense" >
      <option>Seleccionar</option>
      </select>
      </div></td>
    </tr>
    
    <tr>
    <td>&nbsp;
    </td>
    </tr>
    <tr>
    <td colspan="2">solo Hombres :
    <input type="radio" name="grupo" id="hombres" value="2">
    solo Mujeres :
    <input type="radio" name="grupo" id="mujeres" value="1">
    Ambos :
    <input type="radio" name="grupo" id="ambos" checked>
    </td>
    </tr>
    <br>
    <tr>
    <td colspan="2">
    Grafico Lineal :
    <input type="radio" name="tipo_g" id="tipo_g" value="1">
    Grafico de barras :
    <input type="radio" name="tipo_g" id="tipo_g" value="2" checked>
    </td>
    </tr>
    <br />
    <tr>
      <td colspan="2">
      
      <br><br>
      <div align="left">
        <input name="buscar" type="button" id="buscar" value="BUSCAR" class="botonXX" onClick="validaform()"/>
        <input name="volver" type="button" class="botonXX"  id="volver" value="Volver" onClick="window.location='../Menu_Reportes_new2.php'"/>
      </div></td>
      </tr>
  </table>  
  <br><br>
  <div id="">&nbsp;</div>
   
</center>
</form>
							 
<!-- FIN FORMULARIO DE BUSQUEDA -->
 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

         
          <td width="53" height="1024" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>