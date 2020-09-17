<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<?php
require('../../../../../../util/header.inc');
require('../../../../../../util/LlenarCombo.php3');
require('../../../../../../util/SeleccionaCombo.inc');
include('../../../../../clases/class_MotorBusqueda.php');
include('../../../../../clases/class_Membrete.php');
include('../../../../../clases/class_Reporte.php');

if ($institucion==299){
	$whe_ensenanza=" OR (ensenanza = 10)";
   //	OR (curso.grado_curso<5) and (curso.ensenanza<>110)
}
if ($dia == ""){
	   ## si el campo esta vacío poner la fecha actual
	   $dia  = strftime("%d",time());
	   $mes  = strftime("%m",time());
	   $mes  = envia_mes($mes);
	   $ano2  = strftime("%Y",time()); 
	}else{
	   $dia = $dia;
	   $mes = $mes;
	   $ano2 = $ano2;
	}   

?>
<?php 
    //setlocale("LC_ALL","es_ES");
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$alumno			=$c_alumno;
	$curso			=$cod_tipo;
	$cod_tipo		=$cmb_curso;
	$reporte		=$c_reporte;
	$_POSP = 6;
	$_bot = 8;
	
	if ($institucion==769){
	    $cargo="23";
	}else{
	    $cargo="1";
	}
	//--------------- NOMBRE DIRECTOR ---------------------------------//
	$ob_reporte = new Reporte();
	$ob_reporte->institucion=$institucion;
	$ob_reporte->cargo=$cargo;
	$resultDIR = $ob_reporte->EmpleadoCargo($conn);
	
	//--------------------- AÑO ESCOLAR -----------------------------------//
	$ob_reporte->ano=$ano;
	$ob_reporte->AnoEscolar($conn);
	$nro_ano = $ob_reporte->nro_ano;
	
	//--------------------DATOS DE LA INSTITUCION ------------------------//
	$ob_membrete = new Membrete();
	$ob_membrete->institucion=$institucion;
	$ob_membrete->institucion($conn);
		
	$q1 = "select * from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
	$r1 = @pg_Exec($conn,$q1);
	$n1 = @pg_numrows($r1);
	$f1 = @pg_fetch_array($r1,0);
	$cargo = $f1['cargo'];
		
	if ($cargo==1){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "Director(a)";
	}
	if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "Rector(a)";
	}
	
	$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano." AND ensenanza=".$cod_tipo." LIMIT 1 OFFSET 1";
	$rs_curso = @pg_exec($conn,$sql);
	$curso = @pg_result($rs_curso,0);
	
	if($curso!=1){
		if($cod_tipo==110){
			$grado=8;
		}else{
			$grado=4;
		}	
		$sql="SELECT id_curso FROM curso WHERE id_ano=".$ano."  and grado_curso=$grado LIMIT 1 OFFSET 0";
		$rs_curso = @pg_exec($conn,$sql);
		$curso1 = @pg_result($rs_curso,0);
	}else{
		$curso1 = $curso;
	}
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
		if($_PERFIL!=0 && $_PERFIL!=14){
			//veo si tiene autorizacion permanente
			$autp=$ob_reporte->checAutReporteTrabaja($conn);
			$aut = pg_result($autp,0);
			//echo "aut->".$aut;
			
		
			if($aut==0){
				//veo si el usuario tiene el reporte
				$ob_reporte->rdb=$institucion;
				$ob_reporte->usuario= $_NOMBREUSUARIO;
				$ob_reporte->item=$reporte;
				$rp = $ob_reporte->checAutReporte($conn);
				$crp= pg_numrows($rp);
				//echo "aut2->".$crp;
			
				}
				else{
				$crp = $aut;
				}
				
				$rs_quita = $ob_reporte->quitaAutReporte($conn);
		}
		else{
		$crp=1;
		}


if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){	 
$fecha_actual = date('d/m/Y-H:i:s');
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Alumnos_licenciados_$fecha_actual.xls"); 	 
}

	
 ?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">


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

<script language="javascript" type="text/javascript">

function exportar(){
			window.location='printalumnos_licenciados_C.php?cmb_curso=<?=$cod_tipo?>&grado_curso=<?=$curso?>&xls=1';
			return false;
		  }

</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->
<form name="form" method="post" action="../../printalumnos_licenciados_C.php" target="_blank">
<table width="700" border="0"  cellpadding="0" cellspacing="0">
  <tr>
    <td><div id="capa0">
	<table width="100%">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()" value="CERRAR"></td>
	<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
		  <input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR"></td>
	  </tr></table>
      </div></td>
  </tr>
</table>
<table width="700" border="0"  cellpadding="0" cellspacing="0" bordercolor="#000000" >
  <tr>
    <td valign="top">
	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><img src="../../LOG_GOBIERNO.jpg" width="130" height="125"><br>
           <br></td>
      </tr>
      <tr>
        <td><div align="center" class="Estilo2">N&oacute;mina de Alumnos Licenciados</div>
          <?php 
		  		$ob_reporte->cod_tipo=$cod_tipo;
				$ob_reporte->TipoEnsenanza($conn);
						  
		  echo "<font face=verdana size=1><div align=center>$ob_reporte->nombre</div></font>";
		  
		  ?>
     </td>
      </tr>
    </table>
     
      <br>
      <table width="100%" border="1" cellpadding="3" cellspacing="0" bordercolor="#999999">
        <tr>
          <td colspan="6">
		  
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="20%" class="item">Establecimiento</td>
              <td width="42%" class="subitem"><?=$ob_membrete->ins_pal;?></td>
              <td width="11%" class="item">A&ntilde;o escolar </td>
              <td width="27%" class="subitem"><?=$nro_ano ?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="item">Regi&oacute;n</td>
              <td class="subitem"><?=$ob_membrete->region;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="item">Provincia</td>
              <td class="subitem"><?=$ob_membrete->provincia;?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td class="item">Comuna</td>
              <td class="subitem"><?=$ob_membrete->comuna;?></td>
            </tr>
          </table>
          </td>
        </tr>
        <tr>
          <td width="4%" height="25" bgcolor="#CCCCCC" class="item">N&ordm;</td>
          <td width="20%" bgcolor="#CCCCCC" class="item">Apellido Paterno </td>
          <td width="20%" bgcolor="#CCCCCC" class="item">Apellido Materno </td>
          <td width="23%" bgcolor="#CCCCCC" class="item">Nombres </td>
          <td width="13%" bgcolor="#CCCCCC" class="item">R.U.N.</td>
		  <? if($cod_tipo > 110){?>
          <td width="20%" bgcolor="#CCCCCC" class="item">Especialidad</td>
		  <? } ?>
        </tr>
		<?
			if ($cod_tipo==110){
				$grado_curso = 8;
			}
			if ($cod_tipo==310 or $cod_tipo==510 or $cod_tipo==610  or $cod_tipo==410){
				$grado_curso = 4;
			}	
			if($cod_tipo==660){
				$grado_curso = 8;
			}
			if($cod_tipo==363){
				$grado_curso = 3;
			}
			if($cod_tipo > 110 and $institucion==1590){
				$cod_tipo="310,410,510,610";
			}
			?>
			<input name="grado_c" type="hidden" value="<?=$grado_curso?>">
			<?
			$ob_reporte->ano=$ano;
			$ob_reporte->cod_tipo=$cod_tipo;
			$ob_reporte->grado_curso=$grado_curso;
			if($institucion!=1590){
				$result=$ob_reporte->AlumnosPromovidos($conn);
			}else{
				$result=$ob_reporte->AlumnosPromovidos2($conn);
			}
			for($x=0;$x<@pg_numrows($result);$x++){ 
				$fila_alumnos = pg_fetch_array($result,$x);
				$ob_reporte->CambiaDato($fila_alumnos);
			?>	
             
			<tr>
			  <td class="subitem"><?=$x + 1; ?></td>
			  <td class="subitem"><?=$ob_reporte->tilde($ob_reporte->ape_pat); ?></td>
			  <td class="subitem"><?=$ob_reporte->tilde($ob_reporte->ape_mat);?></td>
			  <td class="subitem"><?=$ob_reporte->tilde($ob_reporte->nombre);?></td>
			  <td class="subitem"><?=$ob_reporte->rut_alumno;?></td>
			  <? if($cod_tipo > 110){?>
			  <td class="subitem">&nbsp;<?=$fila_alumnos['nombre_esp'];?></td>
			  <? } ?>
			</tr>
			<?
			
			//if ($x==26){ ?>
     <!-- </table>		   
			    <H1 class=SaltoDePagina>&nbsp;</H1>
			    <table width="100%" border="1" cellpadding="3" cellspacing="1" bordercolor="#999999">-->
		  <? //} 
		}
		?>	
      </table>
      <br>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="subitem"><?php echo ucwords(strtolower($ob_membrete->comuna)).", ".$dia." de ".$mes." del ".$ano2 ?>&nbsp;<br>
            <br>
            <br></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" class="subitem"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
               
               <? $ob_reporte->CambiaDatoEmp($resultDIR,0);
			    $rut_emple=$ob_reporte->rut_emple;
            if(is_file("../../../../empleado/firma_digital/".$rut_emple.".jpg")  && $crp==1){
	$firmadig="<img src='../../../../empleado/firma_digital/$rut_emple.jpg' width='100' height='50'>";?>  				
			     <td width="50%" class="subitem"><div style="width:100; height:50;"></div>
				<div align="center">
				 _________________________<br>
		  <?=$enomina ?>	  
		  <br>
          ENCARGADO DE CONFECCION DE NOMINAS</div>
				</td>
                
			   <td width="50%" class="subitem" align="center"><?=$firmadig?>
				<div align="center">
				 _________________________<br>
		  <?
		  if ($_INSTIT==1756){
		     echo "RAQUEL GUERRERO OVALLE"; 
		  
		  }else{
              $ob_reporte->CambiaDatoEmp($resultDIR,0);
			  echo $ob_reporte->nombre;
			       $ob_reporte->rut_emple;
		  }
		  
		 	  ?>
		  <br>
           DIRECTOR(A) DEL ESTABLECIMIENTO<? //=$cargo_dir2 ?></div>
				</td><? }else{?><!--<script>alert('NO EXISTE FIRMA');</script>-->
			   <td width="50%" class="subitem">
				<div align="center">
				 _________________________<br>
		  <?=$enomina ?>	  
		  <br>
          ENCARGADO DE CONFECCION DE NOMINAS</div>
				</td>
			   
                <td width="50%" class="subitem">
                
				<div align="center">
				 _________________________<br>
		  <?
		  if ($_INSTIT==1756){
		     echo "RAQUEL GUERRERO OVALLE"; 
		  
		  }else{
              $ob_reporte->CambiaDatoEmp($resultDIR,0);
			  echo $ob_reporte->nombre;
			  
		  }
		  
		  ?>	  
		  <br>
           DIRECTOR(A) DEL ESTABLECIMIENTO<? //=$cargo_dir2 ?></div>
				</td><? }?>
              </tr>
            </table></td>
        </tr>
      </table>
      <br></td>
  </tr>
</table>
</form>
<br>

<!-- FIN CUERPO DE LA PAGINA -->

</body>
</html>
<? pg_close($conn);?>