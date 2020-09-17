<?php require('../../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
   echo $curso			=$_CURSO; 
	$_POSP          =5;


	if($_NOMBREUSUARIO==8776002){
		echo "rdb-->".$institucion."  frmModo-->".$frmModo."  ano-->".$ano."  curso-->".$curso;
	}
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion_ano=pg_result($result,0);
	
	//$institucion==19921 || 
	if($institucion==13593){// 
		echo "<script>window.location = 'promocion_pro_new.php'</script>";	
	}
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//curso.ensenanza=".pg_result($rs_acceso,3)." AND
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			$whe_perfil_curso=" AND  id_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25) &&($_PERFIL!=2)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
	//------------------------
	// Año Escolar
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
	$sqlCurso = "select * from curso where id_curso = $curso";
	$rsCurso =@pg_Exec($conn,$sqlCurso);
	$flCurso = @pg_fetch_array($rsCurso ,0);	
	$truncado_final = $flCurso['truncado_final'];
	$truncado_per   = $flCurso['truncado_per'];
	
	//----------------------------------------------------------------------------
	// ALUMNOS
	//----------------------------------------------------------------------------
	$sql_alu = "SELECT distinct(alumno.rut_alumno), alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso, matricula.nro_lista ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	//$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	$sql_alu = $sql_alu . "ORDER BY matricula.nro_lista ";
	
	//if($_PERFIL==0) echo $sql_alu;
	
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
	}
	elseif($cuenta_periodo==3){
		$per="TRI";
	}else{
		$per=($institucion!=7200)?"BIM":"COM";
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

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
		$_ITEM = $item;
		session_register('_ITEM');
	}
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA." AND id_item=".$_ITEM;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
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
<link  rel="shortcut icon" href="/images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/JavaScript" src="../../../../clases/jquery/jquery.js"></script>
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
				alert('Recuerde esperar que termine de cargar la página para realizar la promoción');
				
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
      if (confirm('Se eliminará la promoción del curso. ¿Desea continuar?')){
	       window.location='promocion_eliminar.php';
	  }else{
	  
	  }
}	


function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=yes, width=700, height=400, top=85, left=140";
window.open(pagina,"",opciones);
}

function reporte_rev(){
      var curso, anio, parametros; 
			curso = $("#cmb_curso").val();
			anio = $("#cmb_ano").val();
			parametros = "curso="+curso+"&anio="+anio;
			

 			if (curso!=0){
				//veo si la promocion esta hecha
				$.ajax({
				url:"checkPromo.php",
				data:"curso="+curso+"&anio="+anio,
				type:'POST',
				success:function(data){
				
				//console.log(data);
				if(data==1){
					//si esta hecha, habro el popup
				 Abrir_ventana('reporteRevision.php?'+parametros);
				}
				else{
				 //si no esta hecha, tiro alerta
				 alert('Debe estar previamente procesada la promocion');
				}
				
				
		  }
		});  
				
				
		 
		
			}		
			else{
			alert('Debe seleccionar un curso');
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
						<select name="cmb_ano" id="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
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
			<?  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		    <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano."))  $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" id="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
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
  <tr>
    <td align="left" class="textonegrita">NOTA</td>
    <td align="left" class="textonegrita">: </td>
    <td align="left" class="textosimple">Recuerde esperar que termine de cargar la p&aacute;gina para realizar la promoci&oacute;n</td>
  </tr>
</table>



<table width="100%" border="0" cellspacing="1" cellpadding="1">
  <tr>
    <td align="right">
	<?	
	if ($situacion_ano !=0 or $_PERFIL==0){
		?> <INPUT name="button" TYPE="button" class="botonXX" value="REPORTE REVISI&Oacute;N" onClick="reporte_rev();">&nbsp;<?
	if ($elimina==1){    ?>
	       <INPUT name="button" TYPE="button" class="botonXX" value="ACTUALIZAR NOTAS" onClick="confirmar_eli();">&nbsp;
	<? }
	if($ingreso==1){?>
		   <INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="promocion_ingresa.php"  value="PROCESAR">
     <? } 
	}//cierre if año escolar?>
 
      <INPUT name="button2" TYPE="button" class="botonXX" onClick=document.location="../seteaCurso.php3?caso=4"  value="VOLVER"></td>
  </tr>
  <tr align="center">
    <td class="tableindex" >Promoci&oacute;n de Alumnos </td>
  </tr>
</table> 

<?
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
        <td colspan="<? if($cuenta_periodo==2) echo "3";elseif($cuenta_periodo==3) echo "4"; else echo "5";?>"><div align="center"><strong>PROMEDIOS <br>
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
        <? if($cuenta_periodo==4){ ?>
        <td width="8%"><div align="right"><strong>3 <?=$per;?></strong></div></td>
        <td width="8%"><div align="right"><strong>4 <?=$per;?></strong></div></td>
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
	$sql_promo = "select * from promocion where rdb=".$institucion." AND rut_alumno = '".$alumno."' and id_ano = ".$ano." and id_curso = ".$curso;
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
	<table width="97%" border="0" align="left" cellpadding="0" cellspacing="0" class="cuadro01">
<?    
	//------------------------------------------------------------------------------
	/*$sql_ramos = "select ramo.id_ramo, ramo.conex, ramo.modo_eval, ramo.cod_subsector, subsector.nombre from ramo, tiene$nro_ano1,subsector ";
	$sql_ramos = $sql_ramos . "where ramo.id_curso = ".$curso." and tiene$nro_ano1.rut_alumno = ".$alumno." ";
	$sql_ramos = $sql_ramos . "and tiene$nro_ano1.id_ramo = ramo.id_ramo and ramo.bool_ip = 1  AND ramo.cod_subsector=subsector.cod_subsector ORDER BY id_orden ASC";*/
	$sql_ramos ="SELECT ramo.id_ramo, ramo.conex, ramo.modo_eval, ramo.cod_subsector, subsector.nombre, ramo.nota_exim, ramo.apreciacion,ramo.porc_examen,  ramo.bonifica1, ";
	$sql_ramos.=" ramo.minima1,ramo.maxima1,ramo.truncado, ramo.bonifica2,ramo.minima2,ramo.maxima2,ramo.bonifica3,ramo.minima3,ramo.maxima3,ramo.bonifica4,ramo.minima4,ramo.maxima4, prueba_especial, ramo.coef2, ramo.conexper FROM ramo, tiene$nro_ano1,subsector ";
	$sql_ramos.=" WHERE ramo.id_curso = ".$curso." AND tiene$nro_ano1.rut_alumno =".$alumno." and tiene$nro_ano1.id_ramo = ramo.id_ramo and ramo.bool_ip = 1 ";
	$sql_ramos.=" AND ramo.cod_subsector=subsector.cod_subsector ORDER BY id_orden ASC ";
	//if($_PERFIL==0) echo $sql_ramos;
	$result_ramos =@pg_Exec($conn,$sql_ramos);
	$cont_ramos = @pg_numrows($result_ramos);	
	
	//if($_PERFIL==0) echo "<br>".$sql_ramos;
	for($cont_sub=0 ; $cont_sub < $cont_ramos ; $cont_sub++)
	{
		$apreciacion=0;
		$fila_ramos = @pg_fetch_array($result_ramos,$cont_sub);
		$ramo = $fila_ramos['id_ramo'];
		$examen = $fila_ramos['conex']; // 1 SI 2 NO
		$modo_eval = $fila_ramos['modo_eval'];
		$subsector = $fila_ramos['cod_subsector'];
		$porcentaje = $fila_ramos['porc_examen'];
		$prueba_especial = $fila_ramos['prueba_especial'];
		$coef2 = $fila_ramos['coef2'];
		$examen_per = $fila_ramos['conexper'];
		$aproxima = $fila_ramos['truncado'];
		if($fila_ramos['apreciacion']>0){
			$apreciacion=1;
		}
		if($modo_eval==0) $modo_eval=1;
		
		
			$prom_gral =0;
			$cont_subsector=0;
		
		for($b=0; $b<$cuenta_periodo; $b++){
		
			$fila_per = @pg_fetch_array($rs_periodo,$b);
		
			if($coef2==1){
				$sql = "SELECT promedio FROM notacoef WHERE id_ramo=".$ramo." AND rut_alumno=".$alumno." AND id_periodo=".$fila_per['id_periodo'];
				$rs_notas = @pg_exec($conn,$sql);
				$promedio_sub[$b] = @pg_result($rs_notas,0);
			}elseif($examen_per==1){
				$sql="SELECT nota_final FROM situacion_periodo WHERE id_ramo=".$ramo." AND rut_alumno=".$alumno." AND id_periodo=".$fila_per['id_periodo'];
				$rs_notas = @pg_exec($conn,$sql);
				$promedio_sub[$b] = @pg_result($rs_notas,0);	
				
			}else{
				$sql = "SELECT promedio, notaap FROM notas$nro_ano1 WHERE id_ramo=".$ramo." AND rut_alumno=".$alumno." AND id_periodo=".$fila_per['id_periodo'];
				$rs_notas = @pg_exec($conn,$sql);
				
				if($apreciacion==1){
					$promedio_sub[$b] = @pg_result($rs_notas,1);
				}else{
					$promedio_sub[$b] = @pg_result($rs_notas,0);
				}
			}
			$sql = "SELECT nota,porc,bool_ap FROM notas_examen a INNER JOIN examen_semestral b ON a.id_examen=b.id_examen WHERE a.id_ramo=".$ramo." AND rut_alumno=".$alumno." AND periodo=".$fila_per['id_periodo'];
			$rs_examen_sem = @pg_exec($conn,$sql) or die ("SELECT EXAMEN FALLO :".$sql);
			
			if(@pg_numrows($rs_examen_sem) > 0 ){
				$porc_nota  = (($promedio_sub[$b] * $porcentaje)/100);
				if(@pg_result($rs_examen_sem,2)==1){
					$porc_examen = ((@pg_result($rs_examen_sem,0) * @pg_result($rs_examen_sem,1))/100);
				}else{
					$porc_examen = ((@pg_result($rs_examen_sem,0) * @pg_result($rs_examen_sem,1))/100);
				}
				$promedio_sub[$b] = round($porc_nota + $porc_examen); 
			}
			
			
			if($modo_eval==1 and $promedio_sub[$b] >0){
				
				$prom_gral = $prom_gral + $promedio_sub[$b];
				
				$cont_subsector++;
				
			}elseif(($modo_eval==2)){
			
				if((trim($promedio_sub[$b])=="MB" or trim($promedio_sub[$b])=="B" or trim($promedio_sub[$b])=="S" or trim($promedio_sub[$b])=="I")){
					
				
				$prom_gral = $prom_gral + Conceptual($promedio_sub[$b],2,$institucion,$id_ano,$conn);
				
				if(Conceptual($promedio_sub[$b],2,$institucion,$id_ano,$conn)>=0){
				 $cont_subsector++;
				}
				
				}
			}elseif($modo_eval==3){ // MODIFICACION PARA OBTENER PROMEDIO DE NUMERICO CONCEPTUAL CONSIDERANDO LAS NOTAS (EDUARDO ROJAS)
				$sql="SELECT * FROM notas$nro_ano1 WHERE rut_alumno=".$alumno." AND id_ramo=".$ramo." AND id_periodo=".$fila_per['id_periodo'];
				$rs_notas_concep = pg_exec($conn,$sql);
				$suma=0;
				$cont_concep=0;
				
					$fila_concep = pg_fetch_array($rs_notas_concep,0);
				for($o=0;$o<20;$o++){
					$m=$o + 1;
					$nota = "nota".$m;
					$suma = $suma +  $fila_concep[$nota];	
					if($fila_concep[$nota]!=0){
						$cont_concep++;	
					}

				}
				if($aproxima==1){
					$promedio_conceptual = round($suma / $cont_concep);
				}else{
					$promedio_conceptual = intval($suma / $cont_concep);
				}
				$promedio_sub[$b] = Conceptual($promedio_conceptual,1);
				$prom_gral = $prom_gral + $promedio_conceptual;
				if($promedio_conceptual>0){
				$cont_subsector++;
				}
			}
		}
			if($modo_eval!=1){
				$prom_parcial = round($prom_gral / $cont_subsector);
				$prom_parcial = Conceptual($prom_parcial,1,$institucion,$id_ano,$conn);
			}else{
				/*$prom_parcial = round($prom_gral / $cont_subsector);
				$prom_sin_aprox = intval($prom_gral / $cont_subsector);*/
				if($truncado_per==1){
					$prom_parcial = round($prom_gral / $cont_subsector);
				}else{
					$prom_parcial = intval($prom_gral / $cont_subsector);
					$prom_sin_aprox = intval($prom_gral / $cont_subsector);
				}
			
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
					$prom_final = Conceptual($fila_ex['nota_final'],1,$institucion,$id_ano,$conn);
				}
			}else{
				$escrito = $fila_ex['nota_exam_esc'];
				$oral = $fila_ex['nota_exam_oral'];
				if($modo_eval==1){
					$prom_final = $fila_ex['nota_final'];
				}else{
					$prom_final = Conceptual($fila_ex['nota_final'],1,$institucion,$id_ano,$conn);
				}
			}			
		}else{
			$escrito=0;
			$oral =0;
			$prom_final = $prom_parcial;
		}
		// CODIGO AGREGADO EL 18 DE NOVIEMBRE PARA AGREGAR LA PRUEBA ESPECIAL INDEPENDIENTE
		if($prueba_especial==1){
			$sql ="SELECT nota_final FROM situacion_final WHERE rut_alumno=".$alumno." AND id_ramo=".$ramo;
			$rs_prueba_especial = pg_exec($conn,$sql);
			$prueba_esp = pg_result($rs_prueba_especial,0);
			$prom_final = $prueba_esp;
		}
		
		$sql = "SELECT promedio FROM promedio_sub_alumno WHERE rut_alumno=".$alumno." AND id_ramo=".$ramo;
		$rs_promedio = @pg_exec($conn,$sql);
		if(@pg_numrows($rs_promedio)!=0){
			$prom_final= @pg_result($rs_promedio,0);
			
		}else{
			if(trim($fila_ramos['minima1'])<=trim($prom_final) and trim($fila_ramos['maxima1'])>=trim($prom_final)){
				$prom_final = $prom_final + $fila_ramos['bonifica1'];			
			}elseif(trim($fila_ramos['minima2'])<=trim($prom_final)  and trim($fila_ramos['maxima2'])>=trim($prom_final)){
				$prom_final = $prom_final + $fila_ramos['bonifica2'];			
			}elseif((trim($fila_ramos['minima3'])<=trim($prom_final)) and (trim($fila_ramos['maxima3'])>=trim($prom_final))){
				$prom_final = $prom_final + $fila_ramos['bonifica3'];			
			}elseif((trim($fila_ramos['minima4'])<=trim($prom_final)) and (trim($fila_ramos['maxima4'])>=trim($prom_final))){
				$prom_final = $prom_final + $fila_ramos['bonifica4'];			
			}
			if($prom_final > 70){
				$prom_final=70;
			}
		}
		
		
		
?>
	
	<tr>
	<td width="24%" ><? InicialesSubsector($fila_ramos['nombre']);?></td>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[0];?></div></td>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[1];?></div></td>
	<? if($cuenta_periodo==3){ ?>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[2];?></div></td>
	<? } ?>
    <? if($cuenta_periodo==4){ ?>
     <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[2];?></div></td>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$promedio_sub[3];?></div></td>
	<? } ?>
    <td width="8%" align="center" bgcolor="<?=$colorea?>"><div align="right"><?=$prom_parcial;?></div></td>
    <td width="8%" align="center" ><div align="right"><?=$escrito;?></div></td>
    <td width="8%" align="center" ><div align="right"><?=$oral;?></div></td>
    <td width="26%" align="center" ><div align="right"><?=
	// en este punto tengo que llamar la funcion promedioenquery para obetener el numero correcto del promedio 
	// ya que el promedio que biene ya trae la letra. la idea es que con este promedio  se envie a la funcion 
	// conceptual para que tranforme este promedio en concepto. y tener asi algo mas exacto.	
	$prom_final;?></div></td><!--PROMEDIO FINAL-->
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
