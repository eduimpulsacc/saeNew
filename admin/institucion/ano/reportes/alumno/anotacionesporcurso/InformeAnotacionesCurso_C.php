<SCRIPT language="JavaScript">
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
					
</script>
<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$cmb_anos;
	$curso			=$cmb_curso;
	$periodo		=$cmb_periodo;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
	

?>	
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../../../../../clases/jquery/jquery.js"></script>
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


function traecur(cur){
var funcion=1;
var parametros = "funcion="+funcion+"&ano="+cur;
 $.ajax({
	  url:'cont_busqueda.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		  //alert(data)
	    $("#cur").html(data);
	 }
      
	  })

}

function act(opt){
	

if(opt==1){
	var ruta = "printInformeAnotacionesCurso_C.php";
}
else{
	var ruta = "printGraficoAnotacionesCurso_C.php";
}
form.target="_blank";
		form.action = ruta;
		//form.submit(true);
}
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
.Estilo1 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">


<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE AC� DEBE IR CON INCLUDE -->
			  <?
			  include("../../../../../../cabecera/menu_superior.php");
			  ?>
			  
                        <!-- FIN DE COPIA DE CABECERA -->
                    
					
					</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <!-- AQUI VA EL MEN{U LATERAL -->
						 <?
						 $menu_lateral=3;
						 include("../../../../../../menus/menu_lateral.php");
						 ?>
						 
						 <!--  FIN MENU LATERAL -->
						
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
								  
								     <!-- COPIO LOS BOTONES PARA QUE NO EST�N SEPARADOS -->
								     <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
       					
	  </td></tr> 
</table>
<!-- FIN CUERPO DE LA PAGINA -->


                  <!-- INSETO FORMULARIO DE BUSQUEDA -->
				  
<form method "post" action="" name="form" target="_blank">
<input name="c_reporte" type="hidden" value="<?=$reporte;?>">
<input name="nombre" type="hidden" value="<?=$nombre;?>">
<input name="numero" type="hidden" value="<?=$numero;?>">
<? 
	$ob_motor = new MotorBusqueda();
	$ob_motor -> ano =$ano;
	$ob_motor->perfil=$_PERFIL;
	$ob_motor->curso=$_CURSO;
	$ob_motor->usuario=$_NOMBREUSUARIO;
	$ob_motor->rdb=$institucion;
	//$resultado_query_cue = $ob_motor -> curso2($conn);

	$result_peri =$ob_motor ->Ano($conn);


//------------------
?>
<center>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="">
	<table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="" class="tableindex"><? echo $numero.".- Buscador ".$nombre;?></td>
  </tr>
  <tr>
    <td height="27">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="19%" class="cuadro01">A&ntilde;o escolar<br>
	</td>
    <td width="81%" class="cuadro01"><select name="cmb_anos" id="cmb_anos" class="ddlb_9_x" colspan="2" onChange="traecur(this.value);">
      <font size="1" face="arial, geneva, helvetica">
      <option value=0 selected>(Seleccione A�o)</option>
      <?
		  for($i=0 ; $i < @pg_numrows($result_peri) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_peri,$i); ?>
      <option value="<? echo $fila['id_ano']?>" ><? echo $fila['nro_ano']?></option>
      <? } ?>
      </font>
    </select></td>
    </tr>
	<tr>
	<td class="cuadro01">
	 Curso</td>
    <td class="cuadro01"><font size="1" face="arial, geneva, helvetica"><span id="cur">
    <select name="cmb_curso"  class="ddlb_9_x" >
      <option value=0 >(Seleccione Curso)</option>
    </select>
    </span></font></td>
	</tr>
	<tr>
	  <td class="cuadro01">Formato</td>
	  <td class="cuadro01"><input name="tipo" type="radio" id="tipograf" value="1" onChange="act(this.value)">
	    Listado 
	      <input type="radio" name="tipo" id="tipograf2" value="2" onChange="act(this.value)">
	      Gr&aacute;fico</td>
	  </tr>
	<tr>
	  <td class="cuadro01">&nbsp;</td>
	  <td class="cuadro01">&nbsp;</td>
	  </tr>
	<tr>
	  <td class="cuadro01">&nbsp;</td>
	  <td class="cuadro01"><input type="submit" class="botonXX" name="cb_ok" value="Buscar">
        <input type="button" class="botonXX" name="cb_ok2" value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'"></td>
	  </tr>
    </table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
</center>
</form>                        
		  <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->								  
								  
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
<? pg_close($conn);?>