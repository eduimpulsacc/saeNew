<?
require('../../../../../util/header.inc');
include ("Calendario/calendario.php");

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
	
	// echo "asignacion=$asignacion<br>";
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
	
	
//busco año
$sql_ano = "select * from ano_escolar where id_ano = ".$ano;
$result_ano =@pg_Exec($conn,$sql_ano);
$fila_ano = @pg_fetch_array($result_ano,0);
$nro_ano = $fila_ano['nro_ano'];
	
if (isset($_POST['Submit']))
{
$hora_inicio=$hora_ini.":".$min_ini.":00";
$hora_termino=$hora_ter.":".$min_ter.":00";
$sql_up="update calendario_actividades set actividad='$actividad', fecha_inicio='".CambioFecha($fecha_inicio)."',fecha_termino='".CambioFecha($fecha_termino)."',hora_inicio='$hora_inicio',hora_termino= '$hora_termino' where id_actividad=$id_actividad";
$res_up=@pg_exec($conn,$sql_up);


?>
<script>
alert ('Actividad Actualizada Exitosamente');
opener.self.location='CalCurso.php?id_curso=<?php echo $id_curso ?>&subsector=<?php echo $subsector ?>&fecha_inicio2=<?php echo $fecha_inicio2 ?>&fecha_termino2=<?php echo $fecha_termino2 ?>&nuevo=1';
window.close();
</script>
<?

}




 $sql_act="select * from calendario_actividades where id_actividad=$id_actividad";
 $res_act = @pg_Exec($conn,$sql_act) or die('no hize3');
 $fil_act=pg_fetch_array($res_act,0);
 
 $h_ini=substr($fil_act['hora_inicio'],0,2);
 $m_ini=substr($fil_act['hora_inicio'],3,2);
 $h_ter=substr($fil_act['hora_termino'],0,2);
 $m_ter=substr($fil_act['hora_termino'],3,2);
 ?>
 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.datepicker.css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jqueryui/themes/smoothness/jquery.ui.all.css">

<style>
.ui-datepicker-trigger { position:relative;height:16px;width:16px }
</style>

<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.core.js"></script>
</SCRIPT>

<script language="javascript">
$(document).ready(function() {

$( "#fecha_inicio2,#fecha_termino2,#fecha_inicio,#fecha_termino" ).datepicker({
    'dateFormat':'dd-mm-yy',
	firstDay: 1,
	showOn: "both",
                buttonImage: "Calendario/calendario.gif",
                buttonImageOnly: true,
	yearRange: '<?php echo $nro_ano ?>:<?php echo $nro_ano ?>',
	changeMonth: true,
	//changeYear: true,
	/*minDate: new Date('<?php echo $nro_ano ?>/01/01'),
    maxDate: new Date('<?php echo $nro_ano ?>/12/31'),*/
	dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
    // Dias cortos en castellano
    dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],
    // Nombres largos de los meses en castellano
    monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
    // Nombres de los meses en formato corto 
    monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ]
	
});

//$.datepicker.regional['es']	


});
</script>

</head>

<body>
<form name="form2" method="post" action="<?php echo $PHP_SELF ?>" onSubmit="return vale(this)">
<table  width="680" height="169" border="0" align="center" cellpadding="0" cellspacing="0">
                              <tr  class="tableindex">
                                <td height="22" colspan="5"><div align="center">
                                  <input type="hidden" name="id_curso"  value="<?php echo $id_curso ?>"/>
                                  <input type="hidden" name="subsector" value="<?php echo $subsector ?>" />
                                  <input type="hidden" name="fecha_inicio2" value="<?php echo $fecha_inicio2 ?>" />
								  <input type="hidden" name="fecha_termino2" value="<?php echo $fecha_termino2 ?>" />
								  <input type="hidden" name="id_actividad" value="<?php echo $id_actividad ?>" /> 
Actualizar Actividad </div></td>
  </tr>
                              <tr>
                                <td height="19" colspan="5">&nbsp;</td>
  </tr>
                              <tr>
                                <td width="31%" height="39" class="texto"><div align="center"><strong>Actividad</strong></div></td>
                                <td width="16%" class="texto"><div align="center"><strong>Fecha Inicio </strong></div></td>
                                <td width="18%" class="texto"><div align="center"><strong>Hora Inicio </strong></div></td>
                                <td width="18%" class="texto"><div align="center"><strong>Fecha T&eacute;rmino </strong></div></td>
                                <td width="17%" class="texto"><div align="center"><strong>Hora T&eacute;rmino </strong></div></td>
                              </tr>
                              <tr>
                                <td height="46"><div align="center">
                                  <input name="actividad" type="text" id="actividad" size="30" value="<?php echo $fil_act['actividad'] ?>">
                                </div></td>
                                <td><div align="center"><input name="fecha_inicio" id="fecha_inicio" value="<?php echo CambioFechaDisplay($fil_act['fecha_inicio']) ?>" size="12"/>
                                </div></td>
                                <td><div align="center">
                                  <select name="hora_ini" >
								  <option value="<?php echo $h_ini ?>" selected="selected"><?php echo $h_ini ?></option>
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
								  								  <option value="<?php echo $m_ini ?>" selected="selected"><?php echo $m_ini ?></option>

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
								<input name="fecha_termino" type="text" id="fecha_termino" value="<?php echo CambioFechaDisplay($fil_act['fecha_termino']) ?>" size="12">
								
                                </div></td>
                                <td><div align="center">
                                  <select name="hora_ter" id="hora_ter" >
								  								  <option value="<?php echo $h_ter ?>" selected="selected"><?php echo $h_ter ?></option>

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
								  								  <option value="<?php echo $m_ter ?>" selected="selected"><?php echo $m_ter ?></option>

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
                                <td height="19" colspan="5">&nbsp;</td>
  </tr>
                              <tr>
                                <td height="24" colspan="5"><div align="center">
                                  <input type="submit" name="Submit" value="Actualizar Actividad" class="botonxx">
                                </div></td>
  </tr>
</table>
</form>
</body>
</html>
