
<?php
require('../../../../../util/header.inc');
require('../../../../../util/LlenarCombo.php3');
require('../../../../../util/SeleccionaCombo.inc');
include('../../../../clases/class_Reporte.php');
include('../../../../clases/class_Membrete.php');
//print_r($_POST);

	$_POSP = 4;
	$_bot = 8;
	
	 $institucion	= $_INSTIT;
	 $ano			= $select_anos;
	$curso			= $select_cursos;
	$docente		= 5; //Codigo Docente
	$frmModo		= $_FRMMODO;
	$alumno			= $cmb_alumno;	
	$reporte		= $c_reporte;

if ($select_cursos>0){
	$Curso_pal = CursoPalabra($curso, 1, $conn);
	
}

	$ob_reporte = new Reporte();
	$ob_membrete = new Membrete();

	//-------------------------	 CONFIGURACION DE REPORTE ------------------
	$ob_config = new Reporte();
	$ob_config->id_item=$reporte;
	$ob_config->institucion=$institucion;
	$ob_config->curso=$curso;
	$rs_config = $ob_config->ConfiguraReporte($conn);
	$fila_config = @pg_fetch_array($rs_config,0);
	$ob_config->CambiaDatoReporte($fila_config);
 
	$fecha=$ob_reporte->fecha_actual();
	
	/************** FIRMA ***********************/
		$ob_reporte->rdb=$institucion;
		$ob_reporte->usuario= $_NOMBREUSUARIO;
		$ob_reporte->item=$reporte;
		
	
		
		


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>SAE - Sistema de Administraci&oacute;n Escolar</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../../../../<?=$_ESTILO?>" rel="stylesheet" type="text/css">
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 .titulo
 {
 font-family:<?=$ob_config->letraT;?>;
 font-size:<?=$ob_config->tamanoT;?>px;
 }
 .item
 {
 font-family:<?=$ob_config->letraI;?>;
 font-size:<?=$ob_config->tamanoI;?>px;

 }
 .subitem
 {
 font-family:<?=$ob_config->letraS;?>;
 font-size:<?=$ob_config->tamanoS;?>px;
 }
</style>
<SCRIPT language="JavaScript">
	function MM_goToURL() { //v3.0
	  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
	  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
	}
									
</script>

<script language="JavaScript" type="text/JavaScript">
<!--

function imprimir(){
Element = document.getElementById("layer1")
Element.style.display='none';
Element = document.getElementById("layer2")
Element.style.display='none';
window.print();
Element = document.getElementById("layer1")
Element.style.display='';
Element = document.getElementById("layer2")
Element.style.display='';
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
//-->
</script>
<script>
function imprimir() 
{
	document.getElementById("capa0").style.display='none';
	window.print();
	document.getElementById("capa0").style.display='block';
}

function exportar(){
		//	window.location='printCartaApoderado_C.php?cmb_curso=<?=$curso?>&cmb_alumno=<?=$alumno?>&xls=1';
			return false;
		  }		  
		  
</script>
<script> 
function cerrar(){ 
window.close() 
} 
</script>
<STYLE>
 H1.SaltoDePagina
 {
     PAGE-BREAK-AFTER: always
 }
 
</style>

</head>
<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onLoad="MM_preloadImages('../../../../../cortes/b_ayuda_r.jpg','../../../../../cortes/b_info_r.jpg','../../../../../cortes/b_mapa_r.jpg','../../../../../cortes/b_home_r.jpg')">
 

<!-- INICIO CUERPO DE LA PAGINA -->

<?
					$sql_prom="SELECT pr.promedio,al.nombre_alu,al.ape_pat,al.ape_mat,al.rut_alumno  
								from promocion pr
								inner join alumno al on pr.rut_alumno=al.rut_alumno
								inner join curso cu on pr.id_curso=cu.id_curso
								where cu.id_curso=".$curso." and pr.rdb=".$institucion." and pr.promedio >='".$prom_gral."'
								order by al.ape_pat";
				    $result_prom= @pg_Exec($conn,$sql_prom)or die("Fallo 1".$sql_prom);
					$rut_al="";
					for($j=0;$j<@pg_numrows($result_prom);$j++){
		            $fila_prom = pg_fetch_array($result_prom,$j);
					$promedio_gral=$fila_prom['promedio'];
					$rut_alumno=$fila_prom['rut_alumno'];
					$rut_al .=$rut_alumno.",";
					$rut_alum= substr($rut_al,0,-1);
					$conceptual=strtoupper($not_religion);
					}
					
					if(isset($rut_alum)){
					$sql_rel="select pr.promedio,al.rut_alumno from promedio_sub_alumno pr 
					inner join alumno al on pr.rut_alumno=al.rut_alumno
					inner join curso cu on pr.id_curso=cu.id_curso					
					where pr.rut_alumno IN (".$rut_alum.") and pr.id_ramo=".$txt_religion." and cu.id_curso=".$curso." 
					and pr.rdb=".$institucion." 
					and pr.promedio ='".$conceptual."'";
					
					$result_prom_rel= @pg_Exec($conn,$sql_rel)or die("Fallo 3".$sql_rel);
					$rut_als="";
					for($x=0;$x<pg_numrows($result_prom_rel);$x++){
		            $fila_prom_rel = pg_fetch_array($result_prom_rel,$x);
					$promedio_rel=$fila_prom_rel['promedio'];
					$rut_alumnos=$fila_prom_rel['rut_alumno'];
					$rut_als .=$rut_alumnos.",";
					$rut_alums= substr($rut_als,0,-1);
					}
					
					}else{
						echo"<script type=\"text/javascript\">alert(\"No hay Datos\")
						 location.href = \"CartaFelicitacionAlumno.php\";
						 </script>";  
						}
					
					if($prom_rojo==0){
					
					 $sql_rojos="select DISTINCT al.rut_alumno from promedio_sub_alumno pr 
								inner join alumno al on pr.rut_alumno=al.rut_alumno
								inner join curso cu on pr.id_curso=cu.id_curso
								where pr.rut_alumno IN (".$rut_als.") and 
								cu.id_curso=".$curso."
								and pr.rdb=".$institucion." 
								and pr.promedio >'39'
								AND pr.promedio not in ('MB','B','S','I','EX')";
								$result_rojos= @pg_Exec($conn,$sql_rojos)or die("Fallo 2".$sql_rojos);
								$rut_alr="";
								
								for($k=0;$k<@pg_numrows($result_rojos);$k++){
									$fila_rojos = pg_fetch_array($result_rojos,$k);
									$promedios_rojos=$fila_rojos['promedio'];
									$rut_alumnos_r=$fila_rojos['rut_alumno'];
									
									$rut_alr .=$rut_alumnos_r.",";
									$rut_alumr= substr($rut_alr,0,-1);
								}
					echo "rut_alumno-->>".$rut_alums=$rut_alumr."<br>";
					}
					
	    $chk_ramos_1 = "";
		for($q=0;$q<=20;$q++){
		$chk_ramos="chk_ramos".$q;	
		$chk_ramos=$_POST['chk_ramos'.$q];
		if(isset($chk_ramos)){
			$chk_ramos_1 .= $chk_ramos.",";
	    	}
		}
		$chk_ramos_1 = substr($chk_ramos_1,0,-1);
		$pieces = explode(",", $chk_ramos_1);
		$conta=count($pieces);
		
	
		
		if(isset($chk_ramos_1)){
			
	   $sql="select al.nombre_alu,al.ape_pat,al.ape_mat,al.rut_alumno, count(al.rut_alumno) as contador
			from alumno al inner join matricula m on al.rut_alumno=m.rut_alumno 
			inner join curso cu on m.id_curso=cu.id_curso 
			inner join promedio_sub_alumno pr on m.rut_alumno=pr.rut_alumno 
			where al.rut_alumno in(".$rut_alums.") and m.id_curso=".$curso." and m.rdb=".$institucion." AND pr.id_ramo in(".$chk_ramos_1.") 
			and pr.promedio >='".$prom_ramos."' 
			group by al.nombre_alu,al.ape_pat,al.ape_mat,al.rut_alumno
			HAVING count(al.rut_alumno)=".$conta;
     		$result= @pg_Exec($conn,$sql) or die ("Fallo 4".$sql);//
		
		}else{
			continue;
			}		
			
			if(pg_numrows($result)==""){
				echo"<script type=\"text/javascript\">alert(\"No Hay Datos\")
						 location.href = \"CartaFelicitacionAlumno.php\";
						 </script>";  
				}
				
				
		?>
        
        
        	<div id="capa0">
  <table width="650" align="center">
    <tr>
      <td><input name="button4" type="button" class="botonXX" onClick="cerrar()"   value="CERRAR">
      </td>
      <td align="right"><input name="button3" type="button" class="botonXX" onClick="imprimir();"  value="IMPRIMIR">
	  <? if($_PERFIL==0){?>		  
		<!--<input name="cb_exp" type="button" onClick="exportar()" class="botonXX"  id="cb_exp" value="EXPORTAR">-->
	<? }?>
      </td>
    </tr>
  </table>
</div>
        		
		<?		
		for($e=0;$e<@pg_numrows($result);$e++){
			
		$fila = pg_fetch_array($result,$e);	
		
		$nombre_alumno  = $fila['ape_pat'];
		$nombre_alumno .= $fila['ape_mat'];
		$nombre_alumno .= $fila['nombre_alu'];
	    $notap=$fila['promedio'];
		
		$sql_int="select * from institucion  where institucion.rdb=".$institucion;
			$result_ins= @pg_Exec($conn,$sql_int)or die("fallo 5".$sql_int);
		for($x=0;$x<pg_numrows($result_ins);$x++){
		$fila_ins = pg_fetch_array($result_ins,0);	
		$nombre_inst=$fila_ins['nombre_instit'];	
		}
		/// fin nombre del alumno
	    ?>



		<table width="680"  align="center" border="0" cellspacing="0" cellpadding="5">
	  <tr>
		<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				  <tr>
					<td>
					<!-- aqui va la insignia -->
					
					<table width="125" border="0" cellpadding="0" cellspacing="0">
					<tr valign="top" >
					  <td width="125" align="center"> 	  
						<?
						if($institucion!=""){
						   echo "<img src='../../../../../tmp/".$institucion."insignia". "' >";
						}else{
						   echo "<img src='".$d."menu/imag/logo.gif' >";
						}?>		  </td>
					</tr>
				  </table>
					
					<!-- fin de la insignia -->					</td>
					<td><div align="right" class="subitem"><?=$fecha;?></div></td>
				  </tr>
				</table>
				
	
		<br>
		<br>
		
		  <p class="Estilo5"><br>
			<span class="subitem"><br>
			Señor(a) Apoderado de<b>
			<?=$ob_reporte->tilde($nombre_alumno);?>
			</b> que cursa &nbsp;
			<?=$Curso_pal ?></span></p>
             
		  <span class="subitem">
          
		  <div align="left"><strong> Presente:</strong><br>Estimado(a) Sr.(a)<br><br>
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Con enorme satisfacci&oacute;n nos es grato saludar a usted y familia, para expresarle en nombre de nuestra Comunidad Escolar <?=$nombre_inst;?>, la enorme alegr&iacute;a y optimismo que generan los buenos resultados obtenidos por su pupilo, tanto en su calidad humana como en su aprendizaje durante el primer semestre. Esto no Hubiese sido posible sin el compromiso demostrado por ustedes.<br><br>
          
          El trabajo en conjunto de su familia, su pupilo y del colegio serà el fundamento de futuros &eacute;xitos, tanto personales como academicos.<br><br>
          
          Invito a ustedes a  continuar apoyando y participando activamente en la formaci&oacute;n de su pupilo.<br><br>
          
          Que el Señor nos ilumine el camino y nos ayude a continuar con esta labor.<br><br>
          
          Les Saluda Atentamente.
			<br>            
			<br></div></span>
   </td>
	  </tr>
</table>
 <?php  
		 $ruta_timbre =5;
		 $ruta_firma =3;
		 include("../firmas/firmas.php");?>
<table width="650" border="0" align="center">
  <tr>
    <td>&nbsp;<hr></td>
  </tr>
</table>

	<?
	    echo "<H1 class=SaltoDePagina>&nbsp;</H1>";
	
	?>
	
    <?
	$i++;
	}?>

</body>
</html>
<? pg_close($conn);?>