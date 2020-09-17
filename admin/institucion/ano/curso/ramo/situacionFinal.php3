<?php require('../../../../../util/header.inc');?>
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

if ($eliminar){
$_FRMMODO="eliminar";
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
/*if($nw==1){
$_MENU =$menu;
session_register('_MENU');
$_CATEGORIA = $categoria;
session_register('_CATEGORIA');
}*/
$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
// echo $sql;
$ingreso = @pg_result($rs_permiso,0);
$modifica =@pg_result($rs_permiso,1);
$elimina =@pg_result($rs_permiso,2);
$ver =@pg_result($rs_permiso,3);
}	


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

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


function rst() {
   if(confirm("Seguro que desea eliminar los datos?")){
	//alert("si");
	//document.location="situacionFinal.php3?caso=9&eliminar=1"
	
	$.ajax({
				url:"eliminaSituacionFinal.php",
				data:"frmModo=eliminar&ramo="+<?php echo $ramo ?>,
				type:'POST',
				success:function(data){
				//$('#lista').html(data);
				//console.log(data);
				if(data==1)
				{alert("Datos eliminados correctamente")
				window.location.reload();
				}
		  }
		})
	}
	
}

//-->
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

</head>


<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
<td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
<td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
<? include("../../../../../cabecera/menu_superior.php"); ?>
</td>
</tr>
<tr align="left" valign="top"> 
<td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td width="27%" height="363" align="left" valign="top">
<? $menu_lateral="3_1";?> 
<? include("../../../../../menus/menu_lateral.php"); ?></td>
<td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr> 
<td height="395" align="left" valign="top"> 
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
<tr> 
<td height="390" valign="top">
<FORM method=post name="frm" action="procesoSituacionFinal.php3">
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
<TD align=left><font face="arial, geneva, helvetica" size=2><strong>PLAN DE ESTUDIO</strong></font></TD>
<TD align=left><font face="arial, geneva, helvetica" size=2><strong>:</strong></font></TD>
<TD align=left><font face="arial, geneva, helvetica" size=2><strong>
<?php
$qry4="SELECT curso.truncado_per, curso.id_curso,curso.cod_decreto, plan_estudio.nombre_decreto FROM curso INNER JOIN plan_estudio ON curso.cod_decreto = plan_estudio.cod_decreto WHERE (((curso.id_curso)=".$curso."))";
$result4 =@pg_Exec($conn,$qry4);
$fila4= @pg_fetch_array($result4,0);
echo trim($fila4['nombre_decreto']);
$truncado_per = $fila4['truncado_per'];
//echo $truncado_per." ".truncado_per;
?>
</strong></font></TD>
</TR>
<TR>
<TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>ASIGNATURA</FONT> </strong></TD>
<TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>: </FONT> </strong></TD>
<TD align=left><strong>
<?php
$qry="SELECT subsector.nombre, ramo.conex, ramo.pct_examen, nota_exim, ramo.pct_ex_escrito,ramo.pct_ex_oral,ramo.modo_eval, ramo.conexper, ramo.truncado_per FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE (((ramo.id_ramo)=".$ramo."))";
$result =@pg_Exec($conn,$qry)or die("Fallo 1 ".$qry);
if (@pg_numrows($result)!=0){
$fila2 = @pg_fetch_array($result,0);
$exim = $fila2['nota_exim'];
$modo_eval = $fila2['modo_eval'];
$truncado_ramo = $fila2['truncado_per'];
echo trim($fila2['nombre']);
$pct_examen = $fila2['pct_ex_escrito'];
 $conexper=$fila2['conexper'];
if($pct_examen!="0"){
$examen = 1;	
}
}
?>
</strong> </TD>
</TR>
</TABLE></TD>
</TR>
<TR height=15>
<TD><TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
<TR height="50">
<TD align=right><input type="hidden" name="modo">
<?php if($frmModo=="mostrar"){ ?>
<input class="botonXX"  name="button1" type="button" onClick="rst()" value="RESETEAR">
<?			if($ingreso==1 || $modifica==1){?>
<input class="botonXX"  name="button1" type="button" onClick=document.location="situacionFinal.php3?caso=3&modificar=1" value="MODIFICAR">
<?			}	?>
<INPUT class="botonXX" name="button3" TYPE="button" onClick=document.location="<? echo $_VIENEPAG;?>" value="VOLVER">
<?php } ?>
<?php if ($frmModo=="modificar"){ ?>
<INPUT class="botonXX"  TYPE="submit" value="GUARDAR" name=btnGuardar onClick="return valida(this.form)?;">
<INPUT class="botonXX"  name="button3" TYPE="button" onClick=document.location="situacionFinal.php3?id_ramo=<? echo $_RAMO;?>" value="VOLVER">
<?php } ?>                                              </TD>
</TR>
<TR height=20 >
<TD align=center class="nombre_campo"><strong>SITUACION FINAL DE LA ASIGNATURA</strong></TD>
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
<td width="11%"align="center">PROM. GRAL.</td>
<? if($examen==1){?>
<td width="11%"align="center">EXAMEN ESCRITO</td>
<td width="11%"align="center">EXAMEN ORAL</td>
<? }else{?>
<td width="11%"align="center">EXAMEN</td>
<? } ?>
<!--<td width="12%"align="center">PRUEBA ESPECIAL</td>
--><td width="16%"align="center">PROMEDIO FINAL</td>
<!--TD>PC</TD-->
</tr>
<?php
if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR

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

$qry5="select count(promedio) as sum from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." and id_ramo=".$ramo." and promedio >'0'";
$result5 =pg_Exec($conn,$qry5); 
$fila5= @pg_fetch_array($result5,0); 
$div = $div + $fila5['sum'];

$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
$result6 =pg_Exec($conn,$qry6);
$promedi =0;
for($j=0 ; $j < pg_numrows($result6) ; $j++){
$fila6 = pg_fetch_array($result6,$j);
$prome =0;
/*********************AQUI*************************/
$qsl="select * from ramo where id_ramo=".$ramo;
$resultc =pg_Exec($conn,$qsl);
$filac = pg_fetch_array($resultc,$qsl);
$conexper= $filac['conexper'];

if ($conexper==1){
$qry8="select sp.id_periodo,sp.rut_alumno,sp.nota_final,sp.nota_examen,sp.prom_gral, r.conexper from situacion_periodo as sp   inner
JOIN ramo as r on r.id_ramo = sp.id_ramo where sp.RUT_ALUMNO=".$fila1['rut_alumno']." AND sp.ID_PERIODO=".$fila6['id_periodo']." and sp.id_ramo=".$ramo." and r.conexper=1";
	
$result8 = pg_Exec($conn,$qry8)or die("Fallo ".qry8 );
for($k=0 ; $k < pg_numrows($result8) ; $k++){
$fila8= pg_fetch_array($result8,$k);
$promed = $fila8['nota_final'];
$prome =($prome + $promed);
};
$promedi = $promedi + $prome;
}else{

$qry8="select promedio from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$fila6['id_periodo']." and id_ramo=".$ramo." and promedio >'0'";

$result8 =pg_Exec($conn,$qry8);
for($k=0 ; $k < pg_numrows($result8) ; $k++){
$fila8= @pg_fetch_array($result8,$k);
$promed = $fila8['promedio'];
$prome =($prome + $promed);
};
$promedi = $promedi + $prome;
}
};

?>
<tr onMouseOver=this.style.background='yellow';this.style.cursor='cursor' onMouseOut=this.style.background='transparent'>
<td class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">                                                            <input name="rut_Alu[<?php echo $cont ?>]" type="hidden" value="<?php echo $fila1["rut_alumno"]?>">                                                            <?php echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];?> </td>
<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">&nbsp;
<?php 
if ($div!=0) {	
/*if ($_PERFIL==0){
echo "promedi: $promedi <br>";
echo "div: $div <br>";
echo "truncado_per: <br><br>";
}	*/	
if ($_INSTIT==9566 and $modo_eval==3){     // especial para claretiano subsector religion, modo de evaluacion 3 examen numerico
if ($modo_eval==3){
/// debo recalcular los promedios para traerlo a numérico
// ya que las notas son numericos y el promedio conceptual

$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) ORDER BY periodo.id_periodo";
$result6 =pg_Exec($conn,$qry6);
$suma_promedio = 0;
$contador_promedio = 0;
for($j=0 ; $j < pg_numrows($result6) ; $j++){
$fila6 = pg_fetch_array($result6,$j);

$qry8="select * from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$fila6['id_periodo']." and id_ramo=".$ramo;
$result8 =pg_Exec($conn,$qry8);

for($k=0; $k < pg_numrows($result8) ; $k++){
$fila8= @pg_fetch_array($result8,$k);
/// tomo todas las notas de la 1 a la 20
$suma_notas = 0;
$contador_notas = 0;
for ($jj=1; $jj < 21; $jj++){
$nota = $fila8['nota'.$jj];
	
if ($nota>0){
$suma_notas =  $suma_notas +  $nota;
$contador_notas++;
}
}
/// promediar
if ($truncado_ramo == 1){
// no aproximo
$promedio_ramo = ($suma_notas / $contador_notas);
$promedio_ramo = substr($promedio_ramo,0,2); 
}else{
/// si aproximo
$promedio_ramo = @round($suma_notas/$contador_notas);																			 

}																																									
}
$suma_promedio = $suma_promedio + $promedio_ramo;
$contador_promedio++;

}


}
$promedio_general = ($suma_promedio/$contador_promedio);
$promedio_general = substr($promedio_general,0,2);								

}	   	

if ($_INSTIT==9566 and $modo_eval==3){
echo $promedio_general;
$res = $promedio_general;
$gen = $gen +$res;
$divisor= $divisor + 1;


?>
<input name="prom[<?php echo $cont ?>]" type="hidden" value="<?=$promedio_general ?>">
<?																		
}else{	
if($institucion == 15707){
	$resp2 = PromediarSolo($promedi,$div);	
	$trp = ($exim <= $resp2)?1:0;
}else{
	$trp = $truncado_per;
}

																						
$res = Promediar($promedi,$div,$trp);
imp ($res);
$gen = $gen +$res;
?>
<input name="prom[<?php echo $cont ?>]" type="hidden" value="<?php echo round($res)?>">
<?
}
}
if ($promedi !=0){
$divisor= $divisor + 1;
}

?>
<?php 

$qry9="SELECT * FROM situacion_final WHERE (((situacion_final.rut_alumno)='".$fila1['rut_alumno']."') AND((situacion_final.id_ramo)=".$ramo.")) ";
$result9 =pg_Exec($conn,$qry9);
if (pg_numrows($result9)!=0){
$fila9 = pg_fetch_array($result9,0);
}
?>                                                          </td>
<? if($examen!="1"){?>
<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>"><div align="center">&nbsp;
<?php 
/*  $qry7="SELECT count(tiene3.rut_alumno)as suma FROM (alumno INNER JOIN tiene3 ON alumno.rut_alumno = tiene3.rut_alumno)   WHERE (((tiene3.id_ramo)=".$ramo.") AND((tiene3.id_curso)=".$curso.")) ";
$result7 =pg_Exec($conn,$qry7);
$fila7 = pg_fetch_array($result7,0);*/
$contalum = pg_numrows($result);

?>
<?php if ($frmModo=="modificar"){ ?>
<input type="hidden" name="contalum" value="<?php echo $contalum ?>">
<?php if (($exim)<=(round($res))){
echo "EXIM";
}else{ ?>
<input name="txtExamen[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['nota_examen'] ?>">
<?php 	 }									
}?>
<?php if ($frmModo=="mostrar"){
if (($exim)<=(round($res))){
echo "EXIM";
}else{
echo $fila9['nota_examen'];
}
}?>
</div></td>
<? }else{ 
$contalum = pg_numrows($result);
if ($frmModo=="modificar"){?>
<td class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>"><div align="center">
<?php if (($exim)<=(round($res))){
echo "EXIM";
}else{ ?>
<input name="txtExamenEsc[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['nota_exam_esc'] ?>">
<? } ?>
</div></td>
<td class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>"><div align="center">
<?php if ((40)<=($fila9['nota_final'])&&($fila9['nota_exam_oral']==0)){
echo "EXIM";
}elseif($fila9['nota_exam_esc']==""){ 
echo "&nbsp;";?>
<? }else{?>
<input name="txtExamenOral[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['nota_exam_oral'] ?>">
<?  }?>
</div></td>
<? 	}
if ($frmModo=="mostrar"){?>
<td class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>"><div align="center">
<?php if (($exim)<=(round($res))){
echo "EXIM";
}else{ ?>
<? echo $fila9['nota_exam_esc']; ?>&nbsp;
<? } ?>
</div></td>
<td class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>"><div align="center">
<?php if ((40)<=($fila9['nota_final'])&&($fila9['nota_exam_oral']==0)){
echo "EXIM";
}else{ ?>
<? echo $fila9['nota_exam_oral']; ?>&nbsp;
<? } ?>
</div></td>
<? 						     
}
} ?>

<?php if (($frmModo=="modificar")||($frmModo=="mostrar")){ ?>
<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">&nbsp;<?php     $notafinal = $fila9['nota_final']; 
	
	if($fila9['prueba_especial'] > $notafinal and $fila9['prueba_especial'] >=40 ){
		
		$notafinal=40;
		}
		
	if($fila9['prueba_especial'] > $res and $fila9['prueba_especial'] < 40){
	$notafinal=	$fila9['prueba_especial'];
	}	
	


	echo $notafinal;
	$notfinal=$notfinal+$notafinal;
	if ($notfinal >=0){
$divisor2= $divisor2 + 1;

}

?> </td>

<?php
} 

}
}
}

?>
<tr height=5 bgcolor=black>
<td colspan=41></td>
</tr>
<tr> </tr>
<tr height=20>
<td colspan=40></td>
</tr>
<tr>
<td width ="50%" class="tabla04">PROMEDIO DEL CURSO</td>
<td width="11%"align="center" class="tabla04"><?php 
if($divisor >0 ){
echo (round($gen/$divisor));
}							
?>                                                          </td>
<input type="hidden" name=cont value=<?php echo $cont ?>>
<td width="11%"align="center" class="tabla04">&nbsp;</td>
<td width="12%"align="center" class="tabla04"><?php
        if($divisor2 >0 ){
         echo (round($notfinal/$divisor2));
		 
        }							
        ?></td>
</tr>
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
<!--codigo antiguo inicio-->








<!--fin codigo antiguo--></td>
</tr>
</table></td>
</tr>
</table></td>
</tr>
<tr align="center" valign="middle"> 
<td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
</tr>
</table></td>
</tr>
</table>
</td>
<td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
</tr>
</table></td>
</tr>
</table>
</body>
</html>
