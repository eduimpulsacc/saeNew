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
	
	echo "asignacion=$asignacion<br>";
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


$sql_ano_actual = "select * from curso where id_curso = ".$id_curso." order by ensenanza,grado_curso,letra_curso";
$res_ano_actual = @pg_Exec($conn,$sql_ano_actual);

$fil_cur = @pg_fetch_array($res_ano_actual,0);
//tipo enseñanza
$sql_ense="select * from tipo_ensenanza where cod_tipo= ".$fil_cur['ensenanza'];
$res_ense=pg_exec($conn,$sql_ense);
$fil_ense = @pg_fetch_array($res_ense,0);

$nom_cur=$fil_cur['grado_curso'].$fil_cur['letra_curso'];
$id_cur=$fil_cur['id_curso'];
$nom_ese=$fil_ense['nombre_tipo'];

//busco ramos
$sql_ramo="select * from ramo where id_curso=".$id_curso;
$res_ramo = @pg_Exec($conn,$sql_ramo);

if ($subsector>0)
{
$sql_ramo2="select * from ramo where id_ramo=".$subsector;
$res_ramo2 = @pg_Exec($conn,$sql_ramo2);
$fil_ramo2=@pg_fetch_array($res_ramo2,0);
$cod_subsector2=$fil_ramo2['cod_subsector'];
//busco nombre subsector
$sql_nom_sub2="select * from subsector where cod_subsector=".$cod_subsector2;
$res_nom_sub2=pg_exec($conn,$sql_nom_sub2);
$fil_nombre2=@pg_fetch_array($res_nom_sub2,0);

}
	

if($subsector==0 and $id_curso>0 and (strlen($fecha_inicio2)>0) and (strlen($fecha_termino2)>0)) 
{
  $sql_act="select * from calendario_actividades where id_curso=".$id_curso." and fecha_inicio>='".CambioFecha($fecha_inicio2)."' and fecha_termino<='".CambioFecha($fecha_termino2)."' order by fecha_inicio";
$res_act = @pg_Exec($conn,$sql_act)or die('no hize2');
 $encontrados=pg_numrows($res_act);

}
  elseif($subsector>0 and $id_curso>0 and (strlen($fecha_inicio2)>0) and (strlen($fecha_termino2)>0))
{
  $sql_act="select * from calendario_actividades where id_curso=".$id_curso." and id_subsector=".$subsector." and fecha_inicio>='".CambioFecha($fecha_inicio2)."' and fecha_termino<='".CambioFecha($fecha_termino2)."' order by fecha_inicio";
$res_act = @pg_Exec($conn,$sql_act) or die('no hize3');
 $encontrados=pg_numrows($res_act);
}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<script>
function imprimir() 
{
	document.getElementById("imp").style.display='none';
	window.print();
	document.getElementById("imp").style.display='block';
}


</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
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
.Estilo9 {font-family: Geneva, Arial, Helvetica, sans-serif; font-weight: bold; font-size: 12px; }
.Estilo11 {font-family: Geneva, Arial, Helvetica, sans-serif; font-size: 12px; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')" >
<br>
<div id="imp">
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="302">
      <div align="right">
        <input name="Cerrar" type="button" id="Cerrar" value="Cerrar" onClick="cerrar()" class="botonXX" >
      </div></td>
    <td width="348"><div align="right">
      <input type="button" name="Submit2" value="Imprimir" onClick="imprimir();" class="botonXX" >
    </div></td>
  </tr>
</table>
<br>
</div>
<table  width="650" border="0" cellspacing="0" cellpadding="0" align="center" >
                              <tr >
                                <td class="Estilo9">Establecimiento</td>
                                <td colspan="5" class="Estilo9"><?php echo $nom_inst ?></td>
                              </tr>
                              <tr  >
                                <td class="Estilo9">Curso</td>
                                <td colspan="5" class="Estilo9"><?php echo $nom_cur ?> - <?php echo $nom_ese ?></td>
                              </tr>
							  <?php if ($subsector>0)
							  { ?>
                              <tr  >
                                <td class="Estilo9">Subsector</td>
                                <td colspan="5" class="Estilo9"><span class="Estilo11"><?php echo $fil_nombre2['nombre'] ?></span></td>
                              </tr>
							  <?php }?>
                              <tr >
                                <td colspan="6">&nbsp;</td>
                              </tr>
                              <tr  >
                                <td colspan="6">&nbsp;</td>
                              </tr>
                              <tr  class="tableindex">
                                <td colspan="6"><div align="center"><span class="texto">
                                  </span>Listado Actividades </div></td>
  </tr>
                              <tr>
                                <?php if($subsector==0 and $id_curso>0)
								{?>
								<td width="178" bgcolor="#CCCCCC" class="texto"><div align="center" class="Estilo9">Subsector</div></td>
								<?php  } ?>
                                <td width="147" bgcolor="#CCCCCC" class="texto"><div align="center" class="Estilo9">Actividad</div></td>
                                <td width="62" bgcolor="#CCCCCC" class="texto"><div align="center" class="Estilo9">Fecha Inicio </div></td>
                                <td width="70" bgcolor="#CCCCCC" class="texto"><div align="center" class="Estilo9">Hora Inicio </div></td>
                                <td width="70" bgcolor="#CCCCCC" class="texto"><div align="center" class="Estilo9">Fecha T&eacute;rmino </div></td>
                                <td width="70" bgcolor="#CCCCCC" class="texto"><div align="center" class="Estilo9">Hora T&eacute;rmino </div></td>
								<?php if($_PERFIL==0 || $_PERFIL==27 || $_PERFIL==17 || $_PERFIL==8)
{?>
                                <?php }?>
                              </tr>
                              <tr>
                                <td colspan="6" class="texto"><hr></td>
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
                                <td class="texto"><span class="Estilo11"><?php echo $fil_nombre['nombre'] ?></span></td>
								<?php }?>
                                <td class="texto"><span class="Estilo11"><?php echo $fil_act['actividad'] ?></span></td>
                                <td class="texto"><div align="center" class="Estilo11"><?php echo CambioFechaDisplay($fil_act['fecha_inicio']) ?></div></td>
                                <td class="texto"><div align="center" class="Estilo11"><?php echo $fil_act['hora_inicio'] ?></div></td>
                                <td class="texto"><div align="center" class="Estilo11"><?php echo CambioFechaDisplay($fil_act['fecha_termino']) ?></div></td>
                                <td class="texto"><div align="center" class="Estilo11"><?php echo $fil_act['hora_termino'] ?></div></td>
								<?php if($_PERFIL==0 || $_PERFIL==27 || $_PERFIL==17 || $_PERFIL==8 )
{?>
                                <?  } ?>
                              </tr>
                              <tr>
                                <td colspan="6" class="texto"><hr></td>
  </tr>
							  <?php }?>
</table>
</body>
</html>
<? pg_close($conn);?>