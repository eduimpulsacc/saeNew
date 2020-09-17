<?php
require('../../../../util/header.inc');	
include('../../../clases/class_Reporte.php');
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $cmbANO;
	$curso			= $cmb_curso;
	$estado 		= $cmbESTADO;
	$reporte		= $c_reporte;
	$especialidad	= $cmbESPECIALIDAD;
	
	$count = 0;
	for($i=1;$i<7;$i++){
		if(${"ck_".$i} == 1){
		$count = $count+1;
		}
	}

$ob_reporte = new Reporte();
$ob_reporte ->cod_estado =$estado;
$rs_estado = $ob_reporte->EstadoPractica($conn);
$nombre_estado = @pg_result($rs_estado,1);

$ob_reporte->especialidad = $especialidad;
$rs_espec = $ob_reporte->Especialidad($conn);
$nombre_esp = @pg_result($rs_espec,0);

//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=1;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
if($valor == "1"){
	$Fecha= date("d-m-Y_h:i");
	header('Content-type: application/vnd.ms-excel');
	header("Content-Disposition:inline; filename=Informe_Practicas_$Fecha.xls"); 
	
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
function enviapag2(form){ //-------------------para exportar
		form.target="_blank";
		form.action='PrintInformePracticas.php?valor=1&cmb_estados=<?=$cmb_estados?>&cmb_alumnos=<?=$cmb_alumnos?>&r_ordena=<?=$r_ordena?>&cmb_ano=<?=$ANO?>&ck_1=<?=$ck_1?>&ck_2=<?=$ck_2?>&ck_3=<?=$ck_3?>&ck_4=<?=$ck_4?>&ck_5=<?=$ck_5?>&ck_6=<?=$ck_6?>&ck_7=<?=$ck_7?>&r_puntaje=<?=$r_puntaje?>';
		form.submit(true);
}
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}
function cerrar(){ 
window.close() 
} 
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
</script>
<script src="../../Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

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
<body>

<form name="form" action="PrintInformePracticas.php" method="post">
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div id="capa0">
	<table width="1000" align="center">
	  <tr><td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></td><td align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </td>
	    <td align="right"><input name="button4" type="button" class="botonXX" onClick="enviapag2(this.form)"  value="EXPORTAR"></td>
	  </tr></table>
      
      </div></td>
  </tr>
</table>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
	<tr>
		<?
		$sql_inst="select * from institucion where rdb=".$institucion;
		$result = @pg_Exec($conn,$sql_inst);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
		if 	(!empty($fila_foto['insignia']))
		{ ?>
			<td width="119" rowspan="6"><?
	  if($institucion!=""){
		   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."menu/imag/logo.gif' >";
	  }?></td>
			<td width="50">&nbsp;</td>
			<td>
	
				<table>
				  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['nombre_instit']?></strong></font></div></td>
				  </tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['calle'].$arr['nro'];?></strong></font></div></td>
					</tr>
				</table>
				<table>  <tr>
					<td width="450"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$arr['telefono'];?></strong></font></div></td>
					</tr>
				</table>			</td>

	<? }
		else{?>
		<td>
			<table width="100%">
			  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->ins_pal?></strong></font></div></td>
			  </tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->direccion;?></strong></font></div></td>
				</tr>
			</table>
			<table>  <tr>
				<td width="100%"><div align="left"><font face="Arial, Helvetica, sans-serif" size="-1"><strong><?=$ob_membrete->telefono;?></strong></font></div></td>
				</tr>
			</table>		</td>
	<? }  ?>
	</tr>
</table>
<?

	$sql2="select nro_ano from ano_escolar where id_ano=$ano";
	$resp2=pg_exec($conn,$sql2);
	$año=pg_result($resp2,0);



?>
<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="tabla03">
    <td colspan="2" align="center">CONTROL DE PROCESO PR&Aacute;CTICA Y TITULACI&Oacute;N</td>
    </tr>
  <tr>
    <td width="186" class="textonegrita">ESPECIALIDAD</td>
    <td width="658" class="textonegrita">&nbsp;<?=$nombre_esp;?></td>
    </tr>
  <tr>
    <td class="textonegrita">A&Ntilde;O</td>
    <td class="textonegrita">&nbsp;<?=$año;?></td>
    </tr>
  <tr>
    <td class="textonegrita">ESTADO</td>
    <td class="textonegrita">&nbsp;<?=$nombre_estado;?></td>
    </tr>
</table>
<?
//-----------------------------obtener alumnos-----------------------------------
  
 		$sql="select distinct a.nombre_alu,a.rut_alumno,a.telefono,a.dig_rut,a.ape_pat,a.ape_mat, ";
		$sql.=" a.fecha_nac,b.fecha_ini,b.id_practica, nombre_emp,c.cod_estado,nombre_estado,e.bool_jor,e.grado_curso, ";
		$sql.="e.letra_curso,f.nombre_tipo from alumno a INNER JOIN practicas b ON (a.rut_alumno=b.rut_alu) ";
		$sql.="INNER JOIN estado_practica c ON (b.estado=c.cod_estado) INNER JOIN matricula d ON ";
		$sql.="(b.rut_alu=d.rut_alumno) INNER JOIN curso e ON (e.id_curso=d.id_curso) ";
		$sql.="INNER JOIN tipo_ensenanza f ON (e.ensenanza=f.cod_tipo) where";
		$sql.=" e.id_ano=".$ano." AND c.cod_estado=".$estado." AND e.cod_es=".$especialidad;
		
	
		$rs_sql= pg_exec($conn,$sql);
		for($i=0;$i<pg_numrows($rs_sql);$i++){
		$fila=pg_fetch_array($rs_sql,$i);
		$rut=$fila['rut_alumno'];
		
		$sql4="select * from titulacion where rut_alu=$rut";
		$resp4=pg_exec($conn,$sql4);
		$fila_titu=pg_fetch_array($resp4,0);
		
//------------------------------------------------------------------------------
?>
    
     
  </p>
</blockquote>
<table width="1000" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr class="tabla03">
    <td width="76"><div align="center">NOMBRE ALUMNO</div></td>
    <td colspan="2"><div align="center">DATOS PERSONALES</div></td>
    <td colspan="2"><div align="center">DATOS PR&Aacute;CTICA</div></td>
    <td colspan="4"><div align="center">EVALUACIONES</div></td>
    <td colspan="2"><div align="center">T&Iacute;TULO</div></td>
  </tr>
  <tr>
    <td rowspan="5" class="textonegrita"><div align="center"><?=$fila['nombre_alu']." ".$fila['ape_pat']." ".$fila['ape_mat']?></div></td>
    <td width="90" height="30" class="item"><div align="left">CURSO</div></td>
    <td width="95" class="subitem"><div align="center"><?=$fila['grado_curso']."-".$fila['letra_curso']?>&nbsp;</div></td>
    <td width="150" class="item"><div align="left">FECHA INICIO</div></td>
    <td width="85" class="subitem"><div align="center"><?impF($fila['fecha_ini'])?>&nbsp;</div></td>
    <td width="92" class="item"><div align="center">VARIABLE</div></td>
    <td width="48" class="item"><div align="center">NOTA</div></td>
    <td width="20" class="item"><div align="center">%</div></td>
    <td width="72" class="item"><div align="center">PUNTAJE</div></td>
    <td width="172" class="item"><div align="left">NUMERO</div></td>
    <td width="76" class="subitem"><div align="center"><?=$fila_titu['numero_titulo'];?>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="39" class="item"><div align="left">JORNADA</div></td>
    <td class="subitem"><div align="center"><?
								$jor = $fila['bool_jor'];
								switch ($jor){
								   case 1;
									  echo "MAÑANA";
								   break;	  
								   case 2;
									   echo "TARDE";
								   break;
								   case 3;
									   echo "MAÑANA Y TARDE";	   
								   break;
								   case 4;
									   echo "VESPERTINO";	   
								   break;
								   } ?>	&nbsp;</div></td>
    <td class="item"><div align="left">FECHA T&Eacute;RMINO</div></td>
    <td class="subitem"><div align="center"><?=$fila['fecha_ter']?>&nbsp;</div></td>
    <td class="item"><div align="left">NEM</div></td>
    <?
    
		$sql2="select avg(a.promedio) as promedio from promedio_alumno a ";
		$sql2.=" inner join curso b on (a.id_curso=b.id_curso) where a.rut_alumno=$rut and b.ensenanza>=310 ";
		$resp2=pg_exec($conn,$sql2);
		$promedio=pg_result($resp2,0);
		  	
		$id=$fila['id_practica'];
		$sql3="select calificacion from eval_practicas where id_practica=$id";
		$resp3=pg_exec($conn,$sql3);
		$promedio_prac=pg_result($resp3,0);
		  
		 	
	
	?>
    <td class="subitem"><div align="center"><?=round($promedio);?>&nbsp;</div></td>
    <td class="subitem"><div align="center">70</div></td>
    <td class="subitem"><div align="center"><?=$ponderacion=round($promedio * 0.7);?>&nbsp;</div></td>
    <td class="item"><div align="left">FECHA OTORGACI&Oacute;N<br> 
      N&Uacute;MERO</div></td>
    <td class="subitem"><div align="center"><?impF($fila_titu['fecha_entrega_titulo']) ;?>&nbsp;</div></td>
  </tr>
  <tr>
    <td height="25" class="item"><div align="left">RUT</div></td>
    <td class="subitem"><div align="center"><?=$fila['rut_alumno']."-".$fila['dig_rut']?>&nbsp;</div></td>
    <td class="item"><div align="left">CERTIFICADO NAC.</div></td>
    <td class="subitem"><div align="center">&nbsp;</div></td>
    <td class="item"><div align="left">PR&Aacute;CTICA</div></td>
    <td class="subitem"><div align="center"><?=round($promedio_prac);?>&nbsp;</div></td>
    <td class="subitem"><div align="center">30</div></td>
    <td class="subitem"><div align="center"><?=$ponderacion_prac=round($promedio_prac * 0.3);?>&nbsp;</div></td>
    <td class="item"><div align="left">FECHA ENV&Iacute;O</div></td>
    <td class="subitem"><div align="center"><?impF($fila_titu['fecha_envio_nomina']);?>&nbsp;</div></td>
  </tr>
  <tr>
    <td class="item"><div align="left">FECHA NAC.</div></td>
    <td class="subitem"><div align="center"><?impF($fila['fecha_nac'])

 ?>&nbsp;</div></td>
    <td class="item"><div align="left">CONCENTRACI&Oacute;N <br>
      NOTAS</div></td>
    <td class="subitem"><div align="center">&nbsp;</div></td>
    <td colspan="4" class="textonegrita">&nbsp;</td>
    <td colspan="2" class="textonegrita">&nbsp;</td>
  </tr>
  <tr>
    <td class="item"><div align="left">FONO</div></td>
    <td class="subitem"><div align="center"><?=$fila['telefono']?>&nbsp;</div></td>
    <td class="item"><div align="left">EVALUACI&Oacute;N</div></td>
    <td class="subitem"><div align="center">&nbsp;</div></td>
    <td class="item"><div align="left">NOTA FINAL</div></td>
    <td class="subitem"><div align="center" ><?=$nota_final=round($ponderacion_prac+$ponderacion);?>&nbsp;</div></td>
    <td colspan="2" class="textonegrita">&nbsp;</td>
    <td colspan="2" class="textonegrita">&nbsp;</td>
  </tr>
</table>
<? }?>
        
      <?
  	
  	//////////////////////////////////////////////////
	$FECHAC1= $lista['fecha_ini'];
	$AA1 = substr ("$FECHAC1;", 0, -7); 
	$mm1 = substr ("$FECHAC1;", 5, -4);
	$dd1 = substr ("$FECHAC1;", 8, -1);
	$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
	$dia1 = $dia11["mday"];
	if($dia1<10){
		$dia1 = "0".$dia1;
	}else{
		$dia1;
		}
	$mes1 = $dia11["mon"];
	if($mes1<10){
		$mes1 = "0".$mes1;
	}else{
		$mes1;
	}
	$fecha_mes1 = $dia1."-".$mes1;
	$FECHAC1 = $fecha_mes1."-".$dia11["year"];
	////////////////////////////////////////////////
  
  ?>
  

		
		
		      
        
  <?
 		
		
		
  	//////////////////////////////////////////////////
	$FECHAC1= $lista['fecha_entrega_titulo'];
	$AA1 = substr ("$FECHAC1;", 0, -7); 
	$mm1 = substr ("$FECHAC1;", 5, -4);
	$dd1 = substr ("$FECHAC1;", 8, -1);
	$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
	$dia1 = $dia11["mday"];
	if($dia1<10){
		$dia1 = "0".$dia1;
	}else{
		$dia1;
		}
	$mes1 = $dia11["mon"];
	if($mes1<10){
		$mes1 = "0".$mes1;
	}else{
		$mes1;
	}
	$fecha_mes1 = $dia1."-".$mes1;
	$FECHAC1 = $fecha_mes1."-".$dia11["year"];
	////////////////////////////////////////////////
  
  ?>
  
  

    <?
 
		
		
  	//////////////////////////////////////////////////
	$FECHAC1= $lista['fecha_ini'];
	$AA1 = substr ("$FECHAC1;", 0, -7); 
	$mm1 = substr ("$FECHAC1;", 5, -4);
	$dd1 = substr ("$FECHAC1;", 8, -1);
	$dia11 = getdate(mktime(0,0,0,$mm1,$dd1,$AA1));
	$dia1 = $dia11["mday"];
	if($dia1<10){
		$dia1 = "0".$dia1;
	}else{
		$dia1;
		}
	$mes1 = $dia11["mon"];
	if($mes1<10){
		$mes1 = "0".$mes1;
	}else{
		$mes1;
	}
	$fecha_mes1 = $dia1."-".$mes1;
	$FECHAC1 = $fecha_mes1."-".$dia11["year"];
	////////////////////////////////////////////////
  
  ?>
 

</form>
</body>
</html>
<? pg_close($conn);?>