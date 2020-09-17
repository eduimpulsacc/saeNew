<?php

require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
 	$ramo			=$_RAMO;
	$frmModo		=$_FRMMODO;
	
	if ($viene_de){
		$_VIENEPAG=$viene_de;	
	}
	if($_PERIODO==""){
		$periodo	= $cmbPERIODO;
	}
	if($_PERIODO!=""){
		$periodo 	= $_PERIODO;
	}
	if($cmbPERIODO!="0" && $cmbPERIODO!=""){
		$periodo	= $cmbPERIODO;
	}
	
	session_unregister($_CASO);
	$_CASO="";
	
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
	$docente		=5; //Codigo Docente
	$_POSP           =5;
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

//-->
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script type="text/javascript">
function enviapag(form){
	if(document.frm.cmbPERIODO.value!=0){
		frm.action='situacionFinalPeriodo.php?id_ramo=<?=$ramo;?>';
		frm.submit(true);
	}
}
</script>
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
<FORM method=post name="frm" action="procesoSituacionFinalPeriodo.php">
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
<TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>SUBSECTOR</FONT> </strong></TD>
<TD align=left><strong><FONT face="arial, geneva, helvetica" size=2>: </FONT> </strong></TD>
<TD align=left><strong>
<?php
$qry="SELECT subsector.nombre, ramo.conex, ramo.pct_examen, ramo.nota_exim,nota_ex_semestral, ramo.pct_ex_escrito,ramo.pct_ex_oral,ramo.modo_eval, ramo.truncado_per, ramo.bool_pu, ramo.porc_nota_pu, ramo.truncado_pu FROM ramo INNER JOIN subsector ON ramo.cod_subsector = subsector.cod_subsector WHERE ramo.id_ramo=".$ramo.";";
$result =@pg_Exec($conn,$qry)or die("Fallo :".$qry);
if (@pg_numrows($result)!=0){
$fila1 = @pg_fetch_array($result,0);
$exim = $fila1['nota_ex_semestral'];
$modo_eval = $fila1['modo_eval'];
$truncado_ramo = $fila1['truncado_per'];
echo trim($fila1['nombre']);
$pct_examen = $fila1['pct_ex_escrito'];
if($pct_examen!="0"){
$examen = 1;	
}
$bool_pu = $fila1['bool_pu'];
$porc_notas_pu = $fila1['porc_nota_pu'];
}
?>
</strong> </TD>
</TR>
<tr>
<td class="textonegrita">PERIODO</td>
<td class="textonegrita">:</td>
<td class="Estilo12">
<select name="cmbPERIODO" class="ddlb_x" onChange="enviapag(this.value)">
<option value="0">seleccione</option>
<? $sql = "SELECT nombre_periodo,id_periodo FROM periodo WHERE id_ano=".$ano;
$rs_periodo = @pg_exec($conn,$sql)or die("Fallo :".$sql);
for($i=0;$i<@pg_numrows($rs_periodo);$i++){
$fila_per = @pg_fetch_array($rs_periodo,$i); 
if($fila_per['id_periodo']==$periodo){?>
<option value="<?=$fila_per['id_periodo'];?>" selected="selected"><?=$fila_per['nombre_periodo'];?></option>
<? }else{?>
<option value="<?=$fila_per['id_periodo'];?>"><?=$fila_per['nombre_periodo'];?></option>
<? 	}	
}?>			

</select>
</td>
</tr>
</TABLE></TD>
</TR>
<TR height=15>
<TD><TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
<TR height="50">
<TD align=right><?php //echo $bool_pu ?><input type="hidden" name="modo">
<?php if($frmModo=="mostrar"){ ?>
<?			if($ingreso==1 || $modifica==1){?>
<input class="botonXX"  name="button1" type="button" value="MODIFICAR" onClick="window.location='seteaSituacionFinalPeriodo.php?caso=3&periodo=<?=$periodo;?>'" >
<?	}	?>
<INPUT class="botonXX" name="button3" TYPE="button" onClick="window.location='listarRamos.php3'" value="VOLVER">
<?php } ?>
<?php if ($frmModo=="modificar"){ ?>
<input name="guardar" type="submit" value="GUARDAR" class="botonXX" />
<INPUT class="botonXX"  name="button3" TYPE="button" onClick=document.location="situacionFinalPeriodo.php?id_ramo=<? echo $_RAMO;?>" value="VOLVER">
<?php } ?>                                              </TD>
</TR>
<TR height=20 >
<TD align=center class="nombre_campo"><strong>SITUACION FINAL DEL SUBSECTOR POR PERIODO</strong></TD>
</TR>
<TR>
<TD><TABLE WIDTH="100%" BORDER=0 CELLSPACING=5 CELLPADDING=5 height="100%">
<TR>
<TD><table border=1 cellspacing=2 cellpadding=2 width=100%>
<tr>
<td colspan=45 align="center" class="fondo">NOTAS</td>
</tr>
<tr class="tablatit2-1">
<td width="47%">ALUMNOS</td>
<td width="20%"align="center">PROM. GRAL.</td>
<td width="14%"align="center">EXAMEN</td>
<td width="19%"align="center">PROMEDIO FINAL</td>
<!--TD>PC</TD-->
</tr>
<?php
if(($_PERFIL!=2)&&($_PERFIL!=4)){ //ACADEMICO Y LEGAL
if(($_PERFIL!=3)&&($_PERFIL!=5)){ //FINANCIERO Y  CONTADOR
									      
if (isset($periodo)){ 
//ALUMNOS DEL CURSO
$qry="SELECT tiene$nro_ano.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat FROM (alumno INNER JOIN tiene$nro_ano ON alumno.rut_alumno = tiene$nro_ano.rut_alumno)   WHERE (((tiene$nro_ano.id_ramo)=".$ramo.") AND((tiene$nro_ano.id_curso)=".$curso.")) and tiene$nro_ano.rut_alumno in (select rut_alumno from matricula where matricula.id_curso = '$curso' and matricula.bool_ar='0') order by ape_pat, ape_mat, nombre_alu asc ";
$result =pg_Exec($conn,$qry);

for($i=0 ; $i < pg_numrows($result) ; $i++){
$fila1 = pg_fetch_array($result,$i);
$div =0;
$cont=$i;


$qry5="select count(promedio) as sum from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." and id_ramo=".$ramo."  AND id_periodo=".$periodo." and promedio >'0'";
$result5 =pg_Exec($conn,$qry5); 
$fila5= @pg_fetch_array($result5,0); 
 $div = $div + $fila5['sum'];

/*echo "<br>".$qry6="SELECT periodo.id_periodo, periodo.nombre_periodo FROM periodo WHERE (((periodo.id_ano)=".$ano.")) and id_periodo=".$periodo." ORDER BY periodo.id_periodo";
$result6 =pg_Exec($conn,$qry6);
$promedi =0;
for($j=0 ; $j < pg_numrows($result6) ; $j++){
$fila6 = pg_fetch_array($result6,$j);
$prome =0;
*/
if (isset($periodo)){
	if(intval($bool_pu)==0){
	 $qry8="select promedio from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$periodo." and id_ramo=".$ramo." and id_periodo=".$periodo.";";
	 $result8 =pg_Exec($conn,$qry8)or die("Fallo q ".qry8);
	}else{
		
		$sql="select promedio from pu_notas where RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$periodo." and id_ramo=".$ramo." and id_periodo=".$periodo." ";
		$rs_pu = pg_exec($conn,$sql);
		$sql="select promedio from notas$nro_ano where RUT_ALUMNO=".$fila1['rut_alumno']." AND ID_PERIODO=".$periodo." and id_ramo=".$ramo." and id_periodo=".$periodo;
		$rs_notas =pg_exec($conn,$sql)or die("Fallo q ".$sql);
		$prom_notas = pg_result($rs_notas,0);
		$prom_pu = pg_result($rs_pu,0);
		$proc_notas = 100 - $porc_notas_pu;
		if($fila1['truncado_pu']==1){
			$promedio_pu = round((($prom_notas * $proc_notas)/100) + ($prom_pu * $porc_notas_pu) /100);
		}else{
			$promedio_pu = intval((($prom_notas * $proc_notas)/100) + ($prom_pu * $porc_notas_pu) /100);
		}
}


for($k=0 ; $k < pg_numrows($result8) ; $k++){
	$fila8= @pg_fetch_array($result8,$k);
	if($institucion==10026){
		$promedi = $fila8['promedio'] / 10;
	}else{
		$promedi = $fila8['promedio'];
	}
     $prome =($prome + $promedi);
	 
	
}

};

/*echo $promedi = ($promedi + $prome);

};
*/
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

$suma_promedio = $suma_promedio + $promedio_ramo;
$contador_promedio++;

$promedio_general = ($suma_promedio/$contador_promedio);
$promedio_general = substr($promedio_general,0,2);								
	
?>
<tr onMouseOver=this.style.background='yellow';this.style.cursor='cursor' onMouseOut=this.style.background='transparent'>
<td class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>"><input name="rut_Alu[<?php echo $cont ?>]" type="hidden" value="<?php echo $fila1["rut_alumno"]?>">
<?php echo  $fila1["ape_pat"]." ".$fila1["ape_mat"].", ".$fila1["nombre_alu"];?>

</td>
<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">&nbsp;
 
<?
if (isset($periodo)){ 
	$qry9="SELECT * FROM situacion_periodo WHERE situacion_periodo.rut_alumno='".$fila1['rut_alumno']."' AND situacion_periodo.id_ramo=".$ramo." AND situacion_periodo.id_periodo=".$periodo.";";
	$result9 =pg_Exec($conn,$qry9)or die("Fallo :".$qry9);
	if (pg_numrows($result9)!=0){
		$fila9 = pg_fetch_array($result9,0);
	}
}

?>
<div align="center">

<? 
if(intval($bool_pu)==1){
	$prom_presentacion = $promedio_pu;
}else{
	$prom_presentacion = $fila8['promedio'];
}
if($prom_presentacion==0){ 
	echo "--"; 
}else{
	echo $prom_presentacion;?>
	<input name="prom[<?php echo $cont ?>]" type="hidden" value="<?=$prom_presentacion;?>" />
<? } ?>
</div>

<? 

$res = Promediar($promedi,$div,$truncado_per);
 
 $gen = $gen + $promedi;

if ($promedi >=0){
$divisor= $divisor + 1;

}



?>

</td>
<?
$contalum = pg_numrows($result);

?>

<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>"><div align="center">&nbsp;
<?php 
/*  $qry7="SELECT count(tiene3.rut_alumno)as suma FROM (alumno INNER JOIN tiene3 ON alumno.rut_alumno = tiene3.rut_alumno)   WHERE (((tiene3.id_ramo)=".$ramo.") AND((tiene3.id_curso)=".$curso.")) ";
$result7 =pg_Exec($conn,$qry7);
$fila7 = pg_fetch_array($result7,0);*/
$contalum = pg_numrows($result);

	
	
    ?> 
    <?php if ($frmModo=="modificar"){ ?>
    <input type="hidden" name="contalum" value="<?php echo $contalum ?>">
    <?php if (($exim)<=(round($promedi))){
    echo "EXIM";?>
	 <input name="txtExamen[<?php echo $cont ?>]" type="hidden" size="5" value="<?php echo $fila8['promedio'] ?>">
   <? }else{ ?>
   <input name="txtExamen[<?php echo $cont ?>]" type="text" size="5" value="<?php echo $fila9['nota_examen'] ?>">
   
    <?php 	 }									
    } ?>
    <?php if ($frmModo=="mostrar"){
	 if (($exim)<=(round($promedi))){
		 
    echo "EXIM";
    }else{
     echo $fila9['nota_examen'];
	if($fila9['nota_examen']==""){
	echo"--";	}
    }
    }?>
    </div></td>
	
	<?php if (($frmModo=="modificar")||($frmModo=="mostrar")){ ?>
	<td align="center" class="<? if ($i%2==0){?>tabla04<? }else{?>tabla04<? }?>">&nbsp;<?php $notafinal = $fila9['nota_final']; 
	echo $notafinal;
	$notfinal=$notfinal+$notafinal;
	if ($notfinal >=0){
		$divisor2= $divisor2 + 1;
	}
	?>
    </td>
	<?php
   } 
				}//cierre de for 
			}//cierre if periodo
		}
	}
						
		if(isset($periodo)){				
 ?>
        <tr height=5 bgcolor=black>
        <td colspan=41></td>
        </tr>
        <tr> </tr>
        <tr height=20>
        <td colspan=40></td>
        </tr>
        <tr>
        <td width ="47%" class="tabla04">PROMEDIO DEL CURSO</td>
        <td width="20%"align="center" class="tabla04"><?php
        if($divisor >0 ){
         echo (round($gen/$divisor));
		 
        }							
        ?></td>
        <input type="hidden" name=cont value=<?php echo $cont ?>>
        <td width="14%"align="center" class="tabla04">&nbsp;</td>
        <td width="19%"align="center" class="tabla04"><?php
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
        <TD colspan=4>
        <? }?>
        <TABLE WIDTH="100%" BORDER=0 CELLSPACING=0 CELLPADDING=0>
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
