<? 	header( 'Content-type: text/html; charset=iso-8859-1' );
	session_start();	
	
	//echo "Nacional-->".$_NACIONAL;
	//$_INSTIT=12086;
 	//*echo "IP--> ".$_IPDB."<br>";
	/*echo "PID-->".$_PID;
	echo "<br>perfil-->".$_PERFIL;	
 	echo "<br>Base--> ".$_DBNAME;
	echo "<br>".$_NOMBREUSUARIO;
	echo "<br> institucion -->".$_INSTIT;*/
	

    require "class/Membrete.class.php";
//ECHO $_INSTIT;

	if($_INSTIT==1598){
		$_IPDB="192.168.1.12";
		$_ID_BASE=2;
	}
//	echo $_IPDB." ".$_ID_BASE;
	$ob_membrete = new Membrete($_IPDB,$_ID_BASE);
	pg_dbname($ob_membrete->Conec->conectar());
	$ob_membrete->Registro($_PID,$_INSTIT,$_NOMBREUSUARIO,$_PERFIL);
	$ob_membrete->estilosae($_INSTIT);
/*." AND nro_Ano=2016";*/
	
	$sql="select n.id_nacional 
from nacional n INNER JOIN nacional_corp nc ON n.id_nacional=nc.id_nacional
INNER JOIN corp_instit ci ON ci.num_corp=nc.num_corp
WHERE rdb=".$_INSTIT;
	$rs_nacional =@pg_exec($ob_membrete->Conec->conectar(),$sql) or die("ERROR ANO ESCOLAR");
	$_SESSION['_NACIONAL'] = pg_result($rs_nacional,0); 
	
	$sql ="SELECT id_ano FROM evados.eva_ano_escolar WHERE id_institucion=".$_INSTIT."  AND situacion=1";
	$rs_ano = @pg_exec($ob_membrete->Conec->conectar(),$sql) or die("ERROR ANO ESCOLAR");
	$fila = @pg_fetch_array($rs_ano,0);
	//echo pg_dbname($ob_membrete->Conec->conectar());
	
	
	$_SESSION['_ANO'] = $fila['id_ano'];
	
	
	$rs_tipo_usuario=$ob_membrete->tipo_aveluacion($_NOMBREUSUARIO);
	$tipo_us = pg_result($rs_tipo_usuario,0);
    
	if(pg_num_rows($rs_ano)==0){
	 echo  "<br/><br/><br/><h1>".htmlentities( "Necesita tener un Año Iniciado Para Activar Este Sistema",ENT_QUOTES,'UTF-8')."<h1/>";
	 return;
	}	
	
	$sql ="SELECT id_periodo FROM evados.eva_periodo WHERE id_ano=".$fila['id_ano']." AND (cerrado is null or cerrado=0)";
	//$sql="SELECT id_periodo FROM evados.eva_periodos_evaluacion WHERE id_anio=".$fila['id_ano'];
	$rs_periodo = pg_exec($ob_membrete->Conec->conectar(),$sql) or die("ERROR111");
	$periodo = pg_result($rs_periodo,0);
	$_SESSION['_PERIODO'] = $periodo;
//	echo $_SESSION['_PERIODO'] = 3104;
	// pg_dbname($ob_membrete->Conec->conectar());
	if(pg_numrows($rs_periodo)>1){
		echo "<script>alert('EXISTE MAS DE UN PERIODO ABIERTO, FAVOR CONTACTARSE CON EL ADMINISTRADOR')</script>";	
		/*if($_PERFIL!=40){
			echo "<script>window.location='logout.php'</script>";	
		}*/
	}else{
		if($_PERFIL!=45){
		$sql="SELECT * FROM evados.eva_periodos_evaluacion WHERE id_periodo=".$periodo;
		$rs_periodo_ok = pg_exec($ob_membrete->Conec->conectar(),$sql);// or die("ERROR333");
		
		if(pg_numrows($rs_periodo_ok)==0){
			echo "<script>alert('PERIODO NO CORRESPONDE CON PROCESO DE EVALUACION, FAVOR CONTACTESE CON EL ADMINISTRADOR')</script>";	
			/*if($_PERFIL==40){
				$pag="periodo/periodo.php";
				echo "<script type='text/javascript'>enviapag('".$pag."')</script>";
			}*/	
		}
		}
	}

//echo pg_dbname($ob_membrete->Conec->conectar());
//echo $_PERFIL;
//echo $_INSTIT;

//$_SESSION['_NACIONAL'] = 1;

if(!isset($_SESSION['_INSTIT'])){ 
      $url="logout.php";
      Header("Location: $url");
    }

if ( $archivo != ""){
header("Content-type: application/x-file");
header("Content-Disposition: attachment; filename=$archivo");
readfile("documentos/$archivo");
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link href="<?=$ob_membrete->ESTILO?>" rel="stylesheet" type="text/css">
<link  rel="shortcut icon" href="../images/icono_sae_33.png">
<title>SISTEMA EVALUACION DOCENTE</title>

<link rel="stylesheet" type="text/css" href="../admin/clases/jqueryui/themes/smoothness/jquery-ui-1.8.6.custom.css"/>
<!--<script type="text/javascript" src="../admin/clases/jqueryui/jquery-1.4.2.min.js"></script>-->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script type="text/javascript" src="../admin/clases/jqueryui/jquery-ui-1.8.6.custom.min.js"></script>

<script type="text/javascript">
$(document).ready(function(){ // Script del Navegador 
 
$("ul.subnavegador").not('.selected').hide();
$("a.desplegable").click(function(e){
var desplegable = $(this).parent().find("ul.subnavegador");
$('.desplegable').parent().find("ul.subnavegador").not(desplegable).slideUp('slow');
desplegable.slideToggle('slow');
e.preventDefault();
 })

var tipoUs = "<?=$tipo_us?>";
//alert(perfil);
if(tipoUs==1){
enviapag('evaluacionporcargo/evaluacionporcargo.php');	
}else{
enviapag('evaluacion/evaluacion.php');
}
<? if($_PERFIL==41){ ?>
         // loading();
<? } ?>

});



function loading(){

$("#loading").html('<h5>&#161;Bienvenido al Sistema de Evaluaci&oacute;n al Desempe&ntilde;o Docente Adventista!</h5><p>Con el prop&oacute;sito de introducir mecanismos que contribuyan a asegurar la calidad de la docencia impartida;  el Sistema Educativo Adventista (SEA), ha implementado recientemente un sistema integral de evaluaci&oacute;n docente denominado SEDDA (Sistema de Evaluaci&oacute;n al Desempe&ntilde;o Docente Adventista).</p><p>Es pues en este marco, que usted, en tanto miembro de la comunidad escolar de su colegio, ha sido llamado a colaborar en este proceso como EVALUADOR(A) de un conjunto de docentes de aula y directivo-t&eacute;cnicos del establecimiento.  Lo anterior, implica responder algunas pautas de evaluaci&oacute;n, dando cuenta de su percepci&oacute;n del desempe&ntilde;o del docente evaluado, de acuerdo a  criterios establecidos en una escala de evaluaci&oacute;n.</p><p>Desde ya agradecemos sinceramente su positiva disposici&oacute;n a cooperar con el mejoramiento continuo de nuestro sistema educativo.</p><br/><p><center>Hugo C&aacute;meron Garc&iacute;a<h5>DIRECTOR NACIONAL EDUCACI&Oacute;N ADVENTISTA</h5><p></center>');  			
						 
			$("#loading").dialog({ 
				closeOnEscape: false, 
				open: function(event, ui) { 
				//$(".ui-dialog-titlebar").hide();
				}, 
				modal:true,
				resizable: false,
				Width: 650,
				Height: 650,
				minWidth: 650,
				minHeight: 650,
				maxWidth: 650,
				maxHeight: 650,
				show: "fold",
				hide: "scale",
				position:"fixed",
				position: "absolute",
				buttons: {
					 "Cerrar": function(){
					$(this).dialog("close");
				  }
				}   
			}); 
			
        }
			
			
function enviapag(pag){
if(pag!=""){
     $.ajax({
	  url:"mod/"+pag,
	  type:'POST',
	  error: function(objeto, quepaso, otroobj){
           window.location.href="logout.php";
        },
	  success:function(data){
	    $("#principal").html(data);
	    }
    }); 
  }	
 };

</script>
<style type="text/css">

body {
   font: 10pt Verdana, Geneva, Arial, Helvetica, sans-serif;
    background-color:#F7F7F7;
	margin:0px; 
	}

#contenedor{
   /*padding: 5 5 5 5px;*/
   width:100%;
  /* background:#CC0000;*/
  }
  
#cabecera{
	background-color:#F7F7F7;
	border-collapse:collapse;
	/*border:1px #0000FF;*/
	color:#000;
	font-size:11pt;
	font-weight: bold;
	background-image:url(<?=$ob_membrete->corte5; ?>);
  	width:95%;
	height: 190px;
	padding:0px;  
	border-top-color:#0000FF;
	
  }

#cabecera-derecha{
	float:right;
	margin:5px;
	margin-top:110px;
	}

#cabecera-izquierda{
	float:left;
	margin:10px;
	margin-left:15px;
	}

#cabecera2{
	background-color:#F7F7F7;
	background-image:url(<?=$ob_membrete->corte3;?>);
	margin-left:0;
	height: 33px;
	width:96%;
	float:left;
	 }
	 
#cuerpo{
   margin: 10 0 10 0px;
   width:95%;
   margin-left:1%;
  /*<!-- background-color:#9999FF;-->*/
}

#lateral{
   width: 20%;
   height:500px;
   background-color: #F7F7F7;
   float:left;
   margin-top:1%;
 }
 
#lateral ul{
  list-style:none;
  margin-left:4%;
  padding:0;
  /*list-style-image:url(../cortes/12086/fondo_linea01.jpg);*/
}

#lateral li{
  margin-left:0px;
  padding:0;
  padding-right:0px;
 }

#lateral a{
  display:block;
  width:90%;
  height:20px;
  padding-top:10px;
  padding-left:8px;
 /* text-decoration:none;*/
  text-align:left;
  font-size:12px;
  color:#000000;
  background-color:#CCCCCC;
  border-left:10px solid #666666;
  border: 1px solid;
}
#lateral a:hover{
  color:#FFFFFF;
  background-color:#999999;
  border-left-color:#CC0000;
  border-left-width:medium;
}

#principal{
   /*margin-left:300px;*/
   /*margin:20px;*/
   margin-top: 1%;
   margin-right:2%;
   background-color: #ffffff;
   padding: 5 5 5 5px;
   width:70%;
   height:%;
   border:solid 1px;
   float:right;
    }
  
#otrolado{
	background-color:#0000FF;
    background-image:url(<?=$ob_membrete->IMAGEN_DERECHA?>);
	width:4%;
	height:1000px;
	float:right;
/*	margin-right:10;*/
}
#otrolado2{
	background-color:#0000FF;
	background-image:url(<?=$ob_membrete->IMAGEN_IZQUIERDA?>);
    width:4%;
	height:1000px;
	float:left;
	/*margin-left:10;*/
}

/*#pie{
   background-color: #f0b913;
   margin-top: 50px;
   padding: 3 10 3 10px;
   text-align:right;
   clear: both;
   width:95%;
}*/

</style>
</head>
<body >

  <div id="otrolado">&nbsp;</div>
  <div id="otrolado2">&nbsp;</div>
   
<div id="contenedor">
   
  <div id="cabecera" >
    
    <div id="cabecera-izquierda">
     Sistema Evaluacion Docente<br> 
    </div>

    <div id="cabecera-derecha" >
            <?
            $fila = $ob_membrete->institucion($_INSTIT);
            echo "<spam>Instituci&oacuten : ".ucwords(strtoupper($fila['nombre_instit']))."</spam>";
            echo "<br><spam>Direccion : ".strtoupper($fila['calle'])." ".$fila['nro']." ".strtoupper($fila['nom_com'])."</spam>";
            echo "<br><spam>Telefono : ".$fila['telefono']."</spam>";
            $fila = $ob_membrete->anoescolar($_INSTIT);
            echo "<br><spam>A&ntildeo Escolar : ".$fila['nro_ano']."</spam>";
            ?>  
        </div>
    
  </div> <!--/*cabecera*/-->

  <div id="cuerpo"> 
    <div id="cabecera2" >&nbsp;</div>  
        <div id="lateral">
        <?
		
		if($_PERFIL==0){
									
			$_SESSION['_PERFIL'] = 40;
			
			}
		
		
        $ob_membrete->cargamenulateral($_PERFIL,$_INSTIT);
        ?>
        </div>
        <div id="principal">&nbsp;</div>
        <!--<div id="pie"> © 2011</div>-->
    </div>
</div>
<div id="loading"></div>
</body>
</html>
