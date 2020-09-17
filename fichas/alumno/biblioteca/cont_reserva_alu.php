<?php 
session_start();
require("../../../util/header.inc");
 require("mod_reserva_alu.php");
 
 $funcion=$_POST['funcion'];
 
 $ob_reserva = new Reserva();
 
if($funcion==1){
$rs_listado = $ob_reserva->libro($conn,$_INSTIT);
$rs_rec = $ob_reserva->traeRes($conn,$_INSTIT);
$rs_listadoAutor = $ob_reserva->autor($conn,$_INSTIT);
$rs_listadoMateria = $ob_reserva->categoria($conn,$_INSTIT);

?>
<script type="text/javascript" src="../../../admin/clases/jquery/jquery.js"></script>
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js"></script>
<script type="text/javascript" src="../../../admin/clases/jquery-ui-1.9.2.custom/development-bundle/ui/jquery.ui.datepicker.js"></script>
<script>
$(document).ready(function(){
	
	var d = new Date();
    var dd = (d<10)?("0"+d.getDate())+1:d.getDate()+1;
	var mm = (d.getMonth()+1);
	
	
	
	$("#txtFECHARES").datepicker({
			showOn: 'both',
			changeYear:false,
			changeMonth:true,
			dateFormat: 'dd/mm/yy',
			minDate: new Date(''+mm+'/'+dd+'/'+<?php echo $_NANO ?>+''),
			maxDate: new Date('12/31/'+<?php echo $_NANO ?>+''),
			constrainInput: true,
			monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
		    dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','S&aacute;b'],
		    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute'],
		    firstDay: 1/*,
			beforeShowDay: $.datepicker.noWeekends */
			
		});

  });



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
		 
		   limpia();
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
	
	
	
	//-----------------------------------
	
    $.widget( "custom.combobox2", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox2" )
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
		  .attr( "onkeydown", "limpia2()" )
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
		 $("#idAUT").val('');
		   //limpia2();
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
	
	///////////////////////
	$.widget( "custom.combobox3", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox2" )
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
		  .attr( "onkeydown", "limpia3()" )
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
		$("#idMAT").val('');
			  // limpia3();
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  
  //
  })( jQuery );
 
  $(function() {
      $( "#combobox" ).combobox({
      select: function( event, ui ) {
	 $("#idLBR").val(ui.item.value);
	  //dsp(ui.item.value);
      }
	       });
	
	$( "#combobox2" ).combobox2({
      select: function( event, ui ) {
	 $("#idAUT").val(ui.item.value);
	  //dsp(ui.item.value);
      }
	       });
		   
	$( "#combobox3" ).combobox3({
      select: function( event, ui ) {
	 $("#idMAT").val(ui.item.value);
	  //dsp(ui.item.value);
      }
	       });
	  
	 //
  });
	</script>
    <table width="90%"  border="1" cellpadding="0" cellspacing="0" align="center">
      <tr>
        <td colspan="3" class="tableindex"><div align="center">B&uacute;squeda de t&iacute;tulos</div></td>
      </tr>
       <tr>
          <td width="16%" class="cuadro02">Libro</td>
          <td align="center" class="cuadro02">:</td>
          <td width="82%" class="cuadro01"> 
          <span id="cmb">
            <select id="combobox" >
              <option value=""></option>
              <?php for($l=0;$l<pg_numrows($rs_listado);$l++){
            $fila = pg_fetch_array($rs_listado,$l);?>
              <option value="<?php echo $fila['id_libro'] ?>"><?php echo $fila['titulo'] ?></option>
              <? }?>   
            </select>
            </span>
            <input type="hidden" name="idLBR" id="idLBR">
     </td>
   </tr>
       <tr>
         <td class="cuadro02">Autor</td>
         <td align="center" class="cuadro02">:</td>
         <td class="cuadro01"><span id="cmb2">
            <select id="combobox2" >
              <option value=""></option>
              <?php for($a=0;$a<pg_numrows($rs_listadoAutor);$a++){
            $fila_a = pg_fetch_array($rs_listadoAutor,$a);?>
              <option value="<?php echo $fila_a['id_autor'] ?>"><?php echo $fila_a['nombre'] ?></option>
              <? }?>   
            </select>
            </span>
           <input type="hidden" name="idAUT" id="idAUT"></td>
       </tr>
       <tr>
         <td class="cuadro02">Materia</td>
         <td align="center" class="cuadro02">:</td>
         <td class="cuadro01"><span id="cmb3">
         <select id="combobox3" >
              <option value=""></option>
              <?php for($m=0;$m<pg_numrows($rs_listadoMateria);$m++){
            $fila_m = pg_fetch_array($rs_listadoMateria,$m);?>
           <option value="<?php echo $fila_m['id_categoria'] ?>"><?php echo $fila_m['nombre'] ?></option>
              <? }?>   
         </select>
            </span>
           <input type="hidden" name="idMAT" id="idMAT"></td>
       </tr>
   <tr>
    
    <td class="cuadro02">Fecha de Reserva</td>
    <td align="center" class="cuadro02">:</td>
    <td class="cuadro01"><input type="text" name="txtFECHARES" class="" id="txtFECHARES" readonly placeholder="Seleccione Fecha" ></td>
    
    </tr>
   <tr>
     <td colspan="3" align="right"><!--<input type="button" name="ble" id="ble" value="Reservar libro" onclick="reserva()" />--><div id="sm" class="titulos-respaldo"><input type="button" name="ble" id="ble" value="Buscar" onclick="busca()" class="botonXX" /></div></td>
     </tr>
    </table>
    <?
}
if($funcion==2){
	$rs_listado = $ob_reserva->listaReserva($conn,$_ALUMNO,$_INSTIT,$_ANO);
	if(pg_numrows($rs_listado)>0){
?>
<table width="90%"  border="1" cellpadding="0" cellspacing="0" align="center">
 <tr>
    <td width="90%" colspan="5" class="tableindex" ><p align="center">RESERVAS PENDIENTES</p></td>
    </tr>
  <tr class="tableindex">
    <td width="4%" align="center">#</td>
    <td width="15%" align="center">Nro. Reserva</td>
    <td width="31%" align="center">T&iacute;tulo</td>
    <td width="14%" align="center">Fecha Reserva</td>
    
    <td width="11%" align="center">Acciones</td>
    </tr>
    <?php for($r=0;$r<pg_numrows($rs_listado);$r++){
		$fr = pg_fetch_array($rs_listado,$r);
		
		//$ob_reserva->traeEmpUno($conn,$fr['rut_usuario']);
		
		if($fr['tipo_usuario']==1){
			$r_us = $ob_reserva->traeEmpUno($conn,$fr['rut_usuario']);
		}
		elseif($fr['tipo_usuario']==2){
			$r_us = $ob_reserva->traeApoUno($conn,$fr['rut_usuario']);
		}
		elseif($fr['tipo_usuario']==3){
			$r_us = $ob_reserva->traeAluUno($conn,$fr['rut_usuario']);
			
		}
		$fusu = pg_fetch_array($r_us,0);
		
		?>
  <tr class="cuadro01">
    <td align="center"><?php echo $r+1?></td>
    <td align="center"><?php echo $fr['id_reserva'] ?></td>
    <td align="center"><?php echo $fr['titulo'] ?></td>
    <td align="center"><?php echo CambioFD($fr['fecha_reserva']) ?></td>
   
    <td align="center"><input type="button" name="button2" id="button2" value="A" title="ANULAR RESERVA" onclick="anular(<?php echo $fr['id_reserva'] ?>)" class="botonxx" /></td>
  </tr>
  <?php }?>
    </table>
<? }
else{
	?>
    <div class="titulos-respaldo" align="center"><p>SIN RESERVAS PENDIENTES</p></div>
    <?
}
}
if($funcion==3){
	$rs_pres = $ob_reserva->prestamosUsu($conn,$_ALUMNO,$_ANO); //prestamos activos
	if(pg_numrows($rs_pres)>0){
?>
<table width="90%"  border="1" cellpadding="0" cellspacing="0" align="center">
  <tr>
     <th colspan="4" class="tableindex"><div align="center">Pr&eacute;stamos Vigentes</div></th>
  </tr>
  <tr class="tableindex">
    <th>#</th>
    <th>T&iacute;tulo</th>
    <th>C&oacute;d. ejemplar</th>
    <th>Fecha Devoluci&oacute;n</th>
  </tr>
 <?php  for($i=0;$i<pg_numrows($rs_pres);$i++){
	 $fila = pg_fetch_array($rs_pres,$i);
	 ?>
  <tr class="cuadro01">
    <td align="center"><?php echo $i+1?></td>
    <td align="center"><?php echo $fila['titulo'] ?></td>
    <td align="center"><?php echo $fila['codigo'] ?></td>
    <td align="center"><?php echo CambioFD($fila['fecha_devolucion']) ?></td>
  </tr>
  <?php }?>
</table>
<? }
else{
	?>
    <div class="titulos-respaldo" align="center"><p>SIN PRESTAMOS ACTIVOS</p></div>
    <?
}
}
if($funcion==4){
$rs_anula =$ob_reserva->anula($conn,$idr);
}
if($funcion==5){
	//$respuesta ="";
//ver si tiene reservas duplicadas con ese libro
$rs_dup = $ob_reserva->reservaDuplicada($conn,$_ALUMNO,$lbr,$_ANO);
$rs_stck = $ob_reserva->stockLibro($conn,$lbr);

//listado reservas
$rs_reser = $ob_reserva->listaReserva($conn,$_ALUMNO,$_INSTIT,$_ANO);


//confiiguracion restricciones
$rs_rec = $ob_reserva->traeRes($conn,$_INSTIT);

if(pg_numrows($rs_rec)>0){
	$f_rec= pg_fetch_array($rs_rec,0);
	//reservas sin limite
	if(intval($f_rec['lim_reservas'])==0){
		//$respuesta=0;
		if(pg_numrows($rs_dup)>0){
			$respuesta= 2;
		}
		elseif(pg_numrows($rs_stck)==0){
			$rs_fd = $ob_reserva->minprestamo($conn,$lbr);
			$fecha = pg_result($rs_fd,4);
			$respuesta= CambioFD($fecha);
			//echo 3;
		}
		else{
			$respuesta=0;
		}
		
	}
	//si mi limite de reservas es mayor a 0
	else{
	 if(pg_numrows($rs_reser) < $f_rec['lim_reservas']){
		if(pg_numrows($rs_dup)>0){
				$respuesta= 2;
			}
			elseif(pg_numrows($rs_stck)==0){
				$rs_fd = $ob_reserva->minprestamo($conn,$lbr);
				$fecha = pg_result($rs_fd,4);
				$respuesta= CambioFD($fecha);
				//echo 3;
			}
			else{
				$respuesta=0;
			}
		}
		else{
		$respuesta= 3;
		}
	}
}
//sin configuracion
else{
	if(pg_numrows($rs_dup)>0){
			$respuesta= 2;
		}
		elseif(pg_numrows($rs_stck)==0){
			$rs_fd = $ob_reserva->minprestamo($conn,$lbr);
			$fecha = pg_result($rs_fd,4);
			$respuesta= CambioFD($fecha);
			//echo 3;
		}
		else{
			$respuesta=0;
		}
}

/*//si tengo reservas duplicadas
elseif(pg_numrows($rs_dup)>0){
	$respuesta= 2;
}
elseif(pg_numrows($rs_stck)==0){
	$rs_fd = $ob_reserva->minprestamo($conn,$lbr);
	$fecha = pg_result($rs_fd,4);
	$respuesta= CambioFD($fecha);
	//echo 3;
}
else {$respuesta= 0;}*/
echo $respuesta;

}
if($funcion==6){
$rs_guarda = $ob_reserva->guardaReserva($conn,$lbr,$_ALUMNO,$_ANO,$_INSTIT,$fecha_reserva,3);
}
if($funcion==7){

$conc ="";

if($lbr!="" && $aut!=""  && $mat!="" ){
	$conc = "and (e.id_libro=$lbr or a.id_autor= $aut or c.id_categoria= $mat)";
}

elseif($lbr!="" && $aut==""  && $mat!="" ){
	$conc = "and (e.id_libro=$lbr or c.id_categoria= $mat)";
}

elseif($lbr!="" && $aut==""  && $mat=="" ){
	$conc = "and (e.id_libro=$lbr)";
}

elseif($lbr!="" && $aut==""  && $mat!="" ){
	$conc = "and (e.id_libro=$lbr or c.id_categoria= $mat)";
}

elseif($lbr=="" && $aut!=""  && $mat!="" ){
	$conc = "and (or a.id_autor=$aut c.id_categoria= $mat)";
}

elseif($lbr=="" && $aut!=""  && $mat=="" ){
	$conc = "and (a.id_autor=$aut)";
}

elseif($lbr=="" && $aut==""  && $mat!="" ){
	$conc = "and (c.id_categoria= $mat)";
}
 
 //echo $conc;

$rs_listado = $ob_reserva->titDisponible($conn,$_INSTIT,$conc);
if(pg_numrows($rs_listado)>0){
?>
<table width="90%"  border="1" cellpadding="0" cellspacing="0" align="center">
 <tr>
    <td width="90%" colspan="2" class="tableindex" ><p align="center">T&Iacute;TULOS DISPONIBLES</p></td>
    </tr>
  <tr class="tableindex">
    <td align="center">T&iacute;tulo</td>
    <td width="11%" align="center">RESERVAR</td>
    </tr>
    <?php for($r=0;$r<pg_numrows($rs_listado);$r++){
		$fr = pg_fetch_array($rs_listado,$r);
		
		
		?>
  <tr class="cuadro01"><!--onclick="reserva(<?php echo $fr['id_libro'] ?>)"-->
    <td align="center"><?php echo $fr['titulo'] ?></td>
    <td align="center"><input type="button" name="ble" id="ble" value="Reservar libro" onclick="dsp(<?php echo $fr['id_libro'] ?>)"  class="botonXX"/></td>
  </tr>
  <?php }?>
    </table>
<?	
	}
}
if($funcion==8){
$sib=$ob_reserva->usuarioBloqueado($conn,$ano,$rdb,$rut,1);
if(pg_numrows($sib)>0){
	$filb = pg_fetch_array($sib,0);
	echo "Usuario no tiene permitido reservar libros hasta ".CambioFD($filb['fecha_hasta']);
	}
	else{
	echo 1;
	}
}
 if($funcion==9){
	 //tengo que revisar si tengo bloqueos vencidos
	 $lisbloqueos = $ob_reserva->bloqueosVencidos($conn,$rdb,$ano,$fecha,$rut);
	 if(pg_numrows($lisbloqueos)>0){
			for($r=0;$r<pg_numrows($lisbloqueos);$r++){
				$freg = pg_fetch_array($lisbloqueos,$r);
				$pres = $freg['id_prestamo'];
				$ob_reserva->desbloquearPrestamos($conn,$pres);
			
			}
		}
	}
?>