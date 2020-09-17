<?php 
session_start();
require('../../../../../../../../util/header.inc');
require "mod_impnota.php";
$ob_imp = new Impnota();

$funcion =$_POST['funcion'];
//entorno 1:produccion 2:desarrollo

$entorno =1;

if($entorno==1)
{
	$base = "http://app.edugestor.com/ws/";
}
if($entorno==2)
{
	$base = "http://52.3.198.230/ws/";
}
	

if($funcion==1){
	
$npe = explode(" ",$nomper);
if($npe[0]=="PRIMER"){
$num = 1;
}
elseif($npe[0]=="SEGUNDO"){
$num = 2;
}
elseif($npe[0]=="TERCER"){
$num = 3;
}


	
?>
<script>
$( document ).ready(function() {
   cargapli();
});
</script>

<style>
    select { font-size:12px; font-family:Verdana, Geneva, sans-serif }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#impnota { width: 350px; margin: 20px 0; }
    div#impnota table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#impnota table td {padding: .6em 10px; text-align: left; font-size:12px; font-family:Verdana, Geneva, sans-serif }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  <form id="sic">
   <input type="hidden" name="xx" id="xx" value="" />
   
  <input type="hidden" name="tipo_evaluacion" id="tipo_evaluacion" value="-1" />
  <input type="hidden" name="rdb" id="rdb" value="<?php echo $_INSTIT ?>" />
   <input type="hidden" name="anio" id="anio" value="<?php echo $anio ?>" />
   <input type="hidden" name="asignatura" id="asignatura" value="<?php echo $subs ?>" />
   <input type="hidden" name="periodo" id="periodo" value="<?php echo $num ?>" />
    <input type="hidden" name="idperiodo" id="idperiodo" value="<?php echo $per ?>" />
   <input type="hidden" name="nivel" id="nivel" value="<?php echo $grd ?>" />
   <input type="hidden" name="curso" id="curso" value="<?php echo $let ?>" />
   <input type="hidden" name="idcurso" id="idcurso" value="<?php echo $_CURSO ?>" />
   <input type="hidden" name="idramo" id="idramo" value="<?php echo $_RAMO ?>" />
   <input type="hidden" name="tipo_ensenanza" id="tipo_ensenanza" value="<?php echo $ens ?>" />
    <input type="hidden" name="truncado" id="truncado" value="<?php echo $truncado ?>" />
   
<table width="90%" cellpadding="0" cellspacing="0" border="0">
  <tr>
    <td width="19%"><strong>Tipo Aplicaci&oacute;n</strong></td>
    <td width="1%"><strong>:</strong></td>
    <td width="80%">
    <div id="ap">
    <select name="plica" id="plica" style="width:200px">
    <option value="0">Seleccione...</option>  
    </select>
    </div>
    </td>
  </tr>
  <tr>
    <td><strong>Columna</strong></td>
    <td><strong>:</strong></td>
    <td>
    <select name="posnota" id="posnota">
    <option value="0">Seleccione...</option>
    <?php for($i=1;$i<=20;$i++){?>
    <option value="<?php echo $i ?>">Nota <?php echo $i ?></option>
    <?php }?>
    </select></td>
  </tr>
</table>
</form>
<div id="resu"></div>

<?
}
if($funcion==2){



/*
Cliente de prueba para el servicio web getListaAplicaciones que ofrece Edugestor.
*/
require_once "../../../../../../../../ws_prueba/lib/nusoap.php";

//$base = "https://app.edugestor.com/ws/";

$mostrar = 0;


    $client = new nusoap_client($base . "api/applications.php");

    $error = $client->getError();
    if ($error) {
        $mensaje =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
    }

    $result = $client->call("getListaAplicaciones", array(
        "rbd" => $rdb,
        "anio" => $anio,
        "asignatura" => $asignatura,
        "nivel" => $nivel,
		"curso" => $curso,
        "tipo_ensenanza" => $tipo_ensenanza,
        "tipo_evaluacion" => -1,
        "periodo" => $periodo
		
    ));

    if ($client->fault) {
        $mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
    }
    else {
        $error = $client->getError();
        if ($error) {
            $mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
        }
        else {
            $mostrar = 1;
        }
    }


if ($mostrar==1) {
?>
    
          <select name="plica" id="plica" style="width:200px">
    <option value="0">Seleccione...</option>  
    
	   <?php
            foreach ($result as $aplicacion) {
				?>
                <option value="<?php echo $aplicacion['cod_aplicacion'] ?>"><?php echo utf8_decode($aplicacion['nombre']) ?></option> 
                <?
             //  echo $aplicacion['cod_aplicacion'] . " - " . $aplicacion['nombre'] . ' (<a href="clienteS2.php?cod=' . $aplicacion['cod_aplicacion'] . "\">Ver calificacion</a>)<br/>";
            }
        ?>
   </select>
   

<?php
} elseif (!empty($_POST)) {
    echo $mensaje;
}



}
if ($funcion==3){
//var_dump($_POST);

require_once "../../../../../../../../ws_prueba/lib/nusoap.php";

//$base = "https://app.edugestor.com/ws/";

$mostrar = 0;

 $client = new nusoap_client($base . "api/applications.php");

    $error = $client->getError();
    if ($error) {
        $mensaje =  "<h2>Error constructor:</h2><pre>" . $error . "</pre>";
    }

    $result = $client->call("getCalificaciones", array(
        "cod_aplicacion" => $app
    ));

    if ($client->fault) {
        $mensaje = "<h2>Falla:</h2><pre>" . print_r($result) . "</pre>";
		$mostrar = 2;
    }
    else {
        $error = $client->getError();
        if ($error) {
            $mensaje = "<h2>Error:</h2><pre>" . $error . "</pre>";
			$mostrar = 2;
        }
        else {
            $mostrar = 1;
        }
    }

if ($mostrar==1) {
	
	  foreach ($result as $estudiante) {
		  
		  		$lrt = explode("-",$estudiante['rut']);
				$lrt = str_replace(".","",$lrt[0]);
				
				//$nota = str_replace(".","",$estudiante['nota']);
				$nota=($estudiante['nota'])*10;
				
				$nota = ($truncado==1)?round($nota, 0):intval($nota);
				/*$nota = str_replace(".","",$estudiante['nota']);*/
				
				//revisar si tengo notas
				$rs_rev = $ob_imp->revNota($conn,$lrt,$nano,$ram,$per,$pos);
				
				if(pg_numrows($rs_rev)==0){
					$ob_imp->ingNota($conn,$lrt,$nano,$ram,$per,$pos,$nota);
				
				}else{
				
					$ob_imp->upNota($conn,$lrt,$nano,$ram,$per,$pos,$nota);
				
				}
		  
               
            }
			
		} 

}
?>