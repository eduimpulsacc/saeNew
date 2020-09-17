<?	require('../../util/header.inc');
	//include('../../clases/class_MotorBusqueda.php');
	//include('../../clases/class_Membrete.php');
	//include('../clases/class_Reporte.php');

	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$cmb_ensenanza;
	$cmb_grado;
	//$curso			=$c_curso	;
	//$alumno			=$c_alumno	;
	//$reporte		=$c_reporte;
	//$_POSP = 4;
	//$_bot = 8;
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link href="../../cortes/12086/estilos.css " rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">

function enviapag(form){
			if (form.cmb_subsector.value!=0){
				//form.cmb_ensenanza.target="self";
					//form.action = 'agregasubsector_psu.php?institucion=$institucion';
				form.submit(true);
			}else{
			alert("DEBE SELECCIONAR SUBSECTOR");
			}	
}
			
function enviapag2(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'agregasubsector_psu.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			

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
<body>
<table width="36%" border="0">
  <tr>
    <td colspan="4" class="tableindex">GENERADOR INFORME PSU </td>
  </tr>
  <tr>
    <td class="cuadro01">A&ntilde;o</td>
    <td width="46%" class="cuadro01">
	<?  $sql = "SELECT * FROM ano_escolar WHERE id_institucion =".$institucion;
		$resp = pg_exec($conn,$sql);
		$num = pg_numrows($resp);
		
		?>
		<select name="cmb_ano" id="cmb_ano" class="ddlb_x">
    	<? for($i=0;$i<$num;$i++){
			$fila_ano = pg_fetch_array($resp,$i); ?>
		 	<option value="<?=$fila_ano['id_ano']?>" selected><?=$fila_ano['nro_ano']?></option>
		<? }?>
		</select></td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro02">Subsectores</td>
  </tr>
  <tr>
    <td class="cuadro01"><input type="checkbox" name="ck_1" value="checkbox">
HISTORIA Y CS.  SOC. <br />
<input type="checkbox" name="ck_2" value="checkbox">
MATEMATICA <br />
<input type="checkbox" name="ck_3" value="checkbox">
LENG. CASTELLANA Y COMUNIC. </td>
    <td class="cuadro01"><input type="checkbox" name="ck_4" value="checkbox">
      CIENCIAS <br />
      <input type="checkbox" name="ck_5" value="checkbox">
      BIOLOGIA <br />
      <input type="checkbox" name="ck_6" value="checkbox">
      QUIMICA <br />
      <input type="checkbox" name="ck_7" value="checkbox">
    FISICA </td>
  </tr>
  
  <tr>
    <td colspan="4" class="cuadro02">Ordenar por : </td>
  </tr>
  <tr>
    <td width="54%" class="cuadro01"><div align="center">Curso
        <input name="r_ordena" type="radio" value="radiobutton" />
    </div></td>
    <td colspan="3" class="cuadro01"><div align="center">Alumnos
        <input name="r_ordena" type="radio" value="radiobutton" />
    </div></td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro02">Evaluaci&oacute;n : </td>
  </tr>
  <tr>
    <td class="cuadro01"><div align="center">Puntaje
        <input name="r_puntaje" type="radio" value="radiobutton">
    </div></td>
    <td class="cuadro01"><div align="center">Puntaje/Promedio
        <input name="r_puntaje" type="radio" value="radiobutton">
    </div></td>
  </tr>
  <tr>
    <td colspan="2" class="cuadro01"><div align="center">
      <input type="submit" name="Submit" class="botonXX" value="Buscar">
    </div>
	</td>
  </tr>
</table>


<!--<table width="100%" border="1">
  <tr>
    <td width="5%" rowspan="2" class="cuadro02">Curso</td>
    <td width="7%" rowspan="2" class="cuadro02">Alumnos</td>
    <td colspan="7" class="cuadro02">Subsector</td>
    <td width="8%" rowspan="2" class="cuadro02">Promedio</td>
    <td width="8%" rowspan="2" class="cuadro02">Puntaje PSU </td>
  </tr>
  <tr>
    <td width="11%" class="cuadro02">HISTORIA Y CIENCIAS SOCIALES</td>
    <td width="10%" class="cuadro02">MATEMATICA</td>
    <td width="11%" class="cuadro02">BIOLOGIA</td>
    <td width="8%" class="cuadro02">QUIMICA</td>
    <td width="6%" class="cuadro02">FISICA</td>
    <td width="18%" class="cuadro02">LENGUA CASTELLANA Y COMUNICACION</td>
    <td width="8%" class="cuadro02">CIENCIAS</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>-->
</body>
</html>
<? pg_close($conn);?>