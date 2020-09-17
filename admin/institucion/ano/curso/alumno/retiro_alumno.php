<?php require('../../../../../util/header.inc');?>
<?php 
	$institucion	=$_INSTIT;
	$frmModo		=$_FRMMODO;
	$ano			=$_ANO;
	$_POSP          =5;
	$_bot           =5;
	$alumno         = $_ALUMNO;
	$curso			=$_CURSO;
	
?>
<?php
	$qry="SELECT * FROM ALUMNO WHERE RUT_ALUMNO='".trim($alumno)."'";
	$result =@pg_Exec($conn,$qry);
	if (!$result) {
		error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$qry);
	}else{
		if (pg_numrows($result)!=0){
			$fila = @pg_fetch_array($result,0);	
			if (!$fila){
				error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
				exit();
			}else{
			   $nombre_alumno  = $fila['nombre_alu'];
			   $nombre_alumno .= $fila['ape_pat'];
			   $nombre_alumno .= $fila['ape_mat'];
		    }	   
		}
	}
	
   if ($r == "si"){
         $qry="SELECT curso.cod_decreto, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, tipo_ensenanza.cod_tipo as tpe FROM tipo_ensenanza INNER JOIN curso ON tipo_ensenanza.cod_tipo = curso.ensenanza WHERE (((curso.id_curso)=".$curso."))";
											$result =@pg_Exec($conn,$qry);
											if (!$result) {
												error('<B> ERROR :</b>Error al acceder a la BD. (7)</B>');
											}else{
												if (pg_numrows($result)!=0){
													$fila1 = @pg_fetch_array($result,0);	
													if (!$fila1){
														error('<B> ERROR :</b>Error al acceder a la BD. (8)</B>');
														exit();
													}
													
													if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
														$curso = "Primer Nivel - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else if ( ($fila1['grado_curso']==1) and (($fila1['cod_decreto']==121987) or ($fila1['cod_decreto']==1521989)) ){
													    $curso = "Primer Ciclo - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else if ( ($fila1['grado_curso']==1) and ($fila1['cod_decreto']==1000)){
														$curso = "Sala Cuna - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
														
													}else if ( ($fila1['grado_curso']==2) and (($fila1['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
														$curso = "Segundo Nivel - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==121987) ){
														$curso = "Segundo Ciclo - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
														
													}else if ( ($fila1['grado_curso']==2) and ($fila1['cod_decreto']==1000)){
														$curso = "Nivel Medio Menor - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else if ( ($fila1['grado_curso']==3) and (($fila1['cod_decreto']==771982) or ($fila1['cod_decreto']==461987)) ){
													    $curso = "Tercer Nivel - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else if ( ($fila1['grado_curso']==3) and ($fila1['cod_decreto']==1000)){
														$curso = "Nivel Medio Mayor - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else if ( ($fila1['grado_curso']==4) and ($fila1['cod_decreto']==1000)){
														$curso = "Transición 1er Nivel - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else if ( ($fila1['grado_curso']==5) and ($fila1['cod_decreto']==1000)){
														$curso = "Transición 2do Nivel - ";
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}else{
													    $curso =   $fila1['grado_curso'];
														$curso .=  trim($fila1['letra_curso']);
														$curso .=  trim($fila1['nombre_tipo']);
														
													}
												}
											}		


													//echo trim($fila1['grado_curso'])." ".trim($fila1['letra_curso'])." ".trim($fila1['nombre_tipo'])"; 
													
      // TOMO LOS VALORES A DESPLEGAR //
	  $q1 = "select * from institucion where rdb = '$institucion'";
	  $r1 = pg_Exec($conn,$q1);
	  if (!$r1){
	      echo "Error, no he tomado intitución";
		  exit();
	  }else{
	      $f1 = pg_fetch_array($r1,0);
		  $nom_insti = $f1['nombre_instit'];
	  }
	  
	  $q2 = "select * from matricula where rut_alumno = '$alumno'";
	  $r2 = pg_Exec($conn,$q2);
	  if (!$r2){
	      echo "Error, no he tomado matricula";
		  exit();
	  }else{
	      $f2 = pg_fetch_array($r2,0);
		  $fecha_mat = $f2['fecha'];
		  $fecha_ret = $f2['fecha_retiro'];
		  $dd = substr($fecha_mat,8,2);
		  $mm = substr($fecha_mat,5,2);
		  $aa = substr($fecha_mat,0,4);
		  $fecha_mat = "$dd-$mm-$aa";
		  $dd = substr($fecha_ret,8,2);
		  $mm = substr($fecha_ret,5,2);
		  $aa = substr($fecha_ret,0,4);
		  $fecha_ret = "$dd-$mm-$aa";
		  
	  }
	  // verifico si tiene notas
	  
	  $q3 = "SELECT ano_escolar.nro_ano, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, alumno.ape_pat, alumno.ape_mat, alumno.nombre_alu,institucion.nombre_instit ";
			$q3 = $q3 . "FROM institucion, ano_escolar, alumno, curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
			$q3 = $q3 . "WHERE (((institucion.rdb)=".$institucion.") AND ((ano_escolar.id_ano)=".$ano.") AND ((curso.id_curso)=".$curso.") AND ((alumno.rut_alumno)='".$alumno."'));";
			
	     $r3 =@pg_Exec($conn,$q3);
			if (!$r3) 
			{
				error('<B> ERROR :</b>Error al acceder a la BD. (10)</B>');
			}
			else
			{
				if (pg_numrows($r3)!=0)
				{
					$f3 = @pg_fetch_array($r3,0);	
					if (!$f3)
					{
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
						exit();
					}
				}
			}		
		  	  
		  $q4="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO=".$ano;
		  $r4 =@pg_Exec($conn,$q4);
		  if (!$r4) {
			  error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
		  }else{
			  if (pg_numrows($r4)!=0){
				 $f4 = @pg_fetch_array($r4,0);	
				 if (!$f4){
					error('<B> ERROR :</b>Error al acceder a la BD. (6)</B>');
				    exit();
				 }
				 $ano_act = trim($f4['nro_ano']);
			  }
		  }	  	  
	  
	  
	  
	  $fecha = time();
	  $dd = date(d);
	  $mm = date(m);
	  $aa = date(Y);
	  $fechahoy = "$dd-$mm-$aa";  
	  	  
		  
	  echo "<script>windows.close </script>";	  
	  	  	  													
	  header('Content-type: application/vnd.ms-excel');
      header("Content-Disposition: attachment; filename=alumno_$fechahoy.xls");												
													
   
      echo '
	  
	  
	  
	  
	  ';		
   
   }
   
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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


function deados(url1, url2) { window.location.href= url2; //window.location.href= url2;
  window.open(url1);
 }
//-->
</script>
					

<script language="javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>	
<link href="../../../../../estilos.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.Estilo1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 16px;
}
.Estilo2 {
	color: #FF0000;
	font-weight: bold;
}
.Estilo4 {font-size: 12px}
.Estilo5 {
	font-size: 18px;
	font-weight: bold;
}
.Estilo6 {font-size: 14px}
.Estilo7 {color: #FF6633}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top">
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7">  
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3">
				
				<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?  include("../../../../../menus/menu_lateral.php"); ?></td>
                      <td width="73%" align="left" valign="top">
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="10" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td valign="top">
								  
								  <!--inicio codigo nuevo pagina con fallas de tablas-->
								  
							
									  


				   			  
								  <!--fin codigo nuevo  paginas con fallas de tablas--->
								  <table width="90%" border="1" align="center" cellpadding="5" cellspacing="0" bordercolor="#FF0000">
                                    <tr>
                                      <td><div align="center" class="Estilo1"><span class="Estilo2">&iexcl; AVISO IMPORTANTE !</span><br>
                                          <br>
                                          <span class="Estilo4">AL RETIRAR UN ALUMNO MATRICULADO CON FECHA MENOR A MES DE MAYO DE CADA A&Ntilde;O ESCOLAR, SE ELIMINAR&Aacute; TODA SU INFORMACI&Oacute;N DE ESTE A&Ntilde;O. PODR&Aacute; GUARDAR LA INFORMACION ELIMINADA EN UN ARCHIVO EXCEL QUE SE GENERAR&Aacute; AUTOMATICAMENTE SI CONTIN&Uacute;A CON EL PROCESO.<br>
                                          <br>
                                          <span class="Estilo5"><span class="Estilo6">&iquest;ESTA SEGURO DE RETIRAR AL ALUMNO <span class="Estilo7"><?=$nombre_alumno ?></span> DE ESTE A&Ntilde;O ESCOLAR?</span><br>
                                            </span><br>
                                            <a href="alumno.php3?caso=1&r=si">
                                            <label>
                                            <input name="Submit" class="botonXX" type="button" onClick="MM_goToURL('parent','alumno.php3?caso=1&amp;r=si');return document.MM_returnValue" value="SI, RETIRAR ALUMNO">
                                            </label>
                                            </a> 
                                            <label>
                                            <input name="Submit2" class="botonXX" type="button" onClick="MM_goToURL('parent','alumno.php3?caso=1&amp;r=no');return document.MM_returnValue" value="CANCELAR RETIRO">
                                            </label>
                                            <br>
                                        <br>
                                        <a href="alumno.php3?caso=1"></a></span> </div></td>
                                    </tr>
                                  </table></td>
                                </tr>
                              </table>
						    </td>
                          </tr>
                        </table>
					</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
<? pg_close($conn); ?>
</body>
</html>
