<?php 
	require('../../../../util/header.inc');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$cmb_curso;
	$reporte		=$c_reporte;
	$_POSP = 4;
	$_bot = 8;

	
	if (trim($_url)=="") $_url=0;
	
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Lista_Curso_$Fecha.xls"); 
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
			window.location='printListaCurso_Adap_C.php?cmb_curso=<?=$curso?>&lista_sexo=<?=$lista_sexo?>&email=<?=email?>&lista_fecha=<?=$lista_fecha?>&lista_comuna=<?=$lista_comuna?>&lista_fono=<?=$lista_fono?>&lista_padre=<?=$lista_padre?>&lista_madre=<?=$lista_madre?>&lista_dir=<?=$lista_dir?>&lista_rut=<?=$lista_rut?>&c_reporte=<?=$reporte?>&ck_retirado=<?=$ck_retirado?>';
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

<?
if ($curso != 0){
   ?>
<?php //echo tope("../../../../../util/");?>
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
  <? if($_PERFIL == 0){?>
    <td><span class="Estilo8">
      <input name="button32" TYPE="button" class="botonXX" onClick="javascript:exportar()" value="EXPORTAR">
    </span></td>
	<? }?>
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
            <td align=left class="item">  <strong>CURSO</strong>              </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?php
					$ob_membrete->curso =$curso;
					$ob_membrete ->curso($conn);
											
					/*if (($ob_membrete->cod_decreto==771982) or ($ob_membrete->cod_decreto==461987) or ($ob_membrete->cod_decreto==121987) or ($ob_membrete->cod_decreto==1521989) or ($ob_membrete->cod_decreto==1000) or ($ob_membrete->cod_decreto==1000)){
						$ob_membrete->grado =$ob_membrete->grado_curso;
						$ob_membrete->decreto =$ob_membrete->cod_decreto;
						$ob_membrete->CambiaDatoCurso($conn);
						echo $ob_membrete->sigla." - ".$ob_membrete->letra_curso." ".$ob_membrete->nombre_tipo;
						
					}else{*/
						echo $ob_membrete->grado_curso." - ".$ob_membrete->letra_curso." ".$ob_membrete->ensenanza;
					//}
				?>
               </font> </td>
          </tr>
		  
		<tr> 
            <td align=left class="item">  <strong>PROFESOR JEFE</strong>              </td>
            <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="1"> <strong>:</strong> 
              </font> </td>
            <td class="subitem"> <font face="Verdana, Arial, Helvetica, sans-serif" size="1">  
              <?
				$ob_reporte->curso = $curso;
			  	$ob_reporte->ProfeJefe($conn);
				echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
				
				?>
               </font> </td>
          </tr>  
		  
		<tr><td>&nbsp;</td></tr>
		<tr><td>&nbsp;</td></tr>
		  
        </table></td>
    </tr>

      <tr>
        <td height="20" class="tableindex"><div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="1" color="#ffffff">
					    <strong>LISTADO DEL CURSO ADAPTABLE</strong></font></div></td>
      </tr>

	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td>
	
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
			<tr bgcolor="#48d1cc"> 
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">N&ordm;</span></td>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">nº Mat.</span></td>
			  
			  <? if($email==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">E-mail</span></td>
<?			}?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">APELLIDOS</span></td>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">NOMBRES</span></td>
<?			if($lista_rut==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">RUT</span></td>
<?			}
			if($lista_sexo==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">SEXO</span></td>
<?			}
			if($lista_fecha==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">FECHA NAC.</span></td>
<?			}
			if($lista_matricula==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">FECHA MAT.</span></td>
<?			}
			if($lista_retiro==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">FECHA RET.</span></td>
<?			}

            if($prioritario==1){	?>
			      <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">PRIORITARIO</span></td>
<?			}


			if($lista_fono==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">TELEFONO</span></td>
<?			}	
			if($lista_dir==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">DIRECCI&Oacute;N</span></td>
<?			}	?>

<? 			if($lista_comuna==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">Comuna</span></td>

<? 			}
			if($lista_padre==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">Padre</span></td>

<? 			}
			if($lista_madre==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">Madre</span></td>

<? 			}
?>
			</tr>
	<?php
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $curso;
		$ob_reporte->retirado=$ck_retirado;
		$ob_reporte->orden=$ck_opcion;
		$result=$ob_reporte->FichaAlumnoTodos($conn);
			?>
	<?php
			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				$fila = @pg_fetch_array($result,$i);
				$ob_reporte ->CambiaDato($fila);
				if($lista_padre==1){
					$sql = "SELECT ape_pat || cast(',' as varchar) || nombre_apo as nombre FROM apoderado a WHERE a.sexo=2 AND a.rut_apo in(SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$fila['rut_alumno'].")";
					$rs_padre = @pg_exec($conn,$sql);
					$Nombre_padre = @pg_result($rs_padre,0);
				}
				if($lista_madre==1){
					$sql = "SELECT ape_pat || cast(',' as varchar) || nombre_apo as nombre FROM apoderado a WHERE a.sexo=1 AND a.rut_apo in(SELECT rut_apo FROM tiene2 WHERE rut_alumno=".$fila['rut_alumno'].")";
					$rs_madre = @pg_exec($conn,$sql);
					$Nombre_madre = @pg_result($rs_madre,0);
				}
				
			?>
			<tr>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<? echo $i+1; ?></font> </td>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<?=$ob_reporte->num_matricula;?>
			  </font> </td>
			  
			  
			  <?			if($email==1){	?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;
	          <?=$ob_reporte->email; ?>
			  </font> </td>
<?			}?>
			  <td width="0%" align="left" class="subitem"><font color="#000000"><strong>&nbsp;<? echo $ob_reporte->tilde($ob_reporte->ape_pat." ".$ob_reporte->ape_mat);?></strong> </font></td>
			
			  <td width="0%" align="left" class="subitem"> <font color="#000000">&nbsp;<?=$ob_reporte->tilde($ob_reporte->nombre); ?></font> </td>
<?			if($lista_rut==1){	?>
			  <td width="0%" align="left" class="subitem" ><font color="#000000"><strong><?=$ob_reporte->rut_alumno; ?></strong> </font></td>
<?			}
			if($lista_sexo==1){	?>
			  <td width="0%" align="left" class="subitem" ><font color="#000000"><strong>&nbsp;<?=$ob_reporte->sexo ?></strong> </font></td>
<?			}
			if($lista_fecha==1){	?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<? impF($ob_reporte->fecha_nacimiento); ?></font> </td>
<?			}
			if($lista_matricula==1){	?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<? impF($ob_reporte->fecha_matricula); ?></font> </td>
<?			}
			if($lista_retiro==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<? impF($ob_reporte->fecha_retiro); ?></font> </td>
<?			}

			if($prioritario==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<? if (trim($ob_reporte->prioritario)=="1"){ echo "SI"; } ?></font> </td>
<?			}

	
			if($lista_fono==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<?=$ob_reporte->telefono_alu; ?></font> </td>
<?			}	

			if($lista_dir==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<?=$ob_reporte->tilde($ob_reporte->direccion_alu); 
			  	if(trim($ob_reporte->depto)!=NULL && trim($ob_reporte->depto)!=''){
					echo ", depto ".$ob_reporte->depto; 
				}
			  	if(trim($ob_reporte->block)!=NULL && trim($ob_reporte->block)!=''){
					echo ", ".$ob_reporte->block; 
				}
			  	if(trim($ob_reporte->villa)!=NULL && trim($ob_reporte->villa)!=''){
					echo ", ".$ob_reporte->villa; 
				}
			  ?>
			  </font> </td>
<?			}	?>

<?
			if($lista_comuna==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<?=$ob_reporte->tilde($ob_reporte->comuna);?></font></td>
<? 			}
			if($lista_padre==1){?>
			<td width="0%" class="subitem"><font color="#000000"><?=$Nombre_padre;?></font></td>
			<? } 
			if($lista_madre==1){ ?>
			<td width="0%" class="subitem"><font color="#000000">&nbsp;<?=$Nombre_madre;?></font></td>
			<? }



?>
	    </tr>
    <?php
				}
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