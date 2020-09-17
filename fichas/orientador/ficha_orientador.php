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
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../cabecera/menu_superior.php");
				?>				 
				
				</td>
				</tr>
				</table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						$menu_lateral=3;
						include("../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
 <?

 if  (($cont_alumnos - $cont_paginas)<>1){ 
	echo "<H1 class=SaltoDePagina></H1>";
} ?>
                          </center>
                          
                          <!-- FIN CUERPO DE LA PAGINA -->
                          <!-- INICIO FORMULARIO DE BUSQUEDA -->
  <form method="post" action="ficha_orientador.php">
  <input type="hidden" name="flag" value="<? echo $flag;?>">
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
        <table width="100%" height="43" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td width="53%" class="tableindex">Ficha Orientador </td>
    </tr>
          <tr>
            <td height="27">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td colspan="5" class="textosmediano"><br>
                 <?    $qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
				       $result =@pg_Exec($conn,$qry);
				       if (!$result) {
					        error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				       }else{
					         if (pg_numrows($result)!=0){
						         $filann = @pg_fetch_array($result,0);	
						         if (!$filann){
							          error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							          exit();
						         }  
							 } ?>	 
					
					 
					 <span class="textosimple">Año</span>
                    <div align="left"> 
                      <font size="1" face="arial, geneva, helvetica">
					 			 
                        <select name="cmb_ano" class="ddlb_x" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);$i++){
						      $filann = @pg_fetch_array($result,$i); 
							  $id_ano  = $filann['id_ano'];  
   		                      $nro_ano = $filann['nro_ano'];
							  $situacion = $filann['situacion'];
							  if ($situacion == 0){
							     $estado = "Cerrado";
							  }
							  if ($situacion == 1){
							     $estado = "Abierto";
							  }	 	 
			                  if (($id_ano == $cmb_ano) or ($id_ano == $ano)){
		                          echo "<option value=".$id_ano." selected>".$nro_ano."&nbsp;(".$estado.")</option>";
		                      }else{	    
		                          echo "<option value=".$id_ano.">".$nro_ano."&nbsp;(".$estado.")</option>";
                              }
							} ?>
							</select>
							</font>
							</div>
					 <? } ?>		
							
					</td>
				</tr>
				
				
				
				
				<tr>
                  <td colspan="5" class="textosmediano"><br>
                    <span class="textosimple">Curso</span>
                    <div align="left"> 
                      <font size="1" face="arial, geneva, helvetica">
                        <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
                          <option value=0 selected>(Seleccione Curso)</option>
                          <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++){
			  $fila = @pg_fetch_array($resultado_query_cue,$i); 
			  if ($fila["id_curso"]==$cmb_curso){
					if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
						echo "<option selected value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
						echo "<option selected value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
						echo "<option selected value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
						echo "<option selected value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
						echo "<option selected value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
						echo "<option selected value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
						echo "<option selected value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
						echo "<option selected value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
						echo "<option selected value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
						echo "<option selected value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else{
					echo "<option selected value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}		  
			  }else{
					if (($fila['grado_curso']==1) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987))){
						echo "<option value=".$fila['id_curso'].">"."PN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==1) and (($fila['cod_decreto']==121987) or ($fila['cod_decreto']==1521989)) ){
						echo "<option value=".$fila['id_curso'].">"."PC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==1) and ($fila['cod_decreto']==1000)){
						echo "<option value=".$fila['id_curso'].">"."SL - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==2) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
						echo "<option value=".$fila['id_curso'].">"."SN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==121987) ){
						echo "<option value=".$fila['id_curso'].">"."SC - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==2) and ($fila['cod_decreto']==1000)){
						echo "<option value=".$fila['id_curso'].">"."NMME - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==3) and (($fila['cod_decreto']==771982) or ($fila['cod_decreto']==461987)) ){
						echo "<option value=".$fila['id_curso'].">"."TN - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==3) and ($fila['cod_decreto']==1000)){
						echo "<option value=".$fila['id_curso'].">"."NMMA - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==4) and ($fila['cod_decreto']==1000)){
						echo "<option value=".$fila['id_curso'].">"."T1N - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else if ( ($fila['grado_curso']==5) and ($fila['cod_decreto']==1000)){
						echo "<option value=".$fila['id_curso'].">"."T2N  - ". $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}else{
					echo "<option value=".$fila['id_curso'].">".$fila["grado_curso"] . "-" . $fila["letra_curso"]." ".$fila['nombre_tipo']."</option>";
					}		
			  }
			} ?>
                          </select>
  </font>	  </div>
	    <!--    <td width="199"><div align="right">
      <input name="cb_ok" type="button" class="botonX" onmouseover=this.style.background='FFFFD7';this.style.color='003b85' onmouseout=this.style.background='#5c6fa9';this.style.color='ffffff' id="cb_ok" onClick="MM_goToURL('parent.frames[\'mainFrame\']','NotasParciales_3y4.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&c_periodos='+cmb_periodos.options[cmb_periodos.selectedIndex].value);return document.MM_returnValue" value="Buscar"> --></td>
               </tr>
                <tr>
                  <td colspan="5" class="textosmediano"><br>
                    <span class="textosimple">Alumno</span>
                    <div align="left">
                      
                      <select name="cmb_alumno" class="ddlb_9_x" onChange="enviapag(this.form);">
                        <option value=0 selected>(Seleccione un Alumno)</option>
                        <?
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; $i++){
			$fila = @pg_fetch_array($result,$i);?>
                        <?
			if ($fila["rut_alumno"] == $cmb_alumno){
			   ?>
                        <option value="<? echo $fila["rut_alumno"]; ?>" selected><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
                        <?
			}else{
			   ?>
                        <option value="<? echo $fila["rut_alumno"]; ?>"><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>   	
                        <?
		    }		
			
		}
		?>
                        </select>
                      </div></td>
      </tr>
                <tr>
                  <td width="39" class="textosmediano">&nbsp;</td>
      <td width="100%" colspan="4"><div align="right">
        
        <?
				
		 if (($_PERFIL==0) OR ($_PERFIL==21) OR ($_PERFIL==20)) {
		        if ($frmModo=="agregar"){ ?>		       
		            <input name="guardar" type="submit" class="botonXX" id="guardar" value="GUARDAR">
					<input type="submit" name="cancelar" value="CANCELAR" class="botonXX">
				<?
				}
				if (($frmModo=="mostrar") OR ($frmModo==NULL)){ 
				     if (($cmb_alumno==NULL) OR ($cmb_alumno < 1)){ 
					      // no agrega por que no tiene ningun alumno seleccionado
					 }else{	  
					     ?>		       
		                 <input type="submit" name="agregar" value="AGREGAR" class="botonXX">
					<? } ?>	 
			<?	} ?> 	   
               
       <? } ?>
        </div></td>
      </tr>
  </table>
  
	</td>
    </tr>
  </table>
  
<!--	</td>
    </tr>
  </table>  -->
  </center>
 
				   
<!-- FIN FORMULARIO DE BUSQUEDA -->


        <!-- inicio cuerpo de la pagina -->
		             <?
						if ($frmModo!="agregar"){ 
						
						   if (($cmb_alumno==NULL) OR ($cmb_alumno < 1)){
						        // no muestra listado
						   }else{ ?><br>
								<table width="100%" border="1" cellspacing="0" cellpadding="5">
								  <tr>
									<td width="15%" class="cuadro02">Fecha</td>
									<!--<td width="15%" class="cuadro02">Medicamnento</td>
									<td width="15%" class="cuadro02">Tratamiento</td>
									<td width="15%" class="cuadro02">Diagnostico</td>-->
									<td width="40%" class="cuadro02">Observaci&oacute;n</td>
								  </tr>
								  <?
								  // rescato la informacion de la tabla 
								  $qry2 = "select * from ficha_psicologica where rut_alum = '".trim($cmb_alumno)."' and tipo = '2'";
								  $res2 = pg_Exec($conn,$qry2);
								  $nres = pg_numrows($res2);
								  
								  if ($nres>0){
									  $i = 0;
									  while ($i < $nres){
											  $fres = pg_fetch_array($res2,$i);
											  $fecha_inicio = $fres['fechacontrol'];
											  $medicamento  = $fres['medicamento'];
											  $tratamiento  = $fres['tratamiento'];
											  $diagnostico  = $fres['diagnostico'];
											  $observacion  = $fres['observacion'];
											  
											  $dd = substr($fecha_inicio,8,2);
											  $mm = substr($fecha_inicio,5,2);
											  $aa = substr($fecha_inicio,0,4);
											  
											  $fecha_inicio = "$dd-$mm-$aa";										  
											  
											  ?>						  
											  <tr>
												 <td class="cuadro01"><div align="left">
													 <?=$fecha_inicio ?>
												  </div></td>
												 <!-- <td class="cuadro01"><div align="left">
													 <?=$medicamento ?>
												  </div></td>
												  <td class="cuadro01"><div align="left">
													 <?=$tratamiento ?>
												  </div></td>
												  <td class="cuadro01"><div align="left">
													 <?=$diagnostico ?> -->
												  </div></td>
												  <td class="cuadro01"><?=$observacion ?></td>
											  </tr>
										  <?
										  $i++;
								      }
							      }
							} 	  
							?> 						   
                              </table>
							  
							  
							 
					<? }else{ ?>                       
						
							<br>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td>
								<table width="100%" border="1" cellspacing="0" cellpadding="0">
								  <tr>
									<td class="cuadro02">Fecha de Control </td>
									<td class="cuadro01">
									 <label>
									  <input name="fecha_inicio" type="widget" class="texto" id="fecha_inicio" size="12" maxlength="10"  subtype="wcalendar" format="%Y-%m-%d" skin="blue" language="es" label="..." mondayfirst="true" singleclick="true"  readonly="true" value="<? echo date("Y-m-d");?>	"/>
									</label></td>
								  </tr>
								  
							 <!--	  <tr>
									<td class="cuadro02">Medicamento</td>
									<td class="cuadro01">
									 <label>
									 <input name="medicamento" type="text" id="medicamento" size="40">
								    </label></td>
								  </tr>
								  
								  <tr>
									<td class="cuadro02">Tratamiento</td>
									<td class="cuadro01">
									 <label>
									 <input name="tratamiento" type="text" id="tratamiento" size="40">
								    </label></td>
								  </tr>
								  
								  <tr>
									<td class="cuadro02">Diagnóstico</td>
									<td class="cuadro01">
									 <label>
									 <input name="diagnostico" type="text" id="diagnostico" size="40">
								    </label></td>
								  </tr>   -->
								  
								  
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
					   <? } ?>		
							
						
	      </form>					
						
                      <!-- fin cuerpo de la pagina -->  
					  
					          
						  
						  
					  </td>
                    </tr>
                        </table></td>
              </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema de Administraci&oacute;n Escolar - 2005 </td>
                    </tr>
            </table></td>
        </tr>
            </table>
    </td>
          <td width="53" height="722" align="left" valign="top" background="../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
   </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? require_once("includes/widgets/widgets_end.php"); ?>