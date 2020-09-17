<?	require('../../../util/header.inc');
	
	$institucion	=$_INSTIT	;
	$ano			=$_ANO		;
	$_POSP = 3;
//	$_bot = 8;
	
	$sql="select situacion from ano_escolar where id_ano=$ano";
    $result =pg_exec($conn,$sql);
    $situacion=pg_result($result,0);


	
	
	/************ PERMISOS DEL PERFIL *************************/
	if($_PERFIL==0){
		$ingreso = 1;
		$modifica =1;
		$elimina =1;
		$ver =1;
		//show($_SESSION);
	}else{
		if($nw==1){
			$_MENU =$menu;
			session_register('_MENU');
			$_CATEGORIA = $categoria;
			session_register('_CATEGORIA');
		}
		$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
		$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
		$ingreso = @pg_result($rs_permiso,0);
		$modifica =@pg_result($rs_permiso,1);
		$elimina =@pg_result($rs_permiso,2);
		$ver =@pg_result($rs_permiso,3);
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html><head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script type="text/javascript" src="../../clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/jquery-ui.js"></script>
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<SCRIPT language="JavaScript">

$( document ).ready(function() {
   listadoEnse();
   listadpPeriodo();
   activaBC();
   
});

function listadoEnse(){
	var funcion =1;
	/*var ensen = $("#cmbENSENANZA").val();
	var perfil = $("#cmbPERFIL").val();*/
	var parametros ="funcion="+funcion+"&ano="+<?php echo $ano ?>;
	
	$.ajax({
		url:'contGrupo.php',
		data:parametros,
		type:'POST',
		success: function(data){
			$("#ense").html(data);
			getNivel(0);
			
			
		}
	})
}

function getNivel(ensenanza){
	var funcion =2;
	//var ensenanza = $("#ense").val();
	
	var parametros ="funcion="+funcion+"&ano="+<?php echo $ano ?>+"&ensenanza="+ensenanza;
	
	
	$.ajax({
		url:'contGrupo.php',
		data:parametros,
		type:'POST',
		success: function(data){
			$("#nivel").html(data);
			getAsig(0);
		//	activaBC();
			
		}
	})
	}


function getAsig(nivel){
	
	var funcion =3;
	var ensenanza = $( "#ense option:selected" ).val();
	
	var parametros ="funcion="+funcion+"&ano="+<?php echo $ano ?>+"&ensenanza="+ensenanza+"&nivel="+nivel;
	
	
	$.ajax({
		url:'contGrupo.php',
		data:parametros,
		type:'POST',
		success: function(data){
			$("#asignatura").html(data);
			//activaBC();
			
		}
	})
	}
	
	
function activaBC(){
	
	var funcion =4;
	var ensenanza = $( "#ense option:selected" ).val();
	var nivel = $( "#nivel option:selected" ).val();
	var asig = $( "#asignatura option:selected" ).val();
	
	var parametros ="funcion="+funcion+"&ano="+<?php echo $ano ?>+"&ensenanza="+ensenanza+"&nivel="+nivel+"&asig="+asig;
	
	$("#bcrea").html("");
	$("#tabla").html("");
	
	//if(ensenanza>0 && nivel>0 && asig>0 ){
		$.ajax({
			url:'contGrupo.php',
			data:parametros,
			type:'POST',
			success: function(data){
				$("#bcrea").html(data);
				
				
			}
		})
	//}
}

function muestraCreaGrupo(){
	var funcion =5;
	var ensenanza = $( "#ense option:selected" ).val();
	var nivel = $( "#nivel option:selected" ).val();
	var asig = $( "#asignatura option:selected" ).val();
	var per = $( "#periodo option:selected" ).val();
	var parametros ="funcion="+funcion+"&ano="+<?php echo $ano ?>+"&ensenanza="+ensenanza+"&nivel="+nivel+"&asig="+asig+"&per="+per;

	
	$.ajax({
			url:'contGrupo.php',
			data:parametros,
			type:'POST',
			success: function(data){
				$("#tabla").html(data);
				
				
			}
		})
}

function ngr(){
	var funcion =6;
	var ensenanza = $( "#ense option:selected" ).val();
	var nivel = $( "#nivel option:selected" ).val();
	var asig = $( "#asignatura option:selected" ).val();
	var per = $( "#periodo option:selected" ).val();
	var parametros ="funcion="+funcion+"&ano="+<?php echo $ano ?>+"&ensenanza="+ensenanza+"&nivel="+nivel+"&subsector="+asig+"&per="+per;
$.ajax({
				url:"contGrupo.php",
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
var totalporc=0;
var ensenanza = $( "#ense option:selected" ).val();
var nivel = $( "#nivel option:selected" ).val();
var asig = $( "#asignatura option:selected" ).val();
var per = $( "#periodo option:selected" ).val();
var orden = $( "#orden" ).val();

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
				  
		  var parametros = "funcion=7&porcentaje="+porcentaje+"&n1="+n1+"&n2="+n2+"&n3="+n3+"&n4="+n4+"&n5="+n5+"&n6="+n6+"&n7="+n7+"&n8="+n8+"&n9="+n9+"&n10="+n10+"&n11="+n11+"&n12="+n12+"&n13="+n13+"&n14="+n14+"&n15="+n15+"&n16="+n16+"&n17="+n17+"&n18="+n18+"&n19="+n19+"&n20="+n20+"&leccionario="+leccionario+"&ensenanza="+ensenanza+"&nivel="+nivel+"&subsector="+asig+"&orden="+orden+"&per="+per;
		
			$.ajax({
					url:"contGrupo.php",
					data:parametros,
					type:'POST',
					success:function(data){
					console.log(data);
					if(data==1){
						muestraCreaGrupo();
					}else{
					alert("Error al crear grupo");	
					}
			  }
			})
		
		}
}

function edifila(grupo){
	
var ensenanza = $( "#ense option:selected" ).val();
var nivel = $( "#nivel option:selected" ).val();
var asig = $( "#asignatura option:selected" ).val();
var per = $( "#periodo option:selected" ).val();
var ano = <?php echo $_ANO ?>;
	var parametros = "funcion=8&grupo="+grupo+"&ensenanza="+ensenanza+"&nivel="+nivel+"&subsector="+asig+"&per="+per+"&ano="+ano;
	
	$.ajax({
					url:"contGrupo.php",
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
				  
		  var parametros = "funcion=9&grupo="+grupo+"&porcentaje="+porcentaje+"&n1="+n1+"&n2="+n2+"&n3="+n3+"&n4="+n4+"&n5="+n5+"&n6="+n6+"&n7="+n7+"&n8="+n8+"&n9="+n9+"&n10="+n10+"&n11="+n11+"&n12="+n12+"&n13="+n13+"&n14="+n14+"&n15="+n15+"&n16="+n16+"&n17="+n17+"&n18="+n18+"&n19="+n19+"&n20="+n20+"&leccionario="+leccionario+"&orden="+orden;
		
			$.ajax({
					url:"contGrupo.php",
					data:parametros,
					type:'POST',
					success:function(data){
					//console.log(data);
					
					if(data==1){
							muestraCreaGrupo();
						}else{
						alert("Error al modificar grupo");	
					}
			  }
			})
		
		}
}


function elifila(grupo){
	var parametros = "funcion=10+&grupo="+grupo;
	if(confirm("\xbfSeguro de eliminar grupo de notas?\nSi elimina este grupo de notas las calificaciones asociadas perder\xe1n su validez. Le recomendamos que cree los nuevos grupos inmediatamente.")){
	$.ajax({
					url:"contGrupo.php",
					data:parametros,
					type:'POST',
					success:function(data){
						console.log(data);
						if(data==1){
							muestraCreaGrupo();
						}else{
						alert("Error al eliminar grupo");	
						}
						
					
			  }
			})
	}
}

function asigG(){
var tensenanza = $( "#ense option:selected" ).text().trim();
var tnivel = $( "#nivel option:selected" ).text().trim();
var tperiodo = $( "#asignatura option:selected" ).text().trim();
var tper = $( "#periodo option:selected" ).text().trim();

var ensenanza = $( "#ense option:selected" ).val();
var nivel = $( "#nivel option:selected" ).val();
var asig = $( "#asignatura option:selected" ).val();
var per = $( "#periodo option:selected" ).val();

tnivel = (nivel==0)?"TODOS LOS NIVELES":tnivel;
tperiodo = (per==0)?"TODOS LOS PERIODOS":tperiodo;
tensenanza = (ensenanza==0)?"TODOS LOS TIPOS DE ENSE\xD1ANZA":tensenanza;
tasig = (asig==0)?"TODAS LAS ASIGNATURAS":tensenanza;


if(confirm("Se asignar\xe1 esta configuraci\xf3n a "+tperiodo+", "+tensenanza+", "+tnivel+", "+tasig+", que tengan una configuraci\xf3n similar o que no tengan grupos configurados, por lo que esta operaci\xf3n puede durar varios minutos. \xbfDesea continuar?"))
	{
	


	var nano = $( "#nano" ).val();
	
	var parametros = "funcion=11&ensenanza="+ensenanza+"&nivel="+nivel+"&subsector="+asig+"&nano="+nano+"&per="+per;
	
	$.ajax({
					url:"contGrupo.php",
					data:parametros,
					type:'POST',
					success:function(data){
						console.log(data);
						alert("Datos modificados");
						muestraCreaGrupo();
						if(data==1){
							muestraCreaGrupo();
						}else{
						alert("Error al eliminar grupo");	
						}
						
					
			  }
			})
	
	}
}

function MM_goToURL() { //v3.0
	var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}

function listadpPeriodo(){
	var funcion =12;
	/*var ensen = $("#cmbENSENANZA").val();
	var perfil = $("#cmbPERFIL").val();*/
	var parametros ="funcion="+funcion+"&ano="+<?php echo $ano ?>;
	
	$.ajax({
		url:'contGrupo.php',
		data:parametros,
		type:'POST',
		success: function(data){
			$("#lper").html(data);
			//getNivel(0);
			
			
		}
	})
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

<style type="text/css">
<!--
.Estilo13 {font-size: 10px; font-family: Verdana, Arial, Helvetica, sans-serif; }
-->
</style>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg');
<? if($tipo==1){?>
	txt_ciclo();
<? }?>
"> 
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"> 
				<?
				include("../../../cabecera/menu_superior.php");
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
						include("../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top"></td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="99%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td>
                                  <table width="100%" border="0" cellspacing="o" cellpadding="0">
  <tr class="tableindex">
    <td colspan="2">Configurar Grupos de notas</td>
    
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr class="textosimple">
    <td>Periodo</td>
    <td><div id="lper"></div></td>
  </tr>
  <tr class="textosimple">
    <td>Tipo de Ense&ntilde;anza</td>
    <td><div id="ense"></div></td>
  </tr>
  <tr class="textosimple">
    <td>Nivel</td>
    <td><div id="nivel"></div></td>
  </tr>
  <tr class="textosimple">
    <td>Asignatura</td>
    <td><div id="asignatura"></div></td>
  </tr>
  
                                  </table>
                                 

								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES --><br>
<br>

                                    <div id="bcrea">&nbsp;</div>

 								  								  
								 <br>
<br>
	 <div id="tabla">&nbsp;</div>
								  
								  
								  </td>
                                </tr>
                              </table></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina"><? include("../../../cabecera/menu_inferior.php"); ?></td>
                    </tr>
                  </table></td>
              </tr>
            </table>
          </td>
          <td width="53" align="left" valign="top" background="../../../<?=$_IMAGEN_DERECHA?>">&nbsp;</td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<? pg_close($conn);?>