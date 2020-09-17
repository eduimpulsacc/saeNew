<?php
require('../../../../../util/header.inc');
 	
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
    $curso			=$_CURSO;
	$docente		=5; //Codigo Docente
	$_POSP          =5;
	$_bot           =5;
	$_MDINAMICO     =1;
	$_VIENEPAG		="listar_ramos.php3";
	
	$sql="select situacion from ano_escolar where id_ano=$_ANO";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);
	
	
	if($_PERFIL==0){
		//echo $curso;
	}
	
	if($curso!=""){
		$qryplan ="SELECT * FROM CURSO WHERE id_curso = '$curso'";
		$resultplan = pg_Exec($conn,$qryplan);
		$rowplan = pg_fetch_array($resultplan);
		$_PLAN=$rowplan[cod_decreto];
			if(!session_is_registered('_PLAN')){
				session_register('_PLAN');
			};
	}	
	
	$sql="SELECT planificacion FROM institucion WHERE rdb=".$institucion;
	$rs_plani = pg_exec($connection,$sql);
	$plani = pg_result($rs_plani,0);
	
	session_register("_VIENEPAG");
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
			$_ITEM =$item;
			session_register('_ITEM');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
	
		$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		
		//curso.ensenanza=".pg_result($rs_acceso,3)." AND
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0 && $_PERFIL!=17){
			$whe_perfil_curso=" AND  id_curso in(";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['id_curso'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['id_curso'];
				}
			}
			$whe_perfil_curso.=")";
		}else{

	if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=26)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=20)&&($_PERFIL!=14)&&($_PERFIL!=2)&&($_PERFIL!=21)&&($_PERFIL!=54)&&($_PERFIL!=35)&&($_PERFIL!=22)&&($_PERFIL!=1)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=28)&&($_PERFIL!=30)&&($_PERFIL!=53)&&($_PERFIL!=31)&&($_PERFIL!=32)&&($_PERFIL!=33)&&($_PERFIL!=26)&&($_PERFIL!=27)&&($_PERFIL!=72)){$whe_perfil_curso=" and curso.id_curso=$curso";}
	
		}
	$qry1106="SELECT * FROM ANO_ESCOLAR WHERE ID_ANO = '$ano' AND ID_INSTITUCION=".$institucion." ORDER BY NRO_ANO";
				$result1106 =@pg_Exec($conn,$qry1106);
				
				if (!$result1106){
					error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result1106)!=0){
						$fila1106 = @pg_fetch_array($result1106,0);	
						if (!$fila1106){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}else{
						  $fila1106 = @pg_fetch_array($result1106,0);
					    }	  
					}
											
				}
	
	
?>

 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } ?>
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>

   
<!--<script>

$( document ).ready(function() {
	<?php if($_PERFIL!=0){?>
   aviCod();
	<?php }?>
});
function aviCod(){
var msg="AVISO IMPORTANTE:\n\nFavor verificar los siguientes códigos de asignaturas (al lado derecho del nombre de asignatura) desde séptimo básico a segundo año medio:\n\n11224 - LENGUA Y LITERATURA\n11225 - IDIOMA EXTRANJERO INGLÉS\n517-TECNOLOGÍA\n9845 - EDUCACIÓN FÍSICA Y SALUD\n\nEn caso que estos subsectores posean código diferente a los mencionados, debe comunicarse con soporte a la brevedad.\n\n Atentamente, Colegio Interactivo";
alert(msg);	
}
</script>-->

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link  rel="shortcut icon" href="/images/icono_sae_33.png">
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.min.css">
<link rel="stylesheet" type="text/css" href="../../../../clases/jquery-ui-1.8.14.custom/development-bundle/demos/demos.css">
<script type="text/javascript" src="../../../../clases/jqueryui/jquery.ui.datepicker-es.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--
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

       function enviapag(form){
		    var curso2, frmModo; 
			curso2=form.cmb_curso.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_curso.value!=0){
			    form.cmb_curso.target="self";
				pag="../seteaCurso.php3?caso=11&curso="+curso2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }
		 
		  function enviapag2(form){
		    var ano, frmModo; 
			ano2=form.cmb_ano.value;
			frmModo = form.frmModo.value;
			
 			if (form.cmb_ano.value!=0){
			    form.cmb_ano.target="self";
				pag="../../seteaAno.php3?caso=10&pa=2&ano="+ano2+"&frmModo="+frmModo
				form.action = pag;
				form.submit(true);	
			}		
		 }

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->

function grupon(rm,cur){
	var parametros="funcion=1&curso="+cur+"&ramo="+rm;
	//alert(parametros);

	$.ajax({
	  url:'grupon/cont_grupon.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#ramogrupo").html(data);
		$( "#ramogrupo" ).dialog(
		{ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  height: 450,
	width: 850,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }
		);
		  }
	  })	
 
}
function ngr(ramo){
	var per = $("#idP").val();
	var parametros="funcion=2&ramo="+ramo+"&per="+per;
$.ajax({
				url:"grupon/cont_grupon.php",
				data:parametros,
				type:'POST',
				success:function(data){
				$("#conte > tbody").append(data);
		  }
		}); 
}

function guardaGrupo(){
var total_check = $("input.grn[type=checkbox]:checked").length;
var porcentaje =  $("#prc").val();
var leccionario = $("#txtLECCIONARIO").val();
var orden =  $("#orden").val();
var per = $("#idP").val();
var totalporc=0;

$("input.prco").map(function(){
    //sumpc.push($(this).val());
	totalporc=totalporc+parseInt($(this).val());
  });

  

if(porcentaje=="" || (porcentaje<1 && porcentaje>100)){
	alert("Valor no permitido");
	}
else if(total_check==0){
	alert("Seleccione notas para agrupar");
	}
	else if(totalporc<1 || totalporc>100){
		alert("Suma Porcentajes exceden 100%");
	}
	else{
		var curso = $("#curso").val();
		var ramo = $("#ramo").val();
		var porcentaje = $("#prc").val();
		var n1 = ($("#n1").is(':checked'))?1:0;
		var n2 = ($("#n2").is(':checked'))?1:0;
		var n3 = ($("#n3").is(':checked'))?1:0;
		var n4 = ($("#n4").is(':checked'))?1:0;
		var n5 = ($("#n5").is(':checked'))?1:0;
		var n6 = ($("#n6").is(':checked'))?1:0;
		var n7 = ($("#n7").is(':checked'))?1:0;
		var n8 = ($("#n8").is(':checked'))?1:0;
		var n9 = ($("#n9").is(':checked'))?1:0;
		var n10 = ($("#n10").is(':checked'))?1:0;
		var n11 = ($("#n11").is(':checked'))?1:0;
		var n12 = ($("#n12").is(':checked'))?1:0;
		var n13 = ($("#n13").is(':checked'))?1:0;
		var n14 = ($("#n14").is(':checked'))?1:0;
		var n15 = ($("#n15").is(':checked'))?1:0;
		var n16 = ($("#n16").is(':checked'))?1:0;
		var n17 = ($("#n17").is(':checked'))?1:0;
		var n18 = ($("#n18").is(':checked'))?1:0;
		var n19 = ($("#n19").is(':checked'))?1:0;
		var n20 = ($("#n20").is(':checked'))?1:0;
				  
		  var parametros = "funcion=3&curso="+curso+"&ramo="+ramo+"&porcentaje="+porcentaje+"&n1="+n1+"&n2="+n2+"&n3="+n3+"&n4="+n4+"&n5="+n5+"&n6="+n6+"&n7="+n7+"&n8="+n8+"&n9="+n9+"&n10="+n10+"&n11="+n11+"&n12="+n12+"&n13="+n13+"&n14="+n14+"&n15="+n15+"&n16="+n16+"&n17="+n17+"&n18="+n18+"&n19="+n19+"&n20="+n20+"&leccionario="+leccionario+"&orden="+orden+"&per="+per;
		
			$.ajax({
					url:"grupon/cont_grupon.php",
					data:parametros,
					type:'POST',
					success:function(data){
					//console.log(data);
					//grupon(ramo,curso)
					gruponNew(per);
			  }
			})
		
		}
}

function edifila(grupo){ 
	var per = $("#idP").val();
	var parametros = "funcion=4+&grupo="+grupo+"&per="+per;
	
	$.ajax({
					url:"grupon/cont_grupon.php",
					data:parametros,
					type:'POST',
					success:function(data){
						$('#fila'+grupo).replaceWith(data);
						$(".btne").hide();
						
					
			  }
			})
	
}

function guardaGrupoEdi(){
var total_check = $("input.grn[type=checkbox]:checked").length;
var porcentaje =  $("#prc").val();
var leccionario = $("#txtLECCIONARIO").val();
var orden = $("#orden").val();
var per = $("#idP").val();
var totalporc=0;

$("input.prco").map(function(){
    //sumpc.push($(this).val());
	totalporc=totalporc+parseInt($(this).val());
  });
 
 
  //alert(totalporc);

if(porcentaje=="" || (porcentaje<1 && porcentaje>100)){
	alert("Valor no permitido");
	}
else if(totalporc<1 || totalporc>100){
		alert("Suma Porcentajes exceden 100%");
	}
else if(total_check==0){
	alert("Seleccione notas para agrupar");
	}
	else{
		var grupo = $("#idg").val();
		var porcentaje = $("#prc").val();
		var curso = $("#curso").val();
		var ramo = $("#ramo").val();
		var n1 = ($("#n1").is(':checked'))?1:0;
		var n2 = ($("#n2").is(':checked'))?1:0;
		var n3 = ($("#n3").is(':checked'))?1:0;
		var n4 = ($("#n4").is(':checked'))?1:0;
		var n5 = ($("#n5").is(':checked'))?1:0;
		var n6 = ($("#n6").is(':checked'))?1:0;
		var n7 = ($("#n7").is(':checked'))?1:0;
		var n8 = ($("#n8").is(':checked'))?1:0;
		var n9 = ($("#n9").is(':checked'))?1:0;
		var n10 = ($("#n10").is(':checked'))?1:0;
		var n11 = ($("#n11").is(':checked'))?1:0;
		var n12 = ($("#n12").is(':checked'))?1:0;
		var n13 = ($("#n13").is(':checked'))?1:0;
		var n14 = ($("#n14").is(':checked'))?1:0;
		var n15 = ($("#n15").is(':checked'))?1:0;
		var n16 = ($("#n16").is(':checked'))?1:0;
		var n17 = ($("#n17").is(':checked'))?1:0;
		var n18 = ($("#n18").is(':checked'))?1:0;
		var n19 = ($("#n19").is(':checked'))?1:0;
		var n20 = ($("#n20").is(':checked'))?1:0;
				  
		  var parametros = "funcion=5&grupo="+grupo+"&porcentaje="+porcentaje+"&n1="+n1+"&n2="+n2+"&n3="+n3+"&n4="+n4+"&n5="+n5+"&n6="+n6+"&n7="+n7+"&n8="+n8+"&n9="+n9+"&n10="+n10+"&n11="+n11+"&n12="+n12+"&n13="+n13+"&n14="+n14+"&n15="+n15+"&n16="+n16+"&n17="+n17+"&n18="+n18+"&n19="+n19+"&n20="+n20+"&leccionario="+leccionario+"&ramo="+ramo+"&orden="+orden;
		
			$.ajax({
					url:"grupon/cont_grupon.php",
					data:parametros,
					type:'POST',
					success:function(data){
					//console.log(data);
					//grupon(ramo,curso);
					$( "#idP option:selected" ).val(per);
					gruponNew(per);
			  }
			})
		
		}
}


function elifila(grupo){
	var curso = $("#curso").val();
	var ramo = $("#ramo").val();
	var per = $("#idP").val();
	var parametros = "funcion=6+&grupo="+grupo+"&ramo="+ramo;
	if(confirm("Seguro de eliminar grupo de notas?\nLas notas de este grupo quedan fuera del calculo de promedio de asignatura")){
	$.ajax({
					url:"grupon/cont_grupon.php",
					data:parametros,
					type:'POST',
					success:function(data){
						
						//grupon(ramo,curso);
						$( "#idP option:selected" ).val(per);
						gruponNew(per);
						
					
			  }
			})
	}
}

<?php if($_PERFIL==0){?>
function traspaso(){
	if(confirm("Seguro de trasapasar configuración de las asignaturas?")){
		var ano=$("#cmb_ano").val();
		var curso=$("#cmb_curso").val();
		var parametros = "ano="+ano+"&curso="+curso;
		$.ajax({
				url:"traspaso_conf/traspaso_conf.php",
				data:parametros,
				type:'POST',
				success:function(data){
				console.log(data);
				if(data==0){
				alert("No existe curso equivalente el año anterior");	
				}
				if(data==1){
				alert("Configuración actualizada");	
				window.location.reload();
				}
		  }
		});
	}
	
}//fin funcion


<?php }?>

//cambio funciones para agregar periodo a los grupos de notas
function gruponNew(per){
	var cur = $("#curso").val();
	var rm = $("#ramo").val();
	var parametros="funcion=7&curso="+cur+"&ramo="+rm+"&per="+per;
	//alert(parametros);

	$.ajax({
	  url:'grupon/cont_grupon.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // console.log(data);
	    $("#listaGrupos").html(data);
		/*$( "#ramogrupo" ).dialog(
		{ 
   closeOnEscape: false,
   modal:true,
   resizable: false,
  height: 450,
	width: 850,
   show: "fold",
   hide: "scale",
   stack: true,
   sticky: true,
   position:"fixed",
   position: "absolute",
    buttons: {
		 "Cerrar": function(){
	    $(this).dialog("close");
	  }
	}   
  }
		);*/
		  }
	  })	
 
}

</script>
<style type="text/css">
<!--
.EstiloMODO {color: #FF0000 ; font-size: 10px;}
-->
</style>
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
            <? include("../../../../../cabecera/menu_superior.php"); ?>
                </td>
              </tr>
              <tr align="left" valign="top"> 
                <td height="83" colspan="3"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
							<? $menu_lateral="3_1"; include("../../../../../menus/menu_lateral.php");?></td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td height="" align="right"><!-- codigo antiguo -->
								  
								  
								  
								  
								  
<?php if(($_PERFIL!=17)&&($_PERFIL!=2)&&($_PERFIL!=19)&&($_PERFIL!=20)&&($_PERFIL!=6)&&($_PERFIL!=21)&&($_PERFIL!=22)){?>
<table width="90%" height="30" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td height="" align="right" valign="top">&nbsp;</td>
  </tr>
</table>
<?php } ?>
	<?php //echo tope("../../../../../util/");?>
	<center>
	
	
		<table width="650" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#0000FF">
          <tr>
            <td>
			
			
			  <TABLE BORDER="0" CELLSPACING="1" CELLPADDING="1">
						
						<TR>
							<TD align=left class="textonegrita">AÑO ESCOLAR </TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
										<?php
				$qry="SELECT * FROM ANO_ESCOLAR WHERE ID_INSTITUCION=".$institucion."  $whe_perfil_ano ORDER BY NRO_ANO";
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
			 <form name="form"   action="" method="post">
		        <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
					
						<select name="cmb_ano" class="ddlb_x" id="cmb_ano" onChange="enviapag2(this.form);">
                           <option value=0 selected>(Seleccione un Año)</option> <?
						   for($i=0;$i < @pg_numrows($result);++$i){
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
							</select></form>
				<? }	?>
									</strong>
								</FONT>
							</TD>
						</TR>
						<TR>
							<TD align=left class="textonegrita">												CURSO															</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>:</strong>								</FONT>							</TD>
							<TD>
								<FONT face="arial, geneva, helvetica" size=2>
									<strong>
								
		    <form name="form"   action="" method="post">
		      <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		      <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";

$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso  ";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
//echo $sql_curso;

$resultado_query_cue = pg_exec($conn,$sql_curso);



                 ?>
				 
				 
				 
		  <select name="cmb_curso" class="ddlb_x" id="cmb_curso" onChange="enviapag(this.form);">
            <option value="0" selected>(Seleccione un Curso)</option>
			 <?
			 $sw3 = 1;
			 
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; ++$i)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		  
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal."</option>";
				   $sw3 = 0;
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal."</option>";
                }
		     } 
			
			 ?>
          </select>	 
		 </form>		   
		  
			</strong></FONT>
							</TD> 
						</TR>
					</TABLE></td>
            <!--<td><a href="../../../../../PLAN_ESTUDIO_2016.pdf"  target="_blank"><img src="../../../../../animation_importante2016.gif" width="210" height="96" border="0" title="DESCARGAR AQUI"></a></td>-->
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
		<form name="form2" method="post" action="elimina_ramos.php">
		  <table BORDER="0" CELLSPACING="1" CELLPADDING="3">
			<TR height=0>
				<TD colspan=5 valign="top">&nbsp;</TD>
			</TR>
			<tr>
				<td colspan=6 align=right>
		         <?
                   if ($_PERFIL==0){ ?>
					     <!-- <INPUT name="Enviar"  TYPE="submit" class="botonXX" value="ELIMINAR SUBSECTOR">-->
				 <? } 		 				

             
			 
			 if (($curso != 0) and ($curso != NULL) and ($sw3 != 1)){ ?> 							
		
					<?php if(($_PERFIL!=17) and ($_PERFIL!=19)){?>
						<?php 
						if(($_PERFIL!=4)){ //ACADEMICO Y LEGAL?>
								<?php 
								if(($_PERFIL!=3)&&($_PERFIL!=5) &&($_PERFIL!=26) &&($_PERFIL!=8)&&($_PERFIL!=1)){ //FINANCIERO Y  CONTADOR
								
								if (($plan!=461987) and ($plan!=1901975) and ($plan!=771982) and ($plan!=121987)){
									
									
									if($fila1106['situacion']==0 and $_PERFIL!=0){//CERRADO NO MOSTRAR ESTE BOTON CON LINK
									    ?><INPUT class="botonXX"  TYPE="button" value="AGREGAR">                                <?
								    }else{
										
									     ?>
                                        
                                <input name="button2"  type="button" class="botonXX" onClick=document.location="seteaRamo.php3?caso=2&plan=<?php echo $plan?>" value="AGREGAR">
                                <?
									}
									?>								
																	
									
									
									<INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="Ordensubsector.php"  value="ORDENAR">
									<INPUT class="botonXX"  TYPE="button" value="ASIG. FORMULAS" onClick=document.location="listarFormulas.php3">
											<?php }?>
												<?php }?>
						<?php }?>
					<?php }?>	
					
					<? if ($_INSTIT==1756 and $_PERFIL==17){  ?> <INPUT name="button" TYPE="button" class="botonXX" onClick=document.location="Ordensubsector.php"  value="ORDENAR"> <? } ?>	
					<? if($_PERFIL==14 || $_PERFIL==0||$_PERFIL==25 || $_PERFIL==27){	?> 
					<INPUT name="button" TYPE="button" class="botonXX" onClick='window.location="seteaConfig.php3?curso=<?=$curso;?>&caso=1"'  value="CONFIGURAR ASIGNATURA">
					<? } ?>	
                   
					<INPUT name="button" TYPE="button" class="botonXX" onClick='window.location="modulo/listaModulo.php?curso=<?=$curso;?>&caso=1"'  value="CONFIGURAR MODULOS">
				<? if($_PERFIL==14 || $_PERFIL==0){	?>
					<INPUT name="button" TYPE="button" class="botonXX" onClick='traspaso();'  value="TRASPASAR CONFIGURACION ASIGNATURA">
					<? } ?>	
                    
           								    </td>
			</tr>
			<tr height="20">
				<td align="middle" colspan="7" class="tableindex">Asignaturas</td>
			</tr>
						<tr>
				<td align="left" colspan="7" class="textolink">
					<table width="100%" border="0">
                      <tr class="textolink">
                        <td><input name="button3"  type="button" class="botonXX" value="E" >
Evaluacion</td>
                        <td><input name="button4"  type="button" class="botonXX" value="I" >
Insc. alumnos</td>
                        <td><input name="button5"  type="button" class="botonXX" value="SF" >
Sit. Final</td>
                        <td><input name="button6"  type="button" class="botonXX" value="A" >
Archivos </td>
                        <td><input name="button12"  type="button" class="botonXX" value="NG" > 
                          Grupo Notas</td>
                      </tr>
                      <tr class="textolink">
                        <td><input name="button7"  type="button" class="botonXX" value="PN" >
Prueba Nivel</td>
                        <td><input name="button8" type="button" class="botonXX"  value="P">
Planificaci&oacute;n</td>
                        <td><input name="button9" type="button" class="botonXX" value="ES">
Exm. Semestral </td>
                        <td><input type="button" name="PA" value="AP" class="botonXX" >
                        Apreciación</td>
                        <td>
                        <?php //if($_PERFIL==0){?>
                        <input name="BA" type="button" class="botonXX" id="BA" value="BA" > 
					      Bit&aacute;cora Asignatura
                       <?php  //}?>
                        </td>
                      </tr>
					   <tr class="textolink">
                        <td><input name="CP"  type="button" class="botonXX" id="CP" value="CP" >
Configurar % notas parciales</td>
                        <td><!--<input type="button" name="NE" value="NE" class="botonXX" > 
                          Nuevo Ingreso de Notas (beta) -->
                          <!--<input name="button82" type="button" class="botonXX"  value="NE">
                          Nueva Evaluaci&oacute;n -->
                          <input name="SFP"  type="button" class="botonXX" id="SFP" value="SFP" > Situacion final periodo</td>
                        <td><input name="PE"  type="button" class="botonXX" id="PE" value="PE" >&nbsp;Prueba Especial</td>
                        <td><input type="button" name="NQ" value="NQ" class="botonXX" >
                        Notas Quiz</td>
                        <td> <? if($_PERFIL==0){?>
                         <input name="PP" type="button" class="botonXX" id="PP" value="PP" > 
					      Progreso Porcentual
                           <?php }?></td>
					   </tr>
					   <tr class="textolink">
					     <td><input name="EXQ"  type="button" class="botonXX" id="EXQ" value="EXP" >
Examen Periodo</td>
					     <td><input type="submit" name="button11" id="button" value="ECF2" class="botonXX"> Examen Coef. 2</td>
					     <td><input type="button" name="NQ" value="PU" class="botonXX" >
                        Pruebas de Unidad
                        </td>
					     <td>  <? //if($_PERFIL==0){?>
                         <input name="PS" type="button" class="botonXX" id="PS" value="PS" > 
					       Pruebas S&iacute;ntesis
                           <?php //}?></td>
					     <td>&nbsp;</td>
					     </tr>
                    </table>					</td>
			</tr>
			<tr class="tablatit2-1">
				<td align="center" >
					NOMBRE				</td>
				<td align="center" width="200">
					DOCENTE				</td>
				
				<td>MODO EVALUACI&Oacute;N </td>
				<td>INC.<br>
				  PROM.</td>
				<td>INC.<br>
				  P.G.</td>
				<td>OPCIONES</td>
			</tr>
			<?php
              if (($_SWA==1) and ($_PERFIL !=0)){
			     
			   $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz,ramo.bool_pu,ramo.bool_psintesis,ramo.notagrupo,ramo.coef2,ramo.bool_ip,ramo.bool_pgeneral,ramo.sub_obli,ramo.sub_elect FROM subsector 
			   INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE ramo.id_curso=".$curso." and ramo.id_ramo =".$_RAMO." order by ramo.id_orden";
			  
				  $result_qry =@pg_Exec($conn,$qry);  
				  $fila_modo = @pg_fetch_array($result_qry,0);	
				  $modismo = $fila_modo['modo_eval'];
				  
			  }else{
			      
		  	  $qry="SELECT ramo.id_ramo, subsector.nombre, subsector.cod_subsector, ramo.eee,  ramo.modo_eval, ramo.id_orden,ramo.conex,ramo.prueba_nivel, ramo.porc_examen, ramo.conexper,ramo.prueba_especial,ramo.bool_nquiz,ramo.conexquiz, ramo.coef2,ramo.bool_pu,ramo.bool_psintesis,ramo.notagrupo,ramo.bool_ip,ramo.bool_pgeneral,ramo.sub_obli,ramo.sub_elect FROM subsector INNER JOIN ramo ON subsector.cod_subsector = ramo.cod_subsector WHERE (((ramo.id_curso)=".$curso."))  order by ramo.id_orden";			   
              $result_qry =@pg_Exec($conn,$qry);
			  $fila_modo = @pg_fetch_array($result_qry,0);	
			  $modismo = $fila_modo['modo_eval'];
			 
			  }
			
			  if($institucion==279) echo $qry;
			  
				$result =@pg_Exec($conn,$qry);
				if (!$result) {
					//error('<B> ERROR :</b>Error al acceder a la BD. (5)</B>');
				}else{
					if (pg_numrows($result)!=0){
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
						//	error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}
			?>
			<?php
			
			
				   $contador = @pg_numrows($result);				 			        
				   ?>
				   <input type="hidden" name="contador" value="<?=$contador ?>">
				   <?
			
			
			     	$cant_errores = 0;		        
			
					for($i=0 ; $i < @pg_numrows($result) ; ++$i){
						$fila = pg_fetch_array($result,$i);
						if($fila['sub_obli']==1){
$tp="OBLIGATORIA";
}
if($fila['sub_elect']==1){
$tp="ELECTIVA";
}
$nom=trim($fila['nombre']);
			             
						?>
				       <tr  onMouseOver="this.style.background='yellow';" onMouseOut="this.style.background='transparent'" >
					   <!--<td align="center" class="textolink"><input type="checkbox" name="check<?=$i ?>" value="<? echo $fila["id_ramo"]; ?>" <? if ($fila["eee"]==1){ ?> checked="checked" <? } ?>>	</td>-->
				       <td align="left" class="textolink"   onClick="go('seteaRamo.php3?ramo=<?php echo $fila["id_ramo"];?>&caso=1&plan=<?php echo $fila['cod_decreto']; ?>&cod_subsector=<? echo $fila['cod_subsector']; ?>&swb=1')" title="<?php echo trim("$nom: $tp"); ?>">
					       <?php if($_PERFIL==0){echo $fila["id_ramo"];}?>&nbsp;    <?
						   if ($fila["eee"]==1){ ?>
						       <font color="#FF0000">			   
				         	   <?php echo $fila['nombre'];  echo $fila['cod_subsector']; 
						   }else{
						   	   echo $fila['nombre'];  echo $fila['cod_subsector']; 
						   }
						   ?>											</td>
							<?php
							 //  $qry2="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp) WHERE (((dicta.id_ramo)=".$fila["id_ramo"]."))";
							
								$qry55="select * from dicta where id_ramo=".$fila['id_ramo'];
							//	$qry55="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result55 =@pg_Exec($conn,$qry55);
								$fila55 = @pg_fetch_array($result55,0);
								
								$qry2="select empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from empleado where rut_emp=".$fila55['rut_emp'];
							//	$qry5="SELECT empleado.rut_emp, empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat from (supervisa inner join empleado on supervisa.rut_emp = empleado.rut_emp) where((supervisa.id_curso)=".$fila['id_curso'].")";
								$result2 =@pg_Exec($conn,$qry2);
								$fila2 = @pg_fetch_array($result2,0);

							
							
								//$qry2="SELECT empleado.nombre_emp, empleado.ape_pat, empleado.ape_mat FROM (dicta INNER JOIN empleado ON dicta.rut_emp = empleado.rut_emp) INNER JOIN ramo ON dicta.id_ramo = ramo.id_ramo WHERE (((ramo.id_ramo)=".$fila["id_ramo"]."))";
								$result2 =@pg_Exec($conn,$qry2);
								$fila2 = @pg_fetch_array($result2,0);	
							?>
							<td align="left" class="textolink" onClick="go('seteaRamo.php3?ramo=<?php echo $fila["id_ramo"];?>&caso=1&plan=<?php echo $fila['cod_decreto']; ?>&cod_subsector=<? echo $fila['cod_subsector']; ?>&swb=1')">
							
							 <?
							 if ($fila2['nombre_emp']==NULL){
							     echo "<font face='verdana' size='1' color='FF0000'>¡Falta información!</font>";
								 $cant_errores++;
								 $tipo_error_1 = 1;
						    }else{ ?>		 
								  <font face="arial, geneva, helvetica" size="1" color="#000000"><strong><?php echo $fila2["ape_pat"]." ".$fila2["ape_mat"].", ".$fila2["nombre_emp"];?></strong></font>
								  
						 <? } ?>											</td>
							
							<td nowrap class="textolink"><? switch ($fila['modo_eval']) { //agregado el 25/01/2007/ by telnetk
											case 0:
															 imp('<span class="EstiloMODO">* Revisar </spam>');
															 break;
														 case 1:
															 imp('Numérico');
															 break;
														 case 2:
															 imp('Conceptual (I,S,B,MB)');
															 break;
														 case 3:
															 imp('Numérico-Conceptual');
															 break;
														 case 4:
															 imp('Conceptual-Numérico');
															 break;
														 case 5:
															 imp('Conceptual Especial (SIGLAS)');
															 break;	 
															 
													 };?>&nbsp;</td>
							<td nowrap class="textolink"><?php echo  ($fila['bool_ip']==1)?"SI":"NO"; ?>&nbsp;</td>
							<td nowrap class="textolink"><?php echo  ($fila['bool_pgeneral']==1)?"SI":"NO"; ?></td>
							<td nowrap>
							<?php
											$qry_per="SELECT periodo.id_periodo, ano_escolar.id_ano FROM ano_escolar INNER JOIN periodo ON ano_escolar.id_ano = periodo.id_ano WHERE (((ano_escolar.id_ano)=".$ano."))";
											
											
											$result_per =pg_Exec($conn,$qry_per);
											if (pg_numrows($result_per)!=0){?>
								
								
							<!-- nuevo 	directo
								       <INPUT class="botonXX"  TYPE="button" value="E" onClick=document.location="notas/new_mostrarNotas_dav2.php3?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">   -->
							     		
										
							<!-- antiguo con redireccion -->
							<!--<INPUT class="botonXX"  TYPE="button" value="NE" onClick=document.location="notas/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">--> 
                            
                            	<!--<input name="button10"  type="button" class="botonXX" onClick=document.location="notas/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3" value="NE">-->
                                <? if($_PERFIL==0){?>
                            <input name="button100"  type="button" class="botonXX" onClick=document.location="notas/grilla_notas_jscripNueva2020/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3" value="E3">
							<? }?>
						
<input name="button10"  type="button" class="botonXX" onClick=document.location="notas/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3" value="E">
					  
								  
								  
							  <INPUT class="botonXX"  TYPE="button" value="I" onClick=document.location="InscribirAlumnos.php?id_ramo=<? echo $fila[id_ramo];?>&viene_de=listarRamos.php3&_FRMMODO=mostrar">
							  
							  <? }?>
							  <?php if ($fila['conex']==1 ) { ?> 
							  
							  <input class="botonXX"  type="button" value="SF" onClick=document.location="situacionFinal.php3?frmModo=mostrar&viene_de=listarRamos.php3&id_ramo=<? echo $fila[id_ramo];?>">
							  
							  <? }?>
							  <INPUT class="botonXX"  TYPE="button" value="A" onClick=document.location="contenido/listarContenidos.php3?viene_de=../listarRamos.php3&id_ramo=<? echo $fila[id_ramo];?>">
							  
							  <?	//if(($fila[prueba_nivel]==1)&&(( $_PERFIL==0 )||($_PERFIL==14))){	?>
							  <?	if(($fila[prueba_nivel]==1)){	?>
							  <?	//if($_PERFIL==14 && ($institucion==24977 || $institucion==25478)){	?>							  
							  <!--<INPUT class="botonXX"  TYPE="button" value="PN" onClick=document.location="notas/mostrarNotasNivel.php3?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">-->
							  <?	//}
							  if($_PERFIL==17 && ($institucion==24977 || $institucion==25478)){	?>							   <INPUT class="botonXX"  TYPE="button" value="PN" onClick=document.location="notas/mostrarNotasNivel.php3?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">
							  <?	}else{	?>							  							  							  
							  <INPUT class="botonXX"  TYPE="button" value="PN" onClick=document.location="notas/mostrarNotasNivel.php3?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3">
							  <?	}	?>							  							  							  
							  <? }?>			
							  
							  <?  //echo $_NOMBREUSUARIO;
							  if ($fila2["nombre_emp"]!=NULL){ ?>	
							     <!-- <INPUT class="botonXX"  TYPE="button" value="P" 
                                  onClick=document.location="planificacion/planificacion.php?id_ramo=<? //echo $fila[id_ramo];?>&&viene_de=../listarRamos.php3">--->
								  <INPUT class="botonXX"  TYPE="button" value="P" onClick=document.location="planis/planificacion.php?id_ramo=<? echo $fila[id_ramo];?>&&viene_de=../listarRamos.php3"> 
							 <? 
							 } ?>							  
							 <? if($fila['porc_examen']!=100 &&  $fila['porc_examen']!=NULL){?>
							  <INPUT class="botonXX"  TYPE="button" value="ES" onClick=document.location="examen/seteaExamen.php?caso=1&id_ramo=<? echo $fila[id_ramo];?>"> 
							 <? } ?>
							<input type="button" value="AP" onClick="window.location='seteaApreciacion.php?id_ramo=<? echo $fila[id_ramo];?>&caso=1&curso=<?=$curso;?>'" class="botonXX">
							<?
							if ($_PERFIL==0 or $_PERFIL==14 or $_PERFIL==26 or $_PERFIL==17){ ?>
							<input name="CP"  type="button" class="botonXX" id="CP" onClick="MM_openBrWindow('notas/config_porcentaje.php?id_ramo=<? echo $fila[id_ramo];?>','','scrollbars=yes,width=1000,height=300')" value="CP">
						  <? } 						
						  $conexper = $fila['conexper'];
						 
    /*AQUI ESTOY YO*/       if ($conexper==1){?>
    	
		<input name="SFP"  type="button" class="botonXX" id="SFP" onClick="window.location = 'seteaSituacionFinalPeriodo.php?&id_ramo=<? echo $fila[id_ramo];?>&caso=1&curso=<?=$curso;?>'" value="SFP">
						  <? } 	
						  //if($_PERFIL==0){
							  
                           if($fila['prueba_especial']==1){?>
    	
		<input name="PE"  type="button" class="botonXX" id="PE" onClick="window.location = 'prueba_especial.php?&id_ramo=<?=$fila[id_ramo];?>&curso=<?=$curso;?>'" value="PE">
						  <? } //}
						  if($fila['bool_nquiz']==1){
						  ?>	
                          <input name="NQ"  type="button" class="botonXX" id="NQ" onClick="window.location =' notasqz/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="NQ">
                          <?php }
						  if($fila['conexquiz']==1){
						  ?>	
                          <input name="EXP"  type="button" class="botonXX" id="EXQ" onClick="window.location ='examen_quiz/examen_quiz.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="EXP">
                          <?php }
						  if($fila['coef2']==1){ ?>
						  <input name="ECF2"  type="button" class="botonXX" id="ECF2" onClick="window.location ='coef2/examen.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="ECF2">
						  <? }
                           if($fila['bool_pu']==1){ ?>
						  <input name="PU"  type="button" class="botonXX" id="PU" onClick="window.location =' notaspu/grilla_notas_jscrip/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="PU">
						  <? }?>
                          <!--<? if($plani!=NULL){?>
                          <input type="button" onClick="window.location='../../../../../planificacion/planificacion.php?id_ramo=<? echo $fila['id_ramo'];?>&viene_de=../listarRamos.php3'" value="PD" class="botonXX">
                          <? }?>-->
                          <?php //if($_PERFIL==0){?>
                          <input name="PP"  type="button" class="botonXX" id="PP" onClick="window.location =' notas/notas_porcentaje/new_mostrarNotas.php?truncado=<?php echo $fila['truncado']; ?>&id_ramo=<? echo $fila[id_ramo];?>&id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="PP">
                          <?php //}?>
                         
                            <? //if($_PERFIL==0){
								if($fila['bool_psintesis']==1){;
								?>
                          <input type="button" onClick="window.location='psintesis/psintesis.php?id_ramo=<? echo $fila[id_ramo];?>&viene_de=../listarRamos.php3'" value="PS" class="botonXX">
                          <? 
								}
						  //}?>
                            <? 
								if($fila['notagrupo']==1){;
								?>
                          <input type="button" onClick="grupon(<? echo $fila['id_ramo'];?>,<?php echo $_CURSO ?>)" value="NG" class="botonXX">
                          <? 
								
						  }?>
                          <?php //if($_PERFIL==0){?>
                          <input name="BA" type="button" class="botonXX"  value="BA"  onClick="window.location='bitacora/bitacora.php?curso=<? echo $_CURSO;?>&ramo=<? echo $fila['id_ramo'];?>'" > 
                          <?php //}?>
						  </td>
						</tr>
			             <?php
						 
						
					   }
				}
			?>		
		</table>
		
		
								<?
								if ($cant_errores>0){ ?>	  
	                                  <br>
									  <table width="80%" border="1"  cellpadding="0" cellspacing="0">
									  <tr>
									  <td bgcolor="#FFFFFF">
										  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="0">
											<tr>
											  <td width="10%"><div align="center"><img src="../../../../../icono_atencion.gif" width="33" height="28"></div></td>
											  <td><font face="Verdana, Arial, Helvetica, sans-serif" size="1" >Atenci&oacute;n esta p&aacute;gina contiene <font color="#FF0000"><b><?=$cant_errores?></b></font> observaciones, las cuales debe corregir. </font></td>
											</tr>
											<tr>
											  <td>&nbsp;</td>
											  <td>
											   <? if ($tipo_error_1==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Falta informaci&oacute;n, </font> En uno o más campos falta informaci&oacute;n para determinar ciertos procesos. </font><br><? } ?>
											   <? if ($tipo_error_2==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1" ><font color="#FF0000">- Información incorrecta, </font> Información errónea o no concuerda con la información requerida. </font><br><? } ?>
											   <? if ($error_conf==1){ ?><font face="Verdana, Arial, Helvetica, sans-serif" size="1"><font color="#FF0000">*</font> Entre a la configuración del Curso y corriga la información faltante</font><? } ?>
											   
											   <br>											   											  
											 </td>
											</tr>
										  </table>
									  </td>
									  </tr>
									  </table>
							 <? } ?>
		
		
		</form>
	</center>
			  
<? }else{  ?>
      </td>
	  </tr>
	  </table>
 <? } ?>	  
 
 <?     pg_close($conn);
	pg_close($connection);?>
    								  
								  
								  <!-- fin codigo antiguo --> </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2"><? include("../../../../../cabecera/menu_inferior.php"); ?> </td>
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
<div id="ramogrupo" title="Agrupar Notas"></div>
<div id="bitacora" title="Historial Asignatura"></div>
<div id="nact"></div>
<div id="ncanal" title="Nuevo canal de comunicaci&oacute;n"></div>
</body>
</html>
