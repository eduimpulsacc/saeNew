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
if($funcion==3){
//show($_POST);
?>
 <script type="text/javascript" src="../../../../../../clases/jquery/jquery.js"></script>
    <script type="text/javascript" src="../../../../../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script><br />
<br />

    <b>Instruciones:</b><br />
<br />
    1) Debe descargar la plantilla de notas desde el bot&oacute;n RESPALDAR EN EXCEL.<br /><br />
    2) Una vez descargada, debe editar <strong>SOLO LAS CASILLAS DE NOTAS Y PROMEDIO</strong>. Recuerde que las notas num&eacute;ricas deben ser de solo n&uacute;meros y representadas de 10 a 70, sin puntos ni comas.<br /><br />
    3) <strong>IMPORTANTE: Al guardar el archivo en excel, debe ir a archivo -&gt; Guardar como -&gt; y en el tipo de archivo guardar como &quot;Libro de excel (.xlsx)&quot; o &quot;Libro de excel 97-2003 (.xls)&quot;.</strong><br /><br />
    4) Debe subir la plantilla, en el cuadro de archivo que se encuentra a continuaci&oacute;n. Solo se admiten archivos excel 97-2003 (.xls) y 2007 (.xlsx). Para finalizar, presione el bot&oacute;n "Importar". <br /><br />
<br />
<br />


<form id="notaXLS" method="post" enctype="multipart/form-data">
<input type="hidden" name="xx" id="xx" value="" />
<input type="hidden" name="idperiodo" id="idperiodo" value="<?php echo $per ?>" />
<input type="hidden" name="idramo" id="idramo" value="<?php echo $rm ?>" />
<input type="hidden" name="modo_evali" id="modo_evali" value="<?php echo $modo_eval ?>" />
<input type="hidden" name="idcurso" id="idcurso" value="<?php echo $cu ?>" />
    <input type="hidden" name="institucion" id="institucion" value="<?php echo $institucion ?>" />
    <input type="hidden" name="ano_escolar" id="ano_escolar" value="<?php echo $ano_escolar ?>" />

<input type="hidden" name="ense" id="ense" value="<?php echo $ensenanza ?>" />
<input type="hidden" name="nomper" id="nomper" value="<?php echo $nomper ?>" />
Subir archivo <input type="file" id="plantilla" name="plantilla"/>
</form>
<div class="messages" align="center" >
    <span class='info'></span>
     <span class='error'></span>
    </div>
<?
}
if($funcion==4){
	

$archivo = $_FILES['archivo']['tmp_name'];
$narchivo = $_FILES['archivo']['name'];
$error = "";
 $newfile = "cargas/".$institucion."_".$id_curso."_".$id_ramo."_".$id_periodo."_".$narchivo;
 
 if (!copy($archivo, $newfile)) {
	$error="No se puede subir el archivo";
}

require_once 'PHPExcel/Classes/PHPExcel.php';
//$archivo = "libro1.xlsx";

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

 $ano_e =  trim($objPHPExcel->getActiveSheet()->getCell('B1')->getValue());
$nomcurso = utf8_decode($objPHPExcel->getActiveSheet()->getCell('B6')->getValue());

$v1 = explode(" ",$nomcurso);
$cursoi = explode("-",$v1[0]);
$gradoi = $cursoi[0];
$letrai = $curso[1];
    $rbd_e =  trim($objPHPExcel->getActiveSheet()->getCell('B1')->getValue());
    $rbd_e = explode("-",$rbd_e);
    $rbd_e = $rbd_e[0];
  $ano_e = trim($objPHPExcel->getActiveSheet()->getCell('B6')->getValue());
  
    $level_e = trim($objPHPExcel->getActiveSheet()->getCell('B2')->getValue());
    $level_e = explode("-",$level_e);
    $grado_e = $level_e[0];
    $letra_e = $level_e[1];
    $ense_e = trim($objPHPExcel->getActiveSheet()->getCell('B3')->getValue());
    $ense_e = explode(" ",$ense_e);
    $ense_e = $ense_e[0];
    
    $query1 = "SELECT id_ano from ano_escolar WHERE id_institucion = $institucion and nro_ano = $ano_escolar";
    $rs1 = pg_exec($conn,$query1);
    $ano_l = pg_result($rs1,0);
	
  $query2 = "SELECT id_curso,grado_curso,letra_curso,ensenanza from curso WHERE id_ano = $_ANO and grado_curso = $grado_e and letra_curso = '$letra_e' and ensenanza = $ensenanza";
    $rs2 = pg_exec($conn,$query2);
	
	
    
    
    $idcurso_l = pg_result($rs2,0);
    $grado_l = pg_result($rs2,1);
     $letra_l = pg_result($rs2,2);
   $ensenanza_l = pg_result($rs2,3);
    $subsector_e = utf8_decode(trim($objPHPExcel->getActiveSheet()->getCell('B4')->getValue()));
	$subsector_e = explode(" ",$subsector_e);
	$subsector_e = $subsector_e[0];
    

$periodo_e = utf8_decode(trim($objPHPExcel->getActiveSheet()->getCell('B5')->getValue()));



    //$query1 = "SELECT rdb FROM institucion WHERE rdb = $rbd_e";
    //$rs1 = pg_exec($conn,$query1);
        //echo "ins".$modo_eval = pg_result($rs1,0);
 
        if($rbd_e==$institucion) {
            if($ano_e==$ano_escolar) {
				
				if($periodo_e == $nomper){
               
			    if($grado_l == $grado_e ) {
                    $query3 = "SELECT cod_subsector from subsector where cod_subsector = $subsector_e";
                    $rs3 = pg_exec($conn,$query3);
                    $codsub_e = pg_result($rs3,0);
					
					 $query4 = "SELECT cod_subsector,modo_eval from ramo where id_ramo = $id_ramo";
                    $rs4 = pg_exec($conn,$query4);
                    $codsub_l = pg_result($rs4,0);
					$modoeval_l = pg_result($rs4,1);
                    
					//vamos a buscar subsector
					if($codsub_l ==$codsub_e){
						
					//buscar modo evaluacion
					

$arr = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$insertados =0;
for ($row = 9; $row <= $highestRow; $row++){
// echo "\n".$nomalu = $sheet->getCell("A".$row)->getValue()."<br>";
$rut = $sheet->getCell("B".$row)->getValue();
$query5 = "select rut_alumno from tiene$ano_escolar where rut_alumno = $rut and id_ramo = $id_ramo";
$rs5= pg_exec($conn,$query5);
$cadnro ="";
$cadpos ="";
if(pg_numrows($rs5)>0){


 $promedio = "'".$sheet->getCell("W".$row)->getValue()."'";
 	
    for($c=2; $c<=21; $c++) {
		$cadnro.="nota".($c-1).",";
		$nota = trim($sheet->getCell($arr[$c].$row)->getValue());
        $cadpos.= "'".$sheet->getCell($arr[$c].$row)->getValue()."',";
		 
    }
	
	
}

$cadnro = substr($cadnro,0,-1);
$cadpos = substr($cadpos,0,-1);
 $query5  = "delete from notas$ano_escolar where rut_alumno = $rut and id_ramo = $id_ramo and id_periodo = $id_periodo";
pg_exec($conn,$query5);
$sql6 = "insert into notas$ano_escolar(rut_alumno,id_ramo,id_periodo,$cadnro,promedio) values($rut,$id_ramo,$id_periodo,$cadpos,$promedio)";
	pg_exec($conn,$sql6);
	$insertados++;

}

	
					}else{
						$error = "Asignatura no coincide";
						}
                    
                } else {
                    $error = "Curso no coincide";
                }
				}else{
					$error = "Periodo no coincide";
					}
                    
            } else {
                $error = "A\xf1o escolar no coincide";
            }
        }
    else {
        $error = "Instituci\xf3n no coincide";
        
    }
	
	if(strlen($error)>0){
   	 echo $error;
	}else{
		echo 1;
		}
}
?>
