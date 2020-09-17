<?
include("../inicio/conectar_institucion.php");
include("../consultas.php");
?>

<!DOCTYPE html PUBLIC "_//WAPFORUM//DTD XHTML Mobile 1.2//EN"
    "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=utf-8" />
<title>Sae Mobile 1.0</title>

<style>

body{
	margin:0px;
	}

#fondo{
	margin:0px;
	}
	
 #Info_Notas a {
	    color: #0033FF;
		border: 2px solid;
		background-color: #99FFFF;
		padding: 2px;
		font: 13px Arial, sans-serif;
		font-weight: bold;
		text-decoration: none;
		display: block;
		width: 100%;
		text-align: left;
		margin:5px;
		}

 #Info_Notas a:hover {border: 1px solid;
		padding-top: 3px;
		border: 2px solid;
		border-color:#FF6600;
		color: #0099CC;
		text-decoration: none;
		margin:5px;
		}
 
 .contenedor {
	    color: #0033FF;

		background-color:#FFF;
		
		font-family:"Times New Roman", Times, serif;
	    font-size:12px;
	   
		font-weight: bold;
		text-decoration: none;
		/*display: block;
		width: 100%;*/
		text-align: left;
		margin:1px;
		margin-bottom:10px;
		}

    #header {
	background-color: #000;
	text-align:right;
	/*padding:10px;*/
	color:#FF6600;
	margin-bottom:5px;
	background-color: #FFFFCC;
    background-image: url(Fondo_Header_Movil.png);
    height:50px;	
   }
   

	#footer {
	   background-color: #000;
	   padding:5px;
	   color:#FF6600;
	   margin-top:5px;
	   background-image: url(Fondo_Footer_Movil.png);
	   height:120px;	
	  }
	  

    h3{
		 background-color: #0099ff;
		 color: #fff; 
		 font-size: 13px; 
		 font-weight: bold; 
		 line-height: 1; 
		 padding-left:5px;
		 padding-top:3px;
		 padding-bottom:3px;
		 
		 background-image: url(Fondo_Header_Movil.png);
         height:10px;
		 
	 }
	 
	 h5{ 
		 background-color: #0099ff;
		 color: #fff;
		 font-size: 13px; 
		 font-weight: bold; 
		 line-height: 1; 
		 padding-left:5px;
		 padding-top:3px;
		 padding-bottom:3px;
		 
		 background-image: url(Fondo_Header_Movil.png);
         height:10px;
		 
	 }

		.aaa{
		  background-color: #CCC;
	      display: inline-block;
		  padding: 5px 10px 6px; 
	      color: #fff;
		  text-decoration: none;
	      margin-top:5px;
		  margin-left:10px;
	      font-size: 13px; 
		  font-weight: bold;
	      line-height: 1; 
         }	

   .aaa:link { color: #fff; text-decoration:none;}
   .aaa:hover { background-color:#F60; color: #fff; }
   .aaa:active { top: 1px; }
 
   ul{list-style-type:none;}
   ul li{list-style-type:none;}
	
   .tablota{
	   font-family:"Times New Roman", Times, serif;
	   font-size:12px;
	   } 	

	
</style>
    
</head>
<body>
<html>

       
 <div id="fondo">
       
    <div id="header" >
    
     <div style="float:left;" >
     <a class="aaa" id="cer" href="listarpupilos.php" >Volver</a>
     </div>
        
    </div> 
     
	<?
    $rutalum = $_GET['rutalum'];
    $idano = $_GET['idano'];
    $consultas = new consultas_reportes($conn,$_INSTIT,$rutalum,$idano);
    ?>
                  
   <div id="Info_Notas" class="contenedor" >
   
    <div align="center" style="margin:0px; margin-top:15px;" >
    <img src="logosaemovil.png" width="283" height="73" />
    </div>
    
   
   
   <h3>Info. Notas</h3>
          <?  
		  $result = $consultas->consultar_periodos($idano);
		  
		  if($result){ 
			  
			  for($e=0;$e<pg_num_rows($result);$e++){
			  $fila = pg_fetch_array($result,$e);
			  
			  ?>
              <h5><?=$fila['nombre_periodo']?></h5>
             
			 <?=$consultas->consulta_notas2($fila['id_periodo']);?>
			 
			 <? 
				
				} // for 
		 
		 }else{   
		 
		     echo "<br><h5>No Hay Periodos</h5><br>"; } ?>

    </div><!--Info_Notas-->
    
    
  <div id="Info_Asistencia" class="contenedor" >
   <h3>Info. Asistencia</h3>
              <div style="margin:18px;">
                 <?=$consultas->consulta_asistencia($fila['id_periodo']);?>
               </div>
   </div><!--Info_Asistencia-->
   
   
   <div id="Info_Anotaciones" class="contenedor" >
   <h3>Info. Anotaciones</h3>
   		<?  
		 
		 $result = $consultas->consultar_periodos($idano);
		  
		 if($result){ 
		  
		 for($e=0;$e<pg_num_rows($result);$e++){
				  
		 $fila = pg_fetch_array($result,$e);
		  
		 ?>
		
         <h5><?=$fila['nombre_periodo']?></h5>
             
		 <?
			 
		 $result2 = $consultas->consulta_anotaciones($fila['id_periodo']);
			 
		 if($result2){ 
		 
		  echo "<table class='tablota' border='1' style='border-collapse: collapse;' ><tr><th width='30%' >Fecha</th><th width='70%' >Detalle</th></tr>";
			 
		  for($e2=0;$e2<pg_num_rows($result2);$e2++){
					 
		  $fila2 = pg_fetch_array($result2,$e2);
					 
		  echo "<tr><td>".$fila2['fecha']."</td>";
		  //echo "<td>".htmlentities("Anotación:",ENT_QUOTES,'UTF-8')."</td>";
		  echo "<td>".htmlentities(trim($fila2['observacion']),ENT_QUOTES,'UTF-8')."</td></tr>";
	      
			  }
	      
		     echo "</table>";
		  
		   }

	    }
				
		 }else{   
		 
		 echo "<br><h5>No Hay Periodos</h5><br>"; 
		 
		 } ?>
   </div><!--Info_Anotaciones-->


<div id="footer">
   
   <div style="float:left;" ><a class="aaa" id="cer" href="listarpupilos.php" >Volver</a></div>
    
   <div align="center">  
   <br/>
   <p style="font-size:10px" > 
   <a href="mailto:info@colegiointeractivo.com?subject=Consulta%20desde%20SaeMovil">info@colegiointeractivo.com</a>
   </p>
   <p style="font-size:10px">
   <a href="tel:28293350">Fono : ( 56-2 ) 8293350</a>
   </p>
   <p style="font-size:10px"><a href="http://www.colegiointeractivo.com/">www.colegiointeractivo.com</a> 
   </p>
   <p style="font-size:10px">Copyright Todos los Derechos Reservados</p>
   <br/>
   </div>
    
</div> <!--footer-->

</div><!--fondo-->

</body>
</html>