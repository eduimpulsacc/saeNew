<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');


	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente

	
	$fecha1 	 = $anoN."-04-30"; 
	$ob_membrete = new Membrete();
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
	$ob_reporte = new Reporte();
	$ob_reporte ->cod_tipo = $cmb_curso;
	$ob_reporte ->TipoEnsenanza($conn);

	
	$ob_reporte ->institucion = $institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->cmb_curso = $cmb_curso;
	$ob_reporte ->orden =$orden;
	$resultado_query= $ob_reporte ->AlumnoEnsenanza($conn);
	$total_filas= @pg_numrows($resultado_query);
	
	
if(!$cb_ok =="Buscar"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Registro_Matricula_Ensenanza_$Fecha.xls"); 
	
}	

	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script>
	function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
	</script>
	
<SCRIPT language="JavaScript">
<!--
			function enviapag2(form){
					form.target="_blank";
		   			form.action=='printRegistroMatricula_Ensenanza_C2.php?cmb_curso=<?=$curso?>&orden=<?= $orden?>';
					form.submit(true);
		  	}
function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'RegistroMatricula.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
//-->
</script>
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
//-->
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<style type="text/css">
<!--
.Estilo1 {font-size: 9px}
-->
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 <form name="form" action="printRegistroMatricula_Ensenanza_C2.php?cmb_curso=<?=$curso?>" method="post">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
            
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->

  <STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
<center>
<?
if ($curso != 0){
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
  <td>
  	<div id="capa0">
	<TABLE width="100%"><TR><TD>
	<table>
    <tr>
	  <td align="left"><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">	  </td>
	</tr>
  </table>
  </TD><TD>
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">	
          <!--INPUT name="button" TYPE="button" class="botonX" onClick=document.location="curso.php3" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' value="VOLVER"-->
  		</div></TD>
		
  <TD><input name="exp" TYPE="button" class="botonXX" onClick="enviapag2(this.form)" value="EXPORTAR"></TD>
	
	</TR></TABLE>
	</div>
	</td>
  </tr>
  <tr>
    <td>
	 <table width="100%" height="" border="0" >
        <tr>
          <td width="138" align="left" class="textonegrita">ESTABLECIMENTO</td>
          <td width="200" align="left" class="textonegrita">:&nbsp;<?=$ob_membrete->ins_pal; ?></td>    
          <td width="50" align="left" class="textonegrita">RBD</td>
          <td width="77" align="left" class="textonegrita">:&nbsp;<? echo $institucion."-".$ob_membrete->dig_rdb;; ?></td>
		  <td width="166" align="left" class="textonegrita">TIPO DE ENSEÑANZA</td>
		  <td width="243" align="left" class="textonegrita">:&nbsp;<? echo strtoupper($ob_reporte->nombre) ?></td>
        </tr>
        <tr>
          <td class="textonegrita">DIRECCION</td>
          <td class="textonegrita">:&nbsp;<? echo $ob_reporte->tildeM(strtoupper($ob_membrete->direccion));?></td>
          <td class="textonegrita">FONO</td>
          <td class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->telefono) ?></td>
		  <td width="166" align="left" class="textonegrita">COMUNA</td>
		  <td width="243" align="left" class="textonegrita">:&nbsp;<? echo strtoupper($ob_membrete->comuna) ?></td>
        </tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
        <tr>
          <td height="16" colspan="15"><div align="center" class="textonegrita"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong>LIBRO DE REGISTRO DE MATR&Iacute;CULA </strong></font></div></td>
        </tr>
      </table>
	    <table width="100%" border="1" align=center cellpadding="0" cellspacing="0" bordercolor="#999999">
          <tr>
            <td colspan="11" class="textonegrita"><center>Datos del Alumno</center></td>
            <td align="center" class="textonegrita">&nbsp;</td>
            <td colspan="5" class="textonegrita"><center>Apoderado</center></td>
          </tr>
          <tr> 
            <td width="19" align="center" class="detalle">N&ordm;</td>
			<td width="50" align="center" class="detalle">Nº Matrícula</td>
			<td width="280" align="center" class="detalle">ALUMNOS</td>
			<td width="60" align="center" class="detalle">RUT</td>
			<td width="100" align="center" class="detalle">COMUNA</td>
            <td width="34" align="center" class="detalle">CURSO</td>                            
            <td width="34" align="center" class="detalle">SEXO</td>
            <td width="44" align="center" class="detalle">FECHA NAC</td>            
            <td width="57" align="center" class="detalle">FECHA INGRESO</td>
            <td width="93" align="center" class="detalle">DOMICILIO</td>
            <td width="8"  class="detalle">&nbsp;</td>
            <td width="114" align="center" class="detalle">PADRE</td>
            <td width="96" align="center" class="detalle">MADRE</td>
            <td width="47" align="center" class="detalle">FECHA<br>
              RETIRO</td>
			<td width="60" align="center" class="detalle"><p>MOTIVO<br>
			RETIRO</p>			  </td>
			<td align="center" class="detalle"><div align="center">OBSERVACIONES</div></td>
		</tr>
          <?

		for ($j=0; $j < $total_filas; $j++){
			$fila_alu = @pg_fetch_array($resultado_query,$j);
			$ob_reporte ->CambiaDato($fila_alu);
		
			$sql="select * from apoderado inner join tiene2 ON apoderado.rut_apo=tiene2.rut_apo where rut_Alumno=".$ob_reporte->alumno." ORDER BY relacion ASC";
			$rs_padres = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
			$nombre_padre = "";
			$nombre_madre = "";
			for($xx=0;$xx<@pg_numrows($rs_padres);$xx++){
				$fila_padre = @pg_fetch_array($rs_padres,$xx);
				
				if($fila_padre['relacion']==1){
					$nombre_padre = "&nbsp;".$fila_padre['nombre_apo']." ".$fila_padre['ape_pat']." ".$fila_padre['ape_mat'];
				}else{
					$nombre_madre = "&nbsp;".$fila_padre['nombre_apo']." ".$fila_padre['ape_pat']." ".$fila_padre['ape_mat'];
				}
			}
				if($ob_reporte->cod_tipo==10){
				$Curso = CursoPalabra($ob_reporte->id_curso,2,$conn);
			}else{
				$Curso=$ob_reporte->grado_curso." - ".$ob_reporte->letra_curso." ".$ob_reporte->ensenanza;
			}
			//--------------------------------------------------
			
			
		?>
          <tr> 
            <td align="center"><span class="Estilo1"><? echo ($j+1);?></span></td>
			
			<td align="center"><span class="Estilo1">
			  <?=$ob_reporte->num_matricula;?>
			</span></td>
            <td align="left"><span class="Estilo1">
              <?=//$fila_alu['nombre_alu'];
			  $ob_reporte->tilde($ob_reporte->ape_nombre_alu);?>
            </span></td>
			<td align="left"><span class="Estilo1">
			  <?=$ob_reporte->rut_alumno;?>
			</span></td>
			<td align="left"><span class="Estilo1">
			  <?=$ob_reporte->comuna;?>
			</span></td>			
			<td align="center"><span class="Estilo1"><? echo $Curso;?></span></td>            
			<td align="center"><span class="Estilo1"><? echo $ob_reporte->sexo;?></span></td>
			<td align="center"><span class="Estilo1">
			  <? impF($ob_reporte->fecha_nacimiento);?>
			</span></td>            
            <td align="center"><span class="Estilo1">
              <? impF($ob_reporte->fecha_matricula);?>
            </span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->direccion_alu); ?>
			</span></td>
			
            <td align="left"></td>
            <td><span class="Estilo1">&nbsp;
              <?=$ob_reporte->tilde($nombre_padre);?>
            </span></td>
            <td align="left"><span class="Estilo1">&nbsp;
              <?=$ob_reporte->tilde($nombre_madre);?>
            </span></td>
            <td align="center"><span class="Estilo1">&nbsp;
              <?=$ob_reporte->telefono_apo;?>
            </span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->direccion);?>
			</span></td>
			<td align="center"><span class="Estilo1">&nbsp;
			  <?=$ob_reporte->tilde($ob_reporte->profesion);?>
			</span></td>
			
          </tr>
          <? }?>
        </table>
      <?
	
	//pg_close($conn);
	?>
    </td>
  </tr>
</table>
<?
}
?>
</center>
<table width="1024" border="0">
		  <tr>
		  	<?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
			<td width="25%" class="item" height="100"><hr align="center" width="150" color="#000000"><div align="center"><span class="item"><?=$ob_reporte->nombre_emp;?> </span><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			<? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
		    <td width="25%" class="item"><hr align="center" width="150" color="#000000"> 
		      <div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			 <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
			<td width="25%" class="item"><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
		    <?=$ob_reporte->nombre_cargo;?></div></td>
			<? } ?>
			 <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);?>
		    <td width="25%" class="item"><hr align="center" width="150" color="#000000"><div align="center"><?=$ob_reporte->nombre_emp;?><br>
	        <?=$ob_reporte->nombre_cargo;?> </div></td>
			<? }?>
		  </tr>
</table>

<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->
								 
<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table>
							  
						    </td>
                          </tr>
                        </table>
						
					</td>
                    </tr>
                  </table>
               </td>
              </tr>
            </table>
          </td>

       
        </tr>
      </table>
    </td>
  </tr>
</table>
</form>
</body>
</html>
<? pg_close($conn);?>