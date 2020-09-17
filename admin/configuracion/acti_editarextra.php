<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$ano			=$_ANO;
   $_MDINAMICO = 1;	
 //  echo $_POST["cmb_curso"];
   
require_once("includes/widgets/widgets_start.php");
 	 $sql="select * from actividades_extra where id_extra=".$_GET["id_extra"];
	$resp = @pg_exec($conn,$sql);
  	$fila2= @pg_fetch_array($resp,0);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<SCRIPT language="JavaScript">
        function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="acti_extraprogramaticas.php";
				form.action = pag;
				form.submit(true);	
			}		
		 }	
				
</script>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
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
function valida() {

	if(!chkVacio(frm.txt_corp,'Ingrese Corporación')){
		return false;
	};

	frm.submit()
	
}
//-->
</script>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
<script language="JavaScript" src="../../estadisticas/widgets/calendar.js"></script>
<script language="JavaScript" src="../../estadisticas/widgets/calendar-setup.js"></script>
<script language="JavaScript" src="../../estadisticas/widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="../../estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../../estadisticas/js/moodalbox.js"></SCRIPT>
<link rel="stylesheet" type="text/css" media="all" href="../../estadisticas/widgets/calendar-brown.css" title="green"/> 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')" onload="editInit();">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
   <form name="form"   action="proceso_actividades.php" method="post">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../cabecera/menu_superior.php");
			   ?>
          </td>
        </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=2;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  <center>
					  <input type="hidden" name="modo" value="3">
					  <input type="hidden" name="id_extra" value="<? echo $fila2["id_extra"]; ?>">
					  <table width="466" border="0" align="center">
                        <tr>
                          <td colspan="4" class="tableindex"><CENTER>INGRESAR ACTIVIDADES EXTRAPROGRAMATICAS </CENTER></td>
						 </tr>
                 
		  
		     <td colspan="4" align="center">
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select> </td>
                        </tr>
                        <tr>
                          <td colspan="3"><font face="arial, geneva, helvetica" size="2" color="#000000"> Nombre Actividad:</font></td>
						  <td width="295"><input type="text" name="nombre" value="<? echo $fila2["nombre_extra"]; ?>"></td>
						</tr>
						<tr>
						  <td colspan="3"><font face="arial, geneva, helvetica" size="2" color="#000000"> Fecha:</font></td>
						  <td width="295"><input name="fecha" type="text" value="<? impF($fila2["fecha_extra"]); ?>"/>
						    <input type="button" id="txtFecha" class="botadd" value=".">
								  <script type="text/javascript">
									Calendar.setup({
										inputField     :    "fecha",      // id of the input field
										ifFormat       :    "%Y-%m-%d",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									</script>
                        </tr>
						<tr>
                          <td colspan="3"><font face="arial, geneva, helvetica" size="2" color="#000000"> Observaciones:</font></td>
                          <td><textarea name="observaciones" cols="45" rows="6" style="background-color:#FFFFCC "><? echo $fila2["observacion"]; ?></textarea></td>
						</tr>
                        <tr>
                          <td colspan="4" align="center"><INPUT class="botonXX"  TYPE="SUBMIT" value="GUARDAR">
                            <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="document.location='acti_extra.php'"></td>
                        </tr>
                      </table>
					  </center>
					  </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table></td>
              </tr>
            </table>
    </td>
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table></td>
  </tr>
  </form>
</table>
</body>
</html>

<?  require_once("includes/widgets/widgets_end.php");?>
