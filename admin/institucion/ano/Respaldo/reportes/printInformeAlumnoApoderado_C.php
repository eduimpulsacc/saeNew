<?
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_Reporte.php');


	$dd = date(d);
    $mm = date(m);
    $aa = date(Y);
    $fechahoy = "$dd-$mm-$aa";

	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$cadena01		="00";	
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;
	//if (empty($curso)) //exit;
	
	//-------------- INSTITUCION -------------------------------------------------------------
	$ob_institucion = new Membrete();
	$ob_institucion -> ano =$ano;
	$ob_institucion -> institucion =$institucion;
	$ob_institucion -> institucion($conn);
	
	
	//-----------------------------------------
	// Institución
	//-----------------------------------------
	/*echo "cualquier cosa".$sql_insti = "Select * from institucion where rdb = ".$institucion;
	$result_insti =@pg_Exec($conn,$sql_insti);
	$fila_insti = @pg_fetch_array($result_insti,0);	
	$nombre_insti = $fila_insti['nombre_instit'];*/
	//-----------------------------------------
	// Curso y Profesor Jefe
	//-----------------------------------------
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	//-----------------------------------------
	$ob_reporte = new Reporte();
	$ob_reporte->curso=$curso;
	$ob_reporte->ProfeJefe($conn);
	$profe_jefe = $ob_reporte->profe_jefe;
	//-----------------------------------------
	// Alumnos
	//-----------------------------------------
	$ob_reporte->curso=$curso;
	$ob_reporte->ano=$ano;
	$ob_reporte->retirado=0;
	$result_alu=$ob_reporte->FichaAlumnoTodos($conn);		
	//-----------------------------------------
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	
if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Informe_alumnos_con_apoderados_$fecha_actual.xls"); 	 
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}


function exportar(){
			window.location='printInformeAlumnoApoderado_C.php?cmb_curso=<?=$curso?>&xls=1';
			return false;
		  }


</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>

<body leftmargin="0" topmargin="0" marginwidth="0">
<form name="form" method="post" action="printInformeAlumnoApoderado_C.php" target="_blank">
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td>
	
    </td>
  </tr>
      <tr>
      <td>
	  <div id="capa0">
	    <TABLE width="100%"><TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD  align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
          <input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR"></TD>
	    </TR></TABLE>
      </div>
	  
	  
	  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$ob_institucion->ins_pal;?></strong></font></td>
        <td rowspan="4" align="center"><? echo "<img src='".$d."tmp/".$institucion."insignia". "' >";	?></td>
      </tr>
      <tr>
        <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$ob_institucion->direccion;?></strong></font></td>
        </tr>
      <tr>
        <td><font face="Verdana, Verdana, Arial, Helvetica, sans-serif" size="1"><strong><?=$ob_insitucion->telefono;?></strong></font></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" align="center" class="tableindex"><div align="center">INFORME ALUMNO APODERADO </div></td>
      </tr>
      <tr>
            <td colspan="2" align="center"><font size="1" face="verdana, arial, geneva, helvetica"><strong>&nbsp; </strong></font></td>
      </tr>
      </table>
      <br>
	  <table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
            <td width="115"><font size="1" face="verdana,arial, geneva, helvetica"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="verdana,arial, geneva, helvetica">:</font></div></td>
        <td width="531"><font size="1" face="verdana,arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
           <td><font size="1" face="verdana,arial, geneva, helvetica"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica">:</font></td>
        <td><font size="1" face="verdana,arial, geneva, helvetica"><? echo $ob_reporte->tildeM($profe_jefe);?></font></td>
      </tr>
	 <tr>
    <td>&nbsp;</td>
  </tr>
      </table>
	  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td  colspan="5" class="titulo">INFORMACION DEL ALUMNO</td>
        <td  colspan="6" class="titulo">INFORMACIÓN APODERADO</td>
      </tr>
      <tr>
         <td align="center" class="item" ><strong>Nº Mat.</strong></td>
	     <td align="center" class="item" ><strong>Rut</strong></td>
		 <td align="center" class="item" ><strong>Nombre</strong></td>
	     <td align="center" class="item" ><strong>Apellido Paterno</strong></td>
		 <td align="center" class="item" ><strong>Apellido Materno</strong></td>
		 
	     <td align="center" class="item" ><strong>Rut</strong></td>
		 <td align="center" class="item" ><strong>Nombre</strong></td>
		 <td align="center" class="item" ><strong>Apellido Paterno</strong></td>
		 <td align="center" class="item" ><strong>Apellido Materno</strong></td>
		 <td align="center" class="item" ><strong>Dirección</strong></td>
		 <td align="center" class="item" ><strong>Teléfono</strong></td>
	 </tr>

       <?
	  $numero_alumnos = @pg_numrows($result_alu);	 
	  
	  
	  for($i=0 ; $i < @pg_numrows($result_alu) ; $i++){
	     $fila_alu = @pg_fetch_array($result_alu,$i);
		 $ob_reporte->CambiaDato($fila_alu);
		 
	     $rut_alumno = $ob_reporte->rut_alumno;
		 $nombre_alu = $ob_reporte->nombre;
		 $ape_pat    = $ob_reporte->ape_pat;
		 $ape_mat    = $ob_reporte->ape_mat;
		 
		 $rut_alumno = $fila_alu['rut_alumno'];
	     ?>	
         <tr>
         <td align="center" class="subitem"><? echo $i+1; ?></td>
         <td class="subitem"><? echo $rut_alumno; ?></td>
		 <td class="subitem"><?=$ob_reporte->tilde($nombre_alu);?></td>
		 <td class="subitem"><?=$ob_reporte->tilde($ape_pat);?></td>
		 <td class="subitem"><?=$ob_reporte->tilde($ape_mat);?></td>
	    
			  <?
	          // Aqui saco la informacion del apoderado y su telefono
	          $ob_reporte->alumno=$rut_alumno;
			  $res_apo=$ob_reporte->Apoderado($conn);
	
	          $num_apo = @pg_numrows($res_apo);
	          $fila_apo = @pg_fetch_array($res_apo,0);
			  $ob_reporte->CambiaDatoApo($fila_apo);
	          $rut_apo    = $ob_reporte->rut_apo;
			  $nombre_apo = $ob_reporte->nombre_apo;
	          $ape_pat    = $ob_reporte->ape_pat;
			  $ape_mat    = $ob_reporte->ape_mat;
			  $calle      = $ob_reporte->calle;
			  $telefono   = $ob_reporte->telefono;         
			
		      ?>	
		      <td class="subitem"><div align="left">&nbsp;<? echo $rut_apo; ?></div></td>
			  <td class="subitem"><div align="left">&nbsp;<? echo $ob_reporte->tilde($nombre_apo); ?></div></td>
		      <td class="subitem"><div align="center">&nbsp;<? echo $ob_reporte->tilde($ape_pat); ?></div></td>
			  <td class="subitem"><div align="left">&nbsp;<? echo $ob_reporte->tilde($ape_mat); ?></div></td>
			  <td class="subitem"><div align="left">&nbsp;<? echo $ob_reporte->tilde($calle); ?></div></td>
			  <td class="subitem"><div align="left">&nbsp;<? echo $telefono; ?></div></td>
	    </tr>
  	     <?  } ?>
	</table>
	</td>
  </tr>
</table>
<br>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
        </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="item"><hr align="center" width="150" color="#000000">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }?>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>