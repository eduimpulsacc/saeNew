<?php require('../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$_POSP = 3;
	$cram = $_GET['mdi'];
	$_MDINAMICO = $cram;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$empleado		=$_EMPLEADO;
	
	
	$sql = " SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || ";
	$sql.= " empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado ";
	$sql.= " INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON ";
	$sql.= " trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") AND ";
	$sql.= " ((trabaja.cargo)=5)) ORDER BY trabaja.cargo, ape_pat, ape_mat, nombre_emp ASC ";
	$rs_docente =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
	
	$sql = " SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || ";
	$sql.= " empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado ";
	$sql.= " INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON ";
	$sql.= " trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") AND ";
	$sql.= " ((trabaja.cargo) in (1,2,6))) ORDER BY trabaja.cargo, ape_pat, ape_mat, nombre_emp ASC ";
	$rs_directivos =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
	
	$sql = " SELECT empleado.rut_emp, empleado.dig_rut, (empleado.nombre_emp || ' ' || empleado.ape_pat ||' ' || ";
	$sql.= " empleado.ape_mat) as nombre, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado ";
	$sql.= " INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON ";
	$sql.= " trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") AND ";
	$sql.= " ((trabaja.cargo) not in (1,2,6,5))) ORDER BY trabaja.cargo, ape_pat, ape_mat, nombre_emp ASC ";
	$rs_tecnicos =@pg_exec($conn,$sql) or die ("SELECT FALLÓ:".$sql);
	
	$sql = "SELECT * FROM dotacion_docente WHERE rdb=".$institucion." AND id_ano=".$ano." ";
	$result = @pg_exec($conn,$sql);
	$sw = @pg_numrows($result);
	
 ?>
 <SCRIPT language="JavaScript" src="../../../util/chkform.js"></SCRIPT>
<script language="JavaScript" type="text/JavaScript">
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
</script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">



	
<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=300, height=266, top=85, left=140";
window.open(pagina,"",opciones);
}
</script> 


<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<!--link href="../../../estilos.css" rel="stylesheet" type="text/css"-->
<style type="text/css">
<!--
.Estilo7 {font-family: Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
-->
</style>
<style type="text/css">
body{
color: #333;
font-size: 11px;
font-family: verdana;
}
a{
color: #fff;
text-decoration: none;
}
a:hover{
color: #DFE44F;
}
p{
margin: 0;
padding: 5px;
line-height: 1.5em;
text-align: justify;
border: 1px solid #CCCCCC;
}
#wrapper{
width: 950px;
margin: 0 auto;
}
.box{
background: #fff;
}
.boxholder{
clear: both;
padding: 3px;
background: #CCCCCC;
}
.tab{
float: left;
height: 32px;
width: 150px;
margin: 0 1px 0 0;
text-align: center;
background: #CCCCCC url(images/greentab.jpg) no-repeat;
}
.tabtxt{
margin: 0;
color: #fff;
font-size: 12px;
font-weight: bold;
padding: 9px 0 0 0;
}
.Estilo9 {font-size: 9}
.Estilo10 {font-size: 9px}
</style>
<script type="text/javascript" src="scripts/prototype.lite.js"></script>
<script type="text/javascript" src="scripts/moo.fx.js"></script>
<script type="text/javascript" src="scripts/moo.fx.pack.js"></script>
<script type="text/javascript">
function init(){
	var stretchers = document.getElementsByClassName('box');
	var toggles = document.getElementsByClassName('tab');
	var myAccordion = new fx.Accordion(
		toggles, stretchers, {opacity: false, height: true, duration: 600}
	);
	//hash functions
	var found = false;
	toggles.each(function(h3, i){
		var div = Element.find(h3, 'nextSibling');
			if (window.location.href.indexOf(h3.title) > 0) {
				myAccordion.showThisHideOpen(div);
				found = true;
			}
		});
		if (!found) myAccordion.showThisHideOpen(stretchers[0]);
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
&nbsp;
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="100%" align="left" valign="top">
	   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
               <?
			   include("../../../cabecera/menu_superior.php");
			   ?>
          </td>
         </tr>
         <tr align="left" valign="top"> 
            <td height="83" colspan="3">
				   <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                         <?
						 $menu_lateral=1;
						 include("../../../menus/menu_lateral.php");
						 ?>
						
					  </td>
                      <td align="left" valign="top">
					    
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="0" align="left" valign="top"> 
                             
										
						
								  
							 <table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
					            	
								   <!-- AQUI VA TODA LA PROGRAMACIÓN  -->
									
	<FORM method=post name="form" action="procesoDotacionDocente.php" >

	
		<TABLE WIDTH=100% BORDER=0 align="center" CELLPADDING=0 CELLSPACING=0 >
			<TR height=15>
				<TD bgcolor="#FFFFFF"><table width="100%" border="0">
                              <tr>
                                <td width="18%"><span class="Estilo7">INSTITUCI&Oacute;N</span></td>
                                <td width="3%"><span class="Estilo7">:</span></td>
                                <td width="79%"><font face="Arial, Helvetica, sans-serif" size="3"><? $sql ="SELECT nombre_instit FROM institucion WHERE rdb=".$institucion."";
										$rs_instit = @pg_exec($conn,$sql);
										echo pg_result($rs_instit,0);
									 ?></font></td>
                              </tr>
                            </table><br>
						<table width="200" border="0" align="right">
						  <tr>
						  	<? if($frmModo=="mostrar" && $sw==0){ ?>
							<td><input name="agregar" type="button" value="AGREGAR" class="botonXX" onClick="window.location='seteaDotacionDocente.php?caso=2'"></td>
						 	<? }
								if($frmModo=="mostrar" && $sw > 0){ ?>							
							<td><input name="modificar" type="button" value="MODIFICAR" class="botonXX" onClick="window.location='seteaDotacionDocente.php?caso=3'"></td>
							<? }
								if($frmModo=="ingresar" || $frmModo=="modificar"){ ?>
							<td><input name="guardar" type="submit" value="GUARDAR" class="botonXX"></td>
							<td><input name="cancelar" type="button" value="CANCELAR" class="botonXX" onClick="window.location='seteaDotacionDocente.php?caso=1'"></td>
							<? } ?>
						  </tr>
						</table>

							<br>
							<div id="wrapper">
	<div id="content">
    <div id="tabs-1">
	<h3 class="tab" title="Docentes"><div class="tabtxt"><a href="#tabs-1">Docentes</a></div></h3>
	<div class="tab"><h3 class="tabtxt" title="Directivos"><a href="#tabs-2">Directivos</a></h3></div>
	<div class="tab"><h3 class="tabtxt" title="Técnicos"><a "#tabs-1">Técnicos Pedagogicos</a></h3></div>

	<div class="#tabs-1">
		<div class="box">
			<p><table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="11" class="item Estilo9">DOCENTES</td>
  </tr>
  <tr>
    <td class="item Estilo10">RUT</td>
    <td class="item Estilo10">CALIDAD <br />
    CONTRATO </td>
    <td class="item Estilo10">NOMBRE</td>
    <td class="item Estilo10">HORAS<br />
    CONTRATO</td>
    <td class="item Estilo10">ART.69</td>
    <td class="item Estilo10">HORAS<br />
      AMPLIACI&Oacute;N <br />
      SIMPLES</td>
    <td class="item Estilo10">HORAS<br />
      AMPLIACI&Oacute;N<br />
      JEC</td>
    <td class="item Estilo10">TOTAL<br />
      HORAS<br />
      AULA</td>
    <td class="item Estilo10">HORAS<br />
    EXCEDENTES</td>
    <td class="item Estilo10">CARGO /<br />
    ASIGNATURA / <br />
    ESPECIALIDAD </td>
    <td class="item Estilo10">OBSERVACI&Oacute;N</td>
  </tr>
  <? for($i=0;$i<@pg_numrows($rs_docente);$i++){
  		$fila_emp = @pg_fetch_array($rs_docente,$i);
		if($frmModo=="modificar" || $frmModo=="mostrar"){
			$sql = " SELECT * FROM dotacion_docente WHERE rdb=".$institucion." AND id_ano=".$ano." AND rut_emp=".$fila_emp['rut_emp']." AND ";
			$sql.= " cargo=".$fila_emp['cargo'];
			$result_d = @pg_exec($conn,$sql);
			$fila_1 = @pg_fetch_array($result_d,0);
			if($fila_1['tipo_emp']==0){
				$s_0 ="selected=selected";
				$s_1 ="&nbsp;";
				$s_2 ="&nbsp;";
				$s_3 ="&nbsp;";
			}elseif($fila_1['tipo_emp']==1){
				$s_0 ="&nbsp;";
				$s_1 ="selected=selected";
				$s_2 ="&nbsp;";
				$s_3 ="&nbsp;";
			}elseif($fila_1['tipo_emp']==2){
				$s_0 ="&nbsp;";
				$s_1 ="&nbsp;";
				$s_2 ="selected=selected";
				$s_3 ="&nbsp;";
			}elseif($fila_1['tipo_emp']==3){
				$s_0 ="&nbsp;";
				$s_1 ="&nbsp;";
				$s_2 ="&nbsp;";
				$s_3 ="selected=selected";
			}
		}
  ?>
  	<input type="hidden" name="rut_docente<?=$i;?>" value="<?=$fila_emp['rut_emp'];?>">
	<input type="hidden" name="cargo_docente<?=$i;?>" value="<?=$fila_emp['cargo'];?>">
  <tr>
    <td class="subitem"><div align="right" class="Estilo9">
        <?=$fila_emp['rut_emp']."-".$fila_emp['dig_rut'];?>
    </div></td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
	<select name="cmb_DOCENTE<? echo $i;?>">
      <option value="0" selected="selected">Seleccione</option>
      <option value="1">Indefinido</option>
      <option value="2">Plazo Fijo</option>
      <option value="3">Honorarios</option>
    </select>
	<? }elseif($frmModo=="mostrar"){ 
		if($fila_1['tipo_emp']=="0")
			echo "&nbsp;";
		elseif($fila_1['tipo_emp']=="1")
			echo "Indefinido";
		elseif($fila_1['tipo_emp']=="2")
			echo "Plazo Fijo";
		else
			echo "Honorarios";

		}elseif($frmModo=="modificar"){?>
	<select name="cmb_DOCENTE<? echo $i;?>">
      <option value="0" <?=$s_0;?>>Seleccione</option>
      <option value="1" <?=$s_1;?>>Indefinido</option>
      <option value="2" <?=$s_2;?>>Plazo Fijo</option>
      <option value="3" <?=$s_3;?>>Honorarios</option>
    </select>
	<?	} ?>
	</td>
    <td class="subitem"><div align="left" class="Estilo9"><?=$fila_emp['nombre'];?></div></td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="hrs_contrato<? echo $i;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){ 
			echo $fila_1['hrs_contrato'];
	   }elseif($frmModo=="modificar"){?>
	   	<input name="hrs_contrato<? echo $i;?>" type="text" size="5" value="<?=$fila_1['hrs_contrato'];?>">
	<?  }
	?>	
	</td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="art_69<? echo $i;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){ 
		echo $fila_1['art_69'];
	   }elseif($frmModo=="modificar"){?>
	   <input name="art_69<? echo $i;?>" type="text" size="5" value="<?=$fila_1['art_69'];?>">
	<? } ?>   
	</td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="amp_simple<? echo $i;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){ 
		echo $fila_1['amp_simple'];
	   }elseif($frmModo=="modificar"){ ?>	
	   <input name="amp_simple<? echo $i;?>" type="text" size="5" value="<?=$fila_1['amp_simple'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="amp_jec<? echo $i;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){ 
		echo $fila_1['amp_jec'];
		}elseif($frmModo=="modificar"){ ?>
		<input name="amp_jec<? echo $i;?>" type="text" size="5" value="<?=$fila_1['amp_jec'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="hrs_total<? echo $i;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){ 
		echo $fila_1['total_aula'];
		}elseif($frmModo=="modificar"){ ?>		
		<input name="hrs_total<? echo $i;?>" type="text" size="5" value="<?=$fila_1['total_aula'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="hrs_excedente<? echo $i;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){ 
		echo $fila_1['hrs_excedente'];
	   }elseif($frmModo=="modificar"){ ?>	
	   <input name="hrs_excedente<? echo $i;?>" type="text" size="5" value="<?=$fila_1['hrs_excedente'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="asignatura<? echo $i;?>" type="text" size="10">
	<? }elseif($frmModo=="mostrar"){ 
		echo $fila_1['cargo_asig'];
	   }elseif($frmModo=="modificar"){ ?>	
	   <input name="asignatura<? echo $i;?>" type="text" size="10" value="<?=$fila_1['cargo_asig'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
		<input name="obs<? echo $i;?>" type="text" size="10">
	<? }elseif($frmModo=="mostrar"){ 
		echo $fila_1['obs'];
	   }elseif($frmModo=="modificar"){ ?>	
	   	<input name="obs<? echo $i;?>" type="text" size="10" value="<?=$fila_1['obs'];?>">
	 <? } ?>
	</td>
  </tr>
  <? } ?>
  <input type="hidden" name="cont_docente" value="<?=$i;?>">
  <tr>
    <td colspan="3" class="item Estilo9">TOTALES</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td colspan="2" class="item Estilo9">&nbsp;</td>
  </tr>
</table>
			</p>
		</div>
        </div>
		<div class="box" id="#tabs-2">
			<p><table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="7" class="item Estilo9">    DIRECTIVOS DOCENTES </td>
  </tr>
  <tr>
    <td class="item Estilo9">RUT</td>
    <td class="item Estilo9">CALIDAD <br />
    CONTRATO </td>
    <td class="item Estilo9">NOMBRE</td>
    <td class="item Estilo9">HORAS<br />
    CONTRATO</td>
    <td class="item Estilo9">AMPLIACI&Oacute;N<br />
    HORARIA</td>
    <td class="item Estilo9">TOTAL</td>
    <td class="item Estilo9">TIPO<br />
      FUNCI&Oacute;N</td>
  </tr>
  <? for($j=0;$j<@pg_numrows($rs_directivos);$j++){
  		$fila_direc = @pg_fetch_array($rs_directivos,$j);
		if($frmModo=="modificar" || $frmModo=="mostrar"){
			$sql = " SELECT * FROM dotacion_docente WHERE rdb=".$institucion." AND id_ano=".$ano." AND rut_emp=".$fila_direc['rut_emp']." AND ";
			$sql.= " cargo=".$fila_direc['cargo'];
			$result_d = @pg_exec($conn,$sql);
			$fila_2 = @pg_fetch_array($result_d,0);
			if($fila_2['tipo_emp']==0){
				$s_0 ="selected=selected";
				$s_1 ="&nbsp;";
				$s_2 ="&nbsp;";
				$s_3 ="&nbsp;";
			}elseif($fila_2['tipo_emp']==1){
				$s_0 ="&nbsp;";
				$s_1 ="selected=selected";
				$s_2 ="&nbsp;";
				$s_3 ="&nbsp;";
			}elseif($fila_2['tipo_emp']==2){
				$s_0 ="&nbsp;";
				$s_1 ="&nbsp;";
				$s_2 ="selected=selected";
				$s_3 ="&nbsp;";
			}elseif($fila_2['tipo_emp']==3){
				$s_0 ="&nbsp;";
				$s_1 ="&nbsp;";
				$s_2 ="&nbsp;";
				$s_3 ="selected=selected";
			}
		}
		
	?>
	<input type="hidden" name="rut_director<?=$j;?>" value="<?=$fila_direc['rut_emp'];?>">
	<input type="hidden" name="cargo_director<?=$j;?>" value="<?=$fila_direc['cargo'];?>">
  <tr>
    <td class="subitem Estilo9"><?=$fila_direc['rut_emp']."-".$fila_direc['dig_rut'];?></td>
    <td class="subitem Estilo9">
	<? if($frmModo=="ingresar"){?>
	<select name="cmb_DIRECTIVO<? echo $j;?>">
      <option value="0" selected="selected">Seleccione</option>
      <option value="1">Indefinido</option>
      <option value="2">Plazo Fijo</option>
      <option value="3">Honorarios</option>
    </select>
	<? }elseif($frmModo=="mostrar"){ 
		if($fila_2['tipo_emp']=="0")
			echo "&nbsp;";
		elseif($fila_2['tipo_emp']=="1")
			echo "Indefinido";
		elseif($fila_2['tipo_emp']=="2")
			echo "Plazo Fijo";
		else
			echo "Honorarios";

		}elseif($frmModo=="modificar"){?>
	<select name="cmb_DIRECTIVO<? echo $j;?>">
      <option value="0" <?=$s_0;?>>Seleccione</option>
      <option value="1" <?=$s_1;?>>Indefinido</option>
      <option value="2" <?=$s_2;?>>Plazo Fijo</option>
      <option value="3" <?=$s_3;?>>Honorarios</option>
    </select>
	<?	} ?>
	</td>
    <td class="subitem Estilo9"><?=$fila_direc['nombre'];?></td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="hrs_contrato_d<? echo $j;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_2['hrs_contrato'];
	   }elseif($frmModo=="modificar"){?>
		<input name="hrs_contrato_d<? echo $j;?>" type="text" size="5" value="<?=$fila_2['hrs_contrato'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="amp_simple_d<? echo $j;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_2['amp_simple'];
	   }elseif($frmModo=="modificar"){?>
	   <input name="amp_simple_d<? echo $j;?>" type="text" size="5" value="<?=$fila_2['amp_simple'];?>">
	<? } ?>	
	</td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="total_hrs_d<? echo $j;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_2['total_aula'];
	   }elseif($frmModo=="modificar"){?>
	   <input name="total_hrs_d<? echo $j;?>" type="text" size="5" value="<?=$fila_2['total_aula'];?>">
	<? } ?>	
	</td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="tipo_func_d<? echo $j;?>" type="text">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_2['tipo_func'];
	   }elseif($frmModo=="modificar") {?>
	   <input name="tipo_func_d<? echo $j;?>" type="text" value="<?=$fila_2['tipo_func'];?>">
	<? } ?>
	</td>
  </tr>
  <? } ?>
  <input name="cont_director" type="hidden" value="<?=$j;?>">
  <tr>
    <td colspan="2" class="item Estilo9">TOTALES</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
    <td class="item Estilo9">&nbsp;</td>
  </tr>
</table>
			</p>
		</div>
		<div class="box" id="tabs-3">
			<p><table width="100%" border="1" cellpadding="5" cellspacing="0">
  <tr>
    <td colspan="7" class="item Estilo10"> TECNICO- PEDAGOGICOS </td>
  </tr>
  <tr>
    <td class="item Estilo10">RUT</td>
    <td class="item Estilo10">CALIDAD <br />
    CONTRATO </td>
    <td class="item Estilo10">NOMBRE</td>
    <td class="item Estilo10">HORAS<br />
    CONTRATO</td>
    <td class="item Estilo10">AMPLIACI&Oacute;N<br />
    HORARIA</td>
    <td class="item Estilo10">TOTAL</td>
    <td class="item Estilo10">TIPO<br />
    FUNCI&Oacute;N</td>
  </tr>
  <? for($x=0;$x<@pg_numrows($rs_tecnicos);$x++){
  		$fila_tec = @pg_fetch_array($rs_tecnicos,$x);
		if($frmModo=="modificar" || $frmModo=="mostrar"){
			$sql = " SELECT * FROM dotacion_docente WHERE rdb=".$institucion." AND id_ano=".$ano." AND rut_emp=".$fila_tec['rut_emp']." AND ";
			$sql.= " cargo=".$fila_tec['cargo'];
			$result_d = @pg_exec($conn,$sql);
			$fila_3 = @pg_fetch_array($result_d,0);
			if($fila_3['tipo_emp']==0){
				$s_0 ="selected=selected";
				$s_1 ="&nbsp;";
				$s_2 ="&nbsp;";
				$s_3 ="&nbsp;";
			}elseif($fila_3['tipo_emp']==1){
				$s_0 ="&nbsp;";
				$s_1 ="selected=selected";
				$s_2 ="&nbsp;";
				$s_3 ="&nbsp;";
			}elseif($fila_3['tipo_emp']==2){
				$s_0 ="&nbsp;";
				$s_1 ="&nbsp;";
				$s_2 ="selected=selected";
				$s_3 ="&nbsp;";
			}elseif($fila_3['tipo_emp']==3){
				$s_0 ="&nbsp;";
				$s_1 ="&nbsp;";
				$s_2 ="&nbsp;";
				$s_3 ="selected=selected";
			}
		}
		
  ?>
  <input type="hidden" name="rut_tecnico<?=$x;?>" value="<?=$fila_tec['rut_emp'];?>">
  <input type="hidden" name="cargo_tecnico<?=$x;?>" value="<?=$fila_tec['cargo'];?>">
  <tr>
    <td class="subitem Estilo10"><?=$fila_tec['rut_emp']."-".$fila_tec['dig_rut'];?></td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
	<select name="cmb_TECNICO<? echo $x;?>">
      <option value="0" selected="selected">Seleccione</option>
      <option value="1">Indefinido</option>
      <option value="2">Plazo Fijo</option>
      <option value="3">Honorarios</option>
    </select>
	<? }elseif($frmModo=="mostrar"){ 
		if($fila_3['tipo_emp']=="0")
			echo "&nbsp;";
		elseif($fila_3['tipo_emp']=="1")
			echo "Indefinido";
		elseif($fila_3['tipo_emp']=="2")
			echo "Plazo Fijo";
		else
			echo "Honorarios";

		}elseif($frmModo=="modificar"){?>
	<select name="cmb_TECNICO<? echo $x;?>">
      <option value="0" <?=$s_0;?>>Seleccione</option>
      <option value="1" <?=$s_1;?>>Indefinido</option>
      <option value="2" <?=$s_2;?>>Plazo Fijo</option>
      <option value="3" <?=$s_3;?>>Honorarios</option>
    </select>
	<?	} ?>
	</td>
    <td class="subitem Estilo10"><?=$fila_tec['nombre'];?></td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="hrs_contrato_t<? echo $x;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_3['hrs_contrato'];
	   }elseif($frmModo=="modificar"){?>
	   <input name="hrs_contrato_t<? echo $x;?>" type="text" size="5" value="<?=$fila_3['hrs_contrato'];?>">
	<? } ?>	
	</td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="amp_simple_t<? echo $x;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_3['amp_simple'];
	   }elseif($frmModo=="modificar"){?>
	   <input name="amp_simple_t<? echo $x;?>" type="text" size="5" value="<?=$fila_3['amp_simple'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="total_hrs_t<? echo $x;?>" type="text" size="5">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_3['total_aula'];
	   }elseif($frmModo=="modificar"){?>
	   	<input name="total_hrs_t<? echo $x;?>" type="text" size="5" value="<?=$fila_3['total_aula'];?>">
	<? } ?>
	</td>
    <td class="subitem Estilo10">
	<? if($frmModo=="ingresar"){?>
		<input name="tipo_func_t<? echo $x;?>" type="text">
	<? }elseif($frmModo=="mostrar"){
		echo $fila_3['tipo_func'];
 	   }elseif($frmModo=="modificar"){?>
	   <input name="tipo_func_t<? echo $x;?>" type="text" value="<?=$fila_3['tipo_func'];?>">
	<? }?>
	</td>
  </tr>
  <? } ?>
  <input type="hidden" name="cont_tecnico" value="<?=$x;?>">
  <tr>
    <td colspan="2" class="item Estilo10">TOTALES</td>
    <td class="item Estilo10">&nbsp;</td>
    <td class="item Estilo10">&nbsp;</td>
    <td class="item Estilo10">&nbsp;</td>
    <td class="item Estilo10">&nbsp;</td>
    <td class="item Estilo10">&nbsp;</td>
  </tr>
</table>
			</p>
		
		</div>
	</div>
</div>
</div>
<script type="text/javascript">
	Element.cleanWhitespace('content');
	init();
</script>


</TD>
		  </TR>			
	  </TABLE> 
	</FORM>	
									
									
									<!-- FIN DE INGRESO DE CODIGO NUEVO --> 
																	
															
								  </td>
							    </tr>
							 </table>							  
							</td>  
						  </tr>
                      </table>
					 </td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
                  </table>
		    </td>
         </tr>
       </table>
    </td>

  </tr>
</table>

</td>
    <td width="53" align="left" valign="top" height="100%" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
  </tr>
</table> 
<?
pg_close($conn);
?>
</body>
</html>
