<?php
	
require_once('../reporte_subvencion/mod_reporte_subvencion.php');
require('../../../../util/header.inc');
include_once("funciones_php/FusionCharts.php");

$id_nacional=	$_ID_NACIONAL;
$nro_ano = $cmb_anos; 
$mes	 = $cmb_mes;
$tipo_instit=1;
//print_r($_POST);
	


$obj_motor = new Motor($conn); 
			   
	?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Subvencion Estimada</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}


function imprimir() {
        document.getElementById("capa0").style.display='none';
        window.print();
        document.getElementById("capa0").style.display='block';
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



</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../../cortes/b_ayuda_r.jpg','../../../../../../cortes/b_info_r.jpg','../../../../../../cortes/b_mapa_r.jpg','../../../../../../cortes/b_home_r.jpg')">

<div id="capa0">
  <table width="650" align="center" >
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

<BR>
  <BR>
<table width="650"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
				 <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr align="center">
    <td><img src='../../img/logo cmvm.JPG' width="167" height="104" ></td>
    <td>
    <img src='../../img/logo_colegiointeractivo.jpg' width="194" height="104" >
    
    </tr>
                  
				</table>
                <br>
               
           <?
		//echo $sql;
 	 
    $strXML = "";
	$strXML .= "<graph caption='Gr&aacute;fico Subvenci&oacute;n Estimada' xAxisName='Instituci&oacute;n' yAxisName='totales' decimalPrecision='0' formatNumberScale='0'>";


       $result_ = $obj_motor->busca_institucion($id_nacional);
	   $contador = pg_numrows($result_);
		
		
		$limit=round($contador/2);
				
		$result_i = $obj_motor->busca_institucion_graf_es($id_nacional,$limit);		
				
		for($j=0;$j<pg_numrows($result_i);$j++){
			
			
			
			$monto_total1=0;
			$monto_total2=0;
			$monto_total3=0;
			$monto_total4=0;
						
			
			$fila_instit=pg_fetch_array($result_i,$j);
			$rdb = $fila_instit['rdb'];
			$nom_instit=$fila_instit['nombre_instit'];
		   


$rs_ano=$obj_motor->ano_academico($rdb,$nro_ano);
$id_ano=(pg_result($rs_ano,0));

if($mes==3){
	$dias_restarMarzo=$obj_motor->habilesdiciembre($cmb_mes,$id_ano);
	$dias_restarMarzo=pg_result($dias_restarMarzo,0);
	// "<br>"." Dias restarMarzo-->".$dias_restarMarzo;
	}

if($mes==12){
	$dias_habilesMes=$obj_motor->habilesdiciembre($cmb_mes,$id_ano);
	$dias_habilesMes=pg_result($dias_habilesMes,0);
	 "<br>"."Dias Habiles".$dias_habilesMes;
	}else{
$dias_habilesMes=$obj_motor->habiles($cmb_mes,$nro_ano);
 "<br>"."Dias Habiles ---->".$dias_habilesMes;
	}
$dias_feriados=$obj_motor->dias_feriados($id_ano,$cmb_mes);
//echo "<br>"."Dias Feriados ---->".$dias_feriados;

if($mes==3){
	$diasTotalesMes=($dias_habilesMes-$dias_restarMarzo)-$dias_feriados;
	}else{
$diasTotalesMes=$dias_habilesMes-$dias_feriados;
	}
	
	//echo "totalesMes-->".$diasTotalesMes;

        
        $tipo=1;

        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
           /* $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }*/
		 
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total1=$factorMonto + $monto_total1;
            }
            
        }
		
		
		//exit;
		if($monto_total1==""){$monto_total1=0;}
          
		
		
		
						
  /***************************FIN PROCESO PIE***************************************************/
      
	  
	  
        $tipo=2;

        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total2=$factorMonto + $monto_total2;
            }
            
        }
		if($monto_total2==""){$monto_total2=0;}
         "<br>PIE-->"."$".$monto_total2;
        
        ?>
        
        <?php
        
        $tipo=3;
        
    $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
            echo $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total3=$factorMonto + $monto_total3;
            }
            
        }
		if($monto_total3==""){$monto_total3=0;}
         "<br>RETOS-->"."$".$monto_total3;
        
        ?>
        
        
         <?php
        
        $tipo=4;
        
        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";	*/
                
            //	echo"asistencia-->".$asistencia;
                "total asistencia-->".$totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;;
                
                $factorMonto=($monto*$totalasistencia);
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total4=$factorMonto + $monto_total4;
            }
            
        }
		if($monto_total4==""){$monto_total4=0;}
         "<BR>--->NORMAL  $".intval($monto_total4);
            "<hr>";
			
		
			$montoTotal=($monto_total1+$monto_total2+$monto_total3+$monto_total4);
			 if($montoTotal<=0){
				 continue;
				 }
			
			 $strXML .= "<set name= '$rdb' color = 'FFBA00' value = '$montoTotal' />";
	   }

    $strXML .= "</graph>";
   
	$ancho=400+(55*15);
	echo renderChartHTML("FusionCharts/FCF_Column3D.swf","",$strXML, "myNext", $ancho, 500);
	
	
	echo "<H1 class=SaltoDePagina></H1>";
	
	
	   $strXML = "";
	$strXML .= "<graph caption='Gr&aacute;fico Subvenci&oacute;n Estimada' xAxisName='Instituci&oacute;n' yAxisName='totales' decimalPrecision='0' formatNumberScale='0'>";


       $result_ = $obj_motor->busca_institucion($id_nacional);
	   $contador = pg_numrows($result_);
		
		
		$limit=round($contador/2);
				
		$result_i = $obj_motor->busca_institucion_graf_es2($id_nacional,$limit);		
				
		for($j=0;$j<pg_numrows($result_i);$j++){
			
			
			
			$monto_total1=0;
			$monto_total2=0;
			$monto_total3=0;
			$monto_total4=0;
						
			
			$fila_instit=pg_fetch_array($result_i,$j);
			$rdb = $fila_instit['rdb'];
			$nom_instit=$fila_instit['nombre_instit'];
		   


$rs_ano=$obj_motor->ano_academico($rdb,$nro_ano);
$id_ano=(pg_result($rs_ano,0));

if($mes==3){
	$dias_restarMarzo=$obj_motor->habilesdiciembre($cmb_mes,$id_ano);
	$dias_restarMarzo=pg_result($dias_restarMarzo,0);
	// "<br>"." Dias restarMarzo-->".$dias_restarMarzo;
	}

if($mes==12){
	$dias_habilesMes=$obj_motor->habilesdiciembre($cmb_mes,$id_ano);
	$dias_habilesMes=pg_result($dias_habilesMes,0);
	 "<br>"."Dias Habiles".$dias_habilesMes;
	}else{
$dias_habilesMes=$obj_motor->habiles($cmb_mes,$nro_ano);
 "<br>"."Dias Habiles ---->".$dias_habilesMes;
	}
$dias_feriados=$obj_motor->dias_feriados($id_ano,$cmb_mes);
//echo "<br>"."Dias Feriados ---->".$dias_feriados;

if($mes==3){
	$diasTotalesMes=($dias_habilesMes-$dias_restarMarzo)-$dias_feriados;
	}else{
$diasTotalesMes=$dias_habilesMes-$dias_feriados;
	}
	
	//echo "totalesMes-->".$diasTotalesMes;

        
        $tipo=1;

        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
           /* $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }*/
		 
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total1=$factorMonto + $monto_total1;
            }
            
        }
		
		
		//exit;
		if($monto_total1==""){$monto_total1=0;}
          
		
		
		
						
  /***************************FIN PROCESO PIE***************************************************/
      
	  
	  
        $tipo=2;

        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total2=$factorMonto + $monto_total2;
            }
            
        }
		if($monto_total2==""){$monto_total2=0;}
         "<br>PIE-->"."$".$monto_total2;
        
        ?>
        
        <?php
        
        $tipo=3;
        
    $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
            echo $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";*/	
                
                $totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;;
                
                $factorMonto=($monto*$factor)*$totalasistencia;
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total3=$factorMonto + $monto_total3;
            }
            
        }
		if($monto_total3==""){$monto_total3=0;}
         "<br>RETOS-->"."$".$monto_total3;
        
        ?>
        
        
         <?php
        
        $tipo=4;
        
        $rs_matricula1=$obj_motor->total_matricula($id_ano,$cmb_mes,$tipo);
        $total_mat1 = pg_result($rs_matricula1,0);
        
        for($i=0;$i<pg_numrows($rs_matricula1);$i++){
            $fila1=pg_fetch_array($rs_matricula1,$i);
            
            $id_curso=$fila1['id_curso'];
            
            $rs_asistencia=$obj_motor->aistencia_mes($id_ano,$cmb_mes,$tipo,$id_curso);
            $asistencia = pg_result($rs_asistencia,0);
      if($total_asistencia=="")
         {
            $total_asistencia=0;	 
         }
            
            $cantidad1    = $fila1['contador'];
            $ensenanza1   = $fila1['ensenanza'];
            $grado_curso1 = $fila1['grado_curso'];
            
             $imprime="<table align='center' border='1' style='border-collapse:collapse'>
            <tr>
            <td>".$cantidad1."</td>
            <td>".$ensenanza1."</td>
            <td>".$grado_curso1."</td>
            </tr></table>";
            
            $rs_subvencion=$obj_motor->calculasubvencion($ensenanza1,$grado_curso1,$tipo,$tipo_instit,$nro_ano);
            
            for($x=0; $x<pg_numrows($rs_subvencion);$x++)
            {
                $fila_s=pg_fetch_array($rs_subvencion,$x);
                $factor=$fila_s[0];
                $monto = $fila_s[1]; 
                /*echo"<pre>";
                print_r($fila_s);
                echo"</pre>";	*/
                
            //	echo"asistencia-->".$asistencia;
                "total asistencia-->".$totalasistencia=($diasTotalesMes*$cantidad1)*($txt_porc)/100;;
                
                $factorMonto=($monto*$totalasistencia);
                //echo"<br>factorMonto--->".$factorMonto;
                $monto_total4=$factorMonto + $monto_total4;
            }
            
        }
		if($monto_total4==""){$monto_total4=0;}
         "<BR>--->NORMAL  $".intval($monto_total4);
            "<hr>";
			
		
			$montoTotal=($monto_total1+$monto_total2+$monto_total3+$monto_total4);
			 if($montoTotal<=0){
				 continue;
				 }
			
			 $strXML .= "<set name= '$rdb' color = 'FFBA00' value = '$montoTotal' />";
	   }

    $strXML .= "</graph>";
   
	$ancho=400+(55*15);
	echo renderChartHTML("FusionCharts/FCF_Column3D.swf","",$strXML, "myNext", $ancho, 500);
	
	?>
    	 </td>
         
        
	  </tr>
       <tr>
      
      <td>&nbsp;</td>
      </tr>
      <tr>
      
      <td><div align="right" class="subitem"><? //=$fecha=$ob_reporte->fecha_actual();?></div></td>
      </tr>
      
</table>

</body>
</html> 





        

