<?
require('../../../../../util/header.inc');
include ("Calendario/calendario.php");
require('../../../../../util/funciones_new.php'); 


   
   foreach($_REQUEST as $nombre_campo => $valor)
   { 
    $asignacion = "\$" . $nombre_campo . "='" . $valor . "';"; 
	eval($asignacion);
	//echo "asignacion=$asignacion<br>";
   } 



	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$curso			=$_CURSO;
	$_POSP = 5;
	$_bot = 6;
	
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	// REGISTRO DE HISTORIAL DE NAVEGACION
	registrarnavegacion($_USUARIO,'Calendario Actividades ',1,0,$_SERVER[REMOTE_ADDR],pg_dbname($conn),ObtenerNavegador($_SERVER['HTTP_USER_AGENT']),$_INSTIT,$_NOMBREUSUARIO,$_CURSO,$conn);
	//******************************************************//
		
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

$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL;
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
}

if($_PERFIL==15 || $_PERFIL==16)
{
$sql_ano_actual = "select * from curso where id_curso = ".$curso." order by ensenanza,grado_curso,letra_curso";
$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);
}
else
{
//busco cursos
$sql_ano_actual = "select * from curso where id_ano = ".$ano." $whe_perfil_curso order by ensenanza,grado_curso,letra_curso";
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
	echo "aa";
  $sql_act="select * from calendario_actividades where id_curso=".$id_curso." and fecha_inicio>='".CambioFE($fecha_inicio2)."' and fecha_termino<='".CambioFE($fecha_termino2)."' order by fecha_inicio";
$res_act = @pg_Exec($conn,$sql_act)or die('no hize2');
 $encontrados=pg_numrows($res_act);

}
  elseif($subsector>0 and $id_curso>0 and (strlen($fecha_inicio2)>0) and (strlen($fecha_termino2)>0) and $nuevo==1)
{
	
  $sql_act="select * from calendario_actividades where id_curso=".$id_curso." and id_subsector=".$subsector." and fecha_inicio>='".CambioFE($fecha_inicio2)."' and fecha_termino<='".CambioFE($fecha_termino2)."' order by fecha_inicio";
$res_act = @pg_Exec($conn,$sql_act) or die('no hize3');
 $encontrados=pg_numrows($res_act);
}
elseif($subsector==0 and $id_curso>0 and (strlen($fecha_inicio2)==0) and (strlen($fecha_termino2)==0) and $nuevo==1)
{
  $sql_act="select * from calendario_actividades where id_curso=".$id_curso."   order by fecha_inicio";
$res_act = @pg_Exec($conn,$sql_act) or die('no hize3');
 $encontrados=pg_numrows($res_act);
}



if($nuevo==1)
$ch="checked";
if($nuevo==2)
$ch2="checked";

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

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<script language="JavaScript" src="Calendario/javascripts.js"></script>
<style>
.ui-datepicker-trigger { position:relative;height:16px;width:16px }
</style>
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>

<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">
<script language="javascript">
// A $( document ).ready() block.
$( document ).ready(function() {
<?php $campos=($_PERFIL==15 || $_PERFIL==16)?"#fecha_inicio2,#fecha_termino2":"#fecha_inicio2,#fecha_termino2,#fecha_inicio,#fecha_termino"?>

 $( "<?php echo $campos ?>" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	showOn: "both",
    
	changeMonth: true,
	
	minDate: new Date('<?php echo $nro_ano ?>/01/01'),
    maxDate: new Date('<?php echo $nro_ano ?>/12/31'),
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
	
});
});


</script>
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
  form.action='CalCurso.php';
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
function visible(nuevo,form){
if(document.getElementById(nuevo).value==1){
busca_alum.style.display='block';
act.style.display='none';
lista.style.display='block';
/*mmes1.style.display='block';
mmes2.style.display='block';
mmes3.style.display='block';
mmes4.style.display='block';*/
mmes1.style.visibility='visible';
mmes2.style.visibility='visible';
mmes3.style.visibility='visible';
mmes4.style.visibility='visible';

 


}
if(document.getElementById(nuevo).value==2){
busca_alum.style.display='none';
act.style.display='block';
lista.style.display='none';
/*mmes1.style.display='none';
mmes2.style.display='none';
mmes3.style.display='none';
mmes4.style.display='none';*/
mmes1.style.visibility='hidden';
mmes2.style.visibility='hidden';
mmes3.style.visibility='hidden';
mmes4.style.visibility='hidden';

}

}//-->
</script>
<SCRIPT LANGUAGE="JavaScript">
<!-- Begin
function popUp(URL) {
day = new Date();
id = day.getTime();
eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=699,height=299,left = 330.5,top = 412.5');");
}
// End -->
</script>


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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')" >
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
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								  <table width="" height="0" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td width="" height="0" align="center" valign="top"> 
    <!--<img src="../../../../../images/Optimizando_Modulo2.gif">-->
    </td></tr>
      
	  
  
</table>
<!-- FIN CODIGO DE BOTONES -->
<!-- INICIO FORMULARIO DE BUSQUEDA -->
<table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
					<form action="<? echo $PHP_SELF;?>"  method="post" name="form" onSubmit="return comprobar(this)">
					  <table  width="80%"border="0" cellspacing="0" cellpadding="0" align="center">
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
                                        <td colspan="5"> <p class="texto">NOTA: SE DEBE TENER CUIDADO CON LOS AÑOS DE LAS FECHAS DE INICIO Y TÉRMINO. ESTE MÓDULO TRABAJA EN EL AÑO ACTIVO. (EJ: SI EL AÑO ACTIVO ES 2008, EL AÑO QUE APARECERA EN LAS FECHAS DE INICIO Y TÉRMINO DE LA ACTIVIDAD ES 2008).</p></td>
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
                                        <td colspan="2" class="texto"><input name="nuevo" type="radio" value="1" id="nuevo1" onClick="visible(this.id,this.form)" <?php echo $ch ?>>
                                          Buscar</td>
                                        </tr>
                                      <tr>
                                        <td class="texto"><div align="left">Subsector</div></td>
                                        <td class="texto"><select name="subsector"  <?php if($_PERFIL!=15 && $_PERFIL!=16){?>onChange="cambia(this.form)"<?php }?> >
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
                                        <td colspan="2" class="texto">
										<?php
										
										 if($_PERFIL != 15 && $_PERFIL != 16){?>	
										 <input name="nuevo" type="radio" value="2" id="nuevo2" onClick="visible(this.id,this.form)" <?php echo $ch2 ?>>Agregar <?php }
										 
										?></td>
                                        </tr>
									
                                    
									  <tr>
                                        <td class="texto"><div  id="mmes1" style="visibility:hidden"> Fecha Inicio      &nbsp;&nbsp;&nbsp;</div></td><!---->
                                        <td colspan="4" class="texto"><div style="visibility:hidden" id="mmes2"><input name="fecha_inicio2" id="fecha_inicio2" readonly size="12" placeholder="Seleccionar"/>
										<?php if($_PERFIL==15 || $_PERFIL==16){echo escribe_formulario_fecha_vacio("fecha_inicio2", "form", "", ''); }?>
                                </div></td>
                                      </tr>
                                      <tr>
                                        <td class="texto"><div style="visibility:hidden" id="mmes3">Fecha Término  </div></td>
                                        <td colspan="4" class="texto"><div style="visibility:hidden" id="mmes4"><input name="fecha_termino2" id="fecha_termino2" readonly type="text" size="12" placeholder="Seleccionar">
								            <?php if($_PERFIL==15 || $_PERFIL==16){echo escribe_formulario_fecha_vacio("fecha_termino2", "form", "", ''); }?>
                                        </div></td>
                                      </tr>
									
                                      <tr>
                                        <td class="texto">&nbsp;</td>
                                        <td class="texto">&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td width="3%">&nbsp;</td>
                                        <td width="26%">&nbsp;</td>
                                      </tr>
                                      <tr>
                                     <td colspan="5"><div align="center" id="busca_alum" style="display:none"  >
									<input type="submit" value="Buscar" onClick="validar(this.form)" name="busca_alum" class="botonxx"   >
                                      </div> </td>
                                        </tr>
                                    </table>
							  
							</form>
<!-- FIN FORMULARIO DE BUSQUEDA -->
<div id="lista" >
<br>
                              <br>
							 
							  <?php if ($id_curso!=0 and $nuevo==1)
							{?>
							
<br>
<table  width="80%" border="0" cellspacing="0" cellpadding="0" align="center" >
                              <tr  class="tableindex">
                                <td colspan="8"><div align="center"><span class="texto">
                                  </span>Listado Actividades </div></td>
                                </tr>
                              <tr>
                                <?php if($subsector==0 and $id_curso>0)
								{?>
								<td width="14%" class="texto"><div align="center"><strong>Subsector</strong></div></td>
								<?php  } ?>
                                <td width="19%" class="texto"><div align="center"><strong>Actividad</strong></div></td>
                                <td width="10%" class="texto"><div align="center"><strong>Fecha Inicio </strong></div></td>
                                <td width="9%" class="texto"><div align="center"><strong>Hora Inicio </strong></div></td>
                                <td width="12%" class="texto"><div align="center"><strong>Fecha T&eacute;rmino  </strong></div></td>
                                <td width="12%" class="texto"><div align="center"><strong>Hora T&eacute;rmino </strong></div></td>
								<?php if($_PERFIL==0 || $_PERFIL==27 || $_PERFIL==17 || $_PERFIL==8 || $_PERFIL==14)
{?>
								<td width="13%" class="texto"><div align="center"><strong>Modificar</strong></div></td>
								<?php }?>
								<?php if($_PERFIL==0 || $_PERFIL==27 || $_PERFIL==17 || $_PERFIL==8 || $_PERFIL==14)
{?>
                                <td width="11%" class="texto"><div align="center"><strong>Eliminar</strong></div></td>
								<?php }?>
                              </tr>
                              <tr>
                                <td colspan="8" class="texto"><hr></td>
                                </tr>
							 <?php  for($z=0;$z<$encontrados;$z++)
							  {
							  	$fil_act=@pg_fetch_array($res_act,$z);
							  ?>
                              <tr>
							  <?php if($subsector==0 and $id_curso>0)
								{
									
											$cod_subsector=$fil_act['cod_subsector'];
											//busco nombre subsector
											$sql_nom_sub="select * from subsector where cod_subsector=".$cod_subsector;
											$res_nom_sub=pg_exec($conn,$sql_nom_sub);
											$fil_nombre=@pg_fetch_array($res_nom_sub,0);
								
								?>
                                <td class="texto"><?php echo $fil_nombre['nombre'] ?></td>
								<?php }?>
                                <td class="texto"><?php echo $fil_act['actividad'] ?></td>
                                <td class="texto"><div align="center"><?php echo CambioFD($fil_act['fecha_inicio']) ?></div></td>
                                <td class="texto"><div align="center"><?php echo $fil_act['hora_inicio'] ?></div></td>
                                <td class="texto"><div align="center"><?php echo CambioFD($fil_act['fecha_termino']) ?></div></td>
                                <td class="texto"><div align="center"><?php echo $fil_act['hora_termino'] ?></div></td
								><?php if($_PERFIL==0 || $_PERFIL==27 || $_PERFIL==17 || $_PERFIL==8 || $_PERFIL==14  )
{?>
								<td class="texto"><form>
                                  <div align="center">
                                    <input type="button" name="Submit2" value="OK" onClick="javascript:popUp('ActualizaActividad.php?id_actividad=<?php echo $fil_act['id_actividad'] ?>&id_curso=<?php echo $fil_act['id_curso'] ?>&subsector=<?php echo $subsector ?>&fecha_inicio2=<?php echo $fecha_inicio2 ?>&fecha_termino2=<?php echo $fecha_termino2 ?>&nuevo=1')" class="botonxx">
                                  </div>
								</form></td>
								<?php }?>
								<?php if($_PERFIL==0 || $_PERFIL==27 || $_PERFIL==17 || $_PERFIL==8  || $_PERFIL==14 )
{?>
                                <td class="texto"><div align="center">
								<form>
                                  <input type="hidden" name="fecha_inicio3" value="<?php echo $fecha_inicio2 ?>">
								  <input type="hidden" name="fecha_termino3" value="<?php echo $fecha_termino2 ?>">
                                  <input type="button" name="Submit2" value="OK" onClick="javascript:window.open('EliminaActividad.php?id_actividad=<?php echo $fil_act['id_actividad'] ?>&id_curso=<?php echo $fil_act['id_curso'] ?>&subsector=<?php echo $subsector ?>&fecha_inicio2=<?php echo $fecha_inicio2 ?>&fecha_termino2=<?php echo $fecha_termino2 ?>&nuevo=1','_self')" class="botonxx">
								  </form>
                                </div></td>
								<?  } ?>
                              </tr>
                              <tr>
                                <td colspan="8" class="texto"><hr></td>
                                </tr>
							  <?php }?>
                            </table>
							<?php }?></div><!-- -->
							<div id="act" style="display:none" ><br>
<?php 
if($_PERFIL!=15 && $_PERFIL!=16)
{
	
?>
<form name="form2" if="form2" method="post" action="IngresaActividad.php" onSubmit="return vale(this)">
<table  width="589" border="0" cellspacing="0" cellpadding="0" align="center">
                              <tr  class="tableindex">
                                <td colspan="5"><div align="center">
                                  <input name="id_curso" type="hidden" value="<?php echo $id_curso ?>">
                                  <input name="subsector" type="hidden" value="<?php echo $subsector ?>">
                                  <input name="id_ano" type="hidden" value="<?php echo $ano ?>">
                                  <input name="rdb" type="hidden" value="<?php echo $institucion ?>">
								  
								  
								  <?php 
								 $sql_nom_sub="select * from ramo where id_ramo=".$subsector;
								  $res_nom_sub=pg_exec($conn,$sql_nom_sub);
								  $fil_cod=@pg_fetch_array($res_nom_sub,0);
								  
									?>
											
 Nueva Actividad </div></td>
                                </tr>
                              <tr>
                                <td colspan="5">&nbsp;</td>
                                </tr>
                              <tr>
                                <td width="32%" class="texto"><div align="center"><strong>Actividad</strong></div></td>
                                <td width="16%" class="texto"><div align="center"><strong>Fecha Inicio </strong>
                                    
                                   
                                </div></td>
                                <td width="17%" class="texto"><div align="center"><strong>Hora Inicio </strong></div></td>
                                <td width="18%" class="texto"><div align="center"><strong>Fecha T&eacute;rmino </strong></div></td>
                                <td width="17%" class="texto"><div align="center"><strong>Hora T&eacute;rmino </strong></div></td>
                              </tr>
                              <tr>
                                <td><div align="center">
                                  <input name="actividad" type="text" id="actividad" size="30">
                                </div></td>
                                <td><div align="center"><input name="fecha_inicio" id="fecha_inicio" size="12" readonly placeholder="Seleccionar"/>
                                  </div></td>
                                <td><div align="center">
                                  <select name="hora_ini" >
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                  </select>
                                  : 
                                  <select name="min_ini" >
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                  </select>
                                </div></td>
                                <td><div align="center">
								<input name="fecha_termino"type="text" size="12" readonly  id="fecha_termino" placeholder="Seleccionar">
								
                                </div></td>
                                <td><div align="center">
                                  <select name="hora_ter" id="hora_ter" >
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                  </select>
                                  : 
                                  <select name="min_ter" id="min_ter" >
                                    <option value="00">00</option>
                                    <option value="01">01</option>
                                    <option value="02">02</option>
                                    <option value="03">03</option>
                                    <option value="04">04</option>
                                    <option value="05">05</option>
                                    <option value="06">06</option>
                                    <option value="07">07</option>
                                    <option value="08">08</option>
                                    <option value="09">09</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="27">27</option>
                                    <option value="28">28</option>
                                    <option value="29">29</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="32">32</option>
                                    <option value="33">33</option>
                                    <option value="34">34</option>
                                    <option value="35">35</option>
                                    <option value="36">36</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="39">39</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option>
                                    <option value="42">42</option>
                                    <option value="43">43</option>
                                    <option value="44">44</option>
                                    <option value="45">45</option>
                                    <option value="46">46</option>
                                    <option value="47">47</option>
                                    <option value="48">48</option>
                                    <option value="49">49</option>
                                    <option value="50">50</option>
                                    <option value="51">51</option>
                                    <option value="52">52</option>
                                    <option value="53">53</option>
                                    <option value="54">54</option>
                                    <option value="55">55</option>
                                    <option value="56">56</option>
                                    <option value="57">57</option>
                                    <option value="58">58</option>
                                    <option value="59">59</option>
                                  </select>
                                </div></td>
                              </tr>
                              <tr>
                                <td colspan="5">&nbsp;</td>
                                </tr>
                              <tr>
                                <td colspan="5"><div align="center">
                                  <input type="submit" name="Submit" value="Ingresar Actividad" class="botonxx">
                                </div></td>
                                </tr>
                            </table>
</form>							<?php }

?><p>&nbsp;</p></div>
                             
                           </td>
                                </tr>
                              </table>
</td>
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
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>