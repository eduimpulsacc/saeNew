<?php 
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
?>
<?php   
	$institucion	=$_INSTIT;
	echo $ano			=$_ANO;
	$curso			=$_CURSO;
	$ramo			=$_RAMO; 
	$frmModo		=$_FRMMODO;
	$empleado		=$_EMPLEADO;
    $_POSP = 5;
	$_bot           =5;
	$_MDINAMICO     = 1;
	$funcion = $_POST['funcion'];


		
		if(($frmModo=="ingresar")or($frmModo==""))
		{
			$frmModo = "mostrar"; 
		}
	
		
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=20)&&($_PERFIL!=28)&&($_PERFIL!=21)){$whe_perfil_ano=" and id_ano=$ano";}
if (($_PERFIL!=0)&&($_PERFIL!=14)&&($_PERFIL!=27)&&($_PERFIL!=25)&&($_PERFIL!=2)&&($_PERFIL!=32)&&($_PERFIL!=19)&&($_PERFIL!=31)&&($_PERFIL!=20)&&($_PERFIL!=21)&&($_PERFIL!=28)&&($_PERFIL!=29)&&($_PERFIL!=1)){$whe_perfil_curso=" and curso.id_curso=$curso";}	
		
			
	if (trim($_url)=="") $_url=0;
	
	
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
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">

<link rel="stylesheet" type="text/css" href="../vitacora_alumno/includes/jquery-ui-1.8.6.custom.css">
<SCRIPT language="JavaScript" src="../../../../../util/chkform.js"></SCRIPT>
<script type="text/javascript" src="../../../../clases/jqueryui/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="../../../../clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>

<script type="text/javascript">

	function cargartabla(form){
	
	var curso = $('#cmb_curso').val()
	var ano = "<?=$ano?>";
	frmModo = form.frmModo.value;
	var parametros = "frmModo="+frmModo+"&curso="+curso+"&ano="+ano;
	//alert(parametros);
		$.ajax({
		  url:'listaApoderado.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						$('#modulodatos').html(data);
						
						$("#modulodatos").html();
						}
				     }
		         })
	          } // fin funcion cargartabla
	
	
		function veralum(rut_apo){
			//alert("Aqui Buscaremos Alumnos");
			
			
	   var ano="<?=$ano?>"	
	   var rut_apo= rut_apo;
	   var curso = $('#cmb_curso').val()
	   var parametros = "rut_apo="+rut_apo+"&curso="+curso+"&ano="+ano;
	   //alert(parametros);
	  // return false;
	    $.ajax({
	  url:'alumnosrel.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data);
		$("#alumnosrel").html(data);
			   $("#alumnosrel").dialog({
				  modal: true,
				  title: "Alumnos",
				  width: 800,
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
			
			}
			
			
		function dialogalumno(rut_apo){
			//alert("Aqui Buscaremos Alumnos");
	   var ano = "<?=$ano?>"	
	   var rut_apo= rut_apo;
	   var parametros = "rut_apo="+rut_apo+"&ano="+ano;
	 // alert(parametros);
	    $.ajax({
	  url:'agregar_alumno.php',
	  data:parametros,
	  type:'POST',
	  success:function(data){
		 // alert(data);
		$("#agregaralumno").html(data);
			   $("#agregaralumno").dialog({
				  modal: true,
				  title: "Agregar Alumnos",
				  width: 600,
				    buttons: {
            "Cerrar": function(){
              $(this).dialog("close");
            }
          },
				  show: "fold",
				  hide: "fold"
			   });
		  }
	  });
			
			}
			
			
			
			
 function detalles_apo(rut_apo){
	 
	 
	 var ano = "<?=$ano?>"
	 var curso= $('#cmb_curso').val();
	 var frmModo= "mostrar";
	 
	 var parametros="rut_apo="+rut_apo+"&curso="+curso+"&ano="+ano+"&frmModo="+frmModo;
	 //alert(parametros);
	 
	 $.ajax({
		  url:'apoderado.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						
						$('#modulodatos').hide();
						
						$('#datos_apoderado').html(data);
						$("#datos_apoderado").html();
						$("#datos_apoderado").show();
						$("#combo_curso").hide();
						}
				     }
		         })
	 
	 }			
			
			
		function ocultadiv(){
			$("#modulodatos").toggle();
			$("#datos_apoderado").toggle();
			$("#combo_curso").show();
			}	
			
			
	function modifica_apoderado(rut_apod){
	 	 
	 var ano = "<?=$ano?>"
	 var curso= $('#cmb_curso').val();
	 var frmModo= "modificar";
	 
	 var parametros="rut_apod="+rut_apod+"&curso="+curso+"&ano="+ano+"&frmModo="+frmModo;
	 //alert(parametros);
	 
	 $.ajax({
		  url:'modifica_apo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						
						$('#datos_apoderado').hide();
						$('#modifica_apod').html(data);
						$("#modifica_apod").html();
						$("#modifica_apod").show();
						}
				     }
		         })
	 }			
	 
	 function ingresa_apoderado(){
	 var ano = "<?=$ano?>"
	 var curso= $('#cmb_curso').val();
	 var frmModo= "ingresar";
	 
	 var parametros="curso="+curso+"&ano="+ano+"&frmModo="+frmModo;
	 //alert(parametros);
	 
	 $.ajax({
		  url:'modifica_apo.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
				console.log(data);
					if(data==0){
					alert("Error al Cargar");
					}else{
						
						$('#modulodatos').hide();
						
						$('#modifica_apod').html(data);
						$("#modifica_apod").html();
						$("#modifica_apod").show();
						$("#combo_curso").hide();
						$('#modifica_apod').html(data);
						  $("#hdd_curso").val(curso);
						}
				     }
		         })
	 }		
	 
	 function ocultadiv2(){
			$("#datos_apoderado").toggle();
			$("#modifica_apod").hide();
			}	
			
	function ocultadiv3(){
			$("#modulodatos").show();
			$("#modifica_apod").hide();
			$("#combo_curso").show();
			}			
		
		
		

 function modificaApo(rut_apo){
	 
	 if($('#Region').val()==0){
		alert("Seleccione Region");
		return false;
	  }
	  if($('#Provincia' ).val()==0){
		alert("Seleccione Provincia");
		return false;
	  }
	  if($('#Comuna').val()==0){
		alert("Seleccione Comuna");
		return false;
	  }
	 
 var nombre_apo=$('#nombres').val();
 var ape_pat=$('#apellido_pat').val();
 var ape_mater=$('#apellido_mater').val();
 var telefono=$('#telefono').val();
 var celular=$('#celular').val();
 var direccion=$('#direccion').val();
 var numero=$('#numero').val();
 var Region=$('#Region').val();
 var Provincia=$('#Provincia').val();
 var Comuna=$('#Comuna').val();
 var lugar_trabajo=$('#lugar_trabajo').val();
 var cmbRELACION=$('#cmbRELACION').val();
 var nivel_edu=$('#nivel_edu').val();
 var chkSOS=$('#chkSOS').val();
 var profesion=$('#profesion').val();
 var cargo=$('#cargo').val();
 var email=$('#email').val();
 var modifica_apo=1;
 
	var parametros = "rut_apo="+rut_apo+"&modifica_apo="+modifica_apo+"&nombre_apo="+nombre_apo+"&ape_pat="+ape_pat+"&ape_mater="+ape_mater+"&telefono="+telefono+"&celular="+celular+"&direccion="+direccion+"&numero="+numero+"&Region="+Region+"&Provincia="+Provincia+"&Comuna="+Comuna+"&lugar_trabajo="+lugar_trabajo+"&cmbRELACION="+cmbRELACION+"&nivel_edu="+nivel_edu+"&chkSOS="+chkSOS+"&profesion="+profesion+"&cargo="+cargo+"&email="+email;
	//alert(parametros);
	//return false;
	$.ajax({
		  url:'guardarelacion.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				//alert(data);
					if(data==1){
					alert("Datos Modificados");
					$("#modifica_apod").hide();
					$('#modulodatos').show();
			      
					}else{
						alert("Error al Guardar");
						}
				     }
		         })
	
	
	
	}
 
 
 	function insertaapo(){
		
	if($('#rut').val()==0){
		alert("Escriba El Rut");
		$('#rut' ).focus();
		return false;
	  }
	  if($('#dig' ).val()==""){
		alert("Escriba Digito Rut");
		$('#dig' ).focus();
		return false;
	  }
	  if($('#nombres2').val()==0){
		alert("Escriba Nombre");
		$('#nombres2' ).focus();
		return false;
	  }	
	  if($('#apellido_pat2').val()==0){
		alert("Escriba Apellido Paterno");
		$('#apellido_pat2' ).focus();
		return false;
	  }	
	  if($('#apellido_mat2').val()==0){
		alert("Escriba Apellido Materno");
		$('#apellido_mat2' ).focus();
		return false;
	  }	
		
	if($('#Region').val()==0){
		alert("Seleccione Region");
		return false;
	  }
	  if($('#Provincia' ).val()==0){
		alert("Seleccione Provincia");
		return false;
	  }
	  if($('#Comuna').val()==0){
		alert("Seleccione Comuna");
		return false;
	  }	
	  
	   if($('#cmb_alumno').val()==0){
		alert("Seleccione alumno");
		return false;
	  }	
		
 var rut=$('#rut').val();
 var dig=$('#dig').val();	 
 var nombre_apo=$('#nombres2').val();
 var ape_pat=$('#apellido_pat2').val();
 var ape_mater=$('#apellido_mat2').val();
 var telefono=$('#telefono2').val();
 var celular=$('#celular2').val();
 var direccion=$('#direccion2').val();
 var numero=$('#numero2').val();
 var Region=$('#Region').val();
 var Provincia=$('#Provincia').val();
 var Comuna=$('#Comuna').val();
 var lugar_trabajo=$('#lugar_trabajo2').val();
 var cmbRELACION=$('#cmbRELACION2').val();
 var nivel_edu=$('#nivel_edu2').val();
 var profesion=$('#profesion2').val();
 var cargo=$('#cargo2').val();
 var email=$('#email2').val();
 var curso=$('#hdd_curso').val();
 var alumno=$('#cmb_alumno').val();
 var inserta_apo=1;
 
	var parametros = "rut="+rut+"&dig="+dig+"&inserta_apo="+inserta_apo+"&nombre_apo="+nombre_apo+"&ape_pat="+ape_pat+"&ape_mater="+ape_mater+"&telefono="+telefono+"&celular="+celular+"&direccion="+direccion+"&numero="+numero+"&Region="+Region+"&Provincia="+Provincia+"&Comuna="+Comuna+"&lugar_trabajo="+lugar_trabajo+"&cmbRELACION="+cmbRELACION+"&nivel_edu="+nivel_edu+"&profesion="+profesion+"&cargo="+cargo+"&email="+email+"&curso="+curso+"&alumno="+alumno;
	//alert(parametros);
	//return false;
	$.ajax({
		  url:'guardarelacion.php',
		  data:parametros,
		  type:'POST',
			success:function(data){
				console.log(data);
				//alert(data);
					if(data==1){
					alert("Datos Guardados");
					cargartabla(form);
					}
					else if(data==2){
					alert("Apoderado ya existe en la base de datos");
					
					}
					else{
						alert("Error al Guardar");
						}
				     }
		         })
	}
	
 	function descheck(form){
		if(form.responsable.checked==1){
			form.sostenedor.disabled=true;
			}else{
			form.sostenedor.disabled=false;	
			}
			
		if(form.sostenedor.checked==1){
			form.responsable.disabled=true;
			}else{
			form.responsable.disabled=false;	
			}
		
		}
 
		
		
		
		
</script>

	<script language="javascript">
//**********************************************************************************************************//
//-------------------------------------- CARGA ARREGLO PROVINCIA, COMUNA -----------------------------------//
//**********************************************************************************************************//
        //------------------------ PROVINCIA -----------------------------------//
                var ArrayProvincia = new Array();
                var contador_provincia;
                <?php        $SQL = "SELECT cor_pro,cod_reg,nom_pro FROM provincia ORDER BY nom_pro";
                                $Conexion = @pg_exec($conn,$SQL);
                                $i=0;
                                if (!$Conexion)
                                {
                                        echo("</script><br><center><table><tr><td><b>No se pudo establecer comunicación con la base de datos 1 </b></td></tr></table></center>");
                                        exit();
                                }
                                if (@pg_numrows($Conexion)!=0)
                                { 
                                        $filsprov = @pg_fetch_array($Conexion,0);
                                        for ($i=0;$i<@pg_numrows($Conexion);$i++)
                                        {
                                                $filsprov = @pg_fetch_array($Conexion,$i); ?>
                                                var ArrayFilProv = new Array(3);
                                                ArrayFilProv[0] = '<?php echo Trim($filsprov["cor_pro"])?>';
                                                ArrayFilProv[1] = '<?php echo Trim($filsprov["cod_reg"])?>';
                                                ArrayFilProv[2] = '<?php echo Trim($filsprov["nom_pro"])?>';
                                                ArrayProvincia[<?php echo $i?>] = ArrayFilProv;
                <?php                }
                                }
                                @pg_close($Conexion); ?>
                                contador_provincia = <?php echo $i?>;
        //---------------------- FIN PROVINCIA ---------------------------------//

        //-------------------------- COMUNA ------------------------------------//
                var ArrayComuna = new Array();
                var contador_comuna;
                <?php        $SQL = "SELECT cor_com,cor_pro,cod_reg,nom_com FROM comuna ORDER BY nom_com";
                                $Conexion = @pg_exec($conn,$SQL);
                                $i=0;
                                if (!$Conexion){
                                        echo("</script><br><center><table><tr><td><b>No se pudo establecer comunicación con la base de datos 2 </b></td></tr></table></center>");
                                        exit();
                                };
                                if (@pg_numrows($Conexion)!=0){
                                        $filscom = @pg_fetch_array($Conexion,0);
                                        for ($i=0;$i<@pg_numrows($Conexion);$i++){
                                                $filscom = @pg_fetch_array($Conexion,$i); ?>
                                                var ArrayFilCom = new Array(4);
                                                ArrayFilCom[0] = '<?php echo Trim($filscom["cor_com"])?>';
                                                ArrayFilCom[1] = '<?php echo Trim($filscom["cor_pro"])?>';
                                                ArrayFilCom[2] = '<?php echo Trim($filscom["cod_reg"])?>';
                                                ArrayFilCom[3] = '<?php echo Trim($filscom["nom_com"])?>';
                                                ArrayComuna[<?php echo $i?>] = ArrayFilCom;
                <?php                };
                                };
                                @pg_close($Conexion); ?>
                                contador_comuna = <?php echo $i; ?>;

        //----------------------- FIN COMUNA -----------------------------------//

//**********************************************************************************************************//
//-------------------------------------------- FIN ARREGLOS ------------------------------------------------//
//**********************************************************************************************************//

//**********************************************************************************************************//
//-------------------------------------------- LLENA COMBO -------------------------------------------------//
//**********************************************************************************************************//

        //----------------------- PROVINCIA-----------------------------------//
function LlenaProvincia(){
        var id_search;
        if (document.frm_aux.Region.options.selectedIndex!=-1 || document.frm_aux.Region.options[document.frm_aux.Region.options.selectedIndex].value!="null"){
                id_search = document.frm_aux.Region.options[document.frm_aux.Region.options.selectedIndex].value;
                if (id_search!=""){
                        document.frm_aux.Provincia.length = 0;
                        document.frm_aux.Provincia.options[document.frm_aux.Provincia.options.length++] = new Option("Seleccionar Provincia");
                        document.frm_aux.Provincia.options[document.frm_aux.Provincia.options.length - 1].value = "0";
                        document.frm_aux.Comuna.length = 0;
                        document.frm_aux.Comuna.options[document.frm_aux.Comuna.options.length++] = new Option("Seleccionar Comuna");
                        document.frm_aux.Comuna.options[document.frm_aux.Comuna.options.length - 1].value = "0";
                        for(i=0;i<=contador_provincia-1;i++){
                                if (id_search==ArrayProvincia[i][1]){
                                        document.frm_aux.Provincia.options[document.frm_aux.Provincia.options.length++] = new Option(ArrayProvincia[i][2]);
                                        document.frm_aux.Provincia.options[document.frm_aux.Provincia.options.length - 1].value = ArrayProvincia[i][0];
                                };
                        };
                };
        };
};
        //--------------------- FIN PROVINCIA---------------------------------//

        //------------------------- COMUNA ------------------------------------//
                function LlenaComuna(){
                        var id_search,id_search_aux;
                        if (document.frm_aux.Provincia.options.selectedIndex!=-1 || document.frm_aux.Provincia.options[document.frm_aux.Provincia.options.selectedIndex].value!="null"){
                                id_search = document.frm_aux.Region.options[document.frm_aux.Region.options.selectedIndex].value; 
                                id_search_aux = document.frm_aux.Provincia.options[document.frm_aux.Provincia.options.selectedIndex].value;
                                if (id_search!=""){
                                        document.frm_aux.Comuna.length = 0;
                                        document.frm_aux.Comuna.options[document.frm_aux.Comuna.options.length++] = new Option("Seleccionar Comuna");
                                        document.frm_aux.Comuna.options[document.frm_aux.Comuna.options.length - 1].value = "0";
                                        for(i=0;i<=contador_comuna-1;i++){
                                                if (id_search==ArrayComuna[i][2] && id_search_aux==ArrayComuna[i][1]){
                                                        document.frm_aux.Comuna.options[document.frm_aux.Comuna.options.length++] = new Option(ArrayComuna[i][3]);
                                                        document.frm_aux.Comuna.options[document.frm_aux.Comuna.options.length - 1].value = ArrayComuna[i][0];
                                                };
                                        };
                                };
                        };
                };
        //----------------------- FIN COMUNA -----------------------------------//

//**********************************************************************************************************//
//----------------------------------------- FIN LLENA COMBO ------------------------------------------------//
//**********************************************************************************************************//
  function SeleccionaCombo(Objeto, valor)
  	{
		
		for (i=0;i < Objeto.options.length; i ++) 
		{
		
			if (Objeto.options[i].value == valor)
			{
		
				Objeto.options[i].selected = true; 
			}
		}
	}

</script>
<? 

	 $str_Set_E = "{";

        if ($fila['region']!=""){
                $str_Set_E = $str_Set_E . "SeleccionaCombo(document.frm_aux.Region,".$fila['region'].");";
                $str_Set_E = $str_Set_E . "LlenaProvincia();";
        };
        if ($fila['ciudad']!=""){
                $str_Set_E = $str_Set_E . "SeleccionaCombo(document.frm_aux.Provincia,".$fila['ciudad'].");";
                $str_Set_E = $str_Set_E . "LlenaComuna();";
        };
        if ($fila['comuna']!=""){
                $str_Set_E = $str_Set_E . "SeleccionaCombo(document.frm_aux.Comuna,".$fila['comuna'].");";
        };

        $str_Set_E = $str_Set_E . "}";
?>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
 <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="589" align="left" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="53" height="722" align="left" valign="top" background="../../../../../<?=$_IMAGEN_IZQUIERDA?>">&nbsp;</td>
          <td width="0%" align="left" valign="top" bgcolor="f7f7f7"> 
              
			  
			  <!-- DESDE ACÁ DEBE IR CON INCLUDE -->
			
		  <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr align="left" valign="top">
                <td height="75" valign="middle"><? include("../../../../../cabecera/menu_superior.php"); ?></td>
			  </tr>
		  </table>
				
				</td>
              </tr>
              
              <tr align="left" valign="top"> 
                <td height="83"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr> 
                      <td width="27%" height="363" align="left" valign="top"> 
                        <?
						include("../../../../../menus/menu_lateral.php");
						?>
						
					  </td>
                      <td width="73%" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                          <tr> 
                            <td align="left" valign="top">&nbsp;</td>
                          </tr>
                          <tr> 
                            <td height="395" align="left" valign="top"> 
                              <table width="100%" border="0" cellpadding="0" cellspacing="0" class="cajaborde">
                                <tr> 
                                  <td><br>
								  
								  <!-- INCLUYO CODIGO DE LOS BOTONES -->
								

<!-- FIN CODIGO DE BOTONES -->

<!-- INICIO CUERPO DE LA PAGINA -->
   

 


<!-- FIN CUERPO DE LA PAGINA -->

<!-- INICIO FORMULARIO DE BUSQUEDA -->


<center>
<div id="combo_curso">
<table width="650" border="0" cellspacing="1" cellpadding="3">
    <tr height=15> 
      <td colspan=6> <table border=0 cellspacing=1 cellpadding=1>
          <tr valign="top"> 
           
            <td> 
					
			   </td>
          </tr>
          <tr valign="top"> 
            <td height="35" align=left class="textonegrita">  CURSO               </td>
            <td> <font face="arial, geneva, helvetica" size=2> <strong>:</strong> 
              </font> </td>
          <form name="form"   action="" method="post">
		    <input type="hidden" name="frmModo" value="<?=$frmModo ?>">
		  
		     <td> <font face="arial, geneva, helvetica" size=2> <strong> 
			  <?
			  // AQUI EL CAMPO SELEC QUE TIENE LOS CURSOS //  ?>
		  
                 <? 
$sql_curso= "SELECT curso.id_curso, curso.grado_curso, curso.letra_curso, tipo_ensenanza.nombre_tipo, curso.ensenanza, curso.cod_decreto  ";
$sql_curso = $sql_curso . "FROM curso INNER JOIN tipo_ensenanza ON curso.ensenanza = tipo_ensenanza.cod_tipo ";
$sql_curso = $sql_curso . "WHERE (((curso.id_ano)=".$ano.")) $whe_perfil_curso";
$sql_curso = $sql_curso . "ORDER BY curso.ensenanza, curso.grado_curso, curso.letra_curso; ";
$resultado_query_cue = pg_exec($conn,$sql_curso);
                 ?>
				 
		  <select name="cmb_curso" id="cmb_curso" class="ddlb_x" onChange="cargartabla(this.form);">
            <option value=0 selected>(Seleccione un Curso)</option>
			 <?
		     for($i=0 ; $i < @pg_numrows($resultado_query_cue) ; $i++)
		        {  
		        $fila = @pg_fetch_array($resultado_query_cue,$i); 
   		        $Curso_pal = CursoPalabra($fila['id_curso'], 1, $conn);
		        
		        if (($fila['id_curso'] == $cmb_curso) or ($fila['id_curso'] == $curso)){
		           echo "<option value=".$fila['id_curso']." selected>".$Curso_pal." </option>";
		        }else{	    
		           echo "<option value=".$fila['id_curso'].">".$Curso_pal." </option>";
                }
		     } ?>
          </select> 
		  	  
		 
			    </strong> </font> </td></form>  
          </tr>
          
        </table></td>
    </tr>
	 
    
</table>
</div>
</center>
<div id="modulodatos">&nbsp;</div>
 <div id="datos_apoderado">&nbsp;</div>
 <div id="modifica_apod">&nbsp;</div>	
 <div id="formulario_apoderado" class="ui-button-text" title="Ingreso Alumnos"></div>
	
<br>
<div id="alumnosrel">&nbsp;</div><br>

<!-- FIN FORMULARIO DE BUSQUEDA -->

 
 								  								  
								  </td>
                                </tr>
                              </table></td>
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
<div id="agregaralumno">&nbsp;</div>

</body>
</html>
<? pg_close($conn);?>