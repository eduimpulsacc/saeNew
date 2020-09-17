<?php
require('../../../../util/header.inc');
require('../../../../util/LlenarCombo.php3');
require('../../../../util/SeleccionaCombo.inc');

	
	$_POSP = 4;
	$_bot = 8;
	
	$institucion	= $_INSTIT;
	$ano			= $_ANO;
	$curso			= $c_curso;
	$docente		= 5; //Codigo Docente
	$frmModo		=$_FRMMODO;
	$alumno			=$alumno;	


if ($cmb_curso>0){
   $q1 = "SELECT * from institucion where rdb = '".trim($_INSTIT)."'";
   $r1 = @pg_Exec($conn,$q1);
   $n1 = @pg_numrows($r1);
   
   
   
    $qryEMP="SELECT empleado.rut_emp, empleado.dig_rut, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat, trabaja.cargo, trabaja.fecha_ingreso, trabaja.fecha_retiro FROM (empleado INNER JOIN trabaja ON empleado.rut_emp = trabaja.rut_emp) INNER JOIN institucion ON trabaja.rdb = institucion.rdb WHERE (((institucion.rdb)=".$institucion.") and ((trabaja.cargo)=1)) order by trabaja.cargo, ape_pat, ape_mat, nombre_emp asc";
	$resultEMP =@pg_Exec($conn,$qryEMP);
	if (!$resultEMP) {
	    error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
	}else{
	     if (pg_numrows($resultEMP)!=0){//En caso de estar el arreglo vacio.
				$filaEMP = @pg_fetch_array($resultEMP,0);
				$nombre_director  =	$filaEMP['nombre_emp'];
				$nombre_director .= $filaEMP['ape_pat'];
				$nombre_director .= $filaEMP['ape_mat'];
				$ciudad           = $filaEMP['ciudad'];                
		 }
	}
	/// aqui determino el curso elegio
	$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
	$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
	$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) and curso.id_curso = '".trim($cmb_curso)."'";
	$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
	$resultado_query_cue = pg_exec($conn,$sql_curso);
	//------------------
	$sql_peri = "select * from periodo where id_ano = ".$ano;
	$result_peri = pg_exec($conn,$sql_peri);
    
	$fila = @pg_fetch_array($resultado_query_cue,0); 
	$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
	/// fin curso elegido
	
	
	
	
	// ahora tomo el nombre  del apoderado
	if (($cmb_apoderado>0) or ($cmb_alumno>0)){
	      $sq = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where rut_alumno = '".trim($cmb_alumno)."'))";  
	}
	
	$rs = @pg_Exec($conn,$sq);
	$ns = @pg_numrows($rs);
	 
}

//// FECHA HOY   ////
$dia_hoy = date(d);
$mes_hoy = date(m);
$ano_hoy = date(Y);

if ($mes_hoy=="01"){
   $mes_hoy = "Enero";
}
if ($mes_hoy=="02"){
   $mes_hoy = "Febrero";
}
if ($mes_hoy=="03"){
   $mes_hoy = "Marzo";
}
if ($mes_hoy=="04"){
   $mes_hoy = "Abril";
}
if ($mes_hoy=="05"){
   $mes_hoy = "Mayo";
}
if ($mes_hoy=="06"){
   $mes_hoy = "Junio";
}
if ($mes_hoy=="07"){
   $mes_hoy = "Julio";
}
if ($mes_hoy=="08"){
   $mes_hoy = "Agosto";
}
if ($mes_hoy=="09"){
   $mes_hoy = "Septiembre";
}
if ($mes_hoy=="10"){
   $mes_hoy = "Octubre";
}
if ($mes_hoy=="11"){
   $mes_hoy = "Noviembre";
}
if ($mes_hoy=="12"){
   $mes_hoy = "Diciembre";
}    

$fecha_hoy = "$dia_hoy $mes_hoy de $ano_hoy";



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
	<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
.conscroll {
overflow: auto;
width: 500px;
height: 400px;
clear:both;
} 
.salto{
page-break-after:always;
}
.Estilo5 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
    </style>
	
<SCRIPT language="JavaScript">
			function enviapag(form){
			if (document.form.cmb_curso.value!=0){				
				document.form.action = "carta_apoderado.php";
				document.form.submit();
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}
		function envia(){
			document.form.action="carta_apoderado.php";
			document.form.ssww.value=1;
			document.form.submit();
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
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')">
 

<!-- INICIO CUERPO DE LA PAGINA -->


<div id="capa0">
  <table width="650">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
      </td>
    </tr>
  </table>
</div>
<?
if ($cmb_alumno==0){
    // listar cada apoderado de cada alumno
	$sq = "select * from apoderado where rut_apo in (select rut_apo from tiene2 where rut_alumno in (select rut_alumno from matricula where id_curso = '".trim($cmb_curso)."'))";  
    $rs = @pg_Exec($conn,$sq);
	$ns = @pg_numrows($rs);
}
?>

<?
$i=0;
while ($i < $ns){
	$fs = @pg_fetch_array($rs,$i);
	$nombre_apoderado =  ucwords(strtolower($fs['ape_pat'].$fs['ape_mat'].$fs['nombre_apo'])); 
	$rut_apo          =  $fs['rut_apo']; 
	
    ?>	
	<table width="650" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
		
		
	<? if ($institucion=="770"){ 
		   // no muestro los datos de la institucion
		   // por que ellos tienen hojas pre-impresas
		   echo "<br><br><br><br><br><br><br><br><br><br><br><br>";
		   
	  }else{
		
		    ?>
		
		
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td>
					<!-- aqui va la insignia -->
					
					<table width="125" border="0" cellpadding="0" cellspacing="0">
					<tr valign="top" >
					  <td width="125" align="center"> 	  
						<?
						$result = @pg_Exec($conn,"select * from institucion where rdb=".$institucion);
						$arr=@pg_fetch_array($result,0);
						$fila_foto = @pg_fetch_array($result,0);
						## código para tomar la insignia
						if($institucion!=""){
						   echo "<img src='".$d."tmp/".$fila_foto['rdb']."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>		  </td>
					</tr>
				  </table>
					
					<!-- fin de la insignia -->					</td>
					<td><div align="right" class="Estilo5"><?=$fecha_hoy ?></div></td>
				  </tr>
				</table>
	<? } ?>	
		
		
		
		<?
				
		//// aqui tomo los datos del alumno
		$sql="select * from alumno where rut_alumno in (select rut_alumno from tiene2 where rut_apo = '".trim($rut_apo)."')";
		//$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno and alumno.rut_alumno = '".trim($cmb_alumno)."'";
		$result= @pg_Exec($conn,$sql);
		$fila =  @pg_fetch_array($result,0);
		$nombre_alumno  = $fila['ape_pat'];
		$nombre_alumno .= $fila['ape_mat'];
		$nombre_alumno .= $fila['nombre_alu'];
		/// fin nombre del alumno
	    		
		/// ahora debo tomar los datos de acceso
		$sq1 = "select * from usuario where nombre_usuario = '".trim($rut_apo)."'";
		$rq1 = pg_Exec($conn,$sq1);
		if (@pg_numrows($rq1)>0){
			 $filasq1 = @pg_fetch_array($rq1,0);
			 $usuario_apoderado = $filasq1['nombre_usuario'];
			 $clave_apoderado   = $filasq1['pw'];
		}
		//// fin datos de acceso del apoderado	
	    ?>
		
		
		  <p class="Estilo5"><br>
			<br>
			Se&ntilde;or(a):  <b><?=$nombre_apoderado ?></b><br>
			Apoderado(a)  de <b><?=$nombre_alumno ?></b> de <b><?=$Curso_pal ?></b></p>
		  <p class="Estilo5"><strong>Presente:</strong></p>
		  <p align="justify" class="Estilo5">Junto  con saludarle, tenemos el agrado de informarle que nuestro establecimiento se  encuentra en un plan de innovaci&oacute;n tecnol&oacute;gica y se ha adherido a la plataforma  Internet de Gesti&oacute;n Escolar &ldquo;Colegio Interactivo&rdquo;.<br>
		    <br>
	  Esta  aplicaci&oacute;n a la cual podr&aacute; acceder desde el &nbsp;sitio Web , nos permitir&aacute;&nbsp; fortalecer la misi&oacute;n familia-colegio,  inform&aacute;ndole en forma continua tanto del rendimiento acad&eacute;mico de su pupilo(a),  como su conducta, a fin de fortalecer sus debilidades y destacar sus logros.<br>
	  <br>
	  <br>
	  
	  
	  Para  acceder a esta informaci&oacute;n por primera vez, siga los siguientes pasos:<br>
		  <br>
		  <strong>Acceso como apoderado: </strong></p>
		  <ol class="Estilo5">
			<li>Nombre de usuario: <b><?=$usuario_apoderado ?></b> </li>
			<li>Clave: <b><?=$clave_apoderado ?></b><br>
			</li>
		  </ol>
		  
		 <? 
		  // ahora tomo el nombre del alumno
		  if ($cmb_alumno>0){
			  $sql_usu = "select * from usuario where nombre_usuario = '".trim($cmb_alumno)."'";
			  $res_usu = @pg_Exec($conn,$sql_usu);
			  $num_usu = @pg_numrows($res_usu);
				
			  if ($num_usu > 0){
				 $fil_usu = @pg_fetch_array($res_usu,0);
				 $alu_usu  = $fil_usu['nombre_usuario'];
				 $alu_pw   = $fil_usu['pw'];		     
			  } 	 
		  		  
		  }else{
		      $sql_usu = "select * from tiene2 where rut_apo = '".trim($rut_apo)."'";
			  $res_usu = @pg_Exec($conn,$sql_usu);
			  $num_usu = @pg_numrows($res_usu);
				
			  if ($num_usu > 0){
			      $fil_usu = @pg_fetch_array($res_usu,0);
		          $rut_alumno  = $fil_usu['rut_alumno'];
				  
				  
				  $sql_usu2 = "select * from usuario where nombre_usuario = '".trim($rut_alumno)."'";
				  $res_usu2 = @pg_Exec($conn,$sql_usu2);
				  $num_usu2 = @pg_numrows($res_usu2);
					
				  if ($num_usu2 > 0){
					 $fil_usu2 = @pg_fetch_array($res_usu2,0);
					 $alu_usu  = $fil_usu2['nombre_usuario'];
					 $alu_pw   = $fil_usu2['pw'];		     
				  }
			   }  
		  } 
		  ?>
		  
		  <p class="Estilo5"><br>
		    <strong>Acceso como Alumno:</strong></p>
		  <ol>
		    <li class="Estilo5">Nombre de usuario:<strong> <?=$alu_usu ?></strong></li>
		    <li class="Estilo5">Clave: <strong> <?=$alu_pw ?></strong> </li>
		  </ol>
	  
	  
		    <br>
	        <span class="Estilo5">Como norma de  seguridad, le solicitamos modifique su clave peri&oacute;dicamente y en caso de tener  dificultades comun&iacute;quese con el soporte interno del Colegio.
	        </p>
		    </span>
          <p class="Estilo5">&nbsp;</p>
		  <p class="Estilo5">Atentamente a  usted.<br>
		  </p>
		  <p align="center" class="Estilo5"><strong><?=$nombre_director ?></strong><br>
	  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Director<? if($institucion!=770){?>(a)<? } ?><br>
		  </p>
		  <hr></td>
	  </tr>
</table>
	
	<?
	
	if  ($ns > 1){ 
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	}
	?>
	
    <?
	$i++;
 } ?>

</body>
</html>
<? pg_close($conn);?>