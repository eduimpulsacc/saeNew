<? 
session_start();
include("../inicio/conectar_institucion.php");
?>
<!DOCTYPE html PUBLIC "_//WAPFORUM//DTD XHTML Mobile 1.2//EN"
    "http://www.openmobilealliance.org/tech/DTD/xhtml-mobile12.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=utf-8" />
<title>Sae Mobile 1.0</title>

<!--<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SAE</title> -->

<link rel="stylesheet" type="text/css" href="menus.css"/>


<style>

	body{
		margin:0px; 
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
	   padding:10px;
	   color:#FF6600;
	   margin-top:5px;
	   background-image: url(Fondo_Footer_Movil.png);
	   height:120px;	
	  }
     

	#datos_institucion {
		font-family: "Times New Roman", Times, serif;
		font-size: 12px;
		font-style: normal;
		background-color: #FFF;
	}

	#result{
		font-family: "Times New Roman", Times, serif;
		font-size: 12px;
		border:1px;
		border-collapse:collapse;
		border-color:#CC6600;
		}
	
	h3{
		 background-color: #0099ff;
		 color: #fff; 
		 font-size: 13px; 
		 font-weight: bold; 
		 line-height: 1; 
		 padding-left:5px;
		 padding-top:5px;
		 padding-bottom:5px;
		 
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
	
	
	 .contenedor {
	    color: #0033FF;
		/*border: 1px solid;*/
		background-color:#FFF;
		font: 13px Arial, sans-serif;
		font-weight: bold;
		text-decoration: none;
		/*display: block;
		width: 100%;*/
		text-align: left;
		margin:1px;
		margin-bottom:15px;
		}
		
		 
</style>
 
</head>
<body>
<html>
    
  <div id="header" >
     <div style="float:left;" ><a class="aaa" href="../inicio/salir.php" >Salir</a></div>

  </div> 
    
  <div id="listado_alumnos" class="contenedor" >  
  
  
      <div align="center" style="margin:0px; margin-top:15px;" >
    <!--style="margin:1px"-->
    <img src="logosaemovil.png" width="283" height="73" />
    </div>
    
    
  
  <h3><?=htmlentities("Listado de Alumnos",ENT_QUOTES,'UTF-8')?></h3>
   
           <?php
			
			if($_PERFIL==15){  // perfil apoderado
			
			//TODOS LOS ALUMNOS PARA LOS CUALES A SIDO 
			//APODERADO, EN TODOS LOS AÑOS ACADEMICOS
			$qry="SELECT alumno.rut_alumno,alumno.dig_rut,
			alumno.nombre_alu,alumno.ape_pat,alumno.ape_mat  FROM apoderado   
			INNER JOIN tiene2 ON tiene2.rut_apo = apoderado.rut_apo 
			INNER JOIN alumno ON alumno.rut_alumno = tiene2.rut_alumno 
			WHERE apoderado.rut_apo=".$_NOMBREUSUARIO." ORDER BY 3 ; ";
					
			}else if($_PERFIL==16){ // perfil alumno
						
			$qry="SELECT alumno.rut_alumno,alumno.dig_rut,alumno.nombre_alu,alumno.ape_pat,alumno.ape_mat  FROM alumno WHERE alumno.rut_alumno = ".$_NOMBREUSUARIO."; ";
												
			}	
				
			$result =@pg_Exec($conn,$qry) or die("SELECT FALLO");
			
			if (!$result) {
			
				exit();
			
			}else{
					
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
					
						$fila = @pg_fetch_array($result,0);	
					
						if (!$fila){
							
							exit();
							
						}
					}

			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				
			$fila = @pg_fetch_array($result,$i);

			?>

           <div id="menu" >
           
           <h3><?= "Alumno: ".tilde($fila["ape_pat"])." ".tilde($fila["ape_mat"])." ".tilde($fila["nombre_alu"])?></h3>
                
				<?
				
				if($fila['rut_alumno']!="" and $fila['rut_alumno']!=0 and $fila['rut_alumno']!=NULL){
					
                $qry1 = "SELECT institucion.nombre_instit,ano_escolar.nro_ano, 
                institucion.rdb,matricula.id_ano,matricula.id_curso,ano_escolar.situacion 
                FROM matricula 
                INNER JOIN institucion ON matricula.rdb = institucion.rdb 
                INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano 
                WHERE matricula.rut_alumno = ".$fila['rut_alumno']." ORDER BY 2 DESC 
				LIMIT 3;";
				
        	    $result1 =@pg_Exec($conn,$qry1) or die("SELECT FALLO");
				
				if($result1){
				
				echo '<ul style="margin:5px;" >';
							
				for($i2=0 ; $i2 < @pg_numrows($result1) ; $i2++){
						
				$fila1 = @pg_fetch_array($result1,$i2);
			                 
				$rutalum = $fila['rut_alumno'];
				$idano =  $fila1['id_ano'];
							 
				echo '<li><a href="contenedor.php?rutalum='.$rutalum.'&idano='.$idano.'" >'.$fila1['nro_ano'].'</a></li>';
    		                
				   }
				   
				 echo '</ul>';
				  
				 }else{
					 
					 echo "<p style='margin:5px;' >No Existen Periodos para Este Alumno</p><br/><br/>";
					 
					 }  
				
				}else{
					
					echo "<p style='margin:5px;' >No Existen Datos para Este Alumno</p><br/><br/>";
					
					}	 
				   
            	?>
   
     <?   
	
		echo "</div>";	
		
		    }     // fin ciclo  
			   
      }  // fin if condicion acepta datos 		   
			   ?>
 
 
 </div>
  
  <div id="datos_institucion" class="contenedor" >
  
  <h3><?=htmlentities("Datos Institución",ENT_QUOTES,'UTF-8')?></h3>
 
  <h3><?=$_SESSION['_INSTIT_nombre']?></h3>
  
            <a class="aaa" href="tel:<?=$_SESSION['_INSTIT_telefono']?>">
                 <img src="../lib/images/Contact.png" alt="Telefono" width="35" height="36" border="0" style="margin-right:5px;" />
				<?=$_SESSION['_INSTIT_telefono']?>
            </a>

            <a class="aaa" href="mailto:<?=$_SESSION['_INSTIT_email']?>" >
                <img src="../lib/images/Mail_Read.png" alt="E-Mail" width="35" height="34" border="0"  style="margin-right:5px;" />
				<?=$_SESSION['_INSTIT_email']?>
            </a>
            
            <br/><br/>
      
  </div>
    
</div> <!-- /content -->
 
 
<div id="footer" >


     <div style="float:left;" ><a class="aaa" href="../inicio/salir.php" >Salir</a></div>
   
   <div align="center">  
   <br/>
   <p style="font-size:10px"> 
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


</body>
</html>
