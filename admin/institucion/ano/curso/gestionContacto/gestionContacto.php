<?php require('../../../../../util/header.inc');?>

<?php 
	if ($ano){
		$_ANO=$ano;
		if(!session_is_registered('_ANO')){
			session_register('_ANO');
	  	};
	}
	if ($curso){
		$_CURSO=$curso;
		if(!session_is_registered('_CURSO')){
			session_register('_CURSO');
	  	};
	}

//echo $_MENU."--".$_CATEGORIA."---".$_ITEM;
	$institucion	=$_INSTIT;
	$ano			=$_ANO;
	$curso			=$_CURSO;	
	$_POSP          = 5;
	
	$_bot           = 5;
	
	$sql="SELECT * FROM perfil_curso WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL."";
		if($_PERFIL!=0){
			$sql.=" AND rut_emp=".$_NOMBREUSUARIO;
		}
		//echo $sql;
		$rs_acceso = pg_exec($conn,$sql) or die(pg_last_error($sql));
		//curso.ensenanza=".pg_result($rs_acceso,3)."
		
		if(pg_num_rows($rs_acceso)!=0 && $_PERFIL!=0){
			/*$whe_perfil_curso=" AND curso.ensenanza in (";
			for($i=0;$i<pg_num_rows($rs_acceso);$i++){
				$fila_acceso = pg_fetch_array($rs_acceso,$i);
				if($i==0){
					$whe_perfil_curso.=$fila_acceso['cod_tipo'];
				}else{
					$whe_perfil_curso.=",".$fila_acceso['cod_tipo'];
				}
			}*/
			$whe_perfil_curso.= /*)*/"  AND id_curso in(";
			
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
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)){$whe_perfil_ano=" and id_ano=$ano";}
			if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=25)&&($_PERFIL!=19)&&($_PERFIL!=2)&&($_PERFIL!=20)&&($_PERFIL!=27)){$whe_perfil_curso=" and curso.id_curso=$curso";}
		}
	if (trim($_url)=="") $_url=0;
	//imprime_array($_SESSION);

?>


 <?
if ($_PERFIL==15 or $_PERFIL==16) {?>
<script language="javascript">
			 alert ("No Autorizado");
			 window.location="../../../../../index.php";
		 </script>

<? } ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar   </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--p
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

 
		 
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}		 
		
//-->
</script>
		<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>

<script type="text/javascript" src="../../../../clases/jquery/jquery.js"></script>
<script>
$( document ).ready(function() {
    cargaPeriodo();
	
	
	
});


function cargaPeriodo(){
var funcion =1;
var parametros= "funcion="+funcion;
$.ajax({
		 		  url:'contGestion.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
					 $("#lper").html(data);
		 			     
		 			  } 
		 		  })
	
}


function creaPeriodo(){
	var funcion=2;
	var parametros= "funcion="+funcion;
   $.ajax({
	  url:'contGestion.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	    //alert(data);
		$("#diag").html(data);
		
			   $("#diag").dialog({
				  modal: true,
				  text: '',
				  width: 400,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
				  title: "Crear Periodo",
		
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
        {
            text: "Guardar",
            "class": 'saveButtonClass',
            click: function() {
            	savePeriodo();
				//$(this).dialog("close");
            }
        }],
   
			   });
		  }
	  });  
}

function savePeriodo(){
var funcion=3;
var inicio = $("#fini").val();
var termino = $("#fter").val();

//se cambia los formatos de las fechas y horas para comparar
 var cfini = inicio.split("/").reverse().join("-");
 var cfter = termino.split("/").reverse().join("-");
 
 cfini = new Date(cfini);
 cfter = new Date(cfter); 
 
 if(inicio.length==0){
	alert("Debe ingresar Fecha Inicio periodo");
}
else if(termino.length==0){
	alert("Debe ingresar Fecha T\xe9rmino periodo")
}

else if(cfini > cfter){
	alert("Fecha Inicio debe ser menor a Fecha T\xe9rmino");
}
else{
var parametros = "funcion="+funcion+"&ini="+inicio+"&ter="+termino;
	$.ajax({
		 		  url:'contGestion.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
					//console.log(data);
		 			      if (data==1){ 
					        alert("Datos Agregados. Puede cerrar esta ventana");
							 cargaPeriodo(); 
					       
					      } 
						  else if (data==2){ 
					        alert("Ya existen periodos con fecha similares");
					      } 
		 			  } 
		 		  })
	}
 
}
function ingPer(p){
var funcion=4;
 var txTit = $("#fec"+p).text();

var parametros= "funcion="+funcion+"&pe="+p;
   $.ajax({
	  url:'contGestion.php',
	  data:parametros,
	  type:'POST',
	 
	  success:function(data){
	    //alert(data);
		$("#carg").html(data);
		
			   $("#carg").dialog({
				  modal: true,
				  text: '',
				  width: '100%',
				  height: 1000,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
				  title: "Ingresar informaci&oacute;n periodo "+txTit,
		
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        
        }],
   
			   });
		  }
	  });  
	
}
function cargacurso(c){
var funcion =5;
var per = $("#ip").val();
var parametros= "funcion="+funcion+"&cu="+c+"&per="+per;
$.ajax({
		 		  url:'contGestion.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
					 $("#pcur").html(data);
		 			     
		 			  } 
		 		  })
	
}


function saveRespuesta(al,campo,pr){
var funcion =6;
var per = $("#ip").val();
var an= <?php echo $_ANO ?>;
var cu = $("#cmb_curso").val();
var parametros= "funcion="+funcion+"&al="+al+"&re="+campo+"&per="+per+"&an="+an+"&cu="+cu+"&pr="+pr;
$.ajax({
		 		  url:'contGestion.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
					// $("#pcur").html(data);
		 			  console.log(data);   
		 			  } 
		 		  })
}

function revisaRes(ipe){
	
var funcion =7;
var parametros= "funcion="+funcion+"&per="+ipe;
//alert(parametros);
$.ajax({
		 		  url:'contGestion.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
					// $("#lper").html(data);
		 			 // console.log(data);  
					  if(data==1){
						 window.open('generaExcel.php?ipe='+ipe,'_blank');
					}else{
					if(confirm("No se ha ingresado la evaluaci\xf3n de todos los alumnos, \xbfDesea descargar el archivo de todas formas?")){
					window.open('generaExcel.php?ipe='+ipe,'_blank');
					}
						
					}
					   
		 			  } 
		 		  })
	
}

function delPer(p){
if (confirm("\xbfSeguro desea eliminar periodo?")){
	var funcion =8;
var parametros= "funcion="+funcion+"&per="+p;
$.ajax({
		 		  url:'contGestion.php',
		 		  data:parametros,
		 		  type:'POST',
		 		  success:function(data){
 					if(data==1){
					alert("Periodo eliminado");
					 cargaPeriodo();
					}		 			     
		 			  } 
		 		  })
	}	
}
</script>
<style>
div.ui-dialog{
	font-size:12px;
	}
div.ui-datepicker{
	font-size:12px;
	}

</style>

</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../../../cabecera/menu_superior.php");?>
					</td></tr></table>
					
					</td>
                  
                  </tr>
               
					<!-- FIN DE COPIA DE CABECERA -->
                 
                </table></td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top">
					  <table><tr><td><? $menu_lateral="3_1";?><?
					  
						 include("../../../../../menus/menu_lateral.php");
						 
						 
						 ?>
						 
						 
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
                              <tr>
                                <td valign="top"><table WIDTH="650" BORDER="0" CELLSPACING="1" CELLPADDING="3">
                                  <TR height=15>
                                    <TD width="600" class="tableindex">Gesti&oacute;n de Contactos</TD>
                                  </TR>
                                  <TR height=15>
                                    <TD>&nbsp;</TD>
                                  </TR>
                                  <TR height=15>
                                    <TD align="right"><input type="button" name="button" id="button" value="Agregar Periodo" class="botonXX" onClick="creaPeriodo()"></TD>
                                  </TR>
                                  <TR height=15>
                                    <TD>&nbsp;</TD>
                                  </TR>
                                  <TR height=15>
                                    <TD><div id="lper"></TD>
                                  </TR>
							
                                </table>                                     
                                  <br>
<br>
<br>
<div id="eva">
</div>     
        </td>
                              </tr></table>                   </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../../../cabecera/menu_inferior.php"); ?></td>
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
<div id="diag"></div>
<div id="carg"></div>
</body>
</html>
