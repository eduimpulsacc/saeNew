<?
require('../../../../util/header.inc');
include('../../../clases/class_Reporte.php');
include('../../../clases/class_Membrete.php');
  
//setlocale("LC_ALL","es_ES");


/*
function imprime_arreglo($arreglo){
echo "<pre>";
print_r($arreglo);
echo "</pre>";
}*/
	
$institucion	= $_INSTIT;
$ano			= $_ANO;
$curso			= $cmb_curso;
$reporte		= $c_reporte;
$fin_ano		= $finalp;

//echo $opcion;
	
	if($_PERFIL==0){
	//	echo "fin de año-->".$check_ano;
	}
	$_POSP = 4;
	$_bot = 8;
	$check_may = $_POST['check_may'];
	$conexper=$_POST['conexper'];
	if($conexper==1){
	 echo $tipo_examen=$conexper;
	/*}else{
		echo $fin_ano=$conexper;*/
	}
 /*if($_PERFIL==0){
	echo $institucion;
	echo "<br/>";
	echo $ano;			
	echo "<br/>";
	echo $curso;			
	echo "<br/>";
	echo $reporte;		
	echo "<br/>";
	echo $fin_ano;		
 }*/
		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	/***************** INSTITUCION *****************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
	
	/************* AÑO ESCOLAR ****************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->AnoEscolar($conn);
	$nro_ano = $ob_reporte->nro_ano;
	
	/********* CURSO *******************/
	$Curso_pal = CursoPalabra($curso, 0, $conn);
	
	/************* PROFE JEFE *************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);
	
	/************* SUBSECTOR ****************/
	$ob_reporte ->curso = $curso;
	$ob_reporte ->promocion=1;
	$ob_reporte ->modo_eval=1;
	$ob_reporte ->general=1;
	$ob_reporte ->SubsectorRamo2($conn);
	$result_sub = $ob_reporte ->result;
	$num_subsectores = @pg_numrows($result_sub);
	
	
	/******* ALUMNOS ************************/
	$ob_reporte ->ano =$ano;
	$ob_reporte ->curso = $curso;
	$ob_reporte ->orden = $orden;
	$ob_reporte ->finalp = $finalp;
	$ob_reporte ->retirado=0;
	if($finalp==1){
	$result_alu = $ob_reporte ->promFinalOrden($conn);}
	else{
		$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	}
	
	//echo $curso;
	//if (empty($curso)) //exit;
  
     if (($curso != 0) or ($curso != NULL)){	
	    $query_curso="select * from curso where id_curso='$curso'";
	    $row_curso=pg_fetch_array(pg_exec($conn,$query_curso));
		
		
	}
	
	
	
	
	if(!$cb_ok =="Buscar"){
		$Fecha= date("d-m-Y_h:i");
		header('Content-type: application/vnd.ms-excel');
		header("Content-Disposition:inline; filename=Informe_Notas_Finales_$Fecha.xls"); 
	}	

	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
		
		
		 
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
function exportar(){
			//form.target="_blank";
		window.location='printInformePlanillaNotasFinales_C.php?cmb_curso=<?=$curso?>&check_ano=<?=$fin_ano?>&c_reporte=<?=$c_reporte?>&opcion=<?=$opcion?>';
			//document.form.submit(true);
		return false;
}
function cerrar(){ 
window.close() 
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">

<!-- INICIO CUERPO DE LA PAGINA -->

<?

if (empty($curso)){
     //exit;
}else{
   ?>	 
   
   <table>
    <tr>
	  <td align="left">&nbsp;</td>
	</tr>
  </table>

<center>
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="650" border="0" cellspacing="0" cellpadding="0">
      <tr align="right">
        <td>
		<div id="capa0">
		<TABLE width="100%"><TR><TD><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR"></TD><TD  align="right">
          <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  </TD>
		 
		    <TD  align="right"><input name="button32" type="button" class="botonXX" onClick="javascript:exportar()"  value="EXPORTAR"></TD>
		
		</TR></TABLE>
        </div>
		</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>
	
	
	
	
	
<? if ($institucion=="770"){ 
	   // no muestro los datos de la institucion
	   // por que ellos tienen hojas pre-impresas
	   echo "<br><br><br><br><br><br><br><br><br><br><br>";
	   
  }else{

	?>	
<table width="650" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="487"><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><strong><? echo ucwords(strtoupper($ob_membrete->ins_pal));?></strong></font></td>
    <td width="11">&nbsp;</td>
    <td width="152" rowspan="4" align="center">
		<table width="125" border="0" cellpadding="0" cellspacing="0">
          <tr valign="top" >
            <td width="125" align="center">
		<?
		$result = @pg_Exec($conn,"select insignia, rdb from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## código para tomar la insignia

		  if($institucion!=""){
			  if($institucion==24783){
					  echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
					 }else{
					  echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
					 }
		  }else{
			   echo "<img src='".$d."menu/imag/logo.gif' >";
		  }?>
	  		</td>
		</tr>
    </table>
	</td>
  </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><? echo ucwords(strtolower($ob_membrete->direccion));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
            <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></font></td>
    <td>&nbsp;</td>
    </tr>
  <tr>
    <td height="41">&nbsp;</td>
    <td>&nbsp;</td>
    </tr>  
</table>

<? } ?>



<table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr>
    	<td class="tableindex"><div align="center">INFORME PROMEDIOS FINALES</div></td>
	</tr>
	<tr>
		<td><div align="center"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>AÑO <? echo $nro_ano?></strong> </font></div></td>
	</tr>
</table>
<br>
	<table width="650" border="0" cellspacing="0" cellpadding="0">

            <td width="120"><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Curso</strong></font></td>
        <td width="10"><div align="left"><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></div></td>
        <td width="526"><font size="1" face="arial, geneva, helvetica"><? echo $Curso_pal;?></font></td>
      </tr>
      <tr>
            <td><font size="1" face="Verdana, Arial, Helvetica, sans-serif"><strong>Profesor(a) 
              Jefe</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><strong>:</strong></font></td>
        <td><font size="1" face="arial, geneva, helvetica"><? echo $ob_reporte->tildeM($ob_reporte->profe_jefe);?></font></td>
      </tr>
    </table>
	<br>	<?php  if($finalp==1){?>
    <table width="650" border="1" cellpadding="0" cellspacing="0">
  <tr class="tablatit2-1">
    <td width="37">Nº</td>
	<td width="394">NOMBRE DEL ALUMNO</td>
   <td width="211" align="center">PROMEDIO FINAL</td>
    </tr>
    
   <?php  
   for($a=0;$a<pg_numrows($result_alu);$a++){
	  $fila_alu=pg_fetch_array($result_alu,$a);
	  
	 
		 $nombre_alu = $fila_alu['nombre_alumno'];
	$prom_final = $fila_alu['promedio'];
	
	  
	  ?>
  <tr>
    <td><font size="0" face="arial, geneva, helvetica"><?php echo ($a+1) ?></font></td>
    <td><font size="0" face="arial, geneva, helvetica"><?php echo $nombre_alu ?></font></td>
    <td align="center"><font size="0" face="arial, geneva, helvetica"><?php echo $prom_final ?></font></td>
  </tr>
  
   <?php } ?>
   
    
        </table><?php } 
		
		//tabla sin promocion
		else{
			
			$arr_notas = array();
			?>
            <table width="650" border="1" cellspacing="0" cellpadding="0">
  <tr class="tablatit2-1">
    <td width="37">Nº</td>
	<td width="394">NOMBRE DEL ALUMNO</td>
   <td width="211" align="center">PROMEDIO FINAL</td>
    </tr>
  
    <?	 
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$cod_subsector = $fila_sub['cod_subsector'];
		$modo_eval = $fila_sub['modo_eval'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		if($modo_eval==1) $contador_promedio++;
    ?>	
    
	<? }?>
          
            
          
           
    
    <?	 
	$numero_alumnos = @pg_numrows($result_alu);	 
	for($i=0 ; $i < @pg_numrows($result_alu) ;$i++)
	{
	  $fila_alu = @pg_fetch_array($result_alu,$i);
	  $nombre_alu = ucwords(strtolower(trim($fila_alu['ape_pat']) . " " . trim($fila_alu['ape_mat']) . " " . trim($fila_alu['nombre_alu'])));
	  $rut_alumno = $fila_alu['rut_alumno'];
	  ?>	

    
		<? 
	$promedio_general = 0;
	$cont_prom_general = 0;
	for($cont=0 ; $cont < $num_subsectores; $cont++)
	{
		$fila_sub = @pg_fetch_array($result_sub,$cont);	
		$subsector_curso = $fila_sub['nombre'];
		$id_ramo = $fila_sub['id_ramo'];
		$modo_eval = $fila_sub['modo_eval'];
		$cod_subsector = $fila_sub['cod_subsector'];
		$examen = $fila_sub['conex']; // 1 SI 2 NO
		$obliga = $fila_sub['sub_obli'];
		//---------------------------------------
		// Notas
		//-------------------------------------
		// Eximidos
		//-------------------------------------
		$sql_inscri = "select count(*) as cantidad ";
		$sql_inscri = $sql_inscri . "from   tiene$nro_ano ";
		$sql_inscri = $sql_inscri . "where rut_alumno = ".$rut_alumno."and id_ramo = ".$id_ramo." and id_curso = ".$curso;
		$result_inscri =@pg_Exec($conn,$sql_inscri);
		$fila_inscri= @pg_fetch_array($result_inscri,0);
		if (($fila_inscri['cantidad'] == 0)&&($obliga==1))
		{
			$promedio = "EX";
			$cont_prom=1;
		}
		else
		{
		//-----------------------------------
			if ($check_ano == 1)
			{
				/*$sql_notas = "SELECT situacion_final.nota_final ";
				$sql_notas = $sql_notas . "FROM situacion_final ";
				$sql_notas = $sql_notas . "WHERE (((situacion_final.rut_alumno)=".$rut_alumno.") AND ((situacion_final.id_ramo)=".$id_ramo.")); ";*/
				
				$sql_notas = "SELECT promedio FROM promedio_sub_alumno WHERE rut_alumno=".$rut_alumno." AND id_ramo=".$id_ramo;
				$result_notas =@pg_Exec($conn,$sql_notas);
				$promedio = 0;
				$cont_prom = 0;			
				if (@pg_numrows($result_notas)>0)
				{
					$fila_notas = @pg_fetch_array($result_notas,0);
					if ($modo_eval==1)
					{
						if ($fila_notas['promedio']>0)
						{
							$promedio = $fila_notas['promedio'];
							$cont_prom = 1;
						}
						else
						{
							$promedio = "&nbsp;";
						}
					}
					else
					{
						if (trim($fila_notas['promedio'])<>"0"){
							$promedio = $fila_notas['promedio'];
							$cont_prom = 0;
						}else{ $promedio = "&nbsp;";
						}
					}  
				}
				else
				{
					$promedio = "&nbsp;";
					$cont_prom = 0;
					$e = @pg_numrows($result_notas);
				}
		}
		else
		{
			$prom_se=0;
			$cont_se=0;
			$result_notas=0;
			
			$qsl="select * from ramo where id_ramo=".$id_ramo;
			$resultc =pg_Exec($conn,$qsl);
			$filac = pg_fetch_array($resultc,0);
			 $conexperiodo= $filac['conexper'];	
			// $coef2 = $filac['coef2'];
			if($tipo_examen==1 && $conexperiodo==1 ){
//				if($id_ramo==436182) echo  "no se`po";
			  $sql_notas ="SELECT nota_final as promedio,id_periodo FROM situacion_periodo WHERE rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo'";
			}else{
	//			if($id_ramo==436182) echo"algoXXX";
			$sql_notas = "select promedio,notaap,id_periodo from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo in (select id_ramo from tiene$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo')";
//						if($id_ramo==436182) echo $sql_notas;
			}

			$result_notas =@pg_Exec($conn,$sql_notas);
			for($cc=0 ; $cc < @pg_numrows($result_notas) ; $cc++)
			{
				$promedio_examen=0;
				$fila_notas = pg_fetch_array($result_notas,$cc);

				if ($modo_eval == 1)
				{
					if($tipo_eval==0){ // promedio aritmetico
						if ((trim($fila_notas['promedio'])>'0')&&(trim($fila_notas['promedio'])!='0'))
						{	//echo "<br> otra cosa que na que ver";
							//echo "<br> promedio ".$fila_notas['promedio'];
							
							//  NUEVO CODIGO DE EXAMEN SEMESTRAL
							$sql="SELECT max(cuenta) FROM (SELECT count(*) as cuenta FROM examen_semestral WHERE id_curso=".$curso." group by id_ramo) as contador";
							$rs_examen = @pg_exec($conn,$sql);
							$cuenta_examen = @pg_result($rs_examen,0);
							 $sql= "SELECT * FROM notas_examen WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." AND id_ano=".$ano." AND periodo=".$fila_notas['id_periodo']." AND rut_alumno=".$rut_alumno;
							$rs_nota = @pg_exec($conn,$sql);
							$nota_porc = 0;
							for($jj=0;$jj<$cuenta_examen;$jj++){
								$fils_nota = @pg_fetch_array($rs_nota,$jj);
								$nota_ex = $fils_nota['nota'];
								if(pg_numrows($rs_nota)==0){
									$nota_ex="&nbsp;";
								}
								 $sql = "SELECT porc,bool_ap FROM examen_semestral WHERE id_curso=".$curso." AND id_ramo=".$id_ramo." LIMIT (".$jj."+1) OFFSET ".$jj;
								$rs_porc = @pg_exec($conn,$sql);
								$porc = @pg_result($rs_porc,0);
								$aprox_ex = @pg_result($rs_porc,1);
								$nota_porc = $nota_porc + (($nota_ex * $porc)/100);
							}
							if($nota_porc==0){
								$promedio_examen = $fila_notas['promedio'];
							}else{
								if($row_curso['truncado_final']==1){
									$promedio_examen = round($nota_porc + (($fila_notas['promedio'] * $ob_reporte->porc_examen)/100));
								}else{
									$promedio_examen = intval($nota_porc + (($fila_notas['promedio'] * $ob_reporte->porc_examen)/100));
								}
								
							}
							
							// FIN EXAMEN SEMESTRAL
							//$prom_se = $prom_se + $fila_notas['promedio'];
							$prom_se = $prom_se + $promedio_examen;
							$cont_se = $cont_se + 1;
						}
					}elseif($tipo_eval==2){ // promedio de apreciacion
						if ((trim($fila_notas['notaap'])>'0')&&(trim($fila_notas['notaap'])!='0'))
						{	//echo "<br> otra cosa que na que ver";
							//echo "<br> promedio ".$fila_notas['promedio'];
							$prom_se = $prom_se + $fila_notas['notaap'];
							$cont_se = $cont_se + 1;
						}
					}
					
				}elseif($modo_eval==5){
						$sql = "select promedio from notas$nro_ano where rut_alumno = '$rut_alumno' and id_ramo in (select id_ramo from tiene$nro_ano where rut_alumno = '$rut_alumno' and id_ramo = '$id_ramo')";
						$result_eva = pg_Exec($conn,$sql);
						$prom_se = pg_result($result_eva,0);
				}
				//se supone que este es religion?;
				
				
				else{
					
					if ($tipo_eval==0){ // promedio aritmético
					
					
					    if ((trim($fila_notas['promedio'])!="0") and (trim($fila_notas['promedio'])!="")){
							
						   
						$prom_se = $prom_se + Conceptual($fila_notas['promedio'],2,$institucion,$ano,$conn);
						    $cont_se = $cont_se + 1;
					    }
					}
					if ($tipo_eval==2){	// promedio de apreciación
					    if ((trim($fila_notas['notaap'])!="0") and (trim($fila_notas['notaap'])!="")){
						    $prom_se = $prom_se + Conceptual($fila_notas['notaap'],2,$institucion,$ano,$conn);
						    $cont_se = $cont_se + 1;
					    }
					}	
					
				}
			}// fin for notas

			//if($_PERFIL==0) echo $prom_se."----".$cont_se;
			if ($modo_eval == 1){
			
			
				$sql = "SELECT nota_final FROM situacion_final WHERE id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno;
				$rs_final = @pg_exec($conn,$sql);
				if(@pg_numrows($rs_final)!=0){
					$prom_se = @pg_result($rs_final,0);
				}else{	
					if ($prom_se>0){
						if ($row_curso[truncado_per]==1){
							$prom_se = round($prom_se/$cont_se,0);
						}
						if ($row_curso[truncado_per]==0){
							$prom_se = floor($prom_se/$cont_se	);
						}
					}else
						$prom_se="&nbsp;";
				}
			}elseif($modo_eval==5){
			
			
			}else{
				if ($prom_se>0){
					
					$prom_se = round($prom_se/$cont_se,0);
					$prom_se  = Conceptual($prom_se,1,$institucion,$ano,$conn);
				}
				else
					$prom_se="&nbsp;";
			}
			
			$promedio = $prom_se;
		}
		//if($_PERFIL==0) echo "<BR>ppp-->".$promedio;
		//-----------------------------------
		}
		if ($promedio > 0 and $modo_eval == 1)
		
		{
		
	if (($id_ramo!=16080) and ($id_ramo!=16072) and ($id_ramo!=16064) and ($id_ramo!=16056))   {
			$promedio_general = $promedio_general + $promedio;
			$cont_prom_general = $cont_prom_general + 1;
			$cont_prom_fin = $cont_prom_fin + 1;
			$nota_media = $nota_media + $promedio;
			
		}}
		$notas_arr[$i][$cont] = $promedio;
    ?>	
   <?
	        //////// NUEVO CÓDIGO ESPECIAL PARA SAN VIATOR  ////////
		     if ($_INSTIT==769 and $cod_subsector==13){
		     ///////// nuevo código sacado del acta para calcular el promedio de RELIGION cuando modo de evaluacion es 3 //////////////
				 
				     $sql_notas_3 = "select nota1, nota2, nota3, nota4, nota5, nota6, nota7, nota8, nota9, nota10, nota11, nota12, nota13, nota14,nota15,nota16,nota17,nota18,nota19,nota20 from notas$nro_ano where rut_alumno = ".$rut_alumno." and id_ramo = '$id_ramo'";
					$rsNotas_3=@pg_Exec($conn,$sql_notas_3);				
					$con_notas = 0;
					$prom=0;
					$promedio_nota=0;
					for($g=0 ; $g < @pg_numrows($rsNotas_3) ; ++$g){
						$fNotas_3 = @pg_fetch_array($rsNotas_3,$g);
						if($fNotas_3['nota1']>0){
							$notas_1 = $fNotas_3['nota1'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_1;
						}
						if($fNotas_3['nota2']>0){
							$notas_2 = $fNotas_3['nota2'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_2;
						}
						if($fNotas_3['nota3']>0){
							$notas_3 = $fNotas_3['nota3'];	
							$con_notas=$con_notas+1;	
							$prom = $prom + $notas_3;
						}
						if($fNotas_3['nota4']>0){
							$notas_4 = $fNotas_3['nota4'];
								$con_notas=$con_notas+1;
							$prom = $prom + $notas_4;
						}
						if($fNotas_3['nota5']>0){
							$notas_5 = $fNotas_3['nota5'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_5;
						}
						if($fNotas_3['nota6']>0){
							$notas_6 = $fNotas_3['nota6'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_6;
						}
						if($fNotas_3['nota7']>0){
							$notas_7 = $fNotas_3['nota7'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_7;
						}
						if($fNotas_3['nota8']>0){
							$notas_8 = $fNotas_3['nota8'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_8;
						}
						if($fNotas_3['nota9']>0){
							$notas_9 = $fNotas_3['nota9'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_9;
						}
						if($fNotas_3['nota10']>0){
							$notas_10 = $fNotas_3['nota10'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_10;
						}
						if($fNotas_3['nota11']>0){
							$notas_11 = $fNotas_3['nota11'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_11;
						}
						if($fNotas_3['nota12']>0){
							$notas_12 = $fNotas_3['nota12'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_12;
						}
						if($fNotas_3['nota13']>0){
							$notas_13 = $fNotas_3['nota13'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_13;
						}
						if($fNotas_3['nota14']>0){
							$notas_14 = $fNotas_3['nota14'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_14;
						}
						if($fNotas_3['nota15']>0){
							$notas_15 = $fNotas_3['nota15'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_15;
						}
						if($fNotas_3['nota16']>0){
							$notas_16 = $fNotas_3['nota16'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_16;
						}
						if($fNotas_3['nota17']>0){
							$notas_17 = $fNotas_3['nota17'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_17;
						}
						if($fNotas_3['nota18']>0){
							$notas_18 = $fNotas_3['nota18'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_18;
						}
						if($fNotas_3['nota19']>0){
							$notas_19 = $fNotas_3['nota19'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_19;
						}
						if($fNotas_3['nota20']>0){
							$notas_20 = $fNotas_3['nota20'];
								$con_notas=$con_notas+1;	
							$prom = $prom + $notas_20;
						}						
					}		
						
					$promedio_ramo = @intval($prom / $con_notas);
					
					/////////////// como es modo de evaluacion 3 debo convertir el promedio a conceptual //////////////////
					if ($promedio_ramo > 0 and $promedio_ramo < 40){
						$promedio_nota = "I";
					}
					if ($promedio_ramo > 39 and $promedio_ramo < 50){
						$promedio_nota = "S";
					}
					if ($promedio_ramo > 49 and $promedio_ramo < 60){
						$promedio_nota = "B";
					}
					if ($promedio_ramo > 59 ){
						$promedio_nota = "MB";
					}
					////////////////////////////////////////////////////////////////////////
					$promedio = $promedio_nota;
		
		    }
	
			if($fin_ano==1){
				$sql = "SELECT promedio FROM promedio_sub_alumno WHERE id_ramo=".$id_ramo." AND rut_alumno=".$rut_alumno;
				$rs_promedio = @pg_exec($conn,$sql);
				$promedio = @pg_result($rs_promedio,0);
				
				/*if($_PERFIL==0){
					echo $sql;
				}*/
			}
			
			
			
			if($row_curso['ensenanza'] > 110){
			
			if($nota_nem==1){
					
					$sql_nem="SELECT x.nem FROM nota_nem as x 
                              WHERE x.nota_minima <= ".$promedio." and x.nota_maxima >= ".$promedio."";
					
					$result_nem = @pg_exec($conn,$sql_nem);
					$promedio = @pg_result($result_nem,0);
					
					
					}
			}
		
			if($promedio<40 && $promedio>0){ ?><?
				 if ($_INSTIT==9566 and $cod_subsector==13){
					if($promedio > 0){
						$promedio_conceptual = Conceptual($promedio,1,$institucion,$ano,$conn);
						//echo $promedio_conceptual;
					}else{
					//	echo $promedio;
					}
				}else{		
				   // echo $promedio;
				}	 ?>
      <? 
			
			}
			
			
			else{
				 if ($_INSTIT==9566 and $cod_subsector==13){
					if($promedio > 0){
						$promedio_conceptual = Conceptual($promedio,1,$institucion,$ano,$conn);
					//	echo $promedio_conceptual;
					}else{
					//	echo $promedio;
					}
				}else{		
				
				   // echo $promedio;
				}	
			} ?>
	<? }
	if ($promedio_general>0){ 
	    /*if ($row_curso[truncado_per]==1 and $_INSTIT!=770){
		
		    if (($_INSTIT==769) and ($row_curso[truncado_final]==0)){		
		          $promedio_general = intval($promedio_general/$cont_prom_general,0);
		    }else{
			      $promedio_general= round($promedio_general/$cont_prom_general,0);
			
			}
		} else { 	
			if($row_curso[truncado_final]==0){
			    $promedio_general= intval($promedio_general/$cont_prom_general);
			}else{
				$promedio_general= round($promedio_general/$cont_prom_general);
			}
		}*/
		if($row_curso['truncado_final']==0){
			$promedio_general= intval($promedio_general/$cont_prom_general);
		}else{
			$promedio_general= round($promedio_general/$cont_prom_general);
		}
		
  	} else {
		$promedio_general= "&nbsp;";
	}
	
	/*$arr_notas['nota'][]=$promedio_general;
	$arr_notas['rut'][]=$rut_alumno;
	$arr_notas['nom'][]=$nombre_alu;*/
	
	$arr_notas[]=array('nota'=>$promedio_general,'rut'=>$rut_alumno,'nombre'=>$nombre_alu);
	
	?>
   
	<? 
	//echo $promedio_general;
	if (empty($cadena02))
	{ 
		if ($promedio_general>0) 
		{
			$cadena02 = $promedio_general; 
			$prom_general_ind = $prom_general_ind + $promedio_general;
			$cont_general_ind = $cont_general_ind + 1;
		}
	}
	else
	{ 
		if ($promedio_general>0) 
		{
			$cadena02 = $cadena02 . ";" . $promedio_general;
			$prom_general_ind = $prom_general_ind + $promedio_general;
			$cont_general_ind = $cont_general_ind + 1;
		}
	}
	
	?>

    
    
    
  	<? } 
	
    foreach ($arr_notas as $key => $row) {
    $aux[$key] = $row['nota'];
}
array_multisort($aux, ($orden==1)?SORT_DESC:SORT_ASC, $arr_notas);

$o=0;
foreach ($arr_notas as $key => $row) {
	$o++;
	?>
   <tr><td><font size="0" face="arial, geneva, helvetica"><?php echo $o ?></font></td><td><font size="0" face="arial, geneva, helvetica"> <?php  echo strtoupper($row['nombre']) ?></font></td><td align="center"><font size="0" face="arial, geneva, helvetica"><?php echo $row['nota'] ?></font></td></tr>
   <? 
}
    ?>
	</table>
        <?php }?>
         
    </table>
        <?php }?>
</center>

</body>
</html>
<? @pg_close($conn);?>
