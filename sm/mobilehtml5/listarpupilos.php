<?php 

session_start();
include("../inicio/conectar_institucion.php");

function error($error) {
		echo "<html><title>ERROR</title></head>";
		echo "<body><center>";
		echo $error;
		echo "</center></body></html>";
	}

$a = $_SESSION['_NOMBREUSUARIO'];
$b = $_SESSION['_USUARIOENSESION'];
$c = $_SESSION['_USUARIO'];

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

<div data-role="page" id="listarpupilos" >
    
  <div data-role="header" data-theme="d" style="padding:15px;" >
     <a href="../inicio/salir.php" data-role="button" data-inline="true" rel="external" data-icon="back" style="margin:5px;" >Salir</a>&nbsp;
  </div> <!--header-->
  
  <div  data-role="content"  >
  
  
    <div align="center" >
    <!--style="margin:1px"-->
    <img src="logosaemovil.png" width="283" height="73" />
    </div>
    
    
  <div data-role="collapsible-set"  data-theme="b" data-content-theme="d" >  
  <div data-role="collapsible"  data-theme="b" data-content-theme="d"  >
  <h3 style="color:#FF6600" >Listado de Alumnos</h3>
   
           <?php
			
			
			if($_PERFIL==15){  // perfil apoderado
			
			//TODOS LOS ALUMNOS PARA LOS CUALES A SIDO APODERADO, EN TODOS LOS AÑOS ACADEMICOS
			$qry="SELECT alumno.rut_alumno,alumno.dig_rut,alumno.nombre_alu,alumno.ape_pat,alumno.ape_mat
				  FROM apoderado   
				  INNER JOIN tiene2 ON tiene2.rut_apo = apoderado.rut_apo 
				  INNER JOIN alumno ON alumno.rut_alumno = tiene2.rut_alumno 
				  WHERE apoderado.rut_apo=".$_NOMBREUSUARIO." ORDER BY 3 ; ";
					
					}else if($_PERFIL==16){ // perfil alumno
						
						$qry="SELECT alumno.rut_alumno,alumno.dig_rut,alumno.nombre_alu,alumno.ape_pat,alumno.ape_mat
						FROM alumno WHERE alumno.rut_alumno = ".$_NOMBREUSUARIO."; ";
												
						}	
						
				
			$result =@pg_Exec($conn,$qry) or die("SELECT FALLO");
			
			if (!$result) {
			
				error('<B> ERROR :</b>Error al acceder a la BD. (1)</B>');
			
			}else{
					
					if (pg_numrows($result)!=0){//En caso de estar el arreglo vacio.
						$fila = @pg_fetch_array($result,0);	
						if (!$fila){
							error('<B> ERROR :</b>Error al acceder a la BD. (2)</B>');
							exit();
						}
					}

			for($i=0 ; $i < @pg_numrows($result) ; $i++){
				
			$fila = @pg_fetch_array($result,$i);

			/*'seteaPupilo.php3?institucion=<?php echo $fila['rdb'];?>&alumno=<?php echo trim($fila['rut_alumno']);?>&ano=	
			<?php echo $fila['id_ano'];?>&curso=<?php echo $fila['id_curso'];?>&caso=1'
			*/
			
			?>
 
   <!--<div data-role="collapsible-set" data-theme="a" data-content-theme="c" >-->
   <div data-role="collapsible" >
   <h3><strong><?= strtoupper($fila["ape_pat"]." ".$fila["ape_mat"]." ".$fila["nombre_alu"])?></strong></h3>
        
   		       <!-- <div data-type="horizontal" data-role="controlgroup"  data-inset="true" data-theme="a" >-->
                
				<?
				if($fila['rut_alumno']!="" and $fila['rut_alumno']!=0 and $fila['rut_alumno']!=NULL){
					
				
				//echo "<h5>Consultar Periodo:</h5>";
					
					
                $qry1 = "SELECT institucion.nombre_instit,ano_escolar.nro_ano, 
                institucion.rdb,matricula.id_ano,matricula.id_curso,ano_escolar.situacion 
                FROM matricula 
                INNER JOIN institucion ON matricula.rdb = institucion.rdb 
                INNER JOIN ano_escolar ON matricula.id_ano = ano_escolar.id_ano 
                WHERE matricula.rut_alumno = ".$fila['rut_alumno']." ORDER BY 2 DESC LIMIT 3;";
				
        	    $result1 =@pg_Exec($conn,$qry1) or die("SELECT FALLO");
				
				if($result1){
							
				for($i2=0 ; $i2 < @pg_numrows($result1) ; $i2++){
						
				$fila1 = @pg_fetch_array($result1,$i2);
			                 
				$rutalum = $fila['rut_alumno'];
				$idano =  $fila1['id_ano'];
							 
				echo '<a  datas-icon="star"  data-theme="b" rel="external" data-role="button" href="contenedor.php?rutalum='.$rutalum.'&idano='.$idano.'" >'.$fila1['nro_ano'].'</a>';
    		                
				   }
				   
				  
				 }else{
					 
					 echo "<h5>NO Existen Periodos para Este Alumno</h5>";
					 
					 
					 }  
					 
				
				}else{
					
					
					echo "<h5>NO Existe RUT para Este Alumno</h5>";
					
					
					}	 
				   
				   
            	?>
                <!--</div>-->  <!--controlgroup-->
        
   </div>
   <!--</div>--> <!--collapsible-set 2-->
   
     <?   
	       
		    }     // fin ciclo  
			   
      }  // fin if condicion acepta datos 		   
		
			   ?>
 
  </div>
  </div> <!--collapsible-set 1-->
   
   
   
   
  <div data-role="collapsible-set"  data-theme="b" data-content-theme="d" >  
  <div data-role="collapsible"  data-theme="b" data-content-theme="d"  >
  <h3 style="color:#FF6600" ><?=htmlentities("Datos Institución",ENT_QUOTES,'UTF-8')?></h3>

    <ul data-role="listview" data-theme="g" >
    <li><a href="#" ><?=$_SESSION['_INSTIT_nombre']?></a></li>
    <li><a href="tel:<?=$_SESSION['_INSTIT_telefono']?>"><?=$_SESSION['_INSTIT_telefono']?></a></li>
    <li><a href="mailto:<?=$_SESSION['_INSTIT_email']?>" ><?=$_SESSION['_INSTIT_email']?></a></li>
    </ul>
      
  </div>
  </div> <!--collapsible-set 1-->
  
    
</div> <!-- /content -->
 
  <div data-role="footer" align="center" data-theme="b" ><br>
  <p style="font-size:10px"> 
  <a href="mailto:info@colegiointeractivo.com?subject=Consulta%20desde%20SaeMovil">info@colegiointeractivo.com</a>
  </p>
  <p style="font-size:10px">
  <a href="tel:28293350">Fono : ( 56-2 ) 8293350</a>
  </p>
  <p style="font-size:10px"><a href="http://www.colegiointeractivo.com/">www.colegiointeractivo.com</a> 
  </p>
  <p style="font-size:10px">© Copyright Todos los Derechos Reservados</p>
  <br>
  </div>

  </div> <!--listarpupilos-->

</body>
</html>
