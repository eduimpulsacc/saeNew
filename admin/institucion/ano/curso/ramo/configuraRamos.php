<?	require('../../../../../util/header.inc');

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;	
	$frmModo		=$_FRMMODO;
	$_POSP = 4;
	$_bot = 8;
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	$sql = "SELECT ramo.id_ramo, subsector.nombre, ramo.cod_subsector, subsector.cod_subsector, ramo.eee, ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, 
ramo.porc_examen,ramo.bool_ip, ramo.sub_obli, ramo.bool_sar, ramo.bool_artis, ramo.aprox_entero, ramo.truncado, ramo.pct_examen, ramo.nota_exim,ramo.pct_ex_escrito, ramo.pct_ex_oral, ramo.truncado_pnivel, ramo.pct_nivel, ramo.modo_eval_pnivel, ramo.apreciacion, ramo.hrs_jec, ramo.hrs_plan, ramo.minima1, ramo.maxima1, ramo.bonifica1, ramo.minima2, ramo.maxima2, ramo.bonifica2, ramo.minima3, ramo.maxima3, ramo.bonifica3, ramo.minima4, ramo.maxima4, ramo.bonifica4,ramo.bool_nquiz,formacion FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso.")) order by ramo.id_orden ASC";
	$rs_ramo = @pg_exec($conn,$sql);
	

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
function enviapag(form){
	if(document.form.cmb_curso.value!=0){
		form.action='seteaConfig.php3?caso=1&curso='+document.form.cmb_curso.value;
		form.submit(true);
	}
}
function validarex(form,nombre,posicion){
	 var oral="txt_ORAL" + posicion;
	 var escrito = "txt_ESCRITO" + posicion;
	 var total;
	 if(document.form.elements[nombre].value > 0 || document.form.elements[nombre].value < 100){
	 	total = parseInt(document.form.elements[oral].value) + parseInt(document.form.elements[escrito].value);
		if(total < 100){
			alert("Examen Oral y Escrito deben sumar 100%");
			document.form.elements[oral].focus();
		}else if(total > 100){
			alert("Examen Oral y Escrito exede el 100%");
			document.form.elements[oral].value="";
			document.form.elements[escrito].value="";
			document.form.elements[escrito].focus();
		}
	 }else{
	 	alert("fuera");
	 }
}
function activar(form,nombre,posicion){
	 var pexamen="txt_PEXAMEN" + posicion;
	 var nexamen="txt_NEXAMEN" + posicion;
	 var escrito="txt_ESCRITO" + posicion;
	 var oral="txt_ORAL" + posicion;

	if(document.form.elements[nombre].checked==true){
		document.form.elements[pexamen].disabled=false;
		document.form.elements[nexamen].disabled=false;
		document.form.elements[escrito].disabled=false;
		document.form.elements[oral].disabled=false;
		document.form.elements[pexamen].value="";
		document.form.elements[nexamen].value="";
		document.form.elements[escrito].value="";
		document.form.elements[oral].value="";
		document.form.elements[pexamen].focus(true);
	}else{
		document.form.elements[pexamen].disabled=true;
		document.form.elements[nexamen].disabled=true;
		document.form.elements[escrito].disabled=true;
		document.form.elements[oral].disabled=true;
		document.form.elements[pexamen].value="";
		document.form.elements[nexamen].value="";
		document.form.elements[escrito].value="";
		document.form.elements[oral].value="";
	}
}
function activarnivel(form,nombre,posicion){

	var pnivel="txt_PNIVEL" + posicion;
	var aproxnivel="cb_APROXN" + posicion;
	var evalua="cmbEVALUAPRUEBANIVEL" + posicion;
	
	if(document.form.elements[nombre].checked==true){
		document.form.elements[pnivel].disabled=false;
		document.form.elements[aproxnivel].disabled=false;
		document.form.elements[evalua].disabled=false;
		document.form.elements[pnivel].value="";
		document.form.elements[evalua].value=0;
		document.form.elements[pnivel].focus(true);
	}else{
		document.form.elements[pnivel].disabled=true;
		document.form.elements[aproxnivel].disabled=true;
		document.form.elements[evalua].disabled=true;
		document.form.elements[pnivel].value="";
		document.form.elements[evalua].value=0;
		document.form.elements[aproxnivel].checked=false;
	}
	
}
function limpia(form,nombre,posicion){
	if(document.form.elements[nombre].value==0){
		document.form.elements[nombre].value="";
	}
}
function ValidaMinima(form,nombre){
	if((parseInt(document.form.elements[nombre].value) < 10) ||  (parseInt(document.form.elements[nombre].value) > 70)){
		alert("Nota de estar entre el rango de 11 y 69");
		document.form.elements[nombre].value="";
		document.form.elements[nombre].focus();
	}
}
function ValidaMaxima(form,nombre,posicion,caso){
	if(caso==1){
		var minima ="txt_MINIMA1" + posicion;
	}
	if(caso==2){
		var minima ="txt_MINIMA2" + posicion;
	}
	if(caso==3){
		var minima ="txt_MINIMA3" + posicion;
	}
	if((parseInt(document.form.elements[nombre].value) < 10) ||  (parseInt(document.form.elements[nombre].value) > 70)){
		alert("Nota de estar entre el rango de 11 y 69");
		document.form.elements[nombre].value="";
		document.form.elements[nombre].focus();
	}else{
		if(parseInt(document.form.elements[nombre].value) < parseInt(document.form.elements[minima].value)){
			alert("Nota máxima debe ser mayor que nota mínima");
			document.form.elements[nombre].focus();
		}
	}
}
function ValidaBonifica(form,nombre){
	if(parseInt(document.form.elements[nombre].value) > 70){
		alert("Bonificación no debe superar 70 puntos");
		document.form.elements[nombre].focus();
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>"></td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../../cabecera/menu_superior.php");
				?>				 
				
				</td>
			  </tr>
			</table>
				
		  </td>
        </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
							<form action="procesaConfiguracion.php" name="form" method="post">
							<input type="hidden" name="contador" value="<?=@pg_numrows($rs_ramo);?>" />
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
								  <table width="100%" border="0">
									  <tr>
										<td width="15%" class="textonegrita">CURSO</td>
										<td>
                						<?	$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
											$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
											$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano."))   ";
											$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
											$resultado_query_cue = pg_exec($conn,$sql_curso);
						                ?>
									  <select name="cmb_curso" class="ddlb_x" onChange="enviapag(this.form);">
											<option value="0" selected>(Seleccione un Curso)</option>
									 <?
									// $sw3 = 1;
									 
									 for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i)
										{  
										$fila = @pg_fetch_array($resultado_query_cue,$i); 
										$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
								  
										if (($fila['id_curso'] == $curso)){
										   echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
										   $sw3 = 0;
										}else{	    
										   echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
										}
									 } 
									
									 ?>
								  </select>	 </td>
							  </tr>
									  <tr>
										<td colspan="2">&nbsp;</td>
									  </tr>
									  <tr>
										<td colspan="2"><div align="right">
										<? if ($situacion !=0 or $_PERFIL==0){
										if($frmModo=="mostrar"){?>
										  <input type="button" name="modifica" value="MODIFICAR" class="botonXX" onclick="window.location='seteaConfig.php3?caso=3'">
										  <input type="button" name="Submit2" value="VOLVER" class="botonXX" onClick="window.location='listarRamos.php3?cmb_curso=<?=$curso;?>'">
										 <? } 
										 if($frmModo=="modificar"){ ?>
										  <input type="submit" name="guardar" value="GUARDAR" class="botonXX">
										  <input type="button" name="CANCELAR" value="CANCELAR" class="botonXX" onClick="window.location='seteaConfig.php3?caso=1&curso=<?=$curso;?>'">							 
										 
										 <? }
										}?>
									    </div></td>
									  </tr>
									</table>
									<br>
									<!-- INCLUYO CODIGO DE LOS BOTONES -->
								<table width="" height="49" border="0" cellpadding="0" cellspacing="0">
								  <tr> 
									<td width="" height="30" align="center" valign="top">&nbsp;</td>	  
									  
							    <tr>
								</tr> 
								  
								  
								</table>
 								  	<div id="wrapper">
									<div id="content">
									<h3 class="tab" title="Configuración Básica"><div class="tabtxt"><a href="#">GENERAL</a></div></h3>
									<div class="tab"><h3 class="tabtxt" title="Examén y Prueba de Nivel"><a href="#">EXAMEN/P. NIVEL</a></h3></div>
									<div class="tab"><h3 class="tabtxt" title="Apreciación y Bonificación"><a href="#">APREC./BONFIC</a></h3></div>
									<div class="tab"><h3 class="tabtxt" title="Otras Config."><a href="#">OTRAS CONFIG.</a></h3></div>
									<!--<div class="tab">
									  <h3 class="tabtxt" title="Configura todos los subsectores"><a href="#">CONF. TODOS </a></h3>
									</div>-->
									<div class="boxholder">
										<div class="box">
											<table width="100%" border="1">
											  <tr>
												<td>Nombre</td>
												<? if($_PERFIL==0){?>
												<td>Codigo</td>
												<? } ?>
												<td>Oblig.</td>
												<td>Promo.</td>
												<td>Asociado<br />
											    Religion</td>
												<td>Artistico</td>
												<td>Notas QUIZ</td>
												<td>Hrs JEC </td>
												<td>Hrs<br />
											    Plan Est. </td>
												<td>Orden</td>
												<td>Modo <br />
											    Evaluaci&oacute;n </td>
												<td>Docente</td>
											  </tr>
											  <? if($frmModo!="mostrar"){?>
											  <? } ?>
											  <? for($j=0;$j<@pg_numrows($rs_ramo);$j++){
											  		$fila_ramo = @pg_fetch_array($rs_ramo,$j);
											  ?>
											  <input name="cod_ramo<?=$j;?>" type="hidden" value="<?=$fila_ramo['id_ramo'];?>" />
											  <tr>
												<td><?=$fila_ramo['nombre'];?></td>
												<? if($_PERFIL==0){?>
												<td>
												<? if($frmModo=="mostrar"){
														echo $fila_ramo['cod_subsector'];
													}
													if($frmModo=="modificar"){?>	
														<input name="txtCODIGO<?=$j;?>" type="text" value="<?=$fila_ramo['cod_subsector'];?>" size="5"/>
													<? } ?>
												</td>
												<? } ?>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo($fila_ramo['sub_obli']==1)?"SI":"NO";
													}
													if($frmModo=="modificar"){
												?>
												  <input name="cb_OBLIG<?=$j;?>" type="checkbox" id="cb_OBLIG<?=$j;?>" value="1" <? echo($fila_ramo['sub_obli']==1)?"checked":"";?> />
												<? }
													if($frmModo=="ingresar"){?>
													<input name="cb_OBLIG<?=$j;?>" type="checkbox" id="cb_OBLIG<?=$j;?>" value="1" />
												<? } ?>	  
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo($fila_ramo['bool_ip']==1)?"SI":"NO";
													}
													if($frmModo=="modificar"){
												?>
												  <input name="cb_PROMO<?=$j;?>" type="checkbox" id="cb_PROMO<?=$j;?>" value="1" <? echo($fila_ramo['bool_ip']==1)?"checked":"";?>/>
												<? }
												if($frmModo=="ingresar"){?>
												 <input name="cb_PROMO<?=$j;?>" type="checkbox" id="cb_PROMO<?=$j;?>" value="1" />
												<? } ?>
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo($fila_ramo['bool_sar']==1)?"SI":"NO";
													}
													if($frmModo=="modificar"){
												?>
												  <input name="cb_RELIGION<?=$j;?>" type="checkbox" id="cb_RELIGION<?=$j;?>" value="1" <? echo($fila_ramo['bool_sar']==1)?"checked":"";?>/>
												<? }
												if($frmModo=="ingresar"){?>
													<input name="cb_RELIGION<?=$j;?>" type="checkbox" id="cb_RELIGION<?=$j;?>" value="1" />				
												<? } ?>					
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo($fila_ramo['bool_artis']==1)?"SI":"NO";
													}
													if($frmModo=="modificar"){
												?>
												  <input name="cb_ARTISTICO<?=$j;?>" type="checkbox" id="cb_ARTISTICO<?=$j;?>" value="1" <? echo($fila_ramo['bool_artis']==1)?"checked":"";?>/>
												<? }
												if($frmModo=="ingresar"){?>
												 <input name="cb_ARTISTICO<?=$j;?>" type="checkbox" id="cb_ARTISTICO<?=$j;?>" value="checkbox" />
												<? } ?>
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo($fila_ramo['bool_nquiz']==1)?"SI":"NO";
													}
													if($frmModo=="modificar"){
												?>
												  <input name="cb_NQUIZ<?=$j;?>" type="checkbox" id="cb_NQUIZ<?=$j;?>" value="1" <? echo($fila_ramo['bool_nquiz']==1)?"checked":"";?>/>
												<? }
												if($frmModo=="ingresar"){?>
												 <input name="cb_NQUIZ<?=$j;?>" type="checkbox" id="cb_NQUIZ<?=$j;?>" value="checkbox" />
												<? } ?>
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo "&nbsp;".$fila_ramo['hrs_jec'];
													}
													if($frmModo=="modificar"){
												?>
												 <input name="txt_JEC<?=$j;?>" type="text" id="txt_JEC<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['hrs_jec'];?>"  onblur="limpia(this.form,this.id,<?=$j;?>"/>
												<? }
												if($frmModo=="ingresar"){?>
												<input name="txt_JEC<?=$j;?>" type="text" id="txt_JEC<?=$j;?>" size="5" maxlength="2" />
												<? } ?>
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo "&nbsp;".$fila_ramo['hrs_plan'];
													}
													if($frmModo=="modificar"){
												?>
												  <input name="txt_PLAN<?=$j;?>" type="text" id="txt_PLAN<?=$j;?>" size="5" maxlength="2"  value="<?=$fila_ramo['hrs_plan'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)"/>
												 <? }
												if($frmModo=="ingresar"){?>
												  <input name="txt_PLAN<?=$j;?>" type="text" id="txt_PLAN<?=$j;?>" size="5" maxlength="2"/>
												 <? } ?>
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														echo "&nbsp;".$fila_ramo['id_orden'];
													}
													if($frmModo=="modificar"){
												?>
												  <input name="txt_ORDEN<?=$j;?>" type="text" id="txt_ORDEN<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['id_orden'];?>" />
												 <? }
												if($frmModo=="ingresar"){?>
												<input name="txt_ORDEN<?=$j;?>" type="text" id="txt_ORDEN<?=$j;?>" size="5" maxlength="2" />
												<? } ?>
												
											    </div></td>
												<td><div align="center">
												<? 	if($frmModo=="mostrar"){
														switch ($fila_ramo['modo_eval']){
															case 1:
																echo "Númerico";
																break;
															case 2:
																echo "Conceptual";
																break;
															case 3:
																echo "Númerico/Conceptual";
																break;
															case 4:
																echo "Conceptual/Númerico";
																break;
															case 0:
																echo "&nbsp;";
																break;
														}
													}
													if($frmModo=="modificar" || $frmModo=="ingresar"){
												?>
												<select name="cmbEVALUACION<?=$j;?>" id="cmbEVALUACION<?=$j;?>">
												    <option value="0">seleccione</option>
												    <option value="1" <? echo ($fila_ramo['modo_eval']==1?"SELECTED":"");?>>Númerico</option>
												    <option value="2" <? echo ($fila_ramo['modo_eval']==2?"SELECTED":"");?>>Conceptual</option>
												    <option value="3" <? echo ($fila_ramo['modo_eval']==3?"SELECTED":"");?>>Númerico/Conceptual</option>
												    <option value="4" <? echo ($fila_ramo['modo_eval']==4?"SELECTED":"");?>>Conceptual/Númerico</option>
											      </select>
												<? } ?>
                                                </div></td>
												<td>
												  <div align="center">
												    <? 
														$sql = "SELECT empleado.rut_emp, empleado.nombre_emp || cast(' ' as varchar) || empleado.ape_pat || cast(' ' as varchar) || empleado.ape_mat as nombre FROM empleado inner join dicta ON empleado.rut_emp=dicta.rut_emp where dicta.id_ramo=".$fila_ramo['id_ramo'];
														$rs_dicta = pg_exec($conn,$sql);
														$rut_empleado = pg_result($rs_dicta,0);
													if($frmModo=="mostrar"){
															echo "&nbsp;".@pg_result($rs_dicta,1);
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
													 $sql ="SELECT empleado.rut_emp, empleado.ape_pat || cast(' ' as varchar) || empleado.ape_mat || cast(' ' as varchar) || empleado.nombre_emp as nombre FROM empleado,trabaja, institucion WHERE (((institucion.rdb)=".$institucion.") AND (empleado.rut_emp = trabaja.rut_emp) AND (trabaja.rdb = institucion.rdb)) ORDER BY empleado.ape_pat,empleado.ape_mat ASC  ";
														$rs_docente = @pg_exec($conn,$sql);
														
												?>
												      <select name="cmbDOCENTE<?=$j;?>" id="cmbDOCENTE<?=$j;?>">
												        <option value="0" selected="selected">seleccione</option>
												        <? for($i=0;$i<@pg_numrows($rs_docente);$i++){
															$fila_doc = @pg_fetch_array($rs_docente,$i);
															if($fila_doc['rut_emp']==$rut_empleado){
														?>
															<option value="<?=$fila_doc['rut_emp'];?>" selected="selected"><?=substr($fila_doc['nombre'],0,30);?></option>
														<? }else{ ?>											
													        <option value="<?=$fila_doc['rut_emp'];?>"><?=substr($fila_doc['nombre'],0,30);?></option>
														<?	}
											             } ?>
											          </select>
												<? } ?>
										          </div></td>
											  </tr>
											  <?  } ?>
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
											</table>

										</div>
										<div class="box">
											<table width="100%" border="1">
											  <tr>
												<td rowspan="2">Nombre</td>
												<td colspan="5"><div align="center">Examen</div></td>
												<td colspan="4"><div align="center">Prueba de Nivel </div></td>
											  </tr>
											  <tr>
												<td><div align="center">Examen</div></td>
												<td><div align="center">% examen </div></td>
												<td><div align="center">Nota<br />
												  Eximicion</div></td>
												<td><div align="center">% Escrito </div></td>
												<td><div align="center">% Oral </div></td>
												<td><div align="center">Nivel</div></td>
												<td><div align="center">% P.NIvel </div></td>
												<td><div align="center">Aprox.<br />
											    c/promedio</div></td>
												<td><div align="center">Modo<br />
												  Evaluacion</div></td>
											  </tr>
											   <? for($j=0;$j<@pg_numrows($rs_ramo);$j++){
											  		$fila_ramo = @pg_fetch_array($rs_ramo,$j);
											  ?>
											  <tr>
												<td><?=$fila_ramo['nombre'];?></td>
												<td><div align="center">
												  <? if($frmModo=="mostrar"){
												  		echo ($fila_ramo['conex']==1)?"SI":"NO";
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												  ?>
												  <input name="cb_EXAMEN<?=$j;?>" type="checkbox" id="cb_EXAMEN<?=$j;?>" value="1" <? echo($fila_ramo['conex']==1)?"checked":"";?> onclick="activar(this.form,this.id,<?=$j;?>)" />
												  <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		echo "&nbsp;".($fila_ramo['pct_examen']==0?"--":$fila_ramo['pct_examen']);
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>												  
												  <input name="txt_PEXAMEN<?=$j;?>" type="text" id="txt_PEXAMEN<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['pct_examen'];?>" <? if($fila_ramo['conex']!=1) echo "disabled";?> />
												 <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		echo "&nbsp;".($fila_ramo['nota_exim']==0?"--":$fila_ramo['nota_exim']);
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>										
												  <input name="txt_NEXAMEN<?=$j;?>" type="text" id="txt_NEXAMEN<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['nota_exim'];?>" <? if($fila_ramo['conex']!=1) echo "disabled";?>/>
												 <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		echo "&nbsp;".($fila_ramo['pct_ex_escrito']==0?"--":$fila_ramo['pct_ex_escrito']);
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>										
												  <input name="txt_ESCRITO<?=$j;?>" type="text" id="txt_ESCRITO<?=$j;?>" size="5" maxlength="3" value="<?=$fila_ramo['pct_ex_escrito'];?>" <? if($fila_ramo['conex']!=1) echo "disabled";?> onblur="validarex(this.form,this.id,<?=$j;?>)"/>
												 <? } ?>
											    </div></td>
												
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		echo "&nbsp;".($fila_ramo['pct_ex_oral']==0?"--":$fila_ramo['pct_ex_oral']);
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>		
												  <input name="txt_ORAL<?=$j;?>" type="text" id="txt_ORAL<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['pct_ex_oral'];?>" <? if($fila_ramo['conex']!=1) echo "disabled";?> onblur="validarex(this.form,this.id,<?=$j;?>)"/>
												 <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		echo "&nbsp;".($fila_ramo['prueba_nivel']==0?"NO":"SI");
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>		
												  <input name="cb_NIVEL<?=$j;?>" type="checkbox" id="cb_NIVEL<?=$j;?>" value="1" <? echo($fila_ramo['prueba_nivel']==1)?"checked":"";?> onclick="activarnivel(this.form,this.id,<?=$j;?>)"/>
												 <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		echo "&nbsp;".($fila_ramo['pct_nivel']==0?"--":$fila_ramo['pct_nivel']);
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>		
												  <input name="txt_PNIVEL<?=$j;?>" type="text" id="txt_PNIVEL<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['pct_examen'];?>" <? if($fila_ramo['prueba_nivel']!=1) echo "disabled";?>/>
												  <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		echo "&nbsp;".($fila_ramo['truncado_pnivel']==0?"NO":"SI");
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>	
												  <input name="cb_APROXN<?=$j;?>" type="checkbox" id="cb_APROXN<?=$j;?>" value="1" <? echo($fila_ramo['truncado_pnivel']==1)?"checked":"";?> <? if($fila_ramo['prueba_nivel']!=1) echo "disabled";?>/>
												  <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
												  		switch ($fila_ramo['truncado_pnivel']){
															case 0:
																echo "--";
																break;
															case 1:
																echo "Númerico";
																break;
															case 2:
																echo "Conceptual";
																break;
														}
												  }
												  if($frmModo=="modificar" || $frmModo=="ingresar"){
												 ?>	
												<select name="cmbEVALUAPRUEBANIVEL<?=$j;?>" id="cmbEVALUAPRUEBANIVEL<?=$j;?>" <? if($fila_ramo['prueba_nivel']!=1) echo "disabled";?>>
												<option value="0">seleccione</option>
												<option value="1">Númerico</option>
												<option value="2">Conceptual</option>
												</select>
												<? } ?>
												</div></td>
											  </tr>
											  <? } ?>
											</table>

										</div>
										<div class="box">
											<table width="100%" border="1">
											  <tr>
												<td rowspan="2"><div align="center">Nombre</div><div align="center"></div></td>
												<td rowspan="2"><div align="center">Apreciaci&oacute;n<br />
												M&aacute;xima</div></td>
												<td colspan="2"><div align="center">Aproximaciones</div></td>
											    <td colspan="12"><div align="center">Bonificacion</div></td>
										      </tr>
											  <tr>
												<td><div align="center">Aprox. <br />
											    Notas</div></td>
												<td><div align="center">Aprox.<br />
												  a Entero </div></td>
											    <td><div align="center">Nota<br />
										        Minima</div></td>
											    <td><div align="center">Nota<br />
										        Maxima</div></td>
											    <td><div align="center">Bonif.</div></td>
											    <td><div align="center">Nota<br />
										        Minima</div></td>
											    <td><div align="center">Nota<br />
										        Maxima</div></td>
											    <td><div align="center">Bonif.</div></td>
											    <td><div align="center">Nota<br />
										        Minima</div></td>
											    <td><div align="center">Nota<br />
										        Maxima</div></td>
											    <td><div align="center">Bonif.</div></td>
											    <td><div align="center">Nota<br />
											      Minima</div></td>
											    <td><div align="center">Nota<br />
											      Maxima</div></td>
											    <td><div align="center">Bonif.</div></td>
											  </tr>
											 <? for($j=0;$j<@pg_numrows($rs_ramo);$j++){
											  		$fila_ramo = @pg_fetch_array($rs_ramo,$j);
											  ?>
											  <tr>
												<td><?=$fila_ramo['nombre'];?></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['apreciacion']==0?"--":$fila_ramo['apreciacion']);
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
												  <input name="txt_APRECIACION<?=$j;?>" type="text" id="txt_APRECIACION<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['apreciacion'];?>" onfocus="limpia(this.form,this.id)" />
												 <? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['truncado']==1?"SI":"NO");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
												  <input name="cb_APROX<?=$j;?>" type="checkbox" id="cb_APROX<?=$j;?>" value="1" <? echo ($fila_ramo['truncado']==1?"checked":"");?>/>
												<? } ?>
											    </div></td>
												<td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['aprox_entero']==1?"SI":"NO");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
												  <input name="cb_APROXENTERO<?=$j;?>" type="checkbox" id="cb_APROXENTERO<?=$j;?>" value="1" <? echo ($fila_ramo['aprox_entero']==1?"checked":"");?>/>
												<? } ?>
											    </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['minima1']>0?$fila_ramo['minima1']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
											      <input name="txt_MINIMA1<?=$j;?>" type="text" id="txt_MINIMA1<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['minima1'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMinima(this.form,this.id)"/>
												<? } ?>
										        </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['maxima1']>0?$fila_ramo['maxima1']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
											      <input name="txt_MAXIMA1<?=$j;?>" type="text" id="txt_MAXIMA1<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['maxima1'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMaxima(this.form,this.id,<?=$j;?>,1)"/>
												<? } ?>
										        </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['bonifica1']>0?$fila_ramo['bonifica1']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
											      <input name="txt_BONIFICA1<?=$j;?>" type="text" id="txt_BONIFICA1<?=$j;?>" size="5" maxlength="4" value="<?=$fila_ramo['bonifica1'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaBonifica(this.form,this.id)"/>
											    <? } ?>
										        </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['minima2']>0?$fila_ramo['minima2']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
											      <input name="txt_MINIMA2<?=$j;?>" type="text" id="txt_MINIMA2<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['minima2'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMinima(this.form,this.id)"/>
												<? } ?>
										        </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['maxima2']>0?$fila_ramo['maxima2']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
											      <input name="txt_MAXIMA2<?=$j;?>" type="text" id="txt_MAXIMA2<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['maxima2'];?>"  onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMaxima(this.form,this.id,<?=$j;?>,2)"/>
												<? } ?>
										        </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['bonifica2']>0?$fila_ramo['bonifica2']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
												<input name="txt_BONIFICA2<?=$j;?>" type="text" id="txt_BONIFICA2<?=$j;?>" size="5" maxlength="4" value="<?=$fila_ramo['bonifica2'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" />
												<? } ?>
										        </div></td>
											    <td><div align="center">
											      <? if($frmModo=="mostrar"){
														echo ($fila_ramo['minima3']>0?$fila_ramo['minima3']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
											      <input name="txt_MINIMA3<?=$j;?>" type="text" id="txt_MINIMA3<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['minima3'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMinima(this.form,this.id)"/>
												<? } ?>
										        </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['maxima3']>0?$fila_ramo['maxima3']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>											
											      <input name="txt_MAXIMA3<?=$j;?>" type="text" id="txt_MAXIMA3<?=$j;?>" size="5" maxlength="4" value="<?=$fila_ramo['maxima3'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMaxima(this.form,this.id,<?=$j;?>,3)"/>
												<? } ?>
										        </div></td>
											    <td><div align="center">
												<? if($frmModo=="mostrar"){
														echo ($fila_ramo['bonifica3']>0?$fila_ramo['bonifica3']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
											      <input name="txt_BONIFICA3<?=$j;?>" type="text" id="txt_BONIFICA3<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['bonifica3'];?>"  onfocus="limpia(this.form,this.id,<?=$j;?>)"/>
												<? } ?>
										        </div></td>
											    <td><div align="center">
                                                    <? if($frmModo=="mostrar"){
														echo ($fila_ramo['minima4']>0?$fila_ramo['minima4']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
                                                    <input name="txt_MINIMA4<?=$j;?>" type="text" id="txt_MINIMA4<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['minima4'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMinima(this.form,this.id)"/>
                                                    <? } ?>
                                                </div></td>
											    <td><div align="center">
                                                    <? if($frmModo=="mostrar"){
														echo ($fila_ramo['maxima4']>0?$fila_ramo['maxima4']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
                                                    <input name="txt_MAXIMA4<?=$j;?>" type="text" id="txt_MAXIMA4<?=$j;?>" size="5" maxlength="4" value="<?=$fila_ramo['maxima4'];?>" onfocus="limpia(this.form,this.id,<?=$j;?>)" onblur="ValidaMaxima(this.form,this.id,<?=$j;?>,3)"/>
                                                    <? } ?>
                                                </div></td>
											    <td><div align="center">
                                                    <? if($frmModo=="mostrar"){
														echo ($fila_ramo['bonifica4']>0?$fila_ramo['bonifica4']:"--");
													}
													if($frmModo=="ingresar" || $frmModo=="modificar"){
												?>
                                                    <input name="txt_BONIFICA4<?=$j;?>" type="text" id="txt_BONIFICA4<?=$j;?>" size="5" maxlength="2" value="<?=$fila_ramo['bonifica4'];?>"  onfocus="limpia(this.form,this.id,<?=$j;?>)"/>
                                                    <? } ?>
                                                </div></td>
											  </tr>
											  <? } ?>
											</table>

										</div>
									  <div class="box">
									    <table width="100%" border="1">
                                              <tr>
                                                <td>Nombre</td>
                                                <td>Formaci&oacute;n</td>
                                              </tr>
                                              <? if($frmModo!="mostrar"){?>

                                              <? } ?>
                                              <? for($j=0;$j<@pg_numrows($rs_ramo);$j++){
											  		$fila_ramo = @pg_fetch_array($rs_ramo,$j);
											  ?>
                                              <input name="ramo<?=$j;?>2" type="hidden" value="<?=$fila_ramo['id_ramo'];?>" />
                                              <tr>
                                                <td><?=$fila_ramo['nombre'];?></td>
                                                <td>
												<? if($frmModo=="ingresar"){?>
												<select name="cmbFORMACION<?=$j;?>">
                                                  <option value="1" selected="selected">Formaci&oacute;n General</option>
                                                  <option value="2">Formaci&oacute;n Diferenciada</option>
                                                  <option value="3">Formaci&oacute;n Intrumental</option>
                                                </select>
												<? }
												if($frmModo=="modificar"){?>
												<select name="cmbFORMACION<?=$j;?>">
                                                  <option value="1" <? if($fila_ramo['formacion']==1){ echo "selected"; }else{ echo "&nbsp;";}?>>Formaci&oacute;n General</option>
                                                  <option value="2" <? if($fila_ramo['formacion']==2){ echo "selected"; }else{ echo "&nbsp;";}?>>Formaci&oacute;n Diferenciada</option>
                                                  <option value="3" <? if($fila_ramo['formacion']==3){ echo "selected"; }else{ echo "&nbsp;";}?>>Formaci&oacute;n Intrumental</option>
                                                </select>
												 
												<? } 
													if($frmModo=="mostrar"){
														if($fila_ramo['formacion']==1){
															echo "General";
														}elseif($fila_ramo['formacion']==2){
															echo "Diferenciada";
														}elseif($fila_ramo['formacion']==3){
															echo "Intrumental";
														}
													}
													?>
												</td>
                                              </tr>
                                              <?  } ?>
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
								  </td>
                                </tr>
                              </table>
							  </form>
							  </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"> <? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
<?     pg_close($conn);
	pg_close($connection);?>