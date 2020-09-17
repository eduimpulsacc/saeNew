<?php require('../../../../../../util/header.inc');?>
<?php 
if ($id_ramo){
$_RAMO=$id_ramo;
if(!session_is_registered('_RAMO')){
session_register('_RAMO');
};
$_FRMMODO="mostrar";
}
if ($modificar){
$_FRMMODO="modificar";
}

if ($viene_de){
$_VIENEPAG=$viene_de;	
}


	
	
$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso			=$_CURSO;
$ramo			=$_RAMO;
$frmModo		=$_FRMMODO;

$docente		=5; //Codigo Docente
$_POSP           =6;
$_bot            = 5;
//	$_MDINAMICO = 1;


	if($_PERIODO==""){
		$periodo	= $cmbPERIODO;
	}
	if($_PERIODO!=""){
		$periodo 	= $_PERIODO;
	}
	if($cmbPERIODO!="0" && $cmbPERIODO!=""){
		$periodo	= $cmbPERIODO;
	}
	
	if(isset($_GET['periodo'])){
		$periodo 	= $_GET['periodo'];
	}
	
//echo "-->.".$periodo;


$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
$result_ano =@pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($result_ano,0);	
$nro_ano = $fila_ano['nro_ano'];

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
$ingreso = 1;
$modifica =1;
$elimina =1;
$ver =1;
}else{

$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
// echo $sql;
$ingreso = @pg_result($rs_permiso,0);
$modifica =@pg_result($rs_permiso,1);
$elimina =@pg_result($rs_permiso,2);
$ver =@pg_result($rs_permiso,3);
}	


if(!isset($_GET['periodo'])){
//if($aux!=1)	{//HACER LA CONSULTA Y DESPLEGAR EL PRIMER PERIODO
	
	$qry="SELECT * FROM quiz_periodos WHERE id_ano=".$ano." ORDER BY NOMBRE_PERIODO";
	
	$result =@pg_Exec($conn,$qry);
		
		if (!$result) 
			error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
		else{
		
			if (pg_numrows($result)!=0){
			
				$fila1 = @pg_fetch_array($result,0);	
				
				if (!$fila1){
				
					error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
					exit();
					
				};
				
				$periodo	= $fila1['id_periodo'];
				$periodo_cerrado = $fila1['cerrado'];
				
			}else{
			
				echo "NO EXISTEN PERIODOS INGRESADOS PARA ESTE AÑO";
				
			}
		};
	}

	$_PERIODORAMO = $periodo;
	if(!session_is_registered('_PERIODORAMO')){
		session_register('_PERIODORAMO');
	};
	

//periodo real
// VERIFICO SI EL PERIODO ESTA CERRADO
	 $q11 = "select * from periodo where cerrado = 0 and id_ano=$ano";
	$r11 = pg_Exec($conn,$q11);
	
	if (pg_num_rows($r11)!=1){
	  echo "<script>alert('Debe Haber solo un (1) periodo abierto')
location.href = '../../../periodo/listarPeriodo.php3';
</script>";
	}else{
	   $f11 = pg_fetch_array($r11,0);
	   $periodo_real = $f11['id_periodo'];
	}   
	
	  $_PERIODOREAL	=	$periodo_real;
	if(!session_is_registered('_PERIODOREAL')){
		session_register('_PERIODOREAL');
	};

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script src="../../../../../clases/jquery/jquery.js"></script>
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


function round(number,X) {
// rounds number to X decimal places, defaults to 2
X = (!X ? 0 : X);
return Math.round(number*Math.pow(10,X))/Math.pow(10,X);
}	

//-->



function enviapag(form){
			if (form.cmbPERIODO.value!=0){
				form.cmbPERIODO.target="self";
//				form.action = form.cmbPERIODO.value;
				form.action = 'examen_quiz.php?aux=1&periodo='+form.cmbPERIODO.value;
				form.submit(true);
				}
			}

/*enviar agregar nota de examen*/
function enviapag2(form){
				form.action = 'procesoExamen.php';
				form.submit(true);
				
			}

/*enviar resultado de examen a las notas*/
function enviapag3(form){
				form.action = 'procesoNotas.php';
				form.submit(true);	
			}
			
function notaExamen(x){
	var id_curso = <?php echo $_CURSO ?>;
	var id_ramo = <?php echo $_RAMO ?>;
	var id_periodo = <?php echo $_PERIODORAMO ?>;
	var rut_alumno =  document.getElementById('rut_Alu['+x+']').value;
	var promedio = document.getElementById('prom_Alu['+x+']').value;
	var examen = document.getElementById('txtExamen['+x+']').value;
	var porc_examen_quiz= $("#porc_examen_quiz").val();
	var nota_exim_quiz= $("#nota_exim_quiz").val();
	var truncado_examen_quiz = $("#truncado_examen_quiz").val();
	
	if(examen==0){
	document.getElementById('txtExamen['+x+']').value="";			
	}
	if(examen <0 || examen >70){
	alert ("Formato de nota invalido");
	document.getElementById('txtExamen['+x+']').value="";
	document.getElementById('txtExamen['+x+']').focus();
	document.getElementById('txt_p_final['+x+']').innerHTML = "";
	document.getElementById('p_final['+x+']').value = 0;
	}
	
	else{
	
	var parametros = "id_curso="+id_curso+"&id_ramo="+id_ramo+"&id_periodo="+id_periodo+"&rut_alumno="+rut_alumno+"&promedio="+promedio+"&examen="+examen+"&porc_examen_quiz="+porc_examen_quiz+"&nota_exim_quiz="+nota_exim_quiz+"&truncado_examen_quiz="+truncado_examen_quiz;
	
	$.ajax({
			url:"calculaPromedio.php",
			data:parametros,
			type:'POST',
			success:function(data){	
			 document.getElementById('txt_p_final['+x+']').innerHTML = data;
			 document.getElementById('p_final['+x+']').value = data;
			 
			}
     })
	
	}//validacion si nota es valida
}

 function soloNumeross(e){
	var key = window.Event ? e.which : e.keyCode
	alert(key);
	return (key >= 48 && key <= 57)
}
      //-->

</script>
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../../util/chkform.js"></SCRIPT>

</head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
<td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
<? include("../../../../../../cabecera/menu_superior.php"); ?>
</td>
</tr>
<tr align="left" valign="top"> 
<td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td width="27%" height="363" align="left" valign="top">
<? $menu_lateral="3_1";?> 
<? include("../../../../../../menus/menu_lateral.php"); ?></td>
<td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td height="395" align="left" valign="top"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
<tr> 
<td height="390" valign="top">
<FORM method=post name="frm" >
<TABLE WIDTH=800 BORDER=0 CELLSPACING=0 CELLPADDING=0 align=center>
<TR>
<TD><TABLE BORDER=0 CELLSPACING=1 CELLPADDING=1 height="100%">
<TR>
<TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>A&Ntilde;O ESCOLAR</strong> </FONT> </TD>
<TD><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
<TD><FONT face="arial, geneva, helvetica" size=2> <strong>
<?php
$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
$result =@pg_Exec($conn,$qry);
if (!$result) {
error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
}else{
if (pg_numrows($result)!=0){
$fila1 = @pg_fetch_array($result,0);	
if (!$fila1){
error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
exit();
}
echo trim($fila1['nro_ano']);
}
}
?>
</strong> </FONT> </TD>
</TR>
<TR>
<TD align=left><FONT face="arial, geneva, helvetica" size=2> <strong>CURSO</strong> </FONT> </TD>
<TD><FONT face="arial, geneva, helvetica" size=2> <strong>:</strong> </FONT> </TD>
<TD><FONT face="arial, geneva, helvetica" size=2> <strong>
<?php
$qry="SELECT curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
$result =@pg_Exec($conn,$qry);
if (!$result) {
error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>'.$qry);
}else{
if (pg_numrows($result)!=0){
$fila1 = @pg_fetch_array($result,0);	
if (!$fila1){
error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
exit();
}
echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo']);
}
}

?>
</strong> </FONT> </TD>
</TR>
<TR>
  <TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>ASIGNATURA</FONT> </strong></TD>
  <TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>: </FONT> </strong></TD>
  <TD align=left><font face="arial, geneva, helvetica" size=2><strong>
  <?php
$qry="SELECT subsector.nombre, ramo.conexquiz, ramo.nota_exim_quiz,ramo.modo_eval,ramo.truncado_examen_quiz, ramo.porc_examen_quiz FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
$result =@pg_Exec($conn,$qry)or die("Fallo 1 ".$qry);
if (@pg_numrows($result)!=0){
$fila2 = @pg_fetch_array($result,0);
$exim = $fila2['nota_exim_quiz'];
$modo_eval = $fila2['modo_eval'];
$truncado_ramo = $fila2['truncado_examen_quiz'];
$porc_examen_quiz = $fila2['porc_examen_quiz'];

 trim($fila2['nombre']);
 $conexper=$fila2['conexquiz'];

}
?>
<?php echo trim($fila2['nombre']);  ?> </strong> </font></TD>
</TR>
<TR>
  <TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>PERIODO QUIZ</FONT> </strong></TD>
  <TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>:</FONT> </strong></TD>
  <TD align=left>
  <input type="hidden" name="nota_exim_quiz" id="nota_exim_quiz" value="<?php echo $exim ?>">
  <input type="hidden" name="porc_examen_quiz" id="porc_examen_quiz" value="<?php echo $porc_examen_quiz ?>">
  <input type="hidden" name="truncado_examen_quiz" id="truncado_examen_quiz" value="<?php echo $truncado_ramo ?>">
  
  
   <select name="cmbPERIODO"  onChange="enviapag(this.form)" class="input">
		<?php
		$qry="SELECT periodo.id_periodo, periodo.nombre_periodo FROM quiz_periodos periodo WHERE (((periodo.id_ano)=".$ano."))  order by id_periodo";
				$result =@pg_Exec($conn,$qry);
				if(!$result){ 
					error('<B> ERROR :</b>Error al acceder a la BD. (74)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila1 = @pg_fetch_array($result,0);	
							if (!$fila1){
								error('<B> ERROR :</b>Error al acceder a la BD. (84)</B>');
								exit();
							  };
								for($i=0 ; $i < @pg_numrows($result) ; $i++){
													$fila1 = @pg_fetch_array($result,$i);
								if(($fila1['id_periodo']==$periodo) || $fila1['id_periodo']==$_GET['periodo'] ){
				echo  "<option value=".$fila1["id_periodo"]." selected>".$fila1["nombre_periodo"]."</option>";
										}else{
				echo  "<option value=".$fila1["id_periodo"].">".$fila1["nombre_periodo"]."</option>";
										}
								}
							}
					}
			?>
			</select>
            </form></TD>
</TR>
</TABLE></TD>
</TR>
<TR height=15>
<TD><TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
<TR height="50">
<TD align=right>&nbsp;</TD>
</TR>
<TR height=20 >
<TD align=center class="nombre_campo"><strong>EXAMEN PERIODO QUIZ</strong></TD>
</TR>
<TR height=20 >
  <TD align=center class="nombre_campo">&nbsp;</TD>
</TR>
<TR height=20 >
  <TD align=left class="nombre_campo">INSTRUCCIONES: CADA VEZ QUE SE REQUIERA REPROCESAR LOS PROMEDIOS, DEBE HACER CLIC EN EL BOTON "MODIFICAR" Y POSTERIORMENTE EN EL BOTON "GUARDAR"</TD>
</TR>
<TR height="50">
<TD align=right><input type="hidden" name="modo">

<?php if($frmModo=="mostrar"){ ?>
<?			if($ingreso==1 || $modifica==1){?>
<input name="modificar" type="button" id="modificar" value="MODIFICAR" class="botonXX"  onclick="window.location='examen_quiz.php?caso=3&modificar=1&periodo=<?=$periodo;?>'"/>
<INPUT class="botonXX"  TYPE="button" value="PROCESAR" name=btnGuardar onClick="return enviapag3(this.form);">
<?			}	?>

<?php } ?>
<?php if ($frmModo=="modificar"){ ?>
<INPUT class="botonXX"  TYPE="button" value="GUARDAR" name=btnGuardar onClick="return enviapag2(this.form);">
<!--<INPUT class="botonXX"  TYPE="button" value="PROCESAR" name=btnGuardar onClick="return enviapag3(this.form);">-->
<?php } ?> <INPUT class="botonXX" name="button3" TYPE="button" onClick=document.location="<? echo $_VIENEPAG;?>" value="VOLVER">                                             </TD>
</TR>


<TR>
<TD><TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
<TR>
<TD><table border=1 cellspacing=2 cellpadding=2 width=100%>
<tr>
<td colspan=45 align="center" class="fondo">NOTAS</td>
</tr>
<tr class="tablatit2-1">
<td width="50%">ALUMNOS</td>
<td width="11%"align="center">PROM. PERIODO</td>

<td width="11%"align="center">EXAMEN</td>

<!--<td width="12%"align="center">PRUEBA ESPECIAL</td>
--><td width="16%"align="center">PROMEDIO FINAL</td>
<!--TD>PC</TD-->
</tr>
<?php

//ALUMNOS DEL CURSO
//$qry="SELECT tiene$nro_ano.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno)   WHERE (((tiene$nro_ano.id_ramo)=".$ramo.") AND((tiene$nro_ano.id_curso)=".$curso.")) and tiene$nro_ano.rut_alumno in (select rut_alumno from matricula where matricula.id_curso = '$curso' and matricula.bool_ar='0') order by ape_pat, ape_mat, nombre_alu asc ";
$qry = "SELECT t.rut_alumno, a.dig_rut, a.nombre_alu, a.ape_pat, a.ape_mat, nro_lista
FROM alumno a  INNER JOIN tiene$nro_ano t ON a.rut_alumno = t.rut_alumno
INNER JOIN matricula m ON m.rut_alumno=a.rut_alumno AND 
(m.rut_alumno=t.rut_alumno AND m.id_curso=t.id_curso)
WHERE m.id_curso=".$curso." AND bool_ar='0' and t.id_ramo=".$ramo."
ORDER BY 6";

$result =pg_Exec($conn,$qry);

//if($_PERFIL==0){echo $qry;}

for($i=0 ; $i < pg_numrows($result) ; $i++){
$fila1 = pg_fetch_array($result,$i);
$div =0;
$cont=$i;

/*promedio*/

 $sql_prom = "select promedio from quiz_notas where id_periodo = $periodo and id_ramo = $_RAMO and rut_alumno=".$fila1["rut_alumno"];
$result_prom =pg_Exec($conn,$sql_prom);
$fila_prom = pg_fetch_array($result_prom,0);

/*notas examen*/
$sql_nexamen = "select promedio,examen,promedio_final from quiz_examen where id_periodo = $periodo and id_ramo = $_RAMO and rut_alumno=".$fila1["rut_alumno"];
$result_nexamen =pg_Exec($conn,$sql_nexamen);
$fila_nexamen = pg_fetch_array($result_nexamen,0);

?>
<tr onMouseOver=this.style.background='yellow';this.style.cursor='cursor' onMouseOut=this.style.background='transparent'>
<td class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">   <input name="rut_Alu[<?php echo $cont ?>]" id="rut_Alu[<?php echo $cont ?>]" type="hidden" value="<?php echo $fila1["rut_alumno"]?>">                                                            <?php echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];?> </td>
<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">
<input name="prom_Alu<?php echo $cont ?>" id="prom_Alu[<?php echo $cont ?>]" type="hidden" value="<?php echo intval($fila_prom['promedio'])?>">
<?php echo intval($fila_prom['promedio']) ?></td>

<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">
<div align="center">
<?php if($_FRMMODO=="modificar"){?>
	<input name="txtExamen<?php echo $cont ?>"  id="txtExamen[<?php echo $cont ?>]" type="text" size="5" <?php if($exim<=intval($fila_prom['promedio'])){?> 
    readonly="readonly" style="background-color:#999999"
    value="<?php echo intval($fila_prom['promedio'])?>"
    
     <?php }
    else{?>
    onChange="notaExamen(<?php echo $cont ?>)" 
    value="<?php echo intval($fila_nexamen['examen'])?>"  
    onBlur="notaExamen(<?php echo $cont ?>)"
    onfocus="notaExamen(<?php echo $cont ?>)"
     
 <? }?>
 >
  <!-- onKeyPress="return soloNumeross(event)"-->
<?php }else{?>
<?php echo intval($fila_nexamen['examen']); ?>
<?php  } ?>


</div>
</td>
<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">


<?php if($exim<=intval($fila_prom['promedio'])){
	$val = intval($fila_prom['promedio']);
} 
else{
	$val = intval($fila_nexamen['promedio_final']);
}
?>
<div align="center" id="txt_p_final[<?php echo $cont ?>]">
<?php echo $val ?></div>

<input name="p_final<?php echo $cont ?>" id="p_final[<?php echo $cont ?>]" type="hidden" value="<?php echo $val?>">

</td>
</tr>
<?php }?>
<input name="contadori" type="hidden" value="<?=$i;?>" >
</table></TD>
</TR>
</TABLE></TD>
</TR>
<TR>
<TD colspan=4><TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
<TR>
<TD><HR width="100%" color=#003b85>                                                    </TD>
</TR>
</TABLE></TD>
</TR>
</TABLE></TD>
</TR>
</TABLE>
</FORM>


<? pg_close($conn);?>
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
