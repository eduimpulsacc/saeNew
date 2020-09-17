<?php
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
include('../../../../clases/class_MotorBusqueda.php');
include('../../../../clases/class_Membrete.php');
include('../../../../clases/class_Reporte.php');



	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$reporte		=$c_reporte;
	$ensenanza		=$cmbENSENANZA;
	$curso =1;
	
	$fecha = $_POST['fecha'];
	
	$f = explode("-",$fecha);
	
	$fecha =$f[2]."-".$f[1]."-".$f[0];
	
 	$result = pg_exec($conn,$sql);
	$conteo = @pg_numrows($result_periodo);
	
		
	$ob_membrete = new Membrete();
	$ob_reporte = new Reporte();
	
	$ob_membrete ->institucion = $institucion;
	$ob_membrete ->institucion($conn);
	
	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	

	function mes_pal($mes){
	if ($mes == 01) $mes_pal = "Enero de ";
	    if ($mes == 02) $mes_pal = "Febrero de ";
	    if ($mes == 03) $mes_pal = "Marzo de ";
	    if ($mes == 04) $mes_pal = "Abril de ";
	    if ($mes == 05) $mes_pal = "Mayo de ";
	    if ($mes == 06) $mes_pal = "Junio de ";
	    if ($mes == 07) $mes_pal = "Julio de ";
	    if ($mes == 08) $mes_pal = "Agosto de ";
	    if ($mes == 09) $mes_pal = "Septiembre de ";
	    if ($mes == 10) $mes_pal = "Octubre de ";
	    if ($mes == 11) $mes_pal = "Noviembre de ";
	    if ($mes == 12) $mes_pal = "Diciembre de ";
		 return $mes_pal;	
	}
	
	
	//cursos
	 $sql = "SELECT 
			n.pagina_tabla,
			count(n.pagina_tabla) as cuenta,
			c.id_curso,
			c.grado_curso,
			c.letra_curso,
			e.cod_tipo,
			e.nombre_tipo,
			n.rut_usuario,n.rbd 
			from navegacion n
			join curso c on c.id_curso = n.id_curso
			join tipo_ensenanza e on c.ensenanza = e.cod_tipo 
			where n.fecha ='$fecha' and n.rbd = $institucion
			GROUP BY n.pagina_tabla,c.id_curso,c.grado_curso,c.letra_curso,e.cod_tipo,e.nombre_tipo,n.rut_usuario,n.rbd 
			order by e.cod_tipo,c.grado_curso,c.letra_curso,e.nombre_tipo";
	$result = pg_exec($conn,$sql);
	
	function CambioFechaDisplay($fecha)   //    cambia fecha del tipo   aaaa/mm/dd  ->  dd/mm/aaaa   para mostrarlo en pantalla
{
	$retorno="";
	if(strlen($fecha) <10 )
		return $retorno;
	$d=substr($fecha,8,2);
	$m=substr($fecha,5,2);
	$a=substr($fecha,0,4);
	if (checkdate($m,$d,$a))
		$retorno=$d." ".mes_pal($m).$a;
	else
		$retorno="";
	return $retorno;
}

?>		
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>
<script language="JavaScript" type="text/JavaScript">
<!--
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
//-->
</script>
<script>
function exportar(form){
	form.target="_blank";
	document.form.action='printInformeAsistenciaPorcentaje_C.php';
	document.form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
</script>
<style type="text/css">
.item { font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;
}
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" >
<div id="capa0">
  <table width="950" border="0" align="center">
    <tr>
      <td><input type="button" name="Submit" value="CERRAR" onClick="window.close()" class="botonXX"/></td>
      <td><div align="right">
        <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
      </div></td>
    </tr>
  </table>
</div>
  <br>
  <table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="697"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
      <td width="10">&nbsp;</td>
      <td width="125" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
        <tr valign="top">
          <td width="125" align="center">
		<?
						if($institucion!=""){
						   echo "<img src='".$d."../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>
          </td>
        </tr>
      </table></td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono: &nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td height="41" valign="top">&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br>
<table width="950" border="0" align="center" >
  <tr>
    <td class="tableindex" align="center">&nbsp;<div align="center">Informe de Navegaci&oacute;n </div>
      &nbsp;</td>
  </tr>
</table>
<br>
<table width="950" border="0" align="center">
  <tr>
    <td width="62" class="textonegrita">Fecha:</td>
    <td width="878" class="textosimple">&nbsp;<?php echo $_POST['fecha'] ?></td>
  </tr>
</table>
<br>
<br>
<table width="950" border="0" align="center">
  <tr class="tableindex">
    <td width="162" class="textonegrita">Curso</td>
    <td width="498" class="textonegrita">P&aacute;gina</td>
    <td width="102" align="center" class="textonegrita">Apoderado</td>
    <td width="91" align="center" class="textonegrita">Alumno</td>
   
    
  </tr>
  <?php  for($i=0;$i<@pg_numrows($result);$i++){
	  	$fila = pg_fetch_array($result,$i);?>
  <tr class="textosimple">
    <td >&nbsp;<?=$fila['grado_curso']."º-".$fila['letra_curso'] ." ".$fila['nombre_tipo'];?></td>
    <td ><?php echo $fila['pagina_tabla'] ?></td>
    <?php 
		$sql_cc = "select id_perfil from accede
join usuario on usuario.id_usuario = accede.id_usuario
where usuario.nombre_usuario = '".$fila['rut_usuario'] ."' and accede.id_perfil in(15,16) and accede.rdb = ".$fila['rbd'];
$result_cc = pg_exec($connection,$sql_cc);

$perfil = @pg_fetch_array($result_cc,0);
		
		?>
    <td align="center" >
    <?php if($perfil['id_perfil'] == 15){?>
		<?php echo $fila['cuenta'];?><?php }?>
        </td>
	<td align="center" >
	<?php 	 if($perfil['id_perfil']  == 16){?>
		<?php echo $fila['cuenta'];?>
	<?php }?>
   </td>
    
   
   
  </tr>
  <?php }?>
</table>

<br>
<br>


<table width="650" border="0" align="center">
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

<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <td class="textosimple">&nbsp;<? echo $ob_membrete->comuna.", ".date("d-m-Y");?></td>
  </tr>
</table>
</div>
</body>
</html>
<? 
	//fin ano
pg_close($conn);?>