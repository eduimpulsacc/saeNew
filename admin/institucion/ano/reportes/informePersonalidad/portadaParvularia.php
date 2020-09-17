<style>
.bordes{
-webkit-border-radius:27px;
-moz-border-radius:27px;
-ms-border-radius:27px;
-o-border-radius:27px;
border-radius:27px;
border: 4px solid #000000;
}
.portada{
	font-family:"Comic Sans MS", cursive;
}
.titulop{
	font-size:36px;
}
.subitem { font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
}

</style>
<?php 
$Curso_palK = CursoPalabra($curso, 4, $conn);
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<table width="650" border="0" align="center" class="portada">
  <tr>
    <td align="center">&nbsp;<?
						if($institucion!=""){
							if($institucion==26094 && $ob_membrete->cod_ensenanza==10){
								echo "<img src='".$d."tmp/".$institucion."Kinder.jpg". "' >";
							}
							elseif($institucion==10235 ){
								?>
                                <img src="informePersonalidad/lkogo01.png" width="250" /><br />
								<div align="center" style="font-size:24px; font-weight:bold">INFORME AL HOGAR</div>
                                <?
								}
								elseif($institucion==9117){
								
                                 echo "<img src='".$d."tmp/".$institucion."insignia". "'>";
								 ?>
								 <br />
								<div align="center" style="font-size:24px; font-weight:bold">INFORME AL HOGAR</div>
                                <?
								}
							
							else{ 
							   echo "<img src='".$d."tmp/".$institucion."insignia". "'>";
							}
							
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}	?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <?php if($institucion!=9117){?>
  <tr>
    <td align="center" class="titulop"><? echo $titulo2;?></td>
  </tr>
  <?php }?>
  <tr>
    <td>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br /></td>
  </tr>
  <tr>
    <td align="center"><img src="informePersonalidad/ninos2.jpg"  /></td>
  </tr>
  <tr>
    <td><br />
    
    <br />
    <br /></td>
  </tr>
  <tr>
    <td>
    <table width="650" class="bordes"><tr><td>
    <table width="650">
    <tr>
    <td width="90">
    Instituci&oacute;n:
    </td>
    <td width="10" align="center">:</td>
    <td width="534">
   <? echo strtoupper(trim($ob_membrete->ins_pal)) ?>
    </td>
    </tr>
    <tr>
      <td>Curso</td>
      <td align="center">:</td>
      <td><?php echo $Curso_palK; ?></td>
    </tr>
    <tr>
      <td>Alumno</td>
      <td align="center">:</td>
      <td><?php echo strtoupper($ob_reporte->tildeM($ob_reporte->nombres));?></td>
    </tr>
    <tr>
      <td>Rut</td>
      <td align="center">:</td>
      <td><?php echo $ob_reporte->rut_alumno ?></td>
    </tr>
    <tr>
      <td>Edad</td>
      <td align="center">:</td>
      <td><?php echo edad($ob_reporte->fecha_nacimiento)  ?> a&ntilde;os</td>
    </tr>
    <tr>
      <td>Periodo</td>
      <td align="center">:</td>
      <td><?=$ob_membrete->nombre_periodo;?> <?php echo ($ob_membrete->nombre_periodo!="")?"DEL":"" ?> <?=$ob_membrete->nro_ano;?></td>
    </tr>
    <tr>
      <td>Profesor</td>
      <td align="center">:</td>
      <td><?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_nombre);
					}				
					?></td>
    </tr>
    <tr>
      <td>Fecha</td>
      <td align="center">:</td>
      <td><?php
	  $fechax= date("d-m-Y");
	   echo fecha_espanol($txtFECHA) ?></td>
    </tr>
    </table>
    </td></tr></table>
    </td>
  </tr>
</table>
