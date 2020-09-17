<?php require('../../../../util/header.inc');?>
<?php 

	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO; 
	$_POSP          =5;
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25) &&($_PERFIL!=2)){$whe_perfil_curso=" and curso.id_curso=$curso";}

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
	$sql_alu = "SELECT alumno.rut_alumno, alumno.dig_rut, alumno.nombre_alu, alumno.ape_pat, alumno.ape_mat, matricula.id_curso ";
	$sql_alu = $sql_alu . "FROM matricula INNER JOIN alumno ON matricula.rut_alumno = alumno.rut_alumno ";
	$sql_alu = $sql_alu . "WHERE (((matricula.id_curso)=".$curso.")) ";
	$sql_alu = $sql_alu . "ORDER BY alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu; ";
	
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
	$rs_permiso = @pg_exec($conn,$sql);//or die ("SELECT FALLO :".$sql)
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
<link  rel="shortcut icon" href="../../../../images/icono_sae_33.png">
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
			var ano=<?=$ano?>;
			//alert(ano);
			frmModo = form.frmModo.value;
			var cb_ok=form.cb_ok.value;
			
			
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="RespaldoPromocion.php?curso="+curso2+"&ano="+ano+"&frmModo="+frmModo+"&cb_ok="+cb_ok;
				form.action = pag;
				form.target="_blank";
				form.submit(true);	
				
			}		
		 }
		 
		function exportar(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			var ano=<?=$ano?>;
			//alert(ano);
			frmModo = form.frmModo.value;
			
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="RespaldoPromocion.php?curso="+curso2+"&ano="+ano+"&frmModo="+frmModo;
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
				pag="../seteaAno.php3?caso=10&pa=39&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
</script>
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
                          <?
			   include("../../../../cabecera/menu_superior.php");
			   ?>
                </td>
              </tr>
              <tr align="center" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="10%" height="363" align="left" valign="top"> 
                      
                                  <?
						 $menu_lateral=1;
						 include("../../../../menus/menu_lateral.php");
						 ?>
                      
                      </td>
                      <td width="100%" align="center" ><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="66%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="174" valign="top"><!-- inicio codigo antiguo -->
								  <table width="650" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td>
        <div align="right">
          <INPUT class = "botonXX"  TYPE="button" value="VOLVER" name="btnModificar"  onClick="document.location='../Menu_Respaldo.php'">
      </div></td>
    </tr>
</table>
<table width="645" border="0" align="center" cellspacing="1" cellpadding="1">
  <tr>
    <td class="tableindex" colspan="3">Buscador Avanzado </td>
   </tr>
  <tr>
    <td width="124" align="center"><FONT face="arial, geneva, helvetica" size=2><strong>A&Ntilde;O ESCOLAR </strong></FONT></td>
    <td center="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td center="left"><BR>
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
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>&nbsp;&nbsp;&nbsp;CURSO</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2><strong>:</strong></FONT></td>
    <td align="left"><FONT face="arial, geneva, helvetica" size=2>
	
	   <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  	<input type="hidden" name="ano" value="<?=$ano ?>">
		   
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano."))  $whe_perfil_curso ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" class="ddlb_x" >
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
          </select>
          <tr>
    <td class="cuadro01">&nbsp;</td>
    <td width="21" class="cuadro01">&nbsp;</td>
    <td width="490" class="cuadro01">
    <input name="cb_ok" type="button" class="botonXX"  id="cb_ok" value="Ver" onClick="enviapag(this.form);">
    <input name="cb_exp" type="button"  class="botonXX"  id="cb_exp" value="Exportar" onClick="exportar(this.form);"></td>
 </tr>
          </form>
	</FONT></td>
  </tr>
   
</table>




</table>
</body>
</html>
