<?php require('../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	//$_POSP = 3;
	$ano			=$_ANO;
   //$_MDINAMICO = 1;	
 //  echo $_POST["cmb_curso"];
   
require_once("../../estadisticas/widgets/widgets_start.php"); 
	
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

<script language="JavaScript" src="../../estadisticas/widgets/calendar.js"></script>
<script language="JavaScript" src="../../estadisticas/widgets/calendar-setup.js"></script>
<script language="JavaScript" src="../../estadisticas/widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="../../estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../../estadisticas/js/moodalbox.js"></SCRIPT>
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

		<?php include('../../util/rpc.php3');
		$cmb_ensenanza=$_POST["cmb_ensenanza"];?>
	
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" media="all" href="../../estadisticas/widgets/calendar-brown.css" title="green"/>
<SCRIPT language="JavaScript" src="../../util/chkform.js"></SCRIPT>
		 	
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0"  onload="editInit();">

<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>"></td>
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
						 //$menu_lateral=2;
						 include("../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  <center>
					  
					  <form name="form"   action="proceso_actividades.php" method="post">
					  <input type="hidden" name="modo" value="1">
					  <table width="600" border="0" align="center">
                        <tr>
                          <td colspan="4" class="tableindex"><CENTER>INGRESAR ACTIVIDADES EXTRAPROGRAMATICAS </CENTER></td>
						 </tr>
                 
		  
		     <tr>
		       <td colspan="3" align="left" class="textosimple">Curso</td>
                        <td align="center"><div align="left">
                          <? 
				$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
				$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
				$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
				$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
				$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
                          <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
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
                          </select>
                        </div></td>
		     </tr>
                        <tr>
                          <td colspan="3" class="textosimple">Nombre Actividad:</td>
						  <td width="295"><input type="text" name="nombre"></td>
						</tr>
						<tr>
						  <td colspan="3" class="textosimple">Fecha:</td>
						  <td width="295" textosimple><input name="fecha"/>
						    <input type="button" id="txtFecha" class="botadd" value="Cal.">
								  <script type="text/javascript">
									Calendar.setup({
										inputField     :    "fecha",      // id of the input field
										ifFormat       :    "%d-%m-%Y",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									</script>						  </td>
                        </tr>
						<tr>
                          <td colspan="3" class="textosimple" >Observaciones:</td>
                          <td><textarea name="observaciones" cols="45" rows="6" style="background-color:#FFFFCC "></textarea></td>
						</tr>
                        <tr>
                          <td colspan="4" align="center"><INPUT class="botonXX"  TYPE="SUBMIT" value="GUARDAR">
                            <INPUT class="botonXX"  TYPE="button" value="VOLVER" onClick="document.location='acti_extra.php'"></td>
                        </tr>
                      </table>
					    </form>
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
          <td width="53" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>"></td>
  </tr>
</table>

</body>
</html>

<?  require_once("../../estadisticas/widgets/widgets_end.php");?>
