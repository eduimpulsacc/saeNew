<? /*require('../util/header.php');*/
session_start();
$posp           =$_POSP;
$perfil_user    =$_PERFIL;
$ano            =$_ANO;

if ($ano == NULL){
 $qry="SELECT id_institucion, id_ano, situacion from ano_escolar WHERE id_institucion = '$institucion' AND situacion = 1";
 $result = @pg_Exec($conn,$qry);
 $filaaux = @pg_fetch_array($result,0);	
 $_ANO=$filaaux["id_ano"];
 $ano = $_ANO;
}  

  $qry_info = "select info_colegio from institucion where rdb = '$institucion'";
  $res_info = @pg_Exec($conn,$qry_info);
  $fila_info = @pg_fetch_array($res_info,0);
  $_INFO = $fila_info['info_colegio']; 

$location = dirname($_SERVER['PHP_SELF']); 
$arr = split('/', $location); 
$num = count($arr); 


//$frmModo="ingresar";
$num = $num - 0; ?>


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

    <link rel="stylesheet" href="css/styles.css">
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->
<body>

<div id="wrapper"><img src="<?=$d;?>menu_new/images/redondo.jpg" width="220" height="22">
	<ul class="menu">
   	<? 
	if($_PERFIL==0){
		$sql ="SELECT id_menu,nombre FROM reca_menu ORDER BY orden ASC";
	}else{
		//$sql ="SELECT id_menu,nombre FROM reca_menu WHERE id_menu in (SELECT id_menu FROM reca.perfil_menu WHERE id_perfil=".$_PERFIL." AND rdb=".$_INSTIT.") ORDER BY orden ASC";
		$sql ="SELECT id_menu,nombre FROM reca_menu ORDER BY orden ASC";
	}
	$rs_menu = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);
	
	for($i=0;$i<@pg_numrows($rs_menu);$i++){
		$fila_menu = @pg_fetch_array($rs_menu,$i);
			if($fila_menu['url']==""){
				$url ="#";
			}else{
				$ruta = strpos($fila_menu ['url'],"?");
				if($ruta==false){
					$url = $c.$fila_menu['url']."?menu=".$fila_menu['id_menu']."&nw=1";
				}else{
					$url = $c.$fila_menu['url']."&menu=".$fila_menu['id_menu']."&nw=1";
				}
			}
			
			?>
		<li><a href="<? echo $url;?>"><?=$fila_menu['nombre'];?></a>
<? 	
		if($_PERFIL==0){
			$sql ="SELECT id_categoria,nombre,url FROM reca_categoria WHERE id_menu=".$fila_menu['id_menu']." ORDER BY orden ASC";																																																																																																																																																																																																																																																																																																																																																																	
		}else{
			$sql ="SELECT id_categoria,nombre,url FROM reca_categoria WHERE id_menu=".$fila_menu['id_menu']." ORDER BY orden ASC";																																																																																																																																																																																																																																																																																																																																																																	
//			$sql ="SELECT id_categoria,nombre,url FROM reca.menu_categoria WHERE id_menu=".$fila_menu['id_menu']." AND id_categoria in (SELECT id_categoria FROM reca.perfil_menu WHERE id_perfil=".$_PERFIL." AND rdb=".$_INSTIT.") ORDER BY orden ASC";																																																																																																																																																																																																																																																																																																																																																																	
		}
		$rs_categoria = @pg_exec($conn,$sql) or die("SELECT FALLO :".$sql);
		
		if(@pg_numrows($rs_categoria)!=0){
	?>
		<ul>
	<?
			for($j=0;$j<@pg_numrows($rs_categoria);$j++){
				$fila_cat = @pg_fetch_array($rs_categoria,$j); 
				if($fila_cat['url']==""){
					$url ="#";
				}else{
					$ruta = strpos($fila_cat['url'],"?");
					if($ruta==false){
						$url = $fila_cat['url'];
					}else{
						$url = $fila_cat['url']."&menu=".$fila_menu['id_menu']."&categoria=".$fila_cat['id_categoria']."&nw=1";
					}
				}
		?>		<li><a class="qmparent" href="#" onClick="enviapag('<? echo $url;?>')"><?=$fila_cat['nombre'];?></a>
<?			
				
			} ?>
			</ul></li>
<?		}else{?>
		</li>
<? 		}
} ?>
      
  </ul>

</div>

<!--initiate accordion-->
<script type="text/javascript">
	$(function() {
	
	    var menu_ul = $('.menu > li > ul'),
	           menu_a  = $('.menu > li > a');
	    
	    menu_ul.hide();
	
	    menu_a.click(function(e) {
	        e.preventDefault();
	        if(!$(this).hasClass('active')) {
	            menu_a.removeClass('active');
	            menu_ul.filter(':visible').slideUp('normal');
	            $(this).addClass('active').next().stop(true,true).slideDown('normal');
	        } else {
	            $(this).removeClass('active');
	            $(this).next().stop(true,true).slideUp('normal');
	        }
	    });
	
	});
</script>

