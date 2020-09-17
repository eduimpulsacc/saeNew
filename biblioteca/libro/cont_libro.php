<?php 
session_start();
require("../../util/header.php");
 require("mod_libro.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_libro = new Libro();


if($funcion==1){
//var_dump($_POST);
?>
<table width="95%" border="0" align="center">
      <tr>
        <td align="center" class="titulos-respaldo"><p>MANTENEDOR DE LIBROS</p></td>
  </tr>
     
      <tr>
        <td align="right"><span style="text-align:left"><input type="button" name="button" id="button" value="Cargar con Excel" onclick="cargaExcel();" class="botonXX" /></span>&nbsp;&nbsp;&nbsp;<a href="#"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="Nuevo()"></a></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><table width="100%" border="0" cellspacing="0" class="tablaredonda">
  <tr class="textonegrita">
    <td width="11%" align="center" >Buscar por</td>
    <td width="2%" align="center">:</td>
    <td width="19%" align="center">
    <select name="cmbCRIT" id="cmbCRIT" class="select_redondo">
      <option value="1">T&iacute;tulo</option>
      <option value="2">Autor</option>
      <option value="3">Categor&iacute;a</option>
      <option value="5">Editorial</option>
    </select></td>
    <td width="40%" align="center"><input type="text" name="txtCRIT" id="txtCRIT" class="input_redondo" style="height:15px; width:350px; text-transform:uppercase"  /></td>
    <td width="11%" align="center">Orden</td>
    <td width="1%" align="center">:</td>
    <td width="16%" align="center">
    <select name="cmbORDEN" id="cmbORDEN" class="select_redondo">
     <option value="1">T&iacute;tulo</option>
     <option value="2">Autor</option>
     <option value="3">A&ntilde;o</option>
    </select></td>
    <td width="16%" align="center">&nbsp;</td>
    <td width="16%" align="center"><input type="button" name="button" id="button" value="Buscar" onclick="busqueda();" class="botonXX" /></td>
  </tr>
</table>
</td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><div id="lista"></div></td>
      </tr>
    </table>
<?
}
if($funcion==2){
	$rs_aut = $ob_libro->autor($conn,$rdb);
	$rs_edi = $ob_libro->editorial($conn,$rdb);
	$rs_cat = $ob_libro->categoria($conn,$rdb);
	$rs_idi = $ob_libro->idioma($conn,$rdb);
	$rs_lib = $ob_libro->filtraLibrosAu($conn,$rdb);
	
?>
<style>
ul.ui-autocomplete {
    z-index: 1100;
}
</style>
<script>
$( document ).ready(function() {
    
	$('.solo-numero').keyup(function (){
			this.value = (this.value + '').replace(/[^0-9]/g, '');			
		  });
		  
		  
});


</script>
<script>
  $( function() {
    var availableTags = [
	<?php for($l=0;$l<pg_numrows($rs_lib);$l++){
		$fill=pg_fetch_array($rs_lib,$l);?>
      "<?php echo $fill['titulo'] ?>",
      
	<?php }?>
    ];
    $( "#txtTITULO" ).autocomplete({
      source: availableTags,
	  
	  
    }).each(function() {
      $(this).autocomplete("widget").insertAfter($("#dialogd").parent());
 });
	
	
  } );
 // alert(availableTags)
  </script>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td width="31%" class="cuadro02">ISBN</td>
    <td width="5%" class="cuadro02">:</td>
    <td width="64%" class="cuadro01"><input type="text" name="txtISBN" id="txtISBN" style="text-transform:uppercase" class="solo-numero" onblur="existeISBN()"></td>
    </tr><tr>
     <td class="cuadro02">T&Iacute;TULO</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input name="txtTITULO" type="text" id="txtTITULO" style="text-transform:uppercase" value="" size="30" /></td>
  </tr>
    <tr>
      <td class="cuadro02">AUTOR</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <span id="au">
      <select name="cmbAUTOR" size="8" multiple="multiple" id="cmbAUTOR" style="width:250px">
    
     <?php  for($a=0;$a<pg_numrows($rs_aut);$a++){
		 $fil_a = pg_fetch_array($rs_aut,$a);
		 ?>
     <option value="<?php echo $fil_a['id_autor'] ?>"><?php echo $fil_a['nombre'] ?></option>
     <?php }?>
      </select>
      </span><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="NuevoAutor()"></td>
    </tr>
    <tr>
      <td class="cuadro02">EDITORIAL</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <span id="edi">
      <select name="cmbEDITORIAL" id="cmbEDITORIAL">
       <option value="0">Seleccione...</option>
     <?php  for($e=0;$e<pg_numrows($rs_edi);$e++){
		 $fil_e = pg_fetch_array($rs_edi,$e);
		 ?>
     <option value="<?php echo $fil_e['id_editorial'] ?>"><?php echo $fil_e['nombre'] ?></option>
     <?php }?>
      </select>
      </span><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="NuevoEditorial()"></td>
    </tr>
    <tr>
      <td class="cuadro02">EDICI&Oacute;N</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="txtEDICION" id="txtEDICION" style="text-transform:uppercase"></td>
    </tr>
    <tr>
      <td class="cuadro02">A&Ntilde;O PUBLICACI&Oacute;N</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="txtANOPUB" id="txtANOPUB" style="text-transform:uppercase" class="solo-numero"></td>
    </tr>
    <tr>
      <td class="cuadro02">CATEGOR&Iacute;A</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <span id="cate">
      <select name="cmbCATEGORIA" size="8" multiple="multiple" id="cmbCATEGORIA" style="width:250px">
         <?php  for($c=0;$c<pg_numrows($rs_cat);$c++){
		 $fil_c = pg_fetch_array($rs_cat,$c);
		 ?>
     <option value="<?php echo $fil_c['id_categoria'] ?>"><?php echo $fil_c['nombre'] ?></option>
     <?php }?>
      </select>
      </span><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="NuevoCategoria()"></td>
    </tr>
    <tr>
      <td class="cuadro02">IDIOMA</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <span id="idi">
      <select name="cmbIDIOMA" id="cmbIDIOMA">
       <option value="0">Seleccione...</option>
      <?php  for($i=0;$i<pg_numrows($rs_idi);$i++){
		 $fil_i = pg_fetch_array($rs_idi,$i);
		 ?>
     <option value="<?php echo $fil_i['id_idioma'] ?>"><?php echo $fil_i['nombre'] ?></option>
     <?php }?>
      </select>
      </span><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="NuevoIdioma()"></td>
    </tr>
    <tr>
      <td class="cuadro02">P&Aacute;GINAS</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="txtPAGINAS" id="txtPAGINAS" style="text-transform:uppercase" class="solo-numero"></td>
    </tr>
    <tr>
      <td class="cuadro02">LECTURA COMPLEMENTARIA</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="checkbox" name="chkLCOMP" id="chkLCOMP"></td>
    </tr>
     <tr>
      <td class="cuadro02">SALE DE LA BIBLIOTECA</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="checkbox" name="chkSACABLE" id="chkSACABLE"  />
    <tr>
      <td class="cuadro02">CANTIDAD EJEMPLARES</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input name="ejem" type="text" id="ejem" size="5" /></td>
    </tr>
    <tr>
      <td class="cuadro02">UBICACI&Oacute;N</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="estante" id="estante"  /></td>
    </tr>
  
</table>
<?

}
if($funcion==3){
	
	$cad = sanear_string($titulo);
	$cad = strtoupper($cad);
	
	$estante = sanear_string($estante);
	$estante = strtoupper($estante);
     //$rs_ve = $ob_libro->repetido($conn,$cad,$autor,$ano_publicacion,$rdb);
	 //Si libro existe en el catalogo
	$rs_ve = $ob_libro->repetidoV2($conn,$cad,$ano_publicacion,$rdb,$isbn);
	
	if (pg_numrows($rs_ve)>0){
	echo 2;
	}
	else{
		
	
	
	//$rs_gua = $ob_libro->GuardarLibro($conn,$isbn,$titulo,$autor,$editorial,$edicion,$ano_publicacion,$categoria,$idioma,$paginas,$lectura_comp,$rdb);
	$rs_gua = $ob_libro->GuardarLibroNew($conn,$isbn,$titulo,$editorial,$edicion,$ano_publicacion,$idioma,$paginas,$lectura_comp,$_INSTIT,$sacable); 
	
	if($rs_gua){
	
	$rs_ult = $ob_libro->MaxLibro($conn,$rdb);
	$ult = pg_result($rs_ult,0);
	
	$cau = explode(",",$autor);
	$cac = explode(",",$categoria);
	
	//ligar los autores al libro
		for($a=0;$a<count($cau);$a++){
			$ob_libro->juntaAutorLibro($conn,$ult,$cau[$a]);
		}
		
	
	//ligar las categorias al libro
	for($c=0;$c<count($cac);$c++){
			$ob_libro->juntaCategoriaLibro($conn,$ult,$cac[$c]);
		}
	
	
	
	//echo 1;
	
		if(intval($ejem)>0){
			for($e=0;$e<$ejem;$e++){
				$copia =$e+1;
				//$copia = $ob_libro->maxcopia($conn,$ult);
$cod = $rdb.$ult.pg_result($li,6).$_SESSION['_NANO'].$copia;
				$ob_libro->guardaEjemplar($conn,$ult,$estante,$cod);
			
			}
		}
	
		// si guardo el libro e hizo todo el show de los ejemplares y las categorias
		echo 1;
		}
		//no guardo el libro
		else{echo 0;}
	
	
	}
	
}
if($funcion==4){
	
	$fil = sanear_string($filtro);
	$cad = strtoupper($fil);
	//$cad2 = strtoupper($fil);
	
	if(strlen($filtro)==0){
		$criterio=4;
	}
	
	if($criterio==1){
	$filtro = "li.titulo";
	$tabla = "biblio.libro li";
	
	}
	elseif($criterio==2){
	$filtro = "au.nombre";
	$tabla = "biblio.libro li inner join biblio.autor au on au.id_autor = li.autor";
	}
	elseif($criterio==3){
	$filtro = "cat.nombre";
	$tabla = "biblio.libro li 
inner join biblio.categoria cat on cat.id_categoria = li.categoria ";
	}
	
	elseif($criterio==5){
	$filtro = "edi.nombre";
	$tabla = "biblio.libro li 
inner join biblio.editorial edi on edi.id_editorial = li.editorial ";
	}
	
	elseif($criterio==4){
	$filtro = "";
	$tabla = "biblio.libro li ";
	}
	
	
	$cad22="";
	if($criterio!=4){
		$arrcad = explode(" ",$cad);
		$campo="(";
		for($c=0;$c<count($arrcad);$c++){
			
			$campo.=" $filtro like '%".$arrcad[$c]."%' or ";
				
    }
    $cad22=")";
	}
	
	$campo= substr($campo,0,-4).$cad22;
	
	switch($orden){
	case 1:
	$orden ="titulo";
	break;
	case 2:
	$orden ="autor";
	break;
	case 3:
	$orden ="ano_publicacion";
	break;	
	}
	
	$rs_con = $ob_libro->filtraLibros($conn,$tabla,$campo,$orden,$criterio,$rdb);
	
	if(pg_numrows($rs_con)==0){
	?>
   
<table width="95%" border="0" align="center">
      <tr>
        <td align="center" class="titulos-respaldo"><p>SIN COINCIDENCIAS</p></td>
  </tr>
  </table>
    <?
	}else{
		?>
         <link rel="stylesheet" type="text/css" href="../../admin/clases/smartpaginator/smartpaginator.css">
<script src="../../admin/clases/smartpaginator/smartpaginator.js"></script>
<script>
 $(document).ready(function() {//pg_numrows($rs_listado)
 
               $('#green').smartpaginator({ totalrecords: <?php echo pg_numrows($rs_con) ?>,

		  recordsperpage: 30, 

		  datacontainer: 'mt', 

		  dataelement: 'tr',

		  theme: 'red' });

        });
</script>
        <table width="95%" border="0" align="center" class="tablaredonda" id="mt">
        <tbody>
      <tr>
        <td align="center" class="titulos-respaldo" colspan="11"><p>RESULTADOS DE LA B&Uacute;SQUEDA</p></td>
  </tr>
  <tr class="cuadro02 header">
  <th align="center">#</th>
  <th align="center">T&Iacute;TULO</th>
  <th align="center">AUTOR</th>
  <th align="center">EDITORIAL</th>
  <th align="center">CATEGOR&Iacute;A</th>
  <th align="center">IDIOMA</th>
  <th align="center">A&Ntilde;O</th>
  <th colspan="4" align="center">ACCIONES</th>
  </tr>
  <?php for($l=0;$l<pg_numrows($rs_con);$l++){
	  $fila_li = pg_fetch_array($rs_con,$l);
	 $autor = $ob_libro->cantAutores($conn,$fila_li['id_libro']);
	  $ed = $ob_libro->editorialUno($conn,$fila_li['editorial']);
	  $categorias = $ob_libro->cantCategorias($conn,$fila_li['id_libro']);
	  $idi = $ob_libro->idiomaUno($conn,$fila_li['idioma']);
	  
	  if(($l % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
	  
	  
	  ?>
  <tr class=" <?php echo $clase  ?>">
    <td><?php echo ($l+1) ?></td>
    <td><?php echo $fila_li['titulo'] ?></td>
    <td><?php $nau="";
          for($au=0;$au<pg_numrows($autor);$au++){
				$fila_au = pg_fetch_array($autor,$au);
				 $nau.=$fila_au['nombre'].", ";
				 }
				 echo substr($nau,0,-2);
				 ?></td>
    <td><?php echo pg_result($ed,1); ?></td>
    <td><?php 
		$nca="";
          for($ca=0;$ca<pg_numrows($categorias);$ca++){
				$fila_ca = pg_fetch_array($categorias,$ca);
				 $nca.=$fila_ca['nombre'].", ";
				 }
				 echo substr($nca,0,-2);
				 ?></td>
    <td><?php echo pg_result($idi,1); ?></td>
    <td><?php echo $fila_li['ano_publicacion'] ?></td>
    <td><input type="button" name="button2" id="button2" value="E" title="Editar Datos Libro" class="botonXX" onclick="editaL(<?php echo $fila_li['id_libro'] ?>)" /></td>
    <td><input type="button" name="button3" id="button3" value="+" title="Ejemplares Libro" onclick="ejemplar(<?php echo $fila_li['id_libro'] ?>)" class="botonXX" /></td>
    <td><input type="button" name="button4" id="button4" value="X"  class="botonXX" onclick="bajaL(<?php echo $fila_li['id_libro'] ?>)" title="Dar de baja t&iacute;tulo"   /></td>
    <td><input type="button" name="button5" id="button5" value="C" class="botonXX" onclick="codigoBarra(<?php echo $fila_li['id_libro'] ?>)" /></td>
  </tr>
   <?php }?>
    </tbody>
  </table>

    <?
	}?>
	<!-- <div id="green" style="margin: auto; width:750px" > </div>-->
     <?
}
if($funcion==5){
	$rs_eje = $ob_libro->ejemplarLibro($conn,$lbr);
	$lib = $ob_libro->libroUno($conn,$lbr);
?>


<input name="lbri" type="hidden" id="lbri" value="<?php echo $lbr; ?>" />
<table width="95%" border="0" align="center">
      <tr>
        <td align="center" class="titulos-respaldo"><p>EJEMPLARES LIBRO "<?php echo pg_result($lib,2) ?>"</p></td>
  </tr>
      <tr>
        <td align="right" class="titulos-respaldo"><img src="../../admin/clases/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom/PNG-24/Add.png" width="24" height="24" title="AGREGAR" onClick="NuevoEjemplar()"></td>
      </tr>
      <tr>
        <td align="right" class="titulos-respaldo">&nbsp;</td>
      </tr>
      <tr>
        <td >
        <table width="90%" border="0" align="center" cellspacing="0" >
        <tbody>
  <tr class="cuadro02 header">
    <th align="center">#</th>
    <th align="center">CODIGO</th>
    <th align="center">ESTADO</th>
    <th align="center">ESTANTE</th>
    <th colspan="3" align="center">ACCIONES</th>
    </tr>
   <?php  if(pg_numrows($rs_eje)>0){
	   for($e=0;$e<pg_numrows($rs_eje);$e++){
	   $fila = pg_fetch_array($rs_eje,$e);
	   
	   if(($e % 2)==0){
				$clase="detalleoff";
			}else{
				$clase="detalleon";
			}
			
		if($fila['estado']==1)$est="Disponible";
		if($fila['estado']==2)$est="En Pr&eacute;stamo";
		if($fila['estado']==3)$est="Dado de baja";	
			
	   ?>
  <tr class="<?php echo $clase ?>">
    <td align="center"><?php echo ($e+1) ?></td>
    <td align="center"><?php echo $fila['codigo'] ?></td>
    <td align="center"><?php echo $est ?></td>
    <td align="center"><?php echo $fila['ubicacion'] ?></td>
    <td align="center"><input name="" type="button" value="E" class="botonXX" onclick="editaE(<?php echo $fila['id_ejemplar'] ?>)" title="Editar datos ejemplar" /></td>
    <td align="center"><input name="" type="button" value="X" class="botonXX"  onclick="bajaE(<?php echo $fila['id_ejemplar'] ?>)" title="Eliminar ejemplar" /></td>
    <td align="center"><input type="button" name="button6" id="button6" value="C" class="botonXX" onclick="codigoBarraEjemplar(<?php echo $fila['id_ejemplar'] ?>)" /></td>
  </tr>
  <?php 
	   }
  }else{?>
  <tr>
    <td colspan="7" align="center" class="titulos-respaldo">SIN COINDICENCIAS</td>
    </tr>
  <?php }?>
  </tbody>
</table>
</td>
      </tr>
  </table>
  <div id="green" style="margin: auto;"> </div>
    <?

}
if($funcion==6){
	//var_dump($_POST);
	$cop = $ob_libro->maxCodigo($conn,$id_libro);
	$li = $ob_libro->libroUno($conn,$id_libro);
	$copia = pg_result($cop,0)+1;
	//.pg_result($li,6).$_SESSION['_NANO'].$copia
	/*echo $codi = $_INSTIT.$id_libro.pg_result($li,6).$_SESSION['_NANO'];*/
	?>
<table width="90%" border="0" cellspacing="0" align="center">
  <tr class="textosimple">
    <td width="24%">Estante Ubicaci&oacute;n</td>
    <td width="5%">:</td>
    <td width="71%"><input name="txtESTANTE" id="txtESTANTE" type="text" class="inputredondo" style="text-transform:uppercase" />
    <input name="txtCODLIBRO" id="txtCODLIBRO" type="hidden" class="inputredondo" value="<?php echo $copia ?>" readonly="readonly" /></td>
  </tr>
</table>
<?
}
if($funcion==7){
$ob_libro->guardaEjemplar($conn,$id_libro,$ubicacion,$codigo);
//echo 1;
}
if($funcion==8){
$ob_libro->quitaLibro($conn,$id_libro);
//echo 1;
}
if($funcion==9){
$ob_libro->quitaEjemplar($conn,$id_ejemplar);
//echo 1;
}
if($funcion==10){
	$rs = $ob_libro->ejemplarUno($conn,$id_ejemplar);
	$fila = pg_fetch_array($rs,0);
	$rs_aut = $ob_libro->autor($conn,$rdb);
	$rs_edi = $ob_libro->editorial($conn,$rdb);
	$rs_cat = $ob_libro->categoria($conn,$rdb);
	$rs_idi = $ob_libro->idioma($conn,$rdb);
?>
<table width="90%" border="0" cellspacing="0" align="center">
  <tr class="textosimple">
    <td width="24%">Estante Ubicaci&oacute;n</td>
    <td width="5%">:</td>
    <td width="71%"><input name="txtESTANTE" id="txtESTANTE" type="text" class="inputredondo" value="<?php echo $fila['ubicacion'] ?>" style="text-transform:uppercase" />
    <input type="hidden" name="txtEJEMPLAR" id="txtEJEMPLAR" value="<?php echo $fila['id_ejemplar'] ?>" /></td>
  </tr>
</table>
<?
}
if($funcion==11){
	$ob_libro->modEjemplar($conn,$id_ejemplar,$ubicacion);
}
if($funcion==12){
	$rs_aut = $ob_libro->autor($conn,$_INSTIT);
	$rs_edi = $ob_libro->editorial($conn,$_INSTIT);
	$rs_cat = $ob_libro->categoria($conn,$_INSTIT);
	$rs_idi = $ob_libro->idioma($conn,$_INSTIT);
	$rs_lib = $ob_libro->libroUno($conn,$id_libro);
	$fila = pg_fetch_array($rs_lib,0);
	
	 $autor = $ob_libro->cantAutores($conn,$id_libro);
	 $categorias = $ob_libro->cantCategorias($conn,$id_libro);
	
	//estante
	$rs_estante = $ob_libro->ejemplarSOLO($conn,$id_libro);
	$festante = pg_fetch_array($rs_estante,0);
	//show($festante);
	$estante = $festante['ubicacion'];
	//show($_POST);
	for($au=0;$au<pg_numrows($autor);$au++){
	  $fila_au = pg_fetch_array($autor,$au);
	  $sel[]=$fila_au['id_autor'];
	  }
	  
	 for($ca=0;$ca<pg_numrows($categorias);$ca++){
		$fila_ca = pg_fetch_array($categorias,$ca);
		$sec[]=$fila_ca['id_categoria'];
	}  
?>

<script>
$( document ).ready(function() {
    
	$('.solo-numero').keyup(function (){
			this.value = (this.value + '').replace(/[^0-9]/g, '');			
		  });
});
</script>

<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3"><input type="hidden" name="ed_libro" id="ed_libro" value="<?php echo $fila['id_libro'] ?>" /></td>
  </tr>
  <tr>
    <td width="31%" class="cuadro02">ISBN</td>
    <td width="5%" class="cuadro02">:</td>
    <td width="64%" class="cuadro01"><input type="text" name="txtISBN" id="txtISBN" value="<?php echo $fila['isbn'] ?>" style="text-transform:uppercase" class="solo-numero"></td>
    </tr><tr>
     <td class="cuadro02">T&Iacute;TULO</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input name="txtTITULO" type="text" id="txtTITULO" style="text-transform:uppercase" value="<?php echo $fila['titulo'] ?>" size="30" /></td>
  </tr>
    <tr>
      <td class="cuadro02">AUTOR</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <select name="cmbAUTOR[]" size="8" multiple="multiple" id="cmbAUTOR" style="width:250px">
     
     <?php  for($a=0;$a<pg_numrows($rs_aut);$a++){
		 $fil_a = pg_fetch_array($rs_aut,$a);
		 
		   
		 ?>
     <option value="<?php echo $fil_a['id_autor'] ?>" <?php echo in_array($fil_a['id_autor'], $sel)?"selected":"" ?> ><?php echo $fil_a['nombre'] ?></option>
     <?php 
	 $sel=$sel;  
	 }?>
      </select></td>
    </tr>
    <tr>
      <td class="cuadro02">EDITORIAL</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <select name="cmbEDITORIAL" id="cmbEDITORIAL">
       <option value="0">Seleccione...</option>
     <?php  for($e=0;$e<pg_numrows($rs_edi);$e++){
		 $fil_e = pg_fetch_array($rs_edi,$e);
		 ?>
     <option value="<?php echo $fil_e['id_editorial'] ?>" <?php echo ($fila['editorial']==$fil_e['id_editorial'])?"selected":""; ?>><?php echo $fil_e['nombre'] ?></option>
     <?php }?>
      </select></td>
    </tr>
    <tr>
      <td class="cuadro02">EDICI&Oacute;N</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="txtEDICION" id="txtEDICION" value="<?php echo $fila['edicion'] ?>" style="text-transform:uppercase"></td>
    </tr>
    <tr>
      <td class="cuadro02">A&Ntilde;O PUBLICACI&Oacute;N</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="txtANOPUB" id="txtANOPUB" value="<?php echo $fila['ano_publicacion'] ?>" style="text-transform:uppercase" class="solo-numero"></td>
    </tr>
    <tr>
      <td class="cuadro02">CATEGOR&Iacute;A</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <select name="cmbCATEGORIA[]" size="8" multiple="MULTIPLE" id="cmbCATEGORIA" style="width:250px">
    
     <?php  for($c=0;$c<pg_numrows($rs_cat);$c++){
		 $fil_c = pg_fetch_array($rs_cat,$c);

		 ?>
     <option value="<?php echo $fil_c['id_categoria'] ?>" <?php echo in_array($fil_c['id_categoria'], $sec)?"selected":"" ?>><?php echo $fil_c['nombre'] ?></option>
     <?php 
		  
	 }?>
      </select></td>
    </tr>
    <tr>
      <td class="cuadro02">IDIOMA</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01">
      <select name="cmbIDIOMA" id="cmbIDIOMA">
       <option value="0">Seleccione...</option>
      <?php  for($i=0;$i<pg_numrows($rs_idi);$i++){
		 $fil_i = pg_fetch_array($rs_idi,$i);
		 ?>
     <option value="<?php echo $fil_i['id_idioma'] ?>" <?php echo ($fila['idioma']==$fil_i['id_idioma'])?"selected":""; ?>><?php echo $fil_i['nombre'] ?></option>
     <?php }?>
      </select></td>
    </tr>
    <tr>
      <td class="cuadro02">P&Aacute;GINAS</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="txtPAGINAS" id="txtPAGINAS" value="<?php echo $fila['paginas'] ?>" style="text-transform:uppercase" class="solo-numero"></td>
    </tr>
    <tr>
      <td class="cuadro02">LECTURA COMPLEMENTARIA</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="checkbox" name="chkLCOMP" id="chkLCOMP" <?php echo ($fila['lectura_comp']==1)?"checked":""; ?>></td>
    </tr>
    <tr>
      <td class="cuadro02">SALE DE LA BIBLIOTECA</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="checkbox" name="chkSACABLE" id="chkSACABLE" <?php echo ($fila['sacable']==0)?"checked":""; ?> /></td>
    </tr>
   <tr>
      <td class="cuadro02">UBICACI&Oacute;N</td>
      <td class="cuadro02">:</td>
      <td class="cuadro01"><input type="text" name="estante" id="estante"  value="<?php echo $estante ?>" /></td>
    </tr>
</table>
<?
}

if($funcion==13){
	//show($_POST);
	
	$cad = sanear_string($titulo);
	$cad = strtoupper($cad);
	//$rs_ve = $ob_libro->repetidoE($conn,$cad,$autor,$ano_publicacion,$id_libro);
	
	/*if (pg_numrows($rs_ve)>0){
	echo 2;
	}
	else{*/
	
	$gua = $ob_libro->GuardarLibroE($conn,$isbn,$titulo,$editorial,$edicion,$ano_publicacion,$idioma,$paginas,$lectura_comp,$lll,$sacable);
	
	if($gua){
		$cau = explode(",",$autor);
		$cac = explode(",",$categoria);
		
		$ob_libro->quitaAutor($conn,$lll) ;
		$ob_libro->quitaCategoria($conn,$lll);
		
		
		//ligar los autores al libro
		for($a=0;$a<count($cau);$a++){
			$ob_libro->juntaAutorLibro($conn,$lll,$cau[$a]);
		}
		
	
		//ligar las categorias al libro
		for($c=0;$c<count($cac);$c++){
				$ob_libro->juntaCategoriaLibro($conn,$lll,$cac[$c]);
		}
		
		//&cambio la ubicacion de los ejemplares
	$ob_libro->modUbicacionejemplar($conn,$lll,$estante);
	
	echo 1;
	}else{
	echo 0;
	}
	
	
	//}
}
if($funcion==14){
?>
<table width="95%" border="0" cellpadding="3">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="cuadro02">NOMBRE AUTOR</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNOMBRE" id="txtNOMBRE" style="text-transform:uppercase"></td>
  </tr>
  <tr>
    <td class="cuadro02">NACIONALIDAD</td>
    <td class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtNACIONALIDAD" id="txtNACIONALIDAD" style="text-transform:uppercase"></td>
  </tr>
</table>
<?
}
if($funcion==15){


	$rs_eje = $ob_libro->ejemplarLibro($conn,$idlibro);

?>
<table  border="1" cellpadding="0" style="font-size:10px">
<?php for($i=0;$i<pg_numrows($rs_eje);$i++){
$fila_alu = pg_fetch_array($rs_eje,$i);

?>
<?php if($i%3==0){?>
</tr><tr>
<?php }?>
  
    <td valign="top"><table width="100%" border="1" cellpadding="0" style="border-collapse:collapse">
 
  <tr>
    <td align="center">
  <img src="http://app.colegiointeractivo.cl/sae3.0/biblioteca/libro/codbarra/barcode.php?text=<?php echo $fila_alu['codigo'] ?>&size=60&print=true" />
    </td>
  </tr>
</table>
</td>
  

  <?php }?>

  </tr>
 </table>
<?
}
if($funcion==16){
$rs_eje = $ob_libro->ejemplarUno($conn,$_POST['idejemplar']);
$fila_alu = pg_fetch_array($rs_eje,0);
?>
 <img src="http://app.colegiointeractivo.cl/sae3.0/biblioteca/libro/codbarra/barcode.php?text=<?php echo $fila_alu['codigo'] ?>&size=60&print=true" />
<?
}
if($funcion==17){
?>

<input type="file" name="arc" id="arc" />
<div class="messages" align="center" >
    <span class='info'></span>
     <span class='error'></span>
    </div><br />
<br />

   <a href="cargaLibros.xlsx">Descargar Plantilla de carga</a>
<?

}
if($funcion==18){
$archivo = $_FILES['archivo']['tmp_name'];

require_once '../../admin/clases/PHPExcel/Classes/PHPExcel.php';
//$archivo = "libro1.xlsx";
$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0); 
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();
for ($row = 2; $row <= $highestRow; $row++){ 
$isbn = $sheet->getCell("A".$row)->getValue(); 

$titulo = strtoupper(sanear_string($sheet->getCell("B".$row)->getValue()));


$autor1 = strtoupper(sanear_string($sheet->getCell("C".$row)->getValue()));
$autor2 = strtoupper(sanear_string($sheet->getCell("D".$row)->getValue()));
$autor3 = strtoupper(sanear_string($sheet->getCell("E".$row)->getValue()));
$autor4 = strtoupper(sanear_string($sheet->getCell("F".$row)->getValue()));
$autor5 = strtoupper(sanear_string($sheet->getCell("G".$row)->getValue()));

$editorial = strtoupper(sanear_string($sheet->getCell("H".$row)->getValue()));

$edicion = strtoupper(sanear_string($sheet->getCell("I".$row)->getValue()));

$anio = strtoupper(sanear_string($sheet->getCell("J".$row)->getValue()));
	
$cat1 = strtoupper(sanear_string($sheet->getCell("K".$row)->getValue()));
$cat2 = strtoupper(sanear_string($sheet->getCell("L".$row)->getValue()));
$cat3 = strtoupper(sanear_string($sheet->getCell("M".$row)->getValue()));	
$cat4 = strtoupper(sanear_string($sheet->getCell("N".$row)->getValue()));
$cat5 = strtoupper(sanear_string($sheet->getCell("O".$row)->getValue()));	
$idioma = strtoupper(sanear_string($sheet->getCell("P".$row)->getValue()));
	
$paginas = strtoupper(sanear_string($sheet->getCell("Q".$row)->getValue()));

$complementario = (strtoupper(sanear_string($sheet->getCell("R".$row)->getValue()))=="SI")?1:0;
	
$sacable =(strtoupper(sanear_string($sheet->getCell("S".$row)->getValue()))=="SI")?1:0;
	
$estante = strtoupper(sanear_string($sheet->getCell("T".$row)->getValue()));		
		
 $ejemplares = strtoupper(sanear_string($sheet->getCell("U".$row)->getValue()));
 
  $pais = strtoupper(sanear_string($sheet->getCell("V".$row)->getValue()));		


	
	//trarme los ids de autor para ver si existen
	
	if($autor1!=""){
	 $rau1 = $ob_libro->buscaAUtorNombre($conn,$_INSTIT,$autor1);
	  if(pg_numrows($rau1)>0){
	 	//$cad[]=$rau1;
		$cad[$row][]=pg_result($rau1,0);
	 }else{
		 $ncad1[$row][]=$autor1;
		 }
	  
	}
	
	if($autor2!=""){
	$rau2 = $ob_libro->buscaAUtorNombre($conn,$_INSTIT,$autor2);
	if(pg_numrows($rau2)>0){
	 	$cad[$row][]=pg_result($rau2,0);
	 }else{
		 $ncad1[$row][]=$autor2;
		 }
	}
	if($autor3!=""){
	$rau3 = $ob_libro->buscaAUtorNombre($conn,$_INSTIT,$autor3);
	 if(pg_numrows($rau3)>0){
	 	$cad[$row][]=pg_result($rau3,0);
	 }else{
		 $ncad1[$row][]=$autor3;
		 }
	 
	}
	if($autor4!=""){
	$rau4 = $ob_libro->buscaAUtorNombre($conn,$_INSTIT,$autor4);
	 if(pg_numrows($autor4)>0){
	 	$cad[$row][]=pg_result($rau4,0);
	 }
	 else{
		 $ncad1[$row][]=$autor4;
		 }
	}
	if($autor5!=""){
	$rau5 = $ob_libro->buscaAUtorNombre($conn,$_INSTIT,$autor5);
	if(pg_numrows($autor5)>0){
	 	$cad[$row][]=pg_result($rau5,0);
	 }
	 else{
		 $ncad1[$row][]=$autor5;
		 }
	}
	
	if($autor1=="" && $autor2=="" && $autor3=="" && $autor4=="" && $autor5==""){
	echo "Debe completar los datos de autor en t\xedtulo $titulo\n";
	}else{
		if(count($cad[$row])>0){
		$au= implode(",", $cad[$row]);
		 $aur="and la.id_autor in($au)"	;
		}
	}
	
	//ver si existen las categorias
	
	if($cat1!=""){
	 $rca1 = $ob_libro->buscaCatNombre($conn,$_INSTIT,$cat1);
	 if(pg_numrows($rca1)>0){
	 	//$cad2[]=$rca1;
		$cad2[$row][]=pg_result($rca1,0);
	 }
	 else{
		 $ncad2[$row][]=$cat1;
		 }
	}
	if($cat2!=""){
	$rca2 = $ob_libro->buscaCatNombre($conn,$_INSTIT,$cat2);
	 if(pg_numrows($rca2)>0){
	 	$cad2[$row][]=pg_result($rca2,0);
	 }
	 else{
		 $ncad2[$row][]=$cat2;
		 }
	}
	if($cat3!=""){
	$rca3 = $ob_libro->buscaCatNombre($conn,$_INSTIT,$cat3);
		if(pg_numrows($rca3)>0){
			$cad2[$row][]=pg_result($rca3,0);
		 }
		 else{
		 $ncad2[$row][]=$cat3;
		 }
	}
	if($cat4!=""){
	$rca4 = $ob_libro->buscaCatNombre($conn,$_INSTIT,$cat4);
		if(pg_numrows($rca4)>0){
	 	$cad2[$row][]=pg_result($rca4,0);
	 }
	 else{
		 $ncad2[$row][]=$cat4;
		 }
	}
	if($cad5!=""){
	 $rca5 = $ob_libro->buscaCatNombre($conn,$_INSTIT,$cad5);
	 	if(pg_numrows($rca5)>0){
	 	$cad2[$row][]=pg_result($rca5,0);
	 }else{
		 $ncad2[$row][]=$cat5;
		 }
	}
	
	
		
	if($cat1=="" && $cat2=="" && $cat3=="" && $cat4=="" && $cat5==""){
	echo "Debe completar los datos de categor\xeda en t\xedtulo $titulo\n";
	}else{
		if(count($cad2[$row])>0){
		$ca= implode(",", $cad2[$row]);
		 $car="and ca.id_categoria in($ca)"	;
		}
	}
	
	
	//buscar el idioma
	$idio=$ob_libro->buscaIdioma($conn,$_INSTIT,$idioma);
	$edio=$ob_libro->buscaEditorial($conn,$_INSTIT,$editorial);
	
	$rs_lib = $ob_libro->repetidoNew($conn,$titulo,$aur,$anio,$_INSTIT,$car,$isbn);
	
	/*echo "Existe autor";
	show($cad);
	echo "nuevo autor";
	show($ncad1);
	
	echo "Existe categoria";
	show($cad2);
	echo "nueva categoria";
	show($ncad2);*/
	
	if(pg_numrows($rs_lib)==0){
	//Si el título no existe, lo tenemos que crear	
		if(pg_numrows($idio)>0){
		$idiomaX = pg_result($idio,0);	
		}else{
		$ob_libro->creaIdioma($conn,$_INSTIT,$idioma);
		$idiomaX=$ob_libro->maxIdioma($conn,$_INSTIT);
		}
		
		if(pg_numrows($edio)>0){
		$editorialX = pg_result($edio,0);	
		}else{
		$ob_libro->creaEditorial($conn,$_INSTIT,$editorial);
		$editorialX=$ob_libro->maxEditorial($conn,$_INSTIT);
		}
		
		//se ingresa libro
		$ob_libro->GuardarLibroNew($conn,$isbn,$titulo,$editorialX,$edicion,$anio,$idiomaX,$paginas,$complementario,$_INSTIT,$sacable);
		
		  $mx= $ob_libro->MaxLibroNew($conn,$_INSTIT);
		  
		//si no existen los autores hay que ingresarlos
		for($na=0;$na<count($ncad1[$row]);$na++){
			$ob_libro->AgregarAutorNew($conn,$ncad1[$row][$na],$pais,$_INSTIT);
			$aut = $ob_libro->maxAutor($conn,$_INSTIT);
			$ob_libro->juntaAutorLibro($conn,$mx,$aut);
			}
			
		//si existen, solo ligar
		for($ea=0;$ea<count($cad[$row]);$ea++){
			$ob_libro->juntaAutorLibro($conn,$mx,$cad[$row][$ea]);
		}
		
		
			
		//si no existen las categorias hay que ingresarlas
		for($ca=0;$ca<count($ncad2[$row]);$ca++){
			 $ob_libro->AgregarCategoria($conn,$ncad2[$row][$ca],$_INSTIT);
			 $cate = $ob_libro->maxCategoria($conn,$_INSTIT);
			 $ob_libro->juntaCategoriaLibro($conn,$mx,$cate);
			}
		//si existen, solo ligar
		for($ec=0;$ec<count($cad2[$row]);$ec++){
			$ob_libro->juntaCategoriaLibro($conn,$mx,$cad2[$row][$ec]);
		}
		
			
		//guardar los ejemplares
		for($e=0;$e<=$ejemplares;$e++){
				$cod = $_INSTIT.$mx.$_SESSION['_NANO'].($e+1);
				$ob_libro->guardaEjemplar($conn,$mx,$estante,$cod);
		}
		echo 1;
	/**/}
	else{
		//alerta que título existe y no va a hacer nada mas
		echo "T\xCDtulo $titulo ya existe en cat\xe1logo\n";
		
	}
	
	
}

}
if($funcion==19){
$rs = $ob_libro->existeISBN($conn,$_INSTIT,$isbn);
if(pg_numrows($rs)>0){
	$titulo = pg_result($rs,2);
	echo "C\xf3digo ISBN pertenece al t\xcdtulo $titulo";
	}
	else{
	echo 1;	
	}
	
}

?>