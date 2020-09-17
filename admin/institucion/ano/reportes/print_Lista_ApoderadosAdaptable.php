<?php 
	require('../../../../util/header.inc');
	include('../../../clases/class_Membrete.php');
	include('../../../clases/class_Reporte.php');
	
	//print_r($_POST);
	
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
			window.location='print_Lista_ApoderadosAdaptable.php?cmb_curso=<?=$curso?>&lista_sexo=<?=$lista_sexo?>&email=<?=email?>&lista_fecha=<?=$lista_fecha?>&lista_comuna=<?=$lista_comuna?>&lista_fono=<?=$lista_fono?>&lista_padre=<?=$lista_padre?>&lista_madre=<?=$lista_madre?>&lista_dir=<?=$lista_dir?>&lista_rut=<?=$lista_rut?>&c_reporte=<?=$reporte?>&ck_retirado=<?=$ck_retirado?>';
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
					    <strong>LISTADO APODERADOS DEL CURSO ADAPTABLE</strong></font></div></td>
      </tr>

	<tr><td>&nbsp;</td></tr>
	<br>
	<tr><td>
	
		<table width="100%" border="1" cellpadding="0" cellspacing="0">
			<tr bgcolor="#48d1cc"> 
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">N&ordm;</span></td>
			  
			  <? if($email==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">E-mail</span></td>
<?			}?>
              <td colspan="2" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">APELLIDOS</span></td>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">NOMBRES</span></td>
<?			if($lista_rut==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">RUT</span></td>
<?			}
			if($lista_sexo==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">SEXO</span></td>
<?			}
			if($nacionalidad==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">NACION.</span></td>
<?			}

			if($lista_fecha==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">FECHA NAC.</span></td>
<?			}

if($salud==1){	?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">SISTEMA SALUD</span></td>
<?			}

			if($lista_fono==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">TELEFONO</span></td>
<?			}	
			if($lista_dir==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item" ><span class="Estilo5">DIRECCI&Oacute;N</span></td>
<?			}	?>

<? 			if($lista_comuna==1){		?>
			  <td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">COMUNA</span></td>
			  <td width="0%" align="center" bgcolor="#999999" class="item">RUT ALMUNO</td>

<? 			

             }
		
?>
			<td width="0%" align="center" bgcolor="#999999" class="item"><span class="Estilo5">NOMBRE ALUMNO</span></td>
			</tr>
	<?php
		$ob_reporte->ano = $ano;
		$ob_reporte->curso = $curso;
		$ob_reporte->retirado=$ck_retirado;
		$ob_reporte->orden=$ck_opcion;
		//$result=$ob_reporte->FichaAlumnoTodos($conn);
		
		
		$ob_reporte->cmb_curso = $curso;
		$rs_apo = $ob_reporte->ApoderadoCurso($conn);
		for($e=0;$e<pg_numrows($rs_apo);$e++){
			
			$fila_apo = pg_fetch_array($rs_apo,$e);
			//print_r($fila_apo);
			
			$sql="SELECT nom_com FROM comuna WHERE cod_reg=".$fila_apo['region']." AND cor_pro=".$fila_apo['ciudad']." AND cor_com=".$fila_apo['comuna'];
			$rs_comuna = pg_exec($conn,$sql);
			$comuna = pg_result($rs_comuna,0);
			$sexo_a = $fila_apo['sexo'];
			$nacionalidad_a = $fila_apo['nacionalidad'];
			$id_sistema_salud = $fila_apo['sistema_salud'];
			
			if($sexo_a==1){$sexo_a = "Femenino";}else if ($sexo_a==2){$sexo_a = "Masculino";}
			if($nacionalidad_a==1){$nacionalidad_a = "Extrangera";}else if ($nacionalidad_a==2){$nacionalidad_a = "Chilena";}
			
			$ob_reporte->id_sistema_salud = $id_sistema_salud;
			$rs_sistema_salud = $ob_reporte->sistema_salud($conn);
			$nombre_sistema_salud = pg_result($rs_sistema_salud,1);
			
			$ob_reporte->rut_apo = $fila_apo['rut_apo'];
			$ob_reporte->curso = $curso;
			$rs_alumno = $ob_reporte->alumno_apo($conn);
			$nombre_alumno = pg_result($rs_alumno,2);
			$ape_pat_alum  = pg_result($rs_alumno,3);
			$ape_mat_alum  = pg_result($rs_alumno,4);
			$nombre_completo_al = $nombre_alumno.' '.$ape_pat_alum.' '.$ape_mat_alum;
			$rut_alum = pg_result($rs_alumno,0)."-".pg_result($rs_alumno,1);
			//$ob_reporte->direccion_apo = $fila_apo['calle']." ".$fila_apo['nro'];
			
			?>
	<?php
			
				
			
				
			?>
			<tr>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<? echo $e+1; ?></font> </td>
			 
			  
			  
			  <?			if($email==1){	?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;
	          <?=$fila_apo['email']; ?>
			  </font> </td>
<?			}?>
			  <td width="0%" align="left" class="subitem"><font color="#000000"><strong>&nbsp;<? echo trim($fila_apo['ape_pat']);?></strong> </font></td>
			
			  <td width="0%" align="left" class="subitem"> <font color="#000000">&nbsp;<? echo ' '.trim($fila_apo['ape_mat']);?></font> </td>
              <td width="0%" align="left" class="subitem"> <font color="#000000">&nbsp;<? echo ' '.trim($fila_apo['nombre_apo']);?></font> </td>
<?			if($lista_rut==1){	?>
			  <td width="0%" align="left" class="subitem" ><font color="#000000"><strong><?=$fila_apo['rut_apo'].'-'.$fila_apo['dig_rut']; ?></strong> </font></td>
<?			}
			if($lista_sexo==1){	?>
			  <td width="0%" align="left" class="subitem" ><font color="#000000"><strong>&nbsp;<?=$sexo_a; ?></strong> </font></td>
<?			}
			if($nacionalidad==1){	?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<?=$nacionalidad_a;?></font> </td>
<?			}

		if($lista_fecha==1){?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<?=$fila_apo['fecha_nac'];?></font> </td>
<?			}

			if($salud==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<?=$nombre_sistema_salud;?></font> </td>
<?			}

	
			if($lista_fono==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;<?=$fila_apo['telefono'];?></font> </td>
<?			}	

			if($lista_dir==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<?=$fila_apo['calle'] ?>
              <?php if(trim($fila_apo['nro'])!=NULL && trim($fila_apo['nro'])!=''  && trim($fila_apo['nro'])!='-' && trim($fila_apo['nro'])!='0'){
					echo " ".$fila_apo['nro']; 
				}?>
              
			<?php if(trim($fila_apo['depto'])!=NULL && trim($fila_apo['depto'])!=''  && trim($fila_apo['depto'])!='-' && trim($fila_apo['depto'])!='0'){
					echo ", depto ".$fila_apo['depto']; 
				}?>
			  	<?php
				 if(trim($fila_apo['block'])!=NULL && trim($fila_apo['block'])!='' && trim($fila_apo['block'])!='-' && trim($fila_apo['block'])!='0'){
					//if(strlen($fila_apo['block'])>0){
					echo ", ".$fila_apo['block']; 
				}?>
			  	<? if(trim($fila_apo['villa'])!=NULL && trim($fila_apo['villa'])!='' && trim($fila_apo['villa'])!='-' && trim($fila_apo['villa'])!='0'){
					
					echo ", ".$fila_apo['villa']; 
				}
			  ?>
			  </font> </td>
<?			}	?>

<?
			if($lista_comuna==1){		?>
			  <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<?=$ob_reporte->tilde($comuna);?></font></td>
			  <td width="0%" align="left" class="subitem" ><?php echo $rut_alum ?></td>
<? 			}
			

?>
		 <td width="0%" align="left" class="subitem" > <font color="#000000">&nbsp;&nbsp;<?=$ob_reporte->tilde($nombre_completo_al);?></font></td>
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
<br>
 <?php  
		 $ruta_timbre =4;
		 $ruta_firma =2;
		 include("firmas/firmas.php");?>
<table width="100%" border="0">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig1="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 1 encontrado";
	             }else{
	               "Archivo Firma 1 no existe"; 
		        }
				if(isset($firmadig1)){
				echo $firmadig1;
				}else{
				?>
    <td width="25%" class="item" height="100"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig2="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 2 encontrado";
	             }else{
	               "Archivo Firma 2 no existe"; 
		        }
				if(isset($firmadig2)){
				echo $firmadig2;
				}else{
				?>
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig3="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
					
		     "Archivo Firma 3 encontrado";
	             }else{
	               "Archivo Firma 3 no existe"; 
		        }
				if(isset($firmadig3)){
				echo $firmadig3;
				}else{
				
				?>
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }} ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->curso=$curso;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->Firmas($conn);
				$rut_emp=$ob_reporte->rut_emp;
				
	  if(is_file("../../empleado/firma_digital/".$rut_emp.".jpg")){
	 $firmadig4="<td align='center' width='25%' class='item' height='100'><img src='../../empleado/firma_digital/$rut_emp.jpg' width='100' height='50'><hr align='center' width='150' color='#000000'><div    align='center'><span class='item'>$ob_reporte->nombre_emp</span><br>$ob_reporte->nombre_cargo</div></td>";
		  
		     "Archivo Firma 4 encontrado";
	             }else{
	               "Archivo Firma 4 no existe"; 
		        }
				if(isset($firmadig4)){
				echo $firmadig4;
				}else{
		?>
    <td width="25%" class="item"><div style="width:100; height:50;"></div>
      <hr align="center" width="150" color="#000000">
      <div align="center">
        <?=$ob_reporte->nombre_emp;?>
        <br>
        <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? }}?>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>