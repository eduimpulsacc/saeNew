<?php require('../../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; 
	$_POSP          =5;
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25) &&($_PERFIL!=2)){$whe_perfil_curso=" and curso.id_curso=$curso";}

	//------------------------
	// A�o Escolar
	//------------------------
	$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano1 = $fila_ano['nro_ano'];
	
	//----------------------------------------------------------------------------
	// DATOS INSTITUCION
	//----------------------------------------------------------------------------
	$sql_institu = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono ";
	$sql_institu = $sql_institu . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN comuna ON (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) AND (institucion.region = comuna.cod_reg)) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg) ";
	$sql_institu = $sql_institu . "WHERE (((institucion.rdb)=".$institucion.")); ";
	$result_institu =@pg_Exec($conn,$sql_institu);
	$fila_institu = @pg_fetch_array($result_institu,0);
	$nombre_institu = ucwords(strtolower($fila_institu['nombre_instit']));
	$direccion = ucwords(strtolower($fila_institu['calle'] . " " . $fila_institu['nro'] . " - " . $fila_institu['nom_com']));
	$telefono = $fila_institu['telefono'];
	$region = ucwords(strtolower($fila_institu['nom_reg']));
	$provincia = ucwords(strtolower($fila_institu['nom_pro']));
	$comuna = ucwords(strtolower($fila_institu['nom_com']));
	//----------------------------------------------------------------------------
	// CURSO
	//----------------------------------------------------------------------------	
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//----------------------------------------------------------------------------
	// ALUMNOS
	//----------------------------------------------------------------------------
	$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$result_alu =@pg_Exec($conn,$sql_alu);	
	//----------------------------------------------------------------------------	
	
	//------------------------------------------------------------------------------
	// PERIODOS
	// -----------------------------------------------------------------------------
	$sql = "SELECT * FROM periodo WHERE id_ano=".$ano." ORDER BY id_periodo ASC";
	$rs_periodo = pg_exec($conn,$sql);
	$cuenta_periodo = pg_numrows($rs_periodo);
	if($cuenta_periodo==2){
		$per ="SEM";
	}else{
		$per="TRI";
	}
	
	function InicialesSubsector($Subsector)
{
	$largo = strlen($Subsector);
	for($cont_letras=0 ; $cont_letras < $largo  ; $cont_letras++)
	{
		if ($cont_letras == 0)
		{
			$cadena = strtoupper(substr($Subsector,0,1));
			$cont_letras = 1;
		}
		$letra_query = substr($Subsector,$cont_letras,1);
		if (strlen(trim($letra_query)) == 0)
			if (substr($Subsector,$cont_letras+1,1) == "(")
				$cont_letras = $largo;
			else
				$cadena = $cadena . strtoupper(substr($Subsector,$cont_letras+1,1));
		if (strlen($cadena)==6 )
			$cont_letras = $largo;
	}	
	if (strlen(trim($cadena))==1)
		echo trim(strtoupper(substr($Subsector,0,3)));
	else
		echo trim($cadena);
}
?>
<?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>
		 <? } ?>
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
//-->

function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&p=7&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=5&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
function confirmar_eli(){
      if (confirm('Se eliminar� la promoci�n del curso. �Desea continuar?')){
	       window.location='promocion_eliminar.php';
	  }else{
	  
	  }
}		 
</script>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
                      <td width="10%" height="363" align="left" valign="top"> 
                       <? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="100%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="390" valign="top"><!-- inicio codigo antiguo -->
								  
								  
								  
								  
								  
<center>
<table width="650" border="0" cellspacing="1" cellpadding="1">
  
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>A&Ntilde;O ESCOLAR </strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left">
	<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$filann = @pg_fetch_array($result,0);	
						if (!$filann){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}?>
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
						<select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un A�o)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
			                  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
				<? }?>
	</form>
	</td>
  </tr>
  <tr>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>CURSO</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2>
	
	   <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano."))  $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $filan = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($filan['id_curso'], 1, $conn);
		  
		        if (($filan['id_curso'] == $cmb_curso) or ($filan['id_curso'] == $curso)){
		           echo "<option value=".$filan['id_curso']." selected>".$Curso_pal."</option>";
		        }else{	    
		           echo "<option value=".$filan['id_curso'].">".$Curso_pal."</option>";
                }
		     } ?>
          </select></form>
	</FONT></td>
  </tr>
</table>
<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="right">
	<?	
	if (($_PERFIL==17) AND ($_INSTIT==9566 || $_INSTIT==24977)){ 
	    // no muestro
    }else{ 
	    if (($_PERFIL!=2) and ($_PERFIL!=20)){
	       ?>
	       <INPUT name="button" TYPE="button" class="botonXX" value="ELIMINAR" onClick="confirmar_eli();">&nbsp;
		   <INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="promocion_ingresa.php"  value="PROCESAR">
     <? }
 
   } 
   if (($_PERFIL!=2) and ($_PERFIL!=20)){ ?>   
      <INPUT name="button2" TYPE="button" class="botonXX" onClick=document.location="../seteaCurso.php3?caso=4"  value="VOLVER"></td>
 <? } ?> 
  </tr>
  <tr align="center">
    <td class="tableindex" >Promoci&oacute;n de Alumnos </td>
  </tr>
</table> <?
$cont_alumnos = @pg_numrows($result_alu);
for($cont_paginas=0 ; $cont_paginas < $cont_alumnos  ; $cont_paginas++)
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr class="tablatit2-1">
    <td width="63" height="24" align="center">RUT ALUMNO</td>
    <td width="161" align="center">NOMBRE ALUMNO</td>
    <td width="50" align="center"><table width="97%" border="0" align="left" cellpadding="1" cellspacing="1">
      <tr class="tablatit2-1">
        <td width="25%" rowspan="2"><strong>SUBSECTOR</strong></td>
        <td colspan="<? if($cuenta_periodo==2) echo "3"; else echo "4";?>"><div align="center"><strong>PROMEDIOS <br>
          PERIODOS</strong></div></td>
        <td colspan="2"><div align="center"><strong>EXAM&Eacute;N</strong></div></td>
        <td width="25%">&nbsp;</td>
      </tr>
      <tr class="tablatit2-1">
        <td width="8%"><div align="right"><strong>1 <?=$per;?></strong></div></td>
        <td width="8%"><div align="right"><strong>2 <?=$per;?></strong></div></td>
		<? if($cuenta_periodo==3){ ?>
        <td width="8%"><div align="right"><strong>3 <?=$per;?></strong></div></td>
		<? } ?>	
        <td width="8%"><div align="right"><strong>PROM</strong></div></td>
        <td width="8%"><div align="right"><strong>ESC</strong></div></td>
        <td width="8%"><div align="right"><strong>ORAL</strong></div></td>
        <td><div align="right"><strong>PROMEDIO</strong></div></td>
      </tr>
    </table></td>
    <td width="75" align="center">ASISTENCIA (%)</td>
    <td width="125" align="center">SITUACION</td>
    <td width="157" align="center">OBSERVACI&Oacute;N</td>
  </tr>
 
<?
	$fila_alu = @pg_fetch_array($result_alu,$cont_paginas);	
	$alumno = $fila_alu['rut_alumno'];
	$rut_alumno = $fila_alu['rut_alumno'] . "-" . strtoupper($fila_alu['dig_rut']);
	$nombre_alu = ucwords(strtoupper(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu']))); 
	$curso = $fila_alu['id_curso'];
	$observacion = "";
	//------------------------------------------------------------------------------
	// CONSULTA EN TABLA PROMOCION
	//------------------------------------------------------------------------------
	$sql_promo = "select * from promocion where rut_alumno = '".$alumno."' and id_ano = ".$ano." and id_curso = ".$curso;
	$result_promo =@pg_Exec($conn,$sql_promo);
	$fila_promo = @pg_fetch_array($result_promo,0);		
	if ($fila_promo['promedio']>0) $promedio = $fila_promo['promedio']; else $promedio = "&nbsp;";
	if ($fila_promo['asistencia']>0) $asistencia = $fila_promo['asistencia']."%"; else $asistencia = "&nbsp;";
	if ($fila_promo['situacion_final']>0){
		if ($fila_promo['situacion_final']==1)
			$situacion_final = "APROBADO";
		if ($fila_promo['situacion_final']==2){
			if ($fila_promo['tipo_reprova']==1) $tipo_reproba = "POR NOTAS";
			if ($fila_promo['tipo_reprova']==2) $tipo_reproba = "POR ASISTENCIA";						
			$situacion_final = "REPROBADO"." - ". $tipo_reproba;}
		if ($fila_promo['situacion_final']==3){
			$situacion_final = "RETIRADO";}			//$observacion ="RET. ".cfecha2($fila_promo['fecha_retiro']);
	}else{
		$situacion_final = "&nbsp;";
	}
	$observacion = $observacion . " " .  $fila_promo['observacion'];
?>  
 <tr>
    <td height="24" align="center"><span class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>"><? echo $rut_alumno?></span></td>
    <td align="center"><span class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>"><? echo substr($nombre_alu,0,20)?></span></td>
    <td align="center">
	<table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="cuadro01">
<?    
	//------------------------------------------------------------------------------
	$sql_ramos = "select ramo.id_ramo, ramo.conex, ramo.modo_eval, ramo.cod_subsector, subsector.nombre from ramo, tiene$nro_ano1,subsector ";
	$sql_ramos = $sql_ramos . "where ramo.id_curso = ".$curso." and tiene$nro_ano1.rut_alumno = ".$alumno." ";
	$sql_ramos = $sql_ramos . "and tiene$nro_ano1.id_ramo = ramo.id_ramo and ramo.bool_ip = 1  AND ramo.cod_subsector=subsector.cod_subsector ORDER BY id_orden ASC";
	$result_ramos =@pg_Exec($conn,$sql_ramos);
	$cont_ramos = @pg_numrows($result_ramos);	
	
	//if($_PERFIL==0) echo "<br>".$sql_ramos;
	for($cont_sub=0 ; $cont_sub < $cont_ramos ; $cont_sub++)
	{
		
		$fila_ramos = @pg_fetch_array($result_ramos,$cont_sub);
		$ramo = $fila_ramos['id_ramo'];
		$examen = $fila_ramos['conex']; // 1 SI 2 NO
		$modo_eval = $fila_ramos['modo_eval'];
		$subsector = $fila_ramos['cod_subsector'];
		if($modo_eval==0) $modo_eval=1;
		
		
			$prom_gral =0;
			$cont_subsector=0;
		for($b=0; $b<$cuenta_periodo; $b++){
			$fila_per = @pg_fetch_array($rs_periodo,$b);
			$sql = "SELECT promedio FROM notas$nro_ano1 WHERE id_ramo=".$ramo." AND rut_alumno=".$alumno." AND id_periodo=".$fila_per['id_periodo'];
			$rs_notas = @pg_exec($conn,$sql);
			$promedio_sub[$b] = @pg_result($rs_notas,0);
			if($modo_eval==1 and $promedio_sub[$b] >0){
				$prom_gral = $prom_gral + $promedio_sub[$b];
				$cont_subsector++;
			}elseif(($modo_eval==2 or $modo_eval==3)){
				if((trim($promedio_sub[$b])=="MB" or trim($promedio_sub[$b])=="B" or trim($promedio_sub[$b])=="S" or trim($promedio_sub[$b])=="I")){
				$prom_gral = $prom_gral + Conceptual($promedio_sub[$b],2);
				$cont_subsector++;
				}
			}
		}
			if($modo_eval!=1){
				$prom_parcial = round($prom_gral / $cont_subsector);
				$prom_parcial = Conceptual($prom_parcial,1);
			}else{
				$prom_parcial = round($prom_gral / $cont_subsector);
				$prom_sin_aprox = intval($prom_gral / $cont_subsector);
			
			}
		/*************** EXAMEN *****************************/
		if($examen==1){
			$sql = "SELECT * FROM situacion_final WHERE rut_alumno=".$alumno." AND id_ramo=".$ramo;
			$rs_examen = @pg_exec($conn,$sql);
			$fila_ex = @pg_fetch_array($rs_examen,0);
			if($fila_ex['nota_examen']>0){
				$escrito =  $fila_ex['nota_examen'];
				if($modo_eval==1){
					$prom_final = $fila_ex['nota_final'];
				}else{
					$prom_final = Conceptual($fila_ex['nota_final'],1);
				}
			}else{
				$escrito = $fila_ex['nota_exam_esc'];
				$oral = $fila_ex['nota_exam_oral'];
				if($modo_eval==1){
					$prom_final = $fila_ex['nota_final'];
				}else{
					$prom_final = Conceptual($fila_ex['nota_final'],1);
				}
			}			
		}else{
			$escrito=0;
			$oral =0;
			$prom_final = $prom_parcial;
		}
		$sql = "SELECT promedio FROM promedio_sub_alumno WHERE rut_alumno=".$alumno." AND id_ramo=".$ramo;
		$rs_promedio = @pg_exec($conn,$sql);
		if(@pg_numrows($rs_promedio)!=0){
			$prom_final= @pg_result($rs_promedio,0);
			
		}
?>
	
	<tr>
	<td width="24%" ><? InicialesSubsector($fila_ramos['nombre']);?></td>
    <td width="10%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[0];?></div></td>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[1];?></div></td>
	<? if($cuenta_periodo==3){ ?>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[2];?></div></td>
	<? } ?>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$prom_parcial;?></div></td>
    <td width="8%" align="center" ><div align="right"><?=$escrito;?></div></td>
    <td width="8%" align="center" ><div align="right"><?=$oral;?></div></td>
    <td width="26%" align="center" ><div align="right"><?=$prom_final;?></div></td>
	</tr>
	<input name="id_ramo[<?php echo $contador;?>]" type="hidden" value="<?=$ramo;?>">
	<input name="cont_ramos<?php echo $cont_paginas; ?>" value="<?=$cont_ramos;?>" type="hidden">
<? $contador++;
} ?>
	</table></td>
    <td colspan="3" align="center">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2" align="left" nowrap class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>">PROMEDIO FINAL ALUMNO </td>
    <td align="right" nowrap class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>"><? echo $promedio?></td>
    <td align="center" nowrap class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>"><? echo $asistencia?></td>
    <td align="left" nowrap class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>"><? echo $situacion_final?></td>
    <td align="left" nowrap class="<? if ($cont_paginas%2==0){?>tabla04<? }else{?>tabla04<? }?>"><? echo $observacion?></td>
  </tr>
 <? }?>
 <tr><td colspan="6"><table width="327" border="0" cellpadding="0" cellspacing="0" class="boton02" align="center">
   <tr align="center" valign="middle">
     <td height="23"><a href="../seteaCurso.php3?caso=4	" class="boton02" > <img src="../../../../../cortes/atras.gif" width="11" height="11" border="0"> Volver</a></td>
     <td><a href="#arriba" class="boton02"><img src="../../../../../cortes/subir.gif" width="11" height="11" border="0">Subir</a> </td>
     <td><a href="javascript:;" onClick="window.print();" class="boton02"><img src="../../../../../cortes/print.gif" width="11" height="11" border="0"> Imprimir</a></td>
   </tr>
 </table></td></tr>
</table>

</center>

<? pg_close($conn);?>					  
								  
								  
								  
								  
								  <!--fin codigo antiguo --></td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
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
