<?php

require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
include('../../../../clases/class_Membrete.php');
include('../../../../clases/class_Reporte.php');


//print_r($_POST);




	$_POSP = 4;
	$_bot = 8;
	
	 $institucion	= $_INSTIT;
	 $ano			= $select_anos;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$reporte		= $c_reporte;
	$subsector		=$select_asignatura;
	$curso			=$select_cursos;
	$nivel          =$select_niveles;
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();
	
	

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	$fecha=$ob_reporte->fecha_actual();

	$ob_membrete = new Membrete();
	
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
 // echo $sql_per="select * from  periodo where periodo.id_ano=".$select_anos;
		//$result_p =pg_Exec($conn,$sql_per);
		//$fila_p = pg_fetch_array($result_p,$sql_per);
		// $nombre_per=$fila_p['nombre_periodo'];
		
		
  /****************DATOS PERIODO************/
	
	$sql_nro_ano="select an.nro_ano from ano_escolar an where an.id_ano=".$ano;
			$result_a =pg_Exec($conn,$sql_nro_ano);
			$fila_nro_ano = pg_fetch_array($result_a,$sql_nro_ano);
			$nro_ano=$fila_nro_ano['nro_ano'];
			
	
	  $sql_periodo = "select * from periodo where id_ano = ".$ano . " order by id_periodo";
	$result_periodo = @pg_Exec($conn, $sql_periodo);
	$cadena = "";
	$habiles = 0;
	 $cantidad_periodos =  @pg_numrows($result_periodo);
	for($e=0 ; $e < @pg_numrows($result_periodo) ; $e++)
	{
		$fila_periodo = @pg_fetch_array($result_periodo,$e);
		if ($fila_periodo['dias_habiles']>0)
			$habiles = $habiles + $fila_periodo['dias_habiles'];
		if (trim($cadena)=="")
			$cadena = $fila_periodo['id_periodo'];
		else
			$cadena = $cadena . ";" . $fila_periodo['id_periodo'];
		
	}		
	
	
	
	
	/**************PROFESOR SUBSECTOR *********************/
	$ob_reporte ->ramo =$subsector;
	$ob_reporte ->ProfeSubsector($conn);
	
	$ob_reporte ->institucion =$institucion;
	$ob_reporte ->ano =$ano;
	$ob_reporte ->ramo =$subsector;
	$ob_reporte ->bool_ar=0;
	$ob_reporte ->curso=$curso;
	$ob_reporte ->nro_ano =$nro_ano;
	$ob_reporte ->orden =$ck_orden;
	$result_alu =$ob_reporte ->AlumnosSubsector($conn);
	//$result_alu = $ob_reporte ->FichaAlumnoTodos($conn);
	
		



	
 $sq_emp="select em.rut_emp,em.nombre_emp||' '|| em.ape_pat ||' '|| em.ape_mat as nombre_emp
			from supervisa su 
			inner join empleado em ON em.rut_emp=su.rut_emp
			where id_curso=".$curso;
			
			$rs_emp=pg_exec($conn,$sq_emp);
			$fila_emp=pg_fetch_array($rs_emp,$sq_emp);
			$nombre_emp=$fila_emp['nombre_emp'];			 
			 
			 
			  $sq_sub="select su.nombre from ramo ra 
						inner join subsector su on ra.cod_subsector=su.cod_subsector
						where ra.id_ramo=".$select_asignatura;
			
				$rs_sub=pg_exec($conn,$sq_sub);
				$fila_sub=pg_fetch_array($rs_sub,$sq_sub);
				$nombre_sub=$fila_sub['nombre'];	
				
				
				 $sq_sub_niv="SELECT DISTINCT su.nombre FROM ramo r
								inner join subsector su on r.cod_subsector=su.cod_subsector
								inner join curso cu on r.id_curso=cu.id_curso
								inner join niveles ni on cu.id_nivel=ni.id_nivel
								where ni.id_nivel=".$select_niveles." and r.cod_subsector=".$select_ramos_niveles;
											
				$rs_sub_niv=pg_exec($conn,$sq_sub_niv);
				$fila_sub_niv=pg_fetch_array($rs_sub_niv,$sq_sub_niv);
				$nombre_sub_niv=$fila_sub_niv['nombre'];
			 
			 
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>


<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
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
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function exportar(){
		//	window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
		  }		  
		  
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>
</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 
<!-- INICIO CUERPO DE LA PAGINA -->

<form name="form" method="post" action="print_promedios_insuficientes_curso.php" target="_blank">
<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
	<? }?>
      </td>
    </tr>
  </table>
</div>
<br>
<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
<tr>
		    <td width="487" class="item"><strong><? echo strtoupper(trim($ob_membrete->ins_pal));?></strong></td>
		    <td width="11">&nbsp;</td>
		    <td width="152" rowspan="4" align="center"><table width="125" border="0" cellpadding="0" cellspacing="0">
		      <tr valign="top" >
		        <td width="125" align="center"><?
		$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
		$arr=@pg_fetch_array($result,0);
		$fila_foto = @pg_fetch_array($result,0);
	    ## c&oacute;digo para tomar la insignia

	  if($institucion!=""){
		   echo "<img src='".$d."../tmp/".$fila_foto['rdb']."insignia". "' >";
	  }else{
		   echo "<img src='".$d."../menu/imag/logo.gif' >";
	  }?></td>
	          </tr>
		      </table></td>
	      </tr>
		  <tr>
		    <td class="item"><? echo ucwords(strtolower($ob_membrete->direccion));?></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td class="item">Fono:&nbsp;<? echo ucwords(strtolower($ob_membrete->telefono));?></td>
		    <td>&nbsp;</td>
	      </tr>
		  <tr>
		    <td height="41">&nbsp;</td>
		    <td>&nbsp;</td>
	      </tr>
  </table>
		<br>
  <table width="650" align="center">
	<tr><td class="tableindex" align="center"><div align="center">

<u>RESULTADOS DEL AÑO <?=$nro_ano?></u> </div>

</td></tr>
</table>
<br><br>


<br>
<?

	if($select_cursos==0){
?>

<table width="650" align="center">
<tr>
<td class="titulo">
<br>
<div  class="titulo">Asignatura :
<?=$nombre_sub_niv;?>
</div>
<br>
<div class="titulo">
<?
if($orden==0){
		
		$orden="Menor a";
		}else{
			$orden="Mayor a";
			}
?>
Nota&nbsp;<span> <?=$orden.' '.$txt_nota?></span>
</div>
</td>
</tr>
</table>
<br>
<?
	if($cantidad_periodos==2){
	
	$mom=$_POST['orden']; 
	if($mom !=0){
		$mom = ">";
		}else{
			$mom="<";
			}
	
	
		$ob_reporte ->subsector = $select_ramos_niveles;
		$ob_reporte ->curso=$curso;
		$ob_reporte ->nivel=$nivel;
		$ob_reporte ->orden=$mom;
		$ob_reporte ->nota=$txt_nota;
	  $result_niv1=$ob_reporte ->Promedio1Niv($conn);
	    $truncado_per = $ob_reporte->truncado;
		
?>
 <table width="600" align="center" border="1" cellspacing="0" cellpadding="0">
            <tr class="tablatit2-1"> 
              
              <td width="250"  class="item">Curso</td>
              <td width="160" colspan="" class="item"><div align="center">1ºSem</div></td>
              <td width="171" colspan="" class="item"><div align="center">2ºSem</div></td>
              <td width="59" class="item"><div align="center">P</div></td>
            </tr>
            
            
          <?
		   for($a=0 ; $a < @pg_numrows($result_niv1) ; $a++)
  {
	  $fila_niv = @pg_fetch_array($result_niv1,$a);
	  $cursosniv = $fila_niv['nom_curso'];
      $promedioniv1 = $fila_niv['promedio1'];
	  
	  
	  $result_niv2 = $ob_reporte ->Promedio1Niv2($conn);
		$fila_niv2 = @pg_fetch_array($result_niv2,0);
		$promedioniv2=$fila_niv2['promedio2'];
		  
		  
		  if($promedioniv2==0){
			 $promedioFinal1= $promedioniv1;
			 } 
			 
			 if($promedioniv1==0){
			 $promedioFinal1= $promedioniv2;
			 }
				
			if($promedioniv2!=0){
			$promedioFinal1=	round(($promedioniv1+$promedioniv2)/2);
			 } 	 
			
			
	?>
    <tr class="subitem">
    <td width="250" class="subitem"><?=$cursosniv?></td>
    <td class="subitem"><?=$promedioniv1?></td>
    <td class="subitem"><?=$promedioniv2?></td>
      <td class="subitem"><?=$promedioFinal1?></td>
    </tr>
    
    <?	  
		  
		  
		   }
		  
		  ?>  
        </table>    



<?
	}
?>

<?
	if($cantidad_periodos==3){
		
	$mom=$_POST['orden']; 
	if($mom !=0){
		$mom = ">";
		}else{
			$mom="<";
			}
		$ob_reporte ->subsector = $select_ramos_niveles;
		$ob_reporte ->curso=$curso;
		$ob_reporte ->nivel=$nivel;
		$ob_reporte ->orden=$mom;
		$ob_reporte ->nota=$txt_nota;
	  $result_niv1=$ob_reporte ->Promedio1Niv($conn);
	    $truncado_per = $ob_reporte->truncado;
		
?>
 <table width="600" align="center" border="1" cellspacing="0" cellpadding="0">
            <tr class="tablatit2-1"> 
              
              <td width="160"  class="item">Curso</td>
              <td width="96" colspan="" class="item"><div align="center">1ºTrim</div></td>
              <td width="131" colspan="" class="item"><div align="center">2ºTrim</div></td>
              <td width="131" colspan="" class="item"><div align="center">3ºTrim</div></td>
              <td width="70" class="item"><div align="center">P</div></td>
            </tr>
            
            
          <?
		   for($a=0 ; $a < @pg_numrows($result_niv1) ; $a++)
  {
	  $fila_niv = @pg_fetch_array($result_niv1,$a);
	  $cursosniv = $fila_niv['nom_curso'];
      $promedioniv1 = $fila_niv['promedio1'];
	  
	  
	  $result_niv2 = $ob_reporte ->Promedio1Niv2($conn);
		$fila_niv2 = @pg_fetch_array($result_niv2,0);
		$promedioniv2=$fila_niv2['promedio2'];
		
		
		 $result_niv3 = $ob_reporte ->Promedio1Niv3($conn);
		$fila_niv3 = @pg_fetch_array($result_niv3,0);
		$promedioniv3=$fila_niv3['promedio3'];
		  
		  if($promedioniv2==0){
			 $promedioFinal2= $promedioniv2;
			}else if
		  ($promedioniv3==0){
			$promedioFinal2 =	round(($promedioniv1+$promedioniv2)/2);
			}	else if
		  ($promedioniv2>0 && $promedioniv3>0){
			$promedioFinal2 = round(($promedioniv1+$promedioniv2)+($promedioniv3)/2);
			}
			
	?>
    <tr class="subitem">
    <td width="160" class="subitem"><?=$cursosniv?></td>
    <td class="subitem"><?=$promedioniv1?></td>
    <td class="subitem"><?=$promedioniv2?></td>
      <td class="subitem"><?=$promedioFinal2?></td>
    </tr>
    
    <?	  
		  
		  
		   }
		  
		  ?>  
            
            
            
            
        </table>    




<?
	}
?>	



<br>
<? }else{
	?>
<br>
<table width="650" align="center">
<tr>
<td class="titulo">
<div  class="titulo">Curso :
<? echo $Curso_pal = CursoPalabra($select_cursos, 1, $conn);?>
</div>
<br>
<div  class="titulo">Asignatura :
<?=$nombre_sub;?>
</div>

<br>


<div  class="titulo">Profesor :
<?=$nombre_emp?></div>
<br>
<div class="titulo">

<?
if($orden==0){
		
		$orden="Menor a";
		}else{
			$orden="Mayor a";
			}
?>
Nota&nbsp;<span> <?=$orden.' '.$txt_nota?></span>
</div>
</td>
</tr>
</table>
<br>

<?

 
    	if($cantidad_periodos==2){
			
			$mom=$_POST['orden']; 
	if($mom !=0){
		$mom = ">";
		}else{
			$mom="<";
			}
	?>
	
	      <table width="650" align="center" border="1" cellspacing="0" cellpadding="0">
            <tr class="tablatit2-1"> 
              <td width="47"  class="item">N</td>
              <td  class="item">Nombre del Alumno</td>
              <td colspan="" class="item"><div align="center">1ºSem</div></td>
              <td colspan="" class="item"><div align="center">2ºSem</div></td>
              <td class="item"><div align="center">P</div></td>
            </tr>
            <?
  for($e=0 ; $e < @pg_numrows($result_alu) ; $e++)
  {
	  $fila_alu = @pg_fetch_array($result_alu,$e);
	  $alumno = $fila_alu['rut_alumno'];
	
	  
		//$ob_reporte ->periodo = $periodo;
		$ob_reporte ->rut_alumno = $alumno;
		$ob_reporte ->ramo = $subsector;
		$ob_reporte ->orden=$mom;
		$ob_reporte ->nota=$txt_nota;
		$ob_reporte ->curso=$curso;
	    $ob_reporte ->Curso($conn);
	    $truncado_per = $ob_reporte->truncado;
		
		
		
		
		$result_p = $ob_reporte ->Promedio1($conn);
		$fila_p = @pg_fetch_array($result_p,0);
		$promedio=$fila_p['promedio'];
		
		 $result_p2 = $ob_reporte ->Promedio2($conn);
		$fila_p2 = @pg_fetch_array($result_p2,0);
		$promedio2=$fila_p2['notaapp'];
		 
	
		 
	/***************CON EXAMEN PERIODO PRIMER SEMESTRE*************************/					
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			$conexper = $fila_conexper['conexper'];
			if($conapreciacion==1){
				$promedio=$fila_p['notaapp'];
				}else{
			if($conexamenperiodo==1 && $conexper==1){
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			
			"final->".$promedio = $fila_conexper['nota_final'];
			}else{
			"Promedio->".$promedio 	= $fila_p['promedio'];
			}
				}
	/******************FIN CONEXAMEN PRIMER SEMESTRE********************/	
	
	/***************CON EXAMEN PERIODO SEGUNDO SEMESTRE*************************/					
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,$f);
		$conexper2 = $fila_conexper2['conexper'];
		if($conapreciacion==1){
				$promedio2=$fila_p2['notaapp'];
				}else{

		if($conexamenperiodo==1 && $conexper2==1){
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,0);
		
		  "final->".$promedio2 = $fila_conexper2['nota_final'];
		}else{
		 "Promedio->".$promedio2 = $fila_p2['promedio'];
		}}
	/******************FIN CONEXAMEN********************/
		$algo=substr($subsector_pal,0,8);	
		if($algo=="RELIGION"){
			if (trim($promedio) == "MB")

			$prom = 65;
			$tipo=1;
		if (trim($promedio) == "B")

			$prom = 55;			
			$tipo=1;
		if (trim($promedio) == "S")

			$prom = 45;
			$tipo=1;
		if (trim($promedio) == "I")

			$prom = 35;						
			$tipo=1;
		 $prom;

  if (trim($promedio2) == "MB")

			$prom2 = 65;
			$tipo=1;
		if (trim($promedio2) == "B")

			$prom2 = 55;			
			$tipo=1;
		if (trim($promedio2) == "S")

			$prom2 = 45;
			$tipo=1;
		if (trim($promedio2) == "I")

			$prom2 = 35;						
			$tipo=1;
		 $prom2;
		
			
		 $promedio_promed= round(($prom+$prom2) / 2);	
		
		if ($promedio_promed >= 60 and $promedio_promed<=70)

			 $concepto = "MB";

		if ($promedio_promed >= 50 and $promedio_promed<=59)

			$concepto = "B";

		if ($promedio_promed >= 40 and $promedio_promed<=49)

			$concepto = "S";

		if ($promedio_promed >= 0 and $promedio_promed<=39)

			$concepto = "I";
		
		if($promedio_promed==0)
		
			$concepto = "-";
					 
					 
					 
		 $promedio_promedio = $concepto;	 
					 
		}else{
		
		
	
	
	 
		if($conexamen==1){
		$result_promedio_sub= $ob_reporte ->PromedioSubAlumnos($conn);
		$fila_sub=pg_fetch_array($result_promedio_sub,0);
			if(pg_numrows($result_promedio_sub)==0){
				
				echo $promedio_promedio=0;
			}else{
				$promedio_promedio=$fila_sub['promedio'];
			}
		}else{		
		
		  if($truncado_per==1){
	  	 	$promedio_promedio= round(($promedio+$promedio2) / 2);
		  }else{
			  
		  	$promedio_promedio= intval(($promedio+$promedio2) / 2);
		  }
		}
		}
		
		
		
  ?>
      <tr> 
              <td height="17" class="subitem"><div align="center"><? echo $e+1?></div></td>
              <td width="279" class="subitem"><div align="left"><?=$ob_reporte->tilde($fila_alu['nombres']);?></div></td>
              <td width="133" align="center" class="subitem"> <div align="center"><? 
			    
			if ($promedio>0&&$promedio<40){
				?><font color="#FF0000"><? 
				echo $promedio;
				?> </font>	<?		
				}else{echo $promedio;}
			?></div>
              </td>
              <td width="123" align="center" class="textosimple"> <div align="center">
              <? 
			if ($promedio2>0&&$promedio2<40){
				?><font color="#FF0000"><? 
				echo $promedio2;
				?> </font>	<?		
				}else{echo $promedio2;}
			?>
              </div></td>
            
         
              <td width="56" align="center" class="textosimple"> <div align="center">
			  <? 
			  
			  if(!isset($promedio2)){
				  $promedio_promedio=$promedio;
				  }
			  if(!isset($promedio)){
				  
				  $promedio_promedio=$promedio2;
				  }	  
			  
			  
			if ($promedio_promedio>0&&$promedio_promedio<40){
				?><font color="#FF0000"><? 
				echo $promedio_promedio;
				?> </font>	<?		
				}else{
			echo	$promedio_promedio;
				}
				
				
				
			?>
			  </div>
		</tr>
            <? 
			
		
  
	$cadena01 = $cadena01 . ";" . $promedio;
	$cadena02 = $cadena02 . ";" . $promedio2;
    $cadenaprom = $cadenaprom . ";" . $promedio_promedio;
		
  
	}	?>
		  </table>			

	<? 	}?>
			<br><br><br>	
  </tr>
</table>
<?



    	if($cantidad_periodos==3){

	?>
	      <table width="650" align="center" border="1" cellspacing="0" cellpadding="0">
            <tr class="tablatit2-1"> 
              <td width="47"  class="subitem">N</td>
              <td class="item">Nombre del Alumno</td>
              <td class="item"><div align="center">1ºTrim</div></td>
              <td class="item"><div align="center">2ºTrim</div></td>
              <td class="item"><div align="center">3ºTrim</div></td>
              <td class="item"><div align="center">P</div></td>
            </tr>
            <?
  for($e=0 ; $e < @pg_numrows($result_alu) ; $e++)
  {
	  $fila_alu = @pg_fetch_array($result_alu,$e);
	  $alumno = $fila_alu['rut_alumno'];
	
	  
		//$ob_reporte ->periodo = $periodo;
		$ob_reporte ->rut_alumno = $alumno;
		$ob_reporte ->ramo = $subsector;
		$ob_reporte ->curso=$curso;
	    $ob_reporte ->Curso($conn);
	    $truncado_per = $ob_reporte->truncado;
		
		
		$result_p = $ob_reporte ->Promedio1($conn);
		$fila_p = @pg_fetch_array($result_p,0);
		 //echo "Promedio-->".$promedio=$fila_p['promedio'];
		 
		 $result_p2 = $ob_reporte ->Promedio2($conn);
		$fila_p2 = @pg_fetch_array($result_p2,0);
		//echo "Apreciacion-->".$promedio2=$fila_p2['notaapp'];
		 
		 $result_p3 = $ob_reporte ->Promedio3($conn);
		$fila_p3 = @pg_fetch_array($result_p3,0);
		//echo "Apreciacion-->".$promedio2=$fila_p2['notaapp'];
		 
	/***************CON EXAMEN PERIODO PRIMER*************************/					
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			$conexper = $fila_conexper['conexper'];
			if($conapreciacion==1){
				$promedio=$fila_p['notaapp'];
				}else{
			if($conexamenperiodo==1 && $conexper==1){
			$result_conexamen =$ob_reporte->NotaExamen_periodo1($conn);
			$fila_conexper = @pg_fetch_array($result_conexamen,0);
			
			"final->".$promedio = $fila_conexper['nota_final'];
			}else{
			"Promedio->".$promedio 	= $fila_p['promedio'];
			}
				}
	/******************FIN CONEXAMEN PRIMER ********************/	
	
	/***************CON EXAMEN PERIODO SEGUNDO *************************/					
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,0);
		$conexper2 = $fila_conexper2['conexper'];
		if($conapreciacion==1){
				$promedio2=$fila_p2['notaapp'];
				}else{

		if($conexamenperiodo==1 && $conexper2==1){
		$result_conexamen2 =$ob_reporte->NotaExamen_periodo2($conn);
		$fila_conexper2 = @pg_fetch_array($result_conexamen2,0);
		
		  "final->".$promedio2 = $fila_conexper2['nota_final'];
		}else{
		 "Promedio->".$promedio2 	= $fila_p2['promedio'];
		}}
	/******************FIN CONEXAMEN********************/
	
	/***************CON EXAMEN PERIODO TERCER *************************/					
		$result_conexamen3 =$ob_reporte->NotaExamen_periodo3($conn);
		$fila_conexper3 = @pg_fetch_array($result_conexamen3,0);
		$conexper3 = $fila_conexper3['conexper'];
		if($conapreciacion==1){
				$promedio3=$fila_p3['notaapp'];
				}else{

		if($conexamenperiodo==1 && $conexper2==1){
		$result_conexamen3 =$ob_reporte->NotaExamen_periodo3($conn);
		$fila_conexper3 = @pg_fetch_array($result_conexamen3,0);
		
		  "final->".$promedio3 = $fila_conexper3['nota_final'];
		}else{
		 "Promedio->".$promedio3 	= $fila_p3['promedio'];
		}}
	/******************FIN CONEXAMEN********************/
		
		 if($conexamen==1){
		$result_promedio_sub= $ob_reporte ->PromedioSubAlumnos($conn);
		$fila_sub=pg_fetch_array($result_promedio_sub,0);
			if(pg_numrows($result_promedio_sub)==0){
				echo $promedio_promedio=0;
			}else{
				$promedio_promedio=$fila_sub['promedio'];
			}
		}else{		
		  if($truncado_per==1){
	  	 	$promedio_promedio= round(($promedio+$promedio2) / 2);
		  }else{
		  	$promedio_promedio= intval(($promedio+$promedio2) / 2);
		  }
		}
   	
  ?>
      <tr> 
              <td height="17" class="subitem"><div align="center"><? echo $e+1?></div></td>
              <td width="279" class="subitem"><div align="left"><?=$ob_reporte->tilde($fila_alu['nombres']);?></div></td>
              <td width="133" align="center" class="subitem"> <div align="center">
			   <? 
			if ($promedio>0&&$promedio<40){
				?><font color="#FF0000"><? 
				echo $promedio;
				?> </font>	<?		
				}else{echo $promedio;}
			?>
			  
			  </div></td>
              <td width="123" align="center" class="textosimple"> <div align="center">
               <? 
			if ($promedio2>0&&$promedio2<40){
				?><font color="#FF0000"><? 
				echo $promedio2;
				?> </font>	<?		
				}else{echo $promedio2;}
			?>
              </div></td>
              <td width="123" align="center" class="textosimple"> <div align="center">
               <? 
			if ($promedio3>0&&$promedio3<40){
				?><font color="#FF0000"><? 
				echo $promedio3;
				?> </font>	<?		
				}else{echo $promedio3;}
			?>
              </div></td>
            
         
              <td width="56" align="center" class="textosimple"> <div align="center">
			   <? 
			if ($promedio_promedio>0&&$promedio_promedio<40){
				?><font color="#FF0000"><? 
				echo $promedio_promedio;
				?> </font>	<?		
				}else{echo $promedio_promedio;}
			?>
			  </div>
		</tr>
            <? 
			
		
  
	$cadena01 = $cadena01 . ";" . $promedio;
	$cadena02 = $cadena02 . ";" . $promedio2;
	$cadena02 = $cadena02 . ";" . $promedio3;
    $cadenaprom = $cadenaprom . ";" . $promedio_promedio;


  }
  ?>
		
		  </table>			
			
			<br><br><br>	
	      
	</td>
  </tr>
</table>

<? }




}
	 ?>

<br><br>



<table width="650" border="0" align="center">
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
<table width="75%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<br>
<div style="margin-left:65%" class="subitem"><?=$fecha;?></div>
</form>
	<?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	?>
   
</body>
</html>
<? pg_close($conn);?>