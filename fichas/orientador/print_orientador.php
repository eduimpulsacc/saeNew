<? 
require('../../util/header.inc');
require('../../util/LlenarCombo.php3');
require('../../util/SeleccionaCombo.inc');
require_once('includes/widgets/widgets_start.php');
//setlocale("LC_ALL","es_ES");
$institucion	=$_INSTIT;
$ano			=$_ANO;
$curso			=$c_curso; 
$alumno		    =$c_alumno;
$periodo		=$c_periodos;

if (isset($cmb_ano)){
    $_SESSION['_ANO'] = $cmb_ano;
	$ano              = $cmb_ano;
}	


if (isset($cancelar)){  // si existe el boton agregar
     // cambiamos el modo a agregar
	 $_SESSION['frmModo'] = "mostrar";
}

if (isset($agregar)){  // si existe el boton agregar
     // cambiamos el modo a agregar
	 $_SESSION['frmModo'] = "agregar";
}


// aqui consulta para agregar la ionformacion

if (isset($guardar)){
    // consulto las variables
	/*echo "fecha_inicio: $fecha_inicio <br>";
    echo "observacion: $observacion <br>";
	echo "cmb_alumno: $cmb_alumno <br>";
	echo "ano: $ano <br>";  */
	
	// verifico si existe antes de guardar
	$qry1 = "select * from ficha_psicologica where fechacontrol = '".trim($fecha_inicio)."' and medicamento = '".trim($medicamento)."' and tratamiento = '".trim($tratamiento)."' and diagnostico = '".trim($diagnostico)."' and observacion = '".trim($observacion)."' and rut_alum = '".trim($rut_alum)."' and id_ano = '".trim($ano)."'";
	$res1 = @pg_Exec($conn,$qry1);
	$nres1 = @pg_numrows($res1);
	
	if ($nres1==0){
	   // inserto
    
		// guardo en la tabla
		$qry = "insert into ficha_psicologica (fechacontrol,observacion,rut_alum,id_ano,tipo,rut_emp)
		values ('$fecha_inicio','$observacion','$cmb_alumno','$ano','2','".trim($_EMPLEADO)."')";
		$result =  pg_Exec($conn,$qry);
		
		//ya insertamos ahora cambio el modo
    }else{
	    // no inserto por que ya existe
	}			
	 
	
	$_SESSION['frmModo'] = "mostrar";
}


?>
<SCRIPT language="JavaScript">
function enviapag(form){
   if (form.cmb_curso.value!=0){
	  form.cmb_curso.target="self";
	  form.cmb_ano.target="self";
      form.action = 'ficha_orientador.php';
	  form.submit(true);
   }	
}

 function enviapag2(form){
     var ano, frmModo; 
	 ano2=form.cmb_ano.value;
	 		
 	 if (form.cmb_ano.value!=0){
	    form.cmb_ano.target="self";
		//pag="../../seteaAno.php3?caso=10&pa=2&ano="+ano2+"&frmModo="+frmModo
		form.action = 'ficha_orientador.php';
		form.submit(true);	
	 }		
 }


function MM_goToURL() { //v3.0
    var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	   for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
									
</script>
<?php 
	
	
	$_POSP = 4;
	$_bot = 8;
	
	$sw				=0;
	$rdb = $institucion;
	$ramo_religion = 0;
	if ($curso==0) $sw = 1;
	if ($periodo==0) $sw = 1;
	if ($sw == 1) //exit;
	     $sql = "select  * from periodo where id_ano = ".$ano." and id_periodo = ".$periodo." order by id_periodo" ;
	     $result1 =@pg_Exec($conn,$sql);
	     if (!$result1) 
	         {
	          //error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
	      }
	      else
	     {
		 if (pg_numrows($result1)!=0)
	           {
		  $fila1 = @pg_fetch_array($result1,0);	
		  if (!$fila1)
		  {
			  //error('<B> ERROR :</b>Error al acceder a la BD. (PERIODOS)</B>');
			  //exit();
		  }
	  }
	}
	//-----------------------
	$sql = "select count(id_periodo) as num_periodos from periodo where id_ano = $ano";
	$resultPeri =@pg_Exec($conn,$sql);	
    $fila1Peri = @pg_fetch_array($resultPeri,0);		
	$num_periodos = $fila1Peri['num_periodos'];
	if ($num_periodos==2) $tipo_per = "SE";
	if ($num_periodos==3) $tipo_per = "TR";	
	//-----------------------
	$sql_ano = "select * from ano_escolar where id_ano = ". $ano;
	$result_ano =@pg_Exec($conn,$sql_ano);
	$fila_ano = @pg_fetch_array($result_ano,0);	
	$nro_ano = $fila_ano['nro_ano'];
	//-----------------------

	function Nombre($paterno,$materno,$nombres){
		$Nombres = strtoupper($nombres." ".$paterno." ".$materno);
		echo $Nombres;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>
<style type="text/css">
<!--
.Estilo2 {
	font-size: 9px;
	font-weight: bold;
}
-->
</style>
</head>

</head>
 <body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../cortes/b_ayuda_r.jpg','../../cortes/b_info_r.jpg','../../cortes/b_mapa_r.jpg','../../cortes/b_home_r.jpg')">
 

                          </center>
                          
                          <!-- FIN CUERPO DE LA PAGINA -->
                          <!-- INICIO FORMULARIO DE BUSQUEDA -->
 
  <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
//------------------
$sql_peri = "select * from periodo where id_ano = ".$ano;
$result_peri = pg_exec($conn,$sql_peri);

//------------------
?>
  <center>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td width="100%">
        <table width="70%" height="43" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="53%" class="tableindex">Ficha Orientador </td>
    </tr>
          <tr>
            <td height="27">&nbsp;</td>
    </tr>
  </table>
  


        <!-- inicio cuerpo de la pagina -->
		                           
						
							<br>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td>
								<table width="70%" border="1" cellspacing="0" cellpadding="0" align="center">
								  <tr>
									<td class="cuadro02">Fecha de Control </td>
									<td class="cuadro01">
									 <label>
									  <input name="fecha_inicio" type="widget" class="texto" id="fecha_inicio" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value="<? echo date("Y-m-d");?>	"/>
									</label></td>
								  </tr>
								  
							
								  
								  
								  <tr>
									<td class="cuadro02">Observaci&oacute;n</td>
									<td class="cuadro01"><label>
									  <textarea name="observacion" cols="40" rows="5" id="observacion"></textarea>
									</label></td>
								  </tr>
								  <tr>
									<td colspan="2"><div align="center">
									  <label></label>
									  <label></label>
									</div></td>
								  </tr>
								</table>
								</td>
					         </tr>
				           </table>
					 
						
                      <!-- fin cuerpo de la pagina -->  
					  
					          
						  
						  
				
</body>
</html>
<? require_once("includes/widgets/widgets_end.php"); ?>