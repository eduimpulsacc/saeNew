
<?php
require('../util/header.inc');
include('../admin/clases/class_Reporte.php');
include('../admin/clases/class_Membrete.php');
include_once("../admin/clases/soap/lib/nusoap.php");


//print_r($_GET);
	$_POSP = 4;
	$_bot = 8;
	
	 $institucion	= $_INSTIT;
	 $ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	//$reporte		= $c_reporte;
	$modulo=1;
	$tipo=1;

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();

if ($c_curso>0){
	 $Curso_pal = CursoPalabra($curso, 1, $conn);
	
}

	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	
	
	
	$ob_membrete->ano = $ano;
	$ob_membrete->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;

	/*************** PROFESOR JEFE ****************/
	$ob_reporte ->curso =$curso;
	$ob_reporte ->ProfeJefe($conn);

	

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
 
	$fecha=$ob_reporte->fecha_actual();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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
 table {
  font-size:12px
  
  border-spacing:12px;
 }

th {
  
 }
  
td {
  
  padding:4px;
 }
 
</style>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../cortes/b_ayuda_r.jpg','../cortes/b_info_r.jpg','../cortes/b_mapa_r.jpg','../cortes/b_home_r.jpg')">
 

<!-- INICIO CUERPO DE LA PAGINA -->

<?
	 
				
				
		?>
        
        
        	<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">
	<? }?>
      </td>
    </tr>
  </table>
</div>
<br><br><br>
        		
		<?		
		
		 $sql_int="select * from institucion  where institucion.rdb=".$institucion;
			$result_ins= @pg_Exec($conn,$sql_int)or die("fallo 5".$sql_int);
		for($x=0;$x<pg_numrows($result_ins);$x++){
		$fila_ins = pg_fetch_array($result_ins,0);	
		$nombre_inst=$fila_ins['nombre_instit'];	
		}
		/// fin nombre del alumno
	    ?>



	<table width="650" border="0" align="center" cellpadding="0" cellspacing="0"  style="font-size:12px">
  <tr>
    <? if ($institucion!="770"){ ?>
    <td width="114" class="" ><div align="left" ><strong>INSTITUCI&Oacute;N</strong></div></td>
    <td width="9" class=""><strong>:</strong></td>
    <td width="361" class=""><div align="left"><? echo strtoupper(trim($ob_membrete->ins_pal)) ?></div></td>
    <td width="161" rowspan="7" align="center" valign="top" >
	<?
					$result = @pg_Exec($conn,"select insignia,rdb from institucion where rdb=".$institucion);
					$arr=@pg_fetch_array($result,0);
					$fila_foto  = @pg_fetch_array($result,0);
					## c&oacute;digo para tomar la insignia
			
				  if($institucion!=""){
					   echo "<img src='../tmp/".$fila_foto['rdb']."insignia". "' >";
				  }else{
					   echo "<img src='".$d."../menu/imag/logo.gif' >";
				  }?>    </td>
    <? } ?>
  </tr>
  <tr>
    <td class=""><div align="left"><strong>A&Ntilde;O ESCOLAR</strong></div></td>
    <td class=""><strong>:</strong></td>
    <td class=""><div align="left"><? echo trim($nro_ano) ?></div></td>
  </tr>
  <tr>
    <td class="item"><div align="left"><strong>CURSO</strong></div></td>
    <td class="item"><strong>:</strong></td>
    <td class="item"><div align="left"><? echo $Curso_pal; ?></div></td>
  </tr>
 
  <tr>
    <td class="item"><div align="left"><strong>PROFESOR(A) JEFE</strong></div></td>
    <td class="item"><div align="left"><strong>:</strong></div></td>
    <td class="item"><div align="left">
      <?
				    if($institucion==770){
		                 echo $ob_reporte->profe_nombre;
					}else{
		                 echo $ob_reporte->tildeM($ob_reporte->profe_jefe);
					}				
					?>
    </div>
    </td>
  </tr>
  </table>
				
	
		<br>
        <?php
		
		if($c_curso==0){
			
			  $sql_curso = "select id_curso from curso where curso.id_ano=".$ano." order by id_curso desc";
             $rs_curso = @pg_exec($conn,$sql_curso) or die("SELECT FALLO:".$sql_curso);
			
			
           for($j=0;$j<@pg_numrows($rs_curso);$j++){  // INICIO FOR
			 $fila_c = @pg_fetch_array($rs_curso,$j);
			 $curso=$fila_c['id_curso']; 
			
			 $Curso_pal = CursoPalabra($curso, 1, $conn);
			 
		 $sql = "SELECT cur.id_curso, 
       (cur.grado_curso || ' - ' || cur.letra_curso) as cursote, 
		alu.ape_pat,alu.ape_mat,alu.nombre_alu,alu.rut_alumno,alu.dig_rut
		FROM institucion inst
		inner join ano_escolar aesco on aesco.id_institucion = inst.rdb 
		inner join curso cur on cur.id_ano = aesco.id_ano AND cur.id_curso = ".$curso."
		inner join matricula matri on matri.id_curso = cur.id_curso 
		inner join alumno alu on alu.rut_alumno = matri.rut_alumno
		WHERE
		inst.rdb = ".$institucion."
		ORDER BY 2";
		
		$rs = @pg_exec($conn,$sql);
		
		
		
		echo "<TABLE align='center' border='1' nowrap='nowrap' width='700' style='border-collapse:collapse' style='font-size:8px' >";
echo "<TR>";
echo "<TH colspan='6'>&nbsp;SERVICIO WEB SERVICE SIGE&nbsp;</TH>";
echo "</TR>";
echo "<TR>";
echo "<TH colspan='6'>&nbsp;".$Curso_pal."&nbsp;</TH>";
echo "</TR>";
echo "<TR>";
echo "<TH colspan='6'>&nbsp;</TH>";
echo "</TR>";
echo "<TR>";
echo "<TH>&nbsp;#&nbsp;</TH>";
echo "<TH>&nbsp;RUT&nbsp;</TH>";
echo "<TH>&nbsp;NOMBRE&nbsp;</TH>";
echo "<TH>&nbsp;APE. PATERNO&nbsp;</TH>";
echo "<TH>&nbsp;APE. MATERNO&nbsp;</TH>";
echo "<TH>&nbsp;ESTADO&nbsp;</TH>";
echo "</TR>";

for($x=0;$x<@pg_numrows($rs);$x++){  // INICIO FOR
 
//echo $x1 = $fila['rut_alumno']."=".$fila['nombre_alu']."<br>";
  
	    $fila = @pg_fetch_array($rs,$x);

		$oSoapClient1 = new soapclient('http://dido.mineduc.cl:9080/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);
								
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		/*************************SOLICITO VALOR SEMILLA************************************************/	

		$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>25</ClienteId>
			<ConvenioId>31</ConvenioId>
			<ConvenioToken>TESTCOLEGIOINTERACTIVO</ConvenioToken>
		</EntradaSemillaServicios>'; 
				
		$resultado1 = $oSoapClient1->call('getSemillaServicios',$StrXml1,'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd',
		'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd/getSemillaServicios');
		
		if ($oSoapClient1->fault) {
		
			echo '<h2>Fault 1</h2><pre>';
			print_r($resultado1);
			echo '</pre>';
		
		} else {
		
			$err = $oSoapClient1->getError();
			
			if ($err) {
				echo '<h2>Error2_</h2><pre>'.$err.'</pre>';
			} else {
				 '<h2>Resulttado Semilla</h2><pre>';
				// print_r($resultado1);
				 '</pre>';
			 }
		
		}
		
		/***************************CONSULTO POR ALUMNOS*************************************************/
		
		$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/ValidaAlumnoSigeSoapPort.wsdl',true);
														
		// Se pudo conectar?
		$err = $oSoapClient2->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		$StrXml2 = '<EntradaValidaAlumnoSige xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnoSige.xsd" xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<Run>
			<numero>'.utf8_encode($fila['rut_alumno']).'</numero>
			<dv>'.utf8_encode($fila['dig_rut']).'</dv>
			</Run>
			<Nombres>'.utf8_encode($fila['nombre_alu']).'</Nombres>
			<ApellidoPaterno>'.utf8_encode($fila['ape_pat']).'</ApellidoPaterno>     
			<ApellidoMaterno>'.utf8_encode($fila['ape_mat']).'</ApellidoMaterno>
			<Semilla>'.$resultado1[ValorSemilla].'</Semilla>
		</EntradaValidaAlumnoSige>';
		
		$resultado2 = $oSoapClient2->call('getValidacion',$StrXml2,'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd',
		'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd/getValidacion');
		
		if ($oSoapClient2->fault) {
		
			echo '<tr nowrap="nowrap" >
			      <td>'.$x.'</td>
				  <td colspan="5" >';
			//print_r($resultado2);
			echo '</td>
			      </tr>';
		
		} else {
		
			$err = $oSoapClient2->getError();
			
			if ($err) {
			
				echo "<tr nowrap='nowrap' >
				      <td>".$x."</td>
				      <td colspan='5' >".$err.'</td>
					  </tr>';
			
			} else {
			    
				
			$sql="select * from respuesta_sige rs where rs.numero_respuesta=".$resultado2[ExisteFichaAlumno]." and modulo=".$modulo." and tipo=".$tipo."";
			$resultado_s = pg_Exec($conn,$sql);
			$fila_s	= pg_fetch_array($resultado_s,0);
			$dime_glosa=$fila_s['descripcion'];
				
				
				echo "<tr nowrap='nowrap' style='font-size:12px' >";
				echo "<td>".$x."</td>"; 
				echo "<td align='center'>".$fila['rut_alumno']."-".$fila['dig_rut']."</td>";
				echo "<td>".$fila['nombre_alu']."</td>";
				echo "<td>".$fila['ape_pat']."</td>";
				echo "<td>".$fila['ape_mat']."</td>";
				echo "<td align='left'>".$dime_glosa."</td>";
			    echo "</tr>";
			}
		
		}
       }
	  
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	
		
      }
			
			}else{
        
		 $sql = "SELECT cur.id_curso, 
       (cur.grado_curso || ' - ' || cur.letra_curso) as cursote, 
		alu.ape_pat,alu.ape_mat,alu.nombre_alu,alu.rut_alumno,alu.dig_rut
		FROM institucion inst
		inner join ano_escolar aesco on aesco.id_institucion = inst.rdb 
		inner join curso cur on cur.id_ano = aesco.id_ano AND cur.id_curso = ".$curso."
		inner join matricula matri on matri.id_curso = cur.id_curso 
		inner join alumno alu on alu.rut_alumno = matri.rut_alumno
		WHERE
		inst.rdb = ".$institucion."
		ORDER BY 2";
			
       $rs = @pg_exec($conn,$sql) or die("SELECT FALLO:".$sql);

      
	   
echo "<TABLE align='center' border='1' nowrap='nowrap' width='85%' style='border-collapse:collapse' style='font-size:8px' >";
echo "<TR>";
echo "<TH style='background-color:#D3D3D3' colspan='6'>&nbsp;SERVICIO WEB SERVICE SIGE&nbsp;</TH>";
echo "</TR>";
echo "<TR>";
echo "<TH style='background-color:#D3D3D3' colspan='6'>&nbsp;</TH>";
echo "</TR>";
echo "<TR class='cuadro02'>";
echo "<TH>&nbsp;#&nbsp;</TH>";
echo "<TH>&nbsp;RUT&nbsp;</TH>";
echo "<TH>&nbsp;NOMBRE&nbsp;</TH>";
echo "<TH>&nbsp;APE. PATERNO&nbsp;</TH>";
echo "<TH>&nbsp;APE. MATERNO&nbsp;</TH>";
echo "<TH>&nbsp;ESTADO&nbsp;</TH>";
echo "</TR>";

for($x=0;$x<@pg_numrows($rs);$x++){  // INICIO FOR
 
//echo $x1 = $fila['rut_alumno']."=".$fila['nombre_alu']."<br>";
  
	    $fila = @pg_fetch_array($rs,$x);

		$oSoapClient1 = new soapclient('http://dido.mineduc.cl:9080/WsApiAutorizacion/wsdl/SemillaServiciosSoapPort.wsdl',true);
								
		// Se pudo conectar?
		$err = $oSoapClient1->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		/*************************SOLICITO VALOR SEMILLA************************************************/	

		$StrXml1 = '<EntradaSemillaServicios xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd"
		 xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<ClienteId>25</ClienteId>
			<ConvenioId>31</ConvenioId>
			<ConvenioToken>TESTCOLEGIOINTERACTIVO</ConvenioToken>
		</EntradaSemillaServicios>'; 
				
		$resultado1 = $oSoapClient1->call('getSemillaServicios',$StrXml1,'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd',
		'http://wwwfs.mineduc.cl/Archivos/Schemas/EntradaSemillaServicios.xsd/getSemillaServicios');
		
		if ($oSoapClient1->fault) {
		
			echo '<h2>Fault 1</h2><pre>';
			print_r($resultado1);
			echo '</pre>';
		
		} else {
		
			$err = $oSoapClient1->getError();
			
			if ($err) {
				echo '<h2>Error 2</h2><pre>'.$err.'</pre>';
			} else {
				 '<h2>Resulttado Semilla</h2><pre>';
				//print_r($resultado1);
				 '</pre>';
			 }
		
		}
		
		/***************************CONSULTO POR ALUMNOS*************************************************/
		
		$oSoapClient2 = new soapclient('http://dido.mineduc.cl:9080/WsApiMineduc/wsdl/ValidaAlumnoSigeSoapPort.wsdl',true);
														
		// Se pudo conectar?
		$err = $oSoapClient2->getError();
		if ($err) {
			echo '<h2>Error1</h2><pre>'.$err.'</pre>';
				} 
		
		$StrXml2 = '<EntradaValidaAlumnoSige xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
		xsi:schemaLocation="http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnoSige.xsd" xmlns="http://wwwfs.mineduc.cl/Archivos/Schemas/" >
			<Run>
			<numero>'.utf8_encode($fila['rut_alumno']).'</numero>
			<dv>'.utf8_encode($fila['dig_rut']).'</dv>
			</Run>
			<Nombres>'.utf8_encode($fila['nombre_alu']).'</Nombres>
			<ApellidoPaterno>'.utf8_encode($fila['ape_pat']).'</ApellidoPaterno>     
			<ApellidoMaterno>'.utf8_encode($fila['ape_mat']).'</ApellidoMaterno>
			<Semilla>'.$resultado1[ValorSemilla].'</Semilla>
		</EntradaValidaAlumnoSige>';
		
		$resultado2 = $oSoapClient2->call('getValidacion',$StrXml2,'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd',
		'http:wwwfs.mineduc.cl/Archivos/Schemas/EntradaValidaAlumnosSige.xsd/getValidacion');
		
		if ($oSoapClient2->fault) {
		
			echo '<tr nowrap="nowrap" >
			      <td>'.$x.'</td>
				  <td colspan="5" >';
			print_r($resultado2);
			echo '</td>
			      </tr>';
		
		} else {
		
			$err = $oSoapClient2->getError();
			
			if ($err) {
			
				echo "<tr nowrap='nowrap' >
				      <td>".$x."</td>
				      <td colspan='5' >".$err.'</td>
					  </tr>';
			
			} else {
			    
				//print_r($resultado2[ExisteFichaAlumno]);
				
			    
				$resultado = $resultado2[ExisteFichaAlumno];
				
					
		
			 $sql="select * from respuesta_sige rs where rs.numero_respuesta=".$resultado2[ExisteFichaAlumno]." and modulo=".$modulo." and tipo=".$tipo."";
			$resultado_s = pg_Exec($conn,$sql);
			$fila_s	= pg_fetch_array($resultado_s,0);
			$dime_glosa=$fila_s['descripcion'];
				
				
				echo "<tr  nowrap='nowrap' style='font-size:12px' >";
				echo "<td>".$x."</td>"; 
				echo "<td align='center'>".$fila['rut_alumno']."-".$fila['dig_rut']."</td>";
				echo "<td>".$fila['nombre_alu']."</td>";
				echo "<td>".$fila['ape_pat']."</td>";
				echo "<td>".$fila['ape_mat']."</td>";
				echo "<td align='left'>".$dime_glosa."</td>";
			    echo "</tr>";
			}
		
		}
		
		
		
		
		/*****************************************************************************************************/
		
  } // TERMINA FOR
   }
echo "<TABLE>";
		
		?>
        
        
        
		<br>
		
		 
             
		 
   </td>
	  </tr>
</table>
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

<table width="650" border="0" align="center">
  <tr>
    <td>&nbsp;<hr></td>
  </tr>
</table>

	<?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	?>
	
    <?
	$i++;
	?>

</body>
</html>
<? pg_close($conn);?>