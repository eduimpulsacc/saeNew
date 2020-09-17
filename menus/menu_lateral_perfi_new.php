<? 

$posp           =$_POSP;
$perfil_user    =$_PERFIL;
$ano            =$_ANO;

    $dia  = strftime("%d",time());
	$mes  = strftime("%m",time());
	$mes  = envia_mes($mes);
	$ano2  = strftime("%Y",time()); 

if ($ano == NULL){
 $qry="SELECT id_institucion, id_ano, situacion from ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
 $result = @pg_Exec($conn,$qry);
 $filaaux = @pg_fetch_array($result,0);	
 $_ANO=$filaaux["id_ano"];
 $ano = $_ANO;
}  

  $qry_info = "select info_colegio,reglamento_evaluacion,pme,manual_convivencia from institucion where rdb = '$institucion'";
  $res_info = @pg_Exec($conn,$qry_info);
  $fila_info = @pg_fetch_array($res_info,0);
  $_INFO = $fila_info['info_colegio']; 

	$location = dirname($_SERVER['PHP_SELF']); 
	$arr = split('/', $location); 
	$num = count($arr); 

$num = $num - 0;?>
<? /////////////////////////////////////////////////////////////////////////////
	// Este codigo permite al menu de la cabecera poder encontrar las imagenes en forma automatica
		
		$w = 0;
		$posp = $posp -2;
		$c = "sae3.0/";
		$e = "";
		$d = "";
		$ca = "";
		
		while ($w < $num){ // while de imagenes
		$e = $d;
		$d = $c;
		$c = "../".$c;
		$ca = $c."../";
		$w++; 
		}

////////////////////////////////////////////////////////////////////////////////////////////////
?>

<?php //menus que tengo activos
$sql_menu="select men.* from menu_alu_apo men inner join perfil_menu_alu_apo per on men.id_menu = per.id_menu where per.rdb = $_INSTIT and per.id_perfil=$perfil_user and men.id_menu!=16 order by orden";
$rs_menu = pg_exec($conn,$sql_menu);
?>
<?php //ir a buscar DV alumno
$usuario = ($perfil_user==16)?$_NOMBREUSUARIO:$_ALUMNO;

	 $sql = "select dig_rut from alumno where rut_alumno = ".$usuario;
	$rs = pg_exec($conn,$sql);
	$fi = @pg_fetch_array($rs,0);	
				
	$fi = pg_fetch_array($rs,0);
	$dig = strtoupper($fi['dig_rut']);
	
	$rut = number_format($_NOMBREUSUARIO, 0, ',', '.')."-".$dig;

?>


<!-- jQuery -->
<script type="text/javascript" src="<? echo $c ?>admin/clases/jquery/jquery-lastest.min.js"></script>
<script type="text/javascript" src="<? echo $c ?>admin/clases/font-awesome-4.6.3/js/menumaker.min.js"></script>
<script>
(function($){
$(document).ready(function(){

$(function() {
  var menu = $('#cssmenu > ul');
  menu.find('.has-sub > ul').hide();

  menu.on('click', function(event) {
    //event.preventDefault();

    var targetParent = $(event.target).parent();
    if (targetParent.hasClass('has-sub')) {
      targetParent.toggleClass('active');
      targetParent.children('ul').slideToggle(250);
    }
  })
});

});
})(jQuery);



</script>
<!-- Icon Library -->
<link rel="stylesheet" type="text/css" href="<? echo $c ?>admin/clases/font-awesome-4.6.3/css/font-awesome.min.css"/>

<style type="text/css">

#cssmenu {
  width: 250px;
   font-family: Verdana, Geneva, sans-serif;
}
#cssmenu i {
  margin-right: 5px;
}
#cssmenu ul {
  display: block;
  margin: 0;
  padding: 0;
  list-style: none;
  line-height: 1;
}
#cssmenu ul li {
  position: relative;
  display: block;
}
#cssmenu ul li a {
  display: block;
  text-decoration: none;
  position: relative;
  font-family: Verdana, Geneva, sans-serif;
  font-weight:bold;
  font-size:12px;
 
}
.nhref {
  display: block;
  text-decoration: none;
  position: relative;
  background:#E6E6E6;
   font-size:12px;
}

#cssmenu > ul {
  border: 1px solid #ccc;
  border-radius: 3px;
  background: #fff;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
}
#cssmenu > ul > li:first-child > a {
  border-radius: 3px 3px 0 0;
}
#cssmenu > ul > li:last-child > a {
  border-radius: 0 0 3px 3px;
}
#cssmenu > ul > li:not(:last-child) {
  border-bottom: 1px solid #ccc;
}
#cssmenu > ul > li.active > a {
  color: #777;
  background-color: #e6e6e6;
}
#cssmenu > ul > li.has-sub > a::after {
  content: '';
  position: absolute;
  display: block;
  border: 5px solid transparent;
  border-top-color: #888;
  right: 15px;
  top: 17px;
  transition: all .25s ease;
  transform-origin: 0 25%;
}
#cssmenu > ul > li.has-sub.active > a::after {
  transform: rotateX(180deg);
  border-top-color: #777;
}
#cssmenu > ul > li:hover > a::after {
  border-top-color: #777;
}
#cssmenu > ul > li > a {
  padding: 12px 15px;
  color: #888;
  transition: all 0.3s ease-out;
   font-size:12px;
 
}

#cssmenu > ul > li > a:hover {
  color: #777;
  background-color: #e6e6e6;
}
#cssmenu ul ul li.active > a {
  background-color: #f2f2f2;
  color: #777;
}
#cssmenu ul ul li.has-sub > a::after {
  content: '';
  position: absolute;
  display: block;
  border: 5px solid transparent;
  border-top-color: #888;
  right: 15px;
  top: 15px;
  transition: all .25s ease;
  transform-origin: 0 25%;
}
#cssmenu ul ul li.has-sub.active > a::after {
  transform: rotateX(180deg);
  border-top-color: #777;
}


#cssmenu ul ul li:hover > a::after {
  border-top-color: #777;
}
#cssmenu ul ul li a {
  padding: 10px 15px;
   font-size:12px;
  color: #888;
  transition: all 0.3s ease-out;
}
#cssmenu ul ul li a:hover {
  background-color: #f2f2f2;
  color: #777;
}
#cssmenu ul ul ul li a {
  padding-left: 25px;
}</style>

<?php if($_EDUG==14){?>
<form action="https://app.edugestor.com/ws/passthrough.php" method="post" target="_blank" name="myform">
    <input id='' class='' type='hidden' name='rut' value='<?php echo $rut ?>' />
      <input id='' class='' type='hidden' name='rbd_colegio' value='<?php echo $_INSTIT ?>' />
  <input id='' class='' type='hidden' name='password' value='4*G,#Ueyh.Nydsg+' />
  </form>
  

<script>
function llevaedu(){
 document.myform.submit();
}

</script>

<?php }?>

<?php 
// Aqui rescato nuevamente el año en que esta abierto
		$qry2_ano     = "select * from ano_escolar where id_ano = '".trim($ano)."'";
		$r2_ano       = @pg_Exec($conn,$qry2_ano);
		$f2_ano       = @pg_fetch_array($r2_ano,0);
		$ano_avierto  = $f2_ano['nro_ano'];		  
				  
				  
				  
	    $qry2_curso     = "select * from curso where id_ano = '".trim($ano)."' and id_curso='$curso'";
		$r2_curso       = @pg_Exec($conn,$qry2_curso);
		$f2_curso       = @pg_fetch_array($r2_curso,0);
		$curso_ficha  	= $f2_curso['ensenanza'];		  		  
		$grado_curso	= $f2_curso['grado_curso'];
				  
		$hoy_date=date("Y-m-d");		
		$partedefecha = substr($hoy_date,4,6);
		$hoy_date = "$ano_avierto"."$partedefecha";
		
		$qryM="select * from periodo where id_ano=".$ano." and fecha_inicio<='".$hoy_date."' order by id_periodo Desc "; 
		$resultM=pg_Exec($conn,$qryM);
		$filaM=@pg_fetch_array($resultM,0);		
?>

<div id="cssmenu">
  <ul>
     <li class="active"><a><i class="fa fa-fw fa-home"></i>OPCIONES</a></li>
        <ul style="display: block;">
          <?php for($m=0;$m<pg_numrows($rs_menu);$m++){
			  $fila_menu = pg_fetch_array($rs_menu,$m); 
			  
			 $sql_cate="select * from menu_cat_alu_apo where id_menu=".$fila_menu['id_menu']." order by id_categoria";
			 $rs_cate = pg_exec($conn,$sql_cate); 
			
			 $ico=(pg_numrows($rs_cate)>0)?"bars":"angle-right";
			 $raiz=(pg_numrows($rs_cate)>0)?"class='has-sub'":"";
			 
			 if(pg_numrows($rs_cate)==0){
			  $ref = 'href="'.$c.$fila_menu['url'].'"';
			 }
			
			if($fila_menu['id_menu']==14)
			 {
				 
				$ref='href="'.$c.'admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=0&c_curso='.trim($curso).'&c_alumno='.$usuario.'"';
			 }
			 
			 if($fila_menu['id_menu']==27)
			 {
				$ref='href="'.$c.'admin/institucion/Colegio_restore/Reportes/Rpt18/rpt18.php?tipo=1&c_curso='.trim($curso).'&c_alumno='.$usuario.'"';
			 }
			 
			 if($fila_menu['id_menu']==23)
			 {
				$ref='href="'.$c.'admin/institucion/ano/reportes/alumno/certificadoalumnoregular/printCertificadoAlumnoRegular_C.php?c_reporte=3&cmb_curso='.$curso.'&remitente=&cmb_alumno='.$_ALUMNO.'&opcion=3&cb_ok=Buscar" target="_blank"';
			 }
			 
			  if($fila_menu['id_menu']==22)
			 {
				$ref='href="'.$c.'admin/institucion/ano/reportes/printInformeCertificadoEstudios_C.php?c_reporte=29&cmb_curso='.$curso.'&cmb_alumno='.$alumno.'&dia='.$dia.'&mes='.$mes.'&ano2='.$ano2.'&rd_tipo=1&rd_obligatorio=2&cb_ok=Buscar" target="_blank"';
			 }
			 
			  if($fila_menu['id_menu']==24)
			 { 
			
				$ref='href="'.$c.'admin/institucion/ano/reportes/alumno/certificadomatricula/printInformeCertificadoMatricula.php?c_reporte=209&nombre=Certificado+Matricula&numero=27&c_curso='.$curso.'&c_alumno='.$_ALUMNO.'&cb_ok=Buscar" target="_blank"';
			 }
			
			  if(pg_numrows($rs_cate)>0){
			  $ref = '';
			 }			 
			
			if($fila_menu['id_menu']==1)
			 {
			?>
           <?php  //if (($filaM['mostrar_notas']==1) OR ($filaM['mostrar_notas']=="")){?>
              <li <?php echo $raiz ?>><a <?php echo $ref ?>><i class="fa fa-fw fa-<?php echo $ico ?>"></i><?php echo strtoupper($fila_menu['menu']) ?></a>
              <?php // }?>
            
            <?
			 }
			 else{
			?>
              <li <?php echo $raiz ?>><a <?php echo $ref ?>><i class="fa fa-fw fa-<?php echo $ico ?>"></i><?php echo strtoupper($fila_menu['menu']) ?></a>
            <?
			}
			 
			 
			  ?>
        
          <?php  if(pg_numrows($rs_cate)>0){?>
            <ul>
			   <?php  for($ca=0;$ca<pg_numrows($rs_cate);$ca++){
				   $fila_cat = pg_fetch_array($rs_cate,$ca);
				   ?>
              <li><a href="<? echo $c ?><? echo $fila_cat['url'] ?>"><i class="fa fa-fw fa-angle-right"></i><? echo strtoupper($fila_cat['nombre']) ?></a>
                <?php }?>
                  <?php if($institucion==24756){?>
            <li><a href="<? echo $c ?>../admin/institucion/ano/reportes/Menu_Reportes_new2.php"><i class="fa fa-fw fa-angle-right"></i>REPORTES</a>
           
           <?php }?>
                <?php  if($fila_menu['id_menu']==11 && strlen($fila_info['reglamento_evaluacion'])>0)
			 {?>
			<li><a href="../admin/institucion/atributos/archivos/<?php echo $fila_info['reglamento_evaluacion'] ?>" target="_blank"><i class="fa fa-fw fa-angle-right"></i>REGLAMENTO EVALUAC&Oacute;N</a></li>
			<?php  }?>
            <?php  if($fila_menu['id_menu']==11 && strlen($fila_info['pme'])>0)
			 {?>
			<li><a href="../admin/institucion/atributos/archivos/<?php echo $fila_info['pme'] ?>" target="_blank"><i class="fa fa-fw fa-angle-right"></i>PROYECTO MEJORAMIENTO EDUCATIVO</a></li>
			<?php  }?>
            <?php  if($fila_menu['id_menu']==11 && strlen($fila_info['manual_convivencia'])>0)
			 {?>
			<li><a href="../admin/institucion/atributos/archivos/<?php echo $fila_info['manual_convivencia'] ?>" target="_blank"><i class="fa fa-fw fa-angle-right"></i>MANUAL CONVIVENCIA ESCOLAR</a></li>
			<?php  }?>
            </ul>
            
            <?php  } ?>
           
          </li>
            
          <?php }?>
		  <?php if($_BBL==13){?>
            <li><a href="<? echo $c ?>fichas/alumno/biblioteca/reserva_alu.php"><i class="fa fa-fw fa-angle-right"></i> RESERVAR LIBROS</a>
           
           <?php }?>
           <?php if($_EDUG==14){?>
            <li><a onclick="llevaedu()" style="cursor:pointer"><i class="fa fa-fw fa-angle-right"></i>NOTAS EDUGESTOR</a></li>
           <?php }?>
          <li><a href="<? echo $c ?>menu/salida.php"><i class="fa fa-fw fa-angle-right"></i>SALIR</a></li>
           
    </ul>
         
  </ul>
     </li>
    
  </ul>

      </div>