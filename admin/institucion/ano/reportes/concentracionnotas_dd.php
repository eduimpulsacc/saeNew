<?php require('../../../../util/header.inc');

///////////////////
$institucion = $_INSTIT;
$ano			=$_ANO;

///Sacar nro año actual
$sql_ano_actual = "select nro_ano from ano_escolar where id_ano = '$_ANO'";
$res_ano_actual = @pg_Exec($conn, $sql_ano_actual);
$fil_ano_actual = @pg_fetch_array($res_ano_actual);
$nro_ano = $fil_ano_actual['nro_ano'];

/// sacar los anos anteriores
$sql_ano4 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano4 = @pg_Exec($conn, $sql_ano4);
$fil_ano4 = @pg_fetch_array($res_ano4);
$ano_4    = $fil_ano4['id_ano'];
$nro_ano--;

$sql_ano3 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano3 = @pg_Exec($conn, $sql_ano3);
$fil_ano3 = @pg_fetch_array($res_ano3);
$ano_3    = $fil_ano3['id_ano'];
$nro_ano--;

$sql_ano2 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano2 = @pg_Exec($conn, $sql_ano2);
$fil_ano2 = @pg_fetch_array($res_ano2);
$ano_2    = $fil_ano2['id_ano'];
$nro_ano--;

$sql_ano1 = "select id_ano from ano_escolar where id_institucion = '$_INSTIT' and nro_ano = '$nro_ano'";
$res_ano1 = @pg_Exec($conn, $sql_ano1);
$fil_ano1 = @pg_fetch_array($res_ano1);
$ano_1    = $fil_ano1['id_ano'];
$nro_ano--;

if (isset($cb_ok)){  // comprobar si existe boton buscar
	 
	 
	 $rut_alumno=$cmb_alumno;
	 $whe_conceptos=	"and promedio not in ('I','S','B','MB')";
	
	 function imprime_arreglo($arreglo){
	    echo "<pre>";
	    print_r($arreglo);
	    echo "</pre>";
     }
     
	 $query_ins_ano="select rdb,dig_rdb, nombre_instit from institucion as ins, ano_escolar as ano where ins.rdb='$_INSTIT' and  ano.id_ano='$_ANO'"; //revisar
     $row_ano=pg_fetch_array(pg_exec($conn,$query_ins_ano));


     $q1 = "select cargo, rut_emp from trabaja where rdb = '".trim($institucion)."' and (cargo=1 OR cargo=23)";
     $r1 = @pg_Exec($conn,$q1);
     $n1 = @pg_numrows($r1);

	
	 $f1 = @pg_fetch_array($r1,0);
	 $cargo = $f1['cargo'];
		
	 if ($cargo==1){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "DIRECTOR(a)";
	 }
	 if ($cargo==23){
		$cargo_dir  = "rector(a)";
		$cargo_dir2 = "RECTOR(a)";
	 }
	
	 if ($institucion==2278){
		$cargo_dir  = "director(a)";
		$cargo_dir2 = "DIRECTOR(a)";
	 }
	 if ($institucion==9239){
		$cargo_dir  = "Directora";
		$cargo_dir2 = "Directora";
	 }
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
table{font-family:Verdana, Arial, Helvetica, sans-serif;
font-size:9px;
}
td{
	font-family:Verdana, Arial, Helvetica, sans-serif;
	font-size:10px;
	font-style: normal;
	font-weight: normal;
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
.Estilo1 {
	color: #FF0000;
	font-weight: bold;
}
-->
    </style>
	
<SCRIPT language="JavaScript">
<!--



function imprimir(){
Element = document.getElementById("botones");
Element.style.display='none';
Element = document.getElementById("motor");
Element.style.display='none';
Element = document.getElementById("menu");
Element.style.display='none';
window.print();
Element = document.getElementById("botones");
Element.style.display='';
Element = document.getElementById("motor");
Element.style.display='';
Element = document.getElementById("menu");
Element.style.display='';

}
function enviapag(form){
			if (form.cmb_curso.value!=0){
				form.cmb_curso.target="self";
				form.action = 'concentracionnotas_dd.php';
				form.submit(true);
	
				}	
			}
			function MM_goToURL() { //v3.0
			  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
			  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
			}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}
function window_open(url,ancho,alto){
var opciones="left=100,top=100,width="+ancho+",height="+alto+",scrollbars=yes,resizable=yes,status=yes", i= 0;
 window.open(url,"aa",opciones); 
 }

//-->
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

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
       function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../seteaAno.php3?caso=10&pa=14&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }


</script>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../cortes/b_ayuda_r.jpg','../../../../cortes/b_info_r.jpg','../../../../cortes/b_mapa_r.jpg','../../../../cortes/b_home_r.jpg')"  >

 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../../cabecera/menu_superior.php");
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
						include("../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top">
					  
					  
					  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top">
							
							 <form name="form1" method="post" action="print_concentracionnotas_dd.php" target="_blank">
                              <table width="100%" border="2" cellpadding="0" cellspacing="0" class="cajaborde" bordercolor="#990000">
                                <tr> 
                                  <td>							

<? 


			

if (isset($cb_ok)){ 

            $sql_ins = "SELECT institucion.nombre_instit, institucion.nu_resolucion, institucion.fecha_resolucion, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
			$sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
			$sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion.")); ";
			$result_ins =@pg_Exec($conn,$sql_ins);
			$fila_ins = @pg_fetch_array($result_ins,0);	
			$ins_pal = $fila_ins['nombre_instit'];
			$ciudad = $fila_ins['nom_pro'];
			$fono = $fila_ins['telefono'];
			$direc = $fila_ins['calle'].$fila_ins['nro'];
			$region = $fila_ins['nom_reg'];
			$provincia = $fila_ins['nom_pro'];
			$comuna = $fila_ins['nom_com'];
			$resolucion = $fila_ins['nu_resolucion'];
			$fecha_resolucion = $fila_ins['fecha_resolucion'];
			$separa_fecha = explode("-",$fecha_resolucion);
			$separa_ano = $separa_fecha[0];
			$separa_mes = $separa_fecha[1];
			$separa_dia = $separa_fecha[2];
			$fecha_resolucion = $separa_dia."-".$separa_mes."-".$separa_ano;
			$fecha_convertida = fecha_espanol($fecha_resolucion);


			$query_decreto="select plan.* from  curso , plan_estudio as plan  where curso.id_curso='$cmb_curso' and plan.cod_decreto=curso.cod_decreto";
			$result_decreto=pg_exec($conn,$query_decreto);
			$num_decreto=pg_numrows($result_decreto);
			if ($num_decreto>0){
				$row_decreto=pg_fetch_array($result_decreto);
				$arreglo=explode(" ",$row_decreto[nombre_decreto]);
				$decreto_numero=$arreglo[0];
				$decreto_ano=$arreglo[2];
			}
		
		   
		?>
		<div id="botones">
		<table width="820"><tr><td  align="right">
		<table><tr><td>
		
	    <input name="button32" type="button" class="botonXX" onClick="javascript: window_open( 'concentracion_notas/eliminar.php?rut_alumno=<? echo $rut_alumno;?>&cmb_curso=<? echo $cmb_curso;?>',400,550);"  value="ELIMINAR" />
		
		<input name="button32" type="button" class="botonXX" onClick="javascript: window_open( 'concentracion_notas/ingreso.php?rut_alumno=<? echo $rut_alumno;?>&cmb_curso=<? echo $cmb_curso;?>',400,550);"  value="INGRESAR" />
		
	    <input name="button32" type="button" class="botonXX" onClick="javascript: window_open( 'concentracion_notas/editar.php?rut_alumno=<? echo $rut_alumno;?>&cmb_curso=<? echo $cmb_curso;?>',500,600);"  value="EDITAR" />
			
		</td><td><input name="button3" type="submit" class="botonXX"   value="IMPRIMIR" /></td></tr></table></td></tr></table>
		<input type="hidden" name="cmb_alumno" value="<?=$rut_alumno?>">
		<input type="hidden" name="cmb_curso" value="<?=$cmb_curso?>">
		</div>
		
  <?
		   
   if ($rut_alumno==0){
        $txt_alumno = " ";
   }else{
        $txt_alumno = " and rut_alumno = '$rut_alumno'";   
   }


		       
		  /// consulta para rescatar todos los alumnos
		  $sql_alumnos = "select rut_alumno from matricula where id_ano = '".$_ANO."' and bool_ar = '0' and id_curso = '".$cmb_curso."' $txt_alumno";
		  $res_alumnos = @pg_Exec($conn, $sql_alumnos);
		  $num_alumnos = @pg_numrows($res_alumnos);
		  
		  for ($i_alum=0; $i_alum < $num_alumnos; $i_alum++){
		      $fil_alumnos = @pg_fetch_array($res_alumnos,$i_alum);
			  $rut_alumno = $fil_alumnos['rut_alumno'];		   
		   
		   
		   
				   $query_alumno="select nombre_alu, ape_pat, ape_mat ,rut_alumno, dig_rut from alumno  where rut_alumno='$rut_alumno'";
				   $result_alumno=pg_exec($conn,$query_alumno);
				   $num_alumno=pg_numrows($result_alumno);
				   if ($num_alumno>0){
					   $row_alumno=pg_fetch_array($result_alumno);
				   }
				   $ramo_id=array();
				   $ramo_nombre=array();
				   $cod_subsector=array();
		
				   $query_matricula="select * from matricula as mat, ano_escolar as ano, curso as curso  where mat.rut_alumno='$rut_alumno' and mat.id_ano=ano.id_ano and curso.id_curso=mat.id_curso and mat.bool_ar = '0' and mat.id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by ano.nro_ano Desc";
				
				   $result_matricula=pg_exec($conn,$query_matricula);
				   $num_matricula=pg_numrows($result_matricula);
				   for ($i=0;$i<$num_matricula; ++$i){
					   $row_matricula=pg_fetch_array($result_matricula);
					   $curso_grado=$row_matricula[grado_curso];
					   $anos_id[$curso_grado]=$row_matricula[id_ano];
					   $grado_curso[$curso_grado]=$row_matricula[grado_curso];
					   $nro_ano[$curso_grado]=$row_matricula[nro_ano];
					   $aproxima[$curso_grado]=$row_matricula[truncado_per];
					   $curso_id[$curso_grado]=$row_matricula[id_curso];
					   $origen[$curso_grado]=1;
					
					   $query_tiene="select * from ramo r inner join tiene".$row_matricula[nro_ano]." t on t.id_ramo=r.id_ramo inner join subsector s on s.cod_subsector=r.cod_subsector inner join curso c on c.id_curso=r.id_curso where r.bool_ip = '1' and t.rut_alumno=".$rut_alumno." and (c.ensenanza=310 or c.ensenanza=410 or c.ensenanza=510 or c.ensenanza=610 or c.ensenanza=710 or c.ensenanza=810 or c.ensenanza=360 or c.ensenanza=460 or c.ensenanza=560 or c.ensenanza=660 or c.ensenanza=760 or c.ensenanza=860 or c.ensenanza=461 or c.ensenanza=561 or c.ensenanza=661 or c.ensenanza=761 or c.ensenanza=861 or c.ensenanza=361 ) order by r.id_orden";
					   $result_tiene=pg_exec($conn,$query_tiene);
					   $num_tiene=pg_numrows($result_tiene);
					   for ($s=0;$s<$num_tiene; ++$s){
						   $row_tiene=pg_fetch_array($result_tiene);
						   if (!in_array($row_tiene[cod_subsector],$cod_subsector)){
							   $ramo_id[]=$row_tiene[id_ramo];
							   $ramo_nombre[]=$row_tiene[nombre];
							   $ramo_modo_eval[]=$row_tiene[modo_eval];
							   $cod_subsector[]=$row_tiene[cod_subsector];
							   $cod_subsector_new[]=$row_tiene[id_orden];
							   $ramo_subobli[]=$row_tiene[sub_obli];
						   }
					   }						
				   }
						
				 $query_mat2="select * from concentracion_notas where rut_alumno='$rut_alumno'";
				 $result_mat2=pg_exec($conn,$query_mat2);
				 $num_mat2=pg_numrows($result_mat2);
				 for ($i=0;$i<$num_mat2; ++$i){
					 $row_mat2=pg_fetch_array($result_mat2);
					 $curso_grado=$row_mat2[curso];
					 $anos_id[$curso_grado]=$row_mat2[id_ano];
					 $grado_curso[$curso_grado]=$row_mat2[curso];
					 $origen[$curso_grado]=2;
			
					 ////////////////////////////////
					 $contador_acumulado = 0;
					 $contador_religion = 0;
					 $acumulo_promedio = 0;		
					 ////////////////////////////////
					$query_detalle="select * from concentracion_detalle where rut_alumno='$rut_alumno' and  curso=$row_mat2[curso]";
					
					$result_detalle=@pg_exec($conn,$query_detalle);
					$num_detalle=@pg_numrows($result_detalle);
					for ($ff=0;$ff<$num_detalle; ++$ff){
					   $row_detalle=pg_fetch_array($result_detalle);
					   if (!in_array($row_detalle[subsector],$cod_subsector)){
						  $cod_subsector[]=$row_detalle[subsector];
						  $query_ram="select * from subsector where cod_subsector='$row_detalle[subsector]'";
						  $result_ram=pg_exec($conn,$query_ram);
						  $num_ram=pg_numrows($result_ram);
						  if ($num_ram>0){			
							  $row_ram=pg_fetch_array($result_ram);
							  $ramo_nombre[]=$row_ram[nombre];
						  }			
					   }
					}
				}
						
				?>
		
		
		
		
		
		
		<table  width="640" align="center">
<? if($institucion!=770){ ?>
		<tr>
			<td>
<table width="700" border="0" cellspacing="0" cellpadding="0">
	  <tr>
	    <td width="78" rowspan="5" align="left" valign="top">
	</td>
		<td width="169" rowspan="5" align="left" valign="top">		
			<div align="center">
				<font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>REP&Uacute;BLICA DE CHILE</strong></font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> MINISTERIO DE EDUCACI&Oacute;N</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2"> DIVISI&Oacute;N DE EDUCACI&Oacute;N </font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">SECRETARIA REGIONAL MINISTERIAL</font><BR>
			    <font face="Verdana, Arial, Helvetica, sans-seri" size="-2">DE EDUCACI&Oacute;N </font><BR>
		    </div></td>
 <td width="98" rowspan="5"></td>			
		<td width="104"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">REGIÓN</font></td>
		<td width="10"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td width="241"><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $region?></strong></font></td>
	   

	  </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">PROVINCIA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>
		<?
		if ($_INSTIT==516){
		    echo "LA SERENA";
		}else{
		    if ($_INSTIT==12838){
			    echo "CALAMA";
		    }else{
			     if ($_INSTIT==12829){
		             echo "EL LOA";
			     }else{  	
		             echo $provincia;
			     }
		    }		 	 
		}
		?></strong></font></td>
	    </tr>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">COMUNA</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>
		<?
		if ($_INSTIT==12829){
		    echo "EL LOA";
		}else{  	
		    echo $comuna;
		}
		?></strong></font></td>
	    </tr>
		<? 	$sql_ano = "select id_ano, nro_ano from ano_escolar where id_ano = ".$ano;
			$result_ano =@pg_Exec($conn,$sql_ano);
			$fila_ano = @pg_fetch_array($result_ano,0);	
			$nro_anooo = $fila_ano['nro_ano'];?>
	  <tr>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2">A&Ntilde;O ESCOLAR</font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong>:</strong></font></td>
		<td><font face="Verdana, Arial, Helvetica, sans-seri" size="-2"><strong><? echo $nro_anooo?></strong></font></td>
	    </tr>
	  <tr>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    <td>&nbsp;</td>
	    </tr>
	</table>		
		
			</td>
		</tr>
<? } ?>		
		<tr><td>
		<table align="center">
			<tr><td align="center" class="textosimple"><h4><b>CERTIFICADO DE CONCENTRACION DE NOTAS</b>
			<? if($institucion==1756){
				echo "<br>"; 
				echo "Colegio Claudio Matte";
				}?>
			</h4>
			</td>
			</tr>
			<tr><td class="textosimple">RECONOCIDO OFICIALMENTE POR EL MINISTERIO DE EDUCACION DE LA REPUBLICA DE CHILE<br />
			SEGUN RESOLUCION Nº <? echo $resolucion;?> DEL <? echo strtoupper($fecha_convertida);?>&nbsp;ROL DE BASE DE DATOS Nº<b> <? echo $row_ano['rdb'];?>-<? echo $row_ano['dig_rdb'];?></b><BR />
			OTORGA EL PRESENTE CERTIFICADO DE CONCENTRACION DE CALIFICACIONES A <BR />
			DON(A) &nbsp;<b><? echo strtoupper($row_alumno['ape_pat']);?>&nbsp;<? echo strtoupper($row_alumno['ape_mat']);?>&nbsp;
			<? echo strtoupper($row_alumno['nombre_alu']);?></b> RUN <b><? echo $row_alumno['rut_alumno'];?>- <? echo $row_alumno['dig_rut'];?>
			
		
				</b></td>
			</tr>
		</table>
		</td></tr>
		<tr><td>
		<p>&nbsp;</p>
		<table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
			  <tr>
				<td width="70%" rowspan="2" valign="top" nowrap="nowrap" class="textosimple"><table width="100%" border="1" cellpadding="2" cellspacing="0">
                  <tr>
                    <td rowspan="2">SUBSECTOR ASIGNATURA Y MODULO </td>
                    <td colspan="5">CURSO DE ENSE&Ntilde;ANZA MEDIA </td>
                  </tr>
                  <tr>
				    <td width="1%" align="center" class="textosimple"><span class="Estilo1">Orden</span><br></td> 
                    <td width="40">1</td>
                    <td width="40">2</td>
                    <td width="40">3</td>
                    <td width="40">4</td>
                  </tr>
				  <!-- consulta para sacar los subsectores -->
				  <?
				  $acumulo_promedio = 0;
				  $contador_acumulado=0;
				
				  $sql_orden_sub = "select * from orden_concentracion inner join subsector on orden_concentracion.cod_subsector=subsector.cod_subsector  where orden_concentracion.rut_alumno = '$rut_alumno' order by orden_concentracion.orden";
				  $res_orden_sub = @pg_Exec($conn,$sql_orden_sub);
				  $num_orden_sub = @pg_numrows($res_orden_sub);
				  
				  if ($num_orden_sub==0){
				      /// hacemos un ciclo para insertar los subsectores
					   for ($i=0;$i<count($cod_subsector); ++$i){
					  		 $cod_subsector_aux = $cod_subsector[$i];
							 $nombre_sub = $ramo_nombre[$i];
							 $sql_inserta_orden = "insert into orden_concentracion (rdb, id_ano, cod_subsector, rut_alumno, orden) values ('".$_INSTIT."','999','$cod_subsector_aux','$rut_alumno','0')";
							 $res_inserta_orden = pg_Exec($conn, $sql_inserta_orden);
					   }
					   
					   /// hacemos denuevo la consulta anterior
					   $sql_orden_sub = "select * from orden_concentracion inner join subsector on orden_concentracion.cod_subsector=subsector.cod_subsector  where orden_concentracion.rut_alumno = '$rut_alumno' order by orden_concentracion.orden";
					  $res_orden_sub = @pg_Exec($conn,$sql_orden_sub);
					  $num_orden_sub = @pg_numrows($res_orden_sub);		 				  
				  }
				  
				  
				 $contador_campos=0;
		         for ($i=0;$i<count($cod_subsector); ++$i){				   
					   
					  /// consulta directa para sacar el orden de los subsectores actuales
					  $query_sub="select * from orden_concentracion where cod_subsector='$cod_subsector[$i]' and rut_alumno = '$rut_alumno'";
					  $result_sub=pg_exec($conn,$query_sub);
					  $fila_sub = pg_fetch_array($result_sub,0);			   
					 
					   
					   ?>					   
					   <tr>
						<td height="15"><? echo $ramo_nombre[$i];?></td>
						<td width="1%" align="center" class="textosimple"><label>
						<input name="orden_campo<?=$contador_campos?>" type="text"  size="2" value="<?=$fila_sub['orden'];?>">
						<input name="cso<?=$contador_campos?>" type="hidden"  value="<?=$cod_subsector[$i]?>">
					</label></td>
						<!-- determinar si este año se ingresó a manoo no,
						para ello consultamos el id_ramo en la tabla concentración detalle,
						cón el código del subsector -->
						<?
						$contador_campos++;
						
						
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '1' and subsector = '$cod_subsector[$i]'";
												
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub=="13"){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_1') and cod_subsector='$cod_subsector[$i]') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 						 
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '1')) and cod_subsector = '$cod_subsector[$i]') and rut_alumno = '$rut_alumno'";
								  /*
								  if ($_PERFIL==0){
								       echo "<br>".$sql_curso_1;								  
								  }
								  */
								  
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }					 
							 
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}		 	 
							 	 
						?>							  
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
						
						<?
						/// limpio promedio_sub
						$promedio_sub=0;
						// hacemos lomismo cambiando solo el grado del curso
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '2' and subsector = '$cod_subsector[$i]'";
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub  = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub==13){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_2') and cod_subsector='$cod_subsector[$i]') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     /*if ($_PERFIL==0){
								       echo "<br>".$sql_prom_sub;								  
								 }
								 */
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '2')) and cod_subsector = '$cod_subsector[$i]') and rut_alumno = '$rut_alumno'";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];	
								  							  
								  						 						  
							 }
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>							 
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
						
						<?
						/// limpio promedio_sub
						$promedio_sub=0;
						// hacemos lomismo cambiando solo el grado del curso
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '3' and subsector = '$cod_subsector[$i]'";
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub==13){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_3') and cod_subsector='$cod_subsector[$i]') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 $res_prom_sub = @pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = @pg_numrows($res_prom_sub);
							 if ($_PERFIL==0){
							     //echo "<br>$sql_prom_sub<br>";
							 }							 
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '3')) and cod_subsector = '$cod_subsector[$i]') and rut_alumno = '$rut_alumno'";
								  
								  if ($_PERFIL==0){
							          //echo "<br>$sql_curso_1<br>";
							      }
								  
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>						
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
						
						<?
						/// limpio promedio_sub
						$promedio_sub=0;
						// hacemos lomismo cambiando solo el grado del curso
						$sql_sub_curso = "select * from concentracion_detalle where rut_alumno = '$rut_alumno' and curso = '4' and subsector = '$cod_subsector[$i]'";
																		
						$res_sub_curso = @pg_Exec($conn,$sql_sub_curso);
						$num_sub_curso = @pg_numrows($res_sub_curso);
						if ($num_sub_curso>0){
						     /// existe, fue ingresado manualmente. Tomamos el promedio
							 $fil_sub_curso = @pg_fetch_array($res_sub_curso,0);
							 $promedio_sub = $fil_sub_curso['promedio'];
							 $subsector_sub = $fil_sub_curso['subsector'];
							 if ($subsector_sub==13){
							     $promedio_sub = $fil_sub_curso['religion'];
							 }							 
						}else{
						     // no existe el promedio se debe sacar de la tabla promedio_subsector
							 $sql_prom_sub = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from curso where id_ano = '$ano_4') and cod_subsector='$cod_subsector[$i]') and rut_alumno = '$rut_alumno' and promedio <> '0'";
							 
							 /*if ($_PERFIL==0){
							     echo "<br>$sql_prom_sub<br>";
							 }*/							 
							 $res_prom_sub = pg_Exec($conn,$sql_prom_sub);
							 $num_prom_sub = pg_numrows($res_prom_sub);
							 if ($num_prom_sub>0){
							     // existe, esta hecha la promocion
								 $fil_prom_sub = @pg_fetch_array($res_prom_sub,0);
								 $promedio_sub = $fil_prom_sub['promedio'];
								 
								 if ($_PERFIL==0){
							          //echo "p: $promedio_sub  <br>";
							     }
							 }else{							 
							      /// es posible que esté en otro establecimiento dentro del sistema
								  /// buscar el rut del alumno en matrícula cuando el curso tengra grado 1 y tipo de enseñanza > 300				  
								  $sql_curso_1 = "select promedio from promedio_sub_alumno where id_ramo in (select id_ramo from ramo where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '4')) and cod_subsector = '$cod_subsector[$i]') and rut_alumno = '$rut_alumno'";
								  $res_curso_1 = @pg_Exec($conn,$sql_curso_1);
								  $fil_curso_1 = @pg_fetch_array($res_curso_1,0);
								  $promedio_sub = $fil_curso_1['promedio'];							 						  
							 }
						}
						if ($promedio_sub>0 and $promedio_sub!=NULL){
						    // aacumular para ponderacion remde  //
							$acumulo_promedio = $acumulo_promedio + $promedio_sub;
							$contador_acumulado++;
						}
						?>
						<td>
						  <div align="center">
						    &nbsp;<? if ((trim($promedio_sub)>0)){ ?><?=$promedio_sub?><? }elseif (trim($promedio_sub)=="MB" or trim($promedio_sub)=="B" or trim($promedio_sub)=="S" or trim($promedio_sub)=="I"){ ?><?=$promedio_sub?><? } ?>
				         </div></td>
					   </tr>
					   <?
					   /// limpio promedio_sub
						$promedio_sub=0;
				  }	   
                  ?>
				  <tr>
                    <td height="15">PROMEDIO GENERAL </td>
					<td width="1%" align="center" class="textosimple">&nbsp;</td>
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=1";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_1 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_1') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_1 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in  (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '1')) and rut_alumno = '$rut_alumno'";
							 
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_1 = $fil_prom_gral['asistencia'];						
						}
					}	     	
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
					
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=2";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_2 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_2') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_2 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '2')) and rut_alumno = '$rut_alumno'";
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_2 = $fil_prom_gral['asistencia'];						
						}
					}
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
					
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=3";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_3 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_3') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_3 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '3')) and rut_alumno = '$rut_alumno'";
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_3 = $fil_prom_gral['asistencia'];						
						}
					}
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
					
					<?
					// consultas para sacar el promedio General del alumno //
					$sql_prom_gral="select promedio, asistencia from concentracion_notas where rut_alumno='$rut_alumno' and curso=4";
					$res_prom_gral= @pg_exec($conn,$sql_prom_gral);
					$num_prom_gral= @pg_numrows($res_prom_gral);
					if ($num_prom_gral>0){
					    /// existe, el promedio fué ingresado a mano
						$fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
						$promedio_gral= $fil_prom_gral['promedio'];
						$asistencia_4 = $fil_prom_gral['asistencia'];
					}else{
					    /// el promedio se saca de promocion
						$sql_prom_gral="select promedio, asistencia from promocion where id_ano in (select id_ano from ano_escolar where id_ano = '$ano_4') and rut_alumno='$rut_alumno'";
						$res_prom_gral= @pg_Exec($conn,$sql_prom_gral);
						$num_prom_gral= @pg_numrows($res_prom_gral);
						if ($num_prom_gral>0){
						     /// esta en promocion, se hizo la promocion
							 $fil_prom_gral= @pg_fetch_array($res_prom_gral,0);
	               			 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_4 = $fil_prom_gral['asistencia'];
					    }else{
						     /// tomar la asistencia de la tabla promocion de otra institucion
							 $sql_prom_gral = "select promedio, asistencia from promocion where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar = '0' and id_curso in (select id_curso from curso where ensenanza > 300 and grado_curso = '4')) and rut_alumno = '$rut_alumno'";
							 $res_prom_gral = @pg_Exec($conn,$sql_prom_gral);
							 $fil_prom_gral = @pg_fetch_array($res_prom_gral,0);
							 $promedio_gral= $fil_prom_gral['promedio'];
							 $asistencia_4 = $fil_prom_gral['asistencia'];						
						}
					}
					?>
                    <td>&nbsp;
                      <div align="center">
                        <?=$promedio_gral?>
                    </div></td>
                  </tr>
                  <tr>
                    <td height="15">PROMEDIO ASISTENCIA </td>
					<td width="1%" align="center" class="textosimple">&nbsp;</td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_1?>
                    %</div></td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_2?>
                    %</div></td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_3?>
                    %</div></td>
                    <td>&nbsp;
                      <div align="center">
                        <?=$asistencia_4?>
                    %</div></td>
                  </tr>
                </table></td>
				<td width="30%" align="center" nowrap="nowrap" class="textosimple">AÑO ESCOLAR Y ESTABLECIMIENTO <br />
			    EDUCACIONAL</td>
			  </tr>
			  
			 
			  <tr class="textosimple">				
				<? $colegio=$row_ano[nombre_instit];  ?>
				<td  valign="top" >
					<table width="50%" class="textosimple">
					
					<? for ($j=1;$j<=4; ++$j){?>
						<tr><td><b>
						<? 	$nombre_plan="";
							$nombre_eva="";
							$ano_temp="";
							$arreglo_temp="";
							
							///// determinar si el alumno ha cursado según el grado en alguna institución del sistema.
						    $sql_2 = "select * from curso where id_curso in (select id_curso from matricula where rut_alumno = '$rut_alumno' and bool_ar='0') and grado_curso = '$j' and ensenanza > 300 and id_ano in (select id_ano from promocion where rut_alumno = '$rut_alumno' and situacion_final <> '2') order by id_curso Desc";		 	
						    $res_2 = @pg_Exec($conn,$sql_2);
						    $num_2 = @pg_numrows($res_2);	
							
							 if ($num_2 > 0){  // existe, tomar los datos de la institucion a que corresponde el curso.
							 						 
								  $fil_2 = @pg_fetch_array($res_2,0);
								  $id_curso_temp = $fil_2['id_curso'];
								  $id_ano_temp   = $fil_2['id_ano'];
								  $decreto       = $fil_2['cod_eval'];
								  $cod_ensenanza = $fil_2['ensenanza'];
								  
								  /// rescato el año academico
								  $sql_3 = "select * from ano_escolar where id_ano = '$id_ano_temp'";
								  $res_3 = @pg_Exec($conn,$sql_3);
								  $fil_3 = @pg_fetch_array($res_3);	
								  
								  $year  = $fil_3['nro_ano'];
							      $institucion_temp = $fil_3['id_institucion'];
								  
								  $sql_ins = "SELECT institucion.nombre_instit, institucion.calle, institucion.nro, region.nom_reg, provincia.nom_pro, comuna.nom_com, institucion.telefono, institucion.rdb, institucion.dig_rdb ";
								  $sql_ins = $sql_ins . "FROM ((institucion INNER JOIN region ON institucion.region = region.cod_reg) INNER JOIN provincia ON (institucion.ciudad = provincia.cor_pro) AND (institucion.region = provincia.cod_reg)) INNER JOIN comuna ON (institucion.region = comuna.cod_reg) AND (institucion.ciudad = comuna.cor_pro) AND (institucion.comuna = comuna.cor_com) ";
								  $sql_ins = $sql_ins . "WHERE (((institucion.rdb)=".$institucion_temp.")); ";	
								  
								  $result_ins =@pg_Exec($conn,$sql_ins);
								  $fila_ins = @pg_fetch_array($result_ins,0);	
								  $ins_pal         = $fila_ins['nombre_instit'];
								  $establecimiento = $fila_ins['nombre_instit'];
								  $ciudad          = $fila_ins['nom_pro'];
								  $fono            = $fila_ins['telefono'];
								  $direc           = $fila_ins['calle'].$fila_ins['nro'];
								  $region          = $fila_ins['nom_reg'];
								  $provincia       = $fila_ins['nom_pro'];
								  $city            = $fila_ins['nom_pro'];
								  $comuna          = $fila_ins['nom_com'];
								  $comuna_real     = $fila_ins['nom_com'];	
								  
								  //// determinar el plan de estudio
								  
								  $query_primer="select * from plan_estudio where cod_decreto in (select cod_decreto from curso where id_curso = '$id_curso_temp')";
						     
								  $result_primer=	pg_Exec($conn,$query_primer);
								  $num_primer=pg_numrows($result_primer);
								  if ($num_primer>0){
									  $row_primer=pg_fetch_array($result_primer);	
									  $nombre_plan=$row_primer['nombre_decreto'];
									  $plan=$row_primer['nombre_decreto'];
									  $nombre_eva=$row_primer['nombre_decreto_eval'];
									  $arreglo_temp=explode(" ",trim($nombre_plan));
									  $ano_temp=$nro_ano[$j];
								  }
							}else{     // se ha insgresado la institución a "mano"			
			
							      $query_gene="select * from concentracion_notas where rut_alumno='$rut_alumno' and curso= '$j'";
							      $result_gene=pg_exec($conn,$query_gene);
							  
								  if (@pg_numrows($result_gene) > 0){     /// está en concentracion de notas para ese grado
								  
									  $row_gene = pg_fetch_array($result_gene);
									  $year            = $row_gene['ano'];
									  $establecimiento = $row_gene['institucion'];
									  $city            = $row_gene['ciudad'];									
									  $plan            = $row_gene['plan'];
									  $decreto         = $row_gene['decreto'];
									  $comuna_real     = $row_gene['comuna'];
								
									  $query_primer="select eva.*,plan.* 
											from curso,plan_estudio as plan ,evaluacion as eva
											where curso.id_ano='$row_ano[id_ano]'  and curso.grado_curso=$j and  curso.ensenanza>=310 and plan.cod_decreto=curso.cod_decreto
											and eva.cod_eval=curso.cod_eval";
									  $result_primer=	pg_exec($conn,$query_primer);
									  $num_primer=pg_numrows($result_primer);
									  if ($num_primer>0){
										  $row_primer=pg_fetch_array($result_primer);	
										  $nombre_plan=$row_primer[nombre_decreto];
										  $nombre_eva=$row_primer[nombre_decreto_eval];
										  $arreglo_temp=explode(" ",trim($nombre_plan));
										  $ano_temp=$nro_ano[$j];
									  }
									
									  /*  
									  $nini_es = $row_alumno['rut_alumno'];
							
									  if (($nini_es=16945793)AND($j==3)){
											$year="2006";
									  }
									  */
																	   
								   }else{  // no existe en concetracion
								  
									   
								   }
							 }	/// fin IF
						  
						  
						      if ($j==1){ echo "PRIMER";}
							  if ($j==2){ echo "SEGUNDO";}
							  if ($j==3){ echo "TERCER";}
							  if ($j==4){ echo "CUARTO";}
							  
							  
							  	   
						       ////////  DESPLIEGO LA INFORMACION DE LA TABLA  //////////
						  
						      ?>&nbsp;AÑO</b></td>
					          <? if($year==""){ ?>
						              <td class="textosimple"><b><? echo $ano_temp;?></b><br />Año Escolar </td>
						      <? }else{ ?>
						                 <td class="textosimple"><b><? echo $year;?></b><br />Año Escolar</td>
					          <? } ?>
				      </tr>
							  <?
							  if ($establecimiento==NULL){
							      ?>
							      <tr class="textosimple">
							         <td colspan="2">Sin información. <br><br><br><br><br><br></td>
							      </tr>    
							      <?
							  }else{ ?>	  
							  
					 	          <tr class="textosimple">
							        <td colspan="2">Establecimiento:<b><? echo $establecimiento;?></b></td>
							      </tr>
						          <tr class="textosimple">
							        <td colspan="2">Ciudad:<b>
									<?	
								   if (trim($comuna_real)=="VINA DEL MAR"){
								        $city="VIÑA DEL MAR";
										$comuna_real="VIÑA DEL MAR";
								   
								   }
								   
								   
								    ?>
									
									
									
									
								    <? 
								   if ($_INSTIT!=770 and $_INSTIT!=769 and $_INSTIT!=12838 and $_INSTIT!=12829){
								       echo $city; 
								   }else{
								       if ($establecimiento=="COLEGIO AMALIA ERRÁZURIZ"){
								           echo "Ovalle";
									   }else{
									       if ($_INSTIT==770 and trim($city)=="LIMARI"){
										        echo "OVALLE";
										   }else{
										        if ($_INSTIT==769 and trim($city)=="LIMARI"){
										             echo "OVALLE";
												}elseif($_INSTIT==12838 and trim($city)=="EL LOA"){
													echo "CALAMA";
												}else{	 
												     if($_INSTIT==12829 and trim($city)=="EL LOA"){
													     echo "CALAMA";
									                 }
												}	 
										   }	 	
										  	   									   
									   }	   
							       }
								   ?>
								   
								   
								   </b>&nbsp;&nbsp;Comuna: <b>
								   <? 
								   if($establecimiento=="COLEGIO AMALIA ERRÁZURIZ"){
								       echo Ovalle;
								   }else{
								        if ($_INSTIT==12838 and trim($city)=="EL LOA"){
											echo "CALAMA";
								        }else{
										     if ($_INSTIT==12829 and trim($city)=="EL LOA"){
											      echo "EL LOA";
											 }else{	  			
								                  echo $comuna_real;
											 }	   
								   
								        }
									}	
								   ?> 
								   
								   
								  </b></td>
							      </tr>
							  
							  
								  <tr><td colspan="2" nowrap="nowrap">Plan y Programa de Estudio Decreto Exento o Resolución</td></tr>
								  <tr class="textosimple">
								  <? if($plan==""){  ?>
										<td colspan="2">Exenta de Educacion Nº <b><? echo $nombre_plan;?></b></td>
								  <? }else{ ?>
										<td colspan="2">Exenta de Educacion Nº <b><? echo $plan;?></b></td>
								  <? } ?>
								  </tr>
								  <tr class="textosimple">
									 <td colspan="2">Reglamento de evaluacion y promocion Escolar decreto </td>
								  </tr>
								  <? if($decreto==""){ ?>
										   <tr class="textosimple"><td colspan="2">Exenta de Educacion N&ordm;&nbsp;<b><? echo $nombre_eva;?></b></td>
								  <? }else{ 
								           //// nuevo código que separa el código de decreto
										   if (ereg("de",$decreto)){
										       /// encontrado se deja igual
										   }else{
										        /// no encontrado buscar de otra forma
												 if (ereg("De",$decreto)){
												    // encontrado se deja igual
												 }else{
												      // no encontrado buscar de otra forma
													  if (ereg("DE",$decreto)){
													      // encontrado, dejar igual
													  }else{
													       $lcadena = strlen($decreto);
														   $inicio_ano = $lcadena - 4;
														   $resto_decreto = $lcadena-4;
														   $ano_decreto = substr($decreto,$inicio_ano,4);
														   $nro_decreto = substr($decreto,0,$resto_decreto);
														   $decreto = "$nro_decreto DE $ano_decreto";
													  }
												 }
											}
										   ?>
										   <tr class="textosimple"><td colspan="2">Exenta de Educacion N&ordm;&nbsp;<b><? echo $decreto;?></b></td>
								  <? } ?>
								  </tr>
							      <?
							   }	  					  
						
						     //////////////////////////////////////////////////////////						
						
					 }
					
					
					?>		
				  </table>				  
				</td>				
			  </tr>
			
			</table>
		</td>
		</tr>
		<? $fecha = date("d-m-Y");
			$sql4 = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp FROM supervisa INNER JOIN empleado ON supervisa.rut_emp = empleado.rut_emp ";
			$sql4 = $sql4 . "WHERE (((supervisa.id_curso)=".$cmb_curso.")); ";
			$result =@pg_Exec($conn,$sql4);
			$filaprofe = pg_fetch_array($result);			
			$profe_jefe = trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']).", ".trim($filaprofe['nombre_emp']);
			$profesor_jefe = trim($filaprofe['nombre_emp'])." ".trim($filaprofe['ape_pat'])." ".trim($filaprofe['ape_mat']);
		//----------------------------------
			$sql_dir = "SELECT empleado.ape_pat, empleado.ape_mat, empleado.nombre_emp ";
			$sql_dir = $sql_dir . "FROM trabaja INNER JOIN empleado ON trabaja.rut_emp = empleado.rut_emp ";
			$sql_dir = $sql_dir . "WHERE trabaja.rdb=".$institucion." AND (trabaja.cargo=1 OR trabaja.cargo=23) ";
			$result =@pg_Exec($conn,$sql_dir);
			$filadire = pg_fetch_array($result);
			$director_est =	trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']).", ".trim($filadire['nombre_emp']);
			$director_estab =	trim($filadire['nombre_emp'])." ".trim($filadire['ape_pat'])." ".trim($filadire['ape_mat']);	
		?>
		<tr><td align="center" class="textosimple">
		<? if($_INSTIT!=770 and $_INSTIT!=14703 and $_INSTIT!=516 and $_INSTIT!=769 and $_INSTIT!=12838){ 
		      echo $ciudad; 
		   }else{
		        if ($_INSTIT==770 or $_INSTIT==769) { 
				    echo Ovalle; 
			    }else{
				      if ($_INSTIT==516){
			               echo "LA SERENA";
			          }elseif ($_INSTIT==12838){
			               echo "CALAMA";
			          }
					  else{		 
			               echo $comuna;
					  }
				}	  	    
		   }	   
		
			?>,  <?php echo  fecha_espanol($fecha); ?> <br />
			
		<?
		
		
		   //$acumulo_promedio = $acumulo_promedio + $promedio;
			//$contador_acumulado++;
			
						
			$contador_acumulado = ($contador_acumulado - $contador_religion);
					
			$ponderacion_rende = $acumulo_promedio/$contador_acumulado;
			//$ponderacion_rende = substr($acumulo_promedio/$contador_acumulado,0,2);
			
			$sql_act = "update matricula set total_notas = '$contador_acumulado', suma_pond = '$acumulo_promedio', pond_demre = '$ponderacion_rende' where rut_alumno = '$rut_alumno' and id_ano = '".$_ANO."'";
		    $res_act = @pg_Exec($conn,$sql_act);
			
		   ?>	
		  <table width="200" border="1" cellspacing="0" cellpadding="0" align="left">
            <tr>
              <td class="textosimple" width="170">Total notas promediadas</td>
              <td width="20"><?=$contador_acumulado ?></td>
            </tr>		  
            <tr>
              <td class="textosimple" width="170">Suma Ponderación</td>
              <td width="20"><?=$acumulo_promedio ?></td>
            </tr>
            <tr>
              <td class="textosimple" width="170">Ponderación Demre</td>
              <td width="20"><?=$ponderacion_rende ?></td>
            </tr>
          </table>
	    	<br>  
		  <br /></td></tr>
		<tr><td align="center"><table width="100%">
		  <tr><td><table width="57%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
			<tr>
			  <td align="center" width="100%"><strong><font face="Arial, Helvetica, sans-serif" size="1">__________________________<br />
			  PROFESOR(A) JEFE<br> 
			  <? if($institucion==770){
					echo $profesor_jefe;
				}else{
					echo $profe_jefe;
				}
			  ?>
			  </font></strong></td>
			</tr>
		  </table>
		      <input name="contador_campos" type="hidden" id="contador_campos" value="<?=$contador_campos?>"></td><td><table width="1%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
			<tr>
			  <td align="center" width="100%"><strong><font face="Arial, Helvetica, sans-serif" size="1">__________________________<br />
				<?=$cargo_dir2?> <br />
				<? if($institucion==770){
						echo $director_estab;
					}else{
					    if ($institucion==2278){
						     echo "ANA LORENA ALCOTA IRELAND";
						}else{
						     echo $director_est;
						}	 
					}?>
				</font></strong></td>
			</tr>
		  </table></td></tr></table> </td></tr>
		
		</table>

<? 
      }

  }

?>
<!-- ------------------------------INICIO VEL---------------------------- -->

<!--- -------------------------------FIN VEL-------------------------------- -->
</td>
 </tr>
</table>
</form>
							  
					
					
							  
<!-- buscador --->
<form method "post" action="">
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
<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FFFF00">
  <tr>
    <td width="" valign="top">
	  <table width="100%" height="43" border="0" cellpadding="0" cellspacing="0" class="textosimple">
  <tr>
    <td width=""  class="fondo">Buscador Avanzado </td>
  </tr>
  <tr>
    <td height="27">
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="textosimple">
 
	<tr class="textosimple">
	<td colspan="2" class="cuadro01"><br>
	  Curso..<br>
	  <font size="1" face="arial, geneva, helvetica">
      <select name="cmb_curso"  class="ddlb_9_x" onChange="enviapag(this.form);">
        <option value=0 selected>(Seleccione Curso)</option>
        <?
		  for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i)
		  {
		  $fila = @pg_fetch_array($resultado_query_cue,$i); 
		      $ensenanza = $fila['ensenanza'];
		  if ($fila["id_curso"]==$cmb_curso){
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option selected value=".$fila['id_curso'].">".$Curso_pal.$fila['id_curso']."</option>";
  		  }else{
  				$Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
				echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
		  }
          } ?>
      </select>
      <br>
	  </font></td>
    </tr>
	<tr>
	  <td colspan="2" class="cuadro01"><br>
	    Alumno
	    <br>
	    <select name="cmb_alumno" class="ddlb_9_x">
          <?
		     if ($_INSTIT==9071){ ?>
		         <option value="0">Todos</option>
         <?  }
		$sql="select matricula.rut_alumno, alumno.ape_pat, alumno.ape_mat,  alumno.nombre_alu from matricula, alumno where id_curso = ".$cmb_curso. " and matricula.rut_alumno = alumno.rut_alumno order by ape_pat, ape_mat, nombre_alu";
		$result= @pg_Exec($conn,$sql);
		for($i=0 ; $i < @pg_numrows($result) ; ++$i){
			$fila = @pg_fetch_array($result,$i);?>
          <option value="<? echo $fila["rut_alumno"]; ?>" <? if ($fila["rut_alumno"]==$c_alumno){ echo "selected";}?>><? echo ucwords(strtolower($fila["ape_pat"].$fila["ape_mat"].$fila["nombre_alu"]));?></option>
          <?
		}
		
		
		
		?>
              </select>
	    <br></td>
	  </tr>
	<tr>
	  <td width="107" class="cuadro01">&nbsp;</td>
	  <td width="592"><input name="cb_ok" type="button" class="botonXX"  id="cb_ok" onClick="MM_goToURL('parent','concentracionnotas_dd.php?c_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&cb_ok=1&amp;c_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value+'&amp;cmb_curso='+cmb_curso.options[cmb_curso.selectedIndex].value+'&amp;cmb_alumno='+cmb_alumno.options[cmb_alumno.selectedIndex].value);return document.MM_returnValue" value="Buscar"></td>
	  </tr>
</table>

	</td>
  </tr>
</table>

	</td>
  </tr>
</table>
							  
							</form>
							
							  <!-- fin buscador -->						  
							  
							  </td>
                          </tr>
                        </table>
						</td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2007</td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?
pg_close($conn);

//echo "<h1>fin ".date('h:i:s')."</h1>";//PERCY CUANDO HAGAS ESTO HAZLO PARA QUE LO VEA NADIE SOLO TU

//print_r($total);

?>
