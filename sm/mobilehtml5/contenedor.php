<?
include("../inicio/conectar_institucion.php");
include("../consultas.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta name="viewport" content="width=device-width, content="text/html; charset=UTF-8", minimum-scale=1, maximum-scale=1">

<title>sae movil</title>

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.css" />
<script src="http://code.jquery.com/jquery-1.6.4.min.js"></script>
<script src="http://code.jquery.com/mobile/1.0/jquery.mobile-1.0.min.js"></script>
    
    </head>
    <body>
    
    <div data-role="page" id="contenedor" >
      
          <div data-role="header" data-theme="d"  style="padding:15px;">
          <a href="listarpupilos.php" data-role="button" data-inline="true" rel="external" data-icon="back" style="margin:5px;" >Volver</a>&nbsp;
          </div>
          <!-- /header -->
        
   <div data-role="content" >
   
   
    <div align="center" >
    <!--style="margin:1px"-->
    <img src="logosaemovil.png" width="283" height="73" />
    </div>
    
    
	<?
    $rutalum = $_GET['rutalum'];
    $idano = $_GET['idano'];
    $consultas = new consultas_reportes($conn,$_INSTIT,$rutalum,$idano);
    ?>
    
   <div data-role="collapsible-set"  >
                  
   <div data-role="collapsible" data-theme="b" >
   <h3>Info. Notas</h3>
          <?  
		  $result = $consultas->consultar_periodos($idano);
		  if($result){ 
			  for($e=0;$e<pg_num_rows($result);$e++){
			  $fila = pg_fetch_array($result,$e);
			  ?>
			 <div data-role="collapsible" data-theme="b" >
			 <h3><?=$fila['nombre_periodo']?></h3>
			 <ul data-role="listview" data-inset="true" data-theme="d">
			 <li data-role="list-divider">Notas del Periodo</li>
			 <?=$consultas->consulta_notas($fila['id_periodo']);?>
			 <!--<li data-theme="a">Promedio : <span class="ui-li-count" >59</span></li>-->
			 </ul>
			 </div>
			 <? 
				}
		 }else{   echo "<br><h5>No Hay Periodos</h5><br>"; } ?>
   </div>

  <div data-role="collapsible" data-theme="b"  >
   <h3>Info. Asistencia</h3>
     <ul data-role="listview" data-inset="true" data-theme="d">
			 <li data-role="list-divider">Informe de Inasistencia</li>
                 <div style="margin:18px;">
                 <?=$consultas->consulta_asistencia($fila['id_periodo']);?>
                 </div>
             </li>    
       </ul>
   </div>
   
   
   <div data-role="collapsible" data-theme="b" data-content-theme="d" >
   <h3>Info. Anotaciones</h3>
   		<?  
		  $result = $consultas->consultar_periodos($idano);
		  
		  if($result){ 
		  
			  for($e=0;$e<pg_num_rows($result);$e++){
				  
			  $fila = pg_fetch_array($result,$e);
			  ?>
			 <div data-role="collapsible" data-theme="b" data-content-theme="d" >
			 <h3><?=$fila['nombre_periodo']?></h3>
             
			 <?
			 
			 $result2 = $consultas->consulta_anotaciones($fila['id_periodo']);
			 
		     if($result2){ 
			 
				 for($e2=0;$e2<pg_num_rows($result2);$e2++){
					 
					 $fila2 = pg_fetch_array($result2,$e2);
					 
					 ?>
					   <div data-role="collapsible" data-theme="b" data-content-theme="d" >
					     
                         <h3><?=$fila2['fecha']?></h3>
						 
                         <ul data-role="listview" data-inset="true" data-theme="d">
								 <li data-role="list-divider"><?=htmlentities("Anotación:",ENT_QUOTES,'UTF-8')?></li>
									 <div style="margin:18px;">&nbsp;
                                     
									 <?="<br>&nbsp;&nbsp;&nbsp;&nbsp;".trim($fila2['observacion'])."<br><br><br>"?>
									 
                                     </div>
								 </li>    
						   </ul>
					   </div>
					 <?
				  }
			   }
			 ?>
             
             </div>
			 <? 
				}
				
		 }else{   
		 
		 echo "<br><h5>No Hay Periodos</h5><br>"; 
		 
		 } ?>
   </div>
   
  </div> 

 </div><!-- /content -->
          
  <div data-role="footer" align="center" data-theme="b" ><br>
  <p style="font-size:10px"> 
  <a href="mailto:info@colegiointeractivo.com?subject=Consulta%20desde%20SaeMovil">info@colegiointeractivo.com</a>
  </p>
  <p style="font-size:10px;">
  <a href="tel:28293350">Fono : ( 56-2 ) 8293350</a>
  </p>
  <p style="font-size:10px;"><a href="http://www.colegiointeractivo.com/">www.colegiointeractivo.com</a> 
  </p>
  <p style="font-size:10px;">© Copyright Todos los Derechos Reservados</p>
  <br>
  </div>
    
    </div><!-- /page -->

    </body>
</html>