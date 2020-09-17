<? header( 'Content-type: text/html; charset=iso-8859-1' ); 

 session_start();	

require "Class/Membrete.php";


$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
$fila = $ob_membrete->institucion($_INSTIT);
$ob_membrete->estilosae($_INSTIT);
$fila=$ob_membrete->anoescolar($_INSTIT);




?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>Sistema C.E.D.E.</title>
<link rel="stylesheet" type="text/css" href="Class/JQuery_Tooltip/stylesheets/jquery.tooltip/jquery.tooltip.css"/>
<link type="text/css" href="jquery-ui-1.8.17.custom/css/redmond/jquery-ui-1.7.3.custom.css" rel="stylesheet" />	
<link rel="stylesheet" href="eValidator-1.4/jquery.eValidator-1.4.css" />
<script type="text/javascript" src="jquery-ui-1.8.17.custom/js/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="jquery-ui-1.8.17.custom/js/jquery-ui-1.8.17.custom.min.js"></script>
<script type="text/javascript" src="eValidator-1.4/jquery.eValidator-1.4.js"></script>

<script type="text/javascript" src="Class/JQuery_Tooltip/javascripts/jquery.tooltip.js"></script>




<script> 



$(function(){
// Tabs
$( "#tabs" ).tabs(); 

//alert("para una Correcta Navegacion por el Sistema, Primero Escoja Un Alumno");

});

// Cargar Paginas._
function enviapag(pag){
//alert(pag);
if(pag!=""){
     $.ajax({
	  url:"mod/"+pag,
	  type:'POST', 
	/*  error: function(objeto, quepaso, otroobj){
           window.location.href="logout.php";
        },*/
	  success:function(data){
		//alert(data);
	    $("#Sub_Contenedor").html(data);
	    }
    }); 
  }	
  
 };
 
 
</script>

<style>

body{
	margin:0px;
	font: normal 1em/1.4em Arial, Helvetica, sans-serif;
	 font-size:12px;
	}

#Sitio{
	width:1000px;
	height:auto;
	margin:auto; 
	}

#Header{
	margin:auto;
	width:1000px;
	height:200px;
	background:#FFF;
    border:solid 1px  #79b7e7; 
	margin-bottom:10px;
	margin-top:10px; 
	border-radius:5px 5px 5px 5px;
	}

#Membrete{
	
	margin:auto;  
    width:1000px;
	height:200px;
	background:#FFF;
	background-image:url(img/LOGO_CEDE_azul2.jpg);
	/*background-image:url(jquery-ui-1.8.17.custom/css/redmond/images/ui-bg_gloss-wave_55_5c9ccc_500x100.png);*/
	border-radius:5px 5px 5px 5px;
	}
	
	#cabecera-izquierda{
	float:left;
	margin:10px;
	height:120;
	width:87;
	margin-left:10px;
	
	}
	#cabecera-derecha{
	float:right;
	margin:5px;
	margin-top:5px;
	}
	#alumno_en_sesion{
	float:left;
	margin:1px;
	margin-top:110px;	
	}
	#info_gral{
	float:left;
	margin:5px;
	margin-top:20px;	
	}
	

#Top{
	margin:auto;
	width:1000px;
	height:auto;
	background:#FFF;
	border:solid 2px #003399;
	border:0px;
	}

#Menu_Top{
	margin:auto;
    width:1000px;
	height:auto;
	background:#FFF;
	}

#Contenedor{
	margin:auto;
	margin-top:10px;
	margin-bottom:10px;
	width:1000px;
	height:auto;
	background:#FFF;
	border:solid 1px  #79b7e7; 
	background-image:url(jquery-ui-1.7.3.custom/css/redmond/images/grid-18px-masked.png);
	border-radius:5px 5px 5px 5px;
	}

#Sub_Contenedor{
	margin:auto;
    width:1000px;
	height:auto;
    background-image:url(jquery-ui-1.7.3.custom/css/redmond/images/grid-18px-masked.png);
	}

#Footer{
	margin:auto;
	width:1000px;
	height:auto;
	background:#FFF;
	border:solid 2px #79b7e7;
	margin-bottom:10px;
	border-radius:5px 5px 5px 5px;
	}

#Sub_Footer{
	margin:auto;
    width:1000px;
	height:300px;
	background:#EBEBEB;
	}

#tabs{
	font-size:12px;
	font-family:Georgia, "Times New Roman", Times, serif;
	font-style:oblique;
	}
	

/*FORMULARIOS*/

input[type=text], input[type=password], textarea {
	background: #fff;	border: solid 1px #d6d1c7;
	padding: 5px 7px;color: #1d5987;
	-webkit-border-radius: 4px;-moz-border-radius: 4px; }

textarea:focus, input[type=password]:focus, input[type=text]:focus, select :focus{
	border: 1px solid #79b7e7; background: #fff;
	outline: none; box-shadow: 0 1px 4px #c5c5a2;
	-webkit-box-shadow: 0 1px 4px #c5c5a2;
	-moz-box-shadow: 0 1px 4px #c5c5a2; }

span:hover {
	border: 1px solid  #F60; }

fieldset { border:1px solid #79b7e7; margin:30px; padding:30px; }
legend { font-size:16px; font-style:oblique; }

select { margin:20px; 
padding:3px; 
border-radius:5px; 
border-color:#79b7e7;  
}

.divLeyLoc{
	position: reative;
	top: 25px;
	width: 215px;
	height: 200px;
	padding-right: -27px;
	margin-right: -27px;
	text-align: center;
	font: bold 10px/14px sans-serif;
	color: #835B21;
	background-color: transparent;
	left: 950px;
}

	.contenedor_foto
{postion:absolute;
witch: 100%:
height:500px;}


	
/******/	
</style>

</head>

<body>

<div id="Sitio">

<div id="Header" class="ui-state-focus" >

	<div id="Membrete" class="ui-state-active" >
    
     <div id="cabecera-izquierda">
     <br> 
    </div>
    
    <div id="cabecera-derecha" >
            
			
			
<div class="contenedor_foto">
<div class="divLeyLoc" id="foto"><img src="../infousuario/images/<?=trim($_RUT_ALUMNO)?>" width="160" height="180" /></div>
</div>		
			
	<?		
/*$fila = $ob_membrete->institucion($_INSTIT);
echo htmlentities("Institución: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['nombre_instit']));
echo "<br>".htmlentities("Dirección: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['calle'])).strtoupper($fila['nro']).strtoupper($fila['nom_com']);
echo "<br>".htmlentities("Teléfono: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['telefono']));
if(isset($_ANO_CEDE)){
$fila = $ob_membrete->AnoEscolarSeteado($_ANO_CEDE);
}else{$fila=$ob_membrete->anoescolar($_INSTIT);}
echo "<br>".htmlentities("Año Escolar: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['nro_ano']));
echo "<br><br><br>";
	
   $fila_usuario = $ob_membrete->Usuario_Sesion($_NOMBREUSUARIO);
	 echo htmlentities("Nombre Usuario: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_usuario['nombre_usuario']));
	 echo "<br>".htmlentities("Rut Usuario: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_usuario['rut_empleado']));*/
            ?>  
        </div>
        
     <div id="alumno_en_sesion">
     <?
	
	if(isset($_ANO_CEDE)){
$fila = $ob_membrete->AnoEscolarSeteado($_ANO_CEDE);
$_ANO_CEDE=$fila['id_ano'];
}else{$fila=$ob_membrete->anoescolar($_INSTIT);
$_ANO_CEDE=$fila['id_ano'];
}
	
	 if(isset($_RUT_ALUMNO)){
	 
      $fila_alumno = $ob_membrete->datos_alumno($_ANO_CEDE,$_RUT_ALUMNO);
	  $Curso_pal = $ob_membrete->CursoPalabra($fila_alumno['id_curso'],1);
		echo htmlentities("Rut Alumno: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_alumno['rut_alumno'])).'-'.ucwords(strtoupper($fila_alumno['dig_rut']));
		echo "<br>".htmlentities("Nombre Alumno: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_alumno['nombre_alumno']));
		echo "<br>".htmlentities("Curso: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($Curso_pal));
		
		$fila_apoderado = $ob_membrete->datos_apoderado($_RUT_ALUMNO);
		$_RUT_APODERADO=$fila_apoderado['rut_apo'];
		echo "<br>".htmlentities("Rut Apoderado: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($_RUT_APODERADO.'-'.$fila_apoderado['dig_rut']));
		echo "<br>".htmlentities("Nombre Apoderado: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_apoderado['nombre_apoderado']));
	 
	 }
     ?>
     </div>   
    
    </div>
</div>

<div id="Top" >
	<div id="Menu_Top" >
		
		<div id="tabs">
			<ul>
        <? $sql = "select  * from cede.menu order by cede.menu.orden"; 
			 $registros  = pg_Exec( $ob_membrete->Conec->conectar(),$sql ) or die( "Error bd Select 21" );
				for(  $a=0; $a<pg_num_rows($registros) ; $a++ ){
				           $fila =  pg_fetch_array($registros,$a);
		                   $nombre_menu =  $fila["nombre"];
		                   $url_menu = $fila["url"];
				echo 	'<li><a href="#tabs-'.$a.' " onclick="enviapag('.$url_menu.')" >   '.$nombre_menu.'  </a></li>   ';
			          }   ?>		
			          
			</ul>
   <?
   
   $sql = "select  * from cede.menu order by cede.menu.orden"; 
   
   $registros1  = pg_Exec( $ob_membrete->Conec->conectar(),$sql ) or die( "Error bd Select 22" );
	
   for(  $a1=0; $a1<pg_num_rows($registros1) ; $a1++ ){
    	
    $fila1 =  pg_fetch_array($registros1,$a1);
    
    $id =  $fila1[id_menu];
	   
   ?>
		  <div id="tabs-<?=$a1?>">
           <?
           $sql = "SELECT cede.menu_categoria.* FROM cede.menu 
						INNER JOIN cede.menu_categoria ON cede.menu_categoria.id_menu = cede.menu.id_menu
						WHERE cede.menu.id_menu = $id  ORDER BY cede.menu.orden";
           $registros2  = pg_Exec( $ob_membrete->Conec->conectar(),$sql ) or die( "Error bd Select 23" );
		   
		   	for(  $a2=0; $a2<pg_num_rows($registros2) ; $a2++ ){
				           	
				           $fila =  pg_fetch_array($registros2,$a2);
		                   
		                   $nombre_menu =  $fila["nombre_categoria"];
		                   $url_menu = $fila["url"];
			      
			          ?>

            <a href="#" onclick="enviapag('<?=$url_menu?>')" >[ <?=$nombre_menu?> ]</a>
            
			<?  }  ?>
           
            </div>
            
           <?  }  ?> 
                       
        
        <!--
           
			<div id="tabs-0">
            <a href="#" onclick="enviapag('mapa_conceptual/mapa_conceptual.php')" >[ Mapa Conceptual ]</a>
            <a href="#" onclick="enviapag('nivel_logro/nivel_logro.php')" >[ <?=htmlentities("Nivel de Logro",ENT_QUOTES,'UTF-8')?> ]</a>
            <a href="#" onclick="enviapag('Conf_Entrevistas/Conf_Entrevistas.php')" >
            [ <?=htmlentities("Configuración Entrevistas",ENT_QUOTES,'UTF-8')?> ]</a>
            <a href="#" onclick="enviapag('Crear_Menu/crear_menu.php')" >[ Crear Menu ]</a>
            <a href="#" onclick="enviapag('perfil_menu/perfil_menu.php')" >[ Perfil v/s Menu ]</a>
            </div>
            
            
			<div id="tabs-1">
            <a href="#" onclick="enviapag('Ficha_Alumno/Ficha_Alumno.php')" >[ Ficha Alumno ]</a>
            <a href="#" onclick="enviapag('Entrevistas/Entrevistas.php')" >[ Entrevista Apoderado ]</a>
            <a href="#" onclick="enviapag('Entrevistas/Entrevistas.php')" >[ Entrevista Alumno ]</a>
           <a href="#"  onclick="enviapag('entrevista_profesional/entrevista_profesional.php')">[ Entrevista Profecional ]</a>
            <a href="#" onclick="enviapag('conf_ficha_academica/ficha_academica.php')"><?=htmlentities("Configuración Ficha Academica",ENT_QUOTES,'UTF-8')?></a>
             <a href="#" onclick="enviapag('ficha_academica_curso/ficha_academica_curso.php')"><?=htmlentities("Ficha Academica Curso",ENT_QUOTES,'UTF-8')?></a>
             <a href="#" onclick="enviapag('ficha_academica_alumno/ficha_academica_alumno.php')"><?=htmlentities("Ficha Academica Alumno",ENT_QUOTES,'UTF-8')?></a>
            </div>
			<div id="tabs-2">
            <a href="#" onclick="enviapag('Area_Cognitiva/autorizacion_evaluacion/autorizacion_evaluacion.php')"><?=htmlentities("Autorización de Evaluación",ENT_QUOTES,'UTF-8')?></a>
            <a href="#" onclick="enviapag('Area_Cognitiva/formulario_deficit_atencional/deficit_atencional.php')"><?=htmlentities("Deficit Atencional",ENT_QUOTES,'UTF-8')?></a>
            <a href="#" onclick="enviapag('Area_Cognitiva/formulario_evaluacion_ingreso/evaluacion_ingreso.php')"><?=htmlentities("Evaluación de Ingreso",ENT_QUOTES,'UTF-8')?></a>
             <a href="#" onclick="enviapag('Area_Cognitiva/formulario_reevaluacion/reevaluacion.php')"><?=htmlentities(" Reevaluación",ENT_QUOTES,'UTF-8')?></a>
            <a href="#" onclick="enviapag('Area_Cognitiva/formulario_apoyos_especializados/apoyos_especializados.php')"><?=htmlentities("Apoyos Especializados",ENT_QUOTES,'UTF-8')?></a>
            <a href="#" onclick="enviapag('Area_Cognitiva/formulario_dificultades_especificas/dificultades_especificas.php')"><?=htmlentities("Dificultades Especificas",ENT_QUOTES,'UTF-8')?></a>
             <a href="#" onclick="enviapag('Area_Cognitiva/formulario_valoracion_salud/valoracion_salud.php')"><?=htmlentities("Valoración Salud",ENT_QUOTES,'UTF-8')?></a>
             </div>
            <div id="tabs-3">
			&nbsp;	
            </div>
            -->
		</div>
    </div>
    
</div>

<div id="Contenedor" class="ui-state-focus">
    <div id="Sub_Contenedor" ></div>
</div>

<div id="Footer" class="ui-state-focus">
    <div id="Sub_Footer" >
    <div id="info_gral">
	<?
    $fila = $ob_membrete->institucion($_INSTIT);
echo htmlentities("Institución: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['nombre_instit']));
echo "<br>".htmlentities("Dirección: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['calle'])).strtoupper($fila['nro']).strtoupper($fila['nom_com']);
echo "<br>".htmlentities("Teléfono: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['telefono']));
if(isset($_ANO_CEDE)){
$fila = $ob_membrete->AnoEscolarSeteado($_ANO_CEDE);
}else{$fila=$ob_membrete->anoescolar($_INSTIT);}
echo "<br>".htmlentities("Año Escolar: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila['nro_ano']));
echo "<br><br>";
   $fila_usuario = $ob_membrete->Usuario_Sesion($_NOMBREUSUARIO);
	 echo htmlentities("Nombre Usuario: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_usuario['nombre_usuario']));
	 echo "<br>".htmlentities("Rut Usuario: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_usuario['rut_empleado']));
            ?>  
            
       <br><br>
       <?
	
	if(isset($_ANO_CEDE)){
$fila = $ob_membrete->AnoEscolarSeteado($_ANO_CEDE);
$_SESSION['_ANO_CEDE']=$fila['id_ano'];
        $_ANO_CEDE=$_SESSION['_ANO_CEDE'];
		return $_ANO_CEDE;

}else{$fila=$ob_membrete->anoescolar($_INSTIT);
        
       $_SESSION['_ANO_CEDE']=$fila['id_ano'];
        $_ANO_CEDE=$_SESSION['_ANO_CEDE'];
		return $_ANO_CEDE;

}
	
	 if(isset($_RUT_ALUMNO)){
	 
     $fila_alumno = $ob_membrete->datos_alumno($_ANO_CEDE,$_RUT_ALUMNO);
	  $Curso_pal = $ob_membrete->CursoPalabra($fila_alumno['id_curso'],1);
    echo htmlentities("Rut Alumno: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_alumno['rut_alumno'])).'-'.ucwords(strtoupper($fila_alumno['dig_rut']));
	 echo "<br>".htmlentities("Nombre Alumno: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_alumno['nombre_alumno']));
	 echo "<br>".htmlentities("Curso: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($Curso_pal));
	 
	 
	  $fila_apoderado = $ob_membrete->datos_apoderado($_RUT_ALUMNO);
	  $_RUT_APODERADO=$fila_apoderado['rut_apo'];
    echo "<br>".htmlentities("Rut Apoderado: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($_RUT_APODERADO.'-'.$fila_apoderado['dig_rut']));
	 echo "<br>".htmlentities("Nombre Apoderado: ",ENT_QUOTES,'UTF-8').ucwords(strtoupper($fila_apoderado['nombre_apoderado']));
	 
	 }
     ?>     
    </div>
  
    </div>
</div>

</div>

</body>
</html>
