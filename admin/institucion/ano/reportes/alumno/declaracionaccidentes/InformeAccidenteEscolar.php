<SCRIPT language="JavaScript">
function enviapag(form){
	if (form.c_curso.value!=0){
		form.c_curso.target="self";
		form.target="_parent";
		form.action = 'InformeAccidenteEscolar.php?institucion=$institucion';
		form.submit(true);
	}	
}

			
</script>

<?
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');


	//setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno 		=$c_alumno;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
	
	//if ($curso==0)
		// exit;
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM institucion INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion."));";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];		 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


<link rel="stylesheet" type="text/css" href="../../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">

<script type="text/javascript" src="../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script>
$(document).ready(function() {
	
	
	
$( "#fecha" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	yearRange: "2000:<?php echo date("Y") ?>",
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dec" ],
    onSelect: function(dateText){
        var seldate = $(this).datepicker('getDate');
        seldate = seldate.toDateString();
        seldate = seldate.split(' ');
        var weekday=new Array();
            weekday['Mon']="1";
            weekday['Tue']="2";
            weekday['Wed']="3";
            weekday['Thu']="4";
            weekday['Fri']="5";
            weekday['Sat']="6";
            weekday['Sun']="7";
        var dayOfWeek = weekday[seldate[0]];
		 $('#diasemana_accidente').val(dayOfWeek);
		 
    }
	
});

$.datepicker.regional['es']	


});
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
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

<script> 
function valida_top(x){
	if(x.c_curso.value==0) {
		alert("Debe Seleccionar Curso.");
		x.c_curso.focus();
		return false;
	}
	else if(x.c_alumno.value==0) {
		alert("Debe Seleccionar Alumno.");
		x.c_alumno.focus();
		return false;
	}
	else{
		if(x.fecha.value=="") {
			alert("Debe seleccionar Fecha.");
			x.fecha.focus();
			return false;
		}else{
			return true;
		}			
	}
}
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
        <td width="0%" align="left" valign="top" bgcolor="f7f7f7"><!-- DESDE AC� DEBE IR CON INCLUDE -->
            <?  include("../../../../../../cabecera/menu_superior.php");  ?>
            <!-- FIN DE COPIA DE CABECERA -->        </td>
      </tr>
      <tr align="left" valign="top">
        <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td width="27%" height="363" align="left" valign="top"><!-- AQUI VA EL MEN{U LATERAL -->
                  <?
						 $menu_lateral=3;
						 include("../../../../../../menus/menu_lateral.php");
						 ?>
                  <!--  FIN MENU LATERAL -->              </td>
              <td width="73%" align="left" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td align="left" valign="top">&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="395" align="left" valign="top"><table width="95%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                        <tr>
                          <td><!-- FIN DEL CONTENIDO CENTRAL DE LA P�GINA -->
                              <!-- INSERTO EL CONTENIDO DEL MOTOR DE BUSQUEDA -->
                            <br>
                              <br>
                                 <form method "post" action="printAccidenteEscolar.php" name="form" target="_blank" onSubmit="return valida_top(this);">
                                 <input name="c_reporte" type="hidden" value="<?=$reporte;?>">
                                 <input name="nombre" type="hidden" value="<?=$nombre;?>">
                                 <input name="numero" type="hidden" value="<?=$numero;?>">
	
                                <center>
                                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                      <td><table width="100%" height="43" border="1" cellpadding="0" cellspacing="0">
                                          <tr>
                                            <td class="tableindex"><? echo $numero.".- Buscador ".$nombre;?>*</td>
                                          </tr>
                                          <tr>
                                            <td height="27"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                  <? 
	$ob_curso = new MotorBusqueda();
	$ob_curso ->ano = $ano;
	$ob_curso->perfil=$_PERFIL;
	$ob_curso->curso=$_CURSO;
	$ob_curso->usuario=$_NOMBREUSUARIO;
	$ob_curso->rdb=$institucion;
	$result_curso = $ob_curso -> curso2($conn);
  ?>
                                                  <td width="130" class="cuadro01">Curso <br>
                                                      <br></td>
                                                  <td width="21" class="cuadro01">:</td>
                                                  <td width="495" class="cuadro01"><select name="c_curso"  class="ddlb_9_x" id="c_curso" onChange="enviapag(this.form);">
                                                      <option value=0 selected>(Seleccione Curso)</option>
                                                      <?
		  for($i=0 ; $i < @pg_numrows($result_curso) ; $i++)
		  {
		  $fila = @pg_fetch_array($result_curso,$i); 
		  if ($fila["id_curso"]==$c_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
                                                  </select></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01">Alumno</td>
                                                  <td width="21" class="cuadro01">:</td>
                                                  <td width="495" class="cuadro01"><select name="c_alumno" class="ddlb_9_x" id="c_alumno">
                                                      <option value=0 selected>(Seleccione Alumno)</option>
                                                      <?
			$ob_alumno = new MotorBusqueda();
			$ob_alumno ->ano = $ano;
			$ob_alumno ->cmb_curso = $c_curso;
			$result_alumno = $ob_alumno -> alumno($conn);
			
		for($i=0 ; $i < @pg_numrows($result_alumno) ; $i++){
			$fila = @pg_fetch_array($result_alumno,$i);
			$rutalumno = $fila["rut_alumno"];
			if ($rutalumno == $c_alumno){
		?>
                                                      <option value="<? echo $fila["rut_alumno"]; ?>" <? if ($fila["rut_alumno"]==$c_alumno){ echo "selected";}?>	><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
                                                      <? }else{ ?>
                                                      <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
                                                      <?
	       }
		}
		?>
                                                  </select></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01">Fecha</td>
                                                  <td class="cuadro01">&nbsp;</td>
                                                  <td class="cuadro01"><input name="fecha" type="text" id="fecha" placeholder="Seleccione Fecha" size="10" readonly></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01">&nbsp;</td>
                                                  <td width="21" class="cuadro01">&nbsp;</td>
                                                  <td width="495" class="cuadro01"><input name="cb_ok" type="submit" class="botonXX"  id="cb_ok" value="Buscar">
                                                    <input name="cb_ok2" type="button" class="botonXX"  id="cb_ok2" value="Volver"onClick="window.location='../../Menu_Reportes_new2.php'"></td>
                                                </tr>
                                                <tr>
                                                  <td class="cuadro01">&nbsp;</td>
                                                  <td class="cuadro01">&nbsp;</td>
                                                  <td class="cuadro01">&nbsp;</td>
                                                </tr>
                                                <tr>
                                                  <td colspan="3" class="cuadro01">(*) Para poder generar certificado, debe ir al men&uacute; Cursos-&gt;Declaraci&oacute;n Accidentes e ingresar los datos requeridos</td>
                                                  </tr>
                                            </table></td>
                                          </tr>
                                      </table></td>
                                    </tr>
                                  </table>
                                </center>
                              </form>
                            <!-- FIN DEL CONTENIDO DEL MOTOR DE BUSQUEDA -->                          </td>
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
    </table></td>
    <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
      </table>
</td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>