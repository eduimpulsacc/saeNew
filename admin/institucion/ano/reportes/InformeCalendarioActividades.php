<?
require('../../../../util/header.inc');
include ("../curso/CalActividades/Calendario/calendario.php");

function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d."/".$m."/".$a;
	else
		$retorno="";
	return $retorno;
}

function CambioFecha($fecha)   //    cambia fecha del tipo  dd/mm/aaaa  ->  aaaa/mm/dd    para poder hacer insert y update
{
	$retorno="";
	if(strlen($fecha) !=10)
		return $retorno;
	$d=substr($fecha,0,2);
	$m=substr($fecha,3,2);
	$a=substr($fecha,6,4);
	if (checkdate($m,$d,$a))
		$retorno=$a."-".$m."-".$d;
	else
		$retorno="";
	return $retorno;
}


foreach($_GET as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	
	 "asignacion=$asignacion<br>";
   }
   
   foreach($_POST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
   } 



	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$_POSP = 4;
	$_bot = 6;
	
	
//nombre institucion
$sql_inst = "select * from institucion where rdb = ".$institucion;
$res_inst = @pg_Exec($conn,$sql_inst);
$fil_inst = @pg_fetch_array($res_inst,0);
$nom_inst = $fil_inst['nombre_instit'];

//busco año
$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
$result_ano =@pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
$nro_ano = $fila_ano['nro_ano'];

if($_PERFIL==15 || $_PERFIL==16)
{
$sql_ano_actual = "select * from curso where id_curso = ".$curso." order by ensenanza,grado_curso,letra_curso";
$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
}
else
{
//busco cursos
$sql_ano_actual = "select * from curso where id_ano = ".$ano." order by ensenanza,grado_curso,letra_curso";
$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
}

//busco ramos
$sql_ramo="select * from ramo where id_curso=".$id_curso;
$res_ramo = @pg_Exec($conn,$sql_ramo);
	
switch ($cmb_mes)
{

	case 3:
	$fin_dia=31;
	$sel3="selected";
	break;
	
	case 4:
	$fin_dia=30;
	$sel4="selected";
	break;
	
	case 5:
	$fin_dia=31;
	$sel5="selected";
	break;
	
	case 6:
	$fin_dia=30;
	$sel6="selected";
	break;
	
	case 7:
	$fin_dia=31;
	$sel7="selected";
	break;
	
	case 8:
	$fin_dia=31;
	$sel8="selected";
	break;
	
	case 9:
	$fin_dia=30;
	$sel9="selected";
	break;
	
	case 10:
	$fin_dia=31;
	$sel10="selected";
	break;
	
	case 11:
	$fin_dia=30;
	$sel11="selected";
	break;
	
	case 12:
	$fin_dia=31;
	$sel12="selected";
	break;


}	
	
	
//busco actividades
 if($act==1)
{
 $sql_act="select * from calendario_actividades where id_curso=$id_curso order by id_actividad desc limit 1";
$res_act = @pg_Exec($conn,$sql_act) or die('no hize1');
 $encontrados=pg_numrows($res_act);
} 

elseif($subsector==0 and $id_curso>0 and (strlen($fecha_inicio2)>0) and (strlen($fecha_termino2)>0) and $nuevo==1)
{
  $sql_act="select * from calendario_actividades where id_curso=".$id_curso." and fecha_inicio>='".CambioFecha($fecha_inicio2)."' and fecha_termino<='".CambioFecha($fecha_termino2)."' order by fecha_inicio";
$res_act = @pg_Exec($conn,$sql_act)or die('no hize2');
 $encontrados=pg_numrows($res_act);

}
  elseif($subsector>0 and $id_curso>0 and (strlen($fecha_inicio2)>0) and (strlen($fecha_termino2)>0) and $nuevo==1)
{
 echo $sql_act="select * from calendario_actividades where id_curso=".$id_curso." and id_subsector=".$subsector." and fecha_inicio>='".CambioFecha($fecha_inicio2)."' and fecha_termino<='".CambioFecha($fecha_termino2)."' order by fecha_inicio";
$res_act = @pg_Exec($conn,$sql_act) or die('no hize3');
 $encontrados=pg_numrows($res_act);
}

if($nuevo==1)
$ch="checked";
if($nuevo==2)
$ch2="checked";
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" media="all" href="../../../../estadisticas/widgets/calendar-brown.css" title="green"/>
<script language="javascript" src="../curso/CalActividades/Calendario/javascripts.js"></script>
<script language="JavaScript" src="../../../../estadisticas/widgets/calendar.js"></script>
<script language="JavaScript" src="../../../../estadisticas/widgets/calendar-setup.js"></script>
<script language="JavaScript" src="../../../../estadisticas/widgets/lang/calendar-es.js"></script>
<SCRIPT type="text/javascript" src="../../../../estadisticas/js/mootools.js"></SCRIPT>
<SCRIPT type="text/javascript" src="../../../../estadisticas/js/moodalbox.js"></SCRIPT>
<script language="javascript">



function vale(form2)
{
	if (form2.actividad.value=="")
	{
		alert("Escriba Actividad ");
		form2.actividad.focus();
		return false
	}
	
	if (form2.fecha_inicio.value=="")
	{
		alert("Indique Fecha Inicio Actividad ");
		form2.fecha_inicio.focus();
		return false
	}
	
	if (form2.fecha_termino.value=="")
	{
		alert("Indique Fecha Término Actividad ");
		form2.fecha_termino.focus();
		return false
	}
}

function comprobar(form)
{
	if (form.curso.value==0)
	{
		alert("Seleccione Curso ");
		form.curso.focus();
		return false
	}

	if (form.cmb_mes.value==0)
	{
		alert("Seleccione Mes ");
		form.cmb_mes.focus();
		return false
	}

}

function HacerSubmit(form)
{
  // alert("hacersubmit"+form.I_imptotal.value)
  form.subsector.value=0;
  form.action='InformeCalendarioActividades.php';
  form.target='_self';
   form.submit();
}	

function cambia (){
form2.subsector.value=form.subsector.value;

}</script>
<script language="JavaScript" type="text/JavaScript">
<!--

<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function valida_ingreso(){
	if((document.frm1.BUSCARX[0].checked)&&(document.frm1.filtroRUT.value=="")){
		alert("Debe ingresar Rut");
		return;
	}
	if((document.frm1.BUSCARX[1].checked)&&(document.frm1.Apellido.value=="")){
		alert("Debe ingresar Apellido");
		return;
	}
	document.frm1.submit();
}
//-->


}//-->
</script>
<SCRIPT language="JavaScript" src="../../../../util/chkform.js"></SCRIPT>

<style type="text/css">
<!--
#Layer1 {
	position:absolute;
	left:238px;
	top:567px;
	width:620px;
	height:125px;
	z-index:1;
}
#Layer2 {
	position:absolute;
	left:239px;
	top:580px;
	width:615px;
	height:133px;
	z-index:1;
}
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')" >
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<style>
.texto {
	font-family: Verdana;
	font-size: 10px;
}
</style>
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><table width="100%"><tr><td><table width="100%"><tr><td><table width="100%"><tr><td><?
				include("../../../../cabecera/menu_superior.php");
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
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
   
</table>
<!-- FIN CODIGO DE BOTONES -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
					<form action="printInformeCalendarioActividades_C.php"  method="post" name="form" onSubmit="return comprobar(this)" target="_blank" >
					  <table  width="589"border="0" cellspacing="0" cellpadding="0" align="center">
                                      <tr class="tableindex">
                                        <td colspan="5"><div align="center">Calendario Actividades  </div></td>
                                      </tr>
                                      <tr>
                                        <td width="27%">&nbsp;</td>
                                        <td width="30%">&nbsp;</td>
                                        <td width="14%">&nbsp;</td>
                                        <td colspan="2"><div align="right">
										
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td colspan="5"> <p class="texto">NOTA: SE DEBE TENER CUIDADO CON LOS AÑOS DE LAS FECHAS DE INICIO Y TÉRMINO. ESTE MÓDULO TRABAJA EN EL AÑO ACTIVO. (EJ: SI EL AÑO ACTIVO ES 2008, EL AÑO QUE SE DEBE CONFIGURAR EN LAS FECHAS DE INICIO Y TÉRMINO DE LA ACTIVIDAD ES 2008).</p></td>
                                        </tr>
                                      <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td colspan="2">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td colspan="5" class="texto">
                                          <div align="left">Establecimiento <strong><?php echo $nom_inst ?></strong></div></td>
                                        </tr>
                                      <tr>
                                        <td class="texto">&nbsp;</td>
                                        <td colspan="4" class="texto">&nbsp;</td>
                                      </tr>
                                      <tr>
                                        <td class="texto"><div align="left">Curso</div></td>
                                        <td class="texto"><select name="id_curso" onChange="HacerSubmit(this.form)">
                                          <option value="0">--Seleccione--</option>
                                          <?php for($i=0;$i<pg_numrows($res_ano_actual);$i++)
								{
									$fil_cur = @pg_fetch_array($res_ano_actual,$i);
									//tipo enseñanza
									$sql_ense="select * from tipo_ensenanza where cod_tipo= ".$fil_cur['ensenanza'];
									$res_ense=pg_exec($conn,$sql_ense);
									$fil_ense = @pg_fetch_array($res_ense,0);
									
									$nom_cur=$fil_cur['grado_curso'].$fil_cur['letra_curso'];
									$id_cur=$fil_cur['id_curso'];
									$nom_ese=$fil_ense['nombre_tipo'];
									
									$selected="";
									if($id_curso==$id_cur)
									$selected="selected";
									
								?>
                                          <option value="<?php echo $id_cur ?>" <?php echo $selected ?>><?php echo $nom_cur ?> - <?php echo $nom_ese ?></option>
                                          <?php }?>
                                        </select></td>
                                        <td class="texto">&nbsp;</td>
                                        <td colspan="2" class="texto">&nbsp;</td>
                                        </tr>
                                      <tr>
                                        <td class="texto"><div align="left">Subsector</div></td>
                                        <td class="texto"><select name="subsector" onChange="cambia(this.form)" >
                                          <option value="0">--Seleccionar Todos--</option>
										 <?php  for ($j=0;$j<pg_numrows($res_ramo);$j++)
										  {
										  	$fil_ramo = @pg_fetch_array($res_ramo,$j);
											$cod_subsector=$fil_ramo['cod_subsector'];
											//busco nombre subsector
											$sql_nom_sub="select * from subsector where cod_subsector=".$cod_subsector;
											$res_nom_sub=pg_exec($conn,$sql_nom_sub);
											$fil_nombre=@pg_fetch_array($res_nom_sub,0);
											
											$selected="";
											if($subsector==$fil_ramo['id_ramo'])
											$selected="selected";
										  ?>
										  <option value="<?php echo $fil_ramo['id_ramo'] ?>" <?php echo $selected ?>><?php echo $fil_nombre['nombre'] ?></option>
										  <?php }?>
                                        </select></td>
                                        <td class="texto">&nbsp;</td>
                                        <td colspan="2" class="texto">&nbsp;</td>
                                        </tr>
									
                                    
									  <tr>
                                        <td class="texto">Fecha Inicio      &nbsp;&nbsp;&nbsp;
                                          <input name="button3" type="image" src="../curso/CalActividades/Calendario/calendario.gif" class="botadd" id="txtFecha2" value="." height="20" width="20"></td><!--style="display:none"-->
                                        <td colspan="4" class="texto"><input name="fecha_inicio2" size="12"/>
                                  <script type="text/javascript">
									Calendar.setup({
										inputField     :    "fecha_inicio2",      // id of the input field
										ifFormat       :    "%d/%m/%Y",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha2",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									</script></td>
                                      </tr>
                                      <tr>
                                        <td class="texto">Fecha Término  <input name="button4" type="image" src="../curso/CalActividades/Calendario/calendario.gif" class="botadd" id="txtFecha_t2" value="." height="20" width="20"></td>
                                        <td colspan="4" class="texto"><input name="fecha_termino2" type="text" size="12">
								<script type="text/javascript">
									Calendar.setup({
										inputField     :    "fecha_termino2",      // id of the input field
										ifFormat       :    "%d/%m/%Y",  // format of the input field (even if hidden, this format will be honored)
										button         :    "txtFecha_t2",  // trigger button (well, IMG in our case)
										align          :    "Bl",           // alignment (defaults to "Bl")
										singleClick    :    true,
										mondayFirst	   :    true
									});
									</script></td>
                                      </tr>
									
                                      <tr>
                                        <td class="texto">&nbsp;</td>
                                        <td class="texto">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="3%">&nbsp;</td>
                                        <td width="26%">&nbsp;</td>
                                      </tr>
                                      <tr>
                                     <td colspan="5">
									   <div align="center">
									     <input type="submit" value="Buscar" onClick="validar(this.form)" name="busca_alum" class="botonxx"   >                                      
									     <input name="cb_ok2" type="button" class="botonXX" id="cb_ok2" value="Volver"onClick="window.location='Menu_Reportes_new2.php'">
									   </div></td>
                                        </tr>
                                    </table>
							  
							</form>
<!-- FIN FORMULARIO DE BUSQUEDA -->
</td>
                                </tr>
                              </table>
</td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>