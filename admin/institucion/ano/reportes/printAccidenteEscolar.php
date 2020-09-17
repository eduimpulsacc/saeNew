<?  
require('../../../../util/header.inc');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');

$institucion	=$_INSTIT;
$reporte		=$c_reporte;
$ano			=$_ANO;
$curso			=$c_curso;
$alumno 		=$c_alumno;

$ob_institucion = new Membrete();
$ob_institucion->institucion=$institucion;
$ob_institucion->institucion($conn);

$ob_reporte = new Reporte();
$ob_reporte->alumno=$alumno;
$ob_reporte->ano=$ano;
$rs_alumno = $ob_reporte->FichaAlumnoUno($conn);
$fila_alumno=@pg_fetch_array($rs_alumno,0);
$ob_reporte->CambiaDato($fila_alumno);



$Curso_pal = CursoPalabra($curso, 1, $conn);

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

$ob_reporte->curso=$curso;
$ob_reporte->rut_alumno=$alumno;
$ob_reporte->fecha_accidente=CambioFecha($fecha);
$rs_accidente = $ob_reporte->TraeAccidenteReporte($conn);
$fila_accidente=@pg_fetch_array($rs_accidente,0);

$rs_jornada = $ob_reporte->TraeSoloJornada($conn);
$jornada=@pg_fetch_array($rs_jornada,0);
$jor=$jornada['bool_jor'];

switch($jor){
	case 1:
	$txt_jornada ="Ma&ntilde;ana";
	break;
	
	case 2:
	$txt_jornada ="Tarde";
	break;
	
	case 3:
	$txt_jornada ="Jornada Completa";
	break;
	
	case 4:
	$txt_jornada ="Vespertina";
	break;
	}


$f_accidente = explode("-",$fila_accidente['fecha']);
$anio_ac = $f_accidente[0];
$mes_ac = $f_accidente[1];
$dia_ac = $f_accidente[2];

$f_registro = explode("-",$fila_accidente['fecha_registro']);
$anio_re = $f_registro[0];
$mes_re = $f_registro[1];
$dia_re = $f_registro[2];


function CalculaEdad( $fecha ) {
    list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}


if($cb_ok!="Buscar"){
	$xls=1;
}


switch ($ob_institucion->dependencia) {
	 case 0:
		 $imp=3;
		 break;
	 case 1:
		 $imp=2;
		 break;
	 case 2:
		 $imp=1;
		 break;
	 default:
		 $imp ="OTROS";
		 break;
 };



if($xls==1){
$fecha_actual = date('d/m/Y-H:i:s');	 
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Certificado_alumno_regular_$fecha_actual.xls"); 	 
}	 

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=latin9" />
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<style type="text/css">
<!--
.Estilo1 {
	font-size: 9px;
	font-family: Verdana, Arial, Helvetica, sans-serif;
}
.Estilo2 {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 10px;
}
.Estilo4 {font-size: 9; font-family: Verdana, Arial, Helvetica, sans-serif; }
.Estilo5 {font-size: 12}
-->
</style>
</head>
<script> 
function cerrar(){ 
window.close() 
} 
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function exportar(){
	window.location='printAccidenteEscolar.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
	return false;
}
</script>
<body>
 <div id="capa0">
  <table width="700" align="center">
    <tr>
      <td width="302"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">      </td>
      <td width="316" align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">      </td>
	  <? if($_PERFIL==0){?>
      <td width="66" align="right">&nbsp;</td>
	  <? } ?>
    </tr>
  </table>
</div>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%">
		<? 
			if($institucion!=""){
			    echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
		    }else{
			    echo "<img src='".$d."menu/imag/logo.gif' >";
		    }?>
		</td>
        <td width="82%"><div align="center" class="Estilo2 Estilo5">DECLARACI&Oacute;N INDIVIDUAL<br />
          DE ACCIDENTE ESCOLAR </div></td>
        <td width="16%"><div align="right"><img src="../../../../LOGO_GOB_2.jpg" width="105" height="93" border="0"/></div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td colspan="2"><p><span class="Estilo2">A. INDIVIDUALIZACI&Oacute;N DEL ESTABLECIMIENTO </span></p>
          <p>&nbsp;</p></td>
        <td width="35%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="57%" height="17" class="Estilo1"><span class="Estilo4">Fiscal o Municipal </span></td>
            <td width="16%" class="Estilo1"><span class="Estilo4">= 1 </span></td>
            <td width="27%" rowspan="2"><table width="64%" height="30" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
              <tr>
                <td class="Estilo4" align="center"><?php echo $imp ?></td>
              </tr>
            </table></td>
          </tr>
          <tr class="Estilo1">
            <td><span class="Estilo4">Particular</span></td>
            <td><span class="Estilo4">= 2 </span></td>
            </tr>
          <tr class="Estilo1">
            <td height="18">Particular Subvencionado </td>
            <td>= 3 </td>
            <td>&nbsp;</td>
          </tr>
          
        </table></td>
      </tr>
     
      <tr>
        
        </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		
        <tr>
        <td><span class="Estilo1">
              <?=$ob_institucion->run;?>&nbsp;-<?=$ob_institucion->dig_run;?>
              <br />__________________________________________<br />
              RUN ESTABLECIMIENTO </span></td>
        </tr>
          <tr>
            <td><span class="Estilo1">
              <?=$ob_institucion->ins_pal;?>
              <br />__________________________________________<br />
              NOMBRE ESTABLECIMIENTO </span></td>
            <td><div align="center"><span class="Estilo1"><?=$ob_institucion->provincia;?><br />
              ___________________<br />
              CIUDAD</span></div></td>
            <td><p align="center" class="Estilo1"><?=$ob_institucion->comuna;?><br />________________________________<br />
              COMUNA</p>              </td>
          </tr>
          <tr>
            <td><span class="Estilo1"><br />
              <?=$Curso_pal;?><br />__________________________________________<br />
              CURSO</span></td>
            <td align="center"><span class="Estilo1">
              <?php echo $txt_jornada ?>
              <br />
              ___________________<br />
              HORARIO</span></td>
            <td><span class="Estilo1">Fecha Registro de los Datos</span><br />
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr class="Estilo1">
                  <td align="center"><?php echo $dia_re ?><br />
                    _______</td>
                  <td align="center"><?php echo $mes_re ?><br />
                    _______</td>
                  <td align="center"><?php echo $anio_re?><br />
                    _______</td>
                  </tr>
                <tr>
                  <td><div align="center" class="Estilo1">D&iacute;a</div></td>
                  <td><div align="center" class="Estilo1">Mes</div></td>
                  <td><div align="center" class="Estilo1">A&ntilde;o</div></td>
                  </tr>
                </table>              </td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="3" class="Estilo2">B. INDIVIDUALIZACI&Oacute;N DEL ACCIDENTADO </td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td class="Estilo1"><? echo $alumno."-".$fila_alumno['dig_rut'];?><br />
              _____________<br />
              RUN</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
		  <? $nombrealu=ucwords(strtolower($ob_reporte->ape_nombre_alu)); ?>
            <td width="58%" class="Estilo1"><?=$nombrealu;?><br />_______________________________________________________<br />
              APELLIDO PATERNO MATERNO NOMBRES </td>
            <td width="12%"><table width="91%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="3" class="Estilo1">SEXO</td>
                </tr>
              <tr>
                <td width="10%" class="Estilo1">M</td>
                <td width="30%" class="Estilo1">=2</td>
                <td width="60%" rowspan="2"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                  <tr>
                    <td class="Estilo1"><div align="center">
                      <?=$fila_alumno['sexo'];?>
                      &nbsp;</div></td>
                  </tr>
                </table></td>
              </tr>
              <tr class="Estilo1">
                <td>F</td>
                <td>=1</td>
                </tr>
            </table></td>
            <td width="21%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="Estilo1"><div align="center">A&Ntilde;O NACIMIENTO </div></td>
              </tr>
              <tr>
                <td><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                  <tr>
                    <td class="Estilo1">
                      <div align="center">&nbsp;
                        <?=impF($ob_reporte->fecha_nacimiento);?>
                      </div></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="9%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="Estilo1"><div align="center">EDAD</div></td>
              </tr>
              <tr>
                <td><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                  <tr>
                    <td class="Estilo1" align="center"><?php echo CalculaEdad($ob_reporte->fecha_nacimiento) ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="4" class="Estilo2">RESIDENCIA HABITUAL </td>
            </tr>
          <tr>
            <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="50" class="Estilo1"><?=strtoupper($fila_alumno['calle']);?><br />_________________<br />
                  DOMICILIO</td>
                <td class="Estilo1"><?=$fila_alumno['nro'];?><br />________<br />
                  N&Uacute;MERO</td>
                <td class="Estilo1"><?=strtoupper($ob_reporte->villa);?><br />___________________<br />
                  POBLACI&Oacute;N O VILLA </td>
                <td class="Estilo1"><?=strtoupper($ob_reporte->comuna);?><br />_____________<br />
                  COMUNA</td>
                <td class="Estilo1"><?=strtoupper($ob_reporte->provincia);?><br />__________<br />
                  CIUDAD</td>
                <td class="Estilo1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td><table width="98%" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
                      <tr>
                        <td class="Estilo4">&nbsp;</td>
                      </tr>
                    </table></td>
                    <td><table width="98%" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
                      <tr>
                        <td class="Estilo4">&nbsp;</td>
                      </tr>
                    </table></td>
                    <td><table width="98%" border="1" align="center" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
                      <tr>
                        <td class="Estilo4">&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td colspan="3" class="Estilo1">CODIF. COM. </td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
            </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3" class="Estilo1"><span class="Estilo2">C. INFORME SOBRE EL ACCIDENTE</span> (FECHA,HORA, Y D&Iacute;A DE LA SEMANA EN QUE SE ACCIDENTO) </td>
        </tr>
      <tr>
        <td colspan="3" class="Estilo1">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2"><table width="100%" border="0" cellspacing="5" cellpadding="0">
                  <tr>
                    <td width="21%" class="Estilo1"><div align="center">HORA</div></td>
                    <td width="26%" class="Estilo1"><div align="center">MINUTO</div></td>
                    <td width="21%" class="Estilo1"><div align="center">A&Ntilde;O</div></td>
                    <td width="16%" class="Estilo1"><div align="center">MES</div></td>
                    <td width="16%" class="Estilo1"><div align="center">DIA</div></td>
                  </tr>
                  <tr>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                      <tr>
                        <td height="25" class="Estilo1" align="center"><?php echo $fila_accidente['hora'] ?></td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                      <tr>
                        <td height="25" class="Estilo1" align="center"><?php echo $fila_accidente['minuto'] ?></td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                      <tr>
                        <td height="25" class="Estilo1" align="center"><?php echo $anio_ac; ?></td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                      <tr>
                        <td height="25" class="Estilo1" align="center"><?php echo $mes_ac?></td>
                      </tr>
                    </table></td>
                    <td><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                      <tr>
                        <td height="25" class="Estilo1" align="center"><?php echo $dia_ac; ?></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
                </tr>
              <tr>
                <td width="50%"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="4" class="Estilo1">D&Iacute;A ACCIDENTE </td>
                    </tr>
                  <tr>
                    <td class="Estilo1">LUNES</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">1</td>
                    <td rowspan="7" class="Estilo1"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                      <tr>
                        <td height="28" align="center" class="Estilo1"><?php echo $fila_accidente['dia_accidente'] ?>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td class="Estilo1">MARTES</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">2</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">MI&Eacute;RCOLES</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">3</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">JUEVES</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">4</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">VIERNES</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">5</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">S&Aacute;BADO</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">6</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">DOMINGO</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">7</td>
                    </tr>
                </table></td>
                <td width="50%" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="10">
                  <tr>
                    <td colspan="4" class="Estilo1">ACCIDENTE</td>
                    </tr>
                  <tr>
                    <td width="56%" class="Estilo1">De Trayecto </td>
                    <td width="12%" class="Estilo1">=</td>
                    <td width="12%" class="Estilo1">1</td>
                    <td width="20%" rowspan="2" class="Estilo1"><table width="100%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                      <tr>
                        <td height="25" align="center" class="Estilo1"><?php echo $fila_accidente['tipo'] ?>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td class="Estilo1">En la Escuela </td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">2</td>
                    </tr>
                </table></td>
              </tr>
            </table></td>
            <td width="50%" valign="top"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td colspan="3" class="Estilo2"><div align="center">
                  <table width="80%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                    <tr>
                      <td class="Estilo2"><div align="center">TESTIGOS: (EN CASO DE TRAYECTO) </div></td>
                    </tr>
                  </table>
                  </div></td>
                </tr>
              <tr>
                <td class="Estilo1">a)</td>
                <td height="50" class="Estilo1"><div align="center"><?php echo $fila_accidente['nombre_testigo1'] ?><br />
__________________________<br />
                  NOMBRE-APELLIDO</div></td>
                <td class="Estilo1"><div align="center"><?php echo $fila_accidente['rut_testigo1'] ?><br />___________________<br />
                  C.NAC.ID.</div></td>
              </tr>
              <tr>
                <td class="Estilo1">b)</td>
                <td height="50" class="Estilo1"><div align="center"><?php echo $fila_accidente['nombre_testigo2'] ?><br />__________________________<br />
                  NOMBRE-APELLIDO</div></td>
                <td class="Estilo1"><div align="center"><?php echo $fila_accidente['rut_testigo2'] ?><br />___________________<br />
                  C.NAC.ID.</div></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
        </tr>
      <tr>
        <td colspan="3">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3"><table width="100%" border="0" cellspacing="3" cellpadding="0">
          <tr>
            <td width="73%" class="Estilo1"><span class="Estilo2">CIRCUNSTANCIA DEL ACCIDENTE</span> (DESCRIBA COMO OCURRI&Oacute; -CAUSAL) </td>
            <td width="27%" rowspan="2" valign="bottom" class="Estilo1">_________________<br />
              FIRMA Y TIMBRE <br />
              RECTOR O REPRESENTANTE </td>
          </tr>
          <tr>
            <td class="Estilo1" style="text-align:justify; padding-right:20px"><?php echo $fila_accidente['observaciones'] ?></td>
          </tr>
          </table></td>
        </tr>
      <tr>
        <td width="6%">&nbsp;</td>
        <td width="59%">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="0">
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td rowspan="2" class="Estilo1" valign="top"><img src="../../../../img_reporte.jpg"  width="30" height="200"/></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td colspan="2" class="Estilo2">D. NATURALEZA Y CONSECUENCIA DEL ACCIDENTE </td>
                <td class="Estilo1">S S </td>
                <td class="Estilo2">&nbsp;</td>
                <td class="Estilo1">ESTABLECIMIENTO</td>
              </tr>
              <tr>
                <td class="Estilo1"><div align="left">____________________________________________________<br /></div>
                  <div align="center">ESTABLECIMIENTO ASISTENCIAL </div></td>
                <td class="Estilo1">C&Oacute;DIGO</td>
                <td class="Estilo1"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
                <td class="Estilo1">-</td>
                <td class="Estilo1"><table width="100%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td class="Estilo1"><div align="left">____________________________________________________<br /></div>
                 <div align="center"> DIAGN&Oacute;STICO M&Eacute;DICO </div></td>
                <td colspan="4" class="Estilo1">&nbsp;</td>
                </tr>
              <tr>
                <td colspan="5" class="Estilo1"><table width="100%" border="0" cellspacing="5" cellpadding="0">
                  <tr>
                    <td class="Estilo1">____________________________<br />
                      PARTE DEL CUERPO AFECTADA </td>
                    <td class="Estilo1" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="4" class="Estilo1">HOSPITALIZACI&Oacute;N</td>
                        </tr>
                      <tr>
                        <td width="13%" class="Estilo1">SI</td>
                        <td width="8%" class="Estilo1">=</td>
                        <td width="15%" class="Estilo1">1</td>
                        <td width="64%" rowspan="2" class="Estilo1"><table width="30" height="30" border="1" cellpadding="0" cellspacing="0"   style="border-collapse:collapse">
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="Estilo1">NO</td>
                        <td class="Estilo1">=</td>
                        <td class="Estilo1">2</td>
                        </tr>
                    </table></td>
                    <td class="Estilo1" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="3" class="Estilo1">TOTAL D&Iacute;AS HOSP. </td>
                        </tr>
                      <tr>
                        <td><table width="99%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                        <td><table width="99%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                        <td valign="top"><table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                        </table></td>
                      </tr>
                    </table></td>
                    <td class="Estilo1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="4" class="Estilo1">INCAPACIDAD</td>
                      </tr>
                      <tr>
                        <td width="13%" class="Estilo1">SI</td>
                        <td width="8%" class="Estilo1">=</td>
                        <td width="15%" class="Estilo1">1</td>
                        <td width="64%" rowspan="2" class="Estilo1"><table width="30" height="30" border="1" cellpadding="0" cellspacing="0"   style="border-collapse:collapse">
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>
                      <tr>
                        <td class="Estilo1">NO</td>
                        <td class="Estilo1">=</td>
                        <td class="Estilo1">2</td>
                      </tr>
                    </table></td>
                    <td class="Estilo1"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td colspan="3" class="Estilo1">TOTAL D&Iacute;AS INCAP </td>
                      </tr>
                      <tr>
                        <td><table width="99%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                        </table></td>
                        <td><table width="99%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                        </table></td>
                        <td valign="top"><table width="99%" border="1" cellspacing="0" cellpadding="0"  style="border-collapse:collapse">
                            <tr>
                              <td>&nbsp;</td>
                            </tr>
                        </table></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="3" cellpadding="0">
              <tr>
                <td><table width="99%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="4" class="Estilo2">TIPO DE INCAPACIDAD </td>
                    </tr>
                  <tr>
                    <td class="Estilo1">LEVE</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">1</td>
                    <td rowspan="6" class="Estilo1" valign="middle"> <div align="center"><table width="30" height="30" border="1" cellpadding="0" cellspacing="0"  style="border-collapse:collapse">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table>
                     </div></td>
                  </tr>
                  <tr>
                    <td class="Estilo1">TEMPORAL</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">2</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">INVALIDEZ PARCIAL </td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">3</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">INVALIDEZ TOTAL </td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">4</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">GRAN INVALIDEZ </td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">5</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">MUERTE</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">6</td>
                    </tr>
                </table></td>
                <td valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="4" class="Estilo2">CAUSA DEL CIERRE DEL CASO </td>
                    </tr>
                  <tr>
                    <td class="Estilo1">ALTA M&Eacute;DICA </td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">1</td>
                    <td rowspan="4" class="Estilo1"><table width="30" height="30" border="1" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td class="Estilo1">INVALIDEZ</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">2</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">ABANDONO DEL TRATAMIENTO </td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">3</td>
                    </tr>
                  <tr>
                    <td class="Estilo1">MUERTE</td>
                    <td class="Estilo1">=</td>
                    <td class="Estilo1">4</td>
                    </tr>

                </table></td>
                <td valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td colspan="3" class="Estilo2">FECHA DEL CIERRE DEL CASO </td>
                    </tr>
                  <tr>
                    <td><table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                    <td><table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                    <td><table width="99%" border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse">
                      <tr>
                        <td>&nbsp;</td>
                      </tr>
                    </table></td>
                  </tr>
                  <tr>
                    <td class="Estilo1"><div align="center">A&Ntilde;O</div></td>
                    <td class="Estilo1"><div align="center">MES</div></td>
                    <td class="Estilo1"><div align="center">D&Iacute;A</div></td>
                  </tr>
                </table></td>
                <td class="Estilo1" valign="bottom">_____________________<br />
                  FIRMA DEL ESTAD&Iacute;STICO </td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
