<?php 
	require('../../../../util/header.inc');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Lista_Personal_$Fecha.xls"); 
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function exportar(){
			//form.target="_blank";
			window.location='printListadoPersonal_C.php?lista_nombre=<?=$lista_nombre?>&lista_email=<?=$lista_email?>&lista_fecha=<?=$lista_fecha?>&lista_comuna=<?=$lista_comuna?>&lista_fono=<?=$lista_fono?>&lista_cargo=<?=$lista_cargo?>&lista_dir=<?=$lista_dir?>&lista_rut=<?=$lista_rut?>&c_reporte=<?=$reporte?>';
			//document.form.submit(true);
		return false;
}

//-->
</script>

<style type="text/css">
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->



<center>
<table width="550" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="3">
        <?php if(($_PERFIL!=15)and($_PERFIL!=16)and($_PERFIL!=17)) { ?>
	<div align="right">
	  <div class="Estilo8" id="capa0">Esta Hoja debe Imprimirse en forma Horizontal 
	    <input name="button3" TYPE="button" class="botonXX" onClick="imprimir();" value="IMPRIMIR">
	  </div>
    </div>
    <span class="Estilo8">
    <?	}	?>	
    </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span class="Estilo8">
      <input name="button32" TYPE="button" class="botonXX" onClick="javascript:exportar()" value="EXPORTAR">
    </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <TR><TD colspan="2">&nbsp;</TD></TR>
</table>

<? if ($institucion=="770"){ 
		       // no muestro los datos de la institucion
			   // por que ellos tienen hojas pre-impresas
			   echo "<br><br><br><br><br>";
  }
?>



  <table width="90%" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=5> <table width="550" border=0 cellspacing=1 cellpadding=1>
          <tr> 
            <td align=left class="item"> <strong> INSTITUCION 
              </strong> </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?php  
                  $ob_membrete->institucion = $institucion;                                   
					$ob_membrete->institucion($conn);
					echo $ob_membrete->ins_pal;
				?>
               </font> </td>

                <td width="161" rowspan="5" align="center" valign="top" >
	
   <? if ($institucion=="770"){ 
		  
			   
	 }else{
		
		    ?>


			  <?
			  if($institucion!=""){
				   echo "<img src='".$d."tmp/".$institucion."insignia". "' >";
			  }else{
				   echo "<img src='".$d."menu/imag/logo.gif' >";
			  }?>
  <? } ?>	  </td>
          </tr>
          <tr> 
            <td align=left class="item">  <strong>AÑO ESCOLAR</strong>  </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> </font> </td>
            <td class="subitem"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?php
					$ob_membrete->ano = $ano;
					$ob_membrete ->AnoEscolar($conn);
					echo $ob_membrete->nro_ano;
			?>
               </font> </td>
          </tr>
          <tr> 
            <td align=left class="item">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="subitem">&nbsp;</td>
          </tr>
		  
		<tr> 
            <td align=left class="item">&nbsp;</td>
            <td>&nbsp;</td>
            <td class="subitem">&nbsp;</td>
          </tr>  
		  
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		  
        </table></td>
    </tr>

      <tr>
        <td height="20" class="tableindex"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#ffffff">
					    <strong>LISTADO DEL PERSONAL ADAPTABLE</strong></font></div></td>
      </tr>

	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td>
	
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
			<tr bgcolor="#48d1cc"> 
			  <? if($lista_rut==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">RUT</span></td>
<?			}?>
			  
<?			if($lista_nombre==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">APELLIDOS</span></td>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">NOMBRES</span></td>

<?			}
			if($lista_fono==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">TELEFÓNO</span></td>
<?			}
			if($lista_dir==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">DIRECCIÓN</span></td>
<?			}	
			if($lista_email==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">EMAIL</span></td>
<?			}	?>
<? 			if($lista_comuna==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item">COMUNA</td>
<? 			}
			if($lista_cargo==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">CARGO</span></td>
<? 			}
			if($lista_fecha==1){		?>
			<td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">FECHA NAC.</span></td>
<? 			}
?>
			</tr>
	<?php
		$ob_reporte->institucion = $institucion;
		$result=$ob_reporte->Empleado($conn);
			?>
	<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
			?>
			<tr>
		  <? if($lista_rut==1){	?>
			  <td width="0%" align="center" class="subitem"><?=$fila['rut_emp']."-".$fila['dig_rut'];?>&nbsp;</td>
<?			}?>
			  
<?			if($lista_nombre==1){	?>
			  <td width="0%" align="center" class="subitem" ><div align="left">&nbsp;
			    <?=$ob_reporte->tilde(ucfirst(strtolower($fila['ape_pat'])))." ".$ob_reporte->tilde(ucfirst(strtolower($fila['ape_mat'])));?>
		      </div></td>
			  <td width="0%" align="center" class="subitem" ><div align="left">&nbsp;
			    <?=$ob_reporte->tilde(ucwords(strtolower($fila['nombre_emp'])));?>
		      </div></td>

<?			}
			if($lista_fono==1){	?>
			  <td width="0%" align="center" class="subitem" >&nbsp;<?=$fila['telefono'];?></td>
<?			}
			if($lista_dir==1){		?>
			  <td width="0%" align="center" class="subitem" ><div align="left">&nbsp;
			    <?=$ob_reporte->tilde(ucwords(strtolower($fila['calle']." ".$fila['nro'])));?>
		      </div></td>
<?			}	
			if($lista_email==1){		?>
			  <td width="0%" align="center" class="subitem" ><div align="left">&nbsp;
			    <?=$fila['email'];?>
		      </div></td>
<?			}	?>
<? 			if($lista_comuna==1){		?>
			  <td width="0%" align="center" class="subitem">&nbsp; <?=$fila['nom_com'];?></td>
<? 			}
			if($lista_cargo==1){		?>
			  <td width="0%" align="center" class="subitem"><div align="left">&nbsp;
			    <?=$fila['nombre_cargo'];?>
		      </div></td>
<? 			}
			if($lista_fecha==1){		?>
			<td width="0%" align="center" class="subitem"><div align="right">&nbsp;
			  <? impF($fila['fecha_nacimiento']);?>
			  </div></td>
<? 			}
?>
	    </tr>
    <?php
				}
			
			?>
	</table></td></tr>
    
	<tr> 
      <td colspan="5"></td>
    </tr>
  </table>
</center>
   <?
  //}
 ?>
</body>
</html>
<? pg_close($conn);?>