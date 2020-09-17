<?php 
session_start();
require("../../util/header.php");
 require("mod_devolucion.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_devolucion = new Devolucion();


if($funcion==1){
	$rs_listado = $ob_devolucion->libro($conn,$_INSTIT);

?><script>
	(function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
		  .attr( "id", "txt" )
		  .attr( "onkeydown", "limpia()" )
         // .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
		   //.addClass( "select_redondo" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
       /*   .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })*/
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "Titulo", value + " no encontrado" )
          .tooltip( "open" );
		  
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
		  $("#idLBR").val('');
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
      $( "#combobox" ).combobox({
      select: function( event, ui ) {
		 $("#idLBR").val(''); 
      //alert(ui.item.value);
	  veolb(2,ui.item.value);
	  $("#idLBR").val(ui.item.value);
	  
      }
	  
	  
      });
	  
	  
	 
  });
  

	</script>

<table width="95%" border="0" align="center">
      <tr>
        <td colspan="4" align="center" class="titulos-respaldo"><p>DEVOLUCI&Oacute;N DE LIBROS</p></td>
    </tr>
      <tr>
        <td width="10%">&nbsp;</td>
        <td width="3%" align="center">&nbsp;</td>
        <td width="79%" align="center">&nbsp;</td>
        <td width="8%">&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="cuadro02">Buscar por</td>
        <td align="center" class="cuadro02">:</td>
        <td colspan="2" class="cuadro01"><input type="radio" name="tipo" id="tipo0" value="0" onClick="muestraFiltro(0)">C&oacute;digo <input name="tipo" type="radio" id="tipo1" value="1" onClick="muestraFiltro(1)"> T&iacute;tulo</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr id="fil0">
        <td class="cuadro02">C&oacute;digo</td>
        <td align="center" class="cuadro02">:</td>
        <td class="cuadro01"><input type="text" name="txtCodigo" id="txtCodigo" onBlur="veolb(1,this.value)"></td>
        <td>&nbsp;</td>
      </tr>
  <tr id="fil1">
        <td class="cuadro02">T&iacute;tulo</td>
        <td align="center" class="cuadro02">:</td>
    <td class="cuadro01"> <select id="combobox" class="select_redondo"  >
            <option value=""></option>
            <?php for($l=0;$l<pg_numrows($rs_listado);$l++){
            $fila = pg_fetch_array($rs_listado,$l);?>
           	 <option value="<?php echo $fila['id_libro'] ?>"><?php echo $fila['titulo'] ?></option>
            <? }?>   
          </select>
          <input type="hidden" name="idLBR" id="idLBR"></td>
    <td>&nbsp;</td>
      </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td><div id="lista"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
      </table>
<?php
 }
 if($funcion==2){

	 
	 //ver si tengo cinfigurada las multas
	 $rs_multa = $ob_devolucion->tengoMulta($conn,$_INSTIT);
	 
	if($tipo==1){
		$rs_listado = $ob_devolucion->buscaCodigo($conn,$cade,$_INSTIT,$_ANO);
	}elseif($tipo==2){
		$rs_listado = $ob_devolucion->buscaLibro($conn,$cade,$_ANO);
	}
	
	
	//ano 
	$rsamo =$ob_devolucion->anoEs($conn,$_ANO);
	$nanio = pg_result($rsamo,1);
	$finicio = pg_result($rsamo,2);
	//echo date("$nanio-m-d");
	$hab = hbl($finicio,date("$nanio-m-d"));
	$arrfer = $ob_devolucion->feriadoAno($conn,$_ANO,$finicio,date("$nanio-m-d"));
	
	$cuf =0;
	for($f=0;$f<pg_numrows($arrfer);$f++){
		$ffer = pg_fetch_array($arrfer,$f);
		
		$fini = strtotime ( '+1 day' , strtotime ($fila_p['fecha_devolucion']) ) ;
		$cuf = $cuf+ddiff($fini,$ffer['fecha_fin']);
	}
	
	$dias_utiles = $hab-$cuf;
	
	
	if(pg_numrows($rs_listado)>0){
		
		?>
        <table width="95%" align="center">
  <tr >
    <td colspan="8" align="center" class="titulos-respaldo">EJEMPLARES EN PRESTAMO</td>
    </tr>
  <tr >
    <td colspan="8"><input type="hidden" name="ttt" id="ttt" value="<?php echo $tipo ?>"><input name="" type="hidden" id="ccc" value="<?php echo $cade ?>"></td>
    </tr>
  <tr class="cuadro02">
    <td width="6%" align="center">#</td>
    <td width="20%" align="center">C&oacute;digo</td>
    <td width="37%" align="center">T&iacute;tulo</td>
    <td width="26%" align="center">Usuario</td>
    <td width="26%" align="center">Fecha devolucion</td>
  
        <td width="11%" align="center">Acciones</td>
    </tr>
    <?php for($p=0;$p<pg_numrows($rs_listado);$p++){
	$fila_p = pg_fetch_array($rs_listado,$p);
	
	if($fila_p['tipo_usuario']==1){
		$r_us = $ob_devolucion->traeEmp($conn,$fila_p['rut_usuario']);
	}
	elseif($fila_p['tipo_usuario']==2){
		$r_us = $ob_devolucion->traeApo($conn,$fila_p['rut_usuario']);
	}
	elseif($fila_p['tipo_usuario']==3){
		$r_us = $ob_devolucion->traeAlu($conn,$fila_p['rut_usuario']);
	}
	$fusu = pg_fetch_array($r_us,0);
	
	$fechaFFase=$fila_p['fecha_devolucion'];
	$nuevafecha = date('Y-m-d', strtotime($fechaFFase) + 86400);
	?>
  <tr class="cuadro01">
    <td align="center"><?php echo ($p+1) ?></td>
    <td align="center"><?php echo $fila_p['codigo'] ?> <input type="hidden"  id="datraso_<?php echo $fila_p['id_prestamo'] ?>" value="<?php echo $diasm = hbl( $nuevafecha,date("$nanio-m-d")) ?>" /> <input type="hidden"  id="estadop_<?php echo $fila_p['id_prestamo'] ?>" value="<?php echo $fila_p['estado_prestamo'] ?>" />
      <input type="hidden"  id="prestado_<?php echo $fila_p['id_prestamo'] ?>" value="<?php echo $fila_p['rut_usuario'] ?>" /> 
    </td>
    <td align="center"><?php echo $fila_p['titulo'] ?></td>
    <td align="center"><?php echo $fusu['nombre'] ?></td>
    <td align="center"><?php echo CambioFD($fila_p['fecha_devolucion']) ?></td>
    <td align="center">
    
    <?php if(pg_numrows($rs_multa)>0 && $fila_p['estado_prestamo']==3){?>
   <input name="" type="button" title="Pr&eacute;stamo multado" value="M" onClick="multa(<?php echo $fila_p['id_prestamo'] ?>,<?php echo $fila_p['id_ejemplar'] ?>)">
    <?php } ?>
      <input name="" type="button" title="Devolver Ejemplar" value="D" onClick="devuelve(<?php echo $fila_p['id_prestamo'] ?>,<?php echo $fila_p['id_ejemplar'] ?>)">
    
    </td>
  </tr>
   
        <?
		}
		?>
		 </table>
		<?php }else{?>
        
    <div class="titulos-respaldo" align="center"><p>Sin pr&eacute;stamos activos</p></div>
            <?
		}
}

if($funcion==3){
//actualizar ejemplar
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/
$rs_ace = $ob_devolucion->dejemplar($conn,$ejm);

//ver si colegio tiene multas activadas
$rs_multa = $ob_devolucion->tengoMulta($conn,$_INSTIT);
$fila_multa =  pg_fetch_array($rs_multa,0);
if(pg_numrows($rs_multa)>0){
	
//si cantidad de dias de atraso es >0
if($datraso>0){
	
	$multa = $datraso*$fila_multa['monto'];
	
	$rs_pago = $ob_devolucion->pagaMulta2($conn,$_ANO,$ejm,$usp,$datraso,$multa,$pres);
	$rs_acp = $ob_devolucion->dprestamoM($conn,$pres);
	echo ($rs_ace && $rs_acp)?1:0;
}else{
$rs_acp = $ob_devolucion->dprestamo($conn,$pres);
echo($rs_ace && $rs_acp)?1:0;	
}

	/*$rs_acp = $ob_devolucion->dprestamoM($conn,$pres);*/
	
	
}else{
$rs_acp = $ob_devolucion->dprestamo($conn,$pres);
echo( $rs_acp)?1:0;	
}


//actualizar prestamo
}
if($funcion==4){
	
$r_pres =	$ob_devolucion->datopres($conn,$pres);
$fila_pres = pg_fetch_array($r_pres,0);
$rs_multa = $ob_devolucion->tengoMulta($conn,$_INSTIT);
$fila_multa =  pg_fetch_array($rs_multa,0);
?>
<table width="95%" border="0">
  <tr>
    <td colspan="2" align="center"><input type="hidden" name="prestamo" id="prestamo" value="<?php echo $fila_pres['id_prestamo'] ?>" /><input name="ejemplar" type="hidden" id="ejemplar" value="<?php echo $fila_pres['id_ejemplar'] ?>" />
      <input name="rutu" type="hidden" id="rutu" value="<?php echo $fila_pres['rut_usuario'] ?>" />
    Informaci&oacute;n Pr&eacute;stamo</td>
  </tr>
  <tr>
    <td width="23%">Usuario</td>
    <td width="77%"><?php if($fila_pres['tipo_usuario']==1){
		$r_us = $ob_devolucion->traeEmp($conn,$fila_pres['rut_usuario']);
	}
	elseif($fila_pres['tipo_usuario']==2){
		$r_us = $ob_devolucion->traeApo($conn,$fila_pres['rut_usuario']);
	}
	elseif($fila_pres['tipo_usuario']==3){
		$r_us = $ob_devolucion->traeAlu($conn,$fila_pres['rut_usuario']);
	}
	 $fusu = pg_fetch_array($r_us,0); ?>
     <?php echo $fusu['nombre'] ?></td>
  </tr>
 <?php  if($fila_pres['tipo_usuario']!=1){
	// $rus = $ob_devolucion->cursoUs($conn,$fila_pres['rut_usuario'],$fila_pres['tipo_usuario'],$_ANO);
	// $ic = pg_result($rus,0);
	 ?>
  <tr>
    <td>Curso</td>
    <td><?php switch($fila_pres['tipo_usuario']){
	   case 1:
	   	$tpu="EMPLEADO";
		$rus = $ob_devolucion->traeEmp($conn,$fila_pres['rut_usuario']);
		$us = strtoupper(pg_result($rus,1));
		
		$cc="-";
		
	   break;
	   case 2:
	  	$tpu="APODERADO";
		$rus = $ob_devolucion->traeApo($conn,$fila_pres['rut_usuario']);
		$us = strtoupper(pg_result($rus,1));
		$rcu = $ob_devolucion->cpapo($conn,$_ANO,$fila_pres['rut_usuario']);
		echo $cc=CursoPalabra(pg_result($rcu,1),1,$conn);
		
		
	   break;
	   case 3:
	   	$tpu="ALUMNO";
		$rus = $ob_devolucion->traeAlu($conn,$fila_pres['rut_usuario']);
		$us = strtoupper(pg_result($rus,1));
		$rcu=  $ob_devolucion->cpal($conn,$_ANO,$fila_pres['rut_usuario']);
		echo $cc=CursoPalabra(pg_result($rcu,0),1,$conn);
		
		
	   break;
	   } ?></td>
  </tr>
  <?php }?>
  
  <tr>
    <td>T&iacute;tulo</td>
    <td><?php  
	$r_tit= $ob_devolucion->buscaLibroCodigo($conn,$fila_pres['id_libro']);
	$f_tit = pg_fetch_array($r_tit,0);
	echo $f_tit['titulo']; ?></td>
  </tr>
  <tr>
    <td>Fecha Pr&eacute;stamo</td>
    <td><?php echo CambioFD($fila_pres['fecha_prestamo']) ?></td>
  </tr>
  <tr>
    <td>Fecha Devoluci&oacute;n</td>
    <td><?php echo CambioFD($fila_pres['fecha_devolucion']) ?></td>
  </tr>
  <tr>
    <td>D&iacute;as atraso</td>
    <td><?php echo $diasm = hbl($fila_pres['fecha_devolucion'],date("Y-m-d")) ?>&nbsp;
    <input type="hidden" name="datraso" id="datraso" value="<?php echo $diasm ?>" /></td>
  </tr>
  <tr>
    <td>Valor Multa</td>
    <td><?php echo $valmulta = $fila_multa['monto']*$diasm ?>&nbsp;
      <input type="hidden" name="mon" id="mon" value="<?php echo $valmulta ?>"  />
<input type="hidden" name="rebaja" id="rebaja" value="<?php echo $valmulta ?>" onchange="cambiovalo()"  />
    <input type="button" name="button" id="button" value="Rebaja" class="botonXX" onclick="muestrarebaja()" /></td>
  </tr>
  <tr>
    <td>Valor a pagar</td>
    <td><div id="valpago"><?php echo $valmulta ?></div></td>
  </tr>
</table>

<?
}
if($funcion==5){
	$rs_pago = $ob_devolucion->pagaMulta($conn,$_ANO,$ejm,$rutu,$datr,$mon,$rba,$pres);
	
	if($rs_pago){
	//actualizar ejemplar
//$rs_ace = $ob_devolucion->dejemplar($conn,$ejm);
//$rs_acp = $ob_devolucion->cprestamo($conn,$pres);
	echo 1;
	}

}
?>