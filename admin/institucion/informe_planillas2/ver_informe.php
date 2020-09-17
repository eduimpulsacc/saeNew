<?php require('../../../util/header.inc');
$institucion =$_INSTIT;
$_POSP = 4;
$_bot = 7;

		if (!$__PLANTILLA){
		 $_PLANTILLA=$plantilla;
		session_register("_PLANTILLA");
		}
$creada=1;


?>
<? 
if($eliminar==1){
		/*$sqlElimina="update informe_plantilla set activa=0 where id_plantilla=".$plantilla;
		$resultElimina=pg_exec($conn, $sqlElimina);
			if (!$resultElimina) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlElimina);
			}*/
		$sql="DELETE FROM informe_concepto_eval WHERE id_plantilla=".$_PLANTILLA;
		$rs_delete = pg_exec($conn,$sql);
		
		$sql="DELETE FROM informe_area_item WHERE id_plantilla=".$_PLANTILLA;
		$rs_area=pg_exec($conn,$sql);
		
		$sql="DELETE FROM informe_plantilla WHERE id_plantilla=".$_PLANTILLA;
		$rs_informe = pg_exec($conn,$sql);
		
	header ("Location: listar_informe.php");
	exit;
}

/************ PERMISOS DEL PERFIL *************************/
if($_PERFIL==0){
	$ingreso = 1;
	$modifica =1;
	$elimina =1;
	$ver =1;
}else{
	/*if($nw==1){
		$_MENU =$menu;
		session_register('_MENU');
		$_CATEGORIA = $categoria;
		session_register('_CATEGORIA');
	}*/
	$sql = "SELECT bool_i,bool_m,bool_e,bool_v FROM perfil_menu WHERE rdb=".$institucion." AND id_perfil=".$_PERFIL." AND id_menu=".$_MENU." AND id_categoria=".$_CATEGORIA;
	$rs_permiso = @pg_exec($conn,$sql) or die ("SELECT FALLO :".$sql);
	$ingreso = @pg_result($rs_permiso,0);
	$modifica =@pg_result($rs_permiso,1);
	$elimina =@pg_result($rs_permiso,2);
	$ver =@pg_result($rs_permiso,3);
}

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../../clases/jquery-ui-1.9.2.custom/css/smoothness/jquery-ui-1.9.2.custom.min.css">
<script type="text/javascript" src="../../clases/jquery-ui-1.9.2.custom/js/jquery-1.8.3.js"></script>
<script type="text/javascript" src="../../clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.min.js"></script>

<script language="JavaScript" type="text/JavaScript">
<!--

function ventana(){
	var plantilla = "<?=$plantilla;?>";
	var parametros = 'plantilla='+plantilla;
 $.ajax({
	  url:'salto_pagina.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
	    $("#salto_pagina").html(data);
		
			   $("#salto_pagina").dialog({
				  modal: true,
				  text: '',
				  width: 680,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
				  title:'Activar Salto de Pagina',
			 buttons: [
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
      ],
 });
	 }
      
	  })
	
}


function guarda_salto(x,y)
{
	//alert(x);
	//alert(y);
	
if($("#"+y+"").is(':checked')){
		var chk = 1;
		}else{
		var chk = 0;
		}
var funcion =1;	
var parametros = 'funcion='+funcion+'&id_cat='+x+'&chk='+chk;
//alert(parametros);
	
 $.ajax({
	  url:'salto_pagina.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		// alert(data)
		  if(data==1){
	    alert('Guardado ok!');
		  }else{
			alert("Error")	  
		}
     }
 });	
}


function get_salto(){
	
	
	
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


function duplica(plantilla){
var funcion=1;
var parametros = "funcion="+funcion+"&plantilla="+plantilla;
	  $.ajax({
			url:"plantillaDuplica/duplica.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
				  $("#dupli").html(data);
					  
				   $("#dupli").dialog({
				  modal: true,
				  text: '',
				  width: 680,
				  resizable: false,
				  show: "fold",
				  hide: "scale",
				  title:'Duplicar Plantilla Informe',
			 buttons: [
			  {
            text: "Duplicar",
            "class": 'cancelButtonClass',
            click: function() {
				duplicaPlantilla();
                //$(this).dialog("close");
            }
        },
        {
            text: "Cerrar",
            "class": 'cancelButtonClass',
            click: function() {
                $(this).dialog("close");
            }
        },
      ],
 });
	 
		        }
		    })

}


function tipense(cbe){
var funcion=2;
var parametros = "funcion="+funcion+"&cbe="+cbe;
	  $.ajax({
			url:"plantillaDuplica/duplica.php",
			data:parametros,
			type:'POST',
			success:function(data){
			
			 $("#com").html(data);
		        }
		    })
}


function duplicaPlantilla(){
	var funcion=3;
	var plantilla =  $("#plan").val();
	var pa = $("#pa").is(':checked')?1:0;
	var sa = $("#sa").is(':checked')?1:0;
var ta= $("#ta").is(':checked')?1:0;
var cu= $("#cu").is(':checked')?1:0;
var qu= $("#qu").is(':checked')?1:0;
var sx= $("#sx").is(':checked')?1:0;
var sp= $("#sp").is(':checked')?1:0;
var oc= $("#oc").is(':checked')?1:0;
var nv= $("#nv").is(':checked')?1:0;
var dc= $("#dc").is(':checked')?1:0;
var un= $("#un").is(':checked')?1:0;
var duo= $("#duo").is(':checked')?1:0;
var tre= $("#tre").is(':checked')?1:0;
var cat= $("#cat").is(':checked')?1:0;
var quince= $("#quince").is(':checked')?1:0;
var diezseis=  $("#diezseis").is(':checked')?1:0;
var diecisiete=  $("#diecisiete").is(':checked')?1:0;
var dieciocho=  $("#dieciocho").is(':checked')?1:0;
var diecinueve=  $("#diecinueve").is(':checked')?1:0;
var veinte=  $("#veinte").is(':checked')?1:0;
var veintiuno=  $("#veintiuno").is(':checked')?1:0;
var veintidos=  $("#veintidos").is(':checked')?1:0;
var veintitres=  $("#veintitres").is(':checked')?1:0;
var veinticuatro=  $("#veinticuatro").is(':checked')?1:0;
var veinticinco=  $("#veinticinco").is(':checked')?1:0;

var tipo_ensenanza = $("#cmbEns").val();
var parametros = "funcion="+funcion+"&plantilla="+plantilla+"&pa="+pa+"&sa="+sa+"&ta="+ta+"&cu="+cu+"&qu="+qu+"&sx="+sx+"&sp="+sp+"&oc="+oc+"&nv="+nv+"&dc="+dc+"&un="+un+"&duo="+duo+"&tre="+tre+"&cat="+cat+"&quince="+quince+"&diezseis="+diezseis+"&tipo_ensenanza="+tipo_ensenanza+"&diecisiete="+diecisiete+"&dieciocho="+dieciocho+"&diecinueve="+diecinueve+"&veinte="+veinte+"&veintiuno="+veintiuno+"&veintidos="+veintidos+"&veintitres="+veintitres+"&veinticuatro="+veinticuatro+"&veinticinco="+veinticinco;
	  $.ajax({
			url:"plantillaDuplica/duplica.php",
			data:parametros,
			type:'POST',
			success:function(data){
			console.log(data);
			if(data==1){
				alert("Plantilla Duplicada")
			}else{
				alert("Error al guardar");
			}
		        }
		    })
	
	
}

 
//-->
</script>
<script>
<!--
function Confirmacion(form){
		var pla=form.hiddenPlantilla.value;
		if(confirm('¿ESTA SEGURO DE ELIMINAR ESTOS DATOS?') == false){ return; };
			//window.location='procesoPlantilla.php?plantilla=pla&eliminar=1'
			form.action='ver_informe.php?eliminar=1&plantilla=<? echo $plantilla;?>';
			form.submit(true);
		};
function Modifica(form){
		form.target='_parent';
		form.action='modificarPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

function agregaReg(form){
		form.target='_parent';
		form.action='../plantillaModifica/agregarRegistrosPlantilla.php';
		//form.action='seteaPlantilla.php?plantilla=<? echo $plantilla;?>&caso=3';
		form.submit(true);
}

function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
//-->
</script>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../cortes/b_ayuda_r.jpg','../../../cortes/b_info_r.jpg','../../../cortes/b_mapa_r.jpg','../../../cortes/b_home_r.jpg')">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			<!-- <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top"> <td>
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			<?   //include("../../../cabecera/menu_superior.php");?>
			<!--</td></tr></table>
</td></tr></table>-->
			
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle">
				<table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr align="left" valign="top">
                    <td width="100%" height="75" valign="middle">
					<!-- <img src="../../../cortes/logo_colegio.jpg" width="155px" height="75">-->
					<?   include("../../../cabecera/menu_superior.php");?>
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
					  <table><tr><td><?
					     $menu_lateral = 2;
						 include("../../../menus/menu_lateral.php");
						 ?>
					  </td></tr></table>
					  
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"><table width="100%" height="100%">
							<tr><td class="fondo">Informe de Personalidad</td></tr>
                              <tr><td valign="top"><form method="post" >
                              <? $cont_radio=0;  ?>
                              <table width="76%" border="0" align="left">
                                <tr>
                                  <td colspan="2" class="cuadro01">1.-
                                        <?php if($creada!=1){
        echo "Seleccione el Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe.";
		}else{
		echo "Tipo de Ense&ntilde;anza al que aplicar&aacute; este informe:";
		}
		?>
                                  </font>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td width="92%" class="textosesion"><?php 
	 	$sqlEns="select distinct tipo_ensenanza.cod_tipo, tipo_ensenanza.nombre_tipo from  tipo_ense_inst inner join tipo_ensenanza on tipo_ense_inst.cod_tipo=tipo_ensenanza.cod_tipo where tipo_ense_inst.rdb='".$institucion."' and tipo_ense_inst.estado=0 or tipo_ense_inst.estado=1";
		$resultEns=pg_Exec($conn,$sqlEns);
			if (!$resultEns) {
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>'.$sqlEns);
			}

	 ?>
                                      <?php if($creada!=1){?>
                                      <select name="cmbEns" id="cmbEns">
                                        <option value="0" selected>Seleccione Tipo de Ense&ntilde;anza</option>
                                        <?php
		  
		  for($cEns=0 ; $cEns<pg_numrows($resultEns) ; $cEns++){
			  $filaEns=pg_fetch_array($resultEns,$cEns);
			  echo "<option value=".$filaEns['cod_tipo'].">".$filaEns['nombre_tipo']."</option>";	
		  }//fin for
		  
		  ?>
                                      </select>
                                      <?php }else{ //fin if($creada!=1)
				$sqlTraeEns="select nombre_tipo from tipo_ensenanza inner join informe_plantilla on tipo_ensenanza.cod_tipo=informe_plantilla.tipo_ensenanza where informe_plantilla.id_plantilla=".$plantilla;
				$resultTraeEns=pg_Exec($conn,$sqlTraeEns);
					if (!$resultTraeEns) {
						error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>'.$sqlTraeEns);
					}else{
				
				$filaTraeEns=@pg_fetch_array($resultTraeEns,0);
				}
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeEns['nombre_tipo'];
				echo "</font>";
			}
			?>
                                  </td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">2.-
                                        <?php 
	  if($creada!=1){
	  echo "Seleccione grados a los que aplica esta Plantilla de Informe.";
	  }else{
	  echo "Grados a los que aplica esta Plantilla de Informe:";
	  }
	  ?>
&nbsp; <font size="2" face="Arial, Helvetica, sans-serif"><font size="1">Ed. Parvularia: SC=</font><font size="1" face="Arial, Helvetica, sans-serif"> 1&ordm; A&Ntilde;O, NMME= 2&ordm; A&Ntilde;O, NMMA= 3&ordm; A&Ntilde;O, 1NT= 4&ordm; A&Ntilde;O, 2NT= 5&ordm; A&Ntilde;O</font></font></font></td>
                                </tr>
                                <?php if($creada!=1){?>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">
                                    <input name="pa" type="checkbox" id="pa" value="1">
      PRIMER A&Ntilde;O
      <input name="sa" type="checkbox" id="sa" value="1">
      SEGUNDO A&Ntilde;O
      <input name="ta" type="checkbox" id="ta" value="1">
      TERCER A&Ntilde;O
      <input name="cu" type="checkbox" id="cu" value="1">
      CUARTO A&Ntilde;O </font></td>
                                </tr>
                                <tr>
                                  <td width="8%">&nbsp;</td>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">
                                    <input name="qu" type="checkbox" id="qu" value="1">
      QUINTO A&Ntilde;O
      <input name="sx" type="checkbox" id="sx" value="1">
      SEXTO A&Ntilde;O
      <input name="sp" type="checkbox" id="sp" value="1">
      SEPTIMO A&Ntilde;O
      <input name="oc" type="checkbox" id="oc" value="1">
      OCTAVO A&Ntilde;O</font></td>
                                </tr>
                                <?php } else{?>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td colspan="2" class="textosesion">
                                    <?php 
		$sqlTraeGrados="SELECT * FROM informe_plantilla WHERE id_plantilla=".$plantilla;
		$resultGrados=pg_Exec($conn, $sqlTraeGrados);
			if (!$resultGrados) {
				error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeGrados);
			}
		for($countGr=0 ; $countGr<pg_numrows($resultGrados) ; $countGr++){
			$filaGr=pg_fetch_array($resultGrados);
			if ($filaGr['pa']==1) echo "PRIMERO   ";
			if ($filaGr['sa']==1) echo "SEGUNDO   ";
			if ($filaGr['ta']==1) echo "TERCERO   ";
			if ($filaGr['cu']==1) echo "CUARTO   ";
			if ($filaGr['qu']==1) echo "QUINTO   ";
			if ($filaGr['sx']==1) echo "SEXTO  ";
			if ($filaGr['sp']==1) echo "SEPTIMO   ";
			if ($filaGr['oc']==1) echo "OCTAVO   ";
			if ($filaGr['nc']==1) echo "NOVENO   ";
			if ($filaGr['dc']==1) echo "DECIMO   ";
			if ($filaGr['un']==1) echo "UNDECIMO   ";
			if ($filaGr['tre']==1) echo "DECIMO TERCER   ";
			if ($filaGr['duo']==1) echo "DUODECIMO   ";
			if ($filaGr['cat']==1) echo "DECIMO CUARTO   ";
			if ($filaGr['quince']==1) echo "DECIMO QUINTO   ";
			if ($filaGr['diezseis']==1) echo "DECIMO SEXTO   ";
			if ($filaGr['diecisiete']==1) echo "DECIMO SEPTIMO   ";
			if ($filaGr['dieciocho']==1) echo "DECIMO OCTAVO   ";
			if ($filaGr['diecinueve']==1) echo "DECIMO NOVENO   ";
			if ($filaGr['veinte']==1) echo "VIGESIMO   ";
			if ($filaGr['veintiuno']==1) echo "VIGESIMO PRIMERO   ";
			if ($filaGr['veintidos']==1) echo "VIGESIMO SEGUNDO   ";
			if ($filaGr['veintitres']==1) echo "VIGESIMO TERCERO  ";
			if ($filaGr['veinticuatro']==1) echo "VIGESIMO CUARTO  ";
			if ($filaGr['veinticinco']==1) echo "VIGESIMO QUINTO   ";
		}
		 ?>
                                  </font>&nbsp;</td>
                                </tr>
                                <?php }?>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">3.-
                                        <?php 
	  if($creada!=1){
	  echo "Asigne un nombre a la nueva Plantilla de Informe.";
	  }else{
	  echo "Nombre de la nueva Plantilla de Informe:";
	  }
	  ?>
                                  </font> &nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td class="textosesion"><font size="2" face="Arial, Helvetica, sans-serif">
                                    <?php if($creada!=1){
		echo "Nombre:";?>
                                    <input name="txtNombrePla" type="text" id="txtNombrePla" size="50" maxlength="50">
                                    <?php }else{
				$sqlTraeNombre="select nombre, orientacion from informe_plantilla where id_plantilla=".$plantilla;
				$resultTraeNombre=pg_Exec($conn, $sqlTraeNombre);
				if (!$resultTraeNombre) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeNombre);
				}
				$filaTraeNombre=pg_fetch_array($resultTraeNombre,0);
				echo "<font size=2 face=Arial, Helvetica, sans-serif>";
				echo $filaTraeNombre['nombre'];
				echo "</font>";
	  		} ?>
                                  </font></td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <!--    <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">4.- 
	  <?php 
		// echo "FORMATO DE IMPRESION";
	  ?>
	  </font></td>
    </tr>
     <tr> 
      <td colspan="2"><font size="1" face="Arial, Helvetica, sans-serif">
	  <?php // if($creada!=1){?>
	          VERTICAL 
        <input type="radio" name="orientacion" value="0">
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
	  HORIZONTAL 
        <input type="radio" name="orientacion" value="1">
		<?php /*}else{
		if($filaTraeNombre['orientacion']==1) $impresion="HORIZONTAL";
		if($filaTraeNombre['orientacion']==0) $impresion="VERTICAL";
		}
		echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;", $impresion;*/
		 ?>
        </font></td>
    </tr>
	<TR><TD>&nbsp;</TD></TR> -->
                                <tr>
                                  <td colspan="2" class="cuadro01">4.- Asigne el nombre para el encabezado del informe con el que aparecera en el Informe. </font> &nbsp;</td>
                                </tr>
                                <tr>
                                  <td>&nbsp;</td>
                                  <td class="textosesion">
                                    <?php if($creada!=1){
				echo "T&iacute;tulo Reporte &nbsp;&nbsp;3:";?>
                                    <input name="txtNombreTitulo1" type="text" id="txtNombreTitulo1" size="30" maxlength="100">
                                    <?		echo "<br>T&iacute;tulo Reporte 18:";?>
                                    <input name="txtNombreTitulo2" type="text" id="txtNombreTitulo2" size="30" maxlength="100">
                                    <?php }else{
				$sqlTraeTitulo="select titulo_informe1, titulo_informe2 from informe_plantilla where id_plantilla=".$plantilla;
				$resultTraeTitulo=pg_Exec($conn, $sqlTraeTitulo);
				if (!$resultTraeTitulo) {
					error('<B> ERROR :</b>Error al acceder a la BD. (3)</B>'.$sqlTraeTitulo);
				}
				$filaTraeTitulo=pg_fetch_array($resultTraeTitulo,0);	
					echo "Reporte &nbsp;&nbsp;3: ".$filaTraeTitulo['titulo_informe1']."<br>";	
					echo "Reporte 18: ".$filaTraeTitulo['titulo_informe2'];	
			} ?>
            
            <?	$sql_activa = "SELECT activa FROM informe_plantilla WHERE id_plantilla=".$plantilla;
            	$res_activa = pg_Exec($conn, $sql_activa);
            	$arr_activa = pg_fetch_array($res_activa);
				$activa = $arr_activa['activa'];
				if ($activa == 1) {
					$act_value  = "DESACTIVAR";
				} else {
					$act_value = "ACTIVAR";
				}
            	
            ?>
                                  </font></td>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="cuadro01">5.- Tipo</td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><?php echo ($filaGr['tipo']==0)?"Informe de Personalidad":"Informe Diagn&oacute;stico"; ?>&nbsp;</td>
                                </tr>
                                <tr>
                                  <td colspan="2"><hr align="center" noshade size="1" color="#48d1cc"></td>
                                </tr>
                                <tr>
                                  <td colspan="2">         
								      <input class="botonXX"  type="button" name="cancelar" value="VOLVER" onClick="MM_goToURL('parent','listar_informe.php');return document.MM_returnValue">
									  <? if($elimina==1){?>
								      <input class="botonXX"  type="button" name="eliminar" value="ELIMINAR" onClick="Confirmacion(this.form)">
									 <? } ?>
                                      <input type="hidden" name="hiddenPlantilla" value="<?php echo $plantilla?>">
                                      <? if($modifica==1){?>
									  <input class="botonXX"  type="button" name="cancelar" value="MODIFICAR" onClick="MM_goToURL('parent','modificar_informe.php?plantilla=<? echo $plantilla;?>');return document.MM_returnValue">
									 
                                      <input class="botonXX"  type="button" name="cancelar" value="CONCEPTOS" onClick="MM_goToURL('parent','conceptos.php?plantilla=<? echo $plantilla;?>');return document.MM_returnValue">
                                      <!--<input class="botonXX"  type="button" name="cancelar" value="AGREGAR REGISTROS" onClick="agregaReg(this.form)">-->
									   <input class="botonXX"  type="button" name="cancelar" value="CONFIGURAR" onClick="MM_goToURL('parent','crea_informe_4.php');return document.MM_returnValue">
									    <? } ?>
									  <input class="botonXX"  type="button" name="cancelar" value="PREVIEW" onClick="MM_goToURL('parent','preview.php?plantilla=<? echo $plantilla;?>');return document.MM_returnValue">
									  <? if($modifica==1){?>
                                      <input class="botonXX"  type="button" name="activar" value="<?=$act_value?>" onClick="MM_goToURL('parent','actions/habilitar.php?x=<?=$activa?>&y=<?=$plantilla?>');return document.MM_returnValue">
									  <? } ?>
                                      <input name="Submit" type="submit" class="botonXX" onClick="MM_goToURL('parent','cuadro_evaluacion.php?plantilla=<?=$plantilla?>');return document.MM_returnValue" value="EVALUACION">
                                   
                              <input class="botonXX" type="button" name="btn_salto" id="btn_salto" value="SALTO DE PAGINA" onClick="ventana()"> <?php if($_PERFIL==0){?> <input name="btn_dup" type="button" class="botonXX" value="DUPLICAR" onClick="duplica(<?=$plantilla?>)"><?php }?>                                
                                </td>
                                </tr>
                                <tr>
                                  <td colspan="2">&nbsp;</TD>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">NOTA:</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">ELIMINAR: Permite eliminar la plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">VOLVER : Vuelve al listado de Plantillas creadas.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">MODIFICAR : Permite Modificar el texto de registros creados en la Plantilla actual.</font></td>
                                </tr>
                                <tr>
                                  <td colspan="2" class="textosesion"><font size="1" face="Arial, Helvetica, sans-serif">AGREGAR REGISTROS : Permite Agregar AREAS, SUBAREAS E ITEMES a la Plantilla actual, tambi&eacute;n permite eliminar elementos de la Plantilla.</font></td>
                                </tr>
                             
                              </table>
                              </form></td></tr></table>                         </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="center" valign="middle"> 
                      <td height="45" colspan="2" class="piepagina">SAE Sistema 
                        de Administraci&oacute;n Escolar - 2005</td>
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
<div id="salto_pagina"></div>
<div id="dupli"></div>
</body>
</html>
