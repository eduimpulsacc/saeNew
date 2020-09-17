<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

</script>
<?
require('../../../../util/header.inc');
include('../../../clases/class_Membrete.php');
include('../../../clases/class_MotorBusqueda.php');
include('../../../clases/class_Reporte.php');

	//setlocale("LC_ALL","es_ES")	;
	//---------------------------
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$c_curso;
	$alumno			=$c_alumno;
	$reporte		=$c_reporte;
	
	$_POSP = 4;
	$_bot = 8;
	
	//---------------------------
	if ($curso==0){?>
	  <!--	<script>alert("Debe seleccionar el Curso")</script> -->
	<? //exit;
	 }
	
	if ($alumno==0){?>
		<!--<script>alert("Debe seleccionar el Alumno")</script> -->	
	<? //exit;
	 }		
	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();	 
	/*******INSITUCION *******************/
	$ob_membrete ->institucion=$institucion;
	$ob_membrete ->institucion($conn);
	
		 
	/********** AÑO ESCOLAR*****************/
	$ob_membrete ->ano = $ano;
	$ob_membrete ->AnoEscolar($conn);
	$nro_ano = $ob_membrete->nro_ano;

	/************ CURSO ********************/	
	$Curso_pal = CursoPalabra($curso, 0, $conn);	

		//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
	
	
	if ($alumno == 0){
		
	}else{
		$ob_reporte ->alumno =$alumno;
		$ob_reporte ->ano = $ano;
		$rsAlumno= $ob_reporte->FichaAlumnoUno($conn);
		$fila= @pg_fetch_array($rsAlumno,0);
		$ob_reporte ->CambiaDato($fila);
		
		$sexo = $ob_reporte ->sexo;
		$Curso_pal  = ucwords($Curso_pal);
		if ($sexo == "Masculino"){
			$tipo1 = "alumno";
			$tipo2 = "del interesado";
			$tipo3 = "inscrito";
		}else{
			$tipo1 = "alumna";
			$tipo2 = "de la interesada";
			$tipo3 = "inscrita";
		}			
	}
	
	
	//----------
	

	Function rutF($txt){
		if ($txt!=0){
			$largo=strlen($txt);
			if ($largo==9){
				$millon =substr (($txt), 0,2); 
				$centena = substr (($txt), 2,3); 
				$decena = substr (($txt), 5,3); 
				$exten = substr (($txt), -1); 
			}else{
				$millon =substr (($txt), 0,1); 
				$centena = substr (($txt), 1,3); 
				$decena = substr (($txt), 4,3); 
				$exten = substr (($txt), -1); 
			}
		$txt = $millon.".".$centena.".".$decena." - ".$exten;
		echo $txt;
		}
	}
		//----------
		$sql_curso = "select ensenanza, cod_es, cod_sector, cod_rama from curso where id_curso=" . $curso;
		$result_curso = @pg_exec($conn,$sql_curso);
		$fila_curso = @pg_fetch_array($result_curso,0);
		$Ense = $fila_curso['ensenanza'];
		$Espec = $fila_curso['cod_es'];
		$Sector = $fila_curso['cod_sector'];
		$Rama = $fila_curso['cod_rama'];
		
		if ($Ense >310){
			$sql_esp = "select nombre_esp from especialidad where cod_esp=" .$Espec." and cod_sector=".$Sector." and cod_rama=".$Rama;
			$result_esp = @pg_exec($conn,$sql_esp);
			$fila_esp = @pg_fetch_array($result_esp,0);
			$Especialidad = $fila_esp['nombre_esp'];
		}
		
			$sql_Mat = "select num_mat from matricula where rut_alumno='" .$alumno."' and id_ano=".$ano;
			$result_Mat= @pg_exec($conn,$sql_Mat);
			$fila_Mat = @pg_fetch_array($result_Mat,0);
			$numero = $fila_Mat['num_mat'];
	//----------
	//----------
	$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp, trabaja.cargo FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo='1' OR trabaja.cargo='23')";

	    /*$sql = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
		$sql = $sql . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
		$sql = $sql . "WHERE (((trabaja.rdb)=".$institucion.") AND ((trabaja.cargo)=1)); ";*/
		$result =@pg_Exec($conn,$sql);
		$fila = @pg_fetch_array($result,0);	
		$Nombre_Direc = strtoupper(trim(trim($fila['nombre_emp']. " " .$fila['ape_pat']) . " " . trim($fila['ape_mat'])  ));
        $cargo_dir    = $fila['cargo'];	
		
		
	if ($cargo_dir==1){
	    $cargo_dir  = "Director(a)";
		$cargo_dir2 = "Director(a)";
		
		if ($institucion==24977){
		     $cargo_dir2 = "Rector(a)";
		}
		
	}
	if ($cargo_dir==23){
	    $cargo_dir  = "Rector(a)";
		$cargo_dir2 = "Rector(a)";
	}		



if($cb_ok!="Buscar"){
	$xls=1;
}
	 
if($xls==1){
$fecha_actual = date('d/m/Y-H:i:s');	 
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition:inline; filename=Certificado_alumno_regular_$fecha_actual.xls"); 	 
}	 

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">
			function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'CertificadoAlumnoRegular.php?institucion=$institucion';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		
			
		function exportar(){
			window.location='printCertificadoAlumnoRegular_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
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
 font-size:<?=$ob_config->tamanoS + 6;?>px;
 }

.Estilo1 {font-family: "Arial Narrow"}
.Estilo2 {
	font-family: Verdana;
	font-size: 9px;
	font-weight: bold;
}
.Estilo3 {font-size: 10}
.Estilo4 {font-size: 10px}
.Estilo6{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:9px;
	font-style:italic;
	color:#666666;
}
.Estilo5 {
	font-family: "Times New Roman", Times, serif;
	font-size: 36px;
	font-style: italic;
}
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
<!-- INICIO CUERPO DE LA PAGINA -->

<?
if ($curso > 0 ){
   ?>
<center>
<form name="form" method="post" action="printCertificadoAlumnoRegular_C.php" target="_blank">
  <table width="650" border="0" cellspacing="0" cellpadding="0">
    <tr align="right">
      <td>
        <div id="capa0">
		<table width="100%">
		  <tr><td><table>
          <tr>
            <td align="left"><input name="button4" type="button" class="botonXX" onClick="cerrar()"  value="CERRAR">
            </td>
          </tr>
        </table>
          
		  </td>
		<td align="right">
		  <input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
		  <input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR"></td>
		  </tr>
		  </table>
      </div></td>
    </tr>
  </table>
  
  
</form>
</center>
<p>
  <br>

<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td> <div align="center">
      <?	
			$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
			$arr=@pg_fetch_array($result,0);
			$fila_foto = @pg_fetch_array($result,0);
			## código para tomar la insignia
			
			if($institucion!=""){
			echo "<img src='../../../../tmp/".$fila_foto['rdb']."insignia". "' >";
			}else{
			echo "<img src='".$d."menu/imag/logo.gif' >";
			}
			?>
    </div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center"><em><font color="#666666"><? echo ucwords(strtolower($ob_membrete->ins_pal));?></font></em></div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center" class="Estilo6"><? echo $ob_reporte->tilde(ucwords(strtolower($ob_membrete->direccion)));?></div></td>
  </tr>
  <tr>
    <td class="Estilo6"><div align="center"><em><font color="#666666"><? echo "Fono: ".$ob_membrete->telefono."   Fax: ".$ob_membrete->fax;?></font></em></div></td>
  </tr>
  <tr>
    <td class="Estilo3"><div align="center"><em><font color="#666666"><? echo "e-mail: ".$ob_membrete->email;?></font></em></div></td>
  </tr>
  <tr>
    <td><hr color="#666666" style="border-collapse:collapse; height:1px"></td>
  </tr>
</table>

<br>
<br>
<table width="650" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center" class="Estilo5">CERTIFICADO DE TRASLADO </div></td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="3">
  <tr>
    <td class="subitem" style="line-height:200%"><div align="justify"><strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<em>&nbsp;
        <?	echo ucwords(strtolower($ob_reporte->tilde($Nombre_Direc)));?>
        , </em></strong>
            <em>
      <?
		if ($institucion==1593){ 
		     echo "Director";
		}else{ 
		     if ($institucion==24977){
			      echo $cargo_dir2;
			 }else{
			      echo $cargo_dir;
			 }			 
              if($institucion==14703){
			 echo "  ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			 
			 }else{
			 echo " del ".trim(strtoupper($ob_membrete->ins_pal)).", ";
			 }
			
		}
		?>
      certifica que el(la) <?=$tipo1;?>, <strong>
        <? $nombres=strtoupper($ob_reporte->nombres);
	  echo ucwords(strtolower($ob_reporte->tilde($nombres)));?>
        </strong> del curso <? echo $Curso_pal, " ";?>
            <? 
		if ($institucion!=1518)
		echo ucwords(strtolower($Especialidad)); 
		
		?>, se retira del establecimiento el d&iacute;a <?=$txtFECHA;?>.</em></div></td>
  </tr>
</table>
<br>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2" class="subitem" style="line-height:200%"><div align="justify"><em> Se extiende el presente certificado para ser presentado 
en donde estime conveniente </em></div></td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<table width="650" border="0" align="center">
  <tr>
    <?  
			if($ob_config->firma1!=0){
				$ob_reporte->cargo=$ob_config->firma1;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="Estilo1" height="100"><hr align="center" width="150" color="#000000" style="height:1px">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma2!=0){
				$ob_reporte->cargo=$ob_config->firma2;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="Estilo1"><hr align="center" width="150" color="#000000" style="height:1px">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma3!=0){
		  		$ob_reporte->cargo=$ob_config->firma3;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="Estilo1"><hr align="center" width="150" color="#000000" style="height:1px">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
      </div></td>
    <? } ?>
    <? if($ob_config->firma4!=0){
				$ob_reporte->cargo=$ob_config->firma4;
				$ob_reporte->rdb=$institucion;
				$ob_reporte->curso=$curso;
				$ob_reporte->Firmas($conn);?>
    <td width="25%" class="Estilo1"><hr align="center" width="150" color="#000000" style="height:1px">
        <div align="center">
          <?=$ob_reporte->nombre_emp;?>
          <br>
          <?=$ob_reporte->nombre_cargo;?>
    </div></td>
    <? }?>
  </tr>
</table>
<br>
<table width="724" height="43" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <? $fecha = date("d-m-Y") ?>
    <td width="%" align="left"><em><font face="Arial, Helvetica, sans-serif" size="-1"><? echo ($ob_membrete->comuna . ", " . fecha_espanol($fecha))?></font></em></td>
  </tr>
</table>
<br>
<?	


}
?>
</p>
    <p>	
      <!-- FIN CUERPO DE LA PAGINA -->
      
</p>
</body>
</html>
<? pg_close($conn);?>