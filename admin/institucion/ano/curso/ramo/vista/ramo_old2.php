
<?php
require('../../../../../../util/header.inc');
include('../controlador/ramo.php');
 	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$_POSP          =6;
	$_bot           =6;
	$_MDINAMICO     =1;
	$_VIENEPAG="listar_ramos.php3";
		
	session_register("_VIENEPAG");
	
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
			$_ITEM =$item;
			session_register('_ITEM');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
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
	 window.location="../../../../../../index.php";
</script>
<? } ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="JavaScript" type="text/JavaScript">
<!--
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
				pag="../seteaCurso.php3?caso=11&curso="+curso2+"&frmModo="+frmModo
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
				pag="../../seteaAno.php3?caso=10&pa=2&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.EstiloMODO {color: #FF0000 ; font-size: 10px;}
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
vertical-align:top;
background-position:top;

}
.boxholder{
clear: both;
padding: 3px;
background: #CCCCCC;
vertical-align:top;
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
</style>
<script type="text/javascript" src="../scripts/prototype.lite.js"></script>
<script type="text/javascript" src="../scripts/moo.fx.js"></script>
<script type="text/javascript" src="../scripts/moo.fx.pack.js"></script>
<script type="text/javascript">
<!--

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
//-->
</script>

<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? //include("../../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
							<? $menu_lateral="3_1"; //include("../../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="">
								  <!-- codigo  -->
								  
								  
								  <table width="950" border="0" align="center" cellpadding="3" cellspacing="0">
								  <tr>
									<td width="30%"><b>INSTITUCI&Oacute;N</b></td>
									<td><b>: 
									<?
									$fil_instit = get_institucion($_INSTIT, $conn);
									echo $fil_instit['nombre_instit'];	
									?></b></td>
								  </tr>
								  <tr>
									<td><b>A&Ntilde;O ESCOLAR </b></td>
									<td><b>:	
									<?
									$fil_ano  = get_ano($_ANO, $conn);
									echo $fil_ano['nro_ano'];	
									?></b></td>
								  </tr>
								  <tr>
									<td><b>CURSO</b></td>
									<td><b>: <? echo $curso_palabra = cursoPalabra($_CURSO,0,$conn);?></b></td>
								  </tr>
								  <tr>
									<td><b>SUBSECTOR</b></td>
									<td><b>: 
									<?
									$fil_subsector = get_subsector($_RAMO, $conn);
									echo $fil_subsector['nombre'];	
									?>
									</b></td>
								  </tr>
								</table>
								<table width="950" border="0" align="center" cellpadding="2" cellspacing="0">
								  <tr>
									<td align="right"><label>
									  <input type="submit" name="Submit" value="MODIFICAR" class="BotonXX">
									</label>
									  <label>
									  <input type="submit" name="Submit2" value="VOLVER" class="BotonXX">
									</label></td>
								  </tr>
								</table>
								<div id="wrapper">
									<div id="content">
									<h3 class="tab" title="GENERAL"><div class="tabtxt"><a href="#">GENERAL</a></div></h3>
									<div class="tab"><h3 class="APROXIMACIONES" title="second"><a href="#">APROXIMACIONES</a></h3></div>
									<div class="tab"><h3 class="OTRAS" title="third"><a href="#">OTRAS</a></h3></div>
									<div class="tab"><h3 class="CONFIG. ESPECIAL" title="fourth"><a href="#">CONFIG. ESPECIAL</a></h3></div>
									<div class="boxholder">
										<div class="box">
											<table width="100%" border="0" cellpadding="2" cellspacing="0">
											  <tr>
												<td width="30%">SUBSECTOR</td>
												<td><label>
												  <?
												  echo $fil_subsector['nombre'];	
												  ?>
												</label></td>
											  </tr>
											  <tr>
												<td>OBLIGATORIO</td>
												<td><label>
												<?
												$fil_ramo = get_ramo($_RAMO, $conn);
												$sub_obli = $fil_ramo['sub_obli'];
												if ($sub_obli==1){
													echo "SI";
												}else{
													 echo "NO";
												}
												?>				 
												</label></td>
											  </tr>
											  <tr>
												<td>INCIDE EN PROMOCI&Oacute;N </td>
												<td>
												<?
												$bool_ip = $fil_ramo['bool_ip'];
												if ($bool_ip==1){
													echo "SI";
												}else{
													echo "NO";
												}
												?>
												</td>
											  </tr>
											  <tr>
												<td>ASOCIADO A RELIGI&Oacute;N </td>
												<td>
												<?
												$bool_sar = $fil_ramo['bool_sar'];
												if ($bool_sar==1){
													echo "SI";
												}else{
													echo "NO";
												}
												?>
												</td>
											  </tr>
											  <tr>
												<td>ART&Iacute;STICO</td>
												<td>
												<?
												$bool_artis = $fil_ramo['bool_artis'];
												if ($bool_artis==1){
													echo "SI";
												}else{
													echo "NO";
												}
												?>
												</td>
											  </tr>
											  <tr>
												<td>MODO DE EVALUACI&Oacute;N </td>
												<td>
												<?
												$modo_eval = $fil_ramo['modo_eval'];
												if ($modo_eval==1){
													echo "Numérico";  
												}
												if ($modo_eval==2){
													echo "Conceptual (I,S,B,MB)";  
												}
												if ($modo_eval==3){
													echo "Numérico-Conceptual (I,S,B,MB)";  
												}
												if ($modo_eval==4){
													echo "Conceptual (I,S,B,MB)-Numérico";  
												}
												if ($modo_eval==5){
													echo "Conceptual Especial (SIGLAS)";  
												}
												?>
												</td>
											  </tr>
										  </table>
										</div>
										<div class="box">
											<table width="100%" border="0" cellpadding="2" cellspacing="0">
											  <tr>
												<td width="30%">APROXIMAR PROMEDIO DE NOTAS </td>
												<td width="70%">
												<?
												$truncado = $fil_ramo['truncado'];
												if ($truncado==1){
													echo "SI";  
												}else{
													echo "NO";
												}
												?>
												</td>
											  </tr>
											  <tr>
												<td>TIPO DE APROXIMACI&Oacute;N </td>
												<td>
												<?
												$tipo_aproximacion = $fil_ramo['tipo_aproximacion'];
												if ($tipo_aproximacion==1){
													echo "OPCIONAL";  
												}else{
													echo "ESTÁNDAR";
												}
												?></td>
											  </tr>
											  
											  <?
											  if ($tipo_aproximacion!=0){ ?>
											  <tr>
												<td colspan="2">
												<div>
												<table width="90%" border="1" align="center" cellpadding="3" cellspacing="0" bordercolor="#CCCCCC">
												  <tr>
													<td><table width="100%" border="0" cellpadding="2" cellspacing="2">
													  <tr>
														<td colspan="9">OPCIONES</td>
													  </tr>
													  <tr>
														<td>X</td>
														<td>Si decimal es </td>
														<td>X,</td>
														<td>9</td>
														<td>a</td>
														<td>xx,</td>
														<td>8</td>
														<td>Aproximar al entero siguiente </td>
														<td>Ej: 39,5 =&gt; 40 </td>
													  </tr>
													  <tr>
														<td>X</td>
														<td>Si entero es </td>
														<td>X</td>
														<td>9</td>
														<td>a</td>
														<td>x</td>
														<td>8</td>
														<td>Subir a d&eacute;cima siguiente </td>
														<td>Ej: 35 =&gt; 40 </td>
													  </tr>
													  <tr>
														<td>x</td>
														<td>Si entero es </td>
														<td>X</td>
														<td>9</td>
														<td>a</td>
														<td>x</td>
														<td>9</td>
														<td>Dejar unidad en Cero </td>
														<td>Ej: 34 =&gt; 30 </td>
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
													  </tr>
													  <tr>
														<td colspan="9">OPCIONES LIBRES </td>
													  </tr>
													  <tr>
														<td>X</td>
														<td>Si promedio es </td>
														<td>xx</td>
														<td>a</td>
														<td>xx</td>
														<td> = </td>
														<td>xx</td>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													  </tr>
													  <tr>
														<td>X</td>
														<td>Si promedio es </td>
														<td>xx</td>
														<td>a</td>
														<td>xx</td>
														<td>=</td>
														<td>xx</td>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
													  </tr>
													  <tr>
														<td>x</td>
														<td>Si promedio es </td>
														<td>xx</td>
														<td>a</td>
														<td>xx</td>
														<td>=</td>
														<td>xx</td>
														<td>&nbsp;</td>
														<td>&nbsp;</td>
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
													  </tr>
													</table></td>
												  </tr>
												  
												  <tr>
													<td>APLICA CONFIGURACI&Oacute;N EN </td>
													<td>
													<?
													$fil_subsector = get_subsector($_RAMO, $conn);
													$aplica_aproximacion = $fil_ramo['aplica_aproximacion'];
													if ($aplica_aproximacion==0){
														echo "Solo en este subsector";  
													}
													if ($aplica_aproximacion==1){
														echo "En todos los subsectores de este curso";  
													}
													if ($aplica_aproximacion==2){
														echo "En este tipo de enseñanza";  
													}
													if ($aplica_aproximacion==3){
														echo "En todos los subsectores del establecimiento";  
													}
													
													?>
													</td>
												  </tr>
												  
												</table>
												</div>
												</td>
											  </tr>
											<? } ?>  
											  
										  </table>
										</div>
										<div class="box">
											<table width="100%" border="0" cellpadding="2" cellspacing="0">
											  <tr>
												<td width="30%">DOCENTE</td>
												<td width="70%">
												<?
												$fil_doc = get_docente($_RAMO, $conn);
												$nombre_docente = $fil_doc['nombre_emp']." ".$fil_doc['ape_pat']." ".$fil_doc['ape_mat'];
												if ($nombre_docente!=NULL){
													echo $nombre_docente;  
												}else{
													echo "Indeterminado";
												}
												?>				
												</td>
											  </tr>
											  <tr>
												<td>AYUDANTE</td>
												<td>
												<?
												$fil_ayu = get_ayudante($_RAMO, $conn);
												$nombre_ayudante = $fil_ayu['nombre_emp']." ".$fil_ayu['ape_pat']." ".$fil_ayu['ape_mat'];
												if ($nombre_ayudante!="  "){
													echo $nombre_ayudante;  
												}else{
													echo "Sin ayudante";
												}
												?>	
												</td>
											  </tr>
											  <tr>
												<td>EXAMEN</td>
												<td>
												<? 
												$con_examen = $fil_ramo['conex'];
												if ($con_examen=="1"){
													echo "SI";
												}else{
													if ($con_examen=="2"){
														echo "NO";
													}else{
														echo "<font face='arial, geneva, helvetica' size='2' color='#FF0000'><strong>Indeterminado</strong></font>";
													}			  
												}   
												?>				
												</td>
											  </tr>
											  <?
											  if ($con_examen==1){ ?>
											  <tr>
												<td>&nbsp;</td>
												<td><table width="70%" border="0" align="right" cellpadding="2" cellspacing="2">
												  <tr>
													<td width="40%">Porcentaje Examen </td>
													<td width="60%">
													<? 
													  $porcentaje_examen = $fil_ramo['pct_examen'];
													  echo $porcentaje_examen;
													?>  
													%</td>
												  </tr>
												  <tr>
													<td>Nota de Eximici&oacute;n </td>
													<td>
													<?
													  $nota_eximicion = $fil_ramo['nota_exim'];
													  echo $nota_eximicion;
													?>
													</td>
												  </tr>
												</table></td>
											  </tr>
											<? } ?>	  
											  <tr>
												<td>PRUEBA DE NIVEL </td>
												<td>
												<?
												$prueba_nivel = $fil_ramo['prueba_nivel'];
												if ($prueba_nivel=="1"){
													echo "SI";
												}else{
													 if ($prueba_nivel=="2"){
														 echo "Sin prueba de Nivel";
													 }else{
														  echo "<font face='arial, geneva, helvetica' size='2' color='#FF0000'><strong>Indeterminado</strong></font>";
													 }
												}	 	  	 	
												?>				
												</td>
											  </tr>
											  <?
											  if ($prueba_nivel=="1"){ ?>
												  <tr>
													<td>&nbsp;</td>
													<td><table width="70%" border="0" align="right" cellpadding="2" cellspacing="2">
													  <tr>
														<td width="40%">Porcentaje Prueba de Nivel </td>
														<td width="60%"><? 
														  $porcentaje_prueba_nivel = $fil_ramo['pct_nivel'];
														  echo $porcentaje_prueba_nivel;
														?>
														  %</td>
													  </tr>
													  <tr>
														<td>Aproxima con Promedio </td>
														<td><?
														  $truncado_pnivel = $fil_ramo['truncado_pnivel'];
														  if ($truncado_pnivel=="1"){
															  echo "SI";
														  }else{
															   if ($truncado_pnivel=="0"){
																   echo "NO";
															   }else{
																   echo "<font face='arial, geneva, helvetica' size='2' color='#FF0000'><strong>Indeterminado</strong></font>";
															   }
														  }					  	  
														?>                    </td>
													  </tr>
													  <tr>
														<td>Modo de Evaluación </td>
														<td>
														 <? 
														 $modo_eval_pnivel = $fil_ramo['modo_eval_pnivel'];
														 
														 if ($modo_eval_pnivel=="1"){
															  echo "Numérico";					 
														 }else{
															 if ($modo_eval_pnivel=="2"){
																  echo "Conceptual"; 
															 }else{
																  echo "<font face='arial, geneva, helvetica' size='2' color='#FF0000'><strong>Indeterminado</strong></font>";			  
															 }
														 }				 
														 ?>
														</td>
													  </tr>
													</table></td>
												  </tr>
											  <? } ?>
										  </table>
										</div>
										<div class="box">
											<table width="100%" border="0" cellpadding="2" cellspacing="0">
											  <tr>
												<td width="30%">PORCENTAJE PROMEDIO DE NOTAS PARCIALES </td>
												<td width="70%">
												<? 
												$porc_examen = $fil_ramo['porc_examen'];
												
												if ($porc_examen==NULL){
													echo "100";
												}else{
													$porc_examen;
												}	
												?> %
												</td>
											  </tr>
											  <tr>
												<td colspan="2"><hr /></td>
											  </tr>
											  <tr>
												<td>EX&Aacute;MENES SEMESTRALES </td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td colspan="2">
												
												<table width="80%" border="0" align="center" cellpadding="2" cellspacing="2">
												  <?
												  $examenes = get_examen_semestral($_RAMO, $conn);
												  
												  foreach ($examenes as $examen): 
													  ?>
													  <tr>
														<td><?=$examen['nombre'];?></td>
														<td><?=$examen['porc'];?></td>
													  </tr>
													  <?
												  endforeach ?>
												</table>
												
												</td>
											  </tr>
											  <tr>
												<td colspan="2"><hr /></td>
											  </tr>
											  <tr>
												<td>APROXIMA PROMEDIO FINAL </td>
												<td>
												<? 
												$bool_ap = $fil_ramo['bool_ap'];
												if ($bool_ap=="1"){
													 echo "SI";
												}else{
													 echo "NO";
												}
												
												?>
												</td>
											  </tr>
											  <tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
										  </table>
										</div>
										
									</div>
								</div>
								</div>
								 <script type="text/javascript">
									Element.cleanWhitespace('content');
									init();
								</script> 
								  
								 									  
								  <!-- fin codigo --> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
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
