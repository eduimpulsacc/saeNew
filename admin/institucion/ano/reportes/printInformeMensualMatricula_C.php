<?php
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
//echo "pase x aqui1<br>";
	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $cmb_curso;
	$reporte		= $c_reporte;
	$docente		= 5; //Codigo Docente
	$mes			= $cmb_mes;

		$fecha1 		= $anoN."-04-30"; 

	switch ($cmb_mes)
{

	case 3:
	$fin_dia=31;
	$nom_mes="MARZO";
	$mes_ant="03";
	$dia_ant=31;
	break;
	
	case 4:
	$fin_dia=30;
	$nom_mes="ABRIL";
	$mes_ant="03";
	$dia_ant=31;
	break;
	
	case 5:
	$fin_dia=31;
	$nom_mes="MAYO";
	$mes_ant="04";
	$dia_ant=30;
	break;
	
	case 6:
	$fin_dia=30;
	$nom_mes="JUNIO";
	$mes_ant="05";
	$dia_ant=31;
	break;
	
	case 7:
	$fin_dia=31;
	$nom_mes="JULIO";
	$mes_ant="06";
	$dia_ant=30;
	break;
	
	case 8:
	$fin_dia=31;
	$nom_mes="AGOSTO";
	$mes_ant="07";
	$dia_ant=31;
	break;
	
	case 9:
	$fin_dia=30;
	$nom_mes="SEPTIEMBRE";
	$mes_ant="08";
	$dia_ant=31;
	break;
	
	case 10:
	$fin_dia=31;
	$nom_mes="OCTUBRE";
	$mes_ant="09";
	$dia_ant=30;
	break;
	
	case 11:
	$fin_dia=30;
	$nom_mes="NOVIEMBRE";
	$mes_ant=10;
	$dia_ant=31;
	break;
	
	case 12:
	$fin_dia=31;
	$nom_mes="DICIEMBRE";
	$mes_ant=11;
	$dia_ant=30;
	break;


}
	
	$ob_reporte = new Reporte();
	$ob_reporte -> ano = $ano;
//echo "pase x aqui2<br>";	
	$ob_reporte -> institucion = $institucion;
	$ob_reporte -> AnoEscolar($conn);
	//echo "pase x aqui3<br>";
	$ob_membrete = new Membrete();
	$ob_membrete -> ano = $ano;
	$ob_membrete -> institucion = $institucion;
	$ob_membrete -> institucion($conn);
	
//	echo "pase x aqui4<br>";
   	
	$ob_reporte ->orden = $orden;
	$total_filas= @pg_numrows($resultado_query);
 //echo "pase x aqui5<br>";
 //-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	//echo "pase x aqui6<br>";
	$resultado_query= $ob_reporte ->NomCurso($conn);
	$total_filas= @pg_numrows($resultado_query);

	//echo "pase x aqui7<br>";
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
</head>

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
 .txt_tabla {
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
}
 .txt_nro{
 font-family: Verdana, Geneva, Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight:normal;
}
.Estilo3 {font-size: 10}
</style>
<body>
<table width="1024" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<div id="capa0">
		<div align="right"> <font face="Arial, Helvetica, sans-serif" size="-1">Imprimir Horizontal</font>
		  <input name="button3" TYPE="button" class="botonXX" onClick="imprimir()" value="IMPRIMIR">	
  		</div>
	</div>
	</div>	</td>
  </tr>
  <tr>
    <td>
	
	
	
	
      <table width="85%" height="132" border="0" >
        <tr>
          <td width="184" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ESTABLECIMIENTO EDUCACIONAL </strong></font></td>
          <td width="346" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;
            <?=$ob_membrete->ins_pal; ?>
          </font></td>
          <td width="53" align="left">&nbsp;</td>
          <td width="103" align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>REGION</strong></font></td>
          <td width="316" align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->region;?></font></td>
        </tr>
        <tr>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>ROL BASE 
          DE DATOS</strong></font></div></td>
          <td> <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;</font><font face="Arial, Helvetica, sans-serif" size="1"><? echo $institucion." - ".$ob_membrete->dig_rdb;?></font></div></td>
          <td align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>PROVINCIA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->provincia;?></font></div></td>
        </tr>
        <tr>
          <td ><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>A&Ntilde;O ESCOLAR </strong></font></div></td>
          <td ><div align="left"> <font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;</font><font face="Arial, Helvetica, sans-serif" size="1">
            <?=$ob_reporte->nro_ano; ?>
          </font></div></td>
		            <td align="left">&nbsp;</td>
          <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>COMUNA</strong></font></div></td>
          <td>
            <div align="left"><font face="Arial, Helvetica, sans-serif" size="1">:&nbsp;<?=$ob_membrete->comuna;?></font></div></td>
        </tr>
        <tr>
            <td><font face="Arial, Helvetica, sans-serif" size="1"><strong>MES</strong></font></td>
            <td><div align="left"><font face="Arial, Helvetica, sans-serif" size="1"><strong>:&nbsp;<?php echo $nom_mes ?></strong></font></div></td>
		            <td align="left">&nbsp;</td>
          <td><div align="left"></div></td>
          <td class="Estilo13 Estilo17"><div align="left"></div></td>
        </tr>
        <tr>
          <td height="16" colspan="5" align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>MATR&Iacute;CULA ALUMNOS DURANTE EL MES </strong></font></td>
        </tr>
      </table>
    </td>
  </tr>
</table> 

<?php 


$sw=0;
$tot_ens_mes=0;
$tot_mes_ant=0;
$tot_alt=0;
$tot_bajas=0;
$tot_ens_mes2=0;
for ($i=0;$i<$total_filas;$i++)
  {
  	$fila = pg_fetch_array($resultado_query,$i);
	$filaxxx = pg_fetch_array($resultado_query,$i+1);
	$ob_reporte->grado_c=$fila['grado_curso'];
	$ob_reporte->letra_c=$fila['letra_curso'];
	$ob_reporte->ensenanza=$fila['ensenanza'];
	$ob_reporte->idcurso=$fila['id_curso'];
	$ob_reporte->ensenanza2=$filaxxx['ensenanza'];
	
	$ensenanza=$fila['ensenanza'];
	$ensenanza2=$filaxxx['ensenanza'];	
	
	
  ?>
<table  border="1" cellpadding="0" cellspacing="0" class="txt_tabla">
  <?php if ($i==0)
{?>
  <tr>
    <td width="142" height="28"  bgcolor="#999999"><span class="Estilo3">CURSO</span></td>
    <td width="142"  bgcolor="#999999"><div align="center">Matr&iacute;cula Mes </div></td>
    <td width="142"  bgcolor="#999999"><div align="center">Matr&iacute;cula Mes Anterior </div></td>
    <td width="142"  bgcolor="#999999"><div align="center">Altas</div></td>
    <td width="142"  bgcolor="#999999"><div align="center">Bajas</div></td>
    <td width="142"  bgcolor="#999999"><div align="center">Total Actual </div></td>
  </tr>
  
  <?php }?>
  <?php $sql_tipo="select * from tipo_ensenanza where cod_tipo=".$ob_reporte->ensenanza;
   $res_tip=pg_exec($conn,$sql_tipo);
   $fila0 = @pg_fetch_array($res_tip,0);
   if($i==0){
   		$cod_tipo = $fila0['cod_tipo'];
   }else{
		if($cod_tipo!=$fila0['cod_tipo']){
			$tot_ens_mes=0;
			$cod_tipo = $fila0['cod_tipo'];
		}   
   }
   ?>
  <tr>
    <td width="142" class="txt_nro Estilo3" ><? echo $ob_reporte->grado_c; ?> - <?php echo $ob_reporte->letra_c ?>
        <?php 
   // busco tipo enseñanza
  
   
  
   ?>
        <?php echo trim($fila0['nombre_tipo']); ?> </td>
    <td width="142" class="txt_nro Estilo3" > 
    <div align="center"><?php  /*echo $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso) and fecha<='$ob_reporte->nro_ano-$cmb_mes-$fin_dia' and ID_CURSO>0 ) and rut_alumno not in (select rut_alumno from matricula where id_curso = ($ob_reporte->idcurso) and fecha_retiro <= '$ob_reporte->nro_ano-$cmb_mes-$fin_dia' ) ";*/
	
	 $qry2="SELECT count(*)-(select count (rut_alumno) from matricula 
where id_curso = ($ob_reporte->idcurso) 
 and fecha_retiro <= ('$ob_reporte->nro_ano-$cmb_mes-$fin_dia'))  as SUMA2 FROM MATRICULA WHERE ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso)  
and fecha between '$ob_reporte->nro_ano-$cmb_mes-$fin_dia' and '$ob_reporte->nro_ano-$cmb_mes-01' 
 ";
 //if($_PERFIL==0) echo "SQL-->".$qry2."<br>";

											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
																									
													echo $totalmes = $fila2['suma2'];
													$tot_ens_mes=$tot_ens_mes+$totalmes;
													
												}
											} ?>      </div></td>
    <td width="142" class="txt_nro Estilo3" ><div align="center"><?php  $qry2="SELECT COUNT(*) - (select count(*) from matricula where id_curso = ($ob_reporte->idcurso) and fecha_retiro <= '$ob_reporte->nro_ano-$mes_ant-$dia_ant' ) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso) and fecha<='$ob_reporte->nro_ano-$mes_ant-$dia_ant' and ID_CURSO>0 ) ";
//	if($_PERFIL==0) echo $qry2."<br>";
	//$qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso) and fecha<='$ob_reporte->nro_ano-$mes_ant-$dia_ant' and ID_CURSO>0 and bool_ar = '0') ";
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila2['suma2']);
													if ($cmb_mes==3)
													echo "0";
													else
													echo $totalmesant = $fila2['suma2'];
													
													$tot_mes_ant=$tot_mes_ant+$totalmesant;
													
												}
											} ?></div></td>
    <td width="142" class="txt_nro Estilo3" ><div align="center"><?php  $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso) and fecha between '$ob_reporte->nro_ano-$cmb_mes-01' and '$ob_reporte->nro_ano-$cmb_mes-$fin_dia' and ID_CURSO>0)  ";
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila2['suma2']);
													echo $altas = $fila2['suma2'];
													
													$tot_alt=$tot_alt+$altas;
													
												}
											} ?></div></td>
    <td width="142" class="txt_nro Estilo3" ><div align="center"><?php   $qry2="SELECT COUNT(*) AS SUMA2 FROM MATRICULA  WHERE (MATRICULA.ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso) and fecha_retiro between'$ob_reporte->nro_ano-$cmb_mes-01' and '$ob_reporte->nro_ano-$cmb_mes-$fin_dia' and ID_CURSO>0)";
	
//										if($_PERFIL==0) echo "SQL-->".$ob_reporte->idcurso."<br>";
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
													//echo trim($fila2['suma2']);
													echo $bajas = $fila2['suma2'];
													
													$tot_bajas=$tot_bajas+$bajas;
													
												}
											} ?></div></td>
    <td width="142" class="txt_nro Estilo3" ><div align="center"><?php   $qry2="SELECT COUNT(*) - (select count(*) from matricula where id_curso = ($ob_reporte->idcurso) and fecha_retiro <= '$ob_reporte->nro_ano-$cmb_mes-$fin_dia' ) AS SUMA2 FROM MATRICULA WHERE (ID_ANO=($ano) AND ID_CURSO=($ob_reporte->idcurso) and fecha<='$ob_reporte->nro_ano-$cmb_mes-$fin_dia' and ID_CURSO>0 ) ";
	//if($_PERFIL==0) echo $qry2;
											$result2 =@pg_Exec($conn,$qry2);
											if (!$result2) {
												//error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>');
												//echo "qry2=$qry2<br>";
											}else{
												if (pg_numrows($result2)!=0){
													$fila2 = @pg_fetch_array($result2,0);	
													if (!$fila2){
														error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
														exit();
													}
																									
													echo $totalmes2 = $fila2['suma2'];
													$tot_ens_mes2=$tot_ens_mes2+$totalmes2;
													
												}
											} ?></div></td>
    <?php
	
	for ($j=0;$j<=12;$j++)
	{
		
		if ($j>2)
		{
	?>
    <?php }
	}
	?>
  </tr>
  
  <?  
  
  $filaxxx = pg_fetch_array($resultado_query,$i+1);
  $ensenanza=$fila['ensenanza'];
  $ensenanza2=$filaxxx['ensenanza']; 
   
  if($ensenanza!=$ensenanza2){ 
       $sw=1;
  }    
  
  if ($sw==1){ ?>
  <tr>
    <td width="142"  bgcolor="#999999" class="txt_nro Estilo3" >Subtotal <?php echo trim($fila0['nombre_tipo']); ?></td>
    <td width="142"  bgcolor="#999999" class="txt_nro Estilo3" ><div align="center"><?php echo $tot_ens_mes;
	
	$m_mes=$m_mes+$tot_ens_mes;
	 ?></div>
    </td>
    <td width="142"  bgcolor="#999999" class="txt_nro Estilo3" ><div align="center"><?php echo $tot_mes_ant;
	
	$m_mes_ant=$m_mes_ant+$tot_mes_ant;
	 ?></div></td>
    <td width="142"  bgcolor="#999999" class="txt_nro Estilo3" ><div align="center"><?php echo $tot_alt;
	$t_altas=$t_altas+$tot_alt;
	 ?></div></td>
    <td width="142"  bgcolor="#999999" class="txt_nro Estilo3" ><div align="center"><?php echo $tot_bajas;
	$t_bajas=$t_bajas+$tot_bajas;
	 ?></div></td>
    <td width="142"  bgcolor="#999999" class="txt_nro Estilo3" ><div align="center"><?php echo $tot_ens_mes2;
	$t_mes2=$t_mes2+$tot_ens_mes2;
	 ?></div></td>
  </tr>
  <?
  if($ensenanza!=$ensenanza2){ 
       $tot_alt=0;
	   $tot_bajas=0;
	   $tot_ens_mes2=0;
	   $tot_mes_ant=0;
  }  
	 $sw=0;
  }    
   
  
   
}

?>
  <tr>
    <td width="142" height="20" bgcolor="#999999"><span class="Estilo3">TOTAL</span></td>
    <td width="142" bgcolor="#999999"><div align="center"><?php echo $m_mes ?></div></td>
    <td width="142" bgcolor="#999999"><div align="center"><?php echo $m_mes_ant ?></div></td>
    <td width="142" bgcolor="#999999"><div align="center"><?php echo $t_altas ?></div></td>
    <td width="142" bgcolor="#999999"><div align="center"><?php echo $t_bajas ?></div></td>
    <td width="142" bgcolor="#999999"><div align="center"><?php echo $t_mes2 ?></div></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>